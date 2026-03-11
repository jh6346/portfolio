<?php
    include 'dbconn.php';

    $deletes = isset($_POST['delete']) ? $_POST['delete'] : [];
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $num = $_POST['num'];

    $sql = "select * from sjcom_download where num=$num";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    foreach($deletes as $delete) {
        $filename = $row['uniq' . $delete];
        unlink('./uploads/download/' . $filename);
    }

    $sql = "update sjcom_download set subject='$subject', content='$content'";

    foreach($deletes as $delete) {
        $sql = $sql . ", $delete=null, uniq$delete=null, filetype_" . substr($delete, -1) . "=null";
    }

    for($i = 1; $i <= 3; $i++) {
        $file = isset($_FILES["file$i"]) ? $_FILES["file$i"] : null;

        if (!empty($file['name'])) {
            $filename = $file['name'];
            $uniqfilename = uniqid() . '_' . $filename;
            $upload_file = './uploads/download/' . $uniqfilename;

            if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                echo $file['error'];
                echo '파일이 업로드 되지 않았습니다.';
                exit;
            }

            $sql = $sql . ", filename_" . ($i-1) . "='$filename', uniqfilename_" . ($i-1) . "='$uniqfilename', filetype_" . ($i-1) . "='" . $file['type'] . "'";
        }
    }

    $sql = $sql . " where num=$num";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>