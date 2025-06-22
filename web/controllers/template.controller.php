<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

class TemplateController{

	/*=============================================
	Traemos la Vista Principal de la plantilla
	=============================================*/

	public function index(){

		include "views/template.php";
	}

	/*=============================================
	Ruta Principal o Dominio del sitio
	=============================================*/

	static public function path(){

		if(!empty($_SERVER["HTTPS"]) && ("on" == $_SERVER["HTTPS"])){

			return "https://".$_SERVER["SERVER_NAME"]."/";

		}else{

			return "http://".$_SERVER["SERVER_NAME"]."/";
		}

	}

	/*=============================================
	Función para enviar correos electrónicos
	=============================================*/

	static public function sendEmail($subject, $email, $title, $message, $link){

		date_default_timezone_set("America/Bogota");

		$mail = new PHPMailer;

		$mail->CharSet = 'utf-8';
		//$mail->Encoding = 'base64'; //Habilitar al subir el sistema a un hosting

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com'; // Usar Gmail como servidor SMTP
		$mail->SMTPAuth = true;
		$mail->Username = 'cjair759@gmail.com'; // Usar correo directamente
		$mail->Password = 'bgtq jwfr pefd vxsb'; // Usar contraseña directamente
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usar encriptación STARTTLS
		$mail->Port = 587; // Usar el puerto 587
		$mail->SMTPDebug = 0; // Desactivar depuración para ocultar logs SMTP

		$mail->setFrom("noreply@ecommerce.com","Briana");

		if($email == null){

			$email = "admin@ecommerce.com";
		}

		$mail->Subject = $subject;

		$mail->addAddress($email);

		$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-top:40px; padding-bottom: 40px;">
		
			<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
				
				<center>

    <h2 style="font-weight: bold; color: #333; margin-bottom: 10px;">Briana</h2>

    <h3 style="font-weight:100; color:#999">'.$title.'</h3>

    <hr style="border:1px solid #ccc; width:80%">

    '.$message.'

    <a href="'.$link.'" target="_blank" style="text-decoration: none;">
    	
    	<div style="line-height:25px; background:#000; width:60%; padding:10px; color:white; border-radius:5px">Haz clic aquí</div>
    </a>

    <br>

    <hr style="border:1px solid #ccc; width:80%">

    <h5 style="font-weight:100; color:#999">Si no solicitó el envío de este correo, comuniquese con nosotros de inmediato.</h5>

</center>

			</div>

		</div>');

		$send = $mail->Send();

		if (!$send) {
			error_log("SMTP Error: " . $mail->ErrorInfo); // Registrar el error en el log
			error_log("Verifica las credenciales y la conectividad al servidor SMTP.");
			return $mail->ErrorInfo;
		} else {
			return "ok";
		}
	}

	/*=============================================
	Función Limpiar HTML
	=============================================*/	

	static public function htmlClean($code){

		$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');

		$replace = array('>','<','\\1');

		$code = preg_replace($search, $replace, $code);

		$code = str_replace("> <", "><", $code);

		return $code;
	}

	/*=============================================
	Función para mayúscula inicial
	=============================================*/

	static public function capitalize($value){

		$value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
	    return $value;

	}

	/*=============================================
	Función Reducir texto
	=============================================*/

	static public function reduceText($value, $limit){

		if(strlen($value) > $limit){

			$value = substr($value, 0, $limit)."...";

		}

		return $value;

	}

	/*=============================================
	Función para almacenar imágenes
	=============================================*/

