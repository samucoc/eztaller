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
<script type="text/javascript">
var anteriorFilaSeleccionada = null;
function selecciona(fila){
    var celdasEnFila = fila.getElementsByTagName("TD");
	alert(celdasEnFila);
}
</script> 
<script type="text/javascript">
function asignar_valor(celda) {
  cod = celda.getElementsByTagName('td')[0].innerHTML;
  com = celda.getElementsByTagName('td')[1].innerHTML;
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_equipo'].value = com;
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
     	   document.forms.ciudad.php.value=celda;
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
  if (!confirm('�Seguro?')) return false
  fila = obj.parentNode.parentNode;
  fila.parentNode.removeChild(fila);
}
</script>
<script src="sorttable.js"></script>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
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
		
			}
		?></td>
    </tr>
    <tr>
      <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">REPUESTOS</div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">RESULTADOS BUSQUEDA</span></div></td>
    </tr>
    <tr>
      <td width="664" height="16" align="right"> <?php  $fecha = date ("d-m-Y"); echo($fecha);?></td>
    </tr>
    <tr>
      <td><form action="" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" height="30">
            <tr>
              <td class='mini_titulo'><div align="left"><font><strong>Repuesto seleccionado :</strong></font></div></td>
              <td  class='mini_titulo'><font>
                <input type="hidden" name="txt_cod"> <input type="text" name="txt_equipo" size="40" maxlength="40" />
              </font> </td>
              <td valign="bottom"><div align="left">
                <input type="submit" name="OK" value="Guardar y Seguir" title="Seleccionar y Volver"/>
                <!--<input name="OK" type="image" class="boton" title="Seleccionar y Volver" value="Guardar y Seguir"  src="images/maquinarias_volver.png" align="left" width="30"  height="30"/>-->
              </div></td>
            </tr>
          </table>
        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="38%" bgcolor="#06327D"><span class="Estilo17">C&oacute;digo Repuesto </span></th>
              <th width="49%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Nombre</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><?php
		$codigo = "";
$txt_codigo = "";
if ($_GET["id"]=='0') $_GET["id"]="";
if ($_GET["id"]!=""){
   $txt_codigo = $_GET["id"];	
   $codigo = " where cod_repuesto like '".trim($txt_codigo) ."%' ";

}

$nombre = "";
$txt_nombre = "";
if ($_GET["nombre"]!=""){
   $txt_nombre = $_GET["nombre"];	
   $txt_codigo = $_GET["nombre"];
   $codigo = " where nombre_repuesto like '%" . $txt_nombre . "%' and cod_estado_equipo = 1 ";

}

$sql="SELECT * FROM vigomaq_intranet.repuesto ".($codigo);

$res=mysql_query($sql);
$numeroRegistros=mysql_num_rows($res);
if($numeroRegistros<=0)
{
    echo "<div align='center'>";
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
    echo "</div>";
}else{
    //////////elementos para el orden
    if(!isset($orden))
    {
       $orden="cod_repuesto";
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

//////////fin de dicho calculo

//////////creacion de la consulta con limites
$sql="SELECT * FROM vigomaq_intranet.repuesto ".$codigo." ORDER BY ".$orden.",cod_repuesto ASC LIMIT ".$limitInf.",".$tamPag;
//echo($sql);
$res=mysql_query($sql);

//////////fin consulta con limites


if(isset($txt_codigo)){
    echo "<br>Valor filtro: <b>".$txt_codigo."</b>";
}

			while ($registro = mysql_fetch_array($res)) {
		 ?>
              <span class="Estilo17 Estilo13 Estilo15">Imagen</span></th>
            </tr>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <td bgcolor="#FFFFFF">
			  <?php 
			  	   $cantidad = strlen($registro['cod_repuesto']); 
				   if ($cantidad==1) { echo ("0000000".($registro['cod_repuesto']));}
				   if ($cantidad==2) { echo ("000000".($registro['cod_repuesto']));}
				   if ($cantidad==3) { echo ("00000".($registro['cod_repuesto']));}
				   if ($cantidad==4) { echo ("0000".($registro['cod_repuesto']));}
				   if ($cantidad==5) { echo ("000".($registro['cod_repuesto']));}
				   if ($cantidad==6) { echo ('00'.$registro['cod_repuesto']);}		
				   if ($cantidad==7) { echo ('0'.$registro['cod_repuesto']);}	
				   if ($cantidad==8) { echo $registro['cod_repuesto'];}	
			  ?> </td>
              <td bgcolor="#FFFFFF"><?php echo htmlentities($registro['nombre_repuesto']) ;?></td>
              <td align="center" bgcolor="#FFFFFF"><?php if (!empty($registro['cod_repuesto']) && is_dir('images/producto'.$registro['cod_repuesto'].'/'))
					   {
					   $codproducto  = $registro['cod_repuesto'];
					   $codproducto2 = $registro['cod_repuesto'];
					   $codproducto2 = preg_replace("/&Ntilde;/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/&ntilde;/", "%F1", $codproducto2);	
					   $result2 = mysql_query("SELECT cod_repuesto FROM vigomaq_intranet.repuesto WHERE cod_repuesto = '$txt_cod'" );
									
					   $row2=mysql_fetch_array($result2); 
					    echo '<div class="logo">'.'<img src="images/producto'.$codproducto2.'/thumb/foto0.thumb.jpg"></div>'; 
						}  ?></td>
            </tr>
            <tr>
              <td bordercolor="#FFFFFF" class="CONT">------------------------------------</td>
              <td bordercolor="#FFFFFF" class="CONT">----------------------------------------------</td>
              <td class="CONT">----------------------</td>
            </tr>
			<?php
				}
           ?>
             <?php
			function mensaje()
				{
					echo "<script>
					alert('Seleccione al menos un Repuesto');
					</script>";
				}
		  ?>
          <?php   
		 $link=Conectarse();
		  if ($_POST['OK']=='Guardar y Seguir')
		 {
		
		   $codigo       = trim($_POST['txt_cod']);
		        echo "<script language=Javascript> location.href=\"otros_gastos.php?codigo=".$codigo."\"; </script>";
			} else {
				$link=mensaje();
			}
	//	 }
	?>
          </table>
         
      <br>
      <table border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center" valign="top"><?php //a partir de aqui viene la paginacion
    if($pagina>1)
    {
       echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&id=".$txt_codigo."'>";
       echo "<font face='verdana' size='-2'>anterior</font>";
       echo "</a> ";
    }

    for($i=$inicio;$i<=$final;$i++)
    {
       if($i==$pagina)
       {
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>";
       }else{
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&id=".$txt_codigo."'>";
          echo "<font face='verdana' size='-2'>".$i."</font></a> ";
       }
    }
    if($pagina<$numPags)
   {
       echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&id=".$txt_codigo."'>";
       echo "<font face='verdana' size='-2'>siguiente</font></a>";
   }
//fin de la paginacion

}
?></td>
        </tr>	
         
      </table>


      </form><a href="javascript:history.back()" onmouseover="Volver"><img src="images/volver.png" width="40" height="40" align="right" border="0" /></a></td>
    </tr>
  </table>
  <br />
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>	