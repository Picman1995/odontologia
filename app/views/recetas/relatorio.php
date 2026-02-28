<?php 
$pageTitle = "Receita Odontológica";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container text-center mt-3">
    <img src="<?= BASE_URL ?>/images/logo.jpg" alt="Sistema Odontológico" style="max-height: 100px;">
</div>

<div class="container">
    <h1 class="text-center mt-4">RECEITUÁRIO</h1>

    <div class="form-container mt-4 p-4 rounded shadow-sm bg-dark text-light">

        <h5 class="border-bottom pb-2 mb-3">Emitente</h5>
        <p><strong>Nome:</strong> <?= htmlspecialchars($dentista['nome']) ?> (CRO: <?= htmlspecialchars($dentista['cro']) ?>)</p>
        <p><strong>Endereço:</strong> <?= htmlspecialchars($dentista['endereco']) ?></p>
        <p><strong>Cidade:</strong> <?= htmlspecialchars($dentista['cidade']) ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($dentista['estado']) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($dentista['telefone']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Cidadão</h5>
        <p><strong>Nome:</strong> <?= htmlspecialchars($paciente['nome']) ?></p>
        <p><strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf']) ?></p>
        <p><strong>Endereço:</strong> <?= htmlspecialchars($paciente['endereco']) ?></p>
        <p><strong>Cidade:</strong> <?= htmlspecialchars($paciente['cidade']) ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($paciente['estado']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Medicamentos</h5>
        <p><?= nl2br(htmlspecialchars($receita['conteudo'])) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Data: <?= date("d/m/Y", strtotime($receita['data'])) ?></h5>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/receitas/relatorio/pdf/<?= $receita['id_receita'] ?>" class="btn btn-sm btn-success" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Gerar PDF
            </a>
            <a href="<?= BASE_URL ?>/receitas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
