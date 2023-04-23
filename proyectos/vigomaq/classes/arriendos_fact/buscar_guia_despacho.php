<?php

include("../../conex.php");
include("../array_to_json.php");

$link = Conectarse();
$q = strtolower($_GET["term"]); //termino a buscar
if (!$q) return;

$items = array(); // se crea un array a guardar

$sql = "select distinct equipos_arriendo.num_gd 
		FROM equipos_arriendo
			inner join gd
				on gd.num_gd  = equipos_arriendo.num_gd 
		WHERE (equipos_arriendo.estado_equipo_arr like '%NO FACTURADO' and equipos_arriendo.num_gd like '$q%')  or 
			(equipos_arriendo.num_gd like '$q%' and equipos_arriendo.estado_equipo_arr = 'NO DEVUELTO')
		order by num_gd 
		limit 0,25
		";
$res = mysql_query($sql,$link);
$i=0;
while ($row = mysql_fetch_array($res)){
	$items[$i] = $row['num_gd']; //guardo resultados en el array
	$i++;
	}

$result = array();
foreach ($items as $value) {
		array_push($result, array("id"=>$value, "label"=>$value, "value" => strip_tags($value))); 
		//transformo array para construir json
	}
echo array_to_json($result); //convierto array en json

?>