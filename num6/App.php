<?php
require_once 'RestApiClient.php';

$apiClient = new RestApiClient(
    'https://jsonplaceholder.typicode.com',
    'test_user',  
    'test_pass'   
);

// 1. Получение списка комментариев (первые 5)
echo "=== Получение списка комментариев ===\n";
$comments = $apiClient->get('/comments?_limit=5');

if ($comments['success']) {
    echo "Последние 5 комментариев:\n";
    foreach ($comments['data'] as $comment) {
        echo "✉️ [{$comment['id']}] {$comment['name']}\n";
        echo "   {$comment['body']}\n\n";
    }
} else {
    echo "Ошибка при запросе: {$comments['status']}\n";
    if ($comments['error']) {
        echo "Детали: {$comments['error']}\n";
    }
}

// 2. Создание нового комментария
echo "\n=== Создание нового комментария ===\n";
$newComment = [
    'postId' => 1,
    'name' => 'API Test Comment',
    'email' => 'api.test@example.com',
    'body' => 'Этот комментарий создан через REST API клиент'
];

$createResult = $apiClient->post('/comments', $newComment);

if ($createResult['success']) {
    echo "✅ Комментарий успешно создан!\n";
    echo "ID нового комментария: {$createResult['data']['id']}\n";
    echo "Email автора: {$createResult['data']['email']}\n";
} else {
    echo "❌ Ошибка при создании: {$createResult['status']}\n";
}

// 3. Обновление существующего комментария
echo "\n=== Обновление комментария (ID: 1) ===\n";
$updatedComment = [
    'name' => 'Updated Comment',
    'body' => 'Этот комментарий был обновлен через API'
];

$updateResult = $apiClient->put('/comments/1', $updatedComment);

if ($updateResult['success']) {
    echo "🔄 Комментарий успешно обновлен!\n";
    echo "Новое содержимое: {$updateResult['data']['body']}\n";
} else {
    echo "❌ Ошибка при обновлении: {$updateResult['status']}\n";
}

// 4. Удаление комментария
echo "\n=== Удаление комментария (ID: 1) ===\n";
$deleteResult = $apiClient->delete('/comments/1');

if ($deleteResult['success']) {
    echo "🗑️ Комментарий успешно удален!\n";
} else {
    echo "❌ Ошибка при удалении: {$deleteResult['status']}\n";
    if ($deleteResult['error']) {
        echo "Детали: {$deleteResult['error']}\n";
    }
}

echo "\n=== Статистика запросов ===\n";
echo "Всего выполнено запросов: 4\n";
echo "Успешных: " . 
    ($comments['success'] ? 1 : 0) + 
    ($createResult['success'] ? 1 : 0) + 
    ($updateResult['success'] ? 1 : 0) + 
    ($deleteResult['success'] ? 1 : 0) . "\n";