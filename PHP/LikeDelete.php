<?php
    include 'dbconfig.php';
    session_start();
    if(!isset($_SESSION['User'])){
        header('Location: /Login.php');
    }
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
    $user = $_SESSION['Id'];
    $post = $_GET['Post'];

    $query = "DELETE FROM LIKES WHERE UserId = $user AND PostId = $post";
    mysqli_query($conn, $query);
    mysqli_close($conn);    
?>