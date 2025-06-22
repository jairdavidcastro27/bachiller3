/*=============================================
Grid & List
=============================================*/

$(document).on("click",".btnView", function(){

	var type = $(this).attr("attr-type");
	var btnType = $("[attr-type]");
	var index = $(this).attr("attr-index");
	
	if(type == "list"){

		$(".grid-"+index).hide();
		$(".list-"+index).show();
	}

	if(type == "grid"){

		$(".grid-"+index).show();
		$(".list-"+index).hide();
	}

	btnType.each(function(i){

		if($(btnType[i]).attr("attr-index") == index){

			$(btnType[i]).removeClass("bg-white");

		}

	})
	
	$(this).addClass("bg-white");

})

/*=============================================
Paginación
=============================================*/

var target = $('.pagination');

if(target.length > 0){

	target.each(function() {

		var el = $(this),
		    totalPages = el.data("total-pages"),
		    urlPage = el.data("url-page"),
		    currentPage = el.data("current-page");		    

		el.twbsPagination({
	        totalPages: totalPages,
	        startPage: currentPage,
	        visiblePages: 3,
	        first: '<i class="fas fa-angle-double-left"></i>',
	        last: '<i class="fas fa-angle-double-right"></i>',
	        prev: '<i class="fas fa-angle-left"></i>',
	        next: '<i class="fas fa-angle-right"></i>',
	        onPageClick: function (event, page) {
	        	
	        	if(page == 1){

	        		$(".page-item.first").css({"color":"#aaa"})
	        		$(".page-item.prev").css({"color":"#aaa"})
	        	}

	        	if(page == totalPages){

	        		$(".page-item.next").css({"color":"#aaa"})
	        		$(".page-item.last").css({"color":"#aaa"})
	        	}

	        }
	    
	    }).on("page", function(event,page){

	    	window.location = "/"+urlPage+"/"+page;

	    })

	})

}

/*=============================================
Función para buscar productos
=============================================*/

$(document).on("click", ".btnSearch", function(){

	var value = $(this).parent().parent().children(".inputSearch").val().toLowerCase();
	
	value = value.replace(/[#\\;\\$\\&\\%\\=\\(\\)\\:\\,\\'\\"\\.\\¿\\¡\\!\\?\\]/g, "");
  	value = value.replace(/[ ]/g, "-");
  	value = value.replace(/[á]/g, "a");
  	value = value.replace(/[é]/g, "e");
  	value = value.replace(/[í]/g, "i");
  	value = value.replace(/[ó]/g, "o");
  	value = value.replace(/[ú]/g, "u");
  	value = value.replace(/[ñ]/g, "n");
  	
  	window.location = "/"+value;

})

/*=============================================
Función para buscar productos con tecla ENTER
=============================================*/

$(".inputSearch").keyup(function(event){

	event.preventDefault();

	if(event.keyCode == 13 && $(".inputSearch").val() != ""){

		var value = $(".inputSearch").val().toLowerCase();

		value = value.replace(/[#\\;\\$\\&\\%\\=\\(\\)\\:\\,\\'\\"\\.\\¿\\¡\\!\\?\\]/g, "");
	  	value = value.replace(/[ ]/g, "-");
	  	value = value.replace(/[á]/g, "a");
	  	value = value.replace(/[é]/g, "e");
	  	value = value.replace(/[í]/g, "i");
	  	value = value.replace(/[ó]/g, "o");
	  	value = value.replace(/[ú]/g, "u");
	  	value = value.replace(/[ñ]/g, "n");
	  	
	  	window.location = "/"+value;

	}

})

/*=============================================
Adicionar a favoritos
=============================================*/

$(document).on("click",".addFavorite",function(){

	var idProduct = $(this).attr("idProduct");
	var elem = $(this);
	$(elem).children("i").css({"color":"#dc3545"})
	
	var data = new FormData();
	data.append("token", localStorage.getItem("token-user"));
	data.append("idProduct", idProduct);

	$.ajax({

		url:"/ajax/forms.ajax.php",
		method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response){ 
        	
        	if(JSON.parse(response).comment == "The process was successful"){

        		$(elem).attr("idFavorite",JSON.parse(response).lastId);
        		$(elem).removeClass("addFavorite");
        		$(elem).addClass("remFavorite");

        		fncToastr("success","El producto ha sido agregado a su lista de favoritos");
        	}

        }

	})

})

/*=============================================
Quitar de favoritos
=============================================*/

$(document).on("click",".remFavorite",function(){

	var idFavorite = $(this).attr("idFavorite");
	var elem = $(this);
	$(elem).children("i").css({"color":"#000"})

	var pageFavorite = $(this).attr("pageFavorite");

	if(pageFavorite == "yes"){

		$(this).parent().parent().parent().parent().parent().remove();

	}

	var data = new FormData();
	data.append("token", localStorage.getItem("token-user"));
    data.append("idFavorite", idFavorite);

    $.ajax({

		url:"/ajax/forms.ajax.php",
		method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response){ 
        	
        	if(response == 200){

        		if($('.remFavorite').length == 0 && pageFavorite == "yes"){

        			$("#favorite").html(`

        				<div class="login-page page-error bg-white">
  
						  <div class="login-box bg-white  d-flex justify-content-center">
					
						    <section class="content pb-5">

						      <div class="error-page">
						        <h2 class="headline text-default templateColor rounded"> <i class="fas fa-shopping-cart px-4 text-white"></i></h2>

						        <div class="error-content">
						          <h3><i class="fas fa-exclamation-triangle text-default bg-light p-1"></i> Oops! No hay productos por ahora.</h3>

						          <p>
						          No pudimos encontrar los productos que estás buscando.
						          <a href="/"><strong>Regresa a la página de inicio</strong></a>.
						          <p>

						        </div>

						      </div>

						    </section>

						  </div>

						</div>

        			`)

        		}

        		$(elem).addClass("addFavorite");
        		$(elem).removeClass("remFavorite");
        		

        		fncToastr("success","El producto ha sido removido de su lista de favoritos");

        	}
        	   	
        }

	})


})
