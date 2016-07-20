<?php

//CREATE TABLE Comment(
//        id INT AUTO_INCREMENT PRIMARY KEY,
//        user_id INT NOT NULL,
//        post_id INT NOT NULL,
//        text TEXT NOT NULL,
//        creation_date datetime NOT NULL,
//        FOREIGN KEY(post_id) REFERENCES Tweet(id),
//        FOREIGN KEY(user_id) REFERENCES User(id)
//
//        );
        
class Comment{
    
    private $id;
    private $user_id;
    private $post_id;
    private $creationDate;
    private $text;


    public function getId(){
        return $this->id;
    }


    public function setUserId ($newUserId){
        $this->user_id = is_interger($newUserId) ? $newUserId : '' ;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function setPostId($newPostId){
        $this->post_id = is_inerger($newPostId) ? $newPostId : '';
    }
    
    public function getPostId(){
        return $this->post_id;
    }
    
    public function setCreateionDate($newCreationDate){
        $this->creation_date = $newCreationDate ? $newCreationDate : '';
        
    }
    
    public function getCreationDate(){
        return $this->creation_date;
    }
    
    public function setText($newText){
        $this->text = is_string($newText) ? $newText : '';
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function __construct() {
        $this->id = -1;
        $this->user_id = '';
        $this->post_id = '';
        $this->creationDate = '';
        $this->text = '';
    }
    
    public function loadFromDB (mysqli $conn, $id){
            $sql = "SELECT * FROM Comment WHERE id = $id";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->user_id = $row['user_id'];
                $this->post_id = $row['post_id'];
                $this->text = $row['text'];
                $this->creationDate = $row['creation_date'];
                return true;
            }
            return false;
    }
            
    public function createComment (mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Comment (user_id, post_id, text, creation_date)
            VALUES ('$this->user_id', '$this->post_id', '$this->text', '$this->creationDate')";
            if ($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        }
    }
    
    public function updateComment (mysqli $conn){
        $sql = "UPDATE Comment SET
        user_id = '$this->user_id',
        post_id = '$this->post_id',
        creation_date = '$this->creationDate',
        text = '$this->text'";
        if($conn->query($sql)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function showComment(){
        echo $this->user_id."commented: ".$this->text.' '."creation_date"; 
    }
    
    static public function GetAllComments($conn, $post_id){
        $sql = "SELECT * FROM Comment WHERE post_id = $post_id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $allComments = array();
            foreach($result as $row){
                $newComment = new Comment();
                $newComment->$row['id'];
                $newComment->$row['user_id'];
                $newComment->$row['text'];
                $newComment->$row['creation_date'];
                $allComments [] = $newComment;
            }
            return $allComments;
        }
        return [];
    }
}


