<?php
    function file_upload($file, $upload_file) {
        if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
            //파일 업로드 X
            return 0;
        } else {
            //파일 업로드 O
            return 1;
        }
    }
?>