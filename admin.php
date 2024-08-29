<?php
// Проверяем, была ли отправлена форма для добавления поста
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $title = htmlspecialchars($_POST['title']);
    $content = nl2br(htmlspecialchars($_POST['content'])); // Преобразуем переносы строк

    // Обработка загрузки изображения (необязательная)
    $uploadDir = 'uploads/'; // Директория для загрузки изображений
    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Проверка на существование файла, если файл загружен
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Генерируем случайное имя файла
        $randomFileName = uniqid() . '.' . $imageFileType;
        $uploadFile = $uploadDir . $randomFileName;

        // Проверка типа файла
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Извините, только JPG, JPEG, PNG и GIF файлы разрешены.";
            $uploadOk = 0;
        }

        // Проверка на ошибки загрузки
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                // Сохраняем пост в файл с изображением
                $post = "<h2>$title</h2><img src='$uploadFile' alt='$title' style='max-width: 100%;'><p>$content</p><hr>";
                file_put_contents('posts.html', $post, FILE_APPEND);
                header("Location: /");
            } else {
                echo "Извините, произошла ошибка при загрузке вашего файла.";
            }
        }
    } else {
        // Сохраняем пост в файл без изображения
        $post = "<h2>$title</h2><p>$content</p><hr>";
        file_put_contents('posts.html', $post, FILE_APPEND);
        header("Location: /");
    }
}
// Проверяем, была ли отправлена форма для удаления поста
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $titleToDelete = htmlspecialchars($_POST['titleToDelete']);

    // Загружаем существующие посты
    $posts = file_get_contents('posts.html');

    // Разбиваем посты на массив
    $postsArray = explode("<hr>", $posts);
    $newPostsArray = [];

    // Удаляем пост с указанным заголовком
    foreach ($postsArray as $post) {
        if (strpos($post, "<h2>$titleToDelete</h2>") === false) {
            $newPostsArray[] = $post;
        }
    }

    // Сохраняем обновленный список постов
    file_put_contents('posts.html', implode("<hr>", $newPostsArray));
    header("Location: /");
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
</head>
<body>
    <h2>Добавить новую запись</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Название записи" required>
        <textarea name="content" placeholder="Текст записи" required></textarea>
        <input type="file" name="image" accept="image/*"> <!-- Загрузка изображения теперь необязательна -->
        <input type="hidden" name="action" value="add">
        <button type="submit">Опубликовать</button>
    </form>

    <h2>Удалить запись</h2>
    <form method="post" action="">
        <input type="text" name="titleToDelete" placeholder="Название записи для удаления" required>
        <input type="hidden" name="action" value="delete">
        <button type="submit">Удалить</button>
    </form>

    <h2>Существующие записи</h2>
    <div>
        <?php echo $posts; ?>
    </div>
</body>
</html>
