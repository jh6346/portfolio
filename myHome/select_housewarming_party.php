<?php
    include 'dbconn.php';

    // $sql = "select * from housewarming_party order by regdate desc limit 3";
    $sql = "select H.*, U.idx, U.id, U.name from housewarming_party H LEFT JOIN user U ON H.user_idx=U.idx order by regdate desc limit 3";
    $result = mysqli_query($conn, $sql);
    $array = array();

    while($row = mysqli_fetch_array($result)) {
        $sql = "select floor(avg(cnt)) as star from star where board_id=$row[0]";
        $rs = mysqli_query($conn, $sql);
        $star = mysqli_fetch_array($rs);

        array_push($array, array(
            'board_id' => $row['board_id'],
            'before_img' => $row['before_img'],
            'after_img' => $row['after_img'],
            'user_idx' => $row['idx'],
            'user_id' => $row['id'],
            'user_name' => $row['name'],
            'regdate' => $row['regdate'],
            'content' => $row['content'],
            'star' => ($star['star'] == '') ? 0 : $star['star']
        ));
    }

    echo json_encode($array);
?>