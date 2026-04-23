<?php 
$pageTitle = "Presupuesto";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container text-center mt-3">
    <img src="<?= BASE_URL ?>/images/logo.jpg" alt="Sistema Odontológico" style="max-height: 100px;">
</div>

<div class="container">
    <h1 class="text-center mt-4"><?= htmlspecialchars($numeroOrcamento) ?></h1>

    <div class="form-container mt-4 p-4 rounded shadow-sm bg-dark text-light">

        <h5 class="border-bottom pb-2 mb-3">Datos del paciente</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?= !empty($paciente['fecha_nacimiento']) ? htmlspecialchars(date("d/m/Y", strtotime($paciente['fecha_nacimiento']))) : '—' ?></p>
        <p><strong>Cédula:</strong> <?= htmlspecialchars((string)($paciente['cpf'] ?? '')) ?></p>
        <p><strong>Dirección:</strong> <?= htmlspecialchars((string)($paciente['direccion'] ?? '')) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars((string)($paciente['ciudad'] ?? '')) ?></p>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Datos del dentista</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($dentista['nombre']) ?></p>
        <p><strong>Especialidad:</strong> <?= htmlspecialchars($especialidade) ?></p>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($dentista['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>
        <p><strong>Matrícula profesional:</strong> <?= htmlspecialchars((string)($dentista['matricula_profesional'] ?? '')) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Detalle del presupuesto</h5>
        <p><strong>Servicio:</strong><br> <?=  nl2br(htmlspecialchars((string)($orcamento['descripcion_servicio'] ?? ''))) ?></p>
        <p><strong>Valor:</strong> Gs. <?= number_format((float)($orcamento['valor'] ?? 0), 2, ',', '.') ?></p>
        <h5 class="border-bottom pb-2 mb-3 mt-4"><strong>Fecha:</strong> <?= htmlspecialchars(date("d/m/Y", strtotime((string)($orcamento['fecha'] ?? '')))) ?></h5>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/presupuestos/relatorio/pdf/<?= (int)($orcamento['id_presupuesto'] ?? 0) ?>" class="btn btn-sm btn-success" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Generar PDF
            </a>
            <a href="<?= BASE_URL ?>/presupuestos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver a la lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
