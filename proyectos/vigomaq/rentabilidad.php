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

function tranf_fecha_2($fecha){
	$fecha_temp = explode("-",$fecha);
	//año-mes-dia
	//0 -> año, 1 -> mes, 2 -> dia
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
	return $fecha = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year']; 
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"/><head>
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
<

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
			include('classes/menu.php'); //modulo menu
		?>
	</div>
<table width="95%" border="0" align="center">
  <tr>
    <td><div id="text" style="float:left; clear:left; width:100%; margin-top:10px">
<form method="post" name="frmDatos" id="frmDatos">
      <table width="100%" border="0" align="center" class="bord_img">
        <tr>
          <td colspan="5" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
            <div align="right" class="Estilo19">
              <div align="right" class="Estilo20"><?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
              <?php
				$valor1        = $_GET["codequipo"];
				$nombre_equipo = $_GET["nomequipo"];
				if (!empty($valor1)){
				
					$link=Conectarse();
					
					//buscar datos de equipo
					$sqlequipo  = "SELECT * FROM vigomaq_intranet.equipo WHERE cod_equipo ='$valor1'";
				
					$resequipo  = mysql_query($sqlequipo,$link) or die(mysql_error()); 
					$registro1  = mysql_fetch_array($resequipo);
					$cod_equipo = $registro1['cod_equipo'];
				}else{
					$link=Conectarse();
					$sqlelim = "DELETE FROM vigomaq_intranet.rentabilidad";
					$reselim = mysql_query($sqlelim,$link) or die(mysql_error());
				}
		     ?> 
        RENTABILIDAD <font>EQUIPO</font></div>
            </div>
          </div></td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td height="16" colspan="5" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS BUSQUEDA </span></div></td>
        </tr>
        <tr>
          <td height="24"><div align="left">C&oacute;digo Equipo</div></td>
          <td width="2%">:</td>
          <td colspan="2"><input  name="txt_codigo" type="text" size="8" maxlength="8" value="<?php echo ($valor1); ?>"/>
            <input type="submit" name="buscarcodigo" title="Buscar Equipo por C&oacute;digo" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
            
            <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Equipo por C&oacute;digo" class="searchbutton" src="images/ver.png"/>-->
            <input type="hidden" name="txt_cod" size="20" maxlength="30" />
            <?php
				//envia el nombre
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$busca_cod = $_POST['txt_codigo'];
					$busca_cod = (string)(int)$busca_cod;
					
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eq_rent.php?id=$busca_cod'>";
				}
				//envia el codigo
				if (($_POST['buscarnombre']=='Buscar'))
				{
					$busca_nom = ltrim($_POST['txt_nombre']);
				
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eq_rent.php?nombre=$busca_nom'>";
				}
			?>
          &nbsp;</td>
          <td rowspan="3" align="right"><?php if (!empty($registro1['cod_equipo']) && is_dir('images/producto'.$registro['cod_equipo'].'/'))
					   {
					   $codproducto  = $registro1['cod_equipo'];
					   $codproducto2 = $registro1['cod_equipo'];
					   $codproducto2 = preg_replace("/&Ntilde;/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/&ntilde;/", "%F1", $codproducto2);	
					   $result2 = mysql_query("SELECT cod_equipo FROM vigomaq_intranet.equipo WHERE cod_equipo = '$txt_cod'" );
									
					   $row2=mysql_fetch_array($result2); 
					    echo '<div class="logo">'.'<img src="images/producto'.$codproducto2.'/thumb/foto0.thumb.jpg"></div>'; 
						}  ?></td>
        </tr>
        <tr>
          <td><div align="left">Nombre Equipo</div></td>
          <td>:</td>
          <td colspan="2"><input  name="txt_nombre" type="text" value="<?php echo($nombre_equipo);?> " size="40" maxlength="40" />
            
            <input type="submit" name="buscarnombre" title="Buscar Equipo por Nombre" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
            
           <!-- <input type="image" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" class="searchbutton" src="images/ver.png"/>-->
            <input type="hidden" name="txt_nombre2" size="25" maxlength="25" /></td>
        </tr>
        <tr>
          <td height="30"><div align="left">Fecha Compra </div></td>
          <td>:</td>
          <td><div align="left">
            <input name="fecha_compra" type="text" id="fecha_compra" value="<?php echo $registro1['fecha_compra'];?>" size="10" maxlength="10" disabled="disabled"/>
          </div></td>
          <td>Valor Compra
          <input name="fecha_compra2" type="text" id="valor_compra" value="<?php echo $registro1['valor_compra'];?>" size="10" maxlength="10" disabled="disabled"/></td>
        </tr>
        <tr>
          <td>Valor Arriendo / d&iacute;a </td>
          <td>:</td>
          <td colspan="3" align="left">
            <input name="txt_valarriendo" type="text" value="<?php echo $registro1['valor_unidad_arr'];?>" size="10" maxlength="10"  disabled="disabled"/></td>
        </tr>
        <tr>
          <td align="left"><div align="left">Vida &Uacute;til </div></td>
          <td align="left">:</td>
          <td colspan="3" align="left"><input name="txt_vidautil" type="text" value="<?php echo $registro1['vida_util']." años";?>" size="2" maxlength="2" disabled="disabled"/></td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
            <tr>
              <td colspan="4"><?php

