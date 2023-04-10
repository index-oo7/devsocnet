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
        <div class = "container">
            <div class = "col-md-12">
                <div id="searchBar">
                    <form id="search-form" method="GET" action="profile.php">
                     <input type="text" name="search" id="search" placeholder=" .user /topic #keyword">
                     <button type="submit" id="btnSearch" onclick="Search()" ><i class="fas fa-search"></i></button>
                    </form>
                    <div id="searchresults">

                    </div>    
                
                    
            </div>
            <div class = "TimelinePost">postovi
            <?php
            $dbCategory=$datab->connect();
            $queryForCategories="SELECT DISTINCT category FROM post";
            $result=mysqli_query($dbCategory,$queryForCategories);
            ?> 
            <form method="post">     
<select id="selectCategory" >
    <option value=0>--Choose category--</option>
    <?php
        while($row=mysqli_fetch_assoc($result)){
            echo "<option value='" .$row["category"]. "'>".$row["category"]."</option>";
        }
    ?>
</select>  
<?php echo "<button type='submit' onclick='getSelectedData({$_SESSION['iduser']})'>Sort</button>"?>
    </form>  

                <?php
                $ids=array();
                $dbc=$datab->connect();
                $query=$dbc->prepare("CALL ifollowthem(?)");
                $query->bind_param("i",$_SESSION['iduser']);
                $query->execute();
                $res=$query->get_result();
                while($row=mysqli_fetch_assoc($res)){
                    array_push($ids,$row['following_user_id']);
                }
                $dbc->close();
                $users=array();
                foreach($ids as $uid){
                    $userin=new User($datab,$uid);
                    array_push($users,$userin);
                }
                 //mozes ovde da koristis od posta vrv created time samo vidi ovo $el to ti je post id i po tome mozes da uvatis niz ili kako vec hoces ili direktno u bazi moze da se to sortira po datumu ono order by asc..
                foreach($users as $u){                 
                    $arr_posts=$u->allposts($datab);
                    foreach($arr_posts as $el){
                        echo"<br>{$u->getNickname()}<br>";
                      post::getpost($el,$datab);
                     
                      $numlikes=Post::getlikes($el);
                      echo"<button id='btncomments' onclick='allcomments({$el}); ShowComments()'><i class='fas fa-comment'></i></button><div id='likecounter{$el}' name='likecounter'>{$numlikes}</div><button onclick='Like({$el},{$_SESSION['iduser']})'>like</button><hr><br>";
                    }
                }

                ?>
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
    <!-- <script src="script.js"></script> -->
    </body>
</html>