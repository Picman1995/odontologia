<?php 
$pageTitle = "Editar Agendamento - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
$pacienteModel = new Paciente();
$pacienteName = $pacienteModel->getAll();
$dentistaModel = new Dentista();
$dentistaName = $dentistaModel->getAll();
?>
    <div class="container">
        <h1 class="text-center mt-4">Editar Agendamento</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/agendamentos/update/<?= $agendamento['id_agendamento'] ?>" method="POST">
            <div class="mb-3">
                    <label for="paciente_id" class="form-label">Paciente:</label>
                            <?php foreach ($pacienteName as $paciente): ?>
                                <?php 
                                    if ($paciente['id_paciente'] == $agendamento['paciente_id']) {
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
                    <label for="dentista_id" class="form-label">Dentista:</label>
                        <select class="form-control" name="dentista_id" id="dentista_id" required>
                                <option value="">--Escolha um Dentista--</option>
                            <?php foreach ($dentistaName as $dentista): ?>
                                <option value="<?= htmlspecialchars($dentista['id_dentista']) ?>" <?= (htmlspecialchars($dentista['id_dentista']) == htmlspecialchars($agendamento['dentista_id'])) ? "selected" : "" ?>><?= htmlspecialchars($dentista['nome']) . " - " . $dentistaModel->getEspecialidadeNameById(htmlspecialchars($dentista['especialidade_id'])) ?></option>                          
                            <?php endforeach; ?>    
                        </select>
                </div>

                <div class="mb-3">
                    <label for="data_hora" class="form-label">Data e Hora:</label>
                    <input type="datetime-local" class="form-control" name="data_hora" id="data_hora" value="<?= date('Y-m-d\TH:i', strtotime($agendamento['data_hora'])) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" name="descricao" id="descricao" rows="4" required><?= htmlspecialchars($agendamento['descricao']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-custom w-100">Atualizar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/agendamentos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
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

