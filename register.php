<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once 'src/connection.php';
    require_once 'src/User.php';
    
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
    $psw = isset($_POST['psw']) ? $conn->real_escape_string(trim($_POST['psw'])) : null;
    $passwordConfirmation = isset($_POST['pswConfirmation']) ? trim($_POST['pswConfirmation']) : null;
    $fullName = isset($_POST['fullName']) ? $conn->real_escape_string(trim($_POST['fullName'])) : null;
    
    $user = User::getUserByEmail ($conn, $email);
    if($email && $psw && $psw == $passwordConfirmation && !$user){
        
        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setHashedPassword($psw);
        $newUser->setFullName($fullName);
        $newUser->setActive(1);
        var_dump($newUser);
        
            if ($newUser->savetoDB($conn)){
                header("Location: login.php");
              
            }
        else{
            echo "rejestracja nie powiodła sie<br>";
        }
        
    }
    else {
        if($user){
            echo "Podany adres email istnieje w bazie danych";
        }else{
        echo "Nieprawidłowe dane<br>";
        }
    }
}
         
?>

<html>
    <head>
    </head>
    <body>
        <form method='POST' action='#'>
            <fieldset>
            <label>
                Email:<br>
                <input type="text" name="email"/>
            </label><br>
            <label>
                Password:<br>
                <input type='password' name='psw'/>
            </label><br>
            <label>
                Password confirmation:<br>
                <input type='text' name='pswConfirmation'/>
            </label><br>
            <label>
                Full name:<br>
                <input type ='text' name='fullName'/>
            </label><br>
            <input type='submit' value='register'/>
        </fieldset>
        </form>
    </body>
</html>
