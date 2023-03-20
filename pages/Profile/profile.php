<?php

    session_start();
    $sessionTimeout=2700;//45 min
    if(isset($_SESSION['lastlogin'])&&(time()-$_SESSION['lastlogin']>$sessionTimeout)){
      session_unset();
      session_destroy();
      header('Location: ../Login/login.php');
      exit();
    }else{
    include("../../models/classes.php");
    $datab= new Database();
    $user=new User($datab,$_SESSION['iduser']);
    $_SESSION['lastlogin']=time();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
    <title>Profile</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

  </head>

  <body>
    <div class="container">
      <div class = "header">
        <div class="row">
          <div class="col-md-4">
            <div class="profile-pic">
              <!-- src treba da bude lokacija do slike koju je postavio korisnik -->
              <img src="" alt="Profile Picture">
            </div>
          </div>
          <div class="col-md-8">
            <div class="profile-info">
              <h1><?php echo"{$user->getName()} {$user->getSurname()}"?></h1>
              <ul class="list-unstyled">
                <li><strong>Email:</strong><?php echo " {$user->getEmail()}";?></li>
                <!-- ovde eventualno mogu da idu followers, following, broj postova -->
              </ul>
              <p>
              <!-- PHP -->
              <?php
                echo "<label class='lblProfile'>Nickname:</label> {$user->getNickname()}<br>
                <label class='lblProfile'>Info:</label> {$user->getInfo()}<br>
                <button  type='button' class='btn btn-secondary' id='btnEdit' name='btnEdit'>Edit profile</a>
                <button  type='button' class='btn btn-secondary' id='btnFollow' name='btnFollow'>Follow</a>"; //ovde ajax da se uradi za izmenu podataka o korisniku
              ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    
    
      <div class="col-md-12">
        <div class="counts"> 
          <!-- Ovde idu samo count funkcije -->
          <p>Posts</p>
          <p>Followers</p>
          <p>Following</p>
        </div>


        <div class="adding">
          <form action="profile.php" method="post" enctype="multipart/form-data"><br>
          <input type="text" name="category" id="category" placeholder="Topic"><br>
          <textarea name="caption" rows="1" cols="50" placeholder="What's on your mind?"></textarea><br>
          <input type="file" name="file" id="file" value="Choose file"> <br>
          <!-- zameniti input dugme regularnim dugmetom i resiti upload u backendu -->
          <button name="btnPost" type="submit">Post</button>
          </form>
                <!-- PHP -->
          <?php
          if(isset($_POST['btnPost'])){
              $category=$_POST['category'];
              $caption = $_POST['caption'];
              $userid=$_SESSION['iduser'];
              $newpost= new Post($datab,$userid,$caption,$category);
          }                
          ?>

        </div>
        <div class = "works">
          <h1 class="col-md-4">Works</h1>
          <br><br>
          <!-- PHP -->
          <?php
            $arr_posts=$user->allposts($datab);//ovde mi baca commands out of sync jer pozivam iz baze da mi da idijeve
            foreach($arr_posts as $el){
              post::getpost($el,$datab);
              echo "<div id='commented{$el}'></div>";
              echo "<input type='text' name='commtxt{$el}' id='commtxt{$el}' placeholder='Comment'><br>
              <button id='btncomm' class='btn btn-outline-light' type='submit' onclick='Postcomm({$el},{$_SESSION['iduser']})'>Comment</button><hr>";
              //ovo this nece da mi prosledi element da bih ga u js uhvatio
              }
          ?>
        </div>
      </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="../../scripts/jquery.js"></script>
    <script src="../../scripts/ajaxcalls.js"></script>
  </body>
</html>