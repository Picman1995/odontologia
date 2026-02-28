<?php 
$pageTitle = "Agenda Mensal";
require_once __DIR__ . '/../layouts/header.php';

$dentistaModel = new Dentista();
$dentistas = $dentistaModel->getAll();
$agendamentoModel = new Agendamento();
?>

<h2 style="text-align: center;">Agenda de Atendimentos</h2>

<!-- Filtro centralizado -->
<div style="text-align: center; margin: 20px 0;">
    <label for="dentistaSelect" style="color: #fff; font-weight: bold; margin-right: 10px;">Filtrar por Dentista:</label>
    <select id="dentistaSelect" style="padding: 5px 10px; border-radius: 5px; background-color: #1e1e1e; color: #fff; border: 1px solid #555;">
        <option value="">Todos</option>
        <?php foreach ($dentistas as $d): ?>
            <?php $especialidade = $agendamentoModel->getEspecialidadeNameById($d['especialidade_id'])?>
            <option value="<?= $d['id_dentista'] ?>">
                <?= htmlspecialchars($d['nome']) ?> - <?= htmlspecialchars($especialidade) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div id="calendar"></div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="pacienteModalLabel">Dados do Paciente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Paciente:</strong> <span id="pacienteNome"></span></p>
        <p><strong>Telefone:</strong> <span id="pacienteTelefone"></span></p>
        <p><strong>Email:</strong> <span id="pacienteEmail"></span></p>
        <hr>
        <p><strong>Dentista:</strong> <span id="pacienteDentista"></span></p>
        <p><strong>Especialidade:</strong> <span id="pacienteEspecialidade"></span></p>
        <hr>
        <p><strong>Data/Hora:</strong> <span id="pacienteDataHora"></span></p>
        <hr>
        <p><strong>Descrição:</strong><br><span id="pacienteDescricao"></span></p>
      </div>

    </div>
  </div>
</div>


<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const dentistaSelect = document.getElementById('dentistaSelect');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            timeZone: 'local',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today:    'Hoje',
                month:    'Mês',
                week:     'Semana',
                day:      'Dia',
                list:     'Lista'
            },
            allDayText: 'Dia inteiro',

            eventClick: function(info) {
            const agendamentoId = info.event.id;

            fetch(`/sistema_odontologico/public/agendamentos/paciente/${agendamentoId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pacienteNome').textContent = data.paciente ?? 'N/A';
                    document.getElementById('pacienteTelefone').textContent = data.telefone ?? 'N/A';
                    document.getElementById('pacienteEmail').textContent = data.email ?? 'N/A';

                    document.getElementById('pacienteDentista').textContent = data.dentista ?? 'N/A';
                    document.getElementById('pacienteEspecialidade').textContent = data.especialidade ?? 'N/A';
                    document.getElementById('pacienteDataHora').textContent = formatarDataHora(data.data_hora);
                    document.getElementById('pacienteDescricao').innerHTML = nl2br(data.descricao ?? '-');

                    const modal = new bootstrap.Modal(document.getElementById('pacienteModal'));
                    modal.show();
                })
                .catch(error => {
                    alert('Erro ao carregar dados do agendamento.');
                    console.error(error);
                });
            },


            events: function(fetchInfo, successCallback, failureCallback) {
                const dentistaId = dentistaSelect.value;

                fetch(`/sistema_odontologico/public/agendamentos/eventos?dentista_id=${dentistaId}`)
                    .then(response => response.json())
                    .then(events => successCallback(events))
                    .catch(error => failureCallback(error));
            }
        });

        dentistaSelect.addEventListener('change', function () {
            calendar.refetchEvents();
        });

        function nl2br(str) {
            return (str + '').replace(/(?:\r\n|\r|\n)/g, '<br>');
        }

        calendar.render();

        
    });

    function formatarDataHora(isoString) {
        const data = new Date(isoString);
        return data.toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'short' });
    }

</script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
