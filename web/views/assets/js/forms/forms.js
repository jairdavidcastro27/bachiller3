/*=============================================
Validación Bootstrap 5
=============================================*/
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

/*=============================================
Función para validar datos repetidos
=============================================*/

function validateDataRepeat(event, type){

  if(type == "category"){

    var table = "categories";
    var linkTo = "name_category";

  }

  if(type == "subcategory"){

    var table = "subcategories";
    var linkTo = "name_subcategory";

  }

  if(type == "product"){

    var table = "products";
    var linkTo = "name_product";

  }

  if(type == "email"){

    var table = "users";
    var linkTo = "email_user";

  }

  var value = event.target.value;

  var data = new FormData();
  data.append("table", table);
  data.append("equalTo", value);
  data.append("linkTo",linkTo);

  $.ajax({

    url: "/ajax/forms.ajax.php",
    method: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response){  
      
      if(response == 404){

        if(type == "email"){

          validateJS(event, "email");

        }else{

          validateJS(event, "complete");
  
          createUrl(event, "url_"+type);

          $(".metaTitle").html(value);

        }

      }else{

        $(event.target).parent().addClass("was-validated");
        $(event.target).parent().children(".invalid-feedback").html("Este registro ya existe en la base de datos");

         event.target.value = "";

        return;
      }

    }

  })

}

/*=============================================
Función para crear Url's
=============================================*/

