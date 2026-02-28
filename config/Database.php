<?php

require_once __DIR__ . '/config.php';

class Database {
    private ?PDO $conn = null;

    public function connect(): PDO {
        if ($this->conn === null) {
            try {
                $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";options=--client_encoding=UTF8";
                $this->conn = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
