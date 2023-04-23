<?php 
include('../../conex.php');
$link = Conectarse();
$inicio  = $_GET['inicio'];
$fecha_temp = explode("-",$inicio);
//dia-mes-año
//0 -> dia, 1 -> mes, 2 -> año
$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
$inicio = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
$fin  = $_GET['fin'];
$fecha_temp = explode("-",$fin);
//dia-mes-año
//0 -> dia, 1 -> mes, 2 -> año
$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
$fin = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

$sql_obtener_equipos ="SELECT distinct det_gd.num_gd
						FROM equipos_arriendo 
							INNER JOIN det_gd 
								ON det_gd.num_gd = equipos_arriendo.num_gd
							INNER JOIN factura
								ON equipos_arriendo.cod_arriendo = factura.cod_arriendo
						where equipos_arriendo.arrendado_desde between '".$inicio."' and '".$fin."'
							and equipos_arriendo.arrendado_hasta <> '0000-00-00'
						ORDER BY equipos_arriendo.num_gd, det_gd.cod_equipo";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
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
echo "</tr><tr>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
	$sql_001="select cod_equipo
				from det_gd	
				where num_gd = ".$row_ob_eq['num_gd']."
			  union
				select distinct cod_equipo
				from equipos_arriendo
				where num_gd = ".$row_ob_eq['num_gd']."
					and estado_equipo_arr not like '%CAMBIO'";
	$res_001 = mysql_query($sql_001) or die(mysql_error());
	while($row_001 = mysql_fetch_array($res_001)){
				
		$cod_equipo_inicial = $row_001['cod_equipo'];
		$sql_cei = "select nombre_equipo 
					from equipo	
					where cod_equipo = ".$cod_equipo_inicial;
		$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
		$row_cei = mysql_fetch_array($res_cei);

		$sql_002 = "SELECT factura.num_factura, equipos_arriendo.arrendado_desde,
							equipos_arriendo.arrendado_hasta, det_factura.dias_ajuste,
							det_factura.dias_arriendo, det_factura.tot_arriendo, det_factura.cod_equipo
					FROM equipos_arriendo
						inner join gd
							on equipos_arriendo.cod_arriendo = gd.id_arriendo
					 	inner join factura 
							on factura.cod_arriendo = equipos_arriendo.cod_arriendo
						inner join det_factura 
							on factura.num_factura = det_factura.num_factura
						where equipos_arriendo.cod_equipo =".$cod_equipo_inicial." 
							and equipos_arriendo.num_gd = ".$row_ob_eq['num_gd']."
							and equipos_arriendo.arrendado_hasta >= '".$inicio."'
							and equipos_arriendo.arrendado_desde <= '".$fin."'
							and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
						order by equipos_arriendo.arrendado_hasta asc
						limit 0,1";
		$res_002 = mysql_query($sql_002) or die(mysql_error());
		$registroper_row = mysql_num_rows($res_002);
		if ($registroper_row==0){
			$sql_003 ="select equipos_arriendo.nro_factura
						from equipos_arriendo
						where num_gd = '".$row_ob_eq['num_gd']."'
							and equipos_arriendo.arrendado_hasta >= '".$inicio."'
							and equipos_arriendo.arrendado_desde <= '".$fin."'
							and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'";
			$res_003 = mysql_query($sql_003,$link) or die(mysql_error());
			while ($row_003 = mysql_fetch_array($res_003)){
				$nro_factura = $row_003['nro_factura'];
				
				$sqlperiodo=" SELECT factura.num_factura, equipos_arriendo.arrendado_desde,
								equipos_arriendo.arrendado_hasta, det_factura.dias_ajuste,
								det_factura.dias_arriendo, det_factura.tot_arriendo, det_factura.cod_equipo
						FROM equipos_arriendo
							inner join gd
								on equipos_arriendo.cod_arriendo = gd.id_arriendo
							inner join factura 
								on factura.cod_arriendo = equipos_arriendo.cod_arriendo
							inner join det_factura 
								on factura.num_factura = det_factura.num_factura
							where equipos_arriendo.nro_factura = ".$nro_factura."
							order by equipos_arriendo.arrendado_hasta asc
						limit 0,1";
				$res_002 = mysql_query($sqlperiodo) or die(mysql_error()); 
				}
			$row_002 = mysql_fetch_array($res_002);
			if (mysql_num_rows($res_002)>0){
				echo "<td>".$row_ob_eq['num_gd']."</td>";
				echo "<td>".utf8_encode($row_cei['nombre_equipo'])."</td>";
				echo "<td>".utf8_encode($row_002['num_factura'])."</td>";
				echo "<td>".utf8_encode($row_002['arrendado_desde'])."</td>";
				echo "<td>".utf8_encode($row_002['arrendado_hasta'])."</td>";
				echo "<td>".utf8_encode($row_002['dias_ajuste'])."</td>";
				echo "<td>".utf8_encode($row_002['dias_arriendo'])."</td>";
				echo "<td>".utf8_encode($row_002['tot_arriendo'])."</td>";
				$cod_equipo_inicial_1 = $row_002['cod_equipo'];
				$sql_cei_1 = "select nombre_equipo 
							from equipo	
							where cod_equipo = ".$cod_equipo_inicial_1;
				$res_cei_1 = mysql_query($sql_cei_1,$link) or die(mysql_error());
				$row_cei_1 = mysql_fetch_array($res_cei_1);
				echo "<td>".utf8_encode($row_cei_1['nombre_equipo'])."</td>";
				
				}
			echo "</tr><tr>";
			}
		}
	}
	
echo "</table>";
?>