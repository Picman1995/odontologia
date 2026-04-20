<?php 
$pageTitle = "Editar Paciente - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>
<div class="container">
    <h1 class="text-center mt-4">Editar Paciente</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/pacientes/update/<?= $paciente['id_paciente'] ?>" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?= htmlspecialchars($paciente['nombre']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="<?= htmlspecialchars((string)($paciente['fecha_nacimiento'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo" required>
                    <option value="">Seleccione</option>
                    <option value="M" <?= ($paciente['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= ($paciente['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro" <?= ($paciente['sexo'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">Cédula de identidad:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" maxlength="24" autocomplete="off" value="<?= htmlspecialchars((string)($paciente['cpf'] ?? '')) ?>">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" name="direccion" id="direccion" value="<?= htmlspecialchars((string)($paciente['direccion'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?= htmlspecialchars((string)($paciente['ciudad'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" id="telefono" value="<?= htmlspecialchars((string)($paciente['telefono'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars((string)($paciente['email'] ?? '')) ?>" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Atualizar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/pacientes" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver a la lista</a>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
