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

$sql_obtener_equipos ="SELECT det_gd.num_gd, fila_num_gd, cod_equipo, cantidad, porcentaje_vu, precio, det_gd.observaciones, accesorio, id_arriendo, cod_cliente, fecha, rut_cliente, cod_obra, orden_compra, cond_venta, hora_actual
						FROM  det_gd 
							inner join gd 
								on gd.num_gd = det_gd.num_gd
						where (gd.fecha between '".$inicio."' and '".$fin."'	
							and id_arriendo = 0)
							or (gd.fecha between '".$inicio."' and '".$fin."'	
							and id_arriendo is null
							)
						order by det_gd.num_gd asc";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
echo "<table id='warp_1'><tr>";
echo "<td>Nº Guía</td>";
echo "<td>Fecha Emision</td>";
echo "<td>Hora</td>";
echo "<td>Rut Empresa</td>";
echo "<td>Empresa</td>";
echo "<td>Obra</td>";
echo "<td>Direccion Obra</td>";
echo "<td>Tipo Orden Compra</td>";
echo "<td>Orden Compra</td>";
echo "<td>Cantidad</td>";
echo "<td>Detalle</td>";
echo "<td>Precio Unitario</td>";
echo "<td>Monto Total</td>";
echo "</tr>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
	echo "<tr>";
	echo "<td>".$row_ob_eq['num_gd']."</td>";
	echo "<td>".tranf_fecha_2($row_ob_eq['fecha'])."</td>";
	echo "<td>".$row_ob_eq['hora_actual']."</td>";
	echo "<td>".$row_ob_eq['rut_cliente']."</td>";
	$rut_cliente = $row_ob_eq['rut_cliente'];
	$sql_cliente = "select *
					from clientes
					where rut_cliente = '".$rut_cliente."'"; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	$row_cliente = mysql_fetch_array($res_cliente);
	echo "<td>".($row_cliente['raz_social'])."</td>";
	$cod_obra = $row_ob_eq['cod_obra'];
	$sql_obra = "select *
					from obra
					where cod_obra = ".$cod_obra; 
	$res_obra = mysql_query($sql_obra,$link) or die(mysql_error());
	$row_obra = mysql_fetch_array($res_obra);
	if (empty($row_obra['nombre_obra'])){
		echo "<td> </td>";
		echo "<td> </td>";
		}
	else{
		echo "<td>".($row_obra['nombre_obra'])."</td>";
		echo "<td>".($row_obra['direcc_obra'])."</td>";
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
		echo "<td>XXXX</td>";
		}
	$num_oc = $row_ob_eq['orden_compra'];
	if ($num_oc==''){
		$num_oc = 'XXX';
		}
	echo "<td>".$num_oc."</td>";
	
	echo "<td>".$row_ob_eq['cantidad']."</td>";
	echo "<td>".$row_ob_eq['observaciones']."</td>";
	echo "<td>".$row_ob_eq['precio']."</td>";
	echo "<td>".$row_ob_eq['cantidad']*$row_ob_eq['precio']."</td>";
	echo "</tr>";
	}
	echo "</table>";
?> 