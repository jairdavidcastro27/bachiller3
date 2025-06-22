<?php
require_once __DIR__ . '/../../api/models/connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'msg'=>'Método no permitido']);
    exit;
}

$cliente = trim($_POST['cliente'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$monto = floatval($_POST['monto'] ?? 0);
$prenda = trim($_POST['prenda'] ?? '');
$cantidad = intval($_POST['cantidad'] ?? 1);

if ($cliente === '' || $descripcion === '' || $monto <= 0 || $prenda === '' || $cantidad <= 0) {
    echo json_encode(['success'=>false,'msg'=>'Datos incompletos']);
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
    // Insertar movimiento de ingreso
    $desc = $descripcion . ' | Cliente: ' . $cliente . ' | Prenda: ' . $prenda . ' | Cantidad: ' . $cantidad;
    $stmt = $pdo->prepare("INSERT INTO movimientos_caja (id_caja, tipo, descripcion, monto) VALUES (?, 'ingreso', ?, ?)");
    $ok = $stmt->execute([$id_caja, $desc, $monto]);
    if ($ok) {
        $mov_id = $pdo->lastInsertId();
        echo json_encode(['success'=>true, 'mov_id'=>$mov_id]);
    } else {
        echo json_encode(['success'=>false,'msg'=>'No se pudo registrar venta']);
    }
} catch(Exception $e) {
    echo json_encode(['success'=>false,'msg'=>$e->getMessage()]);
}
