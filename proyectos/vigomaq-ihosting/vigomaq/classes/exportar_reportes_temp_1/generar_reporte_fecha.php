<style>
#warp_1{
	width:2400px;
	}
.floatLeft{
	float:left;
	font-size:8px;
	width:100px;
	}
.floatRight{
	float:right;
	}
.clearFloat{
	clear:both;
	}
</style>
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

function lineas_recursivas_1($cod_equipo_entreg,$num_gd,$cod_reclamo){
	$link = Conectarse();
	$sql_obtener_equipos_1 ="SELECT distinct det_gd.num_gd, arriendo.fecha_arr, arriendo.hora_arr, 
										arriendo.rut_cliente, arriendo.cod_obra, arriendo.tipo_oc, 
										arriendo.fecha_inicio, arriendo.fecha_vcmto, equipos_arriendo.cod_equipo,
										det_gd.precio
							FROM  `arriendo` 
								INNER JOIN equipos_arriendo 
									ON equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
								INNER JOIN det_gd 
									ON det_gd.num_gd = equipos_arriendo.num_gd
							where equipos_arriendo.cod_equipo = ".$cod_equipo_entreg."
								and equipos_arriendo.num_gd = ".$num_gd."
								and arriendo.fecha_arr between '".$inicio."' and '".$fin."'
							ORDER BY equipos_arriendo.num_gd, det_gd.cod_equipo";
	$res_ob_eq_1 = mysql_query($sql_obtener_equipos_1,$link) or die(mysql_error());
	while($row_ob_eq_1 = mysql_fetch_array($res_ob_eq_1)){
		$sql_cod_reclamo_1 = "select * 
							from reclamo
							where cod_equipo_dev = ".$row_ob_eq_1['cod_equipo']."
								and cod_reclamo = ".$cod_reclamo;
		$res_cod_reclamo_1 = mysql_query($sql_cod_reclamo_1,$link) or die(mysql_error());
		echo "<br class='clearFloat'/>";
		echo "<div class='floatLeft'>".$row_ob_eq_1['num_gd']."</div>";
		echo "<div class='floatLeft'>".$row_ob_eq_1['fecha_arr']."</div>";
		echo "<div class='floatLeft'>".$row_ob_eq_1['fecha_arr']."</div>";
		echo "<div class='floatLeft'>".$row_ob_eq_1['hora_arr']."</div>";
		echo "<div class='floatLeft'>".$row_ob_eq_1['rut_cliente']."</div>";
		$rut_cliente_1 = $row_ob_eq_1['rut_cliente'];
		$sql_cliente_1 = "select *
						from clientes
						where rut_cliente = '".$rut_cliente_1."'"; 
		$res_cliente_1 = mysql_query($sql_cliente_1,$link) or die(mysql_error());
		while ($row_cliente_1 = mysql_fetch_array($res_cliente_1)){
			echo "<div class='floatLeft'>".$row_cliente_1['raz_social']."</div>";
			}
		$cod_obra_1 = $row_ob_eq_1['cod_obra'];
		$sql_obra_1 = "select *
						from obra
						where cod_obra = ".$cod_obra_1; 
		$res_obra_1 = mysql_query($sql_obra_1,$link) or die(mysql_error());
		while ($row_obra_1 = mysql_fetch_array($res_obra_1)){
			echo "<div class='floatLeft'>".$row_obra_1['nombre_obra']."</div>";
			echo "<div class='floatLeft'>".$row_obra_1['direcc_obra']."</div>";
			}
		$tipo_obra = $row_ob_eq_1['tipo_oc'];
		if ($tipo_obra==0){
			echo "<div class='floatLeft'>ABIERTA</div>";
			}
		elseif ($tipo_obra==1){
			echo "<div class='floatLeft'>CERRADA</div>";
			}
		elseif ($tipo_obra==2){
			echo "<div class='floatLeft'>SIN O/C</div>";
			}
		elseif ($tipo_obra==3){
			echo "<div class='floatLeft'>PENDIENTE</div>";
			}
		$num_oc = $row_ob_eq_1['num_oc'];
		if ($num_oc==''){
			$num_oc = '';
			}
		echo "<div class='floatLeft'>".$num_oc."</div>";
		$fecha_inicio = $row_ob_eq_1['fecha_inicio'];
		if ($fecha_inicio==''){
			$fecha_inicio = '0000-00-00';
			}
		echo "<div class='floatLeft'>".$fecha_inicio."</div>";
		$fecha_vcmto = $row_ob_eq_1['fecha_vcmto'];
		if ($fecha_vcmto==''){
			$fecha_vcmto = '0000-00-00';
			}
		echo "<div class='floatLeft'>".$fecha_vcmto."</div>";
		$cod_equipo_inicial_1 = $row_ob_eq_1['cod_equipo'];
		$sql_cei_1 = "select nombre_equipo 
					from equipo	
					where cod_equipo = ".$cod_equipo_inicial_1;
		$res_cei_1 = mysql_query($sql_cei_1,$link) or die(mysql_error());
		$row_cei_1 = mysql_fetch_array($res_cei_1);
		echo "<div class='floatLeft'>".utf8_encode($row_cei_1['nombre_equipo'])."</div>";
		echo "<div class='floatLeft'>".$row_ob_eq_1['precio']."</div>";
		if (mysql_num_rows($res_cod_reclamo_1)==0){
			echo "<div class='floatLeft'></div>";
			}
		else{
			while ($row_cod_reclamo_1 = mysql_fetch_array($res_cod_reclamo_1)){
				$cod_equipo_final_1 = $row_cod_reclamo_1['cod_equipo_entreg'];
				$sql_cei_1 = "select nombre_equipo 
							from equipo	
							where cod_equipo = ".$cod_equipo_final_1;
				$res_cei_1 = mysql_query($sql_cei_1,$link) or die(mysql_error());
				$row_cei_1 = mysql_fetch_array($res_cei_1);
				echo "<div class='floatLeft'>".utf8_encode($row_cei_1['nombre_equipo'])."</div>";
				lineas_recursivas_1($row_cod_reclamo_1['cod_equipo_entreg'],$row_ob_eq_1['num_gd'], $row_cod_reclamo_1['cod_reclamo']);
				}
			}
		}
	}


