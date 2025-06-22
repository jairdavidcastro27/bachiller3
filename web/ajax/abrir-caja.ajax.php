<?php
require_once __DIR__ . '/../../api/models/connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'msg'=>'Método no permitido']);
    exit;
}

try {
    $pdo = Connection::connect();
    // Verificar si ya hay una caja abierta
    $stmt = $pdo->query("SELECT id FROM caja WHERE estado='abierta' LIMIT 1");
    $cajaAbierta = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($cajaAbierta) {
        echo json_encode(['success'=>false, 'msg'=>'Ya hay una caja abierta.']);
        exit;
    }
    // Abrir nueva caja (agregar fecha_apertura si existe la columna)
    $sql = "INSERT INTO caja (estado, monto_apertura, monto_cierre, fecha_apertura) VALUES ('abierta', 0, 0, NOW())";
    try {
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute();
    } catch(Exception $e) {
        // Si la columna fecha_apertura no existe, intentar sin ella
        $sql2 = "INSERT INTO caja (estado, monto_apertura, monto_cierre) VALUES ('abierta', 0, 0)";
        $stmt = $pdo->prepare($sql2);
        $ok = $stmt->execute();
    }
    if ($ok) {
        echo json_encode(['success'=>true, 'msg'=>'Caja abierta correctamente']);
    } else {
        echo json_encode(['success'=>false,'msg'=>'No se pudo abrir caja']);
    }
} catch(Exception $e) {
    echo json_encode(['success'=>false,'msg'=>$e->getMessage()]);
}
