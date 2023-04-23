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
<ul class="menu" id="menu">
	<li><a href="principal.php" class="menulink">Inicio</a>
		<ul>
			<li>
				<a href="#" class="sub">Parámetros AVR</a>
				<ul>
					<li class="topline"><a href="sucursales.php" target="_parent">Sucursales Vigomaq</a></li>
				   <li><a href="familia_rep.php" target="_parent">Familia Repuestos</a></li>
				   <li><a href="estado_equipo.php" target="_parent">Estado Equipo</a></li>
				   <li><a href="tipo_eval.php" target="_parent">Tipo Evaluación</a></li>
				   <li><a href="forma_eval.php" target="_parent">Forma Evaluación</a></li>
				   <li><a href="tarifas.php" target="_parent">Tarifa Despacho</a></li>
				   <li><a href="tipo_cliente.php" target="_parent">Tipo Cliente</a></li>
                   <li><a href="personal.php" target="_parent">Personal</a></li>
				   <li><a href="comuna.php" target="_parent">Comunas</a></li>
				   <li><a href="ciudad.php" target="_parent">Ciudades</a></li>
				   <li><a href="unidades.php" target="_parent">Unidades de medida</a></li>
                   <li><a href="condic_arri.php" target="_parent">Condiciones Arriendo</a></li>
                   <li><a href="tipo_obra.php" target="_parent">Tipo Obra</a></li>
                   <li><a href="tipo_personal.php" target="_parent">Tipo Personal</a></li>
                   <li><a href="forma_pago.php" target="_parent">Forma de Pago</a></li>
                   <li><a href="tipo_garantia.php" target="_parent">Tipo de Garantia</a></li>
                   <li class="topline"><?php if ($_SESSION['tipo_usuario']=="0") { ?><a href="iva.php">IVA</a><?php } ?></li>
				</ul>
		   </li>
		
		   <li>
				<a href="#" class="sub">Usuarios AVR</a>
				<ul>
				<li class="topline"><?php if ($_SESSION['tipo_usuario']=="0") { ?><a href="listado_us.php">Listado Usuarios</a><?php }else{ ?> <a href="usuario.php">Usuario</a><?php } ?></li>
                <li class="topline"><?php if ($_SESSION['tipo_usuario']=="0") { ?><a href="list_transacc.php">Listado Transacciones</a><?php } ?></li> 
              </ul>
		  </li>
	</ul>
	</li>
	<li>
		<a href="#" class="menulink">Archivos AVR</a>
		<ul>
			 <li><a href="cliente.php" target="_parent">Clientes/Obra</a></li>
		  <li><a href="proveedor.php" target="_parent">Proveedores</a></li>
		  <li><a href="equipo.php" target="_parent">Inventario Equipos</a></li>
			 <li><a href="repuesto.php" target="_parent">Inventario Repuestos</a></li>
		</ul>
	</li>
	<li>
		<a href="#" class="menulink">Servicios</a>
		<ul>
			 <li>
       	      <a href="#" class="sub">Arriendos</a>
				<ul>
				   <li class="topline"><a href="arriendo_cliente.php" target="_parent">Arriendo</a></li>
				   <li><a href="reclamo.php" target="_parent">Reclamo/Cambio Equipo</a></li>
				   <li><a href="evaluacion.php" target="_parent">Evaluación Técnica</a></li>
				   <li><a href="reparar_equipo.php" target="_parent">Reparacion Equipo</a></li>
                  <li><a href="arriendo_devolver.php" target="_parent">Devolver Arriendo</a></li>
	      		</ul>
			<li><a href="factura.php">Ventas</a>
		</ul>
		
  <li><a href="#" class="menulink">Facturación</a>
		  <ul>
			 <li><a href="arriendos_fact.php">Equipos por Facturar</a></li>
             <li><a href="facturar.php">Emitir Factura</a></li>
             <li><a href="anular.php">Anular Factura</a></li>
			 <li><a href="nc.php" target="_parent">Nota de Credito</a></li>
			 <li><a href="gd.php">Guia de Despacho</a></li>
		  </ul>
  </li>
	  		<li><a href="#" class="menulink">Gestión AVR</a> 
		  <ul>
			 <li><a href="busca_equipo.php" target="_parent">Consulta Equipos</a></li>
			 <li><a href="busca_rep.php" target="_parent">Consulta Repuestos</a></li>
			 <li><a href="busca_cliente.php" target="_parent">Consulta Clientes</a></li>
             <li><a href="busca_proveed.php" target="_parent">Consulta Proveedores</a></li>
             <li><a href="consulta_gd.php" target="_parent">Consulta Guia Despacho</a></li>
             <li><a href="otros_gastos.php" target="_parent">Otros Gastos - Repuestos</a></li>
             <li><a href="otros_gastos_e.php" target="_parent">Otros Gastos - Equipos</a></li>
			 <li><a href="listado_vtas.php" target="_parent">Ventas por Cliente</a></li>
 			 <li><a href="rentabilidad.php" target="_parent">Rentabilidad Activos</a></li>
             <li><a href="arriendos_pendientes.php">Arriendos O/C Pendiente</a></li>
		  </ul>
   		</li>
		
		<li><a href="#" class="menulink">Reportes</a>		 
			<ul> 
				<li><a href="listado_rep.php">Listado Repuestos</a></li>
				<li><a href="listado_proveed.php">Listado Proveedores</a></li>
				<li><a href="listado_clientes.php">Listado Clientes</a></li>
				<li><a href="listado_personal.php">Listado Personal</a></li>
                <li><a href="listado_obras.php">Listado Obras</a></li>
