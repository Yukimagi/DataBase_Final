<!DOCTYPE html>
<html>
<head>
<title>日日香-菜單</title>

<meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://code.jquery.com/ui/1.12.1/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
   <style>
A:link{text-decoration:underline;color:purple;font-family:標楷體}
A:visited{text-decoration:none;color:purple;font-family:標楷體}
A:hover{text-decoration:none;color:#cc3300;font-family:新細明體;font-style:italic;font-weight:900;}
a:active{color:#FF00FF;text-decoration:none;}
p{display:block;width:70%;white-space:pre-line;text-align:justify; text-justify:inter-ideograph; text-indent:2em;}

       h1 {
           padding-top: 40px;
           text-align: center;
           font-size: 30pt;
           color: white;
           font-family: 微軟正黑體;
       }
h2{
font-size:28pt;
text-align:left;
color:gray;
}
h3{
font-size:20pt;
text-align:left;
color:black;
}
h4{font-size:30pt;color:black;font-weight: 900 }

body{
padding-top:0px;
margin:0 auto;
width:100%;
}

*{margin:0;}

#header{/*要記得做結尾，不然會全包，在下面</header>*/
margin:0 auto;
width:100%;
height:100px;/*下面還會再追加10px給menu*/
background-color:#eb6c00;
}  

#header  a{/*做table中美觀的排版(block為不要有底線)*/
display:block;
text-align:center;
color:white;
text-decoration:none;
padding-top: 0px;
 font-size: 40pt;
font-family: 微軟正黑體;
}

#header  a:hover{/*移到超連結時改變顏色*/
color:white;
background-color:lightsalmon;
}

#menu{
padding:0;
margin:0 auto;
background-color:#eb6c00;
width:100%;
text-align:center;
color:gray;
}

#menu ul{/*就像是在做table*/
width:100%;
padding:0;
display:table;
border-spacing:2px;
}

#menu li{/*做table的表格*/
display:table-cell;
background-color:#eb6c00;
list-style-type:none;
font-size:28pt;
color:white;
}

#menu li a{/*做table中美觀的排版(block為不要有底線)*/
display:block;
text-align:center;
padding-bottom:20px;/*剛剛說要加的10px*/
color:white;
text-decoration:none;
}

#menu li a:hover{/*移到超連結時改變顏色*/
color:white;
background-color:lightsalmon;
}

main{
margin:0 auto;
width=100%;
}

section{
margin:0 auto;
padding-left:2em;padding-right:2em;
float:left;
width:55%;
height:2200px;
border-left-width:2px;border-left-color:brown;border-left-style:dotted;
background-color:white;
}

article{
border-bottom-width:2px;border-bottom-color:brown;border-bottom-style:dotted;
background-color:white;
}

aside{
margin:0 auto;
float:right;
width:25%;
height:2200px;
background-color:white;
/* padding-left:2em;padding-right:2em; */

border-left-width:2px;border-left-color:brown;border-left-style:dotted;
border-right-width:2px;border-right-color:brown;border-right-style:dotted;
/*background-image:url(下載.jpg);*//*可以用圖片當背景*/
}

footer{
margin:0 auto;
padding:0;
clear:both;/*清掉前面的float*/
width:100%;
height:50px;
background-color:black;
color:gray;
font-size:20pt;
text-align:left;
}

/*new*/
        .cart > li > a {  /* 選擇設定主要選單a元素 */
        border: 1px solid #000;
        font-size: 16px;
        display: block;
        padding: 5px;
        margin: 5px;
        }
        li{
          padding-left: 10px;
          padding-right: 10px;
        }
        .cart ul {  
            display: none;
        }
        ul { 
          list-style: none; 
          padding-left: 0;
        }
        .content{width:1200px; margin-left: auto; margin-right: auto;}
        table{
        font-family: 'Oswald', sans-serif;
        border-collapse:collapse;
        }

        th{
        padding:5px;
        background-color:lightsalmon;
        color:#ffffff;
        width:auto;
        height:20px;
        }

        td{
        padding:5px;
        background-color:lightsalmon;
        width:auto;
        height:20px;
        text-align:center;
        }

        tr{
        border-bottom: 1px solid #dddddd;
        }

        tr:last-of-type{
        border-bottom: 2px solid lightsalmon;
        }

        tr:nth-of-type(even) td{
        background-color:#f3f3f3;
        }
        .hide{
          display:none;
        }
        .show{
          display:inline;
        }
</style>

</head>

<body>

<header id="header">
<a href="homepage.php">日日香🍚DATABASE</a>
</header>

<?php
  $st_url1=$_SERVER["REQUEST_URI"];
  $st_url2 = explode("?",$st_url1)[1];
  $st_url1 = explode("?",$st_url1)[0];
  $st_url1 = substr( $st_url1 , 0 , -13); 
