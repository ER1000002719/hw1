<?php
    include 'PHP/dbconfig.php';

    if(!empty($_POST["Nome"]) && !empty($_POST["Cognome"]) && !empty($_POST["user"]) && !empty($_POST["mail"]) && !empty($_POST["pass"]) && !empty($_POST["pass-confirm"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name'])  or die ("error: " .mysqli_connect_error());
 
        if(!preg_match('/^[a-z A-Z]+$/', $_POST["Nome"])){
            $error[] = "Nome non valido";
        }
        if(!preg_match('/^[a-z A-Z]+$/', $_POST["Cognome"])){
            $error[] = "cognome non valido";
        }
        if(!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $_POST["pass"])){
            $error[] = "password non valida";
        }
        if($_POST["pass"] != $_POST["pass-confirm"]){
            $error[] = "pass non confermata";
        }
        if(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
            $error[] = "Mail non valida";
        }
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $_POST["user"])){
            $error[] = "user non valido";
        }
        $username = mysqli_real_escape_string($conn, $_POST["user"]);
        $query = "SELECT * FROM Users WHERE Username = '$username'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0){
            $error[] = "Username gia' in uso";
        }
        $mail = mysqli_real_escape_string($conn, $_POST["mail"]);
        $query = "SELECT * FROM Users WHERE Email = '$mail'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0){
            $error[] = "mail gia' in uso";
        }

        if (empty($error)){
            $name = mysqli_real_escape_string($conn, $_POST['Nome']);
            $surname = mysqli_real_escape_string($conn, $_POST['Cognome']);
            $pass = mysqli_real_escape_string($conn, $_POST['pass']);
            $pass = password_hash($pass ,PASSWORD_BCRYPT);

            $query = "INSERT INTO users(Nome, Cognome, Username, Email, Pass) VALUES('$name', '$surname', '$username', '$mail', '$pass')";
            mysqli_query($conn, $query); 

            session_start();    
            $_SESSION['User'] = $username;
            $_SESSION['Id'] = mysqli_insert_id($conn);
            
            header("Location: home.php");
            mysqli_close($conn);
            exit;
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Signup</title>
        <link rel="stylesheet" href="CSS/signup.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="SCRIPTS/signup.js" defer="true"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Roboto:wght@300&display=swap" rel="stylesheet">
    </head>
    <body>
        <main>
          <div>
                <h1>GAME2GO</h1></br>
                <span>Signup</span>

                <form name="Form" method="POST">
                Nome <input type='text' name='Nome' class='textinput'> <span id='name-error'></span>
                Cognome  <input type='text' name='Cognome' class='textinput'> <span id='surname-error'></span>
                Username <input type='text' name='user' class='textinput'> <span id='username-error'></span>
                E-mail  <input type='text' name='mail' class='textinput'> <span id='mail-error'></span>
                <div class="tooltip"> Password <img src='CSS/question.png'> 
  <span class="tooltiptext">Deve contenere almeno una maiuscola, una minuscola, un numero ed essere almeno otto caratteri</span>
</div> <input type='password' name='pass' class='textinput'> <span id='password-error'></span> 
                Conferma Password <input type='password' name='pass-confirm' class='textinput'> <span id='confirm-error'></span>
                <input type='submit' id='submit' value='SIGNUP'>
                </form>
            </div>
        </main>
    </body>
</html>