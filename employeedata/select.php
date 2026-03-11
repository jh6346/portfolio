<?php
    include 'db.php';

    $sql = "select * from employee";
    $result = mysqli_query($conn, $sql);
    $array = array();

    while ($row = mysqli_fetch_array($result)) {
        array_push($array, array(
            'id' => $row['id'],
            'name' => $row['name'],
            'address' => $row['address'],
            'sex' => $row['sex'],
            'job' => $row['job'],
            'age' => $row['age']
        ));
    }

    echo json_encode($array);
    mysqli_close($conn);
?>