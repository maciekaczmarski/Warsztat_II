<a href='index.php'> << Main site </a><br><br>

<?php

require_once 'src/connection.php';
require_once 'src/Message.php';
require_once 'src/User.php';

session_start();
if(isset($_SESSION['loggedUserId'])){
    $userId = (int) $_SESSION['loggedUserId'];
}
$received = Message::loadRecivedMessages($conn, $userId);
$length = count($received);
for($i = 0; $i <=$length-1; $i++){
    $received[$i]->showReceivedMessage();
    $messageId = $received[$i]->getId();
    $seenId = $received[$i]->getSeen();
    echo ("<a href='showMessage.php?id=$messageId' target='_blank'>Kliknij, aby zobaczyć całą wiadomość</a><br>");    
}
?>
<html>
<head>
<meta charset="UTF-8">

</head>
<body>
    
</body>
</html>