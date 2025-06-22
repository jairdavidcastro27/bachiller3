<?php 

/*=============================================
Pedidos
=============================================*/

$select = "id_order";
$url = "orders?linkTo=process_order&equalTo=0&select=".$select;
$method = "GET";
$fields = array();

$orders = CurlController::request($url,$method,$fields);

if($orders->status == 200){

  $orders = $orders->total;

}else{

  $orders = 0;

}

 ?>


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
      <img src="<?php echo $path ?>views/assets/img/template/<?php echo $template->id_template ?>/<?php echo $template->icon_template ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Administradores</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $path ?>views/assets/img/adminlte/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["admin"]->name_admin ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <?php if ($_SESSION["admin"]->rol_admin == "admin"): ?>

            <li class="nav-item">
              <a href="/admin/administradores" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "administradores"): ?> active <?php endif ?>">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>
                  Administradores
                </p>
              </a>
            </li>

            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  General
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/admin/plantillas" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "plantillas"): ?> active <?php endif ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Plantillas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/admin/redes-sociales" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "redes-sociales"): ?> active <?php endif ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Redes Sociales</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php endif ?>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Promoción
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/slides" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "slides"): ?> active <?php endif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Slides</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/banners" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "banners"): ?> active <?php endif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banners</p>
                </a>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Inventario
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/categorias" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "categorias"): ?> active <?php endif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorías</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/subcategorias" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "subcategorias"): ?> active <?php endif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subcategorías</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/productos" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "productos"): ?> active <?php endif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos</p>
                </a>
              </li>
            </ul>
          </li>

          <?php if ($_SESSION["admin"]->rol_admin == "admin"): ?>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-funnel-dollar"></i>
                <p>
                 Ventas
                  <i class="right fas fa-angle-left"></i>
                  <span class="right badge badge-warning mr-1"><?php echo $orders ?></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/admin/pedidos" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "pedidos"): ?> active <?php endif ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pedidos</p>
                    <span class="right badge badge-success"><?php echo $orders ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/admin/informes" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "informes"): ?> active <?php endif ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Informes</p>
                  </a>
                <li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="/admin/clientes" class="nav-link <?php if (!empty($routesArray[1]) && $routesArray[1] == "clientes"): ?> active <?php endif ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Clientes
                  
                </p>
              </a>
            </li>

          <?php endif ?> 

          <li class="nav-item">
            <a href="/views/pages/cashbox.php" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>Caja</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/views/pages/credit_note.php" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Nota de Crédito</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/views/pages/providers_list.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>Proveedores</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/salir" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Salir
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>