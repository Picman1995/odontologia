<?php
require_once __DIR__ . '/../../../public/auth_middleware.php';
require_once __DIR__ . '/../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Sistema Odontológico' ?></title>
    <!-- jQuery (obrigatório pro DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <!-- FullCalendar com suporte a idioma -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

    <style>
        body {
            background: url('<?= BASE_URL ?>/images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        body {
            background-color: #0d1117;
            color: #c9d1d9;
        }
        td {
            text-align: left;
        }
        .navbar {
            background-color: #161b22;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .content {
            padding: 20px;
        }
        .form-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.6);
            max-width: 600px;
            margin: 40px auto;
        }
        .form-label {
            color: #e0e0e0;
        }
        .form-control {
            background-color: #2a2a2a;
            color: #fff;
            border: 1px solid #444;
        }
        .form-control:focus {
            background-color: #2a2a2a;
            color: #fff;
            border-color: #00bcd4;
            box-shadow: none;
        }
        .btn-custom {
            background-color: #00bcd4;
            border: none;
        }
        .btn-custom:hover {
            background-color: #00acc1;
        }
        a {
            color: #90caf9;
        }
        h2 {
            text-align: center;
            color: #ffffff;
        }

        #calendar {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 10px;
        }

        /* Tema escuro para FullCalendar */
        .fc {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .fc-toolbar-title {
            color: #ffffff;
        }

        .fc-button {
            background-color: #333;
            border: none;
            color: #fff;
        }

        .fc-button:hover {
            background-color: #555;
        }

        .fc-button-primary:not(:disabled).fc-button-active, 
        .fc-button-primary:not(:disabled):active {
            background-color: #0d6efd;
        }

        .fc-daygrid-day-number {
            color: #ffffff;
        }

        .fc-event {
            background-color: #0d6efd;
            border: none;
        }

        .fc-day-today {
            background-color: #2a2a2a !important;
        }

        @media (max-width: 768px) {
            #calendar {
                max-width: 100%;
            }
        }

    </style>
</head>
<body>
<!-- Loader -->
<div id="pageLoader" style="position: fixed; z-index: 9999; background: #121212; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
    <img src="<?= BASE_URL ?>/images/loading.gif" alt="Carregando..." style="width: 80px;">
</div>

<script>
// Remove o loader após o carregamento da página
window.addEventListener('load', function () {
    const loader = document.getElementById('pageLoader');
    if (loader) {
        loader.style.transition = "opacity 0.5s ease";
        loader.style.opacity = "0";
        setTimeout(() => loader.remove(), 500);
    }
});
</script>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/dashboard">
        <div class="d-flex flex-column">
    <span class="fw-bold text-white" style="font-size: 1.5rem;"><?= NOME_CLINICA ?></span>
    <span class="text-white" style="font-size: 0.7rem;">Sistema de Consultório Odontológico</span>
</div>

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
        



        <!-- Menu Cadastros -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="cadastrosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menu
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="cadastrosDropdown">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/pacientes">Pacientes</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/especialidades">Especialidades</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/dentistas">Dentistas</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/funcionarios">Funcionarios</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/anamnesis">Anamnesis</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/presupuestos">Presupuestos</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/citas">Citas</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/recetas">Recetas</a></li>
            </ul>
        </li>

        <!-- Menu Financiero -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="financeiroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Financiero
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="financeiroDropdown">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/movimientos">Todos los movimientos</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/movimientos/create">Nuevo movimiento</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/movimientos/relatorioGeral">Informe general</a></li>
            </ul>
        </li>
        <!-- Menu Admin -->
        
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Config
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="adminDropdown">
                <?php if ($_SESSION[SESSION_NAME]['type'] == 'admin'): ?>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/usuarios/create">Nuevo usuario</a></li>
                <?php endif; ?>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/usuarios/change-password">Cambiar contraseña</a></li>
                </ul>
                
            </li>
        
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= BASE_URL ?>/logout"><i class="bi bi-box-arrow-right"></i> Salir</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
<div class="container content">
