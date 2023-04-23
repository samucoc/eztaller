<?php
include("../conex.php");
		$link=Conectarse();
$nro_fact = $_GET['nro_fact'];
$sql = "SELECT cod_cliente, cod_arriendo
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura
	WHERE estado = 'PROCESO_DISTRIBUCION' and factura.num_factura = '".$nro_fact."'";

//id_cliente='+id_cliente+'&cant_dias='+cant_dias+'&todas='+todas,
$res=mysql_query($sql,$link) or die(mysql_error());
if(mysql_num_rows($res)>0){
	$registro = mysql_fetch_array($res);

	$query = "select distinct clientes.raz_social
			from arriendo
				inner join clientes
					on arriendo.rut_cliente = clientes.rut_cliente
			where arriendo.cod_arriendo = ".$registro['cod_arriendo']."";
	$result=mysql_query($query,$link) or die(mysql_error()); 
	if (mysql_num_rows($result)==0){
		$query = "select distinct clientes.raz_social
				from clientes
			 where clientes.cod_cliente = ".$registro['cod_cliente']."";
		$result=mysql_query($query,$link) or die(mysql_error()); 
		}
	$row = mysql_fetch_array($result); 
	echo $row['raz_social']; 
	}
else{
	$sql = "SELECT cod_cliente, cod_arriendo
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura
	WHERE factura.num_factura = '".$nro_fact."'";
	$res=mysql_query($sql,$link) or die(mysql_error());
	if(mysql_num_rows($res)>0){		
		$sql = "select estado
			from factura
			where factura.num_factura = '".$nro_fact."'";
		$res = mysql_query($sql,$link) or die(mysql_error());
		$row = mysql_fetch_array($res);
		
		if ($row['estado']=='CERRADA'){
			echo "Factura emitida y no entregada";
			}
		else{
			echo "Factura 4° copia recepcionada";
			}
		}
	else{
		echo "Factura no Existe";
	}
}
?>

