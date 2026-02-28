<?php

require_once __DIR__ . '/../../config/Database.php';

/** Modelo de movimientos contables (tabla movimientos_contables) */
class LancamentoContabil {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM movimientos_contables ORDER BY fecha_movimiento DESC");
        return $stmt->fetchAll();
    }

    public function find(int $id): array {
        $sql = "SELECT * FROM movimientos_contables WHERE id_movimiento = :id_movimiento LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_movimiento' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO movimientos_contables (
                    paciente_id, presupuesto_id, fecha_movimiento, descripcion, tipo, valor, categoria
                ) VALUES (
                    :paciente_id, :presupuesto_id, :fecha_movimiento, :descripcion, :tipo, :valor, :categoria
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':paciente_id' => $data['paciente_id'],
            ':presupuesto_id' => $data['presupuesto_id'] ?? null,
            ':fecha_movimiento' => $data['fecha_movimiento'],
            ':descripcion' => $data['descripcion'],
            ':tipo' => $data['tipo'],
            ':valor' => $data['valor'],
            ':categoria' => $data['categoria']
        ]);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE movimientos_contables 
                SET paciente_id = :paciente_id, 
                    presupuesto_id = :presupuesto_id, 
                    fecha_movimiento = :fecha_movimiento, 
                    descripcion = :descripcion, 
                    tipo = :tipo, 
                    valor = :valor, 
                    categoria = :categoria 
                WHERE id_movimiento = :id_movimiento";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_movimiento' => $id,
            ':paciente_id' => $data['paciente_id'],
            ':presupuesto_id' => $data['presupuesto_id'],
            ':fecha_movimiento' => $data['fecha_movimiento'],
            ':descripcion' => $data['descripcion'],
            ':tipo' => $data['tipo'],
            ':valor' => $data['valor'],
            ':categoria' => $data['categoria']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM movimientos_contables WHERE id_movimiento = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getByPaciente(int $pacienteId, ?string $dataInicio = null, ?string $dataFim = null): array {
        $sql = "SELECT * FROM movimientos_contables WHERE paciente_id = :id";
        $params = [':id' => $pacienteId];
        if ($dataInicio && $dataFim) {
            $sql .= " AND fecha_movimiento BETWEEN :dataInicio AND :dataFim";
            $params[':dataInicio'] = $dataInicio;
            $params[':dataFim'] = $dataFim;
        }
        $sql .= " ORDER BY fecha_movimiento DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getSaldoPaciente(int $pacienteId, ?string $dataInicio = null, ?string $dataFim = null): float {
        $sql = "SELECT 
                    SUM(CASE WHEN tipo = 'credito' THEN valor ELSE -valor END) AS saldo
                FROM movimientos_contables
                WHERE paciente_id = :id";
        $params = [':id' => $pacienteId];
        if ($dataInicio && $dataFim) {
            $sql .= " AND fecha_movimiento BETWEEN :dataInicio AND :dataFim";
            $params[':dataInicio'] = $dataInicio;
            $params[':dataFim'] = $dataFim;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return (float) ($result['saldo'] ?? 0);
    }

    public function getAllFiltrado(?string $dataInicio = null, ?string $dataFim = null): array {
        $sql = "SELECT * FROM movimientos_contables WHERE 1";
        $params = [];
        if ($dataInicio && $dataFim) {
            $sql .= " AND fecha_movimiento BETWEEN :dataInicio AND :dataFim";
            $params[':dataInicio'] = $dataInicio;
            $params[':dataFim'] = $dataFim;
        }
        $sql .= " ORDER BY fecha_movimiento DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getResumoPorPaciente(string $dataInicio, string $dataFim): array {
        $sql = "
            SELECT 
                lc.paciente_id,
                p.nombre AS paciente_nome,
                SUM(CASE WHEN lc.tipo = 'credito' THEN lc.valor ELSE 0 END) AS total_credito,
                SUM(CASE WHEN lc.tipo = 'debito' THEN lc.valor ELSE 0 END) AS total_debito,
                SUM(CASE WHEN lc.tipo = 'credito' THEN lc.valor ELSE -lc.valor END) AS saldo
            FROM movimientos_contables lc
            JOIN pacientes p ON lc.paciente_id = p.id_paciente
            WHERE lc.fecha_movimiento BETWEEN :dataInicio AND :dataFim
            GROUP BY lc.paciente_id
            ORDER BY p.nombre ASC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':dataInicio' => $dataInicio,
            ':dataFim' => $dataFim
        ]);
        return $stmt->fetchAll();
    }

    public function assinar(string $token, string $tipoInforme, array $datosInforme): array|false {
        $stmtCheck = $this->conn->prepare("SELECT token, tipo_informe, datos_informe FROM firmas WHERE token = :token");
        $stmtCheck->execute([':token' => $token]);
        $firmaExistente = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        if ($firmaExistente) {
            return [
                'token' => $firmaExistente['token'],
                'tipo_relatorio' => $firmaExistente['tipo_informe'],
                'dados_relatorio' => $firmaExistente['datos_informe']
            ];
        }
        $sql = "INSERT INTO firmas (token, tipo_informe, datos_informe) 
                VALUES (:token, :tipoInforme, :datosInforme)";
        $stmt = $this->conn->prepare($sql);
        $sucesso = $stmt->execute([
            ':token' => $token,
            ':tipoInforme' => $tipoInforme,
            ':datosInforme' => json_encode($datosInforme, JSON_UNESCAPED_UNICODE)
        ]);
        if ($sucesso) {
            return [
                'token' => $token,
                'tipo_relatorio' => $tipoInforme,
                'dados_relatorio' => json_encode($datosInforme, JSON_UNESCAPED_UNICODE)
            ];
        }
        return false;
    }
}
