<?php 

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');

require_once "...";

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){   
   	
   	$webhook = file_get_contents('php://input');
   	
   	$web = json_decode($webhook);

   	file_put_contents(
	  'mercadopago.log',
	  $webhook. PHP_EOL,
	  FILE_APPEND
	);	

	if($web->action == "payment.created"){

		$url = "carts?linkTo=ref_cart&equalTo=".$_GET["ref"];
		$method = "GET";
		$fields = array();

		$carts = CurlController::request($url,$method,$fields);

		if($carts->status == 200){

			$carts = $carts->results;

			foreach ($carts as $key => $value) {
	
				$url = "carts?id=".$value->id_cart."&nameId=id_cart&token=no&except=ref_cart";
				$method = "PUT";
				$fields = "order_cart=".$web->data->id;

				$orderUpdate = CurlController::request($url,$method,$fields);

				if($orderUpdate->status == 200){
					file_put_contents(
					  'mercadopago_get.log',
					  $_GET["ref"]. PHP_EOL,
					  FILE_APPEND
					);
				}

			}		

		}

	}

}




?>