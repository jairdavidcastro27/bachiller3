<?php 

$ip = $_SERVER["HTTP_X_REAL_IP"] ?? $_SERVER["REMOTE_ADDR"] ?? '127.0.0.1';
$data = CurlController::apiGeoplugin($ip);
// echo '<pre>'; print_r($data); echo '</pre>';

if($data->geoplugin_status == 200){

	$ip_visit = $ip;
	$country_visit = $data->geoplugin_countryName;
	$region_visit = $data->geoplugin_regionName;
	$city_visit = $data->geoplugin_city;
	$date_created_visit = date("Y-m-d");

	/*=============================================
	PREGUNTAMOS PRIMERO SI LA IP EXISTE EN ESA FECHA
	=============================================*/

	$url = "visits?linkTo=ip_visit,date_created_visit&equalTo=".$ip_visit.",".$date_created_visit;
	$method = "GET";
	$fields = array();

	$visit = CurlController::request($url,$method,$fields);

	if($visit->status == 404){

		$url = "visits?token=no&except=ip_visit";
		$method = "POST";
		$fields = array(
			"ip_visit" => $ip_visit,
			"country_visit" => $country_visit,
			"region_visit" => $region_visit,
			"city_visit" => $city_visit,
			"date_created_visit" => $date_created_visit
		);

		$newVisit = CurlController::request($url,$method,$fields);

	}

}

/*=============================================
TRAER VISITAS
=============================================*/
$totalVisits = 0;

$url = "visits";
$method = "GET";
$fields = array();

$visits = CurlController::request($url,$method,$fields);

$countries = array();
$jsonCountries = []; 

if($visits->status == 200){

	$totalVisits = $visits->total;

	$visits = $visits->results;

	foreach ($visits as $key => $value) {

		array_push($countries, $value->country_visit);
		
	}

	$countries = array_unique($countries);

	foreach ($countries as $key => $value) {
	    if (!isset($jsonCountries[$value])) {
	        $jsonCountries[$value] = 0;
	    }
	    foreach ($visits as $index => $item) {
	        if ($value == $item->country_visit) {
	            $jsonCountries[$value] += 1;
	        }
	    }
	}
}


?>

<?php if (!empty($countries)): ?>

<div class="container-fluid bg-light border" id="topVisit">

	<div class="container clearfix">
		
		<div class="btn-group float-end p-2">

			<p class="pt-3 lead">Tu eres nuestro visitante #<?php echo $totalVisits?></p>
			
		</div>		

	</div>

</div>

<div class="container py-3 pb-5">
	
	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-6">

		<?php $count = 0; foreach ($jsonCountries as $key => $value): $count++ ?>

			<?php if ($count < 7): ?>
				
				<?php $rand = rand(10,99) ?>
			
				<div class="col text-center">
					
					<h3 class="py-3 text-muted"><?php echo $key ?></h3>

					<input type="text" class="knob" value="<?php echo ceil($value*100/($totalVisits)) ?>" data-width="90" data-height="90" data-fgColor="#0<?php echo $rand ?>">
					<div class="knob-label"><?php echo ceil($value*100/($totalVisits)) ?>% de las visitas</div>
				</div>

			<?php endif ?>

		<?php endforeach ?>


	</div>



</div>

<?php endif ?>





<script src="<?php echo $path ?>views/assets/js/visits/visits.js"></script>