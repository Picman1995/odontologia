<?php
declare(strict_types=1);

class Logger {
    public static function auth(string $status, string $email): void {
        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $logMessage = "[$date] $status - Email: $email - IP: $ip" . PHP_EOL;

        $logDir = __DIR__ . '/../../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . '/auth.log';
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
