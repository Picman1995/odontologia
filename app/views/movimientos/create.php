<?php 
$pageTitle = "Nuevo Lanzamiento - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php';
$orcamentoModel = new Orcamento();
?>

<div class="container">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <h1 class="text-center mt-4">Registrar Pago/Transacción</h1>

    <div class="form-container">
        <form method="POST" action="<?= BASE_URL ?>/movimientos/store">
            <div class="mb-3">
                <label for="paciente_id" class="form-label">Paciente:</label>
                
                <input type="text" id="search" class="form-control" placeholder="Escribe el nombre..." onkeyup="searchData()">
                <div id="suggestions" class="list-group mt-2"></div>
                <input type="hidden" name="paciente_id" id="paciente_id"> <!-- Campo oculto para armazenar o id_paciente -->

            </div>

            <div class="mb-3">
                <label for="presupuesto_id" class="form-label">Presupuesto:</label>
                <select class="form-control" name="presupuesto_id" id="presupuesto_id" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($orcamentos as $orcamento): ?>
                        <option value="<?= $orcamento['id_presupuesto'] ?>">
                            #<?= $orcamentoModel->gerarNumeroOrcamento($orcamento['id_presupuesto']) ?> - Paciente: <?= $orcamentoModel->getPacienteNameById($orcamento['paciente_id']) ?> - Servicio: <?= $orcamento['descripcion_servicio'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="data_lancamento" class="form-label">Data:</label>
                <input type="date" class="form-control" name="fecha_movimiento" id="fecha_movimiento" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <select class="form-control" name="tipo" id="tipo" required>
                    <option value="credito">Crédito (Entrada)</option>
                    <option value="debito">Débito (Salida)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <select class="form-control" name="categoria" id="categoria">
                    <option value="cobro">Cobro</option>
                    <option value="descuento">Descuento</option>
                    <option value="reembolso">Reembolso</option>
                    <option value="otros">Otros</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor (Gs):</label>
                <input type="number" step="0.01" name="valor" id="valor" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descripcion:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-custom w-100">Guardar</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/movimientos" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">← Volver a la lista</a>
        </div>
    </div>
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
        function selectPatient(id, nombre) {
            $('#search').val(nombre);  // Atualiza o valor do input com o nombre do paciente
            $('#paciente_id').val(id);  // Atualiza o campo oculto com o id_paciente
            $('#suggestions').html(''); // Limpa as sugestões após a seleção
        }
    </script>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
