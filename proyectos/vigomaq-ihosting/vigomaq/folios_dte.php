<?php ob_start(); 
session_start(); 
//conectamos a la base de datos 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq"); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
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
.Estilo22 {font-size: 16px; color: #666666; font-style: italic; font-family: Arial, Helvetica, sans-serif;}
-->
</style> <script type="text/javascript">
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con éxito!");
  document.location = 'folios_dte.php';
}
 //-->
</script>
<script type="text/javascript">
var anteriorFilaSeleccionada = null;
function selecciona(fila){
    var celdasEnFila = fila.getElementsByTagName("TD");
	alert(celdasEnFila);
}
</script> 
<script language="text/javascript">
function confirmReemp()
{
	var agree=confirm("¿Realmente desea actualizar? ");
	if (agree) return true ;
	else return false ;
	
}
</script>
<script type="text/javascript">
	function eliminar(celda)
	{
		var statusConfirm = confirm("¿Realmente desea eliminar?");
		if (statusConfirm == true)
		{
		   alert ("Eliminas");
     	   document.forms.folios_dte.php.value=celda;
           document.forms.submit();
		}
		else
		{
			alert("Haces otra cosa");
		}
	}
</script> 
<script type="text/javascript">
function eliminar(obj) {
  if (!confirm('¿Seguro?')) return false
  fila = obj.parentNode.parentNode;
  fila.parentNode.removeChild(fila);
}
</script>
<script language="javascript">
{
function Eliminar_onClick() {      
         document.nuevo.action="borra_folios_dte.php?Accion=eliminando"
         document.nuevo.submit()	           
        }                        
}
</script>
<script src="sorttable.js"></script>
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <br />
       <span class="Estilo23  Estilo22">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><table width="550" border="0" align="center">
    <tr>
      <td>      <?php
			{
			include("conex.php");
			$link=Conectarse();
			}
		?>
		 <?php
			{
				$valor1 = $_GET["id"];
				$valor1=1;
				
			}
		?>
        <?php
        if ($_SESSION['tipo_usuario']=="0") { 
		   	  $estado_objetos = 'enabled';
           	 
		}else{
			  $estado_objetos = 'disabled';
           	 
		};
		?>
