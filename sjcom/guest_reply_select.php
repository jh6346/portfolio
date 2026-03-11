<?php
    include 'dbconn.php';

    $parent_no = $_POST['no'];

    $sql = "select * from sjcom_memo_reply where parent=$parent_no";
    $result = mysqli_query($conn, $sql);
    $array = array();

    while($row = mysqli_fetch_array($result)) {
        array_push($array, array(
            'no' => $row['no'],
            'parent' => $row['parent'],
            'id' => $row['id'],
            'name' => $row['name'],
            'content' => $row['content'],
            'regdate' => $row['regdate'],
        ));
    }

    echo json_encode($array);
?>