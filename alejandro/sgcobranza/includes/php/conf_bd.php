<?php
ini_set('display_errors', 1); 
//error_reporting(E_ALL);
error_reporting( error_reporting() & ~E_NOTICE  & ~E_WARNING );

////coneccion local bd en mysql
//$servidor = "localhost";
//$usuario = "root";
//$pass = "admin.,240177";
////$pass = "";
//$bd = "sgreloj";

$servidor= "186.67.71.229";
$usuario = "gescolcl";
//$pass = "admin.,240177";
//$pass 		= "";
$pass 		= "Q0.h=t61Zw&L538S";
$bd		= "gescolcl_arcoiris_cobranza";

/*
$servidor = "localhost";
$usuario = "cyonley_vehusu";
$pass = "vehusu";
$bd = "cyonley_vehiculos";
*/


$conexion = mysqli_connect($servidor, $usuario, $pass);
mysqli_select_db($conexion,$bd);
date_default_timezone_set("America/Santiago");
set_time_limit(0);

ini_set('default_charset', 'utf-8');
$conexion->set_charset("utf8");


if (!function_exists('mysql_connect')) {
	function mysql_connect($host, $username, $password, $db) {
	    return mysqli_connect($host, $username, $password, $db);
	}

	function mysql_select_db($db,$link) {
		return(mysqli_select_db($link,$db));
	}

	function mysql_query($query,$link=false) {
		if($link==false) {
			$link=mysqli_connect("186.67.71.229","gescolcl","Q0.h=t61Zw&L538S","gescolcl_arcoiris_cobranza"); 
			mysqli_select_db($link,"gescolcl_arcoiris_cobranza"); 
		}
		return(mysqli_query($link,$query));
	}

	function mysql_error() {
		return(mysqli_error());
	}

	function mysql_errno($conexion) {
		return(mysqli_errno($conexion));
	}

	function mysql_fetch_array($res) {
		return(mysqli_fetch_array($res));
	}

	function mysql_fetch_assoc($res) {
		return(mysqli_fetch_assoc($res));
	}

	function mysql_free_result($l) {
		return(mysqli_free_result($l));
	}

	function mysql_close($l) {
		if(!isset($l)) return(false);
		return(mysqli_close($l));
	}

	function mysql_num_rows($res) {
		return(mysqli_num_rows($res));
	}

	function mysql_fetch_row($res) {
		return(mysqli_fetch_row($res));
	}

	function mysql_result($res, $row, $field=0) { 
	    $res->data_seek($row); 
	    $datarow = $res->fetch_array(); 
	    return $datarow[$field]; 
	}

	function split($exp,$arr){
		return preg_split($exp,$arr);
	}
}

?>