<li><a href="listado_equipos.php">Listado Equipos</a></li>
			</ul>
		</li>
		
		<li><a href="#" class="menulink">Cerrar Sesión</a>
		  <ul>
			 <li><a href="aut_logout.php" target="_parent" class="menu_top">Salir</a></li>
		  </ul>
   		</li>
       
</ul> 
<table width="70%" border="0" align="center">
  <tr>
    <td><div id="text" style="float:left; clear:left; width:100%; margin-top:10px">
 <form action="busca_proveed.php" method="post" name="frmDatos" id="frmDatos">
<table width="100%" border="0" align="center" class="bord_img">
        <tr>
          <td colspan="7" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
            <div align="right" class="Estilo19">
              <div align="right" class="Estilo20"> CONSULTA PROVEEDORES</div>
            </div>
          </div></td>
        </tr>
        <tr>
          <td><?php
		{
		include("conex.php");
		$link=Conectarse();
		}
	?>
            &nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="7" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS BUSQUEDA </span></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24"><div align="right">Rut</div></td>
          <td>:</td>
          <td><input name="codigo" type="text" class="searchbox" size="12" maxlength="12" /></td>
          <td>
          <input type="submit" name="buscarcodigo" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
          
          <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Proveedor por Rut" class="searchbutton" src="images/ver.png"/>-->
          </td>
          <td><div align="right">Raz&oacute;n Social </div></td>
          <td>:</td>
          <td><div align="left">
            <input name="paterno" type="text" size="35" maxlength="35" />
            
            <input type="submit" name="buscarnombre" value="Buscar" title="Buscar Proveedor por Razon Social" style="background-image:url(images/ver.png); height:16px; width:16px;" class="formato_boton"/>
            
            <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Proveedor por Razon Social" class="searchbutton" src="images/ver.png"/>-->
          </div></td>
        </tr>
        <tr>
          <td height="24" colspan="7"><table width="100%" border="0" align="center">
            <tr>
              <td><?php
if (($_POST['buscarcodigo']=='Buscar') || ($_POST['buscarnombre']=='Buscar'))
{
	
	$sql = "SELECT * FROM proveedor ";

	if ($_POST['codigo'] != "")
	{
	   $txt_codigo = $_POST["codigo"];
		
	   $sql .= " where Rut = '$txt_codigo'";
	}
	
	if ($_POST['paterno'] !="") 
	{
	   $txt_paterno = $_POST["paterno"];
	 
	   $sql .= " where raz_social like '%" . $txt_paterno . "%' ";
	}

	$sql .= " order by Rut ASC;";

	$res=mysql_query($sql);
	$numeroRegistros=mysql_num_rows($res);
}	
	
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
	
	echo "<div align='center'>";
	echo "<font face='verdana' size='-2'>encontrados ".$numeroRegistros." resultados<br>";
	//echo "ordenados por <b>".$orden."</b>";
	if(isset($txt_codigo))
	{
	 
	}
	echo "</font></div>";
?></td>
            </tr>
            <tr>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Rut Proveedor </div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Raz&oacute;n Social</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Fono</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">email</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Contacto</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Email Responsable</div></th>
              <th bgcolor="#06327D"><div align="center"></div></th>
            </tr>
            <tr>
              <?php while($registro=mysql_fetch_array($res))
				{
			?>
              <td><?php echo  $registro['Rut'] ; ?></td>
              <td><?php echo $registro['raz_social'] ;?></td>
              <td><?php echo $registro['fono'] ; ?></td>
              <td><?php echo $registro['email'] ;?></td>
              <td><?php echo $registro['contacto1'] ;?></td>
              <td><?php echo $registro['fono_cont1'] ; ?></td>
              <td><a href='proveedor.php?id=<?php echo $registro['Rut'];?>'>Editar</a></td>
            </tr>
            <tr>
              <td>------------------------</td>
              <td>---------------------------------------</td>
              <td>-----------------</td>
              <td>----------------------------</td>
              <td>----------------------</td>
              <td>---------------------</td>
              <td>----------</td>
            </tr>
            
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

