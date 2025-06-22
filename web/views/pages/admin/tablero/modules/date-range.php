<?php 



  error_reporting(0);

  date_default_timezone_set("America/Bogota");
  /*=============================================
  Definir rnago de fechas
  =============================================*/

  if(isset($_GET["from"]) && isset($_GET["untill"])){
    
    $between1 = date("Y-m-d", strtotime($_GET["from"]));
    $between2 = date("Y-m-d", strtotime($_GET["untill"]));

    /*=============================================
    Calcular diferencia de dias para DateRangePicker
    =============================================*/ 

    $date1 = new DateTime($routesArray[4]);
    $date2 = new DateTime($routesArray[5]);
    $date3 = new DateTime(date("Y-m-d"));
    
    $diff1 = $date1->diff($date3);
    $diff2 = $date2->diff($date3);

  }else{

    $between1 = date("Y-m-d", strtotime("-30 year", strtotime(date("Y-m-d"))));
    $between2 = date("Y-m-d");

  }

 ?>



<div class="container">

  <div class="card mt-1 mb-4">
  
    <div class="card-header">
      
      <!-- card tools -->
        <h3 class="card-title mt-1 mr-2">
          Selecciona rango de fecha
        </h3>
        
        <button type="button" class="btn btn-light border btn-sm daterange" title="Date range">
          <i class="far fa-calendar-alt"></i>
        </button>

        <div class="card-tools mt-1">
          <span class="small">Rango actual: <?php if (isset($_GET["from"]) && isset($_GET["untill"])){ echo "Entre el ".date("d/m/Y", strtotime($between1)) ?> y <?php echo date("d/m/Y", strtotime($between2));}else{ echo "Histórico total";}  ?></span>
        </div>
        

      <!-- /.card-tools -->
    </div>

  </div>

</div>



<script>

    moment.locale('es');

   $('.daterange').daterangepicker({
    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Rango Personalizado",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    ranges: {
      'Hoy': [moment(), moment()],
      'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este Mes': [moment().startOf('month'), moment().endOf('month')],
      'Último Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'Este Año': [moment().startOf('year'), moment().endOf('year')],
      'Último Año': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    },
    <?php if (isset($diff1) && isset($diff2)): ?>

    startDate: moment().subtract(<?php echo $diff1->days ?>, 'days'),
    endDate: moment().subtract(<?php if($diff2->invert > 0){echo -$diff2->days;}else{echo $diff2->days;} ?>, 'days'), 
    
    <?php else: ?>
    
    startDate: moment().subtract(29, 'days'),
    endDate: moment() 
    
    <?php endif ?>
    
  }, function (start, end) {


     window.location = '/admin?from='+start.format('YYYY-MM-DD')+'&untill='+end.format('YYYY-MM-DD');

  })
    

</script>