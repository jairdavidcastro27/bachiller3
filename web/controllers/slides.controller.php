<?php 

class SlidesController{

	/*=============================================
	Gestión Slides
	=============================================*/

	public function slidesManage(){

		if(isset($_POST["slide"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "", "");

			</script>';

			if(!empty($_POST["direction_slide"])){

				$direction_slide = $_POST["direction_slide"];
				$coord_img_slide = $_POST["coord_img_slide"];
				$text_slide = '[{"text":"'.$_POST["textSlide1"].'","color":"'.$_POST["colorSlide1"].'"},{"text":"'.$_POST["textSlide2"].'","color":"'.$_POST["colorSlide2"].'"},{"text":"'.$_POST["textSlide3"].'","color":"'.$_POST["colorSlide3"].'"}]';
				$coord_text_slide = $_POST["coord_text_slide"];
				$link_slide = $_POST["link_slide"];
				$text_btn_slide = $_POST["text_btn_slide"];

			}else{

				$direction_slide = null;
				$coord_img_slide = null;
				$text_slide = null;
				$coord_text_slide = null;
				$link_slide = null;
				$text_btn_slide = null;
			}

			if(isset($_POST["idSlide"])){

				/*=============================================
				Validar y guardar background
				=============================================*/

				if(isset($_FILES['background_slide']["tmp_name"]) && !empty($_FILES['background_slide']["tmp_name"])){

					$image = $_FILES['background_slide'];
					$folder = "assets/img/slide/".base64_decode($_POST["idSlide"]);
					$name = "bg";
					$width = 1600;
					$height = 520;

					$saveBackgroundSlide = TemplateController::saveImage($image,$folder,$name,$width,$height);
					
				}else{

					$saveBackgroundSlide = $_POST["old_background_slide"];
				}

				/*=============================================
				Validar y guardar imagen Flotante
				=============================================*/

				if(isset($_FILES['img_png_slide']["tmp_name"]) && !empty($_FILES['img_png_slide']["tmp_name"])){

					$image = $_FILES['img_png_slide'];
					$folder = "assets/img/slide/".base64_decode($_POST["idSlide"]);
					$name = "img";
					$width = 500;
					$height = 500;

					$saveImagePng = TemplateController::saveImage($image,$folder,$name,$width,$height);
					
				}else{

					$saveImagePng = $_POST["old_img_png_slide"];
				}

				$fields = "direction_slide=".$direction_slide."&coord_img_slide=".$coord_img_slide."&text_slide=".$text_slide."&coord_text_slide=".$coord_text_slide."&link_slide=".$link_slide."&text_btn_slide=".$text_btn_slide."&background_slide=".$saveBackgroundSlide."&img_png_slide=".$saveImagePng;

				$url = "slides?id=".base64_decode($_POST["idSlide"])."&nameId=id_slide&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "PUT";

				$updateData = CurlController::request($url, $method, $fields);

				if($updateData->status == 200){

					echo '<script>

						fncMatPreloader("off");
						fncFormatInputs();

						fncSweetAlert("success","Sus datos han sido actualizados con éxito","/admin/slides");
		
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
					"direction_slide" => $direction_slide,
					"coord_img_slide" => $coord_img_slide,
					"text_slide" => $text_slide,
					"coord_text_slide" => $coord_text_slide,
					"link_slide" => $link_slide,
					"text_btn_slide" => $text_btn_slide,
					"date_created_slide" => date("Y-m-d")

				);

				$url = "slides?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "POST";

				$createData = CurlController::request($url, $method, $fields);
				
				if($createData->status == 200){

					/*=============================================
					Validar y guardar background
					=============================================*/

					if(isset($_FILES['background_slide']["tmp_name"]) && !empty($_FILES['background_slide']["tmp_name"])){

						$image = $_FILES['background_slide'];
						$folder = "assets/img/slide/".$createData->results->lastId;
						$name = "bg";
						$width = 1600;
						$height = 520;

						$saveBackgroundSlide = TemplateController::saveImage($image,$folder,$name,$width,$height);
						
					}

					/*=============================================
					Validar y guardar imagen Flotante
					=============================================*/

					if(isset($_FILES['img_png_slide']["tmp_name"]) && !empty($_FILES['img_png_slide']["tmp_name"])){

						$image = $_FILES['img_png_slide'];
						$folder = "assets/img/slide/".$createData->results->lastId;
						$name = "img";
						$width = 500;
						$height = 500;

						$saveImagePng = TemplateController::saveImage($image,$folder,$name,$width,$height);
						
					}else{

						$saveImagePng = null;
					}

					if(!empty($saveBackgroundSlide)){

						$fields = "background_slide=".$saveBackgroundSlide."&img_png_slide=".$saveImagePng;

						$url = "slides?id=".$createData->results->lastId."&nameId=id_slide&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
						$method = "PUT";

						$updateData = CurlController::request($url, $method, $fields);

						if($updateData->status == 200){

							echo '<script>

								fncMatPreloader("off");
								fncFormatInputs();

								fncSweetAlert("success","Sus datos han sido creados con éxito","/admin/slides");
				
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