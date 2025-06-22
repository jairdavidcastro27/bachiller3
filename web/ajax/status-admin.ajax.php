<?php

require_once "../controllers/curl.controller.php";

class StatusController{

	public $token;
    public $table;
    public $id;
    public $column;
    public $status;

    public function ajaxStatus(){

        $url = $this->table."?id=".base64_decode($this->id)."&nameId=id_".$this->column."&token=".$this->token."&table=admins&suffix=admin";
        $method = "PUT";
        $fields = "status_".$this->column."=".$this->status;

        $status= CurlController::request($url, $method, $fields);

        echo $status->status;

    }

}

if(isset($_POST["status"])){

    $Status = new StatusController();
    $Status -> token = $_POST["token"];
    $Status -> table = $_POST["table"];
    $Status -> id = $_POST["id"];
    $Status -> status = $_POST["status"];
    $Status -> column = $_POST["column"];
    $Status -> ajaxStatus();

}