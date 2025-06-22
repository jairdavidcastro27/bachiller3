<?php
// Vista: Productos y Proveedores (conexión directa)
$pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT p.id_product, p.name_product, p.url_product, p.image_product, p.description_product, p.keywords_product, c.name_category, s.name_subcategory, pr.name AS provider_name,
    pp.purchase_price, pp.quantity, pp.final_price
FROM products p
LEFT JOIN categories c ON p.id_category_product = c.id_category
LEFT JOIN subcategories s ON p.id_subcategory_product = s.id_subcategory
LEFT JOIN providers pr ON p.provider_id = pr.id
LEFT JOIN product_purchases pp ON pp.product_id = p.id_product
ORDER BY p.id_product DESC";

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
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tabla-productos-proveedores" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>URL</th>
                                <th>Imagen</th>
                                <th>Descripción</th>
                                <th>Palabras Claves</th>
                                <th>Categoría</th>
                                <th>Subcategoría</th>
                                <th>Proveedor</th>
                                <th>Precio compra</th>
                                <th>Cantidad</th>
                                <th>Precio final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $i => $prod): ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?= htmlspecialchars($prod['name_product']) ?></td>
                                <td><?= htmlspecialchars($prod['url_product']) ?></td>
                                <td><img src="/views/assets/img/products/<?= htmlspecialchars($prod['url_product']) ?>/<?= htmlspecialchars($prod['image_product']) ?>" class="img-thumbnail rounded" style="max-width:60px;"></td>
                                <td><?= htmlspecialchars($prod['description_product']) ?></td>
                                <td><?= htmlspecialchars($prod['keywords_product']) ?></td>
                                <td><?= htmlspecialchars($prod['name_category']) ?></td>
                                <td><?= htmlspecialchars($prod['name_subcategory']) ?></td>
                                <td><?= htmlspecialchars($prod['provider_name']) ?></td>
                                <td><?= $prod['purchase_price'] !== null ? number_format($prod['purchase_price'], 2) : '-' ?></td>
                                <td><?= $prod['quantity'] !== null ? $prod['quantity'] : '-' ?></td>
                                <td><?= $prod['final_price'] !== null ? number_format($prod['final_price'], 2) : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<style>
.table-responsive { max-width: 100vw; }
#tabla-productos-proveedores { min-width: 1200px; }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#tabla-productos-proveedores').DataTable({
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 100],
        "scrollX": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        }
    });
});
</script>
