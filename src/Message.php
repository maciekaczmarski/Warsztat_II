<?php

//CREATE TABLE Message (
//        id INT AUTO_INCREMENT PRIMARY KEY,
//        sender_id INT NOT NULL,
//        receiver_id INT NOT NULL,
//        text text NOT NULL,
//        seen TINY INT DEFAULT 0,
//        FOREIGN KEY(sender_id) REFERENCES User(id),
//        FOREIGN KEY(receiver_id) REFERENCES User(id),
//                
//        );

class Message {
    
    static public function loadSentMessages (mysqli $conn, $senderId){
        $sql = "SELECT * FROM Message WHERE sender_id = $senderId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $allMsg = array();
            foreach($result as $row){
                $newMsg = new Message();
                $newMsg->id = $row['id'];
                $newMsg->senderId = $row['sender_id'];
                $newMsg->receiverId = $row['receiver_id'];
                $newMsg->text = $row['text'];
                $newMsg->seen = $row['seen'];
                $allMsg[] = $newMsg;
            }
            return $allMsg;
        }
        return [];
    }
    
    static public function loadRecivedMessages (mysqli $conn, $receiverId){
        $sql = "SELECT * FROM Message WHERE receiver_id = $receiverId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $allMsg = array();
            foreach($result as $row){
                $newMsg = new Message();
                $newMsg->id = $row['id'];
                $newMsg->senderId = $row['sender_id'];
                $newMsg->receiverId = $row['receiver_id'];
                $newMsg->text = $row['text'];
                $newMsg->seen = $row['seen'];
                $allMsg [] = $newMsg;
            }
            return $allMsg;
        }
        return [];
    }
    
    private $id;
    private $senderId;
    private $receiverId;
    private $text;
    private $seen;
    
    public function __construct() {
        $this->id = -1;
        $this->senderId = '';
        $this->receiverId = '';
        $this->text = '';
        $this->seen = 0;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setSenderId($newSenderId){
        $this->senderId = is_integer($newSenderId) ? $newSenderId : -1;
    }
    
    public function getSenderId(){
        return $this->senderId;
    }
    
    public function setReceiverId($newReceiverId){
        $this->receiverId = is_integer($newReceiverId) ? $newReceiverId : -1;
    }
    
    public function getReceiverId(){
        return $this->receiverId;
    }
    
    public function setText($newText){
        $this->text = is_string($newText) ? $newText : '';
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function getSeen(){
        return $this->seen;
    }
    
    public function setSeen($isSeen){
        if($isSeen == 0 || $isSeen == 1){
            $this->seen = $isSeen;
        }
        else {
            $this->seen = 0;
        }
    }
    
    public function createMessage (mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Message (sender_id, receiver_id, text, seen)
            VALUES ($this->senderId, $this->receiverId, '$this->text', '$this->seen')";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        }
    }
    
    public function loadFromDB (mysqli $conn, $id){
        $sql = "SELECT * FROM Message WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->receiverId = $row['receiver_id'];
            $this->senderId = $row['sender_id'];
            $this->text = $row['text'];
            $this->seen = $row['seen'];
            return true;    
        }
        return false;
    }
  
    

    
    public function seen($conn){
        if($this->id != -1){
            $sql = "UPDATE Message SET seen = 1";
            if($conn->query($sql)){
                return true;
            }
            return false;
        }
    }
    
    public function showReceivedMessage(){
        if ($this->seen == 0){
        echo "<strong>You received message from user: " .$this->senderId. "<br> Content: " .substr($this->text, 0, 30). "<br></strong>";
        }
        else {
        echo "You received message from user: " .$this->senderId. "<br> Content: " .substr($this->text, 0, 30). "<br>";    
        }
    }
    
    public function showSentMessage(){
        echo "You sent message to: " .$this->receiverId. "<br> Content:" .substr($this->text, 0, 30). "<br>";
    }
    
    public function showMessage(){
        echo "Content: <br>" .$this->text;
    }
}

