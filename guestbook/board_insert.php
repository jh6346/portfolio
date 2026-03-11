<?php
    include 'db.php';
    session_start();

    $id = $_SESSION['user_id'];
    $pw = $_POST['pw'];
    $content = $_POST['text'];

    // $sql = "insert into guestbook_board values(null, '$id', '$pw', '$content', null)";
    $sql = "insert into guestbook_board(id, board_pw, content) values('$id', '$pw', '$content')";
    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>