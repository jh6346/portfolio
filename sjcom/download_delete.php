<?php
    include 'dbconn.php';
    session_start();
    $num = $_POST['num'];

    $sql = "select uniqfilename_0, uniqfilename_1, uniqfilename_2 from download where num=$num";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    function filedelete($file) {
        if ($file) {
            unlink('./uploads/download/' . $file);
        }
    }

    filedelete($row['uniqfilename_0']);
    filedelete($row['uniqfilename_1']);
    filedelete($row['uniqfilename_2']);

    $sql = "delete from sjcom_download where num=$num";
    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>