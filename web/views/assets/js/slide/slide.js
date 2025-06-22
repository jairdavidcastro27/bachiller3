/*=============================================
JD SLIDER
=============================================*/

$('.jd-slider').jdSlider({
	  isLoop:true,
	  speed:500
});


/*=============================================
Esconder el Slide
=============================================*/

var toogle = false;

$(document).on("click","#btnSlide",function(){

	if(!toogle){

		$(".jd-slider").slideUp("fast");
		$("#btnSlide").html('<i class="fa fa-angle-down templateColor"></i>')
		toogle = true;

	}else{

		$(".jd-slider").slideDown("fast");
		$("#btnSlide").html('<i class="fa fa-angle-up templateColor"></i>')
		toogle = false;
	}

})

/*=============================================
BLOQUE DE TEXTO
=============================================*/

$(document).on("change",".changeDirectionSlide", function(){

	if($(this).val() == "opt1" || $(this).val() == "opt2"){

		$(".blockDirectionSlide").show();

		if($(this).val() == "opt1"){

			$("#coord_img_slide").val("top:15%; right:10%; width:45%;");
			$("#coord_text_slide").val("top:20%; left:10%; width:40%;");
		}

		if($(this).val() == "opt2"){

			$("#coord_img_slide").val("bottom:0%; left:15%; width:28%;");
			$("#coord_text_slide").val("top:20%; right:15%; width:40%;");
		}
	
	}else{

		$(".blockDirectionSlide").hide();
	}

})