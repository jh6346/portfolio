<?php
    include 'db.php';

    $id = $_POST['id'];
    $pw = $_POST['pw'];

    $sql = "select * from guestbook_user where id='$id'";
    $result = mysqli_query($conn, $sql);
    
    if ($result == null) {
        echo 'null';
        exit;
    }

    if (mysqli_num_rows($result) < 1) {
        echo 'ID ERROR';
        exit;
    }

    $sql = "select * from guestbook_user where id='$id' and pw='$pw'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) < 1) {
        echo 'PW ERROR';
        exit;
    }

    $row = mysqli_fetch_array($result);

    session_start();

    // echo $row['id'];
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_pw'] = $row['pw'];
    echo '로그인 성공';
?>