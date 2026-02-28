<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
//session_start();

// Evita que páginas privadas fiquem armazenadas no cache do navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Verifica se a sessão está ativa e válida
if (
    !isset($_SESSION[SESSION_NAME]) ||
    empty($_SESSION[SESSION_NAME]['id']) ||
    empty($_SESSION[SESSION_NAME]['email']) ||
    empty($_SESSION[SESSION_NAME]['type'])
) {
    header("Location: " . BASE_URL . "/login");
    exit;
}
