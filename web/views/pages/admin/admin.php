<link rel="stylesheet" href="<?php echo $path ?>views/assets/css/admin/admin.css">

<?php 

if (!isset($_SESSION["admin"])){

  include "login/login.php";

}else{

  /*=============================================
  validar si el token está expirado
  =============================================*/

  date_default_timezone_set("America/Bogota");

  $url = "admins?id=".$_SESSION["admin"]->id_admin."&nameId=id_admin&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
  $method = "PUT";
  $fields = "date_updated_admin=".date("Y-m-d G:i:s");

  $update = CurlController::request($url, $method, $fields);

  if($update->status == 303){

    session_destroy();

    echo '<script>

      window.location = "/admin";

    </script>';

    return;

  }

  /*=============================================
  Lista blanca de url permitidas en el dashboard
  =============================================*/

  if(!empty($routesArray[1])){

    if($routesArray[1] == "administradores" ||
      $routesArray[1] == "plantillas" ||
      $routesArray[1] == "redes-sociales" ||
      $routesArray[1] == "slides" ||
      $routesArray[1] == "banners" || 
      $routesArray[1] == "categorias" ||
      $routesArray[1] == "subcategorias" ||
      $routesArray[1] == "productos" ||
      $routesArray[1] == "pedidos" ||
      $routesArray[1] == "informes" ||
      $routesArray[1] == "clientes"){

      include $routesArray[1]."/".$routesArray[1].".php";

    }else{

      echo '<script>
         window.location = "'.$path.'404";
      </script>';
      
    }


  }else{

     include "tablero/tablero.php";

  }

}

?>

<script src="<?php echo $path ?>views/assets/js/forms/forms.js"></script>
<script src="<?php echo $path ?>views/assets/js/tables/tables.js"></script>
  