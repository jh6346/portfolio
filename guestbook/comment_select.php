<?php
    include 'db.php';

    $board_id = $_POST['board_id'];

    $sql = "SELECT c.id, c.board_id, c.ts, c.content, u.name, c.comment_id FROM guestbook_comment c JOIN guestbook_user u ON c.id = u.id WHERE board_id = $board_id";
    $result = mysqli_query($conn, $sql);

    if ($result == null) {
        echo 'null';
        exit;
    }

    $array = array();

    while($row = mysqli_fetch_array($result)) {
        array_push($array, array(
            'id' => $row[0],
            'board_id' => $row[1],
            'ts' => $row[2],
            'content' => $row[3],
            'name' => $row[4],
            'comment_id' => $row[5]
        ));
    }

    echo json_encode($array);
?>