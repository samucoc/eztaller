<?php 
	include("conex.php");
	$link=Conectarse();

	$sql_1 = "select *
				from equipos_arriendo
					inner join arriendo
						on equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
				order by fecha_arr";
	$res_1 = mysql_query($sql_1,$link) or die();
	$i = 0;
	while($row_1 = mysql_fetch_array($res_1)){
		$cod_equipo = $row_1['cod_equipo'];
		$fecha_arr = $row_1['fecha_arr'];
		echo $cod_equipo."->".$fecha_arr;
		$sql_precio = "select valor_unidad_arr
						from equipo
						where cod_equipo = '$cod_equipo'";
		$res_equipo = mysql_query($sql_precio,$link) or die();
		$row_equipo = mysql_fetch_array($res_equipo);
		$precio = $row_equipo['valor_unidad_arr'];
		
		echo $sql_update = "update equipos_arriendo
						set precio = '$precio'
						where cod_equipo = '$cod_equipo'";
		//$res_update = mysql_query($sql_update,$link) or die(mysql_error());
		echo "<br>";
		$i=$i+1;
		}
	echo $i;
	echo "<br>";

?>