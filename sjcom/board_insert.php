<?php
    include 'dbconn.php';
    session_start();
    
    $user_id = $_SESSION['user_info']['id'];
    $user_name = $_SESSION['user_info']['name'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    $file_array = array();

    function fileupload($file) {
        if ($file['name']) {
            $filename = $file['name'];
            $uniqfilename = uniqid() . '_' . $filename;
            $upload_file = './uploads/board/' . $uniqfilename;
            $array = array();

            if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                echo $file['error'];
                echo '파일이 업로드 되지 않았습니다.';
                exit;
            }

            return array(
                'name' => $filename,
                'uniqfilename' => $uniqfilename
            );
        }
        
        return array('name' => null, 'uniqfilename' => null);
    }

    array_push($file_array, fileupload($_FILES['file1']), fileupload($_FILES['file2']), fileupload($_FILES['file3']));
    

    $sql = "insert into board(id, name, subject, content, hit, filename_0, filename_1, filename_2, uniqfilename_0, uniqfilename_1, uniqfilename_2) values('$user_id', '$user_name', '$subject', '$content', 0, '" . $file_array[0]['name'] . "', '" . $file_array[1]['name'] . "', '" . $file_array[2]['name'] . "', '" . $file_array[0]['uniqfilename'] . "', '" . $file_array[1]['uniqfilename'] . "', '" . $file_array[2]['uniqfilename'] . "')";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
    
?>


