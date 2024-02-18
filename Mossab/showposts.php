<?php
require_once './DataBase/DataBase_Connection.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=sms;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // استعلام لاسترجاع بيانات المنشورات واسم الشخص
    $sql = "SELECT posts.id, posts.user_id, posts.category_id, posts.date, posts.dob, posts.post, posts.image, users.fname, users.lname
            FROM posts
            LEFT JOIN users ON posts.user_id = users.id
            ORDER BY posts.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) { //تعامل مع الاستثناء
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="showPosts.css">
    <title>Show Posts</title>
</head>
<body>
  <!-- عرض المنشورات واسم الشخص وإمكانية التعليق -->
  <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div>
        <h2><?= $row['post'] ?></h2>
        <p>Date: <?= $row['date'] ?></p>
        <p>Posted by: <?= $row['fname'] . ' ' . $row['lname'] ?></p>


        <!-- نموذج إضافة تعليق -->
        <form action='addComment.php' method='post'>
            <input type='hidden' name='post_id' value='<?= $row['id'] ?>'>
            <textarea name='comment' placeholder='Add your comment'></textarea>
            <button type='submit'>Add Comment</button>
        </form>

        <!-- عرض التعليقات -->
        <?php
        $commentsSql = "SELECT * FROM comments WHERE post_id = :post_id";
        $commentsStmt = $pdo->prepare($commentsSql);
        $commentsStmt->bindParam(':post_id', $row['id'], PDO::PARAM_INT);
        $commentsStmt->execute();
        while ($commentRow = $commentsStmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <p><?= $commentRow['comment_text'] ?></p>
        <?php endwhile; ?>

        <!-- نموذج حذف المنشور -->
        <form action='deletepost.php' method='post'>
            <input type='hidden' name='post_id' value='<?= $row['id'] ?>'>
            <button type='submit' name='delete_post'>Delete Post</button>
        </form>
    </div>
<?php endwhile; ?>

</body>
</html>