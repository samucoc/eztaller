<?php 
include('../conex.php');
$link = Conectarse();
$inicio  = $_GET['inicio'];
$fin  = $_GET['fin'];

function tranf_fecha_1($fecha){
	$fecha_temp = explode("-",$fecha);
	//dia-mes-año
	//0 -> dia, 1 -> mes, 2 -> año
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
	return $fecha = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday']; 
	}

function tranf_fecha_2($fecha){
	$fecha_temp = explode("-",$fecha);
	//año-mes-dia
	//0 -> año, 1 -> mes, 2 -> dia
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
	return $fecha = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year']; 
	}
	
$inicio = tranf_fecha_1($inicio);
$fin = tranf_fecha_1($fin); 

$sql_factura ="select * 
				from factura
					inner join det_factura
						on factura.num_factura = det_factura.num_factura
				where factura.fecha between '".$inicio."' and '".$fin."'
					and factura.cod_arriendo = 0
					and factura.estado <> 'NULA'
				order by factura.num_factura";
$res_factura = mysql_query($sql_factura,$link) or die(mysql_error());

echo "<table id='warp_1'><tr>";
	echo "<td>Nº Factura</td>";
	echo "<td>Fecha Emision</td>";
	echo "<td>Rut Empresa</td>";
	echo "<td>Empresa</td>";
	echo "<td>Obra</td>";
	echo "<td>N° Guia Despacho</td>";
	echo "<td>Cantidad</td>";
	echo "<td>Detalle</td>";
	echo "<td>Valor Unitario</td>";
	echo "<td>Total</td>";
	echo "</tr>";

while ($row_factura = mysql_fetch_array($res_factura)){
		echo "<tr><td>".$row_factura['num_factura']."</td>";
		echo "<td>".tranf_fecha_2($row_factura['fecha'])."</td>";
		
		$sql_cliente = "select *
						from clientes
						where cod_cliente = ".$row_factura['cod_cliente']; 
		$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
		$row_cliente = mysql_fetch_array($res_cliente);
		echo "<td>".htmlentities($row_cliente['rut_cliente'])."</td>";
		echo "<td>".$row_cliente['raz_social']."</td>";
	
		$cod_obra = $row_factura['cod_obra'];
		$sql_obra = "select *
						from obra
						where cod_obra = ".$cod_obra; 
		$res_obra = mysql_query($sql_obra,$link) or die(mysql_error());
		$row_obra = mysql_fetch_array($res_obra);
		echo "<td>".($row_obra['nombre_obra'])."</td>";
	
		echo "<td>".($row_factura['observaciones'])."</td>";
	
		echo "<td>".$row_factura['cantidad']."</td>";
		echo "<td>".($row_factura['otros_reparacion'])."</td>";
		echo "<td>".$row_factura['valor_unitario']."</td>";
		echo "<td>".$row_factura['total_rep']."</td>";
		echo "</tr>";
		
		}
echo "</table>";
?>