<?php 
$pageTitle = "Receitas Odontológicas";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Receitas Odontológicas</h2>
        <a href="<?= BASE_URL ?>/receitas/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Cadastrar Nova Receita</a>
    </div>

    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-receitas" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receitas as $r): ?>
                    <tr>
                        <td><?= $r['id_receita'] ?></td>
                        <td><?= htmlspecialchars($r['paciente']) ?></td>
                        <td><?= htmlspecialchars($r['dentista']) ?></td>
                        <td><?= date("d/m/Y", strtotime($r['data'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/receitas/edit/<?= $r['id_receita'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/receitas/delete/<?= $r['id_receita'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta receita?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/receitas/relatorio/<?= $r['id_receita'] ?>" class="btn btn-sm btn-secondary" title="Relatório">
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
        $('#tabela-receitas').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });
    });
    </script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
