<?php
require_once __DIR__ . '/../../config/Database.php';

class Auth
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->connect();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $email, string $clave): bool
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($clave, $user['clave'])) {
            $_SESSION[SESSION_NAME] = [
                'id' => $user['id'],
                'name' => $user['nombre'],
                'email' => $user['email'],
                'type' => $user['tipo'],
            ];
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        unset($_SESSION[SESSION_NAME]);
        session_destroy();
    }

    public function isLogged(): bool
    {
        return isset($_SESSION[SESSION_NAME]);
    }

    public function getUser(): ?array
    {
        return $_SESSION[SESSION_NAME] ?? null;
    }

    public function getUserId(): ?int
    {
        return $this->getUser()['id'] ?? null;
    }

    public function getUserType(): ?string
    {
        return $this->getUser()['type'] ?? null;
    }

    public function isAdmin(): bool
    {
        return $this->getUserType() === 'admin';
    }

    public function isDentista(): bool
    {
        return $this->getUserType() === 'dentista';
    }

    /** Compatible con tipo 'empleado' en la base de datos */
    public function isFuncionario(): bool
    {
        return $this->getUserType() === 'empleado';
    }
}
