<?php 

//colocar familias
$sql_familias="select *
				from tipo_familia_equipo";
$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
while ($row_familia = mysql_fetch_array($res_familia)){
	echo "<div class='floatLeft diez fondo'>".$row_familia['nombre']."</div>";
	$id_familia = $row_familia['id_tipo'];
	$sql_estados="select *
				from estado_equipo";
	$res_estados = mysql_query($sql_estados,$link) or die(mysql_error());
	while($row_estados = mysql_fetch_array($res_estados)){
		$sql_equipos_estados = "select count(cod_estado_equipo) as cont_equipo, cod_estado_equipo
									from equipo
									where cod_estado_equipo = '".$row_estados['cod_estado_equipo']."'
										and id_tipo_equipo = '".$id_familia."'
									order by cod_estado_equipo ";
		$respuesta_equipo_estados = mysql_query($sql_equipos_estados,$link) or die(mysql_error());
		while ($row_03 = mysql_fetch_array($respuesta_equipo_estados)){
			//echo "<a title='Vigomaq 2012' class='link_resumen' href='classes/resumen/mostrar_obj.php?cod_estado_equipo=".$row_estados['cod_estado_equipo']."&id_tipo_equipo=".$id_familia."'><div class='floatLeft diez fondo'>".$row_03['cont_equipo']."</div></a>";
			echo "<div class='floatLeft diez fondo'>".$row_03['cont_equipo']."</div>";
			}
		}
	echo "<br class='clearFloat fondo'/>";
	}
?>