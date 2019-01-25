<?php	

	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_mh_ncorr'])){
		$errors[] = "Menu vacío";
	} if (empty($_POST['mod_m_ncorr'])){
		$errors[] = "Menu vacío";
	} else if (empty($_POST['mod_p_ncorr'])){
		$errors[] = "Perfil vacío";
	} else if (
		!empty($_POST['mod_m_ncorr']) &&
		!empty($_POST['mod_mh_ncorr']) &&
		!empty($_POST['mod_p_ncorr']) 
	){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$m_ncorr=$_POST["mod_m_ncorr"];
		$mh_ncorr=$_POST["mod_mh_ncorr"];
		$p_ncorr=$_POST["mod_p_ncorr"];
		
		$id=$_POST['mod_id'];

		$sql="UPDATE  perfiles_tienen_menus_hijos
					SET menu=\"$m_ncorr\", 
						menu_hijo=\"$mh_ncorr\", 
						perfil=\"$p_ncorr\
			WHERE ptm_ncorr=$id";
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