<?php
    include 'lib.php';
    $board_id = $_POST['id'];
    $user_idx = isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : '';

    //평점 내림하여 평균 불러오기
    $sql = "select floor(avg(cnt)) as star from star where board_id=$board_id";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    $star = ($row && $row['star'] !== null) ? $row['star'] : '';
    
    //평점 작성 여부
    $sql = "select cnt from star where board_id=$board_id and user_idx='$user_idx'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    $star_c = ($row) ? $row['cnt'] : '';
    

    //게시물 불러오기
    $sql = "select H.*, U.idx, U.id, U.name from housewarming_party H LEFT JOIN user U ON H.user_idx=U.idx where board_id=$board_id";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);

    $arr = array(
        'board_id' => $row['board_id'], 
        'before_img' => $row['before_img'],
        'after_img' => $row['after_img'],
        'user_id' => $row['id'],
        'user_name' => $row['name'],
        'regdate' => $row['regdate'],
        'content' => $row['content'],
        'subject' => $row['subject'],
        'star' => $star,
        'star_c' => $star_c
    );

    echo json_encode($arr);
?>