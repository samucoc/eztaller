<?php
	session_start();
	if (isset($_SESSION['autentificado'])){
		unset($_SESSION['autentificado']);
		unset($_SESSION['usuario']);
	}
	
	//header("Location:http://www.siinve.cl/ve/sitio");
	//header("Location:http://www.siinve.cl/");
	header("Location:http://192.168.0.116/ve/sitio");
	
?>
