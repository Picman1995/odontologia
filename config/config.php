<?php
// config.php - Configuración de la base de datos y de la sesión

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'odontologia');
define('DB_USER', 'postgres');
define('DB_PASS', '123456');
define('SESSION_NAME', 'sistema_odontologico'); // Nombre de la sesión

// URL base: con servidor embebido use http://localhost:8000 (sin / al final)
// Con Apache/XAMPP use http://localhost/odontologia/public
define('BASE_URL', 'http://localhost:8000');

// Ruta base en la URL (vacía si el servidor sirve desde public/; con Apache suele ser /odontologia/public)
define('BASE_PATH', '');
define('SECRET_KEY', 'Hello World!!!'); // Clave para la criptografía

define('NOME_CLINICA', 'CLÍNICA ODONTOLÓGICA'); // Nombre de la clínica
define('ENDERECO_CLINICA', 'Rua Marechal Deodoro, nº 281'); // Dirección de la clínica
define('CIDADE_CLINICA', 'Taperoá'); // Ciudad
define('ESTADO_CLINICA', 'BA'); // Estado
define('CEP_CLINICA', '45430-000'); // CEP