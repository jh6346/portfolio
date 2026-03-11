<?php
    include 'db.php';
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sex = $_POST['sex'];
    $job = $_POST['job'];
    $age = $_POST['age'];

    $sql = "insert into employee values(null, '$name', '$address', '$sex', '$job', $age)";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo 'X';
    }

    mysqli_close($conn);
?>