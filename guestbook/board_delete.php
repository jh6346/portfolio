<?php
    session_start();

    include 'db.php';

    $board_pw = $_POST['board_pw'];
    $board_id = $_POST['board_id'];
    $type = $_POST['type'];

    $sql = "select * from guestbook_board where board_id=$board_id and board_pw='$board_pw';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) < 1) {
        echo 'PW ERROR';
        exit;
    }

    if ($type == 'delete') {
        $sql = "delete from guestbook_board where board_id = $board_id;";
        if (mysqli_query($conn, $sql)) {
            echo 'O';
        } else {
            echo mysqli_error($conn);
        }
    } else if ($type == 'modify') {
        echo 'O';
    }
    
?>