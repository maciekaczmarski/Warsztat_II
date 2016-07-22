<a href='index.php'> << Main site </a><br><br>

<?php

require_once 'src/User.php';
require_once 'src/connection.php';
session_start();
if (isset($_SESSION['loggedUserId'])){
    $userId = (int) $_SESSION['loggedUserId'];
}
echo "You are logged as: " .$userId. "<br>";
$user = User::getUserById($conn, $userId);
$user->showUserInfo();
?>
<from action="#" method="POST">
    <fieldset>
        <legend>Change password</legend>
        New password:<br>
        <input type="password" name="newpsw1"><br>
        Repeat new password:<br>
        <input type="password" name="newpsw2"><br>
    </fieldset>
</from>
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $newpsw1 = $_POST['newpsw1'];
    $newpsw2 = $_POST['newpsw2'];
    if(isset($newpsw1)=== isset($newpsw2)){
        $user->setHashedPassword($newpsw1);
        $user->saveToDB($conn);
    }
}