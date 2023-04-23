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

$sql_obtener_gd ="SELECT num_gd, fecha
								from gd
						where gd.fecha between '".$inicio."' and '".$fin."'
							and tipo = 'DEVOL EQUIPO'
						ORDER BY gd.num_gd";
$res_ob_gd = mysql_query($sql_obtener_gd,$link) or die(mysql_error());
echo "<table id='warp_1'><tr>";
echo "<td>Nº Guía Original</td>";
echo "<td>Nombre Equipo Original</td>";
echo "<td>Fecha Guía Cambio</td>";
echo "<td>Nombre Equipo Cambio</td>";
echo "<td>N° Guía Cambio</td>";
echo "</tr>";
while($row_ob_gd = mysql_fetch_array($res_ob_gd)){
	//voy a reclamo a buscar el cod_reclamo
	$sql_001="select cod_reclamo,cod_equipo_dev,cod_equipo_entreg
				from reclamo
				where num_gd_salida = ".$row_ob_gd['num_gd']."";
	$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
	while($row_001 = mysql_fetch_array($res_001)){
		$cod_reclamo = $row_001['cod_reclamo'];
		//voy a equipo_arriendo con el cod_reclamo
			//pregunto por la num_gd original
		$sql_002 = "select num_gd 
					from equipos_arriendo
					where cod_reclamo = ".$cod_reclamo."";
		$res_002 = mysql_query($sql_002,$link) or die(mysql_error());
		$row_002 = mysql_fetch_array($res_002);
		if (!empty($row_002['num_gd'])){
			$num_gd_original = $row_002['num_gd'];
			echo "<tr>";
			//presento num_gd
			echo "<td>".$num_gd_original."</td>";
			//presento equipo entrante
			$sql_003 = "select nombre_equipo
						from equipo
						where cod_equipo = ".$row_001['cod_equipo_dev'];
			$res_003 = mysql_query($sql_003,$link) or die(mysql_error());
			$row_003 = mysql_fetch_array($res_003);
			$nom_eq_ent = $row_003['nombre_equipo'];
			echo "<td>".htmlentities($nom_eq_ent)."</td>";
			//presento fecha reclamo
			echo "<td>".tranf_fecha_2($row_ob_gd['fecha'])."</td>";
			//presento equipo saliente
			$sql_003 = "select nombre_equipo
						from equipo
						where cod_equipo = ".$row_001['cod_equipo_entreg'];
			$res_003 = mysql_query($sql_003,$link) or die(mysql_error());
			$row_003 = mysql_fetch_array($res_003);
			$nom_eq_ent = $row_003['nombre_equipo'];
			echo "<td>".htmlentities($nom_eq_ent)."</td>";
			//presento num_gd cambio	
			echo "<td>".$row_ob_gd['num_gd']."</td>";
			echo "</tr>";
			}
		}
	}
echo "</table>";
?>