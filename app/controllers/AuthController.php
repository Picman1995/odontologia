<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../helpers/Logger.php';

class AuthController {
    private Auth $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function showLoginForm(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['password'] ?? '';

        if (empty($email) || empty($senha)) {
            $_SESSION['login_error'] = 'Por favor, complete todos los campos.';
            Logger::auth('FAILED (Campos vazios)', $email);
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if ($this->auth->login($email, $senha)) {
            session_regenerate_id(true);
            Logger::auth('SUCCESS', $email);
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        } else {
            $_SESSION['login_error'] = 'Email o contraseña incorrectos.';
            Logger::auth('FAILED', $email);
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function logout(): void {
        $this->auth->logout();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