//inicializo el tipo  de operaci&oacute;n y recibo cualquier cadena que se desee buscar
	$sql = "SELECT * FROM rentabilidad ";

	$res=mysql_query($sql);
	$numeroRegistros=mysql_num_rows($res);
//}	
	
	if($numeroRegistros<=0)
	{
		echo "<div align='center'>";
		echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
		echo "</div>";
	}else{
		//elementos para el orden
		if(!isset($orden))
		{
		   $orden="fecha";
		}
		//fin elementos de orden
	
		//calculo de elementos necesarios para paginacion
		//tama&ntilde;o de la pagina
		$tamPag=5;
	
		//pagina actual si no esta definida y limites
		if(!isset($_POST["pagina"]))
		{
		   $pagina=1;
		   $inicio=1;
		   $final=$tamPag;
		}else{
		   $pagina = $_POST["pagina"];
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
//
	//fin de dicho calculo
	
	//creacion de la consulta con limites
	$sql="SELECT * FROM rentabilidad ORDER BY concepto ASC LIMIT ".$limitInf.",".$tamPag;

	
	//fin consulta con limites
	echo "<div align='center'>";
	echo "<font face='verdana' size='-2'>encontrados ".$numeroRegistros." resultados<br>";
	
	if(isset($txt_codigo))
	{
	   
	}
	echo "</font></div>";
?></td>
            </tr>
            <tr>
              <th width="10%" bgcolor="#06327D"><div align="center" class="Estilo17">Fecha</div></th>
              <th width="54%" bgcolor="#06327D"><div align="center" class="Estilo17"><strong>Concepto</strong></div></th>
              <th width="18%" bgcolor="#06327D"><span class="Estilo17">Ingresos</span></th>
              <th width="18%" bgcolor="#06327D"><div align="center" class="Estilo17">Egresos</div></th>
            </tr>
            <tr>
              <?php while($registro=mysql_fetch_array($res))
				{
			?>
              <td bordercolor="#999999"><?php echo  tranf_fecha_2($registro['fecha']);?></td>
              <td bordercolor="#999999"><?php 
			  			if(!empty($registro['concepto'])){
							echo ($registro['concepto']); 
						}else{ 
							echo ($registro['concepto']);
							} ?></td>
              <td bordercolor="#999999" align="right"><?php if(!empty($registro['ingreso'])){echo "$".number_format($registro['ingreso'], 0, ",", "."); $ingreso=$ingreso +$registro['ingreso'];}?></td>
              <td bordercolor="#999999" align="right"><?php if(!empty($registro['egreso'])){echo "- $".number_format($registro['egreso'], 0, ",", "."); $egreso=$egreso +$registro['egreso'];}?></td>
            </tr>
            <!-- fin tabla resultados -->
            <?php
}
echo "</table>";
}
?>
            <tr>
              <td></td>
              <td></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <br />
            <table border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td align="center" valign="top"><?php
?></td>
              </tr>
            </table>
            <?php
    mysql_close();
?>
          </table>
            <p>&nbsp;</p>
            <table width="45%" border="1" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td>Total Ingresos <?php echo "$".number_format($ingreso, 0, ",", ".");?></td>
                <td>Total Egresos <?php echo "$".number_format($egreso, 0, ",", ".");?></td>
              </tr>
              <tr>
                <td colspan="2" align="center">Resultado <?php echo "$".number_format($ingreso-$egreso, 0, ",", ".");?></td>
              </tr>
            </table><a href="rentabilidad.php" class="menulink">
            			<img src="images/clean.png" width="40" height="40" align="right" border="0" />
                    </a>
                    <a href="excel.php?nomexcel=<?php echo $nombre_equipo ;?>" onmouseover="Volver">
                    	<img src="images/Excel-icon.png" width="40" height="40" align="right" border="0" />
                    </a></td>
        </tr>
      </table>
    </form>
  </div></td>
  </tr>
</table>

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>

