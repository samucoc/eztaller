<?php 
include("../../conex.php");
$link = Conectarse();

$fecha_inicio = $_GET['inicio'];
$fecha_temp = explode("-",$fecha_inicio);
//dia-mes-año
//0 -> dia, 1 -> mes, 2 -> año
$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
$fecha_inicio = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

$fecha_fin = $_GET['fin'];
$fecha_temp = explode("-",$fecha_fin);
//dia-mes-año
//0 -> dia, 1 -> mes, 2 -> año
$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
$fecha_fin = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

$sql_eq_no_dev = "
		select distinct equipos_arriendo.num_gd
		from equipos_arriendo
		where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."'
			and equipos_arriendo.estado_equipo_arr = 'DEVUELTO-NO FACTURADO'
		order by equipos_arriendo.num_gd
		 ";
$res_eq_no_dev = mysql_query($sql_eq_no_dev,$link) or die();
?>
<div class="floatLeft cod_arriendo">
	Guia de Despacho
</div>
<div class="floatLeft cod_equipo">
	Empresa
</div>
<div class="floatLeft cod_equipo">
	Obra
</div>
<div class="floatLeft cod_equipo">
	Equipo
</div>
<div class="floatLeft cod_equipo">
	Fecha Devolucion
</div>
<div class="floatLeft inc_accesorio">
	Accion
</div>
<br class="clearFloat"/>
<?php
while($row_eq_no_dev = mysql_fetch_array($res_eq_no_dev)){
	$sql_eq_no_dev_1 = "
		select equipos_arriendo.num_gd,
				equipos_arriendo.nro_factura, equipos_arriendo.estado_equipo_arr,
				equipos_arriendo.arrendado_desde, equipos_arriendo.arrendado_hasta,
				equipos_arriendo.cod_equipo,equipos_arriendo.cod_arriendo
		from equipos_arriendo
		where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."'
			and equipos_arriendo.estado_equipo_arr = 'DEVUELTO-NO FACTURADO'
			and equipos_arriendo.num_gd = '".$row_eq_no_dev['num_gd']."'
		order by equipos_arriendo.num_gd
		 ";
	$res_eq_no_dev_1 = mysql_query($sql_eq_no_dev_1,$link) or die();
	while($row_eq_no_dev_1 = mysql_fetch_array($res_eq_no_dev_1)){
		//http://intranet.vigomaq_intranet.cl/detalle_factura.php?codarr=229&equipo=237&cod_obra=129&num_gd=1
		echo "<div class='floatLeft cod_arriendo'>".$row_eq_no_dev_1['num_gd']."</div>";
		$raz_social = "";
		$sql_rs = "select clientes.raz_social
					from arriendo
						inner join clientes
							on arriendo.rut_cliente = clientes.rut_cliente
					where arriendo.num_gd = '".$row_eq_no_dev_1['num_gd']."'";
		$res_rs = mysql_query($sql_rs,$link) or die();
		$row_rs = mysql_fetch_array($res_rs);
		$raz_social = $row_rs['raz_social'];
		echo "<div class='floatLeft cod_equipo'>".$raz_social."</div>";
		$sql_rs = "select obra.nombre_obra, obra.cod_obra
					from arriendo
						inner join obra
							on arriendo.cod_obra = obra.cod_obra
					where arriendo.num_gd = '".$row_eq_no_dev_1['num_gd']."'";
		$res_rs = mysql_query($sql_rs,$link) or die();
		$row_rs = mysql_fetch_array($res_rs);
		$nombre_obra = $row_rs['nombre_obra'];
		$cod_obra = $row_rs['cod_obra'];
		echo "<div class='floatLeft cod_equipo'>".$nombre_obra."</div>";
		$sql_rs = "select equipo.nombre_equipo
					from equipos_arriendo
						inner join equipo
							on equipo.cod_equipo = equipos_arriendo.cod_equipo
					where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."'
						and equipos_arriendo.estado_equipo_arr = 'DEVUELTO-NO FACTURADO'
						and equipos_arriendo.num_gd = '".$row_eq_no_dev_1['num_gd']."'
						and equipos_arriendo.cod_equipo = '".$row_eq_no_dev_1['cod_equipo']."'";
		$res_rs = mysql_query($sql_rs,$link) or die();
		$row_rs = mysql_fetch_array($res_rs);
		$nombre_equipo = $row_rs['nombre_equipo'];
		echo "<div class='floatLeft cod_equipo'>".htmlentities($nombre_equipo)."</div>";
	
		$fecha_temp = explode("-",$row_eq_no_dev_1['arrendado_hasta']);
		//año-mes-dia
		//mes-dia-año
		$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
		$fecha_dev_1olucion = $dyh['mday']."-".$dyh['mon']."-".$dyh['year'];  
		
		echo  "<div class='floatLeft cod_equipo'>".htmlentities($fecha_dev_1olucion)."</div>";
	
		echo  "	<div class='floatLeft inc_accesorio'>
					<a href='detalle_factura.php?codarr=".$row_eq_no_dev_1['cod_arriendo']."&equipo=".$row_eq_no_dev_1['cod_equipo']."&cod_obra=".$cod_obra."&num_gd=".$row_eq_no_dev_1['num_gd']."'>Facturar</a>
				</div>";
		echo '<br class="clearFloat"/>';
		}	
	}
?>