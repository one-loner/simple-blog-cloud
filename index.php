<?php
// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    // Сохраняем пост в файл
    $post = "<div class='post'><h2>$title</h2><p>$content</p></div>";
    file_put_contents('posts.html', $post, FILE_APPEND);
}

// Загружаем существующие посты
$posts = file_get_contents('posts.html');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standalone blog</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .post {
            border: 1px solid #ccc; /* Цвет рамки */
            padding: 10px; /* Отступы внутри рамки */
            margin: 10px 0; /* Отступы между постами */
            border-radius: 5px; /* Закругление углов */
            background-color: #f9f9f9; /* Цвет фона поста */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Standalone blog</h1>
        <h4>Decription</h4>
        <div class="posts">
            <?php echo $posts; ?>
        </div>
    </div>
</body>
</html>

