<?php
    include 'dbconfig.php';
    
        if(!empty($_GET['Post']) && !empty($_GET['Content'])){
            session_start();
            $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
            $post = $_GET['Post'];
            $content = $_GET['Content'];
            $user = $_SESSION['Id'];

            $query = "INSERT INTO COMMENTS(PostId, UserId, Content) VALUES($post, $user, '$content')" ;
            $res = mysqli_query($conn, $query);
            mysqli_close($conn);
            exit;
        }
?>