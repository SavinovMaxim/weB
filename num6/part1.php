<?php


//GET-запрос
$getUrl = "https://jsonplaceholder.typicode.com/comments/5";
$getCh = curl_init();

// Настройка параметров GET-запроса
curl_setopt($getCh, CURLOPT_URL, $getUrl);
curl_setopt($getCh, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($getCh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($getCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($getCh, CURLOPT_HEADER, false);

$getResponse = curl_exec($getCh);

curl_close($getCh);

echo "=== GET Response ===\n";
echo $getResponse . "\n\n";

//POST-запрос

$postUrl = "https://jsonplaceholder.typicode.com/comments";
$postCh = curl_init();

$postData = [
    'postId' => 5,
    'name' => 'New Comment',
    'email' => 'user@example.net',
    'body' => 'This is a test comment created via cURL'
];

curl_setopt($postCh, CURLOPT_URL, $postUrl);
curl_setopt($postCh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($postCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($postCh, CURLOPT_POST, true);
curl_setopt($postCh, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($postCh, CURLOPT_POSTFIELDS, json_encode($postData));

$postResponse = curl_exec($postCh);

$postInfo = curl_getinfo($postCh);

curl_close($postCh);

echo "=== POST Response ===\n";
echo "HTTP Status: " . $postInfo['http_code'] . "\n";
echo $postResponse . "\n\n";

//PUT-запрос
$putUrl = "https://jsonplaceholder.typicode.com/comments/5";
$putCh = curl_init();

$putData = [
    'id' => 5,
    'postId' => 5,
    'name' => 'Updated Comment',
    'email' => 'updated@example.org',
    'body' => 'This comment has been modified via PUT request'
];

curl_setopt($putCh, CURLOPT_URL, $putUrl);
curl_setopt($putCh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($putCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($putCh, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($putCh, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($putCh, CURLOPT_POSTFIELDS, json_encode($putData));

$putResponse = curl_exec($putCh);
$putInfo = curl_getinfo($putCh);

curl_close($putCh);

echo "=== PUT Response ===\n";
echo "HTTP Status: " . $putInfo['http_code'] . "\n";
echo $putResponse . "\n\n";

//DELETE-запрос
$deleteUrl = "https://jsonplaceholder.typicode.com/comments/5";
$deleteCh = curl_init();

curl_setopt($deleteCh, CURLOPT_URL, $deleteUrl);
curl_setopt($deleteCh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($deleteCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($deleteCh, CURLOPT_CUSTOMREQUEST, 'DELETE');

$deleteResponse = curl_exec($deleteCh);
$deleteInfo = curl_getinfo($deleteCh);

if(curl_errno($deleteCh)) {
    echo 'cURL Error: ' . curl_error($deleteCh) . "\n";
}

curl_close($deleteCh);

echo "=== DELETE Response ===\n";
echo "HTTP Status: " . $deleteInfo['http_code'] . "\n";
echo $deleteResponse . "\n";

echo "\n=== Request Details ===\n";
echo "Total Time: " . $deleteInfo['total_time'] . " seconds\n";
echo "Request Size: " . $deleteInfo['request_size'] . " bytes\n";
?>