</td>
    </tr>
    <tr>
      <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">Folios DTE VIGOMAQ</div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS Folios DTE</span></div></td>
    </tr>
    <tr>
      <td width="664" height="16"></td>
    </tr>
    <tr>
      <td><form action="folios_dte.php" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" height="30">
            <tr>
              <td width="15%" class='mini_titulo'>
              		<div align="left">
              			<font><strong>Folio inicio:</strong></font>
              		</div>
              </td>
              <td width="58%"  class='mini_titulo'><font>
                <input type="hidden" name="txt_fdte_ncorr" size="50" maxlength="50" />
              	<input type="text" name="txt_folios_dte_inicio" size="50" maxlength="50" />
              </font> </td>
              </tr>
			<tr>
              <td width="15%" class='mini_titulo'>
              		<div align="left">
              			<font><strong>Folio Fin:</strong></font>|
              		</div>
              </td>
              <td width="58%"  class='mini_titulo'><font>
                <input type="text" name="txt_folios_dte_fin" size="50" maxlength="50" />
              </font> </td>
              </tr>
			<tr>
              <td width="15%" class='mini_titulo'>
              		<div align="left">
              			<font><strong>Tipo DTE:</strong></font>
              		</div>
              </td>
              <td width="58%"  class='mini_titulo'><font>
                <select name="tipo_dte" id="tipo_dte">
                	<option value="33">Factura Eletronica</option>
                	<option value="52">Guia de Despacho Electronica</option>
                	<option value="61">Nota de Credito Electronica</option>
                	<option value="56">Nota de Debito Electronica</option>
                </select>
              </font> </td>
              </tr>
			<tr>
            	<td width="15%" class='mini_titulo'>
              		<font><strong>Fecha Emision: </strong></font>
            	</td>
              	<td width="58%"  class='mini_titulo'><font>
              	<div align="right"><input name="cal-field-1" type="text" id="cal-field-1" value="" size="10" maxlength="10" >
                  <button type="submit" id="cal-button-1">...</button>
                  <script type="text/javascript">
			            Calendar.setup({
			              inputField    : "cal-field-1",
			              button        : "cal-button-1",
			              align         : "Tr"
			            });
                  </script>
                </div></td>
            </tr>
			<tr>
            	<td width="27%" valign="bottom"><div align="left">
                <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
                
                <!--<input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" align="left" width="35" height="35" <?php echo $estado_objetos ;?>/>-->
              </div></td>
            </tr>
			 <?php
			function mensaje()
				{
					echo "<script>
					alert('Debe Ingresar Folios DTE ');
					</script>";
				}
		   ?>
          </table>
          <table class="sortable" id="unique_id" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" >
              <th bgcolor="#06327D" class="CONT"><span class="Estilo17">Tipo</span></th>
              <th bgcolor="#06327D" class="CONT"><span class="Estilo17">Desde</span></th>
              <th bgcolor="#06327D" class="CONT"><span class="Estilo17">Hasta</span></th>
              <th bgcolor="#06327D" class="CONT"><span class="Estilo17">Fecha</span></th>
            </tr>
            <?php
			$sql="SELECT * FROM folios_dte order by tipo asc";
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?>
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" >
              <td><?php 
              		if ($registro['tipo']=='33'){
              			echo "Factura";
              			}
              		if ($registro['tipo']=='52'){
              			echo "Guia de Despacho";
              			}
              		if ($registro['tipo']=='61'){
              			echo "Nota de Credito";
              			}
              		if ($registro['tipo']=='56'){
              			echo "Nota de Debito";
              			}
              ?></td>
              <td><?php echo $registro['desde'];?></td>
              <td><?php echo $registro['hasta'];?></td>
              <td><?php echo $registro['fecha'];?></td>
              <td>
              	<a href="folios_dte.php?accion=elimina&ftde_ncorr=<?php echo $registro['fdte_ncorr'];?>" name="borrar" 
              		title="Eliminar Folios DTE" value="Borrar" >
              		<img src="images/error.png" width="16px" height="16px" class="formato_boton" />
              	</a>
              </td>
              
       
            </tr>
            <tr>
              <td bordercolor="#FFFFFF">----------------------------------------</td>
              <td bordercolor="#FFFFFF">----------------------------------------------------</td>
              <td>-------------</td>
            </tr>
            <?php
				}
				mysql_free_result($res);
				mysql_close($link);
		 ?>
                   <?php
		if($_GET['accion']=='elimina')
		 { 
			 $link=Conectarse();
			 $sql = "DELETE FROM folios_dte WHERE fdte_ncorr =".$_GET['ftde_ncorr'];
			
			 $res = mysql_query($sql) or die(mysql_error()); 
			 echo "<script type='text/javascript'>RegistroGrabado();</script>";
		 }   
	 ?>

            <?php   
		 $link=Conectarse();
		  if($_POST['OK']=='Guardar y Seguir'){
				if ((empty($_POST['txt_folios_dte_inicio']))||(empty($_POST['txt_folios_dte_fin']))||
					(empty($_POST['tipo_dte']))||(empty($_POST['cal-field-1']))){  
					$link=mensaje();
				} else {  
					   $txt_folios_dte_inicio      	= $_POST['txt_folios_dte_inicio'];
					   $txt_folios_dte_fin			= $_POST['txt_folios_dte_fin'];
					   $tipo_dte       				= $_POST['tipo_dte'];
					   $cal_field_1 				= $_POST['cal-field-1'];
					   list($dia,$mes,$anio) = explode('-',$cal_field_1);
					   $cal_field_1 = $anio.'-'.$mes.'-'.$dia;
					      mysql_query("INSERT INTO `folios_dte`(`desde`, `hasta`, `tipo`, `fecha`) 
						   				VALUES ('".$txt_folios_dte_inicio."','".$txt_folios_dte_fin."',
						   						'".$tipo_dte."','".$cal_field_1."')",$link);
						   $okas="1";
						   echo "<script type='text/javascript'>RegistroGrabado();</script>";
			 }
		} 
	?>
          </table>
      </form></td>
    </tr>
  </table>
  <br />
  <?php if ($valor1!=1) echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=folios_dte.php'>";?>
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>