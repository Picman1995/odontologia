<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Funcionario.php';

class FuncionarioController {
    private Funcionario $funcionarioModel;

    public function __construct() {
        $this->funcionarioModel = new Funcionario();
    }

    public function index(): void {
        $funcionarios = $this->funcionarioModel->getAll();
        include __DIR__ . '/../views/empleados/index.php';
    }

    public function create(): void {
        include __DIR__ . '/../views/empleados/create.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'puesto' => $_POST['puesto'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'email' => $_POST['email'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'sexo' => $_POST['sexo'] ?? '',
                'ciudad' => $_POST['ciudad'] ?? '',
            ];
            $this->funcionarioModel->create($data);
            header('Location: '. BASE_URL .'/funcionarios');
            exit;
        }
    }

    public function edit(int $id): void {
        $funcionario = $this->funcionarioModel->find($id);
        if ($funcionario) {
            include __DIR__ . '/../views/empleados/edit.php';
        } else {
            echo "Empleado no encontrado.";
        }
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'puesto' => $_POST['puesto'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'email' => $_POST['email'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'sexo' => $_POST['sexo'] ?? '',
                'ciudad' => $_POST['ciudad'] ?? '',
            ];
            $this->funcionarioModel->update($id, $data);
            header('Location: '. BASE_URL .'/funcionarios');
            exit;
        }
    }

    public function delete(int $id): void {
        $this->funcionarioModel->delete($id);
        header('Location: '. BASE_URL .'/funcionarios');
        exit;
    }
}
