

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
    var_dump($newMessage);
}
?>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
</body>
</html>