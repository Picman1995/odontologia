<?php
$pageTitle = "Relatório Financeiro Geral - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-5">
    <div class="card bg-dark text-light p-4 rounded-4 shadow">
        <h2 class="mb-4 text-center">Relatório Geral Financeiro por Período</h2>

        <form method="GET" action="<?= BASE_URL ?>/lancamentos/relatorioGeral" class="row g-3 mb-4">
            <div class="col-md-5">
                <label class="form-label">Data Início:</label>
                <input type="date" name="data_inicio" class="form-control bg-dark text-light border-secondary" value="<?= $_GET['data_inicio'] ?? '' ?>" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Data Fim:</label>
                <input type="date" name="data_fim" class="form-control bg-dark text-light border-secondary" value="<?= $_GET['data_fim'] ?? '' ?>" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Gerar</button>
            </div>
        </form>

        <?php if ($dataInicio && $dataFim): ?>
            <h5 class="text-center mb-3">Período: <?= date('d/m/Y', strtotime($dataInicio)) ?> a <?= date('d/m/Y', strtotime($dataFim)) ?></h5>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Total Créditos (R$)</th>
                            <th>Total Débitos (R$)</th>
                            <th>Saldo (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $somaCreditos = 0;
                        $somaDebitos = 0;
                        $somaSaldos = 0;
                        ?>
                        <?php if (!empty($resumo)): ?>
                            <?php foreach ($resumo as $linha): ?>
                                <?php
                                    $somaCreditos += $linha['total_credito'];
                                    $somaDebitos += $linha['total_debito'];
                                    $somaSaldos  += $linha['saldo'];
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($linha['paciente_nome']) ?></td>
                                    <td class="text-success">R$ <?= number_format($linha['total_credito'], 2, ',', '.') ?></td>
                                    <td class="text-danger">R$ <?= number_format($linha['total_debito'], 2, ',', '.') ?></td>
                                    <td class="<?= $linha['saldo'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                        R$ <?= number_format($linha['saldo'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">Nenhum lançamento encontrado para esse período.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                    <?php if (!empty($resumo)): ?>
                        <tfoot>
                            <tr class="fw-bold">
                                <td>Total Geral</td>
                                <td class="text-success">R$ <?= number_format($somaCreditos, 2, ',', '.') ?></td>
                                <td class="text-danger">R$ <?= number_format($somaDebitos, 2, ',', '.') ?></td>
                                <td class="<?= $somaSaldos >= 0 ? 'text-success' : 'text-danger' ?>">
                                    R$ <?= number_format($somaSaldos, 2, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/lancamentos" class="btn btn-outline-light">← Voltar para lançamentos</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
