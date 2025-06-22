<?php
// web/views/pages/credit_note.php
// Formulario simple para crear nota de crédito
require_once '../../../api/models/connection.php';
require_once '../../../web/controllers/curl.controller.php';

// Obtener todas las órdenes y usuarios para los selects
function getApiData($endpoint) {
    $url = 'http://api.ecommerce.com/' . $endpoint;
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: " . Connection::apikey() . "\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    return json_decode($result);
}

// Traer id_order, name_product, id_user_order
$orders = getApiData('relations?rel=orders,products&type=order,product&select=id_order,name_product,id_user_order');
$users = getApiData('users?select=id_user,name_user,email_user');

// Procesar formulario
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? '';
    $user_id = '';
    foreach ($orders->results as $order) {
        if ($order->id_order == $order_id) {
            $user_id = $order->id_user_order;
            break;
        }
    }
    if (!$order_id || !$user_id) {
        $message = '<div class="alert alert-danger">Debes seleccionar una orden válida.</div>';
    } else {
        // Conexión directa a la base de datos para insertar la nota de crédito
        $link = Connection::connect();
        $stmt = $link->prepare("INSERT INTO credit_notes (order_id, user_id, amount, reason) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([
            $order_id,
            $user_id,
            $_POST['amount'],
            $_POST['reason']
        ]);
        if ($result) {
            $message = '<div class="alert alert-success">Nota de crédito creada correctamente (directo en la base de datos).</div>';
        } else {
            $errorInfo = $stmt->errorInfo();
            $message = '<div class="alert alert-danger">Error al guardar en la base de datos: ' . htmlspecialchars(print_r($errorInfo, true)) . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nota de Crédito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $path ?? '/views/assets/css/main.css'; ?>">
    <style>
        .credit-note-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .credit-note-container h2 {
            font-weight: 700;
            color: #6f42c1;
            margin-bottom: 1.5rem;
        }
        .btn-back {
            background: #f4f6f9;
            color: #6f42c1;
            border: 1px solid #6f42c1;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .btn-back:hover {
            background: #6f42c1;
            color: #fff;
        }
    </style>
</head>
<body class="bg-light">
    <div class="credit-note-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/admin/pedidos" class="btn btn-back"><i class="fas fa-arrow-left"></i> Regresar a Pedidos</a>
            <a href="/views/pages/credit_notes_list.php" class="btn btn-secondary"><i class="fas fa-list"></i> Ver Notas de Crédito</a>
        </div>
        <h2>Crear Nota de Crédito</h2>
        <?php echo $message; ?>
        <form method="POST" class="mt-4" autocomplete="off">
            <div class="mb-3">
                <label for="order_id" class="form-label">Orden</label>
                <select class="form-select" id="order_id" name="order_id" required onchange="setUserIdFromOrder()">
                    <option value="">Seleccione una orden</option>
                    <?php if (!empty($orders->results)): foreach ($orders->results as $order): ?>
                        <option value="<?php echo $order->id_order; ?>">
                            <?php echo $order->name_product ? $order->name_product : ("#".$order->id_order); ?>
                        </option>
                    <?php endforeach; else: ?>
                        <option value="">No hay órdenes disponibles</option>
                    <?php endif; ?>
                </select>
                <input type="hidden" id="user_id_hidden" name="user_id">
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Monto</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Motivo</label>
                <textarea class="form-control" id="reason" name="reason" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Crear Nota de Crédito</button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <script>
    function setUserIdFromOrder() {
        var orders = <?php echo json_encode($orders && isset($orders->results) ? $orders->results : []); ?>;
        var orderSelect = document.getElementById('order_id');
        var userIdInput = document.getElementById('user_id_hidden');
        var selectedOrder = orderSelect.value;
        var userId = '';
        orders.forEach(function(order) {
            if(order.id_order == selectedOrder) userId = order.id_user_order;
        });
        userIdInput.value = userId;
    }
    document.addEventListener('DOMContentLoaded', function() {
        setUserIdFromOrder();
    });
    </script>
</body>
</html>
