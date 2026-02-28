<?php 
$pageTitle = "Editar especialidad - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

    <div class="container">
        <h1 class="text-center mt-4">Editar especialidad</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/especialidades/update/<?= $especialidade['id_especialidad'] ?>" method="POST">
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Especialidad:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?= htmlspecialchars($especialidade['descripcion']) ?>" required>
                </div>

                <button type="submit" class="btn btn-custom w-100">Guardar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/especialidades" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver a la lista</a>
            </div>
        </div>
    </div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
