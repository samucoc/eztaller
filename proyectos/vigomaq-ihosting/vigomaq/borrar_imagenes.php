<?php 
	function eliminar_carpeta( $carpeta ){
		$directorio = opendir($carpeta);
		//echo($directorio);
			while ($archivo = readdir($directorio)){
				if( $archivo !='.' && $archivo !='..' ){
						//comprobamos si es un directorio o un archivo
							if ( is_dir( $carpeta.$archivo ) ){
							//si es un directorio, volvemos a llamar a la función para que elimine el contenido del mismo
				eliminar_carpeta( $carpeta.$archivo.'/' );
				rmdir($carpeta.$archivo); //borrar el directorio cuando esté vacío
				} else {
				//si no es un directorio, lo borramos
				unlink($carpeta.$archivo);
			}
		}
	}
closedir($directorio);
}

?>

