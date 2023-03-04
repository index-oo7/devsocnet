<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Log in</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
          <h1>Log In</h1>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>

          <button type="submit" name="btnSubmit">Log In</button>
        </form>
      </div>

      <!-- PHP -->
      <?php


       if(isset($_POST['btnSubmit'])){
        
        if(isset($_POST['email']) and isset($_POST['password'])){
        $email=$_POST['email'];
        $password=$_POST['password'];

        if($email == "" || $password == ""){
            echo "All input fields are required!!!";
        }
        

        $db= mysqli_connect("localhost","root","","project_database");
        $query="SELECT user_id FROM app_user where user_email like ('%{$email}%') and user_password like('%{$password}%')";
        $rez=mysqli_query($db,$query);
        if(mysqli_num_rows($rez)==0){
            echo "Account does not exist. Please SignUp <b><a href='../SignUp/SignUp.php'>here</a></b>";
        }else{
            $_SESSION['loggedin']=true;
            $row=mysqli_fetch_array($rez,MYSQLI_ASSOC);
            $_SESSION['iduser']=$row['user_id']; //stavio sam u query da proveri da li postoji lik i da uzmem id toga da bi na landing page uspeo da ga prosledim kao id i po njemu da prikazujem podatke i bice globalan
            echo gettype($_SESSION['iduser']);
            header('Location: ../profile.php');
            exit;
        }
       }
    }
    
    ?>
</body>
</html>