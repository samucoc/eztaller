<?php
ini_set('display_errors', 1); 
//error_reporting(E_ALL);
error_reporting( error_reporting() & ~E_NOTICE  & ~E_WARNING );

//coneccion local bd en mysql
$servidor = "localhost";
$usuario = "root";
$pass = "";
//$pass = "";
$bd = "eztaller_tubodega";

/*
$servidor = "localhost";
$usuario = "cyonley_vehusu";
$pass = "vehusu";
$bd = "cyonley_vehiculos";
*/

date_default_timezone_set('America/Santiago');

$conexion = mysqli_connect($servidor, $usuario, $pass);
mysqli_select_db($conexion,$bd);


if (!function_exists('mysql_connect')) {
	function mysql_connect($host, $username, $password, $db) {
	    return mysqli_connect($host, $username, $password, $db);
	}

	function mysql_select_db($db,$link) {
		return(mysqli_select_db($link,$db));
	}

	function mysql_query($query,$link=false) {
		if($link==false) {
			$link=mysqli_connect("localhost","root","","eztaller_tubodega"); 
			mysqli_select_db($link,"eztaller_tubodega"); 
		}
		return(mysqli_query($link,$query));
	}

	function mysql_error($link) {
		return(mysqli_error($link));
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
