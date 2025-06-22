<?php
// web/views/pages/credit_notes_list.php
require_once '../../../api/models/connection.php';

// Obtener todas las notas de crédito
$link = Connection::connect();
$stmt = $link->prepare("SELECT cn.id, cn.order_id, cn.user_id, cn.amount, cn.reason, cn.created_at, o.number_order, p.name_product, u.name_user, u.email_user FROM credit_notes cn LEFT JOIN orders o ON cn.order_id = o.id_order LEFT JOIN products p ON o.id_product_order = p.id_product LEFT JOIN users u ON cn.user_id = u.id_user ORDER BY cn.created_at DESC");
$stmt->execute();
$creditNotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas de Crédito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .credit-notes-list-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .credit-notes-list-container h2 {
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
    <div class="credit-notes-list-container">
        <a href="/admin/pedidos" class="btn btn-back mb-3"><i class="fas fa-arrow-left"></i> Regresar a Pedidos</a>
        <h2>Notas de Crédito</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Orden</th>
                    <th>Producto</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Motivo</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($creditNotes)): ?>
                    <tr><td colspan="7" class="text-center">No hay notas de crédito registradas.</td></tr>
                <?php else: foreach ($creditNotes as $note): ?>
                    <tr>
                        <td><?php echo $note['id']; ?></td>
                        <td>#<?php echo $note['number_order'] ?? $note['order_id']; ?></td>
                        <td><?php echo $note['name_product'] ?? '-'; ?></td>
                        <td><?php echo $note['name_user'] ? $note['name_user'] . ' (' . $note['email_user'] . ')' : $note['user_id']; ?></td>
                        <td>$<?php echo number_format($note['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($note['reason']); ?></td>
                        <td><?php echo $note['created_at'] ?? '-'; ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>
