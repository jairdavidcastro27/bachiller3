<?php

require_once "../controllers/curl.controller.php";

class FormsController{

    /*=============================================
   	Validar títulos repetidos
    =============================================*/

    public $table;
    public $equalTo;
    public $linkTo;

    public function ajaxForms(){

    	$url = $this->table."?equalTo=".urlencode($this->equalTo)."&linkTo=".$this->linkTo."&select=".$this->linkTo;	
    	$method = "GET";
		$fields = array();

		$data = CurlController::request($url, $method, $fields);

		echo $data->status;

    }

    /*=============================================
   	Selector Anidado
    =============================================*/

    public $idCategory;

    public function listSubcategories(){

    	$select = "id_subcategory,name_subcategory";
    	$url = "subcategories?linkTo=id_category_subcategory&equalTo=".$this->idCategory."&select=".$select; 

    	$method = "GET";
        $fields = array();

        $data = CurlController::request($url, $method, $fields)->results; 

        echo json_encode($data);
    }

    /*=============================================
    Adicionar favoritos en base de datos
    =============================================*/

    public $idProduct;
    public $token;

    public function addFavorites(){

        $select = "id_user";
        $url = "users?linkTo=token_user&equalTo=".$this->token."&select=".$select; 
        $method = "GET";
        $fields = array();

        $data = CurlController::request($url, $method, $fields); 
        
        if($data->status == 200){

            $url = "favorites?token=".$this->token."&table=users&suffix=user";
            $method = "POST";
            $fields = array(
                "id_user_favorite" => $data->results[0]->id_user,
                "id_product_favorite" => $this->idProduct,
                "date_created_favorite" => date("Y-m-d")
            );

            $addFavorite = CurlController::request($url, $method, $fields); 
            
            if($addFavorite->status == 200){
                echo json_encode($addFavorite->results);
            }   

        }

    }

    /*=============================================
    Remover favoritos en base de datos
    =============================================*/

    public $idFavorite;

    public function remFavorite(){

        $url = "favorites?id=".$this->idFavorite."&nameId=id_favorite&token=".$this->token."&table=users&suffix=user";
        $method = "DELETE";
        $fields = array();

        $remFavorite = CurlController::request($url, $method, $fields);

        echo $remFavorite->status;
    }

     /*=============================================
    Adicionar al carrito de compras en base de datos
    =============================================*/

    public $idProductCart;
    public $idVariantCart;
    public $quantityCart;

    public function addCart(){

        $select = "id_user";
        $url = "users?linkTo=token_user&equalTo=".$this->token."&select=".$select; 
        $method = "GET";
        $fields = array();

        $data = CurlController::request($url, $method, $fields); 
        
        if($data->status == 200){

            $url = "carts?token=".$this->token."&table=users&suffix=user";
            $method = "POST";
            $fields = array(
                "id_user_cart" => $data->results[0]->id_user,
                "id_product_cart" => $this->idProductCart,
                "id_variant_cart" => $this->idVariantCart,
                "quantity_cart" => $this->quantityCart,
                "date_created_cart" => date("Y-m-d")
            );

            $addCart = CurlController::request($url, $method, $fields);

            echo $addCart->status;         

        }


    }


    /*=============================================
    Actualizar Cantidad carrito de compras en base de datos
    =============================================*/

    public $idCartUpdate;
    public $quantityCartUpdate;

    public function updateCart(){
      
        $url = "carts?id=".$this->idCartUpdate."&nameId=id_cart&token=".$this->token."&table=users&suffix=user";
      
        $method = "PUT";
        $fields = "quantity_cart=".$this->quantityCartUpdate;

        $updateCart = CurlController::request($url, $method, $fields);

        echo $updateCart->status;         

    }

     /*=============================================
    Remover carrito en base de datos
    =============================================*/

    public $idCartDelete;

    public function remCart(){

        $url = "carts?id=".$this->idCartDelete."&nameId=id_cart&token=".$this->token."&table=users&suffix=user";
        $method = "DELETE";
        $fields = array();

        $remCart = CurlController::request($url, $method, $fields);

        echo $remCart->status;

     }

}

if(isset($_POST["table"])){

	$forms = new FormsController();
	$forms -> table = $_POST["table"];
	$forms -> equalTo = $_POST["equalTo"];
	$forms -> linkTo = $_POST["linkTo"];
	$forms -> ajaxForms();
}

if(isset($_POST["idCategory"])){

	$data = new FormsController();
	$data -> idCategory = $_POST["idCategory"];
	$data -> listSubcategories();
}

if(isset($_POST["idProduct"])){

    $addFavorites = new FormsController();
    $addFavorites -> token = $_POST["token"];
    $addFavorites -> idProduct = $_POST["idProduct"];
    $addFavorites -> addFavorites();
}

if(isset($_POST["idFavorite"])){

    $remFavorites = new FormsController();
    $remFavorites -> token = $_POST["token"];
    $remFavorites -> idFavorite = $_POST["idFavorite"];
    $remFavorites -> remFavorite();
}

if(isset($_POST["idProductCart"])){

    $addCart = new FormsController();
    $addCart -> token = $_POST["token"];
    $addCart -> idProductCart = $_POST["idProductCart"];
    $addCart -> idVariantCart = $_POST["idVariantCart"];
    $addCart -> quantityCart = $_POST["quantityCart"];
    $addCart -> addCart();
}

if(isset($_POST["idCartUpdate"])){

    $updateCart = new FormsController();
    $updateCart -> token = $_POST["token"];
    $updateCart -> idCartUpdate = $_POST["idCartUpdate"];
    $updateCart -> quantityCartUpdate = $_POST["quantityCartUpdate"];
    $updateCart -> updateCart();
}

if(isset($_POST["idCartDelete"])){

    $remCart = new FormsController();
    $remCart -> token = $_POST["token"];
    $remCart -> idCartDelete = $_POST["idCartDelete"];
    $remCart -> remCart();
}
