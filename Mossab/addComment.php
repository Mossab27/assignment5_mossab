<?php
require_once './DataBase/DataBase_Connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
        $pdo = new PDO('mysql:host=localhost;dbname=sms;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];

        // إدخال التعليق في جدول التعليقات
        $sql = "INSERT INTO comments (post_id, comment_text) VALUES (:post_id, :comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();

        // إعادة توجيه المستخدم إلى نفس الصفحة بعد الإضافة
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
} catch (PDOException $e) {
   
    echo "Error: " . $e->getMessage();
}
?>
