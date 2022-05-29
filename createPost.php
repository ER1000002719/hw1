<?php
    include 'PHP/dbconfig.php';
    session_start();

    if(!isset($_SESSION['User'])){
        header('Location: login.php');
    }

    if(!empty($_POST['Game']) && !empty($_POST['Title']) && !empty($_POST['Content'])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
        $game = mysqli_real_escape_string($conn, $_POST['Game']);
        $title = mysqli_real_escape_string($conn, $_POST['Title']);
        $content = mysqli_real_escape_string($conn, $_POST['Content']);
        $grade = $_POST['Grade'];
        $poster = $_SESSION['Id'];
        $query = "INSERT INTO POSTS(Title, Game, Content, Poster, Grade) VALUES('$title', '$game', '$content', $poster, $grade)";
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>GAME2GOHOME</title>
        <link rel="stylesheet" href="CSS/createPost.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="SCRIPTS/createPost.js" defer="true"></script>
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
                <a href="Profile.php"><?php echo($_SESSION['User'])?></a>
                <a href="PHP/Logout.php">logout</a>
            </div>
        </div>
        <main>
            <div id="searchbox">
                <h1>Cerca un gioco da recensire</h1>
                <textarea></textarea>
                <button>CERCA</button>
            </div>

            <div id="searchresult">
            </div>

            <form name="Form" method="POST" class='hidden'>
                <input type='text' name='Game' class='hidden'>
                Titolo Recensione<input type='text' name='Title' class='textinput'> <span id='title-error'></span>
                Voto <select name='Grade' class='textinput'>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                     </select> 
                <textarea id='content' name='Content'>Scrivi qui la tua recensione</textarea> <span id='content-error'></span>
                <input type='submit' id='submit' value='Invia Post'>
            </form>
        </main>
    </body>
</html>