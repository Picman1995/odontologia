<?php 
$pageTitle = "Editar Funcionário - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container">
    <h1 class="text-center mt-4">Editar Funcionário</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/funcionarios/update/<?= (int)($funcionario['id_empleado'] ?? 0) ?>" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?= htmlspecialchars((string)($funcionario['nombre'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="puesto" class="form-label">Cargo:</label>
                <input type="text" class="form-control" name="puesto" id="puesto" value="<?= htmlspecialchars((string)($funcionario['puesto'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" id="telefono" value="<?= htmlspecialchars((string)($funcionario['telefono'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars((string)($funcionario['email'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo" required>
                    <option value="">— Seleccione —</option>
                    <option value="M" <?= (($funcionario['sexo'] ?? '') === 'M') ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= (($funcionario['sexo'] ?? '') === 'F') ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro" <?= in_array(($funcionario['sexo'] ?? ''), ['Otro', 'Outro'], true) ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" name="direccion" id="direccion" value="<?= htmlspecialchars((string)($funcionario['direccion'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?= htmlspecialchars((string)($funcionario['ciudad'] ?? '')) ?>" required>
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
