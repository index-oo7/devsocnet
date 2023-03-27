<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <title>SignUp</title>
</head>
<body>
    <div class="container">
        <form action="SignUp.php" method="post">
          <h1>SignUp</h1>
          <label for="firstName">First Name:</label>
          <input type="text" id="firstName" name="firstName" required>
          <label for="lastName">Last Name:</label>
          <input type="text" id="lastName" name="lastName" required>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
          <button type="submit" name="btnSubmit">Sign Up</button>
          <br><br>
          <div class="warning"><p>Already have an account?  <b><a href='../Login/Login.php'>Log in</a></b><br></p></div>
        </form>
      </div>
            <!--AUTOGENERATING USERNAME  -->
      <?php
        if(isset($_POST['btnSubmit'])){
            if($_POST['firstName']!="" and $_POST['lastName']!="" and $_POST['email']!="" and $_POST['password']!=""){

                $firstName=$_POST['firstName'];
                $lastName=$_POST['lastName'];
                $email=$_POST['email'];
                $password=$_POST['password'];

                $db= mysqli_connect("localhost","root","","project_database"); 
                mysqli_query($db,"SET NAMES utf8");
                
                $upit="INSERT INTO app_user (user_name,user_surname,user_email,user_password) values ('$firstName','$lastName','$email','$password')";
                $rez=mysqli_query($db,$upit);
                mysqli_close($db);
            }
        }
        
    ?>
</body>
</html>