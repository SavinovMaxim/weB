<?php
session_start();
// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_data'] = [
        'last_name' => $_POST['last_name'],
        'first_name' => $_POST['first_name'],
        'age' => $_POST['age']
    ];
    header('Location: display.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ввод данных</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        form { display: grid; gap: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { padding: 8px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Введите ваши данные</h1>
    <form method="POST">
        <div>
            <label for="last_name">Фамилия:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>
        <div>
            <label for="first_name">Имя:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div>
            <label for="age">Возраст:</label>
            <input type="number" id="age" name="age" min="1" max="120" required>
        </div>
        <button type="submit">Сохранить</button>
    </form>
    
    <div style="margin-top: 30px; padding: 15px; background: #f5f5f5;">
        <h3>Информация о приложении:</h3>
        <p>Название: UserData Collector</p>
        <p>Версия: 1.0</p>
        <p>Рейтинг: ★★★★☆</p>
    </div>
</body>
</html>