<?php 

if(isset($_GET["subcategory"])){

	$select = "id_subcategory,name_subcategory,url_subcategory,image_subcategory,description_subcategory,keywords_subcategory,id_category_subcategory";
	$url = "subcategories?linkTo=id_subcategory&equalTo=".base64_decode($_GET["subcategory"])."&select=".$select;
	$method = "GET";
	$fields = array();

	$subcategory = CurlController::request($url, $method, $fields);
	
	if($subcategory->status == 200){

		$subcategory = $subcategory->results[0];

	}else{

		$subcategory = null;

	}

}else{

	$subcategory = null;
	
	
}


 ?>


<div class="content pb-5">
	
	<div class="container">
		
		<div class="card">
			
			<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

				<?php if (!empty($subcategory)): ?>

					<input type="hidden" name="idSubcategory" value="<?php echo base64_encode($subcategory->id_subcategory) ?>">
					
				<?php endif ?>

				<div class="card-header">
					
					<div class="container">
						
						<div class="row">
							
							<div class="col-12 col-lg-6 text-center text-lg-left">							
								
								<h4 class="mt-3">Agregar Subcategoría</h4>
											
							</div>	

							<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill">Guardar Información</button>
								
								<a href="/admin/subcategorias" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/subcategorias" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

				<div class="card-body">

					<?php 

						require_once "controllers/subcategories.controller.php";
						$manage = new SubcategoriesController();
						$manage -> subcategoryManage();
					
					?>


					<!--=====================================
					PRIMER BLOQUE
					======================================-->

					<div class="row row-cols-1"> 

						<div class="col">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Seleccionar la categoría
									======================================-->

									<div class="form-group pb-3">

										<?php if (!empty($subcategory)): ?>

											<input type="hidden" name="old_id_category_subcategory" value="<?php echo base64_encode($subcategory->id_category_subcategory) ?>">
	
										<?php endif ?>
										
										<label for="id_category_subcategory">Seleccionar Categoría<sup class="text-danger">*</sup></label>

										<?php 

										 	$url = "categories?select=id_category,name_category";
											$method = "GET";
						                	$fields = array();

						                	$categories = CurlController::request($url, $method, $fields);

						                	if($categories->status == 200){

						                		$categories = $categories->results;
						                	
						                	}else{

						                		$categories = array();
						                	}

										?>

										<select
					                    class="custom-select"
					                    name="id_category_subcategory"
					                    id="id_category_subcategory"
					                    required>

					                    	<option value="">Selecciona Categoría</option>

					                    	<?php foreach ($categories as $key => $value): ?>

					                    		<option value="<?php echo $value->id_category ?>" <?php if (!empty($subcategory) && $subcategory->id_category_subcategory == $value->id_category): ?> selected <?php endif ?>><?php echo $value->name_category ?></option>
					                    		
					                    	<?php endforeach ?>

					                	</select>

									</div>


									<!--=====================================
									Título de la subcategoría
									======================================-->
									
									<div class="form-group pb-3"> 

										<label for="name_subcategory">Título <sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar el título"
										id="name_subcategory"
										name="name_subcategory"
										onchange="validateDataRepeat(event,'subcategory')"
										<?php if (!empty($subcategory)): ?> readonly <?php endif ?>
										value="<?php if (!empty($subcategory)): ?><?php echo $subcategory->name_subcategory ?><?php endif ?>"
										required
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									URL de la subcategoría
									======================================-->

									<div class="form-group pb-3"> 

										<label for="url_subcategory">URL <sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control"
										id="url_subcategory"
										name="url_subcategory"
										value="<?php if (!empty($subcategory)): ?><?php echo $subcategory->url_subcategory ?><?php endif ?>"
										readonly
										required
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

								</div>

							</div>

						</div>

					</div>

					<!--=====================================
					SEGUNDO BLOQUE
					======================================-->

					<div class="row row-cols-1 row-cols-md-2 pt-2"> 

						<div class="col">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Descripción de la subcategoría
									======================================-->
									
									<div class="form-group pb-3"> 

										<label for="description_subcategory">Descripción<sup class="text-danger font-weight-bold">*</sup></label>

										<textarea 
										rows="9"
										class="form-control mb-3"
										placeholder="Ingresar la descripción"
										id="description_subcategory"
										name="description_subcategory"
										onchange="validateJS(event,'complete')"
										required
										><?php if (!empty($subcategory)): ?><?php echo $subcategory->description_subcategory ?><?php endif ?></textarea>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Palabras claves de la categoría
									======================================-->

									<div class="form-group pb-3"> 

										<label for="keywords_subcategory">Palabras claves<sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control tags-input"
										data-role="tagsinput"
										placeholder="Ingresar las palabras claves"
										id="keywords_subcategory"
										name="keywords_subcategory"
										onchange="validateJS(event,'complete-tags')"
										value="<?php if (!empty($subcategory)): ?><?php echo $subcategory->keywords_subcategory ?><?php endif ?>"
										required
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

								</div>

							</div>

						</div>

						<div class="col">

							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Imagen de la subcategoría
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Imagen de la Subcategoría<sup class="text-danger">*</sup></label>

										<label for="image_subcategory">
											
											
											<?php if (!empty($subcategory)): ?>

												<input type="hidden" value="<?php echo $subcategory->image_subcategory ?>" name="old_image_subcategory">

												<img src="/views/assets/img/subcategories/<?php echo $subcategory->url_subcategory ?>/<?php echo $subcategory->image_subcategory ?>" class="img-fluid changeImage">

											<?php else: ?>

												<img src="/views/assets/img/subcategories/default/default-image.jpg" class="img-fluid changeImage">
												
											<?php endif ?>
											

											<p class="help-block small mt-3">Dimensiones recomendadas: 1000 x 600 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="image_subcategory"
										 	name="image_subcategory"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeImage')"
										 	<?php if (empty($subcategory)): ?>
										 	required	
										 	<?php endif ?>
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="image_subcategory">Buscar Archivo</label>

										 </div>

									</div>

								</div>

							</div>				

						</div>

					</div>

					<!--=====================================
					TERCER BLOQUE
					======================================-->

					<div class="row row-cols-1 pt-2">
						
						<div class="col">
							
							<div class="card">
								
								<div class="card-body col-md-6 offset-md-3">
									
									<!--=====================================
									Visor metadatos
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label>Visor Metadatos</label>

										<div class="d-flex justify-content-center">
											
											<div class="card">
												
												<div class="card-body">

													<!--=====================================
													Visor imagen
													======================================-->

													<figure class="mb-2">

														<?php if (!empty($subcategory)): ?>

															<img src="/views/assets/img/subcategories/<?php echo $subcategory->url_subcategory ?>/<?php echo $subcategory->image_subcategory ?>" class="img-fluid metaImg" style="width:100%">

														<?php else: ?>

															<img src="/views/assets/img/subcategories/default/default-image.jpg" class="img-fluid metaImg" style="width:100%">

														<?php endif ?>
														
													</figure>

													<!--=====================================
													Visor título
													======================================-->

													<h6 class="text-left text-primary mb-1 metaTitle">

														<?php if (!empty($subcategory)): ?>
													    	<?php echo $subcategory->name_subcategory ?>
													    <?php else: ?>
													    	Lorem ipsum dolor sit
													    <?php endif ?>

													</h6>

													<!--=====================================
													Visor URL
													======================================-->

													<p class="text-left text-success small mb-1">
														<?php echo $path ?><span class="metaURL"><?php if (!empty($subcategory)): ?><?php echo $subcategory->url_subcategory ?><?php else: ?>lorem<?php endif ?></span>
													</p>

													<!--=====================================
													Visor Descripción
													======================================-->

													<p class="text-left small mb-1 metaDescription">

														<?php if (!empty($subcategory)): ?>
													    	<?php echo $subcategory->description_subcategory ?>
													    <?php else: ?>
															Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus impedit ipsam obcaecati voluptas unde error quod odit ad sapiente vitae.
														<?php endif ?> 
													</p>

													<!--=====================================
													Visor Palabras claves
													======================================-->

													<p class="small text-left text-secondary metaTags">
														<?php if (!empty($subcategory)): ?>
															<?php echo $subcategory->keywords_subcategory ?>
														<?php else: ?>	
															lorem, ipsum, dolor, sit
														<?php endif ?>
													</p>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>
				
				</div>

				<div class="card-footer">
					
					<div class="container">
						
						<div class="row">
							
							<div class="col-12 col-lg-6 text-center text-lg-left mt-lg-3">
								
								<label class="font-weight-light"><sup class="text-danger">*</sup> Campos obligatorios</label>

							</div>	

							<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill">Guardar Información</button>
								
								<a href="/admin/categorias" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/categorias" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>


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

