<?php
$pageTitle = "Lanzamientos Financeiros - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Comunicados financieros</h1>
        <a href="<?= BASE_URL ?>/movimientos/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">+ Nuevo movimiento</a>
    </div>

    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-lanzamientos" class="table table-dark table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Presupuesto</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Valor (Gs)</th>
                    <th>Descripcion</th>
                    <th>acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lanzamientos as $lanc): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)($lanc['id_movimiento'] ?? '')) ?></td>
                        <td>
                            <?php
                                $paciente = (new Paciente())->find((int)($lanc['paciente_id'] ?? 0));
                                echo htmlspecialchars(is_array($paciente) ? ($paciente['nombre'] ?? 'Desconocido') : 'Desconocido');
                            ?>
                        </td>
                        <td><?= !empty($lanc['presupuesto_id']) ? '#' . htmlspecialchars((string)$lanc['presupuesto_id']) : '-' ?></td>
                        <td><?= !empty($lanc['fecha_movimiento']) ? date('d/m/Y', strtotime($lanc['fecha_movimiento'])) : '-' ?></td>
                        <td>
                            <span class="badge bg-<?= ($lanc['tipo'] ?? '') === 'credito' ? 'success' : 'danger' ?>">
                                <?= ucfirst(htmlspecialchars((string)($lanc['tipo'] ?? ''))) ?>
                            </span>
                        </td>
                        <td><?= ucfirst(htmlspecialchars((string)($lanc['categoria'] ?? ''))) ?></td>
                        <td>R$ <?= number_format((float)($lanc['valor'] ?? 0), 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars((string)($lanc['descripcion'] ?? '')) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/movimientos/edit/<?= (int)($lanc['id_movimiento'] ?? 0) ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/movimientos/delete/<?= (int)($lanc['id_movimiento'] ?? 0) ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este Lanzamiento?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/movimientos/relatorio/<?= (int)($lanc['id_movimiento'] ?? 0) ?>" class="btn btn-sm btn-secondary" title="Relatório">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>

                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($lanzamientos)): ?>
                    <tr>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>No hay movimientos registrados.</td>
                        <td>&mdash;</td>
                    </tr>
                <?php endif; ?>
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
        $('#tabela-lanzamientos').DataTable({
            "scrollX": true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
