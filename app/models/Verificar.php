<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/Database.php';

/**
 * Verifica si el token existe y devuelve los datos asociados (tabla firmas).
 */
class Verificar {
    private PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function verificarToken(string $token): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM firmas WHERE token = :token LIMIT 1");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($dados && isset($dados['datos_informe'])) {
            $dados['dados_relatorio'] = $dados['datos_informe'];
            $dados['tipo_relatorio'] = $dados['tipo_informe'] ?? null;
        }
        return $dados ?: null;
    }
}
