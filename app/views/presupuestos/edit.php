<?php 
$pageTitle = "Editar Orçamento - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
$pacienteModel = new Paciente();
$pacienteInfo = $pacienteModel->find($orcamento['paciente_id']);
$dentistaModel = new Dentista();
$dentistaInfo = $dentistaModel->find($orcamento['dentista_id']);
$anamneseModel = new Anamnese();
$anamneseInfo = $anamneseModel->find($orcamento['anamnese_id']);
$orcamentoModel= new Orcamento();
?>
 <div class="container">
        <h1 class="text-center mt-4">Editar Orçamento</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/orcamentos/update/<?= $orcamento['id_orcamento'] ?>" method="POST">
            <input type="hidden" id="paciente_id" name="paciente_id" value="<?= $orcamento['paciente_id'] ?>">
            <input type="hidden" id="dentista_id" name="dentista_id" value="<?= $orcamento['dentista_id'] ?>">
            <div class="mb-4">
                <p><strong>Paciente:</strong> <?= htmlspecialchars($pacienteInfo['nome']) ?></p>
                <p><strong>Dentista:</strong> <?= htmlspecialchars($dentistaInfo['nome']) ?></p>
                <p><strong>Nº Orçamento:</strong> <?= $orcamentoModel->gerarNumeroOrcamento($orcamento['id_orcamento']) ?></p>
                <p><strong>Nº Anamnese:</strong> 
                    <?php 
                        $ano = date("Y", strtotime($anamneseInfo['data']));
                        echo $anamneseModel->gerarNumeroAnamnese($orcamento['anamnese_id'], $ano); 
                    ?>
                </p>
            </div>

                
                <div class="mb-3">
                    <label for="descricao_servico" class="form-label">Descrição do Serviço:</label>
                    <textarea class="form-control" name="descricao_servico" id="descricao_servico" rows="4" required><?= htmlspecialchars($orcamento['descricao_servico']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$):</label>
                    <input type="number" class="form-control" name="valor" id="valor" step="0.01" value="<?= htmlspecialchars($orcamento['valor']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" class="form-control" name="data" id="data" value="<?= htmlspecialchars($orcamento['data']) ?>" required>
                </div>

                <button type="submit" class="btn btn-custom w-100">Atualizar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/orcamentos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
            </div>
        </div>
    </div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
