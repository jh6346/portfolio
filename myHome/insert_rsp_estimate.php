<?php
    include 'lib.php';
    $user_idx = isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : null;

    $cost = $_POST['cost'];
    $rq_id = $_POST['rq_id'];
    $sql = "insert into rsp_estimate(rq_id, spl_idx, cost) values($rq_id, $user_idx, $cost)";

    if (mysqli_query($conn, $sql))
        echo 'o';
    else
        echo mysqli_error($conn);
?>