<?php
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/connection.php';
session_start();

if (!isset($_SESSION ['loggedUserId'])){
    header("Location: login.php");  //przekierowania
}
$loggedUser = (int)$_SESSION['loggedUserId'];
?>
Hello. You are logged as: <?php echo $_SESSION['loggedUserId'];?> <a href="editProfile.php">Edit profile</a>  
<html>
    <head>
        <meta charset="utf-8" /> 
    </head>
    <body>
        <?php echo "<a href='userPage.php?userId=$loggedUser'>  Go to your page</a>"?>
        <a href="allUsers.php">All Users</a>
        Messages:
        <a href="inbox.php">Inbox<a/>
        <a href="sent.php">Sent</a>
        <a href='logout.php'>Logout</a><br>
    </body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $tweetContent = $_POST['tweet'];
    $newTweet = new Tweet();
    $newTweet->setText($tweetContent);
    $newTweet->setUserId($loggedUser);
    $newTweet->createTweet($conn);
}
?>

Create new tweet: <br>
 <form method="POST" action="#">
     <textarea name="tweet" rows='4' cols="50" maxlength="160"></textarea>
     <input type="submit" value="Tweet it!"/>
 </form>

<?php
echo "All posted tweets:<br>";
$allTweets = Tweet::loadAllTweets($conn);
$length = count($allTweets);
for($i = 0; $i < $length; $i++){
    $allTweets[$i]->showTweet();
    $tweetId = $allTweets[$i]->getId();
    echo ("<a href='showPost.php?tweetId=$tweetId'>Show comments</a><br>");
}
?>