<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Log in</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post" class="form">
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

        $db= mysqli_connect("localhost","root","","project_database");
        $query="SELECT user_id FROM app_user where user_email like ('%{$email}%') and user_password='$password'";
        $rez=mysqli_query($db,$query);
        if(mysqli_num_rows($rez)==0){
            echo "<script>
            let warning = document.querySelector('.form');
            warning.innerHTML += `<br><br><div class='warning'><p>Account does not exist or the password is incorrect. Please <b><a href='../SignUp/SignUp.php'>SignUp</a></b><br></p></div>`;
            </script>";
        }else{
            $_SESSION['lastlogin']=time();
            $row=mysqli_fetch_array($rez,MYSQLI_ASSOC);
            $_SESSION['iduser']=$row['user_id']; //stavio sam u query da proveri da li postoji lik i da uzmem id toga da bi na landing page uspeo da ga prosledim kao id i po njemu da prikazujem podatke i bice globalan
            echo gettype($_SESSION['iduser']);
            header('Location: ../Profile/profile.php');
            exit;
        }
       }
    }
    
    ?>

</body>
</html>