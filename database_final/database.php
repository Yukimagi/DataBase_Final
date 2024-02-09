<!DOCTYPE html>
<html>
<head>
<title>日日香DataBase-資料庫</title>

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
font-size:20pt;
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
padding-left:2em;padding-right:2em;
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
        .cart > li > a:hover {  /* 製作hover效果 */
        background-color: #007bff;
        color: #FFFFFF;
        }
        .cart ul {  
            display: none;
        }
        ul { list-style: none; }
        .content{width:1200px; margin-left: auto; margin-right: auto;}
        table{
        font-family: 'Oswald', sans-serif;
        border-collapse:collapse;

        }

        th{
        background-color:lightsalmon;
        color:#ffffff;
        width:25vw;
        height:50px;
        }

        td{
        background-color:lightsalmon;
        width:25vw;
        height:50px;
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
  width: 100px; /* 調整寬度 */
  height:28px;
  font-size: 24px; /* 調整字體大小 */
}

/* 調整按鈕樣式 */
button[type="submit"] {
  font-size: 20px; /* 調整字體大小 */
  height:32px;
}

input[type="text"] {
  font-size: 20px; /* 調整字體大小 */
  height:26px;
}

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
  $st_url1 = substr( $st_url1 , 0 , -10); 
?>

<div id="menu">
<ul>
 <li><a href="homepage.php">主頁</a></li>
 <li><a href="database.php">資料庫</a></li>
 <!-- <li><a href="SQL.php">SQL</a></li> -->
 <li><a href="IO.php">匯入/出</a></li>
</ul>
</div>



<main>
<section>
<article>
<p>
<h2>資料庫</h2>
<table>
  
</table> 
</article>
<h2>新增資料庫：</h2>
<form method="post">
  <label for="newDbName">資料庫名稱：</label>
  <input type="text" id="newDbName" name="newDbName" required>
  <button type="submit" name="addDb">新增</button>
</form>

<h2>刪除資料庫：</h2>
<form method="post">
  <label for="deleteDbName">選擇要刪除的資料庫：</label>
  <select name="deleteDbName" id="deleteDbName">
    <?php
    $dbFolders = glob('db/*', GLOB_ONLYDIR);
    foreach ($dbFolders as $dbFolder) {
        $dbName = basename($dbFolder);
        echo '<option value="' . $dbName . '">' . $dbName . '</option>';
    }
    ?>
  </select>
  <button type="submit" name="deleteDb">刪除</button>
</form>

<?php
if (isset($_POST['addDb'])) {
    $newDbName = $_POST['newDbName'];
    $newDbFolder = 'db/' . $newDbName;

    if (!file_exists($newDbFolder)) {
        mkdir($newDbFolder);
        echo '資料庫 ' . $newDbName . ' 已新增。';
    } else {
        echo '資料庫 ' . $newDbName . ' 已存在，無法重複新增。';
    }
}
function delTree($dir) { 
    $files = glob($dir . '*', GLOB_MARK); 
    foreach ($files as $file) { 
        if (is_dir($file)) {
            delTree($file);
        } else {
            if (!unlink($file)) {
                echo 'Error deleting file: ' . $file;
            }
        }
    }

    if (is_dir($dir)) {
        if (!rmdir($dir)) {
            echo 'Error deleting directory: ' . $dir;
        }
    }
}
if (isset($_POST['deleteDb'])) {
    $deleteDbName = $_POST['deleteDbName'];
    $deleteDbFolder = 'db/' . $deleteDbName;

    if (file_exists($deleteDbFolder)) {
        // 刪除資料庫資料夾
        delTree($deleteDbFolder);
        echo '資料庫 ' . $deleteDbName . ' 已刪除。';
    } else {
        echo '資料庫 ' . $deleteDbName . ' 不存在，無法刪除。';
    }
}
?>

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
        $URL = substr( $URL , 0 , -12); 
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