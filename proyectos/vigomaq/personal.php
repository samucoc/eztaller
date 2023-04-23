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
			  <?php
				function verifica_RUT($rut='') {
				  $sep = array();  $multi = 2;  $suma = 0;
				  if (empty($rut)) return 1;
				  $tmpRUT = preg_replace('/[^0-9kK]/','',$rut);
				  if (strlen($tmpRUT) == 8 ) $tmpRUT = '0'.$tmpRUT;
				  if (strlen($tmpRUT) != 9) return 2;
				  $sep['rut'] = substr($tmpRUT,0,8);
				  $sep['dv']  = substr($tmpRUT, -1);
				  if ($sep['dv'] == 'k') $sep['dv'] = 'K';
				  if (!is_numeric($sep['rut'])) return 3;
				  if (empty($sep['rut']) OR $sep['dv'] == '') return 4;
				  for ($i=strlen($sep['rut']) - 1; $i >= 0; $i--) {
					$suma = $suma + $sep['rut'][$i] * $multi;
					if ($multi == 7) $multi = 2;
					else $multi++;
				  }
				  $resto = $suma % 11;
				  if ($resto == 1) $sep['dvt'] = 'K';
				  else {
					if ($resto == 0) $sep['dvt'] = '0';
					else $sep['dvt'] = 11 - $resto;
				  }
				  if ($sep['dvt'] != $sep['dv']) return 5;
				  return 0;
				}
				?>
 <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <?php 
