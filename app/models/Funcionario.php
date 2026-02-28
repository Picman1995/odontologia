<?php

require_once __DIR__ . '/../../config/Database.php';

/** Modelo de empleados (tabla empleados) */
class Funcionario {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM empleados");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO empleados (
                    nombre, puesto, telefono, email, direccion, cep, cpf, rg,
                    sexo, ciudad, estado
                ) VALUES (
                    :nombre, :puesto, :telefono, :email, :direccion, :cep, :cpf, :rg,
                    :sexo, :ciudad, :estado
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':puesto' => $data['puesto'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':direccion' => $data['direccion'],
            ':cep' => $data['cep'],
            ':cpf' => $data['cpf'],
            ':rg' => $data['rg'],
            ':sexo' => $data['sexo'],
            ':ciudad' => $data['ciudad'],
            ':estado' => $data['estado']
        ]);
    }

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM empleados WHERE id_empleado = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE empleados SET
                    nombre = :nombre,
                    puesto = :puesto,
                    telefono = :telefono,
                    email = :email,
                    direccion = :direccion,
                    cep = :cep,
                    cpf = :cpf,
                    rg = :rg,
                    sexo = :sexo,
                    ciudad = :ciudad,
                    estado = :estado
                WHERE id_empleado = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':puesto' => $data['puesto'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':direccion' => $data['direccion'],
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
        $stmt = $this->conn->prepare("DELETE FROM empleados WHERE id_empleado = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function total(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM empleados");
        $result = $stmt->fetch();
        return (int) $result['total'];
    }
}
