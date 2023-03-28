<?php
class Database{
    private $host="localhost";
    private $username="root";
    private $password="";
    private $name="project_database";

    function connect(){
        return mysqli_connect($this->host,$this->username,$this->password,$this->name);
    }

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

    public function __construct($datab,$id){
        $this->id = $id;
        $this->db = $datab->connect();
        $this->loadData();
    }
    
    // function changeInfo($iduser,$name,$surname,$nickname,$info){
    //     $query="UPDATE app_user SET user_name='{$name}', user_surname='{$surname}', user_nickname='{$nickname}',user_info='{$info}' WHERE user_id={$iduser}";
    //     $res=mysqli_query($this->db,$query);
    //     return "Data changed successfully!";
    // }

    function loadData(){
        $querry="SELECT user_name, user_surname, user_nickname, user_email, user_info, user_password FROM app_user WHERE user_id = {$this->id}";
        $res=mysqli_query($this->db,$querry);
        if(mysqli_error($this->db)){
            header('Location: ../Login/login.php');

        }
        if(mysqli_num_rows($res)==0){
            echo "eror sa upitom nema ga u bazi"; 
        }else{   
            while($row=mysqli_fetch_assoc($res)){
            $this->name = $row['user_name'];
            $this->surname = $row['user_surname'];
            $this->nickname = $row['user_nickname'];
            $this->email = $row['user_email'];
            $this->info = $row['user_info'];
            $this->password = $row['user_password'];
            }
        }
        $this->db->close();
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

    function allposts($datab){
        $dbc=$datab->connect();
        $posts=array();
        $query="call posts_procedure({$this->id})";
        $res=mysqli_query($dbc,$query);
        while($row = mysqli_fetch_assoc($res)){
            $posts[]=$row['post_id'];
        }
        $dbc->close();
        return $posts;
    }
    //napraviti proceduru da mi dohvati ime po id da se prikaze u comm
}


class Post{
    public $dbc;
    public $userid;
    public $datetime;
    public $caption;
    public $category;
   // public $uploaded_file;
    
    function __construct($datab,$userid,$caption,$category){
        $this->dbc=$datab->connect();
        $this->userid=$userid;
        $this->caption=$caption;
        $this->category=$category;
        $this->loadtodatabase();
    }

    function loadtodatabase(){
        $query = $this->dbc->prepare("CALL addpost(?, ?, ?)");
        $query->bind_param("iss", $this->userid, $this->caption, $this->category);
        $query->execute();
    }

    public static function getpost($idpost,$datab){
        $dbc=$datab->connect();
        $query=$dbc->prepare("CALL getpost(?)");
        $query->bind_param("i",$idpost);
        $query->execute();
        $res=$query->get_result();
        while( $row=mysqli_fetch_assoc($res)){
            $topic=$row['category'];
            $time=$row['created_datetime'];
            $date=date('d.m.Y.',strtotime($time));
            $txt=$row['caption'];
            $htmlanswer="";
            $htmlanswer.="<div>
            <h5>{$topic}</h5>
            {$txt}<br>
            <div class='date'>{$date}</div>
            </div>";
            echo $htmlanswer;
        }
        $dbc->close();
    }
}

class Comment{
    public $userid;
    public $postid;
    public $text;
    public $dbc;
    
    function __construct($db,$userid,$postid,$text){
        $this->dbc=$db->connect();
        $this->postid=$postid;
        $this->text=$text;
        $this->userid=$userid;
        $this->loadtodb();
    }
    function loadtodb(){
        $query=$this->dbc->prepare("CALL addcomm(?,?,?)");
        $query->bind_param("iis",$this->userid,$this->postid,$this->text);
        $query->execute();
        $this->dbc->close();
    }
    function showcomm(){
        $database= new Database();
        $dbc=$database->connect();
        $query=$dbc->prepare("CALL showcomm(?,?)");
        $query->bind_param("ii",$this->userid,$this->postid);
        $query->execute();
        $resp="";
        $result = $query->get_result();
        $nizkom=[];
        while ($row = $result->fetch_assoc()) { 
            $resp=$row['comment_text']." ".$row['created_datetime'];
        }
        return $resp;
        $dbc->close();
    }
    static function getcommbypostid($postid){
        $databse=new Database();
        $dbc=$database->connect();
        $query=$dbc->prepare("CALL commentsofpost(?)");
        $stm->bind_param("i",$postid);
        $query->execute();
        $comments=array();
        $result=$stm->get_result();
        while($row=$result->fetch_assoc()){
            array_push($comments,$row);
        }
        return $comments;
        $dbc->close();
    }
}




  // $query="CALL addpost({$this->userid},{$this->caption},{$this->category})";
        // mysqli_query($this->dbc,$query);
        // mysqli_error($this->dbc); //nmp sto ovo nije htelo da radi mjkmi
        

 //    $topic=$row['category'];
    //    $time=$row['created_datetime'];
    //    $txt=$row['caption'];
    //    echo gettype($topic);
    //    echo $topic;
    //    $htmlanswer="";
    //     $htmlanswer.="<div>
    //     <h3>{$topic}</h3><br>
    //     {$txt}<br>
    //     {$time};
    //     </div>";
    //     return $htmlanswer;
    // }
// class comment{
// public $user_id;
// public $post_id;
// public $comm_text;
// public $comm_time;
// public $dbc;

// public __construct($datab,$userid,$postid,$txt){
//     $this->dbc=$datab->connect();
//     $this->$user_id=$userid;
//     $this->$post_id=$postid;
//     $this->comm_text=$txt;
//     $this->loadtodatabase();
// }
// function loadtodatabase(){
//     $querry=$this->dbc->prepare("CALL addcomm(?,?,?)");
//     $querry=bind_param("iis",$this->user_id,$this->post_id,$this->comm_text);
//     $querry->execute();
//     $dbc->close();
// }
// } 




?>