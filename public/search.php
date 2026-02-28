<?php
// Conexión con la base de datos
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$database = new Database();
$conn = $database->connect();

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $stmt = $conn->prepare("SELECT id_paciente, nombre FROM pacientes WHERE nombre LIKE :query LIMIT 5");
    $stmt->execute([':query' => '%' . $query . '%']);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="selectPatient(' . $row['id_paciente'] . ', \'' . htmlspecialchars($row['nombre']) . '\')">' . htmlspecialchars($row['nombre']) . '</a>';
        }
    } else {
        echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">Ningún resultado encontrado.</a>';
    }
}
?>
