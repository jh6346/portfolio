<?php
    include 'lib.php';
    
    $spl_idx = $_POST['spl_idx'];
    $rq_id = $_POST['rq_id'];

    $sql = "update rq_estimate set sel_spl_idx='$spl_idx' where rq_id=$rq_id";
    if (mysqli_query($conn, $sql))
        echo 'o';
    else
        echo mysqli_error($conn);
?>