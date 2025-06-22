<div class="card bg-white">
	
	<?php if (!empty($carts)): $totalCart = 0; ?>

		<div class="card-body">
			
			<?php foreach ($carts as $key => $value): ?>

				 <div class="row" style="position:relative;">

		            <!--==========================================
		            PRODUCTO
		            ===========================================-->
		            
		            <div class="col-12 col-lg-8 text-left">

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
		                    <small class="m-0"><?php echo $value->quantity_cart ?></small>

		                   </div>

		                </div>

		              </a>

		            </div>

		            <!--==========================================
		            SUBTOTAL
		            ===========================================-->

		            <div class="col-6 col-lg-4 text-center mt-3">
		              
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

		            <?php if ($key < count($carts)-1): ?>

	                    <hr class="mt-3  px-0" style="border:1px solid #ccc">

	                <?php endif ?> 
		 
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
	          
	            <div class="col-3 col-lg-8 text-right font-weight-bold">TOTAL:</div>
	            <div class="col-3 col-lg-4 text-center font-weight-bold">
	              $<span class="totalCart"><?php echo number_format($totalCart,2)  ?></span>
	            </div>
	           
	        </div>

	    </div>


	<?php endif ?>	


</div>