<?php 
$pageTitle = "Sistema Odontológico";
require_once __DIR__ . '/layouts/header.php';
$pacienteModel = new Paciente();
$totalPacientes = $pacienteModel->total();
$dentistaModel = new Dentista();
$totalDentistas = $dentistaModel->total();
$funcionarioModel = new Funcionario();
$totalFuncionarios = $funcionarioModel->total();
$especialidadeModel = new Especialidade();
$totalEspecialidades = $especialidadeModel->total();
$anamneseModel = new Anamnese();
$totalAnamneses = $anamneseModel->total();
$orcamentoModel = new Orcamento();
$totalOrcamentos = $orcamentoModel->total();
$agendamentoModel = new Agendamento();
$totalAgendamentos = $agendamentoModel->total();
?>

<div class="container mt-5 text-center">
    <img src="<?= BASE_URL ?>/images/logo.jpg" alt="Logo Sistema Odontológico" class="img-fluid mb-4" style="max-height: 100px;">
    <h2 class="mb-4">Bem-vindo, <?=  $_SESSION[SESSION_NAME]['name'] ?? 'Usuário' ?>!</h2>

    <!-- Container escuro com informações do usuário -->
    <div class="container mt-4">
        <div class="card bg-dark text-white shadow-sm px-4 py-3">
            <h4 class="text-center mb-4"><i class="bi bi-person-circle me-2"></i>Informações do Usuário</h4>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <strong class="me-2">Email:</strong> 
                        <span><?= htmlspecialchars($_SESSION[SESSION_NAME]['email']) ?></span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-badge-fill me-2"></i>
                        <strong class="me-2">Nível:</strong> 
                        <span class="text-capitalize"><?= htmlspecialchars($_SESSION[SESSION_NAME]['type']) ?></span>
                    </div>
                </div>
            </div>
      
            <br>

            <h4 class="text-center mb-3"><i class="bi bi-hospital-fill me-2"></i>Informações da Clínica</h4>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-hospital-fill me-2"></i>
                    <strong class="me-2">Nome:</strong> 
                    <span><?= htmlspecialchars(NOME_CLINICA) ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-geo-alt-fill me-2"></i>
                    <strong class="me-2">Endereço:</strong> 
                    <span><?= htmlspecialchars(ENDERECO_CLINICA) ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-buildings me-2"></i>
                    <strong class="me-2">Cidade:</strong> 
                    <span><?= htmlspecialchars(CIDADE_CLINICA) ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-globe-americas me-2"></i>
                    <strong class="me-2">Estado:</strong> 
                    <span><?= htmlspecialchars(ESTADO_CLINICA) ?></span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-mailbox me-2"></i>
                    <strong class="me-2">CEP:</strong> 
                    <span><?= htmlspecialchars(CEP_CLINICA) ?></span>
                </div>
            </div>
        </div>


        </div>

    </div>



    <div class="row row-cols-1 row-cols-md-4 g-4 mt-4 justify-content-center">
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Pacientes</h5>
                    <p class="card-text display-6"><?= $totalPacientes ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Dentistas</h5>
                    <p class="card-text display-6"><?= $totalDentistas ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Funcionários</h5>
                    <p class="card-text display-6"><?= $totalFuncionarios ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Especialidades</h5>
                    <p class="card-text display-6"><?= $totalEspecialidades ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Anamneses</h5>
                    <p class="card-text display-6"><?= $totalAnamneses ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Orçamentos</h5>
                    <p class="card-text display-6"><?= $totalOrcamentos ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Agendamentos</h5>
                    <p class="card-text display-6"><?= $totalAgendamentos ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/layouts/footer.php';
?>
