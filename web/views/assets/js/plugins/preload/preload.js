$(document).ready(function(){

    /*=============================================
    Función Preload
    =============================================*/

    function preload(){

        var preloadFalse = $(".preloadFalse");
        var preloadTrue = $(".preloadTrue");

        if(preloadFalse.length > 0){

            preloadFalse.each(function(i){

                var el = $(this);

                $(el).ready(function(){

                    $(preloadTrue[i]).delay(3000).fadeOut();      
                    $(el).css({"opacity":1,"height":"auto"});

                    setTimeout(()=>{

                      $(el).removeClass("preloadFalse");
                      $(preloadTrue[i]).remove();
                      
                    },1000)

                })

            })

        }
    }

    preload();

})