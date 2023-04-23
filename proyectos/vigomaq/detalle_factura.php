<?php ob_start(); 
$resultado_resta = 0;
$sum=0;
$fecha_corte="";
	$flag_1=0;


				function restaFechas($dFecIni, $dFecFin) {
					$dFecIni = explode("-",$dFecIni);
					$dFecFin = explode("-",$dFecFin);

					$date1 = mktime(0, 0, 0,$dFecIni[1], $dFecIni[0], $dFecIni[2]);
					$date2 = mktime(0, 0, 0,$dFecFin[1], $dFecFin[0], $dFecFin[2]);
					
					return round(($date2 - $date1) / (60 * 60 * 24)) + 1;
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
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
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
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo24 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.Estilo25 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
<?php  	
if ($_POST['calcular']!='Calcular') {
		?>
.formato_boton{
	display:none;
	}
	<?php
	  }
	  ?>	
-->
</style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>
    
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
</head>
<body>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php'); //modulo cabecera
	?>
    </div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="75%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td height="37"><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
            <?php
			{
				$cod_obra = $_GET["cod_obra"];
				$cod_arr  = $_GET["codarr"];
				$valor1   = $_GET["equipo"];
				$num_gd   = $_GET["num_gd"];
			 
				if (!empty($valor1)) {
				
					$link=Conectarse();
					//mysql_select_db("vigomaq"); 
					//buscar equipo
				 	$sqleval   = "SELECT * FROM equipo WHERE cod_equipo ='$valor1'";
				 	
					$res         = mysql_query($sqleval,$link) or die(mysql_error()); 
					$registro    = mysql_fetch_array($res);
					$id          = $registro['cod_equipo'];
					
					//buscar en equipos arrendados
					$sqleq       = "SELECT * 
									FROM equipos_arriendo 
									WHERE cod_equipo ='$valor1' 
										and cod_arriendo = '$cod_arr' 
										and num_gd = '$num_gd' 
										and (estado_equipo_arr like 'DEVUELTO-NO FACTURADO' or estado_equipo_arr ='NO DEVUELTO')";
					$reseq       = mysql_query($sqleq,$link) or die(mysql_error()); 
					$registroeq  = mysql_fetch_array($reseq);
					
					//buscar en arriendo
					$sql_arr = "select *
								from arriendo
								where cod_arriendo = '$cod_arr'";
					$res_arr = mysql_query($sql_arr,$link);
					$row_arr = mysql_fetch_array($res_arr);
					
					//buscar nombre obra
					$sqlobra     = "SELECT obra.nombre_obra,obra.cod_cliente,
											obra.cod_obra,obra.cod_condic, 
											condic_arriendo.condiciones 
									FROM obra 
										inner join condic_arriendo
											on condic_arriendo.cod_cond_arr = obra.cod_condic
									WHERE obra.cod_obra ='$cod_obra'";
				 	
					$resobra     = mysql_query($sqlobra,$link) or die(mysql_error()); 
					$registroobra= mysql_fetch_array($resobra);
					$cod_cliente = $registroobra['cod_cliente'];
					
					//buscar nombre cliente
					$sqlcli   = "SELECT raz_social FROM clientes WHERE cod_cliente ='$cod_cliente'";
				
					$rescli       = mysql_query($sqlcli,$link) or die(mysql_error()); 
					$registrocli = mysql_fetch_array($rescli);
					$cliente     = $registrocli['raz_social'];
					
					$sql_fact_ult = "select distinct nro_factura
										 					FROM equipos_arriendo 
					 										WHERE num_gd = '$num_gd'
					 					";
					$res_fact_ult = mysql_query($sql_fact_ult,$link);
					$flag='0';
					while(($row_fact_ult = mysql_fetch_array($res_fact_ult))&&($flag=='0')){

						$nro_factura = $row_fact_ult['nro_factura'];

						$sql_num_factura     = "SELECT (COALESCE(num_factura,0)) as ncorr
										FROM factura
										where 
											num_factura > '37750' 
											and estado = '' 
											and num_factura = '".$nro_factura."'
										order by num_factura asc
										limit 0,1";
					 	
						$res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
						$registro_num_factura= mysql_fetch_array($res_num_factura);
						$num_factura_nuevo = $registro_num_factura['ncorr'];
						if (($num_factura_nuevo!='0')||($num_factura_nuevo!='')){
							$flag='1';
							}
						else{

							}
						}
					if (($num_factura_nuevo=='0')||($num_factura_nuevo=='')){
						$sql_num_factura     = "SELECT (COALESCE(num_factura,0)) as ncorr
										FROM factura
										where 
											num_factura > '37750' 
										order by num_factura desc
										limit 0,1";
					 	
						$res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
						$registro_num_factura= mysql_fetch_array($res_num_factura);
						if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 37751;
						else $num_factura_nuevo = $registro_num_factura['ncorr']+1;
						
						}
					else{
						echo "<script> alert ('Factura $num_factura_nuevo abierta.'); </script>";
						}
					// $sql_busca_gd = "select count(num_gd) as contador 
					// 				FROM equipos_arriendo 
					// 				WHERE num_gd = '$num_gd' 
					// 					and estado_equipo_arr in ('DEVUELTO-NO FACTURADO','NO DEVUELTO')

					// 					";
					// $res_busca_gd = mysql_query($sql_busca_gd,$link) or die(mysql_error());
					// $row_busca_gd = mysql_fetch_array($res_busca_gd);
					// $contador_gd_ea = $row_busca_gd['contador'];

					// $sql_busca_gd = "select count(num_gd) as contador 
					// 				FROM det_gd 
					// 				WHERE num_gd = '$num_gd' 
					// 					";
					// $res_busca_gd = mysql_query($sql_busca_gd,$link) or die(mysql_error());
					// $row_busca_gd = mysql_fetch_array($res_busca_gd);
					// $contador_gd = $row_busca_gd['contador'];


					// //echo "$contador_gd > $contador_gd_ea";
					// if ($contador_gd_ea==0){

					// 	}
					// else{
					// 	if ($contador_gd > $contador_gd_ea ){
					// 		$sqlnro_factura       = "SELECT nro_factura
					// 					FROM equipos_arriendo 
					// 					WHERE cod_arriendo = '$cod_arr' 
					// 						and num_gd = '$num_gd' 
					// 						and estado_equipo_arr not in ('DEVUELTO-NO FACTURADO','NO DEVUELTO')
					// 					order by cod_equipo_arriendo desc
					// 					limit 0,1";
					// 		$resnro_factura       = mysql_query($sqlnro_factura,$link) or die(mysql_error()); 
					// 		$registronro_factura  = mysql_fetch_array($resnro_factura);
							
					// 		$num_factura_nuevo = $registronro_factura['nro_factura'];
					// 		$sql_filtro = "select * 
					// 						from folios_dte
					// 						where desde <= '".$num_factura_nuevo."' and 
					// 								hasta >= '".$num_factura_nuevo."' and 
					// 								tipo = 33";
					// 		$res_filtro = mysql_query($sql_filtro,$link);
					// 		if (mysql_num_rows($res_filtro)==0){
					// 			$sql_num_factura     = "SELECT (COALESCE(num_factura,0) + 1) as ncorr
					// 					FROM factura
					// 					WHERE num_factura < 100
					// 					order by num_factura desc";
					 	
					// 			$res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
					// 			$registro_num_factura= mysql_fetch_array($res_num_factura);
					// 			$num_factura_nuevo = $registro_num_factura['ncorr'];
					// 			}
					// 		}
					// 	}
					if ($num_factura_nuevo=='') $num_factura_nuevo=1;

						$sql_filtro = "select * 
										from folios_dte
										where desde <= '".$num_factura_nuevo."' and 
												hasta >= '".$num_factura_nuevo."' and 
												tipo = 33";
						$res_filtro = mysql_query($sql_filtro,$link);
						if (mysql_num_rows($res_filtro)==0){
							$num_factura_nuevo = "Error.";
							}
					
				}
			}
		 ?>
            DETALLE EQUIPO</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td height="530" valign="top"><form method="post" enctype="multipart/form-data" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="left">
            <tr>
              <td colspan="7"></td>
            </tr>
            <tr>
              <td width="11%" bgcolor="#06327D"><span class="Estilo24">DATOS EQUIPO </span><span class="Estilo24">
                <div align="right"></div>
              </span></td>
              <td width="1%" bgcolor="#06327D">&nbsp;</td>
              <td width="47%" bgcolor="#06327D"><span class="Estilo24"><?php echo("Estado : ".$registroeq['estado_equipo_arr']);?></span></td>
              <td width="11%" bgcolor="#06327D">&nbsp;</td>
              <td colspan="3" bgcolor="#06327D" align="right"><span class="Estilo24">
                <?php  $fecha = date ("d-m-Y"); echo($fecha);?>
              </span></td>
              </tr>
            <tr>
              <td colspan="7"></td>
            </tr>
            <tr>
              <td><div align="left">N&deg; Guia Despacho</div></td>
              <td>:</td>
              <td align="left" style="font-size:18px; font-weight:bold">
			  <?php 
			  	echo $num_gd;
			  	//echo $num_gd." || Equipo : ".$valor1;
				  ?>
              
              </td>
              <td align="right" valign="middle">N&deg; Factura</td>
              <td width="1%" align="right" valign="middle">:</td>
              <td width="20%"  align="right" valign="middle"><span class="Estilo24">
                <input name="txt_factura" id="txt_factura" type="text"onkeypress="return acceptNum(event)" value="<?php if ($_POST['txt_factura']=='') echo $num_factura_nuevo;
                																						else echo($_POST['txt_factura']);?>"  class="validate[required,custom[number]]"  size="10" maxlength="10" style="font-size:18px; font-weight:bold; color:red; border:#F00 solid 2px; padding:5px"/>
              </span></td>
	              <td width="9%" align="right" valign="middle">&nbsp;</td>
              </tr>
            <tr>
              <td><div align="left">Cliente</div></td>
              <td>:</td>
              <td><input name="txt_cliente" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?><?php // =$_GET['nomequipo'];?>" size="50" maxlength="50" disabled="disabled" />
                <input name="txt_codcliente" type="hidden" value="<?php 
					if (!empty($registroobra['cod_cliente'])) {
						echo ($registroobra['cod_cliente']);
						}
					else{
						echo($_GET['txt_codcliente']);
						}
					?>" size="10" maxlength="10" disabled="disabled" /></td>
              <td align="right" valign="middle">Nro. OC</td>
              <td align="right" valign="middle">:</td>
              <td align="right" valign="middle"><?php echo $row_arr['num_oc']?></td>
              </tr>
            <tr>
              <td><div align="left">Obra</div></td>
              <td>:</td>
              <td><input name="txt_obra" type="text" value="<?php if (!empty($registroobra['nombre_obra'])) {echo ($registroobra['nombre_obra']);}else{echo($_GET['txt_obra']);}?><?php // =$_GET['nomequipo'];?>" size="40" maxlength="40" disabled="disabled" /></td>
              <td align="right" valign="middle">Tipo OC</td>
              <td align="right" valign="middle">:</td>
              <td align="right" valign="middle"><?php 
			  	$tipo_oc = $row_arr['tipo_oc'];
				if ($tipo_oc=='0'){
					echo "ABIERTA";
					}
				elseif ($tipo_oc=='1'){
					echo "CERRADA";
					}
				elseif ($tipo_oc=='2'){
					echo "SIN O/C";
					}
				elseif ($tipo_oc=='3'){
					echo "O/C PENDIENTE";
					}
			  ?></td>
              </tr>
            <tr>
              <td>Condiciones de Arriendo</td>
              <td>:</td>
              <td><input name="txt_condicarr" type="text" value="<?php 
			  		echo($registroobra['condiciones']);
					?>" size="40" maxlength="40" disabled="disabled" />
                <input name="txt_codobra" type="hidden" value="<?php if (!empty($registroobra['cod_obra'])) {echo ($registroobra['cod_obra']);}else{echo($_GET['txt_codobra']);}?><?php // =$_GET['nomequipo'];?>" size="10" maxlength="10" disabled="disabled" /></td>
              <td align="right" valign="middle">Fecha Emision OC</td>
              <td align="right" valign="middle">:</td>
              <td align="right" valign="middle"><?php 
			  	if(($row_arr['tipo_oc']=='0')||($row_arr['tipo_oc']=='1')){
					if (($row_arr['fecha_inicio']!='0000-00-00')&&($row_arr['fecha_inicio']!='1969-12-31')){
						$fecha_temp = explode("-",$row_arr['fecha_inicio']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
						}
					}
				?></td>
              <td align="right" valign="middle"></td>
            </tr>
            <tr>
              <td><div align="left">Nombre Equipo </div></td>
              <td>:</td>
              <td><input name="txt_nomequipo" type="text" value="<?php 
			  	if (!empty($registro['nombre_equipo'])) {
					echo (htmlentities($registro["nombre_equipo"]));
					}
				else{
					echo($_GET['txt_nomequipo']);}
				?>" size="40" maxlength="40" disabled="disabled" /></td>
              <td align="right" valign="middle">Fecha Vencimiento OC</td>
              <td align="right" valign="middle">:</td>
              <td align="right" valign="middle"><?php 
			  	if ($row_arr['tipo_oc']=='1'){
					if (($row_arr['fecha_vcmto']!='0000-00-00')&&($row_arr['fecha_vcmto']!='1969-12-31')){
						$fecha_temp = explode("-",$row_arr['fecha_vcmto']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
						}
					else{
						echo "Falta fecha vencimiento OC";
						}
					}
			  ?></td>
              <td align="right" valign="middle"></td>
              </tr>
            <tr>
              <td>Reclamo</td>
              <td>:</td>
              <td>
              
              <textarea name="textfield" cols="50" rows="3" id="textfield" disabled="disabled"><?php if ($registroeq['cod_reclamo'] != 0){
			  
			  $sql_reclamo = "SELECT * FROM reclamo where cod_reclamo = ".$registroeq['cod_reclamo'];
			  $res_reclamo       = mysql_query($sql_reclamo,$link) or die(mysql_error()); 
			  $registroreclamo = mysql_fetch_array($res_reclamo);
			  
			
    			$salida = "Falla: ".$registroreclamo['det_falla']." \nFecha Reclamo: ".$registroreclamo['fecha_reclamo']." - Hora: ".$registroreclamo['hora_reclamo']."\nResolución: ".$registroreclamo['resolucion_reclamo'];
    
   echo $salida;
    
   /*
    [det_falla] => AA
    [fecha_reclamo] => 14/08/2011
    [hora_reclamo] => 6:47:23
    [num_gd_salida] => 201
    [num_gd_ingreso] => 200
    [resolucion_reclamo] => BB
	*/
              
			  
			  }else{
			  echo 'No Posee reclamo';
              
              }
			  
			   ?>
</textarea>
             
              
              <a href="#" onclick="ver_reclamo();"></a>
              
              
              </td>

              <td align="right" valign="middle">&nbsp;</td>
              <td align="right" valign="middle">&nbsp;</td>
                 <?php 
							if (($row_arr['tipo_oc']=='1')&&(isset($_POST['txt_hasta']))){
								$fecha_hasta = $_POST['txt_hasta'];
								$fecha_temp = explode("-",$fecha_hasta);
								$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
								$fecha_hasta = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

								$fecha_vencimiento_oc = $row_arr['fecha_vcmto'];
								if ($fecha_vencimiento_oc < $fecha_hasta){
									echo '<td align="right" valign="middle" style="color:#F00; font-weight:bold; border:#F00 solid 2px; padding:10px">						ORDEN DE COMPRA VENCIDA</td>';
									}								
								}
							elseif($row_arr['tipo_oc']=='3'){
								echo '<td align="right" valign="middle" style="color:#F00; font-weight:bold; border:#F00 solid 2px; padding:10px">						O/C PENDIENTE</td>';
								}						
					?>
            </tr>
            <tr>
              <td><div align="left">Estado Equipo</div></td>
              <td>:</td>
              <td align="left"><div align="left">
                <?php
				$precio = 0;
				if ($registroeq['precio']==0){
					$sqlest      = "SELECT equipo.cod_estado_equipo, det_gd.precio as valor_unidad_arr 
										FROM equipo 
											inner join det_gd
												on det_gd.cod_equipo = equipo.cod_equipo
										where det_gd.cod_equipo='$valor1'
											and det_gd.num_gd = '$num_gd'";
					$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
					$registroest = mysql_fetch_array($resest);
					$precio = $registroest['valor_unidad_arr'];
					if (empty($registroest['valor_unidad_arr'])){
						$sqlest      = "SELECT cod_estado_equipo, valor_unidad_arr 
										FROM equipo 
										where cod_equipo='$valor1'";
						$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
						$registroest = mysql_fetch_array($resest);
						$precio = $registroest['valor_unidad_arr'];
						}
					}
				else{
					$precio = $registroeq['precio'];

					}
				$sql2="SELECT estado_equipo.cod_estado_equipo, est_equipo, descripcion_estado 
						FROM estado_equipo 
						inner join equipo
							on estado_equipo.cod_estado_equipo = equipo.cod_estado_equipo
						where equipo.cod_equipo = '$valor1'
						order by estado_equipo.cod_estado_equipo ASC";
				$res2=mysql_query($sql2,$link) or die(mysql_error());	
				
				while($campos2=mysql_fetch_row($res2))
				{	
		    ?>
                <div align="left">
					<?php 
						if ($campos2[1]==0) {
							$campos2[1] ="NO DISPONIBLE" ;
							}
						else{ 
							$campos2[1] ="DISPONIBLE";
							}
					?>
                    <?php echo $campos2[1]." - ".$campos2[2]?>                    
                  <?php
			}  
					$cargo2 = explode( ',', $_POST['estado_equipo'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
                  </div>
              </div></td>
              	<td align="right" valign="middle" >
                </td>
              </tr>
            <tr>
              <td>Valor Arriendo Diario </td>
              <td>:</td>
              <td align="left" valign="middle"><input name="txt_valor_dia" type="text" value="<?php 
			  			echo $precio;
					?>" size="10" maxlength="10"/>
                <input name="txt_valorunidad" type="hidden" value="<?php 
			  			echo $precio;
					?>" size="10" maxlength="10" disabled="disabled"/></td>
              <td align="left" valign="middle">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Fecha Arriendo</div></td>
              <td>:</td>
              <td><div align="left">
                <input name="txt_desde" type="text" value="<?php 
					//echo $registroeq['arrendado_desde'];
					$fecha_temp = explode("-",$registroeq['arrendado_desde']);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
					?>" size="10" maxlength="10" readonly="readonly"   />
                </div></td>
              <td align="right" valign="middle"><div align="right">Hora Arriendo</div></td>
              <td align="right" valign="middle">:</td>
              <td align="right" valign="middle"><input name="txt_hora_arr" type="text" value="<?php 
			  		if (isset($_POST['txt_hora_arr'])) echo $_POST['txt_hora_arr'];
					else echo $registroeq['hora_arr'];?>" size="10" maxlength="10"   /></td>
            </tr>
            <tr>
              <td><div align="left"><?php if ($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO"){ echo("Feha Devoluci�n"); }else{ echo("Fecha Corte"); }?> </div></td>
              <td>:</td>
              <td align="left"><?php if ($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO"){ ?>
              	<input name="txt_hasta" id="txt_hasta" type="text" value="<?php 
					if (empty($registroeq['arrendado_hasta'])){
						$fecha = date ("d-m-Y"); 
						echo($fecha);
						}
					else{
						$fecha_temp = explode("-",$registroeq['arrendado_hasta']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
						}
			?>" size="10" maxlength="10" /> 
			<?php }else{ ?> 
            	<input name="txt_hasta" type="text" id="txt_hasta" value="<?php 
					if (!empty($registro['arrendado_hasta'])){
						$fecha_temp = explode("-",$registroeq['arrendado_hasta']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
					}else{
						echo($_POST["txt_hasta"]) ;}
						?>" size="10" maxlength="10"   />
           <button type="submit" id="cal-button-1">...</button>
            <?php } ?></td>
            
			<?php 
			if ($registroeq['estado_equipo_arr']=="NO DEVUELTO"){ 
              echo '
			  <td align="left"><div align="right">Hora Devoluci&oacute;n</div></td>
			  <td>:</td>
              <td align="right"><input name="txt_hora_dev" type="text" value="18:30:00" size="10" maxlength="10"  />
              </td> ';
                }else{ 
			echo '
              <td align="left"><div align="right">Hora Devoluci&oacute;n </div></td>
			  <td>:</td>
              <td align="right"><input name="txt_hora_dev" type="text" value="';
			  		if (isset($registroeq['hora_devol'])){ 
						echo $registroeq['hora_devol'];
						}
			echo '" size="10" maxlength="10"   /></td> ';
				} ?>
            </tr>
            <tr>
              <td>Arrendado hace</td>
              <td>:</td>
              <td align="left"><?php 
 				 if ($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO"){ 
						$fecha_temp_1 = explode("-",$registroeq['arrendado_desde']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp_1[1], $fecha_temp_1[2], $fecha_temp_1[0]));
						$fecha_temp_1 =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

						$fecha_temp_2 = explode("-",$registroeq['arrendado_hasta']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						$fecha_temp_2 =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

  			   	    $resultado_resta = restaFechas($fecha_temp_1,$fecha_temp_2);
				    $resultado_resta = $resultado_resta;
					/*if ($registroobra['cod_condic']!=1) {
							$fecha1  = $registroeq['arrendado_desde'];
							//$fecha1=str_replace("/", "-", $fecha1);
							$fecha1=strftime('%Y-%m-%d',strtotime($fecha1));	
						 
							$fecha2  = $registroeq['arrendado_hasta']; 
							//$fecha2=str_replace("/", "-", $fecha2);
							$fecha2=strftime('%Y-%m-%d',strtotime($fecha2)); 
					
							$fecha1 = strtotime($fecha1); 
							$fecha2 = strtotime($fecha2); 
					
					for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
						if ($registroobra['cod_condic']==2){
							if((strcmp(date('D',$fecha1),'Sun')!=0) and (strcmp(date('D',$fecha1),'Sat')!=0)){
								$sum=$sum+1;
							}
						}elseif ($registroobra['cod_condic']==4){
							if((strcmp(date('D',$fecha1),'Sun')!=0)){
								$sum=$sum+1;
							}
						}
					}   
					echo $resultado_resta = $sum;
				    }*/
				 }
				 
				 if ($registroeq['estado_equipo_arr']=="NO DEVUELTO"){ 
				   $fecha_corte = $_POST['txt_hasta'];
				   if (!(isset($_POST['txt_hasta']))){
					   $fecha_corte = date("d-m-Y");
					   }
					$fecha_inicio = $registroeq['arrendado_desde'];
					$fecha_inicio = explode("-",$fecha_inicio);
					
					$date1 = getdate(mktime(0, 0, 0,$fecha_inicio[1], $fecha_inicio[2], $fecha_inicio[0]));
					$fecha_inicio = $date1['mday'].'-'.$date1['mon']."-".$date1['year'];  
					
				   $resultado_resta = restaFechas($fecha_inicio,$fecha_corte);
				  /* if ($registroobra['cod_condic']!=1) {
						$fecha1 = strtotime($fecha_inicio); 
						$fecha2 = strtotime($fecha_corte); 
						for( ;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
							if ($registroobra['cod_condic']==2){
								if((strcmp(date('D',$fecha1),'Sun')!=0) and (strcmp(date('D',$fecha1),'Sat')!=0)){
									$sum=$sum+1;
								}
							}elseif (($registroobra['cod_condic']==4)||($registroobra['cod_condic']==5)){
								if((strcmp(date('D',$fecha1),'Sun')!=0)){
									$sum=$sum+1;
								}
							}
						}   
						$resultado_resta = $sum;
				   	}*/
				}
				  
			    ?> <input name="txt_dias_arrendado" type="text" value="<?php
				
			   if (!empty($fecha_corte)) {
				   if ($resultado_resta < '0'){  
						echo "0";
					}else{
						echo ($resultado_resta." dias.");
					}
			   }else{ 
					if ($resultado_resta > '0'){
						echo($resultado_resta." dias.");
						}
					else{ 
						echo "0";
					}
				}?>" size="10" maxlength="10" readonly="readonly"/>
				<?php 
					if ($resultado_resta < '0') 
						echo("Fecha Corte debe ser posterior a Fecha Arriendo"); 
				?>
              </td>
              <td height="24" align="right" valign="middle" class="Estilo20">Total dias a Facturar</td>
              <td align="right" valign="middle"  class="Estilo20">:</td>
              <td align="right" valign="middle" class="fondo"><input name="txt_totdias" type="text" class="cantidades" value="<?php
			  if ($_POST['calcular']=='Calcular') {
				  
				$dia_menos = 0;
				$fecha_arr_temp 	=	$_POST['txt_desde'];
				$hora_arr_temp  	=	$_POST['txt_hora_arr'];
				$fecha_dev_temp		= 	$_POST['txt_hasta'];
				$hora_dev_temp 		= 	$_POST['txt_hora_dev'];
				$resultado_resta 	= 	restaFechas($fecha_arr_temp,$fecha_dev_temp)-1;
				//if ($resultado_resta > 0){
					if ($fecha_arr_temp == $fecha_dev_temp){
						$resultado_resta = $resultado_resta + 1;
					}
					else{
						if ($hora_arr_temp <= '14:00:00' && $hora_dev_temp <= '14:00:00'){
							$resultado_resta = $resultado_resta;
						}
						else{
							if ($hora_arr_temp < '14:00:00' && $hora_dev_temp > '14:00:00'){
								$resultado_resta = $resultado_resta + 1;
								}
							else{
								if($hora_arr_temp > '14:00:00' && $hora_dev_temp <= '14:00:00' && $resultado_resta>1){
										$resultado_resta = $resultado_resta - 1;
									}
								else{
									$resultado_resta = $resultado_resta;
									}
								}
							}
						}
				/*if ($registroobra['cod_condic']!=1) {
						$fecha1 = strtotime($fecha_arr_temp); 
						$fecha2 = strtotime($fecha_dev_temp); 
						$sum=0;
						for( ;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
							if ($registroobra['cod_condic']==2){
								if((strcmp(date('D',$fecha1),'Sun')!=0) and (strcmp(date('D',$fecha1),'Sat')!=0)){
									$sum=$sum+1;
								}
							}elseif (($registroobra['cod_condic']==4)||($registroobra['cod_condic']==5)){
								if((strcmp(date('D',$fecha1),'Sun')!=0)){
									$sum=$sum+1;
								}
							}
						}   
						$resultado_resta = $sum;
				   	}*/
					
				  if ($resultado_resta > 0) {
					  echo $total_dias_arr = $resultado_resta - $_POST['txt_ajustes'];	
					  //if ($total_dias_arr < '0'){ echo("0");}else{echo($total_dias_arr);}
					  
				  }else{
					  if ($resultado_resta < '0'){ echo("0");}else{echo($resultado_resta);}
				  }
			  }else{
			  	echo $_POST['txt_totdias'];
				}
			  ?>"  size="3" maxlength="3" readonly="readonly" /></td>
              <td align="right" valign="middle" class="Estilo20"><?php 
			  	if (isset($_POST['calcular'])){
					if ($resultado_resta < '0'){ 
						echo("Fecha Corte debe ser posterior a Fecha Arriendo");
						} 
					if ($total_dias_arr < '0'){ 
						echo("    Ajuste Incorrecto");
						} 
					}
				?></td>
              </tr>
            <tr>
              <td>Monto dias </td>
              <td>:</td>
              <td align="left"><input name="txt_monto_dias" type="text" value="<?php
            if ($_POST['calcular']=='Calcular') {  
					$resultado = ($resultado_resta)*$_POST['txt_valor_dia'];
					if ($resultado < 0 ) { 
						echo("0") ;
						}
					else{
						//$resultado;   
						//echo $resultado_final = $resultado + $total - (($resultado_resta-$dia_menos)*($registroest['valor_unidad_arr']));
						//echo $dia_menos;
						//echo " -> ".($resultado_resta);
					}
				/*if ($registroobra['cod_condic']!=1) {
					$fecha1 = strtotime($fecha_arr_temp); 
					$fecha2 = strtotime($fecha_dev_temp); 
					$sum=0;
					for( ;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
						if ($registroobra['cod_condic']==2){
							if((strcmp(date('D',$fecha1),'Sun')!=0) and (strcmp(date('D',$fecha1),'Sat')!=0)){
								$sum=$sum+1;
							}
						}elseif (($registroobra['cod_condic']==4)||($registroobra['cod_condic']==5)){
							if((strcmp(date('D',$fecha1),'Sun')!=0)){
								$sum=$sum+1;
							}
						}
					}   
					$resultado_resta = $sum;
				   }*/
				   echo $resultado = (($resultado_resta-$ajustes)*$_POST['txt_valor_dia']);
				}else{
				  echo(0);
				}
			//}
			  ?>" size="10" maxlength="10" readonly="readonly"/>
                <?php if (($resultado < '0')&&(isset($_POST['calcular']))) { 
					echo("Ajuste Incorrecto");
					}?></td>
              <td align="right" valign="middle"><p>Porcentaje Descuento</p></td>
              <td align="right" valign="middle">:</td>
              <td align="right" valign="middle"><input type="text" name="porcentaje_vu" id="porcentaje_vu"  size="10" maxlength="10" class="validate[required,custom[number]]" value="<?php if (isset($_POST['porcentaje_vu'])){
			  										echo $_POST['porcentaje_vu'];
													}
												else {
													echo "0";
													}
												?>"/>
                %</td>
              <td align="right" valign="middle" class="Estilo20">&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo20">Ajuste de dias</span></td>
              <td>:</td>
              <td align="left"><span class="Estilo24">
                <input name="txt_ajustes" type="text"onkeypress="return acceptNum(event)" value="<?php echo($_POST["txt_ajustes"]) ;?>" size="3" maxlength="3" />
                <?php
function habiles($mes,$anno){
   $habiles = 0; 
   // Consigo el n&uacute;mero de d&iacute;as que tiene el mes mediante "t" en date()
   $dias_mes = date("t", mktime(0, 0, 0, $mes, 1, $anno));
   // Hago un bucle obteniendo cada d&iacute;a en valor n&uacute;merico, si es menor que 
   // 6 (sabado) incremento $habiles
   for($i=1;$i<=$dias_mes;$i++) {
       if (date("N", mktime(0, 0, 0, $mes, $i, $anno))<6) $habiles++;
   }

   return $habiles;
}

echo habiles("11","2006");

$resultado_restas = habiles($registroeq['arrendado_desde'],$fecha);	
	echo "Arrendado hace ".$resultado_restas." dias."; 

?>
                <span class="Estilo20">
                  <?php
		function mensaje()
			{
				echo "<script> alert('Ingrese Numero de Factura');</script>";
			}
	$valor2 = $_POST["OK"];
	$num_factura = $_POST['txt_factura']; 
	$flag_1=0;
	if (!(empty($num_factura))&&($_POST['OK']=='Guardar y Seguir')){
		$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
		$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
		$registroiva = mysql_fetch_array($resiva);
		$valor_iva = $registroiva['valor_iva'];	
		///////
		//devuelto no facturado
		if (($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO")||($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO-CAMBIO")&&($flag_1==0)){		
			//calculo monto reparaciones
			$cod_arriendo=$registroeq['cod_arriendo'];
			
			$sql_rep   = "SELECT SUM(valor_reparacion) as arreglo FROM reparacion_equipos where cod_arriendo = $cod_arriendo and cod_equipo =".$valor1;
			$res      = mysql_query($sql_rep,$link) or die(mysql_error()); 
			$registroarr = mysql_fetch_array($res);
			$monto_reparacion=$registroarr['arreglo'];
			//fin calculo
			$num_factura        = $_POST['txt_factura'];    	       // echo "$num_factura<br>";
			$cod_cliente        = $registroobra['cod_cliente'];      //   echo "$cod_cliente<br>";
			$cod_obra           = $registroobra['cod_obra'];            //echo "$cod_obra<br>";
			$cod_ariendo        = $registroeq['cod_arriendo'];                             // echo "$cod_ariendo<br>";
			
			$fecha_arr			= $_POST['txt_desde'];
			$fecha_temp = explode("-",$fecha_arr);
			$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
			$fecha_arr = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

			$fecha_hasta		= $_POST['txt_hasta'];
			$fecha_temp = explode("-",$fecha_hasta);
			$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
			$fecha_hasta = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

			/* movida a facturar para que todos los equipos tengan la misma fecha de facturacion
			
			*/			$cod_estado_equipo  = $cargo_id2;                          //echo "$cod_estado_equipo<br>";

			//datos detalle factura
			$valor_rep          = $monto_reparacion;               //echo "$valor_rep<br>"; 
			$dias_arr           = $_POST['txt_totdias'];                  //  echo "$dias_arr<br>";
			$tot_arriendo       = $_POST['txt_total'] ; 
			$dias_ajuste        = $_POST['txt_ajustes'];      //echo "$dias_ajuste<br>";
			if (empty($dias_ajuste)){
				$dias_ajuste = 0;
				}
			$hora_devolucion 	= $_POST['txt_hora_dev'];
			if (isset($_POST['txt_hora_dev'])){
				$hora_devolucion = '18:30:00';
				}
				if (empty($num_factura)&&($_POST['OK']=='Guardar y Seguir')){  
					$link=mensaje();
				} else {
					$num_factura        = $_POST['txt_factura'];    	      //  echo "$num_factura<br>";
					$cod_cliente        = $registroobra['cod_cliente'];       //  echo "$cod_cliente<br>";
					$cod_obra           = $registroobra['cod_obra'];          //  echo "$cod_obra<br>";
					$cod_ariendo        = $registroeq['cod_arriendo'];                         //  echo "$cod_ariendo<br>";
					$porcentaje_vu		= $_POST['porcentaje_vu'];
					
					$cod_estado_equipo  = $cargo_id2;                     // echo "$cod_estado_equipo<br>";
					
					//datos detalle factura
					$valor_rep          = $monto_reparacion;         //  echo "$valor_rep<br>";
					if (empty($monto_reparacion)){
						$valor_rep = 0;
						}
					$dias_arr           = $_POST['txt_totdias'];                    //echo "$dias_arr<br>";
					$tot_arriendo       = $_POST['txt_total']; 
					$dias_ajuste        = $_POST['txt_ajustes'];     // echo "$dias_ajuste<br>";
					if (!empty($num_factura)&&($_POST['OK']=='Guardar y Seguir')){
						//ingresar datos de la factura
						$sqlf = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
						$resfetf   = mysql_query($sqlf,$link) or die(mysql_error()); 
						$registrod = mysql_fetch_array($resfetf);
						if (($registrod['estado']=="CERRADA")or($registrod['estado']=="NULA")){
							if ($registrod['estado']=="CERRADA")
								echo "<script> alert (\"Factura no puede ser Modificada. Ingrese Otro Folio.\"); </script>";
								if ($registrod['estado']=="NULA")
									echo "<script> alert (\"Factura se encuentra NULA.\"); </script>";															
							}else{
								if ((empty($registrod['estado']))){
									if (empty($registrod['num_factura'])){
										//insertar factura
										$query ="insert into factura (num_factura,cod_cliente,cod_arriendo,cod_obra,valor_iva,fecha) 
										values ('$num_factura','$cod_cliente','$cod_arriendo','$cod_obra','$valor_iva','$fecha_hasta')";
										mysql_query($query,$link);
										//guardar detalle de factura
										$query="insert into det_factura (num_factura,cod_equipo,dias_arriendo,tot_arriendo,dias_ajuste,otros_reparacion,monto_otros,porcentaje_vu) 
												values ('$num_factura','$valor1','$dias_arr','$tot_arriendo','$dias_ajuste','REPARACION','$valor_rep','$porcentaje_vu')";
										mysql_query($query,$link);
										//$res  = mysql_query($sql) or die(mysql_error());
										//nuevo periodo
										//cambiar estado equipo
										$link=Conectarse();
										$sql = "UPDATE equipos_arriendo 
														SET estado_equipo_arr='DEVUELTO-FACTURADO', 
															hora_devol = '$hora_devolucion',
															nro_factura = '$num_factura'
												where cod_equipo='$valor1' 
													and num_gd='$num_gd'
													and arrendado_desde = '$fecha_arr'
													and estado_equipo_arr not like '%CAMBIO%'";
										$res  = mysql_query($sql,$link) or die(mysql_error());

										$sql_1 = "select *
												from equipos_arriendo 
												where cod_equipo='$valor1' and num_gd='$num_gd'
												limit 0,1";
										$res_1  = mysql_query($sql_1,$link) or die(mysql_error());
										$row_1 	= mysql_fetch_array($res_1);
										$precio	=	0;
										if ($row_1['precio']==0){
											$sqlest = "SELECT det_gd.precio as valor_unidad_arr 
														FROM equipo 
															inner join det_gd
																on det_gd.cod_equipo = equipo.cod_equipo
														where det_gd.cod_equipo='$valor1'
															and det_gd.num_gd = '$num_gd'";
											$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
											$registroest = mysql_fetch_array($resest);
											
											if (empty($registroest['valor_unidad_arr'])){
												$sqlest      = "SELECT cod_estado_equipo, valor_unidad_arr 
																FROM equipo 
																where cod_equipo='$valor1'";
												$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
												$registroest = mysql_fetch_array($resest);
												}
											$precio = 	$registroest['valor_unidad_arr'];
											}
										else{
											$precio = $row_1['precio'];
											}	
										$link=Conectarse();
										$sql = "UPDATE equipos_arriendo 
														SET precio = '$precio'
												where cod_equipo='$valor1' 
													and num_gd='$num_gd'
													and arrendado_desde = '$fecha_arr'";
										$res  = mysql_query($sql,$link) or die(mysql_error());
										mysql_close($link);	
										echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";		
										echo "<script language=Javascript> location.href=\"arriendos_fact.php?arriendos=".$num_gd."\"; </script>";		  
									}else{
										if (!empty($registrod['cod_cliente']) and($registrod['cod_cliente']<>$cod_cliente)) {
											echo "<script> alert (\"N� Factura pertenece a otro cliente.\"); </script>";
										}
										else{
										$link=Conectarse();
										$sql = "UPDATE equipos_arriendo 
														SET estado_equipo_arr='DEVUELTO-FACTURADO', 
															hora_devol = '$hora_devolucion',
															nro_factura = '$num_factura'
												where cod_equipo='$valor1' 
													and num_gd='$num_gd'
													and arrendado_desde = '$fecha_arr'
													and estado_equipo_arr not like '%CAMBIO%'";
										$res  = mysql_query($sql,$link) or die(mysql_error());
										$link=Conectarse();
										
										$sql_1 = "select *
												from equipos_arriendo 
												where cod_equipo='$valor1' and num_gd='$num_gd'
												limit 0,1";
										$res_1  = mysql_query($sql_1,$link) or die(mysql_error());
										$row_1 	= mysql_fetch_array($res_1);
										$precio	=	0;
										if ($row_1['precio']==0){
											$sqlest = "SELECT det_gd.precio as valor_unidad_arr 
														FROM equipo 
															inner join det_gd
																on det_gd.cod_equipo = equipo.cod_equipo
														where det_gd.cod_equipo='$valor1'
															and det_gd.num_gd = '$num_gd'";
											$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
											$registroest = mysql_fetch_array($resest);
											
											if (empty($registroest['valor_unidad_arr'])){
												$sqlest      = "SELECT cod_estado_equipo, valor_unidad_arr 
																FROM equipo 
																where cod_equipo='$valor1'";
												$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
												$registroest = mysql_fetch_array($resest);
												}
											$precio = 	$registroest['valor_unidad_arr'];
											}
										else{
											$precio = $row_1['precio'];
											}	
										$link=Conectarse();
										$sql = "UPDATE equipos_arriendo 
														SET precio = '$precio'
												where cod_equipo='$valor1' 
													and num_gd='$num_gd'
													and arrendado_desde = '$fecha_arr'";
										$res  = mysql_query($sql,$link) or die(mysql_error());
										
										
										
											$query="insert into det_factura (num_factura,cod_equipo,dias_arriendo,tot_arriendo,dias_ajuste,porcentaje_vu) 
													values ('$num_factura','$valor1','$dias_arr','$tot_arriendo','$dias_ajuste','$porcentaje_vu')";
											mysql_query($query,$link);
											mysql_close($link);	
											echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";	
											echo "<script language=Javascript> location.href=\"arriendos_fact.php?arriendos=".$num_gd."\"; </script>";		  
											
}
										}
									}
								}	  
							}
						} 
					}
				}
	 /////// 
	 
	 //NO DEVUELTO FACTURAR
	 if (($registroeq['estado_equipo_arr']=="NO DEVUELTO")&&($flag_1==0)){
				//calculo monto reparaciones
			$cod_arriendo=$registroeq['cod_arriendo'];
			
			//fin calculo
			$num_factura        = $_POST['txt_factura'];    	       // echo "$num_factura<br>";
			$cod_cliente        = $registroobra['cod_cliente'];      //   echo "$cod_cliente<br>";
			$cod_obra           = $registroobra['cod_obra'];            //echo "$cod_obra<br>";
			$cod_arriendo       = $_POST['txt_codarriendo'];                             // echo "$cod_ariendo<br>";
			$porcentaje_vu 		= $_POST['porcentaje_vu'];
			$fecha_arr 			=	"";
			$fecha_corte		=	"";
			if (isset($_POST['txt_desde'])){
				$fecha_arr			= $_POST['txt_desde'];
				$fecha_temp = explode("-",$fecha_arr);
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
				$fecha_arr = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
				}
			if (isset($_POST['txt_hasta'])){
				$fecha_corte		= $_POST['txt_hasta'];
				$fecha_temp = explode("-",$fecha_corte);
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
				$fecha_corte = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
			}
			$hora_corte         = $_POST['txt_hora_dev']; 
			if (isset($_POST['txt_hora_dev'])){
				$hora_corte = '18:30:00';
				}
			$cod_estado_equipo  = $cargo_id2;                          //echo "$cod_estado_equipo<br>";
			//datos detalle factura
			$dias_arr           = $_POST['txt_totdias'];                  //  echo "$dias_arr<br>";
			$tot_arriendo       = $_POST['txt_total']; 
			$dias_ajuste        = $_POST['txt_ajustes'];      //echo "$dias_ajuste<br>";
			
			if (empty($num_factura)&&($_POST['OK']=='Guardar y Seguir')){  
				$link=mensaje();
			} else {
				
				$num_factura        = $_POST['txt_factura'];    	      //  echo "$num_factura<br>";
				$cod_cliente        = $registroobra['cod_cliente'];       //  echo "$cod_cliente<br>";
				$cod_obra           = $registroobra['cod_obra'];          //  echo "$cod_obra<br>";
				$cod_arriendo        = $_GET['codarr'];                           //  echo "$cod_ariendo<br>";
			
				//$hora_corte         = $_POST['txt_hora_dev'];
				$cod_estado_equipo  = $estado_equipo;                     // echo "$cod_estado_equipo<br>";
				
				//datos detalle factura
				$dias_arr           = $_POST['txt_totdias'];                    //echo "$dias_arr<br>";
				$tot_arriendo       = $_POST['txt_total']; 
				
				if (isset($_POST['txt_ajustes'])){
					$dias_ajuste        = $_POST['txt_ajustes'];     // echo "$dias_ajuste<br>";
					}
				else{
					$dias_ajuste=0;
					}
				if (!empty($num_factura)&&($_POST['OK']=='Guardar y Seguir')){
					
				//verificar si existe la factura 
				$sqlfact    = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
				// echo "sqlfact= $sqlfact<br>";
				$resfetfact  = mysql_query($sqlfact,$link) or die(mysql_error()); 
				$registrodet = mysql_fetch_array($resfetfact);
				
				if (($registrodet['estado']=="CERRADA")or($registrodet['estado']=="NULA"))	{
					if ($registrodet['estado']=="CERRADA")
						echo "<script> alert (\"Factura no puede ser Modificada. Ingrese Otro Folio.\"); </script>";
					if ($registrodet['estado']=="NULA")
						echo "<script> alert (\"Factura se encuentra NULA.\"); </script>";															
				}else{
					if ((empty($registrodet['estado'])))   	    {
						 if (empty($registrodet['num_factura'])) {
							$query="insert into factura (num_factura,cod_cliente,cod_arriendo,cod_obra,valor_iva,fecha) 
							values ('$num_factura','$cod_cliente','$cod_arriendo','$cod_obra','$valor_iva','$fecha_corte')";
							mysql_query($query,$link);//}
							//rcb_fecha_corte
							//actualizar equipos arriendo para el periodo facturado
							$sql = "UPDATE equipos_arriendo 
										SET estado_equipo_arr='NO DEVUELTO-FACTURADO', 
											arrendado_hasta='$fecha_corte', 
											hora_devol='$hora_corte',
											nro_factura = '$num_factura'
									where arrendado_hasta = '0000-00-00' 
										and arrendado_desde = '$fecha_arr'
										and cod_equipo='$valor1' 
										and cod_arriendo ='$cod_arriendo' 
										and num_gd='$num_gd'";
							
							$res  = mysql_query($sql,$link) or die(mysql_error());
							//crear un nuevo periodo para facturar en equipo arriendo
							//$fecha_corte = $fecha_corte + 1;
							$fec_emision = $fecha_corte;
							$fecha = explode("-",$fec_emision);
							$can_dias = 1;
							//print(date("d/m/Y H:i:s",mktime(0,0,0,3,(27 + 1),2004))); 
							//$aFecIni[2], $aFecIni[1], $aFecIni[3])
							$dyh = getdate(mktime(0, 0, 0,$fecha[1], $fecha[2]+1, $fecha[0]));
							$fec_emision = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
							// fin rcb
							
							$sql_1 = "select *
									from equipos_arriendo 
									where cod_equipo='$valor1' and num_gd='$num_gd'
									limit 0,1";
							$res_1  = mysql_query($sql_1,$link) or die(mysql_error());
							$row_1 	= mysql_fetch_array($res_1);
							$precio	=	0;
							if ($row_1['precio']==0){
								$sqlest = "SELECT det_gd.precio as valor_unidad_arr 
											FROM equipo 
												inner join det_gd
													on det_gd.cod_equipo = equipo.cod_equipo
											where det_gd.cod_equipo='$valor1'
												and det_gd.num_gd = '$num_gd'";
								$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
								$registroest = mysql_fetch_array($resest);
								
								if (empty($registroest['valor_unidad_arr'])){
									$sqlest      = "SELECT cod_estado_equipo, valor_unidad_arr 
													FROM equipo 
													where cod_equipo='$valor1'";
									$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
									$registroest = mysql_fetch_array($resest);
									}
								$precio = 	$registroest['valor_unidad_arr'];
								}
							else{
								$precio = $row_1['precio'];
								}	
							
							$query="insert into equipos_arriendo(cod_arriendo,cod_equipo,arrendado_desde,hora_arr,estado_equipo_arr,num_gd,nro_factura,precio) 
								values ('$cod_arriendo','$valor1','$fec_emision','08:30:00','NO DEVUELTO','$num_gd','0','$precio')";
							mysql_query($query,$link);
						
						 //guardar detalle de factura
							$query="insert into det_factura (num_factura,cod_equipo,dias_arriendo,tot_arriendo,dias_ajuste,porcentaje_vu) 
									values ('$num_factura','$valor1','$dias_arr','$tot_arriendo','$dias_ajuste','$porcentaje_vu')";
							mysql_query($query,$link);
						
						  	echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";								
							echo "<script language=Javascript> location.href=\"arriendos_fact.php?arriendos=".$num_gd."\"; </script>";		  
}else{
							if (!empty($registrodet['cod_cliente']) and($registrodet['cod_cliente']<>$cod_cliente)) {
								echo "<script> alert (\"N� Factura pertenece a otro cliente.\"); </script>";
							}else{
							$query="insert into det_factura (num_factura,cod_equipo,dias_arriendo,tot_arriendo,dias_ajuste,porcentaje_vu) 
							  			values ('$num_factura','$valor1','$dias_arr','$tot_arriendo','$dias_ajuste','$porcentaje_vu')";
							mysql_query($query,$link);
							$sql = "UPDATE equipos_arriendo 
										SET estado_equipo_arr='NO DEVUELTO-FACTURADO', 
											arrendado_hasta='$fecha_corte', 
											hora_devol='$hora_corte',
											nro_factura = '$num_factura'
									where arrendado_hasta = '0000-00-00'  
										and arrendado_desde = '$fecha_arr'
										and cod_equipo='$valor1' 
										and cod_arriendo ='$cod_arriendo' 
										and num_gd='$num_gd'";
							$res  = mysql_query($sql,$link) or die(mysql_error());
							$fec_emision = $fecha_corte;
							$fecha = explode("-",$fec_emision);
							$can_dias = 1;
							//print(date("d/m/Y H:i:s",mktime(0,0,0,3,(27 + 1),2004))); 
							//$aFecIni[2], $aFecIni[1], $aFecIni[3])
							$dyh = getdate(mktime(0, 0, 0,$fecha[1], $fecha[2]+1, $fecha[0]));
							$fec_emision = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
							// fin rcb
							$sql_1 = "select *
												from equipos_arriendo 
												where cod_equipo='$valor1' and num_gd='$num_gd'
												limit 0,1";
							$res_1  = mysql_query($sql_1,$link) or die(mysql_error());
							$row_1 	= mysql_fetch_array($res_1);
							$precio	=	0;
							if ($row_1['precio']==0){
								$sqlest = "SELECT det_gd.precio as valor_unidad_arr 
											FROM equipo 
												inner join det_gd
													on det_gd.cod_equipo = equipo.cod_equipo
											where det_gd.cod_equipo='$valor1'
												and det_gd.num_gd = '$num_gd'";
								$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
								$registroest = mysql_fetch_array($resest);
								
								if (empty($registroest['valor_unidad_arr'])){
									$sqlest      = "SELECT cod_estado_equipo, valor_unidad_arr 
													FROM equipo 
													where cod_equipo='$valor1'";
									$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
									$registroest = mysql_fetch_array($resest);
									}
								$precio = 	$registroest['valor_unidad_arr'];
								}
							else{
								$precio = $row_1['precio'];
								}	
										
							$query="insert into equipos_arriendo(cod_arriendo,cod_equipo,arrendado_desde,hora_arr,estado_equipo_arr,num_gd,nro_factura,precio) 
								values ('$cod_arriendo','$valor1','$fec_emision','08:30:00','NO DEVUELTO','$num_gd','0','$precio')";
							mysql_query($query,$link);

							echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
							echo "<script language=Javascript> location.href=\"arriendos_fact.php?arriendos=".$num_gd."\"; </script>";		  
						  	}
						}
				   	}
				}
			}
	 	}
	} 	 
	 /////
	?>
                </span></span></td>
              <td align="right" valign="middle" class="Estilo20">Total</td>
              <td align="right" valign="middle"  class="Estilo20">:</td>
              <td align="right" valign="middle"  class="Estilo20"><input name="txt_total" type="text" class="cantidades" value="<?php 
			  if ($_POST['calcular']=='Calcular') {  
				if ($resultado_resta > 0)	  {
					$porcentaje_vu_temp = 0;
					if ($_POST['porcentaje_vu']==0){
						$porcentaje_vu_temp = 100;
						}
					else{
						$porcentaje_vu_temp =$_POST['porcentaje_vu'];
						}
					$valor_calcular = $porcentaje_vu_temp/100;
					$valor_total = 1;
					$porcentaje_desc = $valor_total - $valor_calcular;
					if ($porcentaje_desc ==0){
						$porcentaje_desc = 1;
						}
				  	$res_total_dias=(($resultado_resta - $_POST['txt_ajustes'])*$_POST['txt_valor_dia']+ $registroarr['arreglo'])*($porcentaje_desc);
				  if ($res_total_dias < '0'){
					  	echo(0);
						}
				  else{ 
				  		echo($res_total_dias);
					}
			  }else{
				  echo(0);
			  }	
			  }else{
				  echo $_POST['txt_total'];
				  }
			  ?>" size="10" maxlength="10" readonly="readonly"/></td>
              <td align="right" valign="middle" class="Estilo20">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td><span class="Estilo24">
                <input type="submit" name="calcular" id="calcular" value="Calcular"  style="background-image:url(images/ico_calculadora1.gif); width:40px; height:40px;" title="Calcular dias a cobrar"/>
                </span></td>
              <td>&nbsp;</td>
              <td><span class="Estilo24">
                <input type="submit" id="OK" name="OK" value="Guardar y Seguir" title="Guardar y continuar" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" onclick='var msj = confirm("Confirme numero de factura");
			if (!(msj)){
				alert("Proceso no realizado");
				window.location="arriendos_fact.php";
}' />
                </span></td>
              <td><span class="Estilo24"><a href="arriendos_fact.php" onmouseover="Volver" ><img src="images/volver.png" width="40" height="40" title="Volver Menu Principal" border="0"/></a></span></td>
            </tr>
            <?php 
			echo '<tr>';
				if ($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO"){
					echo '<td><span class="Estilo20">';
					echo("Reparacion Equipo"); 
					echo '</span></td>';
              		echo '<td>'; 
					if ($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO"){ echo(":");} 
					echo '</td><td align="left"><span class="Estilo20">';
			  		if ($registroeq['estado_equipo_arr']=="DEVUELTO-NO FACTURADO"){
		                echo '<input name="txt_reparacion" type="text" value="';
					        $cod_arriendo=$registroeq['cod_arriendo'];
							$sql_rep   = "SELECT SUM(valor_reparacion) as arreglo FROM reparacion_equipos where cod_arriendo = $cod_arriendo and cod_equipo =".$valor1;
							$res      = mysql_query($sql_rep,$link) or die(mysql_error()); 
							$registroarr = mysql_fetch_array($res);
							echo($registroarr['arreglo']);
							$monto_reparacion=$registroarr['arreglo'];
							echo '" size="10" maxlength="10" disabled="disabled"/>';
						}
					}
              echo '</span></td>
            </tr>';
			?>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</div>

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
            <script type="text/javascript">
            Calendar.setup({
              inputField    : "txt_hasta",
              button        : "cal-button-1",
              align         : "Tr"
            });
          </script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/languages/jquery.validationEngine-es.js"></script>
<script>
	function mayor(fecha, fecha2){
		var xMes=fecha.substring(3, 5);
		var xDia=fecha.substring(0, 2);
		var xAnio=fecha.substring(6,10);
		var yMes=fecha2.substring(3, 5);
		var yDia=fecha2.substring(0, 2);
		var yAnio=fecha2.substring(6,10);
		if (xAnio > yAnio){
			return(true);
		}else{
			if (xAnio == yAnio){
				if (xMes > yMes){
					return(true);
				}
				if (xMes == yMes){
					if (xDia > yDia){
						return(true);
					}else{
						return(false);
					}
				}else{
					return(false);
				}
			}else{
				return(false);
			}
		}
	}
	$(document).ready(function() {
		$("#frmDatos").validationEngine('attach');
		$("#txt_factura").bind('blur',function() {
		    var num_gd = $("#txt_factura").val();
		      // $.ajax({
		      //   url:'classes/facturar/buscar-factura.php?num_gd='+num_gd,
		      //   success: function(data){
		      //     if (data=='1'){
		      //       alert("Folio Existente");
		      //       document.getElementById('txt_factura').focus();
		      //       } 
		      //     if (data=='2'){
		      //       alert("Folio fuera de rango");
		      //       document.getElementById('txt_factura').focus();
		      //       }
		      //     if (data=='3'){
		      //       alert("Folio fuera de rango sugerido");
		      //       document.getElementById('txt_factura').focus();
		      //       }
		      //     }
		      // });
		      //location.href="gd.php?num_gd="+num_gd;
		    });
			

		$("#txt_hasta").change(function(){
			var txt_desde = document.getElementById("txt_desde").value;
			var txt_hasta = document.getElementById("txt_hasta").value;
			if (new Date(txt_hasta).getTime() > new Date(txt_desde).getTime()){


			}else{
				if (new Date(txt_hasta).getTime() = new Date(txt_desde).getTime()){
				
				
				
				} 
				else{
					alert("Fecha de cierre no corresponde.");
					document.getElementById("txt_hasta").value = "";					
					}
				}
			});
		});

</script>


</body>

</html>