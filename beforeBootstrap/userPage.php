<a href='index.php'> << Main site </a><br><br>

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

if ($_SERVER['REQUEST_METHOD'] == "GET"){
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
if ($loggedUserId != $userId){
    echo("<a href='sendMessage.php?receiver_id=$userId'> Send message<a>");
}
?>