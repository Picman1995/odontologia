<?php
$pageTitle = "Extrato Financeiro - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-5">
    <div class="card bg-dark text-light p-4 rounded-4 shadow">
        <h2 class="mb-4 text-center">Extrato Financeiro</h2>
        <form method="GET" action="<?= BASE_URL ?>/lancamentos/extrato/<?= $pacienteId ?>" class="row g-3 mb-4">
            <input type="hidden" name="paciente_id" value="<?= $pacienteId ?>">
            <div class="col-md-5">
                <label class="form-label">Data Início:</label>
                <input type="date" name="data_inicio" class="form-control bg-dark text-light border-secondary" value="<?= $_GET['data_inicio'] ?? '' ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label">Data Fim:</label>
                <input type="date" name="data_fim" class="form-control bg-dark text-light border-secondary" value="<?= $_GET['data_fim'] ?? '' ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>

        <?php if ($paciente): ?>
            <h4 class="mb-3">Paciente: <?= htmlspecialchars($paciente['nome']) ?></h4>
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
                    <th>Valor (R$)</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lancamentos)): ?>
                    <?php foreach ($lancamentos as $lanc): ?>
                        <tr>
                            <td><?= $lanc['id_lancamento'] ?></td>
                            <td><?= date('d/m/Y', strtotime($lanc['data_lancamento'])) ?></td>
                            <td>
                                <span class="badge bg-<?= $lanc['tipo'] === 'credito' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($lanc['tipo']) ?>
                                </span>
                            </td>
                            <td><?= ucfirst($lanc['categoria']) ?></td>
                            <td>R$ <?= number_format($lanc['valor'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($lanc['descricao']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhum lançamento encontrado para este paciente.</td>
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
            <a href="<?= BASE_URL ?>/lancamentos" class="btn btn-outline-light">← Voltar para lançamentos</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
