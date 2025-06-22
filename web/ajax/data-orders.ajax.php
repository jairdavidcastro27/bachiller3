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

            $url = "relations?rel=orders,users,products,variants&type=order,user,product,variant&select=id_order";
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

            $select = "type_variant,process_order,url_product,image_product,media_variant,name_product,description_variant,quantity_order,price_order,name_user,ref_order,method_order,number_order,track_order,start_date_order,medium_date_order,end_date_order,id_order,uniqid_order";

            /*=============================================
           	Búsqueda de datos
            =============================================*/	

            if(!empty($_POST['search']['value'])){	

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

            		$linkTo = ["name_product","description_variant","price_order","name_user","uniqid_order","method_order","number_order","track_order"];

            		$search = str_replace(" ","_",$_POST['search']['value']);

            		foreach ($linkTo as $key => $value) {
            			
            			$url = "relations?rel=orders,users,products,variants&type=order,user,product,variant&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "relations?rel=orders,users,products,variants&type=order,user,product,variant&select=".$select."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
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

					if($value->type_variant == "gallery"){

						if($value->process_order == 0){

							$process_order = "<span class='badge badge-warning rounded-pill px-3 py-1'>Pendiente</span>";
						
						}

						if($value->process_order == 1){

							$process_order = "<span class='badge badge-primary rounded-pill px-3 py-1'>En Proceso</span>";
						
						}

						if($value->process_order == 2){

							$process_order = "<span class='badge badge-success rounded-pill px-3 py-1'>Entregado</span>";
						
						}

						if($value->process_order == 3){

							$process_order = "<span class='badge badge-dark bg-purple rounded-pill px-3 py-1'>Garantía</span>";
						
						}

						if($value->process_order == 4){

							$process_order = "<span class='badge badge-danger rounded-pill px-3 py-1'>Devolución</span>";
						
						}

						$media_variant = "<img src='/views/assets/img/products/".$value->url_product."/".json_decode($value->media_variant)[0]."' class='img-thumbnail rounded' style='width:75px'>";

					}else{

						$process_order = "<span class='badge badge-success rounded-pill px-3 py-1'>Entregado</span>";
						$media_variant = "<img src='/views/assets/img/products/".$value->url_product."/".$value->image_product."' class='img-thumbnail rounded' style='width:75px'>"; 
					}

					
					$name_product = $value->name_product." - ".$value->description_variant;
					$quantity_order = $value->quantity_order;
					$price_order = "<span>$".number_format($value->price_order,2)."</span>";
					$name_user = $value->name_user;
					$uniqid_order = "<span class='badge badge-default bg-white border rounded-pill text-dark px-3 py-1'>".$value->uniqid_order."</span>";
					$method_order = "<p class='text-uppercase'>".$value->method_order."</p>";
					$number_order = $value->number_order;
					$track_order =  $value->track_order;
					$dates = "<span class='badge badge-warning rounded-pill px-3 py-1'>".$value->start_date_order."</span>
							  <span class='badge badge-primary rounded-pill px-3 py-1'>".$value->medium_date_order."</span>
							  <span class='badge badge-success rounded-pill px-3 py-1'>".$value->end_date_order."</span>";
					$dates = TemplateController::htmlClean($dates);

					$actions = "<button type='button' class='btn bg-purple border-0 rounded-pill mr-2 btn-sm px-3 modalEditOrder' idOrder='".base64_encode($value->id_order)."' processOrder='".$value->process_order."' trackOrder='".$value->track_order."' startOrder='".$value->start_date_order."' mediumOrder='".$value->medium_date_order."' endOrder='".$value->end_date_order."'>
								<i class='fas fa-pencil-alt text-white'></i>
						</button>";

					$actions = TemplateController::htmlClean($actions);

					$dataJson.='{ 

						"id_order":"'.($start+$key+1).'",
					     "process_order":"'.$process_order.'",
					     "media_variant":"'.$media_variant.'",
					     "name_product":"'.$name_product.'",
					     "quantity_order":"'.$quantity_order.'",
					     "price_order":"'.$price_order.'",
					     "name_user":"'.$name_user.'",
					     "uniqid_order":"'.$uniqid_order.'",
					     "method_order":"'.$method_order.'",
					     "number_order":"'.$number_order.'",
					     "track_order":"'.$track_order.'",
					     "dates":"'.$dates.'",
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