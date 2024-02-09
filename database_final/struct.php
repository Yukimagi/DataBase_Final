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
<li><a href="<?php echo $st_url1.'menu_1.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">瀏覽</a></li>
 <li><a href="<?php echo $st_url1.'struct.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">結構</a></li>
 <li><a href="<?php echo $st_url1.'table_search.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">搜尋</a></li>
 <li><a href="<?php echo $st_url1.'table_add.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">新增</a></li>
 <li><a href="<?php echo $st_url1.'IO.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">匯入/出</a></li>
 <li><a href="<?php echo $st_url1.'SQL.php?db='.$_GET['db'].'&tb='.$_GET['tb'] ?>">SQL</a></li>
</ul>
</div>

<?php
$q_db = $_GET['db'];
$q_tb = $_GET['tb'];
  if (isset($_GET['row'])) {
      $rowToAddPK = $_GET['row'];
      // CSV文件的路徑
      $csvFilePath = __DIR__ ."/db"."/".$q_db."/".$q_tb."/col.csv";
      // echo $csvFilePath;
      // 開啟CSV文件
      $file = fopen($csvFilePath, 'r');
      // 初始化一個空陣列來存儲CSV文件的每一行
      $csvData = [];
      // 讀取CSV文件的內容
      while (($row = fgetcsv($file)) !== false) {
          $csvData[] = $row;
      }
      // 關閉文件
      fclose($file);
      // 找到行
      foreach ($csvData as $key => $row) {
        if ($key == $rowToAddPK) {
            $csvData[$key][1] = "1";
            break;
        }
      }
      // 重新索引數組，以防止出現缺失的索引
      $csvData = array_values($csvData);
      // 開啟CSV文件以寫入
      $file = fopen($csvFilePath, 'w');
      // 將修改後的數據寫回CSV文件
      foreach ($csvData as $row) {
          fputcsv($file, $row);
      }
      // 關閉文件
      fclose($file);
      echo '<script>';
      echo 'alert("主鍵已成功新增。");';
      echo '</script>';
  }
  if (isset($_GET['where'])) {
    $check = 1;
    $rowToADD = $_GET['where'];
    $howmuch = $_GET['howmuch'];
    $csvFilePath = __DIR__ ."/db"."/".$q_db."/".$q_tb."/col.csv";

    $file = fopen($csvFilePath, 'r');
    $csvData = [];
    while (($row = fgetcsv($file)) !== false) {
        $csvData[] = $row;
        for($j = 0;$j < $howmuch;$j++){
          if($row[0] == $_GET[$j]){
            $check = 0;
            break;
          }
        }
    }
    fclose($file);
    if($check == 1){
      $templist=[];
      for($k = 0;$k < $howmuch;$k++){
        $templistin=[];
        array_push($templistin,$_GET[$k],"0","0");
        array_push($templist,$templistin);
      }
      $csvData1 = array_slice($csvData, 0, $rowToADD);
      $csvData2 = array_slice($csvData, $rowToADD);
      $csvData = array_merge($csvData1,$templist,$csvData2);
      $csvData = array_values($csvData);

      $file = fopen($csvFilePath, 'w');
      foreach ($csvData as $row) {
          fputcsv($file, $row);
      }
      fclose($file);
      echo '<script>';
      echo 'alert("column已成功新增");';
      echo '</script>';
    }else{
      echo '<script>';
      echo 'alert("新增失敗，出現重複值");';
      echo '</script>';
    }
    ///////////////////////////////////////////////////////////////
    $csvFilePath = __DIR__ ."/db"."/".$q_db."/".$q_tb."/data.csv";

    // 指定要插入的空值的數量
    $numColumnsToInsert = $howmuch;

    // 指定插入的起始欄位位置（從0開始）
    $startInsertIndex = $rowToADD;

    // 開啟原始 CSV 檔案
    $inputFile = fopen($csvFilePath, 'r');

    // 檢查檔案是否成功開啟
    if ($inputFile === false) {
        die("Unable to open input file.");
    }

    // 創建臨時檔案
    $tempFilePath = 'temp.csv';
    $tempFile = fopen($tempFilePath, 'w');

    // 檢查檔案是否成功開啟
    if ($tempFile === false) {
        fclose($inputFile);
        die("Unable to open temporary file.");
    }

    // 逐行讀取原始 CSV 檔案，插入空值後寫入臨時檔案
    while (($row = fgetcsv($inputFile)) !== false) {
        // 插入指定數量的空值
        array_splice($row, $startInsertIndex, 0, array_fill(0, $numColumnsToInsert, ''));

        // 寫入臨時檔案
        fputcsv($tempFile, $row);
    }

    // 關閉檔案
    fclose($inputFile);
    fclose($tempFile);

    // 覆蓋原始檔案
    rename($tempFilePath, $csvFilePath);
    }
