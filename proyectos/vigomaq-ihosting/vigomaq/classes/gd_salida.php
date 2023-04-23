<?php

/* RECEIVE VALUE */
$validateValue=$_GET['fieldValue'];
$validateId=$_GET['fieldId'];

	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;

include("../conex.php");
$link = Conectarse();

$sql = "select num_gd 
		from gd 
		where num_gd = '$validateValue' 
		";
$res = mysql_query($sql,$link);
if (mysql_num_rows($res)>0){
	$arrayToJs[1] = false;
	}
else{
	$arrayToJs[1] = true;			// RETURN TRUE
	}

echo json_encode($arrayToJs);			// RETURN ARRAY 
?>