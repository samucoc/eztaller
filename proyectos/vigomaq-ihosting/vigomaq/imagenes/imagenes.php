<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Panel de Control</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<script language="JavaScript">
<!--
var nav4 = window.Event ? true : false;
function acceptNum(evt){	
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
var key = nav4 ? evt.which : evt.keyCode;	
return (key <= 13 || (key >= 48 && key <= 57));
}
//-->
</script>
<script type="text/javascript">
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con Exito!");
  document.location = 'imagenes.php';
  
}
 //-->
</script>
<script language="JavaScript" type="text/javascript">
function activa(){
document.frmDatos.imagenes.disabled=false;
}
</script>
</head>

<body>
<table class="bord_img" width="600" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><font><span class="maincontainer"> 
      <?php
  	    {
			include("../conex.php");
			$link=Conectarse();

	    }
	 ?>
      <?php
			{
				$valor1 = $_GET["id"];
				echo "valor 1 = $valor1";
				if (empty($valor1)){
				
				}else{
					  	$link=Conectarse();
						$sql = "SELECT * FROM vigomaq.equipo WHERE cod_equipo ='$valor1'";
						echo "sql= $sql<br>";
						$res = mysql_query($sql,$link) or die(mysql_error()); 
						$registro = @mysql_fetch_array($res);
				}
			}
		?>
      </span><span class="maincontainer"><font><span class='titulo'> 
      <? if (empty($valor1)){?>
      Ingreso de Productos</span></font> </span> 
      <?  }else{ ?>
      <span class='titulo'> Edici�n de </span><span class='titulo'>Productos</span> 
      <? } ?>
      </font></td>
  </tr>
  <tr> 
    <td width="664"><span class="maincontainer"> </span></td>
  </tr>
  <tr> 
    <td><FORM action="imagenes.php" method="POST" name="frmDatos" id="frmDatos">
      <table width="90%" border="0">
      <tr class="bord_img">
        <td colspan="2"><div align="right">
          <table width="90%" border="0">
            <tr>
              <td width="146" height="25" class="menu_texto"><div align="left">Código: </div></td>
              <td width="321"><div align="left">
                <input  name="txt_codigo" type="text" value="<?=$registro['cod_equipo'];?>">
              </div>
              <td width="84"><div align="center">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?=$registro['cod_equipo'];?>">
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Producto:</div></td>
              <td><div align="left">
                <input name="txt_producto" type="text" value="<?=$registro['nombre_equipo'];?>" size="45">
                <? echo ($_POST['txt_prod']);?></div>
              <td></td>
            </tr>
            <tr>
              <td><div align="left">Activo: </div></td>
              <td><div align="left"></div>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Evento Asociado:</div></td>
              <td align="left">
              <td></td>
            </tr>
            <tr>
              <td height="23"><div align="left">Mensaje:</div></td>
              <td><div align="left"><?php 
					$result = mysql_query("SELECT * FROM vigomaq.equipo WHERE cod_equipo= '$valor1'"); 
					if (!$result) {
					    echo 'no se pudo: ' . mysql_error();
				    exit;
					}
					$row=mysql_fetch_array($result); 
							echo '<div class="strip_of_thumbnails">';
									{	
										if (!empty($row['cod_equipo']) && is_dir('../images/producto'.$row['cod_equipo'].'/'))
										   {
										   $codproducto = $row['cod_equipo'];
										   $codproducto2 = $row['cod_equipo'];
										   $codproducto2 = preg_replace("/�/", "%D1", $codproducto2);
										   $codproducto2 = preg_replace("/�/", "%F1", $codproducto2);
											
										   $result2 = mysql_query("SELECT cod_equipo FROM vigomaq.equipo WHERE cod_equipo= '$valor1'" );
										   echo($result2);				
											$row2=@mysql_fetch_array($result2); 
											echo '<div class="logo">'.'<a href="ficha.php?id='.$codproducto2.'"><img src="../images/producto'.$codproducto2.'/destac/foto0.destac.jpg"></a></div>'; 
											}
								echo '</div>';
					}
?></div></td>
              <td></td>
            </tr>
            <tr>
              <td><div align="left">Valor:</div></td>
              <td><div align="left"></div></td>
              <td></td>
            </tr>
            <tr class="bord_img">
              <td><div align="left">Stock:</div></td>
              <td><div align="left"></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr class="bord_img">
              <td valign="middle"><div align="left">Descripci&oacute;n</div></td>
              <td colspan="2"><div align="left"></div></td>
            </tr>
            <tr class="bord_img">
              <td height="27">&nbsp;</td>
              <td colspan="2"><div align="right">
                <input type="submit" name="OK" value="Guardar y Seguir" title="Guardar y continuar" class="boton"/>
                <br>
              </div></td>
            </tr>
            <tr class="bord_img">
              <td height="26">&nbsp;</td>
            </tr>
            <tr class="bord_img">
              <td colspan="2"><?php 
				if (empty($registro['cod_equipo'])) 
					{
						echo "<br>";
							} else  {
						echo '<a href="subir.php?id='.$registro['cod_equipo'].'" class="boton">Ingresar Im�genes</a></td>';
					}
			?>
              </tr>
            <? $idprop = $registro['cod_equipo']; ?>
            <tr class="bord_img">
              <td height="26">&nbsp;</td>
              <td colspan="2"><?php 
			$dir = "../images/producto".$idprop."/";
			echo($dir);
			if (empty($registro['cod_equipo'])) 
				{
					echo "Para ingresar im�genes primero debe guardar el producto";
		?></td>
            </tr>
          </table>
        </div></td>
      </tr>
      </table>
    </FORM></td>
  </tr>
</table>
<p>
  <? } else if(!is_dir($dir)) {
				echo "No existen im�genes asociadas a este producto, Si desea agregar alguna presione Ingresar Im�genes"; ?>
  </td>
  </td>
  </tr>
  </table>
  </div>
  </form>
  <? } else { ?>
  </td>
  </td>
  </tr>
  </table>
  </div>
  </form>
  <? 
  }?>
</p>
</body>
</html>

<?php
	function mensaje()
		{
			echo "<script>
			alert('Ingrese Producto y Código');
			</script>";
		}
	?>

<?php    
if($_POST['OK']=='Guardar y Seguir'){
    $producto       = $_POST['txt_producto']; 
	$cod_producto   = $_POST['txt_codigo']; 
	if (empty($producto)||empty($cod_producto)){  
		$link=mensaje();
	} else {
		$producto       = $_POST['txt_producto']; 
		$cod_producto   = $_POST['txt_codigo']; 
		
		$codigo = $_POST['txt_cod'];	
		if (empty($codigo))
		{
			 mysql_query("insert into vigomaq.equipo (nombre_equipo) values ('$nombre')",$link);
			 mysql_close($link);
			 echo ($_POST['cod_producto']);
			 echo "<script> alert (\"Producto creado con Exito. Ahora usted podrá ingresar las imágenes al Producto.\"); </script>";
			 echo "<script language=Javascript> location.href=\"imagenes.php?id=".$cod_producto."\"; </script>";  
		 } else {
			$sql = "UPDATE vigomaq.equipo SET nombre_equipo='$nombre' where cod_equipo='$cod_producto'";
			$res  = mysql_query($sql) or die(mysql_error());
			
			echo "<script> alert (\"Registros actualizados con Exito.\"); </script>";
			echo "<script language=Javascript> location.href=\"imagenes.php?id=".$cod_producto."\"; </script>";
		  }	

   }
 }
?>
 
