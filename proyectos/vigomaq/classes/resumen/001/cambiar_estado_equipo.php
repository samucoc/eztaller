<?php 

include('../conex.php');
$link=Conectarse();

//estado=OPERATIVO&cod_equipo=".$row_equipos['cod_equipo'].

$nombre_estado = $_GET['estado'];
$cod_equipo = $_GET['cod_equipo'];

$sql_cod_estado 	=	"	select cod_estado_equipo
							from estado_equipo
							where descripcion_estado = '".$nombre_estado."'";
$res_cod_estado 	=	mysql_query($sql_cod_estado,$link) or die(mysql_error());
$row_cod_estado		=	mysql_fetch_array($res_cod_estado);
$cod_estado_equipo	=	$row_cod_estado['cod_estado_equipo'];

$sql_update 	=	"update equipo
						set cod_estado_equipo = ".$cod_estado_equipo."
						where cod_equipo = ".$cod_equipo;
$res_update		=	mysql_query($sql_update,$link) or die(mysql_error());

header("Location: ../../menu.php");
?>	
