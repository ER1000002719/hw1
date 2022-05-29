<?php
include 'PHP/dbconfig.php';
    session_start();

    if(!isset($_SESSION['Id'])){
        header('Location: Login.php');
    }
    $id = $_SESSION['Id'];
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name'])  or die ("error: " .mysqli_connect_error());
    $query = "SELECT COUNT(*) AS numPosts FROM POSTS WHERE Posts.Poster = '$id'";
    $result = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($result);

    $numPosts = $res['numPosts'];

    $query = "SELECT COUNT(*) AS numLikes FROM LIKES WHERE Likes.UserId = '$id'";
    $result = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($result);

    $numLikes = $res['numLikes'];

    $query = "SELECT COUNT(*) AS numComments FROM COMMENTS WHERE Comments.UserId = '$id'";
    $result = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($result);

    $numComments = $res['numComments'];

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>GAME2GOHOME</title>
        <link rel="stylesheet" href="CSS/Profile.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="SCRIPTS/Profile.js" defer="true"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="navbar">
            <h1>GAME2GO</h1>
            <div class='links'>
                <a href="Home.php">home</a>
                <a href="createPost.php">Nuovo Post</a>
                <a href="PHP/Logout.php">logout</a>
            </div>
        </div>
        <main>
            <div id='profilebox'>
                <h1><?php echo($_SESSION['User'])?></h1>
                <div><h1>POST</h1><span><?php echo($numPosts)?></span></div>
                <div><h1>LIKE</h1><span><?php echo($numLikes)?></span></div>
                <div><h1>COMMENTI</h1><span><?php echo($numComments)?></span></div>
            </div>

            <div id='postsbox'>
            </div>
        </main>
</html>