<?php
include("../conex.php");
		$link=Conectarse();
$nro_fact = $_GET['nro_fact'];
$sql = "SELECT estado
	FROM factura
	WHERE factura.num_factura = '".$nro_fact."'";

//id_cliente='+id_cliente+'&cant_dias='+cant_dias+'&todas='+todas,
$res=mysql_query($sql,$link) or die(mysql_error());
if(mysql_num_rows($res)>0){
	$row = mysql_fetch_array($res);
	echo $row['estado']; 
	}
else{
	echo "Factura no Existe";
}
?>

