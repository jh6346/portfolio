<?php
    include "lib.php";

    $user_idx = $_SESSION['user_idx'];

    $date = $_POST['date'];

    $content = $_POST['content'];

    // $sel_spl_idx; //선택된 전문가 아이디

    $sql = "insert into rq_estimate(user_idx, date, content) values($user_idx, '$date', '$content')";
    if (mysqli_query($conn, $sql))
        echo 'o';
    else
        echo mysqli_error($conn);
?>