<?php ob_start(); 
session_start(); 
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
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-weight: bold}
.Estilo22 {font-weight: bold}
.Estilo24 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
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
       <span class="Estilo24">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
</table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="90%" height="427" border="0" align="center">
    <tr>
      <td width="49%" height="31"></td>
      <td width="51%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13">	
			<?php
  	    {
			include("classes/conex.php");
			$link=Conectarse();

	    }

			 ?>
            <?php
					$gd = $_POST['txt_gd'];
					if (empty($_POST["txt_gd"])) $gd =  $_GET["num_gd"];
					$link=Conectarse();

					$sqlgd = "SELECT * FROM gd WHERE num_gd ='$gd'";						
					// echo "sqlfact= $sqlfact<br>";
					$resgd = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$gd=$registrogd['num_gd'];
					$cod_cli=$registrogd['cod_cliente'];
					//echo($registrofact['num_gd']);
					$sqlcliente = "SELECT * FROM clientes WHERE cod_cliente ='$cod_cli'";
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($rescliente);
					if (empty($registrogd['num_gd'])and($_POST['buscar']=='Buscar')) echo "<script>alert('Guia de Despacho No Ingresada');</script>";
			?>
ELIMINAR GUIA DE DESPACHO </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS GUIA DESPACHO
            <div align="right">
          <?php  $fecha = date ("d-m-Y"); echo($fecha);?>
        </div></span>
      </div></td>
    </tr>
    <tr>
      <td height="372" colspan="2" valign="top"><form action="eliminar_gd.php" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td height="8" colspan="2"><input type="hidden" name="txt_numgd" size="20" maxlength="30" value="<?php echo($registrogd['num_gd']);?>" />
                N&deg; Guia de Despacho<span class="Estilo24">
                  <input name="txt_gd" id="txt_gd" type="text" value="<?php if (!empty($registrogd['num_gd'])) {echo ($registrogd['num_gd']);}else{echo($_POST["txt_gd"]) ;}?>" size="10" maxlength="10" />
                  
                  <input type="submit" name="buscar" value="Buscar" title="Buscar Guía Despacho" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
                  
                  <!--<input type="image" name="buscar" value="Buscar" title="Buscar Gu�a Despacho" class="searchbutton" src="images/ver.png"/>-->
              </span></td>
              <td height="8" colspan="3"  align="right">Fecha Emision<input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registrogd['fecha'])) {echo ($registrogd['fecha']);}else{echo($_POST["cal-field-1"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td width="10%"><div align="left">Rut</div></td>
              <td width="59%"><input name="txt_rut" type="text" id="rut" value="<?php if (!empty($registro['rut_cliente'])) 
			{echo ($registro['rut_cliente']);}else{echo($_POST["txt_rut"]) ;} ?>" size="12" maxlength="12" disabled="disabled"/>
                <span class="Estilo20">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </span></td>
              <td width="15%">&nbsp;</td>
              <td width="9%" height="8"  align="right">&nbsp;</td>
              <td width="7%" height="8">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td colspan="3"><input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td><input  name="txt_codcli" type="hidden" value="<?php if (!empty($registrofact['cod_cliente'])) {echo ($registrofact['cod_cliente']);}else{echo($_POST["txt_codcli"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td colspan="3"><input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td colspan="3
              "><input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td colspan="3" align="left"><input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registro['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
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
              <td colspan="3" align="left"><input name="txt_comuna" type="text" value="<?php
			   if (!empty($registro['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
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
              <td colspan="3"><input name="txt_cod_area" type="text" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled" 
            />
                <input name="txt_fono" type="text" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"
            /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Tipo</div></td>
              <td align="left" valign="middle"><textarea name="txt_tipo" cols="63" rows="4" disabled="disabled"><?php if (!empty($registrogd['tipo'])) {echo ($registrogd['tipo']);}else{echo($_POST["txt_tipo"]) ;}?></textarea></td>
              <td colspan="3" align="right" valign="middle">
                <input type="submit" name="borrar" id="borrar" value="Borrar" title="Eliminar Guia Despacho" onclick="return confirm('Desea eliminar?');" style="background-image:url(images/anular_fact.png); width:48px; height:48px;" class="formato_boton" align="right" />
				<a href="eliminar_gd.php" title="Limpiar">
                	<img src="images/clean.png" width="48" height="48" align="middle" border="0"/>
                	<input type="hidden" name="txt_cod2" size="20" maxlength="30" />
                	<input type="hidden" name="txt_equipo" size="25" maxlength="25" />
                </a>                
            
                </td>
            </tr>
            <tr class="sortable">
              <th></th>
              <th><?php if ($registrogd['estado']=='NULA'){
				  echo "<h3>Guia de Despacho ".$registrogd['estado']."</h3>";
				  }?></th>
              <th></th>
              <th></th>
              <th align="right"></th>
            </tr>
            <tr class="sortable">
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Detalle</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Valor Unitario</div></th>
              <th colspan="2" align="right" bgcolor="#06327D"><div align="center" class="Estilo17">Total</div></th>
            </tr>
            <?php
			if (!empty($gd)){
			$sqldet="	SELECT 	distinct det_gd.num_gd, det_gd.cod_equipo, det_gd.cantidad, 
								det_gd.porcentaje_vu, det_gd.precio, det_gd.observaciones, 
								det_gd.accesorio
						FROM  det_gd 
							inner join gd
								on det_gd.num_gd = gd.num_gd
						where gd.num_gd = ".$gd." 
						order by gd.id_arriendo, det_gd.fila_num_gd ASC";
			
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
            <tr bordercolor="#FFFFFF" class="sortable">
              <td align="left"><?php echo($registrodet['cantidad']); ?></td>
              <td align="left"><?php 
					$sqlnomrep="SELECT nombre_equipo, accesorios, cod_motor FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
					$resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
					$registronrep = mysql_fetch_array($resnomrep);
					$detalle="";
					if ($registrodet['observaciones']==''){
						$detalle .= 'ARRIENDO DE ';
						}
					else{
						$detalle .= $registrodet['observaciones']." ";
						}
					$detalle .= (utf8_decode($registronrep['nombre_equipo']));
					if($registronrep['cod_motor'] > 1){
						$detalle .= ' , C/MOTOR N. '.$registronrep['cod_motor'];
						}
					//incluye accesorio
					if($registrodet['accesorio'] == 1){
						$detalle .= ' , '.$registronrep['accesorios'];
						}
					echo (utf8_decode($detalle));
			 ?>
             </td>
              <td align="right"><?php echo("$ ".number_format($registrodet['precio'], 0, ",", ".")) ;?></td>
              <td colspan="2" align="right"><?php echo("$ ".number_format(($registrodet['precio'] * $registrodet['cantidad']), 0, ",", "."));  $costo_tot = $costo_tot + (($registrodet['precio'])*($registrodet['cantidad']));  ?></td>
            </tr>
            <?php } 
			
			?>
            <tr class="sortable">
              <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <?php
				mysql_free_result($resdet);
				mysql_close($link); 
		 ?>
              <td class="CONT">&nbsp;</td>
              <td align="right" class="CONT">&nbsp;</td>
              <td colspan="2" align="right" class="CONT"><?php echo ("NETO: $".number_format($costo_tot, 0, ",", "."));?>
              <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
            </tr>
            <tr>
              <td height="8"></td>
              <td height="8"></td>
              <td height="8" align="right">&nbsp;</td>
              <td height="8" colspan="2" align="right"><span class="CONT">
                <?php $iva = $costo_tot * 0.19;	echo ("IVA : $".number_format($iva, 0, ",", ".")); ?>
                <input type="hidden" name="txt_iva"  value="<?php echo $iva?>" size="20" maxlength="30" />
              </span></td>
            </tr>
            <tr>
              <td height="8"></td>
              <td height="8"></td>
              <td height="8" align="right">&nbsp;</td>
              <td height="8" colspan="2" align="right"><span class="CONT">
                <?php $total = $costo_tot + $iva; echo ("TOTAL : $".number_format($total, 0, ",", "."));?>
                <input type="hidden" name="txt_iva2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
              </span></td>
            </tr>
           <?php } ?>
          </table>
      </form></td>
    </tr>
  </table>
	<?php
	function mensaje() {
			echo "<script> alert('Ingrese Numero Guia de Despacho');</script>";
			echo "<script language=Javascript> location.href=\"eliminar_gd.php\"; </script>";
		}

    $valor2 = $_POST["OK"];
	if ($_POST['borrar']=='Borrar'){
			//  echo("entra");
		    //datos factura
			$num_gd        = $_POST['txt_gd'];    	               // echo "$num_gd<br>";				
			
			if (empty($num_gd)){  
				$link=mensaje();
			} else {
				//	echo "si entra graba";
				$num_gd        = $_POST['txt_gd'];    	               // echo "$num_gd<br>";
				$fecha              = $_POST['cal-field-1'];              // echo "$fecha<br>";
				$link=Conectarse();
				
				//verificar estado de la factura
				$sqlanular   = "SELECT * FROM gd WHERE num_gd ='$num_gd'";
				//echo "sqlfact= $sqlfact<br>";
				$resanular   = mysql_query($sqlanular,$link) or die(mysql_error()); 
				$registronula= mysql_fetch_array($resanular);
				if (empty($registronula['num_gd']))
				{
					echo "<script> alert (\"Guia de Despacho no encontrada.\"); </script>";
				}else{
					//buscar factura
					$sql_verificacion ="select nro_factura	 
										from equipos_arriendo
										where num_gd ='$num_gd'
											and nro_factura <> 0
										union 
										select num_factura
										from factura
										where gd_rep = '$num_gd'";
					$res_ver = mysql_query($sql_verificacion) or die(mysql_error());
					$row_ver = 0;	
					//echo "<br />";
					$row_ver = mysql_num_rows($res_ver);
					//echo "<br />";
					//buscar cambio
					$sql_verificacion ="select *	 
										from equipos_arriendo
										where num_gd ='$num_gd'
											and estado_equipo_arr like '%CAMBIO'";
					$res_ver = mysql_query($sql_verificacion) or die(mysql_error());
					$row_ver_001 = 0;
					//echo "<br />";
					$row_ver_001 = mysql_num_rows($res_ver);
					//echo "<br />";
					//buscar gd de cambio
					$sql_verificacion ="select *	 
										from gd
										where num_gd ='$num_gd'
											and tipo like 'DEVOL EQUIPO'";
					$res_ver = mysql_query($sql_verificacion) or die(mysql_error());
					$row_ver_002 = 0;
					//echo "<br />";
					$row_ver_002 = mysql_num_rows($res_ver);
					//echo "<br />";

					if ($row_ver==0){
						if (($row_ver_001>0)&&($row_ver_002==0)){
							
							$sql_001 = "select cod_reclamo
											from equipos_arriendo
											where num_gd = ".$num_gd."
											order by cod_reclamo desc";
							$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
							$row_001 = mysql_fetch_array($res_001);
							$cod_reclamo = $row_001['cod_reclamo'];
							
							$sql_001 = "select  num_gd_salida
											from reclamo
											where cod_reclamo = ".$cod_reclamo."
											order by cod_reclamo desc";
							$res_001 = mysql_query($sql_001,$link) or die(mysql_error());

							$temp = "";
							
							$row_001 = mysql_fetch_array($res_001);
							$temp .= $row_001['num_gd_salida'];

							echo "<script> alert (\"Guía tiene cambios. (".$temp."). El proceso de eliminación no se realizará\"); </script>";
							/*echo "<script> alert ('Guias Nro. ".$temp." '); </script>";*/
							echo "<script language=Javascript> location.href=\"eliminar_gd.php\"; </script>";	
							}
						elseif (($row_ver_002==0)){
							//actualizar estado de equipo
							$sql_001 ="select distinct cod_equipo 
										from equipos_arriendo
										where num_gd ='$num_gd'";
							$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
							while ($row_001 = mysql_fetch_array($res_001)){
								$sql_est_equi = " select cod_estado_equipo
														from equipo
														where cod_equipo = ".$row_001['cod_equipo'];
								$res_est_equi = mysql_query($sql_est_equi,$link) or die(mysql_error());
								$row_003 = mysql_fetch_array($res_est_equi);
								
								if ($row_003['cod_estado_equipo']==3){
									$sql_005 ="select arrendado_hasta, hora_devol
												from equipos_arriendo
												where num_gd = '$num_gd'
													and cod_equipo = '".$row_001['cod_equipo']."'
												order by arrendado_hasta desc, hora_devol desc
												limit 0,1";
									$res_005 = mysql_query($sql_005,$link) or die(mysql_error());
									$row_005 = mysql_fetch_array($res_005);
									
									$arrendado_hasta = $row_005['arrendado_hasta'];
									$hora_devol = $row_005['hora_devol'];
									$row_num_005 = 0;
									if (($arrendado_hasta!='0000-00-00')&&($hora_devol!='00:00:00')){
										$sql_006 ="select distinct num_gd
													from equipos_arriendo
													where arrendado_hasta > '".$arrendado_hasta."'
														and hora_devol > '".$hora_devol."'
														and cod_equipo = '".$row_001['cod_equipo']."'";
										$res_005 = mysql_query($sql_005,$link) or die(mysql_error());
										$row_num_005 = mysql_num_rows($res_005);
										}
									if ($row_num_005 > 0){
										$sql_006 = " select nombre_equipo
														from equipo
														where cod_equipo = ".$row_001['cod_equipo'];
										$res_006 = mysql_query($sql_006,$link) or die(mysql_error());
										$row_006 = mysql_fetch_array($res_006);
										echo "<script> alert (\"Equipo : ".$row_006['nombre_equipo']." ha sido arrendado.\"); </script>";
										}	
									else{
										$sql_1  = "UPDATE equipo
												SET cod_estado_equipo = '1' 
											 where cod_equipo = '".$row_001['cod_equipo']."'";
										$res_1  = mysql_query($sql_1) or die(mysql_error());
										}
									}else{
										$sql_006 = " select nombre_equipo
														from equipo
														where cod_equipo = ".$row_001['cod_equipo'];
										$res_006 = mysql_query($sql_006,$link) or die(mysql_error());
										$row_006 = mysql_fetch_array($res_006);
										echo "<script> alert (\"Equipo : ".$row_006['nombre_equipo']." con estado diferente a ARRENDADO.\"); </script>";
										}
								}
							$sql_2  = "delete from equipos_arriendo
										where num_gd ='$num_gd'";
							$res_2  = mysql_query($sql_2) or die(mysql_error());
							
							//borrar arriendo
							$sql_5  = " delete
										from arriendo
										where num_gd='$num_gd'";
							$res_5  = mysql_query($sql_5) or die(mysql_error());
							
							//borrar det_gd
							$sql_3  = " delete	
										from det_gd
										where num_gd='$num_gd'";
							$res_3  = mysql_query($sql_3) or die(mysql_error());
						
							//borrar gd
							$sql_4  = " delete
										from gd
										where num_gd='$num_gd'";
							$res_4  = mysql_query($sql_4) or die(mysql_error());
							echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
							echo "<script language=Javascript> location.href=\"menu.php\"; </script>";	
							}
						if ($row_ver_002>0){
							echo "<script> alert (\"Guía de Cambio.\"); </script>";
							echo "<script> alert(\"Revisando si existen facturas asociadas...\")</script>";
							$sql_001 = "select cod_reclamo, cod_equipo_dev ,cod_equipo_entreg 	
											from reclamo
											where num_gd_salida	 = ".$num_gd."
											order by cod_reclamo desc";
							$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
							$row_001 = mysql_fetch_array($res_001);
							$cod_reclamo = $row_001['cod_reclamo'];
							$cod_equipo_dev = $row_001['cod_equipo_dev']; 	
							$cod_equipo_entreg = $row_001['cod_equipo_entreg'];
							echo $sql_ver_gd_fact = " select num_gd, arrendado_desde
															from equipos_arriendo 
															where cod_reclamo = ".$cod_reclamo;
							$res_ver_gd_fact = mysql_query($sql_ver_gd_fact,$link) or die(mysql_error());
							$row_ver_gd_fat = mysql_num_rows($res_ver_gd_fact);
							$row_002 = mysql_fetch_array($res_ver_gd_fact);
							$num_gd_002 = $row_002['num_gd'];
							$arrendado_desde = $row_002['arrendado_desde'];
							$nro_factura = 0;
							$flag_1=0;

							echo $sql_ver_gd_fact_1 = " select nro_factura
													from equipos_arriendo 
													where (num_gd = ".$num_gd_002."
														and nro_factura <> 0
														and arrendado_desde < ".$arrendado_desde.")";
							$res_ver_gd_fact_1 = mysql_query($sql_ver_gd_fact_1,$link) or die(mysql_error());
							$row_ver_gd_fat_1 = mysql_num_rows($res_ver_gd_fact_1);
							$row_002_1 = mysql_fetch_array($res_ver_gd_fact_1);
							$nro_factura = $row_002_1['nro_factura'];

							if ($nro_factura==0){
								echo "<script> alert(\"Guia de Cambio sin Facturas.\")</script>";
								$flag_1 = 0;
								}
							else{
								$flag_1 = 1;
								echo "<script> alert(\"Guia de Cambio con Facturas.\")</script>";
								$temp ="";
								$sql_verificacion ="select nro_factura	 
													from equipos_arriendo
													where (num_gd = ".$num_gd_002."
															and nro_factura <> 0
															and arrendado_desde = ".$arrendado_desde.")
															or (num_gd = ".$num_gd_002."
															and nro_factura <> 0
															and arrendado_desde > ".$arrendado_desde.")";								
								$res_ver = mysql_query($sql_verificacion,$link) or die(mysql_error());
								while ($row_ver = mysql_fetch_array($res_ver)){
									$temp .= $row_ver['nro_factura'].", ";
									}
								echo "<script> alert(\"Factura Nro. ".$temp."\")</script>";
								echo "<script> alert(\"No se procede.\")</script>";
								echo "<script language=Javascript> location.href=\"eliminar_gd.php\"; </script>";	
								}
							//echo "<br />";
							if (($row_ver_gd_fat>0)&&($flag_1==0)){
								echo "<script> alert(\"Revisando si se arrendó el equipo devuelto...\")</script>";
								$sql_est_equi = " select cod_estado_equipo
														from equipo
														where cod_equipo = ".$cod_equipo_dev;
								$res_est_equi = mysql_query($sql_est_equi,$link) or die(mysql_error());
								$row_est_equi = mysql_num_rows($res_est_equi);
								$row_003 = mysql_fetch_array($res_est_equi);
								if ($row_003['cod_estado_equipo']=='3'){
									echo "<script> alert(\"Equipo devuelto arrendado. No se puede eliminar la guia de cambio.\")</script>";
									}
								else{
									/*echo "<script> alert(\"Equipo devuelto no asignado.\")</script>";*/											
									$sql_2 = "update equipo
												set cod_estado_equipo = 3
												where cod_equipo = ".$cod_equipo_dev."
											";
									$res_2 = mysql_query($sql_2,$link) or die();															
									//echo "<br />";
									$sql_2 = "update equipo
												set cod_estado_equipo = 1	
												where cod_equipo = ".$cod_equipo_entreg."
											";
									$res_2 = mysql_query($sql_2,$link) or die();															
									//echo "<br />";
									
									$sql_1 = "update equipos_arriendo
												set estado_equipo_arr = 'NO DEVUELTO',
													arrendado_hasta = '0000-00-00',
													hora_devol = '00:00:00',
													cod_reclamo = 0
												where num_gd = ".$num_gd_002."
													and cod_equipo = ".$cod_equipo_dev."
													and estado_equipo_arr like '%CAMBIO'
											";
									$res_1 = mysql_query($sql_1,$link) or die();
									//echo "<br />";
									$sql_1 = "delete from equipos_arriendo
												where num_gd = ".$num_gd_002." 
													and cod_equipo = ".$cod_equipo_entreg."
													and estado_equipo_arr = 'NO DEVUELTO'
											";
									$res_1 = mysql_query($sql_1,$link) or die();
										//borrar det_gd
									$sql_3  = " delete
												from det_gd
												where num_gd='$num_gd'";
									$res_3  = mysql_query($sql_3) or die(mysql_error());
								
									//borrar gd
									$sql_4  = " delete
												from gd
												where num_gd='$num_gd'";
									$res_4  = mysql_query($sql_4) or die(mysql_error());
										//echo "<br />";
									echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
									echo "<script language=Javascript> location.href=\"menu.php\"; </script>";	
									}
								}
							}
						}							
					else{
						$temp = "";
						$sql_verificacion ="select nro_factura	 
											from equipos_arriendo
											where num_gd ='$num_gd'
												and nro_factura <> 0
											union 
											select num_factura
											from factura
											where gd_rep = '$num_gd'";
						$res_ver = mysql_query($sql_verificacion,$link) or die(mysql_error());
						while ($row_ver = mysql_fetch_array($res_ver)){
							$temp .= $row_ver['nro_factura'].", ";
							}
						echo "<script> alert ('Guía asociada a facturas. ".$temp."'); </script>";
						echo "<script language=Javascript> location.href=\"eliminar_gd.php\"; </script>";	
						}						
					}
				}
			} 
	?> 
</div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
	$(document).ready(function(){
		$("#vista-previa-gd").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});
		});
	$(window).load(function() {
		$("#vista-previa-gd").attr('href','http://sebter.cl/classes/consulta-gd/vista-previa-gd.php?num_gd=<?php echo $_POST['txt_gd'] ?>');
		});
</script>
</body>

</html>

