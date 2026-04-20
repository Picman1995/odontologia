<?php 
$pageTitle = "Cadastrar Anamnese - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
$pacienteModel = new Paciente();
$pacienteName = $pacienteModel->getAll();
$dentistaModel = new Dentista();
$dentistaName = $dentistaModel->getAll();
?>

    <div class="container">
        <h1 class="text-center mt-4">Ficha de Anamnese Odontológica</h1>

        <div class="form-container">
            <form action="<?= BASE_URL ?>/anamneses/store" method="POST">
                <div class="mb-3">
                    <label for="dentista_id" class="form-label">Dentista:</label>
                        <select class="form-control" name="dentista_id" id="dentista_id" required>
                                <option value="">--Escolha um Dentista--</option>
                            <?php foreach ($dentistaName as $dentista): ?>
                                <?php $especialidade = $dentistaModel->getEspecialidadeNameById((int)($dentista['especialidad_id'] ?? 0)); ?>
                                <option value="<?= htmlspecialchars($dentista['id_dentista']) ?>"><?= htmlspecialchars($dentista['nombre']) ?> - <?= $especialidade ?></option>                          
                            <?php endforeach; ?>    
                        </select>
                </div>

                <div class="mb-3">
                    <label for="paciente_id" class="form-label">Paciente:</label>

                        <input type="text" id="search" class="form-control" placeholder="Escribe el nombre..." onkeyup="searchData()">
                        <div id="suggestions" class="list-group mt-2"></div>
                        <input type="hidden" name="paciente_id" id="paciente_id"> <!-- Campo oculto para armazenar o id_paciente -->

                        
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descripcion:</label>
                    <textarea class="form-control" name="descricao" id="descricao" rows="20" required>
Queixa principal:


--------------------------------------------
Histórico médico:
1. Sofre de alguma doença: ( ) Sim ( ) Não
1.1 Em caso positivo, qual (is):
2. Está fazendo tratamento médico atualmente: ( ) Sim ( ) Não
2.1 Em caso positivo, qua l(is):
2.2 Nombre do médico responsável:
2.3 Telefono para contato:
3. Está fazendo uso de medicação: ( ) Sim ( ) Não3.1 Em caso positivo, qual (is):
4. Está grávida: ( ) Sim ( ) Não
4.1 Em caso positivo, qual a idade gestacional: ___semanas e ___dias
5. Possui algum tipo de alergias: ( ) Sim ( ) Não
5.1 Em caso positivo, qual (is):
6. Já foi submetido a procedimento cirúrgico: ( ) Sim ( ) Não
6.1 Em caso positivo, qual (is):
6.2 Teve problemas com a cicatrização: ( ) Sim ( ) Não
6.3 Teve problemas com a anestesia: ( ) Sim ( ) Não
6.4 Teve problemas de hemorragia: ( ) Sim ( ) Não
7. Sofreu alguma das seguintes doenças:
7.1 Febre Reumática: ( ) Sim ( ) Não
7.2 Problemas Cardíacos: ( ) Sim ( ) Não
7.2.1 Em caso positivo, qual (is):
7.2.2 Histórico Familiar: ( ) Sim ( ) Não
                    </textarea>
                </div>

                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" class="form-control" name="data" id="data" required>
                </div>

                <button type="submit" class="btn btn-custom w-100">Salvar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/anamneses" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
            </div>
        </div>
    </div>

    
    <script>
        function searchData() {
            var query = $('#search').val(); 
            
            if (query.length > 0) {
                $.ajax({
                    url: '<?= BASE_URL ?>/search.php', 
                    method: 'GET',
                    data: { query: query }, 
                    success: function(response) {
                        $('#suggestions').html(response); 
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error: ' + status + ' - ' + error);
                        $('#suggestions').html('<p>Ocorreu um erro ao buscar os resultados. Tente novamente mais tarde.</p>'); // Exibe mensagem de erro para o usuário
                    }
                });
            } else {
                $('#suggestions').html(''); 
            }
        }

        function selectPatient(id, nombre) {
            $('#search').val(nombre); 
            $('#paciente_id').val(id);
            $('#suggestions').html(''); 
        }
    </script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
