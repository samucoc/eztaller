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
  document.location = 'usuario.php';
}
 //-->
</script>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("Repuesto no ha sido ingresado!");
  document.location = 'usuario.php';
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
<ul class="menu" id="menu">
	<li><a href="principal.php" class="menulink">Inicio</a>
		<ul>
			<li>
				<a href="#" class="sub">Par�metros AVR >></a>
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
			 <li><a href="otros_gastos.php" target="_parent">Inventario Repuestos</a></li>
		</ul>
	</li>
	<li>
		<a href="#" class="menulink">Servicios</a>
		<ul>
			 <li><a href="#">Arriendos >> </a>
				<ul>
				   <li><a href="arriendo_cliente.php" target="_parent">Arriendo</a></li>
				   <li><a href="reclamo.php" target="_parent">Reclamo/Cambio Equipo</a></li>
				   <li><a href="evaluacion.php" target="_parent">Evaluación Técnica</a></li>
				   <li><a href="reparar_equipo.php" target="_parent">Reparacion Equipo</a></li>
<li><a href="arriendo_devolver.php" target="_parent">Devolver Arriendo</a></li>
	      		</ul>
			<li><a href="factura.php">Ventas </a>
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
			 <li><a href="busca_equipo.php">Consulta Equipos</a></li>
			 <li><a href="busca_rep.php">Consulta Repuestos</a></li>
			 <li><a href="busca_cliente.php">Consulta Clientes</a></li>
			 <li><a href="busca_proveed.php">Consulta Proveedores</a></li>
             <li><a href="consulta_gd.php" target="_parent">Consulta Guia Despacho</a></li>
             <li><a href="hoja_arriendo.php" target="_parent">Hoja de Arriendo</a></li>
			 <li><a href="otros_gastos.php" target="_parent">Otros Gastos - Repuestos</a></li>
             <li><a href="otros_gastos_e.php" target="_parent">Otros Gastos - Equipos</a></li>
			 <li><a href="listado_vtas.php" target="_parent">Ventas por Cliente</a></li>
 			<li><a href="rentabilidad.php" target="_parent">Rentabilidad Activos</a></li>
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
	  

<div id="text" style="float:left; clear:left; width:100%; margin-top:10px">
  <script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
  </script>
  <br />
</div>
	<link rel="stylesheet" type="text/css" href="styles_menu.css" />
	<script type="text/javascript" src="ie.js"></script>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<table width="75%" border="0" align="center">
  <tr>
    <td width="80%" height="80" align="center" valign="top"><form action="usuario.php" method="POST" name="frmDatos" id="frmDatos">
      <table width="80%" border="0" align="center">
        <tr>
          <td height="8">&nbsp;</td>
          <td height="8">&nbsp;</td>
          <td height="8" colspan="2"><div align="center" class="Estilo6">
            <div align="right" class="Estilo20"><strong><font>
              <?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
              <?php
			{
				if (empty($_SESSION['usuario'])){ 
				}else{
					$valor1 = $_SESSION['usuario'];}
					
				if (empty($valor1)){}else{
					$link=Conectarse();
					$sql = "SELECT * FROM vigomaq_intranet.usuario WHERE nombre_usuario ='$valor1'";
					
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
					$rut_usuario = $registro['rut_usuario'];
					
					if (empty($registro['rut_usuario']) && $_POST["buscar"]=="Buscar"){
						echo "<script> alert (\"Usuario No Encontrado\"); </script>";
					 }
					 
					 $sqlcli = "SELECT * FROM vigomaq_intranet.personal WHERE rut_personal ='$rut_usuario'";
					
					$rescli = mysql_query($sqlcli,$link) or die(mysql_error()); 
					$registrocli = mysql_fetch_array($rescli);
					
				}
				
			}
		?>
              <strong><font>
              <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
           	  
		}else{
			  $estado_objetos = 'disabled';
           	  
		};
		?>
              </font></strong> USUARIO             </font></strong></div>
          </div></td>
          </tr>
        <tr>
          <td colspan="4" height="8"></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#06327D"><div align="left"><span class="Estilo7 Estilo25">DATOS USUARIO</span></div></td>
        </tr>
        <tr>
          <td><?php if (empty($registrocli['cod_personal'])){ }else{ echo " Código Personal " ;}?></td>
          <td><?php if (empty($registrocli['cod_personal'])){ }else{ echo " : " ;}?></td>
          <td><div align="left"><span class='mini_titulo'>
            <?php if (empty($valor1)){ }else{ 
				   $cantidad = strlen($registrocli['cod_personal']); 
				   if ($cantidad==1) { echo ("00" .('' . $registrocli['cod_personal'] . ' ') );  }
				   if ($cantidad==2) { echo ("0" .('' . $registrocli['cod_personal'] . ' ') );  }
				   if ($cantidad==3) { echo '' . $registrocli['cod_personal'] . ' ';  }	
				?>
            </span>
            <?php } ?>
            </div></td>
          <td align="center" valign="middle"><span class="Estilo20">
            <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registrocli['cod_personal'];?>" />
            </span></td>
        </tr>
        <tr>
          <td><div align="left">Rut<span class="Estilo20"> </span></div></td>
          <td>:</td>
          <td><div align="left">
            <input name="txt_rut" type="text" id="rut" value="<?php 
 if (($registrocli['rut_personal']!= "") && (empty($registrocli['cod_personal'])))
			  {		$rut_param = $registrocli['rut_personal'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $registrocli['rut_personal'];
					}
					echo ($rutok);
				}else{ 
				  	if (!empty($registrocli['rut_personal'])) {
						echo($registrocli['rut_personal']); 
					}else{ 
						echo ($_POST['txt_rut']);
					}
				}?>" size="12" maxlength="12" disabled="disabled"/>
            <span class="Estilo20">
              <input type="hidden" name="txt_cod2" size="20" maxlength="30" value="<?php echo $registro['rut_personal'];?>" />
            </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Nombres</div></td>
          <td>:</td>
          <td><div align="left">
            <input name="txt_nombres" type="text" value="<?php echo $registrocli['nombres_personal'];?>" size="45" maxlength="45" disabled="disabled" />
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Apellido Paterno</div></td>
          <td> :</td>
          <td><div align="left">
            <input name="txt_appat" type="text" value="<?php echo $registrocli['ap_patpersonal'];?>" size="35" maxlength="35" disabled="disabled"/>
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Tipo Usuario</div></td>
          <td>:</td>
          <td><input name="txt_tipous" type="text" value="<?php if ($registro['tipo_usuario']=="0"){echo "ADMINISTRADOR";}?><?php if ($registro['tipo_usuario']=="1"){echo "NORMAL";}?><?php if ($registro['tipo_usuario']=="2"){echo "TECNICOS";}?>" size="15" maxlength="15" disabled="disabled" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Usuario</div></td>
          <td>:</td>
          <td><input name="txt_usuario" type="text" value="<?php echo $registro['nombre_usuario'];?>" size="10" maxlength="10" disabled="disabled"/></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Contrase&ntilde;a</div></td>
          <td>:</td>
          <td><input name="txt_contrasena" type="password" value="<?php echo $registro['contrasena'];?>" size="10" maxlength="10" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Nueva Contrase&ntilde;a</div></td>
          <td>:</td>
          <td><input name="txt_contrasena3" type="password" value="" size="10" maxlength="10" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Repetir Contrase&ntilde;a</div></td>
          <td>:</td>
          <td><div align="left"><input name="txt_contrasena2" type="password" size="10" maxlength="10"></div></td>
          <td>
          
          <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" />
          
          <!--<input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png"/>--></td>
        </tr>
        <tr>
          <td height="10" valign="top">&nbsp;</td>
          <td height="10" valign="top">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10" valign="bottom">&nbsp;</td>
        </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>
