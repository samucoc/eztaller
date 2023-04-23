<? 
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
<?
		 $idproducto = $_POST['idpropiedad'];
		 echo($idproducto);
   //Preguntamos si nuetro arreglo fue definido
  
		 $nombre_archivo = "../images/producto".$idproducto."/thumb/"; 
		if (file_exists($nombre_archivo)) { 
					eliminar_carpeta(str_replace(" ", "","../images/producto".$idproducto."/thumb/"));
					rmdir(str_replace(" ", "","../images/producto".$idproducto."/thumb/"));
					
					eliminar_carpeta(str_replace(" ", "","../images/producto".$idproducto."/destac/"));
					rmdir(str_replace(" ", "","../images/producto".$idproducto."/destac/"));
					
					eliminar_carpeta(str_replace(" ", "","../images/producto".$idproducto."/left/"));
					rmdir(str_replace(" ", "","../images/producto".$idproducto."/left/")); 
					
					eliminar_carpeta(str_replace(" ", "","../images/producto".$idproducto."/"));
					rmdir(str_replace(" ", "","../images/producto".$idproducto."/"));
		} else {  
		} 
		
	 	 $dir = "../images/producto".$idproducto."/";
		 echo ($dir);
		 if (!is_dir($dir)) {
			mkdir ("../images/producto".$idproducto."/", 0755);
			mkdir ("../images/producto".$idproducto."/destac/", 0755);
			mkdir ("../images/producto".$idproducto."/thumb/", 0755);
			mkdir ("../images/producto".$idproducto."/left/", 0755);
			} else {
			echo("<b>Agregando Imágenes</b><br />");
		}

		$x = "0";
         if (isset ($_FILES["archivos"])) {
	         $tot = count($_FILES["archivos"]["name"]);
    	     for ($i = 0; $i < $tot; $i++){
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
            echo("<b>Se ha subido la foto </b>");
            echo($name);
            echo("<br />");
			

			$fotoexiste = "../images/producto".$idproducto."/foto".$x.".jpg";
			while (file_exists($fotoexiste))
			{
						$x++;
						$fotoexiste = "../images/producto".$idproducto."/foto".$x.".jpg";
			}
			rename($tmp_name, "../images/producto".$idproducto."/foto".$x.".jpg");
			chmod("../images/producto".$idproducto."/foto".$x.".jpg", 0644);
			$fotobuena = "../images/producto".$idproducto."/foto".$x.".jpg";
			$thumbnail = "../images/producto".$idproducto."/destac/foto".$x.".destac.jpg";
			$thumbnail2 = "../images/producto".$idproducto."/left/foto".$x.".left.jpg";
			$thumbnail3 = "../images/producto".$idproducto."/thumb/foto".$x.".thumb.jpg";
			
			$original = imagecreatefromjpeg($fotobuena);
			$thumb = imagecreatetruecolor(258,173); 
			$ancho = imagesx($original);
			$alto = imagesy($original);
			imagecopyresampled($thumb,$original,0,0,0,0,258,173,$ancho,$alto);
			imagejpeg($thumb,$thumbnail,100);
			
			$original2 = imagecreatefromjpeg($fotobuena);
			$thumb2 = imagecreatetruecolor(258,173); 
			$ancho2 = imagesx($original2);
			$alto2 = imagesy($original2);
			imagecopyresampled($thumb2,$original2,0,0,0,0,258,173,$ancho2,$alto2);
			imagejpeg($thumb2,$thumbnail2,100);
			
			$original3 = imagecreatefromjpeg($fotobuena);
			$thumb3 = imagecreatetruecolor(120,100); 
			$ancho3 = imagesx($original3);
			$alto3 = imagesy($original3);
			imagecopyresampled($thumb3,$original3,0,0,0,0,120,100,$ancho,$alto);
			imagejpeg($thumb3,$thumbnail3,100);
			echo("<br />");
           
      }
 }      

echo "<script> alert (\"Archivos subidos con exito\"); </script>";
echo "<script language=Javascript> location.href=\"../equipo.php?id=".$idproducto."\"; </script>";

return;
?>
