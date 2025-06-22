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

<input type="hidden" id="between1" value="<?php echo $between1 ?>">
<input type="hidden" id="between2" value="<?php echo $between2 ?>">
<input type="hidden" id="page" value="admin/clientes">

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
				
				<table id="tableReportClients" class="table table-bordered table-striped">
					
					<thead>
						<tr>
							<th>#</th>
							<th>Cliente</th>
							<th>Email</th>
							<th>Registro</th>
							<th>País</th>
							<th>Estado</th>
							<th>Ciudad</th>
							<th>Dirección</th>
							<th>Teléfono</th>
							<th>Última visita</th>
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
	
	$("#tableReportClients").DataTable({
		"responsive": true, 
		"lengthChange": true, 
		"autoWidth": false,
		"processing":true,
		"serverSide": true,
		"aLengthMenu": [[10, 50, 100, 500, 1000], [10, 50, 100, 500, 1000]],
		"order": [[ 0, "desc" ]],
		"ajax":{
			"url": "<?php echo $path ?>ajax/report-clients.ajax.php?between1=<?php echo $between1 ?>&between2=<?php echo $between2 ?>",
			"type": "POST"
		},
		"columns": [
			{ "data": "id_user" },
			{ "data": "name_user" },
			{ "data": "email_user" },
			{ "data": "method_user" },
			{ "data": "country_user" },
			{ "data": "department_user" },
			{ "data": "city_user" },
			{ "data": "address_user" },
			{ "data": "phone_user" },
			{ "data": "date_updated_user" }
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
	}).buttons().container().appendTo('#tableReportClients_wrapper .col-md-6:eq(0)');

	$("#tableReportClients").on("draw.dt", function(){

		$("#tableReportClients_wrapper .dt-buttons").addClass("float-left");
		$("#tableReportClients_wrapper .dt-buttons").addClass("mr-3");
		$("#tableReportClients_wrapper .dt-buttons").addClass("mb-3");
		$("#tableReportClients_wrapper .dataTables_length").addClass("float-left");
		$("#tableReportClients_wrapper .dataTables_length").addClass("mt-1");
		$("#tableReportClients_wrapper .dataTables_filter").addClass("mt-1");

	})

	
	
	
</script>

