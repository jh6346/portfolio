<?php
    include 'dbconn.php';
    session_start();
    
    $user_id = $_SESSION['user_info']['id'];
    $user_name = $_SESSION['user_info']['name'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    $file_array = array();

    function filedownload($file) {
        if ($file['name']) {
            $filename = $file['name'];
            $uniqfilename = uniqid() . '_' . $filename;
            $upload_file = './uploads/download/' . $uniqfilename;
            $upload_file_type = $file['type'];
            
            $array = array(
                'name' => $filename,
                'uniqfilename' => $uniqfilename,
                'type' => $upload_file_type
            );
            
            if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                echo $file['error'];
                echo '파일이 업로드 되지 않았습니다.';
                exit;
            }

            return $array;
        }

        return array(
            'name' => null,
            'uniqfilename' => null,
            'type' => null
        );
    }

    array_push($file_array, filedownload($_FILES['file1']), filedownload($_FILES['file2']), filedownload($_FILES['file3']));

    $sql = "insert into sjcom_download(id, name, subject, content, filename_0, filename_1, filename_2, filetype_0, filetype_1, filetype_2, uniqfilename_0, uniqfilename_1, uniqfilename_2) values('$user_id', '$user_name', '$subject', '$content', '" . $file_array[0]['name'] . "', '" . $file_array[1]['name'] . "', '" . $file_array[2]['name'] . "', '" . $file_array[0]['type'] . "', '" . $file_array[1]['type'] . "', '" . $file_array[2]['type'] . "', '" . $file_array[0]['uniqfilename'] . "', '" . $file_array[1]['uniqfilename'] . "', '" . $file_array[2]['uniqfilename'] . "')";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
    
?>