<?php 

	/*=============================================
	Total Ventas
	=============================================*/

	$totalSales = 0;
	$select = "price_order";

	$url = "orders?linkTo=process_order&equalTo=2&select=".$select;
	$method = "GET";
	$fields = array();
	
	$sales = CurlController::request($url, $method, $fields);

	if(	$sales->status == 200){

			$sales = $sales->results;

			foreach ($sales as $key => $value) {
				
				$totalSales += $value->price_order;
			
			}

	}else{

		$totalSales = 0;
	
	
	}


	/*=============================================
	Total Productos
	=============================================*/

	$select = "id_product";

	$url = "products?select=".$select;
	$totalProducts = CurlController::request($url, $method, $fields);

	if($totalProducts->status == 200){

		$totalProducts = $totalProducts->total;

	}else{

		$totalProducts = 0;
	
	
	}


	/*=============================================
	Total Usuarios
	=============================================*/

	$select = "id_user";

	$url = "users?select=".$select;
	$totalUsers = CurlController::request($url, $method, $fields);

	if($totalUsers->status == 200){

		$totalUsers = $totalUsers->total;

	}else{

		$totalUsers = 0;
	
	}

	/*=============================================
	Total Visitas
	=============================================*/

	$select = "id_visit";

	$url = "visits?select=".$select;
	$totalVisits = CurlController::request($url, $method, $fields);

	if($totalVisits->status == 200){

		$totalVisits = $totalVisits->total;

	}else{

		$totalVisits = 0;
	
	
	}


?>

<div class="container">

	<div class="row">
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-lightblue">
	      <div class="inner">
	        <h3 class="bg-lightblue disabled">$ <?php echo number_format($totalSales,2) ?></h3>

	        <p>Ventas</p>
	      </div>
	      <div class="icon">
	        <i class="fas fa-dollar-sign"></i>
	      </div>
	      <a href="/admin/informes" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-purple text-white">
	      <div class="inner">
	        <h3 class="bg-purple disabled"><?php echo $totalProducts ?></h3>

	        <p>Productos</p>
	      </div>
	      <div class="icon">
	        <i class="fas fa-shopping-bag"></i>
	      </div>
	      <a href="/admin/productos" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-warning">
	      <div class="inner">
	        <h3 class="bg-warning disabled"><?php echo $totalUsers?></h3>

	        <p>Usuarios</p>
	      </div>
	      <div class="icon">
	        <i class="fas fa-users"></i>
	      </div>
	      <a href="/admin/clientes" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-gray-dark text-white">
	      <div class="inner">
	        <h3 class="bg-gray-dark disabled"><?php echo $totalVisits ?></h3>

	        <p>Visitas</p>
	      </div>
	      <div class="icon">
	        <i class="fas fa-map-marker-alt"></i>
	      </div>
	      <a href="/#topVisit" target="_blank" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	</div>

</div>