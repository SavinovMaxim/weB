<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анализатор текста на PHP</title>
    <style>
        textarea {width: 100%; height: 150px;}
        button {margin-top: 14px;}
        
    </style>
</head>
<body>
    <form method="post">
        <textarea name="text"><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea><br>
        <button type="submit">Подсчитать</button>
    </form>
    
    <?php
    if (isset($_POST['analyze']) {
        $text = $_POST['text'] ?? '';
        
        // Подсчет символов
        $charCount = mb_strlen($text);
        
        // Подсчет слов
        $words = preg_split('/\s+/', trim($text));
        $wordCount = count(array_filter($words, function($word) {
            return !empty($word);
        });
        
        // Подсчет URL
        preg_match_all('/(https?:\/\/[^\s]+)|(www\.[^\s]+)/i', $text, $urlMatches);
        $urlCount = count(array_filter($urlMatches[0]));
        
        // Вывод результатов
        echo '<p>Количество символов: ' . $charCount . '</p>';
        echo '<p>Количество слов: ' . $wordCount . '</p>';
        echo '<p>Количество URL-адресов: ' . $urlCount . '</p>';
    }
    ?>
</body>
</html>