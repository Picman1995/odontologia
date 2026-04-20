<?php 
$pageTitle = "Orçamento - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container text-center mt-3">
    <img src="<?= BASE_URL ?>/images/logo.jpg" alt="Sistema Odontológico" style="max-height: 100px;">
</div>

<div class="container">
    <h1 class="text-center mt-4"><?= htmlspecialchars($numeroOrcamento) ?></h1>

    <div class="form-container mt-4 p-4 rounded shadow-sm bg-dark text-light">

        <h5 class="border-bottom pb-2 mb-3">Informacciones do Paciente</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?= !empty($paciente['fecha_nacimiento']) ? htmlspecialchars(date("d/m/Y", strtotime($paciente['fecha_nacimiento']))) : '—' ?></p>
        <p><strong>Cédula:</strong> <?= htmlspecialchars((string)($paciente['cpf'] ?? '')) ?></p>
        <p><strong>Direccion:</strong> <?= htmlspecialchars((string)($paciente['direccion'] ?? '')) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars((string)($paciente['ciudad'] ?? '')) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Informacciones do Dentista</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($dentista['nombre']) ?></p>
        <p><strong>Especialidade:</strong> <?= htmlspecialchars($especialidade) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($dentista['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>
        <p><strong>CRO:</strong> <?= htmlspecialchars($dentista['cro']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Informacciones do Orçamento</h5>
        <p><strong>Serviço:</strong><br> <?=  nl2br(htmlspecialchars($orcamento['descricao_servico'])) ?></p>
        <p><strong>Valor:</strong> R$ <?= number_format($orcamento['valor'], 2, ',', '.') ?></p>
        <h5 class="border-bottom pb-2 mb-3 mt-4"><strong>Data:</strong> <?= htmlspecialchars(date("d/m/Y", strtotime($orcamento['data']))) ?></h5>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/orcamentos/relatorio/pdf/<?= $orcamento['id_orcamento'] ?>" class="btn btn-sm btn-success" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Generar PDF
            </a>
            <a href="<?= BASE_URL ?>/orcamentos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
