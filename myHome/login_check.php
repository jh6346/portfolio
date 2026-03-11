<?php
    session_start();
    include 'dbconn.php';

    $id = $_POST['id'];
    $pw = $_POST['pw'];

    $sql = "select * from user where id='$id' and pw='$pw'";
    $rs = mysqli_query($conn, $sql);

    if (mysqli_num_rows($rs) < 1) {
        echo '아이디 또는 비밀번호가 일치하지 않습니다.';
        exit;
    } else {
        while($row = mysqli_fetch_array($rs)) {
            $_SESSION['user_idx'] = $row['idx'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_img'] = $row['img'];
            $_SESSION['is_admin'] = $row['a'];
        }

        echo 'o';
    }

?>