<?php 
include("conex.php");
$link=Conectarse();

//colocar estados
$sql_estados="select *
				from estado_equipo";
$res_estados = mysql_query($sql_estados,$link) or die(mysql_error());

echo "<div class='floatLeft diez Estilo17 titulo'>Familia de equipos</div>";
while($row_estados = mysql_fetch_array($res_estados)){
	echo "<div class='floatLeft diez Estilo17 titulo'>".utf8_encode($row_estados['descripcion_estado'])."</div>";
	}
echo "<br class='clearFloat fondo'/>";

?>