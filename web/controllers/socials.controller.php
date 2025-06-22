<?php 

class SocialsController{

	/*=============================================
	Gestión Categorias
	=============================================*/

	public function socialManage(){

		if(isset($_POST["name_social"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "", "");

			</script>';

			if(isset($_POST["idSocial"])){

				$fields = "name_social=".trim($_POST["name_social"])."&url_social=".trim($_POST["url_social"])."&icon_social=".$_POST["icon_social"]."&color_social=".$_POST["color_social"];

				$url = "socials?id=".$_POST["idSocial"]."&nameId=id_social&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "PUT";

				$updateData = CurlController::request($url, $method, $fields);

				if($updateData->status == 200){

					echo '<script>

						fncMatPreloader("off");
						fncFormatInputs();

						fncSweetAlert("success","Sus datos han sido actualizados con éxito","/admin/redes-sociales");
		
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
				
					
					"name_social" => trim($_POST["name_social"]),
					"url_social" => trim($_POST["url_social"]),
					"icon_social" => $_POST["icon_social"],
					"color_social" => $_POST["color_social"],
					"date_created_social" => date("Y-m-d")

				);

				$url = "socials?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "POST";

				$createData = CurlController::request($url, $method, $fields);
				
				if($createData->status == 200){	

					echo '<script>

						fncMatPreloader("off");
						fncFormatInputs();

						fncSweetAlert("success","Sus datos han sido creados con éxito","/admin/redes-sociales");
		
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