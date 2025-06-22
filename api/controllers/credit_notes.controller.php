<?php
// api/controllers/credit_notes.controller.php
require_once "models/post.model.php";
require_once "models/get.model.php";

class CreditNotesController {
    // Crear nota de crédito con validación básica
    static public function createCreditNote($data) {
        // Validar campos requeridos
        $required = ["order_id", "user_id", "amount", "reason"];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === "") {
                return ["status" => 400, "results" => "Falta el campo: $field"];
            }
        }
        // Validar que la orden exista
        $order = GetModel::getDataFilter("orders", "*", "id_order", $data["order_id"], null, null, null, null);
        if (empty($order)) {
            return ["status" => 404, "results" => "La orden no existe."];
        }
        // Validar que el usuario coincida
        if ($order[0]["id_user_order"] != $data["user_id"]) {
            return ["status" => 400, "results" => "La orden no pertenece al usuario."];
        }
        // Validar que el monto no supere el total de la orden
        if ($data["amount"] > $order[0]["price_order"] * $order[0]["quantity_order"]) {
            return ["status" => 400, "results" => "El monto excede el total de la orden."];
        }
        // Insertar nota de crédito
        $result = PostModel::postData("credit_notes", $data);
        if (isset($result["lastId"])) {
            return ["status" => 201, "results" => $result];
        } else {
            return ["status" => 500, "results" => $result];
        }
    }
}
