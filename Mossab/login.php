<?php
    require_once './php_models/user_model.php';
    require_once './php_models/user_sql.php';
    require_once './DataBase/DataBase_Connection.php';
    require_once './php_models/auth.php';
    require_once './helper/session_helper.php';
    SessionHelper::start();
    function areAllValuesEmpty($assocArray) {
        foreach ($assocArray as $value) {
            if (!empty($value)) {
                return false; // If any value is not empty, return false
            }
        }
        return true; // All values are empty
    }
    
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !areAllValuesEmpty($_POST)) {
        try {
            $auth = new Auth(new DataBase('localhost','root','','sms'));
            $newUser = new UserModel();
            $newUser->setUserFromPostArray($_POST);
            $result = $auth->login($newUser);
            if ($result->getID() != null) {
                SessionHelper::set('fname',$result->getFirstName());
                SessionHelper::set('lname',$result->getLastName());
                header("Location: Home.php");
                exit();
            }else{
                $message = "User is not found.";
            }

        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }
    }else{
        $message = 'NO data input';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <form action="" method="post">
            <label>Email :</label>
            <input type="email" placeholder="" name="email">
            <label>PassWord :</label>
            <input type="password" placeholder="" name="password">
            <input type="submit" value="Submit">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && strlen($message) !== 0) {
                echo "<p>$message</p>";
        }
        ?>
    </div>
    <p class="para2">not have account <a href="index.php">sing up here</a></p>
</body>
</html>