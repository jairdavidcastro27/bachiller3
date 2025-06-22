<?php

require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";

class DatatableController{

	public function data(){

		if(!empty($_POST)){

			/*=============================================
            Capturando y organizando las variables POST de DT
            =============================================*/

			$draw = $_POST["draw"]; 

			$orderByColumnIndex = $_POST["order"][0]["column"];

			$orderBy = $_POST["columns"][$orderByColumnIndex]["data"];

			$orderType = $_POST["order"][0]["dir"]; 

			$start = $_POST["start"];

			$length = $_POST["length"];

			/*=============================================
            El total de registros de la data
            =============================================*/

            $url = "users?linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&select=id_user";
     
            $method = "GET";
            $fields = array();

            $response = CurlController::request($url, $method, $fields);

            if($response->status == 200){

            	$totalData = $response->total;
            
            }else{

            	echo '{
            		"Draw": 1,
					"recordsTotal": 0,
				    "recordsFiltered": 0,
				    "data":[]}';

            	return;

            }

        
            $select = "*";

            /*=============================================
           	Búsqueda de datos
            =============================================*/	

            if(!empty($_POST['search']['value'])){	

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

            		$linkTo = ["name_user","email_user","country_user","department_user","city_user","address_user","phone_user","date_updated_user"];

            		$search = str_replace(" ","_",$_POST['search']['value']);

            		foreach ($linkTo as $key => $value) {
            			
            			$url = "users?select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

	            		$data = CurlController::request($url, $method, $fields)->results;

	            		if($data == "Not Found"){

	            			$data = array();
	            			$recordsFiltered = 0;
	            		
	            		}else{

	            			$recordsFiltered = count($data);
	            			break;
	            		}
            		}

            	}else{

            		echo '{
            		"Draw": 1,
					"recordsTotal": 0,
				    "recordsFiltered": 0,
				    "data":[]}';

                	return;

            	}

            }else{

	            /*=============================================
	            Seleccionar datos
	            =============================================*/

	            $url = "users?linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&select=".$select."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
	            $data = CurlController::request($url, $method, $fields)->results;

	            $recordsFiltered = $totalData;

	        }
           
            /*=============================================
            Cuando la data viene vacía
            =============================================*/

             if(empty($data)){

            	echo '{
            		"Draw": 1,
					"recordsTotal": 0,
				    "recordsFiltered": 0,
				    "data":[]}';

            	return;

            }

            /*=============================================
            Construimos el dato JSON a regresar
            =============================================*/

            $dataJson = '{
				"Draw": '.intval($draw).',
				"recordsTotal": '.$totalData.',
				"recordsFiltered": '.$recordsFiltered.',
				"data": [';

				foreach ($data as $key => $value) {
	
						$name_user = $value->name_user;
						$email_user = $value->email_user;
						$method_user = $value->method_user;
						$country_user = $value->country_user;
						$department_user = $value->department_user;
						$city_user = $value->city_user;
						$address_user = $value->address_user;
						$phone_user = $value->phone_user;
						$date_updated_user = $value->date_updated_user;

					$dataJson.='{ 

						"id_user":"'.($start+$key+1).'",
						"name_user":"'.$name_user.'",
						"email_user":"'.$email_user.'",
						"method_user":"'.$method_user.'",
						"country_user":"'.$country_user.'",
						"department_user":"'.$department_user.'",
						"city_user":"'.$city_user.'",
						"address_user":"'.$address_user.'",
						"phone_user":"'.$phone_user.'",
						"date_updated_user":"'.$date_updated_user.'"
					},';
				}

			$dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

			$dataJson .= ']}';

			echo $dataJson;

		}

	}

}

/*=============================================
Activar función DataTable
=============================================*/ 

$data = new DatatableController();
$data -> data();