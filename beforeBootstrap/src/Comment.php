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
    
    static public function getAllComments($conn, $post_id){
        $sql = "SELECT * FROM Comment WHERE post_id = $post_id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $allComments = array();
            foreach($result as $row){
                $newComment = new Comment();
                $newComment->id = $row['id'];
                $newComment->userId = $row['user_id'];
                $newComment->postId = $row['post_id'];
                $newComment->text = $row['text'];
                $newComment->creationDate = $row['creation_date'];
                $allComments [] = $newComment;
            }
            return $allComments;
        }
        return [];
    }
    
    private $id;
    private $userId;
    private $postId;
    private $creationDate;
    private $text;


    public function getId(){
        return $this->id;
    }


    public function setUserId ($newUserId){
        $this->userId = is_integer($newUserId) ? $newUserId : -1 ;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    
    public function setPostId($newPostId){
        $this->postId = is_integer($newPostId) ? $newPostId : -1;
    }
    
    public function getPostId(){
        return $this->postId;
    }
    
    public function setCreationDate($newCreationDate){
        $this->creationDate = $newCreationDate ? $newCreationDate : '';
        
    }
    
    public function getCreationDate(){
        return $this->creationDate;
    }
    
    public function setText($newText){
        $this->text = is_string($newText) ? $newText : '';
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->postId = '';
        $this->creationDate = '';
        $this->text = '';
    }
    
    public function loadFromDB (mysqli $conn, $id){
        $sql = "SELECT * FROM Comment WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->userId = $row['user_id'];
            $this->postId = $row['post_id'];
            $this->text = $row['text'];
            $this->creationDate = $row['creation_date'];
            return true;
        }
        return false;
    }
            
    public function createComment (mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Comment (user_id, post_id, text, creation_date)
            VALUES ('$this->userId', '$this->postId', '$this->text', '$this->creationDate')";
            
            if ($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
        }
        return false;
    }
    
    public function updateComment (mysqli $conn){
        if($this->id != -1){
            $sql = "UPDATE Comment SET
            user_id = '$this->userId',
            post_id = '$this->postId',
            creation_date = '$this->creationDate',
            text = '$this->text'";
            if($conn->query($sql)){
                return TRUE;
        }
        }
        return FALSE;
    }
    
    public function showComment(){
        echo "User: " .$this->userId. " commented: " .$this->text. "<br>"; 
        echo "<span style='color:grey'>" .$this->creationDate. "</span><br>";
    }
    

}


