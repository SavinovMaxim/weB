<?php
class RestApiClient
{
    private string $baseUrl;
    private array $defaultHeaders = [];
    private array $authCredentials = [];

    public function __construct(string $apiBaseUrl, string $username = '', string $password = '')
    {
        $this->baseUrl = rtrim($apiBaseUrl, '/');
        
        $this->defaultHeaders = [
            'Accept: application/json',
            'Content-Type: application/json'
        ];
        
        if (!empty($username)) {
            $this->setBasicAuth($username, $password);
        }
    }

    public function setBasicAuth(string $username, string $password): void
    {
        $this->authCredentials = [
            'username' => $username,
            'password' => $password
        ];
    }

    private function sendRequest(
        string $method, 
        string $endpoint, 
        array $data = null
    ): array {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        $ch = curl_init($url);

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $this->defaultHeaders,
            CURLOPT_TIMEOUT => 30,
        ];

        if (!empty($this->authCredentials)) {
            $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
            $options[CURLOPT_USERPWD] = $this->authCredentials['username'] . ':' . $this->authCredentials['password'];
        }

        if (!empty($data)) {
            $jsonData = json_encode($data);
            $options[CURLOPT_POSTFIELDS] = $jsonData;
            $this->defaultHeaders[] = 'Content-Length: ' . strlen($jsonData);
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        $decodedResponse = null;
        if (!empty($response)) {
            $decodedResponse = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $decodedResponse = $response; // Возвращаем как есть, если не JSON
            }
        }

        return [
            'status' => $httpCode,
            'data' => $decodedResponse,
            'error' => $error ?: null,
            'success' => $httpCode >= 200 && $httpCode < 300
        ];
    }

    public function get(string $endpoint): array
    {
        return $this->sendRequest('GET', $endpoint);
    }

    public function post(string $endpoint, array $data): array
    {
        return $this->sendRequest('POST', $endpoint, $data);
    }

    public function put(string $endpoint, array $data): array
    {
        return $this->sendRequest('PUT', $endpoint, $data);
    }

    public function patch(string $endpoint, array $data): array
    {
        return $this->sendRequest('PATCH', $endpoint, $data);
    }

    public function delete(string $endpoint): array
    {
        return $this->sendRequest('DELETE', $endpoint);
    }
}