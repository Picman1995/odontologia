<?php

require_once __DIR__ . '/../../config/Database.php';

class Anamnese {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM anamnesis");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO anamnesis (paciente_id, dentista_id, descripcion, fecha)
                VALUES (:pacienteId, :dentistaId, :descripcion, :fecha)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pacienteId' => $data['paciente_id'],
            ':dentistaId' => $data['dentista_id'],
            ':descripcion' => $data['descripcion'],
            ':fecha' => $data['fecha']
        ]);
    }

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM anamnesis WHERE id_anamnesis = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE anamnesis 
                SET paciente_id = :pacienteId, dentista_id = :dentistaId, descripcion = :descripcion, fecha = :fecha 
                WHERE id_anamnesis = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pacienteId' => $data['paciente_id'],
            ':dentistaId' => $data['dentista_id'],
            ':descripcion' => $data['descripcion'],
            ':fecha' => $data['fecha'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM anamnesis WHERE id_anamnesis = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function total(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM anamnesis");
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function getPacienteNameById(int $id): string {
        $stmt = $this->conn->prepare("SELECT nombre FROM pacientes WHERE id_paciente = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result ? $result['nombre'] : 'Paciente no encontrado';
    }

    public function getDentistaNameById(int $id): string {
        $stmt = $this->conn->prepare("SELECT nombre FROM dentistas WHERE id_dentista = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result ? $result['nombre'] : 'Dentista no encontrado';
    }

    public function getPacienteAllInfoById(int $id): array|false {
        $stmtOrc = $this->conn->prepare("SELECT paciente_id FROM anamnesis WHERE id_anamnesis = :id");
        $stmtOrc->execute([':id' => $id]);
        $anamnese = $stmtOrc->fetch();
    
        if (!$anamnese || empty($anamnese['paciente_id'])) {
            return false;
        }
    
        // 2. Buscar informacciones completas do paciente
        $stmtPac = $this->conn->prepare("SELECT * FROM pacientes WHERE id_paciente = :paciente_id");
        $stmtPac->execute([':paciente_id' => $anamnese['paciente_id']]);
        return $stmtPac->fetch();
    }

    public function getDentistaAllInfoById(int $id): array|false {
        // 1. Buscar o orçamento para obter o dentista_id
        $stmtOrc = $this->conn->prepare("SELECT dentista_id FROM anamnesis WHERE id_anamnesis = :id");
        $stmtOrc->execute([':id' => $id]);
        $anamnese = $stmtOrc->fetch();
    
        if (!$anamnese || empty($anamnese['dentista_id'])) {
            return false;
        }
    
        // 2. Buscar informacciones completas do dentista
        $stmtDent = $this->conn->prepare("SELECT * FROM dentistas WHERE id_dentista = :dentista_id");
        $stmtDent->execute([':dentista_id' => $anamnese['dentista_id']]);
        return $stmtDent->fetch();
    }
    
    public function getEspecialidadeNameById(int $id): string {
        $stmt = $this->conn->prepare("SELECT descripcion FROM especialidades WHERE id_especialidad = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
    
        return $result ? $result['descripcion'] : 'Especialidad no encontrada';
    }

    public function assinar(string $token, string $tipoRelatorio, array $dadosRelatorio): array|false {
        $stmtCheck = $this->conn->prepare("SELECT token, tipo_informe, datos_informe FROM firmas WHERE token = :token");
        $stmtCheck->execute([':token' => $token]);
        $assinaturaExistente = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        if ($assinaturaExistente) {
            return [
                'token' => $assinaturaExistente['token'],
                'tipo_relatorio' => $assinaturaExistente['tipo_informe'] ?? null,
                'dados_relatorio' => $assinaturaExistente['datos_informe'] ?? null
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

    function gerarNumeroAnamnese(int $idAnamnese, int $ano): string {
        return 'ANAMNESIS-' . str_pad($idAnamnese, 6, '0', STR_PAD_LEFT) . '/' . $ano;
    }
}
