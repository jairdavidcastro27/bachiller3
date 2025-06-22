<?php 

if (!isset($_SESSION["user"])){

	echo '<script>
     window.location = "'.$path.'404";
  </script>';

}else{

	if(isset($routesArray[1])){

		$url = "relations?rel=orders,products,variants&type=order,product,variant&linkTo=url_product,id_user_order&equalTo=".$routesArray[1].",".$_SESSION["user"]->id_user;
		$method = "GET";
    	$fields = array();

    	$course = CurlController::request($url, $method, $fields);

    	 if($course->status != 200){

    	 	echo '<script>
		     window.location = "'.$path.'404";
		  </script>';

    	 }else{

    	 	$course = $course->results[0];
    	 	
    	 }

	}else{

	echo '<script>
	     window.location = "'.$path.'404";
	  </script>';

	}

}


?>

<!--==========================================
Breadcrumb
===========================================-->

<div class="container-fluid bg-light border mb-2">
  
  <div class="container py-3">

    <div class="d-flex flex-row-reverse lead small">

      <div class="px-1 font-weight-bold"><?php echo $course->description_variant ?></div>
      <div class="px-1">/</div> 
      <div class="px-1 font-weight-bold">Cursos</div>
      <div class="px-1">/</div>
      <div class="px-1"><a href="/">Inicio</a></div>

    </div>

  </div>

</div>

<!--==========================================
Contenido
===========================================-->

<div class="container-fluid">
	
	<?php include "modules/content.php" ?>
	
</div>

