<?php

 /*=============================================
Config de la paginación
 =============================================*/

$endAt = 12;

if (isset($routesArray[1]) && !empty($routesArray[1])) {
	
	$startAt = ($routesArray[1]-1)*$endAt;	
	$currentPage = $routesArray[1];	

}else{

	$startAt = 0;
	$currentPage = 1;
}

/*=============================================
Traemos productos relacionados con categorias
=============================================*/

$url = "relations?rel=products,categories&type=product,category&linkTo=url_category&equalTo=".$routesArray[0]."&select=id_product";
$totalProducts = CurlController::request($url,$method,$fields);

if($totalProducts->status == 200){

	$totalProducts = $totalProducts->total;

	if($startAt > $totalProducts){

		echo '<script>
	      window.location = "/404";
	    </script>';
	}

	$select = "id_product,name_product,url_product,description_product,date_created_product,id_category_product";
	$url = "relations?rel=products,categories&type=product,category&linkTo=url_category&equalTo=".$routesArray[0]."&select=".$select."&startAt=".$startAt."&endAt=".$endAt."&orderBy=id_product&orderMode=DESC";
	$method = "GET";
	$fields = array();

	$products = CurlController::request($url,$method,$fields)->results;
	$locationBanner = "CATEGORÍA";

}else{

	/*=============================================
	Traemos productos relacionados con subcategorias
	=============================================*/

	$url = "relations?rel=products,subcategories&type=product,subcategory&linkTo=url_subcategory&equalTo=".$routesArray[0]."&select=id_product";
	$totalProducts = CurlController::request($url,$method,$fields);

	if($totalProducts->status == 200){

		$totalProducts = $totalProducts->total;

		if($startAt > $totalProducts){

			echo '<script>
		      window.location = "/404";
		    </script>';
		}

		$select = "id_product,name_product,url_product,description_product,date_created_product,id_subcategory_product";
		$url = "relations?rel=products,subcategories&type=product,subcategory&linkTo=url_subcategory&equalTo=".$routesArray[0]."&select=".$select."&startAt=".$startAt."&endAt=".$endAt."&orderBy=id_product&orderMode=DESC";
		$method = "GET";
		$fields = array();

		$products = CurlController::request($url,$method,$fields)->results;
		$locationBanner = "SUBCATEGORÍA";


	}else{

		/*=============================================
		Traemos productos gratuitos
		=============================================*/

		if($routesArray[0] == "free"){

			$url = "relations?rel=variants,products&type=variant,product&linkTo=price_variant&equalTo=0&select=id_product";
			$totalProducts = CurlController::request($url,$method,$fields);

			if($totalProducts->status == 200){

				$totalProducts = $totalProducts->total;

				if($startAt > $totalProducts){

					echo '<script>
				      window.location = "/404";
				    </script>';
				}

				$select = "id_product,name_product,url_product,type_variant,media_variant,date_created_product,stock_variant,description_product,offer_variant,price_variant";
				$url = "relations?rel=variants,products&type=variant,product&linkTo=price_variant&equalTo=0&startAt=".$startAt."&endAt=".$endAt."&orderBy=id_variant&orderMode=DESC&select=".$select;
				$method = "GET";
				$fields = array();

				$products = CurlController::request($url,$method,$fields)->results;
				$products[0]->check_variant = "yes";

			}else{

				/*=============================================
				Anulamos ingreso al catálogo
				=============================================*/

				echo '<script>
			      window.location = "/no-found";
			    </script>';



			}

		/*=============================================
		Filtrando productos más vistos
		=============================================*/

		}else if($routesArray[0] == "most-seen"){

			$url = "relations?rel=variants,products&type=variant,product&linkTo=views_product&between1=1&between2=1000&select=id_product";
			$totalProducts = CurlController::request($url,$method,$fields);

			if($totalProducts->status == 200){

				$totalProducts = $totalProducts->total;

				if($startAt > $totalProducts){

					echo '<script>
				      window.location = "/404";
				    </script>';
				}

				$select = "id_product,name_product,url_product,type_variant,media_variant,date_created_product,stock_variant,description_product,offer_variant,price_variant";
				$url = "relations?rel=variants,products&type=variant,product&linkTo=views_product&between1=1&between2=1000&startAt=".$startAt."&endAt=".$endAt."&orderBy=id_variant&orderMode=DESC&select=".$select;
				$method = "GET";
				$fields = array();

				$products = CurlController::request($url,$method,$fields)->results;
				$products[0]->check_variant = "yes";

			}else{

				echo '<script>
			      window.location = "/no-found";
			    </script>';
			}

		/*=============================================
		Filtrando productos más vendidos
		=============================================*/


		}else if($routesArray[0] == "most-sold"){

			$url = "relations?rel=variants,products&type=variant,product&linkTo=sales_product&between1=1&between2=1000&select=id_product";
			$totalProducts = CurlController::request($url,$method,$fields);

			if($totalProducts->status == 200){

				$totalProducts = $totalProducts->total;

				if($startAt > $totalProducts){

					echo '<script>
				      window.location = "/404";
				    </script>';
				}

				$select = "id_product,name_product,url_product,type_variant,media_variant,date_created_product,stock_variant,description_product,offer_variant,price_variant";
				$url = "relations?rel=variants,products&type=variant,product&linkTo=sales_product&between1=1&between2=1000&startAt=".$startAt."&endAt=".$endAt."&orderBy=id_variant&orderMode=DESC&select=".$select;
				$method = "GET";
				$fields = array();

				$products = CurlController::request($url,$method,$fields)->results;
				$products[0]->check_variant = "yes";

			}else{

				/*=============================================
				Anulamos ingreso al catálogo
				=============================================*/

				echo '<script>
			      window.location = "/no-found";
			    </script>';


			}
		

		}else{

			/*=============================================
      Filtro de búsqueda
      =============================================*/
      
      $linkTo = ["name_product","keywords_product","name_category","keywords_category","name_subcategory","keywords_subcategory"];
      $totalSearch = 0;

      foreach ($linkTo as $key => $value) {

      	$totalSearch++;

      	$url = "relations?rel=products,subcategories,categories&type=product,subcategory,category&linkTo=".$value."&search=".$routesArray[0]."&select=id_product";
      	$totalProducts = CurlController::request($url,$method,$fields);

      	if($totalProducts->status == 200){

      		$totalProducts = $totalProducts->total;

      		if($startAt > $totalProducts){

      			echo '<script>
      			window.location = "/404";
      			</script>';
      		}


      		$select = "id_product,name_product,url_product,description_product,date_created_product";
      		$url = "relations?rel=products,subcategories,categories&type=product,subcategory,category&linkTo=".$value."&search=".$routesArray[0]."&select=".$select."&startAt=".$startAt."&endAt=".$endAt."&orderBy=id_product&orderMode=DESC";
      		$products = CurlController::request($url,$method,$fields)->results;

      		break;

      	}

      }

      if($totalSearch == count($linkTo)){

				/*=============================================
				Anulamos ingreso al catálogo
				=============================================*/

				echo '<script>
				window.location = "/no-found";
				</script>';

			}

		}
	
	}
 
}

