<?php 

class TemplatesController{

	/*=============================================
	Gestion de Plantillas
	=============================================*/
	
	public function templatesManage(){

		if(isset($_POST["title_template"])){
			
			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "Guardando...", "");

			</script>';

			/*=============================================
			Organizar el JSON de las fuentes
			=============================================*/

			$fonts_template = '{"fontFamily":"'.$_POST["fontFamily"].'","fontBody":"'.$_POST["fontBody"].'","fontSlide":"'.$_POST["fontSlide"].'"}';

			/*=============================================
			Organizar el JSON de los colores
			=============================================*/

			$colors_template = '[{"top":{"background":"'.$_POST["topBackground"].'","color":"'.$_POST["topColor"].'"}},{"template":{"background":"'.$_POST["templateBackground"].'","color":"'.$_POST["templateColor"].'"}}]';

			if(isset($_POST["idTemplate"])){

				/*=============================================
				Validar y guardar logotipo
				=============================================*/

				if(isset($_FILES['logo_template']["tmp_name"]) && !empty($_FILES['logo_template']["tmp_name"])){

					$image = $_FILES['logo_template'];
					$folder = "assets/img/template/".base64_decode($_POST["idTemplate"]);
					$name = "logo";
					$width = 500;
					$height = 100;

					$saveImageLogo = TemplateController::saveImage($image,$folder,$name,$width,$height);
					
				}else{

					$saveImageLogo = $_POST["old_logo_template"];

				}

				/*=============================================
				Validar y guardar icono
				=============================================*/

				if(isset($_FILES['icon_template']["tmp_name"]) && !empty($_FILES['icon_template']["tmp_name"])){

					$image = $_FILES['icon_template'];
					$folder = "assets/img/template/".base64_decode($_POST["idTemplate"]);
					$name = "icono";
					$width = 100;
					$height = 100;

					$saveImageIcon = TemplateController::saveImage($image,$folder,$name,$width,$height);
					
				}else{

					$saveImageIcon = $_POST["old_icon_template"];

				}

				/*=============================================
				Validar y guardar portada
				=============================================*/

				if(isset($_FILES['cover_template']["tmp_name"]) && !empty($_FILES['cover_template']["tmp_name"])){

					$image = $_FILES['cover_template'];
					$folder = "assets/img/template/".base64_decode($_POST["idTemplate"]);
					$name = "cover";
					$width = 1000;
					$height = 600;

					$saveImageCover = TemplateController::saveImage($image,$folder,$name,$width,$height);
					
				}else{

					$saveImageCover = $_POST["old_cover_template"];

				}

				/*=============================================
				Organizar el JSON de las fuentes
				=============================================*/

				$fonts_template = '{"fontFamily":"'.urlencode($_POST["fontFamily"]).'","fontBody":"'.$_POST["fontBody"].'","fontSlide":"'.$_POST["fontSlide"].'"}';

				$fields = "title_template=".trim(TemplateController::capitalize($_POST["title_template"]))."&description_template=".trim($_POST["description_template"])."&keywords_template=".strtolower($_POST["keywords_template"])."&fonts_template=".$fonts_template."&colors_template=".$colors_template."&logo_template=".$saveImageLogo."&icon_template=".$saveImageIcon."&cover_template=".$saveImageCover;

				$url = "templates?id=".base64_decode($_POST["idTemplate"])."&nameId=id_template&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "PUT";

				$updateData = CurlController::request($url, $method, $fields);

				if($updateData->status == 200){

					echo '<script>

						fncMatPreloader("off");
						fncFormatInputs();

						fncSweetAlert("success","Sus datos han sido actualizados con éxito","/admin/plantillas");
		
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

				/*=============================================
				Validar y guardar la información de la plantilla
				=============================================*/

				$fields = array(
				
					"title_template" => trim(TemplateController::capitalize($_POST["title_template"])),
					"description_template" => trim($_POST["description_template"]),
					"keywords_template" => strtolower($_POST["keywords_template"]),
					"fonts_template" => $fonts_template,
					"colors_template" => $colors_template,
					"date_created_template" => date("Y-m-d")

				);

				$url = "templates?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
					$method = "POST";

				$createData = CurlController::request($url, $method, $fields);

				if($createData->status == 200){

					/*=============================================
					Validar y guardar logotipo
					=============================================*/

					if(isset($_FILES['logo_template']["tmp_name"]) && !empty($_FILES['logo_template']["tmp_name"])){

						$image = $_FILES['logo_template'];
						$folder = "assets/img/template/".$createData->results->lastId;
						$name = "logo";
						$width = 500;
						$height = 100;

						$saveImageLogo = TemplateController::saveImage($image,$folder,$name,$width,$height);
						
					}

					/*=============================================
					Validar y guardar icono
					=============================================*/

					if(isset($_FILES['icon_template']["tmp_name"]) && !empty($_FILES['icon_template']["tmp_name"])){

						$image = $_FILES['icon_template'];
						$folder = "assets/img/template/".$createData->results->lastId;
						$name = "icono";
						$width = 100;
						$height = 100;

						$saveImageIcon = TemplateController::saveImage($image,$folder,$name,$width,$height);
						
					}

					/*=============================================
					Validar y guardar portada
					=============================================*/

					if(isset($_FILES['cover_template']["tmp_name"]) && !empty($_FILES['cover_template']["tmp_name"])){

						$image = $_FILES['cover_template'];
						$folder = "assets/img/template/".$createData->results->lastId;
						$name = "cover";
						$width = 1000;
						$height = 600;

						$saveImageCover = TemplateController::saveImage($image,$folder,$name,$width,$height);
						
					}

					if(!empty($saveImageLogo) && !empty($saveImageIcon) && !empty($saveImageCover)){

						$url = "templates?id=".$createData->results->lastId."&nameId=id_template&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
						$method = "PUT";

						$fields = "logo_template=".$saveImageLogo."&icon_template=".$saveImageIcon."&cover_template=".$saveImageCover;

						$updateData = CurlController::request($url, $method, $fields);

						if($updateData->status == 200){

							echo '<script>

									fncMatPreloader("off");
									fncFormatInputs();

									fncSweetAlert("success","Sus datos han sido creados con éxito","/admin/plantillas");
					
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

	