$status = "";
if ($_POST["action"] == "upload") {
	// obtenemos los datos del archivo 
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$prefijo=$_POST['txt_rut'];
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "files/".$prefijo."_".$archivo;
		if (copy($_FILES['archivo']['tmp_name'],$destino)) {
			$status = "Archivo subido: <b>".$archivo."</b>";
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
}
?>

<script language="JavaScript" type="text/javascript">
function activa(){
document.frmDatos.imagenes.disabled=false;
}
//-->
</script>
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
<head>
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link href="estilo_pdf.css" rel="stylesheet" type="text/css" />
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<style type="text/css">
<!--
.Estilo19 {	color: #999999;
	font-weight: bold;
}
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
<script type="text/javascript">
function verifica_rut(c){var r=false,d=c.value,t=d.replace(/\b[^0-9kK]+\b/g,'');if(t.length==8){t=0+t;};if(t.length==9){var a=t.substring(t.length-1,-1),b=t.charAt(t.length-1);if(b=='k'){b='K'};if(!isNaN(a)){var s=0,m=2,x='0',e=0;for(var i=a.length-1;i>=0;i--){s=s+a.charAt(i)*m;if(m==7){m=2;}else{m++;};}var y=s%11;if(y==1){x='K';}else{if(y==0){x='0';}else{e=11-y;x=e+'';};};if(x==b){r=true;c.value=a.substring(0,2)+'.'+a.substring(2,5)+'.'+a.substring(5,8)+'-'+b};}}return r;};
</script>
	<script type="text/javascript" src="ie.js"></script>
	<script type="text/javascript">
      <!--
    function RegistroGrabado() {
      alert("Proceso realizado con Exito!");
      document.location = 'personal.php';
    }
     //-->
     </script>
	<script type="text/javascript">
	  <!--
	function Noingresado() {
	  alert("Repuesto no ha sido ingresado!");
	  document.location = 'personal.php';
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
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
  <tr>
    <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
    <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
            <br />
            <br />
            <span class="Estilo23 Estilo21">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
  </tr>
</table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div>
    <table width="70%" height="405" border="0" align="center">
      <tr>
        <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
            <div align="right" class="Estilo19">
              <div align="right" class="Estilo20"><?php
				{
					include("conex.php");
					$link=Conectarse();
				}
			 ?>
			<?php include("borrar_imagenes.php"); ?>
              <?php
				{
					$valor1 = $_GET['id'];
					if (empty($valor1)) $valor1= $_POST['txt_rut'];
					if (empty($valor1)) $valor1= $_GET['txt_rut'];
				
					
					if (empty($valor1)){
					
					}else{
							$link=Conectarse();
							$sql = "SELECT cod_personal, cod_tipo_pers, cod_ciudad, rut_personal, ap_patpersonal, ap_matpersonal, nombres_personal, fecha_nacpersonal, valor_hh, fono, movil, direcc, email FROM vigomaq_intranet.personal WHERE rut_personal ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							if (empty($registro['cod_personal']) && $_POST["buscar"]=="Buscar"){
							 	 echo "<script> alert (\"Personal No Encontrado\"); </script>";
							}
					}
					
				}
			?>
             <?php
				{
					$cod_personal = $_GET['codigo'];
					
					
					if (empty($cod_personal)){
					
					}else{
							$link=Conectarse();
							$sql = "SELECT cod_personal,rut_personal, cod_tipo_pers, cod_ciudad, rut_personal, ap_patpersonal, ap_matpersonal, nombres_personal, fecha_nacpersonal, valor_hh, fono, movil, direcc, email FROM vigomaq_intranet.personal WHERE cod_personal ='$cod_personal'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							$valor1 = $registro['rut_personal'];
							
							if (empty($registro['cod_personal']) && $_POST["buscar"]=="Buscar"){
							 	 echo "<script> alert (\"Personal No Encontrado\"); </script>";
							}
					}
					
				}
			?>
            
              <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
      
		}else{
			  $estado_objetos = 'disabled';
          
		};
		?>
              PERSONAL</div>
            </div>
        </div></td>
      </tr>
      <tr>
        <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS PERSONAL </span></div></td>
      </tr>
      <tr>
        <td height="350" align="center" valign="top">    <?php
			if (isset($_POST['txt_rut'])) {
		
			  $error = verifica_rut($_POST['txt_rut']);
			  switch($error) {
				case 0 :    
					$rut_param = $_POST['txt_rut'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $rut_param;
					}
	
				break;
				case 1 : echo "<script> alert (\"Ingrese Rut Personal\"); </script>"; break;
				case 2 : echo "<script>	alert (\"El Rut no cuenta con el mínimo de caracteres necesarios para validarlo\");					</script>"; break;
				case 4 : echo "<script>	alert (\"El Rut o el dígito viene vacío\");</script>"; break;
				case 5 : echo "<script>	alert (\"El Rut y el dígito no coinciden\");</script>"; break;
				default: echo "<script>	alert (\"Error\");</script>"; break;
			  }
			
			}
		?><form method="post" name="frmDatos" action="personal.php"  id="frmDatos" enctype="multipart/form-data">

		    <table width="100%" border="0">

              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr>
                <td width="21%"><?php if (empty($registro['cod_personal'])){ }else{ echo " Código Personal: " ;}?></td>
                <td width="3%"><?php if (empty($registro['cod_personal'])){ }else{ echo ":" ;}?></td>
                <td width="47%"><div align="left"> <span class='mini_titulo'>
                  <?php if (empty($valor1)){ }else{ 
				   $cantidad = strlen($registro['cod_personal']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_personal'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_personal'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_personal'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_personal'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_personal'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_personal'] . ' ';  }		
				   
           ?>
                  </span>
                  <?php } ?>
                </div></td>
                <td width="29%" rowspan="7">
<?php 
$txt_cod = $registro['cod_personal'];

