<?php
    $id = $_POST['id'];

    include 'db.php';

    $sql = "select * from employee where id=$id";
    $result = mysqli_query($conn, $sql);
    
    $row = mysqli_fetch_array($result);

    echo json_encode(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'address' => $row['address'],
        'sex' => $row['sex'],
        'job' => $row['job'],
        'age' => $row['age']
    ));
    
?>