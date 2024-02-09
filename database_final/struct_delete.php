<?php
$db = $_GET['db'];
$tb = $_GET['tb'];

if (isset($_GET['dlrow'])) {
    $rowToDelete = $_GET['dlrow'];

    // CSV文件的路徑
    $csvFilePath = __DIR__ ."/db"."/".$db."/".$tb."/col.csv";
    // echo $csvFilePath;
    // 開啟CSV文件
    $file = fopen($csvFilePath, 'r');

    // 初始化一個空陣列來存儲CSV文件的每一行
    $csvData = [];

    $count_row = 0;
    // 讀取CSV文件的內容
    while (($row = fgetcsv($file)) !== false) {
        $count_row++;
        $csvData[] = $row;
    }

    // 關閉文件
    fclose($file);

    if($count_row == 1){
        echo '<script>';
        echo 'alert("USE DROP TABLE INSTEAD");';
        echo 'window.location.href = "./struct.php?db='.$db.'&tb='.$tb.'"';
        echo '</script>';  
    }else{

    // 找到要刪除的行並刪除
    foreach ($csvData as $key => $row) {
      if ($key == $rowToDelete) {
          unset($csvData[$key]);
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

    /////////////////////////////////////////////////////////////////////////////////////

    $csvFile = __DIR__ ."/db"."/".$db."/".$tb."/data.csv";
    $rows = [];
    if (($handle = fopen($csvFile, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
    }
    $columnToDelete = $_GET['dlrow'];
    foreach ($rows as &$row) {
        if (isset($row[$columnToDelete])) {
            unset($row[$columnToDelete]);
        }
    }
    if (($handle = fopen($csvFile, 'w')) !== false) {
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

    echo '<script>';
    echo 'alert("column已成功刪除。");';
    echo 'window.location.href = "./struct.php?db='.$db.'&tb='.$tb.'"';
    echo '</script>'; 
    }  
}



?>