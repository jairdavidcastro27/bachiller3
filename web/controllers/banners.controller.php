<?php 

class BannersController{

	/*=============================================
	Gestión Banners
	=============================================*/

	public function bannersManage(){

		if(isset($_POST["banner"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "", "");

			</script>';

			if(isset($_POST["idBanner"])){

				/*=============================================
				Validar y guardar background
				=============================================*/

				if(isset($_FILES['background_banner']["tmp_name"]) && !empty($_FILES['background_banner']["tmp_name"])){

					$image = $_FILES['background_banner'];
					$folder = "assets/img/banner/".$createData->results->lastId;
					$name = "bg";
					$width = 1600;
					$height = 550;

					$saveBackgroundBanner = TemplateController::saveImage($image,$folder,$name,$width,$height);
					
				}else{

					$saveBackgroundBanner = $_POST["old_background_banner"];
				}


				$fields = "location_banner=".$_POST["location_banner"]."&id_category_banner=".$_POST["id_category_banner"]."&id_subcategory_banner=".$_POST["id_subcategory_banner"]."&text_banner=".$_POST["text_banner"]."&discount_banner=".$_POST["discount_banner"]."&end_banner=".$_POST["end_banner"]."&background_banner=".$saveBackgroundBanner;

				$url = "banners?id=".base64_decode($_POST["idBanner"])."&nameId=id_banner&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "PUT";

				$updateData = CurlController::request($url, $method, $fields);

				if($updateData->status == 200){

					echo '<script>

						fncMatPreloader("off");
						fncFormatInputs();

						fncSweetAlert("success","Sus datos han sido actualizados con éxito","/admin/banners");
		
					</script>';	

				}else{

					if($updateData->status == 303){	

						echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncSweetAlert("error","Token expirado, vuelva a iniciar sesión","/salir");

						</script>';		

					}else{

						echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncToastr("error","Ocurrió un error mientras se guardaban los datos, intente de nuevo");

						</script>';	

					}

				}

			}else{

				$fields = array(
				
					"location_banner" => $_POST["location_banner"],
					"id_category_banner" => $_POST["id_category_banner"],
					"id_subcategory_banner" => $_POST["id_subcategory_banner"],
					"text_banner" => $_POST["text_banner"],
					"discount_banner" => $_POST["discount_banner"],
					"end_banner" => $_POST["end_banner"],
					"date_created_banner" => date("Y-m-d")

				);

				$url = "banners?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "POST";

				$createData = CurlController::request($url, $method, $fields);
				
				if($createData->status == 200){

					/*=============================================
					Validar y guardar background
					=============================================*/

					if(isset($_FILES['background_banner']["tmp_name"]) && !empty($_FILES['background_banner']["tmp_name"])){

						$image = $_FILES['background_banner'];
						$folder = "assets/img/banner/".$createData->results->lastId;
						$name = "bg";
						$width = 1600;
						$height = 550;

						$saveBackgroundBanner = TemplateController::saveImage($image,$folder,$name,$width,$height);
						
					}

					if(!empty($saveBackgroundBanner)){

						$fields = "background_banner=".$saveBackgroundBanner;

						$url = "banners?id=".$createData->results->lastId."&nameId=id_banner&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
						$method = "PUT";

						$updateData = CurlController::request($url, $method, $fields);

						if($updateData->status == 200){

							echo '<script>

								fncMatPreloader("off");
								fncFormatInputs();

								fncSweetAlert("success","Sus datos han sido creados con éxito","/admin/banners");
				
							</script>';	

						}else{

							if($updateData->status == 303){	

								echo '<script>

									fncFormatInputs();
									fncMatPreloader("off");
									fncSweetAlert("error","Token expirado, vuelva a iniciar sesión","/salir");

								</script>';		

							}else{

								echo '<script>

									fncFormatInputs();
									fncMatPreloader("off");
									fncToastr("error","Ocurrió un error mientras se guardaban los datos, intente de nuevo");

								</script>';	

							}

						}

					}


				}


			}

		}

	}

}