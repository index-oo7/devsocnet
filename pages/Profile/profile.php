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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://use.fontawesome.com/1d73bb3427.js"></script>
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
          <div class="col-md-4">
            <div class="profile-info">
              <h1><?php echo"{$user->getName()} {$user->getSurname()}"?></h1>
              <ul class="list-unstyled">
                <li><strong>Email:</strong><?php echo "{$user->getEmail()}";?></li>
              </ul>
              <p>

              <?php
                echo "<label class='lblProfile'>Nickname:</label> {$user->getNickname()}<br>
                <label class='lblProfile'>Info:</label> {$user->getInfo()}<br>
                <button  type='button' class='btn btn-secondary' id='btnEdit' name='btnEdit'>Edit profile</a>
                <button  type='button' class='btn btn-secondary' id='btnFollow' name='btnFollow'>Follow</a>"; 
                //ovde ajax da se uradi za izmenu podataka o korisniku
              ?>
              </p>
              </div>
          </div>
          <div class="col-md-4">
            <div class="post">
              <button id="btnPost" name="btnPost" class="btnTransparent"><i class="fa-regular fa-folder-open fa-6x"></i></button>
            </div>
          </div>
        </div>
      </div>
    
    
      <div class="col-md-12">
        <div id="counts"> 
          <p>Posts</p>
          <p>Followers </p>
          <p>Following</p>
          <!-- Dodati broj pratilaca, broj zapraćenih profila i broj objava uz pomoć funkcija iz mySQL-a -->
        </div>

        <div id="editing" class="window">

          <form method="post">
            <label for="name">Change name:</label>
            <input type="text" name="name" id="name" value='<?php echo"{$user->getName()}"?>'><br>
            <label for="surname">Change surname:</label>
            <input type="text" name="surname" id="surname" value='<?php echo"{$user->getSurname()}"?>'><br>
            <label for="nickname">Change nick:</label>
            <input type="text" name="nickname" id="nickname" value='<?php echo"{$user->getNickname()}"?>'><br>
            <label for="info">Change info:</label>
            <textarea name="info" id="info" ><?php echo"{$user->getInfo()}"?></textarea><br><br>
            <button id="btnSubmitChanges" name="btnSubmitChanges" class='btn btn-outline-light' >Save changes</button>
          </form>

        </div>

        <div id="adding" class="window">
          
          <form action="profile.php" method="post" enctype="multipart/form-data"><br>
          <input type="text" name="category" id="category" placeholder="Topic" required><br>
          <textarea name="caption" rows="1" cols="50" placeholder="What's on your mind?" required></textarea><br>
          <input type="file" name="file" id="file" value="Choose file"> <br><br>
          <button name="btnAdd" type="submit" class='btn btn-outline-light'>Post</button>
          </form>
                
          <?php
          if(isset($_POST['btnAdd'])){
            if($_POST['category']!="" && $_POST['caption']!=""){
              $category=$_POST['category'];
              $caption = $_POST['caption'];
              $userid=$_SESSION['iduser'];
              $newpost= new Post($datab,$userid,$caption,$category);
            }
          }                
          ?>

        </div>

        <!-- Background is shadow shown everytime user invokes popup window -->
        <div id="background"></div>

        <div id = "works">
          <h1 class="col-md-4">Works</h1>
          <br><br>

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
  

    <!-- Files handling ajax communication -->
    <script src="../../scripts/jquery.js"></script>
    <script src="../../scripts/ajaxcalls.js"></script>

    <!-- Script file handling popup windows -->
    <script src="script.js"></script>
  </body>
</html>