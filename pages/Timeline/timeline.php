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
        <title>Timeline</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <script src="https://use.fontawesome.com/1d73bb3427.js"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="timeline.css">

    </head>
    <body>
        <div id="searchBar"><input class="input" name="text" placeholder="Search..." type="search"></div>

































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