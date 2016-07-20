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
    
    private $id;
    private $senderId;
    private $receiverId;
    private $text;
    private $seen;
    
    public function __construct() {
        $this->id = -1;
        $this->sender_id = '';
        $this->receiver_id = '';
        $this->text = '';
        $this->seen = 0;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setSenderId($newSenderId){
        $this->sender_id = is_integer($newSenderId) ? $newSenderId : '';
    }
    
    public function getSenderId(){
        return $this->sender_id;
    }
    
    public function setReceiverId($newReceiverId){
        $this->receiver_id = is_integer($newReceiverId) ? $newReceiverId : '';
    }
    
    public function getReceiverId(){
        return $this->receiver_id;
    }
    
    public function setText($newText){
        $this->text = is_string($newText) ? $newText : '';
    }
    
    public function getText(){
        return $this->text;
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
            $sql = "INSERT INTO Message (user_id, receiver_id, sender_id, text, seen)
            VALUES ('$this->receiver_id', '$this->sender_id', '$this->text', '$this->seen')";
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
  
    
    static public function LoadMsgForSender (mysqli $conn, $sender_id){
        $sql = "SELECT * FROM Message WHERE sender_id = $sender_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $allMsg = array();
            foreach($result as $row){
                $newMsg = new Message();
                //$newMsg->$row['sender_id']; // w sumie to jest niepotrzebne poniewaz uzytkownik wie jakie ma id
                $newMsg->$row['receiver_id'];
                $newMsg->$row['text'];
                $newMsg->$row['seen'];
                $allMsg[] = $newMsg;
            }
                return $allMsg;
            }
            return [];
        }
    
    static public function LoadAllMsgForReceiver (mysqli $conn, $receiver_id){
        $sql = "SELECT * FROM Mesage WHERE receiver_id = $receiver_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $allMsg = array();
            foreach($result as $row){
                $newMsg = new Message();
                $newMsg->$row['sender_id'];
                $newMsg->$row['text'];
                $newMsg->$row['seen'];
                $allMsg [] = $newMsg;
            }
            return $allMsg;
        }
        return [];
    }
    
    public function Seen($conn){
        if($this->id != -1){
            $sql = "UPDATE Message SET seen = 1";
            if($conn->query($sql)){
                return true;
            }
        return false;
        }
    }
}

