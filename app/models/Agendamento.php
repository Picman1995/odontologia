<?php
require_once __DIR__ . '/../../config/Database.php';

class Agendamento {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM citas");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO citas (paciente_id, dentista_id, fecha_hora, descripcion)
                VALUES (:pacienteId, :dentistaId, :fechaHora, :descripcion)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pacienteId' => $data['paciente_id'],
            ':dentistaId' => $data['dentista_id'],
            ':fechaHora' => $data['fecha_hora'],
            ':descripcion' => $data['descripcion']
        ]);
    }

    public function find(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM citas WHERE id_cita = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE citas 
                SET paciente_id = :pacienteId, dentista_id = :dentistaId, fecha_hora = :fechaHora, descripcion = :descripcion 
                WHERE id_cita = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pacienteId' => $data['paciente_id'],
            ':dentistaId' => $data['dentista_id'],
            ':fechaHora' => $data['fecha_hora'],
            ':descripcion' => $data['descripcion'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM citas WHERE id_cita = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function total(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM citas");
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

    public function getEventosParaCalendario(?string $dentistaId = null): array {
        $sql = "SELECT a.id_cita, a.fecha_hora, a.descripcion, p.nombre AS paciente
                FROM citas a
                JOIN pacientes p ON a.paciente_id = p.id_paciente";
        if ($dentistaId) {
            $sql .= " WHERE a.dentista_id = :dentista_id";
        }
        $stmt = $this->conn->prepare($sql);
        if ($dentistaId) {
            $stmt->bindParam(':dentista_id', $dentistaId, PDO::PARAM_INT);
        }
        $stmt->execute();
        $eventos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eventos[] = [
                'id' => $row['id_cita'],
                'title' => $row['paciente'] . ' - ' . $row['descripcion'],
                'start' => $row['fecha_hora'],
                'allDay' => false
            ];
        }
        return $eventos;
    }

    public function getEspecialidadeNameById(int $id): string {
        $stmt = $this->conn->prepare("SELECT descripcion FROM especialidades WHERE id_especialidad = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ? $result['descripcion'] : 'Especialidad no encontrada';
    }

    public function getPacienteInfoByAgendamento(int $idAgendamento): array {
        $sql = "SELECT 
                    p.nombre AS paciente,
                    p.telefono,
                    p.email,
                    d.nombre AS dentista,
                    e.descripcion AS especialidad,
                    a.fecha_hora,
                    a.descripcion
                FROM citas a
                JOIN pacientes p ON a.paciente_id = p.id_paciente
                JOIN dentistas d ON a.dentista_id = d.id_dentista
                JOIN especialidades e ON d.especialidad_id = e.id_especialidad
                WHERE a.id_cita = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $idAgendamento]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
}
