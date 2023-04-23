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
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
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
  document.location = 'repuesto.php';
}
 //-->
</script>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("Repuesto no ha sido ingresado!");
  document.location = 'repuesto.php';
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
			include('classes/menu.php'); //modulo menu
		?>
	</div>
<table width="95%" height="445" border="0" align="center">
  <tr>
    <td width="80%" height="80" align="center" valign="top"><form action="repuesto.php" method="POST" name="frmDatos" id="frmDatos">
      <table width="100%" border="0" align="center">
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
				
				if (empty($_GET["id"])){}else{
					$valor1 = $_GET["id"];}
				if (empty($_POST["txt_nombre_rep"])){}else{
					$valor1 = $_POST["txt_nombre_rep"];}
					
				if (empty($valor1)){}else{
					  	$link=Conectarse();
						$sql = "SELECT cod_repuesto, cod_familia, cod_fabricante, cod_unidad, ubicacion_repuesto, cod_proveedor, nombre_repuesto, cantidad_repuestos, fecha_compra, precio_costo, precio_bodega, precio_sala, porc_dscto, precio_costo_lista, obs_reposicion FROM vigomaq_intranet.repuesto WHERE cod_repuesto ='$valor1'";
				
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
					
					if (empty($registro['cod_repuesto']) && $_POST["buscar"]=="Buscar"){
							 	 echo "<script> alert (\"Repuesto No Encontrado\"); </script>";
					 }
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
              INVENTARIO REPUESTOS</font></strong></div>
            </div></td>
        </tr>
        <tr>
          <td colspan="4" height="8"></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#06327D"><span class="Estilo7">BUSCAR <span class="Estilo7 Estilo25">REPUESTO</span></span></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
        <tr class="bord_img">
          <td width="219" height="24"><div align="left"><strong>C&oacute;digo Repuesto</strong></div></td>
          <td width="17"><strong>:</strong></td>
          <td colspan="2"><strong>
            <input  name="txt_codigo" type="text" size="8" maxlength="8" value=""/>
            
            
            <input type="submit" name="buscarcodigo" title="Buscar Repuesto por Codigo" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
            <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Repuesto por Codigo" class="searchbutton" src="images/ver.png"/>-->
            <?php
				//envia el nombre
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$busca_cod = $_POST['txt_codigo'];
					$busca_cod = (string)(int)$busca_cod;
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_rep_ficha.php?id=$busca_cod'>";
				}
				//envia el codigo
				if (($_POST['buscarnombre']=='Buscar'))
				{
					$busca_nom = ltrim($_POST['txt_nombre']);
				
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_rep_ficha.php?nombre=$busca_nom'>";
				}
			?>
            &nbsp;<span class="Estilo20">
              <input type="hidden" name="txt_cod2" size="20" maxlength="30" value="<?php echo $registro['cod_equipo'];?>" />
            </span></strong></td>
        </tr>
        <tr class="bord_img">
          <td><div align="left"><strong>Nombre Repuesto</strong></div></td>
          <td><strong>:</strong></td>
          <td colspan="2"><strong>
            <input  name="txt_nombre" type="text" value=" " size="40" maxlength="40" />
            
            
            <input type="submit" name="buscarnombre" title="Buscar Repuesto por Nombre" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
            <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Repuesto por Nombre" class="searchbutton" src="images/ver.png"/>-->
            <input type="hidden" name="txt_nombre2" size="25" maxlength="25" />
            </strong></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#06327D"><span class="Estilo7">DATOS <span class="Estilo7 Estilo25">REPUESTO</span></span></td>
        </tr>
        <tr>
          <td>C&oacute;digo Repuesto</td>
          <td>:</td>
          <td width="317"><strong>
            <input  name="txt_codigo2" type="text" size="8" maxlength="8" value="<?php $cantidad = strlen($registro['cod_repuesto']); 
				   if ($cantidad==1) { echo ("00" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==2) { echo ("0" .('' . $registro['cod_repuesto'] . ' ') );  }
				   if ($cantidad==3) { echo '' . $registro['cod_repuesto'] . ' ';  }?>" disabled="disabled"/>
            <input type="hidden" name="txt_cod3" size="20" maxlength="30" value="<?php echo $registro["cod_repuesto"]?>"/>
          </strong></td>
          <td width="186"><span class="Estilo20">
            <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['cod_repuesto'];?>" />
          </span></td>
        </tr>
        <tr>
          <td><div align="left">Nombre Repuesto </div></td>
          <td>:</td>
          <td><div align="left"><strong>
          <textarea name="txt_nombre_rep" cols="35" rows="1"><?php if (!empty($registro['nombre_repuesto'])){echo ($registro['nombre_repuesto']);}else{echo($_POST["txt_nombre_rep"]) ;}?></textarea></strong></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Código Fabricante</div></td>
          <td>:</td>
          <td><div align="left">
            <input name="txt_cod_fab" type="text" value="<?php if (!empty($registro['cod_fabricante'])) 
			{echo ($registro['cod_fabricante']);}else{echo($_POST["txt_cod_fab"]) ;}?>" size="20" maxlength="20" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Familia</div></td>
          <td>:</td>
          <td><?php
			$sql1="SELECT cod_familia, familia_repuesto FROM familia_rep order by cod_familia ASC";
  			$res1=mysql_query($sql1,$link) or die(mysql_error());	
			
			echo "<select name=familia_repuesto>\n"; 

			while($campos1=mysql_fetch_row($res1))
			{	
               if ($registro['cod_familia']==$campos1[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos1[0].",".$campos1[1]?>" <?php echo $selected?>>
                  <?php echo $campos1[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo1 = explode( ',', $_POST['familia_repuesto'] );
					$cargo_id1 = $cargo1[0];
					$cargo_contenido1 = $cargo1[1];  
					echo $campos1; 
		 ?>
              </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Unidad de Medida </div></td>
          <td> :</td>
          <td align="left"><?php
			$sql2="SELECT cod_unidad, unidad FROM unidad order by cod_unidad ASC";
  			$res2=mysql_query($sql2,$link) or die(mysql_error());	
			
			echo "<select name=unid_medida>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro['cod_unidad']==$campos2[0]){
                    $selected2 = "SELECTED";
               }
               else {
                    $selected2 = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos2[0].",".$campos2[1]?>" <?php echo $selected2?>>
                  <?php echo $campos2[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo2 = explode( ',', $_POST['unid_medida'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
              </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Ubicacion Repuesto </div></td>
          <td>:</td>
          <td align="left"><div align="left">
            <input name="txt_ubicacion" type="text" value="<?php if (!empty($registro['ubicacion_repuesto'])){echo ($registro['ubicacion_repuesto']);}else{echo($_POST["txt_ubicacion"]) ;}//=$registro['ubicacion_repuesto'];?>" size="40" maxlength="40" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Proveedor</div></td>
          <td>:</td>
          <td><?php
		  
		  //print_r ($registro);
			$sql3="SELECT cod_fabricante, raz_social FROM proveedor order by raz_social ASC";
  			$res3=mysql_query($sql3,$link) or die(mysql_error());	
			
			echo "<select name=proveed>\n"; 

			while($campos3=mysql_fetch_row($res3))
			{	
			   //if ($registro['cod_fabricante']==$campos3[0]){
			   if ($registro['cod_proveedor']==$campos3[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
            <div align="left">
              <option value="<?php echo $campos3[0].",".$campos3[1]?>" <?php echo $selected?>>
              <?php echo $campos3[1]?>
              </option>
              <?php
			}  
                    echo "</select>";	
					$cargo3 = explode( ',', $_POST['proveed'] );
					$cargo_id3 = $cargo3[0];
					$cargo_contenido3 = $cargo3[1];  
					echo $campos3; 
		 ?>
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Fecha Compra </div></td>
          <td>:</td>
          <td><div align="left">
            <input type="text" id="cal-field-1" name="cal-field-1" value="<?php if (!empty($registro['fecha_compra'])){echo ($registro['fecha_compra']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha_compra'];?>"/>
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
          <td>Cantidad</td>
          <td> :</td>
          <td align="left"><div align="left">
            <input name="txt_cantidad" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['cantidad_repuestos'])){echo ($registro['cantidad_repuestos']);}else{echo($_POST["txt_cantidad"]) ;}//=$registro['cantidad_repuestos'];?>" size="9" maxlength="9" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Precio Costo </div></td>
          <td> :</td>
          <td align="left"><div align="left">
            <input name="txt_costo" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['precio_costo'])){echo ($registro['precio_costo']);}else{echo($_POST["txt_costo"]) ;}//=$registro['precio_costo'];?>" size="9" maxlength="9" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Precio Costo Lista </div></td>
          <td> :</td>
          <td align="left"><input name="txt_vallista" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['precio_costo_lista'])){echo ($registro['precio_costo_lista']);}else{echo($_POST["txt_vallista"]) ;}//=$registro['precio_costo_lista'];?>" size="9" maxlength="9" />          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Precio Bodega</div></td>
          <td> :</td>
          <td align="left"><div align="left">
            <input name="txt_valbodega" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['precio_bodega'])){echo ($registro['precio_bodega']);}else{echo($_POST["txt_valbodega"]) ;}//=$registro['precio_bodega'];?>" size="9" maxlength="9" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Precio Sala </div></td>
          <td> :</td>
          <td align="left"><div align="left">
            <input name="txt_valsala" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['precio_sala'])){echo ($registro['precio_sala']);}else{echo($_POST["txt_valsala"]) ;}//=$registro['precio_sala'];?>" size="9" maxlength="9" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">% Descuento </div></td>
          <td> :</td>
          <td align="left"><div align="left">
            <input name="txt_descuento" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['porc_dscto'])){echo ($registro['porc_dscto']);}else{echo($_POST["txt_descuento"]) ;}//=$registro['porc_dscto'];?>" size="3" maxlength="3" />
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="10" valign="top">Observaciones de Reposici&oacute;n</td>
          <td height="10" valign="top">:</td>
          <td height="10"><textarea name="txt_obsrepos" cols="50" rows="8"><?php if (!empty($registro['obs_reposicion'])){echo ($registro['obs_reposicion']);}else{echo($_POST["txt_obsrepos"]) ;}//=$registro['obs_reposicion'];?></textarea></td>
          <td height="10" valign="bottom"><?php $idrepuesto = $registro["nombre_repuesto"]; ?>
            
            
            <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
            
           <!--<input name="OK" type="image" class="boton" width="30" height="30" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" <?php echo $estado_objetos ;?>/>-->
            
            
             <a href="repuesto.php" class="menulink"><input name="Limpiar" type="image" title="Limpiar"  width="30" height="30" value="Limpiar"  src="images/clean.png"/></a>
            
            
             <input type="submit" name="eliminar" title="Eliminar Repuesto" value="Eliminar" onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style="background-image:url(images/salir.png); width:48px; height:48px;" class="formato_boton"/>
             
             <!--<input name="eliminar" type="image" class="boton" width="30" height="30" title="Eliminar Repuesto" value="Eliminar"  src="images/salir.png"  onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?>/>--></td>
        </tr>
        <tr>
          <td colspan="4" height="10"></td>
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
				function mensaje_rep()
				 {
					echo "<script>
					alert('No puede eliminar.');
					</script>";
				 }
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_nombre_rep']))
				{  
					$link=mensaje2();
				} else {
					
				};
			}
	  ?>   
    <?php
	if ($_POST['eliminar']=='Eliminar') 
	   {
	    if (!empty($_POST['txt_cod3'])){
			//veirificar si tiene documentos asociados
			//no tiene elimina
			 $link       = Conectarse();
			 $codigo     = $_POST['txt_cod3'];
			 $result_prov= mysql_query("SELECT COUNT(cod_repuesto) FROM arriendo WHERE cod_repuesto = '$codigo'");
			 $filas      = @mysql_num_rows($result_prov);
			  if ($filas>=1)
			  {
				$link=mensaje_rep();
			  }else{
				$sql = "DELETE FROM repuesto WHERE cod_repuesto = '$codigo'";
			
				$res = mysql_query($sql) or die(mysql_error()); 
				echo "<script type='text/javascript'>RegistroGrabado();</script>";
			  }
		}else{
			echo "<script> alert (\"No hay Repuesto que eliminar.\"); </script>";
		}
	   }
    ?>    
      <?php   
	$valor2 = $_POST["OK"];

