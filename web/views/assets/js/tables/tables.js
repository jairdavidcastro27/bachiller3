/*=============================================
Tabla para administradores
=============================================*/

if($(".adminsTable").length > 0){

  var url = "/ajax/data-admins.ajax.php";

  var columns = [
     {"data":"id_admin"},
     {"data":"name_admin"},
     {"data":"email_admin"},
     {"data":"rol_admin"},
     {"data":"date_updated_admin"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];
  

}

/*=============================================
Tabla para plantillas
=============================================*/

if($(".templatesTable").length > 0){

  var url = "/ajax/data-templates.ajax.php";

  var columns = [
     {"data":"id_template"},
     {"data":"active_template"},
     {"data":"logo_template"},
     {"data":"icon_template"},
     {"data":"cover_template"},
     {"data":"title_template"},
     {"data":"description_template"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];

}

/*=============================================
Tabla para categorias
=============================================*/

if($(".categoriesTable").length > 0){

  var url = "/ajax/data-categories.ajax.php";

  var columns = [
     {"data":"id_category"},
     {"data":"status_category"},
     {"data":"name_category"},
     {"data":"url_category"},
     {"data":"image_category"},
     {"data":"description_category"},
     {"data":"keywords_category"},
     {"data":"subcategories_category"},
     {"data":"products_category"},
     {"data":"views_category"},
     {"data":"date_updated_category"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];
  
}

/*=============================================
Tabla para subcategorias
=============================================*/

if($(".subcategoriesTable").length > 0){

  var url = "/ajax/data-subcategories.ajax.php";

  var columns = [
     {"data":"id_subcategory"},
     {"data":"status_subcategory"},
     {"data":"name_subcategory"},
     {"data":"url_subcategory"},
     {"data":"image_subcategory"},
     {"data":"description_subcategory"},
     {"data":"keywords_subcategory"},
     {"data":"name_category"},
     {"data":"products_subcategory"},
     {"data":"views_subcategory"},
     {"data":"date_updated_subcategory"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];
  
}

/*=============================================
Tabla para productos
=============================================*/

if($(".productsTable").length > 0){

  var url = "/ajax/data-products.ajax.php";

  var columns = [
     {"data":"id_product"},
     {"data":"status_product"},
     {"data":"name_product"},
     {"data":"url_product"},
     {"data":"image_product"},
     {"data":"description_product"},
     {"data":"keywords_product"},
     {"data":"name_category"},
     {"data":"name_subcategory"},
     {"data":"views_product"},
     {"data":"date_updated_product"},
     {"data":"actions", "orderable":false, "searchable":false},
     {"data":"provider"}
  ]

  var order = [0,"desc"];
  
}

/*=============================================
Tabla para slides
=============================================*/

if($(".slidesTable").length > 0){

  var url = "/ajax/data-slides.ajax.php";

  var columns = [
     {"data":"id_slide"},
     {"data":"status_slide"},
     {"data":"background_slide"},
     {"data":"direction_slide"},
     {"data":"img_png_slide"},
     {"data":"date_created_slide"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];
  
}

/*=============================================
Tabla para banners
=============================================*/

if($(".bannersTable").length > 0){

  var url = "/ajax/data-banners.ajax.php";

  var columns = [
     {"data":"id_banner"},
     {"data":"status_banner"},
     {"data":"location_banner"},
     {"data":"background_banner"},
     {"data":"text_banner"},
     {"data":"discount_banner"},
     {"data":"end_banner"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];
  
}

/*=============================================
Tabla para órdenes
=============================================*/

if($(".ordersTable").length > 0){

  var url = "/ajax/data-orders.ajax.php";

  var columns = [
     {"data":"id_order"},
     {"data":"process_order"},
     {"data":"media_variant"},
     {"data":"name_product"},
     {"data":"quantity_order"},
     {"data":"price_order"},
     {"data":"name_user"},
     {"data":"uniqid_order"},
     {"data":"method_order"},
     {"data":"number_order"},
     {"data":"track_order"},
     {"data":"dates"},
     {"data":"actions", "orderable":false, "searchable":false}
  ]

  var order = [0,"desc"];
  
}




/*=============================================
Configuración global Datatable
=============================================*/

$("#tables").DataTable({
"responsive":true,
"aLengthMenu":[[10, 25, 50, 100],[10, 25, 50, 100]],
"order":[order],
"lengthChange": true, 
"autoWidth": false,
"processing":true,
"serverSide": true,
"ajax":{
	"url":url,
	"type": "POST"
},
"columns":columns,
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

});

/*=============================================
Eliminar item
=============================================*/

$(document).on("click",".deleteItem", function(){

  var idItem = $(this).attr("idItem");
  var table = $(this).attr("table");
  var column =  $(this).attr("column");
  var rol =  $(this).attr("rol");

  fncSweetAlert("confirm","¿Está seguro de borrar este item?","").then(resp=>{
   
    if(resp){

      fncMatPreloader("on");
      fncSweetAlert("loading", "", "");

      if(rol == "admin"){

        var token = localStorage.getItem("token-admin");
        var url = "/ajax/delete-admin.ajax.php";
      
      }

      var data = new FormData();
      data.append("token", token);
      data.append("table", table);
      data.append("id", idItem);
      data.append("nameId", "id_"+column);

      $.ajax({

        url: url,
        method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response){

          if(response == 200){

            fncMatPreloader("off");
            fncSweetAlert(
              "success",
              "El item ha sido borrado correctamente",
              location.reload()
            )

          }else if(response == "no-borrar"){

            if(table == "categories"){

              fncMatPreloader("off");
              fncToastr("warning","Este item no se puede borrar porque tiene subcategorías vinculadas");
            
            }else if(table == "subcategories"){

              fncMatPreloader("off");
              fncToastr("warning","Este item no se puede borrar porque tiene productos vinculados");
            
            }else{
               
              fncMatPreloader("off");
              fncToastr("warning","Este item no se puede borrar");

            }


          }else{

            fncMatPreloader("off");
            fncToastr("Error","Este item no se pudo borrar");

          }

        }

      })

    }

  })

})

/*=============================================
Suiche
=============================================*/

$("#tables").on("draw.dt", function(){

    $("input[data-bootstrap-switch]").each(function(){

      $(this).bootstrapSwitch({

        onSwitchChange: function(event, state){
         
          var idItem = $(event.target).attr("idItem");
          var table = $(event.target).attr("table");
          var column =  $(event.target).attr("column");
          var status = 0;

          if(state){

            status = 1;

          }else{

            status = 0;

          }

          var token = localStorage.getItem("token-admin");

          var data = new FormData();
          data.append("token", token);
          data.append("table", table);
          data.append("id", idItem);
          data.append("status", status);
          data.append("column", column);

          $.ajax({

            url: "/ajax/status-admin.ajax.php",
            method: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response){

             if(response == 200){

                fncMatPreloader("off");
                fncToastr(
                  "success",
                  "El item ha sido actualizado correctamente"
                  )

              }else{

                fncMatPreloader("off");
                fncToastr("Error","Este item no se pudo actualizar");

              }

            }

          })

        }

      });

    })

})

/*=============================================
Rango de fechas
=============================================*/

$('#daterange-btn').daterangepicker(
  {
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
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'Este Año': [moment().startOf('year'), moment().endOf('year')],
      'Último Año'  : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    },
    startDate: moment($("#between1").val()),
    endDate  : moment($("#between2").val())
  },
  function (start, end) {

    var page = $("#page").val();
    window.location = "/"+page+"?start="+start.format('YYYY-MM-DD')+"&end="+end.format('YYYY-MM-DD');
    
  }

)