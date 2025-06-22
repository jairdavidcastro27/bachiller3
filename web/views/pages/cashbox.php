<?php
// --- LIMPIEZA: Eliminado bloque de depuración que abría/cerraba caja manualmente y mostraba estructura de la tabla ---
require_once __DIR__ . '/../../../api/models/connection.php';
require_once __DIR__ . '/../../controllers/cashflow.controller.php';

$pdo = Connection::connect();
// Obtener lista de administradores para apertura/cierre de caja
try {
    $stmtUsuarios = $pdo->query("SELECT id_admin, name_admin FROM admins ORDER BY name_admin ASC");
    $usuariosCaja = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
    error_log('admins encontrados: ' . print_r($usuariosCaja, true));
    echo '<script>console.log("admins encontrados:", ' . json_encode($usuariosCaja) . ');</script>';
} catch(Exception $e) {
    $usuariosCaja = [];
    error_log('Error al consultar admins: ' . $e->getMessage());
    echo '<script>console.error("Error al consultar admins: ' . addslashes($e->getMessage()) . '");</script>';
}

$pdo = Connection::connect();
// Buscar la caja abierta más reciente
$stmt = $pdo->query("SELECT * FROM caja WHERE estado='abierta' ORDER BY id DESC LIMIT 1");
$cajaReciente = $stmt->fetch(PDO::FETCH_ASSOC);
$hayCajaAbierta = false;
if ($cajaReciente) {
    $hayCajaAbierta = true;
    $id_caja = $cajaReciente['id'];
    // Obtener movimientos y saldo de la caja abierta
    $stmt = $pdo->prepare("SELECT * FROM movimientos_caja WHERE id_caja = ? ORDER BY created_at DESC");
    $stmt->execute([$id_caja]);
    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT SUM(CASE WHEN tipo='ingreso' THEN monto ELSE -monto END) as saldo FROM movimientos_caja WHERE id_caja = ?");
    $stmt->execute([$id_caja]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $saldo = $row ? $row['saldo'] : 0;
    $msg = '';
} else {
    // No hay caja abierta, no mostrar movimientos ni saldo
    $movimientos = [];
    $saldo = 0;
    $msg = 'No hay caja abierta.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
    <link rel="stylesheet" href="/views/assets/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-cashbox {
            max-width: 900px;
            margin: 30px auto;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        }
        .table-products th, .table-products td {
            vertical-align: middle;
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini bg-light">
    <div class="container-fluid px-0" style="min-height:100vh;">
        <div class="row no-gutters justify-content-center align-items-start" style="min-height:100vh;">
            <div class="col-12">
                <a href="/web/index.php" class="btn btn-secondary btn-back mt-3 ml-3"><i class="fas fa-arrow-left"></i> Regresar</a>
                <div class="d-flex flex-wrap justify-content-between align-items-center px-3 mt-3 mb-2">
                    <div>
                        <h2 class="mb-0"><i class="fas fa-cash-register"></i> Caja</h2>
                    </div>
                    <div>
                        <!-- Botones de caja -->
                        <div>
                            <button class="btn btn-primary mr-2" onclick="mostrarAbrirCajaModal()"><i class="fas fa-unlock"></i> Abrir Caja</button>
                            <?php if ($hayCajaAbierta): ?>
                                <button class="btn btn-danger mr-2" onclick="mostrarCerrarCajaDirectoModal()"><i class="fas fa-lock"></i> Cerrar Caja</button>
                                <button class="btn btn-success" onclick="mostrarVentaManualModal()"><i class="fas fa-plus"></i> Venta Manual</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (!$hayCajaAbierta): ?>
                <div class="alert alert-warning mx-3">No hay caja abierta. Debes abrir una caja para registrar ventas o movimientos.</div>
                <?php endif; ?>
                <div class="card card-cashbox mx-3 mb-4">
                    <div class="card-body">
                        <section class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-info-circle"></i> Resumen de Caja</h5>
                            <?php if ($msg): ?>
                                <div class="alert alert-warning"><?php echo $msg; ?></div>
                            <?php endif; ?>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Saldo actual:</span>
                                    <span class="badge badge-success badge-pill" style="font-size:1.2em;">$<?php echo number_format($saldo,2); ?></span>
                                </li>
                            </ul>
                        </section>
                        <section>
                            <h5 class="mb-3"><i class="fas fa-history"></i> Movimientos recientes</h5>
                            <?php if (empty($movimientos)): ?>
                                <em>No hay movimientos registrados.</em>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Monto</th>
                                            <th>Prendas</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($movimientos as $mov): ?>
                                        <tr>
                                            <td><?php echo $mov['created_at']; ?></td>
                                            <td><span class="badge badge-<?php echo $mov['tipo']==='ingreso'?'success':'danger'; ?>"><?php echo ucfirst($mov['tipo']); ?></span></td>
                                            <td><?php echo $mov['descripcion']; ?></td>
                                            <td>$<?php echo number_format($mov['monto'],2); ?></td>
                                            <td>
                                                <?php if (!empty($mov['productos'])): ?>
                                                    <ul class="mb-0 pl-3">
                                                        <?php foreach ($mov['productos'] as $prod): ?>
                                                            <li><?php echo htmlspecialchars($prod['name_product']); ?> <span class="text-muted">(<?php echo $prod['quantity_order']; ?>)</span></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <em class="text-muted">-</em>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($mov['tipo'] === 'ingreso'): ?>
                                                    <button class="btn btn-sm btn-success mb-1" onclick="generarBoletaHTML(<?php echo htmlspecialchars(json_encode($mov), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-file-invoice"></i> Boleta</button>
                                                    <button class="btn btn-sm btn-primary mb-1" onclick="mostrarFacturaForm(<?php echo htmlspecialchars(json_encode($mov), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-file-invoice-dollar"></i> Factura</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cerrar Caja -->
    <div class="modal fade" id="cerrarCajaModal" tabindex="-1" role="dialog" aria-labelledby="cerrarCajaLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="cerrarCajaLabel"><i class="fas fa-lock"></i> Cerrar Caja</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="cerrarCajaForm" method="post">
            <div class="modal-body">
              <p>¿Estás seguro que deseas cerrar la caja? Esta acción es irreversible y registrará el cierre con el saldo actual.</p>
              <div class="form-group">
                <label>Monto de cierre</label>
                <input type="number" step="0.01" min="0" class="form-control" name="monto_cierre_directo" value="<?php echo number_format($saldo,2,'.',''); ?>" required>
              </div>
              <div class="form-group">
                <label>Usuario</label>
                <select class="form-control" name="usuario_cierre" required>
                  <option value="">Seleccionar usuario</option>
                  <?php foreach ($usuariosCaja as $usuario): ?>
                    <option value="<?php echo $usuario['id_admin']; ?>"><?php echo $usuario['name_admin']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="cerrar_caja_directo" class="btn btn-danger">Cerrar Caja</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Venta Manual -->
    <div class="modal fade" id="ventaManualModal" tabindex="-1" role="dialog" aria-labelledby="ventaManualLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="ventaManualLabel"><i class="fas fa-plus"></i> Registrar Venta Manual</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="ventaManualForm">
            <div class="modal-body">
              <div class="form-group">
                <label>Cliente</label>
                <input type="text" class="form-control" name="cliente" required <?php if(!$hayCajaAbierta) echo 'disabled'; ?>>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <input type="text" class="form-control" name="descripcion" required <?php if(!$hayCajaAbierta) echo 'disabled'; ?>>
              </div>
              <div class="form-group">
                <label>Monto</label>
                <input type="number" step="0.01" min="0" class="form-control" name="monto" required <?php if(!$hayCajaAbierta) echo 'disabled'; ?>>
              </div>
              <div class="form-group">
                <label>Prenda</label>
                <input type="text" class="form-control" name="prenda" required <?php if(!$hayCajaAbierta) echo 'disabled'; ?>>
              </div>
              <div class="form-group">
                <label>Cantidad</label>
                <input type="number" min="1" class="form-control" name="cantidad" value="1" required <?php if(!$hayCajaAbierta) echo 'disabled'; ?>>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success" <?php if(!$hayCajaAbierta) echo 'disabled'; ?>>Registrar Venta</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Abrir Caja -->
    <div class="modal fade" id="abrirCajaModal" tabindex="-1" role="dialog" aria-labelledby="abrirCajaLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="abrirCajaLabel"><i class="fas fa-unlock"></i> Abrir Caja</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          <form id="abrirCajaForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="modal-body">
              <div class="form-group">
                <label>Usuario que abre la caja</label>
                <select name="usuario_apertura" class="form-control" required>
                  <option value="">Selecciona un usuario</option>
                  <?php foreach($usuariosCaja as $u): ?>
                    <option value="<?php echo $u['id_admin']; ?>"><?php echo htmlspecialchars($u['name_admin']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="abrir_caja_directo" class="btn btn-warning">Abrir Caja</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Cerrar Caja Directo -->
    <div class="modal fade" id="cerrarCajaDirectoModal" tabindex="-1" role="dialog" aria-labelledby="cerrarCajaDirectoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="cerrarCajaDirectoLabel"><i class="fas fa-lock"></i> Cerrar Caja</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          <form id="cerrarCajaDirectoForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="id_caja" value="<?php echo isset($id_caja) ? $id_caja : ''; ?>">
            <div class="modal-body">
              <div class="form-group">
                <label>Usuario que cierra la caja</label>
                <select name="usuario_cierre" class="form-control" required>
                  <option value="">Selecciona un usuario</option>
                  <?php foreach($usuariosCaja as $u): ?>
                    <option value="<?php echo $u['id_admin']; ?>"><?php echo htmlspecialchars($u['name_admin']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Monto de cierre</label>
                <input type="number" step="0.01" min="0" class="form-control" name="monto_cierre_directo" value="<?php echo number_format($saldo,2,'.',''); ?>" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="cerrar_caja_directo" class="btn btn-danger">Cerrar Caja</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php if (empty($usuariosCaja)): ?>
    <div class="alert alert-danger mx-3">No hay administradores registrados en la base de datos.</div>
    <?php else: ?>
    <div class="alert alert-info mx-3">
        <b>Administradores disponibles:</b>
        <ul>
        <?php foreach($usuariosCaja as $u): ?>
            <li>ID: <?php echo $u['id_admin']; ?> - <?php echo htmlspecialchars($u['name_admin']); ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    function abrirCaja() {
        if(confirm('¿Deseas abrir una nueva caja?')){
            fetch('/web/ajax/abrir-caja.ajax.php', {
                method: 'POST'
            }).then(r=>r.json()).then(resp=>{
                if(resp.success){
                    alert('Caja abierta correctamente');
                    location.reload();
                }else{
                    alert('Error al abrir caja: '+resp.msg);
                }
            });
        }
    }
    function mostrarCerrarCajaModal() {
        $('#cerrarCajaModal').modal('show');
    }
    function mostrarVentaManualModal() {
        if(!<?php echo json_encode($hayCajaAbierta); ?>){
            alert('No hay caja abierta.');
            return;
        }
        $('#ventaManualModal').modal('show');
    }
    function mostrarAbrirCajaModal() {
        $('#abrirCajaModal').modal('show');
    }
    function mostrarCerrarCajaDirectoModal(e) {
        if(e) e.preventDefault();
        $('#cerrarCajaDirectoModal').modal('show');
        return false;
    }
    document.getElementById('cerrarCajaForm').onsubmit = function(e) {
        e.preventDefault();
        var monto = this.monto_cierre.value;
        var btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Cerrando...';
        fetch('/web/ajax/cerrar-caja.ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'monto_cierre=' + encodeURIComponent(monto)
        }).then(r=>r.json()).then(resp=>{
            btn.disabled = false;
            btn.textContent = 'Cerrar Caja';
            if(resp.success){
                $('#cerrarCajaModal').modal('hide');
                setTimeout(function(){
                    alert('Caja cerrada correctamente');
                    location.reload();
                }, 300);
            }else{
                alert('Error al cerrar caja: '+resp.msg);
            }
        }).catch(function(){
            btn.disabled = false;
            btn.textContent = 'Cerrar Caja';
            alert('Error de red al cerrar caja.');
        });
    };    document.getElementById('abrirCajaForm').onsubmit = function(e) {
        e.preventDefault();
        var usuario = this.usuario_apertura.value;
        if(!usuario){
            alert('Selecciona un usuario.');
            return;
        }
        
        // Añadir campo oculto para indicar que es apertura
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'abrir_caja_directo';
        hiddenInput.value = '1';
        this.appendChild(hiddenInput);
        
        // Enviar formulario tradicional (no AJAX)
        this.submit();
    };    document.getElementById('cerrarCajaDirectoForm').onsubmit = function(e) {
        e.preventDefault();
        var usuario = this.usuario_cierre.value;
        var monto = this.monto_cierre_directo.value;
        var idCaja = this.id_caja ? this.id_caja.value : '';
        
        if(!usuario){
            alert('Selecciona un usuario.');
            return;
        }
        
        if(!idCaja){
            alert('Error: No se ha especificado el ID de la caja.');
            return;
        }
        
        // Añadir campo oculto para indicar que es cierre (para depuración)
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'cerrar_caja_directo';
        hiddenInput.value = '1';
        this.appendChild(hiddenInput);
        
        console.log('Enviando formulario de cierre de caja:', {
            id_caja: idCaja,
            usuario_cierre: usuario,
            monto_cierre: monto
        });
        
        // Enviar formulario tradicional (no AJAX)
        this.submit();
    };
    document.getElementById('ventaManualForm').onsubmit = function(e) {
        if(!<?php echo json_encode($hayCajaAbierta); ?>){
            alert('No hay caja abierta.');
            return false;
        }
        e.preventDefault();
        var fd = new FormData(this);
        fetch('/web/ajax/venta-manual.ajax.php', {
            method: 'POST',
            body: fd
        }).then(r=>r.json()).then(resp=>{
            if(resp.success && resp.mov_id){
                alert('Venta registrada correctamente. Ahora genera la boleta.');
                let mov = {
                    id: resp.mov_id,
                    created_at: new Date().toISOString().slice(0,19).replace('T',' '),
                    tipo: 'ingreso',
                    descripcion: fd.get('descripcion') + ' | Cliente: ' + fd.get('cliente') + ' | Prenda: ' + fd.get('prenda') + ' | Cantidad: ' + fd.get('cantidad'),
                    monto: fd.get('monto'),
                    productos: [{name_product: fd.get('prenda'), quantity_order: fd.get('cantidad')}],
                    name_user: fd.get('cliente')
                };
                generarBoletaHTML(mov);
                location.reload();
            }else{
                alert('Error al registrar venta: '+resp.msg);
            }
        });
    };
    function mostrarFacturaForm(mov) {
        let formHtml = `
        <div id='factura-modal-bg' style='position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:9999;'>
          <div style='background:#fff;max-width:400px;margin:5% auto;padding:30px;border-radius:10px;box-shadow:0 0 20px #000;'>
            <h3 style='text-align:center;color:#007bff;'>Generar Factura</h3>
            <form id='facturaForm'>
              <div style='margin-bottom:10px;'>
                <label>Razón Social:</label>
                <input type='text' name='razon' required style='width:100%;padding:6px;'>
              </div>
              <div style='margin-bottom:10px;'>
                <label>RUC:</label>
                <input type='text' name='ruc' required style='width:100%;padding:6px;'>
              </div>
              <div style='text-align:center;'>
                <button type='submit' class='btn btn-primary'>Generar Factura PDF</button>
                <button type='button' class='btn btn-danger' onclick='cerrarFacturaForm()'>Cancelar</button>
              </div>
            </form>
          </div>
        </div>`;
        let modal = document.createElement('div');
        modal.innerHTML = formHtml;
        document.body.appendChild(modal);
        document.getElementById('facturaForm').onsubmit = function(e) {
            e.preventDefault();
            let razon = this.razon.value;
            let ruc = this.ruc.value;
            document.body.removeChild(modal);
            generarFacturaHTML(mov, razon, ruc);
        };
    }
    function cerrarFacturaForm() {
        let modal = document.getElementById('factura-modal-bg');
        if(modal) modal.parentNode.removeChild(modal);
    }
    function generarBoletaHTML(mov) {
        let codigo = mov.numero_boleta || ('BOL-' + Math.random().toString(36).substr(2, 10).toUpperCase());
        let fecha = mov.created_at;
        let descripcion = mov.descripcion;
        let monto = mov.monto;
        let id_venta = mov.id_venta || '-';
        let productosHTML = '';
        if (Array.isArray(mov.productos) && mov.productos.length > 0) {
            productosHTML = `<table style='width:100%;margin-bottom:10px;border-collapse:collapse;'>
                <thead><tr><th style='border-bottom:1px solid #28a745;text-align:left;'>Prenda</th><th style='border-bottom:1px solid #28a745;text-align:right;'>Cantidad</th></tr></thead><tbody>`;
            mov.productos.forEach(p => {
                productosHTML += `<tr><td>${p.name_product}</td><td style='text-align:right;'>${p.quantity_order}</td></tr>`;
            });
            productosHTML += '</tbody></table>';
        } else {
            productosHTML = '<em>No hay detalles de productos.</em>';
        }
        let nombre_cliente = mov.name_user || 'Cliente Genérico';
        let direccion_cliente = mov.address_user || 'Dirección no registrada';
        let html = `
        <div style='width:420px;margin:0 auto;font-family:monospace;border:2px solid #28a745;padding:24px;border-radius:12px;background:#fff;box-shadow:0 0 10px #bbb;'>
            <div style='text-align:center;margin-bottom:10px;'>
                <img src='/views/assets/img/template/logo.png' alt='Logo' style='height:48px;margin-bottom:8px;'>
            </div>
            <h2 style='color:#28a745;text-align:center;margin-bottom:8px;letter-spacing:2px;'>BOLETA ELECTRÓNICA</h2>
            <hr style='border:1px dashed #28a745;'>
            <table style='width:100%;font-size:15px;margin-bottom:10px;'>
                <tr><td><b>N° Boleta:</b></td><td style='text-align:right;'>${codigo}</td></tr>
                <tr><td><b>Fecha:</b></td><td style='text-align:right;'>${fecha}</td></tr>
                <tr><td><b>Cliente:</b></td><td style='text-align:right;'>${nombre_cliente}</td></tr>
                <tr><td><b>Dirección:</b></td><td style='text-align:right;'>${direccion_cliente}</td></tr>
                <tr><td><b>Descripción:</b></td><td style='text-align:right;'>${descripcion}</td></tr>
            </table>
            <div style='margin-bottom:10px;'>
                <b>Prendas compradas:</b>
                ${productosHTML}
            </div>
            <table style='width:100%;font-size:15px;margin-bottom:10px;'>
                <tr><td><b>Monto:</b></td><td style='text-align:right;'>$${parseFloat(monto).toFixed(2)}</td></tr>
                <tr><td><b>ID Venta:</b></td><td style='text-align:right;'>${id_venta}</td></tr>
            </table>
            <div style='text-align:center;font-size:13px;color:#888;margin-top:10px;'>Documento electrónico válido según normativa SUNAT.<br>Emitida por ecommerce</div>
            <div style='text-align:center;font-size:12px;color:#aaa;margin-top:8px;'>Representación impresa de boleta electrónica</div>
        </div>
        `;
        guardarYDescargarPDF(mov, html, `${codigo}.pdf`);
    }
    function generarFacturaHTML(mov, razon, ruc) {
        let codigo = mov.numero_boleta || ('FAC-' + Math.random().toString(36).substr(2, 10).toUpperCase());
        let fecha = mov.created_at;
        let descripcion = mov.descripcion;
        let monto = mov.monto;
        let id_venta = mov.id_venta || '-';
        let productosHTML = '';
        if (Array.isArray(mov.productos) && mov.productos.length > 0) {
            productosHTML = `<table style='width:100%;margin-bottom:10px;border-collapse:collapse;'>
                <thead><tr><th style='border-bottom:1px solid #007bff;text-align:left;'>Prenda</th><th style='border-bottom:1px solid #007bff;text-align:right;'>Cantidad</th></tr></thead><tbody>`;
            mov.productos.forEach(p => {
                productosHTML += `<tr><td>${p.name_product}</td><td style='text-align:right;'>${p.quantity_order}</td></tr>`;
            });
            productosHTML += '</tbody></table>';
        } else {
            productosHTML = '<em>No hay detalles de productos.</em>';
        }
        let nombre_cliente = mov.name_user || 'Cliente Genérico';
        let direccion_cliente = mov.address_user || 'Dirección no registrada';
        let html = `
        <div style='width:420px;margin:0 auto;font-family:monospace;border:2px solid #007bff;padding:24px;border-radius:12px;background:#fff;box-shadow:0 0 10px #bbb;'>
            <div style='text-align:center;margin-bottom:10px;'>
                <img src='/views/assets/img/template/logo.png' alt='Logo' style='height:48px;margin-bottom:8px;'>
            </div>
            <h2 style='color:#007bff;text-align:center;margin-bottom:8px;letter-spacing:2px;'>FACTURA ELECTRÓNICA</h2>
            <hr style='border:1px dashed #007bff;'>
            <table style='width:100%;font-size:15px;margin-bottom:10px;'>
                <tr><td><b>N° Factura:</b></td><td style='text-align:right;'>${codigo}</td></tr>
                <tr><td><b>Fecha:</b></td><td style='text-align:right;'>${fecha}</td></tr>
                <tr><td><b>Razón Social:</b></td><td style='text-align:right;'>${razon}</td></tr>
                <tr><td><b>RUC:</b></td><td style='text-align:right;'>${ruc}</td></tr>
                <tr><td><b>Cliente:</b></td><td style='text-align:right;'>${nombre_cliente}</td></tr>
                <tr><td><b>Dirección:</b></td><td style='text-align:right;'>${direccion_cliente}</td></tr>
                <tr><td><b>Descripción:</b></td><td style='text-align:right;'>${descripcion}</td></tr>
            </table>
            <div style='margin-bottom:10px;'>
                <b>Prendas compradas:</b>
                ${productosHTML}
            </div>
            <table style='width:100%;font-size:15px;margin-bottom:10px;'>
                <tr><td><b>Monto:</b></td><td style='text-align:right;'>$${parseFloat(monto).toFixed(2)}</td></tr>
                <tr><td><b>ID Venta:</b></td><td style='text-align:right;'>${id_venta}</td></tr>
            </table>
            <div style='text-align:center;font-size:13px;color:#888;margin-top:10px;'>Documento electrónico válido según normativa SUNAT.<br>Emitida por ecommerce</div>
            <div style='text-align:center;font-size:12px;color:#aaa;margin-top:8px;'>Representación impresa de factura electrónica</div>
        </div>
        `;
        guardarYDescargarPDF(mov, html, `${codigo}.pdf`);
    }
    function guardarYDescargarPDF(mov, html, filename) {
        let opt = {
            margin: 0.2,
            filename: filename,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        let container = document.createElement('div');
        container.innerHTML = html;
        document.body.appendChild(container);
        if (window.html2pdf) {
            html2pdf().set(opt).from(container).outputPdf('blob').then(function(pdfBlob) {
                let reader = new FileReader();
                reader.onload = function() {
                    let base64 = reader.result.split(',')[1];
                    fetch('/web/ajax/upload-pdf.ajax.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'mov_id=' + encodeURIComponent(mov.id) + '&pdf_base64=' + encodeURIComponent(base64)
                    }).then(() => {
                        html2pdf().set(opt).from(container).save().then(() => {
                            document.body.removeChild(container);
                        });
                    });
                };
                reader.readAsDataURL(pdfBlob);
            });
        } else {
            alert('Para descargar el PDF automáticamente, incluye html2pdf.js en tu proyecto.');
            document.body.removeChild(container);
        }
    }
    </script>
</body>
</html>
<?php
// --- Lógica para procesar operaciones de caja (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST recibido: " . print_r($_POST, true));
    
    // ABRIR CAJA
    if (isset($_POST['abrir_caja_directo'])) {
        $usuarioApertura = isset($_POST['usuario_apertura']) ? intval($_POST['usuario_apertura']) : 0;
        if ($usuarioApertura > 0) {
            try {
                $pdo = Connection::connect();                // Verificar si ya hay una caja abierta
                $stmt = $pdo->query("SELECT id FROM caja WHERE estado='abierta' LIMIT 1");
                $cajaAbierta = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($cajaAbierta) {
                    echo "<script>alert('Ya hay una caja abierta (ID: " . $cajaAbierta['id'] . ").');</script>";
                } else {                    // Abrir nueva caja
                    try {
                        $sql = "INSERT INTO caja (estado, monto_apertura, monto_cierre, fecha, usuario_apertura) VALUES ('abierta', 0, 0, CURDATE(), ?)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$usuarioApertura]);
                        $id = $pdo->lastInsertId();
                        echo "<script>alert('Caja abierta correctamente. ID: " . $id . "');</script>";
                    } catch (Exception $e) {
                        // Si falla con usuario_apertura, intentar sin él
                        $sql = "INSERT INTO caja (estado, monto_apertura, monto_cierre, fecha) VALUES ('abierta', 0, 0, CURDATE())";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $id = $pdo->lastInsertId();
                        echo "<script>alert('Caja abierta correctamente (modo simple). ID: " . $id . "');</script>";
                    }
                }
            } catch(Exception $e) {
                echo "<script>alert('Error al abrir caja: " . addslashes($e->getMessage()) . "');</script>";
            }
        } else {
            echo "<script>alert('Faltan datos para abrir la caja: se requiere un usuario.');</script>";
        }
    }    // CERRAR CAJA
    if (isset($_POST['cerrar_caja_directo'])) {
        $idCaja = isset($_POST['id_caja']) ? intval($_POST['id_caja']) : 0;
        $usuarioCierre = isset($_POST['usuario_cierre']) ? intval($_POST['usuario_cierre']) : 0;
        $montoCierre = isset($_POST['monto_cierre_directo']) ? floatval($_POST['monto_cierre_directo']) : 0;

        error_log("Intentando cerrar caja: id=$idCaja, usuario=$usuarioCierre, monto=$montoCierre");

        if ($idCaja > 0 && $usuarioCierre > 0) {
            try {
                $pdo = Connection::connect();
                
                // Verificar si la caja existe y está abierta
                $stmt = $pdo->prepare("SELECT id, estado FROM caja WHERE id = ?");
                $stmt->execute([$idCaja]);
                $caja = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$caja) {
                    echo "<script>alert('Error: La caja con ID $idCaja no existe.');</script>";
                } else if ($caja['estado'] !== 'abierta') {
                    echo "<script>alert('La caja con ID $idCaja ya está cerrada.');</script>";
                } else {                    // Método simple y directo para cerrar caja
                    try {
                        // Primera opción: Usar consulta SQL directa, igual que en apertura
                        $sql = "UPDATE caja SET estado='cerrada', usuario_cierre=$usuarioCierre, monto_cierre=$montoCierre, fecha_cierre=NOW() WHERE id=$idCaja";
                        $resultado = $pdo->exec($sql);
                        
                        if ($resultado !== false) {
                            echo "<script>alert('Caja cerrada correctamente. ID: $idCaja');</script>";
                            error_log("Caja cerrada correctamente ID: $idCaja, filas afectadas: $resultado");
                        } else {
                            // Segunda opción: Solo actualizar el estado
                            $resultado = $pdo->exec("UPDATE caja SET estado='cerrada' WHERE id=$idCaja");
                            echo "<script>alert('Caja cerrada en modo simple. ID: $idCaja');</script>";
                            error_log("Caja cerrada en modo simple ID: $idCaja, filas afectadas: $resultado");
                        }
                    } catch (Exception $e) {
                        // Tercer intento con consulta más básica
                        error_log("Error al cerrar caja: " . $e->getMessage());                        try {
                            $pdo->exec("UPDATE caja SET estado='cerrada' WHERE id=$idCaja");
                            echo "<script>alert('Caja cerrada en modo de emergencia. ID: $idCaja');</script>";
                            error_log("Caja cerrada en modo de emergencia ID: $idCaja");
                        } catch (Exception $e2) {
                            error_log("Error en cierre de emergencia: " . $e2->getMessage());
                        }
                    }
                }
            } catch(Exception $e) {
                echo "<script>alert('Error crítico al cerrar caja: " . addslashes($e->getMessage()) . "');</script>";
                error_log("Error crítico al cerrar caja: " . $e->getMessage());
            }
        } else {
            echo "<script>alert('Faltan datos para cerrar la caja: ID Caja: $idCaja, Usuario: $usuarioCierre');</script>";
        }
    }
    
    echo "<script>setTimeout(function() { window.location.href = window.location.pathname; }, 500);</script>";
}
