<?php
    include 'dbconn.php';

    $user_name = $_POST['name'];
    $user_id = $_POST['id'];
    $user_pw = $_POST['pw'];
    $user_tel = $_POST['tel'];
    $user_email = $_POST['email'];
    $user_ip = $_SERVER['REMOTE_ADDR'];

    $sql = "select * from sjcom_member where id='$user_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo 'X';
        exit;
    }

    $sql = "insert into sjcom_member(name, id, pw, tel, email, ip) values('$user_name', '$user_id', '$user_pw', '$user_tel', '$user_email', INET_ATON('$user_ip'))";
    //INET_NTOA() 정수를 ip주소
    //select INET_NTOA(ip) from member;

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>