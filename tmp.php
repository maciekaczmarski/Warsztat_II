<?php

    require_once 'src/connection.php';
    require_once 'src/User.php';
    
    $tweet = new User;
    $tweet->loadAllTweets($conn);
    var_dump($tweet);