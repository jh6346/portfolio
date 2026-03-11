<?php
    session_start();

    include 'db.php';

    $user_id = $_SESSION['user_id'];
    $board_id = $_POST['board_id'];
    $content = $_POST['content'];

    // $sql = "insert into guestbook_comment values(null, '$user_id', $board_id, null, '$content');";
    $sql = "insert into guestbook_comment(id, board_id, content) values('$user_id', $board_id, '$content');";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>