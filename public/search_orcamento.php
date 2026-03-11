<?php
// Conexão com o banco de dados
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$database = new Database();
$conn = $database->connect();

if (isset($_GET['query'])) {
    $query = $_GET['query']; // Obtém a string de busca

    // Preparar a consulta para encontrar pacientes que correspondem ao nombre
    $stmt = $conn->prepare("SELECT id_paciente, nombre FROM pacientes WHERE nombre LIKE :query LIMIT 5");
    $stmt->execute([':query' => '%' . $query . '%']);
    
    // Obtém os resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($result) {
        foreach ($result as $row) {
            // Para cada paciente encontrado, buscar todas as informações relacionadas
            $id_paciente = $row['id_paciente'];
            
            // Consulta para obter todas as informações do paciente com base no id_paciente
            $stmtPaciente = $conn->prepare("SELECT * FROM pacientes WHERE id_paciente = :id_paciente");
            $stmtPaciente->execute([':id_paciente' => $id_paciente]);
            $paciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);
            
            if ($paciente) {
                // Criar um link para o paciente, passando o id e nombre
                echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="selectPatient(' . $paciente['id_paciente'] . ', \'' . htmlspecialchars($paciente['nombre']) . '\')">';
                echo htmlspecialchars($paciente['nombre']);  // Exibe o nombre do paciente
                echo '</a>';
            }
        }
    } else {
        echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">Ningún resultado encontrado.</a>';
    }
}
?>
