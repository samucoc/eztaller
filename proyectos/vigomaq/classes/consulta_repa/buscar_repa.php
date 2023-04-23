<?php

include("../conex.php");
include("../array_to_json.php");

$link = Conectarse();
$q = strtolower($_GET["term"]); //termino a buscar
if (!$q) return;

$items = array(); // se crea un array a guardar

$sql = "select cod_equipo, nombre_equipo
		FROM  equipo
		WHERE (nombre_equipo like '%$q%')
		order by nombre_equipo
		limit 0,10
		";
$res = mysql_query($sql,$link);
$i=0;
while ($row = mysql_fetch_array($res)){
	$temp = utf8_encode($row['nombre_equipo']);
	$temp = str_replace(
			array("\\", "¨", "~",
             "#", "@", "|", "!", 
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":",
             "."),
			'',
			$temp);
	$items[$i][0] = $row['cod_equipo']; //guardo resultados en el array
	$items[$i][1] = $temp; //guardo resultados en el array
	$i++;
	}

$result = array();
foreach ($items as $value) {
	array_push($result, array("id"=>($value[0]), "label"=>($value[1]), "value" => strip_tags(($value[1])))); 
		//transformo array para construir json
	}
echo array_to_json($result); //convierto array en json

?>