<?php
require_once './DataBase/DataBase_Connection.php';

// قم بفحص الطلب القادم من النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=sms;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

     
        $post_id_to_delete = $_POST['post_id'];

        // قم بكتابة استعلام SQL لحذف البوست
        $sql_delete_post = "DELETE FROM posts WHERE id = :post_id";
        $stmt_delete_post = $pdo->prepare($sql_delete_post);
        $stmt_delete_post->bindParam(':post_id', $post_id_to_delete, PDO::PARAM_INT);
        $stmt_delete_post->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$sql = "SELECT * FROM posts WHERE user_id = :user_id";
$user_id = 1; // قم بتعيين معرف المستخدم الفعلي هنا
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts</title>
</head>
<body>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div>
            <h2><?= $row['post'] ?></h2>
            <p>Date: <?= $row['date'] ?></p>
          
            <!-- إضافة نموذج الحذف -->
            <form action="myposts.php" method="post">
                <input type="hidden" name="post_id" value="<?= $row['id'] ?>">
                <button type="submit" name="delete_post">Delete Post</button>
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>
