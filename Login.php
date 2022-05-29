<?php
    include 'PHP/dbconfig.php';
    $error = array();
    if(!empty($_POST['user']) && !empty($_POST['pass'])){

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die ("error: " .mysqli_connect_error());
        $username = mysqli_real_escape_string($conn, $_POST["user"]);
        $query = "SELECT Username, Pass, Id FROM Users WHERE Username = '$username'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)==0){
            $error[] = "Username inesistente";
        }else{
            $password = mysqli_real_escape_string($conn, $_POST['pass']);
            $row = mysqli_fetch_assoc($res);
            if(!password_verify($password, $row['Pass'])){
                $error[] = "Password sbagliata";
            }
        }
        

        if(empty($error)){
            session_start();    
            $_SESSION['User'] = $username;
            $_SESSION['Id'] = $row['Id'];

            header("Location: home.php");
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="CSS/login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="SCRIPTS/login.js" defer="true"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Roboto:wght@300&display=swap" rel="stylesheet">
    </head>
    <body>
        <main>
          <div>
                <h1>GAME2GO</h1></br>
                <span>Login</span>

                <form name="Form" method="POST">
                Username </br> <input type='text' name='user' class='textinput'> <span id='username-error'></span>
                Password </br> <input type='password' name='pass' class='textinput'>  <span id='password-error'></span>
                <span class='posterror'> <?php foreach($error as $err) echo($err) ?> </span>
                <input type='submit' id='submit' value='LOGIN'>
                </form>

                <a id='signup' href='signup.php'>Non hai ancora un Account? Registrati adesso!</a>
            </div>
        </main>
    </body>
</html>