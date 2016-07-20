<?php
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/connection.php';
session_start();

if (!isset($_SESSION ['loggedUserId'])){
    header("Location: login.php");  //przekierowania
}
?>

Id użytkownika: <?php echo $_SESSION['loggedUserId'];?><br>


<html>
    <head>
        <meta charset="utf-8" /> 
    </head>
    <body>
        <a href='logout.php'>Logout</a><br>
        
    </body>
</html>

<?php

//$allTweets = new User();
//$allTweets->loadAllTweets($conn);
//var_dump($allTweets);

$newTweet = new Tweet();
$newTweet->createTweet($conn, 6, "Tweet testowy");