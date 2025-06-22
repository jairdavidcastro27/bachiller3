<?php
// api/routes/services/credit_note.php
require_once "models/connection.php";
require_once "controllers/credit_notes.controller.php";

// DEBUG: Mostrar cabeceras recibidas en el backend para depuración
error_log('HEADERS: ' . print_r(getallheaders(), true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar API KEY
    if (!isset(getallheaders()["Authorization"]) || getallheaders()["Authorization"] != Connection::apikey()) {
        $json = ["status" => 400, "results" => "No autorizado."];
        echo json_encode($json, http_response_code($json["status"]));
        return;
    }
    // Recibir datos
    $data = $_POST;
    $response = CreditNotesController::createCreditNote($data);
    echo json_encode($response, http_response_code($response["status"]));
    return;
}
// Si no es POST
$json = ["status" => 405, "results" => "Método no permitido."];
echo json_encode($json, http_response_code($json["status"]));
return;
