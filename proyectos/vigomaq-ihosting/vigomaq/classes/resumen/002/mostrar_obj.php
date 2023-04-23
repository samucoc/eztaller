<style>
body {
	font:11px Verdana,Arial;
	position: relative;
	border-color: #FFF;
}
body select{
	font:11px Verdana,Arial;
	}
.floatLeft{
	float:left;
	padding:2px;
	height:30px;
	}

.floatRight{
	float:right;
	padding-left:5px;
	}
.clearBoth{
	clear:both;
	}
.diez{
	width:10%;
	}
.cuarto{
	width:30%;
	}
.tercio{
	width:35%;
	}
.mitad{
	width:50%;
	}
</style>
<?php 

$cod_estado_equipo= $_GET['cod_estado_equipo']; 
$id_tipo_equipo=$_GET['id_tipo_equipo'];


include('../../conex.php');
$link=Conectarse();

$sql_familias="select *
				from tipo_familia_equipo
				where id_tipo = $id_tipo_equipo
				";
$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
$row_familia = mysql_fetch_array($res_familia);
$sql_estados="select *
			from estado_equipo
		 	where cod_estado_equipo = $cod_estado_equipo";
$res_estados = mysql_query($sql_estados,$link) or die(mysql_error());
$row_estados = mysql_fetch_array($res_estados);
$nombre_estado = $row_estados['descripcion_estado'];
echo "
<div class='floatLeft diez'>Grupo Equipos	:</div><div class='floatLeft '>".$row_familia['nombre']."</div>
<br class='clearBoth'>
<div class='floatLeft diez'>Estado equipos 	:</div><div class='floatLeft '>".$row_estados['descripcion_estado']."</div>
<br class='clearBoth'>
<br class='clearBoth'>
<div class='floatLeft cuarto'>Equipos</div>";
//<div class='floatLeft cuarto'>Acciones</div>
echo "<br class='clearBoth'>
";

$sql_equipos = "select *
				from equipo
				where id_tipo_equipo = $id_tipo_equipo and cod_estado_equipo = $cod_estado_equipo";
