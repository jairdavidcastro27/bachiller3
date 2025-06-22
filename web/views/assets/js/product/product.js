/*=============================================
FlexSlider
=============================================*/

function activateFlexSlider(){

	$('#carousel').flexslider({
		animation: "slide",
		controlNav: true,
		controlsContainer: false,
		directionNav: false,
		animationLoop: false,
		slideshow: true,
		itemWidth: 210,
		itemMargin: 5,
		asNavFor: '#slider'
	});

	$('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#carousel"
	});

}

activateFlexSlider();



/*=============================================
Cambiar variante
=============================================*/

$(document).on("change",".changeVariant", function(){

	var variant = JSON.parse($(this).attr("variant"));
	// console.log("variant", variant);
	 var url = $(this).attr("url");
	
	/*=============================================
    Cambiar la galeria de imagenes
    =============================================*/

	if(variant.type_variant == "gallery"){

		$(".blockQuantity").show();
	  $(".pulseAnimation").parent().addClass("col-md-9");

		$(".blockMedia").html(`

			<div id="slider" class="flexslider" style="margin-bottom:-4px">
                <ul class="slides"></ul>
            </div>
            <div id="carousel" class="flexslider">
              <ul class="slides"></ul>
            </div>

		`)

		var count = 0;

		JSON.parse(variant.media_variant).forEach((e,i)=>{

			count++;

			$("#slider .slides").append(`

				 <li><img src="/views/assets/img/products/${url}/${e}" class="img-thumbnail" /></li>

			 `)

			$("#carousel .slides").append(`

          <li><img src="/views/assets/img/products/${url}/${e}" class="img-thumbnail" /></li>

      `)

      if(JSON.parse(variant.media_variant).length == count){

      	activateFlexSlider();

    	}
		
		})

	}

	 /*=============================================
    Cambiar el video
    =============================================*/

	  if(variant.type_variant == "video"){

	  		$(".blockQuantity").hide();
	  		$(".pulseAnimation").parent().removeClass("col-md-9");

        var idVideo = variant.media_variant.split("/").pop();

        $(".blockMedia").html(`

            <iframe width="100%" height="315" src="https://www.youtube.com/embed/${idVideo}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

        `)

    }


	/*=============================================
  Cambiar precio
  =============================================*/

  if(variant.offer_variant > 0){

  	$(".blockPrice").html(`

  		<h5 class="my-3 text-center font-weight-bold text-danger">¡Aprovecha la PROMO y llévalo a un increíble precio!<br>↓↓↓</h5>

			<h3 class="text-center">ANTES 
				<s>$${Number(variant.price_variant).toFixed(2)}</s>
			</h3>

			<h3 class="text-center">
				<span class="text-success pt-4">AHORA ${Number(variant.offer_variant).toFixed(2)}</span>
				<span class="ml-2 px-2 p-1 small rounded-pill" 
				style="font-size: 16px; position:relative; top:-4px; border:2px solid #000 !important">
					AHORRE $${(Number(variant.offer_variant)-Number(variant.price_variant)).toFixed(2)}			
				</span>
			</h3>

  	`)

  }else{

  	 $(".blockPrice").html(`

        <h2 class="text-center"><span class="text-success pt-4">$${Number(variant.price_variant).toFixed(2)}</span></h2>  
     `)

  }

  /*=============================================
  Cambiar fecha de finalización oferta
  =============================================*/

  if(variant.offer_variant > 0){

  	$(".countdown").show();

  	 if(variant.end_offer_variant != "0000-00-00"){

  	 		$(".countdown").attr("ddate", variant.end_offer_variant);

  	 		countDown();

  	 }else{

  	 	  var day = new Date().getDate();
  	 	  day  = ("0"+day).slice(-2);
  	 	 
  	 	  var month = new Date().getMonth()+1;
  	 	  month = ("0"+month).slice(-2);

  	 		$(".countdown").attr("ddate", new Date().getFullYear()+"-"+month+"-"+day);

  	 		countDown();
  	 }

  }else{

  	$(".countdown").hide();

  }

 	/*=============================================
  Cambiar stock
  =============================================*/

  if(variant.stock_variant > 0){

  	$(".blockStock").html(`

  			<p class="text-center lead font-weight-bold">🔥 ¡Sólo ${variant.stock_variant} unidades disponibles! 🔥</p>

				<div class="progress">
				  <div class="progress-bar bg-danger" style="width:30%"></div>
				</div>

	  `)

  }else{

  	function numeroAleatorio(min, max){

  		return Math.round(Math.random() * (max - min) + min);

  	}

  	var sales = numeroAleatorio(300, 500);
  	var stock = numeroAleatorio(10, 20);

  	$(".blockStock").html(`

				<p class="text-center lead font-weight-bold">
					
				🔥 ¡${sales} vendidos - Sólo ${stock} unidades disponibles! 🔥 </p>

				<div class="progress">
			  		<div class="progress-bar bg-danger" style="width:${stock*100/(sales/5)}%"></div>
				</div>

		`)

  }

  /*=============================================
  Agregar ID de variante al botón addCart
  =============================================*/

  if($(".addCart").length > 0){

  	var addCart = $(".addCart");

  	addCart.each((i)=>{

  		$(addCart[i]).attr("idVariant",variant.id_variant);

  		if(variant.offer_variant>0){

  			$(addCart[i]).attr("priceVariant",variant.offer_variant);

  		}else{

  			$(addCart[i]).attr("priceVariant",variant.price_variant);
  		}

  	})

  }

})

