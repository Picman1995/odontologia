<?php
require_once __DIR__ . '/../../config/Database.php';

class Receita {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAll(): array {
        $sql = "SELECT r.*, p.nombre AS paciente, d.nombre AS dentista
                FROM recetas r
                JOIN pacientes p ON r.paciente_id = p.id_paciente
                JOIN dentistas d ON r.dentista_id = d.id_dentista
                ORDER BY r.fecha DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO recetas (paciente_id, dentista_id, fecha, contenido)
                VALUES (:paciente_id, :dentista_id, :fecha, :contenido)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':paciente_id' => $data['paciente_id'],
            ':dentista_id' => $data['dentista_id'],
            ':fecha' => $data['fecha'],
            ':contenido' => $data['contenido']
        ]);
    }

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM recetas WHERE id_receta = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE recetas SET paciente_id = :paciente_id, dentista_id = :dentista_id, fecha = :fecha, contenido = :contenido WHERE id_receta = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':paciente_id' => $data['paciente_id'],
            ':dentista_id' => $data['dentista_id'],
            ':fecha' => $data['fecha'],
            ':contenido' => $data['contenido'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM recetas WHERE id_receta = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function assinar(string $token, string $tipoRelatorio, array $dadosRelatorio): array|false {
        $stmtCheck = $this->conn->prepare("SELECT token, tipo_informe, datos_informe FROM firmas WHERE token = :token");
        $stmtCheck->execute([':token' => $token]);
        $firmaExistente = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        if ($firmaExistente) {
            return [
                'token' => $firmaExistente['token'],
                'tipo_relatorio' => $firmaExistente['tipo_informe'] ?? null,
                'dados_relatorio' => $firmaExistente['datos_informe'] ?? null
            ];
        }
        $sql = "INSERT INTO firmas (token, tipo_informe, datos_informe) 
                VALUES (:token, :tipoRelatorio, :dadosRelatorio)";
        $stmt = $this->conn->prepare($sql);
        $sucesso = $stmt->execute([
            ':token' => $token,
            ':tipoRelatorio' => $tipoRelatorio,
            ':dadosRelatorio' => json_encode($dadosRelatorio, JSON_UNESCAPED_UNICODE)
        ]);
        if ($sucesso) {
            return [
                'token' => $token,
                'tipo_relatorio' => $tipoRelatorio,
                'dados_relatorio' => json_encode($dadosRelatorio, JSON_UNESCAPED_UNICODE)
            ];
        }
        return false;
    }


}
