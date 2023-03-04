<?php
class Database{
private $host="localhost";
private $username="root";
private $password="";
private $name="project_database";

function connect(){
    return mysqli_connect($this->host,$this->username,$this->password,$this->name);
}
// function readbyid($id){
//     $db=$this->connect();
//     $query="select * from $this->name.readbyid($id)";
//     $rez=mysqli_query($db,$query);
//     if($rez!=NULL){
//         return $rez;
//     }else {
//         echo "greska!!!! ".mysqli_error($db);
//     }


// }
    
}


class User{
     public $id;
     public $db;
     public $name;
     public $surname;
     public $nickname;
     public $email;
     public $password;
     public $info;

    public function __construct($db,$id){
        $this->id = $id;
        $this->db = $db;
        $this->loadData();
    }
    


    function loadData(){
        
        $querry="SELECT user_name, user_surname, user_nickname, user_email, user_info, user_password FROM app_user WHERE user_id = {$this->id}";
        $res=mysqli_query($this->db,$querry);
        if(mysqli_num_rows($res)==0){
            echo "eror sa upitom nema ga u bazi"; 
        }else
        {   while($row=mysqli_fetch_assoc($res)){
            $this->name = $row['user_name'];
            $this->surname = $row['user_surname'];
            $this->nickname = $row['user_nickname'];
            $this->email = $row['user_email'];
            $this->info = $row['user_info'];
            $this->password = $row['user_password'];
        }
        
    }

    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getNickname() {
        if ($this->nickname!=""){
            return $this->nickname;
        }else{
            return "not entered yet";
        }
        
       
    }

    public function setNickname($nickname) {

        $this->nickname = $nickname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getInfo() {
        if($this->info!=""){
        return $this->info;
        }else{
            return "Not added info";
        }
    }

    public function setInfo($info) {
        $this->info = $info;
    }
    //funkcija za sve njegove postove ili to da bude funkcija u sql 
    function allposts(){
        $posts=array();
        $query="call posts_procedure({$this->id})";
        $res=mysqli_query($this->db,$query);
        while($row = mysqli_fetch_assoc($res)){
            $posts[]=$row['post_id'];
        }

        return $posts;
    }

}
class Post{
    public $db;
    public $userid;
    public $datetime;
    public $caption;
    public $category;
   // public $uploaded_file;
    
    function _construct($userid,$caption,$category){
        $this->userid=$userid;
        $this->caption=$caption;
        $this->category=$category;
        $this->loadtodatabase();
    }

    function loadtodatabase(){
        


        
    }
}


?>