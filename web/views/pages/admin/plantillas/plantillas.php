<?php if ($_SESSION["admin"]->rol_admin == "editor"){
  
  echo '<script>
         window.location = "'.$path.'404";
      </script>';
}

?>


<div class="content-wrapper" style="min-height: 1504.06px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> <small>Plantillas</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Tablero</a></li>
              <li class="breadcrumb-item">General</li>
              <li class="breadcrumb-item active">Plantillas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <?php 

  if(!empty($routesArray[2])){

    if($routesArray[2] == "gestion"){

      include "modules/".$routesArray[2].".php";

    }else{

      echo '<script>
        window.location = "'.$path.'404";
      </script>';
    }

  }else{

    include "modules/listado.php";

  }

  ?>
    <!-- /.content -->
  </div>

 <script src="<?php echo $path ?>views/assets/js/templates/templates.js"></script>