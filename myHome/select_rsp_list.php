<?php
    include 'lib.php';

    $idx = isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : null;
    // $sql = "SELECT * FROM rsp_estimate RSP LEFT JOIN rq_estimate RQ ON RSP.rq_id=RQ.rq_id WHERE spl_idx=$idx";
    $sql = "SELECT *, (SELECT U.id FROM user U WHERE RQ.user_idx=U.idx) user_id, (SELECT U.name FROM user U WHERE RQ.user_idx=U.idx) user_name FROM rsp_estimate RSP LEFT JOIN rq_estimate RQ ON RSP.rq_id=RQ.rq_id WHERE spl_idx=$idx";
    $rs = mysqli_query($conn, $sql);
    $arr = array();

    while($row = mysqli_fetch_array($rs)) {
        // $sel_user_idx = $row['user_idx'];
        // $sel_user = "SELECT * FROM user WHERE idx=$sel_user_idx";

        array_push($arr, array(
            'rsp_id' => $row['rsp_id'],
            'rq_id' => $row['rq_id'],
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'date' => $row['date'],
            'content' => $row['content'],
            'cost' => $row['cost'],
            'sel_spl_idx' => $row['sel_spl_idx']
        ));
    }

    echo json_encode($arr);
?>