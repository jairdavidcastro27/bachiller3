<?php
// web/views/pages/provider.php
require_once '../../../api/models/connection.php';

// Procesar formulario
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    if (!$name || !$email) {
        $message = '<div class="alert alert-danger">Nombre y email son obligatorios.</div>';
    } else {
        $link = Connection::connect();
        $stmt = $link->prepare("INSERT INTO providers (name, email, phone, address) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([
            $name,
            $email,
            $phone,
            $address
        ]);
        if ($result) {
            $message = '<div class="alert alert-success">Proveedor creado correctamente.</div>';
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
    <title>Crear Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .provider-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .provider-container h2 {
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
    <div class="provider-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/views/pages/providers_list.php" class="btn btn-back"><i class="fas fa-arrow-left"></i> Ver Proveedores</a>
        </div>
        <h2>Crear Proveedor</h2>
        <?php echo $message; ?>
        <form method="POST" class="mt-4" autocomplete="off">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Dirección</label>
                <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Crear Proveedor</button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>
