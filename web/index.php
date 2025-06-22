<?php 

/*=============================================
Depurar errores
=============================================*/

// ini_set("display_errors", 1);
// ini_set("log_errors", 1);
// ini_set("error_log", "D:/xampp/htdocs/ecommerce/web/php_error_log");

// Configurar el registro de errores para centralizar en logs/php_errors.log
ini_set('log_errors', 'On');
ini_set('error_log', __DIR__ . '/logs/php_errors.log');

/*=============================================
Require
=============================================*/

require_once "controllers/template.controller.php";
require_once "controllers/curl.controller.php";
require_once 'extensions/vendor/autoload.php';


/*=============================================
Plantilla
=============================================*/

$index = new TemplateController();
$index->index();





