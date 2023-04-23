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
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
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
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<form>
    <table width="90%" border="0" align="center" class="bord_img">
      <tr> 
        <td colspan="2" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">LISTADO  PERSONAL</div>
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

$sql = "SELECT * FROM personal order by rut_personal asc;";

$res=mysql_query($sql);
$numeroRegistros=mysql_num_rows($res);
//echo "$numeroRegistros";
if($numeroRegistros<=0)
{
    echo "<div align='center'>";
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
    echo "</div>";
}else{
    //////////elementos para el orden
    if(!isset($orden))
    {
       $orden="rut_personal";
    }
    //////////fin elementos de orden

    //////////calculo de elementos necesarios para paginacion
    //tama&ntilde;o de la pagina
    $tamPag=5;

    //pagina actual si no esta definida y limites
    if(!isset($_GET["pagina"]))
    {
       $pagina=1;
       $inicio=1;
       $final=$tamPag;
    }else{
       $pagina = $_GET["pagina"];
    }
    //calculo del limite inferior
    $limitInf=($pagina-1)*$tamPag;

    //calculo del numero de paginas
    $numPags=ceil($numeroRegistros/$tamPag);
    if(!isset($pagina))
    {
       $pagina=1;
       $inicio=1;
       $final=$tamPag;
    }else{
       $seccionActual=intval(($pagina-1)/$tamPag);
       $inicio=($seccionActual*$tamPag)+1;

       if($pagina<$numPags)
       {
          $final=$inicio+$tamPag-1;
	   }else{
          $final=$numPags;
       }

        if ($final>$numPags){
          $final=$numPags;
       }
    }

//fin de dicho calculo

echo "<div align='center'>";
echo "<font face='verdana' size='-2'>encontrados ".$numeroRegistros." resultados<br>";
if(isset($txt_codigo)){

}
echo "</font></div>";
?></td>
 <td align="right" valign="top" bgcolor="#FFFFFF"><input type="image" name="impresion" value="Impresion" src="images/impresora.gif" onclick="window.print();"  class="oculto" ></td>
      </tr>
      <tr><td colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">LISTADO DE PERSONAL </span></div></td>
      </tr>

      <tr>
        <td colspan="2"><table width="100%" border="0" align="center">
         
          <tr>
            <th width="92" bgcolor="#06327D"><div align="center" class="Estilo17">Rut  </div></th>
            <th width="185" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
            <th width="102" bgcolor="#06327D"><div align="center" class="Estilo17">Tipo Personal</div></th>
            <th width="95" bgcolor="#06327D"><div align="center" class="Estilo17">Tel&eacute;fono</div></th>
            <th width="79" bgcolor="#06327D"><div align="center" class="Estilo17">Movil</div></th>
            <th width="79" bgcolor="#06327D"><div align="center" class="Estilo17">Valor HH</div></th>
            <th width="79" bgcolor="#06327D"><div align="center" class="Estilo17">Email</div></th>
            </tr>
          <tr>
            <?php while($registro=mysql_fetch_array($res))
{
?>
            <td><?php echo $registro['rut_personal'];?></td>
            <td><?php echo $registro['nombres_personal'];?></td>
            <td><?php echo $registro['cod_tipo_pers'] ; ?></td>
            <td><?php echo $registro['fono'] ;?></td>
            <td><?php echo $registro['movil'] ; ?></td>
            <td align="right"><?php echo "$".number_format($registro['valor_hh'], 0, ",", ".") ;?></td>
            <td><?php echo $registro['email'] ; ?></td>
            </tr>
          <tr>
            <td>----------------</td>
            <td>-------------------------------------</td>
            <td>--------------------</td>
            <td>--------------------</td>
            <td>---------------</td>
            <td>-----------------------</td>
            <td>-------------------------------------------</td>
            </tr>
          <!-- fin tabla resultados -->
          <?php
}//fin while
echo "</table>";
}//fin if
//////////a partir de aqui viene la paginacion
?>
          <br />
          <table border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td align="center" valign="top"><?php
    if($pagina>1)
    {
       echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&codigo=".$txt_codigo."'>";
       echo "<font face='verdana' size='-2'>anterior</font>";
       echo "</a> ";
    }

    for($i=$inicio;$i<=$final;$i++)
    {
       if($i==$pagina)
       {
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>";
       }else{
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&codigo=".$txt_codigo."'>";
          echo "<font face='verdana' size='-2'>".$i."</font></a> ";
       }
    }
    if($pagina<$numPags)
   {
       echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&codigo=".$txt_codigo."'>";
       echo "<font face='verdana' size='-2'>siguiente</font></a>";
   }
//////////fin de la paginacion
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
</body>
</html>