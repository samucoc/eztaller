<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
    } else if (empty($_POST['descripcion'])){
		$errors[] = "Descripción vacío";
	} else if (empty($_POST['icono'])) {
           $errors[] = "Ícono vacío";
    } else if (empty($_POST['link'])){
		$errors[] = "Link vacío";
	} else if (empty($_POST['estado'])) {
           $errors[] = "Estado vacío";
    } else if (empty($_POST['orden'])){
		$errors[] = "Orden vacío";
	} else if (
		!empty($_POST['nombre']) &&
		!empty($_POST['descripcion']) &&
		!empty($_POST['icono']) &&
		!empty($_POST['link']) &&
		!empty($_POST['estado']) &&
		!empty($_POST['orden']) 
	){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$icono=$_POST["icono"];
		$link=$_POST["link"];
		$estado=$_POST["estado"];
		$orden=$_POST["orden"];
		
		$sql="INSERT INTO menus ( nombre, descripcion ,icono, link ,estado, orden, created, usuario) 
			  VALUES ('$nombre','$descripcion','$icono','$link','$estado','$orden','".date("Y-m-d H:i:s")."','".$_SESSION['user_id']."')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "El menú ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		
		}else{
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>