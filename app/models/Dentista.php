<?php

require_once __DIR__ . '/../../config/Database.php';

class Dentista {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM dentistas");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO dentistas (
                    nombre, especialidad_id, telefono, email,
                    direccion, ciudad, matricula_profesional
                ) VALUES (
                    :nombre, :especialidadId, :telefono, :email,
                    :direccion, :ciudad, :matricula_profesional
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':especialidadId' => $data['especialidad_id'] !== '' ? $data['especialidad_id'] : null,
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':direccion' => $data['direccion'],
            ':ciudad' => $data['ciudad'],
            ':matricula_profesional' => (($data['matricula_profesional'] ?? '') !== '')
                ? $data['matricula_profesional']
                : null,
        ]);
    }

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM dentistas WHERE id_dentista = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE dentistas SET
                    nombre = :nombre,
                    especialidad_id = :especialidadId,
                    telefono = :telefono,
                    email = :email,
                    direccion = :direccion,
                    ciudad = :ciudad,
                    matricula_profesional = :matricula_profesional
                WHERE id_dentista = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':especialidadId' => $data['especialidad_id'] !== '' ? $data['especialidad_id'] : null,
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':direccion' => $data['direccion'],
            ':ciudad' => $data['ciudad'],
            ':matricula_profesional' => (($data['matricula_profesional'] ?? '') !== '')
                ? $data['matricula_profesional']
                : null,
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM dentistas WHERE id_dentista = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function total(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM dentistas");
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function getEspecialidadeNameById(int $id): string {
        $stmt = $this->conn->prepare("SELECT descripcion FROM especialidades WHERE id_especialidad = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ? $result['descripcion'] : 'Especialidad no encontrada';
    }
}
