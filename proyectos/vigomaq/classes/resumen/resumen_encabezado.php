<?php 
include('classes/conex.php');
$link=Conectarse();

$sql_estados="select *
				from estado_equipo
				where activado = 1
				order by nivel asc";
$res_estados = mysql_query($sql_estados,$link) or die(mysql_error());
//echo "Resolución Sugerida : 1280x800";
//echo "<br class='clearFloat fondo'/>";
echo "<br class='clearFloat fondo'/>";
echo "<div class='floatLeft diez Estilo17 titulo'>Familia de equipos</div>";
while($row_estados = mysql_fetch_array($res_estados)){
	echo "<div class='floatLeft diez Estilo17 titulo'>".utf8_encode($row_estados['descripcion_estado'])."</div>";
	}
echo "<br class='clearFloat fondo'/>";

?>