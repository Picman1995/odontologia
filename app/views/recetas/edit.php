<?php 
$pageTitle = "Editar Receita";
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../../models/Dentista.php';
$dentistaModel = new Dentista();
?>

<div class="container">
    <h2>Editar Receita</h2>

    <form action="<?= BASE_URL ?>/receitas/update/<?= $receita['id_receita'] ?>" method="POST" class="form-container mt-4">

        <div class="mb-3">
            <label for="paciente_id" class="form-label">Paciente</label>
                <?php foreach ($pacientes as $paciente): ?>
                    <?php 
                        if ($paciente['id_paciente'] == $receita['paciente_id']) {
                            $id_paciente = $paciente['id_paciente'];
                            $nome_paciente = $paciente['nome'];
                        } 
                    ?>
                <?php endforeach; ?>
            <input type="text" id="search" class="form-control" placeholder="Digite um nome..." onkeyup="searchData()" value="<?= htmlspecialchars($nome_paciente) ?>">
            <div id="suggestions" class="list-group mt-2"></div>
            <input type="hidden" name="paciente_id" id="paciente_id" value="<?= $id_paciente ?>"> <!-- Campo oculto para armazenar o id_paciente -->
        </div>

        <div class="mb-3">
            <label for="dentista_id" class="form-label">Dentista</label>
            <select name="dentista_id" id="dentista_id" class="form-control" required>
                <?php foreach ($dentistas as $d): ?>
                    <?php $especialidade = $dentistaModel->getEspecialidadeNameById($d['especialidade_id']); ?>
                    <option value="<?= $d['id_dentista'] ?>" <?= $d['id_dentista'] == $receita['dentista_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($d['nome']) ?> - <?= $especialidade ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data</label>
            <input type="date" name="data" id="data" class="form-control" value="<?= $receita['data'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="conteudo" class="form-label">Conteúdo da Receita</label>
            <textarea name="conteudo" id="conteudo" rows="6" class="form-control" required><?= htmlspecialchars($receita['conteudo']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Atualizar Receita</button>
        <a href="<?= BASE_URL ?>/receitas" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
