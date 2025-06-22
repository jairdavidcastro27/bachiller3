<?php 

class PaymentsController{

	/*=============================================
	Actualizar datos y pasarelas de pago
	=============================================*/	

	public function payment(){

		if(isset($_POST["optradio"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "procesando para pagar...", "");

			</script>';
			
			/*=============================================
    		Actualizar datos de usario en bd
    		=============================================*/

    		$url = "users?id=".$_SESSION["user"]->id_user."&nameId=id_user&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
    		$method = "PUT";
    		$fields = "name_user=".TemplateController::capitalize(trim($_POST["name_user"]))."&country_user=".explode("_",$_POST["country_user"])[0]."&department_user=".TemplateController::capitalize(trim($_POST["department_user"]))."&city_user=".TemplateController::capitalize(trim($_POST["city_user"]))."&address_user=".trim(urlencode($_POST["address_user"]))."&phone_user=".str_replace("+","",explode("_",$_POST["country_user"])[1])."_".str_replace("-","",$_POST["phone_user"]); 

    		$updateUser = CurlController::request($url, $method, $fields);

            if($updateUser->status == 200){

            	/*=============================================
				Traemos su carrito de compras
				=============================================*/

				$url = "relations?rel=carts,variants,products&type=cart,variant,product&linkTo=id_user_cart&equalTo=".$_SESSION["user"]->id_user;

				$method = "GET";
				$fields = array();

				$carts = CurlController::request($url,$method,$fields);

				if($carts->status == 200){
					
					$carts = $carts->results;
					$totalCart = 0;

					foreach ($carts as $key => $value) {
						
						if($value->offer_variant == 0){

							$totalCart += $value->price_variant*$value->quantity_cart;	

						}else{

							$totalCart += $value->offer_variant*$value->quantity_cart;	
							

						}

					}

					$ref = TemplateController::genCodec(1000);

					/*=============================================
					Notificación por email al vendedor
					=============================================*/

					$subject = "Recibirá un pago de $".number_format($totalCart,2)." a través de".$_POST["optradio"];
					$email = null;
					$title = "Referencia del pago ".$ref;
					$message = "<h4>¡Recibirá un pago de $".number_format($totalCart,2)."!</4><h5>De ".TemplateController::capitalize(trim($_POST["name_user"])).", celular: ".str_replace("+","",explode("_",$_POST["country_user"])[1])."_".str_replace("-","",$_POST["phone_user"]).", ".TemplateController::capitalize(trim($_POST["city_user"]))." - ".TemplateController::capitalize(trim($_POST["department_user"])).". Del producto: ".$carts[0]->name_product."</h5>";
					$link = TemplateController::path().'thanks?ref='.$ref;

					TemplateController::sendEmail($subject, $email, $title, $message, $link);
					
					/*=============================================
					Pasarela de pagos de PayPal
					=============================================*/

					if($_POST["optradio"] == "paypal"){

						$url = "v2/checkout/orders";
						$method = "POST";
						$fields = '{
						  "intent": "CAPTURE",
						  "purchase_units": [
						    {
						      "reference_id": "'.$ref.'",
						      "amount": {
						        "currency_code": "USD",
						        "value": "'.$totalCart.'"
						      }
						    }
						  ],
						  "payment_source": {
						    "paypal": {
						      "experience_context": {
						        "payment_method_preference": "IMMEDIATE_PAYMENT_REQUIRED",
						        "user_action": "PAY_NOW",
						        "return_url": "'.TemplateController::path().'thanks?ref='.$ref.'",
						        "cancel_url": "'.TemplateController::path().'checkout"
						      }
						    }
						  }
						}';

						$paypal = CurlController::paypal($url,$method,$fields);
						
						if($paypal->status == "PAYER_ACTION_REQUIRED"){

							$count = 0;

							foreach ($carts as $key => $value) {
								
								$url = "carts?id=".$value->id_cart."&nameId=id_cart&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
								$method = "PUT";
								$fields = "ref_cart=".$ref."&order_cart=".$paypal->id."&method_cart=".$_POST["optradio"]."&price_cart=".$totalCart;

								$updateCart = CurlController::request($url, $method, $fields);

								$count++;

								if($count == count($carts)){

									echo '<script>

										window.location ="'.$paypal->links[1]->href.'"

									</script>';

								}
							
							}

						}				

					}

					/*=============================================
					Pasarela de pagos de D-Local Go
					=============================================*/

					if($_POST["optradio"] == "dlocal"){

						$url = "v1/payments";
						$method = "POST";
						$fields = '{
						    "amount": '.$totalCart.',
						    "currency" : "USD",
						    "success_url":"'.TemplateController::path().'thanks?ref='.$ref.'",
						    "back_url": "'.TemplateController::path().'checkout"
						}';

						$dlocal = CurlController::dlocal($url,$method,$fields);

						if($dlocal->status == "PENDING"){

							$count = 0;

							foreach ($carts as $key => $value) {
								
								$url = "carts?id=".$value->id_cart."&nameId=id_cart&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
								$method = "PUT";
								$fields = "ref_cart=".$ref."&order_cart=".$dlocal->id."&method_cart=".$_POST["optradio"]."&price_cart=".$totalCart;

								$updateCart = CurlController::request($url, $method, $fields);

								$count++;

								if($count == count($carts)){

									echo '<script>

										window.location ="'.$dlocal->redirect_url.'"

									</script>';

								}
							
							}

						}

					}

					/*=============================================
					Pasarela de pagos de Mercado Pago
					=============================================*/

					if($_POST["optradio"] == "mercado_pago"){

						$url = "checkout/preferences";
						$method = "POST";
						$fields = '{
						   "auto_return":"approved",
						    "back_urls": {
						    "success":"'.TemplateController::path().'thanks?ref='.$ref.'",
						    "pending":"'.TemplateController::path().'thanks?ref='.$ref.'",
						    "failure":"'.TemplateController::path().'checkout"
						    },
						    "expires": false,
						    "items": [
						        {
						        "title": "Pago en Ecommerce",
						        "quantity": 1,
						        "currency_id": "COP",
						        "unit_price": '.round(TemplateController::exchange("currency")*$totalCart).'
						        }
						    ],
						    "notification_url":"'.TemplateController::path().'webhooks/mercadopago.php?ref='.$ref.'"

						}';

						$mercadoPago = CurlController::mercadoPago($url,$method,$fields);

						if($mercadoPago->auto_return == "approved"){

							$count = 0;

							foreach ($carts as $key => $value) {
								
								$url = "carts?id=".$value->id_cart."&nameId=id_cart&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
								$method = "PUT";
								$fields = "ref_cart=".$ref."&order_cart=".null."&method_cart=".$_POST["optradio"]."&price_cart=".$totalCart;

								$updateCart = CurlController::request($url, $method, $fields);

								$count++;

								if($count == count($carts)){

									echo '<script>

										window.location ="'.$mercadoPago->init_point.'"

									</script>';

								}
							
							}

						}

					}

				}

            }

		}

	}

	/*=============================================
	Editar una órden
	=============================================*/	

	public function editOrder(){

		if(isset($_POST["process_order"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "procesando...", "");

			</script>';

			$url = "orders?id=".base64_decode($_POST["idOrder"])."&nameId=id_order&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
			$method = "PUT";
			$fields = "process_order=".$_POST["process_order"]."&track_order=".$_POST["track_order"]."&start_date_order=".$_POST["start_date_order"]."&medium_date_order=".$_POST["medium_date_order"]."&end_date_order=".$_POST["end_date_order"];

			$updateOrder = CurlController::request($url, $method, $fields);

            if($updateOrder->status == 200){

            	echo '<script>

						fncMatPreloader("off");
						fncFormatInputs();

						fncSweetAlert("success","Sus datos han sido actualizados con éxito","/admin/pedidos");
		
					</script>';	

			}else{

				if($updateOrder->status == 303){	

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