<?php
$q = strtolower($_GET['rut']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

	$mes_1			= 	$_GET["mes_1"];
	$anio_1			= 	$_GET["anio_1"];
	$mes_2			= 	$_GET["mes_2"];
	$anio_2			= 	$_GET["anio_2"];

			$anio_pos = date("Y",mktime(0,0,0,$mes_1,1,$anio_1));
			$mes_pos = date("m",mktime(0,0,0,$mes_1,1,$anio_1));
			
			$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

			
			$anio_pos = date("Y",mktime(0,0,0,$mes_2,1,$anio_2));
			$mes_pos = date("m",mktime(0,0,0,$mes_2,1,$anio_2));
			
			$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
			$dia_mes_ant	        = date("t",$medio_mes_ant);
			
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

			


$sql = "SELECT distinct carga_veh 
        FROM `cargas_vehiculos` 
        WHERE `carga_pers` = '".$q."' and carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."'
			";
$res = mysql_query($sql, $conexion);
$rut = 'Patentes Asociadas : ';
if (mysql_num_rows($res)>0){
    while ($row = mysql_fetch_array($res)) {
        $rut .= $row['carga_veh'].',';
        }
}else{
    $rut = "Sin asignacion";
}
echo $rut;
?>
	