<?php 
ob_start(); 
session_start(); 
 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
	}
$fecha_factura ="";	
require_once('classes/tc_calendar.php');
function utf8_decode_1($string, $strip_zeroes = false) {
	$pos = 0;
	$len = strlen($string);
	$result = '';
 
	while ($pos < $len) {
		$code1 = ord($string[$pos++]);
		if ($code1 < 0x80) {
			$result .= chr($code1);
		} elseif ($code1 < 0xE0) {
			// Two byte
			$code1 = 0x1F & $code1;
			$code2 = 0x3F & ord($string[$pos++]);
			$res_code1 = $code1 >> 2;
			if ($res_code1 > 0 || $strip_zeroes) {
				$result .= chr($res_code1);
			}
			$result .= chr( ($code1 << 6) | $code2);
		} elseif ($code1 < 0xF0) {
			// Three byte
			$code1 = $code1; // No need to mask
			$code2 = 0x3F & ord($string[$pos++]);
			$code3 = 0x3F & ord($string[$pos++]);
			$res_code1 = chr( ($code1 << 4) | ($code2 >> 2));
			if ($res_code1 > 0 || $strip_zeroes) {
				$result .= chr($res_code1);
			}
			$result .= chr( ($code2 << 6) | $code3);
		}
	}
 
	return $result;
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
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script language="javascript" type="text/javascript">
</script>
<script type="text/javascript" src="script.js"></script>
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
<style type="text/css">
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
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }

