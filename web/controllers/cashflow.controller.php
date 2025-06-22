<?php
require_once __DIR__ . '/../models/cashflow.model.php';

class CashflowController {
    public static function mostrarFlujoCaja() {
        $id_caja = CashflowModel::getOpenCajaId();
        if (!$id_caja) {
            return [
                'saldo' => 0,
                'movimientos' => [],
                'msg' => 'No hay caja abierta.'
            ];
        }
        $movimientos = CashflowModel::getMovimientos($id_caja);
        $saldo = CashflowModel::getSaldo($id_caja);
        return [
            'saldo' => $saldo,
            'movimientos' => $movimientos,
            'msg' => ''
        ];
    }

    public static function registrarIngreso($descripcion, $monto, $id_venta = null) {
        $id_caja = CashflowModel::getOpenCajaId();
        if (!$id_caja) return false;
        return CashflowModel::addMovimiento($id_caja, 'ingreso', $descripcion, $monto, $id_venta);
    }

    public static function registrarEgreso($descripcion, $monto) {
        $id_caja = CashflowModel::getOpenCajaId();
        if (!$id_caja) return false;
        return CashflowModel::addMovimiento($id_caja, 'egreso', $descripcion, $monto);
    }
}
