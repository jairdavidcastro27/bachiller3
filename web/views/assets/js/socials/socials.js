var bodyMySocial = $(".bodyMySocial").html();

$("#tablesStatic").DataTable({

	"responsive":true,
	"aLengthMenu":[[10, 25, 50, 100],[10, 25, 50, 100]],
	"order":[0, "asc"],
	"lengthChange": true, 
	"autoWidth": false,
	"language":{

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
    }

})


/*=============================================
Cambiar color red social
=============================================*/

function changeColorSocial(event){

	$(".iconView").attr("class","input-group-text iconView "+event.target.value);

}

/*=============================================
Editar redes sociales
=============================================*/

$(document).on("click",".modalEditSocial",function(){

	$("#mySocial").modal("show");

	var data = JSON.parse($(this).attr("data-social"));
	
	$("#mySocial").on('shown.bs.modal', function () {

		if(data != undefined){

			$(".bodyMySocial").append(`<input type="hidden" name="idSocial" value="${data.id_social}">`);

			$("#name_social").val(data.name_social)

			$("#url_social").val(data.url_social)

			$(".iconView").addClass(data.color_social)

			$(".iconView").html(`<i class="${data.icon_social}"></i>`)

			$("#icon_social").val(data.icon_social)

			$("#color_social").val(data.color_social)

			data = undefined;

		}

		function changeColorSocial(event){

			$(".iconView").attr("class","input-group-text iconView "+event.target.value);

		}

	});

})

$("#mySocial").on('hidden.bs.modal', function () {

	$(".bodyMySocial").html('')

	$(".bodyMySocial").html(bodyMySocial);

})

