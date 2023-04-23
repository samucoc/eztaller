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
	$fecha = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year']; 
	if ($fecha == '30-11-1999'){
		return '';
		}
	return $fecha;
	}
	
$inicio = tranf_fecha_1($inicio);
$fin = tranf_fecha_1($fin);

$tipo  = $_GET['tipo'];

function lineas_recursivas_1($cod_equipo_entreg,$num_gd,$cod_reclamo){
	$link = Conectarse();
	$sql_cliente = "select cod_reclamo
					from equipos_arriendo
					where num_gd = '".$num_gd."'
					and cod_reclamo not in ('".$cod_reclamo."')
					and cod_reclamo <> 0"; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	$row_cliente = mysql_fetch_array($res_cliente);
	$cod_reclamo_un = 0;
	$cod_reclamo_un = $row_cliente['cod_reclamo'];
	
	if (($cod_reclamo_un!=0)&&(!empty($cod_reclamo_un))){
		$sql_cod_reclamo = "select * 
							from reclamo
							where cod_equipo_dev = ".$cod_equipo_entreg."
								and cod_reclamo = ".$cod_reclamo_un."
								and cod_reclamo not in ('".$cod_reclamo."')
								and cod_reclamo <> 0";
		$res_cod_reclamo = mysql_query($sql_cod_reclamo,$link) or die(mysql_error());
		if (mysql_num_rows($res_cod_reclamo)==0){
			$sql_cei = "select nombre_equipo 
						from equipo	
						where cod_equipo = ".$cod_equipo_entreg;
			$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
			$row_cei = mysql_fetch_array($res_cei);
			echo "<td>".utf8_encode($row_cei['nombre_equipo'])."</td>";
			return $cod_equipo_entreg;
			}
		else{
			while ($row_cod_reclamo = mysql_fetch_array($res_cod_reclamo)){
				$cod_reclamo = $cod_reclamo."','".$row_cod_reclamo['cod_reclamo'];
				lineas_recursivas_1($row_cod_reclamo['cod_equipo_entreg'],$num_gd,$cod_reclamo,1);
				}
			}
		}
	else{
		$sql_cei = "select nombre_equipo 
					from equipo	
					where cod_equipo = ".$cod_equipo_entreg;
		$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
		$row_cei = mysql_fetch_array($res_cei);
		echo "<td>".utf8_encode($row_cei['nombre_equipo'])."</td>";
		return $cod_equipo_entreg;
		}
	}

$sql_obtener_equipos ="SELECT distinct det_gd.num_gd, arriendo.fecha_arr, arriendo.hora_arr, 
									arriendo.rut_cliente, arriendo.cod_obra, arriendo.tipo_oc, 
									arriendo.fecha_inicio, arriendo.fecha_vcmto, det_gd.cod_equipo,
									det_gd.precio,arriendo.num_oc
						FROM  `arriendo` 
							INNER JOIN equipos_arriendo 
								ON equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
							INNER JOIN det_gd 
								ON det_gd.num_gd = equipos_arriendo.num_gd
						where arriendo.fecha_arr between '".$inicio."' and '".$fin."'
						ORDER BY equipos_arriendo.num_gd, det_gd.cod_equipo";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
