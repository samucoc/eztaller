<?php 
include('../conex.php');
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

function lineas_recursivas_1($cod_equipo_entreg,$num_gd,$cod_reclamo){
	$link = Conectarse();
	$sql_obtener_equipos_1 ="SELECT distinct det_gd.num_gd, det_gd.cod_equipo, gd.fecha
							FROM  det_gd 
								inner join gd
									ON det_gd.num_gd = gd.num_gd
								where det_gd.cod_equipo = ".$cod_equipo_entreg."
									and gd.num_gd = ".$num_gd."
							ORDER BY gd.num_gd, det_gd.cod_equipo";
	$res_ob_eq_1 = mysql_query($sql_obtener_equipos_1,$link);
	while($row_ob_eq_1 = mysql_fetch_array($res_ob_eq_1)){
		$sql_cod_reclamo_1 = "select * 
							from reclamo
							where cod_equipo_entreg = ".$row_ob_eq_1['cod_equipo']."
								and cod_reclamo = ".$cod_reclamo;
		$res_cod_reclamo_1 = mysql_query($sql_cod_reclamo_1,$link) or die(mysql_error());
		if (mysql_num_rows($res_cod_reclamo_1)==0){
			echo "<td>".$row_ob_eq_1['num_gd']."</td>";
			$sql_equipo = "select nombre_equipo
							from equipo
							where cod_equipo = ".$row_ob_eq_1['cod_equipo'];
			$res_equipo = mysql_query($sql_equipo) or die(mysql_error());
			$row_equipo = mysql_fetch_array($res_equipo);
			$nombre_equipo = $row_equipo['nombre_equipo'];
			echo "<td>".utf8_encode($nombre_equipo)."</td>";
			echo "<td>XXXX</td>";
			echo "<td>No registra Cambios</td>";
			echo "<td>XXXX</td>";
			echo "</tr><tr>";
			}
		else{
			while($row_cod_reclamo_1 = mysql_fetch_array($res_cod_reclamo_1)){
				echo "<td>".$row_ob_eq_1['num_gd']."</td>";
				$sql_equipo = "select nombre_equipo
								from equipo
								where cod_equipo = ".$row_ob_eq_1['cod_equipo'];
				$res_equipo = mysql_query($sql_equipo) or die(mysql_error());
				$row_equipo = mysql_fetch_array($res_equipo);
				$nombre_equipo = $row_equipo['nombre_equipo'];
				echo "<td>".utf8_encode($nombre_equipo)."</td>";
				echo "<td>".$row_cod_reclamo_1['fecha_reclamo']."</td>";
				$sql_equipo = "select nombre_equipo
								from equipo
								where cod_equipo = ".$row_cod_reclamo_1['cod_equipo_entreg'];
				$res_equipo = mysql_query($sql_equipo) or die(mysql_error());
				$row_equipo = mysql_fetch_array($res_equipo);
				$nombre_equipo = $row_equipo['nombre_equipo'];
				echo "<td>".utf8_encode($nombre_equipo)."</td>";
				echo "<td>".$row_cod_reclamo_1['num_gd_salida']."</td>";
				echo "</tr><tr>";
				lineas_recursivas_1($row_ob_eq_1['cod_equipo'],$row_cod_reclamo_1['num_gd_salida'],$row_cod_reclamo_1['cod_reclamo']);
				}
			}
		}
	}


$sql_obtener_equipos ="SELECT distinct det_gd.num_gd, det_gd.cod_equipo
						FROM  `arriendo` 
							INNER JOIN equipos_arriendo 
								ON equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
							INNER JOIN det_gd 
								ON det_gd.num_gd = equipos_arriendo.num_gd
						where arriendo.fecha_arr between '".$inicio."' and '".$fin."'
						ORDER BY equipos_arriendo.num_gd, det_gd.cod_equipo";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
echo "<table id='warp_1'><tr>";
echo "<td>Nº Guía Original</td>";
echo "<td>Nombre Equipo Original</td>";
echo "<td>Fecha Guía Cambio</td>";
echo "<td>Nombre Equipo Bueno</td>";
echo "<td>N° Guía Cambio</td>";
echo "</tr><tr>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
	
	$sql_num_gd = "select cod_reclamo 
					from equipos_arriendo 
					where num_gd = ".$row_ob_eq['num_gd']."";
	$res_num_gd = mysql_query($sql_num_gd,$link) or die(mysql_error());
	$row_num_gd = mysql_fetch_array($res_num_gd);
	
	$cod_reclamo = $row_num_gd['cod_reclamo'];
	
	$sql_cod_reclamo = "select * 
						from reclamo
						where cod_equipo_dev = ".$row_ob_eq['cod_equipo']."
							and cod_reclamo = ".$row_num_gd['cod_reclamo']."";
	$res_cod_reclamo = mysql_query($sql_cod_reclamo,$link) or die(mysql_error());
	if (mysql_num_rows($res_cod_reclamo)==0){
		echo "<td>".$row_ob_eq['num_gd']."</td>";
		$sql_equipo = "select nombre_equipo
						from equipo
						where cod_equipo = ".$row_ob_eq['cod_equipo'];
		$res_equipo = mysql_query($sql_equipo) or die(mysql_error());
		$row_equipo = mysql_fetch_array($res_equipo);
		$nombre_equipo = $row_equipo['nombre_equipo'];
		echo "<td>".utf8_encode($nombre_equipo)."</td>";
		echo "<td>XXXX</td>";
		echo "<td>No registra Cambios</td>";
		echo "<td>XXXX</td>";
		echo "</tr><tr>";
		}
	else{
		while($row_cod_reclamo = mysql_fetch_array($res_cod_reclamo)){
			echo "<td>".$row_ob_eq['num_gd']."</td>";
			$sql_equipo = "select nombre_equipo
							from equipo
							where cod_equipo = ".$row_ob_eq['cod_equipo'];
			$res_equipo = mysql_query($sql_equipo) or die(mysql_error());
			$row_equipo = mysql_fetch_array($res_equipo);
			$nombre_equipo = $row_equipo['nombre_equipo'];
			echo "<td>".utf8_encode($nombre_equipo)."</td>";
			echo "<td>".$row_cod_reclamo['fecha_reclamo']."</td>";
			$sql_equipo = "select nombre_equipo
							from equipo
							where cod_equipo = ".$row_cod_reclamo['cod_equipo_entreg'];
			$res_equipo = mysql_query($sql_equipo) or die(mysql_error());
			$row_equipo = mysql_fetch_array($res_equipo);
			$nombre_equipo = $row_equipo['nombre_equipo'];
			echo "<td>".utf8_encode($nombre_equipo)."</td>";
			echo "<td>".$row_cod_reclamo['num_gd_salida']."</td>";
			echo "</tr><tr>";
			lineas_recursivas_1($row_ob_eq['cod_equipo'],$row_cod_reclamo['num_gd_salida'],$row_cod_reclamo['cod_reclamo']);
			}
		}
	}
echo "</table>";
?>