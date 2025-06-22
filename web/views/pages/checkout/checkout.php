<?php 

if (!isset($_SESSION["user"])){

  echo '<script>
     window.location = "'.$path.'404";
  </script>';

}else{

  if(empty($carts)){

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
      
      <div class="px-1 font-weight-bold">Checkout</div>
      <div class="px-1">/</div>
      <div class="px-1"><a href="/">Inicio</a></div>

    </div>

  </div>

</div>

<!--==========================================
Checkout
===========================================-->

<div class="container my-4">
  
  <div class="card">

    <div class="card-body bg-light">    

      <form method="post" class="needs-validation" novalidate>
        
        <div class="row row-cols-1 row-cols-lg-2">

          <div class="col">
            
            <?php include "modules/datos.php" ?>

          </div>

          <div class="col">

            <?php include "modules/carrito.php" ?>
            <?php include "modules/pasarelas.php" ?>
            
          </div>

        </div>

      </form>

    </div>

  </div>


</div>

<script>

  /*=============================================
  Evento Facebook
  =============================================*/

  fbq("track", "InitiateCheckout");
    
</script>