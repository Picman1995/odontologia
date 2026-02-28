<?php 
$pageTitle = "Lista de Orçamentos - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
$orcamentoModel = new Orcamento();
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Orçamentos</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/orcamentos/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Cadastra Novo Orçamento</a>
            </div>
        </div>
    <!-- Tabela -->
    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-orcamentos" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Serviço</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orcamentos as $orcamento): ?>
                    <tr>
                        <td><?= htmlspecialchars(string: $orcamentoModel->gerarNumeroOrcamento($orcamento['id_orcamento'])) ?></td>
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
                        <td><?= nl2br(htmlspecialchars($orcamento['descricao_servico'])) ?></td>
                        <td>R$ <?= number_format($orcamento['valor'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars(date("d/m/Y", strtotime($orcamento['data']))) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/orcamentos/edit/<?= $orcamento['id_orcamento'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/orcamentos/delete/<?= $orcamento['id_orcamento'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este orçamento?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/orcamentos/relatorio/<?= $orcamento['id_orcamento'] ?>" class="btn btn-sm btn-secondary" title="Relatório">
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
            Voltar para o Dashboard
        </a>
    </div>
    </div>
    
    <script>
    $(document).ready(function () {
        $('#tabela-orcamentos').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });
    });
    </script>
    
<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
