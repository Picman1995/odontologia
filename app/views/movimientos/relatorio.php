<?php
$pageTitle = "Relatório de Lanzamientos";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-5">
    <div class="card bg-dark text-light p-4 rounded-4 shadow">
        <h2 class="text-center mb-4">Relatório de Lanzamientos</h2>

        <!-- Informacciones do Paciente -->
        <div class="mb-4">
            <h5 class="mb-3">Dados do Paciente</h5>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>RG:</strong> <?= htmlspecialchars($paciente['rg']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($paciente['data_nascimento'])) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Sexo:</strong> <?= htmlspecialchars($paciente['sexo']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Telefono:</strong> <?= htmlspecialchars($paciente['telefono']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>CEP:</strong> <?= htmlspecialchars($paciente['cep']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Direccion:</strong> <?= htmlspecialchars($paciente['endereco']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Ciudad:</strong> <?= htmlspecialchars($paciente['ciudades']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Estado:</strong> <?= htmlspecialchars($paciente['estado']) ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($paciente['created_at'])) ?>
                </div>
            </div>
        </div>

        <!-- Tabela de Lanzamientos -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Valor (Gs)</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lanzamientos as $l): ?>
                        <tr>
                            <td><?= $l['id_lancamento'] ?></td>
                            <td><?= date('d/m/Y', strtotime($l['data_lancamento'])) ?></td>
                            <td class="<?= $l['tipo'] === 'credito' ? 'text-success' : 'text-danger' ?>">
                                <?= ucfirst($l['tipo']) ?>
                            </td>
                            <td><?= ucfirst($l['categoria']) ?></td>
                            <td>R$ <?= number_format($l['valor'], 2, ',', '.') ?></td>
                            <td><?= nl2br(htmlspecialchars($l['descricao'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Saldo final -->
        <h4 class="text-end mt-3">Saldo: 
            <span class="<?= $saldo >= 0 ? 'text-success' : 'text-danger' ?>">
                R$ <?= number_format($saldo, 2, ',', '.') ?>
            </span>
        </h4>

        <!-- Botões -->
        <div class="text-center mt-4 d-flex flex-column flex-md-row justify-content-center gap-2">
            <a href="<?= BASE_URL ?>/lanzamientos/relatorio/pdf/<?= $paciente['id_paciente'] ?>" class="btn btn-success px-4 shadow-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Generar PDF
            </a>
            <a href="<?= BASE_URL ?>/lanzamientos" class="btn btn-outline-light px-4 shadow-sm">
                ← Voltar
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
