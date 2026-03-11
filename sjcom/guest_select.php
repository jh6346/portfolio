<?php
    include 'dbconn.php';
    session_start();

    $sql = "select * from sjcom_memo";
    $result = mysqli_query($conn, $sql);
    $array = array();

    while($row = mysqli_fetch_array($result)) {
        array_push($array, array(
            'no' => $row['no'],
            'id' => $row['id'],
            'name' => $row['name'],
            'content' => $row['content'],
            'regdate' => $row['regdate']
        ));
    }

    echo json_encode($array);
?>