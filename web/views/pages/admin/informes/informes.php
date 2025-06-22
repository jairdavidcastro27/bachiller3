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
            <h1 class="m-0"> <small>Informes</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Tablero</a></li>
              <li class="breadcrumb-item">Ventas</li>
              <li class="breadcrumb-item active">Informes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php 

    include "modules/listado.php";

    ?>
  </div>