<?php


/*=============================================
Iniciar variables de sesión
=============================================*/

ob_start();
session_start();

/*=============================================
validar si el token está expirado
=============================================*/

if(isset($_SESSION["user"])){

  date_default_timezone_set("America/Bogota");

  $url = "users?id=".$_SESSION["user"]->id_user."&nameId=id_user&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
  $method = "PUT";
  $fields = "date_updated_user=".date("Y-m-d G:i:s");

  $update = CurlController::request($url, $method, $fields);

  if($update->status == 303){

    session_destroy();

    echo '<script>

      window.location = "/";

    </script>';

    return;

  }

}


/*=============================================
Variable Path
=============================================*/ 

$path = TemplateController::path();
$phone = "";
$google_analytics = "";
$pixel_facebook = "";

/*=============================================
Capturar las rutas de la URL
=============================================*/ 

$routesArray = explode("/",$_SERVER["REQUEST_URI"]);
array_shift($routesArray);


/*=============================================
Cuando utilizamos localhost
=============================================*/ 

if( $_SERVER["SERVER_NAME"] == "localhost"){

 $routesArray = array_slice($routesArray,2);
 $path = $path."ecommerce/web/";
  // echo '<pre>'; print_r($routesArray); echo '</pre>';

}


foreach ($routesArray as $key => $value) { 
  $routesArray[$key] = explode("?",$value)[0];
}

/*=============================================
Registro - Login con Facebook y google
=============================================*/

if(!empty($routesArray[0])) {

  // https://github.com/facebookarchive/php-graph-sdk/
  if($routesArray[0] == "facebook"){

    require_once "controllers/users.controller.php";
    $response = UsersController::socialConnect($routesArray[0],$_GET["urlRedirect"]);
    echo '<pre>'; print_r($response); echo '</pre>';

  }

   // https://github.com/googleapis/google-api-php-client
  if($routesArray[0] == "google"){

    require_once "controllers/users.controller.php";

    if(isset($_GET["urlRedirect"])){
      $response = UsersController::socialConnect($routesArray[0],$_GET["urlRedirect"]);
    }else{
      $response = UsersController::socialConnect($routesArray[0],null); 
    }

  }

}


/*=============================================
Solicitud GET de Template
=============================================*/ 

$url = "templates?linkTo=active_template&equalTo=ok";
$method = "GET";
$fields = array();

$template = CurlController::request($url,$method,$fields);

if(!$template){
    error_log("API response is null. Check the API endpoint or parameters.");
}

if($template && $template->status == 200){

  $template = $template->results[0];
  
}else{

  echo '<!DOCTYPE html>
        <html lang="en">
        <head>
        <link rel="stylesheet" href="'.$path.'views/assets/css/plugins/adminlte/adminlte.min.css">
        </head>
        <body class="hold-transition sidebar-collapse layout-top-nav">
        <div class="wrapper">';
        include "pages/500/500.php";
  echo '</div>
        </body>
        </html>';

  return;

}


/*=============================================
Datos en Arreglo
=============================================*/
 
$keywords = $template->keywords_template;

/*=============================================
Datos en Objeto
=============================================*/

$fontFamily = json_decode($template->fonts_template)->fontFamily;
$fontBody = json_decode($template->fonts_template)->fontBody;
$fontSlide = json_decode($template->fonts_template)->fontSlide;

/*=============================================
Datos en JSON
=============================================*/

$topColor = json_decode($template->colors_template)[0]->top;
$templateColor = json_decode($template->colors_template)[1]->template;

