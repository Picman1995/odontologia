<?php 
$pageTitle = "Lista de Agendamentos - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
$agendamentoModel = new Agendamento();
?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Agendamentos</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/agendamentos/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Novo Agendamento</a>
                <a href="<?= BASE_URL ?>/agendamentos/calendario" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Exibir Calendário</a>
            </div>
        </div>
        <div class="table-responsive bg-dark p-3 rounded shadow-sm">
            <table id="tabela-agendamentos" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Data e Hora</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars($agendamento['id_agendamento']) ?></td>
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
                        <td><?= htmlspecialchars(date("d/m/Y H:i", strtotime($agendamento['data_hora']))) ?></td>
                        <td><?= nl2br(htmlspecialchars($agendamento['descricao'])) ?></td>
                        <td>

                        <a href="<?= BASE_URL ?>/agendamentos/edit/<?= $agendamento['id_agendamento'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/agendamentos/delete/<?= $agendamento['id_agendamento'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este orçamento?')">
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
            Voltar para o Dashboard
        </a>
    </div>
    </div>
    
    <script>
    $(document).ready(function () {
        $('#tabela-agendamentos').DataTable({
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