$res_equipos = mysql_query($sql_equipos,$link) or die(mysql_error());
while ($row_equipos = mysql_fetch_array($res_equipos)){
	echo "<div class='floatLeft cuarto'>".utf8_encode($row_equipos['nombre_equipo'])."</div>";
/*	//OPERATIVO SERVICIO TECNICO ARRENDADO MANTENCION RESERVADO
	//Cambiar Estado(Combo) | Arrendar | Generar GD | Anular GD | Vender | Cambio/Devolucion | Eliminar Devolucion | Facturar						
	//echo $nombre_estado;
 	
	//operativo
	//arrendar | vender 
	if (rtrim($nombre_estado)=='OPERATIVOS'){
		echo "<div class='floatLeft tercio'>Arrendar | Vender</div>";
		}
	//Servicio Tecnico
	//Cambiar Estado | eliminar devolucion(si existe)
	elseif (rtrim($nombre_estado)=='SERVICIO TECNICO'){
		//eliminar devolucion
		//arriendo_no_devolver.php?cod_arr=12345 ---> nro de GD
		$sql_equipo_gd_004 = "select num_gd
							from equipos_arriendo
							where cod_equipo = ".$row_equipos['cod_equipo']." and estado_equipo_arr like 'DEVUELTO-NO FACTURADO'
							order by arrendado_desde desc, arrendado_hasta asc 
							limit 0,1	";
		$res_equipo_gd_004 = mysql_query($sql_equipo_gd_004,$link) or die(mysql_error());
		$row_equipo_gd_004 = mysql_fetch_array($res_equipo_gd_004);
		$num_gd_004 = $row_equipo_gd_004['num_gd'];
		echo "	<div class='floatLeft mitad'>
					<select name='cambiar_estado' id='cambiar_estado' onchange='cambio_select()'>
						<option value='OPERATIVOS&cod_equipo=".$row_equipos['cod_equipo']."'>OPERATIVO</option>
						<option value='ARRENDADOS&cod_equipo=".$row_equipos['cod_equipo']."'>ARRENDADO</option>
						<option value='MANTENCION&cod_equipo=".$row_equipos['cod_equipo']."'>MANTENCION</option>
						<option value='RESERVADO&cod_equipo=".$row_equipos['cod_equipo']."'>RESERVADO</option>
					</select>
					<a href='cambiar_estado_equipo.php' id='link_cambiar_estado' target='_top'>
						Cambiar Estado
					</a>
					";
		if (!empty($num_gd_004)){
			echo " || "	;			
			echo "		<a href='../../arriendo_no_devolver.php?cod_arr=".$num_gd_004."' class='eliminar_dev' target='_new'>
							Eliminar Devolucion
						</a> ";
			}
		echo "</div>";

		}
	//arrendado
	//eliminar gd | anular gd | cambio/devolucion | facturar
	elseif (rtrim($nombre_estado)=='ARRENDADOS'){
		//anular gd
		//anular_gd.php?num_gd=12345 ---> num de gd
		$sql_equipo_gd_001 = "select equipos_arriendo.num_gd
							from equipos_arriendo
								inner join arriendo
									on arriendo.cod_arriendo = equipos_arriendo.cod_arriendo
							where equipos_arriendo.cod_equipo = ".$row_equipos['cod_equipo']." 
								and equipos_arriendo.estado_equipo_arr in ('DEVUELTO-NO FACTURADO','NO DEVUELTO')
							order by equipos_arriendo.arrendado_desde desc, equipos_arriendo.arrendado_hasta asc 
							limit 0,1	";
		$res_equipo_gd_001 = mysql_query($sql_equipo_gd_001,$link) or die(mysql_error());
		$row_equipo_gd_001 = mysql_fetch_array($res_equipo_gd_001);
		$num_gd_001 = $row_equipo_gd_001['num_gd'];
		//cambio/devolucion
		//reclamo.php?id=123 --> nro de equipo
		$cod_equipo_002 = $row_equipos['cod_equipo'];
		//facturar
		//detalle_factura.php?codarr=192&equipo=469&cod_obra=226&num_gd=13363
		$sql_equipo_gd_003 = "select equipos_arriendo.num_gd, arriendo.cod_arriendo, arriendo.cod_obra
							from equipos_arriendo
								inner join arriendo
									on arriendo.cod_arriendo = equipos_arriendo.cod_arriendo
							where equipos_arriendo.cod_equipo = ".$row_equipos['cod_equipo']." 
								and equipos_arriendo.estado_equipo_arr in ('DEVUELTO-NO FACTURADO','NO DEVUELTO')
							order by equipos_arriendo.arrendado_desde desc, equipos_arriendo.arrendado_hasta asc 
							limit 0,1	";
		$res_equipo_gd_003 = mysql_query($sql_equipo_gd_003,$link) or die(mysql_error());
		$row_equipo_gd_003 = mysql_fetch_array($res_equipo_gd_003);
		$num_gd_003 = $row_equipo_gd_003['num_gd'];
		$cod_arriendo_003 = $row_equipo_gd_003['cod_arriendo'];
		$cod_obra_003 = $row_equipo_gd_003['cod_obra'];
		//eliminar devolucion
		//arriendo_no_devolver.php?cod_arr=12345 ---> nro de GD
		$sql_equipo_gd_004 = "select num_gd
							from equipos_arriendo
							where cod_equipo = ".$row_equipos['cod_equipo']." and estado_equipo_arr like 'DEVUELTO-NO FACTURADO'
							order by arrendado_desde desc, arrendado_hasta asc 
							limit 0,1	";
		$res_equipo_gd_004 = mysql_query($sql_equipo_gd_004,$link) or die(mysql_error());
		$row_equipo_gd_004 = mysql_fetch_array($res_equipo_gd_004);
		$num_gd_004 = $row_equipo_gd_004['num_gd'];
		echo "	<div class='floatLeft mitad'>";	
		if (!empty($num_gd_001)){
			echo "		<a href='../../eliminar_gd.php?num_gd=".$num_gd_001."' class='cambio' target='_new'>
							Eliminar GD
						</a> ";
			}
		echo " || ";
		if (!empty($num_gd_001)){
			echo "		<a href='../../anular_gd.php?num_gd=".$num_gd_001."' class='cambio' target='_new'>
							Anular GD
						</a> ";
			}
		echo " || ";
		if (!empty($cod_equipo_002)){
			echo "		<a href='../../reclamo.php?id=".$row_equipos['cod_equipo']."' class='cambio' target='_new'>
							Cambio-Devolucion
						</a> ";
			}
		echo " || ";
		if (!empty($num_gd_003)){
			echo "		<a href='../../detalle_factura.php?codarr=".$cod_arriendo_003."&equipo=".$row_equipos['cod_equipo']."&cod_obra=".$cod_obra_003."&num_gd=".$num_gd_003."' class='facturar' target='_new'>
							Facturar
						</a> ";
			}
		if (!empty($num_gd_004)){
			echo " || ";
			echo "		<a href='../../arriendo_no_devolver.php?cod_arr=".$num_gd_004."' class='eliminar_dev' target='_new'>
							Eliminar Devolucion
						</a> ";
			}
		echo "</div>";
		}
	//mantencion
	//Cambiar Estado | eliminar devolucion(si existe)
	elseif (rtrim($nombre_estado)=='MANTENCION'){
		//eliminar devolucion
		//arriendo_no_devolver.php?cod_arr=12345 ---> nro de GD
		$sql_equipo_gd_004 = "select num_gd
							from equipos_arriendo
							where cod_equipo = ".$row_equipos['cod_equipo']." and estado_equipo_arr like 'DEVUELTO-NO FACTURADO'
							order by arrendado_desde desc, arrendado_hasta asc 
							limit 0,1	";
		$res_equipo_gd_004 = mysql_query($sql_equipo_gd_004,$link) or die(mysql_error());
		$row_equipo_gd_004 = mysql_fetch_array($res_equipo_gd_004);
		$num_gd_004 = $row_equipo_gd_004['num_gd'];
		echo "	<div class='floatLeft mitad'>
					<select name='cambiar_estado' id='cambiar_estado' onchange='cambio_select()'>
						<option value='OPERATIVOS&cod_equipo=".$row_equipos['cod_equipo']."'>OPERATIVO</option>
						<option value='ARRENDADOS&cod_equipo=".$row_equipos['cod_equipo']."'>ARRENDADO</option>
						<option value='SERVICIO TECNICO&cod_equipo=".$row_equipos['cod_equipo']."'>SERVICIO TECNICO</option>
						<option value='RESERVADO&cod_equipo=".$row_equipos['cod_equipo']."'>RESERVADO</option>
					</select>
					<a href='cambiar_estado_equipo.php' id='link_cambiar_estado' target='_top'>
						Cambiar Estado
					</a>					";
		if (!empty($num_gd_004)){
			echo " || "	;			
			echo "		<a href='../../arriendo_no_devolver.php?cod_arr=".$num_gd_004."' class='eliminar_dev' target='_new'>
							Eliminar Devolucion
						</a> ";
			}
		echo "</div>";

		}
	//reservado
	//Cambiar Estado 
	elseif (rtrim($nombre_estado)=='RESERVADO'){
		echo "<div class='floatLeft tercio'>Cambiar Estado </div>";
		}
	
	*/	
	echo "<br class='clearBoth'>";
	}

?>
<script>
	function cambio_select() { 
		var select_value = document.getElementById("cambiar_estado").value;
		document.getElementById("link_cambiar_estado").href = 'cambiar_estado_equipo.php?estado='+select_value;
	}
</script>