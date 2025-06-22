<?php 

if(isset($_GET["template"])){

	$url = "templates?linkTo=id_template&equalTo=".base64_decode($_GET["template"]);
	$method = "GET";
	$fields = array();

	$template = CurlController::request($url, $method, $fields);
	
	if($template->status == 200){

		$template = $template->results[0];
	
	}else{

		$template = null;

	}

}else{

	$template = null;
	
}


?>


<div class="content pb-5">

	<div class="container">
		
		<div class="card">

			<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

				<?php if (!empty($template)): ?>

					<input type="hidden" name="idTemplate" value="<?php echo base64_encode($template->id_template) ?>">
		
				<?php endif ?>

				<div class="card-header">
					
					<div class="container">
						
						<div class="row">

							<div class="col-12 col-lg-6 text-center text-lg-left">
								
								<?php if (!empty($template)): ?>

									<h4 class="mt-3">Editar Plantilla</h4>
								
								<?php else: ?>

									<h4 class="mt-3">Agregar Plantilla</h4>

								<?php endif ?>
								
							</div>

							<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill">Guardar Información</button>
								
								<a href="/admin/plantillas" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/plantillas" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	


						</div>

					</div>

				</div>

				<div class="card-body">
					
					<?php 

						require_once "controllers/templates.controller.php";
						$manage = new TemplatesController();
						$manage -> templatesManage();
					
					?>

					<!--=====================================
					PRIMER BLOQUE
					======================================-->

					<div class="row row-cols-1 row-cols-md-2 pt-2"> 

						<div class="col">
							
							<div class="card">
								
								<div class="card-body">
									
									<!--=====================================
									Título de la plantilla
									======================================-->

									<div class="form-group pb-3"> 

										<label for="title_template">Título <sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar el título"
										id="title_template"
										name="title_template"
										onchange="validateJS(event,'text')"
										value="<?php if (!empty($template)): ?><?php echo $template->title_template ?><?php endif ?>"
										required
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Descripción de la plantilla
									======================================-->
									
									<div class="form-group pb-3"> 

										<label for="description_template">Descripción<sup class="text-danger font-weight-bold">*</sup></label>

										<textarea 
										rows="9"
										class="form-control"
										placeholder="Ingresar la descripción"
										id="description_template"
										name="description_template"
										onchange="validateJS(event,'complete')"
										required
										><?php if (!empty($template)): ?><?php echo $template->description_template ?><?php endif ?></textarea>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Palabras claves de la plantilla
									======================================-->

									<div class="form-group pb-3"> 

										<label for="keywords_template">Palabras claves<sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control tags-input"
										data-role="tagsinput"
										placeholder="Ingresar las palabras claves"
										id="keywords_template"
										name="keywords_template"
										onchange="validateJS(event,'complete-tags')"
										value="<?php if (!empty($template)): ?><?php echo $template->keywords_template ?><?php endif ?>"
										required
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Fuentes de la plantilla
									======================================-->

									<div class="form-group pb-3"> 

										<label>Fuentes <sup class="text-danger font-weight-bold">*</sup></label>

										<div class="input-group">

	    									<span class="input-group-text">Google Fonts:</span>

											<textarea 
											type="text"
											class="form-control"
											id="fontFamily"
											rows="7"
											required
											><?php if (!empty($template)): ?><?php echo htmlspecialchars(urldecode(json_decode($template->fonts_template)->fontFamily)) ?><?php endif ?></textarea>

											<div class="valid-feedback">Válido.</div>
											<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

											<input type="hidden" name="fontFamily">

										</div>

										<div class="row my-3">
											
											<div class="col">

												<div class="input-group">

													<span class="input-group-text">Body:</span>

													<input type="text" 
													class="form-control"
													placeholder="Font Family"
													id="fontBody"
													name="fontBody"
													value="<?php if (!empty($template)): ?><?php echo json_decode($template->fonts_template)->fontBody ?><?php endif ?>"
													required 
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

											<div class="col">

												<div class="input-group">

													<span class="input-group-text">Slide:</span>

													<input 
													type="text" 
													class="form-control" 
													placeholder="Font Family"
													id="fontSlide"
													name="fontSlide"
													value="<?php if (!empty($template)): ?><?php echo json_decode($template->fonts_template)->fontSlide ?><?php endif ?>"
													required >

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>


										</div>
		

									</div>

									<!--=====================================
									Colores de la plantilla
									======================================-->

									<div class="form-group pb-3"> 

										<label>Colores <sup class="text-danger font-weight-bold">*</sup></label>

										<div class="row mb-3">

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Texto Superior:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="topColor"
													name="topColor"	
													value="<?php if (!empty($template)): ?><?php echo json_decode($template->colors_template)[0]->top->color ?><?php endif ?>"	
													required
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Fondo Superior:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="topBackground"
													name="topBackground"
													value="<?php if (!empty($template)): ?><?php echo json_decode($template->colors_template)[0]->top->background ?><?php endif ?>"	
													required
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

										</div>

										<div class="row mb-3">

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Texto Botón:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="templateColor"
													name="templateColor"
													value="<?php if (!empty($template)): ?><?php echo json_decode($template->colors_template)[1]->template->color ?><?php endif ?>"	
													required
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Fondo Botón:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="templateBackground"
													name="templateBackground"
													value="<?php if (!empty($template)): ?><?php echo json_decode($template->colors_template)[1]->template->background ?><?php endif ?>"	
													required
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

										</div>



									</div>


								</div>

							</div>

						</div>

						<div class="col">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Logo de la plantilla
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Logo de la plantilla<sup class="text-danger">*</sup></label>

										<label for="logo_template">

											<?php if (!empty($template)): ?>

												<input type="hidden" value="<?php echo $template->logo_template ?>" name="old_logo_template">

												<img src="/views/assets/img/template/<?php echo $template->id_template ?>/<?php echo $template->logo_template ?>" class="img-fluid changeLogo">

											<?php else: ?>

												<img src="/views/assets/img/template/default/default-logo.jpg" class="img-fluid changeLogo">
												
											<?php endif ?>
											

												
											<p class="help-block small mt-3">Dimensiones recomendadas: 500 x 100 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="logo_template"
										 	name="logo_template"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeLogo')"
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="logo_template">Buscar Archivo</label>

										 </div>

									</div>

									<!--=====================================
									Icono de la plantilla
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Icono de la plantilla<sup class="text-danger">*</sup></label>

										<label for="icon_template">
											
											<?php if (!empty($template)): ?>

												<input type="hidden" value="<?php echo $template->icon_template ?>" name="old_icon_template">

												<img src="/views/assets/img/template/<?php echo $template->id_template ?>/<?php echo $template->icon_template ?>" class="img-fluid changeIcon">

											<?php else: ?>

												<img src="/views/assets/img/template/default/default-icon.jpg" class="img-fluid changeIcon">
												
											<?php endif ?>
											<p class="help-block small mt-3">Dimensiones recomendadas: 100 x 100 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="icon_template"
										 	name="icon_template"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeIcon')"
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="icon_template">Buscar Archivo</label>

										 </div>

									</div>


									<!--=====================================
									Imagen de la plantilla
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Imagen de la plantilla<sup class="text-danger">*</sup></label>

										<label for="cover_template">
											
											<?php if (!empty($template)): ?>

												<input type="hidden" value="<?php echo $template->cover_template ?>" name="old_cover_template">

												<img src="/views/assets/img/template/<?php echo $template->id_template ?>/<?php echo $template->cover_template ?>" class="img-fluid changeCover">

											<?php else: ?>

												<img src="/views/assets/img/template/default/default-image.jpg" class="img-fluid changeCover">
												
											<?php endif ?>

											<p class="help-block small mt-3">Dimensiones recomendadas: 1000 x 600 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="cover_template"
										 	name="cover_template"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeCover')"
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="cover_template">Buscar Archivo</label>

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
								
								<a href="/admin/plantillas" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/plantillas" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

			</form>

		</div>

	</div>

</div>