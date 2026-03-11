<?php
    include 'dbconn.php';

    // insert into housewarming_party values(1, '1_before.jpg', '1_after.jpg', 'user1', null, null, null);
    // for ($i = 1; $i <= 4; $i++) {
    //     $sql = "insert into user values(null, 'specialist$i', '1234', '전문가$i', 'specialist$i.jpg', 1)";
    //     mysqli_query($conn, $sql);
    // }
    // for ($i = 1; $i <= 4; $i++) {
    //     $sql = "insert into specialist values('specialist$i', '전문가$i', 'specialist$i.jpg')";
    //     mysqli_query($conn, $sql);
    // }

    $sql = "select * from user where a=1";
    $result = mysqli_query($conn, $sql);
    $arr = array();

    while($row = mysqli_fetch_array($result)) {
        array_push($arr, array(
            'id' => $row['id'],
            'name' => $row['name'],
            'img' => $row['img']
        ));
    }

    echo json_encode($arr);
?>