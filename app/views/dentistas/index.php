<?php 
$pageTitle = "Lista de Dentistas - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
$dentistaModel = new Dentista();
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dentistas</h1>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/dentistas/create" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Cadastrar Novo Dentista</a>
            </div>
        </div>

    <!-- Tabela -->
    <div class="table-responsive bg-dark p-3 rounded shadow-sm">
        <table id="tabela-dentistas" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Especialidade</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>CEP</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>CRO</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dentistas as $dentista): ?>
                    <tr>
                        <td><?= htmlspecialchars($dentista['id_dentista']) ?></td>
                        <td><?= htmlspecialchars($dentista['nome']) ?></td>
                        <td>
                            <?php
                                $nomeEspecialidade = $dentistaModel->getEspecialidadeNameById($dentista['especialidade_id']);
                                echo $nomeEspecialidade;
                            ?>
                        </td>
                        <td><?= htmlspecialchars($dentista['telefone']) ?></td>
                        <td><?= htmlspecialchars($dentista['email']) ?></td>
                        <td><?= htmlspecialchars($dentista['endereco']) ?></td>
                        <td><?= htmlspecialchars($dentista['cidade']) ?></td>
                        <td><?= htmlspecialchars($dentista['estado']) ?></td>
                        <td><?= htmlspecialchars($dentista['cep']) ?></td>
                        <td><?= htmlspecialchars($dentista['rg']) ?></td>
                        <td><?= htmlspecialchars($dentista['cpf']) ?></td>
                        <td><?= htmlspecialchars($dentista['cro']) ?></td>
                        <td>
                                                                
                            <a href="<?= BASE_URL ?>/dentistas/edit/<?= $dentista['id_dentista'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/dentistas/delete/<?= $dentista['id_dentista'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este orçamento?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>d
    
    <div class="d-flex justify-content-end mt-3">
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">
            Voltar para o Dashboard
        </a>
    </div>
    </div>
    <script>
    $(document).ready(function () {
        $('#tabela-dentistas').DataTable({
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
