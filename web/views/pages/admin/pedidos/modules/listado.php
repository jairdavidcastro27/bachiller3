<div class="content pb-5">
	
	<div class="container">
		
		<div class="card">
			
			<div class="card-header"></div>

			<div class="card-body">
				
				<table id="tables" class="table table-bordered table-striped ordersTable">
					
					<thead>
						<tr>
							<th>#</th>
							<th>Estado</th>
							<th>Imagen</th>
							<th>Producto</th>	
							<th>Cantidad</th>
							<th>Precio</th>
							<th>Cliente</th>
							<th>Referencia</th>
							<th>Método</th>
							<th>Id Pago</th>
							<th>Guía</th>
							<th>Fechas</th>
							<th>Acciones</th>
						</tr>
						
					</thead>
					<tbody>
						<!--  <tr>
							<td>1</td>

							<td>
								<span class="badge badge-warning rounded-pill px-3 py-1">Pendiente</span>
							</td>

							<td>
								<img src="/views/assets/img/products/default/default-image.jpg" class="img-thumbnail rounded">
							</td>

							<td>Ropa - Conjunto Beige</td>

							<td>1</td>

							<td>$150</td>

							<td>Juan Urrego</td>

							<td>
								<span class="badge badge-default border rounded-pill text-dark px-3 py-1">86291706914879</span>
							</td>

							<td>DLOCAL</td>

							<td>DP-41467</td>

							<td>24124124</td>

							<td>
								<span class="badge badge-warning rounded-pill px-3 py-1">2024-02-02</span>
								<span class="badge badge-primary rounded-pill px-3 py-1">2024-02-03</span>
								<span class="badge badge-success rounded-pill px-3 py-1">2024-02-05</span>
							</td>

							<td>
								<div class="btn-group">
									<a href="" class="btn bg-purple border-0 rounded-pill mr-2 btn-sm px-3">
										<i class="fas fa-pencil-alt text-white"></i>
									</a>
								</div>
							</td>
						</tr>
 -->
					</tbody>


				</table>


			</div>

		</div>

	</div>	


</div>

<!--=================================
MODAL PARA EDITAR UNA ORDEN
====================================-->

<!-- The Modal -->
<div class="modal fade" id="myOrder">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<form method="post" class="needs-validation" novalidate>

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Gestionar pedido</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body bodyMyOrder">

					<div class="mb-3 mt-3">
						
						<label for="process_order" class="form-label">Estado de la Orden:</label>
						
						<select class="form-select" name="process_order" id="process_order">
							<option value="0" id="opt0">Pendiente</option>
							<option value="1" id="opt1">En proceso</option>
							<option value="2" id="opt2">Entregado</option>
							<option value="3" id="opt3">Garantía</option>
							<option value="4" id="opt4">Devolución Dinero</option>
						</select>

						<div class="valid-feedback">Válido.</div>
						<div class="invalid-feedback">Por favor llena este campo correctamente.</div>
					
					</div>

					<div class="mb-3 mt-3">

						<label for="track_order" class="form-label">Guía Transportadora:</label>
						
						<input 
						type="text" 
						class="form-control" 
						id="track_order" 
						placeholder="Número de guía transportadora"
						name="track_order" 
						onchange="validateJS(event,'complete')"
						>

						<div class="valid-feedback">Válido.</div>
						<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					</div>

					<div class="mb-3 mt-3">

						<label for="start_date_order" class="form-label">Fecha Inicial:</label>
						
						<input 
						type="date" 
						class="form-control" 
						id="start_date_order" 
						name="start_date_order" 
						>

					</div>

					<div class="mb-3 mt-3">

						<label for="medium_date_order" class="form-label">Fecha Intermedia:</label>
						
						<input 
						type="date" 
						class="form-control" 
						id="medium_date_order" 
						name="medium_date_order" 
						>

					</div>

					<div class="mb-3 mt-3">

						<label for="end_date_order" class="form-label">Fecha Final:</label>
						
						<input 
						type="date" 
						class="form-control" 
						id="end_date_order" 
						name="end_date_order" 
						>

					</div>
	

				</div>

				<!-- Modal footer -->
				<div class="modal-footer d-flex justify-content-between">
					<div><button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">Cerrar</button></div>
					<div><button type="submit" class="btn btn-default templateColor rounded-pill">Guardar</button></div>  
				</div>

				<?php 

					require_once "controllers/payments.controller.php";
					$manage = new PaymentsController();
					$manage -> editOrder();
				
				?>

			</form>

		</div>
	</div>
</div>

<!--=================================
MODAL PARA NOTA DE CRÉDITO
====================================-->
<div class="modal fade" id="modalCreditNote">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h4 class="modal-title">Crear Nota de Crédito</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3">
                        <label for="credit_order" class="form-label">Orden</label>
                        <select id="credit_order" name="credit_order" class="form-select" required></select>
                        <div class="invalid-feedback">Selecciona una orden válida.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="credit_user" class="form-label">Usuario</label>
                        <select id="credit_user" name="credit_user" class="form-select" required></select>
                        <div class="invalid-feedback">Selecciona un usuario válido.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="credit_amount" class="form-label">Monto</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="credit_amount" name="credit_amount" placeholder="Monto de la nota de crédito" required>
                        <div class="invalid-feedback">Ingresa un monto válido.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="credit_reason" class="form-label">Motivo</label>
                        <textarea class="form-control" id="credit_reason" name="credit_reason" rows="2" placeholder="Motivo de la nota de crédito" required></textarea>
                        <div class="invalid-feedback">Ingresa el motivo.</div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div><button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">Cerrar</button></div>
                    <div><button type="submit" class="btn btn-success rounded-pill">Crear Nota de Crédito</button></div>
                </div>
                <!-- Aquí puedes agregar el PHP para procesar la nota de crédito si lo deseas -->
            </form>
        </div>
    </div>
</div>