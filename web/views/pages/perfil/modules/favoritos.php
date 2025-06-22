<?php

$select = "id_favorite,id_product,url_product,name_product,description_product,date_created_product";
$url = "relations?rel=favorites,products&type=favorite,product&linkTo=id_user_favorite&equalTo=".$_SESSION["user"]->id_user."&select=".$select;
$method = "GET";
$fields = array();

$favorites = CurlController::request($url,$method,$fields);


if($favorites->status == 200){

	$favorites = $favorites->results;

}else{

	$favorites = array();

}

/*=============================================
Traemos la primera variante de los productos
=============================================*/

if(!empty($favorites)){

	foreach ($favorites as $key => $value) {

		/*=============================================
		Traemos la primera variante
		=============================================*/
		
		$select = "type_variant,media_variant,price_variant,offer_variant,end_offer_variant,stock_variant";
		$url = "variants?linkTo=id_product_variant&equalTo=".$value->id_product."&select=".$select;
		$variant = CurlController::request($url,$method,$fields)->results[0];
		
		$favorites[$key]->type_variant = $variant->type_variant;
		$favorites[$key]->media_variant = $variant->media_variant;
		$favorites[$key]->price_variant = $variant->price_variant;
		$favorites[$key]->offer_variant = $variant->offer_variant;
		$favorites[$key]->end_offer_variant = $variant->end_offer_variant;
		$favorites[$key]->stock_variant = $variant->stock_variant;
	
	}

}


?>


<?php if (!empty($favorites)): ?>

	<div class="row list-2 p-3">

		<?php foreach ($favorites as $key => $value): ?>
		
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
								class="btn btn-light border-0 remFavorite"
								idFavorite="<?php echo $value->id_favorite  ?>"
								pageFavorite="yes" 
								>
									Quitar de favoritos
								</button>


								<a class="btn btn-primary templateColor border-0" href="/<?php echo $value->url_product ?>">
									Comprar
								</a>

							</div>
						</span>
					</div>

				</div>

			</div>

		<?php endforeach ?>

	</div>

<?php else: ?>

	<?php include "views/pages/no-found/no-found.php" ?>
	
<?php endif ?>

