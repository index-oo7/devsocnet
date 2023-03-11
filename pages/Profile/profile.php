<?php
    session_start();
    include("../../models/classes.php");
    
    $datab= new Database();
    $user=new User($datab,$_SESSION['iduser']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Minimalistic Social Media Profile</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>



<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="profile-pic">
          <img src="https://via.placeholder.com/150" alt="Profile Picture">
        </div>
      </div>
      <div class="col-md-8">
        <div class="profile-info">
          <h1><?php echo"{$user->getName()} {$user->getSurname()}"?></h1>
          <ul class="list-unstyled">
            <li><strong>Email:</strong><?php echo " {$user->getEmail()}";?></li>
          </ul>
          <p>
          <?php
            echo "<label class='lblProfile'>Nickname:</label> {$user->getNickname()}<br>
            <label class='lblProfile'>Info:</label> {$user->getInfo()}<br>
            <button id='setupprofile' name='setuppprofile'>Change data</a>"; //ovde ajax da se uradi za izmenu podataka o korisniku
          ?>
          </p>
        </div>
      </div>
    </div>
  </div>
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
                            $newpost= new Post($datab,$userid,$caption,$category);
                        }
                    
                    
                    
                    ?>
                </div>
                <div>
                        <h1>Your posts</h1>
                        <?php
                            
                            $arr_posts=$user->allposts($datab);//ovde mi baca commands out of sync jer pozivam iz baze da mi da idijeve

                            foreach($arr_posts as $el){
                              post::getpost($el,$datab);
                            }
                           

                        ?>
                </div>


    </div>


  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>