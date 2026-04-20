<?php

require_once __DIR__ . '/../config/Database.php';

// Controllers
require_once __DIR__ . '/../app/controllers/PacienteController.php';
require_once __DIR__ . '/../app/controllers/DentistaController.php';
require_once __DIR__ . '/../app/controllers/FuncionarioController.php';
require_once __DIR__ . '/../app/controllers/EspecialidadeController.php';
require_once __DIR__ . '/../app/controllers/AnamneseController.php';
require_once __DIR__ . '/../app/controllers/OrcamentoController.php';
require_once __DIR__ . '/../app/controllers/AgendamentoController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/VerificarController.php';
require_once __DIR__ . '/../app/controllers/ReceitaController.php';
require_once __DIR__ . '/../app/controllers/LancamentoController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

// Conexión con la base de datos
$db = (new Database())->connect();

// Inicializar controladores
$pacienteController = new PacienteController();
$dentistaController = new DentistaController();
$funcionarioController = new FuncionarioController();
$especialidadeController = new EspecialidadeController();
$anamneseController = new AnamneseController();
$orcamentoController = new OrcamentoController();
$agendamentoController = new AgendamentoController();
$authController = new AuthController();
$verificarController = new VerificarController();
$receitaController = new ReceitaController();
$lancamentoController = new LancamentoController();
$usuarioController = new UsuarioController();

// URI y método (BASE_PATH se define en config.php: vacío para servidor embebido, /odontologia/public para Apache)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = (defined('BASE_PATH') && BASE_PATH !== '') ? str_replace(BASE_PATH, '', $uri) : $uri;
if ($uri === false || $uri === '') {
    $uri = '/';
}

// Rutas antiguas en portugués (/receitas/...) → mismas reglas que /recetas/...
if (str_starts_with($uri, '/receitas')) {
    $uri = '/recetas' . (strlen($uri) > 9 ? substr($uri, 9) : '');
}
if (str_starts_with($uri, '/lanzamientos')) {
    $uri = '/movimientos' . (strlen($uri) > 13 ? substr($uri, 13) : '');
}

$method = $_SERVER['REQUEST_METHOD'];

if ($uri == '/') {
    require __DIR__ . '/../app/views/dashboard.php';
}

// Verificar Token
elseif (preg_match('/\/verificar\/([a-zA-Z0-9]+)/', $uri, $matches)) {
    $verificarController->verificar($matches[1]);
}

// Login
elseif ($uri == '/login' && $method == 'GET') {
    $authController->showLoginForm();
} elseif ($uri == '/login' && $method == 'POST') {
    $authController->login();
} elseif ($uri == '/logout') {
    $authController->logout();
}

