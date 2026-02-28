<?php 
$pageTitle = "Lista de Funcionários - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Funcionários</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/funcionarios/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Cadastrar Nova Funcionário</a>
            </div>
        </div>

    <!-- Tabela -->
    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-funcionarios" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>RG</th>
                    <th>Sexo</th>
                    <th>Endereço</th>
                    <th>CEP</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <tr>
                        <td><?= htmlspecialchars($funcionario['id_funcionario']) ?></td>
                        <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                        <td><?= htmlspecialchars($funcionario['cargo']) ?></td>
                        <td><?= htmlspecialchars($funcionario['telefone']) ?></td>
                        <td><?= htmlspecialchars($funcionario['email']) ?></td>
                        <td><?= htmlspecialchars($funcionario['cpf']) ?></td>
                        <td><?= htmlspecialchars($funcionario['rg']) ?></td>
                        <td><?= htmlspecialchars($funcionario['sexo']) ?></td>
                        <td><?= htmlspecialchars($funcionario['endereco']) ?></td>
                        <td><?= htmlspecialchars($funcionario['cep']) ?></td>
                        <td><?= htmlspecialchars($funcionario['cidade']) ?></td>
                        <td><?= htmlspecialchars($funcionario['estado']) ?></td>
                        <td>
                                                                    
                            <a href="<?= BASE_URL ?>/funcionarios/edit/<?= $funcionario['id_funcionario'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/funcionarios/delete/<?= $funcionario['id_funcionario'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este orçamento?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">
            Voltar para o Dashboard
        </a>
    </div>
    </div>
    <script>
    $(document).ready(function () {
        $('#tabela-funcionarios').DataTable({
            "scrollX": true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });
    });
    </script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
