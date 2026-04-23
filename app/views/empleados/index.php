<?php 
$pageTitle = "Lista de Funcionários - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Funcionários</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/funcionarios/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Registrar Nuevo Funcionário</a>
            </div>
        </div>

    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-funcionarios" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Sexo</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)($funcionario['id_empleado'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['nombre'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['puesto'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['telefono'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['email'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['sexo'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['direccion'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($funcionario['ciudad'] ?? '')) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/funcionarios/edit/<?= (int)($funcionario['id_empleado'] ?? 0) ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/funcionarios/delete/<?= (int)($funcionario['id_empleado'] ?? 0) ?>" class="btn btn-sm btn-danger me-1" title="Eliminar" onclick="return confirm('¿Confirma eliminar este funcionario?')">
                                <i class="bi bi-trash3"></i>
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
        $('#tabela-funcionarios').DataTable({
            "scrollX": true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
    </script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
