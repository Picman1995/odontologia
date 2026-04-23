<?php 
$pageTitle = "Citas";
require_once __DIR__ . '/../layouts/header.php';
$agendamentoModel = new Agendamento();
?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Citas</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/citas/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Nueva cita</a>
                <a href="<?= BASE_URL ?>/citas/calendario" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Calendario</a>
            </div>
        </div>
        <div class="table-responsive bg-dark p-3 rounded shadow-sm">
            <table id="tabela-agendamentos" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Fecha y hora</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)($agendamento['id_cita'] ?? '')) ?></td>
                        <td>
                        <?php 
                            $nomePaciente = $agendamentoModel->getPacienteNameById($agendamento['paciente_id']);
                            echo htmlspecialchars($nomePaciente);
                        ?>
                        </td>
                        <td>
                        <?php
                            $nomeDentista = $agendamentoModel->getDentistaNameById($agendamento['dentista_id']);
                            echo htmlspecialchars($nomeDentista);
                        ?>
                        </td>
                        <td><?= htmlspecialchars(date("d/m/Y H:i", strtotime($agendamento['fecha_hora'] ?? ''))) ?></td>
                        <td><?= nl2br(htmlspecialchars((string)($agendamento['descripcion'] ?? ''))) ?></td>
                        <td>

                        <a href="<?= BASE_URL ?>/citas/edit/<?= (int)($agendamento['id_cita'] ?? 0) ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/citas/delete/<?= (int)($agendamento['id_cita'] ?? 0) ?>" class="btn btn-sm btn-danger me-1" title="Eliminar" onclick="return confirm('¿Eliminar esta cita?')">
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
        $('#tabela-agendamentos').DataTable({
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
