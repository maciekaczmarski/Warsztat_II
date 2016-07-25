<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <a href="indexB.php" class="btn btn-info btn-lg" role="button"><< Tweeter</a><br>
</body>
</html>

<?php


require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/connection.php';
require_once 'src/Comment.php';
require_once 'src/Message.php';

session_start();
if (isset($_SESSION['loggedUserId'])){
   $loggedUserId = $_SESSION['loggedUserId'];
}

echo "<div class='container' style='font-size:30px;'>";
echo "<div class='well'";
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $userId = $_GET['userId'];
    $allUserTweets = Tweet::loadAllTweetsByUserId($conn, $userId);
    $length = count($allUserTweets);
    for($i=0; $i<=$length-1;$i++){
        $allUserTweets[$i]->showTweet();
        $allTweetComments = Comment::GetAllComments($conn, $allUserTweets[$i]->getId());
        $tweetsLength = count($allTweetComments);
        for($j=0; $j<=$tweetsLength-1;$j++){
            $allTweetComments[$j]->showComment();
        }
    }
}
echo "</div></div>";
echo "<div class='container'>";
if ($loggedUserId != $userId){
    echo "<a href='sendMessageB.php?receiver_id=$userId' class='btn btn-info' role='button'>Send message</a>";
    //echo("<a href='sendMessage.php?receiver_id=$userId'> Send message<a>");
}
echo "</div>";
?>