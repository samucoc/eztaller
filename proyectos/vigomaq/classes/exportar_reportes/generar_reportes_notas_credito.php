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
						FROM nota_credito 
						where fecha between '".$inicio."' and '".$fin."'	 
						order by num_nota_cred asc";
$res_ob_eq = mysql_query($sql_obtener_equipos,$link) or die(mysql_error());
echo "<table id='warp_1'><tr>";
echo "<td>Nº NC</td>";
echo "<td>Fecha Emision</td>";
echo "<td>Cliente</td>";
echo "<td>Factura Asociada</td>";
echo "<td>Monto</td>";
echo "<td>Descripcion</td>";
echo "</tr>";

while($row_ob_eq = mysql_fetch_array($res_ob_eq)){
	echo "<tr>";
	echo "<td>".$row_ob_eq['num_nota_cred']."</td>";
	echo "<td>".$row_ob_eq['fecha']."</td>";
	$rut_cliente = $row_ob_eq['cod_cliente'];
		$sql_cliente = "select *
						from clientes
						where cod_cliente = '".$rut_cliente."'"; 
		$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
		$row_cliente = mysql_fetch_array($res_cliente);
	echo "<td>".$row_cliente['raz_social']."</td>";
	echo "<td>".$row_ob_eq['num_factura']."</td>";
	
	$sql_001 = "SELECT * FROM `det_nc` where num_nc = '".$row_ob_eq['num_nota_cred']."'";
	$res_001 = mysql_query($sql_001,$link);
	$row_001 = mysql_fetch_array($res_001);

	echo "<td>".$row_001['monto']."</td>";
	echo "<td>".$row_001['referencias']."</td>";

	echo "</tr>";
	}
	echo "</table>";
?> 