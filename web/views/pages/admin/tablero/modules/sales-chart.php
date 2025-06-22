<?php 

  /*=============================================
  Gráfico de ventas
  =============================================*/

  $select = "price_order,start_date_order";

  $url = "orders?linkTo=start_date_order&between1=".$between1."&between2=".$between2."&filterTo=process_order&inTo=2&select=".$select."&orderBy=start_date_order&orderMode=ASC";
  $method = "GET";
  $fields = array(); 

  $sales = CurlController::request($url, $method, $fields);

  if( $sales->status == 200){

    $sales = $sales->results;
   
  }else{

    $sales = array();
   
  
  }

  $totals = 0;
  $arrayDate = array();
  $sumViews = array();

  foreach ($sales as $key => $value){

      $totals+=$value->price_order;
  
      //Capturamos año y mes
      $date = substr($value->start_date_order, 0, 7);
      // echo '<pre>'; print_r($date); echo '</pre>';

      //Introducir fechas en un nuevo array
      array_push($arrayDate, $date);
     // echo '<pre>'; print_r($arrayDate); echo '</pre>';
     
      //Capturar las vistas que ocurrieron en dichas fechas
      $arraySales = array($date => $value->price_order);
      // echo '<pre>'; print_r($arraySales); echo '</pre>';
     
    
      //Sumamos los pagos que ocurrieron el mismo mes
      foreach ($arraySales  as $index => $item) {

          $sumSales[$index] += $item;
           
      }

  }

  // echo '<pre>'; print_r($sumSales); echo '</pre>';

  //Agrupar las fechas en un nuevo arreglo para que no se repitan
  $dateNoRepeat = array_unique($arrayDate);
  // echo '<pre>'; print_r($dateNoRepeat); echo '</pre>';


?>

<div class="container">
  <div class="card border-0 shadow-none">
    <div class="card-header border-0">
      <div class="d-flex justify-content-between">
        
        <h3 class="card-title">Gráfico de ventas
          
          <br> <span class="small"><?php if (isset($_GET["from"]) && isset($_GET["untill"])){ echo "Entre el ".date("d/m/Y", strtotime($between1)) ?> y <?php echo date("d/m/Y", strtotime($between2));}else{ echo "Histórico total";}  ?></span>
        </h3>

        <?php if (isset($_GET["from"]) && isset($_GET["untill"])): ?>
          <a href="/admin/informes?start=<?php echo $_GET["from"] ?>&end=<?php echo $_GET["untill"] ?>">Ver Reporte</a>
      <?php else: ?>
          <a href="/admin/informes">Ver Reporte</a>
        <?php endif ?>
        
      </div>
    </div>

  </div>
<div class="card-body p-0">

    <div class="d-flex">

      <p class="d-flex flex-column px-3">

        <span class="text-bold text-lg">$ <?php echo number_format($totals,2) ?> Ventas</span>
       
      </p>
     
    </div>
    <!-- /.d-flex -->

    <?php if (count($sales)>0): ?>

      <div class="position-relative mb-5 px-3">

        <canvas id="sales-chart" height="200"></canvas>

      </div>

    <?php else: ?>

      <div class="card-footer border-top mb-5">

        <div class="text-center">No hay ventas en este rango de tiempo</div>

      </div>

    <?php endif ?>    

  </div>

</div>
        

<!-- /.card -->

<script>



  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  if($('#sales-chart').length > 0){

    var $visitorsChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var visitorsChart = new Chart($visitorsChart, {
      data: {
        labels: [

          <?php 

              foreach ($dateNoRepeat as $key => $value) {
                  
                  echo "'".$value."',";
              }


          ?>

        ],
        datasets: [{
          cubicInterpolationMode: 'monotone',
          type: 'line',
          backgroundColor: '#a5b3c9',
          borderColor: '#a5b3c9',
          data: [

            <?php

                foreach($dateNoRepeat as $key => $value){

                    echo "'".$sumSales[$value]."',";

                }

            ?>

          ],
          backgroundColor: '#e7e9f0',
          borderColor: '#a5b3c9',
          pointBorderColor: '#a5b3c9',
          pointBackgroundColor: '#a5b3c9',
          fill: true,
          pointHoverBackgroundColor: '#a5b3c9',
          pointHoverBorderColor    : '#a5b3c9',
        }]
      },
      options: {
        elements:{
          line:{
            tension: 0.4
          }
        },
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              // suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: true
            },
            ticks: ticksStyle
          }]
        }
      }
    })

  }

</script>



