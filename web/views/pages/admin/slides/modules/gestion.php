<?php 

if(isset($_GET["slide"])){

	$select = "*";
	$url = "slides?linkTo=id_slide&equalTo=".base64_decode($_GET["slide"])."&select=".$select;
	$method = "GET";
	$fields = array();

	$slide = CurlController::request($url, $method, $fields);
	
	if($slide->status == 200){

		$slide = $slide->results[0];

	}else{

		$slide = null;

	}

}else{

	$slide = null;
	
}

?>


<div class="content pb-5">
	
	<div class="container">

		<div class="card">
			
			<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

				<?php if (!empty($slide)): ?>

					<input type="hidden" name="idSlide" value="<?php echo base64_encode($slide->id_slide) ?>">
		
				<?php endif ?>

				<div class="card-header">
					
					<div class="container">
						
						<div class="row">
							
							<div class="col-12 col-lg-6 text-center text-lg-left">

								<?php if (!empty($slide)): ?>
									<h4 class="mt-3">Editar Slide</h4>
								<?php else: ?>
									<h4 class="mt-3">Agregar Slide</h4>
								<?php endif ?>
													
							</div>	

							<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill">Guardar Información</button>
								
								<a href="/admin/slides" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/slides" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

				<div class="card-body">

					<input type="hidden" name="slide" value="slide">

					<?php 

						require_once "controllers/slides.controller.php";
						$manage = new SlidesController();
						$manage -> slidesManage();
					
					?>
					
					<!--=====================================
					PRIMER BLOQUE
					======================================-->

					<div class="row row-cols-1 pt-2">
						
						<div class="col">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Imagen de fondo
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Imagen de fondo<sup class="text-danger">*</sup></label>

										<label for="background_slide">
											
											
											<?php if (!empty($slide)): ?>

												<input type="hidden" value="<?php echo $slide->background_slide ?>" name="old_background_slide">

												<img src="/views/assets/img/slide/<?php echo $slide->id_slide ?>/<?php echo $slide->background_slide ?>" class="img-fluid changeBackground">

											<?php else: ?>

												<img src="/views/assets/img/slide/default/default-slide.jpg" class="img-fluid changeBackground">
												
											<?php endif ?>
											

											<p class="help-block small mt-3">Dimensiones recomendadas: 1600 x 520 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="background_slide"
										 	name="background_slide"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeBackground')"
										 	<?php if (empty($slide)): ?>
										 	required	
										 	<?php endif ?>
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="background_slide">Buscar Archivo</label>

										 </div>

									</div>

									<!--=====================================
									Posición del Slide
									======================================-->

									<div class="form-group pb-3 text-left">
										
										<label for="direction_slide" class="pb-3 float-left">Posición del Slide</label>

										<select class="form-select changeDirectionSlide" name="direction_slide" id="direction_slide">

											<option value="" >No aplica</option>
											<option value="opt1" <?php if (!empty($slide) && $slide->direction_slide == "opt1"): ?> selected <?php endif ?>>Opción 1</option>
											<option value="opt2" <?php if (!empty($slide) && $slide->direction_slide == "opt2"): ?> selected <?php endif ?>>Opción 2</option>
									
										</select>

									</div>	

								</div>

							</div>

						</div>

					</div>

					<!--=====================================
					SEGUNDO BLOQUE
					======================================-->

					<div class="row pt-2 blockDirectionSlide" <?php if (!empty($slide)): ?> <?php if ($slide->direction_slide == null): ?> style="display:none" <?php endif ?> <?php else: ?> style="display:none" <?php endif ?> >
						
						<div class="col-12 col-md-4">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Imagen Flotante
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Imagen flotante</label>

										<label for="img_png_slide">
											
											
											<?php if (!empty($slide)): ?>

												<input type="hidden" value="<?php echo $slide->img_png_slide ?>" name="old_img_png_slide">

												<img src="/views/assets/img/slide/<?php echo $slide->id_slide ?>/<?php echo $slide->img_png_slide ?>" class="img-fluid changeImgPng">

											<?php else: ?>

												<img src="/views/assets/img/slide/default/default-img.png" class="img-fluid changeImgPng">
												
											<?php endif ?>
											

											<p class="help-block small mt-3">Dimensiones recomendadas: 500 x 500 pixeles | Peso Max. 2MB | Formato: PNG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="img_png_slide"
										 	name="img_png_slide"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeImgPng')"
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="img_png_slide">Buscar Archivo</label>

										 </div>

									</div>

									<!--=====================================
									Coordenadas Imagen
									======================================-->

									<div class="form-group">
									
										<label for="coord_img_slide">Coordenadas Imagen Flotante</label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar texto CSS"
										id="coord_img_slide"
										name="coord_img_slide"
										onchange="validateJS(event,'complete')"
										value="<?php if (!empty($slide)): ?><?php echo $slide->coord_img_slide ?><?php endif ?>"
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>
								
								</div>

							</div>	

						</div>

						<div class="col-12 col-md-8">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Texto 1
									======================================-->

									<div class="form-group pb-1">

										<label for="coord_img_slide">Bloque de textos</label>
									
										<div class="row">

											<div class="col">

												<div class="input-group">

													<label class="input-group-text">Texto 1</label>

													<input 
													type="text"
													class="form-control"
													placeholder="Ingresar texto 1"
													id="textSlide1"
													name="textSlide1"
													onchange="validateJS(event,'complete')"
													value="<?php if (!empty($slide) && $slide->text_slide != null): ?><?php echo json_decode($slide->text_slide)[0]->text ?><?php endif ?>"
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>
			
											</div>

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Color 1:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="colorSlide1"
													name="colorSlide1"
													value="<?php if (!empty($slide) && $slide->text_slide != null): ?><?php echo json_decode($slide->text_slide)[0]->color ?><?php endif ?>"
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

										</div>
	
									</div>

									<!--=====================================
									Texto 2
									======================================-->

									<div class="form-group pb-1">
									
										<div class="row">

											<div class="col">

												<div class="input-group">

													<label class="input-group-text">Texto 2</label>

													<input 
													type="text"
													class="form-control"
													placeholder="Ingresar texto 2"
													id="textSlide2"
													name="textSlide2"
													onchange="validateJS(event,'complete')"
													value="<?php if (!empty($slide) && $slide->text_slide != null): ?><?php echo json_decode($slide->text_slide)[1]->text ?><?php endif ?>"
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>
			
											</div>

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Color 2:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="colorSlide2"
													name="colorSlide2"
													value="<?php if (!empty($slide) && $slide->text_slide != null): ?><?php echo json_decode($slide->text_slide)[1]->color ?><?php endif ?>"
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

										</div>
	
									</div>

									<!--=====================================
									Texto 3
									======================================-->

									<div class="form-group pb-3">
									
										<div class="row">

											<div class="col">

												<div class="input-group">

													<label class="input-group-text">Texto 3</label>

													<input 
													type="text"
													class="form-control"
													placeholder="Ingresar texto 3"
													id="textSlide3"
													name="textSlide3"
													onchange="validateJS(event,'complete')"
													value="<?php if (!empty($slide) && $slide->text_slide != null): ?><?php echo json_decode($slide->text_slide)[2]->text ?><?php endif ?>"
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>
			
											</div>

											<div class="col">

												<div class="input-group">

			    									<span class="input-group-text">Color 3:</span>

													<input 
													type="color"
													class="form-control form-control-color border"
													id="colorSlide3"
													name="colorSlide3"
													value="<?php if (!empty($slide) && $slide->text_slide != null): ?><?php echo json_decode($slide->text_slide)[2]->color ?><?php endif ?>"
													>

													<div class="valid-feedback">Válido.</div>
													<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

												</div>

											</div>

										</div>
	
									</div>

									<!--=====================================
									Coordenadas texto
									======================================-->

									<div class="form-group">
									
										<label for="coord_text_slide">Coordenadas Texto</label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar texto CSS"
										id="coord_text_slide"
										name="coord_text_slide"
										onchange="validateJS(event,'complete')"
										value="<?php if (!empty($slide)): ?><?php echo $slide->coord_text_slide ?><?php endif ?>"
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Link Slide
									======================================-->

									<div class="form-group">
									
										<label for="link_slide">Enlace Slide</label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar enlace del Slide"
										id="link_slide"
										name="link_slide"
										onchange="validateJS(event,'complete')"
										value="<?php if (!empty($slide)): ?><?php echo $slide->link_slide ?><?php endif ?>"
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Texto Botón Slide
									======================================-->

									<div class="form-group">
									
										<label for="txt_btn_slide">Texto Botón Slide</label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar texto del botón"
										id="text_btn_slide"
										name="text_btn_slide"
										onchange="validateJS(event,'text')"
										value="<?php if (!empty($slide)): ?><?php echo $slide->text_btn_slide ?><?php endif ?>"
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

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
								
								<a href="/admin/slides" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/slides" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

			</form>

		</div>
	</div>	

</div>