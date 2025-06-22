function changeLocation(event){

	if(event.target.value == "CATEGORÍA"){

		$(".locationCategory").show();
		$(".locationSubcategory").hide();

	}else if(event.target.value == "SUBCATEGORÍA"){

		$(".locationCategory").hide();
		$(".locationSubcategory").show();
		
	}else{

		$(".locationCategory").hide();
		$(".locationSubcategory").hide();

	}

}