/*=============================================
Traemos la primera variante de los productos y si existen favoritos para ese producto
=============================================*/

if(!empty($products)){

	foreach ($products as $key => $value) {

		/*=============================================
		Traemos la primera variante
		=============================================*/

		if(!isset($products[0]->check_variant)){
		
			$select = "type_variant,media_variant,price_variant,offer_variant,end_offer_variant,stock_variant";
			$url = "variants?linkTo=id_product_variant&equalTo=".$value->id_product."&select=".$select;
			$variant = CurlController::request($url,$method,$fields)->results[0];
			
			$products[$key]->type_variant = $variant->type_variant;
			$products[$key]->media_variant = $variant->media_variant;
			$products[$key]->price_variant = $variant->price_variant;
			$products[$key]->offer_variant = $variant->offer_variant;
			$products[$key]->end_offer_variant = $variant->end_offer_variant;
			$products[$key]->stock_variant = $variant->stock_variant;

		}

		/*=============================================
		Traemos la primera variante
		=============================================*/

		if(isset($_SESSION["user"])){

			$select = "id_favorite";
			$url = "favorites?linkTo=id_product_favorite,id_user_favorite&equalTo=".$value->id_product.",".$_SESSION["user"]->id_user."&select=".$select;
			$favorite = CurlController::request($url,$method,$fields);

			if($favorite->status == 200){

				$products[$key]->id_favorite = $favorite->results[0]->id_favorite;

			}else{

				$products[$key]->id_favorite = 0;
			
			}

		}else{

			$products[$key]->id_favorite = 0;

		}
		
	}

}

include "modules/banner.php";

?>



