<?php
require_once '../../models/connection.php';

header('Content-Type: application/json');

if (isset($_POST['mov_id']) && isset($_POST['pdf_base64'])) {
    try {
        $mov_id = intval($_POST['mov_id']);
        $pdf_data = base64_decode($_POST['pdf_base64']);
        
        $conn = Connection::connect();
        $stmt = $conn->prepare("UPDATE movimientos_caja SET pdf_comprobante = ? WHERE id = ?");
        $result = $stmt->execute([$pdf_data, $mov_id]);
        
        echo json_encode(['success' => $result]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Faltan datos']);
}
