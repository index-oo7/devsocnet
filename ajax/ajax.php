<?php
require_once '../models/classes.php';
session_start();


$fun=$_GET['fun'];
if($fun=="comment"){
    if(isset($_POST['iduser']) and isset ($_POST['commtxt'])and isset($_POST['postid'])){
        $db= new Database();
        $txt=$_POST['commtxt'];
        $userid=$_POST['iduser'];
        $postid=$_POST['postid'];
        if($txt!=""){
            $comment= new Comment($db,$userid,$postid,$txt);
        }
    }
}
if($fun=="commentsbypost"){
    if(isset($_POST['postid'])){
        $postid=$_POST['postid'];
        $comments=array();
        $comments=Comment::getcommbypostid($_POST['postid']);
        $commented="";
        foreach ($comments as $comment) {
            $userrow= User::getbyid($comment['user_id']);
                foreach($userrow as $user){
                    $usernik=$user['user_nickname'];
                }
            
           
            $commented.= $usernik."<br>" . $comment['comment_text'] . date('d.m.Y.',strtotime($comment['created_datetime']))."<br><br>";
        }
        
        $response=$commented."<input type='text' name='commtxt{$postid}' id='commtxt{$postid}' placeholder='Comment'><br><button id='btncomm' class='btn btn-outline-light' type='submit' onclick='Postcomm({$postid},{$_SESSION['iduser']})'>Comment</button>";
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
            $response="<div class='warning'><p>Data changed successfully!</p></div>";
        }
        else{
            $response="<div class='warning'><p>Nickname already exists. Please try with another one.</p></div>";
        }
        echo $response;
    }   
}

if($fun=="follow"){
    if(isset($_POST['following_user_id']) and isset($_POST['email']) and isset($_POST['nickname'])){
           $db=new Database();
        $following_user_id=$_POST['following_user_id'];
        $email=$_POST['email'];
        $nickname=$_POST['nickname'];
        $query="SELECT user_id FROM app_user WHERE user_email='{$email}' and user_nickname='{$nickname}'";
        $res=mysqli_query($db->connect(),$query);
        $red=mysqli_fetch_assoc($res);
        $followed_user_id=$red['user_id'];
        $queryForFollowingStatus="SELECT following_status FROM follower WHERE following_user_id={$following_user_id} AND followed_user_id={$followed_user_id}";
        $resForFollowingStatus=mysqli_query($db->connect(),$queryForFollowingStatus);
        if(mysqli_num_rows($resForFollowingStatus)==0){
            $queryForFollow="CALL follow_user({$following_user_id},{$followed_user_id},1)";
            $resForFollow=mysqli_query($db->connect(),$queryForFollow);
            $response="Followed";
            }
        else{
            $row=mysqli_fetch_assoc($resForFollowingStatus);
            if($row['following_status']==0){
                $queryForFollowAgain="UPDATE follower SET following_status=1 WHERE following_user_id={$following_user_id} and followed_user_id={$followed_user_id}";
                $resForFollowAgain=mysqli_query($db->connect(),$queryForFollowAgain);
                $response="Followed";
            }
            else if($row['following_status']==1){
                $response="already follow";
            }
            }
       
        }
    echo $response;
    }
    

    if($fun=="search"){
        echo"";
        if(isset($_GET['input'])){
            $input=$_GET['input'];
            $type=substr($input,0,1);
            $input=substr($input,1);
            if($type=="."){
                echo"";
               $db=new Database();
                $dbc=$db->connect();
                $query=$dbc->prepare("CALL searchuser(?)");
                $query->bind_param("s",$input);
                $query->execute();
                $res=$query->get_result();
                if(mysqli_num_rows($res)==0){
                    echo"<div>User not found</div>";
                }else{
                    while($row=mysqli_fetch_assoc($res)){//moze se ostaviti ovde vrednost id da se redirektuje na user.php i tako imamo multypage shit a layout sa profile moze se iskorititi
                    echo"<div>{$row['user_name']} {$row['user_surname']} {$row['user_nickname']}</div><br><br>";
                }
                }
                $dbc->close();
    
            }elseif($type=="/"){
                $out="";
                echo $out;
                $db=new Database();
                $dbc=$db->connect();
                $query=$dbc->prepare("CALL searchtopic(?)");
                $query->bind_param("s",$input);
                $query->execute();
                $res=$query->get_result();
    
                if(mysqli_num_rows($res)==0){
                    $out="<div>Topic not found</div>";
                }else{
                    while($row=mysqli_fetch_assoc($res)){//moze se ostaviti ovde vrednost id da se redirektuje na user.php i tako imamo multypage shit a layout sa profile moze se iskorititi
                    $out.="<strong><div>{$row['category']}</strong> <br>". substr($row['caption'],0,40) ."   ".date('d.m.Y.',strtotime($row['created_datetime']))." </div><br>";
                }
                }
                echo $out;
                $dbc->close();
            }elseif($type=="#"){
                echo"keyword to be done";
            }
        }
    
    
    }

