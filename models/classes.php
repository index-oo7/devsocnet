<?php
class Database{
private $host="localhost";
private $username="root";
private $password="";
private $name="project_database";

function connect(){
    $db= mysqli_connect($this->host,$this->username,$this->password,$this->name);
    return $db;

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


class user{
    private $id
    private $db
    private $name;
    private $surname;
    private $nickname;
    private $email;
    private $password;
    private $info;

    public function __construct($db,$id){
        $this->id = $id;
        $this->db = $db;
        $this->loadData();
    }
    function loadData(){
        $query=$this->db->prepare("SELECT user_name, user_surname, user_nickname, user_email, user_info, user_password FROM app_user WHERE user_id = $this->id");
        $res=mysqli_query($this->db,$query);
        if($row = mysqli_fetch_assoc($res)){
            $this->name = $row['user_name'];
            $this->surname = $row['user_surname'];
            $this->nickname = $row['user_nickname'];
            $this->email = $row['user_email'];
            $this->info = $row['user_info'];
            $this->password = $row['user_password'];


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
            return "Choose your nicname";
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
            return "Tell us something about you.";
        }
    }

    public function setInfo($info) {
        $this->info = $info;
    }
    //funkcija za sve njegove postove ili to da bude funkcija u sql 


}
?>