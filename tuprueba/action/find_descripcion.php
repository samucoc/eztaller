<?php	
    include_once "../config/config.php";//Contiene funcion que conecta a la base de datos
    global $con;
	session_start();
	$q = $_GET['codigo'];

	$query=mysqli_query($con,"select descricpion from productos where codigo = '".$q."'");
    while ($row=mysqli_fetch_array($query)) {
    	echo $row['descricpion'];
    }

?>