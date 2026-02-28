<?php 
$pageTitle = "Lista de Anamneses - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
$anamneseModel = new Anamnese(); 
$dentistaModel = new Dentista();
?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Anamneses</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/anamneses/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Cadastra Nova Anamnese</a>
            </div>
        </div>
    
    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-anamneses" class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Dentista</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($anamneses as $anamnese): ?>
                <tr>
                    <td><?= htmlspecialchars($anamneseModel->gerarNumeroAnamnese($anamnese['id_anamnese'], date("Y", strtotime($anamnese['data'])))) ?></td>
                    <td>
                    <?php
                        $nomePaciente = $anamneseModel->getPacienteNameById($anamnese['paciente_id']);
                        echo $nomePaciente;
                    ?>
                    </td>
                    <td>
                    <?php
                        $nomeDentista = $dentistaModel->find($anamnese['dentista_id']);
                        echo $nomeDentista['nome'];
                    ?>
                    </td>
                    <td><?= nl2br(htmlspecialchars($anamnese['descricao'])) ?></td>
                    <td><?= htmlspecialchars(date("d/m/Y", strtotime($anamnese['data']))) ?></td>
                    <td>
                                    
                    <a href="<?= BASE_URL ?>/anamneses/edit/<?= $anamnese['id_anamnese'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/anamneses/delete/<?= $anamnese['id_anamnese'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este orçamento?')">
                        <i class="bi bi-trash3"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/anamneses/relatorio/<?= $anamnese['id_anamnese'] ?>" class="btn btn-sm btn-secondary" title="Relatório">
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
        $('#tabela-anamneses').DataTable({
            "scrollX": true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });
    });
    </script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
