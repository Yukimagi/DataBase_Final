<!DOCTYPE html>
<html>
<head>
<title>日日香-DataBase</title>

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
</style>


    <script>
        function loadTables(database, targetSelect) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var tables = JSON.parse(xhr.responseText);
                    var select = document.getElementById(targetSelect);
                    select.innerHTML = ""; // 清空原有選項

                    tables.forEach(function(table) {
                        var option = document.createElement("option");
                        option.value = table;
                        option.text = table;
                        select.add(option);
                    });
                }
            };
            xhr.open("GET", "get_tables.php?database=" + encodeURIComponent(database), true);
            xhr.send();
        }
    </script>

</head>

<body>

<header id="header">
<a href="homepage.php">日日香🍚DATABASE</a>
</header>

<?php
  $st_url1=$_SERVER["REQUEST_URI"];
  $st_url2 = explode("?",$st_url1)[1];
  $q_db = $_GET['db'];
?>

<div id="menu">
<ul>
 <li><a href="./db_structure.php?db=<?php echo $q_db;?>">結構</a></li>
 <li><a href="#">搜尋</a></li>
 <li><a href="./db_structure.php?db=<?php echo $q_db;?>">設計器</a></li>
</ul>
</div>

<main>
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
        $URL = substr( $URL , 0 , -16); 
        $URL2 = $URL."menu_1.php" . '?db=' . $db_name . '&tb=' . $tb_name;
        echo'<li><a href="'.$URL2.'">'.$tb_name.'</a></li>';
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

<section>
<article>
<p>
<h2>關聯表</h2>
<?php
$dbPath = 'db'; // 這是到資料庫目錄的路徑

// 這個函數讀取指定路徑的資料夾，返回資料夾名稱作為資料庫或資料表名稱
function readDirectories($path) {
    return array_filter(glob($path . '/*'), 'is_dir');
}

// 這個函數讀取col.csv文件並返回列名。對於被參考的資料表，它將只返回標記為主鍵的列
function readTableColumns($tablePath, $onlyPrimaryKey = false) {
    $columns = [];
    if (($handle = fopen($tablePath . '/col.csv', "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (!$onlyPrimaryKey || $row[1] == '1') {
                $columns[] = $row[0];
            }
        }
        fclose($handle);
    }
    return $columns;
}

// 選擇資料庫
$selectedDb = isset($_GET['db']) ? $_GET['db'] : '';
$databaseDirectories = readDirectories($dbPath);

// 獲取選擇的資料表
$selectedReferencingTable = isset($_POST['referencingTable']) ? $_POST['referencingTable'] : '';
$selectedReferencedTable = isset($_POST['referencedTable']) ? $_POST['referencedTable'] : '';

// 獲取資料表的屬性
$referencingAttributes = $selectedReferencingTable ? readTableColumns("$dbPath/$selectedDb/$selectedReferencingTable") : [];
$referencedAttributes = $selectedReferencedTable ? readTableColumns("$dbPath/$selectedDb/$selectedReferencedTable", true) : [];

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedReferencingAttribute = isset($_POST['referencingAttribute']) ? $_POST['referencingAttribute'] : '';
    $selectedReferencedAttribute = isset($_POST['referencedAttribute']) ? $_POST['referencedAttribute'] : '';

    if ($selectedReferencingAttribute && $selectedReferencedAttribute) {
        // 將用戶選擇的屬性關係寫入到文件中
        // 檢查目標資料夾是否存在，如果不存在，則創建它

        $outputFile = "relation/".$selectedDb."_relations.txt";
        $content = "參考的人：" . $selectedReferencingTable . " 屬性：" . $selectedReferencingAttribute . "\n" .
                   "被參考：" . $selectedReferencedTable . " 屬性：" . $selectedReferencedAttribute . "\n";
        file_put_contents($outputFile, $content, FILE_APPEND);
        echo "<p>已將您的選擇保存到文件中。</p>";
    }
}
?>

<h4>選擇要操作的資料庫：</h4>
<form method="get">
    <label for="db">選擇資料庫：</label>
    <select name="db" id="db" onchange="this.form.submit()">
        <option value="">請選擇資料庫</option>
        <?php foreach ($databaseDirectories as $dir): ?>
            <option value="<?= basename($dir) ?>" <?= $selectedDb == basename($dir) ? 'selected' : '' ?>><?= basename($dir) ?></option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($selectedDb): ?>
    <h4>選擇關聯的屬性：</h4>
    <form method="post">
        <div style="float: left; margin-right: 20px;">
            <h3>參考別人:</h3>
            <select name="referencingTable" onchange="this.form.submit()">
                <option value="">請選擇資料表</option>
                <?php
                $tableDirectories = readDirectories("$dbPath/$selectedDb");
                foreach ($tableDirectories as $tableDir):
                    $tableName = basename($tableDir);
                ?>
                    <option value="<?= $tableName ?>" <?= $selectedReferencingTable == $tableName ? 'selected' : '' ?>><?= $tableName ?></option>
                <?php endforeach; ?>
            </select>
            <?php foreach ($referencingAttributes as $attribute): ?>
                <div>
                    <input type="radio" name="referencingAttribute" value="<?= $attribute ?>" id="<?= $attribute ?>" <?= isset($_POST['referencingAttribute']) && $_POST['referencingAttribute'] == $attribute ? 'checked' : '' ?>>
                    <label for="<?= $attribute ?>"><?= $attribute ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="float: left;">
            <h3>被參考的:</h3>
            <select name="referencedTable" onchange="this.form.submit()">
                <option value="">請選擇資料表</option>
                <?php foreach ($tableDirectories as $tableDir):
                    $tableName = basename($tableDir);
                ?>
                    <option value="<?= $tableName ?>" <?= $selectedReferencedTable == $tableName ? 'selected' : '' ?>><?= $tableName ?></option>
                <?php endforeach; ?>
            </select>
            <?php foreach ($referencedAttributes as $attribute): ?>
                <div>
                    <input type="radio" name="referencedAttribute" value="<?= $attribute ?>" id="ref_<?= $attribute ?>" <?= isset($_POST['referencedAttribute']) && $_POST['referencedAttribute'] == $attribute ? 'checked' : '' ?>>
                    <label for="ref_<?= $attribute ?>"><?= $attribute ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="clear: both;">
            <input type="submit" value="提交">
        </div>
    </form>
<?php endif; ?>

</article>

</section>
</main>



<footer>
</footer>

</body>
</html>