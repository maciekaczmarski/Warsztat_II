<?php

class Tweet{
    
    static public function LoadAllTweetsByUserId(mysqli $conn, $user_id){
        $sql = "SELECT * FROM Tweet WHERE user_id = $user_id";
        $result = $conn->query($sql);
        if($result != FALSE && $result->num_rows > 0){
            $allTweets = array();
            foreach ($result as $row){
                $newTweet = new Tweet();
                $newTweet->id = $row['id'];
                $newTweet->text = $row['text'];
                $newTweet->user_id = $row['user_id'];
                $allTweets[] = $newTweet;
            }
            return $allTweets;
        }
        
        return [];
    }


    protected $id;
    protected $user_id;
    protected $text;
    
    
    public function __construct (){
        $this->id = -1;
        $this->user_id = "";
        $this->text =  "";
    }
    
    public function setUserId ($userId) {
        $this->user_id = is_integer($userId) ? $userId : -1;
        return $this;
    }
    
    public function setText($text) {
        $this->text = is_string($text) ? $text : null;
        return $this;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function loadFromDB (mysqli $conn, $id){
        //$sql = "SELECT User.*, Tweet.id, Tweet.user_id, Tweet.text FROM User JOIN Tweet ON User.id=Tweet.user_id";
        $sql = "SELECT * FROM Tweet WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->user_id = $row['user_id'];
            $this->text = $row['text'];
            return true;
        }
        return false;
          
    }

    

    public function createTweet(mysqli $conn){//wsadzic w if aby sprawdzal czy id == -1
        if ($this->id == -1){
            $sql = "INSERT INTO Tweet(user_id, text) VALUES ($this->user_id, '$this->text')";
            if  ($conn->query($sql)){
                $this->id = $conn->insert_id;
                return TRUE;
            }
            else{
                echo $conn->error. "<br>";
                echo $sql;
            }
        }
        return FALSE;
        
    }
    
    public function updateTweet (mysqli $conn){//if sprwadzajacy czy id jest != -1
        if($this->id != -1){
            $sql = "UPDATE Tweet SET user_id = $this->user_id, text = '$this->text'";
            if ($conn->query($sql)){              
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function showTweet(){
        echo $this->user_id. "said: " .$this->text;
    }
    
    public function getAllComents(mysql $conn){
        return Comment::GetAllComments($conn, $this->id);
    }
}