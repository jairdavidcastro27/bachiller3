<?php
// Formulario para registrar o editar precio de compra de un producto a un proveedor
$pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todos los proveedores
$stmt = $pdo->prepare("SELECT id, name FROM providers ORDER BY name ASC");
$stmt->execute();
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selected_provider = isset($_GET['provider_id']) ? intval($_GET['provider_id']) : 0;
$productos = [];
if ($selected_provider) {
    $stmt = $pdo->prepare("SELECT id_product, name_product FROM products WHERE provider_id = ?");
    $stmt->execute([$selected_provider]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Guardar datos si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $purchase_price = floatval($_POST['purchase_price']);
    $quantity = intval($_POST['quantity']);
    $final_price = floatval($_POST['final_price']);
    $invoice_number = $_POST['invoice_number'];
    $purchase_date = $_POST['purchase_date'];

    // Insertar o actualizar
    $stmt = $pdo->prepare("REPLACE INTO product_purchases (product_id, purchase_price, quantity, final_price, invoice_number, purchase_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$product_id, $purchase_price, $quantity, $final_price, $invoice_number, $purchase_date]);
    $msg = 'Precio de compra guardado correctamente.';
    // Mantener el proveedor seleccionado después de guardar
    $selected_provider = isset($_POST['provider_id']) ? intval($_POST['provider_id']) : $selected_provider;
    // Recargar productos del proveedor seleccionado
    $stmt = $pdo->prepare("SELECT id_product, name_product FROM products WHERE provider_id = ?");
    $stmt->execute([$selected_provider]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar precio de compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f6f9;
        }
        .providers-list-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(111,66,193,0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            border: 2px solid #6f42c1;
        }
        h2 {
            font-weight: 700;
            color: #6f42c1;
            margin-bottom: 1.5rem;
        }
        .form-label {
            color: #6f42c1;
            font-weight: 600;
        }
        .btn-success {
            background: #6f42c1;
            border: none;
        }
        .btn-success:hover {
            background: #563d7c;
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
        .alert-success {
            background: #e9d8fd;
            color: #6f42c1;
            border: 1px solid #6f42c1;
        }
        select:disabled, input:disabled {
            background: #f4f6f9;
        }
    </style>
    <script>
    function cargarProductos() {
        var providerId = document.getElementById('provider_id').value;
        if(providerId) {
            window.location.href = '?provider_id=' + providerId;
        }
    }
    </script>
</head>
<body>
<div class="providers-list-container">
    <a href="/views/pages/providers_list.php" class="btn btn-back mb-3"><i class="fas fa-arrow-left"></i> Volver a proveedores</a>
    <h2>Registrar precio de compra</h2>
    <?php if (!empty($msg)): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>
    <form method="post" class="mb-4">
        <div class="mb-3">
            <label for="provider_id" class="form-label">Proveedor</label>
            <select name="provider_id" id="provider_id" class="form-select" onchange="cargarProductos()" required>
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($proveedores as $prov): ?>
                    <option value="<?= $prov['id'] ?>" <?= ($selected_provider == $prov['id']) ? 'selected' : '' ?>><?= htmlspecialchars($prov['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="product_id" class="form-label">Producto</label>
            <select name="product_id" id="product_id" class="form-select" required <?= $selected_provider ? '' : 'disabled' ?>>
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $prod): ?>
                    <option value="<?= $prod['id_product'] ?>"> <?= htmlspecialchars($prod['name_product']) ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="purchase_price" class="form-label">Precio de compra (individual)</label>
            <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Cantidad</label>
            <input type="number" min="1" name="quantity" id="quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="final_price" class="form-label">Precio final</label>
            <input type="number" step="0.01" name="final_price" id="final_price" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label for="invoice_number" class="form-label">Boleta/Factura</label>
            <input type="text" name="invoice_number" id="invoice_number" class="form-control">
        </div>
        <div class="mb-3">
            <label for="purchase_date" class="form-label">Fecha de compra</label>
            <input type="date" name="purchase_date" id="purchase_date" class="form-control">
        </div>
        <button type="submit" class="btn btn-success w-100">Guardar</button>
    </form>
</div>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
<script>
document.getElementById('purchase_price').addEventListener('input', calculateFinalPrice);
document.getElementById('quantity').addEventListener('input', calculateFinalPrice);
function calculateFinalPrice() {
    var price = parseFloat(document.getElementById('purchase_price').value) || 0;
    var qty = parseInt(document.getElementById('quantity').value) || 0;
    document.getElementById('final_price').value = (price * qty).toFixed(2);
}
</script>
</body>
</html>
