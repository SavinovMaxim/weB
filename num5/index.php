<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Доска объявлений</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        label { display: block; margin-bottom: 5px; }
        input, select, textarea { margin-bottom: 15px; width: 100%; padding: 8px; }
        button { background: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer; }
        button:hover { background: #45a049; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Доска объявлений</h1>
    
    <form action="save.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="category">Категория:</label>
        <select id="category" name="category" required>
            <option value="">-- Выберите категорию --</option>
            <option value="Спортивное питание">Спортивное питание</option>
            <option value="Витамины">Витамины</option>
            <option value="БАДы">БАДы</option>
        </select>
        
        <label for="title">Заголовок объявления:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="text">Текст объявления:</label>
        <textarea id="text" name="text" rows="4" required></textarea>
        
        <button type="submit">Добавить объявление</button>
    </form>
    
    <h2>Список объявлений</h2>
    <table>
        <thead>
            <tr>
                <th>Категория</th>
                <th>Заголовок</th>
                <th>Текст</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Функция для чтения объявлений из категории
            function readAdsFromCategory($category) {
                $ads = [];
                $dir = "categories/$category";
                if (is_dir($dir)) {
                    $files = scandir($dir);
                    foreach ($files as $file) {
                        if ($file != '.' && $file != '..') {
                            $title = str_replace('.txt', '', $file);
                            $content = file_get_contents("$dir/$file");
                            $email = '';
                            
                            // Извлекаем email из первой строки файла
                            $lines = explode("\n", $content, 2);
                            if (count($lines) > 0) {
                                $email = trim($lines[0]);
                                $content = count($lines) > 1 ? $lines[1] : '';
                            }
                            
                            $ads[] = [
                                'category' => $category,
                                'title' => $title,
                                'content' => $content,
                                'email' => $email
                            ];
                        }
                    }
                }
                return $ads;
            }
            
            // Получаем все объявления из всех категорий
            $allAds = [];
            $categories = ['Спортивное питание', 'Витамины', 'БАДы'];
            foreach ($categories as $category) {
                $allAds = array_merge($allAds, readAdsFromCategory($category));
            }
            
            // Выводим объявления в таблицу
            foreach ($allAds as $ad) {
                echo "<tr>";
                echo "<td>{$ad['category']}</td>";
                echo "<td>{$ad['title']}</td>";
                echo "<td>{$ad['content']}</td>";
                echo "<td>{$ad['email']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>