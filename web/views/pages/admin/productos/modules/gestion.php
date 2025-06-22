<?php 

if(isset($_GET["product"])){

	$select = "id_product,name_product,url_product,image_product,description_product,keywords_product,id_category_product,id_subcategory_product,name_subcategory,info_product";
	$url = "relations?rel=products,subcategories&type=product,subcategory&linkTo=id_product&equalTo=".base64_decode($_GET["product"])."&select=".$select;
	$method = "GET";
	$fields = array();

	$product = CurlController::request($url, $method, $fields);
	
	if($product->status == 200){

		$product = $product->results[0];

	}else{

		$product = null;

	}

}else{

	$product = null;
	
	
}


 ?>


<div class="content pb-5">
	
	<div class="container">
		
		<div class="card">
			
			<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

				<?php if (!empty($product)): ?>

					<input type="hidden" name="idProduct" value="<?php echo base64_encode($product->id_product) ?>">
					
				<?php endif ?>

				<div class="card-header">
					
					<div class="container">
						
						<div class="row">
							
							<div class="col-12 col-lg-6 text-center text-lg-left">							
								
								<h4 class="mt-3">Agregar Producto</h4>
											
							</div>	

							<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill saveBtn">Guardar Información</button>
								
								<a href="/admin/productos" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/productos" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill saveBtn">Guardar Información</button></div>
		
							</div>	

						</div>
					</div>

				</div>

				<div class="card-body">

					<?php 

						require_once "controllers/products.controller.php";
						$manage = new ProductsController();
						$manage -> productManage();
					
					?>


					<!--=====================================
					PRIMER BLOQUE
					======================================-->

					<div class="row row-cols-1 row-cols-md-2"> 

						<div class="col">
							
							<div class="card">
								
								<div class="card-body">

									<!--=====================================
									Seleccionar la categoría
									======================================-->

									<div class="form-group pb-3">

										<?php if (!empty($product)): ?>

											<input type="hidden" name="old_id_category_product" value="<?php echo base64_encode($product->id_category_product) ?>">
											
										<?php endif ?>
										
										<label for="id_category_product">Seleccionar Categoría<sup class="text-danger">*</sup></label>

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
					                    name="id_category_product"
					                    id="id_category_product"
					                    onchange="changeCategory(event)"
					                    required>

					                    	<option value="">Selecciona Categoría</option>

					                    	<?php foreach ($categories as $key => $value): ?>

					                    		<option value="<?php echo $value->id_category ?>" <?php if (!empty($product) && $product->id_category_product == $value->id_category): ?> selected <?php endif ?>><?php echo $value->name_category ?></option>
					                    		
					                    	<?php endforeach ?>

					                	</select>

									</div>

									<!--=====================================
									Seleccionar la subcategoría
									======================================-->

									<div class="form-group pb-3">

										<?php if (!empty($product)): ?>

											<input type="hidden" name="old_id_subcategory_product" value="<?php echo base64_encode($product->id_subcategory_product) ?>">
											
										<?php endif ?>
										
										<label for="id_subcategory_product">Seleccionar Subcategoría<sup class="text-danger">*</sup></label>

										<select
					                    class="custom-select"
					                    name="id_subcategory_product"
					                    id="id_subcategory_product"
					                    required>

					                    <?php if (!empty($product)): ?>

					                    	<option value="<?php echo $product->id_subcategory_product ?>"><?php echo $product->name_subcategory ?></option>

					                    <?php else: ?>

					                    	<option value="">Selecciona primero una Categoría</option>
					                    	
					                    <?php endif ?>

					                	</select>

									</div>

									<!--=====================================
									Seleccionar el proveedor
									======================================-->

									<div class="form-group pb-3">
									    <label for="provider_id">Seleccionar Proveedor</label>
									    <?php 
									        $url = "providers?select=id,name";
									        $method = "GET";
									        $fields = array();
									        $providers = CurlController::request($url, $method, $fields);
									        if($providers && $providers->status == 200){
									            $providers = $providers->results;
									        }else{
									            $providers = array();
									        }
									    ?>
									    <select class="custom-select" name="provider_id" id="provider_id">
									        <option value="">Sin proveedor</option>
									        <?php foreach ($providers as $prov): ?>
									            <option value="<?php echo $prov->id ?>" <?php if (!empty($product) && isset($product->provider_id) && $product->provider_id == $prov->id): ?> selected <?php endif ?>><?php echo $prov->name ?></option>
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
									Título del Producto
									======================================-->
									
									<div class="form-group pb-3"> 

										<label for="name_product">Título <sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control"
										placeholder="Ingresar el título"
										id="name_product"
										name="name_product"
										onchange="validateDataRepeat(event,'product')"
										<?php if (!empty($product)): ?> readonly <?php endif ?>
										value="<?php if (!empty($product)): ?><?php echo $product->name_product ?><?php endif ?>"
										required
										>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									URL del producto
									======================================-->

									<div class="form-group pb-3"> 

										<label for="url_product">URL <sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control"
										id="url_product"
										name="url_product"
										value="<?php if (!empty($product)): ?><?php echo $product->url_product ?><?php endif ?>"
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
									Descripción del producto
									======================================-->
									
									<div class="form-group pb-3"> 

										<label for="description_product">Descripción<sup class="text-danger font-weight-bold">*</sup></label>

										<textarea 
										rows="9"
										class="form-control mb-3"
										placeholder="Ingresar la descripción"
										id="description_product"
										name="description_product"
										onchange="validateJS(event,'complete')"
										required
										><?php if (!empty($product)): ?><?php echo $product->description_product ?><?php endif ?></textarea>

										<div class="valid-feedback">Válido.</div>
										<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

									</div>

									<!--=====================================
									Palabras claves del producto
									======================================-->

									<div class="form-group pb-3"> 

										<label for="keywords_product">Palabras claves<sup class="text-danger font-weight-bold">*</sup></label>

										<input 
										type="text"
										class="form-control tags-input"
										data-role="tagsinput"
										placeholder="Ingresar las palabras claves"
										id="keywords_product"
										name="keywords_product"
										onchange="validateJS(event,'complete-tags')"
										value="<?php if (!empty($product)): ?><?php echo $product->keywords_product ?><?php endif ?>"
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
									Imagen del producto
									======================================-->

									<div class="form-group pb-3 text-center">
										
										<label class="pb-3 float-left">Imagen del Producto<sup class="text-danger">*</sup></label>

										<label for="image_product">
											
											
											<?php if (!empty($product)): ?>

												<input type="hidden" value="<?php echo $product->image_product ?>" name="old_image_product">

												<img src="/views/assets/img/products/<?php echo $product->url_product ?>/<?php echo $product->image_product ?>" class="img-fluid changeImage">

											<?php else: ?>

												<img src="/views/assets/img/products/default/default-image.jpg" class="img-fluid changeImage">
												
											<?php endif ?>
											

											<p class="help-block small mt-3">Dimensiones recomendadas: 1000 x 600 pixeles | Peso Max. 2MB | Formato: PNG o JPG</p>

										</label>

										 <div class="custom-file">
										 	
										 	<input 
										 	type="file"
										 	class="custom-file-input"
										 	id="image_product"
										 	name="image_product"
										 	accept="image/*"
										 	maxSize="2000000"
										 	onchange="validateImageJS(event,'changeImage')"
										 	<?php if (empty($product)): ?>
										 	required	
										 	<?php endif ?>
										 	>

										 	<div class="valid-feedback">Válido.</div>
	            							<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

					                        <label class="custom-file-label" for="image_product">Buscar Archivo</label>

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
								
								<div class="card-body">

									<div class="form-group mx-auto" style="max-width:700px">

										<!--=====================================
										Información del producto
										======================================-->
				            
							            <label for="info_product">Información del Producto<sup class="text-danger">*</sup></label>

							            <textarea
							            class="summernote"
							            name="info_product"
							            id="info_product"
							            required
							            >
							            <?php if (!empty($product)): ?>
							            	<?php echo $product->info_product ?>
							            <?php endif ?>
				
							            </textarea>

							            <div class="valid-feedback">Válido.</div>
			        				    <div class="invalid-feedback">Por favor llena este campo correctamente.</div>

							        </div>

								</div>

							</div>

						</div>


					</div>

					<!--=====================================
					CUARTO BLOQUE
					======================================-->

					<div class="row row-cols-1 pt-2 variantList">
						
						<div class="col">

							<div class="card">
									
								<div class="card-body">

									<?php if (!empty($product)):  ?>


										<?php 

										$url = "variants?linkTo=id_product_variant&equalTo=".$product->id_product;
										$method = "GET";
										$fields = array();

										$variants = CurlController::request($url, $method, $fields);

										if($variants->status == 200){

											$variants = $variants->results;

										}else{

											$variants = array();
											
										}

									 	?>

									<?php else: $variants = array(); ?>


										
									<?php endif ?>

									<?php if (count($variants) > 0): ?>

										<input type="hidden" name="totalVariants" value="<?php echo count($variants) ?>">

										<?php foreach ($variants as $key => $value): ?>

											<input type="hidden" class="idVariant" name="idVariant_<?php echo ($key+1)?>" value="<?php echo $value->id_variant ?>">
											
											<!--=====================================
											Variantes
											======================================-->

											<div class="card variantCount">

												<div class="card-body">

													<div class="form-group">
														
														<div class="d-flex justify-content-between">
															
															<label for="info_product">Variante <?php echo ($key+1) ?><sup class="text-danger">*</sup></label>

															<?php if (($key+1) == 1): ?>

																<div>
																	<button type="button" class="btn btn-default btn-sm rounded-pill px-3 addVariant"><i class="fas fa-plus fa-xs"></i> Agregar otra variante</button>
																</div>

															<?php else: ?>

																<div>
																	<button type="button" class="btn btn-default btn-sm rounded-pill px-3 deleteVariant" idVariant="<?php echo base64_encode($value->id_variant) ?>"><i class="fas fa-times fa-xs"></i> Quitar esta variante</button>
																</div>

																
															<?php endif ?>

															

														</div>

													</div>

													<div class="row row-cols-1 row-cols-md-2">
														
														<div class="col">
															
															<!--=====================================
															Tipo de variante
															======================================-->

															<div class="form-group">
																
																<select 
																class="custom-select" 
																name="type_variant_<?php echo ($key+1) ?>"
																onchange="changeVariant(event, <?php echo ($key+1) ?>)"
																> 

																	<option <?php if ($value->type_variant == "gallery"): ?> selected <?php endif ?> value="gallery">Galería de fotos</option>
																	<option <?php if ($value->type_variant == "video"): ?> selected <?php endif ?>  value="video">Video</option>

																</select>

															</div>

															<?php if ($value->type_variant == "gallery"): ?>

																<!--=====================================
														        Galería del Producto
														        ======================================-->    

														        <div class="dropzone dropzone_<?php echo ($key+1) ?> mb-3">
														        	
														        	<!--=====================================
														        	Plugin Dropzone
														        	======================================--> 

														        	<?php foreach (json_decode($value->media_variant,true)  as $index => $item): ?>
													
															        	<div class="dz-preview dz-file-preview">
															        		
															        		<div class="dz-image">
															        			
															        				<img class="img-fluid" src="<?php echo "/views/assets/img/products/".$product->url_product."/".$item ?>">

															        		</div>

															        		<a class="dz-remove" data-dz-remove remove="<?php echo $item ?>" onclick="removeGallery(this, <?php echo ($key+1) ?>)">Remove file</a>

															        	</div>  

														        	<?php endforeach ?>

														        	<div class="dz-message">
														        		
														        		Arrastra tus imágenes acá, tamaño máximo 400px * 450px
														        	
														        	</div> 

														        </div>

														        <input type="hidden" name="galleryProduct_<?php echo ($key+1) ?>" class="galleryProduct_<?php echo ($key+1) ?>"> 

														        <input type="hidden" name="galleryOldProduct_<?php echo ($key+1) ?>" class="galleryOldProduct_<?php echo ($key+1) ?>" value='<?php echo $value->media_variant ?>'>

														        <input type="hidden" name="deleteGalleryProduct_<?php echo ($key+1) ?>" class="deleteGalleryProduct_<?php echo ($key+1) ?>" value='[]'>

														        <!--=====================================
														        Insertar video Youtube
														        ======================================--> 

														        <div class="input-group mb-3 inputVideo_<?php echo ($key+1) ?>" style="display:none">
														        	
														        	<span class="input-group-text">
														        	 	<i class="fas fa-clipboard-list"></i>
														        	 </span>  

														        	<input 
																	type="text" 
																	class="form-control" 
																	name="videoProduct_<?php echo ($key+1) ?>"
																	placeholder="Ingresa la URL de YouTube"
																	onchange="changeVideo(event, <?php echo ($key+1) ?>)"
																	>

														        </div>

														        <iframe width="100%" height="280" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="mb-3 iframeYoutube_<?php echo ($key+1) ?>" style="display:none"></iframe>


														    <?php else: ?>

														    	<!--=====================================
														        Insertar video Youtube
														        ======================================--> 

														        <div class="input-group mb-3 inputVideo_<?php echo ($key+1) ?>">
														        	
														        	<span class="input-group-text">
														        	 	<i class="fas fa-clipboard-list"></i>
														        	 </span>  

														        	<input 
																	type="text" 
																	class="form-control" 
																	name="videoProduct_<?php echo ($key+1) ?>"
																	placeholder="Ingresa la URL de YouTube"
																	value="<?php echo $value->media_variant ?>"
																	onchange="changeVideo(event, <?php echo ($key+1) ?>)"
																	>

														        </div>

														        <?php 

														         $idYoutube = explode("/",$value->media_variant);
														         $idYoutube = end($idYoutube);

														        
														        ?>

														        <iframe width="100%" height="280" src="https://www.youtube.com/embed/<?php echo $idYoutube ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="mb-3 iframeYoutube_<?php echo ($key+1) ?>" ></iframe>

														        <!--=====================================
														        Galería del Producto
														        ======================================-->    

														        <div class="dropzone dropzone_<?php echo ($key+1) ?> mb-3" style="display:none">
														        	
														        	<!--=====================================
														        	Plugin Dropzone
														        	======================================--> 
														    
														        	<div class="dz-message">
														        		
														        		Arrastra tus imágenes acá, tamaño máximo 400px * 450px
														        	
														        	</div> 

														        </div>

														        <input type="hidden" name="galleryProduct_<?php echo ($key+1) ?>" class="galleryProduct_<?php echo ($key+1) ?>" style="display:none"> 

														    <?php endif ?>							        

														</div>	

														<div class="col">

															<!--=====================================
															Descripción de la variante
															======================================-->

															<div class="input-group mb-3">

															    <span class="input-group-text">
															    	<i class="fas fa-clipboard-list"></i>
															    </span>
															    
																<input 
																type="text" 
																class="form-control" 
																name="description_variant_<?php echo ($key+1) ?>" 
																placeholder="Descripción: Color Negro, talla S, Material Goma"
																value="<?php echo $value->description_variant ?>">

															</div>

															<!--=====================================
															Costo de la variante
															======================================-->

															<div class="input-group mb-3">

															    <span class="input-group-text">
															    	<i class="fas fa-hand-holding-usd"></i>
															    </span>
															  
																<input type="number" 
																step="any" 
																class="form-control" 
																name="cost_variant_<?php echo ($key+1) ?>" 
																placeholder="Costo de compra"
																value="<?php echo $value->cost_variant ?>"
																>

															</div>

															<!--=====================================
															Precio de la variante
															======================================-->

															<div class="input-group mb-3">
					
															    <span class="input-group-text">
															    	<i class="fas fa-funnel-dollar"></i>
															    </span>

																<input type="number"
																 step="any" 
																 class="form-control" 
																 name="price_variant_<?php echo ($key+1) ?>" 
																 placeholder="Precio de venta"
																 value="<?php echo $value->price_variant ?>" 
																 >

															</div>

															<!--=====================================
															Oferta de la variante
															======================================-->

															<div class="input-group mb-3">

															    <span class="input-group-text">
															    	<i class="fas fa-tag"></i>
															    </span> 

																<input 
																type="number"
																step="any" 
																class="form-control" 
																name="offer_variant_<?php echo ($key+1) ?>" 
																placeholder="Precio de descuento"
																value="<?php echo $value->offer_variant ?>" 
																>

															</div>

															<!--=====================================
															Fin de Oferta de la variante
															======================================-->

															<div class="input-group mb-3">

															    <span class="input-group-text">Fin del descuento</span>
															    
																<input 
																type="date" 
																class="form-control"
																name="date_variant_<?php echo ($key+1) ?>"
																value="<?php echo $value->end_offer_variant ?>"
																 >

															</div>


															<!--=====================================
															Stock de la variante
															======================================-->

															<div class="input-group mb-3">

															    <span class="input-group-text">
															    	<i class="fas fa-list"></i>
															    </span>
						
																<input 
																type="number" 
																class="form-control"
																name="stock_variant_<?php echo ($key+1) ?>" 
																placeholder="Stock disponible"
																value="<?php echo $value->stock_variant ?>"
																>

															</div>
															


														</div>


													</div>

												</div>

											</div>

										<?php endforeach ?>

									<?php else: ?>
										
										<input type="hidden" name="totalVariants" value="1">

										<!--=====================================
										Variantes
										======================================-->

										<div class="form-group">
											
											<div class="d-flex justify-content-between">
												
												<label for="info_product">Variante 1<sup class="text-danger">*</sup></label>

												<div>
													<button type="button" class="btn btn-default btn-sm rounded-pill px-3 addVariant">
														<i class="fas fa-plus fa-xs"></i> Agregar otra variante
													</button>
												</div>

											</div>

										</div>

										<div class="row row-cols-1 row-cols-md-2">
											
											<div class="col">
												
												<!--=====================================
												Tipo de variante
												======================================-->

												<div class="form-group">
													
													<select 
													class="custom-select" 
													name="type_variant_1"
													onchange="changeVariant(event, 1)"
													> 

														<option value="gallery">Galería de fotos</option>
														<option value="video">Video</option>

													</select>

												</div>

												<!--=====================================
										        Galería del Producto
										        ======================================-->    

										        <div class="dropzone dropzone_1 mb-3">
										        	
										        	<!--=====================================
										        	Plugin Dropzone
										        	======================================--> 
										    
										        	<div class="dz-message">
										        		
										        		Arrastra tus imágenes acá, tamaño máximo 400px * 450px
										        	
										        	</div> 

										        </div>

										        <input type="hidden" name="galleryProduct_1" class="galleryProduct_1"> 

										        <!--=====================================
										        Insertar video Youtube
										        ======================================--> 

										        <div class="input-group mb-3 inputVideo_1" style="display:none">
										        	
										        	<span class="input-group-text">
										        	 	<i class="fas fa-clipboard-list"></i>
										        	 </span>  

										        	<input 
													type="text" 
													class="form-control" 
													name="videoProduct_1"
													placeholder="Ingresa la URL de YouTube"
													onchange="changeVideo(event, 1)"
													>

										        </div>

										        <iframe width="100%" height="280" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="mb-3 iframeYoutube_1" style="display:none"></iframe>

											</div>	

											<div class="col">

												<!--=====================================
												Descripción de la variante
												======================================-->

												<div class="input-group mb-3">

												    <span class="input-group-text">
												    	<i class="fas fa-clipboard-list"></i>
												    </span>
												    
													<input type="text" class="form-control" name="description_variant_1" placeholder="Descripción: Color Negro, talla S, Material Goma">

												</div>

												<!--=====================================
												Costo de la variante
												======================================-->

												<div class="input-group mb-3">

												    <span class="input-group-text">
												    	<i class="fas fa-hand-holding-usd"></i>
												    </span>
												  
													<input type="number" step="any" class="form-control" name="cost_variant_1" placeholder="Costo de compra">

												</div>

												<!--=====================================
												Precio de la variante
												======================================-->

												<div class="input-group mb-3">
		
												    <span class="input-group-text">
												    	<i class="fas fa-funnel-dollar"></i>
												    </span>

													<input type="number" step="any" class="form-control" name="price_variant_1" placeholder="Precio de venta">

												</div>

												<!--=====================================
												Oferta de la variante
												======================================-->

												<div class="input-group mb-3">

												    <span class="input-group-text">
												    	<i class="fas fa-tag"></i>
												    </span> 

													<input type="number" step="any" class="form-control" name="offer_variant_1" placeholder="Precio de descuento">

												</div>

												<!--=====================================
												Fin de Oferta de la variante
												======================================-->

												<div class="input-group mb-3">

												    <span class="input-group-text">Fin del descuento</span>
												    
													<input type="date" class="form-control" name="date_variant_1">

												</div>


												<!--=====================================
												Stock de la variante
												======================================-->

												<div class="input-group mb-3">

												    <span class="input-group-text">
												    	<i class="fas fa-list"></i>
												    </span>
			
													<input type="number" class="form-control" name="stock_variant_1" placeholder="Stock disponible">

												</div>
												


											</div>


										</div>

									<?php endif ?>


								</div>

							</div>
							

						</div>


					</div>

					<!--=====================================
					QUINTO BLOQUE
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

														<?php if (!empty($product)): ?>

															<img src="/views/assets/img/products/<?php echo $product->url_product ?>/<?php echo $product->image_product ?>" class="img-fluid metaImg" style="width:100%">

														<?php else: ?>

															<img src="/views/assets/img/products/default/default-image.jpg" class="img-fluid metaImg" style="width:100%">

														<?php endif ?>
														
													</figure>

													<!--=====================================
													Visor título
													======================================-->

													<h6 class="text-left text-primary mb-1 metaTitle">

														<?php if (!empty($product)): ?>
													    	<?php echo $product->name_product ?>
													    <?php else: ?>
													    	Lorem ipsum dolor sit
													    <?php endif ?>

													</h6>

													<!--=====================================
													Visor URL
													======================================-->

													<p class="text-left text-success small mb-1">
														<?php echo $path ?><span class="metaURL"><?php if (!empty($product)): ?><?php echo $product->url_product ?><?php else: ?>lorem<?php endif ?></span>
													</p>

													<!--=====================================
													Visor Descripción
													======================================-->

													<p class="text-left small mb-1 metaDescription">

														<?php if (!empty($product)): ?>
													    	<?php echo $product->description_product ?>
													    <?php else: ?>
															Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus impedit ipsam obcaecati voluptas unde error quod odit ad sapiente vitae.
														<?php endif ?> 
													</p>

													<!--=====================================
													Visor Palabras claves
													======================================-->

													<p class="small text-left text-secondary metaTags">
														<?php if (!empty($product)): ?>
															<?php echo $product->keywords_product ?>
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
								
								<button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill saveBtn">Guardar Información</button>
								
								<a href="/admin/categorias" class="btn btn-default float-right py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a>

							</div>	

							<div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
								
								<div><a href="/admin/categorias" class="btn btn-default py-2 px-3 btn-sm rounded-pill mr-2">Regresar</a></div>

								<div><button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill saveBtn">Guardar Información</button></div>
		
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

