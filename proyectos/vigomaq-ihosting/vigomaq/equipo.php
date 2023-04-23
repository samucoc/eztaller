<?php ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<?php
require_once('classes/tc_calendar.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
    <link href="estilo_pdf.css" rel="stylesheet" type="text/css" />
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
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
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
<!--
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo22 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.Estilo23 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("Repuesto no ha sido ingresado!");
  document.location = 'equipo.php';
}
 //-->
</script>
<script language="text/javascript">
function confirmReemp()
{
	var agree=confirm("¿Realmente desea actualizar? ");
	if (agree) return true ;
	else return false ;
	
}
</script>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); 
    </style> 
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php'); //modulo cabecera
	?>
    </div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div>
  <table width="60%" height="528" border="0" align="center">
    <tr>
      <td width="80%"><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php
  	    {
			include("conex.php");
			$link=Conectarse();
			mysql_query ("SET NAMES 'utf8'");

	    }
	 ?><?php include("borrar_imagenes.php"); ?>
          <strong><font>
            <?php
			{
				
				if (empty($_GET["id"])){}else{
					$valor2 = $_GET["id"];}
				if (empty($_GET["txt_nombre"])){}else{
					$valor1 = $_GET["txt_nombre"];}
				
				
				if (!empty($valor1)){
				
					$link=Conectarse();
					$sql = "SELECT cod_equipo, cod_estado_equipo, cod_proveedor, descrp_equipo, codigo_fabrica, procedencia_eq, cod_unidad, ubicacion_equipo, marca_equipo, nombre_equipo, fecha_compra, valor_compra, vida_util,fecha_ingreso_arr, valor_unidad_arr, accesorios, cod_motor, id_tipo_equipo FROM vigomaq_intranet.equipo WHERE nombre_equipo ='$valor1'";
					
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
					
					
					}else{
				
					  	$link=Conectarse();
						$sql = "SELECT cod_equipo, cod_estado_equipo, cod_proveedor, descrp_equipo, codigo_fabrica, procedencia_eq, cod_unidad, ubicacion_equipo, marca_equipo, nombre_equipo, fecha_compra, valor_compra, vida_util,fecha_ingreso_arr, valor_unidad_arr, accesorios, cod_motor, id_tipo_equipo FROM vigomaq_intranet.equipo WHERE cod_equipo ='$valor2'";
						
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
					
					
				}
				
				
			}
		?>
            <?php
        if (($_SESSION['tipo_usuario']=="0")||($_SESSION['tipo_usuario']=="2")) {
		   	  $estado_objetos = 'enabled';
           	 
		}else{
			  $estado_objetos = 'disabled';
           	  
		};
		?>
                  
          </font></strong> INVENTARIO EQUIPOS.</font></strong></div>
      </div></td>
    </tr>
    <tr>
      <td height="80" valign="top"><form method="post" action="equipo.php" enctype="multipart/form-data" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td colspan="4" height="8"></td>
            </tr>
            <tr>
              <td colspan="4" bgcolor="#06327D"><span class="Estilo22">BUSCAR EQUIPO</span></td>
            </tr>
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr class="bord_img">
              <td width="269" height="24"><div align="left"><strong>C&oacute;digo Equipo</strong></div></td>
              <td width="9"><strong>:</strong></td>
              <td colspan="2"><strong>
              <input  name="txt_codigo" type="text" size="8" maxlength="8" value=""/>
              
              <input type="submit" name="buscarcodigo" value="Buscar" title="Buscar Equipo por Codigo" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
              
              <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Equipo por Codigo" class="searchbutton" src="images/ver.png"/>-->
              <?php
			  
			    //envia el nombre
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$busca_cod = $_POST['txt_codigo'];
					$busca_cod = (string)(int)$busca_cod;
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eq_ficha.php?id=$busca_cod'>";
				}
				//envia el codigo
				if (($_POST['buscarnombre']=='Buscar'))
				{
					$busca_nom = ltrim($_POST['txt_nombre']);
				
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eq_ficha.php?nombre=$busca_nom'>";
				}
			?>
              &nbsp;<span class="Estilo20">
              <input type="hidden" name="txt_cod2" size="20" maxlength="30" value="<?php echo $registro['cod_equipo'];?>" />
              </span></strong></td>
            </tr>
            <tr class="bord_img">
              <td><div align="left"><strong>Nombre Equipo</strong></div></td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
              <input  name="txt_nombre" type="text" value=" " size="40" maxlength="40" />
              
              <input type="submit" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
              
              <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" class="searchbutton" src="images/ver.png"/>-->
              <input type="hidden" name="txt_nombre2" size="25" maxlength="25" />
              </strong></td>
            </tr>
            
            <tr>
              <td colspan="4" bgcolor="#06327D"><span class="Estilo22">DATOS EQUIPO</span></td>
            </tr>
            <tr>
              <td>C&oacute;digo Equipo</td>
              <td><strong>:</strong></td>
              <td><strong>
              <input  name="txt_codigo2" type="text" size="8" maxlength="8" value="<?php echo $registro["cod_equipo"] ?>" disabled="disabled"/>
              <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro["cod_equipo"]?>"/>
              </strong></td>
              <td width="213">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Nombre </div></td>
              <td><strong>:</strong></td>
              <td><div align="left"><strong><textarea name="txt_nombre_equ2" cols="35" rows="1"><?php echo $registro["nombre_equipo"] ?></textarea></strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Código Motor</td>
              <td>:</td>
              <td><input name="txt_codigo_motor" type="text" value="<?php echo $registro['cod_motor'];?>" size="9" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top">Accesorios</td>
              <td valign="top">:</td>
              <td valign="top"><textarea name="txt_accesorios" cols="35" rows="5"><?php echo $registro["accesorios"] ?></textarea></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
            	<td valign="top">Familia Equipo</td>
            	<td valign="top">:</td>
            	<td valign="top"><select name="id_tipo_equipo" id="id_tipo_equipo">
                	<?php 
						$sql_familias="select *
										from tipo_familia_equipo";
						$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
						while ($row_familia = mysql_fetch_array($res_familia)){
							echo "<option value='".$row_familia['id_tipo']."'";
							if ($row_familia['id_tipo']==$registro['id_tipo_equipo']){
								echo " selected='selected' ";
								}
							echo ">".$row_familia['nombre']."</option>";
						}
					?>
                </select></td>
            </tr>
            <tr>
              <td><div align="left">Proveedor</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <?php
			$sql3="SELECT cod_fabricante, raz_social FROM proveedor order by raz_social ASC";
  			$res3=mysql_query($sql3,$link) or die(mysql_error());	
			
			echo "<select name=proveed>\n"; 

			while($campos3=mysql_fetch_row($res3))
			{	
			   if ($registro['cod_proveedor']==$campos3[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                </strong>
                <div align="left">
                  <strong>
                    <option value="<?php echo $campos3[0].",".$campos3[1]?>" <?php echo $selected?>>
                      <?php echo $campos3[1]?>
                    </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo3 = explode( ',', $_POST['proveed'] );
					$cargo_id3 = $cargo3[0];
					$cargo_contenido3 = $cargo3[1];  
					echo $campos3; 
		 ?>
                </strong></div>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Estado</div></td>
              <td><strong>:</strong></td>
              <td align="left"><div align="left">
                <strong>
                <?php
			$sql2="SELECT cod_estado_equipo, est_equipo, descripcion_estado FROM estado_equipo order by cod_estado_equipo ASC";
  			$res2=mysql_query($sql2,$link) or die(mysql_error());	
			
			echo "<select name=estado_equipo>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro['cod_estado_equipo']==$campos2[0]){
                    $selected2 = "SELECTED";
               }
               else {
                    $selected2 = "";
               }

		 ?>
                </strong>
                <div align="left">
                  <strong>
                  <?php if ($campos2[1]==0) {
					  $campos2[1] ="NO DISPONIBLE" ;}else{ $campos2[1] ="DISPONIBLE";}?>
                  <option value="<?php echo $campos2[0].",".$campos2[1]?>" <?php echo $selected2?>>
                    <?php echo $campos2[1]." - ".$campos2[2]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo2 = explode( ',', $_POST['estado_equipo'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
                </strong></div>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">C&oacute;digo Fabricante</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input name="txt_codfabrica" type="text" value="<?php echo $registro['codigo_fabrica'];?>" size="50" maxlength="50" />
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Fecha Compra</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input type="text" id="cal-field-1" name="cal-field-1" value="<?php echo $registro['fecha_compra'];?>"/>
                <button type="submit" id="cal-button-1">...</button>
                <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
                </script>
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Marca</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input name="txt_marca" type="text" value="<?php echo $registro['marca_equipo'];?>" size="35" maxlength="35" />
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ubicacion</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input name="txt_ubicacion" type="text" value="<?php echo $registro['ubicacion_equipo'];?>" size="40" maxlength="40" />
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Procedencia</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input name="txt_procedencia" type="text" value="<?php echo $registro['procedencia_eq'];?>" size="45" maxlength="45" />
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Unidad</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <?php
			$sql1="SELECT cod_unidad, unidad FROM unidad order by cod_unidad ASC";
  			$res1=mysql_query($sql1,$link) or die(mysql_error());	
			
			echo "<select name=unidad>\n"; 

			while($campos1=mysql_fetch_row($res1))
			{	
               if ($registro['cod_unidad']==$campos1[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                </strong>
                <div align="left">
                  <strong>
                    <option value="<?php echo $campos1[0].",".$campos1[1]?>" <?php echo $selected?>>
                    <?php echo $campos1[1]?>
                    </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo1 = explode( ',', $_POST['unidad'] );
					$cargo_id1 = $cargo1[0];
					$cargo_contenido1 = $cargo1[1];  
					echo $campos1; 
		 ?>
                </strong></div>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Fecha Ingreso Arriendo</div></td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input type="text" id="cal-field-2" name="cal-field-2" value="<?php echo $registro['fecha_ingreso_arr'];?>"/>
                <button type="submit" id="cal-button-2">...</button>
                <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-2",
              button        : "cal-button-2",
              align         : "Tr"
            });
                </script>
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Valor Compra</div></td>
              <td><strong> :</strong></td>
              <td align="left"><div align="left">
                  <strong>
                  <input name="txt_compra" type="text" onkeypress="return acceptNum(event)" value="<?php echo $registro['valor_compra'];?>" size="30" maxlength="30" />
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Vida Útil</div></td>
              <td><strong>:</strong></td>
              <td align="left"><div align="left">
                  <strong>
                  <input name="txt_vidautil" type="text" onkeypress="return acceptNum(event)" value="<?php echo $registro['vida_util'];?>" size="2" maxlength="2" />
              </strong>años</div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Valor Arriendo / d&iacute;a </td>
              <td><strong>:</strong></td>
              <td><div align="left">
                <strong>
                <input name="txt_valarriendo" type="text" onkeypress="return acceptNum(event)" value="<?php echo $registro['valor_unidad_arr'];?>" size="9" maxlength="9" />
              </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td>Descripci&oacute;n</td>
              <td><strong>:</strong></td>
              <td><strong><textarea name="txt_descripcion" cols="37"  rows="2"><?php echo $registro['descrp_equipo'];?></textarea></strong></td>
              <td><strong>
            
              
             <input type="submit" name="OK" id="button" value="Guardar y Seguir" title="Guardar y continuar" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
             
             <!--<input name="OK" type="image" width="30" height="30" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" <?php echo $estado_objetos ;?>/>-->
               <a href="equipo.php" class="menulink">
               
               <input type="submit" name="Limpiar" value="Limpiar" title="Limpiar" style="background-image:url(images/clean.png); width:64px; height:64px;" class="formato_boton"/>
               
               <!--<input name="Limpiar" type="image" title="Limpiar"  width="30" height="30" value="Limpiar"  src="images/clean.png"/>-->
               </a>
               <input type="submit" name="eliminar" value="Eliminar" title="Eliminar Equipo" value="Eliminar" onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style="background-image:url(images/salir.png); width:48px; height:48px;" class="formato_boton"/>
               
              <!--<input name="eliminar" type="image" width="30" height="30" title="Eliminar Equipo" value="Eliminar"  src="images/salir.png"  onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?>/>-->
              </strong></td>
            </tr>
            <tr>
              <td colspan="4" height="10"></td>
            </tr>
            <tr>
              <td height="8" colspan="4" bgcolor="#06327D" class="Estilo22">Foto</td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td colspan="2">
                <strong>
<?php 

$txt_cod = $registro['cod_equipo'];

$result = mysql_query("SELECT * FROM vigomaq_intranet.equipo WHERE cod_equipo = '$txt_cod'"); 
if (!$result) {
	echo 'no se pudo: ' . mysql_error();
exit;
}
$row=mysql_fetch_array($result); 
		echo '<div class="strip_of_thumbnails">';
				{	
					if (!empty($row['cod_equipo']) && is_dir('images/producto'.$row['cod_equipo'].'/'))
					   {
					   $codproducto = $row['cod_equipo'];
					   $codproducto2 = $row['cod_equipo'];
                       $codproducto2 = preg_replace("/Ñ/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/ñ/", "%F1", $codproducto2);
						
					   $result2 = mysql_query("SELECT cod_equipo FROM vigomaq_intranet.equipo WHERE cod_equipo= '$txt_cod'" );
							
						$row2=mysql_fetch_array($result2); 
						echo '<div class="logo">'.'<a href="ficha.php?id='.$codproducto2.'"><img src="images/producto'.$codproducto2.'/destac/foto0.destac.jpg"></a></div>'; 
						}
			echo '</div>';
}
?>
<?php 
	if (empty($registro['cod_equipo'])) 
		{
			
				} else  {
		
		}
?>
            </strong></tr>
            <tr>
              <td height="10"><strong>
              <?php $idprop = $registro['cod_equipo']; ?>
              </strong></td>
              <td height="10">&nbsp;</td>
              <td height="10"><strong>
              <?php 
			$dir = "images/producto".$idprop."/";
			
			if (empty($registro['cod_equipo'])) 
				{
					echo "Para ingresar imagenes primero debe guardar el Equipo";
		?>
		 <?php } else if(!is_dir($dir)) {
				echo "No existen imágenes asociadas a este equipo, Si desea agregar alguna presione";
                echo '<a href="subir.php?id='.$registro['cod_equipo'].'" class="boton">Ingresar Imágenes</a>';
                } else { 
					echo '<a href="subir.php?id='.$registro['cod_equipo'].'" class="boton">Cambiar Imagen</a>'?>
                
               <?php  
  }?>	 
              </strong></td>
              <td height="10">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" height="10"></td>
            </tr>
            <tr>
              <td colspan="4" bgcolor="#06327D"><span class="Estilo22">Ficha Tecnica </span></td>
            </tr>
            <tr>
               <td colspan="4"><input name="archivo" type="file" class="casilla" id="archivo" size="35" />
      <input name="enviar" type="submit" class="boton" id="enviar" value="Cargar Archivo" />
	  <input name="action" type="hidden" value="upload" />	
<?php
	$numequipo=$_GET['id'];
	$numequipo=(string)(int)$numequipo;?>
<a  href="files/ficha_tecnica/<?php  echo "equipo".$numequipo?>.pdf" target="_blank"><strong>Ver Ficha Tecnica pdf</strong></a>  </td>
            </tr>
            <tr>
              <td colspan="4" height="10"></td>
            </tr>
            <tr>
              <td colspan="4" bgcolor="#06327D"><span class="Estilo22">Nota  T&eacute;cnica </span></td>
            </tr>
            <tr>
              <td colspan="4">
                <input name="archivo2" type="file" class="casilla" id="archivo2" size="35" />
                <input name="enviar2" type="submit" class="boton" id="enviar2" value="Cargar Archivo" />
                <input name="action2" type="hidden" value="upload2" />
                <?php
					$numequipo=$_GET['id'];
					$numequipo=(string)(int)$numequipo;?>
                <a  href="files/nota_tecnica/<?php  echo "equipo".$numequipo?>.pdf" target="_blank"><strong>Ver Nota Tecnica pdf</strong></a>              </td>
            </tr>
          </table>
      </form></td>
    </tr>
  </table>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>
<?php 
$status = "";
if ($_POST["action"] == "upload") {
	// obtenemos los datos del archivo 
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
	$idequipo = $_POST['txt_cod'];
	
   //Preguntamos si nuetro arreglo 'archivos' fue definido
  
	$nombre_archivo = "equipo".$idequipo; 
	
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "files/ficha_tecnica/".$nombre_archivo.".pdf";
		if (copy($_FILES['archivo']['tmp_name'],$destino)) {
			$status = "Archivo subido: <b>".$archivo."</b>";
			echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			echo "<script language=Javascript> location.href=\"equipo.php?id=".$idequipo."\"; </script>";
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
}
?>
<?php 
$status = "";
if ($_POST["action2"] == "upload2") {

	// obtenemos los datos del archivo 
	$tamano = $_FILES["archivo2"]['size'];
	$tipo = $_FILES["archivo2"]['type'];
	$archivo = $_FILES["archivo2"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
	$idequipo = $_POST['txt_cod'];
	 
   //Preguntamos si nuetro arreglo 'archivos' fue definido
  
	$nombre_archivo = "equipo".$idequipo; 
	 
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "files/nota_tecnica/".$nombre_archivo.".pdf";
		if (copy($_FILES['archivo2']['tmp_name'],$destino)) {
			$status = "Archivo subido: <b>".$archivo."</b>";
			 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			 echo "<script language=Javascript> location.href=\"equipo.php?id=".$idequipo."\"; </script>";
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
}
?>

		<?php
			function mensaje()
				{
					echo "<script>
					alert('Ingrese Datos Equipo');
					</script>";
				}
				function mensaje2()		
				{
					echo "<script>
					alert('Ingrese Nombre Equipo');
					</script>";
				}
				 function mensaje_equipo()
				 {
					echo "<script>
					alert('No puede eliminar.');
					</script>";
				 }
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_nombre']))
				{  
					$link=mensaje2();
				} else {
					
				};
			}
	  ?>    
        <?php
	if ($_POST['eliminar']=='Eliminar') 
	   {
		   if (!empty($_POST["txt_cod"]))
				  {
				//veirificar si tiene documentos asociados
				//no tiene elimina
				 $link       = Conectarse();
				 
				 $codigo     = $_POST["txt_cod"];
				 $result_prov= mysql_query("SELECT COUNT(cod_equipo) FROM arriendo WHERE cod_equipo = '$codigo'");
				 $filas      = @mysql_num_rows($result_prov);
				  if ($filas>=1)
				  {
					$link=mensaje_equipo();
				  }else{
			      $sql = "DELETE FROM equipo WHERE cod_equipo = '$codigo'";
				 
				  
				  //eliminar imagen
				  $nombre_archivo = 'images/producto'.$codigo; 
				 
					if (file_exists($nombre_archivo)) { 
					    
							eliminar_carpeta(str_replace(" ", "","images/producto".$codigo.'/'));
							rmdir(str_replace(" ", "","images/producto".$codigo.'/'));
							} else { 
						 
					}
			  	 //eliminar pdf	
			     $nombre_ficha = 'files/ficha_tecnica/equipo'.$codigo.".pdf"; 
			     //echo($nombre_ficha);
				 if (file_exists($nombre_ficha)) { 
						unlink($nombre_ficha);
						} else { 
					//echo "El archivo $nombre_ficha no existe"; 
				  }
			     $nombre_nota = 'files/nota_tecnica/equipo'.$codigo.".pdf"; 
			   
				 if (file_exists($nombre_nota)) { 
						unlink($nombre_nota);
						} else { 
					 
				  }
				  
				$res = mysql_query($sql) or die(mysql_error()); 
				echo "<script type='text/javascript'>RegistroGrabado();</script>";
			  }
				}else{
					echo "<script>alert('Seleccione Equipo.');</script>";
			}
	   }
    ?>  
      <?php   
	$valor2 = $_POST["OK"];
 if ($_POST['OK']=='Guardar y Seguir') {
 
	$nombre_equipo      = strtoupper($_POST['txt_nombre_equ2']);     //echo "$nombre_equipo<br>";
	$cod_estado         = $cargo_id2;                     	             //echo "$cod_estado<br>";	
	$proveedor          = $cargo_id3;  	                                 //echo "$proveedor<br>";
	$descripcion        = strtoupper($_POST['txt_descripcion']);//echo "$descripcion<br>";
	$descripcion        = trim($descripcion);	
	$cod_fabricante     = strtoupper($_POST['txt_codfabrica']); //echo "$cod_fabricante<br>"; 
	$procedencia        = strtoupper($_POST['txt_procedencia']);//echo "$procedencia<br>"; 
	$unidad_med         = $cargo_id1;  	                                 //echo "$unidad_med<br>";  
	$ubicacion          = strtoupper($_POST['txt_ubicacion']);  //echo "$ubicacion<br>";
	$marca              = strtoupper($_POST['txt_marca']); 	 //echo "$marca<br>"
	$nombre             = strtoupper($_POST['txt_nombre']);     //echo "$nombre<br>";	
	$fecha_compra       = $_POST['cal-field-1']; 	             //echo "$fecha_compra<br>";
	$valor_compra       = $_POST['txt_compra']; 	             //echo "$valor_compra<br>";
	$vida_util          = $_POST['txt_vidautil']; 	             //echo "$vida_util<br>";
	$fecha_ing_arr      = $_POST['cal-field-2'];  	             //echo "$fecha_ing_arr<br>";	 
	$val_arriendo       = $_POST['txt_valarriendo']; 	         //echo "$val_arriendo<br>";
	
	if (empty($nombre_equipo)||empty($descripcion)||empty($procedencia)||empty($ubicacion)||empty($marca)||empty($nombre)||empty($fecha_compra)||empty($valor_compra)||empty($vida_util)||empty($fecha_ing_arr)||empty($val_arriendo)){  
		$link=mensaje();
	} else {
		 
		$nombre_equipo      = strtoupper($_POST['txt_nombre_equ2']);     //echo "$nombre_equipo<br>";
		$cod_estado         = $cargo_id2;                     	             //echo "$cod_estado<br>";	
		$proveedor          = $cargo_id3;  	                                 //echo "$proveedor<br>";
		$descripcion        = strtoupper($_POST['txt_descripcion']);//echo "$descripcion<br>";
		$descripcion        = trim($descripcion);	
		$cod_fabricante     = strtoupper($_POST['txt_codfabrica']); //echo "$cod_fabricante<br>"; 
		$procedencia        = strtoupper($_POST['txt_procedencia']);//echo "$procedencia<br>"; 
		$unidad_med         = $cargo_id1;  	                                 //echo "$unidad_med<br>";  
		$ubicacion          = strtoupper($_POST['txt_ubicacion']);  //echo "$ubicacion<br>";
		$marca              = strtoupper($_POST['txt_marca']); 	 //echo "$marca<br>"
		$nombre             = strtoupper($_POST['txt_nombre']);     //echo "$nombre<br>";	
		$fecha_compra       = $_POST['cal-field-1']; 	             //echo "$fecha_compra<br>";
		$valor_compra       = $_POST['txt_compra']; 	             //echo "$valor_compra<br>";
		$vida_util          = $_POST['txt_vidautil']; 	             //echo "$vida_util<br>";
		$fecha_ing_arr      = $_POST['cal-field-2'];  	             //echo "$fecha_ing_arr<br>";	 
		$val_arriendo       = $_POST['txt_valarriendo']; 	         //echo "$val_arriendo<br>";
		$accesorios         = $_POST['txt_accesorios'];
		$cod_motor         = $_POST['txt_codigo_motor'];
		$id_tipo_equipo		= $_POST['id_tipo_equipo'];
		
		$codigo = $_POST['txt_cod'];	
		if (empty($codigo)){
 			 mysql_query("insert into vigomaq_intranet.equipo (cod_estado_equipo, cod_proveedor, descrp_equipo, codigo_fabrica, procedencia_eq, cod_unidad, ubicacion_equipo, marca_equipo, nombre_equipo, fecha_compra, valor_compra, vida_util,fecha_ingreso_arr, valor_unidad_arr, accesorios, cod_motor, id_tipo_equipo) values ('$cod_estado','$proveedor','$descripcion','$cod_fabricante','$procedencia','$unidad_med','$ubicacion','$marca','$nombre_equipo','$fecha_compra','$valor_compra','$vida_util','$fecha_ing_arr','$val_arriendo' , '$accesorios', $cod_motor, '$id_tipo_equipo')",$link);
			 mysql_close($link);
			 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			 echo "<script language=Javascript> location.href=\"equipo.php?txt_nombre=".$nombre_equipo."\"; </script>";
		 } else {
 
				$sql = "UPDATE vigomaq_intranet.equipo SET cod_estado_equipo='$cod_estado', cod_proveedor='$proveedor', descrp_equipo='$descripcion', codigo_fabrica='$cod_fabricante', procedencia_eq='$procedencia', cod_unidad='$unidad_med', ubicacion_equipo='$ubicacion', marca_equipo='$marca', nombre_equipo='$nombre_equipo', fecha_compra='$fecha_compra', valor_compra='$valor_compra', vida_util='$vida_util', fecha_ingreso_arr='$fecha_ing_arr', valor_unidad_arr='$val_arriendo', accesorios= '$accesorios', cod_motor = $cod_motor, id_tipo_equipo = '$id_tipo_equipo' where cod_equipo='$codigo'";
				$res  = mysql_query($sql) or die(mysql_error());
				 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
						 
				echo "<script language=Javascript> location.href=\"equipo.php?id=".$codigo."\"; </script>";
		  }	  
	}
 } 
?>