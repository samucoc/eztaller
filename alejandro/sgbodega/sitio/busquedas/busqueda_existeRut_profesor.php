<?php



$q = strtolower($_GET['q']);

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../../includes/php/validaciones.php"; //validaciones



$data = array();



$sql = "SELECT * 

        FROM gescolcl_arcoiris_administracion.Profesores

        WHERE NumeroRutProfesor = '".$q."' 

            ";

$res = mysql_query($sql, $conexion);

$i=0; 

if (mysql_num_rows($res)>0){

	echo "Error";

	}   

else{

	echo "0";

	}    

?>