	static public function saveImage($image,$folder,$name,$width,$height){

		if(isset($image["tmp_name"]) && !empty($image["tmp_name"])){ 

			/*=============================================
			Configuramos la ruta del directorio donde se guardará la imagen
			=============================================*/

			$directory = strtolower("views/".$folder);

			/*=============================================
			Preguntamos primero si no existe el directorio, para crearlo
			=============================================*/

			if(!file_exists($directory)){

				mkdir($directory, 0755);

			}

			/*=============================================
			Capturar ancho y alto original de la imagen
			=============================================*/

			list($lastWidth, $lastHeight) = getimagesize($image["tmp_name"]);


			if($lastWidth < $width || $lastHeight < $height){

				$lastWidth = $width;
				$lastHeight = $height;

			}

			/*=============================================
			De acuerdo al tipo de imagen aplicamos las funciones por defecto
			=============================================*/

			if($image["type"] == "image/jpeg"){

				//definimos nombre del archivo
				$newName = $name.'.jpg';

				//definimos el destino donde queremos guardar el archivo
				$folderPath = $directory.'/'.$newName;

				if(isset($image["mode"]) && $image["mode"] == "base64"){

					file_put_contents($folderPath, file_get_contents($image["tmp_name"]));

				}else{

					//Crear una copia de la imagen
					$start = imagecreatefromjpeg($image["tmp_name"]);

					//Instrucciones para aplicar a la imagen definitiva
					$end = imagecreatetruecolor($width, $height);

					imagecopyresized($end,  $start,  0, 0,  0, 0,$width, $height, $lastWidth, $lastHeight);

					imagejpeg($end, $folderPath);

				}


			}

			if($image["type"] == "image/png"){

				//definimos nombre del archivo
				$newName  = $name.'.png';

				//definimos el destino donde queremos guardar el archivo
				$folderPath = $directory.'/'.$newName;

				if(isset($image["mode"]) && $image["mode"] == "base64"){

					file_put_contents($folderPath, file_get_contents($image["tmp_name"]));

				}else{

					//Crear una copia de la imagen
					$start = imagecreatefrompng($image["tmp_name"]);

					//Instrucciones para aplicar a la imagen definitiva
					$end = imagecreatetruecolor($width, $height);

					imagealphablending($end, FALSE);
					
					imagesavealpha($end, TRUE);	

					imagecopyresampled($end, $start, 0, 0, 0, 0, $width, $height, $lastWidth, $lastHeight);

					imagepng($end, $folderPath);

				}


			}

			if($image["type"] == "image/gif"){

				$newName = $name.'.gif';

				$folderPath = $directory.'/'.$newName;	

				if(isset($image["mode"]) && $image["mode"] == "base64"){

					file_put_contents($folderPath, file_get_contents($image["tmp_name"]));

				}else{
					
					move_uploaded_file($image["tmp_name"], $folderPath);

				}	

			}

			return $newName;

		}else{

			return "error";

		}

	}

	/*=============================================
	Función para generar códigos alfanuméricos aleatorios
	=============================================*/

	static public function genPassword($length){

		$password = "";
		$chain = "0123456789abcdefghijklmnopqrstuvwxyz";

		$password = substr(str_shuffle($chain),0,$length);

		return $password;
	}

	/*=============================================
	Función para redireccionar al mismo lugar
	=============================================*/

	static public function urlRedirect(){

		if(!empty($_SERVER["HTTPS"]) && ("on" == $_SERVER["HTTPS"])){

			return "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		}else{

			return "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		
	}

	/*=============================================
	Función para generar códigos numéricos aleatorios
	=============================================*/

	static public function genCodec($length){

		$codec = rand(1*$length,(10*$length)-1).Time();

		return $codec;
	}

	/*=============================================
	Convertidor de moneda
	=============================================*/

	static public function exchange($type){

		$ip = $_SERVER["HTTP_X_REAL_IP"] ?? $_SERVER["REMOTE_ADDR"] ?? '127.0.0.1';
		$data = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

		if(json_decode($data)->geoplugin_status == 200){

			if($type == "currency"){

				return json_decode($data)->geoplugin_currencyConverter; 
			}

			if($type == "country"){

				return json_decode($data)->geoplugin_countryName;
			}

			if($type == "ip"){

				return json_decode($data)->geoplugin_request;
			}

			if($type == "timezone"){

				return json_decode($data)->geoplugin_timezone;
			}

		}else{

			return "error";
		}

	}

	/*=============================================
	Función para dar formato a las fechas
	=============================================*/

	static public function formatDate($type, $value){

		$timezone = TemplateController::exchange("timezone");
		if ($timezone && $timezone !== 'error') {
		    date_default_timezone_set($timezone);
		} else {
		    error_log("Invalid timezone: $timezone");
		    date_default_timezone_set("UTC");
		}

		setlocale(LC_TIME, 'es_VE.UTF-8','esp'); //Para traer dias y meses en español

		if($type == 1){

			return strftime("%d %B, %Y", strtotime($value));
		}

		if($type == 2){

			return strftime("%b %Y", strtotime($value));

		}

		if($type == 3){

			return strftime("%d - %m - %Y", strtotime($value));

		}

		if($type == 4){

			return strftime("%d/%m/%Y", strtotime($value));

		}

	}

}