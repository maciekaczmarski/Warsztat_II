

<?php
require_once 'src/connection.php';
require_once 'src/Message.php';

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $messageId = (int) $_GET['id'];
    $newMessage = new Message();
    $newMessage->loadFromDB($conn, $messageId);
    $newMessage->showMessage();
    $seenId = $newMessage->getSeen();
    $newMessage->seen($conn);
    //var_dump($newMessage);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Show message</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
</body>
</html>