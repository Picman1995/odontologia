<?php 
$pageTitle = "Nueva receta";
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../../models/Dentista.php';
$dentistaModel = new Dentista();
?>

<div class="container">
    <h2>Nueva receta</h2>

    <form action="<?= BASE_URL ?>/recetas/store" method="POST" class="form-container mt-4">

        <div class="mb-3">
            <label for="paciente_id" class="form-label">Paciente</label>
                <input type="text" id="search" class="form-control" placeholder="Escriba el nombre..." onkeyup="searchData()">
                <div id="suggestions" class="list-group mt-2"></div>
                <input type="hidden" name="paciente_id" id="paciente_id">
        </div>

        <div class="mb-3">
            <label for="dentista_id" class="form-label">Dentista</label>
            <select name="dentista_id" id="dentista_id" class="form-control" required>
                <option value="">Seleccione un dentista</option>
                <?php foreach ($dentistas as $d): ?>
                    <?php $especialidade = $dentistaModel->getEspecialidadeNameById((int)($d['especialidad_id'] ?? 0)); ?>
                    <option value="<?= $d['id_dentista'] ?>"><?= htmlspecialchars($d['nombre']) ?> - <?= $especialidade ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido de la receta</label>
            <textarea name="contenido" id="contenido" rows="10" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-custom w-100">Guardar</button>
        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/recetas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver a la lista</a>
        </div>
    </form>
    
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
                        $('#suggestions').html('<p class="text-danger">No se pudieron cargar los resultados. Intente de nuevo.</p>');
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