if($fun=="unfollow"){
    if(isset($_POST['following_user_id']) and isset($_POST['email']) and isset($_POST['nickname'])){
        $db=new Database();
        $following_user_id=$_POST['following_user_id'];
        $email=$_POST['email'];
        $nickname=$_POST['nickname'];
        $query="SELECT user_id FROM app_user WHERE user_email='{$email}' and user_nickname='{$nickname}'";
        $res=mysqli_query($db->connect(),$query);
        $red=mysqli_fetch_assoc($res);
        $followed_user_id=$red['user_id'];
        $queryForFollowingStatus="SELECT following_status FROM follower WHERE following_user_id={$following_user_id} AND followed_user_id={$followed_user_id}";
        $resForFollowingStatus=mysqli_query($db->connect(),$queryForFollowingStatus);
        $row=mysqli_fetch_assoc($resForFollowingStatus);
        if($row['following_status']==1){
            $queryForUnfollow="CALL unfollow_user({$following_user_id},{$followed_user_id})";
            $resForUnfollow=mysqli_query($db->connect(),$queryForUnfollow);
            $response="Unfollowed successfully";
        }
    }
    echo $response;
}
if($fun=="like"){
    if(isset($_GET['postid']) and isset($_GET['userid'])){
        $postid=$_GET['postid'];
        $userid=$_GET['userid'];
        $db=new Database();
        $flag=0;
        
        $dbc=$db->connect();
        $query=$dbc->prepare("Call checklike(?,?)");
        $query->bind_param("ii",$postid,$userid);
        $query->execute();
        $res=$query->get_result();
        $numrows=mysqli_num_rows($res);
        if($numrows==0){
           $flag=1; 
           echo"br redova $numrows<br>";//not liked 
        }else if($numrows!=0){
            $flag=2; //liked
            echo"br redova $numrows<br>";
           
        }
        $dbc->close();
         
        if($flag==1){
        
            $dbc=$db->connect();
            $query=$dbc->prepare("call insertlike(?,?)");
            $query->bind_param("ii",$postid,$userid); 
            $query->execute();
            $dbc->close();//ubacivanje like u bazu
            $numlikes=Post::getlikes($postid); 
            echo"$numlikes";    //ponovno prebrojavanje
        }else if($flag==2){
            $dbc=$db->connect();
            $query=$dbc->prepare("call deletelike(?,?)");
            $query->bind_param("ii",$postid,$userid); 
            $query->execute();
            $dbc->close();//brisanje iz baze
            $numlikes=Post::getlikes($postid); 
            echo"$numlikes"; 
        }

    }
}

if($fun=="sortByCategory"){
    if(isset($_GET['selected'])){
        $db=new Database();
        $category=$_GET['selected'];
        $following_user_id=$_GET['following_user_id'];
        $query="CALL sortByCategory({$following_user_id},'{$category}')";
        $res=mysqli_query($db->connect(),$query);
        if(mysqli_num_rows($res)>0){
            $red=mysqli_fetch_assoc($res);
            $response="<div>{$red['user_nickname']}<br>{$red['category']}<br>{$red['caption']}<br>{$red['created_datetime']}</div><hr>";
    
        }
        else{
            $response="No results found.";
        }
       
    }
    echo $response;
}


?>