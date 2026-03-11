<?php
    include 'dbconn.php';
    session_start();

    $parent_no = $_POST['parent_no'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_info']['id'];
    $user_name = $_SESSION['user_info']['name'];
    $sql = "insert into sjcom_memo_reply(parent, id, name, content) values($parent_no, '$user_id', '$user_name', '$content')";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>