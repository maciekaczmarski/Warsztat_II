<a href='index.php'> << Main site </a><br><br>

<?php
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/connection.php';
require_once 'src/Comment.php';
require_once 'src/Message.php';


session_start();
if (isset($_SESSION['loggedUserId'])){
    $userId = (int)$_SESSION['loggedUserId'];
}
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $tweetId = (int)$_GET['tweetId'];
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['comment'])){
        if (trim($_POST['comment']) != null){
            $addComment = new Comment();
            $addComment->setUserId($userId);
            $addComment->setText($_POST['comment']);
            $addComment->setCreationDate($_POST['creationDate']);
            $addComment->setPostId((int)$_POST['tweetId']);
            $addComment->createComment($conn);
            $tweetId = (int)$_POST['tweetId'];
        }
    }
    else {
        echo "<br> Add comment here: <br>";
    }
}
$tweet = new Tweet();
$tweet->loadFromDB($conn, $tweetId);
$tweet->showTweet();
$allComments = Comment::getAllComments($conn, $tweetId);
$length = count($allComments);
for($i=0; $i<=$length-1;$i++){
    $allComments[$i]->showComment();
}
?>
<html>
     <form method="POST" action="#">
         <br>Add comment:<br>
        <textarea name="comment" rows='3' cols="40"></textarea>
        <input type="hidden" name="creationDate" value="<?php echo date('Y-m-d H:i:s')?>">
        <input type="hidden" name="tweetId" value="<?php echo $tweetId?>">
        <input type="submit" value="Dodaj">
    </form>
</html>

