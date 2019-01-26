<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['descripcion'])){
			$errors[] = "Descripción vacío";
		} else if (
			!empty($_POST['descripcion'])
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		// escaping, additionally removing everything that could be (html/javascript-) code
		$descripcion=$_POST["descripcion"];
		
		$sql="INSERT INTO productos ( descricpion) 
			  VALUES ('$descripcion')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "El perfil ha sido ingresado satisfactoriamente.";
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