?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $template->title_template ?></title>

  <meta name="description" content="<?php echo $template->description_template ?>">
  <meta name="keywords" content="<?php echo $keywords ?>">

  <link rel="icon" href="<?php echo $path ?>views/assets/img/template/<?php echo $template->id_template ?>/<?php echo $template->icon_template ?>">

  <!-- Google Font: Source Sans Pro -->
  <?php echo urldecode($fontFamily) ?>

  <?php if ($google_analytics != ""): ?>

    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google_analytics ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $google_analytics ?>');
    </script>

  <?php endif ?>

  <!-- CSS -->

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/fontawesome-free/css/all.min.css">

  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- JDSlider -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/jdSlider/jdSlider.css">

  <!-- Notie Alert -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/notie/notie.min.css">

  <!-- Toastr Alert -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/toastr/toastr.min.css">

  <!-- Material Preloader -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/material-preloader/material-preloader.css">

   <!-- Tags Input -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/tags-input/tags-input.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Summernote -->
  <link  rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/summernote/summernote-bs4.min.css">
  <link  rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/summernote/emoji.css">

  <!-- Codemirror -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/codemirror/codemirror.min.css">

   <!-- Dropzone -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/dropzone/dropzone.css">

  <!-- FlexSlider -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/flexslider/flexslider.css">

    <!-- Preload -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/preload/preload.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/select2/select2-bootstrap4.min.css">

  <!-- TimeLine -->
  <!-- https://mdbootstrap.com/docs/standard/extended/timeline/ -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/timeline/timeline.css">

  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/daterangepicker/daterangepicker.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/adminlte/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/template/template.css">

  <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/products/products.css">

  <style>
    
    body{
      font-family: '<?php echo $fontBody ?>', sans-serif;
    }

    .slideOpt h1, .slideOpt h2, .slideOpt h3{   
      font-family: '<?php echo $fontSlide ?>', sans-serif;
    }

    .topColor{
      background: <?php echo $topColor->background ?>; 
      color: <?php echo $topColor->color ?>;
    }

    .templateColor, .templateColor:hover, a.templateColor{
      background: <?php echo $templateColor->background ?> !important; 
      color:<?php echo $templateColor->color ?> !important;
    }


  </style>

  <!-- JS -->

  <!-- jQuery -->
  <script src="<?php echo $path ?>views/assets/js/plugins/jquery/jquery.min.js"></script>

  <?php if (!empty($routesArray[0]) && $routesArray[0] == "admin" &&
            !empty($routesArray[1]) && $routesArray[1] == "productos" &&
            !empty($routesArray[2]) && $routesArray[2] == "gestion"): ?>

      <!-- Bootstrap 4 -->
      <script src="<?php echo $path ?>views/assets/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> 

  <?php else: ?>  

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>   
    
  <?php endif ?>
  
  <!-- JDSlider 
  https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
  <script src="<?php echo $path ?>views/assets/js/plugins/jdSlider/jdSlider.js"></script>

  <!-- Knob -->
  <script src="<?php echo $path ?>views/assets/js/plugins/knob/knob.js"></script>

  <script src="<?php echo $path ?>views/assets/js/alerts/alerts.js"></script>

  <!-- Notie Alert -->
  <!-- https://jaredreich.com/notie/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/notie/notie.min.js"></script>

  <!-- Sweet Alert 2 -->
  <!-- https://sweetalert2.github.io/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

  <!-- Toastr Alert-->
  <script src="<?php echo $path ?>views/assets/js/plugins/toastr/toastr.min.js"></script>

  <!-- Material Preloader -->
  <!-- https://www.jqueryscript.net/demo/Google-Inbox-Style-Linear-Preloader-Plugin-with-jQuery-CSS3/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/material-preloader/material-preloader.js"></script>

   <!-- Tags-Input -->
  <!-- https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/tags-input/tags-input.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- Bootstrap Switch -->
  <!-- https://bttstrp.github.io/bootstrap-switch/examples.html -->
  <script src="<?php echo $path ?>views/assets/js/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>

  <!-- summernote -->
  <!-- https://summernote.org/getting-started/#run-summernote -->
  <script src="<?php echo $path ?>views/assets/js/plugins/summernote/summernote-bs4.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/summernote/summernote-code-beautify-plugin.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/summernote/emoji.config.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/summernote/tam-emoji.min.js"></script>

  <!-- CodeMirror https://github.com/codemirror/CodeMirror/blob/master/demo/activeline.html -->
  <script src="<?php echo $path ?>views/assets/js/plugins/codemirror/codemirror.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/codemirror/xml.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/codemirror/formatting.min.js"></script>

  <!-- Dropzone -->
  <!-- https://www.dropzonejs.com/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/dropzone/dropzone.js"></script>

  <!-- pagination -->
  <!-- http://josecebe.github.io/twbs-pagination/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/twbs-pagination/twbs-pagination.min.js"></script>

  <!-- FlexSlider -->
  <!-- http://flexslider.woothemes.com/thumbnail-controlnav.html -->
  <script src="<?php echo $path ?>views/assets/js/plugins/flexslider/jquery.flexslider.js"></script>

  <!-- sticky -->
  <!-- https://rgalus.github.io/sticky-js/ -->
  <script src="<?php echo $path ?>views/assets/js/plugins/sticky/sticky.min.js"></script>

   <!-- Preload -->
  <!-- https://codepen.io/tutorialesatualcance/pen/oNqObGL -->
  <!-- https://youtu.be/6_lg2D_-GSk -->
  <script src="<?php echo $path ?>views/assets/js/plugins/preload/preload.js"></script>

  <!-- Select2 -->
  <!-- https://github.com/select2/select2 -->
  <script src="<?php echo $path ?>views/assets/js/plugins/select2/select2.full.min.js"></script>

  <!-- InputMask -->
   <!-- https://github.com/RobinHerbots/Inputmask -->
  <script src="<?php echo $path ?>views/assets/js/plugins/input-mask/moment.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/input-mask/jquery.inputmask.min.js"></script>

  <script src="<?php echo $path ?>views/assets/js/plugins/moment/moment.min.js"></script>
  <script src="<?php echo $path ?>views/assets/js/plugins/daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

  <!-- ChartJS -->
  <script src="<?php echo $path ?>views/assets/js/plugins/chart.js/Chart.min.js"></script>

  <?php if($pixel_facebook != ""): ?>

    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '<?php echo $pixel_facebook ?>');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=<?php echo $pixel_facebook ?>&ev=PageView&noscript=1"
    /></noscript>
  <!-- End Facebook Pixel Code -->


  <?php endif ?>

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">


  <?php 

  /*=============================================
  Verificación de usuarios
  =============================================*/

  if(isset($_GET["confirm"])){

    $url = "users?linkTo=confirm_user&equalTo=".$_GET["confirm"];
    $method = "GET";
    $fields = array();

    $confirm = CurlController::request($url,$method,$fields);

    if($confirm->status == 200){

      $url = "users?id=".$confirm->results[0]->id_user."&nameId=id_user&token=no&except=verification_user";
      $method = "PUT";
      $fields = "verification_user=1";

      $verification = CurlController::request($url,$method,$fields);

      if($verification->status == 200){


        if(isset($_SESSION["user"])){

          $_SESSION["user"]->verification_user = 1;

        }

        echo '<script>
        fncToastr("success", "Felicidades su cuenta ha sido verificada, ya puede ingresar al sistema y utilizar todas las funciones");
        </script>';

      }

    }else{

        echo '<script>
        fncToastr("error", "El código de verificación esta mal escrito");
        </script>';

    }

  }


  ?>

  <input type="hidden" id="urlPath" value="<?php echo $path ?>">
