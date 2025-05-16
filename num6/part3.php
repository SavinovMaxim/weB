<?php

$apiUrl = 'https://jsonplaceholder.typicode.com/comments/5';

$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($curl, CURLOPT_URL, $apiUrl); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); 

$apiResponse = curl_exec($curl); 

if(curl_errno($curl)) {
    echo 'cURL ошибка: ' . curl_error($curl); 
    curl_close($curl);
    exit; 
}

$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
curl_close($curl); 

// Обрабатываем ответ
switch($statusCode) {
    case 200: 
        $responseData = json_decode($apiResponse);
        
        if(json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON декодирование не удалось: ' . json_last_error_msg();
            exit;
        }
        
        echo "Успешный ответ (200):\n";
        print_r($responseData);
        break;
        
    case 404: 
        echo "Ошибка 404\n";
        echo "Ответ сервера: " . $apiResponse;
        break;
        
    case 500: 
        echo "Ошибка 500\n";
        echo "Детали: " . $apiResponse;
        break;
        
    default:
        if($statusCode >= 400 && $statusCode < 500) {
            echo "Клиентская ошибка ({$statusCode}):\n";
            echo $apiResponse;
        } elseif($statusCode >= 500) {
            echo "Серверная ошибка ({$statusCode}):\n";
            echo $apiResponse;
        } else {
            echo "Неожиданный HTTP код: {$statusCode}\n";
            echo "Ответ: " . $apiResponse;
        }
}

echo "\n\n=== Детали запроса ===\n";
echo "HTTP статус: {$statusCode}\n";
echo "Длина ответа: " . strlen($apiResponse) . " байт\n";
?>