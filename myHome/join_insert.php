<?php
    include 'dbconn.php';

    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $name = $_POST['name'];
    // $img = $_POST['img'];

    $sql = "select * from user where id='$id'";
    $rs = mysqli_query($conn, $sql);

    if (mysqli_num_rows($rs) > 0) {
        echo '중복되는 아이디입니다. 다른 아이디를 사용해주세요.';
        exit;
    }

    $sql = "insert into user(id, pw, name, img, a) values('$id', '$pw', '$name', 'img', 0)";
    
    if (mysqli_query($conn, $sql)) {
        echo 'o';
    } else {
        echo '회원 가입 실패';
    }
?>