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
              <img src="https://via.placeholder.com/150" alt="Profile Picture">
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
                <button  type='button' class='btn btn-secondary' id='btnEdit' name='btnEdit'>Change data</a>"; //ovde ajax da se uradi za izmenu podataka o korisniku
              ?>

              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <form action="profile.php" method="post" enctype="multipart/form-data">
      <input type="text" name="category" id="category" placeholder="Topic"><button name="btnPost" type="submit">Post</button>
      <textarea name="caption" rows="5" cols="50" placeholder="What's on your mind?"></textarea>
      <input type="file" name="file" id="file">
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
        <div>
          <h1>Works</h1>
            <!-- PHP -->
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