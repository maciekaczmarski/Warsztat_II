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
            $user = new User();//jezeli znalezlismy uzytkownika chcemy okreslic mu atrybuty
            $user->setId($row['id']);
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
        return Tweet::LoadAllTweetsByUserId($conn, $this->user_id);//czy tu na pewno user_id
    }
    
    public function LoadMsgForSender(mysqli $conn){
        return Message::LoadAllMsgForSender($conn, $this->user_id);
    }
    
    public function LoadMsgForReceiver(mysqli $conn){
        return Message::LoadAllMsgForReceiver($conn, $this->user_id);
    }
}