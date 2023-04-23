<?php

include("../conex.php");
include("../array_to_json.php");

$link = Conectarse();
$q = strtolower($_GET["term"]); //termino a buscar
if (!$q) return;

$items = array(); // se crea un array a guardar

$sql = "select distinct rut_cliente 
			from clientes
			where rut_cliente like '$q%'
		limit 0,25
		";
$res = mysql_query($sql,$link);
$i=0;
while ($row = mysql_fetch_array($res)){
	$items[$i] = $row['rut_cliente']; //guardo resultados en el array
	$i++;
	}

$result = array();
foreach ($items as $value) {
		array_push($result, array("id"=>$value, "label"=>$value, "value" => strip_tags($value))); 
		//transformo array para construir json
	}
echo array_to_json($result); //convierto array en json

?>