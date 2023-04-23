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

$tipo  = $_GET['tipo'];

$sql_obtener_equipos ="SELECT *
						FROM gd 
						where gd.estado = 'NULA'
							and fecha between '".$inicio."' and '".$fin."'	
						order by num_gd asc";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
echo "<table id='warp_1'><tr>";
echo "<td>Nº Guía</td>";
echo "<td>Fecha Emision</td>";
echo "<td>Observaciones</td>";

echo "</tr>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
	echo "<tr>";
	echo "<td>".$row_ob_eq['num_gd']."</td>";
	echo "<td>".tranf_fecha_2($row_ob_eq['fecha'])."</td>";
	echo "<td>".$row_ob_eq['observaciones']."</td>";
	echo "</tr>";
	}
	echo "</table>";
?> 