<?php
    include 'db.php';

    $comment_id = $_POST['comment_id'];

    $sql = "delete from guestbook_comment where comment_id=$comment_id";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>