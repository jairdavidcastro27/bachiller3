/*=============================================
Aumentar y disminuir la cantidad
=============================================*/

$(document).on("click",".btnInc", function(){

	var key = $(this).attr("key");

	if($(this).attr("type") == "btnMin"){

		if(Number($(".showQuantity_"+key).val()) > 1){

			$(".showQuantity_"+key).val(Number($(".showQuantity_"+key).val())-1);

		}
	}

	if($(this).attr("type") == "btnMax"){

		$(".showQuantity_"+key).val(Number($(".showQuantity_"+key).val())+1);

	}

	/*=============================================
	Actualizamos el subtotal
	=============================================*/

	var quantity = $(".showQuantity_"+key).val();
	var price = $(".priceCart_"+key).html();

	$(".subtotalCart_"+key).html((Number(quantity)*Number(price)).toFixed(2));

	/*=============================================
	Actualizamos el total
	=============================================*/

	var sumaSubtotal = $(".subtotalCart");
	var total = 0;

	sumaSubtotal.each((i)=>{

		total += Number($(sumaSubtotal[i]).html());	

	})

	$(".totalCart").html(total.toFixed(2));

	/*=============================================
	Actualizamos la cesta
	=============================================*/

	var showQuantity = $(".showQuantity");
	var shoppingBasket = 0;

	showQuantity.each((i)=>{

		shoppingBasket += Number($(showQuantity[i]).val());

	})

	$("#shoppingBasket").html(shoppingBasket);
	$("#totalShop").html(total.toFixed(2));

	/*=============================================
	Actualizamos base de datos
	=============================================*/

	var idCart =  $(this).attr("idCart");

	var data = new FormData();
	data.append("token", localStorage.getItem("token-user"));
	data.append("idCartUpdate", idCart);
	data.append("quantityCartUpdate", quantity);

	$.ajax({
	  
	  	url:"/ajax/forms.ajax.php",
	  	method: "POST",
	  	data: data,
	  	contentType: false,
	  	cache: false,
	  	processData: false,
	  	success: function (response){ 
	  		
	  		if(response == 200){

	  			fncToastr("success","El producto ha sido actualizado");
	  		}

	  	}

	 })

})

/*=============================================
Quitar del carrito de compras
=============================================*/

$(document).on("click",".remCart", function(){

	fncSweetAlert("confirm","¿Está seguro de borrar este item?","").then(resp=>{

		if(resp){

			var key = $(this).attr("key");

			$(".hr_"+key).remove();

			$(this).parent().parent().remove();

			var idCart = $(this).attr("idCart");	

			var data = new FormData();

			data.append("token", localStorage.getItem("token-user"));
		    data.append("idCartDelete", idCart);

		     $.ajax({
		    
		        url:"/ajax/forms.ajax.php",
		        method: "POST",
		        data: data,
		        contentType: false,
		        cache: false,
		        processData: false,
		        success: function (response){
		        	
		        	if(response == 200){

		        		var total = 0;

		        		/*=============================================
		        		Actualizar el total
		        		=============================================*/

		        		if($(".subtotalCart").length > 0){

		        			var subtotalCart = $(".subtotalCart");		

		        			subtotalCart.each((i)=>{

		        				total += Number($(subtotalCart[i]).html());

		        			})

		        			$(".totalCart").html(total.toFixed(2));

		        		}

		        		/*=============================================
						Actualizamos la cesta
						=============================================*/

						var showQuantity = $(".showQuantity");
						var shoppingBasket = 0;

						showQuantity.each((i)=>{

							shoppingBasket += Number($(showQuantity[i]).val());

						})

						$("#shoppingBasket").html(shoppingBasket);
						$("#totalShop").html(total.toFixed(2));
				

						/*=============================================
						Cuando eliminamos el último producto
						=============================================*/

						if($('.remCart').length == 0){

							$("#bodyCart").html(`

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

							$(".card-footer").remove();
						}

						fncToastr("success","El producto ha sido removido de su carrito de compras");

		        	}

		        }

		    })

		}

	})

})