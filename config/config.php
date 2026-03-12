<?php
// config.php - Configuración de la base de datos y de la sesión

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'odontologia');
define('DB_USER', 'postgres');
define('DB_PASS', '123456');
define('SESSION_NAME', 'sistema_odontologico');



// URL base: con servidor embebido use http://localhost:8000 (sin / al final)
// Con Apache/XAMPP use http://localhost/odontologia/public
define('BASE_URL', 'http://localhost:8000');

define('BASE_PATH', '');
define('SECRET_KEY', 'Hello World!!!'); 

define('NOME_CLINICA', 'CLÍNICA ODONTOLÓGICA');
define('ENDERECO_CLINICA', 'Ruta departamental km 27'); 
define('CIDADE_CLINICA', 'ITA'); 
define('ESTADO_CLINICA', 'BA');
define('CEP_CLINICA', '45430-000'); 