<?php
require_once '../models/classes.php';
$fun=$_GET['fun'];
if($fun=="comment"){
    if(isset($_POST['iduser']) and isset ($_POST['commtxt'])and isset($_POST['postid'])){
 $db= new Database();
$txt=$_POST['commtxt'];
$userid=$_POST['iduser'];
$postid=$_POST['postid'];
if($txt!=""){
    $comment= new Comment($db,$userid,$postid,$txt);
    $response = $comment->showcomm();

}

echo $response;
}
}

if($fun=="change"){
if(isset($_POST['userid']) and isset($_POST['name']) and isset($_POST['surname']) and isset($_POST['nickname']) and isset($_POST['info'])){
    $db= new Database();
    $iduser=$_POST['userid'];
    $name=$_POST['name'];
    $surname=$_POST['surname'];
    $nickname=$_POST['nickname'];
    $info=$_POST['info'];
    $query="SELECT * FROM app_user WHERE user_nickname='{$nickname}' and user_id<>'{$iduser}'";
    $res=mysqli_query($db->connect(),$query);
    if(mysqli_num_rows($res)==0){
        // $target_user="SELECT * FROM app_user WHERE user_id={$iduser}";
        // $response=$target_user->changeInfo($iduser,$name,$surname,$nickname,$info);
        $query="UPDATE app_user SET user_name='{$name}', user_surname='{$surname}', user_nickname='{$nickname}',user_info='{$info}' WHERE user_id={$iduser}";
        $res=mysqli_query($db->connect(),$query);
        $response="Data changed successfully!";
    }
    else{
        $response="Nickname already exists. Please try with another one.";
    }
    echo $response;
}    
}

?>