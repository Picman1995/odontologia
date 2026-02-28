<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Especialidade.php';

class EspecialidadeController {
    private Especialidade $especialidadeModel;

    public function __construct() {
        $this->especialidadeModel = new Especialidade();
    }

    public function index(): void {
        $especialidades = $this->especialidadeModel->getAll();
        include __DIR__ . '/../views/especialidades/index.php';
    }

    public function create(): void {
        include __DIR__ . '/../views/especialidades/create.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'descripcion' => $_POST['descripcion'] ?? ''
            ];
            $this->especialidadeModel->create($data);
            header('Location: '. BASE_URL .'/especialidades');
            exit;
        }
    }

    public function edit(int $id): void {
        $especialidade = $this->especialidadeModel->find($id);
        if ($especialidade) {
            include __DIR__ . '/../views/especialidades/edit.php';
        } else {
            echo "Especialidad no encontrada.";
        }
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'descripcion' => $_POST['descripcion'] ?? ''
            ];
            $this->especialidadeModel->update($id, $data);
            header('Location: '. BASE_URL .'/especialidades');
            exit;
        }
    }

    public function delete(int $id): void {
        $this->especialidadeModel->delete($id);
        header('Location: '. BASE_URL .'/especialidades');
        exit;
    }
}
