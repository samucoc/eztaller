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
			include('classes/menu.php'); //modulo menu
		?>
	</div><table width="70%" border="0" align="center">
  <tr>
    <td><div id="text" style="float:left; clear:left; width:100%; margin-top:10px">
 <form action="busca_rep.php" method="post" name="frmDatos" id="frmDatos">
      <table width="100%" border="0" align="center" class="bord_img">
        <tr>
          <td colspan="7" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
            <div align="right" class="Estilo19">
              <div align="right" class="Estilo20"> CONSULTA REPUESTOS</div>
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
          <input type="submit" name="buscarcodigo" value="Buscar" title="Buscar Repuesto por Codigo" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
          
          <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Repuesto por Codigo" class="searchbutton" src="images/ver.png"/>-->
          </td>
          <td><div align="left">Nombre </div></td>
          <td>:</td>
          <td><div align="left">
            <input name="repuesto" type="text" size="35" maxlength="35" />
            
            <input type="submit" name="buscarnombre" value="Buscar" title="Buscar Repuesto por Nombre" style="background-image:url(images/ver.png); height:16px; width:16px" class="formato_boton" />
            
            <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Repuesto por Nombre" class="searchbutton" src="images/ver.png"/>-->
          </div></td>
        </tr>
        <tr>
          <td colspan="7"><table border="0" align="center">
            <tr>
              <td>
                <?php
if (($_POST['buscarcodigo']=='Buscar') || ($_POST['buscarnombre']=='Buscar'))
{
	
//inicializo el tipo  de operaci&oacute;n y recibo cualquier cadena que se desee buscar
	$sql = "SELECT * FROM repuesto ";

	if ($_POST['codigo'] != "")
	{
	   $txt_codigo = $_POST["codigo"];
	 	
	   $sql .= " where cod_repuesto = '$txt_codigo'";
	}
	
	if ($_POST['repuesto'] !="") 
	{
	   $txt_repuesto = $_POST["repuesto"];
	
	   $sql .= " where nombre_repuesto like '%" . $txt_repuesto . "%' ";
	}

	$sql .= " order by cod_repuesto ASC;";

	$res=mysql_query($sql);
	$numeroRegistros=mysql_num_rows($res);
}	
	
	if($numeroRegistros<=0)
	{
		echo "<div align='center'>";
		echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
		echo "</div>";
	}else{
		//elementos para el orden
		if(!isset($orden))
		{
		   $orden="cod_repuesto";
		}
		//fin elementos de orden
	
		//calculo de elementos necesarios para paginacion
		//tama&ntilde;o de la pagina
		$tamPag=50;
	
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

	if(isset($txt_codigo))
	{
	   
	}
	echo "</font></div>";
?></td>
            </tr>
            <tr>
              <th bgcolor="#06327D"><div align="center" class="Estilo17"> C&oacute;dgo Repuesto</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Precio Bodega </div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Precio Sala </div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Precio Costo Lista </div></th>
              <th bgcolor="#06327D"><div align="center"><span class="Estilo17"></span></div></th>
            </tr>
            <tr>
              <?php while($registro=mysql_fetch_array($res))
				{
			?>
              <td><?php 
                if (empty($registro['cod_repuesto'] )){ }else{ 
				   $cantidad = strlen($registro['cod_repuesto']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_repuesto'] . ' ';  }
               } ?></td>
              <td><?php echo htmlentities($registro['nombre_repuesto']) ;?></td>
              <td><?php echo $registro['cantidad_repuestos'] ; ?></td>
              <td align="right"><?php echo "$".number_format($registro['precio_bodega'], 0, ",", ".") ;?></td>
              <td align="right"><?php echo "$".number_format($registro['precio_sala'], 0, ",", ".") ;?></td>
              <td align="right"><?php echo "$".number_format($registro['precio_costo_lista'], 0, ",", ".") ; ?></td>
              <td align="right"><a href='repuesto.php?id=<?php echo $registro['cod_repuesto'];?>'>Editar</a></td>
            </tr>
            <tr>
              <td>-------------------------</td>
              <td>---------------------------------------------------</td>
              <td>---------------------</td>
              <td>-----------------</td>
              <td>--------------</td>
              <td>-----------------------</td>
              <td>----------</td>
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

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>

