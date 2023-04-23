<?php
include("../conex.php");
		$link=Conectarse();
$sql="SELECT DATE_FORMAT(factura_pagos.fecha,'%d-%m-%Y') as fecha,  factura_pagos.tipo_pago, 	
			factura_pagos.monto, DATE_FORMAT(factura_pagos.fecha_dig,'%d-%m-%Y %H:%i:%s') as fecha_dig,
			factura_pagos.usuario , factura_pagos.fp_ncorr, factura.cod_cliente, cp_ncorr, factura.num_factura
		FROM  factura_pagos
			left join factura
				on factura_pagos.num_factura = factura.num_factura
		where 1
	";
	
if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
		$sql .= " and factura_pagos.num_factura in (select num_factura from factura where cod_cliente like '".$_GET["id_cliente"]."') ";
		$sql_a .= " and factura_pagos.num_factura in (select num_factura from factura where cod_cliente like '".$_GET["id_cliente"]."') ";
		}
	}
if (isset($_GET['fecha_inicio'])){
	if ($_GET["fecha_inicio"]!=""){
		$fecha_inicio = $_GET["fecha_inicio"];
		list($dia,$mes,$anio) = explode('-',$fecha_inicio);
		$fecha_inicio = $anio.'-'.$mes.'-'.$dia;
		$sql .= " and factura_pagos.fecha >= '".$fecha_inicio."' ";
		$sql_a .= " and factura_pagos.fecha >= '".$fecha_inicio."' ";
		}
	}

if (isset($_GET['fecha_fin'])){
	if ($_GET["fecha_fin"]!=""){
		$fecha_inicio = $_GET["fecha_fin"];
		list($dia,$mes,$anio) = explode('-',$fecha_inicio);
		$fecha_inicio = $anio.'-'.$mes.'-'.$dia;
		$sql .= " and factura_pagos.fecha <= '".$fecha_inicio."' ";
		$sql_a .= " and factura_pagos.fecha <= '".$fecha_inicio."' ";
		}
	}

?>
<table>
<tr>
	<td colspan="6" align="left"><h3>Pagos</h3></td>
</tr>
<tr>
	<td>Nro Comprobante de Pago</td>
	<td>Monto Comprobante de Pago</td>
	<td>Cliente</td>
	<td>Nro Factura</td>
	<td>Fecha Pago</td>
	<td>Tipo Pago</td>
	<td>Monto Pago</td>
	<td>Banco</td>
	<td>Cuenta Corriente</td>
	<td>Nro Cheque</td>
	<td>Valor</td>
	<td>Fecha Digitacion</td>
	<td>Usuario</td>
</tr>
<?php 
	$res1 = mysql_query($sql,$link) or die(mysql_error());
	$temp = "";
	$nro_monto = "";
	while($row4 = mysql_fetch_array($res1)){
?>
<tr>
	<?php 
		$sql_cp = "select * from comprobante_pago where cp_ncorr = '".$row4['cp_ncorr']."'";
		$res_cp = mysql_query($sql_cp,$link);
		if (mysql_num_rows($res_cp)>0){
		$row_cp = mysql_fetch_array($res_cp);
	?>
	<td>
		<?php 
			if (($temp=='')||($temp!=$row_cp['cp_ncorr'])){
				$temp = $row_cp['cp_ncorr'];
				echo $temp;
				$nro_monto = number_format(($row_cp['monto']),0,".",",");
				}
			else{
				echo "----------------";
				$nro_monto = "----------------";
				}
		?>
	</td>
	<td>
		<?php 
			echo $nro_monto;
		?>
	</td>
	<?php }else{?>
	<td colspan="2">
		------------------
	</td>
	<?php }?>
	<td>

		<?php
			if ($row4['cod_cliente']!=''){
				$query = "select distinct clientes.raz_social
							from clientes
						 where clientes.cod_cliente = ".$row4['cod_cliente']."";
				
				$result=mysql_query($query,$link) or die(mysql_error()); 
				if(mysql_num_rows($result)>0){
					$row = mysql_fetch_array($result); 
					echo $row['raz_social'];
					}
				}
			else{ echo "Sin Cliente";}
		?>
	</td>
	<td><?php 
		echo $row4['num_factura'];		
		?>
	</td>
	<td><?php 
		echo $row4['fecha'];		
		?>
	</td>
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
	<?php 
		$sql_cp = "select * from factura_operaciones where cp_ncorr = '".$row4['cp_ncorr']."'";
		$res_cp = mysql_query($sql_cp,$link);
		if (mysql_num_rows($res_cp)>0){
			$row_cp = mysql_fetch_array($res_cp);
	?>
	<td><?php  
			$sql_familias="select *
					from bancos where banco_ncorr = ".$row_cp['banco']."";
			$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
			while ($row_familia = mysql_fetch_array($res_familia)){
				echo $row_familia['nombre'];
				}
		?></td>
	<td><?php echo $row_cp['ctacte']?></td>
	<td><?php echo $row_cp['nrocheque']?></td>
	<td><?php echo number_format(($row_cp['valor']),0,".",",")?></td>
	<?php }else{?>
	<td colspan="4">
		------------------
	</td>
	<?php }?>
	<td><?php echo $row4['fecha_dig']?></td>
	<td><?php echo $row4['usuario']?></td>
</tr>
<?php }?>
<tr>
	<td colspan="6" align="left">Tipo Pago</td>
</tr>
<tr>
	<td>Tipo Pago</td>
	<td>Monto</td>
</tr>
<?php 
	$sql_1 = "select tipo_pago, sum(monto) as monto
		FROM  factura_pagos
		where 1 $sql_a
		group by tipo_pago";
	$res1 = mysql_query($sql_1,$link) or die(mysql_error());
	while($row4 = mysql_fetch_array($res1)){
?>
<tr>
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
</tr>
<?php }?>
</table>
