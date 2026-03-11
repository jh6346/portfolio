<?php
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sex = $_POST['sex'];
    $job = $_POST['job'];
    $age = $_POST['age'];

    include 'db.php';

    $sql = "update employee set name='$name', address='$address', sex='$sex', job='$job', age='$age' where id=$id";

    if (mysqli_query($conn, $sql)) {
        echo 'O';
    } else {
        echo mysqli_error($conn);
    }
?>