/*=============================================
Aplicar Sticky al bloque Media
=============================================*/

if(window.matchMedia("(min-width:768px)").matches){

	var sticky = new Sticky(".blockMedia");
	var topMedia = $(".blockMedia").offset().top;

	$(window).scroll(function(event) {

		var scrollTop = $(window).scrollTop();

		var footerTop = $(".footerBlock").offset().top;

		var blockMedia = $(".blockMedia").height();		
		
		if(scrollTop > (footerTop - blockMedia)){

			$(".blockMedia")[0].sticky.active = false;

			$(".blockMedia").css({"position":"relative","left":"0px","top":footerTop-(blockMedia+topMedia)+"px"})

		}else{

			$(".blockMedia")[0].sticky.active = true;

		}

	})
	
}

/*=============================================
Aumentar y disminuir la cantidad
=============================================*/

$(".btnInc").click(function(){

	if($(this).attr("type") == "btnMin"){

		if(Number($(".showQuantity").val()) > 1){

			$(".showQuantity").val(Number($(".showQuantity").val())-1);

		}
	}

	if($(this).attr("type") == "btnMax"){

		$(".showQuantity").val(Number($(".showQuantity").val())+1);

	}

	if($(".addCart").length > 0){

  	var addCart = $(".addCart");

  	addCart.each((i)=>{

  		$(addCart[i]).attr("quantity",$(".showQuantity").val());

  	})

  }

})

/*=============================================
Agregar al carrito de compras
=============================================*/

$(document).on("click",".addCart", function(){

	var idProduct =  $(this).attr("idProduct");
	var idVariant = $(this).attr("idVariant");
	var quantity = $(this).attr("quantity");
	var priceVariant = $(this).attr("priceVariant");
	
	var data = new FormData();
	data.append("token", localStorage.getItem("token-user"));
	data.append("idProductCart", idProduct);
	data.append("idVariantCart", idVariant);
	data.append("quantityCart", quantity);

	$.ajax({

		url:"/ajax/forms.ajax.php",
		method: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response){

    	if(response == 200){

    		var shoppingBasket = $("#shoppingBasket").html();
    		var totalShop = $("#totalShop").html();

    		$("#shoppingBasket").html(Number(shoppingBasket)+Number(quantity));
    		$("#totalShop").html((Number(totalShop)+(Number(quantity)*Number(priceVariant))).toFixed(2));

    		fncSweetAlert("footer", "Producto agregado a tu carrito de compras", "/carrito");

    	}

    }

	})

})

/*=============================================
Whatsapp
=============================================*/

if($(".questionProduct").length > 0){

	var questionProduct = $(".questionProduct");

	questionProduct.each((i)=>{

		$(questionProduct[i]).attr("href","https://wa.me/"+$(questionProduct[i]).attr("phone")+"?text="+encodeURIComponent("¡Hola! Tengo una inquietud con el producto "+$(questionProduct[i]).attr("name")));
	
	})

}

