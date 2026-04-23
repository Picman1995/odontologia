<?php 
$pageTitle = "Nuevo Funcionário - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container">
    <h1 class="text-center mt-4">Nuevo Funcionário</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/funcionarios/store" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>

            <div class="mb-3">
                <label for="puesto" class="form-label">Cargo:</label>
                <input type="text" class="form-control" name="puesto" id="puesto" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" id="telefono" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo" required>
                    <option value="">— Seleccione —</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" name="direccion" id="direccion" required>
            </div>

            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Guardar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/funcionarios" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">volver a la lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
