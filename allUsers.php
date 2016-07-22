<a href='index.php'> << Main site </a><br><br>

<?php

require_once 'src/connection.php';
require_once 'src/Message.php';
require_once 'src/User.php';

$allUsers = User::loadAllUsers($conn);
$length = count($allUsers);
for($i=0; $i < $length; $i++){
    $allUsers[$i]->showUser();
    $userId = $allUsers[$i]->getId();
    echo "<a href='userPage.php?userId=$userId'>  Go to user page</a><br>";
}

