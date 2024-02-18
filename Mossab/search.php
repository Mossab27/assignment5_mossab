<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>

    <div class="search-form">
        <form action="" method="post">
            <label for="search-type">Search by:</label>
            <select name="search-type" id="search-type">
                <option value="date">Date</option>
                <option value="category">Category</option>
                <option value="username">Username</option>
            </select>

            <label for="search-keyword">Keyword:</label>
            <input type="text" name="search-keyword" id="search-keyword">

            <button type="submit">Search</button>
        </form>
    </div>

    <table>
    <thead>
        <tr>
            <th>Post</th>
            <th>Category</th>
            <th>Date</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pdo = new PDO('mysql:host=localhost;dbname=sms;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Determine the search type
        $searchType = isset($_POST['search-type']) ? $_POST['search-type'] : '';
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';

        try {
            // Prepare the query based on the search type
            switch ($searchType) {
                case 'date':
                    $sql = "SELECT posts.*, categories.name AS category_name, COUNT(comments.id) AS comment_count
                            FROM posts 
                            JOIN categories ON posts.category_id = categories.id 
                            LEFT JOIN comments ON posts.id = comments.post_id
                            WHERE posts.date LIKE :keyword
                            GROUP BY posts.id";
                    break;
                case 'category':
                    $sql = "SELECT posts.*, categories.name AS category_name, COUNT(comments.id) AS comment_count
                            FROM posts 
                            JOIN categories ON posts.category_id = categories.id 
                            LEFT JOIN comments ON posts.id = comments.post_id
                            WHERE categories.name LIKE :keyword
                            GROUP BY posts.id";
                    break;
                case 'username':
                    $sql = "SELECT posts.*, categories.name AS category_name, COUNT(comments.id) AS comment_count
                            FROM posts 
                            JOIN users ON posts.user_id = users.id 
                            JOIN categories ON posts.category_id = categories.id 
                            LEFT JOIN comments ON posts.id = comments.post_id
                            WHERE users.fname LIKE :keyword OR users.lname LIKE :keyword
                            GROUP BY posts.id";
                    break;
                default:
                    $sql = "SELECT posts.*, categories.name AS category_name, COUNT(comments.id) AS comment_count
                            FROM posts 
                            JOIN categories ON posts.category_id = categories.id 
                            LEFT JOIN comments ON posts.id = comments.post_id
                            GROUP BY posts.id";
                    break;
            }

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $keyword . '%');
            if ($searchType === 'username') {
                $stmt->bindValue(':keyword2', '%' . $keyword . '%');
            }
            $stmt->execute();

            // Display the results in the table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['post']}</td>";
                echo "<td>{$row['category_name']}</td>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['comment_count']}</td>"; // Display comment count
                echo "</tr>";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </tbody>
</table>

</body>
</html>