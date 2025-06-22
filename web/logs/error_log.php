<?php

/*=============================================
Centralizar Logs de Errores
=============================================*/

// Ruta del archivo de logs
$logFile = __DIR__ . '/php_errors.log';

// Verificar si el archivo existe, si no, crearlo
if (!file_exists($logFile)) {
    file_put_contents($logFile, "");
}

// Configurar PHP para registrar errores en este archivo
ini_set('log_errors', 'On');
ini_set('error_log', $logFile);

// Mensaje de confirmación
echo "Los errores se registrarán en: " . $logFile;

?>