<div class="container-fluid bg-light border">
	
	<div class="container clearfix">
		
		<div class="btn-group float-end <?php if (!empty($products)): ?> p-2 <?php else: ?> p-4 <?php endif ?>">

			<?php if (!empty($products)): ?>
			
				<button class="btn btn-default btnView bg-white" attr-type="grid" attr-index="2">
					
					<i class="fas fa-th fa-xs pe-1"></i>

					<span class="col-xs-0 float-end small mt-1">GRID</span>

				</button>

				<button class="btn btn-default btnView" attr-type="list" attr-index="2">
					
					<i class="fas fa-list fa-xs pe-1"></i>

					<span class="col-xs-0 float-end small mt-1">LIST</span>

				</button>

			<?php endif ?>

		</div>

	</div>

</div>


<div class="container-fluid bg-white">
	
	<div class="container">

		<!--=====================================
		Grid Preload
		======================================-->

		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 pt-3 pb-4 preloadTrue">
			
			<?php for($i = 0; $i < count($products); $i++): ?>

				<div class="col px-3 py-3">

					<div class="p-5 bg-preload" style="height: 285px;">
							<div class="into-preload"></div>
					</div>

					<div class="p-3 bg-preload my-3">
          	<div class="into-preload"></div>
        	</div>

        	<div class="d-flex justify-content-between">
        		
        		<div class="p-3 px-5 bg-preload">
            	<div class="into-preload"></div>
          	</div>

          	<div class="p-3 px-5 bg-preload">
            	<div class="into-preload"></div>
          	</div>

        	</div>

				</div>
				
			<?php endfor ?>

		</div>

		<!-- GRID -->

		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 pt-3 pb-4 grid-2 preloadFalse">

			<?php foreach ($products as $key => $value): ?>

				<div class="col px-3 py-3">
				
					<a href="/<?php echo $value->url_product ?>">
						
						<figure class="imgProduct">
							
							<?php if ($value->type_variant == "gallery"): ?>

								<img src="<?php echo $path ?>views/assets/img/products/<?php echo $value->url_product ?>/<?php echo json_decode($value->media_variant)[0] ?>" class="img-fluid">

							<?php else: $arrayYT = explode("/", $value->media_variant) ?>

								<img src="http://img.youtube.com/vi/<?php echo end($arrayYT) ?>/maxresdefault.jpg" class="img-fluid bg-light">
								
							<?php endif ?>

						</figure>

						<h5><small class="text-uppercase text-muted"><?php echo $value->name_product ?></small></h5>

					</a>

					<p class="small">

						<?php 

						$date1 = new DateTime($value->date_created_product);
						$date2 = new DateTime(date("Y-m-d"));
						$diff = $date1->diff($date2);

						?>

						<?php if ($diff->days < 30): ?>
					 		<span class="badge badgeNew bg-warning text-uppercase text-white mt-1 p-2 badge-pill">Nuevo</span>
						<?php endif ?>

						<?php if ($value->offer_variant > 0): ?>
							<span class="badge bg-danger text-uppercase text-white mt-1 p-2 badge-pill">¡En oferta!</span>		
						<?php endif ?>

						<?php if ($value->stock_variant == 0 && $value->type_variant == "gallery"): ?>
							<span class="badge bg-dark text-uppercase text-white mt-1 p-2 badge-pill">No tiene stock</span>
						<?php endif ?>
						
					</p>

					<div class="clearfix">

						<?php if ($value->price_variant == 0): ?>
							
							<h5 class="float-start text-uppercase text-muted"><small>Gratis</small></h5>

						<?php else: ?>
						
						
							<h5 class="float-start text-uppercase text-muted">
								
								<?php if ($value->offer_variant > 0): ?>
									<del class="small" style="color:#bbb">USD $<?php echo $value->price_variant ?></del> $<?php echo $value->offer_variant ?>
								<?php else: ?>
									$<?php echo $value->price_variant ?>
								<?php endif ?>

							</h5>

						<?php endif ?>

						<span class="float-end">
							
							<div class="btn-group btn-group-sm">

								<!--============================================
								FAVORITOS
								============================================-->
								
								<button 
								type="button" 
								class="btn btn-light border 
								<?php if (isset($_SESSION["user"]) && $value->id_favorite == 0): ?> addFavorite <?php endif ?>
								<?php if (isset($_SESSION["user"]) && $value->id_favorite > 0): ?> remFavorite <?php endif ?>"
								<?php if (!isset($_SESSION["user"])): ?> data-bs-toggle="modal" data-bs-target="#login" <?php endif ?>
								idProduct="<?php echo $value->id_product ?>"
								idFavorite="<?php echo $value->id_favorite ?>"
								pageFavorite="no"
								>
									<?php if ($value->id_favorite > 0): ?>
										<i class="fas fa-heart" style="color:#dc3545"></i>
									<?php else: ?>
										<i class="fas fa-heart"></i>	
									<?php endif ?>
									
								</button>


								<button type="button" class="btn btn-light border" onclick="location.href='/<?php echo $value->url_product ?>'">
									<i class="fas fa-eye"></i>
								</button>

							</div>
						</span>
					</div>

				</div>
				
			<?php endforeach ?>
			
		</div>

		<!-- LIST -->

		<div class="row list-2" style="display:none">

			<?php foreach ($products as $key => $value): ?>
			
				<div class="media border-bottom px-3 pt-4 pb-3 pb-lg-2">
		
					<a href="/<?php echo $value->url_product ?>">
	
						<figure class="imgProduct">

							<?php if ($value->type_variant == "gallery"): ?>

									<img src="<?php echo $path ?>views/assets/img/products/<?php echo $value->url_product ?>/<?php echo json_decode($value->media_variant)[0] ?>" class="img-fluid" style="width:150px">

								<?php else: $arrayYT = explode("/", $value->media_variant) ?>

									<img src="http://img.youtube.com/vi/<?php echo end($arrayYT) ?>/maxresdefault.jpg" class="img-fluid bg-light" style="width:150px">
									
								<?php endif ?>

						</figure>

					</a>

					<div class="media-body ps-3">
						
						<a href="/<?php echo $value->url_product ?>">
							<h5><small class="text-uppercase text-muted"><?php echo $value->name_product ?></small></h5>
						</a>

						<p class="small">

							<?php 

							$date1 = new DateTime($value->date_created_product);
							$date2 = new DateTime(date("Y-m-d"));
							$diff = $date1->diff($date2);

							?>

							<?php if ($diff->days < 30): ?>
						 		<span class="badge badgeNew bg-warning text-uppercase text-white mt-1 p-2 badge-pill">Nuevo</span>
							<?php endif ?>

							<?php if ($value->offer_variant > 0): ?>
								<span class="badge bg-danger text-uppercase text-white mt-1 p-2 badge-pill">¡En oferta!</span>		
							<?php endif ?>

							<?php if ($value->stock_variant == 0 && $value->type_variant == "gallery"): ?>
								<span class="badge bg-dark text-uppercase text-white mt-1 p-2 badge-pill">No tiene stock</span>
							<?php endif ?>
							
						</p>

						<p class="my-2"><?php echo $value->description_product ?></p>

						<div class="clearfix">
							
							<h5 class="float-start text-uppercase text-muted">
								<?php if ($value->offer_variant > 0): ?>
								<del class="small" style="color:#bbb">USD $<?php echo $value->price_variant ?></del> $<?php echo $value->offer_variant ?>
							<?php else: ?>
								$<?php echo $value->price_variant ?>
							<?php endif ?>
							</h5>

							<span class="float-end">
								
								<div class="btn-group btn-group-sm">

									<!--============================================
									FAVORITOS
									============================================-->
									
									<button 
									type="button" 
									class="btn btn-light border 
									<?php if (isset($_SESSION["user"]) && $value->id_favorite == 0): ?> addFavorite <?php endif ?>
									<?php if (isset($_SESSION["user"]) && $value->id_favorite > 0): ?> remFavorite <?php endif ?>"
									<?php if (!isset($_SESSION["user"])): ?> data-bs-toggle="modal" data-bs-target="#login" <?php endif ?>
									idProduct="<?php echo $value->id_product ?>"
									idFavorite="<?php echo $value->id_favorite ?>"
									pageFavorite="no"
									>
										<?php if ($value->id_favorite > 0): ?>
											<i class="fas fa-heart" style="color:#dc3545"></i>
										<?php else: ?>
											<i class="fas fa-heart"></i>	
										<?php endif ?>
										
									</button>


									<button type="button" class="btn btn-light border" onclick="location.href='/<?php echo $value->url_product ?>'">
										<i class="fas fa-eye"></i>
									</button>

								</div>
							</span>
						</div>

					</div>

				</div>

			<?php endforeach ?>

		</div>

		<!-- PAGINACIÓN -->

		<div class="d-flex justify-content-center mt-3 mb-5">


			<div class="cont-pagination">

				<ul 
				class="pagination"
				data-total-pages="<?php echo ceil($totalProducts/$endAt) ?>"
				data-url-page="<?php echo $routesArray[0] ?>"
				data-current-page="<?php echo $currentPage ?>"
				></ul>

			</div>


		</div>

	</div>

</div>


