<?php ob_start(); 
session_start(); 
//conectamos a la base de datos 
//mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
mysql_connect("localhost","root","");  
mysql_connect("localhost","root","");
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
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con Exito!");
  document.location = 'otros_gastos_e.php';
}
 //-->
</script>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("repuesto no ha sido ingresado!");
  document.location = 'otros_gastos_e.php';
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
       <span class="Estilo21">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
</table>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>
<table width="80%" border="0" align="center">
  <tr>
    <td width="80%" height="80" align="center" valign="top"><form action="otros_gastos.php" method="POST" name="frmDatos" id="frmDatos">
      <table width="80%" border="0" align="center">
        <tr>
          <td colspan="4" height="8"><div align="center" class="Estilo6">
            <div align="right" class="Estilo20"><strong><font>
              <?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
              <?php
			{
				if ($_GET['codigo'] != "")
				{
				   $txt_codigo = $_GET["codigo"];
				    
					$sql = "SELECT * FROM repuesto where cod_repuesto ='$txt_codigo'";
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
					
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
              </span>OTROS GASTOS - REPUESTO</font></strong></div>
          </div></td>
        </tr>
        <tr>
          <td colspan="4" height="8"></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#06327D"><div align="left"><span class="Estilo7 Estilo25">BUSSQUEDA REPUESTO</span></div></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
        <tr class="bord_img">
          <td height="24"><div align="left">C&oacute;digo Repuesto</div></td>
          <td>:</td>
          <td colspan="2"><input  name="txt_codigo" type="text" size="8" maxlength="8" value=""/>
            
            <input type="submit" name="buscarcodigo" title="Buscar repuesto por Codigo" value="Buscar"  style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
            
            <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar repuesto por Codigo" class="searchbutton" src="images/ver.png"/>-->
            <?php
				//envia el nombre
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$busca_cod = $_POST['txt_codigo'];
					$busca_cod = (string)(int)$busca_cod;
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eq_otror.php?id=$busca_cod'>";
				}
				//envia el codigo
				if (($_POST['buscarnombre']=='Buscar'))
				{
					$busca_nom = ltrim($_POST['txt_nombre']);
				
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eq_otror.php?nombre=$busca_nom'>";
				}
			?>
            &nbsp;</td>
        </tr>
        <tr class="bord_img">
          <td><div align="left">Nombre Repuesto</div></td>
          <td>:</td>
          <td colspan="2"><input  name="txt_nombre" type="text" value=" " size="40" maxlength="40" />
            <input type="submit" name="buscarnombre" title="Buscar repuesto por Nombre" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
            
            <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar repuesto por Nombre" class="searchbutton" src="images/ver.png"/>-->
            <input type="hidden" name="txt_nombre2" size="25" maxlength="25" /></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#06327D"><div align="left"><span class="Estilo7 Estilo25">DATOS OTROS GASTOS</span></div></td>
        </tr>
        <tr>
          <td><div align="left">C&oacute;digo Repuesto</div></td>
          <td>&nbsp;</td>
          <td><input  name="txt_codigo2" type="text" size="8" maxlength="8" value="<?php echo $registro["cod_repuesto"] ?>" disabled="disabled"/>
            <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro["cod_repuesto"]?>"/></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Nombre Repuesto </div></td>
          <td>:</td>
          <td><div align="left">
            <input name="txt_nombre_equ2" type="text" value="<?php echo $registro["nombre_repuesto"] ?>" size="35" maxlength="35" disabled="disabled"/>
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Fecha</div></td>
          <td>:</td>
          <td><div align="left">
            <input type="text" id="cal-field-1" name="cal-field-1" value="<?php ?>"/>
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
          <td><div align="left">Monto</div></td>
          <td>:</td>
          <td><div align="left">
            <input name="txt_monto" type="text" onkeypress="return acceptNum(event)"  value="<?php ?>" size="9" maxlength="9" />
          </div></td>
          <td height="10" valign="bottom">&nbsp;</td>
        </tr>
        <tr>
          <td height="10" valign="top">Observaciones</td>
          <td height="10" valign="top">:</td>
          <td height="10"><textarea name="txt_obsrepos" cols="50" rows="8"><?php ?></textarea></td>
          <td height="10" valign="bottom">
          
          <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
          
          <!--<input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" <?php echo $estado_objetos ;?>/>-->
            </td>
        </tr>
        <tr>
          <td colspan="4" height="10"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>	
		<?php
			function mensaje()
				{
					echo "<script>
					alert('Ingrese Datos Repuesto');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Nombre Repuesto');
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
	$valor2 = $_POST["OK"];

if ($_POST['OK']=='Guardar y Seguir') {
    $codigo_repuesto = $_POST['txt_cod']; // echo "$codigo_repuesto<br>";
	$fecha_gasto        = $_POST['cal-field-1']; 	        //   echo "$fecha_gasto<br>";
	$monto_gasto        = $_POST['txt_monto'];              //  echo "$monto_gasto<br>";
	$Observaciones      = strtoupper($_POST['txt_obsrepos']);//  echo "$Observaciones<br>";
	$Observaciones      = trim($Observaciones);
	
	if (empty($codigo_repuesto)||empty($fecha_gasto)||empty($Observaciones)){  
		$link=mensaje();
	} else {
		$fecha_gasto        = $_POST['cal-field-1']; 	            //echo "$fecha_gasto<br>";
		$monto_gasto        = $_POST['txt_monto'];                 //echo "$monto_gasto<br>";
		$Observaciones      = strtoupper($_POST['txt_obsrepos']);  //echo "$Observaciones<br>";
		$Observaciones      = trim($Observaciones);
					
		 mysql_query("insert into vigomaq_intranet.otros_gastos (cod_repuesto,fecha_gasto,monto_gasto,Observaciones) values ('$codigo_repuesto','$fecha_gasto','$monto_gasto','$Observaciones')",$link);

		 
		 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
		 echo "<script language=Javascript> location.href=\"otros_gastos.php\"; </script>"; 
		 } 
	}

?>