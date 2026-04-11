<?php
class ApiGateway {
    private $rateLimit = 100;
    private $requestCount = [];
    private $allowedIps = [];
    private $apiKeys = [];

    public function addAllowedIp(string $ip): void {
        $this->allowedIps[] = $ip;
    }

    public function addApiKey(string $key): void {
        $this->apiKeys[] = $key;
    }

    public function checkAuth(string $ip, ?string $apiKey): bool {
        if (!in_array($ip, $this->allowedIps)) return false;
        if (!in_array($apiKey, $this->apiKeys)) return false;
        return true;
    }

    public function checkRateLimit(string $ip): bool {
        $currentMinute = date('i');
        $key = $ip . '_' . $currentMinute;
        $this->requestCount[$key] = ($this->requestCount[$key] ?? 0) + 1;
        return $this->requestCount[$key] <= $this->rateLimit;
    }

    public function logRequest(string $endpoint, string $ip, int $status): void {
        $log = [
            'endpoint' => $endpoint,
            'ip' => $ip,
            'status' => $status,
            'time' => date('Y-m-d H:i:s')
        ];
        file_put_contents('./api_logs.log', json_encode($log) . PHP_EOL, FILE_APPEND);
    }

    public function response(int $code, mixed $data, string $msg = ''): array {
        return [
            'code' => $code,
            'message' => $msg,
            'data' => $data,
            'timestamp' => time()
        ];
    }
}
?>
