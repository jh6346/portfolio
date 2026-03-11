<?php
    include 'dbconn.php';
    session_start();

    $no = $_POST['no'];

    $sql = "delete from sjcom_memo where no=$no";
    if (mysqli_query($conn, $sql)) {
        echo '방명록이 삭제되었습니다.';
    } else {
        echo mysqli_error($conn);
    }
?>