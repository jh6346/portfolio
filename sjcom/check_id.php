<?php
    include 'dbconn.php';

    $id = $_POST['id'];
    
    if ($id) {
        $sql = "select * from sjcom_member where id='$id'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) echo '사용 중인 아이디';
        else echo '사용 가능한 아이디';
    } else {
        echo '아이디를 입력해주세요.';
    }
?>