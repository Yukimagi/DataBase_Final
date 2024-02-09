<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 檢查輸入的資料是否齊全
    if (
        isset($_POST['db_name']) &&
        isset($_POST['table_name']) &&
        isset($_POST['num_columns']) &&
        isset($_POST['columns'])
    ) {
        $db_name = $_POST['db_name'];
        $table_name = $_POST['table_name'];
        $num_columns = $_POST['num_columns'];
        $columns = $_POST['columns'];

        // 寫入欄位名稱到 col.csv
        $folder_path = "db/$db_name/$table_name";
        $col_file = fopen("$folder_path/col.csv", "w");
        // 寫入csv格式的內容：欄位名稱,0,0 每行一個欄位
        foreach ($columns as $column) {
            fputcsv($col_file, [$column, 0, 0]);
        }
        fclose($col_file);

        // 產生空的 data.csv
        $data_file = fopen("$folder_path/data.csv", "w");
        fclose($data_file);

        // 跳轉或顯示成功訊息
        echo "Table created successfully!";
        echo '<html><head><title>返回上一頁</title></head><body>';
        echo '<p>將在3秒後返回上一頁。</p>';

                // 使用JavaScript在3秒後返回上一頁
        echo '<script>setTimeout(function() { history.go(-2); }, 3000);</script>';

        echo '</body></html>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>日日香-DataBase-Input Columns</title>

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
 <li><a href="./db_designer.php?db=<?php echo $q_db;?>">設計器</a></li>
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
<h2>Input Columns</h2>
 <form method="post" action="">
        <input type="hidden" name="db_name" value="<?php echo $_GET['db_name']; ?>">
        <input type="hidden" name="table_name" value="<?php echo $_GET['table_name']; ?>">
        <input type="hidden" name="num_columns" value="<?php echo $_GET['num_columns']; ?>">

        <h2>Enter Column Names</h2>

        <?php for ($i = 1; $i <= $_GET['num_columns']; $i++): ?>
            <label for="column_<?php echo $i; ?>">Column <?php echo $i; ?>:</label>
            <input type="text" name="columns[]" required>
        <?php endfor; ?>
        
        <button type="submit">Submit Columns</button>
    </form>


</article>

</section>
</main>



<footer>
</footer>

</body>
</html>