?>



<main>
<section>
<article>
<p>
<h2>結構</h2>
<table>
  <tr>
    <th>.</th>
    <th>#</th>
    <th>名稱</th>
    <th>動作</th>
  </tr> 
  <?php
      $q_db = $_GET['db'];
      $q_tb = $_GET['tb'];
      $file = fopen(__DIR__ ."/db"."/".$q_db."/".$q_tb."/col.csv","r");
      $i = 0;
      $arrofOption = [];
      while(!feof($file)){
        $i++;
        $arr2 = fgetcsv($file);
        if($arr2[0]==""){
          break;
        }
        echo"<tr>";
        echo'<td>'.'</td>';
        echo'<td>'.$i.'</td>';
        echo '<td>'.$arr2[0];
        if($arr2[1] == 1){
          echo '<img src="pic/key.png" height=20 weight=20 border=0 style="display:inline; margin:0 auto;" />';
        }
        echo '</td>';
        echo'<td>';
        echo '<button onclick="showConfirmation3('.($i-1).')">修改</button>';
        echo '<button onclick="showConfirmation2('.($i-1).')">刪除</button>';
        if($arr2[1] != 1){
          echo '<button onclick="showConfirmation('.($i-1).')">主鍵</button>';
        }else{
          echo '<button onclick="" style="color:grey">主鍵</button>';
        }
        echo '<a href="#">唯一</a><a href="#">索引</a><a href="#">空間</a><a href="#">全文搜尋</a><a href="#">顯示相異值</a>'.'</td>';
        echo"</tr>";
        array_push($arrofOption,$arr2[0]);
      }
    ?> 
    <script>
    function showConfirmation(value) {
        var result = confirm("確定要新增主鍵嗎？");
        if (result) {
            // alert("你按下了確定按鈕！"+value);
            var currentUrl = window.location.href;
            var separator = currentUrl.indexOf('?') !== -1 ? '&' : '?';
            var newUrl = currentUrl + separator + "row=" + encodeURIComponent(value);
            window.location.href = newUrl;
        }
    }

    function showConfirmation2(value) {
        var result = confirm("確定要刪除嗎？");
        if (result) {
          var currentUrl = window.location.href;

          // 獲取 URL 中的 GET 參數
          var params = new URLSearchParams(window.location.search);
          var dbParam = params.get('db');
          var tbParam = params.get('tb');

          // 提取當前 URL 中的資料夾部分
          var folderUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/'));

          // 組合新的 URL，包括 GET 參數
          var mainPhpUrl = folderUrl + '/struct_delete.php?db=' + encodeURIComponent(dbParam) + '&tb=' + encodeURIComponent(tbParam);
          var newUrl = mainPhpUrl + "&dlrow=" + encodeURIComponent(value);
          window.location.href = newUrl;
        }
    }

    function showConfirmation3(value,db,tb) {
          var currentUrl = window.location.href;

          // 獲取 URL 中的 GET 參數
          var params = new URLSearchParams(window.location.search);
          var dbParam = params.get('db');
          var tbParam = params.get('tb');

          // 提取當前 URL 中的資料夾部分
          var folderUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/'));

          // 組合新的 URL，包括 GET 參數
          var mainPhpUrl = folderUrl + '/struct_update.php?db=' + encodeURIComponent(dbParam) + '&tb=' + encodeURIComponent(tbParam);
          var newUrl = mainPhpUrl + "&udrow=" + encodeURIComponent(value);
          window.location.href = newUrl;
    }
  </script>
</table> 

<form method="get" action="struct_add.php">
  <?php
    echo '<input type="hidden" name="db" value ="'.$q_db.'">';
    echo '<input type="hidden" name="tb" value ="'.$q_tb.'">';
  ?>
<h3>新增<input type="number" name="howmuch" value=1 style="display:inline; width:40px;">筆於
<select id="where" name="where">
  <option value=0>
    於資料表開始
  </option>
  <?php
    foreach ($arrofOption as $value => $num){
      echo "<option value=".($value+1).">";
      echo $num;
      echo "</option>";
    }
  ?>
</select>
之後</h3>
<input type="submit" value="執行">

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
        $URL = substr( $URL , 0 , -10); 
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
    e.preventDefault();  // 取消默認行為
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