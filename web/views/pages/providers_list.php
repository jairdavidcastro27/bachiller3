<?php
// web/views/pages/providers_list.php
require_once '../../../api/models/connection.php';

// Obtener todos los proveedores
date_default_timezone_set('America/Bogota');
$link = Connection::connect();
$stmt = $link->prepare("SELECT * FROM providers ORDER BY created_at DESC");
$stmt->execute();
$providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .providers-list-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .providers-list-container h2 {
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
    <div class="providers-list-container">
        <a href="/admin/pedidos" class="btn btn-back mb-3"><i class="fas fa-arrow-left"></i> Regresar a Pedidos</a>
        <h2>Proveedores</h2>
        <a href="/views/pages/provider.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Nuevo Proveedor</a>
        <a href="/views/pages/register_purchase_price.php" class="btn btn-success mb-3 ms-2"><i class="fas fa-dollar-sign"></i> Registrar precio de compra</a>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($providers)): ?>
                    <tr><td colspan="7" class="text-center">No hay proveedores registrados.</td></tr>
                <?php else: foreach ($providers as $prov): ?>
                    <tr>
                        <td><?php echo $prov['id']; ?></td>
                        <td><?php echo htmlspecialchars($prov['name']); ?></td>
                        <td><?php echo htmlspecialchars($prov['email']); ?></td>
                        <td><?php echo htmlspecialchars($prov['phone']); ?></td>
                        <td><?php echo htmlspecialchars($prov['address']); ?></td>
                        <td><?php echo $prov['created_at'] ?? '-'; ?></td>
                        <td>
                            <a href="/views/pages/edit_provider.php?id=<?php echo $prov['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="/views/pages/delete_provider.php?id=<?php echo $prov['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?');"><i class="fas fa-trash"></i></a>
                            <a href="/views/pages/products_by_provider.php?provider_id=<?php echo $prov['id']; ?>" class="btn btn-sm btn-info"><i class="fas fa-box"></i> Ver productos</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>
