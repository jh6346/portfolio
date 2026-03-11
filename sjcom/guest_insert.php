<?php
    include 'dbconn.php';
    session_start();

    $user_id = $_SESSION['user_info']['id'];
    $user_name = $_SESSION['user_info']['name'];
    $content = $_POST['content'];
    
    $sql = "insert into sjcom_memo(id, name, content) values('$user_id', '$user_name', '$content')";
    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>