<?php 

if(isset($_GET["banner"])){

	$select = "*";
	$url = "banners?linkTo=id_banner&equalTo=".base64_decode($_GET["banner"])."&select=".$select;
	$method = "GET";
	$fields = array();

	$banner = CurlController::request($url, $method, $fields);
	
	if($banner->status == 200){

		$banner = $banner->results[0];

	}else{

		$banner = null;

	}

}else{

	$banner = null;
	
}

?>

<div class="content pb-5">
	
	<div class="container">

		<div class="card">
			
			<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

				<?php if (!empty($banner)): ?>

					<input type="hidden" name="idBanner" value="<?php echo base64_encode($banner->id_banner) ?>">
		
				<?php endif ?>

				<div class="card-header">
					
					<div class="container">
						
						<div class="row">
							
							<div class="col-12 col-lg-6 text-center text-lg-left">

								<?php if (!empty($banner)): ?>
									<h4 class="mt-3">Editar Banner</h4>
								<?php else: ?>
									<h4 class="mt-3">Agregar Banner</h4>
								<?php endif ?>
													
							</div>	

							<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill">Guardar Información</button>
								
								<a href="/admin/banners" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/banners" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

				<div class="card-body">

					<input type="hidden" name="banner" value="banner">

					<?php 

						require_once "controllers/banners.controller.php";
						$manage = new BannersController();
						$manage -> bannersManage();
					
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

										<label for="background_banner">
	
											<?php if (!empty($banner)): ?>

												<input type="hidden" value="<?php echo $banner->background_banner ?>" name="old_background_banner">

												<img src="/views/assets/img/banner/<?php echo $banner->id_banner ?>/<?php echo $banner->background_banner ?>" class="img-fluid changeBackground">

											<?php else: ?>

												<img src="/views/assets/img/banner/default/default-banner.jpg" class="img-fluid changeBackground">
												
											<?php endif ?>
											

											<p class="help-block small mt-3">Dimensiones recomendadas: 1600 x 550 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="background_banner"
										 	name="background_banner"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeBackground')"
										 	<?php if (empty($banner)): ?>
										 	required	
										 	<?php endif ?>
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="background_banner">Buscar Archivo</label>

										 </div>

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
									Seleccionar la ubicación
									======================================-->

									<div class="form-group pb-3">

										<label for="location_banner">Seleccionar Ubicación<sup class="text-danger">*</sup></label>
										
										<select 
										class="custom-select"
										name="location_banner" 
										id="location_banner"
										onchange="changeLocation(event)"
										required>

											<option value="HOME" <?php if (!empty($banner) && $banner->location_banner == "HOME" ): ?> selected <?php endif ?>>HOME</option>
											<option value="CATEGORÍA" <?php if (!empty($banner) && $banner->location_banner == "CATEGORÍA" ): ?> selected <?php endif ?>>CATEGORÍA</option>
											<option value="SUBCATEGORÍA" <?php if (!empty($banner) && $banner->location_banner == "SUBCATEGORÍA" ): ?> selected <?php endif ?>>SUBCATEGORÍA</option>
											
										</select>

									</div>

									<!--=====================================
									Seleccionar la categoría
									======================================-->

									<div class="form-group pb-3 locationCategory" <?php if (!empty($banner) && $banner->location_banner == "CATEGORÍA"): ?> style="display:block"  <?php else: ?> style="display:none" <?php endif ?>>
										
										<label for="id_category_bannert">Seleccionar Categoría<sup class="text-danger">*</sup></label>

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
					                    name="id_category_banner"
					                    id="id_category_banner"
					                    >

					                    	<option value="">Selecciona Categoría</option>

					                    	<?php foreach ($categories as $key => $value): ?>

					                    		<option value="<?php echo $value->id_category ?>" <?php if (!empty($banner) && $banner->id_category_banner == $value->id_category): ?> selected <?php endif ?>><?php echo $value->name_category ?></option>
					                    		
					                    	<?php endforeach ?>

					                	</select>

									</div>

									<!--=====================================
									Seleccionar la subcategoría
									======================================-->

									<div class="form-group pb-3 locationSubcategory" <?php if (!empty($banner) && $banner->location_banner == "SUBCATEGORÍA" ): ?> style="display:block" <?php else: ?> style="display:none"  <?php endif ?>>

										<label for="id_subcategory_banner">Seleccionar Subcategoría<sup class="text-danger">*</sup></label>

										<?php 

										 	$url = "subcategories?select=id_subcategory,name_subcategory";
											$method = "GET";
						                	$fields = array();

						                	$subcategories = CurlController::request($url, $method, $fields);

						                	if($subcategories->status == 200){

						                		$subcategories = $subcategories->results;
						                	
						                	}else{

						                		$subcategories = array();
						                	}

										?>

										<select
					                    class="custom-select"
					                    name="id_subcategory_banner"
					                    id="id_subcategory_banner"
					                    >

					                    	<option value="">Selecciona Subcategoría</option>

					                    	<?php foreach ($subcategories as $key => $value): ?>

					                    		<option value="<?php echo $value->id_subcategory ?>" <?php if (!empty($banner) && $banner->id_subcategory_banner == $value->id_subcategory): ?> selected <?php endif ?>><?php echo $value->name_subcategory ?></option>
					                    		
					                    	<?php endforeach ?>

					                	</select>

									</div>

								</div>

							</div>

						</div>

						<div class="col">

							<div class="card">
								
								<div class="card-body">
							
									<!--=====================================
									Texto del Banner
									======================================-->

									<div class="form-group">
									
										<label for="text_banner">Texto del Banner</label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar texto Banner"
										id="text_banner"
										name="text_banner"
										onchange="validateJS(event,'complete')"
										value="<?php if (!empty($banner)): ?><?php echo $banner->text_banner ?><?php endif ?>"
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Descuento del Banner
									======================================-->

									<div class="form-group">
									
										<label for="text_banner">Descuento del Banner</label>

										<input 
										type="number"
										class="form-control"
										placeholder="0"
										id="discount_banner"
										name="discount_banner"
										onchange="validateJS(event,'number')"
										value="<?php if (!empty($banner)): ?><?php echo $banner->discount_banner ?><?php endif ?>"
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Fecha final Oferta
									======================================-->

									<div class="form-group">
									
										<label for="text_banner">Fecha final del descuento</label>

										<input 
										type="date" 
										class="form-control"
										name="end_banner"
										value="<?php if (!empty($banner)): ?><?php echo $banner->end_banner ?><?php endif ?>"
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
								
								<a href="/admin/banners" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/banners" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

			</form>

		</div>
	</div>	

</div>
