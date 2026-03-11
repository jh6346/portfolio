<?php
    $filename = $_GET['file'];
    $filepath = './uploads/download/' . $filename;

    $start = strpos($filename, '_') + 1;
    $download_filename = substr($filename, $start);

    if (!is_file($filepath) || !file_exists($filepath)) {
        echo '파일이 존재하지 않습니다.';
        exit;
    }

    $filesize = filesize($filepath);

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $download_filename . "");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $filesize);
    header("Pragma: no-cache");
    header("Expires: 0");

    $fp = fopen($filepath, "r");
    fpassthru($fp);
    fclose($fp);

    echo $filesize;
?>