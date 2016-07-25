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

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tweeter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
    <body>
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">Tweeter</a>
            </div>
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">You are loged as <?php echo $_SESSION['loggedUserId'];?></a></li>
              <li><a href="editProfile.php">Edit Profile</a></li>
              <li><a href="allUsersB.php">All users</a></li> 
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Messages
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="inboxB.php">Inbox</a></li>
                      <li><a href="sentB.php">Sent</a></li>
                    </ul>
                  </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log-out</a></li>
            </ul>
          </div>
        </nav>
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

<div class="container">
  <form role="form" method="POST" action="#">
    <div class="form-group">
        <label for="tweet"><h2>create new Tweet:</h2></label>
      <textarea class="form-control" rows="4" name="tweet" maxlength="160"></textarea>
      <input type="submit" class='btn' value="Tweet it!"/>
    </div>
  </form>
</div>

<?php

echo "<div class='container'>
        <div class='jumbotron'>
         <h2>All posted Tweets:</h2><br><h2>";
            $allTweets = Tweet::loadAllTweets($conn);
            $length = count($allTweets);
            //var_dump($length);
            for($i = $length-1; $i+1 > 0; $i--){
            $allTweets[$i]->showTweet();
            //var_dump($i);
            $tweetId = $allTweets[$i]->getId();
            echo ("<a style = 'font-size:22px; 'href='showPost.php?tweetId=$tweetId'>Show comments</a><br><br>");
            }
       echo"</h2></div>
    </div>";



?>

