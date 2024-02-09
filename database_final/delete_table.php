<?php
// delete_table.php
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 接收從客戶端發送的資料
    $db = $_POST['db'];
    $table = $_POST['table'];

    // 在這裡執行刪除資料表的操作
    // 這只是一個簡單的範例，實際上你需要根據你的需求來處理資料表的刪除操作

    // 示意：刪除資料夾
    $folder_path = "db/" . $db . "/" . $table;
    deleteDirectory($folder_path);
    echo "成功刪除資料表 " . $table;
    
} else {
    echo "無效的請求";
}
?>