$result = mysql_query("SELECT * FROM vigomaq_intranet.personal WHERE cod_personal = '$txt_cod'"); 
if (!$result) {
	echo 'no se pudo: ' . mysql_error();
exit;
}
$row=mysql_fetch_array($result); 
		echo '<div class="strip_of_thumbnails">';
				{	
					if (!empty($row['cod_personal']) && is_dir('images/personal'.$row['cod_personal'].'/'))
					   {
					   $codproducto = $row['cod_personal'];
					   $codproducto2 = $row['cod_personal'];
					   $codproducto2 = preg_replace("/&Ntilde;/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/&ntilde;/", "%F1", $codproducto2);
						
					   $result2 = mysql_query("SELECT cod_personal FROM vigomaq_intranet.personal WHERE cod_personal= '$txt_cod'" );
							
						$row2=mysql_fetch_array($result2); 
						echo '<div class="logo">'.'<a href="ficha.php?id='.$codproducto2.'"><img src="images/personal'.$codproducto2.'/destac/foto0.destac.jpg"></a></div>'; 
						}
			echo '</div>';
}
?>
      <?php 
		if ($_SESSION['tipo_usuario']=="0") {
			if (empty($registro['cod_equipo'])) 
				{
						} else  {
				}
			}
	?>
            <?php $idprop = $registro['cod_personal']; ?>
            <?php 
			$dir = "images/personal".$idprop."/";
		
			if (empty($registro['cod_personal'])) 
				{
					 echo "Para ingresar imagenes primero debe guardar";
		?>
            <?php } else if(!is_dir($dir)) {
				echo "No existen imagenes asociadas. Si desea agregar alguna presione";
                echo '<a href="subir_per.php?id='.$registro['cod_personal'].'" class="boton">Ingresar Imagenes</a>';
                } else { 
					echo '<a href="subir_per.php?id='.$registro['cod_personal'].'" class="boton">Cambiar Imagen</a>' ;}?>
			          </td>
              </tr>
              <tr>
                <td><div align="left">Rut</div></td>
                <td>:</td>
                <td><div align="left">
                  <input name="txt_rut" type="text" id="rut" value="<?php 
 if (($registro['rut_personal']!= "") && (empty($registro['cod_personal'])))
			  {		$rut_param = $registro['rut_personal'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $registro['rut_personal'];
					}
					echo ($rutok);
				}else{ 
				  	if (!empty($registro['rut_personal'])) {
						echo($registro['rut_personal']); 
					}else{ 
						echo ($_POST['txt_rut']);
					}
				}?>" size="12" maxlength="12"  />
                  
                  
                  <input type="submit" name="buscar" title="Buscar Personal" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
                  
                  <!--<input type="image" name="buscar" value="Buscar" title="Buscar Personal" class="searchbutton" src="images/ver.png"/>-->
                  <span class="Estilo20">
                    <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_personal'];?>" />
                  </span><strong>[11.111.111-1]</strong></div></td>
              </tr>
              <tr>
                <td><div align="left">Nombres</div></td>
                <td>:</td>
                <td><div align="left">
                  <input name="txt_nombres" type="text" value="<?php if (!empty($registro['nombres_personal'])){echo ($registro['nombres_personal']);}else{echo($_POST["txt_nombres"]) ;}//=$registro['nombres_personal'];?>" size="45" maxlength="45"/>
                </div></td>
              </tr>
              <tr>
                <td><div align="left">Apellido Paterno</div></td>
                <td> :</td>
                <td><div align="left">
                  <input name="txt_appat" type="text" value="<?php if (!empty($registro['ap_patpersonal'])){echo ($registro['ap_patpersonal']);}else{echo($_POST["txt_appat"]) ;} //=$registro['ap_patpersonal'];?>" size="35" maxlength="35" />
                </div></td>
              </tr>
              <tr>
                <td><div align="left">Apellido Materno</div></td>
                <td> :</td>
                <td><div align="left">
                  <input name="txt_apmat" type="text" value="<?php if (!empty($registro['ap_matpersonal'])){echo ($registro['ap_matpersonal']);}else{echo($_POST["txt_apmat"]) ;}//=$registro['ap_matpersonal'];?>" size="35" maxlength="35" />
                </div></td>
              </tr>
              <tr>
                <td><div align="left">Tipo Personal</div></td>
                <td> : </td>
                <td><?php
			$sql="SELECT cod_tipo_pers, tipo_personal FROM tipo_personal order by cod_tipo_pers ASC";
  			$res2=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=tipo_pers>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro['cod_tipo_pers']==$campos2[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos2[0].",".$campos2[1]?>" <?php echo $selected?>>
                  <?php echo $campos2[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo2 = explode( ',', $_POST['tipo_pers'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?></div></td>
              </tr>
              <tr>
                <td><div align="left">Fecha Nacimiento</div></td>
                <td> :</td>
                <td><input type="text" id="cal-field-1" name="cal-field-1" value="<?php if (!empty($registro['fecha_nacpersonal'])){echo ($registro['fecha_nacpersonal']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha_nacpersonal'];?>"/>
                  <button type="submit" id="cal-button-1">...</button>
                <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
                  </script></td>
              </tr>
              <tr>
                <td><div align="left">Direcci&oacute;n</div></td>
                <td>:</td>
                <td><input name="txt_direcc" type="text" value="<?php if (!empty($registro['direcc'])){echo ($registro['direcc']);}else{echo($_POST["txt_direcc"]) ;}//=$registro['direcc'];?>" size="50" maxlength="50" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Ciudad</div></td>
                <td align="left">:</td>
                <td align="left"><?php
			$sql="SELECT cod_ciudad, ciudad FROM ciudad order by ciudad ASC";
  			$res=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=ciudad>\n"; 

			while($campos1=mysql_fetch_row($res))
			{	
               if ($registro['cod_ciudad']==$campos1[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos1[0].",".$campos1[1]?>" <?php echo $selected?>>
                  <?php echo $campos1[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo1 = explode( ',', $_POST['ciudad'] );
					$cargo_id1 = $cargo1[0];
					$cargo_contenido1 = $cargo1[1];  
					echo $campos1; 
		 ?></div></td>
                <td></td>
              </tr>
              <tr>
                <td><div align="left">Contrato de Trabajo</div></td>
                <td align="left">:</td>
                <td colspan="2" align="left">
                  	
<?php
	$numpersonal=$registro['cod_personal'];
	$numpersonal=(string)(int)$numpersonal;?>
 </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php 

			   	 $idprop = $registro['cod_personal'];
				 $contrato = 'files/personal/contrato'.$idprop.".pdf"; 
			
				 if (empty($registro['cod_personal'])) 
				 {
					 echo "Para ingresar contrato primero debe guardar";
				  } else 
				  	if (file_exists($contrato)) { ?>
					 <a  href="files/personal/<?php  echo "contrato".$numpersonal?>.pdf" target="_blank">Ver Contrato de Trabajo pdf</a><input name="elim_contrato" type="submit" class="boton" id="enviar" value="Elim_Contrato" />
				<?php } else { ?>
					<input name="archivo" type="file" class="casilla" id="archivo" size="10" />
	 				<input name="action" type="hidden" value="upload" />
                    <input name="enviar" type="submit" class="boton" id="enviar" value="Cargar Archivo" />
                    
					<?php	echo "No existe Contrato asociado";	
                }?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Valor HH</td>
                <td>: </td>
                <td><input name="txt_valorhh" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['valor_hh'])){echo ($registro['valor_hh']);}else{echo($_POST["txt_valorhh"]) ;}//=$registro['valor_hh'];?>" size="6" maxlength="6" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Fono</div></td>
                <td>:</td>
                <td><input name="txt_fono" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono'])){echo ($registro['fono']);}else{echo($_POST["txt_fono"]) ;}//=$registro['fono'];?>" size="8" maxlength="8" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Movil</div></td>
                <td>:</td>
                <td><input name="txt_movil" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil'])){echo ($registro['movil']);}else{echo($_POST["txt_movil"]) ;}//=$registro['movil'];?>" size="9" maxlength="9" /></td>
                <td rowspan="2" align="right">
                
                <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
                
                <!--<input name="OK" type="image" title="Guardar y continuar"  width="30" height="30" value="Guardar y Seguir"  src="images/guardar.png" <?php echo $estado_objetos ;?>/>-->
                  <a href="personal.php" class="menulink"><input name="Limpiar" type="image" title="Limpiar"  width="30" height="30" value="Limpiar"  src="images/clean.png"/></a>
                
                
                  <input type="submit" name="eliminar" title="Eliminar Personal" value="Eliminar" onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style=" background-image:url(images/salir.png); width:48px; height:48px;" class="formato_boton"/>
                  
                <!--<input name="eliminar" type="image" width="30" height="30"title="Eliminar Personal" value="Eliminar"  src="images/salir.png"  onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?>  />--></td>
              </tr>
              <tr>
                <td><div align="left">e-mail</div></td>
                <td align="left">:</td>
                <td align="left"><input name="txt_email" type="text" value="<?php if (!empty($registro['email'])){echo ($registro['email']);}else{echo($_POST["txt_email"]) ;}//=$registro['email'];?>" size="50" maxlength="50" /></td>
              </tr>

             
            </table>
        </form></td>
      </tr>
    </table> 

  </div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>
<?php

function eliminar_recursivo_contenido_de_directorio($carpeta)
{
$directorio = opendir($carpeta);
while ($archivo = readdir($directorio))
{

	if ( is_dir( $carpeta.'/'.$archivo ) )
	{
	
	
	}else{

	unlink($carpeta.'/'.$archivo);

	 }
}
closedir($directorio);
}


?>
<?php 
$status = "";
if ($_POST["enviar"] == "Cargar Archivo") {
	// obtenemos los datos del archivo 
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
	$idpersonal =  $registro['cod_personal'];
	$nombre_archivo = "contrato".$idpersonal; 
	
	if ($nombre_archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "files/personal/".$nombre_archivo.".pdf";             
		if (copy($_FILES['archivo']['tmp_name'],$destino)) {
			$dir="files";
			eliminar_recursivo_contenido_de_directorio($dir) ;
		
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
}
?>
      <?php 
		 function validaRut ( $rut ){ 
		 if( strpos ( $rut , "-" )== false ){ 
		 $RUT [ 0 ] = substr ( $rut , 0 , - 1 ); 
		 $RUT [ 1 ] = substr ( $rut , - 1 ); 
		 }else{ 
		 $RUT = explode ( "-" , trim ( $rut )); 
		 } 
		 $elRut = str_replace ( "." , "" , trim ( $RUT [ 0 ])); 
		 $factor = 2 ; 
		 for( $i = strlen ( $elRut )- 1 ; $i >= 0 ; $i --): 
		 $factor = $factor > 7 ? 2 : $factor ; 
		 $suma += $elRut { $i }* $factor ++; 
		 endfor; 
		 $resto = $suma % 11 ; 
		 $dv = 11 - $resto ; 
		 if( $dv == 11 ){ 
		 $dv = 0 ; 
		 }else if( $dv == 10 ){ 
		 $dv = "k" ; 
		 }else{ 
		 $dv = $dv ; 
		 } 
		 if( $dv == trim ( strtolower ( $RUT [ 1 ]))){ 
		 return true ; 
		 }else{ 
		 return false ; 
		 } 
		 } 
	 

?>
<?php
			function mensaje()
				{
					echo "<script>
					alert('Ingrese Datos Personal');
					</script>";
				}
		   function mensaje_rep()
			    {
					echo "<script>
					alert('No puede eliminar.');
					</script>";
				}
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_rut']))
				{  
					$link=mensaje();
				} else {
					
				};
			}
	  ?> 
      <?php
	  	if ($_POST['elim_contrato']=='Elim_Contrato') 
	   {
		 //eliminar pdf	
		 $contrato = 'files/personal/contrato'.$idprop.".pdf"; 
		
		 if (file_exists($contrato)) { 
				unlink($contrato);
				echo "<script language=Javascript> location.href=\"personal.php?id=".$_POST['txt_rut']."\"; </script>";
				} else { 
		  }
	   }
	  ?>
    <?php
	if ($_POST['eliminar']=='Eliminar') 
	   {
	    //veirificar si tiene documentos asociados
	    //no tiene elimina
	     $link       = Conectarse();
		 $codigo     = $registro['cod_personal'];
	
		 $result_prov="SELECT COUNT(*) as filas FROM arriendo WHERE cod_personal = '$codigo'";
		 $rs_busqueda=mysql_query($result_prov);
		 $filas=mysql_result($rs_busqueda,0,"filas");
		  
		
		  if ($filas>=1)
		  {
			$link=mensaje_rep();
		  }else{
		  	$sql = "DELETE FROM personal WHERE cod_personal = '$codigo'";
			
			//eliminar imagen
			 $nombre_archivo = 'images/personal'.$idprop;
				if (file_exists($nombre_archivo)) { 
				  
						eliminar_carpeta(str_replace(" ", "","images/personal".$idprop.'/'));
						rmdir(str_replace(" ", "","images/personal".$idprop.'/'));
						} else { 
					
				}
				 //eliminar pdf	
			     $contrato = 'files/personal/contrato'.$idprop.".pdf"; 
			     //echo($nombre_ficha);
				 if (file_exists($contrato)) { 
						unlink($contrato);
						} else { 
					
				  }
				  
		    $res = mysql_query($sql) or die(mysql_error()); 
		    echo "<script type='text/javascript'>RegistroGrabado();</script>";
		  }
	   }
    ?>  
      <?php   
	$valor2 = $_POST["OK"];
	
if ($_POST['OK']=='Guardar y Seguir') {
	$rut                = $_POST['txt_rut'];                    //echo "$rut<br>";
	if (strlen($rut)==12){
			$cod_tipopers       = $cargo_id2;                     	             //echo "$cod_tipopers<br>"; 
			$cod_ciudad         = $cargo_id1;  	                                 //echo "$cod_ciudad<br>";  
			$ap_pat             = strtoupper($_POST['txt_appat']);      //echo "$ap_pat<br>";
			$ap_mat             = strtoupper($_POST['txt_apmat']);      //echo "$ap_mat<br>"; 
			$nombres            = strtoupper($_POST['txt_nombres']);    //echo "$nombres<br>";
			$fecha_nac          = $_POST['cal-field-1']; 	             //echo "$fecha_nac<br>";
			$valorhh            = $_POST['txt_valorhh'];  	             //echo "$valorhh<br>";
			$fono               = $_POST['txt_fono'];                   //echo "$fono<br>";
			$movil              = $_POST['txt_movil']; 	             //echo "$movil<br>";
			$direcc             = strtoupper($_POST['txt_direcc']); 	 //echo "$direcc<br>";
			$email              = strtoupper($_POST['txt_email']); 	 //echo "$email<br>";	 
			
			if (empty($cod_tipopers)||empty($cod_ciudad)||empty($ap_pat)||empty($ap_mat)||empty($nombres)||empty($fecha_nac)||empty($valorhh)||empty($fono)||empty($movil)||empty($direcc)||empty($email)){  
				$link=mensaje();
			} else {
				
				$rut                = $_POST['txt_rut'];                    //echo "$rut<br>";
				$cod_tipopers       = $cargo_id2;                     	             //echo "$cod_tipopers<br>"; 
				$cod_ciudad         = $cargo_id1;  	                                 //echo "$cod_ciudad<br>";  
				$ap_pat             = strtoupper($_POST['txt_appat']);      //echo "$ap_pat<br>";
				$ap_mat             = strtoupper($_POST['txt_apmat']);      //echo "$ap_mat<br>"; 
				$nombres            = strtoupper($_POST['txt_nombres']);    //echo "$nombres<br>";
				$fecha_nac          = $_POST['cal-field-1']; 	             //echo "$fecha_nac<br>";
				$valorhh            = $_POST['txt_valorhh'];  	             //echo "$valorhh<br>";
				$fono               = $_POST['txt_fono'];                   //echo "$fono<br>";
				$movil              = $_POST['txt_movil']; 	             //echo "$movil<br>";
				$direcc             = strtoupper($_POST['txt_direcc']); 	 //echo "$direcc<br>";
				$email              = strtoupper($_POST['txt_email']); 	 //echo "$email<br>";	
						
				$codigo = $_POST['txt_cod'];	
				if (empty($codigo)){
				
					 mysql_query("insert into vigomaq_intranet.personal (cod_tipo_pers,cod_ciudad,rut_personal,ap_patpersonal,ap_matpersonal,nombres_personal,fecha_nacpersonal,valor_hh,fono,movil,direcc,email) values ('$cod_tipopers','$cod_ciudad','$rut','$ap_pat','$ap_mat','$nombres','$fecha_nac','$valorhh','$fono','$movil','$direcc','$email')",$link);
					 mysql_close($link);
					 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
					 echo "<script language=Javascript> location.href=\"personal.php?id=".$rut."\"; </script>";
				 } else {
		 
						$sql = "UPDATE vigomaq_intranet.personal SET cod_tipo_pers='$cod_tipopers', cod_ciudad='$cod_ciudad', rut_personal='$rut', ap_patpersonal='$ap_pat', ap_matpersonal='$ap_mat', nombres_personal='$nombres', fecha_nacpersonal='$fecha_nac', valor_hh='$valorhh', fono='$fono', movil='$movil', direcc='$direcc', email='$email' where rut_personal='$codigo'";
						$res  = mysql_query($sql) or die(mysql_error());
						echo "<script type='text/javascript'>RegistroGrabado();</script>";
					
						echo "<script language=Javascript> location.href=\"personal.php?id=".$rut."\"; </script>";
				  }	  
			}
	}else{
		echo "<script> alert (\"Rut Incorrecto.\"); </script>";
	}
 } 
?>