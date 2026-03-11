<?php
    session_start();
    include 'dbconn.php';
    include 'file_upload.php';

    $upload_dir = './img/housewarming_party';

    // if (!isset($_FILES['before']) && !isset($_FILES['after'])) {
    //     die('업로드할 파일이 없습니다.');
    // }

    //파일
    $before = $_FILES['before'];
    $after = $_FILES['after'];

    $u_before_name = uniqid() . '_' . $before['name']; //유니크 ID + 파일 이름
    $u_after_name = uniqid() . '_' . $after['name'];

    //저장될 디렉터리 및 파일명
    $upload_before = $upload_dir . '/' . $u_before_name;
    $upload_after = $upload_dir . '/' . $u_after_name;

    //파일 업로드
    if (!(file_upload($before, $upload_before) && file_upload($after, $upload_after))) {
        //파일 업로드 X
    }
    


    //db insert
    $subject = $_POST['subject'];
    $content = $_POST['know-how'];
    $user_idx = isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : '';

    $sql = "insert into housewarming_party(before_img, after_img, user_idx, content, subject) values('$u_before_name', '$u_after_name', '$user_idx', '$content', '$subject')";

    if(mysqli_query($conn, $sql)) {
        echo 'o';
    } else {
        echo 'x';
    }

?>