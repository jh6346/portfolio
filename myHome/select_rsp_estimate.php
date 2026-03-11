<?php
    include 'lib.php';

    $rq_id = $_POST['rq_id'];
    $sql = "select R.*, U.id, U.name, U.img from rsp_estimate R LEFT JOIN user U ON R.spl_idx=U.idx where rq_id=$rq_id"; //받은 견적 가져오기. 견적 보낸 전문가 정보 받아오기.
    $rs = mysqli_query($conn, $sql);

    if (mysqli_num_rows($rs) < 1) {
        echo json_encode('');
        exit;
    }
    
    $arr = array();

    $sql_sel_spl = "select sel_spl_idx from rq_estimate where rq_id=$rq_id"; //요청한 견적에 선택된 전문가 있는지 확인하기 위해
    $rs_sel_spl = mysqli_query($conn, $sql_sel_spl);
    $row_sel_spl = mysqli_fetch_array($rs_sel_spl);

    while($row = mysqli_fetch_array($rs)) {
        array_push($arr, array(
            'rsp_id' => $row['rsp_id'],
            'rq_id' => $row['rq_id'],
            'spl_idx' => $row['spl_idx'],
            'spl_id' => $row['id'],
            'spl_name' => $row['name'],
            'spl_img' => $row['img'],
            'cost' => $row['cost'],
            'sel_spl_idx' => $row_sel_spl['sel_spl_idx']
        ));
    }

    echo json_encode($arr);
?>