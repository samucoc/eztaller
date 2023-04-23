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

$sql_factura ="select distinct equipos_arriendo.nro_factura
				from equipos_arriendo
					inner join factura
						on factura.num_factura = equipos_arriendo.nro_factura
				where factura.fecha between '".$inicio."' and '".$fin."'
					and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
				order by equipos_arriendo.nro_factura";
$res_factura = mysql_query($sql_factura,$link) or die(mysql_error());

echo "<table id='warp_1'><tr>";
	echo "<td>Nº Factura</td>";
	echo "<td>Fecha Emision</td>";
	echo "<td>Rut Empresa</td>";
	echo "<td>Empresa</td>";
	echo "<td>Obra</td>";
	echo "<td>N° Guia Despacho</td>";
	echo "<td>Equipo Facturado</td>";
	echo "<td>Fecha Desde</td>";
	echo "<td>Fecha Hasta</td>";
	echo "<td>Total Días Cobrados</td>";
	echo "<td>Monto Neto</td>";
	echo "</tr>";

while ($row_factura = mysql_fetch_array($res_factura)){
	$sql_obtener_equipos ="	SELECT distinct det_factura.num_factura, factura.fecha, factura.cod_cliente,
									factura.cod_obra, factura.cod_arriendo, det_factura.cod_equipo,
									equipos_arriendo.num_gd, equipos_arriendo.arrendado_desde, 
									equipos_arriendo.arrendado_hasta, det_factura.dias_arriendo, det_factura.tot_arriendo
							FROM  factura
								INNER JOIN det_factura
									ON det_factura.num_factura = factura.num_factura
								INNER JOIN equipos_arriendo
									ON equipos_arriendo.cod_arriendo = factura.cod_arriendo
							where factura.fecha between '".$inicio."' and '".$fin."'
								and equipos_arriendo.nro_factura = ".$row_factura['nro_factura']."
							order by equipos_arriendo.nro_factura";
	$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
	
	while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
		echo "<tr><td>".$row_ob_eq['num_factura']."</td>";
		echo "<td>".tranf_fecha_2($row_ob_eq['fecha'])."</td>";
		
		$sql_cliente = "select *
						from clientes
						where cod_cliente = ".$row_ob_eq['cod_cliente']; 
		$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
		while ($row_cliente = mysql_fetch_array($res_cliente)){
			echo "<td>".utf8_encode($row_cliente['rut_cliente'])."</td>";
			echo "<td>".utf8_encode($row_cliente['raz_social'])."</td>";
			}
	
		$cod_obra = $row_ob_eq['cod_obra'];
		$sql_obra = "select *
						from obra
						where cod_obra = ".$cod_obra; 
		$res_obra = mysql_query($sql_obra,$link) or die(mysql_error());
		while ($row_obra = mysql_fetch_array($res_obra)){
			echo "<td>".utf8_encode($row_obra['nombre_obra'])."</td>";
			}
	
		$cod_equipo_inicial = $row_ob_eq['cod_equipo'];
		$sql_cei = "select nombre_equipo 
					from equipo	
					where cod_equipo = ".$cod_equipo_inicial;
		$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
		$row_cei = mysql_fetch_array($res_cei);
		echo "<td>".utf8_encode($row_cei['nombre_equipo'])."</td>";
	
		echo "<td>".$row_ob_eq['num_gd']."</td>";
		echo "<td>".tranf_fecha_2($row_ob_eq['arrendado_desde'])."</td>";
		echo "<td>".tranf_fecha_2($row_ob_eq['arrendado_hasta'])."</td>";
		echo "<td>".$row_ob_eq['dias_arriendo']."</td>";
		echo "<td>".$row_ob_eq['tot_arriendo']."</td>";
		echo "</tr>";
		
		}
	}

echo "</table>";
?>