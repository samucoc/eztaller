<?php 
$enlace = $_GET['nombre_archivo'].'.txt';
header ("Content-Disposition: attachment; filename=".$enlace." ");
header('Content-Type: text/plain', true);
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
?>