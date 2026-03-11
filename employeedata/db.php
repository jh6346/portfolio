<?php
    $host = 'localhost';
    $user = 'ojh';
    $pw = 'o04118977!';
    $db = 'ojh';

    $conn = mysqli_connect($host, $user, $pw, $db);

    if (!$conn) {
        echo mysqli_connect_error($conn);
    }
?>