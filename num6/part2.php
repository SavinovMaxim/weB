<?php

// 1. GET-запрос с пользовательскими заголовками
$getCh = curl_init();

$getUrl = 'https://jsonplaceholder.typicode.com/comments';
curl_setopt($getCh, CURLOPT_URL, $getUrl);

$customHeaders = [
    'X-Custom-Data: SampleHeaderValue',
    'Accept-Language: en-US'
];

curl_setopt($getCh, CURLOPT_HTTPHEADER, $customHeaders);
curl_setopt($getCh, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($getCh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($getCh, CURLOPT_RETURNTRANSFER, 1);

$getResponse = curl_exec($getCh);

if (curl_errno($getCh)) {
    echo 'Произошла ошибка при GET-запросе: ' . curl_error($getCh);
}

curl_close($getCh);

echo "=== GET с заголовками ===\n";
echo $getResponse . "\n\n";

// 2. POST-запрос с JSON-данными
$postCh = curl_init();

$postUrl = 'https://jsonplaceholder.typicode.com/comments';
curl_setopt($postCh, CURLOPT_URL, $postUrl);

$postPayload = [
    'postId' => 15,
    'name' => 'API Test',
    'email' => 'api.test@example.com',
    'body' => 'Тестовый комментарий через JSON POST'
];

$jsonPayload = json_encode($postPayload);

curl_setopt($postCh, CURLOPT_POST, 1);
curl_setopt($postCh, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($postCh, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json; charset=UTF-8',
    'Content-Length: ' . strlen($jsonPayload)
]);
curl_setopt($postCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($postCh, CURLOPT_SSL_VERIFYPEER, 0);

$postResponse = curl_exec($postCh);

if (curl_errno($postCh)) {
    echo 'Ошибка POST-запроса: ' . curl_error($postCh);
}

curl_close($postCh);

echo "=== POST с JSON ===\n";
echo $postResponse . "\n\n";

// 3. GET-запрос с URL-параметрами
$paramCh = curl_init();

$baseUrl = 'https://jsonplaceholder.typicode.com/comments';

$queryParams = [
    'postId' => 5,
    '_limit' => 3
];

$fullUrl = $baseUrl . '?' . http_build_query($queryParams);

curl_setopt($paramCh, CURLOPT_URL, $fullUrl);
curl_setopt($paramCh, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($paramCh, CURLOPT_SSL_VERIFYPEER, false);

$paramResponse = curl_exec($paramCh);

if (curl_errno($paramCh)) {
    echo 'Ошибка при запросе с параметрами: ' . curl_error($paramCh);
}

curl_close($paramCh);

echo "=== GET с параметрами ===\n";
echo $paramResponse . "\n";

echo "\n=== Информация о запросах ===\n";
echo "GET запрос: " . strlen($getResponse) . " байт\n";
echo "POST запрос: " . strlen($postResponse) . " байт\n";
echo "GET с параметрами: " . strlen($paramResponse) . " байт\n";
?>