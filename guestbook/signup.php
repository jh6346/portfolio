<?php
    include 'db.php';

    $id = $_POST['id'];
    $name = $_POST['name'];
    $pw = $_POST['pw'];

    $sql = "select * from guestbook_user where id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result != null) {
        if (mysqli_num_rows($result) > 0) {
            echo 'ID 중복';
            exit;
        }
    }

    $sql = "insert into guestbook_user values('$id', '$name', '$pw')";

    if (mysqli_query($conn, $sql)) {
        echo '가입 성공';
    } else {
        echo '가입 실패';
        echo mysqli_error($conn);
    }
?>