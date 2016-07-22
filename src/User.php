<?php

class User{
    
    static public function logIn (mysqli $conn, $email, $psw) {//mysqli $conn polaczenie do bazy danych
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){//jesli email jest prawidlowy = jest taki uztkownik
            $row = $result->fetch_assoc();//zwraca wynik zapytania w tablicy asocjacyjnej z insekasami z tablicy User
            if (password_verify($psw, $row['psw'])){//sprawdz haslo
                return $row['id'];
            }else{
                return false;
            }
        }
        else{
            return false;//gdy ktos uzyl email ktorego nie ma w naszej bazie danych
        }
    }
    
    static public function getUserByEmail (mysqli $conn, $email){//metoda nie pozawala zrejestrowac sie uzytkownikowi ktorego email jest w bazie danych
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user = new User();
            $user->setId((int)$row['id']);
            $user->setEmail($row['email']);
            $user->setPassword($row['psw']);
            $user->setFullName($row['fullName']);
            $user->setActive($row['active']);
            return $user;
        }
        else{
            return false;
        }
    }
    
    static public function getUserById (mysqli $conn, $id){
        $sql = "SELECT * FROM User WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user = new User();
            $user->setId((int)$row['id']);
            $user->setEmail($row['email']);
            $user->setPassword($row['psw']);
            $user->setFullName($row['fullName']);
            $user->setActive($row['active']);
            return $user;
        }
        else{
            return false;
        }
    }
    
    static public function loadAllUsers (mysqli $conn){
        $sql ="SELECT * FROM User";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $allUsers = array();
            foreach ($result as $row){
                $newUser = new User();
                $newUser->id = (int)$row['id'];
                $newUser->email = $row['email'];
                $newUser->fullName = $row['fullName'];
                $allUsers[] =  $newUser;
            }
            return $allUsers;
        }
        else{
            return [];
        }
    }
    
    


    protected $id;
    protected $email;
    protected $psw;
    protected $fullName;
    protected $active;
    
    public function __construct() {
        $this->id = -1;
        $this->email = '';
        $this->psw = '';
        $this->fullName = '';
        $this->active = 0;
    }
    
    public function setId($id){
        $this->id = is_integer($id) ? $id : -1;
        return $this;
    }
    
    public function  setEmail($email){
        $this->email = is_string($email) ? $email : '';
        return $this;
    }
    
    public function setPassword($psw) {
        $this->psw = is_string($psw) ? $psw : '';
        
    }
    
    public function setHashedPassword ($psw){
        $this->psw = is_string($psw) ? password_hash($psw, PASSWORD_DEFAULT) : '';
    }
    
    public function setFullName($fullName){
        $this->fullName = is_string($fullName) ? $fullName : '';
        return $this;
    }
    
    public function setActive($active){
        $this->active = $active == 0 || $active == 1 ? $active : 0;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function saveToDB(mysqli $conn){
        if($this->id == -1 ){
            $sql = "INSERT INTO User (email, psw, fullName, active)
                    VALUES ('$this->email', '$this->psw', '$this->fullName',
                    '$this->active')";

            if ($conn->query($sql)){
                $this -> id = $conn->insert_id;
                return $this;
            }
            else{
                return false;
            }
            
        }
        else{
            $sql= "UPDATE User SET
                    email = '$this->email',
                    psw = '$this->psw',
                    fullname = '$this->fullName',
                    active = '$this->active',
                    WHERE id = $this->id";
        }
        if ($conn->query($sql)){
                $this -> id = $conn->insert_id;               
                return $this;
            }
            else{
                return false;
            }
    }
    
    public function loadAllTweets(mysqli $conn){
        return Tweet::loadAllTweetsByUserId($conn, $this->id);
    }
    
    public function loadSentMessages(mysqli $conn){
        return Message::loadSentMessages($conn, $this->id);
    }
    
    public function loadRecivedMessages(mysqli $conn){
        return Message::loadRecivedMessages($conn, $this->id);
    }
    
    public function showUserInfo(){
      echo  "ID: " .$this->id. "<br>".
            "emiail adress: " .$this->email. "<br>".
            "Full name: " .$this->fullName. "<br>".
            "Active: " .$this->active;
    }
    
    public function showUser(){
        echo "ID: " .$this->id.  " email adress: " .$this->email;
    }
}