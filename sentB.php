<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sent</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <a href="indexB.php" class="btn btn-info btn-md" role="button"><< Tweeter</a><br>
</body>
</html>
<?php

require_once 'src/connection.php';
require_once 'src/Message.php';
require_once 'src/User.php';

session_start();
if(isset($_SESSION['loggedUserId'])){
    $userId = $_SESSION['loggedUserId'];
}
echo "<div class = 'container'>
<div class = 'well'>";
$sent = Message::loadSentMessages($conn, $userId);
$length = count($sent);
for($i=0; $i<=$length-1; $i++){
    $sent[$i]->showSentMessage();
    $messageId = $sent[$i]->getId();
    echo ("<a href='showMessage.php?id=$messageId' target='_blank'>Kliknij, aby zobaczyć całą wiadomość</a><br>");
}
echo "</div></div>";
?>
