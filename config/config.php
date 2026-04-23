<?php
// config.php - Configuración de la base de datos y de la sesión

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'odontologia');
define('DB_USER', 'postgres');
define('DB_PASS', '123456');
define('SESSION_NAME', 'sistema_odontologico');



// URL base: debe incluir el esquema (https:// o http://) y sin barra final.
// Sin https:// el navegador trata el host como ruta relativa y falla el redirect tras login.
// Con Apache/XAMPP use p. ej. http://localhost/odontologia/public
define('BASE_URL', 'https://fe4d-181-94-250-44.ngrok-free.app');

define('BASE_PATH', '');
define('SECRET_KEY', 'Hello World!!!'); 

define('NOME_CLINICA', 'CLÍNICA ODONTOLÓGICA');
define('ENDERECO_CLINICA', 'Ruta departamental km 27'); 
define('CIDADE_CLINICA', 'ITA'); 
define('ESTADO_CLINICA', 'BA');