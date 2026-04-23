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
        <p><strong>Nombre:</strong> <?= htmlspecialchars($dentista['nombre']) ?> <?php $mp = (string)($dentista['matricula_profesional'] ?? ''); ?><?= $mp !== '' ? '(Matrícula profesional: ' . htmlspecialchars($mp) . ')' : '' ?></p>
        <p><strong>Direccion:</strong> <?= htmlspecialchars((string)($dentista['direccion'] ?? '')) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars((string)($dentista['ciudad'] ?? '')) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($dentista['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Cidadão</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></p>
        <p><strong>Cédula:</strong> <?= htmlspecialchars((string)($paciente['cpf'] ?? '')) ?></p>
        <p><strong>Direccion:</strong> <?= htmlspecialchars((string)($paciente['direccion'] ?? '')) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars((string)($paciente['ciudad'] ?? '')) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Medicamentos</h5>
        <p><?= nl2br(htmlspecialchars((string)($receita['contenido'] ?? ''))) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Fecha: <?= !empty($receita['fecha']) ? date("d/m/Y", strtotime($receita['fecha'])) : '—' ?></h5>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/recetas/relatorio/pdf/<?= (int)($receita['id_receta'] ?? 0) ?>" class="btn btn-sm btn-success" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Generar PDF
            </a>
            <a href="<?= BASE_URL ?>/recetas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">volver a la lista</a>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
