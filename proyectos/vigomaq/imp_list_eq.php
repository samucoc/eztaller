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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />

<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
   <style type="text/css">
 @media print {
    .oculto {display:none}
  }
</style>
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
.Estilo21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style> 
<script src="sorttable.js"></script>
<SCRIPT language="javascript"> 
function imprimir() { 
if ((navigator.appName == "Netscape")) { window.print() ; 
} 
else { 
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = ""; 
} 
} 
</SCRIPT>

<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<form>
    <table border="0" align="center" class="bord_img">
      <tr> 
        <td colspan="2" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">LISTADO EQUIPOS</div>
          </div>
      </div></td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#FFFFFF"></td>
      </tr>
      <tr>
        <td height="26" valign="top" bgcolor="#FFFFFF"><?php
		{
		include("conex.php");
		$link=Conectarse();
		}
	?>
        &nbsp;          <?php
//inicializo el tipo  de operaci&oacute;n y recibo cualquier cadena que se desee buscar

$sql = "SELECT * FROM equipo left join equipos_arriendo on equipo.cod_equipo = equipos_arriendo.cod_equipo";

//codigo de la propiedad
if ($_GET["codigo"]!="")
  {
	   $txt_codigo = $_GET["codigo"];
	  	
	   $codigo = " where equipo.cod_equipo like '%" . $txt_codigo . "%' ";
	}
$sql .= " order by equipos_arriendo.num_gd, equipo.cod_equipo asc";

$res=mysql_query($sql);
$numeroRegistros=mysql_num_rows($res);

if($numeroRegistros<=0)
{
    echo "<div align='center'>";
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
    echo "</div>";
}else{
    
echo "<div align='center'>";
echo "<font face='verdana' size='-2'>encontrados ".$numeroRegistros." resultados<br>";

if(isset($txt_codigo)){
 
}
echo "</font></div>";
?></td>
 <td align="right" valign="top" bgcolor="#FFFFFF"><input type="image" name="impresion" width="40" height="40"value="Impresion" src="images/impresora.gif" onclick="window.print();"class="oculto" /></td>
      </tr>
      <tr><td colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">LISTADO EQUIPOS</span></div></td>
      </tr>

      <tr>
        <td colspan="2"><table border="0" align="center">
         
          <tr>
            <th width="80" bgcolor="#06327D"><div align="center" class="Estilo17">C&oacute;dgo Equipo</div></th>
            <th width="80" bgcolor="#06327D"><div align="center" class="Estilo17">GD</div></th>
            <th width="151" bgcolor="#06327D"><div align="center" class="Estilo17">Estado</div></th>
            <th width="107" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
            <th width="123" bgcolor="#06327D"><div align="center" class="Estilo17">Descripci&oacute;n</div></th>
            <th width="143" bgcolor="#06327D"><div align="center" class="Estilo17">Ubicaci&oacute;n </div></th>
            <th width="93" bgcolor="#06327D"><div align="center" class="Estilo17">Valor Arriendo</div></th>
            </tr>
          <tr>
            <?php while($registro=mysql_fetch_array($res)){?>
            <td align="left"><?php echo $registro['cod_equipo'] ;?></td>
            <td align="left"><?php echo $registro['num_gd'] ;?></td>
            <td align="left">
			 <?php 
			  $c_est_equipo = $registro['cod_estado_equipo'];
			  $sql2 = "SELECT descripcion_estado FROM vigomaq_intranet.estado_equipo where cod_estado_equipo='$c_est_equipo'"; 
			  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
			  $registro2 = mysql_fetch_array($res2);
			  if ($registro['cod_estado_equipo']==1) { echo "DISPONIBLE - " ;}else{ echo "NO DISPONIBLE - ";}
			  echo $registro2['descripcion_estado'] ;
			 ?></td>
            <td align="left"><?php echo htmlentities($registro['nombre_equipo']) ; ?></td>
            <td align="left"><?php echo htmlentities($registro['descrp_equipo']) ;?></td>
            <td align="left"><?php echo $registro['ubicacion_equipo'] ;?></td>
            <td align="right"><?php echo "$".number_format($registro['valor_unidad_arr'], 0, ",", ".") ; ?></td>
            </tr>
          <tr>
            <td>-----------------</td>
            <td>---------------------------------</td>
            <td>-----------------------</td>
            <td>--------------------------</td>
            <td>---------------------------</td>
            <td>-----------------------</td>
            </tr>
         
          <?php
}
echo "</table>";
}

?>
          <br />
          <table border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td align="center" valign="top"><?php
?>              </td>
            </tr>
          </table>
          <?php
    mysql_close();
?>
        </table></td>
      </tr>
    </table>
  </form>
  
</div>
</head>
</body>
</html>