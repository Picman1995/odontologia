<?php 
$pageTitle = "Cadastrar Dentista - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
$especialidadeModel = new Especialidade(); 
$especialidadeName = $especialidadeModel->getAll();
?>

<div class="container">
    <h1 class="text-center mt-4">Registrar un nuevo dentista</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/dentistas/store" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>

            <div class="mb-3">
                <label for="especialidad_id" class="form-label">Especialidad:</label>
                <select class="form-control" name="especialidad_id" id="especialidad_id">
                <option value="">— Seleccione —</option>
                    <?php foreach ($especialidadeName as $especialidade): ?>
                        <option value="<?= htmlspecialchars((string)($especialidade['id_especialidad'] ?? '')) ?>">
                            <?= htmlspecialchars((string)($especialidade['descripcion'] ?? '')) ?>
                        </option>                          
                    <?php endforeach; ?>    
                </select>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono:</label>
                <input type="text" class="form-control" name="telefono" id="telefono" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Direccion:</label>
                <input type="text" class="form-control" name="direccion" id="direccion" required>
            </div>

            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <input type="text" class="form-control" name="estado" id="estado" required>
            </div>

            <div class="mb-3">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" class="form-control" name="cep" id="cep" required>
            </div>

            <div class="mb-3">
                <label for="rg" class="form-label">RG:</label>
                <input type="text" class="form-control" name="rg" id="rg" required>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" required>
            </div>

            <div class="mb-3">
                <label for="cro" class="form-label">CRO:</label>
                <input type="text" class="form-control" name="cro" id="cro" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Salvar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/dentistas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
