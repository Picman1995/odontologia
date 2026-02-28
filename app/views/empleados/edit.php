<?php 
$pageTitle = "Editar Funcionário - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container">
    <h1 class="text-center mt-4">Editar Funcionário</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/funcionarios/update/<?= $funcionario['id_funcionario'] ?>" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" name="nome" id="nome" value="<?= htmlspecialchars($funcionario['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" class="form-control" name="cargo" id="cargo" value="<?= htmlspecialchars($funcionario['cargo']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" class="form-control" name="telefone" id="telefone" value="<?= htmlspecialchars($funcionario['telefone']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($funcionario['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" value="<?= htmlspecialchars($funcionario['cpf']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="rg" class="form-label">RG:</label>
                <input type="text" class="form-control" name="rg" id="rg" value="<?= htmlspecialchars($funcionario['rg']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo" required>
                    <option value="">Selecione</option>
                    <option value="M" <?= $funcionario['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= $funcionario['sexo'] === 'F' ? 'selected' : '' ?>>Feminino</option>
                    <option value="Outro" <?= $funcionario['sexo'] === 'Outro' ? 'selected' : '' ?>>Outro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço:</label>
                <input type="text" class="form-control" name="endereco" id="endereco" value="<?= htmlspecialchars($funcionario['endereco']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" class="form-control" name="cep" id="cep" value="<?= htmlspecialchars($funcionario['cep']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade:</label>
                <input type="text" class="form-control" name="cidade" id="cidade" value="<?= htmlspecialchars($funcionario['cidade']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado (UF):</label>
                <input type="text" class="form-control" name="estado" id="estado" maxlength="2" value="<?= htmlspecialchars($funcionario['estado']) ?>" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Atualizar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/funcionarios" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
