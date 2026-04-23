<?php 
$pageTitle = "Nueva cita";
require_once __DIR__ . '/../layouts/header.php';
$pacienteModel = new Paciente();
$pacienteName = $pacienteModel->getAll();
$dentistaModel = new Dentista();
$dentistaName = $dentistaModel->getAll();
?>
    <div class="container">
        <h1 class="text-center mt-4">Nueva cita</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/citas/store" method="POST">
                
                <div class="mb-3">
                    <label for="paciente_id" class="form-label">Paciente</label>
                        <input type="text" id="search" class="form-control" placeholder="Escriba el nombre..." onkeyup="searchData()">
                        <div id="suggestions" class="list-group mt-2"></div>
                        <input type="hidden" name="paciente_id" id="paciente_id">
                </div>

                
                <div class="mb-3">
                    <label for="dentista_id" class="form-label">Dentista</label>
                        <select class="form-control" name="dentista_id" id="dentista_id" required>
                                <option value="">Seleccione un dentista</option>
                            <?php foreach ($dentistaName as $dentista): ?>
                                <option value="<?= htmlspecialchars($dentista['id_dentista']) ?>"><?= htmlspecialchars($dentista['nombre']) . " - " . $dentistaModel->getEspecialidadeNameById((int)($dentista['especialidad_id'] ?? 0)) ?></option>                          
                            <?php endforeach; ?>    
                        </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_hora" class="form-label">Fecha y hora</label>
                    <input type="datetime-local" class="form-control" name="fecha_hora" id="fecha_hora" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-custom w-100">Guardar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/citas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver a la lista</a>
            </div>
        </div>
    </div>

    <script>
        function searchData() {
            var query = $('#search').val();
            
            if (query.length > 0) {
                $.ajax({
                    url: '<?= BASE_URL ?>/search.php',
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        $('#suggestions').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error: ' + status + ' - ' + error);
                        $('#suggestions').html('<p class="text-danger">No se pudieron cargar los resultados.</p>');
                    }
                });
            } else {
                $('#suggestions').html('');
            }
        }

        function selectPatient(id, nombre) {
            $('#search').val(nombre);
            $('#paciente_id').val(id);
            $('#suggestions').html('');
        }
    </script>


    <?php 
    require_once __DIR__ . '/../layouts/footer.php';
    ?>
