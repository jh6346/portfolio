<?php
    include 'lib.php';

    $content = $_POST['content'];
    $star = $_POST['star'];
    $spl_idx = $_POST['spl_idx'];
    $cost = $_POST['cost'];
    $user_idx = isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : '';
    // $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';

    $sql = "insert into specialist_review(spl_idx, user_idx, cost, content, star) values('$spl_idx', '$user_idx', $cost, '$content', $star)";
    if (mysqli_query($conn, $sql))
        echo 'o';
    else
        echo 'x';
?>