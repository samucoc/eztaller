<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	/*

'fecha' : $("#fecha").val() , 
                                'movim_bodega' : $("#movim_bodega").val() , 
                                'obervacion' : $("#obervacion").val() , 
                                'arr_codigo' : $("#arr_codigo").val() , 
                                'arr_cantidad' : $("#arr_cantidad").val() , 
                                'arr_descripcion' : $("#arr_descripcion").val()
	*/

	if (empty($_POST['fecha'])) {
           $errors[] = "Fecha vacío";
    } else if (empty($_POST['movim_bodega'])){
		$errors[] = "Bodega vacío";
    } else if (empty($_POST['arr_codigo'])){
		$errors[] = "Sin Códigos";
	} else if (empty($_POST['arr_cantidad'])) {
           $errors[] = "Sin Cantidades";
    } else if (empty($_POST['arr_descripcion'])){
		$errors[] = "Sin Decripcion";
	} else if (
		!empty($_POST['fecha']) &&
		!empty($_POST['movim_bodega']) &&
		!empty($_POST['arr_codigo']) &&
		!empty($_POST['arr_cantidad']) &&
		!empty($_POST['arr_descripcion'])
	){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		// escaping, additionally removing everything that could be (html/javascript-) code
		$fecha=$_POST["fecha"];
		list($d,$m,$a) = explode('-',$fecha);
		$fecha = $a.'-'.$m.'-'.$d;
		$obervacion=$_POST["obervacion"];
		$movim_bodega=$_POST["movim_bodega"];

		$sql="INSERT INTO movim ( `movim_tipo`, `movim_bodega`, `movim_bodega_trans`, `vendedor`, `fecha`, `observacion`, `usuario`, `created`) 
			  VALUES ('4','$movim_bodega','0','xxx','$fecha','$obervacion','".$_SESSION['user_id']."','".date("Y-m-d H:i:s")."')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
 				$m_ncorr = mysqli_insert_id($con);
 				$arr_codigo = explode(',',$_POST["arr_codigo"]);
				$arr_cantidad = explode(',',$_POST["arr_cantidad"]);
				$arr_descripcion = explode(',',$_POST["arr_descripcion"]);

				for($i=1;$i<count($arr_codigo);$i++){
					$sql_1="INSERT INTO `movim_detalle`( `m_ncorr`, `codigo`, `descr`, `cantidad`, `created`) VALUES 
						   ('".$m_ncorr."','".$arr_codigo[$i]."','".$arr_descripcion[$i]."',
						  			'".$arr_cantidad[$i]."','".date("Y-m-d H:i:s")."')";
					$query_new_insert_1 = mysqli_query($con,$sql_1);
					if ($query_new_insert_1){
												
					}
					else{
						$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
					}
				}
				if (!isset($error) ){
					$messages[] = "El ajuste a bodega ha sido completado satisfactoriamente.";	
				}

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