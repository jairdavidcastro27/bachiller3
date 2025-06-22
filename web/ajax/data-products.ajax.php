<?php

require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";

// Conexión directa para proveedores
$conn = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

class DatatableController{

	public function data(){

		if(!empty($_POST)){

			/*=============================================
            Capturando y organizando las variables POST de DT
            =============================================*/

			$draw = $_POST["draw"]; //Contador utilizado por DataTables para garantizar que los retornos de Ajax de las solicitudes de procesamiento del lado del servidor sean dibujados en secuencia por DataTables 
			// echo '<pre>$draw '; print_r($draw); echo '</pre>';

			$orderByColumnIndex = $_POST["order"][0]["column"]; //Índice de la columna de clasificación (0 basado en el índice, es decir, 0 es el primer registro)
			// echo '<pre>$orderByColumnIndex '; print_r($orderByColumnIndex); echo '</pre>';

			$orderBy = $_POST["columns"][$orderByColumnIndex]["data"];//Obtener el nombre de la columna de clasificación de su índice
			// echo '<pre>$orderBy '; print_r($orderBy); echo '</pre>';

			$orderType = $_POST["order"][0]["dir"]; // Obtener el orden ASC o DESC
			// echo '<pre>$orderType '; print_r($orderType); echo '</pre>';

			$start = $_POST["start"];//Indicador de primer registro de paginación.
			// echo '<pre>$start '; print_r($start); echo '</pre>';

			$length = $_POST["length"];//Indicador de la longitud de la paginación.
			// echo '<pre>$length '; print_r($length); echo '</pre>';

			/*=============================================
            El total de registros de la data
            =============================================*/

            $url = "relations?rel=products,subcategories,categories&type=product,subcategory,category&select=id_product";
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

            $select = "id_product,status_product,name_product,url_product,image_product,description_product,keywords_product,name_category,name_subcategory,views_product,date_updated_product";

            /*=============================================
           	Búsqueda de datos
            =============================================*/	

            if(!empty($_POST['search']['value'])){	

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

            		$linkTo = ["name_product", "url_product","description_product","keywords_product","date_updated_product,name_category,name_subcategory"];

            		$search = str_replace(" ","_",$_POST['search']['value']);

            		foreach ($linkTo as $key => $value) {
            			
            			$url = "relations?rel=products,subcategories,categories&type=product,subcategory,category&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "relations?rel=products,subcategories,categories&type=product,subcategory,category&select=".$select."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
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

            		if($value->status_product == 1){

	            		$status_product = "<input type='checkbox' data-size='mini' data-bootstrap-switch data-off-color='danger' data-on-color='dark' checked='true' idItem='".base64_encode($value->id_product)."' table='products' column='product'>";

	            	}else{

	            		$status_product = "<input type='checkbox' data-size='mini' data-bootstrap-switch data-off-color='danger' data-on-color='dark' idItem='".base64_encode($value->id_product)."' table='products' column='product'>";
	            	}

            		/*=============================================
            		TEXTOS
            		=============================================*/

					$name_product = $value->name_product;


					$url_product = "<a href='/".$value->url_product."' target='_blank' class='badge badge-light px-3 py-1 border rounded-pill'>/".$value->url_product."</a>";

					$image_product =  "<img src='/views/assets/img/products/".$value->url_product."/".$value->image_product."' class='img-thumbnail rounded'>";

					$description_product = templateController::reduceText($value->description_product, 25);

					$keywords_product = "";

					$keywordsArray = explode(",",$value->keywords_product);

					foreach ($keywordsArray as $index => $item) {
						
						$keywords_product .= "<span class='badge badge-primary rounded-pill px-3 py-1'>".$item."</span>";
					}

					$name_category = $value->name_category;

					$name_subcategory = $value->name_subcategory;

					$views_product = "<span class='badge badge-warning rounded-pill px-3 py-1'><i class='fas fa-eye'></i> ".$value->views_product."</span>";

            		$date_updated_product = $value->date_updated_product;
					
            		$actions = "<div class='btn-group'>
									<a href='/admin/productos/gestion?product=".base64_encode($value->id_product)."' class='btn bg-purple border-0 rounded-pill mr-2 btn-sm px-3'>
										<i class='fas fa-pencil-alt text-white'></i>
									</a>
									<button class='btn btn-dark border-0 rounded-pill mr-2 btn-sm px-3 deleteItem' rol='admin' table='products' column='product' idItem='".base64_encode($value->id_product)."'>
										<i class='fas fa-trash-alt text-white'></i>
									</button>
								</div>";

					$actions = TemplateController::htmlClean($actions);

					$dataJson.='{ 
                        "id_product":"'.($start+$key+1).'",
                        "status_product":"'.$status_product.'",
                        "name_product":"'.$name_product.'",
                        "url_product":"'.$url_product.'",
                        "image_product":"'.$image_product.'",
                        "description_product":"'.$description_product.'",
                        "keywords_product":"'.$keywords_product.'",
                        "name_category":"'.$name_category.'",
                        "name_subcategory":"'.$name_subcategory.'",
                        "views_product":"'.$views_product.'",
                        "date_updated_product":"'.$date_updated_product.'",
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