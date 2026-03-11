<?php
    include 'lib.php';

    $board_id = $_POST['board_id'];
    $user_idx = $_SESSION['user_idx'];
    $star = $_POST['star'];

    $sql = "select * from star where board_id='$board_id' and user_idx='$user_idx'";
    $rs = mysqli_query($conn, $sql);

    if ($rs != null) {
        if (mysqli_num_rows($rs) > 0) {
            echo 'x';
            exit;
        }
    }

    $sql = "insert into star values('$board_id', '$user_idx', '$star')";

    if (mysqli_query($conn, $sql))
        echo 'o';
    else
        echo mysqli_error($conn);
?>