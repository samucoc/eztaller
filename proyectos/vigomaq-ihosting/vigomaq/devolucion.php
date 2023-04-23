<?php 
ob_start(); 
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
	<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
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
.Estilo24 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.Estilo25 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2 Estilo25"><br />
       <br />
       <br />
       <span class="Estilo23">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="80%" border="0">
  <tr>
    <td align="center"><div id="text" style="float:center;width:85%; margin-top:10px">
      <script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
    </script>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="80%" height="37"><div align="center" class="Estilo6">
            <div align="right" class="Estilo20"><strong><font>
              <?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
              <?php
			{
				$valor1 = $_GET["id"];
				$cod_arr= $_GET["cod_arr"];
			
				if (!empty($valor1))
				{
				
					$link=Conectarse();
					$sqleval   = "SELECT nombre_equipo FROM vigomaq_intranet.equipo WHERE cod_equipo ='$valor1'";
				 	
					$res      = mysql_query($sqleval,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
				
					
					$sqlarr     = "SELECT * 
									FROM vigomaq_intranet.equipos_arriendo 
									WHERE num_gd ='$cod_arr' 
										and cod_equipo ='$valor1'
										and estado_equipo_arr = 'NO DEVUELTO'";
					
					
					$resarr     = mysql_query($sqlarr,$link) or die(mysql_error()); 
					$registroarr = mysql_fetch_array($resarr);
					$fecha_arr   = $registroarr['arrendado_desde'];
					
				}
			}
		 ?>
              DEVOLUCION</font></strong></div>
          </div></td>
        </tr>
        <tr>
          <td valign="top"><form method="post" enctype="multipart/form-data" name="frmDatos" id="frmDatos">
            <table width="100%" border="0" align="center">
              <tr>
                <td colspan="4" height="8"></td>
              </tr>
              <tr>
                <td colspan="4" bgcolor="#06327D"><span class="Estilo24">DATOS DEVOLUCION <?php echo"Guia de Despacho N&deg; ".$cod_arr ;?></span></td>
              </tr>
              <tr>
                <td colspan="4"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td width="18%"><div align="left">Nombre Equipo </div></td>
                <td width="2%">:</td>
                <td width="62%"><div align="left">
                  <input name="txt_nomequipo" type="text" value="<?php if (!empty($registro['nombre_equipo'])) {echo ($registro['nombre_equipo']);}else{echo($_GET['nomequipo']);}?>" size="40" maxlength="40" disabled="disabled" />
                  Cod.Equipo:
                  <input name="txt_codequipo" type="text" value="<?php $cantidad = strlen($valor1); 
				
				   if ($cantidad==1) { echo ("0000000".($valor1));}
				   if ($cantidad==2) { echo ("000000".($valor1));}
				   if ($cantidad==3) { echo ("00000".($valor1));}
				   if ($cantidad==4) { echo ("0000".($valor1));}
				   if ($cantidad==5) { echo ("000".($valor1));}
				   if ($cantidad==6) { echo ("00".($valor1));}		
				   if ($cantidad==7) { echo ("0".($valor1));}	
				   if ($cantidad==8) { echo $valor1; }?>" size="8" maxlength="8" disabled="disabled" />
                </div></td>
                <td width="18%">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Arrendado desde</div></td>
                <td>:</td>
                <td align="left"><input name="txt_arrdesde" type="text" value="<?php 
				if (!empty($fecha_arr)) {
					$fecha_temp = explode("-",$fecha_arr);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];
					}
				else{
					$fecha_temp = explode("-",$_GET['txt_arrdesde']);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];
					}
					
					?>" size="10" maxlength="10" disabled="disabled" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Estado Equipo</div></td>
                <td>:</td>
                <td align="left"><div align="left">
                  <?php
				$sqlest      = "SELECT cod_estado_equipo FROM equipo where cod_equipo='$valor1'";
				$res         = mysql_query($sqlest,$link) or die(mysql_error()); 
				$registroest = mysql_fetch_array($res);
				
				$sql2="SELECT cod_estado_equipo, est_equipo, descripcion_estado 
						FROM estado_equipo 
						where cod_estado_equipo <> 3
						order by cod_estado_equipo ASC";
				$res2=mysql_query($sql2,$link) or die(mysql_error());	
				
				echo "<select name=estado_equipo>\n"; 
	
				while($campos2=mysql_fetch_row($res2))
				{	
				   if ($registroest['cod_estado_equipo']==$campos2[0]){
						$selected = "SELECTED";
				   }
				   else {
						$selected = "";
				   }
		    ?>
                  <div align="left">
                    <?php if ($campos2[1]==0) {
					  $campos2[1] ="NO DISPONIBLE" ;}else{ $campos2[1] ="DISPONIBLE";}?>
                    <option value="<?php echo $campos2[0].",".$campos2[1]?>" <?php echo $selected?>>
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
                  </div>
                </div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Fecha</div></td>
                <td>:</td>
                <td><div align="left">
                  <input name="cal-field-1" type="text" id="cal-field-1" value="<?php 
				  if (empty($registroeq['arrendado_hasta'])){
						if (isset($_POST['cal-field-1'])){
							echo $_POST['cal-field-1'];						
							}
						else{
							echo date ("d-m-Y"); 
							}
						}
					else{
						$fecha_temp = explode("-",$registroeq['arrendado_hasta']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
						}
						?>" size="10" maxlength="10" />
                  <button type="submit" id="cal-button-1">...</button>
                  <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
          </script>
                </div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Hora</div></td>
                <td> :</td>
                <td align="left"><div align="left">
                  <input name="hora" type="text" id="hora" value="<?php echo date ("H:i:s"); ?>" size="8" maxlength="8" />
                </div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td valign="top" class="Estilo20">Observaciones</td>
                <td  class="Estilo24">&nbsp;</td>
                <td class="Estilo24"><textarea name="txt_observaciones" cols="50" rows="2"><?php if (!empty($registro['obs_devolucion'])){echo ($registro['obs_devolucion']);}else{echo($_POST["txt_observaciones"]) ;}?></textarea></td>
                <td class="Estilo24" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td><?php
		function mensaje()
			{
				echo "<script>
				alert('Ingrese todos los datos');
				</script>";
			}
	  ?>
                  <?php	
	  $valor2 = $_POST["OK"];
	  if ($_POST['OK']=='Guardar y Seguir'){
		
			$codigo_equipo      = $valor1;                     		              //  echo "$codigo_equipo<br>";
			$cod_estado_equipo  = $cargo_id2;                                    //   echo "$cod_estado_equipo<br>";
			$fecha_devolucion   = $_POST['cal-field-1']; 	              //  echo "$fecha_devolucion<br>";
			$hora_devolucion    = $_POST['hora'];                       //   echo "$hora_devolucion<br>";
            $observaciones      = strtoupper($_POST['txt_observaciones']); 		
			$observaciones      = trim($observaciones); 		                   // echo "$observaciones<br>"; 
			
			if (empty($fecha_devolucion)||empty($hora_devolucion)){  
				$link=mensaje();
			} else {
				
				$codigo_equipo      = $_GET['valor1'];                     		     //echo "$codigo_equipo<br>";
				$cod_estado_equipo  = $cargo_id2;                                     //echo "$cod_estado_equipo<br>";
				$fecha_devolucion   = $_POST['cal-field-1'];	             //echo "$fecha_evaluacion<br>";
				$hora_devolucion    = $_POST['hora'];                       //echo ($hora_devolucion)."$hora_devolucion<br>";
				$observaciones      = strtoupper($_POST['txt_observaciones']); 		
				$observaciones      = trim($observaciones); 		                  //echo "$observaciones<br>"; 
	
				if (!empty($valor1)){
				function restaFechas($dFecIni, $dFecFin)
				{
					$dFecIni = str_replace("-","",$dFecIni);
					$dFecIni = str_replace("/","",$dFecIni);
					$dFecFin = str_replace("-","",$dFecFin);
					$dFecFin = str_replace("/","",$dFecFin);
				
					ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
					ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
			
					$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
					$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
				
					return round(($date2 - $date1) / (60 * 60 * 24));
				}
				$resultado_resta = restaFechas($registroarr['arrendado_desde'],$fecha_devolucion);
				if ($resultado_resta<0)
				{
					 echo "<script> alert (\"Fecha devolucion debe ser posterior a fecha arriendo.\"); </script>";
				}else{
						//ingresar datos de la devolucion al arriendo
					$fecha_arr			= $_POST['cal-field-1'];
					$fecha_temp = explode("-",$fecha_arr);
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
					$fecha_devolucion = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

					 $sql = "UPDATE vigomaq_intranet.equipos_arriendo 
					 		SET arrendado_hasta='$fecha_devolucion', 
								hora_devol='$hora_devolucion', 
								comentarios='$observaciones', 
								estado_equipo_arr='DEVUELTO-NO FACTURADO' 
							 where arrendado_hasta = '0000-00-00' 
							 	and cod_equipo='$valor1' 
								and num_gd ='$cod_arr'
								and estado_equipo_arr='NO DEVUELTO'";
					 $res  = mysql_query($sql) or die(mysql_error());
					
					 //cambiar estado equipo
					 $sql = "UPDATE vigomaq_intranet.equipo SET cod_estado_equipo='$cod_estado_equipo' where cod_equipo='$valor1'";
					
					 $res  = mysql_query($sql) or die(mysql_error());
					 mysql_close($link);	
	
					 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
					 echo "<script language=Javascript> location.href=\"arriendo_devolver.php?cod_arr=".$cod_arr."\"; </script>";
				}
			    }	  
			}
		 } 
		 
	?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><span class="Estilo24">
                  <input type="submit" name="OK" value="Guardar y Seguir" title="Guardar y continuar" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" />
                  
                 <!-- <input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" width="35" height="35" />-->
                  <a href="arriendo_devolver.php" onmouseover="Volver"><img src="images/volver.png" width="45" height="45" border="0"  title="Volver"/></a></span></td>
              </tr>
            </table>
          </form></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/languages/jquery.validationEngine-es.js"></script>
<script>
	$(document).ready(function() {
		$("#frmDatos").validationEngine('attach');
		});
</script>		
</body>

</html>