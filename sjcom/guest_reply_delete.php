<?php
    include 'dbconn.php';
    
    $no = $_POST['no'];
    $sql = "delete from sjcom_memo_reply where no=$no";

    if (mysqli_query($conn, $sql)) {
        echo '댓글이 삭제되었습니다.';
    } else {
        echo mysqli_error($conn);
    }
?>