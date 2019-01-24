<?php	

	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
    } else if (empty($_POST['mod_m_ncorr'])){
		$errors[] = "Menu vacío";
	} else if (empty($_POST['mod_descripcion'])){
		$errors[] = "Descripción vacío";
	} else if (empty($_POST['mod_icono'])) {
           $errors[] = "Ícono vacío";
    } else if (empty($_POST['mod_link'])){
		$errors[] = "Link vacío";
	} else if (empty($_POST['mod_estado'])) {
           $errors[] = "Estado vacío";
    } else if (empty($_POST['mod_orden'])){
		$errors[] = "Orden vacío";
	} else if (
		!empty($_POST['mod_m_ncorr']) &&
		!empty($_POST['mod_nombre']) &&
		!empty($_POST['mod_descripcion']) &&
		!empty($_POST['mod_icono']) &&
		!empty($_POST['mod_link']) &&
		!empty($_POST['mod_estado']) &&
		!empty($_POST['mod_orden']) 
	){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$m_ncorr=$_POST["mod_m_ncorr"];
		$nombre=$_POST["mod_nombre"];
		$descripcion=$_POST["mod_descripcion"];
		$icono=$_POST["mod_icono"];
		$link=$_POST["mod_link"];
		$estado=$_POST["mod_estado"];
		$orden=$_POST["mod_orden"];
		$id=$_POST['mod_id'];

		$sql="UPDATE menus_hijos
					SET m_ncorr=\"$m_ncorr\", 
						nombre=\"$nombre\", 
						descripcion=\"$descripcion\"  ,
						icono=\"$icono\", 
						link=\"$link\"  ,
						estado=\"$estado\", 
						orden=\"$orden\"  ,
						updated = '".date("Y-m-d H:i:s")."',
						usuario = '".$_SESSION['user_id']."
			WHERE mh_ncorr=$id";
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