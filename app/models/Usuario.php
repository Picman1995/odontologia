<?php

require_once __DIR__ . '/../../config/Database.php';

class Usuario {
    private PDO $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO usuarios (nombre, email, clave, tipo, creado_en, actualizado_en)
                VALUES (:nombre, :email, :clave, :tipo, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':email' => $data['email'],
            ':clave' => password_hash($data['clave'], PASSWORD_DEFAULT),
            ':tipo' => $data['tipo'],
        ]);
    }

    public function changePassword(int $id, string $newPassword): bool {
        $sql = "UPDATE usuarios SET clave = :clave, actualizado_en = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':clave' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':id' => $id
        ]);
    }

    public function verifyPassword(int $id, string $password): bool {
        $stmt = $this->conn->prepare("SELECT clave FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario && password_verify($password, $usuario['clave']);
    }
}
