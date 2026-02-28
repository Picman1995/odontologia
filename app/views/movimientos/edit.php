<?php 
$pageTitle = "Novo Lançamento - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
$orcamentoModel = new Orcamento();
$orcamentos = $orcamentoModel->getAll();
$pacienteModel = new Paciente();
$pacientes = $pacienteModel->getAll();
?>

<div class="container">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <h1 class="text-center mt-4">Editar Pagamento / Lançamento</h1>

    <div class="form-container">
        <form method="POST" action="<?= BASE_URL ?>/lancamentos/update/<?= $lancamento['id_movimiento'] ?>">
            <div class="mb-3">
                <label for="paciente_id" class="form-label">Paciente:</label>
                    <?php foreach ($pacientes as $paciente): ?>
                        <?php 
                            if ($paciente['id_paciente'] == $lancamento['paciente_id']) {
                                $id_paciente = $paciente['id_paciente'];
                                $nome_paciente = $paciente['nombre'];
                            } 
                        ?>
                    <?php endforeach; ?>                
                <input type="text" id="search" class="form-control" placeholder="Digite um nome..." onkeyup="searchData()" value="<?= htmlspecialchars($nome_paciente) ?>">
                <div id="suggestions" class="list-group mt-2"></div>
                <input type="hidden" name="paciente_id" id="paciente_id" value="<?= $id_paciente ?>"> <!-- Campo oculto para armazenar o id_paciente -->
            </div>

            <div class="mb-3">
                <label for="orcamento_id" class="form-label">Orçamento:</label>
                <select class="form-control" name="presupuesto_id" id="presupuesto_id" required>
                    <option value="">Selecione</option>
                    <?php foreach ($orcamentos as $orcamento): ?>
                        <?php if ($orcamento['paciente_id'] == $lancamento['paciente_id']): ?>
                            <option value="<?= $orcamento['id_presupuesto'] ?>" <?= $orcamento['id_presupuesto'] === $lancamento['presupuesto_id'] ? 'selected' : '' ?>>#<?= $orcamentoModel->gerarNumeroOrcamento($orcamento['id_presupuesto']) ?> - Paciente: <?= $orcamentoModel->getPacienteNameById($orcamento['paciente_id']) ?> - Servicio: <?= $orcamento['descripcion_servicio'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="data_lancamento" class="form-label">Data:</label>
                <input type="date" class="form-control" name="fecha_movimiento" id="fecha_movimiento" value="<?= htmlspecialchars($lancamento['fecha_movimiento']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <select class="form-control" name="tipo" id="tipo" required>
                    <option value="credito" <?= $lancamento['tipo'] === 'credito' ? 'selected' : '' ?>>Crédito (Entrada)</option>    
                    <option value="debito" <?= $lancamento['tipo'] === 'debito' ? 'selected' : '' ?>>Débito (Saída)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <select class="form-control" name="categoria" id="categoria">
                    <option value="recebimento" <?= $lancamento['categoria'] === 'recebimento' ? 'selected' : '' ?>>Recebimento</option>
                    <option value="desconto" <?= $lancamento['categoria'] === 'desconto' ? 'selected' : '' ?>>Desconto</option>
                    <option value="estorno" <?= $lancamento['categoria'] === 'estorno' ? 'selected' : '' ?>>Estorno</option>
                    <option value="outros" <?= $lancamento['categoria'] === 'outros' ? 'selected' : '' ?>>Outros</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor (R$):</label>
                <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="<?= $lancamento['valor'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"><?= htmlspecialchars($lancamento['descripcion']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-custom w-100">Atualizar Lançamento</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/lancamentos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">← Voltar para lista</a>
        </div>
    </div>
</div>


    <script>
        // Função chamada a cada digitação no campo de texto
        function searchData() {
            var query = $('#search').val(); // Obtém o valor digitado no campo de texto
            
            if (query.length > 0) {
                $.ajax({
                    url: '<?= BASE_URL ?>/search.php', // Arquivo que irá processar a requisição
                    method: 'GET',
                    data: { query: query }, // Envia a consulta de busca
                    success: function(response) {
                        $('#suggestions').html(response); // Exibe os resultados recebidos
                    }
                });
            } else {
                $('#suggestions').html(''); // Limpa as sugestões se o campo estiver vazio
            }
        }

        // Função para selecionar um item da lista de sugestões
        function selectPatient(id, nome) {
            $('#search').val(nome);  // Atualiza o valor do input com o nome do paciente
            $('#paciente_id').val(id);  // Atualiza o campo oculto com o id_paciente
            $('#suggestions').html(''); // Limpa as sugestões após a seleção
        }

        // Caso os valores já existam, preenche diretamente no carregamento
        $(document).ready(function() {
            var pacienteId = $('#paciente_id').val();
            var pacienteNome = $('#search').val();

            // Se tiver um id paciente e nome já definidos, faz a seleção automaticamente
            if (pacienteId && pacienteNome) {
                $('#search').val(pacienteNome);
                $('#paciente_id').val(pacienteId);
            }
        });
    </script>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
