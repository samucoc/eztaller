<?php 
	function eliminar_carpeta( $carpeta ){
		$directorio = opendir($carpeta);
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
<?php
		 $idproducto = $_POST['idpropiedad'];
   //Preguntamos si nuetro arreglo 'archivos' fue definido
  
		 $nombre_archivo = "images/personal".$idproducto."/thumb/"; 
		if (file_exists($nombre_archivo)) { 
					eliminar_carpeta(str_replace(" ", "","images/personal".$idproducto."/thumb/"));
					rmdir(str_replace(" ", "","images/personal".$idproducto."/thumb/"));
					
					eliminar_carpeta(str_replace(" ", "","images/personal".$idproducto."/destac/"));
					rmdir(str_replace(" ", "","images/personal".$idproducto."/destac/"));
					
					eliminar_carpeta(str_replace(" ", "","images/personal".$idproducto."/left/"));
					rmdir(str_replace(" ", "","images/personal".$idproducto."/left/")); 
					
					eliminar_carpeta(str_replace(" ", "","images/personal".$idproducto."/"));
					rmdir(str_replace(" ", "","images/personal".$idproducto."/"));
		} else { 
		} 
		
	 	 $dir = "images/personal".$idproducto."/";
		 if (!is_dir($dir)) {
			mkdir ("images/personal".$idproducto."/", 0755);
			mkdir ("images/personal".$idproducto."/destac/", 0755);
			mkdir ("images/personal".$idproducto."/thumb/", 0755);
			mkdir ("images/personal".$idproducto."/left/", 0755);
			} else {
			echo("<b>Agregando Imágenes</b><br />");
		}

		$x = "0";
         if (isset ($_FILES["archivos"])) {
	         $tot = count($_FILES["archivos"]["name"]);
    	     for ($i = 0; $i < $tot; $i++){
         //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
         //para trabajar con este
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
            echo("<b>Se ha subido la foto </b>");
            echo($name);
            echo("<br />");
			

			$fotoexiste = "images/personal".$idproducto."/foto".$x.".jpg";
			while (file_exists($fotoexiste))
			{
						$x++;
						$fotoexiste = "images/personal".$idproducto."/foto".$x.".jpg";
			}
			// copiandola al producto
			rename($tmp_name, "images/personal".$idproducto."/foto".$x.".jpg");
			chmod("images/personal".$idproducto."/foto".$x.".jpg", 0644);
			$fotobuena = "images/personal".$idproducto."/foto".$x.".jpg";
			$thumbnail = "images/personal".$idproducto."/destac/foto".$x.".destac.jpg";
			$thumbnail2 = "images/personal".$idproducto."/left/foto".$x.".left.jpg";
			$thumbnail3 = "images/personal".$idproducto."/thumb/foto".$x.".thumb.jpg";
			
			$original = imagecreatefromjpeg($fotobuena);
			$thumb = imagecreatetruecolor(258,173); // Lo haremos de un tamaño 150x150
			$ancho = imagesx($original);
			$alto = imagesy($original);
			imagecopyresampled($thumb,$original,0,0,0,0,258,173,$ancho,$alto);
			imagejpeg($thumb,$thumbnail,100);
			
			$original2 = imagecreatefromjpeg($fotobuena);
			$thumb2 = imagecreatetruecolor(258,173); // Lo haremos de un tamaño 150x150
			$ancho2 = imagesx($original2);
			$alto2 = imagesy($original2);
			imagecopyresampled($thumb2,$original2,0,0,0,0,258,173,$ancho2,$alto2);
			imagejpeg($thumb2,$thumbnail2,100);
			
			$original3 = imagecreatefromjpeg($fotobuena);
			$thumb3 = imagecreatetruecolor(120,100); // Lo haremos de un tamaño 150x150
			$ancho3 = imagesx($original3);
			$alto3 = imagesy($original3);
			imagecopyresampled($thumb3,$original3,0,0,0,0,120,100,$ancho,$alto);
			imagejpeg($thumb3,$thumbnail3,100);
			echo("<br />");
           
      }
 }      

// devolver HTML
echo "<script> alert (\"Archivos subidos con exito\"); </script>";
echo "<script language=Javascript> location.href=\"personal.php?codigo=".$idproducto."\"; </script>";
// salir
return;
?>
