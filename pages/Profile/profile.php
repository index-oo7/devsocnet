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
          
          <?php
          $idUser=$_SESSION['iduser'];
          $databa= mysqli_connect("localhost","root","","project_database");
          $qry="SELECT fun_num_of_posts({$idUser}) as num_of_posts";
          $rs=mysqli_query($databa,$qry);
          $row=mysqli_fetch_assoc($rs);
          $num_of_posts=$row['num_of_posts'];
          echo "<p>Posts: ".$num_of_posts ."</p>";

          $query="SELECT fun_num_of_followers({$idUser}) as num_of_followers";
          $res=mysqli_query($databa,$query);
          $red = mysqli_fetch_assoc($res);
          $num_of_followers=$red['num_of_followers'];
          echo "<p>Followers: ".$num_of_followers. "</p>";
           
          $query1="SELECT fun_num_of_followed({$idUser}) as num_of_followed";
          $res1=mysqli_query($databa,$query1);
          $red1 = mysqli_fetch_assoc($res1);
          $num_of_followed=$red1['num_of_followed'];
          echo " <p>Following: ".$num_of_followed."</p>";
          mysqli_close($databa);

          ?>
          
         
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
           <?php echo "<button id='btnSubmitChanges' name='btnSubmitChanges' class='btn btn-outline-light' onclick='ChangeInfo({$_SESSION['iduser']})'>Save changes</button>"?>
            
          </form>
          <div id="response"></div> 
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
              $caption = $_POST['caption'] ;
              $userid=$_SESSION['iduser'];
                  if(isset($_FILES['file'])){
                  $uploaded=$_FILES['file']['name'];
                  $targetdir="../../uploads/";
                  $file=$targetdir. basename($uploaded);
                  $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                  if(move_uploaded_file($_FILES['file']['tmp_name'],$file)){
                    $newpost=new Post($datab,$userid,$caption,$category,$file,$file_ext);
                  }else{ 
                    $newpost= new Post($datab,$userid,$caption,$category);}
                  }
             
            }
            header('Location: ../Profile/profile.php');
          }                
          ?>

        </div>

       
        <!-- Background is shadow shown everytime user invokes popup window -->
        <div id="background"></div>

        <!-- Initial comment display -->
        <div id="commsecc" class="windowComment">komentariii</div>

        <div id = "works">
          <h1 class="col-md-4">Works</h1>
          <br><br>
          
          <?php
            $arr_posts=$user->allposts($datab);
            foreach($arr_posts as $el){
              post::getpost($el,$datab);
              echo"<button id='btncomments' onclick='allcomments({$el}); ShowComments()'><i class='fas fa-comment'></i></button><hr>";
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