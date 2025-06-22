<?php
require_once __DIR__ . '/../../api/models/connection.php';

class CashflowModel {
    public static function getOpenCajaId() {
        $stmt = Connection::connect()->prepare("SELECT id FROM caja WHERE estado = 'abierta' ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id'] : null;
    }    public static function getMovimientos($id_caja) {
        $stmt = Connection::connect()->prepare("
            SELECT 
                m.*,
                o.id_user_order,
                o.number_order,
                u.name_user,
                u.address_user
            FROM movimientos_caja m
            LEFT JOIN orders o ON m.id_venta = o.id_order
            LEFT JOIN users u ON o.id_user_order = u.id_user
            WHERE m.id_caja = ?
            ORDER BY m.created_at DESC
        ");
        $stmt->execute([$id_caja]);
        $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Por cada movimiento, buscar los productos de la venta (por number_order)
        foreach ($movimientos as &$mov) {
            $productos = [];
            if (!empty($mov['number_order'])) {
                $stmt2 = Connection::connect()->prepare("
                    SELECT p.name_product, o.quantity_order
                    FROM orders o
                    LEFT JOIN products p ON o.id_product_order = p.id_product
                    WHERE o.number_order = ?
                ");
                $stmt2->execute([$mov['number_order']]);
                $productos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
            $mov['productos'] = $productos;
        }
        return $movimientos;
    }

    public static function addMovimiento($id_caja, $tipo, $descripcion, $monto, $id_venta = null) {
        $stmt = Connection::connect()->prepare("INSERT INTO movimientos_caja (id_caja, tipo, descripcion, monto, id_venta) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_caja, $tipo, $descripcion, $monto, $id_venta]);
    }

    public static function getSaldo($id_caja) {
        $stmt = Connection::connect()->prepare("SELECT SUM(CASE WHEN tipo='ingreso' THEN monto ELSE -monto END) as saldo FROM movimientos_caja WHERE id_caja = ?");
        $stmt->execute([$id_caja]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['saldo'] : 0;
    }
}
