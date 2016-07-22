<a href='index.php'> << Main site </a><br><br>

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
            echo "Message was sent successfully";
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
<form action="#" method="POST">
    
    Type your message here:<br>
    <textarea name="message" rows='4' cols="50" ></textarea>
    <input type="hidden" value="<?php echo $receiverId?>" name="receiverId">
    <input type="submit" value="Wyslij">
</form>