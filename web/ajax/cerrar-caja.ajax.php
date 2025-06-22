<?php
require_once __DIR__ . '/../models/connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'msg'=>'Método no permitido']);
    exit;
}

$monto_cierre = isset($_POST['monto_cierre']) ? floatval($_POST['monto_cierre']) : 0;
if ($monto_cierre <= 0) {
    echo json_encode(['success'=>false,'msg'=>'Monto inválido']);
    exit;
}

try {
    $pdo = Connection::connect();
    // Buscar caja abierta
    $stmt = $pdo->prepare("SELECT id FROM caja WHERE estado='abierta' ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $caja = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$caja) {
        echo json_encode(['success'=>false,'msg'=>'No hay caja abierta']);
        exit;
    }
    $id_caja = $caja['id'];
    // Actualizar caja
    $stmt = $pdo->prepare("UPDATE caja SET estado='cerrada', monto_cierre=? WHERE id=?");
    $ok = $stmt->execute([$monto_cierre, $id_caja]);
    if ($ok) {
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false,'msg'=>'No se pudo cerrar caja']);
    }
} catch(Exception $e) {
    echo json_encode(['success'=>false,'msg'=>$e->getMessage()]);
}
