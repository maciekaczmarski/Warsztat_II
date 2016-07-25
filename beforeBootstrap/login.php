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

            header("Location: index.php");
    }else{
        echo"Niepoprawne dane logowania<br>";
    }
}


?>
<html>
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
</html>