<?php

require_once __DIR__ . '/../../config/Database.php';

class Orcamento {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM presupuestos");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool|string {
        $stmtAnamnese = $this->conn->prepare("
            SELECT id_anamnesis 
            FROM anamnesis 
            WHERE paciente_id = :paciente_id 
            ORDER BY fecha DESC, id_anamnesis DESC 
            LIMIT 1
        ");
        $stmtAnamnese->execute([':paciente_id' => $data['paciente_id']]);
        $anamnese = $stmtAnamnese->fetch();
        if (!$anamnese || empty($anamnese['id_anamnesis'])) {
            return "Error: No se encontró anamnesis para este paciente.";
        }
        $anamnesisId = $anamnese['id_anamnesis'];
        $sql = "INSERT INTO presupuestos (
                    anamnesis_id, paciente_id, dentista_id, descripcion_servicio, valor, fecha
                ) VALUES (
                    :anamnesisId, :pacienteId, :dentistaId, :descripcionServico, :valor, :fecha
                )";
    
        $stmt = $this->conn->prepare($sql);
        $success = $stmt->execute([
            ':anamnesisId' => $anamnesisId,
            ':pacienteId' => $data['paciente_id'],
            ':dentistaId' => $data['dentista_id'],
            ':descripcionServico' => $data['descripcion_servicio'],
            ':valor' => $data['valor'],
            ':fecha' => $data['fecha']
        ]);
        return $success;
    }
    

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM presupuestos WHERE id_presupuesto = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE presupuestos 
                SET paciente_id = :pacienteId,
                    dentista_id = :dentistaId,
                    descripcion_servicio = :descripcionServico,
                    valor = :valor,
                    fecha = :fecha 
                WHERE id_presupuesto = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pacienteId' => $data['paciente_id'],
            ':dentistaId' => $data['dentista_id'],
            ':descripcionServico' => $data['descripcion_servicio'],
            ':valor' => $data['valor'],
            ':fecha' => $data['fecha'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM presupuestos WHERE id_presupuesto = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function total(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM presupuestos");
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
        $stmtOrc = $this->conn->prepare("SELECT paciente_id FROM presupuestos WHERE id_presupuesto = :id");
        $stmtOrc->execute([':id' => $id]);
        $orcamento = $stmtOrc->fetch();
    
        if (!$orcamento || empty($orcamento['paciente_id'])) {
            return false;
        }
    
        $stmtPac = $this->conn->prepare("SELECT * FROM pacientes WHERE id_paciente = :paciente_id");
        $stmtPac->execute([':paciente_id' => $orcamento['paciente_id']]);
        return $stmtPac->fetch();
    }

    public function getDentistaAllInfoById(int $id): array|false {
        $stmtOrc = $this->conn->prepare("SELECT dentista_id FROM presupuestos WHERE id_presupuesto = :id");
        $stmtOrc->execute([':id' => $id]);
        $orcamento = $stmtOrc->fetch();
    
        if (!$orcamento || empty($orcamento['dentista_id'])) {
            return false;
        }
    
        $stmtDent = $this->conn->prepare("SELECT * FROM dentistas WHERE id_dentista = :dentista_id");
        $stmtDent->execute([':dentista_id' => $orcamento['dentista_id']]);
        return $stmtDent->fetch();
    }

    public function getEspecialidadeNameById(int $id): string {
        $stmt = $this->conn->prepare("SELECT descripcion FROM especialidades WHERE id_especialidad = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ? $result['descripcion'] : 'Especialidad no encontrada';
    }

    function gerarNumeroOrcamento(int $idOrcamento): string {
        $ano = date('Y');
        return 'PRESUPUESTO-' . str_pad($idOrcamento, 6, '0', STR_PAD_LEFT) . '/' . $ano;
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
}
