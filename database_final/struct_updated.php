<?php
$db = $_GET['db'];
$tb = $_GET['tb'];

if (isset($_GET['udrow'])) {
    $rowToUd = $_GET['udrow'];
    $updatenum = $_GET['updatenum'];

    $csvFilePath = __DIR__ ."/db"."/".$db."/".$tb."/col.csv";
    $file = fopen($csvFilePath, 'r');
    $csvData = [];
    while (($row = fgetcsv($file)) !== false) {
        $csvData[] = $row;
    }
    fclose($file);

    $check = 1;
    foreach($csvData as $row){
        if($row[0] == $updatenum){
            $check = 0;
        }
    }

    if($check){

    $csvData[$rowToUd][0] = $updatenum;
    
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


    echo '<script>';
    echo 'alert("column已成功修改。");';
    echo 'window.location.href = "./struct.php?db='.$db.'&tb='.$tb.'"';
    echo '</script>'; 
    }else{
        echo '<script>';
        echo 'alert("ERROR，出現重複值。");';
        echo 'window.location.href = "./struct.php?db='.$db.'&tb='.$tb.'"';
        echo '</script>'; 
    }
}



?>