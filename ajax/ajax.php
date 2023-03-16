<?php
require_once '../models/classes.php';
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



?>