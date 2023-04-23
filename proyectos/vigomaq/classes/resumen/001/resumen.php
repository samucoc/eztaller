<?php 

$sql_familias="select *
				from tipo_familia_equipo";
$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
while ($row_familia = mysql_fetch_array($res_familia)){
	echo "<div class='floatLeft diez fondo'>".$row_familia['nombre']."</div>";
	$id_familia = $row_familia['id_tipo'];
	$sql_estados="select *
				from estado_equipo
				where activado = 1
				order by nivel asc";
	$res_estados = mysql_query($sql_estados,$link) or die(mysql_error());
	while($row_estados = mysql_fetch_array($res_estados)){
		$sql_equipos_estados = "SELECT COUNT( cod_estado_equipo )  AS cont_equipo, 
											cod_estado_equipo, id_tipo_equipo
								FROM equipo
								WHERE cod_estado_equipo = '".$row_estados['cod_estado_equipo']."'
									and id_tipo_equipo = '".$id_familia."'
								GROUP BY cod_estado_equipo, id_tipo_equipo";
		$respuesta_equipo_estados = mysql_query($sql_equipos_estados,$link) or die(mysql_error());
		if (mysql_num_rows($respuesta_equipo_estados)==0){
			echo "<div class='floatLeft diez fondo'>0</div>";
			}
		while ($row_03 = mysql_fetch_array($respuesta_equipo_estados)){
			echo "<a title='Vigomaq ".date("Y")."' class='link_resumen' href='classes/resumen/mostrar_obj.php?cod_estado_equipo=".$row_estados['cod_estado_equipo']."&id_tipo_equipo=".$id_familia."'><div class='floatLeft diez fondo'>".$row_03['cont_equipo']."</div></a>";
			}
		}
	echo "<br class='clearFloat fondo'/>";
	}
?>