function createUrl(event, input){

  var value = event.target.value;

  value = value.toLowerCase();
  value = value.replace(/[#\\;\\$\\&\\%\\=\\(\\)\\:\\,\\'\\"\\.\\¿\\¡\\!\\?\\]/g, "");
  value = value.replace(/[ ]/g, "-");
  value = value.replace(/[á]/g, "a");
  value = value.replace(/[é]/g, "e");
  value = value.replace(/[í]/g, "i");
  value = value.replace(/[ó]/g, "o");
  value = value.replace(/[ú]/g, "u");
  value = value.replace(/[ñ]/g, "n");

  $('[name="'+input+'"]').val(value);
  $('.metaURL').html(value);

}


/*=============================================
Función para validar formularios
=============================================*/

function validateJS(event, type){

  $(event.target).parent().addClass("was-validated");
  
  if(type == "email"){

    var pattern = /^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;
    
    if(!pattern.test(event.target.value)){

      $(event.target).parent().children(".invalid-feedback").html("El correo electrónico está mal escrito");

      event.target.value = "";

      return;

    }

  }

  if(type == "text"){

    var pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    
    if(!pattern.test(event.target.value)){

      $(event.target).parent().children(".invalid-feedback").html("El campo solo debe llevar texto");

      event.target.value = "";

      return;

    }

  }

  if(type == "password"){

    var pattern = /^[*\\$\\!\\¡\\?\\¿\\.\\_\\#\\-\\0-9A-Za-z]{1,}$/;
    
    if(!pattern.test(event.target.value)){

      $(event.target).parent().children(".invalid-feedback").html("La contraseña no puede llevar ciertos caracteres especiales");

      event.target.value = "";

      return;

    }

  }

  if(type == "complete"){

    var pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    
    if(!pattern.test(event.target.value)){

      $(event.target).parent().children(".invalid-feedback").html("La entrada tiene errores de caracteres especiales");

      event.target.value = "";

      return;

    }else{

      $(".metaDescription").html(event.target.value)
    
    }

  }

  if(type == "complete-tags"){

    var pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    
    if(!pattern.test(event.target.value)){

      $(event.target).parent().children(".invalid-feedback").html("La entrada tiene errores de caracteres especiales");

      event.target.value = "";

      return;

    }else{

      $(".metaTags").html(event.target.value)
    
    }

  }

}

/*=============================================
Función para recordar email en el login
=============================================*/

function rememberEmail(event){
  
  if(event.target.checked){

    localStorage.setItem("emailAdmin", $('[name="loginAdminEmail"]').val());
    localStorage.setItem("checkRem", true);

  }else{

    localStorage.removeItem("emailAdmin");
    localStorage.removeItem("checkRem");

  }

}

function getEmail(){

  if(localStorage.getItem("emailAdmin") != null){

    $('[name="loginAdminEmail"]').val(localStorage.getItem("emailAdmin"));

  }

   if(localStorage.getItem("checkRem") != null && localStorage.getItem("checkRem")){

    $("#remember").attr("checked", true);

  }

}

getEmail();

/*=============================================
Cambio de icono para la categoría
=============================================*/

function addIcon(event){

  $("#myIcon").show();
  $("#mySocial").modal("hide");

  $(document).ready(function(){

    $(".myInputIcon").on("keyup", function(){

       var value = $(this).val().toLowerCase();

       $(".btnChangeIcon").filter(function(){

          $(this).toggle($(this).attr("mode").toLowerCase().indexOf(value) > -1)
       
       })

    })

  })

   $(document).on("click",".btnChangeIcon", function(e){

      e.preventDefault();

      $(".iconView").html(`<i class="`+$(this).attr("mode")+`"></i>`)
      $(event.target).val($(this).attr("mode"))
      $("#myIcon").hide();    
      $("#mySocial").modal("show"); 

   })

}

$(document).on("click",'[data-bs-dismiss="modal"]',function(){

   var modal = $(".modal");

   modal.each((i)=>{

        $(modal[i]).hide()

    })

})

/*=============================================
Tags Input
=============================================*/

if($('.tags-input').length > 0){

  $('.tags-input').tagsinput({
     maxTags: 5
  });

}

/*=============================================
Validamos imagen
=============================================*/

function validateImageJS(event, tagImg){

  fncSweetAlert("loading", "", "");

  var image = event.target.files[0];
  
  if(image == undefined){

    fncSweetAlert("close", "", "");

    return;

  }

  /*=============================================
  Validamos el formato
  =============================================*/

  if(image["type"] !== "image/jpeg" && image["type"] !== "image/png" && image["type"] !== "image/gif"){


    fncSweetAlert("error", "La imagen debe estar en formato JPG, GIF o PNG.", null)

    return;

  }

  /*=============================================
  Validamos el tamaño
  =============================================*/

  else if(image["size"] > 2000000){

    fncSweetAlert("error", "La imagen no debe ser superior a 2MB", null)

    return;
  }

  /*=============================================
  Mostramos la imagen temporal
  =============================================*/

  else{

    var data = new FileReader();
    data.readAsDataURL(image);

    $(data).on("load", function(event){
      
      var path = event.target.result; 

      fncSweetAlert("close", "", "");

      $("."+tagImg).attr("src", path);
      $(".metaImg").attr("src", path);    

    })

  }

}

/*=============================================
Traer subcategorias de acuerdo a la categoría seleccionada
=============================================*/

function changeCategory(event){

  $("#id_subcategory_product").html(`<option value="">Selecciona Subcategoría</option>`);

  var idCategory = event.target.value;
  console.log("idCategory", idCategory);
  
  var data = new FormData();
  data.append("idCategory",idCategory);

  $.ajax({

    url: "/ajax/forms.ajax.php",
    method: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response){  
      
      if(JSON.parse(response).length > 0){

        JSON.parse(response).forEach((v) =>{
          
          $("#id_subcategory_product").append(`

            <option value="`+v.id_subcategory+`">`+v.name_subcategory+`</option>

          `)

        })


      }

    }

  })

}

/*=============================================
Summernote
=============================================*/

if($('.summernote').length > 0){

  $('.summernote').summernote({

    minHeight: 500,
    prettifyHtml:false,
    followingToolbar: true,
    codemirror: { // codemirror options
        mode: "application/xml",
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true
    },
    toolbar:[
      ['misc', ['codeview', 'undo', 'redo']],
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['para', ['style', 'ul', 'ol', 'paragraph', 'height']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['insert', ['link','picture', 'hr','video','table','emoji']],
    ],
    callbacks: {

      onImageUpload: function(files){
        
        fncSweetAlert(
            "loading",
            "Cargando imagen...",
            ""
        );

        for(var i = 0; i < files.length; i++){

          upload(files[i])

        }
 
      }

    }

  })

}

/*=============================================
Adicionar fondo blanco al toolbar de summernote
Adicionar iconos al toolbar de summernote
=============================================*/

if($(".note-toolbar").length > 0){

  $(".note-toolbar").addClass("bg-white");

  $(".emoji-picker").removeClass("fa-smile-o");
  $(".emoji-picker").addClass("fa-smile");

  $("[aria-label='More Color']").html(`<i class="fas fa-caret-down"></i>`)

}


/*=============================================
Subir imagen al servidor
=============================================*/

function upload(file){
  
  var data = new FormData();       
  data.append('file', file, file.name);

  $.ajax({

    url: "/ajax/upload.ajax.php",
    method: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {

      fncSweetAlert("close",
      null,
      null
      );

      switch(response){
                
          case "size":

               fncNotie(
                  3,
                  "Error: la imagen debe pesar menos de 10MB"
              );    

              return;

          break;

          case "type":

              fncNotie(
                  3,
                  "Error: la imagen debe ser formato JPG, PNG o GIF"
              );    

              return;

          break;

          case "process":

              fncNotie(
                  3,
                  "Error en el proceso de subir la imagen"
              );    

              return;

          break;

      }

      $('.summernote').summernote('insertImage', response, function ($image) {

        $image.attr('class', 'img-fluid');
        $image.css('width', '100%');
      
      }); 
     
      console.log("response", response);

    },

    error: function (jqXHR, textStatus, errorThrown) {
      
        console.log("jqXHR", jqXHR);

        if(response == "type"){

            fncNotie(
                3,
                textStatus + " " + errorThrown
            );    

            return;

        }

    }

  })

}

/*=============================================
Cambio de variante: Galería o video
=============================================*/

function changeVariant(event, item){

  if(event.target.value == "video"){

    $(".inputVideo_"+item).show();
    $(".iframeYoutube_"+item).show();
    $(".dropzone_"+item).hide();
    $(".galleryProduct_"+item).hide();

  }else{

    $(".inputVideo_"+item).hide();
    $(".iframeYoutube_"+item).hide();
    $(".dropzone_"+item).show();
    $(".galleryProduct_"+item).show();

  }

}

/*=============================================
DropZone
=============================================*/

Dropzone.autoDiscover = false;

function initDropzone(item){

  $(".dropzone_"+item).dropzone({

    url: "/",
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg, image/png, image/gif",
    maxFilesize: 10,
    maxFiles: 10,
    init: function(){

      var elem = $(this.element);
      
      var arrayFiles = [];

      var countArrayFiles = 0;

      this.on("addedfile", function(file){

        countArrayFiles++;

        setTimeout(function(){

          arrayFiles.push({

            "file":file.dataURL,
            "type":file.type,
            "width":file.width,
            "height":file.height

          })

          elem.parent().children(".galleryProduct_"+item).val(JSON.stringify(arrayFiles));

        },500*countArrayFiles)

      })

      this.on("removedfile", function(file){

        countArrayFiles++;

        setTimeout(function(){

          var index = arrayFiles.indexOf({

            "file":file.dataURL,
            "type":file.type,
            "width":file.width,
            "height":file.height

          })

          arrayFiles.splice(index, 1);

          elem.parent().children(".galleryProduct_"+item).val(JSON.stringify(arrayFiles));

        },500*countArrayFiles) 
       

      })

       myDropzone = this;

       $(".saveBtn").click(function(){

           if(arrayFiles.length == 0 &&  $("[name='type_variant_"+item+"']").val() == "gallery" && $(".idVariant").length == 0){

            fncToastr("error","La galería no puede estar vacía");
            
           }else{

              myDropzone.processQueue();

          }

       })

    }

  });

}

/*=============================================
Activar DropZone de acuerdo a la cantidad de galerías existentes
=============================================*/

var numDropzone = $(".dropzone");

for(var item = 1; item <= numDropzone.length; item++){

  initDropzone(item);

}

/*=============================================
Insertar Video de youtube
=============================================*/

function changeVideo(event, item){

  var idYoutube = event.target.value.split("/").slice(-1);
  $(".iframeYoutube_"+item).attr("src", "https://www.youtube.com/embed/"+idYoutube)

}

/*=============================================
Edición de Galeria
=============================================*/

var arrayFilesEdit = Array();
var arrayFilesDelete = Array();

function removeGallery(elem, item){

  $(elem).parent().remove();

  var index = JSON.parse($(".galleryOldProduct_"+item).val()).indexOf($(elem).attr("remove"));  

  arrayFilesEdit = JSON.parse($(".galleryOldProduct_"+item).val());

  arrayFilesEdit.splice(index, 1);

  $(".galleryOldProduct_"+item).val(JSON.stringify(arrayFilesEdit));

  arrayFilesDelete = JSON.parse($(".deleteGalleryProduct_"+item).val());

  arrayFilesDelete.push($(elem).attr("remove"));

  $(".deleteGalleryProduct_"+item).val(JSON.stringify(arrayFilesDelete));
  

}


/*=============================================
Adicionar Variante
=============================================*/

$(document).on("click",".addVariant", function(){

  var variantItem = Number($('[name="totalVariants"]').val()) + 1;

  $(".variantList").append(`

    <div class="col">

      <div class="card variantCount">
          
        <div class="card-body">

          <div class="form-group">
                      
            <div class="d-flex justify-content-between">
              
              <label for="info_product">Variante ${variantItem}<sup class="text-danger">*</sup></label>

              <div>
                <button type="button" class="btn btn-default btn-sm rounded-pill px-3 quitVariant"><i class="fas fa-times fa-xs"></i> Quitar esta variante</button>
              </div>

            </div>

          </div>

          <div class="row row-cols-1 row-cols-md-2">
                      
            <div class="col">

              <div class="form-group">
                
                <select 
                class="custom-select" 
                name="type_variant_${variantItem}"
                onchange="changeVariant(event, ${variantItem})"
                > 

                  <option value="gallery">Galería de fotos</option>
                  <option value="video">Video</option>

                </select>

              </div>

              <div class="dropzone dropzone_${variantItem} mb-3">
          
                <div class="dz-message">
                  
                  Arrastra tus imágenes acá, tamaño máximo 400px * 450px
                
                </div> 

              </div>

              <input type="hidden" name="galleryProduct_${variantItem}" class="galleryProduct_${variantItem}"> 
              <input type="hidden" name="galleryOldProduct_${variantItem}" class="galleryOldProduct_${variantItem}" value='[]'> 
              <input type="hidden" name="deleteGalleryProduct_${variantItem}" class="deleteGalleryProduct_${variantItem}" value='[]'> 

              <div class="input-group mb-3 inputVideo_${variantItem}" style="display:none">
                
                <span class="input-group-text">
                   <i class="fas fa-clipboard-list"></i>
                 </span>  

                <input 
                type="text" 
                class="form-control" 
                name="videoProduct_${variantItem}"
                placeholder="Ingresa la URL de YouTube"
                onchange="changeVideo(event, ${variantItem})"
                >

              </div>

              <iframe width="100%" height="280" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="mb-3 iframeYoutube_${variantItem}" style="display:none"></iframe>

            </div>  

            <div class="col">

              <div class="input-group mb-3">

                  <span class="input-group-text">
                    <i class="fas fa-clipboard-list"></i>
                  </span>
                  
                <input type="text" class="form-control" name="description_variant_${variantItem}" placeholder="Descripción: Color Negro, talla S, Material Goma">

              </div>

              <div class="input-group mb-3">

                  <span class="input-group-text">
                    <i class="fas fa-hand-holding-usd"></i>
                  </span>
                
                <input type="number" step="any" class="form-control" name="cost_variant_${variantItem}" placeholder="Costo de compra">

              </div>

              <div class="input-group mb-3">

                  <span class="input-group-text">
                    <i class="fas fa-funnel-dollar"></i>
                  </span>

                <input type="number" step="any" class="form-control" name="price_variant_${variantItem}" placeholder="Precio de venta">

              </div>

              <div class="input-group mb-3">

                  <span class="input-group-text">
                    <i class="fas fa-tag"></i>
                  </span> 

                <input type="number" step="any" class="form-control" name="offer_variant_${variantItem}" placeholder="Precio de descuento">

              </div>

              <div class="input-group mb-3">

                  <span class="input-group-text">Fin del descuento</span>
                  
                <input type="date" class="form-control" name="date_variant_${variantItem}">

              </div>

              <div class="input-group mb-3">

                  <span class="input-group-text">
                    <i class="fas fa-list"></i>
                  </span>

                <input type="number" class="form-control" name="stock_variant_${variantItem}" placeholder="Stock disponible">

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

   `)

$('[name="totalVariants"]').val(variantItem);
  
   initDropzone(variantItem);
 

})

/*=============================================
Quitar Variante
=============================================*/

$(document).on("click", ".deleteVariant", function(){

  $(this).parent().parent().parent().parent().parent().remove();

  var variantCount = $(".variantCount");
  $('[name="totalVariants"]').val(variantCount.length);

  if($(this).attr("idVariant") != undefined){

    var data = new FormData();

    data.append("token", localStorage.getItem("token-admin"));
    data.append("table", "variants");
    data.append("id", $(this).attr("idVariant"));
    data.append("nameId", "id_variant");

    $.ajax({
    
        url:"/ajax/delete-admin.ajax.php",
        method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response){  

          if(response == 200){

            fncToastr("success","Variante borrada correctamente");
          }
        
        }    

    })

  }

})

/*=============================================
Agregar codigo telefónico
=============================================*/ 

function changeCountry(event){
  $(".dialCode").html(event.target.value.split("_")[1]); 
}

/*=============================================
Activar select 2
=============================================*/

if($('.select2').length > 0){

   $('.select2').select2();
}

/*=============================================
Activar Input Mask
=============================================*/


if($('[data-mask]').length > 0){

   $('[data-mask]').inputmask()
}


