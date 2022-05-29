<?php
    include 'dbconfig.php';

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $mail = mysqli_real_escape_string($conn, $_GET['check']);

    $query = "SELECT * FROM Users WHERE Email = '$mail'";
    $res = mysqli_query($conn, $query);

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
    mysqli_free_result($res);
    mysqli_close($conn);
?>