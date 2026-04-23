<?php 
$pageTitle = "Editar presupuesto";
require_once __DIR__ . '/../layouts/header.php'; 
$pacienteModel = new Paciente();
$pacienteInfo = $pacienteModel->find($orcamento['paciente_id']);
$dentistaModel = new Dentista();
$dentistaInfo = $dentistaModel->find($orcamento['dentista_id']);
$anamneseModel = new Anamnese();
$anamId = (int)($orcamento['anamnesis_id'] ?? 0);
$anamneseInfo = $anamId ? $anamneseModel->find($anamId) : false;
$orcamentoModel= new Orcamento();
?>
 <div class="container">
        <h1 class="text-center mt-4">Editar presupuesto</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/presupuestos/update/<?= (int)($orcamento['id_presupuesto'] ?? 0) ?>" method="POST">
            <input type="hidden" id="paciente_id" name="paciente_id" value="<?= htmlspecialchars((string)($orcamento['paciente_id'] ?? '')) ?>">
            <input type="hidden" id="dentista_id" name="dentista_id" value="<?= htmlspecialchars((string)($orcamento['dentista_id'] ?? '')) ?>">
            <div class="mb-4">
                <p><strong>Paciente:</strong> <?= htmlspecialchars($pacienteInfo['nombre'] ?? '') ?></p>
                <p><strong>Dentista:</strong> <?= htmlspecialchars($dentistaInfo['nombre'] ?? '') ?></p>
                <p><strong>N.º presupuesto:</strong> <?= $orcamentoModel->gerarNumeroOrcamento((int)($orcamento['id_presupuesto'] ?? 0)) ?></p>
                <p><strong>N.º anamnesis:</strong> 
                    <?php 
                        $ano = (int) date('Y', strtotime(($anamneseInfo && !empty($anamneseInfo['fecha'])) ? $anamneseInfo['fecha'] : 'now'));
                        echo $anamneseModel->gerarNumeroAnamnese($anamId, $ano); 
                    ?>
                </p>
            </div>

                
                <div class="mb-3">
                    <label for="descripcion_servicio" class="form-label">Descripción del servicio</label>
                    <textarea class="form-control" name="descripcion_servicio" id="descripcion_servicio" rows="4" required><?= htmlspecialchars((string)($orcamento['descripcion_servicio'] ?? '')) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (Gs.)</label>
                    <input type="number" class="form-control" name="valor" id="valor" step="0.01" value="<?= htmlspecialchars((string)($orcamento['valor'] ?? '')) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" id="fecha" value="<?= htmlspecialchars((string)($orcamento['fecha'] ?? '')) ?>" required>
                </div>

                <button type="submit" class="btn btn-custom w-100">Actualizar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/presupuestos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver a la lista</a>
            </div>
        </div>
    </div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