<div class="wrapper">

	<?php 

  include "modules/top.php"; 
  include "modules/navbar.php"; 

  if (isset($_SESSION["admin"])){
    include "modules/sidebar.php"; 
  }

  

  if(!empty($routesArray[0])) {

    /*=============================================
    Filtro de lista blanca
    =============================================*/

    if($routesArray[0] == "admin" ||
       $routesArray[0] == "perfil" ||
       $routesArray[0] == "salir" ||
       $routesArray[0] == "carrito" ||
       $routesArray[0] == "checkout" ||
       $routesArray[0] == "thanks" ||
       $routesArray[0] == "aprendizaje" ||
       $routesArray[0] == "no-found"){

      include "pages/".$routesArray[0]."/".$routesArray[0].".php";

    }else{

      /*=============================================
      Buscar coincidencia url - producto
      =============================================*/

      $url = "products?linkTo=url_product&equalTo=".$routesArray[0]."&select=url_product";
      $product = CurlController::request($url,$method,$fields);
      
      if($product->status == 200){

        include "pages/product/product.php";

      }else{

        /*=============================================
        Buscar coincidencia url - categoría
        =============================================*/

        $url = "categories?linkTo=url_category&equalTo=".$routesArray[0]."&select=url_category";
        $category = CurlController::request($url,$method,$fields);
        
        if($category->status == 200){

          include "pages/products/products.php";

        }else{

          /*=============================================
          Buscar coincidencia url - subcategoría
          =============================================*/

          $url = "subcategories?linkTo=url_subcategory&equalTo=".$routesArray[0]."&select=url_subcategory";
          $subcategory = CurlController::request($url,$method,$fields);
          
          if($subcategory->status == 200){

            include "pages/products/products.php";

          }else{

            /*=============================================
            Filtro de productos gratuitos y demás
            =============================================*/
          
            if($routesArray[0] == "free" ||
               $routesArray[0] == "most-seen" ||
               $routesArray[0] == "most-sold"){

                include "pages/products/products.php";

            }else{

              /*=============================================
              Filtro de búsqueda
              =============================================*/
              
              $linkTo = ["name_product","keywords_product","name_category","keywords_category","name_subcategory","keywords_subcategory"];
              $totalSearch = 0;

              foreach ($linkTo as $key => $value) {

                $totalSearch++;
                
                $url = "relations?rel=products,subcategories,categories&type=product,subcategory,category&linkTo=".$value."&search=".$routesArray[0]."&select=id_product";
                $search = CurlController::request($url,$method,$fields);

                if($search->status == 200){
   
                  include "pages/products/products.php";
                 
                  break;

                }//Finaliza Filtro de búsqueda

              }

              if($totalSearch == count($linkTo)){

                include "pages/404/404.php";

              }
                
            }//Finaliza Filtro de productos gratuitos y demás

          }//Finaliza Filtro de url subcategorías

        }//Finaliza Filtro de url categorías

      }//Finaliza Filtro de url productos

    }//Finaliza Filtro de lista blanca

  }else{

    include "pages/home/home.php";
  
  }

  include "modules/footer.php"; 
  include "modules/modals.php"; 

  ?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- AdminLTE App -->
<script src="<?php echo $path ?>views/assets/js/plugins/adminlte/adminlte.min.js"></script>
<script src="<?php echo $path ?>views/assets/js/products/products.js"></script>

<script>
fbq("track", "ViewContent"); 
</script>

</body>
</html>


