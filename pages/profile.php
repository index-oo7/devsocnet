<?php
    session_start();
    include("../models/classes.php");
    $datab= new Database();
    $db=$datab->connect();
    $user=new User($db,$_SESSION['iduser']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo"{$user->getName()} {$user->getSurname()}"?></h1>
    <div class="about" style="background:gray; width:200px">
        <?php
           
            
           
            echo "<br>{$user->getName()} {$user->getSurname()}<br> Nickname:{$user->getNickname()}<br> email:{$user->getEmail()}<br>{$user->getInfo()}<br><button id='setupprofile' name='setuppprofile'>Change data</a>"; //ovde ajax da se uradi za izmenu podataka o korisniku

            
        
        ?>
    </div>
    <div class="posts" style="float:left;width:900px;background:lightblue">
                <div>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="category" id="category" placeholder="Topic"><button name="postit" type="submit">Post</button>
                    <textarea name="caption" rows="5" cols="50" placeholder="Whats on ur mind???"></textarea>
                    <input type="file" name="file" id="file">
                    </form>
                    <?php

                        
                        if(isset($_POST['postit'])){
                            $category=$_POST['category'];
                            $caption = $_POST['caption'];
                            $userid=$_SESSION['iduser'];
                            $newpost= new Post($db,$userid,$caption,$category);
                            



                        }
                    
                    
                    
                    ?>
                </div>
                <div>
                        <h1>Your posts</h1>
                        <?php
                            $arr_posts=[2,6,7,8];//ovde mi baca commands out of sync jer pozivam iz baze da mi da idijeve

                            foreach($arr_posts as $el){
                              post::getpost($el,$db);
                            }
                        ?>
                </div>


    </div>
</body>
</html>