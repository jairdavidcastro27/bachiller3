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

            $url = "relations?rel=orders,users,products,variants&type=order,user,product,variant&linkTo=start_date_order&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&select=id_order&filterTo=process_order&inTo=2";
     
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

            $select = "id_order,ref_order,description_variant,quantity_order,price_order,name_user,email_user,country_user,department_user,city_user,method_order,number_order,track_order,start_date_order,end_date_order";

            /*=============================================
           	Búsqueda de datos
            =============================================*/	

            if(!empty($_POST['search']['value'])){	

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

            		$linkTo = ["ref_order","description_variant","quantity_order","price_order","name_user","email_user","country_user","department_user","city_user","method_order","number_order","track_order","start_date_order","end_date_order"];

            		$search = str_replace(" ","_",$_POST['search']['value']);

            		foreach ($linkTo as $key => $value) {
            			
            			$url = "relations?rel=orders,users,products,variants&type=order,user,product,variant&select=".$select."&linkTo=".$value.",process_order&search=".$search.",2&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "relations?rel=orders,users,products,variants&type=order,user,product,variant&linkTo=start_date_order&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&select=".$select."&filterTo=process_order&inTo=2&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
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

						$ref_order = $value->ref_order;
					    $description_variant = $value->description_variant;
						$quantity_order = $value->quantity_order;
						$price_order = number_format($value->price_order,2);
						$name_user = $value->name_user;
						$email_user = $value->email_user;
						$country_user = $value->country_user;
						$department_user = $value->department_user;
						$city_user = $value->city_user;
						$method_order = $value->method_order;
						$number_order = $value->number_order;
						$track_order = $value->track_order;
						$start_date_order = $value->start_date_order;
						$end_date_order = $value->end_date_order;

					$dataJson.='{ 

						"id_order":"'.($start+$key+1).'",
						"ref_order":"'.$ref_order.'",
					    "description_variant":"'.$description_variant.'",
						"quantity_order":"'.$quantity_order.'",
						"price_order":"'.$price_order.'",
						"name_user":"'.$name_user.'",
						"email_user":"'.$email_user.'",
						"country_user":"'.$country_user.'",
						"department_user":"'.$department_user.'",
						"city_user":"'.$city_user.'",
						"method_order":"'.$method_order.'",
						"number_order":"'.$number_order.'",
						"track_order":"'.$track_order.'",
						"start_date_order":"'.$start_date_order.'",
						"end_date_order":"'.$end_date_order.'"
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