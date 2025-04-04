<?php
session_start();

// Проверяем, есть ли данные в сессии
if (!isset($_SESSION['user_data'])) {
    header('Location: form.php');
    exit;
}

$userData = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваши данные</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .user-data { background: #f9f9f9; padding: 20px; margin-bottom: 20px; }
        .app-info { background: #f0f8ff; padding: 15px; }
    </style>
</head>
<body>
    <h1>Ваши данные</h1>
    
    <div class="user-data">
        <p><strong>Фамилия:</strong> <?= htmlspecialchars($userData['last_name']) ?></p>
        <p><strong>Имя:</strong> <?= htmlspecialchars($userData['first_name']) ?></p>
        <p><strong>Возраст:</strong> <?= htmlspecialchars($userData['age']) ?></p>
    </div>
    
    <div class="app-info">
        <h3>Информация о приложении:</h3>
        <p><strong>Название:</strong> UserData Collector</p>
        <p><strong>Версия:</strong> 1.0</p>
        <p><strong>Рейтинг:</strong> ★★★★☆ (4.0/5.0)</p>
    </div>
    
    <p><a href="form.php">Вернуться к форме</a></p>
</body>
</html>