<?php
include 'dbconfig.php';
    $Post = $_GET['Post'];
    $comments = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
    $query = "SELECT Comments.*,Users.Username FROM COMMENTS JOIN USERS ON COMMENTS.UserId = USERS.Id WHERE Comments.PostId = $Post";

    $res = mysqli_query($conn, $query);
    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
        $comments[$i] = mysqli_fetch_assoc($res);
    }
    echo json_encode($comments);
    mysqli_free_result($res);
    mysqli_close($conn);    
?>