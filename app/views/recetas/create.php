<?php 
$pageTitle = "Nova Receita";
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../../models/Dentista.php';
$dentistaModel = new Dentista();
?>

<div class="container">
    <h2>Nova Receita</h2>

    <form action="<?= BASE_URL ?>/receitas/store" method="POST" class="form-container mt-4">

        <div class="mb-3">
            <label for="paciente_id" class="form-label">Paciente</label>
                <input type="text" id="search" class="form-control" placeholder="Digite um nome..." onkeyup="searchData()">
                <div id="suggestions" class="list-group mt-2"></div>
                <input type="hidden" name="paciente_id" id="paciente_id"> <!-- Campo oculto para armazenar o id_paciente -->
        </div>

        <div class="mb-3">
            <label for="dentista_id" class="form-label">Dentista</label>
            <select name="dentista_id" id="dentista_id" class="form-control" required>
                <option value="">Selecione um dentista</option>
                <?php foreach ($dentistas as $d): ?>
                    <?php $especialidade = $dentistaModel->getEspecialidadeNameById($d['especialidade_id']); ?>
                    <option value="<?= $d['id_dentista'] ?>"><?= htmlspecialchars($d['nome']) ?> - <?= $especialidade ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data</label>
            <input type="date" name="data" id="data" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label for="conteudo" class="form-label">Conteúdo da Receita</label>
            <textarea name="conteudo" id="conteudo" rows="10" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-custom w-100">Salvar</button>
        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/receitas" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </form>
    
</div>

    <script>
        // Função chamada a cada digitação no campo de texto
        function searchData() {
            var query = $('#search').val(); // Obtém o valor digitado no campo de texto
            
            if (query.length > 0) {
                $.ajax({
                    url: '<?= BASE_URL ?>/search.php', // Verifique se o caminho está correto
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
