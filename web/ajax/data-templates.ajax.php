<?php

require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";

class DatatableController{

	public function data(){

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

        $url = "templates?select=id_template";
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

        $select = "id_template,active_template,logo_template,icon_template,cover_template,title_template,description_template";

        /*=============================================
        Búsqueda de datos
        =============================================*/ 

        if(!empty($_POST['search']['value'])){ 

            if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

               $linkTo = ["title_template","description_template","date_created_template"]; 

               $search = str_replace(" ","_",$_POST['search']['value']);

               foreach ($linkTo as $key => $value) {

                    $url = "templates?select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length; 

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

            $url = "templates?select=".$select."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
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

                if($value->active_template == "ok"){

                    $active_template = "<div class='form-check'>
                                    <input type='radio' class='form-check-input changeTemplate' idItem='".$value->id_template."' id='radio".$key."' name='optradio' value='on' checked><span>ON</span>
                                    <label class='form-check-label' for='radio".$key."'></label>
                                </div>";

                }else{

                    $active_template = "<div class='form-check'>
                                    <input type='radio' class='form-check-input changeTemplate' idItem='".$value->id_template."' id='radio".$key."' name='optradio' value='off' ><span>OFF</span>
                                    <label class='form-check-label' for='radio".$key."'></label>
                                </div>"; 

                }

                $active_template = TemplateController::htmlClean($active_template);

                $logo_template =  "<img src='/views/assets/img/template/".$value->id_template."/".$value->logo_template."' class='img-fluid' style='width:100px'>";
                $icon_template =  "<img src='/views/assets/img/template/".$value->id_template."/".$value->icon_template."' class='img-fluid' style='width:25px'>";
                $cover_template =  "<img src='/views/assets/img/template/".$value->id_template."/".$value->cover_template."' class='img-thumbnail rounded' style='width:100px'>";

                $title_template = $value->title_template;

                $description_template = templateController::reduceText($value->description_template, 25);

                $actions = "<div class='btn-group'>
                        <a href='/admin/plantillas/gestion?template=".base64_encode($value->id_template)."' class='btn bg-purple border-0 rounded-pill mr-2 btn-sm px-3'>
                            <i class='fas fa-pencil-alt text-white'></i>
                        </a>

                        <button class='btn btn-dark border-0 rounded-pill mr-2 btn-sm px-3 deleteItem' rol='admin' table='templates' column='template' idItem='".base64_encode($value->id_template)."'>
                            <i class='fas fa-trash-alt text-white'></i>
                        </button>
                    </div>";

                $actions = TemplateController::htmlClean($actions);

                $dataJson.='{ 
                    "id_template":"'.($start+$key+1).'",
                    "active_template":"'.$active_template.'",
                    "logo_template":"'.$logo_template.'",
                    "icon_template":"'.$icon_template.'",
                    "cover_template":"'.$cover_template.'",
                    "title_template":"'.$title_template.'",
                    "description_template":"'.$description_template.'",
                    "actions":"'.$actions.'"
                },';

            }

        $dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

        $dataJson .= ']}';

        echo $dataJson;

	}
}

/*=============================================
Activar función DataTable
=============================================*/ 

$data = new DatatableController();
$data -> data();