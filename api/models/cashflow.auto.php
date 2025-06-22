<?php
require_once __DIR__ . '/../../web/models/cashflow.model.php';
require_once __DIR__ . '/../../api/models/connection.php';

class CashflowAuto {
    public static function registrarIngresoVenta($id_venta, $monto) {
        $id_caja = CashflowModel::getOpenCajaId();
        if (!$id_caja) return false;
        $descripcion = "Ingreso por venta #$id_venta";
        $ok = CashflowModel::addMovimiento($id_caja, 'ingreso', $descripcion, $monto, $id_venta);
        if ($ok) {
            self::generarBoletaElectronica($id_venta, $monto);
        }
        return $ok;
    }

    public static function generarBoletaElectronica($id_venta, $monto) {
        $conn = Connection::connect();
        // Generar número de boleta aleatorio de 10 dígitos
        $numero_boleta = 'BOL-' . strtoupper(bin2hex(random_bytes(5)));
        $pdf_url = '';
        $fecha_emision = date('Y-m-d H:i:s');
        $estado = 'emitida';
        $stmt = $conn->prepare("INSERT INTO boletas_electronicas (id_venta, numero_boleta, pdf_url, fecha_emision, estado) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_venta, $numero_boleta, $pdf_url, $fecha_emision, $estado]);
        return $conn->lastInsertId();
    }

    // Guarda o actualiza el comprobante PDF en el movimiento de caja relacionado a la venta
    public static function guardarOActualizarComprobanteCaja($id_venta, $pdf_blob) {
        $conn = Connection::connect();
        // Buscar movimiento de caja asociado a la venta
        $stmt = $conn->prepare("SELECT id FROM movimientos_caja WHERE id_venta = ? LIMIT 1");
        $stmt->execute([$id_venta]);
        $mov = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($mov) {
            // Si existe, actualiza el campo pdf_comprobante
            $stmt2 = $conn->prepare("UPDATE movimientos_caja SET pdf_comprobante = ? WHERE id = ?");
            $stmt2->bindParam(1, $pdf_blob, PDO::PARAM_LOB);
            $stmt2->bindParam(2, $mov['id']);
            $stmt2->execute();
            return $mov['id'];
        } else {
            // Si no existe, crea el movimiento y guarda el PDF
            $id_caja = CashflowModel::getOpenCajaId();
            if (!$id_caja) return false;
            $descripcion = "Ingreso por venta #$id_venta";
            $monto = self::obtenerMontoVenta($id_venta, $conn);
            $stmt3 = $conn->prepare("INSERT INTO movimientos_caja (id_caja, tipo, descripcion, monto, id_venta, pdf_comprobante) VALUES (?, 'ingreso', ?, ?, ?, ?)");
            $stmt3->bindParam(1, $id_caja);
            $stmt3->bindParam(2, $descripcion);
            $stmt3->bindParam(3, $monto);
            $stmt3->bindParam(4, $id_venta);
            $stmt3->bindParam(5, $pdf_blob, PDO::PARAM_LOB);
            $stmt3->execute();
            return $conn->lastInsertId();
        }
    }

    // Guarda o actualiza el comprobante PDF en el movimiento de caja relacionado a la venta
    // $pdf puede ser binario puro o path temporal de archivo subido
    public static function guardarOActualizarComprobanteCajaDesdeInput($id_venta, $pdf_input) {
        // Si es un archivo subido, obtener el binario
        if (is_string($pdf_input) && file_exists($pdf_input)) {
            $pdf_blob = file_get_contents($pdf_input);
        } else {
            $pdf_blob = $pdf_input;
        }
        return self::guardarOActualizarComprobanteCaja($id_venta, $pdf_blob);
    }

    // Guarda o actualiza el comprobante PDF en el movimiento de caja usando el id del movimiento
    public static function guardarComprobantePorMovimiento($mov_id, $pdf_blob) {
        $conn = Connection::connect();
        $stmt = $conn->prepare("UPDATE movimientos_caja SET pdf_comprobante = ? WHERE id = ?");
        $stmt->bindParam(1, $pdf_blob, PDO::PARAM_LOB);
        $stmt->bindParam(2, $mov_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Obtiene el monto de la venta desde la base de datos
    private static function obtenerMontoVenta($id_venta, $conn) {
        $stmt = $conn->prepare("SELECT total FROM ventas WHERE id = ?");
        $stmt->execute([$id_venta]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total'] : 0;
    }

    // Busca el movimiento de caja correspondiente a una venta y retorna su id
    public static function obtenerIdMovimientoPorVenta($id_venta) {
        $conn = Connection::connect();
        $stmt = $conn->prepare("SELECT id FROM movimientos_caja WHERE id_venta = ? LIMIT 1");
        $stmt->execute([$id_venta]);
        $mov = $stmt->fetch(PDO::FETCH_ASSOC);
        return $mov ? $mov['id'] : null;
    }
}
