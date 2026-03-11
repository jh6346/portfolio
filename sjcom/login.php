<?php
    include 'dbconn.php';
    session_start();

    $user_id = $_POST['id'];
    $user_pw = $_POST['pw'];

    $sql = "select no, name, id, pw, tel, email, regdate, inet_ntoa(ip) ip from sjcom_member where id='$user_id' and pw='$user_pw'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) <= 0) {
        echo json_encode('X');
        exit;
    }

    $array = array();

    if ($row = mysqli_fetch_array($result)) {
        array_push($array, array(
            'no' => $row['no'],
            'name' => $row['name'],
            'id' => $row['id'],
            'pw' => $row['pw'],
            'tel' => $row['tel'],
            'email' => $row['email'],
            'regdate' => $row['regdate'],
            'ip' => $row['ip']
        ));
    }

    $_SESSION['user_info'] = $row;
    echo json_encode($array);
?>