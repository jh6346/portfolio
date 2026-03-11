<?php
    include 'db.php';

    $board_id = $_POST['board_id'];
    $content = $_POST['content'];
    $sql = "update guestbook_board set content='$content' where board_id=$board_id;";

    if (mysqli_query($conn, $sql)){
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>