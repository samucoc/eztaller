<?php ob_start(); 
session_start(); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<?php
require_once('classes/tc_calendar.php');
include ("classes/conex.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="imagetoolbar" content="no" />
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>

<link rel="stylesheet" href="css/style.css" type="text/css" />
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
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); .Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
    </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<script>
self.moveTo(0,0);
self.resizeTo(screen.availWidth, screen.availHeight);
</script>

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
	</div>
  <tr>
    <td height="592">
    <table width="95%" border="0" align="center">
      <tr>
        <td width="80%" ><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            REGISTRO GUIA DE DESPACHO NULAS</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><form method="post" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td colspan="6" height="8"></td>
            </tr>
            <tr>
              <td colspan="6" bgcolor="#06327D"><span class="Estilo24">REGISTRO GUIA DE DESPACHO </span><span class="Estilo24">NULAS
                  <div align="right"></div>
              </span></td>
            </tr>
            <tr>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td width="17%">N&deg; Guia de Despacho</td>
              <td width="2%">:</td>
              <td width="23%"><span class="Estilo24">
                <input name="txt_gd" type="text"onkeypress="return acceptNum(event)" size="10" maxlength="10" />

                <!--<input type="image" name="buscarfactura" value="Buscar" title="Buscar Factura" class="searchbutton" src="images/ver.png"/>-->A</span></td>
              <td width="11%" height="8"  align="right">Fecha Emision</td>
              <td width="36%" height="8"><div align="left">
                <input name="cal-field-1" type="text" id="cal-field-1" size="10" maxlength="10" value="<?php echo date("d-m-Y")?>"/>
                <button type="submit" id="cal-button-1">...</button>
              </div></td>
              <td width="11%" class="Estilo25">&nbsp;</td>
            </tr>
            <tr>
              <td><p>Observaciones</p></td>
              <td>:</td>
              <td colspan="3" align="left"><textarea name="txt_condic" cols="100" rows="5"></textarea></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td colspan="2" align="right">&nbsp;</td>
              <td align="right">
                <input type="submit" name="borrar" id="button" value="Borrar" title="Anular Guia Despacho" src="images/anular_fact.png" onclick="elimina=confirm('Desea anular?');return elimina;" style="background-image:url(images/anular_fact.png); width:48px; height:48px;" class="formato_boton"/>
              <a href="anular_gd.php" class="menulink">
                <img src="images/clean.png" />
              </a>
              </td>
              <td>&nbsp;</td>
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
            <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
          </script>

</body>

</html>
	<?php
	function mensaje() {
			echo "<script> alert('Ingrese Numero Guia de Despacho');</script>";
			echo "<script language=Javascript> location.href=\"anular_gd.php\"; </script>";
		}

	if ($_POST['borrar']=='Borrar'){
			$num_gd        = $_POST['txt_gd'];    	               // echo "$num_gd<br>";				
			if (empty($num_gd)){  
				$link=mensaje();
			} else {
				//	echo "si entra graba";
				$num_gd        = $_POST['txt_gd'];    	               // echo "$num_gd<br>";
				$fecha              = $_POST['cal-field-1'];              // echo "$fecha<br>";
				$fech = explode("-",$fecha);
				$dyh = getdate(mktime(0, 0, 0,$fech[1], $fech[0], $fech[2]));
				$fecha = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday']; 
				$observaciones		= $_POST['observaciones'];
				$link=Conectarse();
				
				//verificar estado de la factura
				$sqlanular   = "SELECT * FROM gd WHERE num_gd ='$num_gd'";
				//echo "sqlfact= $sqlfact<br>";
				$resanular   = mysql_query($sqlanular,$link) or die(mysql_error()); 
				$registronula= mysql_fetch_array($resanular);
				if (!empty($registronula['num_gd']))
				{
					echo "<script> alert (\"Guia de Despacho existente.\"); </script>";
				}elseif (($registronula['estado'])=='NULA'){
					echo "<script> alert (\"Guia de Despacho nula.\"); </script>";
				}else{

					$sql_4  = " insert into gd (num_gd,estado,fecha, observaciones)
								values ('$num_gd','NULA','$fecha','$observaciones')";
					$res_4  = mysql_query($sql_4) or die(mysql_error());
						//echo "<br />";
					echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
					}
				}
			} 
	?> 
