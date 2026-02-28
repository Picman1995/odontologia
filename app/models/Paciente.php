<?php

require_once __DIR__ . '/../../config/Database.php';

class Paciente {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM pacientes");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO pacientes (
                    nombre, fecha_nacimiento, direccion, telefono, email,
                    cep, cpf, rg, sexo, ciudad, estado
                ) VALUES (
                    :nombre, :fechaNacimiento, :direccion, :telefono, :email,
                    :cep, :cpf, :rg, :sexo, :ciudad, :estado
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':fechaNacimiento' => $data['fecha_nacimiento'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':cep' => $data['cep'],
            ':cpf' => $data['cpf'],
            ':rg' => $data['rg'],
            ':sexo' => $data['sexo'],
            ':ciudad' => $data['ciudad'],
            ':estado' => $data['estado']
        ]);
    }

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM pacientes WHERE id_paciente = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE pacientes SET
                    nombre = :nombre,
                    fecha_nacimiento = :fechaNacimiento,
                    direccion = :direccion,
                    telefono = :telefono,
                    email = :email,
                    cep = :cep,
                    cpf = :cpf,
                    rg = :rg,
                    sexo = :sexo,
                    ciudad = :ciudad,
                    estado = :estado
                WHERE id_paciente = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':fechaNacimiento' => $data['fecha_nacimiento'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':cep' => $data['cep'],
            ':cpf' => $data['cpf'],
            ':rg' => $data['rg'],
            ':sexo' => $data['sexo'],
            ':ciudad' => $data['ciudad'],
            ':estado' => $data['estado'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $this->conn->prepare("DELETE FROM citas WHERE paciente_id = :id")->execute([':id' => $id]);
        $this->conn->prepare("DELETE FROM presupuestos WHERE paciente_id = :id")->execute([':id' => $id]);
        $this->conn->prepare("DELETE FROM recetas WHERE paciente_id = :id")->execute([':id' => $id]);
        $this->conn->prepare("DELETE FROM anamnesis WHERE paciente_id = :id")->execute([':id' => $id]);
        $stmt = $this->conn->prepare("DELETE FROM pacientes WHERE id_paciente = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function total(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM pacientes");
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function getPacienteAllInfoByLancamentoId($lancamentoId): array|false {
        $sql = "SELECT p.*
                FROM pacientes p
                INNER JOIN movimientos_contables l ON p.id_paciente = l.paciente_id
                WHERE l.id_movimiento = :movimiento_id
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':movimiento_id', $lancamentoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
