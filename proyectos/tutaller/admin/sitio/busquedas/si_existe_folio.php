<?php

$q = strtolower($_GET['folio']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM sgcopec.orden_trabajo
        WHERE `folio` = '".$q."'";
$res = mysql_query($sql, $conexion);
$i=0;        
if (mysql_num_rows($res)>0){
	echo "Folio ocupado";
}
else{
	echo "";
}
?>
