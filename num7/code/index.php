<?php
// Конфигурация базы данных
define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASS', 'helloworld');
define('DB_NAME', 'web');

// Установка соединения с базой данных
try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Обработка формы добавления объявления
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submit_ad'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if ($email && $title && $category && $description) {
        $stmt = $db->prepare("INSERT INTO ads (email, title, category, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $title, $category, $description);
        $stmt->execute();
        $stmt->close();
        
        // Перенаправление для предотвращения повторной отправки формы
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Получение списка объявлений
$ads = [];
$result = $db->query("SELECT * FROM ads ORDER BY created_at DESC");
if ($result) {
    $ads = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

$db->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доска объявлений</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        textarea { min-height: 100px; }
        button { background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
        .ad-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .ad-title { color: #333; margin-top: 0; }
        .ad-meta { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>Доска объявлений</h1>
    
    <section class="ad-form">
        <h2>Добавить новое объявление</h2>
        <form method="post">
            <div class="form-group">
                <label for="email">Ваш Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="category">Категория:</label>
                <select id="category" name="category" required>
                    <option value="">-- Выберите категорию --</option>
                    <option value="Техника">Техника</option>
                    <option value="Недвижимость">Недвижимость</option>
                    <option value="Транспорт">Транспорт</option>
                    <option value="Работа">Работа</option>
                    <option value="Услуги">Услуги</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="title">Заголовок объявления:</label>
                <input type="text" id="title" name="title" required maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            
            <button type="submit" name="submit_ad">Опубликовать</button>
        </form>
    </section>
    
    <section class="ads-list">
        <h2>Последние объявления</h2>
        
        <?php if (empty($ads)): ?>
            <p>Объявлений пока нет. Будьте первым!</p>
        <?php else: ?>
            <?php foreach ($ads as $ad): ?>
                <article class="ad-card">
                    <h3 class="ad-title"><?= htmlspecialchars($ad['title']) ?></h3>
                    <div class="ad-description"><?= nl2br(htmlspecialchars($ad['description'])) ?></div>
                    <div class="ad-meta">
                        Категория: <strong><?= htmlspecialchars($ad['category']) ?></strong> | 
                        Контакты: <?= htmlspecialchars($ad['email']) ?> | 
                        Дата: <?= date('d.m.Y H:i', strtotime($ad['created_at'])) ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>
</html>