<?php 

class UsersController{

	/*=============================================
	Registro de usuarios
	=============================================*/	

	public function register(){

		if(isset($_POST["email_user"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "procesando...", "");

			</script>';

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/',$_POST["name_user"]) &&
			   preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["email_user"])){

			   	/*=============================================
				Registro de Usuarios
				=============================================*/	
				$confirm_user = TemplateController::genPassword(20);
				
				$url = "users?register=true&suffix=user";
				$method = "POST";
				$fields = array(
					"name_user" => TemplateController::capitalize(trim($_POST["name_user"])),
					"email_user"  => $_POST["email_user"],
					"password_user" => $_POST["password_user"],
					"method_user" => "directo",
					"verification_user" => 0,
					"confirm_user" => $confirm_user,
					"date_created_user" => date("Y-m-d")
				);

				$register = CurlController::request($url, $method, $fields);

				if($register->status == 200){

					/*=============================================
					Enviamos correo de confirmación
					=============================================*/	
					$subject = 'Registro - Ecommerce';
					$email = $_POST["email_user"];
					$title ='CONFIRMAR CORREO ELECTRÓNICO';
					$message = '<h4 style="font-weight: 100; color:#999; padding:0px 20px">Dar clic en el siguiente botón para confirmar su correo electrónico y activar su cuenta</h4>';
					$link = TemplateController::path().'?confirm='.$confirm_user;

					$sendEmail = TemplateController::sendEmail($subject, $email, $title, $message, $link);

					if($sendEmail == "ok"){

						echo '<script>

								fncFormatInputs();
								fncMatPreloader("off");
								fncToastr("success", "Su cuenta ha sido creada, revisa tu correo electrónico para activar tu cuenta");

							</script>
						';

					}else{

						echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncNotie("error", "'.$sendEmail.'");

							</script>
						';

					}

				}

			}else{

				echo '<div class="alert alert-danger mt-3">Error de sintaxis en los campos</div>

				<script>

				    fncToastr("error","Error de sintaxis en los campos");
					fncMatPreloader("off");
					fncFormatInputs();

				</script>

				';


			}


		}


	}

	/*=============================================
	Ingreso de usuarios
	=============================================*/	

	public function login(){


		if(isset($_POST["login_email_user"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "procesando...", "");

			</script>';

			if(preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["login_email_user"])){


				$url = "users?login=true&suffix=user";
				$method = "POST";
				$fields = array(

					"email_user" => $_POST["login_email_user"],
					"password_user" => $_POST["login_password_user"]

				);

				$login = CurlController::request($url,$method,$fields);
				
				if($login->status == 200){

					$_SESSION["user"] = $login->results[0];

					echo '<script>
						
						localStorage.setItem("token-user", "'. $login->results[0]->token_user.'")
						window.location="'.TemplateController::urlRedirect().'"

					</script>';

				}else{

					$error = null;

					if($login->results == "Wrong email"){

						$error = "Correo mal escrito";
					
					}else{

						$error = "Contraseña mal escrita";

					}

					echo '<div class="alert alert-danger mt-3">Error al ingresar: '.$error.'</div>

					<script>

						fncToastr("error","Error al ingresar: '.$error.'");
						fncMatPreloader("off");
						fncFormatInputs();
						
					</script>';

				}




			}else{

				echo '<div class="alert alert-danger mt-3">Error de sintaxis en los campos</div>

				<script>

				    fncToastr("error","Error de sintaxis en los campos");
					fncMatPreloader("off");
					fncFormatInputs();

				</script>

				';


			}



		}
	}

	/*=============================================
	Volver a enviar Verificación de usuarios
	=============================================*/	

	public function verification(){

		if(isset($_POST["new_verification"]) && $_POST["new_verification"] == "yes"){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "procesando...", "");

			</script>';

			$confirm_user = TemplateController::genPassword(20);

			$url = "users?id=".$_SESSION["user"]->id_user."&nameId=id_user&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
			$method = "PUT";
			$fields = "confirm_user=".$confirm_user;
			
			$verification = CurlController::request($url, $method, $fields);

			if($verification->status == 200){

				/*=============================================
				Enviamos correo de confirmación
				=============================================*/	
				$subject =  'Verificación - Ecommerce';
				$email = $_SESSION["user"]->email_user;
				$title ='CONFIRMAR CORREO ELECTRÓNICO';
				$message = '<h4 style="font-weight: 100; color:#999; padding:0px 20px">Dar clic en el siguiente botón para confirmar su correo electrónico y activar su cuenta</h4>';
				$link = TemplateController::path().'?confirm='.$confirm_user;

				$sendEmail = TemplateController::sendEmail($subject, $email, $title, $message, $link);

				if($sendEmail == "ok"){

					echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncToastr("success", "Se ha enviado nuevamente un correo electrónico para activar su cuenta");

						</script>
					';

				}else{

					echo '<script>

						fncFormatInputs();
						fncMatPreloader("off");
						fncNotie("error", "'.$sendEmail.'");

						</script>
					';

				}



			}


		}
	}

	/*=============================================
	Modificar datos de usuarios
	=============================================*/	

	public function modify(){

		if(isset($_POST["country_user"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "procesando...", "");

			</script>';

			$password_user;

			if(!empty($_POST["password_user"])){

				$password_user = crypt($_POST["password_user"], '$2a$07$azybxcags23425sdg23sdfhsd$');

				$fields = "name_user=".TemplateController::capitalize(trim($_POST["name_user"]))."&password_user=".$password_user."&country_user=".explode("_",$_POST["country_user"])[0]."&department_user=".TemplateController::capitalize(trim($_POST["department_user"]))."&city_user=".TemplateController::capitalize(trim($_POST["city_user"]))."&address_user=".trim(urlencode($_POST["address_user"]))."&phone_user=".str_replace("+","",explode("_",$_POST["country_user"])[1])."_".str_replace("-","",$_POST["phone_user"]);

			}else{

				$fields = "name_user=".TemplateController::capitalize(trim($_POST["name_user"]))."&country_user=".explode("_",$_POST["country_user"])[0]."&department_user=".TemplateController::capitalize(trim($_POST["department_user"]))."&city_user=".TemplateController::capitalize(trim($_POST["city_user"]))."&address_user=".trim(urlencode($_POST["address_user"]))."&phone_user=".str_replace("+","",explode("_",$_POST["country_user"])[1])."_".str_replace("-","",$_POST["phone_user"]);
				
			}

			$url = "users?id=".$_SESSION["user"]->id_user."&nameId=id_user&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
			$method = "PUT";
			
			$modify = CurlController::request($url, $method, $fields);

			if($modify->status == 200){

				$_SESSION["user"]->name_user = TemplateController::capitalize(trim($_POST["name_user"]));
				$_SESSION["user"]->country_user = explode("_",$_POST["country_user"])[0];
				$_SESSION["user"]->department_user = TemplateController::capitalize(trim($_POST["department_user"]));
				$_SESSION["user"]->city_user = TemplateController::capitalize(trim($_POST["city_user"]));
				$_SESSION["user"]->address_user = trim($_POST["address_user"]);
				$_SESSION["user"]->phone_user = str_replace("+","",explode("_",$_POST["country_user"])[1])."_".str_replace("-","",$_POST["phone_user"]);

				echo '<script>

						fncFormatInputs();
						fncMatPreloader("off");
						fncToastr("success", "Se han actualizado tus datos");

					</script>
				';

			}



		}

	}

	/*=============================================
	Recuperar contraseña
	=============================================*/

	public function resetPassword(){

		if(isset($_POST["resetPassword"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/	

			if(preg_match( '/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["resetPassword"] )
			){

				/*=============================================
				Preguntamos primero si el usuario está registrado
				=============================================*/	

				$url = "users?linkTo=email_user&equalTo=".$_POST["resetPassword"]."&select=id_user";
				$method = "GET";
				$fields = array();

				$user = CurlController::request($url,$method,$fields);
				
				if($user->status == 200){

					$newPassword = TemplateController::genPassword(11);

					$crypt = crypt($newPassword, '$2a$07$azybxcags23425sdg23sdfhsd$');
							
					/*=============================================
					Actualizar contraseña en base de datos
					=============================================*/
					$url = "users?id=".$user->results[0]->id_user."&nameId=id_user&token=no&except=password_user";
					$method = "PUT";
					$fields = "password_user=".$crypt;

					$updatePassword = CurlController::request($url,$method,$fields);

					if($updatePassword->status == 200){	

						$subject = 'Solicitud de nueva contraseña - Ecommerce';
						$email = $_POST["resetPassword"];
						$title ='SOLICITUD DE NUEVA CONTRASEÑA';
						$message = '<h4 style="font-weight: 100; color:#999; padding:0px 20px"><strong>Su nueva contraseña: '.$newPassword.'</strong></h4>
							<h4 style="font-weight: 100; color:#999; padding:0px 20px">Ingrese nuevamente al sitio con esta contraseña y recuerde cambiarla en el panel de perfil de usuario</h4>';
						$link = TemplateController::path();

						$sendEmail = TemplateController::sendEmail($subject, $email, $title, $message, $link);

						if($sendEmail == "ok"){

							echo '<script>

									fncFormatInputs();
									fncMatPreloader("off");
									fncToastr("success", "Su nueva contraseña ha sido enviada con éxito, por favor revise su correo electrónico");

								</script>
							';

						}else{

							echo '<script>

								fncFormatInputs();
								fncMatPreloader("off");
								fncNotie("error", "'.$sendEmail.'");

								</script>
							';

						}
					}

				}else{

					echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncNotie("error", "El correo no existe en la base de datos");

						</script>
					';

				}

			}


		}


	}

	/*=============================================
	Conexión con redes sociales
	=============================================*/
	static public function socialConnect($type, $urlRedirect){

		if($type == "facebook"){

			/*=============================================
			Conexión con facebook
			=============================================*/
			$fb = new \Facebook\Facebook([
			  'app_id' => '',
			  'app_secret' => '',
			  'default_graph_version' => 'v2.10',
			  //'default_access_token' => '{access-token}', // optional
			]);

			/*=============================================
			Creamos redirección a la API de Facebook
			=============================================*/

			$handler = $fb->getRedirectLoginHelper();

			
			/*=============================================
			Activamos la URL de Fecebook con los  dos parámetros: 
			URL de regreso y los datos que solicitamos
			=============================================*/

			$data = ["email"];

			if(!isset($_GET["code"])){

				$fullUrl = $handler->getLoginUrl(TemplateController::urlRedirect(), $data);
				
				/*=============================================
				Redireccionamos nuestro sitio hacia Facebook
				=============================================*/

				echo '<script>
					window.location = "'.$fullUrl.'";
				</script>';

			}else{


				/*=============================================
				Solicitamos access token de facebook
				=============================================*/

				try{
					
					$accessToken = $handler->getAccessToken();	

				}catch(\Facebook\Exceptions\FacebookResponseException $e){

					echo '<script>

							fncNotie("error", "Response Exception: '.$e->getMessage().'");

						</script>
					';
					exit();

				}catch(\Facebook\Exceptions\FacebookSDKException $e){

					echo '<script>

							fncNotie("error", "SDK Exception: '.$e->getMessage().'");

						</script>
					';
					exit();	
					
				}

				$oAuth2Client = $fb->getOAuth2Client();
				$userData = null;

				if(!$accessToken->isLongLived())
					$accessToken = $oAuth2Client->getLongLivedAccesToken($accessToken);
					$response = $fb->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
					$userData = $response->getGraphNode()->asArray();

				if(!empty($userData)){

					/*=============================================
					Preguntamos si el usuario ya está registrado en nuestra base de datos
					=============================================*/

					$url = "users?linkTo=email_user&equalTo=".$userData["email"];
					$method = "GET";
					$fields = Array();

					$user = CurlController::request($url,$method,$fields);
					
					/*=============================================
					si el usuario no está registrado
					=============================================*/

					if($user->status != 200){

						$url = "users?register=true&suffix=user";
						$method = "POST";
						$fields = array(

							"name_user" => $userData["first_name"]." ".$userData["last_name"],
							"email_user"  => $userData["email"],
							"method_user" => "facebook",
							"verification_user" => 1,
							"date_created_user" => date("Y-m-d")

						);

						$register = CurlController::request($url, $method, $fields);

						if($register->status == 200){

							$url = "users?linkTo=email_user&equalTo=".$userData["email"];
							$method = "GET";
							$fields = Array();

							$login = CurlController::request($url,$method,$fields);

							if($login->status == 200){

								$_SESSION["user"] = $login->results[0];

								echo '<script>
									
									localStorage.setItem("token-user", "'.$login->results[0]->token_user.'")
									window.location="'.$urlRedirect.'"

								</script>';

							}

						}


					/*=============================================
					si el usuario está registrado
					=============================================*/

					}else{

						if($user->results[0]->method_user != "facebook"){

							echo '<script>

								fncFormatInputs();
								fncMatPreloader("off");
								fncSweetAlert("error", "Su correo electrónico ya está registrado con el método de ingreso '.$user->results[0]->method_user.'","'.$urlRedirect.'");

							</script>';

							return;

						}

						$url = "users?login=true&suffix=user";
						$method = "POST";
						$fields = array(

							"email_user" => $user->results[0]->email_user,
							"password_user" => ""

						);

						$login = CurlController::request($url,$method,$fields);
				
						if($login->status == 200){

							$_SESSION["user"] = $login->results[0];

							echo '<script>
									
									localStorage.setItem("token-user", "'.$login->results[0]->token_user.'")
									window.location="'.$urlRedirect.'"

								</script>';

						}
					}

				}	
			}


		}

		if($type == "google"){

			/*=============================================
			Conexión con google
			=============================================*/

			$client = new Google\Client();
			$client->setAuthConfig('views/assets/json/client_secret.json');
			$client->setScopes(['profile','email']);
			$client->setRedirectUri(TemplateController::path()."google");
			$fullUrl = $client->createAuthUrl();
			
			/*=============================================
			Redireccionamos nuestro sitio hacia Google
			=============================================*/
		
			if(!isset($_GET["code"])){

				if($urlRedirect != null){

					setcookie("urlRedirect", $urlRedirect, time() + 30*24*60*60);

				}

				echo '<script>
					window.location = "'.$fullUrl.'";
				</script>';

			}else{

				/*=============================================
				Solicitamos access token de google
				=============================================*/

				$token = $client->authenticate($_GET["code"]);
				$_SESSION["id_token_google"] = $token;
				$client->setAccessToken($token);

				/*=============================================
				Recibimos datos de google en un array
				=============================================*/

				if($client->getAccessToken()){

					$userData = $client->verifyIdToken();

					if(!empty($userData)){

						if(isset($_COOKIE["urlRedirect"])){

							$redirect = $_COOKIE["urlRedirect"];

						}else{

							$redirect = TemplateController::urlRedirect();	
						}

						/*=============================================
						Preguntamos si el usuario ya está registrado en nuestra base de datos
						=============================================*/

						$url = "users?linkTo=email_user&equalTo=".$userData["email"];
						$method = "GET";
						$fields = Array();

						$user = CurlController::request($url,$method,$fields);

						/*=============================================
						si el usuario no está registrado
						=============================================*/

						if($user->status != 200){

							$url = "users?register=true&suffix=user";
							$method = "POST";
							$fields = array(

								"name_user" => $userData["given_name"]." ".$userData["family_name"],
								"email_user"  => $userData["email"],
								"method_user" => "google",
								"verification_user" => 1,
								"date_created_user" => date("Y-m-d")

							);

							$register = CurlController::request($url, $method, $fields);

							if($register->status == 200){

								$url = "users?linkTo=email_user&equalTo=".$userData["email"];
								$method = "GET";
								$fields = Array();

								$login = CurlController::request($url,$method,$fields);

								if($login->status == 200){

									$_SESSION["user"] = $login->results[0];

									echo '<script>
										
										localStorage.setItem("token-user", "'. $login->results[0]->token_user.'")
										window.location="'.$redirect.'"

									</script>';

								}

							}

						/*=============================================
						si el usuario ya está registrado
						=============================================*/

						}else{

							if($user->results[0]->method_user != "google"){

								echo '<script>

									fncFormatInputs();
									fncMatPreloader("off");
									fncSweetAlert("error", "Su correo electrónico ya está registrado con el método de ingreso '.$user->results[0]->method_user.'","'.$redirect.'");

								</script>';

								return;

							}

							$url = "users?login=true&suffix=user";
							$method = "POST";
							$fields = array(

								"email_user" => $user->results[0]->email_user,
								"password_user" => ""

							);

							$login = CurlController::request($url,$method,$fields);
					
							if($login->status == 200){

								$_SESSION["user"] = $login->results[0];

								echo '<script>
										
										localStorage.setItem("token-user", "'.$login->results[0]->token_user.'")
										window.location="'.$redirect.'"

									</script>';

							}

						}
					}
				}
			}

		}

	}


}