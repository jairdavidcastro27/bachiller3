
<div class="content pb-5">
	
	<div class="container">
		
		<div class="card">
			
			<div class="card-header">
				
				<h3 class="card-title">
					<button type="button" class="btn bg-default templateColor py-2 px-3 btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#mySocial">Agregar Red Social</button>
				</h3>

			</div>

			<div class="card-body">
				
				<table id="tablesStatic" class="table table-bordered table-striped">
					
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Url</th>
							<th>Icono</th>
							<th>Color</th>
							<th>Acciones</th>
						</tr>
						
					</thead>
					<tbody>

						<?php foreach ($socials as $key => $value): ?>

							<tr>
								<td><?php echo $key+1 ?></td>

								<td>
									<p class="text-uppercase"><?php echo $value->name_social ?></p>
								</td>

								<td>
									<a href="<?php echo $value->url_social ?>" target="_blank"><?php echo $value->url_social ?> <i class="fas fa-external-link-alt ml-1"></i></a>
								</td>

								<td>
									<span class="badge badge-light border rounded-pill text-white py-2 px-3" style="background:<?php echo $topColor->background ?>"><i class="<?php echo $value->icon_social ?> <?php echo $value->color_social ?>"></i></span>
								</td>
								
								<td>
									<h3 class="border <?php echo $value->color_social ?> rounded p-0 m-0 text-center" style="width:31px; height:31px"><i class="fas fa-square p-0"></i></h3>
								</td>

								<td>
									<div class="btn-group">
										<button href="" class="btn bg-purple border-0 rounded-pill mr-2 btn-sm px-3 modalEditSocial" data-social='<?php echo json_encode($value) ?>'>
											<i class="fas fa-pencil-alt text-white"></i>
										</button>
										<button href="" class="btn btn-dark border-0 rounded-pill mr-2 btn-sm px-3 deleteItem" rol="admin" table="socials" column="social" idItem="<?php echo base64_encode($value->id_social) ?>">
											<i class="fas fa-trash-alt text-white"></i>
										</button>
									</div>
								</td>
							</tr>
							
						<?php endforeach ?>

						

					</tbody>

				</table>

			</div>

		</div>

	</div>

</div>

<!-- The Modal -->
<div class="modal fade" id="mySocial">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<form method="post" class="needs-validation" novalidate>

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Gestionar Red Social</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body bodyMySocial">
					
					<div class="mb-3 mt-3">
						
						<label for="name_social" class="form-label">Nombre:</label>
						
						<input type="text" 
						class="form-control" 
						id="name_social" 
						placeholder="Ej: Facebook" 
						name="name_social" 
						onchange="validateJS(event,'text')"
						required>

						<div class="valid-feedback">Válido.</div>
						<div class="invalid-feedback">Por favor llena este campo correctamente.</div>
					
					</div>

					<div class="mb-3 mt-3">

						<label for="url_social" class="form-label">Url:</label>
						
						<input 
						type="text" 
						class="form-control" 
						id="url_social" 
						placeholder="Ej: https://facebook.com/" 
						name="url_social" 
						onchange="validateJS(event,'complete')"
						required>

						<div class="valid-feedback">Válido.</div>
						<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					</div>

					<div class="row">

						<label class="form-label">Icono y color:</label>
						
						<div class="col">

							<div class="input-group">

								<span class="input-group-text iconView" style="background:<?php echo $topColor->background ?>;">
									<i class="fas fa-shopping-bag"></i>
								</span>

								<input 
								type="text"
								class="form-control"
								id="icon_social"
								name="icon_social"
								onfocus="addIcon(event)"
								value="fas fa-shopping-bag"
								required
								>

								<div class="valid-feedback">Válido.</div>
								<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

							</div>

						</div>

						<div class="col">
							<select class="form-select" onchange="changeColorSocial(event)" id="color_social" name="color_social">
							  <option value="">Selecciona Color</option>
							  <option value="text-white">Blanco</option>
							  <option value="text-dark">Negro</option>
							  <option value="text-facebook">Facebook</option>
							  <option value="text-youtube">YouTube</option>
							  <option value="text-instagram">Instagram</option>
							  <option value="text-twitter">Twitter</option>
							  <option value="text-linkedin">Linkedin</option>
							  <option value="text-twitch">Twitch</option>
							</select>
						</div>
					</div>

				</div>

				<!-- Modal footer -->
				<div class="modal-footer d-flex justify-content-between">
					<div><button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">Cerrar</button></div>
					<div><button type="submit" class="btn btn-default templateColor rounded-pill">Guardar</button></div>  
				</div>

				<?php 

					require_once "controllers/socials.controller.php";
					$manage = new SocialsController();
					$manage -> socialManage();
				
				?>

			</form>

		</div>
	</div>
</div>

<!--=====================================
Modal con librería de iconos
======================================-->

<div class="modal" id="myIcon">
	
	<div class="modal-dialog modal-lg modal-dialog-centered ">
		
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title">Cambiar Icono</h4>
				<button type="button" class="close"  data-bs-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body mx-3">

				<input type="text" class="form-control mt-4 mb-3 myInputIcon" placeholder="Buscar Icono">
				
				<?php 

				$data = file_get_contents($path."views/assets/json/fontawesome.json");
				$icons = json_decode($data);
		
				?>

				<div 
				class="row row-cols-1 row-cols-sm-2 row-cols-md-4 py-3"
				style="overflow-y: scroll; overflow-x: hidden; height:500px"
				>
					
					<?php foreach ($icons as $key => $value): ?>

						<div class="col text-center py-4 btn btnChangeIcon" mode="<?php echo $value  ?>">
							<i class="<?php echo $value ?> fa-2x"></i>
						</div>
						
					<?php endforeach ?>

				</div>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Salir</button>

			</div>

		</div>

	</div>

</div>


