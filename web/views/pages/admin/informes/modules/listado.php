<?php 

/*=============================================
Filtros de fechas
=============================================*/

if(isset($_GET["start"]) && isset($_GET["end"])){

	$between1 = $_GET["start"];
  	$between2 = $_GET["end"];

}else{

	$between1 = date("Y-m-d", strtotime("-30 year", strtotime(date("Y-m-d"))));
	$between2 = date("Y-m-d");
}



?>
<input type="hidden" id="page" value="admin/informes">
<div class="content pb-5">
	
	<div class="container">
		
		<div class="card">
			
			<div class="card-header">

				<div class="card-tools d-flex">
					
					<div class="input-group">
						
						<button type="button" class="btn float-right" id="daterange-btn">
							
							<i class="far fa-calendar-alt mr-2"></i> 

							<?php if ($between1 < "2000"): ?>

								Seleccionar Fecha

							<?php else: ?>

								<?php echo $between1 ?> - <?php echo $between2 ?>
								
							<?php endif ?>

							<i class="fas fa-caret-down ml-2"></i>

						</button>

					</div>


				</div>

			</div>

			<div class="card-body">
				

				<table id="tableReportSales" class="table table-bordered table-striped">

					<thead>
						<tr>
							<th>#</th>
							<th>Referencia</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Ganancia</th>
							<th>Cliente</th>
							<th>Email</th>
							<th>País</th>
							<th>Estado</th>
							<th>Ciudad</th>
							<th>Pasarela</th>
							<th>ID.Pago</th>
							<th>Guía</th>
							<th>Fecha Compra</th>
							<th>Fecha Entrega</th>
						</tr>
						
					</thead>

					<tbody>

					</tbody>

				</table>


			</div>

		</div>

	</div>

</div>

<script>
	
$("#tableReportSales").DataTable({
	"responsive": true, 
	"lengthChange": true, 
	"autoWidth": false,
	"processing":true,
	"serverSide": true,
	"aLengthMenu": [[10, 50, 100, 500, 1000], [10, 50, 100, 500, 1000]],
	"order": [[ 0, "desc" ]],
	"ajax":{
		"url": "/ajax/report-sales.ajax.php?between1=<?php echo $between1 ?>&between2=<?php echo $between2 ?>",
		"type": "POST"
	},
	"columns": [
		{ "data": "id_order" },
		{ "data": "ref_order" },
	    { "data": "description_variant" },
		{ "data": "quantity_order"},
		{ "data": "price_order" },
		{ "data": "name_user" },
		{ "data": "email_user" },
		{ "data": "country_user" },
		{ "data": "department_user" },
		{ "data": "city_user" },
		{ "data": "method_order" },
		{ "data": "number_order" },
		{ "data": "track_order" },
		{ "data": "start_date_order" },
		{ "data": "end_date_order" }
	],  
	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	},
	fnDrawCallback: function(oSettings) {

			if (oSettings.aoData.length == 0) {
				$('.dataTables_paginate').hide();
				$('.dataTables_info').hide();
			}
		},
		dom: 'B<"clear">lfrtip',
		buttons: [
	        { extend: 'copy', className: 'btn-light border' },
	        // { extend: 'csv', className: 'btn-light border' },
	        { extend: 'excel', className: 'btn-light border' },
	        // { extend: 'pdf', className: 'btn-light border' },
	        { extend: 'print', className: 'btn-light border' },
	        { extend: 'colvis', className: 'btn-light border' }
	    ]
	}).buttons().container().appendTo('#tableReportSales_wrapper .col-md-6:eq(0)');
	
	$("#tableReportSales").on("draw.dt", function(){

		$("#tableReportSales_wrapper .dt-buttons").addClass("float-left");
		$("#tableReportSales_wrapper .dt-buttons").addClass("mr-3");
		$("#tableReportSales_wrapper .dt-buttons").addClass("mb-3");
		$("#tableReportSales_wrapper .dataTables_length").addClass("float-left");
		$("#tableReportSales_wrapper .dataTables_length").addClass("mt-1");
		$("#tableReportSales_wrapper .dataTables_filter").addClass("mt-1");

	})


</script>