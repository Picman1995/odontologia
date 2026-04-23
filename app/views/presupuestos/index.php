<?php 
$pageTitle = "Presupuestos";
require_once __DIR__ . '/../layouts/header.php'; 
$orcamentoModel = new Orcamento();
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Presupuestos</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/presupuestos/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Nuevo presupuesto</a>
            </div>
        </div>
    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-orcamentos" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Servicio</th>
                    <th>Valor</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orcamentos as $orcamento): ?>
                    <tr>
                        <td><?= htmlspecialchars($orcamentoModel->gerarNumeroOrcamento((int)($orcamento['id_presupuesto'] ?? 0))) ?></td>
                        <td>
                        <?php 
                            $nomePaciente = $orcamentoModel->getPacienteNameById($orcamento['paciente_id']);
                            echo htmlspecialchars($nomePaciente);
                        ?>
                        </td>
                        <td>
                        <?php 
                            $nomeDentista = $orcamentoModel->getDentistaNameById($orcamento['dentista_id']);
                            echo htmlspecialchars($nomeDentista);
                        ?>
                        </td>
                        <td><?= nl2br(htmlspecialchars((string)($orcamento['descripcion_servicio'] ?? ''))) ?></td>
                        <td>Gs. <?= number_format((float)($orcamento['valor'] ?? 0), 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars(date("d/m/Y", strtotime((string)($orcamento['fecha'] ?? '')))) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/presupuestos/edit/<?= (int)($orcamento['id_presupuesto'] ?? 0) ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/presupuestos/delete/<?= (int)($orcamento['id_presupuesto'] ?? 0) ?>" class="btn btn-sm btn-danger me-1" title="Eliminar" onclick="return confirm('¿Eliminar este presupuesto?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/presupuestos/relatorio/<?= (int)($orcamento['id_presupuesto'] ?? 0) ?>" class="btn btn-sm btn-secondary" title="Informe">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
   
    <div class="d-flex justify-content-end mt-3">
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">
            Volver al panel 
        </a>
    </div>
    </div>
    
    <script>
    $(document).ready(function () {
        $('#tabela-orcamentos').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
    </script>
    
<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
