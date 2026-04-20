<?php 
$pageTitle = "Recetas Odontológicas";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Recetas Odontológicas</h2>
        <a href="<?= BASE_URL ?>/recetas/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Registrar Nueva Receta</a>
    </div>

    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-receitas" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Data</th>
                    <th>acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receitas as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)($r['id_receta'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($r['paciente']) ?></td>
                        <td><?= htmlspecialchars($r['dentista']) ?></td>
                        <td><?= !empty($r['fecha']) ? date("d/m/Y", strtotime($r['fecha'])) : '—' ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/recetas/edit/<?= (int)($r['id_receta'] ?? 0) ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/recetas/delete/<?= (int)($r['id_receta'] ?? 0) ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta receita?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/recetas/relatorio/<?= (int)($r['id_receta'] ?? 0) ?>" class="btn btn-sm btn-secondary" title="Relatório">
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
        $('#tabela-receitas').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
    </script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
