<?php
include 'dbconfig.php';
    session_start();
    if(!isset($_SESSION['User'])){
        header('Location: login.php');
    }
    if(isset($_GET['Post'])){
        $id = $_GET['Post'];
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
        $query = "DELETE FROM POSTS WHERE Id = $id";
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }
?>