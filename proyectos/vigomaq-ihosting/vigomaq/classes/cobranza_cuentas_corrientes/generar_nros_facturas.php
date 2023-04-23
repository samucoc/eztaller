
<?php 

include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total , sum(total_rep) as total_1, oc_rep, estado, valor_iva
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura
	where factura.num_factura in (".$_GET['facturas'].")
	group by num_factura";
$res=mysql_query($sql,$link) or die(mysql_error());
    $total_facturas = '';

while ($row =mysql_fetch_array($res)){

	$total_facturas .= ','.$row['num_factura'];
	}

echo substr($total_facturas,1); 
?>