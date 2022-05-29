<?php
    include 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
    if(!isset($_SESSION['User'])){
        header('Location: /Login.php');
    }
    $user = $_SESSION['Id'];
    $post = $_GET['Post'];

    $query = "INSERT INTO LIKES (UserId, PostId) VALUES($user, $post)";
    mysqli_query($conn, $query);
    mysqli_close($conn);
?>