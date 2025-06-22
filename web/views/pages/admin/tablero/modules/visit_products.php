<?php 

/*=============================================
Visualizaciones Artículos
=============================================*/

$select = "*";

$url = "products?linkTo=date_updated_product&between1=".$between1."+00%3A00%3A00&between2=".$between2."+23%3A59%3A59&select=".$select."&orderBy=views_product&orderMode=DESC&startAt=0&endAt=5";
$method = "GET";
$fields = array();


$viewsProducts = CurlController::request($url, $method, $fields);

if($viewsProducts->status == 200){

   $viewsProducts = $viewsProducts->results;

}else{

   $viewsProducts = array();
   

}


?>

<div class="card mb-5">
   <div class="card-header border-0">
      <div class="d-flex justify-content-between">
         <h3 class="card-title">Los Productos más vistos
         <br><span class="small"><?php if (isset($_GET["from"]) && isset($_GET["untill"])){ echo "Entre el ".date("d/m/Y", strtotime($between1)) ?> y <?php echo date("d/m/Y", strtotime($between2));}else{ echo "Histórico Total";}  ?></span>
         </h3>
      </div>
   </div>

   <div class="card-body table-responsive p-0">

     <table class="table table-striped table-valign-middle">
      <thead>
         <tr>
            <th>Productos</th>
            <th>Vistas</th>
            <th>Ver</th>
         </tr>
      </thead>
      <tbody>

         <?php if (count($viewsProducts)>0): ?>


            <?php foreach ($viewsProducts as $key => $value): ?>

               <tr>
                  <td>
                     <div class="media border-0 p-1">
                       <img src="/views/assets/img/products/<?php echo $value->url_product ?>/<?php echo $value->image_product ?>" class="mr-3 img-fluid" style="width:60px;">
                       <div class="media-body">
                         <p><?php echo $value->name_product ?></p>
                       </div>
                     </div>
                  </td>
                  <td><?php echo $value->views_product  ?></td>
                  <td>
                     <a href="/<?php echo $value->url_product ?>" target="_blank" class="text-muted">
                        <i class="fas fa-search"></i>
                     </a>
                  </td>
               </tr>

            <?php endforeach ?>

         </tbody>
      </table>
   </div>

      <?php else: ?>

      </tbody>
      </table>
      </div>

   <div class="card-footer">

      <div class="text-center">No hay productos vistos en este rango de tiempo</div>

   </div>


<?php endif ?>

</div> 