$sql_obtener_equipos ="SELECT distinct det_gd.num_gd, arriendo.fecha_arr, arriendo.hora_arr, 
									arriendo.rut_cliente, arriendo.cod_obra, arriendo.tipo_oc, 
									arriendo.fecha_inicio, arriendo.fecha_vcmto, det_gd.cod_equipo,
									det_gd.precio
						FROM  `arriendo` 
							INNER JOIN equipos_arriendo 
								ON equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
							INNER JOIN det_gd 
								ON det_gd.num_gd = equipos_arriendo.num_gd
						where arriendo.fecha_arr between '".$inicio."' and '".$fin."'
						ORDER BY equipos_arriendo.num_gd, det_gd.cod_equipo";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
echo "<div id='warp_1'>";
echo "<div class='floatLeft'>Nº Guía</div>";
echo "<div class='floatLeft'>Fecha Emision</div>";
echo "<div class='floatLeft'>Fecha Arriendo</div>";
echo "<div class='floatLeft'>Hora</div>";
echo "<div class='floatLeft'>Rut Empresa</div>";
echo "<div class='floatLeft'>Empresa</div>";
echo "<div class='floatLeft'>Obra</div>";
echo "<div class='floatLeft'>Direccion Obra</div>";
echo "<div class='floatLeft'>Tipo Orden Compra</div>";
echo "<div class='floatLeft'>Orden Compra</div>";
echo "<div class='floatLeft'>Fecha O/C</div>";
echo "<div class='floatLeft'>Fecha Vencimiento O/C</div>";
echo "<div class='floatLeft'>Equipo Arrendado</div>";
echo "<div class='floatLeft'>Tarifa</div>";
echo "<div class='floatLeft'>Equipo Cambio</div>";
echo "<div class='floatLeft'>Fecha Devolucion</div>";
echo "<div class='floatLeft'>Hora Devolucion</div>";
echo "<div class='floatLeft'>Total Dias Ajuste</div>";
echo "<div class='floatLeft'>Total Días Arr. Cobrados</div>";
echo "<div class='floatLeft'>Ultima factura Asociada</div>";
echo "<div class='floatLeft'>Fecha Ultima Factura</div>";
echo "<br class='clearFloat'/>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
	$sql_cod_reclamo = "select * 
						from reclamo
						where cod_equipo_dev = ".$row_ob_eq['cod_equipo']."
							and cod_reclamo in (select cod_reclamo 
												from equipos_arriendo 
												where num_gd = ".$row_ob_eq['num_gd'].")";
	$res_cod_reclamo = mysql_query($sql_cod_reclamo,$link) or die(mysql_error());
	echo "<div class='floatLeft'>".$row_ob_eq['num_gd']."</div>";
	echo "<div class='floatLeft'>".$row_ob_eq['fecha_arr']."</div>";
	echo "<div class='floatLeft'>".$row_ob_eq['fecha_arr']."</div>";
	echo "<div class='floatLeft'>".$row_ob_eq['hora_arr']."</div>";
	echo "<div class='floatLeft'>".$row_ob_eq['rut_cliente']."</div>";
	$rut_cliente = $row_ob_eq['rut_cliente'];
	$sql_cliente = "select *
					from clientes
					where rut_cliente = '".$rut_cliente."'"; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<div class='floatLeft'>".utf8_encode($row_cliente['raz_social'])."</div>";
		}
	$cod_obra = $row_ob_eq['cod_obra'];
	$sql_obra = "select *
					from obra
					where cod_obra = ".$cod_obra; 
	$res_obra = mysql_query($sql_obra,$link) or die(mysql_error());
	while ($row_obra = mysql_fetch_array($res_obra)){
		echo "<div class='floatLeft'>".utf8_encode($row_obra['nombre_obra'])."</div>";
		echo "<div class='floatLeft'>".utf8_encode($row_obra['direcc_obra'])."</div>";
		}
	$tipo_obra = $row_ob_eq['tipo_oc'];
	if ($tipo_obra==0){
		echo "<div class='floatLeft'>ABIERTA</div>";
		}
	elseif ($tipo_obra==1){
		echo "<div class='floatLeft'>CERRADA</div>";
		}
	elseif ($tipo_obra==2){
		echo "<div class='floatLeft'>SIN O/C</div>";
		}
	elseif ($tipo_obra==3){
		echo "<div class='floatLeft'>PENDIENTE</div>";
		}
	$num_oc = $row_ob_eq['num_oc'];
	if ($num_oc==''){
		$num_oc = '';
		}
	echo "<div class='floatLeft'>".$num_oc."</div>";
	$fecha_inicio = $row_ob_eq['fecha_inicio'];
	if ($fecha_inicio==''){
		$fecha_inicio = '0000-00-00';
		}
	echo "<div class='floatLeft'>".$fecha_inicio."</div>";
	$fecha_vcmto = $row_ob_eq['fecha_vcmto'];
	if ($fecha_vcmto==''){
		$fecha_vcmto = '0000-00-00';
		}
	echo "<div class='floatLeft'>".$fecha_vcmto."</div>";
	$cod_equipo_inicial = $row_ob_eq['cod_equipo'];
	$sql_cei = "select nombre_equipo 
				from equipo	
				where cod_equipo = ".$cod_equipo_inicial;
	$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
	$row_cei = mysql_fetch_array($res_cei);
	echo "<div class='floatLeft'>".utf8_encode($row_cei['nombre_equipo'])."</div>";
	echo "<div class='floatLeft'>".$row_ob_eq['precio']."</div>";
	if (mysql_num_rows($res_cod_reclamo)==0){
		echo "<div class='floatLeft'></div>";
		}
	while ($row_cod_reclamo = mysql_fetch_array($res_cod_reclamo)){
		$cod_equipo_final = $row_cod_reclamo['cod_equipo_entreg'];
		$sql_cei = "select nombre_equipo 
					from equipo	
					where cod_equipo = ".$cod_equipo_final;
		$res_cei = mysql_query($sql_cei,$link) or die(mysql_error());
		$row_cei = mysql_fetch_array($res_cei);
		echo "<div class='floatLeft'>".utf8_encode($row_cei['nombre_equipo'])."</div>";
		lineas_recursivas_1($row_cod_reclamo['cod_equipo_entreg'],$row_ob_eq['num_gd'],$row_cod_reclamo['cod_reclamo']);
		}
	$sql_bah = "select arrendado_hasta, hora_devol
				from equipos_arriendo
				where num_gd = ".$row_ob_eq['num_gd']."
					and cod_equipo = ".$cod_equipo_inicial."
				order by arrendado_hasta desc
				limit 0,1";
	$res_bah = mysql_query($sql_bah,$link) or die(mysql_error());
	$row_bah = mysql_fetch_array($res_bah);
	echo "<div class='floatLeft'>".$row_bah['arrendado_hasta']."</div>";
	echo "<div class='floatLeft'>".$row_bah['hora_devol']."</div>";
	
	$sql_precio = "select det_factura.dias_arriendo, det_factura.dias_ajuste, factura.fecha, factura.num_factura
					from det_factura
						inner join factura
							on det_factura.num_factura = factura.num_factura
					where factura.cod_arriendo in (select distinct cod_arriendo 
											from equipos_arriendo
											where num_gd = ".$row_ob_eq['num_gd'].")
						and det_factura.cod_equipo = ".$cod_equipo_inicial."
					order by factura.fecha desc
					limit 0,1";
	$res_precio = mysql_query($sql_precio,$link) or die(mysql_error());
	$row_precio = mysql_fetch_array($res_precio);
	if ($row_precio['dias_ajuste']==''){
		echo "<div class='floatLeft'>0</div>";
		}
	else{
		echo "<div class='floatLeft'>".$row_precio['dias_ajuste']."</div>";
		}
	if ($row_precio['dias_arriendo']==''){
		echo "<div class='floatLeft'>0</div>";
		}
	else{
		echo "<div class='floatLeft'>".$row_precio['dias_arriendo']."</div>";
		}
	if ($row_precio['fecha']==''){
		echo "<div class='floatLeft'>0000-00-00</div>";
		}
	else{
		echo "<div class='floatLeft'>".$row_precio['fecha']."</div>";
		}
	if ($row_precio['num_factura']==''){
		echo "<div class='floatLeft'></div>";
		}
	else{
		echo "<div class='floatLeft'>".$row_precio['num_factura']."</div>";
		}
	echo "<br class='clearFloat'/>";
	}
	echo "</div>";
?> 