<div class="content-wrapper" style="min-height: 1504.06px;">
    <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"> <small>Productos</small></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin">Tablero</a></li>
            <li class="breadcrumb-item">Inventario</li>
            <li class="breadcrumb-item active">Productos</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <?php 

    if(!empty($routesArray[2])){

      if($routesArray[2] == "gestion"){

         include "modules/".$routesArray[2].".php";

      }else if($routesArray[2] == "productos_proveedores"){
        include "modules/../productos_proveedores.php";
      }else if($routesArray[2] == "productos_proveedores_precios"){
        include "modules/../productos_proveedores_precios.php";
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