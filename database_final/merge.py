# -*- coding: UTF-8 -*-
import codecs
import csv
import re
import os
import pandas as pd
import numpy as np
import sys
import time
from typing import List, Tuple, Dict

with open('query.txt', 'r',encoding="utf-8") as file:
    query = file.read().strip()
    # print(query)

OriResult=pd.DataFrame()
command = query

whichCauseError = ""

def ALLpd(tableName):
    pk=[]
    data_dict={}
    data_path = f"db/{dbName}/{tableName}/data.csv"
    col_path = f"db/{dbName}/{tableName}/col.csv"
    if(os.path.exists(col_path)):
        i=0
        col_dict = {}
        data_dict={}
        with open(col_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                col_name = row[0]
                is_pk = int(row[1])
                is_idx = int(row[2])
                if(is_pk==1):
                    pk.append(col_name)    
                col_dict[col_name] = [is_pk, is_idx]
                i=i+1
            #print(col_dict)
        keys=[]

        for key in col_dict.keys():
                keys.append(key)
        with open(data_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                data_dict = process_row(row, keys)
        #print("Before:")
        #print(data_dict)
        data_df=pd.DataFrame(data_dict)
        return data_df
        # 檢查每個鍵的值的長度
        #lengths = set(len(v) for v in data_dict.values())

        #print(lengths)
        #print("After:")
        #print(data_df)

               
def extract_table_and_columns(sql_query):
    # 使用正規表達式提取FROM後的表格名稱
    match_from = re.search(r'\bFROM\b\s+([a-zA-Z_][a-zA-Z0-9_]*)', sql_query, re.IGNORECASE)
    if match_from:
        table_name = match_from.group(1)
    else:
        table_name = None

    # 使用正規表達式提取SELECT後的欄位名稱
    match_select = re.search(r'\bSELECT\b\s+([\w,\s()]+)\bFROM\b', sql_query, re.IGNORECASE)
    if match_select:
        columns_text = match_select.group(1)
        # 移除聚合函數和空白，同時移除括號
        columns_text_cleaned = re.sub(r'\bSUM\b|\bCOUNT\b|\bMIN\b|\bMAX\b|\bAVG\b|\(|\)|\s', '', columns_text, flags=re.IGNORECASE)
        # 分割成欄位名稱的列表
        columns = [col.strip() for col in columns_text_cleaned.split(',')]
    else:
        columns = None

    return table_name, columns


def process_group_by(dataF, group_by_cols, select_col):
    #print("dataF")
    #print(dataF)
    # NOTE 12/28 新增
    agg = {}
    for col in select_col:
        if group_by_cols[0] == col.lower():
            continue

        agg[col.lower()] = "first"

    if agg:
        try:
            grouped_df = dataF.groupby(group_by_cols).agg(agg).reset_index()
        except KeyError as e:
            raise e
    else:
        grouped_df = dataF.groupby(group_by_cols).size().reset_index(name='count').drop(columns=['count'])

    cols = []

    for col in select_col:

        cols.append(col.lower())

    grouped_df = grouped_df[cols]

    return grouped_df

def process_having(dataF, group_by_cols, aggregation_function_str , select_col):
    # 分組
    #print('group_by_cols' , group_by_cols)
    #print('select_col' , select_col)
    grouped_data = dataF.groupby(group_by_cols)
    
    # 解析聚合函数字符串和條件
    match = re.match(r'(\w+)\((\w+)\)([><=]+)?([\d.]+)?', aggregation_function_str)
    if not match:
        print("ERROR: Invalid aggregation function string")
        return pd.DataFrame()  
    
    agg_function, agg_column, condition_op, condition_val = match.groups()
    agg_column = agg_column.lower() #mod
    dataF[agg_column] = pd.to_numeric(dataF[agg_column], errors='coerce')

    # 檢查條件是否為 True 或 False
    try:
        # 使用解析的聚合函數
        if agg_function == 'SUM':
            aggregated_data = grouped_data[agg_column].sum().reset_index(name=agg_column)
        elif agg_function == 'MAX':
            aggregated_data = grouped_data[agg_column].max().reset_index(name=agg_column)
        elif agg_function == 'MIN':
            aggregated_data = grouped_data[agg_column].min().reset_index(name=agg_column)
        elif agg_function == 'AVG':
            aggregated_data = grouped_data[agg_column].mean().reset_index(name=agg_column)
        elif agg_function == 'COUNT':
            aggregated_data = grouped_data.size().reset_index(name=agg_column)

        if condition_op is None:
            return aggregated_data

        condition_val = float(condition_val)
        if condition_op == '>':
            result_df = aggregated_data[aggregated_data[agg_column] > condition_val]
        elif condition_op == '<':
            result_df = aggregated_data[aggregated_data[agg_column] < condition_val]
        elif condition_op == '>=':
            result_df = aggregated_data[aggregated_data[agg_column] >= condition_val]
        elif condition_op == '<=':
            result_df = aggregated_data[aggregated_data[agg_column] <= condition_val]
        elif condition_op == '=':
            result_df = aggregated_data[aggregated_data[agg_column] == condition_val]
        elif condition_op == '~':
            # 使用正则表达式进行模糊匹配
            result_df = aggregated_data[aggregated_data[agg_column].astype(str).str.contains(str(condition_val))]
        else:
            print("ERROR: Invalid condition operator")
            return pd.DataFrame()
        
        # NOTE 12/29 新增
        # NOTE KAI 0104
        count = int(result_df[group_by_cols].count().iloc[0])   
        first_index = [0] * count
        for i in range(count):
            test = result_df[group_by_cols].iloc[i]     #一一擷取資料 為了在原df找對應資料
            # NOTE KAI 0104
            first_occurrence_index = int((dataF[group_by_cols] == test).idxmax().iloc[0]  )  #在原本的data找group_by_cols 的第一筆出現位置 
            first_index[i] = first_occurrence_index     #儲存所有第一筆位置

        lowercase_columns = [col.lower() for col in select_col] #將SELECT內容改為小寫
       
        new_df = dataF.iloc[first_index]    #將原df擷取first_index的位置資料 組成新df
        try:
            new_df = new_df[lowercase_columns]  #新df 只要select_col 部分
        except:    #NOTE 01/02 處理沒有SELECT的例外
            print('No SELECT Item!!!')
            new_df = new_df.drop(index = new_df.index)  #清空df
        #print(new_df)
        new_df = new_df.reset_index(drop = True)    #NOTE 01/02 改變編號
        return new_df
    except Exception as e:
        print(f"ERROR: Unable to execute aggregation function. {e}")
        return pd.DataFrame()

#----------------------------(以上我用的部分)

def cleanOnlyBrace(st:str):
    return st.replace('"','').replace('\'','')

def cleanOnlySpace(st:str):
    return st.replace(' ','')

def clean(st:str):
    return st.replace(' ','').replace('\'','').replace('"','')

def checkDirExists(files:list[str]):
    for i in files:
        file_path = "db/"+dbName+'/'+i.lower()
        if not os.path.isdir(file_path):
            global whichCauseError
            whichCauseError = i
            return False
    return True

def checkCols(table:str,cols:list[str]):
    if(table == ''):
        return None
    table_path = "db/"+dbName+'/'+table.lower()+'/'+"col.csv"
    csvFile = pd.read_csv(table_path, header=None, index_col=False) #使pd讀取時不把第一列值當索引
    column_names = ['colName', 'pk', 'idx'] #使索引是['colName', 'pk', 'idx']
    csvFile.columns = column_names
    colNames = list(csvFile['colName']) #找colName
    
    if(cols[0] != "*"):
        for col in cols:
            if col.lower() not in map(str.lower, colNames): #大小寫不拘
                global whichCauseError
                whichCauseError = col
                return None
    return [word.lower() for word in colNames]

def readCsv(tables:list[str],colNames:list[str],idx_col:list[int],cols:list[int]):
    dataF = tableMerge(tables,colNames).astype(str)
    if(cols[0] == "*"):
        df_subset = dataF
    else:
        df_subset = dataF[cols]
        
    if df_subset.empty:
        print("EMPTY")
    else:
        json_data = df_subset.to_json(orient='records')
        print(json_data)
    
def readCsv2(tables:list[str],colNames:list[str],idx_col:list[int],cols:list[int],con:tuple()):
    dataF = tableMerge(tables,colNames).astype(str)
    if(con[3] == "="):
        condition = (dataF[con[0]] == con[1])
    elif(con[3] == ">"):
        condition = (dataF[con[0]] > con[1])
    elif(con[3] == "<"):
        condition = (dataF[con[0]] < con[1])
    elif(con[3] == ">="):
        condition = (dataF[con[0]] >= con[1])
    elif(con[3] == "<="):
        condition = (dataF[con[0]] <= con[1])
    filtered_df = dataF[condition]
    if(cols[0] == "*"):
        df_subset = filtered_df
    else:
        df_subset = filtered_df[cols]
    if df_subset.empty:
        print("EMPTY")
    else:
        json_data = df_subset.to_json(orient='records')
        print(json_data)
    
def readCsv3(tables:list[str],colNames:list[str],idx_col:list[int],cols:list[int],con:tuple()):
    dataF = tableMerge(tables,colNames).astype(str)
    if(con[3] == "="):
        condition = (dataF[con[0]] == dataF[con[1]])
    elif(con[3] == ">"):
        condition = (dataF[con[0]] > dataF[con[1]])
    elif(con[3] == "<"):
        condition = (dataF[con[0]] < dataF[con[1]])
    elif(con[3] == ">="):
        condition = (dataF[con[0]] >= dataF[con[1]])
    elif(con[3] == "<="):
        condition = (dataF[con[0]] <= dataF[con[1]])
    filtered_df = dataF[condition]
    if(cols[0] == "*"):
        df_subset = filtered_df
    else:
        df_subset = filtered_df[cols]
    if df_subset.empty:
        print("EMPTY")
    else:
        json_data = df_subset.to_json(orient='records')
        print(json_data)

def tableMerge(tables:list[str],colNames:list[str]):
    if(len(tables)==1): #只有一個table
        file_path = "db/"+dbName+"/"+tables[0]+"/data.csv"
        ret = pd.read_csv(file_path, header=None, index_col=False)
        column_names = colNames #使索引是['colName', 'pk', 'idx']
        ret.columns = column_names
        return ret 
    else:
        ans = list()
        for i in tables:
            file_path = "db/"+dbName+"/"+i+"/data.csv"
            ret = pd.read_csv(file_path, header=None, index_col=False)
            ans.append(ret)
        result = pd.merge(ans[0],ans[1], how='cross')
        column_names = colNames #使索引是['colName', 'pk', 'idx']
        result.columns = column_names
        return result

def extract_operators(string:str):
    operators = set(['==', '<=', '>=', '<', '>', '='])
    in_quotes = False
    current_quote = ''
    result = []
    for char in string:
        if char in {'"', "'", "`"}:
            if in_quotes and char == current_quote:
                in_quotes = False
                current_quote = ''
            else:
                in_quotes = True
                current_quote = char
        elif not in_quotes and char in operators:
            result.append(char)
    return result
    
def check_quotes(input_string:str):
    single_quotes = input_string.count("'")
    double_quotes = input_string.count('"')
    backticks = input_string.count('`')

    if single_quotes % 2 != 0 or double_quotes % 2 != 0 or backticks % 2 != 0:
        return 0#"Error: Unbalanced quotes"
    elif (single_quotes > 0 and double_quotes > 0) or (single_quotes > 0 and backticks > 0) or (double_quotes > 0 and backticks > 0):
        return 1#"Error: Mixing different types of quotes"
    elif single_quotes > 0:
        return 2#"String is correctly quoted with single quotes"
    elif double_quotes > 0:
        return 2#"String is correctly quoted with double quotes"
    elif backticks > 0:
        return 3#"String is correctly quoted with backticks"
    else:
        return 4#"String is correctly quoted with no quotes"

def checkTF(con:str):
    op = ''.join(extract_operators(con)) #將['<','='] 合成 <=
    if(op != ''): #如果是運算式
        # print(op)
        front = con.split(op)[0]
        back = con.split(op)[1]
        frontType = check_quotes(front)
        backType = check_quotes(back)
        
        if(frontType == 4):
            try:
                float(front)
                frontType = 2
            except ValueError:
                frontType = 3
        
        if(backType == 4):
            try:
                float(back)
                backType = 2
            except ValueError:
                backType = 3
        
        if(frontType == 0 or backType == 0): 
            return -1 #error
        if(frontType == backType == 2): #都是val
            
            if(op=="="):
                if(cleanOnlyBrace(front) == cleanOnlyBrace(back)):
                    return 1
                else:
                    return 0
            elif(op==">"):
                if(cleanOnlyBrace(front) > cleanOnlyBrace(back)):
                    return 1
                else:
                    return 0
            elif(op=="<"):
                if(cleanOnlyBrace(front) < cleanOnlyBrace(back)):
                    return 1
                else:
                    return 0
            elif(op=="<="):
                if(cleanOnlyBrace(front) <= cleanOnlyBrace(back)):
                    return 1
                else:
                    return 0
            elif(op==">="):
                if(cleanOnlyBrace(front) >= cleanOnlyBrace(back)):
                    return 1
                else:
                    return 0
                
        if(frontType == 3 and backType == 2): #一邊是col，一邊是val
            tar = cleanOnlyBrace(front.lower())
            val = cleanOnlyBrace(back)
            return (tar,val,0,op)
        elif(frontType == 2 and backType == 3):
            tar = cleanOnlyBrace(back.lower())
            val = cleanOnlyBrace(front)
            return (tar,val,0,op)
        elif(frontType == backType == 3): #一邊是col，一邊是col
            a = cleanOnlyBrace(back.lower())
            b = cleanOnlyBrace(front.lower())
            return (a,b,1,op)
    elif(con.isdigit()):
        if(int(con) != 0):
            return 1
        else:
            return 0
    else:
        return 0
    # print("CON: ",con)
    return -2

def checkJoinCols(tables:list[str],cols:list[str]):
    AllCol=[]
    retAllCol = []
    if(tables[0] == ''):
        return None
    for table in tables:
        table_path = "db/"+dbName+'/'+table.lower()+'/'+"col.csv"
        csvFile = pd.read_csv(table_path, header=None, index_col=False) #使pd讀取時不把第一列值當索引
        column_names = ['colName', 'pk', 'idx'] #使索引是['colName', 'pk', 'idx']
        csvFile.columns = column_names
        colNames = list(csvFile['colName'])
        NewColNames = list(table.lower()+'.'+csvFile['colName']) #找colName
        AllCol += colNames
        retAllCol += NewColNames
    #print("全部沒dbname的cols",AllCol)
    #print("全部加上dbname的cols",retAllCol)
    
    if cols[0] == "*":
        return (retAllCol,retAllCol)
    
    for i in range(len(cols)):
        if( not(cols[i] in retAllCol) ):
            global whichCauseError
            if(cols[i] in AllCol):
                if(AllCol.count(cols[i]) > 1):
                    whichCauseError = cols[i]
                    return 0
                else:
                    idx = AllCol.index(cols[i])
                    #print(idx)
                    cols[i] = retAllCol[idx]
            else:
                whichCauseError = cols[i]
                return None
    return (retAllCol,cols)
    # if(cols[0] != "*"):
    #     for col in cols:
    #         if col.lower() not in map(str.lower, colNames): #大小寫不拘
    #             global whichCauseError
    #             whichCauseError = col
    #             return None
    # return [word.lower() for word in colNames]
    
# NOTE 12/28 新增
def _is_aggregation_fun_in_group_by(query: str) -> bool:
    """檢查 aggregation funtion 是否有在 SELECT GROUP BY Query 中"""

    pattern = re.compile(r"SELECT\s+(SUM|MAX|MIN|AVG|COUNT)\((.+)\)\s+FROM\s+(.+)\s+GROUP\s+BY\s+(.+)")

    match = pattern.match(query)

    return bool(match)

# NOTE 12/28 新增
def _is_group_by_more_than_one_col(query: str) -> bool:
    """檢查 query 中是否是 group by 多個 col"""

    pattern = re.compile(r"^SELECT\s+[^,]+\s+FROM\s+[^,]+\s+GROUP\s+BY\s+[^,]+,\s+[^,]+$")

    match = pattern.match(query)

    return bool(match)

def Select(query:str):
    exceptOp = query.replace("SELECT ","")
    allcondition = False
    
    if("FROM" in exceptOp): #如果包含FROM才執行
        others = exceptOp.split("FROM")
        cols = clean(others[0].lower()).split(',') #cols
        IsItWHERE = 0
        
        # if not ("WHERE" in exceptOp):
        #     tables = clean(others[1].split("WHERE")[0]).split(',')
        #     if(tables[0] != ''): 
        #         chkD = checkDirExists(tables)
        #         if(chkD):
        #             if(len(tables) == 1): #沒有Join，一個table
                        
        #                 chkCol = checkCols(tables[0],cols)
                        
        #                 if(chkCol != None): #如果table存在

        #                     index_col = [] #索引(數字)

        #                     if(IsItWHERE == 1): #一邊是col，一邊是val
        #                         readCsv2(tables,chkCol,index_col,cols,thecon)
        #                     elif(IsItWHERE == 0):  #條件為True
        #                         readCsv(tables,chkCol,index_col,cols)
        #                     elif(IsItWHERE == 4): #一邊是col，一邊是col
        #                         if(checkCols(tables[0],[thecon[0],thecon[1]]) == None):
        #                             print("Unknow Column: ",whichCauseError)
        #                             return
        #                         readCsv3(tables,chkCol,index_col,cols,thecon)
        #                     else:
        #                         print("empty")
        #                 else:
        #                     print("Error: column '"+ whichCauseError +"' not exists")
        #             else:#有join
        #                 #print("isitwh ",IsItWHERE)
        #                 chkJoinCols = checkJoinCols(tables,cols)
        #                 if(chkJoinCols == 0):
        #                     print("Column "+whichCauseError+" in field list is ambiguous")
        #                 elif(chkJoinCols == None): 
        #                     print("Error: column '"+ whichCauseError +"' not exists")
        #                 else:
        #                     chkCol = chkJoinCols[0] #所有上table的col
        #                     cols = chkJoinCols[1] #上table的要求col
        #                     #print(thecon)
        #                     #print(cols)
        #                     if(IsItWHERE == 0):
        #                         readCsv4Join(tables,chkCol,cols,0,None)
        #                     elif(IsItWHERE == 4):
        #                         if not (thecon[0] in chkCol):
        #                             print("Column "+thecon[0]+" unknown or ambiguous")
        #                         elif not (thecon[1] in chkCol):
        #                             print("Column "+thecon[1]+" unknown or ambiguous")
        #                         elif ( (thecon[0] in chkCol) and (thecon[1] in chkCol) ):
        #                             readCsv4Join(tables,chkCol,cols,1,thecon)
        #                     elif(IsItWHERE == 1):
        #                         readCsv4Join(tables,chkCol,cols,2,thecon)
        #                     else:
        #                         print("empty")
        #         else:
        #             print("Error: Table '"+ whichCauseError +"' not exists")
        #     else:
        #         print("Error: Lack of Table ")
        #     return
        
        if("WHERE" in exceptOp): #如果有條件
            condition = cleanOnlySpace(exceptOp.split("WHERE")[1])
            thecon = checkTF(condition)
            if(thecon == -1):
                print("Unbalanced quotes")
                return
            elif(thecon == 1):  #條件為True
                IsItWHERE = 0
            elif(thecon == 0):  #條件為False
                IsItWHERE = 3
            elif(thecon == -2): #ERROR
                print("ERROR")
            elif(thecon[2]): #一邊是col，一邊是col
                IsItWHERE = 4
            else:  #一邊是col，一邊是val
                IsItWHERE = 1
            # print("thecon :  ",thecon)
            
        tables = clean(others[1].split("WHERE")[0].split("GROUPBY")[0]).split(',')
        # print(tables)
        if(tables[0] != ''):
            chkD = checkDirExists(tables)
            if(chkD):
                if(len(tables) == 1): #沒有Join
                    chkCol = checkCols(tables[0],cols)
                    # print(tables[0])
                    if(chkCol != None): #如果table存在
                        # print("chkCol: ",chkCol)
                        index_col = [] #索引(數字)
                        # for i in cols:
                        #     index_col.append(chkCol.index(i.lower()))
                        # print(index_col)
                        #read csv
                        if(IsItWHERE == 1): #一邊是col，一邊是val
                            OriResult=readCsv2(tables,chkCol,index_col,cols,thecon)
                            return OriResult
                        elif(IsItWHERE == 0):  #條件為True
                            OriResult=readCsv(tables,chkCol,index_col,cols)
                            return OriResult
                        elif(IsItWHERE == 4): #一邊是col，一邊是col
                            if(checkCols(tables[0],[thecon[0],thecon[1]]) == None):
                                print("Unknow Column: ",whichCauseError)
                                return
                            OriResult=readCsv3(tables,chkCol,index_col,cols,thecon)
                            return OriResult
                        else:
                            print("EMPTY")
                    else:
                        print("Unknow Column: ",whichCauseError)
                else:#有join
                    #print("isitwh ",IsItWHERE)
                    chkJoinCols = checkJoinCols(tables,cols)
                    if(chkJoinCols == 0):
                        print("Column "+whichCauseError+" in field list is ambiguous")
                    elif(chkJoinCols == None): 
                        print("Error: column '"+ whichCauseError +"' not exists")
                    else:
                        chkCol = chkJoinCols[0] #所有上table的col
                        cols = chkJoinCols[1] #上table的要求col
                        #print(thecon)
                        #print(cols)
                        if(IsItWHERE == 0):
                            readCsv4Join(tables,chkCol,cols,0,None)
                            return
                        elif(IsItWHERE == 4):
                            if not (thecon[0] in chkCol):
                                print("Column "+thecon[0]+" unknown or ambiguous")
                                return
                            elif not (thecon[1] in chkCol):
                                print("Column "+thecon[1]+" unknown or ambiguous")
                                return
                            elif ( (thecon[0] in chkCol) and (thecon[1] in chkCol) ):
                                readCsv4Join(tables,chkCol,cols,1,thecon)
                                return
                        elif(IsItWHERE == 1):
                            readCsv4Join(tables,chkCol,cols,2,thecon)
                            return
                        else:
                            print("EMPTY")
                            return
            else:
                if not(("GROUP" in exceptOp)): #mod
                    print("Error: Table '"+ whichCauseError +"' not exists")
        else:
            print("Error: Lack of Table ")
            
#__________這裡是新的和where同層____________
        if _is_aggregation_fun_in_group_by(query):
            print("題目已說明不提供 aggregation function.")
            quit()
            raise Exception("題目已說明不提供 aggregation function.")
        
        # NOTE 12/28 新增
        if _is_group_by_more_than_one_col(query):
            print("題目要求不會執行超過一欄位的 group")
            quit()
            # raise Exception("題目要求不會執行超過一欄位的 group")
        
        #  HAVING
        if "HAVING" in exceptOp:
            table, columns = extract_table_and_columns(query)
            #print("Table:", table)
            #print("Columns:", columns)
            OriResult = ALLpd(table)
            #print('Ori = ' , OriResult)
            group_by_cols = cleanOnlySpace(exceptOp.split("GROUP BY")[1].split("HAVING")[0]).split(',')
            #print(group_by_cols)
            having_condition = cleanOnlySpace(exceptOp.split("HAVING")[1])
            # print('have condition = ',having_condition)
            group_by_cols = [element.lower() for element in group_by_cols]#mod
            # NOTE 12/29 新增
            #process_having 多傳入select_col
            dataF = process_having(OriResult,group_by_cols,having_condition , select_col=columns)
            if dataF.empty :
                print("Empty")
            else:
                json_data = dataF.to_json(orient='records')
                print(json_data)
        else:
            table, columns = extract_table_and_columns(query)
            #print("OriResult_MAIN")
            OriResult = ALLpd(table)
            #print(OriResult)
            if "GROUP BY" in exceptOp:
                group_by_cols = cleanOnlySpace(exceptOp.split("GROUP BY")[1].split("HAVING")[0]).split(',')
                            # OriResult->DataFrame
                
                group_by_cols = [element.lower() for element in group_by_cols]#mod
                # NOTE 12/29 新增
                dataF = process_group_by(OriResult, group_by_cols, select_col=columns) #mod
                ################################################################################
                column_count = {}

                # 迭代所有列標籤，進行重命名
                new_columns = []
                for column in dataF.columns:
                    if column not in column_count:
                        # 如果是第一次出現，不需要重命名
                        new_columns.append(column)
                        column_count[column] = 1
                    else:
                        # 如果已經出現過，進行重命名
                        new_name = column
                        for _ in range(0,column_count[column]):
                            new_name += " "
                        new_columns.append(new_name)
                        column_count[column] += 1

                # 將 DataFrame 的列標籤設置為新的列標籤
                dataF.columns = new_columns
                #########################################################
                if dataF.empty:
                    print("Empty")
                else:
                    json_data = dataF.to_json(orient='records')
                    print(json_data)
            else:
                pass
                #print("Error: Lack of Table ")
#_________改到這裡
    else:
        print("Error: FROM keyword not found in the query.")

def readCsv4Join(tables:list[str],colNames:list[str],cols,mode,con):
    if mode == 0:
        dataF = tableMerge(tables,colNames).astype(str)
        if(cols[0] == "*"):
            df_subset = dataF
        else:
            df_subset = dataF[cols]
        if df_subset.empty:
            print("Empty")
        else:
            json_data = df_subset.to_json(orient='records')
            print(json_data)
    elif mode == 1:
        dataF = tableMerge(tables,colNames).astype(str)
        if(con[3] == "="):
            condition = (dataF[con[0]] == dataF[con[1]])
        elif(con[3] == ">"):
            condition = (dataF[con[0]] > dataF[con[1]])
        elif(con[3] == "<"):
            condition = (dataF[con[0]] < dataF[con[1]])
        elif(con[3] == ">="):
            condition = (dataF[con[0]] >= dataF[con[1]])
        elif(con[3] == "<="):
            condition = (dataF[con[0]] <= dataF[con[1]])
        filtered_df = dataF[condition]
        if(cols[0] == "*"):
            df_subset = filtered_df
        else:
            df_subset = filtered_df[cols]
        if df_subset.empty:
            print("Empty")
        else:
            json_data = df_subset.to_json(orient='records')
            print(json_data)
    elif mode == 2:
        dataF = tableMerge(tables,colNames).astype(str)
        if(con[3] == "="):
            condition = (dataF[con[0]] == con[1])
        elif(con[3] == ">"):
            condition = (dataF[con[0]] > con[1])
        elif(con[3] == "<"):
            condition = (dataF[con[0]] < con[1])
        elif(con[3] == ">="):
            condition = (dataF[con[0]] >= con[1])
        elif(con[3] == "<="):
            condition = (dataF[con[0]] <= con[1])
        filtered_df = dataF[condition]
        if(cols[0] == "*"):
            df_subset = filtered_df
        else:
            df_subset = filtered_df[cols]
        
        if df_subset.empty:
            print("Empty")
        else:
            json_data = df_subset.to_json(orient='records')
            print(json_data)
# def tableMerge2(tables:list[str],colNames:list[str]):
#     ans = list()
#     for i in tables:
#         file_path = "db/"+dbName+"/"+i+"/data.csv"
#         ret = pd.read_csv(file_path, header=None, index_col=False)
#         ans.append(ret)
#     result = pd.merge(ans[0],ans[1], how='cross')
#     column_names = colNames #使索引是['colName', 'pk', 'idx']
#     result.columns = column_names
#     # print(result)
#     return result

#------------------------------------------------------------------------------       
        
data_dict={}
def save_to_csv(data_dict, col_dict, data_path):
    keys = list(col_dict.keys())
    with open(data_path, 'w', newline='', encoding='utf-8') as file:
        file.write("")
    with open(data_path, 'a', encoding='utf-8') as file:
        for j in range(0,len(data_dict[keys[0]])):
            i=1
            for k in keys:
                if i<len(keys):
                    file.write(data_dict[k][j]+",")
                else:
                    file.write(data_dict[k][j]+"\n")
                i=i+1
    

def process_row(row, keys):
    for i in range(len(keys)):
        if keys[i] not in data_dict:
            data_dict[keys[i]] = []
        try:
            data_dict[keys[i]].append(row[i])
        except:
            pass
    return data_dict

def parser_insert_with_col_query(exceptOp: str) -> Tuple[str, List[str], List[str]]:
    """解析出 INSERT with col 語句中的 table col 和 value
    Args:
        exceptOp: 處理過後的 query，例如: `STUDENTS ('A', 'V', 'C')  ('A1000007','王測試','測試系','');`
    Returns:
        其中第一項為 `table name`
        第二項為 `col name list`
        第三項為 `value name list`
    """

    pattern = r"(\w+)\s*\(([^)]+)\)\s*\(([^)]+)\);?"

    match = re.match(pattern, exceptOp)

    table_name = match.group(1)
    colunms = [col.strip("'\'") for col in match.group(2).replace(" ", "").split(',')]
    valuse = [val.strip("'\'") for val in match.group(3).replace(" ", "").split(",")]

    return (table_name, colunms, valuse)

# NOTE 12/21 新增
def is_insert_with_col(exceptOp: str) -> bool:
    """判斷是否是帶有 table col 的 INSERT 語句
    Args:
        exceptOp: 處理過後的 query，例如: `STUDENTS ('A', 'V', 'C')  ('A1000007','王測試','測試系','');`
    """

    pattern = r"(\w+)\s*\(([^)]+)\)\s*\(([^)]+)\);?"

    match = re.match(pattern, exceptOp)

    return bool(match)

# NOTE 12/21 新增
def get_table_col(col_path: str) -> List[str]:
    """取得指定 table 的 col 名稱 list"""

    with open(col_path, "r") as f:
        reader = csv.reader(f)

        col_list = [x[0] for x in reader]

    return col_list

# NOTE 12/21 新增
def get_table_col(col_path: str) -> List[str]:
    """取得指定 table 的 col 名稱 list"""

    with open(col_path, "r") as f:
        reader = csv.reader(f)

        col_list = [x[0] for x in reader]

    return col_list

# NOTE 12/21 新增
def get_exist_table_pk(data_path: str) -> List[str]:
    """取得指定 table 中已經有的 PK 值 list"""

    with open(data_path, "r", encoding="utf-8") as f:
        reader = csv.reader(f)

        pk_list = [x[0] for x in reader if x]

    return pk_list

# NOTE 12/21 新增
def get_insert_data(col_list: List[str], value_list: List[str]) -> Dict[str, str]:
    """生成要插入資料庫的 data 格式，要注意這兩個 list 的位置是對應的，比如 col_list[0] 對應到 value_list[0]
    Args:
        col_list: 欄位 list
        value_list: 值 list
    Returns:
        key 為 col 的值
        value 為 value 的值
    """

    return dict(zip(col_list, value_list))

# NOTE 12/21 新增
def _insert_with_col(table_name: str, col_list: List[str], value_list: str) -> None:
    """根據指定的 col 新增資料
    * 如果 col_list 和 value_list 的長度不符合，則會報錯
    * 如果沒有指定的欄位，則會默認 null
    * 如果沒有指定主鍵，則會報錯
    * 如果 table_name 不存在，則會報錯
    * 如果主鍵值已經存在，則會報錯
    Args:
        table_name: 表名稱
        col_list: 欄位名稱 list
        value_list: 值 list
    """

    if len(col_list) != len(value_list):
        print("The number of fields does not match the number of values")
        quit()
        #raise Exception("欄位個數和值個數不符合")

    table_path = os.path.join("db", dbName, table_name)
    col_path = os.path.join(table_path, "col.csv")
    data_path = os.path.join(table_path, "data.csv")

    if not os.path.exists(table_path):
        print((f"Table name: {table_name} is not exist."))
        quit
        #raise FileNotFoundError(f"Table name: {table_name} is not exist.")

    csv_col_list = get_table_col(col_path)

    if csv_col_list[0] not in col_list:
        print("PK value not specified")
        quit()
        #raise Exception("未指定 PK 值")

    insert_data = get_insert_data(col_list, value_list)
    table_pk_value_list = get_exist_table_pk(data_path)

    if insert_data[csv_col_list[0]] in table_pk_value_list:
        print((f"PK: {insert_data[csv_col_list[0]]} already exists"))
        quit()
        #raise Exception(f"PK 值: {insert_data[csv_col_list[0]]} 已經存在")

    data = []

    for csv_col in csv_col_list:

        if not insert_data.get(csv_col):
            data.append("null")

        else:

            data.append(insert_data[csv_col])

    with open(data_path, "a", encoding="utf-8") as f:
        writer = csv.writer(f)

        writer.writerow(data)

def Insert(query: str):
    # NOTE 12/21 新增
    exceptOp = query.replace("INSERT INTO ","").replace("VALUES","").replace("VALUES ","").replace(";","")

    # 判斷是否是 INSERT with table col
    if is_insert_with_col(exceptOp):

        table_name, col_list, value_list = parser_insert_with_col_query(exceptOp)

        col_list = [col.lower() for col in col_list]

        _insert_with_col(table_name.lower(), col_list, value_list)
        print("Insertion successful.")

        return

    # NOTE END
    others = exceptOp.split('(')
    tableName = others[0].strip()#.lower()  # 將資料表名稱轉換成小寫
    value = others[1].strip().replace(")","").split(',')  # 值列表
    values=[]
    cols=[]
    for v in value:
        v1=v.split("'")
        try:
            #print(v1[1])
            values.append(v1[1])
        except:
            pass
    #print(tableName)
    #print(values)
    
    # Check if columns are specified
    if '(' in exceptOp:
        # Columns are specified
        columns_str = exceptOp.split('(')[0].strip().lower()
        cols = columns_str.replace("insert into", "").replace(tableName, "").replace("(", "").replace(")", "").strip().split(',')
        cols = [col.strip() for col in cols]
        #print(cols)
    else:
        # Columns are not specified
        cols = None
    pk=[]
    data_path = f"db/{dbName}/{tableName}/data.csv"
    col_path = f"db/{dbName}/{tableName}/col.csv"
    if(os.path.exists(col_path)):
        i=0
        col_dict = {}
        data_dict={}
        with open(col_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                col_name = row[0]
                is_pk = int(row[1])
                is_idx = int(row[2])
                if(is_pk==1):
                    pk.append(col_name)    
                col_dict[col_name] = [is_pk, is_idx]
                i=i+1
            #print(col_dict)
        keys=[]
        for key in col_dict.keys():
            keys.append(key)
        with open(data_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                data_dict = process_row(row, keys)
        #print("Before INSERTION:")
        #print(data_dict)
        #print(len(values),len(keys))
        
        if((len(values)!=len(keys)) and not cols):
            for i in range(0,len(cols)):
                try:
                    data_dict[cols[i]].append(values[i])
                except:
                    pass
        elif(len(values)==len(keys)):
            for i in range(0,len(keys)):
                try:
                    data_dict[keys[i]].append(values[i])
                except:
                    pass
        #print("After INSERTION:")
        #print(data_dict)
        save_to_csv(data_dict, col_dict, data_path)
        #print("Data has been updated in CSV file.")
               
            
    print("Insertion successful.")

    

def delete_record(data_dict, column_name, operator, value):
    if column_name in data_dict:
        indices_to_delete = []

        for i, val in enumerate(data_dict[column_name]):
            if operator == '=' and val == value:
                indices_to_delete.append(i)
            elif operator == '<' and val < value:
                indices_to_delete.append(i)
            elif operator == '>' and val > value:
                indices_to_delete.append(i)

        # Delete rows at the identified indices for all columns
        for key in data_dict.keys():
            data_dict[key] = [value for i, value in enumerate(data_dict[key]) if i not in indices_to_delete]

    return data_dict

# NOTE 12/21 新增
def delete_all_table(data_path: str) -> None:
    """刪除整個 table 的資料"""

    with open(data_path, "w", encoding="utf-8") as f:
        writer = csv.writer(f)
        writer.writerows([])

def DELETE(query: str):
    # 定義正則表達式
    delete_pattern = re.compile(r'DELETE\s+FROM\s+(\w+)\s+WHERE\s+(\w+)\s*([=<>]+)\s*(\S+)', re.IGNORECASE)
    #print("q",query)
    delete_all_pattern =  r'DELETE\s+FROM\s+(\w+)'
    # 使用正則表達式匹配語句
    match = delete_pattern.match(query)
    # NOTE 12/21 新增
    match_all = re.match(delete_all_pattern, query)
    
    if match:
        # 提取匹配的各個元素
        table_name = match.group(1)
        column_name = match.group(2)
        operator = match.group(3)
        v = match.group(4)
        v1=v.split("'")
        value=str(v1[1])
        #print(table_name, column_name, operator, value)
    # NOTE 12/21 新增
    elif match_all:

        table_name = match_all.group(1).lower()

        table_path = os.path.join("db", dbName, table_name)
        if not os.path.exists(table_path):
            print((f"Table: {table_name} is not exist"))
            quit()
            #raise FileNotFoundError(f"Table: {table_name} is not exist")

        data_path = os.path.join(table_path, "data.csv")

        delete_all_table(data_path)

        print(f"All data in the table {table_name} has been deleted.")

        return

    else:
        # NOTE 12/21 新增
        print("Grammatical errors")
        quit()
        #raise Exception("語法錯誤")
    
    data_path = f"db/{dbName}/{table_name}/data.csv"
    col_path = f"db/{dbName}/{table_name}/col.csv"
    if(os.path.exists(col_path)):
        i=0
        col_dict = {}
        data_dict={}
        with open(col_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                col_name = row[0]
                is_pk = int(row[1])
                is_idx = int(row[2])
                col_dict[col_name] = [is_pk, is_idx]
                i=i+1
            #print(col_dict)
        keys=[]
        for key in col_dict.keys():
            keys.append(key)
        with open(data_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                data_dict = process_row(row, keys)
            #print("Before Deletion:")
            #print(data_dict)
            
            # Delete records based on the DELETE query condition
            data_dict = delete_record(data_dict, column_name, operator, value)
            
            #print("After Deletion:")
            #print(data_dict)
            save_to_csv(data_dict, col_dict, data_path)
            print("Data has been updated in CSV file.")
        
    else:
        print('無路徑')

def update_record(data_dict, column_values, where_column, where_value):
    if where_column in data_dict:
        indices_to_update = []

        # Identify indices to update based on WHERE condition
        for i, val in enumerate(data_dict[where_column]):
            if val == where_value:
                indices_to_update.append(i)

        # Update values at the identified indices for specified columns
        for column, value in column_values.items():
            if column in data_dict:
                for i in indices_to_update:
                    data_dict[column][i] = value

    return data_dict        
        
def UPDATE(query: str):
    data_dict={}
    # 定義正則表達式
    update_pattern = re.compile(r'UPDATE\s+(\w+)\s+SET\s+((\w+)\s*=\s*(\S+)(?:\s*,\s*(\w+)\s*=\s*(\S+))*)\s+WHERE\s+(\w+)\s*=\s*(\S+)', re.IGNORECASE)

    
    # 使用正則表達式匹配語句
    match = update_pattern.match(query)
    
    if match:
        # 提取匹配的各個元素
        table_name = match.group(1).lower()
        set_clause = match.group(2)
        where_column = match.group(7).lower()
        where_value = match.group(8)
        #print("where_value")
        #print(where_value)
        v=where_value.split("'")
        value=v[1]
        #print(value)
        # 解析 SET 子句，提取列名和值
        set_values = dict(re.findall(r'(\w+)\s*=\s*(\S+)', set_clause))
        for key, values in set_values.items():
            # NOTE 12/21 新增
            set_values[key] = values.replace(",", "").strip("'")
        set_values = {key.lower(): value for key, value in set_values.items()}# mod
        #print(table_name, set_values, where_column, value)
    else:
        print("ERROR")
    
    data_path = f"db/{dbName}/{table_name}/data.csv"
    col_path = f"db/{dbName}/{table_name}/col.csv"
    if(os.path.exists(col_path)):
        i=0
        col_dict = {}
        data_dict={}
        with open(col_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                col_name = row[0]
                is_pk = int(row[1])
                is_idx = int(row[2])
                col_dict[col_name] = [is_pk, is_idx]
                i=i+1
            #print(col_dict)
        keys = list(col_dict.keys())
        for key in col_dict.keys():
            keys.append(key)
        with open(data_path, 'r', encoding='utf-8') as file:
            reader = csv.reader(file)
            for row in reader:
                data_dict = process_row(row, keys)
            #print("Before Update:")
            #print(data_dict)
            
            # Update records based on the UPDATE query condition
            data_dict = update_record(data_dict, set_values, where_column, value)
            #print(data_dict, set_values, where_column, value)
            #print("After Update:")
            #print(data_dict)
            
            # Save the updated data back to the CSV file
            save_to_csv(data_dict, col_dict, data_path)
            print("Data has been updated in CSV file.")
    else:
        print('無路徑')




def execute_sql(query:str):
    tokens = query.split()
    operation = tokens[0]

    if operation == "SELECT":
        Select(query.upper())
    elif operation =="INSERT":
        Insert(query)
    elif operation =="DELETE":
        DELETE(query)
    elif operation =="UPDATE":
        UPDATE(query)
    else:
        print("Unsupported operation")
    

#主程式 KAI
sql_query = 'SELECT * FROM students'
#sql_query = 'SELECT sid,name FROM students'
#sql_query = 'SELECT * FROM students WHERE sid = "M1115522"'
#sql_query = 'SELECT * FROM vote Where vote = 1'
#sql_query = 'SELECT * FROM vote Where 0'
#sql_query = 'SELECT * FROM vote Where 1 = 2
#sql_query = 'SELECT * FROM vote,students WHERE students.sid = students.name'

#主程式
#sql_query = 'SELECT sid,name FROM students WHERE sid > "M1115505"'
#sql_query = "INSERT INTO students VALUES ('A1000007','王測試','測試系','')"
#sql_query = "DELETE FROM students WHERE sid='A1000002';"
#sql_query = "UPDATE students SET sid='A1000008' WHERE sid='A1000002';"
#sql_query = 'SELECT department FROM students GROUP BY department'
#sql_query = 'SELECT score FROM students GROUP BY department HAVING SUM(score)>1'

# NOTE 12/28 新增
# 解決此 query 會顯示 count 欄位的問題
#sql_query = "SELECT score FROM students GROUP BY department"
# 以下 query 會顯示錯誤
#sql_query = "SELECT SUM(score) FROM students GROUP BY department"
#sql_query = "SELECT MAX(score) FROM students GROUP BY department"
#sql_query = "SELECT score FROM students GROUP BY department, name"
        
# NOTE 12/29 新增
#sql_query = "SELECT name, sid, name,sid,name FROM students GROUP BY department"
#sql_query = "SELECT name FROM students GROUP BY department"
#sql_query = "SELECT department FROM students GROUP BY department HAVING SUM(score)>2"

# sql_query = "SELECT name , department FROM students GROUP BY department HAVING SUM(score)>2"

# sql_query = command
# print(command)
#command = command.replace("\\","\"")
# print(command)

# sql_query = "SELECT score FROM students GROUP BY department"

#sql_query = "SELECT name FROM instructors GROUP BY department"
# sql_query = "SELECT c_no FROM classes GROUP BY c_no HAVING SUM(score)>100"

# dbName = "students"
# execute_sql(sql_query)

dbName = sys.argv[1]
execute_sql(command)