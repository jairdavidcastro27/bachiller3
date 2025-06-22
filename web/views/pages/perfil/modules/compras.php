<?php 

 /*=============================================
Traer órdenes de compra
=============================================*/
$select = "*";
$url = "relations?rel=orders,variants,products,users&type=order,variant,product,user&linkTo=id_user_order&equalTo=".$_SESSION["user"]->id_user."&select=".$select;
$method = "GET";
$fields = array();

$shopping = CurlController::request($url,$method,$fields);

if($shopping->status == 200){

	$shopping = $shopping->results;
	

}else{

	$shopping = array();
}

?>

<?php if (!empty($shopping)): ?>

	<div class="row list-2">
		
		<?php foreach ($shopping as $key => $value): ?>

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
					
					<div class="row row-cols-1 row-cols-lg-2">
						
						<div class="col">
							
							<small class="text-info">Órden de compra N.<?php echo $value->uniqid_order ?></small>
							<hr class="mt-1 mb-1">
							<a href="/<?php echo $value->url_product ?>">
								<h5><small class="text-uppercase text-muted"><?php echo $value->name_product ?></small></h5>
							</a>

							<div>
								<small class="m-0"><?php echo $value->description_variant ?></small>
								<small class="m-0">* <?php echo $value->quantity_order ?></small>
							</div>

							<h4 class="mt-2 font-weight-bold">
								
								$

								<?php 

								if ($value->offer_variant>0) {
									echo number_format(($value->quantity_order*$value->offer_variant),2);
								}else{
									echo number_format(($value->quantity_order*$value->price_variant),2); 
								}

								?>

							</h4>

							<?php if ($value->type_variant == "gallery" && $value->process_order > 1): ?>

								<div class="d-flex mt-4">

									<?php 

									if ($value->end_date_order != null){

										$deliveryDate = date($value->end_date_order);
										$warrantyDate = date("Y-m-d", strtotime($deliveryDate."+ ".$value->warranty_order." days"));

									}
		
									?>

									<?php if ($warrantyDate >= date("Y-m-d")): ?>
				
										<a href="" target="_blank" class="mr-1 py-2 px-3 bg-warning rounded-pill small getWarranty" phone="<?php echo $phone ?>" order="<?php echo $value->uniqid_order ?>">Fecha límite garantía: <?php echo TemplateController::formatDate(1, $warrantyDate) ?> <i class="fab fa-whatsapp ml-2"></i></a>

									<?php else: ?>

										<a
											class="questionOrder bg-transparent border rounded-pill small p-2"
											href=""
											target="_blank"
											order="<?php echo $value->uniqid_order ?>"
											phone="<?php echo $phone ?>"
											>
											  ¿Tiene dudas acerca de esta compra? ¡haz clic acá! <i class="fab fa-whatsapp ml-2"></i>
									</a>


									<?php endif ?>


								</div>
								
							<?php endif ?>

						</div>

						<div class="col">

			                <?php if ($value->type_variant == "gallery"): ?>

			                <!--==========================================
			                Línea de tiempo
			                ===========================================--> 

			                <div class="container">
			                	
			                	<ul class="timeline-3">

			                		<li>
			                			<p class="font-weight-bold float-start">Creando guía de seguimiento</p>
			                			<p class="float-end"><?php echo TemplateController::formatDate(1, $value->start_date_order) ?></p>
			                			<div class="clearfix"></div>
			                		</li>

			                		<li
			                		class="<?php if ($value->process_order > 0): ?> text-dark <?php else: ?> text-light<?php endif ?>"
			                		>
			                			<p class="font-weight-bold float-start">En reparto</p>

			                			<?php if ($value->process_order > 0 && $value->track_order != ""): ?>
			                			
			                			<p class="float-end"><?php echo TemplateController::formatDate(1, $value->medium_date_order) ?></p>

			                			<span class="ml-2 badge badge-pill badge-primary">
			                				<small class="mt-2">Guía de seguimiento <?php echo $value->track_order ?></small>
			                			</span>

			                			<?php endif ?>
			                			<div class="clearfix"></div>
			                		</li>

			                		<li
			                		class="<?php if ($value->process_order > 1): ?> text-dark <?php else: ?> text-light<?php endif ?>"
			                		>
			                			<p class="font-weight-bold float-start">Entregado <i class="far fa-check-circle fa-lg"></i></p>
			                			<?php if ($value->process_order > 1 && $value->track_order != ""): ?>
			                			<p class="float-end"><?php echo TemplateController::formatDate(1, $value->end_date_order) ?></p>
			                			<?php endif ?>
			                			<div class="clearfix"></div>
			                		</li>
			                		
			                	</ul>
			                </div>

			                <?php else: ?>

			                	<div class="mt-3">
			                		
			                		<a href="/aprendizaje/<?php echo $value->url_product ?>" class="btn btn-default border-0 templateColor float-end rounded-pill px-4" style="color:white !important">Ir al curso</a>
			                		<div class="clearfix"></div>

			                	</div>

			                	<?php if ($value->type_variant != "gallery"): ?>

			                		<div class="float-end my-3">

				                		<?php 

										if ($value->start_date_order != null){

											$deliveryDate = date($value->start_date_order);
											$warrantyDate = date("Y-m-d", strtotime($deliveryDate."+ ".$value->warranty_order." days"));

										}
			
										?>

										<?php if ($warrantyDate >= date("Y-m-d")): ?>
					
											<a href="" target="_blank" class="ml-1 py-2 px-3 bg-warning rounded-pill small getRefund" phone="<?php echo $phone ?>" order="<?php echo $value->uniqid_order ?>">Fecha límite reembolso: <?php echo TemplateController::formatDate(1, $warrantyDate) ?></a>

										<?php else: ?>

										<a
											class="questionOrder bg-transparent border rounded-pill small p-2"
											href=""
											target="_blank"
											order="<?php echo $value->uniqid_order ?>"
											phone="<?php echo $phone ?>"
											>
											  ¿Tiene dudas acerca de esta compra? ¡haz clic acá! <i class="fab fa-whatsapp ml-2"></i>
										</a>

										<?php endif ?>

									</div>

			                	<?php endif ?>

			                <?php endif ?>

						</div>

					</div>

				</div>

			</div>
			
		<?php endforeach ?>

	</div>

<?php else: ?>

	<?php include "views/pages/no-found/no-found.php" ?>
	
<?php endif ?>

<script src="<?php echo $path ?>views/assets/js/orders/orders.js"></script>