<?php
// Vista: Productos y Precios de Compra por Proveedor (conexión directa)
$pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta productos y proveedores con información de compra
$sql = "SELECT p.id_product, p.name_product, p.url_product, p.image_product, pr.name AS provider_name, 
       IFNULL(pc.purchase_price, '-') AS purchase_price, IFNULL(pc.invoice_number, '-') AS invoice_number, IFNULL(pc.purchase_date, '-') AS purchase_date
FROM products p
LEFT JOIN providers pr ON p.provider_id = pr.id
LEFT JOIN product_purchases pc ON p.id_product = pc.product_id
ORDER BY pr.name, p.name_product";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content pb-5">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="/admin/productos" class="btn btn-secondary py-2 px-3 btn-sm rounded-pill">Volver a productos</a>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Precio Compra</th>
                            <th>Boleta/Factura</th>
                            <th>Fecha Compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $i => $prod): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= htmlspecialchars($prod['provider_name']) ?></td>
                            <td><?= htmlspecialchars($prod['name_product']) ?></td>
                            <td><img src="/views/assets/img/products/<?= htmlspecialchars($prod['url_product']) ?>/<?= htmlspecialchars($prod['image_product']) ?>" class="img-thumbnail rounded" style="max-width:60px;"></td>
                            <td><?= htmlspecialchars($prod['purchase_price']) ?></td>
                            <td><?= htmlspecialchars($prod['invoice_number']) ?></td>
                            <td><?= htmlspecialchars($prod['purchase_date']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
