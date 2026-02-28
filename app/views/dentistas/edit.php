<?php 
$pageTitle = "Editar Dentista - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
$especialidadeModel = new Especialidade(); 
$especialidadeName = $especialidadeModel->getAll();
?>

<div class="container">
    <h1 class="text-center mt-4">Editar Dentista</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/dentistas/update/<?= $dentista['id_dentista'] ?>" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" name="nome" id="nome" value="<?= htmlspecialchars($dentista['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="especialidade_id" class="form-label">Especialidade:</label>
                <select class="form-control" name="especialidade_id" id="especialidade_id" required>
                    <option value="">--SELECIONE--</option>
                    <?php foreach ($especialidadeName as $especialidade): ?>
                        <option value="<?= htmlspecialchars($especialidade['id_especialidade']) ?>"
                            <?= $especialidade['id_especialidade'] == $dentista['especialidade_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($especialidade['descricao']) ?>
                        </option>
                    <?php endforeach; ?>    
                </select>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" class="form-control" name="telefone" id="telefone" value="<?= htmlspecialchars($dentista['telefone']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($dentista['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço:</label>
                <input type="text" class="form-control" name="endereco" id="endereco" value="<?= htmlspecialchars($dentista['endereco']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade:</label>
                <input type="text" class="form-control" name="cidade" id="cidade" value="<?= htmlspecialchars($dentista['cidade']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <input type="text" class="form-control" name="estado" id="estado" value="<?= htmlspecialchars($dentista['estado']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" class="form-control" name="cep" id="cep" value="<?= htmlspecialchars($dentista['cep']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="rg" class="form-label">RG:</label>
                <input type="text" class="form-control" name="rg" id="rg" value="<?= htmlspecialchars($dentista['rg']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" value="<?= htmlspecialchars($dentista['cpf']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="cro" class="form-label">CRO:</label>
                <input type="text" class="form-control" name="cro" id="cro" value="<?= htmlspecialchars($dentista['cro']) ?>" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Atualizar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/dentistas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