</html>
		<?php
			function mensaje()
				{
					echo "<script>
					alert('Ingrese Datos Usuario');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Usuario');
					</script>";
				 }
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_usuario']))
				{  
					$link=mensaje2();
				} else {
					
				};
			}
	  ?>      
      <?php   
	$valor2 = $_POST["OK"];
	if ($_POST['OK']=='Guardar y Seguir') {
		$rut_usuario        = $registrocli['rut_personal'];                     //  echo "$rut_usuario<br>";
		$usuario            = $registro['nombre_usuario'];                     //   echo "$usuario<br>";	
		$pass               = $_POST['txt_contrasena3'];               //   echo "$pass<br>";	
		$pass2              = $_POST['txt_contrasena2']; 	           //   echo "$pass2<br>";
		if (empty($rut_usuario)||empty($usuario)||empty($pass)){  
			$link=mensaje();
		} else {
			if ($pass == $pass2)
			{
				
				$rut_usuario        = $registrocli['rut_personal'];                    //    echo "$rut_cliente<br>";
				$usuario            = $registro['nombre_usuario'];          //    echo "$usuario<br>";	
				$pass               = $_POST['txt_contrasena3'];             //    echo "$pass<br>";	
				$pass2              = $_POST['txt_contrasena2']; 	         //    echo "$pass2<br>";
				$codigo             = $_POST['txt_cod'];
				$link=Conectarse();
				$sqlus      = "SELECT * FROM vigomaq_intranet.usuario WHERE rut_usuario ='$rut_usuario'";

				$resus      = mysql_query($sqlus,$link) or die(mysql_error()); 
				$registrous = mysql_fetch_array($resus);
				$cod_usuario = $registrous['rut_usuario'];
	
				$sqlact = "UPDATE vigomaq_intranet.usuario SET rut_usuario='$rut_usuario', nombre_usuario='$usuario', contrasena='$pass' where rut_usuario='$cod_usuario'";
		
				$resact  = mysql_query($sqlact) or die(mysql_error());
				echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
				echo "<script language=Javascript> location.href=\"usuario.php?id=".$rut_usuario."\"; </script>";
			}else{
				echo "<script> alert (\"Contrase�a y confirmacion no coinciden.\"); </script>";
			}
		}
	 } 
?>