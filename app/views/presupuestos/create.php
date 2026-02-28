<?php 
$pageTitle = "Cadastrar Orçamento - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
$anamneseModel = new Anamnese();
$anamneseName = $anamneseModel->getAll();
$pacienteModel = new Paciente();
$pacienteName = $pacienteModel->getAll();
$dentistaModel = new Dentista();
$dentistaName = $dentistaModel->getAll();
?>

<div class="container">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center mt-4">Cadastrar Novo Orçamento</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/orcamentos/store" method="POST">
                <div class="mb-3">
                    <label for="paciente_id" class="form-label">Paciente:</label>
                          
                        <input type="text" id="search" class="form-control" placeholder="Digite um nome..." onkeyup="searchData()">
                        <div id="suggestions" class="list-group mt-2"></div>
                        <input type="hidden" name="paciente_id" id="paciente_id"> <!-- Campo oculto para armazenar o id_paciente -->
                </div>
                <div class="mb-3">
                    <label for="dentista_id" class="form-label">Dentista:</label>
                        <select class="form-control" name="dentista_id" id="dentista_id" required>
                                <option value="">--Escolha um Dentista--</option>
                            <?php foreach ($dentistaName as $dentista): ?>
                                <?php $nomeEspecialidade = $dentistaModel->getEspecialidadeNameById($dentista['especialidade_id']); ?>
                                <option value="<?= htmlspecialchars($dentista['id_dentista']) ?>"><?= htmlspecialchars($dentista['nome']) ?> - <?= htmlspecialchars($nomeEspecialidade) ?></option>                          
                            <?php endforeach; ?>    
                        </select>
                </div>
                <div class="mb-3">
                    <label for="descricao_servico" class="form-label">Descrição do Serviço:</label>
                    <textarea class="form-control" name="descricao_servico" id="descricao_servico" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$):</label>
                    <input type="number" class="form-control" name="valor" id="valor" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" class="form-control" name="data" id="data" required>
                </div>

                <button type="submit" class="btn btn-custom w-100">Salvar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/orcamentos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
            </div>
        </div>
    </div>

    <script>
        // Função chamada a cada digitação no campo de texto
        function searchData() {
            var query = $('#search').val(); // Obtém o valor digitado no campo de texto
            
            if (query.length > 0) {
                $.ajax({
                    url: '<?= BASE_URL ?>/search_orcamento.php', // Verifique se o caminho está correto
                    method: 'GET',
                    data: { query: query }, // Envia a consulta de busca
                    success: function(response) {
                        $('#suggestions').html(response); // Exibe os resultados recebidos
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error: ' + status + ' - ' + error); // Exibe o erro no console para depuração
                        $('#suggestions').html('<p>Ocorreu um erro ao buscar os resultados. Tente novamente mais tarde.</p>'); // Exibe mensagem de erro para o usuário
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
    </script>
<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
