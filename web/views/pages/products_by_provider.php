<?php
// Mostrar productos de un proveedor específico
$pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$provider_id = isset($_GET['provider_id']) ? intval($_GET['provider_id']) : 0;

// Obtener datos del proveedor
$stmt = $pdo->prepare("SELECT name FROM providers WHERE id = ?");
$stmt->execute([$provider_id]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener productos del proveedor
$stmt = $pdo->prepare("SELECT id_product, name_product, url_product, image_product, description_product FROM products WHERE provider_id = ?");
$stmt->execute([$provider_id]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos de Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f6f9; }
        .container { max-width: 900px; margin: 40px auto; }
        h2 { color: #6f42c1; font-weight: 700; }
        .card { border: 1.5px solid #6f42c1; border-radius: 12px; }
        .card-title { color: #6f42c1; font-weight: 600; }
        .btn-back { background: #f4f6f9; color: #6f42c1; border: 1px solid #6f42c1; font-weight: 600; margin-bottom: 1.5rem; }
        .btn-back:hover { background: #6f42c1; color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <a href="/views/pages/providers_list.php" class="btn btn-back mb-3"><i class="fas fa-arrow-left"></i> Volver a proveedores</a>
    <h2>Productos de <?= htmlspecialchars($proveedor['name'] ?? 'Proveedor desconocido') ?></h2>
    <div class="card mt-4">
        <div class="card-body">
            <?php if (empty($productos)): ?>
                <div class="alert alert-warning">Este proveedor no tiene productos registrados.</div>
            <?php else: ?>
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>URL</th>
                            <th>Imagen</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $prod): ?>
                        <tr>
                            <td><?= $prod['id_product'] ?></td>
                            <td><?= htmlspecialchars($prod['name_product']) ?></td>
                            <td><?= htmlspecialchars($prod['url_product']) ?></td>
                            <td><img src="/views/assets/img/products/<?= htmlspecialchars($prod['url_product']) ?>/<?= htmlspecialchars($prod['image_product']) ?>" class="img-thumbnail rounded" style="max-width:60px;"></td>
                            <td><?= htmlspecialchars($prod['description_product']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>
