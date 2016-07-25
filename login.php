<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'src/connection.php';
    require_once 'src/User.php';
    
    
    $email = isset($_POST['email']) ?  $conn->real_escape_string(trim($_POST['email'])) : null;
    $psw = isset($_POST['psw']) ? trim($_POST['psw']) : null;
    
    if (strlen($email) >= 5 && strlen($psw) > 0){
        if($userid = User::logIn($conn, $email, $psw));
            $_SESSION['loggedUserId'] = $userid;

            header("Location: indexB.php");
    }else{
        echo"Niepoprawne dane logowania<br>";
    }
}


?>
<!--<html>
    <head>
        <title>Log In</title>
    </head>
    <body>
        <form action='#' method="POST">
            <fieldset>
                <legend>Logowanie</legend>
            <label>
                E-mail:
                <input type="text" name='email'/>
            </label><br>
            <label>
                Password:
                <input type="password" name='psw'/>
            </label><br>
            <input type='submit' value='Login'>
            </fieldset>
        </form>
        <br>
        <a href='register.php'> Registration </a>
    </body>
</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <div class='container'>
    <form action='#' method="POST">
        <fieldset>
            <div class ='well'>
                <h2>Log-in</h2>
            </div>
        <label>
            E-mail:
            <input type="text" class="form-control" name='email'/>
        </label><br>
        <label>
            Password:
            <input type="password" class="form-control" name='psw'/>
        </label><br>
        <input type="submit" class="btn btn-info" value="Login">
        </fieldset>
    </form>
    <br>
    <a href="register.php" class="btn btn-danger" role="button">Registration</a>
    </div>
</body>
</html>