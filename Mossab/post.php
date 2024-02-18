<?php
require_once './DataBase/DataBase_Connection.php';
require_once './php_models/post_model.php';

  try {

     if (
      !isset($_POST['category_id']) || !isset($_POST['date'])
     || !isset($_POST['post']) || !isset($_POST['image'])
    ) {
      throw new Exception("<p>You have not entered all the required details.<br />
                        Please go back and try again.</p>");
    }
    // create short variable names
    $category_id = $_POST['category_id'];
    $date = $_POST['date'];
    $post = $_POST['post'];
    $image = $_POST['image'];
    $postArray = array(
    'category_id' => $category_id,
    'date' => $date,
    'post' => $post,
    'image' => $image
);
    //create a category object
    $post = new PostModel();
    $post->setPostFromPostArray($postArray);
    //create a list of books object
    $dob = new DataBase('localhost','root','','sms');
    //insert book into db
    $dob->insert('posts',$post->getProprtyArry());


  } catch (Exception $e) {
    //catch exception
    echo '<BR>Message: ' . $e->getMessage();
  }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="postPage.css">
    <title>post</title>
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
            
    
     <a href="search.php"><button type="button">search</button></a>
     <a href="myposts.php"><button type="button">myposts</button></a>
     <a href="showposts.php"><button type="button">showposts</button></a>
    
     
   
   

            </div>
            <div class="nav-usr-icon online">
                <img src="img/photo_2024-01-20_02-17-13.jpg" alt="erorr">
            </div>
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
        <div class="formdiv">
            <h1>Add Post</h1>
            <form action="" method="post">
                <label class="option" for="">Date<input name="date" class="input1" type="date"></label><br>
                <label for="" class="option">category
                    <select name="category_id" id="">
                <option value="1">علمي</option>
                <option value="2">ثقافي</option>
                <option value="3">رياضي</option>
                </select></label>
                <textarea type="text" name="post" ></textarea>
                <label for="" class="option">Upload Media</label>
                <input type="file" name="image" class="file-input">
                <ul>
                    <li><a href="#"><button class="button2" type="submit">Post</button></a></li>
                    <li><a href="#"><button class="button2" type="reset">Clear</button></a></li>
                </ul>
            </form>
        </div>
    </div>
    <!-- right-sidebar -->
    <div class="right-sidebar"></div>
    </div>  
</body>
</html>