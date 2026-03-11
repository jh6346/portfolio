<?php
    include 'dbconn.php';
    session_start();
    $num = $_POST['num'];

    $sql = "select * from board where num=$num";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    function unlinkfile($file) {
        if ($file) {
            unlink('./uploads/board/' . $file);
        }
    }

    unlinkfile($row['uniqfilename_0']);
    unlinkfile($row['uniqfilename_1']);
    unlinkfile($row['uniqfilename_2']);

    $sql = "delete from board where num=$num";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
        exit;
    }
?>