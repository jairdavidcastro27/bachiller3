<?php
// Script de prueba para depuración de la tabla caja y la conexión
try {
    require_once __DIR__ . '/../api/models/connection.php';
    $pdo = Connection::connect();
    $sql = "DESCRIBE caja";
    $stmt = $pdo->query($sql);
    $estructura = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Estructura de la tabla 'caja':</h2>";
    echo "<table border='1' cellpadding='5'><tr>";
    foreach ($estructura[0] as $col => $v) echo "<th>$col</th>";
    echo "</tr>";
    foreach ($estructura as $fila) {
        echo "<tr>";
        foreach ($fila as $v) echo "<td>".htmlspecialchars($v)."</td>";
        echo "</tr>";
    }
    echo "</table>";
    // Verificar si hay caja abierta
    $stmt = $pdo->query("SELECT * FROM caja WHERE estado='abierta' ORDER BY id DESC LIMIT 1");
    $caja = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($caja) {
        echo "<p style='color:green;'>Caja abierta encontrada: ID ".$caja['id']."</p>";
    } else {
        echo "<p style='color:red;'>No hay caja abierta.</p>";
    }
} catch(Exception $e) {
    echo "<b>Error:</b> ".$e->getMessage();
}
?>
