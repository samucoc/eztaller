<?php ob_start(); 
session_start(); 
	include("../conex.php");
	$link=Conectarse();
	if ($_POST['eliminar']=='Eliminar'){
		if(isset($_POST['id']))$id	= $_POST['id'];
		if (isset($id)){
				$obs = "Accion : Eliminado || Nro. : ".$id." || Fecha : ".date("Y-m-d");
				$sql1="SELECT num_factura
					FROM  factura_pagos
					where fp_ncorr =".$_GET['id']."
				";
				$res1 = mysql_query($sql1,$link) or die(mysql_error());
				$row4 = mysql_fetch_array($res1) ;
				$num_factura = $row4['num_factura']	;
				$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','ABONANDO','ELIMINADO PAGO','".$_SESSION['usuario']."')";
				$res=mysql_query($sql,$link) or die(mysql_error());

				$sql = "delete
					FROM  factura_pagos
					where fp_ncorr =".$_GET['id']."";
				$res=mysql_query($sql,$link) or die(mysql_error());
				header('Location:ver_logs.php?num_factura='.$num_factura);
			}
		}
	if ($_POST['actualizar']=='Actualizar'){
		if(isset($_POST['id']))$id	= $_POST['id'];
		if (isset($id)){

				if(isset($_POST['fecha']))$fecha	= $_POST['fecha'];
				list($dia1,$mes1,$anio1) = explode('-', $fecha);
				$fecha 	= $anio1.'-'.$mes1.'-'.$dia1;
				if(isset($_POST['tipo_pago']))$tipo_pago		= $_POST['tipo_pago'];
				if(isset($_POST['monto']))$monto	= $_POST['monto'];

				$sql1="SELECT num_factura
					FROM  factura_pagos
					where fp_ncorr ='".$id."'
				";
				$res1 = mysql_query($sql1,$link) or die(mysql_error());
				$row4 = mysql_fetch_array($res1) ;
				$num_factura = $row4['num_factura']	;
				
				$sql_0 = "SELECT sum(tot_arriendo) as total ,sum(total_rep) as total_1
					FROM factura
						inner join det_factura
							on factura.num_factura = det_factura.num_factura
					where factura.num_factura = '".$num_factura."'
					group by factura.num_factura";			
				$res_0 = mysql_query($sql_0,$link) or die(mysql_error());
				$row_0 = mysql_fetch_array($res_0);
				
				$total = $row_0['total'];
				if ($total==0){
					$total = $row_0['total_1'];
					}
				if ($monto>0){
					$sql = "update factura
						set 	estado = 'ABONANDO'
						where num_factura = '".$num_factura."'";
					$res=mysql_query($sql,$link) or die(mysql_error());
					$obs = "Accion : Abonado || Nro. : ".$id." || Fecha : ".$fecha;
					$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','ABONANDO','".$_SESSION['usuario']."')";
					$res=mysql_query($sql,$link) or die(mysql_error());

					$sql = "update `factura_pagos`
							set `tipo_pago` = '".$tipo_pago."', 
								`monto` = '".$monto."', 
								`fecha` = '".$fecha."'
							where fp_ncorr = '".$id."'";
					$res=mysql_query($sql,$link) or die(mysql_error());

					$sql3="SELECT sum(monto) as monto
					from factura_pagos
					where num_factura = '".$num_factura."'";
					$res3 = mysql_query($sql3,$link) or die(mysql_error());
					$registro3 = mysql_fetch_array($res3);
					$abono = $registro3['monto'];

					if (!($total-$abono>0)){
						$sql = "update factura
							set 	estado = 'PAGADO'
							where num_factura = '".$num_factura."'";
						$res=mysql_query($sql,$link) or die(mysql_error());
						$obs = "Accion : Abonado || Nro. : ".$id." || Fecha : ".$fecha;
						$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','ABONANDO','PAGADO','".$_SESSION['usuario']."')";
						$res=mysql_query($sql,$link) or die(mysql_error());

						}

					$id = mysql_insert_id();
					$obs = "Accion : PAGO || Nro. : ".$id." || Fecha : ".$fecha;
					$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','PROCESO_PAGO','".$_SESSION['usuario']."')";
					$res=mysql_query($sql,$link) or die(mysql_error());

					$monto = $monto-$total;
					}
				header('Location:ver_logs.php?num_factura='.$num_factura);
			}
		
		}
	$factura = $_GET['num_factura'];
	$sql1="SELECT DATE_FORMAT(fecha,'%d-%m-%Y') as fecha,  tipo_pago, 	
			monto, DATE_FORMAT(fecha_dig,'%d-%m-%Y %H:%i:%s') as fecha_dig,
			usuario , fp_ncorr
		FROM  factura_pagos
		where fp_ncorr =".$_GET['id']."
	";
	$res1 = mysql_query($sql1,$link) or die(mysql_error());
	$row4 = mysql_fetch_array($res1) ;
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
</head>
<body>
	<form method="post" name="frmDatos" id="frmDatos">
		<table>
		<tr>
			<td colspan="6" align="left">
				<h3>Modificar Pago</h3>
				<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']?>">
			</td>
		</tr>
		<tr>
			<td>Fecha Pago</td>
			<td><input type="text" id="fecha" name="fecha" value="<?php echo $row4['fecha']?>"/></td>
		</tr>
		<tr>
			<td>Tipo Pago</td>
			<td>
				<select name="tipo_pago" id="tipo_pago">
				<?php 
				$sql3="SELECT nombre,tp_ncorr
					FROM tipo_pagos ";
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				while ($registro3 = mysql_fetch_array($res3)){ ?>
					<option value="<?php echo $registro3['tp_ncorr'];	?>"><?php echo $registro3['nombre'];	?></option>
				<?php }?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Monto</td>
			<td><input type="text" id="monto" name="monto" value=<?php echo $row4['monto']?> /></td>
		</tr>
		<tr>
			<td><input type="submit" value="Eliminar" id="eliminar" name="eliminar" /></td>
			<td><input type="submit" value="Actualizar" id="actualizar" name="actualizar" /></td>
		</tr>
		</table>
	</form>
</body>
</html>
<?php ob_flush();?>