</style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); 
    </style>
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
<style type="text/css">
.Estilo241 {color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
</style>
</head>
<body>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php');
	?>
    </div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="95%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="80%" ><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php
			include("classes/conex.php");
			$link=Conectarse();
				$num_factura =  $_POST["txt_factura"];
				if (empty($_POST["txt_factura"])) $num_factura =  $_GET["num_fact"];
				if (!(empty($_GET["nro_factura"]))) $num_factura =  $_GET["nro_factura"];
			
				
				$cod_obra    = $_GET["cod_obra"];


				$cod_arr     = $_GET["codarr"];
				$valor1      = $_GET["equipo"];
			
				if (!empty($num_factura)) {
				
					$link=Conectarse();
					//busca factura
					$sqlfact    = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
				 	
					$res         	= mysql_query($sqlfact,$link) or die(mysql_error()); 
					$registro    	= mysql_fetch_array($res);
					$cod_cliente 	= $registro['cod_cliente'];
					$num_arriendo	= $registro['cod_arriendo'];
					$fecha_factura 	= $registro['fecha'];
					$cod_obra 		= $registro['cod_obra'];

					$sql_obra = "select nombre_obra, direcc_obra from obra where cod_obra = '".$cod_obra."'";
					$reS_obra = mysql_query($sql_obra,$link);
					$row_obra = mysql_fetch_array($reS_obra);

					$nombre_obra = $row_obra['nombre_obra'];
					$direcc_obra = $row_obra['direcc_obra'];

					//buscar cliente
					$sqlcli   = "SELECT * FROM clientes WHERE cod_cliente ='$cod_cliente'";
			
					$rescli       = mysql_query($sqlcli,$link) or die(mysql_error()); 
					$registrocli = mysql_fetch_array($rescli);
					$cliente     = $registrocli['raz_social'];
					
                    //num gd
					$sqlgd   = "SELECT * FROM arriendo WHERE cod_arriendo ='$num_arriendo'";
			
					$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$num_gd     = $registrogd['num_gd'];
					if (empty ($num_gd)) {
						$sqlgd   = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
				
						$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
						$registrogd = mysql_fetch_array($resgd);
						if (empty($registrogd['gd_rep'])){
							$sqlgd   = "SELECT * 
										FROM equipos_arriendo
										WHERE cod_arriendo ='$num_arriendo'";
							$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
							$registrogd = mysql_fetch_array($resgd);
							$num_gd     = $registrogd['num_gd'];
							}
						else{
							$num_gd     = $registrogd['gd_rep'];
							}
					}
				}
		 ?>
            FACTURAR</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><form method="post" enctype="multipart/form-data" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td colspan="5" height="8"><?php //echo "<a href='imp_list_eq.php' target='_blank'>Vista Preliminar</a>"; ?></td>
            </tr>
            <tr>
              <td colspan="5" bgcolor="#06327D"><span class="Estilo24">DATOS FACTURA</span><span class="Estilo24">
                <div align="right">
                  <?php  $fecha = date ("d-m-Y"); echo($fecha);//echo date ( "j - n - Y" );?>
                </div>
              </span></td>
            </tr>
            <tr>
              <td colspan="5"></td>
            </tr>
            <tr>
              <td width="15%">N&deg; Factura</td>
              <td>:</td>
              <td width="33%" valign="middle"><span class="Estilo24">
                <input name="txt_factura" type="text"onkeypress="return acceptNum(event)" value="<?php 
						if (!empty($registro['num_factura'])) {
							$fecha_factura = $registro['fecha'];
							echo ($registro['num_factura']);
							}
						else{
							echo($_POST["txt_factura"]) ;
							}// echo($_POST['txt_factura']);?>" size="10" maxlength="10" />
               <input type="submit" name="buscarfactura" value="Buscar" title="Buscar Factura" style="background-image:url(images/ver.png); width:24px; height:24px;" class="formato_boton" /></span></td>
              <td height="8"  align="right">Fecha Emision
              <input name="fecha_facturacion" type="text" id="fecha_facturacion" value="<?php 
			  			if (!empty($registro['fecha'])) {
							if ($registro['fecha']!='0000-00-00'){
								$fecha_temp = explode("-",$registro['fecha']);
								//año-mes-dia
								//0 -> dia, 1 -> mes, 2 -> año
								$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
								echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
								}
							else{
								echo date("d-m-Y");
								}
							}
						else{
							echo($_POST["fecha_facturacion"]) ;
							}//=$registro['fecha'];?>" size="10" maxlength="10" />
				</td>
              <td width="10%"><input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" width="32" height="32" onclick='var msj = confirm("Confirme fecha de emisión de factura");
                                if (!(msj)){
                                    alert("Proceso no realizado");
                    }' /></td>
            </tr>
            <?php if (!empty($num_factura)) { ?>
            <tr>
              <td><div align="left">Cliente</div></td>
              <td>:</td>
              <td colspan="2"><input name="txt_cliente" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td>:</td>
              <td colspan="2"><input name="txt_giro" type="text" value="<?php if (!empty($registrocli['giro_cliente'])) {echo ($registrocli['giro_cliente']);}else{echo($_GET['txt_giro']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td width="2%">:</td>
              <td colspan="2"><input name="txt_direcc" type="text" value="<?php if (!empty($registrocli['direcc_cliente'])) {echo ($registrocli['direcc_cliente']);}else{echo($_GET['txt_direcc']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td>:</td>
              <td colspan="2" align="left"><input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registrocli['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registrocli['cod_ciudad'];
						  // echo($sql3);
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Comuna</div></td>
              <td>:</td>
              <td colspan="2" align="left"><input name="txt_comuna" type="text" value="<?php
			   if (!empty($registrocli['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registrocli['cod_comuna'];
						  // echo($sql3);
						  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
						  $registrocom = mysql_fetch_array($rescom);
						  echo($registrocom['comuna']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Tel&eacute;fono</div></td>
              <td>:</td>
              <td colspan="2" align="left"><input name="txt_fono" type="text" value="<?php if (!empty($registrocli['fono_cliente'])) {echo ($registrocli['fono_cliente']);}else{echo($_GET['txt_fono']);}?>" size="8" maxlength="8" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Guia despacho </td>
              <td>:</td>
              <td colspan="2" align="left">
              		<input name="txt_numgd2" type="text" value="<?php 
						if (empty($registro['observaciones'])){
							if (!empty($num_gd)){
								echo ($num_gd);
							}
						}else{
							echo $registro['observaciones'];
							}
						?>" size="50" maxlength="50" disabled="disabled" />
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Orden Compra</td>
              <td>:</td>
              <td colspan="2" align="left"><input name="txt_orden_compra" type="text" value="<?php 
			  	if (!empty($registro['oc_rep'])){
					echo $registro['oc_rep'];
					}
			  	else{
					$sql_gd = "select * from gd where num_gd = ".$num_gd;
					$res_gd = mysql_query($sql_gd,$link);
					$row_gd = mysql_fetch_array($res_gd);
					if (!empty($row_gd['orden_compra'])){
						echo $row_gd['orden_compra'];
						}
					else{
						$sql_gd = "select num_oc from arriendo where num_gd = ".$num_gd."";
						$res_gd = mysql_query($sql_gd,$link);
						$row_gd = mysql_fetch_array($res_gd);
						if (!empty($row_gd['num_oc'])){
							echo $row_gd['num_oc'];
							}	
						else{
							echo "Sin Orden Compra";
							}
						}
					}
			  ?>" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Condiciones Venta/Arriendo</div></td>
              <td>:</td>
              <td colspan="2" align="left"><textarea name="txt_condic" cols="50" rows="5" disabled="disabled"><?php 
			  		$sql_num_gd = "select *
									from gd
									where num_gd = ".$num_gd;
					$res_num_gd = mysql_query($sql_num_gd,$link);
					$row_num_gd = mysql_fetch_array($res_num_gd);
			  		if (!empty($row_num_gd['cond_venta'])) {
						if ($row_num_gd['cond_venta']<11){
									$sql_002 = "select forma_pago.forma_pago 
													from forma_pago
												where cod_forma_pago = '".$row_num_gd['cond_venta']."'";
									$res_002 = mysql_query($sql_002,$link);
									$row_002 = mysql_fetch_array($res_002);
									echo $cond_venta = $row_002['forma_pago'];

								}
								else{
									echo utf8_decode(utf8_encode($row_num_gd['cond_venta']));
									}
						}
					else{
						$sql_gd = "select num_gd from arriendo where num_gd = ".$num_gd."";
						$res_gd = mysql_query($sql_gd,$link);
						$row_gd = mysql_fetch_array($res_gd);
						if (!empty($row_gd['num_gd'])){

							$sql_002 = "select forma_pago.forma_pago 
											from arriendo
												inner join forma_pago
													on forma_pago.cod_forma_pago = arriendo.forma_pago
										where num_gd = '".$num_gd."'";
							$res_002 = mysql_query($sql_002,$link);
							$row_002 = mysql_fetch_array($res_002);
							echo $cond_venta = $row_002['forma_pago'];
							}
						else{
					  		$sql_num_gd = "select *
										from factura
										where num_factura = ".$num_factura;
							$res_num_gd = mysql_query($sql_num_gd,$link);
							$row_num_gd = mysql_fetch_array($res_num_gd);
							if (!empty($row_num_gd['cond_venta'])) {
								if ($row_num_gd['cond_venta']<11){
									$sql_002 = "select forma_pago.forma_pago 
													from forma_pago
												where cod_forma_pago = '".$row_num_gd['cond_venta']."'";
									$res_002 = mysql_query($sql_002,$link);
									$row_002 = mysql_fetch_array($res_002);
									echo $cond_venta = $row_002['forma_pago'];

								}
								else{
									echo utf8_decode(utf8_encode($row_num_gd['cond_venta']));
									}
								}
							else{
							echo($_POST["txt_condicenv"]) ;
							}
						}
					} 
					?></textarea></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td align="right">
                <?php if ($registro['estado']=='NULA'){
				  echo "<h3>Factura ".$registro['estado']."</h3>";
				  }?>
				</td>
              <td align="right" valign="middle"></input>
                <?php if ($registro['estado']!='NULA'){ ?>
                <a href="facturar.php" class="menulink">
	                <img src="images/clean.png" width="48" height="48" title="Limpiar"/>             
                </a>
				<?php if (!empty($registrocli['raz_social'])){ ?> 
                    <a id="cerrar-factura" href="#" download title="Descargar Factura">
	                    <img border=0 width="48" src="images/gest_fin/factura.png" />
                    </a>
                    <a id="vista-previa-factura" href="#" title="Ver Factura">
	                    <img border=0 src="images/impresora.gif" />
                    </a>
                <?php } }?>
               </td>
              <td align="right">&nbsp;</td>
            </tr>
          </table>
        </form>
        </td>
      </tr>
    </table>
      <table width="100%" border="0" align="center">
        <tr>
          <td><table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="10%" bgcolor="#06327D"><span class="Estilo17">Cantidad</span></th>
              <th width="40%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Detalle</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Valor Unitario</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Total Neto</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Descuento</span></th>
              <th width="20%" bgcolor="#06327D" class="CONT">
                <span class="Estilo17 Estilo13 Estilo15">Total</span></th>
            </tr>
            <?php
			$sql="SELECT * 
					FROM det_factura 
					where det_factura.num_factura = '$num_factura'";
			$res = mysql_query($sql) or die(mysql_error()); 
			
			while ($registro = mysql_fetch_array($res)) {
				$dias_arriendo = $registro['dias_arriendo'];
				$dias_ajuste = $registro['dias_ajuste'];
				$valor_unitario = $registro['valor_unitario'];
				$total_rep = $registro['total_rep'];
				$monto_otros = $registro['monto_otros'];
				$cod_repuesto = $registro['cod_repuesto'];
				$cod_equipo = $registro['cod_equipo'];
				$porcentaje_vu = $registro['porcentaje_vu'];
			
		?>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
			<?php if (($registro['cod_equipo']==0)) {?>            
            <td align="left"  bgcolor="#FFFFFF"><?php 
				echo($registro['cantidad']);?>
           	</td>
            <td align="left"  bgcolor="#FFFFFF"><?php 
				if ($registro['otros_reparacion']!='')
					echo utf8_decode($registro['otros_reparacion']);
				else
					echo utf8_decode($registro['observaciones']); 
			 ?></td>
            <td align="right"  bgcolor="#FFFFFF"><?php 
				if (!empty($registro['valor_unitario']))
	   			  	echo "$".number_format($registro['valor_unitario'], 0, ",", ".");
				else
				 	echo "$".number_format($registro['precio'], 0, ",", ".");
			  ?>
           	</td>
            <td align="right"  bgcolor="#FFFFFF">
				<?php 
					if (!empty($registro['cod_equipo'])){
						echo "$".number_format($valor, 0, ",", ".") ; 
					}else{ 
						if (!empty($registro['total_rep'])){
							echo("$".number_format($registro['total_rep'], 0, ",", ".")); 
							}
						else{
							echo("$".number_format($registro['precio'], 0, ",", ".")); 
							}
					} 
				?></td>
            <td  bgcolor="#FFFFFF"></td>
            <td align="right"  bgcolor="#FFFFFF">
				<?php 
					if (!empty($registro['cod_equipo'])){
						echo "$".number_format($valor, 0, ",", ".") ; 
						$costo_tot= $costo_tot + $valor; 
					}else{ 
						if (!empty($registro['total_rep'])){
							echo("$".number_format($registro['total_rep'], 0, ",", ".")); 
							$costo_tot= $costo_tot + ($registro['total_rep']);
							}
						else{
							echo("$".number_format($registro['precio'], 0, ",", ".")); 
							$costo_tot= $costo_tot + ($registro['precio']);
							}
					} 
				?></td>
			<?php } else {?>            
              <td width="10%" bgcolor="#FFFFFF"><?php echo "Dias arriendo : ".$dias_arriendo."<br/>Dias ajuste : ".$dias_ajuste; ?> </td>
              <td width="40%" bgcolor="#FFFFFF">Día(s) de arriendo con contrato nro <?php 
				echo $num_gd.' ';	  
			  if (!empty($cod_repuesto[$contador-1])) {
				  $sqlnomrep="SELECT cod_repuesto, nombre_repuesto FROM repuesto where cod_repuesto =".$cod_repuesto;
				  $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
				  $registronrep = mysql_fetch_array($resnomrep);
				  echo($registronrep['nombre_repuesto']);
	
			  }else{
				  //BUSCAR FECHA DE ARRIENDO
					$sqlperiodo=" SELECT *
									FROM equipos_arriendo
										inner join gd
											on equipos_arriendo.cod_arriendo = gd.id_arriendo
										inner join factura 
											on factura.cod_arriendo = equipos_arriendo.cod_arriendo
										where equipos_arriendo.nro_factura = '".$num_factura."'
											and equipos_arriendo.cod_equipo =".$cod_equipo." 
										order by equipos_arriendo.arrendado_hasta asc
									limit 0,1";
					$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				  	$registroper_row = mysql_num_rows($resperiodo);
					  if ($registroper_row==0){
						  $sqlperiodo=" SELECT *
										FROM equipos_arriendo
											inner join factura 
												on factura.cod_arriendo = equipos_arriendo.cod_arriendo
											where equipos_arriendo.cod_arriendo =".$num_arriendo." 
												and equipos_arriendo.cod_equipo =".$cod_equipo." 
												and equipos_arriendo.num_gd = ".$num_gd."
												and factura.num_factura = '".$num_factura."'
												and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
												and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
											order by equipos_arriendo.arrendado_hasta asc
										limit 0,1";
						  $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					  }
				$registroper = mysql_fetch_array($resperiodo); 
					  if (!empty($registroper['arrendado_hasta'])){ 
							$hasta = $registroper['arrendado_hasta']; 
						  }
					  else{ 
							$hasta = "NO DEVUELTO";
						  }
					  $sqlnomob="SELECT cod_equipo, nombre_equipo,valor_unidad_arr 
								FROM equipo where cod_equipo =".$cod_equipo;
					  $resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
					  $registronob = mysql_fetch_array($resnomob);
					  //echo($registronob['nombre_equipo']." "."PERIODO ".$registroper['arrendado_desde']."-".$hasta." "."ARRENDADO"." ".$registro['dias_arriendo']." "."DIAS"." "."AJUSTE"." ".$registro['dias_ajuste']." "."DIAS"." "."TOTAL"." ".($registro['dias_arriendo']-$registro['dias_ajuste'])." "."DIAS");
						
						$fecha_temp = explode("-",$registroper['arrendado_desde']);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						$fecha_factura_temp = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
	
						$fecha_temp = explode("-",$hasta);
						//año-mes-dia
						//0 -> dia, 1 -> mes, 2 -> año
						$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
						$hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
	
					  
					  echo(htmlentities($registronob['nombre_equipo'])." "." PERIODO: ".$fecha_factura_temp." --> ".$hasta);
					 }
			 ?>
			  </td>
              <td width="13%" align="right" bgcolor="#FFFFFF"><?php  
			  if (!empty($cod_equipo)){
			 		$valor_u = $registro['tot_arriendo']/$dias_arriendo;
				  	echo "$".number_format($valor_u, 0, ",", "."); 
					$valor=(($dias_arriendo)*($valor_u));
			  }else{
				  echo "$".number_format($valor_unitario, 0, ",", ".");
			  }?></td>
              <td width="13%" align="right" bgcolor="#FFFFFF"><?php if (!empty($cod_equipo)){
						echo "$".number_format($valor, 0, ",", ".") ; 
						
						}
					else{ 
						echo("$".number_format($total_rep, 0, ",", ".")/*($registro['total_rep'])*/); 
						$costo_tot= $costo_tot + $total_rep;}
				?>
                <br /></td>
              <td width="13%" align="right" bgcolor="#FFFFFF">
			  	<?php 
				
				
				$porcentaje_emitir = ($registro['porcentaje_vu']);
				
				if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
					echo "0%";
					}
				else{
					echo $porcentaje_emitir."%";
					}
				?>
              </td>
              <td width="20%" align="right" bgcolor="#FFFFFF"><?php 
			if (!empty($cod_equipo)){
                  $valor_def = $registro['tot_arriendo'];
                  $costo_tot= $costo_tot + $valor_def; 
                  echo "$".number_format($registro['tot_arriendo'], 0, ",", ".");
						
						}
					else{ 
                  $valor_def = $registro['total_rep'];
                  $costo_tot= $costo_tot + $valor_def; 
                  echo "$".number_format($registro['total_rep'], 0, ",", ".");
						}
			?></td>
            </tr>
            <tr>
              <td width="10%" height="20" bordercolor="#FFFFFF" class="CONT"><?php if ($monto_otros>0) { echo(1);}?></td>
              <td width="40%" class="CONT"><?php if ($monto_otros>0) { echo ("REPARACION");} ?></td>
              <td width="13%" align="right" class="CONT"><?php if ($monto_otros>0) echo "$".number_format($monto_otros, 0, ",", ".") ; ?></td>
              <td width="13%" align="right" class="CONT"><?php if ($monto_otros>0) echo "$".number_format($monto_otros, 0, ",", ".") ; $costo_tot= $costo_tot + $monto_otros; ?></td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="20%" align="right" class="CONT">&nbsp;</td>
            </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">---------</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">---------------------------------------------------------------------------</td>
              <td width="13%" class="CONT">--------------</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="20%" class="CONT">--------------------</td>
			</tr>
             <?php
			}
			}
				mysql_free_result($res);
				mysql_close($link);
		 ?>
		 	<tr>
		 		<td colspan="6">
		 			Nombre Obra : <?php echo $nombre_obra ?>
				<br>
				Direccion Obra : <?php echo $direcc_obra ?>
		 		</td>
		 	</tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="20%" align="right" class="CONT"><?php
				echo ("NETO: $".number_format($costo_tot, 0, ",", "."));
		 ?>
                <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
              </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="20%" align="right"><span class="CONT">
                <?php
				if (empty($val_iva)){
					$link=Conectarse();
					$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
					$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
					$registroiva = mysql_fetch_array($resiva);
					$valor_iva = $registroiva['valor_iva'];
				}else{
					$valor_iva = $val_iva;
				}
				$iva = $costo_tot * ($valor_iva/100);
				echo ("IVA : $".number_format($iva, 0, ",", "."));
		 ?>
                <input type="hidden" name="txt_iva"  value="<?php echo $iva?>" size="20" maxlength="30" />
              </span></td>
              </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="20%" align="right"><span class="CONT">
                <?php
				$total = $costo_tot + $iva;
				echo ("TOTAL : $".number_format($total, 0, ",", "."));
		 ?>
                <input type="hidden" name="txt_iva2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
              </span></td>
            </tr>
            </table></td>
        </tr>
      </table>
      <table width="80%" border="0" align="center">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
     </td>
  </tr>
  <?php }?>
</table>
<p>
  <script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
       </script>
  <?php
		function mensaje()
			{
				echo "<script>
				alert('Ingrese Numero de Factura y Fecha de Emision');
				</script>";
			}

	  $valor2 = $_POST["OK"];
      $fecha  = $_POST['fecha_facturacion'];              // echo "$fecha<br>";

	  if (isset($_POST['fecha_facturacion'])){
		 //  echo("entra");
		    //datos factura
				$num_factura        = $_POST['txt_factura'];    	               // echo "$num_factura<br>";
				$fecha              = $_POST['fecha_facturacion'];              // echo "$fecha<br>";
			if (empty($num_factura)or(empty($fecha))){  
				$link=mensaje();
			} else {
				//	echo "si entra graba";
				$num_factura        = $_POST['txt_factura'];    	               // echo "$num_factura<br>";
				$fecha              = $_POST['fecha_facturacion'];              // echo "$fecha<br>";
				$link=Conectarse();
				
				$fecha_temp = explode("-",$fecha);
				//dia-mes-año
				//0 -> dia, 1 -> mes, 2 -> año
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
				$fecha =  $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
				//verificar estado de la factura
				$sqlestado   = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
				//echo "sqlfact= $sqlfact<br>";
				$resestado   = mysql_query($sqlestado,$link) or die(mysql_error()); 
				$registroest = mysql_fetch_array($resestado);
				if (($registroest['estado']=="CERRADA")or($registroest['estado']=="NULA"))
				{
					if ($registroest['estado']=="CERRADA")echo "<script> alert (\"Factura no puede ser Modificada.\"); </script>";
					if ($registroest['estado']=="NULA")echo "<script> alert (\"Factura se encuentra NULA.\"); </script>";															
				}else{
					//actualizar datos de la factura
					$sql = "UPDATE factura SET fecha='$fecha' where num_factura='$num_factura'";
					$res  = mysql_query($sql) or die(mysql_error());
					echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
					echo "<script language=Javascript> location.href=\"facturar.php?num_fact=".$num_factura."\"; </script>";	
				}
			}
		 } 
		?>
	<script src="js/jquery-1.6.2.min.js"></script>
    <script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script>
		$(document).ready(function(){
			$("#vista-previa-factura").fancybox({
				'width'    		: '100%',
				'height'   		: '100%',
				'autoScale'		: false,
				'transitionIn'  : 'none',
				'transitionOut' : 'none',
				'type'    		: 'iframe',
				'title'			: this.title
				});
			});
		$(window).load(function() {
				$("#vista-previa-factura").attr('href','classes/descarga.php?ruta=c:/XML/PDF/33_<?php echo $num_factura?>.pdf');
				$("#vista-previa-factura").attr('title','Ver Factura nro : <?php echo $num_factura?>');
				$("#cerrar-factura").attr('href','classes/facturar/cerrar-factura.php?num_fact=<?php echo $num_factura?>&fecha_factura=<?php echo $_POST['fecha_facturacion']?>');
				$("#cerrar-factura").attr('title','Descargar Factura nro : <?php echo $num_factura?>');
			});
		var a = document.getElementById('cerrar-factura'); //or grab it by tagname etc
		a.href = "classes/facturar/cerrar-factura.php?num_fact=<?php echo $num_factura?>&fecha_factura=<?php echo $_POST['fecha_facturacion']?>";
	</script>
</body>
</html>
<?php 
ob_flush();
?>