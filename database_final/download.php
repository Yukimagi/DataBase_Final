<?php
if (isset($_POST['db']) && isset($_POST['table'])) {
    $selectedDb = $_POST['db'];
    $selectedTable = $_POST['table'];
    $zipFileName = $selectedTable . '.zip';

    $tablePath = 'db/' . $selectedDb . '/' . $selectedTable;
    $zip = new ZipArchive();
    
    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($tablePath),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($files as $file) {
            if ($file->isFile()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($tablePath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        $zip->close();
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename=$zipFileName");
        readfile($zipFileName);
        unlink($zipFileName); // 刪除臨時檔案
    } else {
        echo "無法建立壓縮檔案。";
    }
} else {
    echo "選擇的資料庫和資料表無效。";
}
?>





