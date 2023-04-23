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
<!--
.Estilo2 {
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-style: italic;
}
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo19 {color: #999999;
	font-weight: bold;
}
.Estilo20 {color: #000000}
.Estilo6 {font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</div></td>
   </tr>
 </table>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>	
<p>&nbsp;</p>
<table width="70%" border="0" align="center">
  <tr>
    <td>
    <div id="text" style="float:left; clear:left; width:100%; margin-top:10px">
    <form action="busca_equipo.php" method="post" name="frmDatos" id="frmDatos">
      <table width="100%" border="0" align="center" class="bord_img">
        <tr>
          <td colspan="7" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
            <div align="right" class="Estilo19">
              <div align="right" class="Estilo20"> CONSULTA <font>EQUIPO</font></div>
            </div>
          </div></td>
        </tr>
        <tr>
          <td width="9%"><?php
		{
		include("conex.php");
		$link=Conectarse();
		}
	?>
            &nbsp;</td>
        </tr>
        <tr>
          <td height="16" colspan="7" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS BUSQUEDA </span></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="1%" >&nbsp;</td>
          <td width="5%">&nbsp;</td>
          <td width="31%">&nbsp;</td>
          <td width="7%" >&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="46%">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">C&oacute;digo</div></td>
          <td>:</td>
          <td><input name="codigo" type="text" class="searchbox" size="6" maxlength="6" /></td>
          <td>
          <input type="submit" name="buscarcodigo" value="Buscar" style="background-image:url(images/ver.png); height:16px; width:16px;" class="formato_boton" />
          
          <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Equipo por Codigo" class="searchbutton" src="images/ver.png"/>-->
          </td>
          <td><div align="left">Nombre </div></td>
          <td>:</td>
          <td><div align="left">
            <input name="equipo" type="text" size="35" maxlength="35" />
            
            <input type="submit" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" style="background-image:url(images/ver.png); height:16px; width:16px;" class="formato_boton"/>
            
            <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" class="searchbutton" src="images/ver.png"/>-->
          </div></td>
        </tr>
        <tr>
          <td colspan="7"><table width="100%" border="0" align="center">
            <tr>
              <td width="16%">
                <?php
$res=array();				
if (($_POST['buscarcodigo']=='Buscar') || ($_POST['buscarnombre']=='Buscar') || (isset($_GET['buscarnombre'])) || (isset($_GET['buscarcodigo'])))
{
	
//inicializo el tipo  de operaci&oacute;n y recibo cualquier cadena que se desee buscar
	$sql = "SELECT * FROM equipo ";

	if ($_POST['codigo'] != ""){
	   $txt_codigo = $_POST["codigo"];
	   $sql .= " where cod_equipo = '$txt_codigo'";
	}
	if ($_GET['codigo'] != ""){
	   $txt_codigo = $_GET["codigo"];
	   $sql .= " where cod_equipo = '$txt_codigo'";
	}
	
	if ($_POST['equipo'] !="") {
	   $txt_equipo = $_POST["equipo"];
	   $sql .= " where nombre_equipo like '%" . $txt_equipo . "%' "; 
	}
	if ($_GET['equipo'] !="") {
	   $txt_equipo = $_GET["equipo"];
	   $sql .= " where nombre_equipo like '%" . $txt_equipo . "%' "; 
	}

	$sql .= " order by cod_equipo ASC";

	$res=mysql_query($sql);
	$numeroRegistros=mysql_num_rows($res);
	$inicio = 0;
	$final = 0;
	if($numeroRegistros<=0)	{
		echo "<div align='center'>";
		echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
		echo "</div>";
	}else{
		//elementos para el orden
		if(!isset($orden)) {
		   $orden="cod_equipo";
		}
		//fin elementos de orden
	
		//calculo de elementos necesarios para paginacion
		//tama&ntilde;o de la pagina
		$tamPag=20;
	
		//pagina actual si no esta definida y limites
		if(!isset($_GET["pagina"])){
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
		if(!isset($pagina)) {
		   $pagina=1;
		   $inicio=1;
		   $final=$tamPag;
		}else{
		   $seccionActual=intval(($pagina-1)/$tamPag);
		   $inicio=($seccionActual*$tamPag)+1;
	
		   if($pagina<$numPags)    {
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
	
	if(isset($txt_codigo))	{
	   
	}
	echo "</font></div>";
	$limitSup=0;
	if ($limitInf==0){
		$limitInf = 20;
		}
	else{
		$limitInf = $limitInf+20;
		}
	if (isset($_GET['pagina'])){
		$constante = $_GET['pagina'];
		$limitSup = (20 * $constante)-20;
		}
	else{
		$constante = 1;
		$limitSup = (20 * $constante)-20;
		}
	
	//$sql .= " limit $limitSup, $limitInf;";
	$res = mysql_query($sql);
}	
	
?></td>
            </tr>
            <tr>
              <th bgcolor="#06327D"><div align="center" class="Estilo17"> Guia Despacho</div></th>
              <th width="25%" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
              <th width="16%" bgcolor="#06327D"><div align="center" class="Estilo17"><strong>Valor<br />
Arriendo / d&iacute;a </strong></div></th>
              <th width="32%" bgcolor="#06327D"><div align="center" class="Estilo17"><strong>Estado</strong></div></th>
              <th width="11%" bgcolor="#06327D"><div align="center"><span class="Estilo17"></span></div></th>
            </tr>
            <tr>
              <?php while($registro=mysql_fetch_array($res))
				{
			?>
              <td><?php 
                if($registro['cod_estado_equipo'] == 3){
					$sql_1 = "SELECT num_gd
								FROM equipos_arriendo 
								where cod_equipo = ".$registro['cod_equipo']." 
									and estado_equipo_arr in ('NO DEVUELTO','DEVUELTO-NO FACTURADO')
								order by arrendado_desde desc LIMIT 1";
					$res_1 = mysql_query($sql_1,$link) or die(mysql_error()); 
					$registro_1 = mysql_fetch_array($res_1);
						
					echo $registro_1['num_gd'];
				}
				else{
					echo "Sin Guia de Despacho";
					}
				?></td>
              <td><?php echo htmlentities($registro['nombre_equipo']) ;?></td>
              <td align="right"><?php echo "$ ".number_format($registro['valor_unidad_arr'], 0, ",", ".") ; ?></td>
              <td align="right"><?php 
			  
			  if($registro['cod_estado_equipo'] == 3){
			  	
					
					
					$sql_1 = "SELECT cod_arriendo 
								FROM equipos_arriendo 
								where cod_equipo = ".$registro['cod_equipo']." 
									and estado_equipo_arr in ('NO DEVUELTO','DEVUELTO-NO FACTURADO')
								order by arrendado_desde desc LIMIT 1";
					$res_1 = mysql_query($sql_1,$link) or die(mysql_error()); 
					$registro_1 = mysql_fetch_array($res_1);
					
					$cod_arriendo_1 =  $registro_1['cod_arriendo'];
					
					$salida = '--';
					
					if($cod_arriendo_1 != ''){
						$sql_2 = "SELECT clientes.raz_social, obra.nombre_obra, arriendo.* FROM arriendo
						left join clientes clientes on arriendo.rut_cliente = clientes.rut_cliente
						left join obra obra on obra.cod_obra =  arriendo.cod_obra
						where cod_arriendo = ".$cod_arriendo_1." limit 1";
						
						
						
						$res_2 = mysql_query($sql_2,$link) or die(mysql_error()); 
						$registro_2 = mysql_fetch_array($res_2);
						
						//print_r ($registro_2);
						
						
						$salida = $registro_2['raz_social'].' <br /> '.$registro_2['nombre_obra'];
					}
					
					
					echo $salida;
					
					
					
					//print_r ($registro_2);
					
					//$salida = 
				
					//echo $salida;
				
			  }else{
			  		$c_est_equipo = $registro['cod_estado_equipo'];
					  $sql2 = "SELECT descripcion_estado FROM vigomaq_intranet.estado_equipo where cod_estado_equipo='$c_est_equipo'"; 
					  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
					  $registro2 = mysql_fetch_array($res2);
					  if ($registro['cod_estado_equipo']==1) { echo "DISPONIBLE - " ;}else{ echo "NO DISPONIBLE - ";}
					  echo $registro2['descripcion_estado'] ;
			  
			  }
			  
			  
			  
			 ?></td>
              <td align="center"><a href='equipo.php?id=<?php echo $registro['cod_equipo'];?>'>Editar</a></td>
            </tr>
            <tr>
              <td height="15">----------------</td>
              <td>------------------------------------</td>
              <td>-----------------------</td>
              <td>--------------------------------------------------------</td>
              <td>-------------</td>
            </tr>
            <!-- fin tabla resultados -->
            <?php
}//fin while
echo "</table>";
}//fin if
//a partir de aqui viene la paginacion
?>
            <br />
            <table border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td align="center" valign="top"><?php
    if($pagina>1)
    {
		if ($_POST['codigo'] != ""){
    	   echo "<a name='buscarcodigo' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&codigo=".$txt_codigo."&buscarcodigo=buscarcodigo'>";}else{
    	   echo "<a name='buscarnombre' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&equipo=".$txt_equipo."&buscarnombre=buscarnombre'>";
			   }
       echo "<font face='verdana' size='-2'>anterior</font>";
       echo "</a> ";
    }

    for($i=$inicio;$i<=$final;$i++)
    {
       if($i==$pagina)
       {
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>";
       }else{
		if ($_POST['codigo'] != ""){
    	   echo "<a name='buscarcodigo' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($i)."&orden=".$orden."&codigo=".$txt_codigo."&buscarcodigo=buscarcodigo'>";}else{
    	   echo "<a name='buscarnombre' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($i)."&orden=".$orden."&equipo=".$txt_equipo."&buscarnombre=buscarnombre'>"			;
			   }
          echo "<font face='verdana' size='-2'>".$i."</font></a> ";
       }
    }
    if($pagina<$numPags)
   {
		if ($_POST['codigo'] != ""){
    	   echo "<a name='buscarcodigo' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&codigo=".$txt_codigo."&buscarcodigo=buscarcodigo'>";}else{
    	   echo "<a name='buscarnombre' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&equipo=".$txt_equipo."&buscarnombre=buscarnombre'>"			;
			   }
       echo "<font face='verdana' size='-2'>siguiente</font></a>";
   }
//fin de la paginacion
?></td>
              </tr>
            </table>
            <?php
    mysql_close();
?>
          </table></td>
        </tr>
      </table>
    </form>
</div></td>
  </tr>
</table>
<p>&nbsp; </p>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>

