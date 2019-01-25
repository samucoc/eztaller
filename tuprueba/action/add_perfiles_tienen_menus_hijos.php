<?php	

	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mh_ncorr'])){
		$errors[] = "Menu vacío";
	} if (empty($_POST['m_ncorr'])){
		$errors[] = "Menu vacío";
	} else if (empty($_POST['p_ncorr'])){
		$errors[] = "Perfil vacío";
	} else if (
		!empty($_POST['m_ncorr']) &&
		!empty($_POST['mh_ncorr']) &&
		!empty($_POST['p_ncorr']) 
	){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$m_ncorr=$_POST["m_ncorr"];
		$mh_ncorr=$_POST["mh_ncorr"];
		$p_ncorr=$_POST["p_ncorr"];
		
		$sql="INSERT INTO  perfiles_tienen_menus_hijos ( menu,  menu_hijo, perfil) 
			  VALUES ('$m_ncorr','$mh_ncorr','$p_ncorr')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "El menú hijo ha sido ingresado satisfactoriamente.";
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