if ($_POST['OK']=='Guardar y Seguir') {
	$nombre_rep         = strtoupper($_POST['txt_nombre_rep']); //echo "$nombre_rep<br>";
	$cod_fabricante     = strtoupper($_POST['txt_cod_fab']);    //echo "$cod_fabricante<br>"; 
	$cod_familia        = $cargo_id1;                     	             //echo "$cod_familia<br>"; 
	$unidad_med         = $cargo_id2;  	                                 //echo "$unidad_med<br>";  
	$proveedor          = $cargo_id3;  	                                 //echo "$proveedor<br>";
	$ubica              = strtoupper($_POST['txt_ubicacion']);  //echo "$ubica<br>"; 
	$fecha_compra       = $_POST['cal-field-1']; 	             //echo "$fecha_compra<br>";
	$cantidad           = $_POST['txt_cantidad']; 	             //echo "$cantidad<br>";
	$costo              = $_POST['txt_costo'];  	             //echo "$costo<br>";
	$costo_lista        = $_POST['txt_vallista'];               //echo "$costo_lista<br>";
	$valor_bodega       = $_POST['txt_valbodega']; 	         //echo "$valor_bodega<br>";
	$valor_sala         = $_POST['txt_valsala']; 	             //echo "$valor_sala<br>";
	$descuento          = $_POST['txt_descuento']; 	         //echo "$descuento<br>";	 
	$obs_reposicion     = strtoupper($_POST['txt_obsrepos']); 	 //echo "$obs_reposicion<br>";
	$obs_reposicion     = trim($obs_reposicion);
	
	if (empty($nombre_rep)||empty($cod_familia)||empty($unidad_med)||empty($ubica)||empty($proveedor)||empty($fecha_compra)||empty($cantidad)||empty($costo)||empty($costo_lista)||empty($valor_bodega)||empty($valor_sala)||empty($obs_reposicion)){  
		$link=mensaje();
	} else {
		$nombre_rep         = strtoupper($_POST['txt_nombre_rep']); //echo "$nombre_rep<br>";
		$cod_fabricante     = strtoupper($_POST['txt_cod_fab']);    //echo "$cod_fabricante<br>"; 
		$cod_familia        = $cargo_id1;                     	             //echo "$cod_familia<br>"; 
		$unidad_med         = $cargo_id2;  	                                 //echo "$unidad_med<br>";  
		$proveedor          = $cargo_id3;  	                                 //echo "$proveedor<br>";
		$ubica              = strtoupper($_POST['txt_ubicacion']);  //echo "$ubica<br>"; 
		$fecha_compra       = $_POST['cal-field-1']; 	             //echo "$fecha_compra<br>";
		$cantidad           = $_POST['txt_cantidad']; 	             //echo "$cantidad<br>";
		$costo              = $_POST['txt_costo'];  	             //echo "$costo<br>";
		$costo_lista        = $_POST['txt_vallista'];               //echo "$costo_lista<br>";
		$valor_bodega       = $_POST['txt_valbodega']; 	         //echo "$valor_bodega<br>";
		$valor_sala         = $_POST['txt_valsala']; 	             //echo "$valor_sala<br>";
		$descuento          = $_POST['txt_descuento']; 	         //echo "$descuento<br>";	 
		$obs_reposicion     = strtoupper($_POST['txt_obsrepos']); 	 //echo "$obs_reposicion<br>";
		$obs_reposicion     = trim($obs_reposicion);
				
		$codigo = $_POST['txt_cod'];	
		if (empty($codigo)){
			if ($descuento < '100')
			{
					 mysql_query("insert into vigomaq_intranet.repuesto (cod_familia,cod_fabricante,cod_unidad,ubicacion_repuesto,cod_proveedor,nombre_repuesto,cantidad_repuestos,fecha_compra,precio_costo,precio_bodega,precio_sala,porc_dscto,precio_costo_lista,obs_reposicion) values ('$cod_familia','$cod_fabricante','$unidad_med','$ubica','$proveedor','$nombre_rep','$cantidad','$fecha_compra','$costo','$valor_bodega','$valor_sala','$descuento','$costo_lista','$obs_reposicion')",$link);
					 
					  $sql5="SELECT * FROM  repuesto where cod_repuesto = LAST_INSERT_ID()";
					 
					  $res5 = mysql_query($sql5) or die(mysql_error()); 
					  $registro5 = mysql_fetch_array($res5);
					  $cod_repuesto = $registro5['cod_repuesto'];
					 
					 mysql_close($link);
					 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
					 echo "<script language=Javascript> location.href=\"repuesto.php?id=".$cod_repuesto."\"; </script>";
			}else{
				echo "<script> alert (\"Descuento no debe ser mayor a 100.\"); </script>";
			}
		 } else {
              if ($descuento < '100')
			{
				
					$sql = "UPDATE vigomaq_intranet.repuesto SET cod_familia='$cod_familia', cod_fabricante='$cod_fabricante', cod_unidad='$unidad_med', ubicacion_repuesto='$ubica', cod_proveedor='$proveedor', nombre_repuesto='$nombre_rep', cantidad_repuestos='$cantidad', fecha_compra='$fecha_compra', precio_costo='$costo', precio_bodega='$valor_bodega', precio_sala='$valor_sala', porc_dscto='$descuento', precio_costo_lista='$costo_lista', obs_reposicion='$obs_reposicion' where cod_repuesto='$codigo'";
					$res  = mysql_query($sql) or die(mysql_error());
					echo "<script type='text/javascript'>RegistroGrabado();</script>";
					echo "<script language=Javascript> location.href=\"repuesto.php?id=".$codigo."\"; </script>";
			}else{
				echo "<script> alert (\"Descuento no debe ser mayor a 100.\"); </script>";
				echo "<script language=Javascript> location.href=\"repuesto.php?id=".$codigo."\"; </script>";
			}
		  }	  
	}
 } 
?>