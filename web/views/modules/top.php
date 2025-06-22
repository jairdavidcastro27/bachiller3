<?php 

/*=============================================
Datos de las redes sociales
=============================================*/

$url = "socials";
$method = "GET";
$fields = array();

$socials = CurlController::request($url,$method,$fields);

if($socials->status == 200){

	$socials = $socials->results;	

}


?>

<div class="container-fluid topColor">
	
	<div class="container">
		
		<div class="d-flex justify-content-between">
			
			<div class="p-2">
				
				<div class="d-flex justify-content-center">

					<?php foreach ($socials as $key => $value): ?>

						<div class="p-2">
							
							<a href="<?php echo $value->url_social ?>" target="_blank">
								
								<i class="<?php echo $value->icon_social ?> <?php echo $value->color_social ?>"></i>
							
							</a>

						</div>
						
					<?php endforeach ?>

				</div>

			</div>

			<?php if (isset($_SESSION["user"])): ?>

				<div class="p-2">
					
					<div class="d-flex justify-content-center small">
						
						<div class="p-2">
							
							<a href="/perfil" class="text-white">
								
								Hola, <?php echo $_SESSION["user"]->name_user ?>
							
							</a>

						</div>

						<div class="p-2">

							|
							
						</div>

						<div class="p-2">
							
							<a href="/salir" class="text-white">
								
								Salir
							
							</a>

						</div>

						
					</div>

				</div>

			<?php else: ?>


				<div class="p-2">
					
					<div class="d-flex justify-content-center small">
						
						<div class="p-2">
							
							<a href="#login" class="text-white" data-bs-toggle="modal">
								
								Ingresar
							
							</a>

						</div>

						<div class="p-2">

							|
							
						</div>

						<div class="p-2">
							
							<a href="#register" class="text-white" data-bs-toggle="modal">
								
								Crear cuenta
							
							</a>

						</div>

						
					</div>

				</div>

			<?php endif ?>

		</div>


	</div>


</div>