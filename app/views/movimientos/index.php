<?php
$pageTitle = "Lançamentos Financeiros - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lançamentos Financeiros</h1>
        <a href="<?= BASE_URL ?>/lancamentos/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">+ Novo Lançamento</a>
    </div>

    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-lancamentos" class="table table-dark table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Orçamento</th>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Valor (R$)</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lancamentos as $lanc): ?>
                    <tr>
                        <td><?= $lanc['id_lancamento'] ?></td>
                        <td>
                            <?php
                                $paciente = (new Paciente())->find($lanc['paciente_id']);
                                echo htmlspecialchars($paciente['nome'] ?? 'Desconhecido');
                            ?>
                        </td>
                        <td><?= $lanc['orcamento_id'] ? '#' . $lanc['orcamento_id'] : '-' ?></td>
                        <td><?= date('d/m/Y', strtotime($lanc['data_lancamento'])) ?></td>
                        <td>
                            <span class="badge bg-<?= $lanc['tipo'] === 'credito' ? 'success' : 'danger' ?>">
                                <?= ucfirst($lanc['tipo']) ?>
                            </span>
                        </td>
                        <td><?= ucfirst($lanc['categoria']) ?></td>
                        <td>R$ <?= number_format($lanc['valor'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($lanc['descricao']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/lancamentos/edit/<?= $lanc['id_lancamento'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/lancamentos/delete/<?= $lanc['id_lancamento'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este lançamento?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/lancamentos/relatorio/<?= $lanc['id_lancamento'] ?>" class="btn btn-sm btn-secondary" title="Relatório">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>

                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($lancamentos)): ?>
                    <tr>
                        <td colspan="9">Nenhum lançamento cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">
            Voltar para o Dashboard
        </a>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabela-lancamentos').DataTable({
            "scrollX": true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
