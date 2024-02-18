<?php
    require_once './helper/session_helper.php';
    SessionHelper::start();
    $name = SessionHelper::get('fname').' '.SessionHelper::get('lname');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="./home.css">
</head>
<body>
    <nav>
        <div class="nav-left">
             <img src="img/sms (1).png" alt="logoo" class="logo">
             <ul>
                 <li><img src="img/notification.png" ></li>
                 <li><img src="img/sms.png" ></li>
                 <li><img src="img/video-camera.png" ></li>
             </ul>
        </div>
      
        <div class="nav-right">
        


            <div class="nav-usr-icon online">
                <img src="img/photo_2024-01-20_02-17-13.jpg" alt="erorr">
            </div>
              <?php if(SessionHelper::isValueSet('fname')&&SessionHelper::isValueSet('lname')){ ?>
        <div><button id="log-out-btn"><a href="./php_models/loggout_handler.php">Logout</a></button></div>
        <?php }?>
            <?php if(strlen($name)!==0){?>
            <p><?=$name?></p>
            <?php }?>

        </div>
    </nav>
    <!-- container -->
    <div class="container">
    <!-- left-sidebar -->
    <div class="left-sidebar">
        <div class="emp-links">
            <a href="#"><img src="img/megaphone.png">News</a>
            <a href="#"><img src="img/friends.png">Friends</a>
            <a href="#"><img src="img/multiple-users-silhouette.png">Groups</a>
            <a href="#"><img src="img/trolley.png">Market</a>
            <a href="#"><img src="img/play-button-arrowhead.png">Watch</a>
            <a href="#">see more</a>
        </div>
    </div>
    <!-- main-content -->
    <div class="main-content">
      <div class="page">
        <a href="index.php"><img src="img/signup.png">Sing Up</a>
        <a href="login.php"><img src="img/login.png">LogIn </a>
      
        <a href="post.php"><img src="img/post.png">Post</a>
      </div>
   
    </div>
    <div class="right-sidebar"></div>
    </div>
     
</body>
</html>