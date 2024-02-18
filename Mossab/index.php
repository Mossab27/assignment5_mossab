<?php
    require_once './php_models/user_model.php';
    require_once './php_models/user_sql.php';
    require_once './DataBase/DataBase_Connection.php';
    require_once './php_models/auth.php';
    require_once './helper/session_helper.php';
    SessionHelper::start();
    $meessage = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST)) {
        try {
            $auth = new Auth(new DataBase('localhost','root','','sms'));
            $newUser = new UserModel();
            $newUser->setUserFromPostArray($_POST);
            $result = $auth->signup($newUser);
            if ($result) {
                SessionHelper::set('fname',$newUser->getFirstName());
                SessionHelper::set('lname',$newUser->getLastName());
                header("Location: Home.php");
                exit();
            }
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }
    }else{
        $meessage = 'NO data input';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Sing Up</title>
    <link rel="stylesheet" href="./style.css">
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
            <div class="serch">
                <img src="img/magnifying-glass.png">
                <input type="text" placeholder="serch ...">
            </div>
        </div>
    </nav>
    <div class="Sing_Up">
        <h1>Sing Up </h1>
        <h4>its free and only takes a minute</h4> 
        <form action="" method="post">
            <label>First Name</label>
            <input type="text" placeholder="" name="fname">
            <label>Last Name</label>
            <input type="text" placeholder="" name="lname">
            <label>DOB</label>
            <input type="date" placeholder="" name="dob">
            <label>Email</label>
            <input type="email" placeholder="" name="email">
            <label>PassWord</label>
            <input type="password" placeholder="" name="password">
            <label>Confirm PassWord</label>
            <input type="password" placeholder="" name>
            <input type="submit" value="Submit">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && strlen($meessage) !== 0) {
                echo "<p>$message</p>";
        }
        ?>
        <p>By clicking the Sing up button , you agree to our <br>
        <a href="#">Terms and Condition</a> and <a href="#">Policy privacy</a>
        </p>
    </div>
    <p class="para2">i have account <a href="./login.php">Login</a> </p>
</body>
</html>