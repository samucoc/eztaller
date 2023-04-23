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
		select  equipos_arriendo.num_gd, clientes.raz_social, 
				obra.nombre_obra, equipo.nombre_equipo, 
				equipos_arriendo.nro_factura, equipos_arriendo.estado_equipo_arr,
				equipos_arriendo.arrendado_desde, equipos_arriendo.arrendado_hasta,
				equipos_arriendo.cod_equipo, obra.cod_obra, equipos_arriendo.cod_arriendo
		from equipos_arriendo
			inner join equipo
				on equipo.cod_equipo = equipos_arriendo.cod_equipo
			inner join arriendo
				on arriendo.cod_arriendo = equipos_arriendo.cod_arriendo
			inner join clientes
				on arriendo.rut_cliente = clientes.rut_cliente
			inner join obra 
				on clientes.cod_cliente = obra.cod_cliente
		where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."'
			and equipo.cod_estado_equipo = 3
			and equipos_arriendo.estado_equipo_arr = 'NO DEVUELTO'
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
<div class="floatLeft inc_accesorio">
	Accion
</div>
<br class="clearFloat"/>
<?php
while($row_eq_no_dev = mysql_fetch_array($res_eq_no_dev)){
	//http://intranet.vigomaq_intranet.cl/detalle_factura.php?codarr=229&equipo=237&cod_obra=129&num_gd=1
	echo "<div class='floatLeft cod_arriendo'>".$row_eq_no_dev['num_gd']."</div>";
	echo  "<div class='floatLeft cod_equipo'>".$row_eq_no_dev['raz_social']."</div>";
	echo  "<div class='floatLeft cod_equipo'>".$row_eq_no_dev['nombre_obra']."</div>";
	echo  "<div class='floatLeft cod_equipo'>".htmlentities($row_eq_no_dev['nombre_equipo'])."</div>";
	echo  "	<div class='floatLeft inc_accesorio'>
				<a href='detalle_factura.php?codarr=".$row_eq_no_dev['cod_arriendo']."&equipo=".$row_eq_no_dev['cod_equipo']."&cod_obra=".$row_eq_no_dev['cod_obra']."&num_gd=".$row_eq_no_dev['num_gd']."'>Facturar</a>
		 	</div>";
	echo '<br class="clearFloat"/>';
	}	

$sql_eq_no_dev_1 = "
		select  equipos_arriendo.num_gd, clientes.raz_social,  
				obra.nombre_obra, equipo.nombre_equipo, 
				equipos_arriendo.nro_factura, equipos_arriendo.estado_equipo_arr,
				equipos_arriendo.arrendado_desde, equipos_arriendo.arrendado_hasta,
				equipos_arriendo.cod_equipo, obra.cod_obra, equipos_arriendo.cod_arriendo
		from equipos_arriendo
			inner join equipo
				on equipo.cod_equipo = equipos_arriendo.cod_equipo
			inner join arriendo
				on arriendo.cod_arriendo = equipos_arriendo.cod_arriendo
			inner join clientes
				on arriendo.rut_cliente = clientes.rut_cliente
			inner join obra 
				on clientes.cod_cliente = obra.cod_cliente
		where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."' 
			and equipos_arriendo.estado_equipo_arr = 'NO DEVUELTO-FACTURADO'
		order by equipos_arriendo.num_gd
		 ";
$res_eq_no_dev_1 = mysql_query($sql_eq_no_dev_1,$link) or die();		 
while($row_eq_no_dev_1 = mysql_fetch_array($res_eq_no_dev_1)){
	echo "<div class='floatLeft cod_arriendo'>".$row_eq_no_dev_1['num_gd']."</div>";
	echo  "<div class='floatLeft cod_equipo'>".$row_eq_no_dev_1['raz_social']."</div>";
	echo  "<div class='floatLeft cod_equipo'>".$row_eq_no_dev_1['nombre_obra']."</div>";
	echo  "<div class='floatLeft cod_equipo'>".htmlentities($row_eq_no_dev_1['nombre_equipo'])."</div>";
	echo  "	<div class='floatLeft inc_accesorio'>
				<a href='facturar.php?nro_factura=".$row_eq_no_dev_1['nro_factura']."'>Ver Factura</a>
		 	</div>";
	echo '<br class="clearFloat"/>';
	}		 
		 
?>