<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private Usuario $model;

    public function __construct() {
        $this->model = new Usuario();
    }

    public function create(): void {
        $this->authorize('admin');
        include __DIR__ . '/../views/usuarios/create.php';
    }

    public function store(): void {
        $this->authorize('admin');
    
        if (session_status() === PHP_SESSION_NONE) session_start();
    
        $tipo = $_POST['tipo'] ?? '';
            if ($tipo === 'funcionario') $tipo = 'empleado';
            $data = [
            'nombre' => $_POST['nombre'] ?? '',
            'email' => $_POST['email'] ?? '',
            'clave' => $_POST['clave'] ?? '',
            'tipo' => $tipo,
        ];
        if ($this->model->create($data)) {
            $_SESSION['success'] = 'Usuario creado correctamente.';
            header('Location: ' . BASE_URL . '/usuarios/create');
            exit;
        } else {
            $_SESSION['error'] = 'Error al crear el usuario. Intente de nuevo.';
            header('Location: ' . BASE_URL . '/usuarios/create');
            exit;
        }
    }
    

    public function changePasswordForm(): void {
        include __DIR__ . '/../views/usuarios/change_password.php';
    }

    public function changePassword(): void {
        $id = $_SESSION[SESSION_NAME]['id'];
        $claveActual = $_POST['clave_actual'] ?? '';
        $nuevaClave = $_POST['nueva_clave'] ?? '';

        if ($this->model->verifyPassword($id, $claveActual)) {
            $this->model->changePassword($id, $nuevaClave);
            $_SESSION['success'] = 'Clave cambiada correctamente.';
            header('Location: ' . BASE_URL . '/usuarios/change-password');
        } else {
            $_SESSION['error'] = "Clave actual incorrecta.";
            header('Location: ' . BASE_URL . '/usuarios/change-password');
        }
    }

    private function authorize(string $tipo): void {
        if ($_SESSION[SESSION_NAME]['type'] !== $tipo) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }
}