echo "<table id='warp_1'><tr>";
echo "<td>Nº Guía</td>";
echo "<td>Fecha Emision</td>";
echo "<td>Fecha Arriendo</td>";
echo "<td>Hora</td>";
echo "<td>Rut Empresa</td>";
echo "<td>Empresa</td>";
echo "<td>Obra</td>";
echo "<td>Direccion Obra</td>";
echo "<td>Tipo Orden Compra</td>";
echo "<td>Orden Compra</td>";
echo "<td>Fecha O/C</td>";
echo "<td>Fecha Vencimiento O/C</td>";
echo "<td>Equipo Arrendado</td>";
echo "<td>Tarifa</td>";
echo "<td>Equipo Cambio</td>";
echo "<td>Fecha Devolucion</td>";
echo "<td>Hora Devolucion</td>";
echo "<td>Total Dias Ajuste</td>";
echo "<td>Total Días Arr. Cobrados</td>";
echo "<td>Ultima factura Asociada</td>";
echo "<td>Fecha Ultima Factura</td>";
echo "</tr><tr>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
		echo "<td>".$row_ob_eq['num_gd']."</td>";
		echo "<td>".tranf_fecha_2($row_ob_eq['fecha_arr'])."</td>";
		echo "<td>".tranf_fecha_2($row_ob_eq['fecha_arr'])."</td>";
		echo "<td>".$row_ob_eq['hora_arr']."</td>";
		echo "<td>".$row_ob_eq['rut_cliente']."</td>";
		$rut_cliente = $row_ob_eq['rut_cliente'];
		$sql_cliente = "select *
						from clientes
						where rut_cliente = '".$rut_cliente."'"; 
		$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
		$row_cliente = mysql_fetch_array($res_cliente);
		echo "<td>".utf8_encode($row_cliente['raz_social'])."</td>";
		$cod_obra = $row_ob_eq['cod_obra'];
		$sql_obra = "select *
						from obra
						where cod_obra = ".$cod_obra; 
		$res_obra = mysql_query($sql_obra,$link) or die(mysql_error());
		$row_obra = mysql_fetch_array($res_obra);
		if (empty($row_obra['nombre_obra'])){
			echo "<td></td>";
			echo "<td></td>";
			}
		else{
			echo "<td>".utf8_encode($row_obra['nombre_obra'])."</td>";
			echo "<td>".utf8_encode($row_obra['direcc_obra'])."</td>";
			}
		$tipo_obra = $row_ob_eq['tipo_oc'];
		if ($tipo_obra==0){
			echo "<td>ABIERTA</td>";
			}
		elseif ($tipo_obra==1){
			echo "<td>CERRADA</td>";
			}
		elseif ($tipo_obra==2){
			echo "<td>SIN O/C</td>";
			}
		elseif ($tipo_obra==3){
			echo "<td>PENDIENTE</td>";
			}
		else{
			echo "<td></td>";
			}
		$num_oc = $row_ob_eq['num_oc'];
		if ($num_oc==''){
			$num_oc = '';
			}
		echo "<td>".$num_oc."</td>";
		$fecha_inicio = $row_ob_eq['fecha_inicio'];
		if (($fecha_inicio=='')||($fecha_inicio=='0000-00-00')){
			$fecha_inicio='';
			echo "<td>".($fecha_inicio)."</td>";
			}
		else{
			echo "<td>".tranf_fecha_2($fecha_inicio)."</td>";
			}
		$fecha_vcmto = $row_ob_eq['fecha_vcmto'];
		if ($fecha_vcmto==''){
			echo "<td>".($fecha_vcmto)."</td>";
			}
		else{
			echo "<td>".tranf_fecha_2($fecha_vcmto)."</td>";			
			}
		$cod_equipo_inicial = $row_ob_eq['cod_equipo'];
		$sql_cei = "select nombre_equipo 
					from equipo	
					where cod_equipo = ".$cod_equipo_inicial;
		$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
		$row_cei = mysql_fetch_array($res_cei);
		echo "<td>".utf8_encode($row_cei['nombre_equipo'])."</td>";
		echo "<td>".$row_ob_eq['precio']."</td>";
		$sql_reclamo = "(select cod_reclamo 
													from equipos_arriendo 
													where num_gd = ".$row_ob_eq['num_gd'].")";
		$res_reclamo = mysql_query($sql_reclamo,$link) or die(mysql_error());
		$row_reclamo = mysql_fetch_array($res_reclamo);
		$cod_reclamo = $row_reclamo['cod_reclamo'];
		$sql_cod_reclamo = "select * 
							from reclamo
							where cod_equipo_dev = ".$row_ob_eq['cod_equipo']."
								and cod_reclamo = ".$cod_reclamo."
							limit 0,1";
		$res_cod_reclamo = mysql_query($sql_cod_reclamo,$link) or die(mysql_error());
		if (mysql_num_rows($res_cod_reclamo)==0){
			echo "<td></td>";
			}
		while ($row_cod_reclamo = mysql_fetch_array($res_cod_reclamo)){
			$temp = lineas_recursivas_1($row_cod_reclamo['cod_equipo_entreg'],$row_ob_eq['num_gd'],$row_cod_reclamo['cod_reclamo']);
			if ($temp!=0){
				$cod_equipo_inicial = $temp;
				}
			}
		$sql_bah = "select arrendado_hasta, hora_devol
					from equipos_arriendo
					where num_gd = ".$row_ob_eq['num_gd']."
						and cod_equipo = ".$cod_equipo_inicial."
					order by arrendado_hasta desc
					limit 0,1";
		$res_bah = mysql_query($sql_bah,$link) or die(mysql_error());
		$row_bah = mysql_fetch_array($res_bah);
		echo "<td>".tranf_fecha_2($row_bah['arrendado_hasta'])."</td>";

		if ($row_bah['hora_devol']=='00:00:00'){
			echo "<td></td>";
			}
		else{
			echo "<td>".$row_bah['hora_devol']."</td>";
			}
		$sql_arriendo = "select distinct cod_arriendo 
						from equipos_arriendo
						where num_gd = ".$row_ob_eq['num_gd']."";
		$res_arriendo = mysql_query($sql_arriendo,$link) or die(mysql_error());
		$row_arriendo = mysql_fetch_array($res_arriendo);
		$cod_arriendo = $row_arriendo['cod_arriendo'];
			
		$sql_precio = "select det_factura.dias_arriendo, det_factura.dias_ajuste, factura.fecha, factura.num_factura
						from det_factura
							inner join factura
								on det_factura.num_factura = factura.num_factura
						where factura.cod_arriendo = ".$cod_arriendo."
							and det_factura.cod_equipo = ".$cod_equipo_inicial."
						order by factura.fecha desc
						limit 0,1";
		$res_precio = mysql_query($sql_precio,$link) or die(mysql_error());
		$row_precio = mysql_fetch_array($res_precio);
		if ($row_precio['dias_ajuste']==''){
			echo "<td>0</td>";
			}
		else{
			echo "<td>".$row_precio['dias_ajuste']."</td>";
			}
		if ($row_precio['dias_arriendo']==''){
			echo "<td>0</td>";
			}
		else{
			echo "<td>".$row_precio['dias_arriendo']."</td>";
			}
		if ($row_precio['num_factura']==''){
			echo "<td></td>";
			}
		else{
			echo "<td>".$row_precio['num_factura']."</td>";
			}
		if ($row_precio['fecha']==''){
			echo "<td></td>";
			}
		else{
			echo "<td>".tranf_fecha_2($row_precio['fecha'])."</td>";
			}
		echo "</tr><tr>";
	}
	echo "</tr>";
?> 