<?php
session_start();
require_once './DataBase/DataBase_Connection.php';

try {
    // التحقق من إرسال نموذج التعليق
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_post'])) {
            $pdo = new PDO('mysql:host=localhost;dbname=sms;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $post_id = $_POST['post_id'];
            $sql = "DELETE FROM posts WHERE id = :post_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    $pdo = new PDO('mysql:host=localhost;dbname=sms;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // التحقق من وجود user_id في الجلسة
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // ابوستات المستخدم الحالي
    $sql = "SELECT `id`, `user_id`, `category_id`, `date`, `dob`, `post`, `image` FROM `posts` WHERE user_id = :user_id ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="showPosts.css">
    <title>My Posts</title>
</head>
<body>
    
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div>
            <h2><?= $row['post'] ?></h2>
            <p>Date: <?= date('Y-m-d H:i:s', strtotime($row['date'])) ?></p>
            <p><?= $row['content'] ?></p>
       
            <form action='myposts.php' method='post'>
                <input type='hidden' name='post_id' value='<?= $row['id'] ?>'>
                <button type='submit' name='delete_post'>Delete Post</button>
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>
