<?php 

$fecha = $_GET['fecha'];
$fecha_inicio = $fecha;
		list($dia1,$mes1,$anio1) = explode('/', $fecha_inicio);
		$fecha_actual = date("Y-m-d");
		list($anio2,$mes2,$dia2) = explode('-', $fecha_actual);

if (($anio2>$anio1)&&($mes2>$mes1)&&($dia2>$dia1)){
		if ($anio2-$anio1 > 1) $anio2 = $anio1+1;
		
		$fechainicial = new DateTime($anio1.'-'.$mes1.'-'.$dia1);
		$fechafinal = new DateTime($anio2.'-'.$mes2.'-'.$dia2);

		$diferencia = $fechainicial->diff($fechafinal);
		$meses = ( $diferencia->y * 12 ) + $diferencia->m;
		$dias	=	$diferencia->d % $meses;
		
		$total = 1.25 * $meses;
		$total = $total + (0.04167*$dias);
		
echo $total;
}
else{
	echo 0;
	}

?>