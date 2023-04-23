<?php 
include('../conex.php');
$link = Conectarse();
$inicio  = $_GET['inicio'];
$fin  = $_GET['fin'];

$arr_equipo_inicial = array();
$arr_cod_reclamo = array();

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

echo "<table id='warp_1'><tr>";
echo "<td>Nº Guía</td>";
echo "<td>Equipo Original</td>";
echo "<td>N° Factura</td>";
echo "<td>Fecha Desde</td>";
echo "<td>Fecha Hasta</td>";
echo "<td>Días Ajuste</td>";
echo "<td>Días Cobrados</td>";
echo "<td>Neto</td>";
echo "<td>Equipo Facturado</td>";
echo "</tr>";

$sql_003 ="select distinct equipos_arriendo.nro_factura, num_gd
			from equipos_arriendo
			where equipos_arriendo.arrendado_desde between '".$inicio."' and '".$fin."'
				and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
				order by equipos_arriendo.nro_factura, num_gd";
$res_003 = mysql_query($sql_003,$link) or die(mysql_error());
while ($row_003 = mysql_fetch_array($res_003)){

	$nro_factura = $row_003['nro_factura'];
	$num_gd = $row_003['num_gd'];
	$sqlperiodo=" SELECT distinct equipos_arriendo.nro_factura, equipos_arriendo.arrendado_desde,
					equipos_arriendo.arrendado_hasta, equipos_arriendo.cod_equipo
			FROM equipos_arriendo
			where equipos_arriendo.nro_factura = ".$nro_factura."
				and equipos_arriendo.num_gd = ".$num_gd."
				and equipos_arriendo.arrendado_desde between '".$inicio."' and '".$fin."'
			order by equipos_arriendo.nro_factura asc";
	$res_002 = mysql_query($sqlperiodo) or die(mysql_error()); 
	while ($row_002 = mysql_fetch_array($res_002)){
		if (mysql_num_rows($res_002)>0){
			echo "<tr><td>".$num_gd."</td>";
			$flag_0 = 0;
			
			$sql_005 ="select distinct det_gd.cod_equipo, equipo.nombre_equipo
						from det_gd
							inner join equipo
								on equipo.cod_equipo = det_gd.cod_equipo
						where det_gd.num_gd = ".$num_gd."";
			$res_005 = mysql_query($sql_005,$link) or die(mysql_error());
			$i=0;
			while($row_005 = mysql_fetch_array($res_005)){
				$arr_equipo_inicial[$i][0] = $row_005['cod_equipo'];
				$arr_equipo_inicial[$i][1] = $row_005['nombre_equipo'];
				$i++;
				}
			$i=0;
			for ($i=0; $i<count($arr_equipo_inicial);$i++ ){
				if (($row_002['cod_equipo']==$arr_equipo_inicial[$i][0]) && ($flag_0==0)){
					echo "<td>".utf8_encode($arr_equipo_inicial[$i][1])."</td>";
					$flag_0=1;
					}
				}
			if ($flag_0==0){
				$sql_010 = "select cod_equipo_dev
							from equipos_arriendo
								inner join reclamo
									on equipos_arriendo.cod_reclamo = reclamo.cod_reclamo
							where equipos_arriendo.num_gd = ".$num_gd."
								and reclamo.cod_reclamo <> 0
								and reclamo.cod_equipo_entreg = ".$row_002['cod_equipo']."
							order by reclamo.cod_reclamo desc";
				$res_010 = mysql_query($sql_010,$link) or die(mysql_error());
				$row_10 = mysql_fetch_array($res_010);
				
				$cod_equipo_entre = $row_10['cod_equipo_dev'];
				$i=0;
				while ($i==0){
					$sql_gd = "select cod_equipo
								from det_gd
								where num_gd = ".$num_gd."
									and cod_equipo = ".$cod_equipo_entre;
					$res_gd = mysql_query($sql_gd,$link) or die(mysql_error());
					if (mysql_num_rows($res_gd)>0){
						$sql_cei_1 = "select nombre_equipo 
									from equipo	
									where cod_equipo = ".$cod_equipo_entre;
						$res_cei_1 = mysql_query($sql_cei_1,$link) or die(mysql_error());
						$row_cei_1 = mysql_fetch_array($res_cei_1);
						echo "<td>".utf8_encode($row_cei_1['nombre_equipo'])."</td>";
						$i=1;
						}
					else{
						$sql_010 = "select cod_equipo_dev
									from equipos_arriendo
										inner join reclamo
											on equipos_arriendo.cod_reclamo = reclamo.cod_reclamo
									where equipos_arriendo.num_gd = ".$num_gd."
										and reclamo.cod_reclamo <> 0
										and reclamo.cod_equipo_entreg = ".$cod_equipo_entre."
									order by reclamo.cod_reclamo desc";
						$res_010 = mysql_query($sql_010,$link) or die(mysql_error());
						$row_10 = mysql_fetch_array($res_010);
						
						$cod_equipo_entre = $row_10['cod_equipo_dev'];
						}
					}
				}
			echo "<td>".utf8_encode($row_002['nro_factura'])."</td>";
			echo "<td>".tranf_fecha_2(utf8_encode($row_002['arrendado_desde']))."</td>";
			echo "<td>".tranf_fecha_2(utf8_encode($row_002['arrendado_hasta']))."</td>";
			$sql_detalle = "select *
							from det_factura
							where num_factura = ".$row_002['nro_factura']."
								and cod_equipo = ".$row_002['cod_equipo'];
			$res_detalle = mysql_query($sql_detalle,$link) or die(mysql_error());
			$row_detalle = mysql_fetch_array($res_detalle);
			echo "<td>".utf8_encode($row_detalle['dias_ajuste'])."</td>";
			echo "<td>".utf8_encode($row_detalle['dias_arriendo'])."</td>";
			echo "<td>".utf8_encode($row_detalle['tot_arriendo'])."</td>";
			$cod_equipo_inicial_1 = $row_002['cod_equipo'];
			$sql_cei_1 = "select nombre_equipo 
						from equipo	
						where cod_equipo = ".$cod_equipo_inicial_1;
			$res_cei_1 = mysql_query($sql_cei_1,$link) or die(mysql_error());
			$row_cei_1 = mysql_fetch_array($res_cei_1);
			echo "<td>".utf8_encode($row_cei_1['nombre_equipo'])."</td>";
			echo "</tr>";
			}
		}
	}
echo "</table>";
?>