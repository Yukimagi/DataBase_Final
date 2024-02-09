<!DOCTYPE html>
<html>
<head>
<title>日日香Database-匯出/匯入</title>

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

h5{
font-size:16pt;
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

/* 調整下拉式選單樣式 */
select {
  width: 150px; /* 調整寬度 */
  height:28px;
  font-size: 24px; /* 調整字體大小 */
}

/* 調整按鈕樣式 */
input[type="submit"] {
  font-size: 20px; /* 調整字體大小 */
  height:32px;
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
  $st_url1 = substr( $st_url1 , 0 , -6); 
?>

<div id="menu">
<ul>
 <li><a href="homepage.php">主頁</a></li>
 <li><a href="database.php">資料庫</a></li>
 
 <li><a href="IO.php">匯入/出</a></li>
</ul>
</div>

<main>
<section>
<article>
<p>
    <h2>匯入/匯出</h2>
    <h3>選擇要操作的資料庫：</h3>
    <form method="get">
        <h5><label for="db">選擇資料庫：</label>
        <select name="db" id="db">
            <?php
            $dbFolders = glob('db/*', GLOB_ONLYDIR);
            foreach ($dbFolders as $dbFolder) {
                $dbName = basename($dbFolder);
                echo '<option value="' . $dbName . '">' . $dbName . '</option>';
            }
            ?>
        </select>
        <input type="submit" value="選擇">
    </form>

    <?php
    if (isset($_GET['db'])) {
        $selectedDb = $_GET['db'];
        echo '<h2>操作資料庫：' . $selectedDb . '</h2>';
    ?>
    
    <h3>選擇要操作的資料表：</h3>
    <form method="get">
        <input type="hidden" name="db" value="<?php echo $selectedDb; ?>">
        <h5><label for="table">選擇資料表：</label>
        <select name="table" id="table">
            <?php
            $tableFolders = glob('db/' . $selectedDb . '/*', GLOB_ONLYDIR);
            foreach ($tableFolders as $tableFolder) {
                $tableName = basename($tableFolder);
                echo '<option value="' . $tableName . '">' . $tableName . '</option>';
            }
            ?>
        </select>
        <input type="submit" value="選擇">
    </form>

    <?php
    }

    if (isset($_GET['db']) && isset($_GET['table'])) {
        $selectedDb = $_GET['db'];
        $selectedTable = $_GET['table'];
    ?>
    
    <!-- 以下是資料表操作部分，包括下載和上傳 -->
    <h2>下載資料表：</h2>
    <form action="download.php" method="post">
        <input type="hidden" name="db" value="<?php echo $selectedDb; ?>">
        <input type="hidden" name="table" value="<?php echo $selectedTable; ?>">
        <input type="submit" value="下載資料表">
    </form>

    <h2>上傳資料：</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".csv" required><br>
        <input type="hidden" name="db" value="<?php echo $selectedDb; ?>">
        <input type="hidden" name="table" value="<?php echo $selectedTable; ?>">
        <input type="submit" value="上傳">
    </form>

    <?php
    }
    ?>
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
        $URL = substr( $URL , 0 , -6); 
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