// Pacientes
elseif ($uri == '/pacientes') {
    $pacienteController->index();
} elseif ($uri == '/pacientes/create') {
    $pacienteController->create();
} elseif ($uri == '/pacientes/store' && $method == 'POST') {
    $pacienteController->store();
} elseif (preg_match('/\/pacientes\/edit\/(\d+)/', $uri, $matches)) {
    $pacienteController->edit($matches[1]);
} elseif (preg_match('/\/pacientes\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $pacienteController->update($matches[1]);
} elseif (preg_match('/\/pacientes\/delete\/(\d+)/', $uri, $matches)) {
    $pacienteController->delete($matches[1]);
}

// Dentistas
elseif ($uri == '/dentistas') {
    $dentistaController->index();
} elseif ($uri == '/dentistas/create') {
    $dentistaController->create();
} elseif ($uri == '/dentistas/store' && $method == 'POST') {
    $dentistaController->store();
} elseif (preg_match('/\/dentistas\/edit\/(\d+)/', $uri, $matches)) {
    $dentistaController->edit($matches[1]);
} elseif (preg_match('/\/dentistas\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $dentistaController->update($matches[1]);
} elseif (preg_match('/\/dentistas\/delete\/(\d+)/', $uri, $matches)) {
    $dentistaController->delete($matches[1]);
}

// Empleados
elseif ($uri == '/empleados') {
    $funcionarioController->index();
} elseif ($uri == '/empleados/create') {
    $funcionarioController->create();
} elseif ($uri == '/empleados/store' && $method == 'POST') {
    $funcionarioController->store();
} elseif (preg_match('/\/empleados\/edit\/(\d+)/', $uri, $matches)) {
    $funcionarioController->edit($matches[1]);
} elseif (preg_match('/\/empleados\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $funcionarioController->update($matches[1]);
} elseif (preg_match('/\/empleados\/delete\/(\d+)/', $uri, $matches)) {
    $funcionarioController->delete($matches[1]);
}

// Especialidade
elseif ($uri == '/especialidades') {
    $especialidadeController->index();
} elseif ($uri == '/especialidades/create') {
    $especialidadeController->create();
} elseif ($uri == '/especialidades/store' && $method == 'POST') {
    $especialidadeController->store();
} elseif (preg_match('/\/especialidades\/edit\/(\d+)/', $uri, $matches)) {
    $especialidadeController->edit($matches[1]);
} elseif (preg_match('/\/especialidades\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $especialidadeController->update($matches[1]);
} elseif (preg_match('/\/especialidades\/delete\/(\d+)/', $uri, $matches)) {
    $especialidadeController->delete($matches[1]);
}

// Anamnesis
elseif ($uri == '/anamnesis') {
    $anamneseController->index();
} elseif ($uri == '/anamnesis/create') {
    $anamneseController->create();
} elseif ($uri == '/anamnesis/store' && $method == 'POST') {
    $anamneseController->store();
} elseif (preg_match('/\/anamnesis\/edit\/(\d+)/', $uri, $matches)) {
    $anamneseController->edit($matches[1]);
} elseif (preg_match('/\/anamnesis\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $anamneseController->update($matches[1]);
} elseif (preg_match('/\/anamnesis\/delete\/(\d+)/', $uri, $matches)) {
    $anamneseController->delete($matches[1]);
} elseif (preg_match('/\/anamnesis\/relatorio\/(\d+)/', $uri, $matches)) {
    $anamneseController->relatorio($matches[1]);
} elseif (preg_match('/\/anamnesis\/relatorio\/pdf\/(\d+)/', $uri, $matches)) {
    $anamneseController->gerarRelatorioPDF($matches[1]);
}

// Presupuestos
elseif ($uri == '/presupuestos') {
    $orcamentoController->index();
} elseif ($uri == '/presupuestos/create') {
    $orcamentoController->create();
} elseif ($uri == '/presupuestos/store' && $method == 'POST') {
    $orcamentoController->store();
} elseif (preg_match('/\/presupuestos\/edit\/(\d+)/', $uri, $matches)) {
    $orcamentoController->edit($matches[1]);
} elseif (preg_match('/\/presupuestos\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $orcamentoController->update($matches[1]);
} elseif (preg_match('/\/presupuestos\/delete\/(\d+)/', $uri, $matches)) {
    $orcamentoController->delete($matches[1]);
} elseif (preg_match('/\/presupuestos\/relatorio\/(\d+)/', $uri, $matches)) {
    $orcamentoController->relatorio($matches[1]);
} elseif (preg_match('/\/presupuestos\/relatorio\/pdf\/(\d+)/', $uri, $matches)) {
    $orcamentoController->gerarRelatorioPDF($matches[1]);
}

// Citas
elseif ($uri == '/citas') {
    $agendamentoController->index();
} elseif ($uri == '/citas/create') {
    $agendamentoController->create();
} elseif ($uri == '/citas/store' && $method == 'POST') {
    $agendamentoController->store();
} elseif ($uri === '/citas/calendario') {
    $agendamentoController->calendario();
} elseif ($uri === '/citas/eventos') {
    header('Content-Type: application/json');
    echo json_encode($agendamentoController->getEventosJson());
} elseif (preg_match('/\/citas\/paciente\/(\d+)/', $uri, $matches)) {
    header('Content-Type: application/json');
    echo json_encode($agendamentoController->getPacienteByAgendamentoId((int)$matches[1]));
} elseif (preg_match('/\/citas\/edit\/(\d+)/', $uri, $matches)) {
    $agendamentoController->edit($matches[1]);
} elseif (preg_match('/\/citas\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $agendamentoController->update($matches[1]);
} elseif (preg_match('/\/citas\/delete\/(\d+)/', $uri, $matches)) {
    $agendamentoController->delete($matches[1]);
} 

// Recetas
elseif ($uri == '/recetas') {
    $receitaController->index();
} elseif ($uri == '/recetas/create') {
    $receitaController->create();
} elseif ($uri == '/recetas/store' && $method == 'POST') {
    $receitaController->store();
} elseif (preg_match('/\/recetas\/edit\/(\d+)/', $uri, $matches)) {
    $receitaController->edit($matches[1]);
} elseif (preg_match('/\/recetas\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $receitaController->update($matches[1]);
} elseif (preg_match('/\/recetas\/delete\/(\d+)/', $uri, $matches)) {
    $receitaController->delete($matches[1]);
} elseif (preg_match('/\/recetas\/relatorio\/(\d+)/', $uri, $matches)) {
    $receitaController->relatorio($matches[1]);
} elseif (preg_match('/\/recetas\/relatorio\/pdf\/(\d+)/', $uri, $matches)) {
    $receitaController->gerarRelatorioPDF($matches[1]);
}

// Movimientos contables
elseif ($uri == '/movimientos') {
    $lancamentoController->index();
} elseif ($uri == '/movimientos/create') {
    $lancamentoController->create();
} elseif ($uri == '/movimientos/store' && $method == 'POST') {
    $lancamentoController->store();
} elseif (preg_match('/\/movimientos\/edit\/(\d+)/', $uri, $matches)) {
    $lancamentoController->edit($matches[1]);
} elseif (preg_match('/\/movimientos\/update\/(\d+)/', $uri, $matches) && $method == 'POST') {
    $lancamentoController->update($matches[1]);
} elseif (preg_match('/\/movimientos\/delete\/(\d+)/', $uri, $matches)) {
    $lancamentoController->delete($matches[1]);
}
elseif (preg_match('/\/movimientos\/extrato\/(\d+)/', $uri, $matches)) {
    $lancamentoController->extrato($matches[1]);
}
elseif (preg_match('/\/movimientos\/relatorio\/(\d+)/', $uri, $matches)) {
    $lancamentoController->relatorio($matches[1]);
} elseif (preg_match('/\/movimientos\/relatorio\/pdf\/(\d+)/', $uri, $matches)) {
    $lancamentoController->gerarRelatorioPDF($matches[1]);
}
elseif ($uri == '/movimientos/relatorioGeral') {
    $lancamentoController->relatorioGeral();
} 

// Usuários
elseif ($uri == '/usuarios/create') {
    $usuarioController->create();
} elseif ($uri == '/usuarios/store' && $method == 'POST') {
    $usuarioController->store();
} elseif ($uri == '/usuarios/change-password') {
    if ($method == 'GET') {
        $usuarioController->changePasswordForm();
    } elseif ($method == 'POST') {
        $usuarioController->changePassword();
    }
}


// Dashboard
elseif ($uri === '/dashboard') {
    require __DIR__ . '/../app/views/dashboard.php';
}

// Erro  404
else {
    http_response_code(404);
    echo "Página no encontrada.";
}
