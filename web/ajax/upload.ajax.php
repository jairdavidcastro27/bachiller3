<?php

if(isset($_FILES["file"]["name"])){

	if (!$_FILES['file']['error']) {

		/*=============================================
		Validamos el formato de la imagen
		=============================================*/

		if($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/gif"){

			/*=============================================
			Validamos el peso de la imagen
			=============================================*/

			if($_FILES["file"]["size"] < 10000000){

				/*=============================================
				Configuramos la ruta del directorio donde se guardará la imagen
				=============================================*/

				$directory = strtolower('../views/assets/img/temp');

				/*=============================================
				Preguntamos primero si no existe el directorio, para crearlo
				=============================================*/

				if(!file_exists($directory)){

					mkdir($directory, 0755);

				}

				/*=============================================
				Creamos el nombre de la imagen
				=============================================*/

				$name = rand(10000000, 99999999).getdate()['seconds'];

				/*=============================================
				Capturamos la extensión del archivo
				=============================================*/

				$extension = explode('.', $_FILES['file']['name']);

				/*=============================================
				Asignamos nombre y extensión
				=============================================*/

				$file = $name.'.'.$extension[count($extension)-1];

				/*=============================================
				Movemos el archivo al directorio nuevo
				=============================================*/

				$end = $_FILES["file"]["tmp_name"];
				$start = $directory.'/'.$file; 

				move_uploaded_file($end, $start);

				echo '/views/assets/img/temp/'.$file;			

			}else{

				echo  'size';

			}

		}else{

			echo  'type';

		}

	}else{

		echo 'process';
	}

}
