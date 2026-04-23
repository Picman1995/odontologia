<?php 
$pageTitle = "Calendario de citas";
require_once __DIR__ . '/../layouts/header.php';

$dentistaModel = new Dentista();
$dentistas = $dentistaModel->getAll();
$agendamentoModel = new Agendamento();
?>

<h2 style="text-align: center;">Calendario de citas</h2>

<div style="text-align: center; margin: 20px 0;">
    <label for="dentistaSelect" style="color: #fff; font-weight: bold; margin-right: 10px;">Filtrar por dentista:</label>
    <select id="dentistaSelect" style="padding: 5px 10px; border-radius: 5px; background-color: #1e1e1e; color: #fff; border: 1px solid #555;">
        <option value="">Todos</option>
        <?php foreach ($dentistas as $d): ?>
            <?php $especialidade = $agendamentoModel->getEspecialidadeNameById((int)($d['especialidad_id'] ?? 0))?>
            <option value="<?= $d['id_dentista'] ?>">
                <?= htmlspecialchars($d['nombre']) ?> - <?= htmlspecialchars($especialidade) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div id="calendar"></div>

<div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="pacienteModalLabel">Datos del paciente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Paciente:</strong> <span id="pacienteNome"></span></p>
        <p><strong>Teléfono:</strong> <span id="pacienteTelefone"></span></p>
        <p><strong>Email:</strong> <span id="pacienteEmail"></span></p>
        <hr>
        <p><strong>Dentista:</strong> <span id="pacienteDentista"></span></p>
        <p><strong>Especialidad:</strong> <span id="pacienteEspecialidade"></span></p>
        <hr>
        <p><strong>Fecha y hora:</strong> <span id="pacienteDataHora"></span></p>
        <hr>
        <p><strong>Descripción:</strong><br><span id="pacienteDescricao"></span></p>
      </div>

    </div>
  </div>
</div>


<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const dentistaSelect = document.getElementById('dentistaSelect');
        const baseUrl = <?= json_encode(rtrim(BASE_URL, '/')) ?>;

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            timeZone: 'local',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today:    'Hoy',
                month:    'Mes',
                week:     'Semana',
                day:      'Día',
                list:     'Lista'
            },
            allDayText: 'Todo el día',

            eventClick: function(info) {
            const agendamentoId = info.event.id;

            fetch(baseUrl + '/citas/paciente/' + agendamentoId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pacienteNome').textContent = data.paciente ?? 'N/A';
                    document.getElementById('pacienteTelefone').textContent = data.telefono ?? 'N/A';
                    document.getElementById('pacienteEmail').textContent = data.email ?? 'N/A';

                    document.getElementById('pacienteDentista').textContent = data.dentista ?? 'N/A';
                    document.getElementById('pacienteEspecialidade').textContent = data.especialidad ?? 'N/A';
                    document.getElementById('pacienteDataHora').textContent = formatarDataHora(data.fecha_hora);
                    document.getElementById('pacienteDescricao').innerHTML = nl2br(data.descripcion ?? '-');

                    const modal = new bootstrap.Modal(document.getElementById('pacienteModal'));
                    modal.show();
                })
                .catch(error => {
                    alert('No se pudieron cargar los datos de la cita.');
                    console.error(error);
                });
            },


            events: function(fetchInfo, successCallback, failureCallback) {
                const dentistaId = dentistaSelect.value;

                fetch(baseUrl + '/citas/eventos?dentista_id=' + encodeURIComponent(dentistaId))
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
        return data.toLocaleString('es-PY', { dateStyle: 'short', timeStyle: 'short' });
    }

</script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
