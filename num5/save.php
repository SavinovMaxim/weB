<?php
// Проверяем, что все поля заполнены
if (empty($_POST['email']) || empty($_POST['category']) || empty($_POST['title']) || empty($_POST['text'])) {
    die("Все поля обязательны для заполнения.");
}

// Проверяем email
$email = trim($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Некорректный email адрес.");
}

// Подготавливаем данные
$category = trim($_POST['category']);
$title = trim($_POST['title']);
$text = trim($_POST['text']);

// Проверяем, что категория существует
$allowedCategories = ['Спортивное питание', 'Витамины', 'БАДы'];
if (!in_array($category, $allowedCategories)) {
    die("Недопустимая категория.");
}

// Создаем папку категории, если ее нет
if (!is_dir("categories/$category")) {
    mkdir("categories/$category", 0777, true);
}

// Очищаем название от недопустимых символов и заменяем пробелы на подчеркивания
$cleanTitle = preg_replace('/[^\w\s\-]/u', '', $title);
$cleanTitle = str_replace(' ', '_', $cleanTitle);
$filename = "categories/$category/$cleanTitle.txt";

// Сохраняем объявление в файл (email в первой строке)
$content = "$email\n$text";
file_put_contents($filename, $content);

// Перенаправляем обратно на главную страницу
header("Location: index.php");
exit;
?>