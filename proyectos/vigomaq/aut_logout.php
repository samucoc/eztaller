<?php 
ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<?php

$_SESSION = array();
    unset($_COOKIE[session_name()]);
    session_destroy();
    echo "logging out...";
	header("replace.location:login.php");

?>
<html>
<head>
<title>Area de Administración de Vigomaq</title>
<meta http-equiv="Refresh" content="0; url=http://vigomaq-old.gescol.cl/login.php">
<link rel="shortcut icon" href="http://vigomaq-old.gescol.cl/favicon.ico">
</head>
</html>
