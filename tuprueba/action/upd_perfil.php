<?php	

	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        } else if (empty($_POST['mod_descripcion'])){
			$errors[] = "Descripción vacío";
		} else if (
			!empty($_POST['mod_nombre']) &&
			!empty($_POST['mod_descripcion'])
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$nombre=$_POST["mod_nombre"];
		$descripcion=$_POST["mod_descripcion"];
		$id=$_POST['mod_id'];

		$sql="UPDATE perfiles SET nombre=\"$nombre\", descripcion=\"$descripcion\"  WHERE p_ncorr=$id";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Datos actualizados satisfactoriamente.";

			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
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