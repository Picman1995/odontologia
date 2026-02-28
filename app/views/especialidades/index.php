<?php 
$pageTitle = "Lista de especialidades - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Especialidades</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/especialidades/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Registrar nueva especialidad</a>
            </div>
        </div>
    
    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-especialidades" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($especialidades as $especialidade): ?>
                    <tr>
                        <td><?= htmlspecialchars($especialidade['id_especialidad']) ?></td>
                        <td><?= htmlspecialchars($especialidade['descripcion']) ?></td>
                        <td>
                        <div class="text-center">
                            <a href="<?= BASE_URL ?>/especialidades/edit/<?= $especialidade['id_especialidad'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/especialidades/delete/<?= $especialidade['id_especialidad'] ?>" class="btn btn-sm btn-danger me-1" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar esta especialidad?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </div>
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
        $('#tabela-especialidades').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
    </script>
<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
