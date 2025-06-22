<link rel="stylesheet" href="<?php echo $path ?>views/assets/css/product/product.css">

<!--==========================================
Breadcrumb
===========================================-->

<div class="container-fluid bg-light border mb-2">
  
  <div class="container py-3">
    
    <div class="d-flex flex-row-reverse lead small">
      
      <div class="px-1 font-weight-bold">Carrito de Compras</div>
      <div class="px-1">/</div>
      <div class="px-1"><a href="/">Inicio</a></div>

    </div>

  </div>

</div>

<!--==========================================
Carrito de compras
===========================================-->

<div class="container my-4">
  
  <div class="card">
    
    <div class="card-header bg-light">

      <div class="row">
        
        <div class="d-none d-lg-block col-lg-5 text-center">PRODUCTO</div>
        <div class="d-none d-lg-block col-lg-2 text-center">CANTIDAD</div>
        <div class="d-none d-lg-block col-lg-2 text-center">PRECIO</div>
        <div class="d-none d-lg-block col-lg-2 text-center">SUBTOTAL</div>
        <div class="d-none d-lg-block col-lg-1 text-center"></div>

      </div>

    </div>

    <?php if (!empty($carts)): $totalCart = 0 ?>

      <div class="card-body" id="bodyCart">
        
        <?php foreach ($carts as $key => $value): ?>

          <?php if ($key > 0): ?>
               
               <hr class="d-block d-lg-none my-4 mx-auto w-75 hr_<?php echo $key ?>" style="border:1px solid #aaa">

            <?php endif ?>

          <div class="row py-1" style="position:relative;">

            <!--==========================================
            PRODUCTO
            ===========================================-->
            
            <div class="col-12 col-lg-5 text-left">

              <a href="/<?php echo $value->url_product ?>">
              
              <div class="media">

                  <figure class="imgProduct">

                    <?php if ($value->type_variant == "gallery"): ?>

                        <img src="<?php echo $path ?>views/assets/img/products/<?php echo $value->url_product ?>/<?php echo json_decode($value->media_variant)[0] ?>" class="img-thumbnail mr-3" style="width:80px">

                      <?php else: $arrayYT = explode("/", $value->media_variant) ?>

                        <img src="http://img.youtube.com/vi/<?php echo end($arrayYT) ?>/maxresdefault.jpg" class="img-thumbnail mr-3" style="width:80px">
                        
                      <?php endif ?>

                  </figure>

                   <div class="media-body">

                    <p class="m-0 font-weight-bold"><?php echo $value->name_product ?> </p>
                    <small class="m-0"><?php echo $value->description_variant ?></small>

                   </div>

                </div>

              </a>

            </div>

            <!--==========================================
            CANTIDAD
            ===========================================-->
            <div class="col-12 col-lg-2 text-left">

              <?php if ($value->type_variant == "gallery"): ?>
              
                <div class="blockQuantity d-flex justify-content-center"> 

                  <div class="input-group mb-3 mt-2" style="width:130px">

                    <span class="input-group-text btnInc" type="btnMin" key="<?php echo $key ?>" idCart="<?php echo $value->id_cart ?>">
                      <i class="fas fa-minus"></i>
                    </span>

                    <input type="number" class="form-control text-center showQuantity_<?php echo $key ?> showQuantity" onwheel="return false;" value="<?php echo $value->quantity_cart ?>">

                    <span class="input-group-text btnInc" type="btnMax"  key="<?php echo $key ?>" idCart="<?php echo $value->id_cart ?>">
                      <i class="fas fa-plus"></i>
                    </span>

                  </div>

                </div>

              <?php else: ?>

                <input type="hidden" class="form-control text-center showQuantity" value="<?php echo $value->quantity_cart ?>">

              <?php endif ?>

            </div>

             <!--==========================================
            PRECIO
            ===========================================-->
            <div class="col-6 col-lg-2 text-center mt-3">
               
               <?php if ($value->type_variant == "gallery"): ?>
                  
                  <span class="d-block d-lg-none">Precio:</span>
                 
                  $<span class="priceCart_<?php echo $key ?>">
                  <?php

                  if ($value->offer_variant>0) {
                    echo number_format($value->offer_variant,2);
                  }else{
                    echo number_format($value->price_variant,2); 
                  }
                  ?>  
                  </span> 

                <?php endif ?>

            </div>

             <!--==========================================
            SUBTOTAL
            ===========================================-->

            <div class="col-6 col-lg-2 text-center mt-3">
              
              <span class="d-block d-lg-none">Subtotal:</span>
              $<span class="subtotalCart_<?php echo $key ?> subtotalCart">
              
              <?php 

                if ($value->offer_variant>0) {
                  echo number_format(($value->quantity_cart*$value->offer_variant),2);
                }else{
                  echo number_format(($value->quantity_cart*$value->price_variant),2); 
                }           

              ?>  

              </span>

            </div>

             <!--==========================================
            QUITAR ELEMENTOS
            ===========================================-->

            <div class="d-none d-lg-block col-lg-1 text-center mt-3">
              
              <button class="btn btn-light btn-sm border remCart" key="<?php echo $key ?>" idCart="<?php echo $value->id_cart ?>"><i class="fas fa-times"></i></button>

            </div>

            <div class="d-block d-lg-none">
              
              <button class="btn btn-light btn-sm border remCart" key="<?php echo $key ?>" idCart="<?php echo $value->id_cart ?>" style="position:absolute; top:0px; right:0px"><i class="fas fa-times"></i></button>

            </div>
 
          </div>

          <?php 

          if ($value->offer_variant>0) {

            $totalCart += $value->quantity_cart*$value->offer_variant;

          }else{

            $totalCart += $value->quantity_cart*$value->price_variant;

          }

          ?>
   
        <?php endforeach ?>

      </div>

      <!--==========================================
      TOTAL
      ===========================================-->

      <div class="card-footer bg-light">
        
        <div class="row">
          
            <div class="col-3 col-lg-9 text-right font-weight-bold">TOTAL:</div>
            <div class="col-3 col-lg-2 text-center font-weight-bold">
              $<span class="totalCart"><?php echo number_format($totalCart,2)  ?></span>
            </div>
            <div class="col-6 col-lg-1 text-center">
              <a href="/checkout" class="btn btn-default templateColor border-0 px-3 pulseAnimation">Pagar</a>
            </div>

        </div>

      </div>

    <?php else: ?>

      <div class="card-body ">
        <?php include "views/pages/no-found/no-found.php" ?>
      </div>
      
    <?php endif ?>

  </div>


</div>

<script src="<?php echo $path ?>views/assets/js/carts/carts.js"></script>
