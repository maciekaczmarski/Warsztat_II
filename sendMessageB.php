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
    <a href="indexB.php" class="btn btn-info btn-md" role="button"><< Tweeter</a><br>
</body>
</html>

<?php
require_once 'src/connection.php';
require_once 'src/Message.php';
require_once 'src/User.php';
session_start();
if (isset($_SESSION['loggedUserId'])){
    $userId = (int) $_SESSION['loggedUserId'];
}
if(isset($_GET['receiver_id'])){
    $receiverId = (int)$_GET['receiver_id'];
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (trim($_POST['message']) != FALSE){
        $message = $_POST['message'];
        $newMessage = new Message();
        $newMessage->setText($message);
        $newMessage->setSenderId($userId);
        $id = (int) $_POST['receiverId'];
        $newMessage->setReceiverId($id);
        $newMessage->setSeen(0);
        $newMessage->createMessage($conn);
        if ($conn == TRUE){
            echo "<div class='container'>
                    <div class='alert alert-success'>Message was sent successfully</div>
                </div>";
        }
        else{
            echo "error";
        }
    }
    else {
        echo "Type a message!";
    }
}  
?>

<!--<form action="#" method="POST">
    
    Type your message here:<br>
    <textarea name="message" rows='4' cols="50" ></textarea>
    <input type="hidden" value="<?php echo $receiverId?>" name="receiverId">
    <input type="submit" value="Wyslij">
</form>-->
<div class='container'>
<form action="#" method="POST">
    <div class="form-group">
        <label for="comment"><h3>Type your message here:</h3></label>
      <textarea class="form-control" rows="2" name="message"></textarea>
      <input type="hidden" value="<?php echo $receiverId?>" name="receiverId">
      <input type="submit" class="btn btn-info" value="Send">
    </div>
</form>
</div>