<?php
include 'dbconfig.php';
    $key = '?key=ab7a5b9fbdc04a96823d553be23f4a29';
    $url = 'https://api.rawg.io/api/games/';
    session_start();
    $posts = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
    $User = $_SESSION['Id'];
    if(isset($_GET['CurrentUser'])){
        $query = "SELECT Posts.*, Users.Username, EXISTS(SELECT * FROM Likes WHERE PostId = POSTS.Id AND UserId = $User) AS Liked FROM POSTS JOIN USERS on Posts.Poster = Users.Id WHERE Posts.Poster = $User";
    }else{
        $query = "SELECT Posts.*, Users.Username, EXISTS(SELECT * FROM Likes WHERE PostId = POSTS.Id AND UserId = $User) AS Liked FROM POSTS JOIN USERS on Posts.Poster = Users.Id";
    }
    $res = mysqli_query($conn, $query);
    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
        $posts[$i] = mysqli_fetch_assoc($res);
        $game = $posts[$i]['Game'];
        $geturl = $url . $game . $key;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $geturl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result,true);
        array_push($posts[$i], $result['name']);
        array_push($posts[$i], $result['background_image']); 
    }
    
    echo json_encode($posts);
    mysqli_free_result($res);
    mysqli_close($conn);
?>