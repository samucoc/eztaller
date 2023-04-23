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
		select  distinct equipos_arriendo.num_gd
		from equipos_arriendo
		where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."'
			and equipos_arriendo.arrendado_hasta = '0000-00-00'
		order by equipos_arriendo.num_gd
		 ";
$res_eq_no_dev = mysql_query($sql_eq_no_dev,$link) or die();

$num_res = mysql_num_rows($res_eq_no_dev);

?>
<h4>Encontrados <?php echo $num_res?> resultados</h4>
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
	Ultimo Cierre Mes
</div>
<div class="floatLeft inc_accesorio">
	Accion
</div>
<br class="clearFloat"/>
<?php
while($row_eq_no_dev = mysql_fetch_array($res_eq_no_dev)){
	//http://intranet.vigomaq_intranet.cl/detalle_factura.php?codarr=229&equipo=237&cod_obra=129&num_gd=1
	$num_gd = $row_eq_no_dev['num_gd'];
	$sql_eq_no_dev_001 = "
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
			INNER JOIN obra 
				ON arriendo.cod_obra = obra.cod_obra
		where equipos_arriendo.arrendado_desde between '".$fecha_inicio."' and '".$fecha_fin."'
			and equipos_arriendo.arrendado_hasta = '0000-00-00'
			and equipos_arriendo.estado_equipo_arr = 'NO DEVUELTO'
			and equipos_arriendo.num_gd  = '".$num_gd."'
		order by equipos_arriendo.num_gd
		 ";
	$res_eq_no_dev_001 = mysql_query($sql_eq_no_dev_001,$link) or die();	
	while($row_eq_no_dev_001 = mysql_fetch_array($res_eq_no_dev_001)){
		echo "<div class='floatLeft cod_arriendo'>".$num_gd."</div>";
		echo  "<div class='floatLeft cod_equipo'>".$row_eq_no_dev_001['raz_social']."</div>";
		echo  "<div class='floatLeft cod_equipo'>".$row_eq_no_dev_001['nombre_obra']."</div>";
		echo  "<div class='floatLeft cod_equipo'>".htmlentities($row_eq_no_dev_001['nombre_equipo'])."</div>";
		
		$fecha_temp = explode("-",$row_eq_no_dev_001['arrendado_desde']);
		//año-mes-dia
		//mes-dia-año
		$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
		$fecha_inicio_1 = $dyh['mday']."-".$dyh['mon']."-".$dyh['year'];  
		
		echo  "<div class='floatLeft cod_equipo'>".htmlentities($fecha_inicio_1)."</div>";
		echo  "	<div class='floatLeft inc_accesorio'>
					<a href='detalle_factura.php?codarr=".$row_eq_no_dev_001['cod_arriendo']."&equipo=".$row_eq_no_dev_001['cod_equipo']."&cod_obra=".$row_eq_no_dev_001['cod_obra']."&num_gd=".$row_eq_no_dev_001['num_gd']."'>Facturar</a>
				</div>";
		echo '<br class="clearFloat"/>';
		}
	}	
	 
?>