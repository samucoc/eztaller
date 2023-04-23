<?php ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 
$fecha_temp = array();
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}

if(isset($_GET['update'])){

	include("conex.php");
	$link=Conectarse();
	
	$id_arriendo = $_GET['id_arriendo'];
	$tipo_oc = $_GET['tipo_oc'];
	$num_oc = $_GET['num_oc'];
	$fecha_inicio_oc = $_GET['fecha_inicio'];
	if ($fecha_inicio_oc == 'undefined'){
		$fecha_inicio_oc ='';
		}
	
	$fecha_temp = explode("-",$fecha_inicio_oc);
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
	$fecha_inicio_oc = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

	$fecha_fin_oc = $_GET['fecha_fin'];

	$fecha_temp = explode("-",$fecha_fin_oc);
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
	$fecha_fin_oc = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

	$sql = "update arriendo 
				set tipo_oc = '".$tipo_oc."' , 
					num_oc = '".$num_oc."' ,
					fecha_inicio = '".$fecha_inicio_oc."' ,
					fecha_vcmto = '".$fecha_fin_oc."'
				where cod_arriendo = ".$id_arriendo;
	$rescliente = mysql_query($sql,$link) or die(mysql_error()); 
	?>
	<script>
		alert ('Actualizacion Realizada');
	</script>
	<meta http-equiv="refresh" content="0;URL=arriendos_pendientes.php" />
	<?php
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
<script>
function cambiar_estado(id_arriendo,tipo_oc, num_oc,fecha_inicio_oc, fecha_fin_oc){
	pagina = "arriendos_pendientes.php?id_arriendo="+id_arriendo+"&tipo_oc="+tipo_oc+"&update=update&num_oc="+num_oc+"&fecha_inicio="+fecha_inicio_oc+"&fecha_fin="+fecha_fin_oc;
	window.location = pagina;
	}
	
function cambia_tipo_oc(txt_oc,tipo_oc,fecha_inicio_oc,fecha_fin_oc){

	var fechaActual = new Date();
	dia = fechaActual.getDate();
	mes = fechaActual.getMonth() +1;
	anno = fechaActual.getYear();
   	if (dia <10) dia = "0" + dia;
	if (mes <10) mes = "0" + mes;  
	//fechaHoy = dia + "/" + mes + "/" + anno;

	fechaHoy1 = <?php echo date('d'); ?>;
	fechaHoy2 = <?php echo date('m'); ?>;
	fechaHoy3 = <?php echo date('Y'); ?>;
	fechaHoy = fechaHoy1+"-"+fechaHoy2 + "-" + fechaHoy3;
	
	valor = document.formulario.tipo_oc.value;
	
	if(valor == 0){
	
		document.formulario.fecha_inicio_oc.readOnly = false;
		document.formulario.fecha_inicio_oc.value = fechaHoy;
		document.formulario.fecha_inicio_oc.disabled = false;
	
		document.formulario.fecha_fin_oc.value = '';
		document.formulario.fecha_fin_oc.disabled = true;
		
	}
	
	if(valor ==1){

		document.formulario.fecha_inicio_oc.value = fechaHoy;
		document.formulario.fecha_inicio_oc.disabled = false;
	
		document.formulario.fecha_fin_oc.value = fechaHoy;
		document.formulario.fecha_fin_oc.disabled = false;

	}
	
	
	
	if(valor == 2){
		//Campos: Nº OC, Fecha Emisión OC y Fecha Vencimiento OC, deben quedar bloqueados (sin valores)
		document.formulario.fecha_fin_oc.value = '';
		document.formulario.fecha_fin_oc.readOnly = true;
		
		document.formulario.fecha_inicio_oc.value = '00-00-0000';
		document.formulario.fecha_inicio_oc.disabled = true;
	
		document.formulario.fecha_fin_oc.value = '00-00-0000';
		document.formulario.fecha_fin_oc.disabled = true;
		
	}

}

</script>

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
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css"/>
</head>
<body>
<table width="85%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
</table>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>	
<p>&nbsp;</p>
<table width="95%" border="0" align="center">
  <tr>
    <td align="center"><div id="text" style="float:left; clear:left; width:100%; margin-top:10px">
 <form name="formulario" id="formulario">
    <table width="100%" border="0" align="center" class="bord_img">
      <tr> 
        <td colspan="2" class='titulo_fondo'><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">Arriendos O/C Pendiente o Vencida</div>
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

		$sql="SELECT *
				FROM arriendo 
					inner join clientes
						on arriendo.rut_cliente = clientes.rut_cliente
				where (arriendo.tipo_oc = 3) or (arriendo.tipo_oc = 1 and arriendo.fecha_vcmto > ".date("Y-m-d").")
				order by clientes.raz_social asc" ;
		$res=mysql_query($sql);
?></td>
 <td width="10%" align="right" valign="top" bgcolor="#FFFFFF"><?php //echo "<a href='imp_list_per.php' target='_blank'>Vista Preliminar</a>"; ?></td>
      </tr>
      <tr><td colspan="2" valign="top" bgcolor="#06327D"><div align="left"></div></td>
      </tr>

      <tr>
        <td colspan="2"><table width="100%" border="0" align="center">
         
          <tr>
            <th width="145" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre Cliente  </div></th>
            <th width="145" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre Obra</div></th>
            <th width="58" bgcolor="#06327D"><div align="center" class="Estilo17">N. Guía Despacho</div></th>
            <th width="171" bgcolor="#06327D"><div align="center" class="Estilo17">Equipos Arrendados</div></th>
            <th width="60" bgcolor="#06327D"><div align="center" class="Estilo17">
              <div align="center" class="Estilo17">Num O.C.</div>
            </div></th>
            <th width="66" bgcolor="#06327D"><div align="center" class="Estilo17">Fecha Inicio OC</div></th>
            <th width="66" bgcolor="#06327D"><div align="center" class="Estilo17">Fecha Termino OC</div></th>
            <th width="132" bgcolor="#06327D"><div align="center" class="Estilo17">Cambiar Estado</div></th>
            <th width="132" bgcolor="#06327D" class="Estilo17">Estado Arriendo</th>
            </tr>
            <?php 
			$pos = 0;
			while($registro=mysql_fetch_array($res)){
				$pos++;
			?>
          <tr <?php 
			$sql_001 = "select distinct estado_equipo_arr
						from equipos_arriendo
						where cod_arriendo = ".$registro['cod_arriendo']."";
			$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
			$estado = ' style="display: none;" ';
			while ($row_001 = mysql_fetch_array($res_001)){
				if (($row_001['estado_equipo_arr']=='DEVUELTO-NO FACTURADO')||($row_001['estado_equipo_arr']=='NO DEVUELTO')){
					$estado = "";
					}
				}
			echo $estado;
			?> >
            <td><?php //echo $registro['rut_cliente'];
					$sqlcliente = "SELECT * FROM clientes where rut_cliente = '".$registro['rut_cliente']."'";
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registrocliente = mysql_fetch_array($rescliente);
					$valor1=$registrocliente['raz_social'];
					echo $valor1;
			?></td>
            <td><?php //echo $registro['cod_obra'];
						$sqlcliente = "SELECT * FROM obra where cod_obra = ".$registro['cod_obra'];
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registrocliente = mysql_fetch_array($rescliente);
					$valor1=$registrocliente['nombre_obra'];
					echo $valor1;
			?></td>
            <td>
			<?php 
				if ($registro['num_gd']==0){
					$sql_gd = "select distinct num_gd from equipos_arriendo where cod_arriendo =".$registro['cod_arriendo'];
					$res_gd = mysql_query($sql_gd,$link) or die(mysql_error());
					$row_gd = mysql_fetch_array($res_gd);
					
					echo $row_gd['num_gd'];
					}
				else{
					echo $registro['num_gd'];
					}
			?>
			</td>
            <td><?php //echo $registro['cod_arriendo'] ;
				$sqlcliente = "SELECT distinct cod_equipo
							FROM equipos_arriendo 
							where cod_arriendo =".$registro['cod_arriendo'];
				$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					//$registrocliente = mysql_fetch_array($rescliente);
				$cont_equipo = 0;	
				while($registrocliente=mysql_fetch_array($rescliente)){
					$cont_equipo++;
					$valor1=$registrocliente['cod_equipo'];
					// nombre equipo
					$sql_equipo = "SELECT * FROM equipo where cod_equipo = ".$valor1;
					$res_equipo = mysql_query($sql_equipo,$link) or die(mysql_error()); 
					$registro_equipo = mysql_fetch_array($res_equipo);
					$nombre_equipo=$registro_equipo['nombre_equipo'];
					//echo $nombre_equipo;
					//
					//echo $nombre_equipo."<br />";
					echo $cont_equipo.'.- '.htmlentities($nombre_equipo)."<br />";
					}
			?></td>
            <td><div align="center">
              <input name="num_oc_<?php echo $pos; ?>" type="text" id="num_oc_<?php echo $pos; ?>" value="<?php echo $registro['num_oc']; ?>" size="10"  />
            </div></td>
            <td><div align="center">
            	<input name="fecha_inicio_<?php echo $pos; ?>" type="text" class="validate[required] fecha_inicio" id="fecha_inicio_<?php echo $pos; ?>" size="11" maxlength="11" value="<?php 
				if ($registro['fecha_inicio']=='1969-12-31' || $registro['fecha_inicio']=='0000-00-00'){
					echo "00-00-0000";
					}
				else{
					$fecha_temp = explode("-",$registro['fecha_inicio']);
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
					}
				?>"/>
            </div></td>
            <td><div align="center">
               	<input name="fecha_fin_<?php echo $pos; ?>" type="text"  class="validate[optional] fecha_fin" id="fecha_fin_<?php echo $pos; ?>" size="11" maxlength="11" value="<?php 
				//echo $registro['fecha_vcmto'];
				if ($registro['fecha_vcmto']=='1969-12-31' || $registro['fecha_vcmto']=='0000-00-00'){
					echo "00-00-0000";
					}
				else{
					$fecha_temp = explode('-',$registro['fecha_vcmto']);
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
					}
				?>"/>
            </div></td>
            <td><select name="tipo_oc_<?php echo $pos; ?>" id="tipo_oc_<?php echo $pos; ?>" class="floatLeft validate[required]"  >
              <option value="0"
             <?php 
			if($registro['tipo_oc'] == 0) {
				echo "selected='selected'";
			}
			?>
            >ABIERTA</option>
              <option value="1"
             <?php 
			if($registro['tipo_oc'] == 1) {
				echo "selected='selected'";
			}
			?>
            >CERRADA</option>
              <option value="2"
             <?php 
			if($registro['tipo_oc'] == 2) {
				echo "selected='selected'";
			}
			?>
            >SIN O/C</option>
              <option value="2"
             <?php 
			if($registro['tipo_oc'] == 3) {
				echo "selected='selected'";
			}
			?>
            >PENDIENTE</option>
            </select>

              <a href="#" onClick="javascript:cambiar_estado('<?php echo $registro['cod_arriendo']; ?>', document.formulario.tipo_oc_<?php echo $pos; ?>.value, document.formulario.num_oc_<?php echo $pos; ?>.value, document.formulario.fecha_inicio_<?php echo $pos; ?>.value, document.formulario.fecha_fin_<?php echo $pos; ?>.value);" class="floatLeft" ><img src="images/guardar.png" alt="" width="30" height="30" border="0" /></a>
              <div class="clearFloat"></div></td>
            <td align="center"><?php 
			
			$sql_001 = "select distinct estado_equipo_arr
						from equipos_arriendo
						where cod_arriendo = ".$registro['cod_arriendo']."";
			$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
			$estado = "Finalizado";
			while ($row_001 = mysql_fetch_array($res_001)){
				if (($row_001['estado_equipo_arr']=='DEVUELTO-NO FACTURADO')||($row_001['estado_equipo_arr']=='NO DEVUELTO')){
					$estado = 'Arriendo No Finalizado';
					}
				}
			echo $estado;
			?></td>
            </tr>
          <tr <?php 
			$sql_001 = "select distinct estado_equipo_arr
						from equipos_arriendo
						where cod_arriendo = ".$registro['cod_arriendo']."";
			$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
			$estado = ' style="display: none;" ';
			while ($row_001 = mysql_fetch_array($res_001)){
				if (($row_001['estado_equipo_arr']=='DEVUELTO-NO FACTURADO')||($row_001['estado_equipo_arr']=='NO DEVUELTO')){
					$estado = "";
					}
				}
			echo $estado;
			?> >
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <!-- fin tabla resultados -->
          <?php
}//fin while
echo "</table>";
?>


        </table>
        
        
        </td>
      </tr>
    </table>
  </form>

</div></td>
  </tr>
</table>

<!--
<div align="center">Actualizar <input type="submit" name="OK" id="button" value="Guardar y Seguir" title="Guardar y Finalizar Arriendo" style="background-image:url(images/guardar.png); width:45px; height:45px" class="formato_boton"/>
</div>
-->

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/languages/jquery.validationEngine-es.js"></script>
<script src="js/i18n/jquery.ui.datepicker-es.js"></script>
<script>
    $(document).ready(function() {
		$( ".fecha_inicio, .fecha_fin" ).datepicker({
			firstDay: 1,
			dateFormat: "dd-mm-yy" 
			});
		$("#formulario").validationEngine('attach');
	});
</script>
</body>

</html>	