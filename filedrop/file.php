<?php
// Получаем текущую директорию
$currentDir = __DIR__;

// Открываем директорию
$files = [];
if ($handle = opendir($currentDir)) {
    // Читаем файлы в директории
    while (false !== ($entry = readdir($handle))) {
        // Пропускаем текущую и родительскую директории
        if ($entry != "." && $entry != ".." && $entry != "index.php" && $entry != "styles.css" && $entry != "files.php") {
            $files[] = $entry;
        }
    }
    // Закрываем директорию
    closedir($handle);
}

// Проверяем, была ли отправлена форма для загрузки файла
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'upload') {
    // Обработка загрузки файла
    $uploadDir = './'; // Директория для загрузки файлов (корневая папка)
    $uploadOk = 1;

    // Проверка на существование файла, если файл загружен
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Получаем расширение файла
        $fileExtension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        // Генерируем случайное имя файла
        $randomFileName = uniqid() . uniqid() . uniqid() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $randomFileName;

        // Проверка на ошибки загрузки
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo "Файл был успешно загружен: <a href='$uploadFile'>$randomFileName</a><br>";
        } else {
            echo "Извините, произошла ошибка при загрузке вашего файла.";
        }
    } else {
        echo "Не был загружен файл.";
    }
}

// Проверяем, была ли отправлена форма для удаления файла
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $fileToDelete = htmlspecialchars($_POST['fileToDelete']);
    $filePath = './' . $fileToDelete;

    // Проверка, существует ли файл
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "Файл '$fileToDelete' был успешно удален.";
        } else {
            echo "Не удалось удалить файл '$fileToDelete'.";
        }
    } else {
        echo "Файл '$fileToDelete' не существует.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка и удаление файла</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Загрузить файл</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="file" name="file" required> <!-- Загрузка файла обязательна -->
        <input type="hidden" name="action" value="upload">
        <button type="submit">Загрузить</button>
    </form>

    <h2>Удалить файл</h2>
    <form method="post" action="">
        <input type="text" name="fileToDelete" placeholder="Имя файла для удаления" required>
        <input type="hidden" name="action" value="delete">
        <button type="submit">Удалить</button>
    </form>
<br>
 <div class="container">
        <h1>Список файлов</h1>
        <div class="posts">
            <?php if (empty($files)): ?>
                <div class="post">
                    <h2>Нет файлов в директории.</h2>
                </div>
            <?php else: ?>
                <?php foreach ($files as $file): ?>
                    <div class="post">
                        <h2><a href="<?php echo htmlspecialchars($file); ?>" style="color: white;"><?php echo htmlspecialchars($file); ?></a></h2>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
