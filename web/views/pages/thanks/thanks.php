<?php

if(isset($_GET["ref"])){

  $status = "pending";

  /*=============================================
  Consultar referencia
  =============================================*/

  // $url = "carts?linkTo=ref_cart&equalTo=".$_GET["ref"];
  $url = "relations?rel=carts,variants,products&type=cart,variant,product&linkTo=ref_cart&equalTo=".$_GET["ref"];
  $method = "GET";
  $fields = array();

  // $refs = CurlController::request($url,$method,$fields);
  $carts = CurlController::request($url,$method,$fields);

  if($carts->status == 200){

    $carts = $carts->results;

    /*=============================================
    Validar el pago con PayPal
    =============================================*/

    if($carts[0]->method_cart == "paypal"){

      $url = "v2/checkout/orders/".$carts[0]->order_cart;
      $paypal= CurlController::paypal($url,$method,$fields);

      if($paypal->status == "APPROVED"){

         $status = "ok";

      }

    }

     /*=============================================
    Validar el pago con DLocal
    =============================================*/

    if($carts[0]->method_cart == "dlocal"){

      $url = "v1/payments/".$carts[0]->order_cart;
      $dlocal = CurlController::dlocal($url,$method,$fields);

      if($dlocal->status == "PAID"){

         $status = "ok";

      }

    }

    /*=============================================
    Validar el pago con Mercado Pago
    =============================================*/

    if($carts[0]->method_cart == "mercado_pago"){

      if($carts[0]->order_cart == ""){

        if(isset($_GET["payment_id"])){

          $count = 0;

          foreach ($carts as $key => $value) {

            $count++;
            
            $url = "carts?id=".$value->id_cart."&nameId=id_cart&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
            $method = "PUT";
            $fields = "order_cart=".$_GET["payment_id"];

            $value->order_cart = $_GET["payment_id"];

            $updateCart = CurlController::request($url, $method, $fields);

            if($count == count($carts)){

              $url = "v1/payments/".$_GET["payment_id"];
              $method = 'GET';
              $fields = array();

              $mercadoPago = CurlController::mercadoPago($url,$method,$fields);

              if($mercadoPago->status == "approved"){

                $status = "ok";
             
              }
            
            }
          
          }

        }

      }else{

        $url = "v1/payments/".$carts[0]->order_cart;
        $method = 'GET';
        $fields = array();

        $mercadoPago = CurlController::mercadoPago($url,$method,$fields);

        if($mercadoPago->status == "approved"){

          $status = "ok";
         
       
        }

      }

    }

    /*=============================================
    Crear órdenes de compra y eliminar datos del carrito
    =============================================*/

    if($status == "ok"){

      $count = 0;

      foreach ($carts as $key => $value) {

        if($value->type_variant == "gallery"){

          $process_order = 0;
        
        }else{

           $process_order = 2;
        }

        $url = "orders?token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
        $method = 'POST';
        $fields = array(
          "id_user_order" => $value->id_user_cart,
          "uniqid_order" => uniqid(),
          "id_product_order" => $value->id_product_cart,
          "id_variant_order" => $value->id_variant_cart,
          "quantity_order" => $value->quantity_cart,
          "price_order" => $value->price_cart,
          "ref_order" => $value->ref_cart,
          "number_order" => $value->order_cart,
          "method_order" => $value->method_cart,
          "warranty_order" => 7,
          "process_order" =>  $process_order,
          "start_date_order" => date("Y-m-d"),
          "date_created_order" => date("Y-m-d")

        );

        $orders = CurlController::request($url,$method,$fields);

        if($orders->status == 200){

          /*=============================================
          Actualizamos las ventas del producto
          =============================================*/

          $url = "products?id=".$value->id_product_cart."&nameId=id_product&token=no&except=sales_product";
          $method = "PUT";
          $fields = "sales_product=".$value->sales_product+$value->quantity_cart;

          $updateProduct = CurlController::request($url,$method,$fields);

          /*=============================================
          Eliminamos el carrito de compras
          =============================================*/

          $url = "carts?id=".$value->id_cart."&nameId=id_cart&token=".$_SESSION["user"]->token_user."&table=users&suffix=user";
          $method = "DELETE";
          $fields = array();
          $deleteCart = CurlController::request($url, $method, $fields);

          $count++;

          if($count == count($carts)){

            /*=============================================
            Enviar evento de compra a facebook a través de Navegador
            =============================================*/ 

            $eventID = TemplateController::genCodec(3);

            echo "<script>fbq('track', 'Purchase',
            {
              value: ".$value->price_cart.",
              currency: 'USD',
              contents: [
              {
                id: '".$value->id_product_cart."',
                quantity: ".$value->quantity_cart."
              }],
              content_type: 'product'           
            },{
              eventID: ".$eventID."
            }
            );</script>";

            /*=============================================
            Enviamos correo electrónico de confirmación del pedido
            =============================================*/

            $subject = "Su compra con la tienda Ecommerce ha sido confirmada";
            $email = $_SESSION["user"]->email_user;
            $title = "Referencia del pago ".$_GET["ref"];
            $message = "<h4>La compra del producto ".$carts[0]->name_product." ha sido confirmada y comenzará el proceso de envío</h4>";
            $link = TemplateController::path().'thanks?ref='.$_GET["ref"];

            TemplateController::sendEmail($subject, $email, $title, $message, $link);

          }

        }

      }

    }

  }else{

    /*=============================================
    Traer órdenes de compra
    =============================================*/
    $url = "relations?rel=orders,variants,products&type=order,variant,product&linkTo=ref_order&equalTo=".$_GET["ref"];
    $method = "GET";
    $fields = array();

    $carts = CurlController::request($url,$method,$fields);

    if($carts->status == 200){

      $carts = $carts->results;

      $status = "ok";
    
    }else{

      echo '<script>
         window.location = "'.$path.'404";
      </script>';

    }

  }

}else{

  echo '<script>
     window.location = "'.$path.'404";
  </script>';
}

?>

<!--==========================================
Breadcrumb
===========================================-->

<div class="container-fluid bg-light border mb-2">
  
  <div class="container py-3">

    <div class="d-flex flex-row-reverse lead small">
      
      <div class="px-1 font-weight-bold">¡Gracias por su compra!</div>
      <div class="px-1">/</div>
      <div class="px-1"><a href="/">Inicio</a></div>

    </div>

  </div>

</div>

<!--==========================================
Thanks
===========================================-->

<div class="container my-4">

  <div class="card">

    <div class="card-body bg-light">

      <div class="row row-cols-1 row-cols-lg-2">
          
        <div class="col">
          
          <?php include "modules/datos.php" ?>

        </div>

        <div class="col">
          
          <?php include "modules/carrito.php" ?>

        </div>

      </div>

    </div>

  </div>

</div>

