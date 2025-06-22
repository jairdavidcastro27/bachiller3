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

            $url = "banners?select=id_banner";
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

            $select = "id_banner,location_banner,background_banner,text_banner,discount_banner,status_banner,end_banner";

            /*=============================================
           	Búsqueda de datos
            =============================================*/	

            if(!empty($_POST['search']['value'])){	

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

            		$linkTo = ["end_banner","text_banner","discount_banner","location_banner"];

            		$search = str_replace(" ","_",$_POST['search']['value']);

            		foreach ($linkTo as $key => $value) {
            			
            			$url = "banners?select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "banners?select=".$select."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
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

					/*=============================================
            		STATUS
            		=============================================*/

            		if($value->status_banner == 1){

	            		$status_banner = "<input type='checkbox' data-size='mini' data-bootstrap-switch data-off-color='danger' data-on-color='dark' checked='true' idItem='".base64_encode($value->id_banner)."' table='banners' column='banner'>";

	            	}else{

	            		$status_banner = "<input type='checkbox' data-size='mini' data-bootstrap-switch data-off-color='danger' data-on-color='dark' idItem='".base64_encode($value->id_banner)."' table='banners' column='banner'>";
	            	}

	            	$location_banner = $value->location_banner;

					$background_banner =  "<img src='/views/assets/img/banner/".$value->id_banner."/".$value->background_banner."' class='img-thumbnail rounded' style='width:100px'>";

					$text_banner = $value->text_banner;

					$discount_banner = $value->discount_banner."% OFF";

					$end_banner = TemplateController::formatDate(4,$value->end_banner);
					
            		$actions = "<div class='btn-group'>
									<a href='/admin/banners/gestion?banner=".base64_encode($value->id_banner)."' class='btn bg-purple border-0 rounded-pill mr-2 btn-sm px-3'>
										<i class='fas fa-pencil-alt text-white'></i>
									</a>
									<button class='btn btn-dark border-0 rounded-pill mr-2 btn-sm px-3 deleteItem' rol='admin' table='banners' column='banner' idItem='".base64_encode($value->id_banner)."'>
										<i class='fas fa-trash-alt text-white'></i>
									</button>
								</div>";

					$actions = TemplateController::htmlClean($actions);

					$dataJson.='{ 
						"id_banner":"'.($start+$key+1).'",
						"status_banner":"'.$status_banner.'",
						"location_banner":"'.$location_banner.'",
						"background_banner":"'.$background_banner.'",
						"text_banner":"'.$text_banner.'",
						"discount_banner":"'.$discount_banner.'",
						"end_banner":"'.$end_banner.'",
						"actions":"'.$actions.'"
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