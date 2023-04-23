<?php 
	include("../conex.php");
	$link=Conectarse();
	$factura = $_GET['num_factura'];
?>
<table>
<tr>
	<td colspan="6" align="left"><h3>Historial</h3></td>
</tr>
<tr>
	<td>Fecha</td>
	<td>Hora</td>
	<td>Estado Anterior</td>
	<td>Estado Posterior</td>
	<td>Usuario</td>
	<td>Observacion</td>
</tr>
<?php 
	$sql1="SELECT DATE_FORMAT(fecha_log,'%d-%m-%Y') as fecha_log, 
			DATE_FORMAT(fecha_log,'%H:%i:%s') as hora_log,
			observacion, estado_anterior, estado_posterior,usuario
		FROM  factura_logs
		where num_factura =".$factura."
	";
	$res1 = mysql_query($sql1,$link) or die(mysql_error());
	while($row4 = mysql_fetch_array($res1)){
?>
<tr>
	<td><?php echo $row4['fecha_log']?></td>
	<td><?php echo $row4['hora_log']?></td>
	<td><?php echo $row4['estado_anterior']?></td>
	<td><?php echo $row4['estado_posterior']?></td>
	<td><?php echo $row4['usuario']?></td>
	<td><?php echo $row4['observacion']?></td>
</tr>
<?php }?>
<tr>
	<td colspan="6" align="left"><h3>Eventos</h3></td>
</tr>
<tr>
	<td>Fecha Evento</td>
	<td>Tipo Evento</td>
	<td>Detalle Evento</td>
	<td>Fecha Compromiso</td>
	<td>Tipo Compromiso</td>
</tr>
<?php
	$sql3="SELECT DATE_FORMAT(fecha_evento,'%d-%m-%Y') as fecha_evento,  tipo_evento, 	
			detalle, DATE_FORMAT(fecha_diag,'%d-%m-%Y') as fecha_diag,
			tipo_compromiso	 
		FROM  factura_eventos
		where num_factura =".$factura."
	";
	$res3 = mysql_query($sql3,$link) or die(mysql_error());
	while ($registro3 = mysql_fetch_array($res3)){
?>
<tr>
	<td><?php echo $registro3['fecha_evento']?></td>
	<td><?php 
		$sql = "select nombre
			from tipo_eventos
			where te_ncorr = ".$registro3['tipo_evento']."";
		$res = mysql_query($sql,$link);
		$row = mysql_fetch_array($res);
		echo $row['nombre'];
		?>
	</td>
	<td><?php echo $registro3['detalle']?></td>
	<td><?php echo $registro3['fecha_diag']?></td>
	<td><?php 
		$sql = "select nombre
			from tipo_compromisos
			where tc_ncorr = ".$registro3['tipo_compromiso']."";
		$res = mysql_query($sql,$link);
		$row = mysql_fetch_array($res);
		echo $row['nombre'];
		?>
	</td>
</tr>
<?php } ?>
<tr>
	<td colspan="6" align="left"><h3>Pagos</h3></td>
</tr>
<tr>
	<td>Fecha Pago</td>
	<td>Tipo Pago</td>
	<td>Monto</td>
	<td>Fecha Digitacion</td>
	<td>Usuario</td>
	<td>Modificar</td>
</tr>
<?php 
	$sql1="SELECT DATE_FORMAT(fecha,'%d-%m-%Y') as fecha,  tipo_pago, 	
			monto, DATE_FORMAT(fecha_dig,'%d-%m-%Y %H:%i:%s') as fecha_dig,
			usuario , fp_ncorr
		FROM  factura_pagos
		where num_factura =".$factura."
	";
	$res1 = mysql_query($sql1,$link) or die(mysql_error());
	while($row4 = mysql_fetch_array($res1)){
?>
<tr>
	<td><?php echo $row4['fecha']?></td>
	<td><?php 
		$sql3="SELECT nombre
			FROM tipo_pagos 
			where tp_ncorr = '".$row4['tipo_pago']."'";
		$res3 = mysql_query($sql3,$link) or die(mysql_error());
		$registro3 = mysql_fetch_array($res3);
		echo $registro3['nombre'];		
		?>
	</td>
	<td><?php echo number_format(($row4['monto']),0,".",",")?></td>
	<td><?php echo $row4['fecha_dig']?></td>
	<td><?php echo $row4['usuario']?></td>
	<td>
		<a href="modificar_pago.php?id=<?php echo $row4['fp_ncorr']?>" id="modificar" name="modificar">
			Editar
		</a>
	</td>
</tr>
<?php }?>
</table>
