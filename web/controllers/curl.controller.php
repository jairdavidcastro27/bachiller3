<?php


class CurlController{

	/*=============================================
	Peticiones a la API
	=============================================*/	

	static public function request($url,$method,$fields){

		$curl = curl_init();		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.ecommerce.com/'.$url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_POSTFIELDS => $fields,
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: SSDFzdg235dsgsdfAsa44SDFGDFDadg'
		  ),
		));

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		error_log("Curl Debug - URL: http://api.ecommerce.com/$url, Method: $method, Fields: " . json_encode($fields));
		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		error_log("Curl Debug - HTTP Code: $httpCode, Response: " . $response);

		$error = curl_error($curl);
		if ($error) {
		    error_log("Curl Error: " . $error);
		}

		curl_close($curl);

		$response = json_decode($response);
		return $response;

	}

	/*=============================================
	Peticiones a la API de PAYPAL
	=============================================*/	

	static public function paypal($url, $method, $fields){

		$endpoint = "https://api-m.sandbox.paypal.com/"; //TEST
		$clientId = "..."; //TEST
		$secretClient = "..."; //TEST

		$basic = base64_encode($clientId.":".$secretClient);

		/*=============================================
		ACCESS TOKEN
		=============================================*/	

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $endpoint."v1/oauth2/token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Authorization: Basic '.$basic,
		    'Cookie: cookie_check=yes'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$response = json_decode($response);
		
		$token = $response->access_token;

		if(!empty($token)){

			/*=============================================
			CREAR ORDEN
			=============================================*/	

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $endpoint.$url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $method,
			  CURLOPT_POSTFIELDS => $fields,
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Authorization: Bearer '.$token,
			    'Cookie: cookie_check=yes'
			  ),
			));

			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

			$response = curl_exec($curl);

			curl_close($curl);
			
			$response = json_decode($response);
			return $response;

		}

	}

	/*=============================================
	Peticiones a la API de DLOCAL
	=============================================*/	

	static public function dlocal($url, $method, $fields){

		$endpoint = "https://api-sbx.dlocalgo.com/"; //TEST
		$apiKey = "HylkxObOUwYgwNYIDQALFyTMwJdUsSQC"; //TEST
		$secretKey = "iR265jyVGVtxwWEukUA1IgJMp7bJm6YGEkMnICy0"; //TEST


		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $endpoint.$url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_POSTFIELDS => $fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$apiKey.':'.$secretKey
		  ),
		));

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($curl);

		curl_close($curl);
		
		$response = json_decode($response);
		return $response;

	}

	/*=============================================
	Peticiones a la API de MERCADO PAGO
	=============================================*/	

	static public function mercadoPago($url, $method, $fields){

		$endpoint = "https://api.mercadopago.com/"; //TEST Y LIVE
		$accessToken = "..."; //TEST

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $endpoint.$url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_POSTFIELDS => $fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$accessToken
		  ),
		));

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($curl);

		curl_close($curl);
		
		$response = json_decode($response);
		return $response;

	}

	/*=============================================
	API GEOPLUGIN
	=============================================*/	

	static public function apiGeoplugin($ip){

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://www.geoplugin.net/json.gp?ip='.$ip,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$response = json_decode($response);
		return $response;

	}


}