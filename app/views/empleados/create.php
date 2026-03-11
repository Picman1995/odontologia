<?php 
$pageTitle = "Cadastrar Funcionário - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container">
    <h1 class="text-center mt-4">Cadastrar Nuevo Funcionário</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/funcionarios/store" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" class="form-control" name="cargo" id="cargo" required>
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
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" required>
            </div>

            <div class="mb-3">
                <label for="rg" class="form-label">RG:</label>
                <input type="text" class="form-control" name="rg" id="rg" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo" required>
                    <option value="">Selecione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Direccion:</label>
                <input type="text" class="form-control" name="endereco" id="endereco" required>
            </div>

            <div class="mb-3">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" class="form-control" name="cep" id="cep" required>
            </div>

            <div class="mb-3">
                <label for="ciudades" class="form-label">Ciudad:</label>
                <input type="text" class="form-control" name="ciudades" id="ciudades" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado (UF):</label>
                <input type="text" class="form-control" name="estado" id="estado" maxlength="2" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Salvar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/funcionarios" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>

