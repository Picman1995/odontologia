<?php
$pageTitle = "Estracto Financiero - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-5">
    <div class="card bg-dark text-light p-4 rounded-4 shadow">
        <h2 class="mb-4 text-center">Estracto Financiero</h2>
        <form method="GET" action="<?= BASE_URL ?>/movimientos/extrato/<?= $pacienteId ?>" class="row g-3 mb-4">
            <input type="hidden" name="paciente_id" value="<?= $pacienteId ?>">
            <div class="col-md-5">
                <label class="form-label">Data Início:</label>
                <input type="date" name="data_inicio" class="form-control bg-dark text-light border-secondary" value="<?= $_GET['data_inicio'] ?? '' ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label">Data Fin:</label>
                <input type="date" name="data_fim" class="form-control bg-dark text-light border-secondary" value="<?= $_GET['data_fim'] ?? '' ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>

        <?php if ($paciente): ?>
            <h4 class="mb-3">Paciente: <?= htmlspecialchars($paciente['nombre']) ?></h4>
        <?php else: ?>
            <h4 class="mb-3">Paciente não encontrado</h4>
        <?php endif; ?>

        <table class="table table-dark table-striped table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Valor (Gs)</th>
                    <th>Descripcion</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lanzamientos)): ?>
                    <?php foreach ($lanzamientos as $lanc): ?>
                        <tr>
                            <td><?= htmlspecialchars((string)($lanc['id_movimiento'] ?? '')) ?></td>
                            <td><?= !empty($lanc['fecha_movimiento']) ? date('d/m/Y', strtotime($lanc['fecha_movimiento'])) : '-' ?></td>
                            <td>
                                <span class="badge bg-<?= ($lanc['tipo'] ?? '') === 'credito' ? 'success' : 'danger' ?>">
                                    <?= ucfirst(htmlspecialchars((string)($lanc['tipo'] ?? ''))) ?>
                                </span>
                            </td>
                            <td><?= ucfirst(htmlspecialchars((string)($lanc['categoria'] ?? ''))) ?></td>
                            <td>R$ <?= number_format((float)($lanc['valor'] ?? 0), 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars((string)($lanc['descripcion'] ?? '')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>&mdash;</td>
                        <td>No se encontraron registros para este paciente.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-4 text-end">
            <h4>
                Saldo do Período: 
                <span class="<?= $saldo >= 0 ? 'text-success' : 'text-danger' ?>">
                    R$ <?= number_format($saldo, 2, ',', '.') ?>
                </span>
            </h4>
        </div>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/movimientos" class="btn btn-outline-light">Regresar a movimientos</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