?>

<div id="menu">
<ul>
 <li><a href="<?php echo $st_url1.'menu_1.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">瀏覽</a></li>
 <li><a href="<?php echo $st_url1.'struct.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">結構</a></li>
 <li><a href="<?php echo $st_url1.'table_search.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">搜尋</a></li>
 <li><a href="<?php echo $st_url1.'table_add.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">新增</a></li>
 <li><a href="<?php echo $st_url1.'IO.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">匯入/出</a></li>
 <li><a href="<?php echo $st_url1.'SQL.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">SQL</a></li>
</ul>
</div>

<main>
<section>
  <article>
    <p>
    <h2>新增</h2>
    <!-- 搜尋介面 送出搜尋會隱藏 -->
    <div  <?php if(isset($_GET['searched'])){echo "class='hide'";}else{echo "class='show'";} ?>>
      <table>
        <tr>
          <th>欄位</th>
          <th>型態</th>
          <th>值</th>
        </tr>
        <form method="GET">
        <?php
          $col_num = 0;
          $q_db=$_GET['db'];
          $q_tb=$_GET['tb'];
          echo '<input type="hidden" name="db" value ="'.$q_db.'">';
          echo '<input type="hidden" name="tb" value ="'.$q_tb.'">';
          $i = 0;
          $file = fopen(__DIR__ ."/db"."/".$q_db."/".$q_tb."/col.csv","r");
            while(!feof($file)){
              $i++;
              $arr2 = fgetcsv($file);
              if($arr2[0]==""){
                break;
              }
              echo"<tr>";
              echo '<td>'.$arr2[0].'</td>';
              echo'<td>'.'</td>';
              echo'<td>'.'<input type="text" name="'.$i.'">'.'</td>';
              echo"</tr>";
              $col_num += 1;
            }
          fclose($file);
        ?>
      </table>
      <input type="submit" name="searched" id="searched" value="執行" onclick="hideButton()">
      <?php
        $check1 = 0;
        $check2 = 1;
        if (isset($_GET['searched'])) {
          $myarr = [];
          for($l = 0; $l < $col_num; $l++){
            array_push($myarr, $_GET[$l+1]);
            if($_GET[$l+1] != ""){
              $check1 = 1;
            }
          }
          //////////////////////
          $csvFilePath = __DIR__ ."/db"."/".$q_db."/".$q_tb."/data.csv";
          // echo $csvFilePath;
          // 開啟CSV文件
          $file = fopen($csvFilePath, 'r');
          $csvData = [];

          // 讀取CSV文件的內容
          while (($row = fgetcsv($file)) !== false) {
              $csvData[] = $row;
          }

          // 關閉文件
          fclose($file);

          foreach ($csvData as $key => $row) {
            if($csvData[$key] == $myarr){
              $check2 = 0;
              break;
            }
          }
          /////////////////////
          if($check1 && $check2){
            $file2 = fopen(__DIR__ ."/db"."/".$q_db."/".$q_tb."/data.csv","a");
              fputcsv($file2,$myarr);
            fclose($file2);
          }
        }
      ?>
      </form>
    </div>

    <!-- 搜尋結果介面 正常會隱藏 -->
    <div <?php if(!isset($_GET['searched'])){echo "class='hide'";}else{echo "class='show'";} ?> >
      <h2><?php if($check1 && $check2){echo "成功新增一筆";}else{ echo "失敗";}?></h2>
    </div>

  </article>
</section>


<aside>
<ul class="cart">
<?php
  echo $URL;
    $filter4db = glob("db/*"); 
    for($i = 0; $i < count($filter4db); $i++){
      $filter4tb = glob($filter4db[$i]."/*",GLOB_ONLYDIR);
      echo'<li>';
      $db_name = substr( $filter4db[$i] , 3 , strlen($filter4db[$i]));
      echo'<a href="./db_structure.php?db='.$db_name.'">'.$db_name.'</a>';
      echo'<button type="button">+</button>';
      echo'<ul>';
      for($j = 0; $j < count($filter4tb); $j++){
        $arr = mb_split("/",$filter4tb[$j]);
        $tb_name = $arr[count($arr)-1];
        $URL=strtok($_SERVER["REQUEST_URI"],'?');
        $URL = substr( $URL , 0 , -13); 
        $URL = $URL."menu_1.php" . '?db=' . $db_name . '&tb=' . $tb_name;
        echo'<li><a href="'.$URL.'">'.$tb_name.'</a></li>';
      }
      echo'</ul>';
      echo'</li>';
    }
  ?>
</ul>
<script>
  $('.cart > li > button').click(function (e) { 
    // $(this).parent().siblings().find('ul').slideUp();
    $(this).parent().find('ul').slideToggle();
  });
</script>
</aside>
</main>



<footer>
</footer>

</body>
</html>