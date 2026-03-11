<?php
    include 'db.php';

    $sql = "select b.board_id, u.name name, u.id id, b.content, b.ts from guestbook_board b inner join guestbook_user u on b.id = u.id;";
    $result = mysqli_query($conn, $sql);

    if ($result == null) {
        echo 'null';
        exit;
    }

    $array = array();

    while ($row = mysqli_fetch_array($result)) {
        array_push($array, array(
            'board_id' => $row[0],
            'name' => $row[1],
            'id' => $row[2],
            'content' => $row[3],
            'ts' => $row[4]
        ));
    }

    echo json_encode($array);
?>