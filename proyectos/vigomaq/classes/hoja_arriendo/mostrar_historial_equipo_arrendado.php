<style>
	.inicio_fact{
		width:75%;
		border: 1px solid #000;
		padding:10px
		}
	.precio_arr{
		width:30%
		}
	.dias_arr{
		width:30%
		}
	.neto{
		width:30%
		}
	.iva{
		width:30%
		}
	.vence{
		width:30%
		}
	.nro_fact{
		width:30%
		}
	.total{
		width:30%
		}
	.observaciones{
		width:60%
		}

</style>

<?php
include("../conex.php");
$num_gd = $_GET['num_gd'];
$cod_equipo = $_GET['cod_equipo'];
$nro_factura = 0;
$link = Conectarse();

	//detalle hoja arriendo		
	//primer detalle			
	echo "<br class='clearFloat'/>";
	
	$cod_equipo_temp = $cod_equipo;
	$cod_equipo_arr = array();
	$cod_reclamo_arr = array();
	for ($i=0;$i<10;$i++){
		
		$cod_reclamo_arr = array_unique($cod_reclamo_arr);
		$cod_reclamo_arr = array_values($cod_reclamo_arr);
	
		$string_cod_reclamo = implode("','",$cod_reclamo_arr);
		$sql_inicial = "select cod_reclamo
						from equipos_arriendo
						where cod_equipo = ".$cod_equipo_temp."
						 and num_gd = ".$num_gd."
						 and cod_reclamo <> 0
						 and cod_reclamo not in ('".$string_cod_reclamo."')";
		$res_inicial = mysql_query($sql_inicial) or die();
		$row_inicial = mysql_fetch_array($res_inicial);
		if (!empty($row_inicial['cod_reclamo']))
			$cod_reclamo = $row_inicial['cod_reclamo'];
		else
			$cod_reclamo = 0;
		$cod_reclamo_arr[$i]=$cod_reclamo;
		$sql="select fecha_reclamo, cod_equipo_entreg, num_gd_salida
				from reclamo
				where cod_reclamo = ".$cod_reclamo."
				";
		$res_bus_equ_cam = mysql_query($sql) or die();
		$row_bus_equ_cam = mysql_fetch_array($res_bus_equ_cam);
		if (!empty($row_bus_equ_cam['num_gd_salida'])){
			$sql_nom_equ = "select *
						from equipo
						where cod_equipo = '".$row_bus_equ_cam['cod_equipo_entreg']."'";
			$res_nom_equ = mysql_query($sql_nom_equ,$link);
			$row_nom_equ = mysql_fetch_array($res_nom_equ);
			$nombre_equipo = $row_nom_equ['nombre_equipo'];
			}
		else{
			}
		$cod_equipo_arr[$i]=$cod_equipo_temp;
		if (!empty($row_bus_equ_cam['cod_equipo_entreg'])){
			$cod_equipo_temp=$row_bus_equ_cam['cod_equipo_entreg'];
			}
		}
	$cod_equipo_arr = array_unique($cod_equipo_arr);
	$cod_equipo_arr = array_values($cod_equipo_arr);
				
	$string_cod_equipo = implode("','",$cod_equipo_arr);

	$sql_001 ="select distinct cod_arriendo
				from equipos_arriendo
				where num_gd = ".$num_gd;
	$res_001 = mysql_query($sql_001,$link) or die(mysql_error());
	$row_001 = mysql_fetch_array($res_001);
	$cod_arriendo = $row_001['cod_arriendo'];
	
	$sql_002 ="select distinct num_factura, fecha
				from factura
				where cod_arriendo = ".$cod_arriendo;
	$res_002 = mysql_query($sql_002,$link) or die(mysql_error());
	$num_factura_arr = array();
	$i=0;
	while ($row_002 = mysql_fetch_array($res_002)){
		$num_factura_arr[$i] = $row_002['num_factura'];
		$i=$i+1;
		}
	$i=0;
	
	$num_factura_arr = array_unique($num_factura_arr);
	$num_factura_arr = array_values($num_factura_arr);
	
	$string_num_factura = implode("','",$num_factura_arr);
	
	$sql_inicial_1 = "
					SELECT *
							FROM equipos_arriendo
								inner join det_factura
									on equipos_arriendo.nro_factura = det_factura.num_factura
										and det_factura.cod_equipo = equipos_arriendo.cod_equipo
								where equipos_arriendo.cod_arriendo = ".$cod_arriendo." 
									and equipos_arriendo.cod_equipo in ('".$string_cod_equipo."') 
									and det_factura.cod_equipo in ('".$string_cod_equipo."') 
									and equipos_arriendo.num_gd = ".$num_gd."
									and equipos_arriendo.nro_factura in ('".$string_num_factura."')
									and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
					order by  equipos_arriendo.arrendado_hasta asc
					";
	$res_inicial_1 = mysql_query($sql_inicial_1,$link) or die(mysql_error());
	$row_inicial_1 = mysql_fetch_array($res_inicial_1);
	
	$precio_equipo = $row_inicial_1['tot_arriendo']/$row_inicial_1['dias_arriendo'];
	echo "<div class='inicio_fact'>";
	
	$sql_cod_equipo ="select precio
						from det_gd
						where cod_equipo = ".$cod_equipo."
							and num_gd = ".$num_gd;
	$res_cod_equipo = mysql_query($sql_cod_equipo,$link) or die(mysql_error());
	$row_cod_equipo = mysql_fetch_array($res_cod_equipo);
	
	$precio = $row_cod_equipo['precio'];
	
	echo (("<div class='floatLeft precio_arr'>Inicio Arriendo ".$precio." x </div>"));
	echo (("<div class='floatLeft dias_arr'> ".$row_inicial_1['dias_arriendo']." dias </div>"));
	echo (("<div class='floatRight neto'>Neto  : ".$row_inicial_1['tot_arriendo']."</div>"));
	echo "<br class='clearFloat'/>";
	echo (("<div class='floatLeft vence'>Vence : ".$row_inicial_1['arrendado_hasta']."</div>"));
	echo (("<div class='floatLeft nro_fact'>Nro Factura :".$row_inicial_1['num_factura']."</div>"));
	echo (("<div class='floatRight iva'>Iva    : ".$row_inicial_1['tot_arriendo']*0.19."</div>"));
	echo "<br class='clearFloat'/>";
	echo (("<div class='floatLeft observaciones'>Observaciones : Dias Ajuste = ".$row_inicial_1['dias_ajuste']."</div>"));
	echo (("<div class='floatRight total'>Total : ".$row_inicial_1['tot_arriendo']*1.19."</div>"));
	echo "<br class='clearFloat'/>";
	echo "</div>";
	echo "<br class='clearFloat'/>";
		
	//otros detalles
	while ($row_inicial_1 = mysql_fetch_array($res_inicial_1)){				
		echo "<br class='clearFloat'/>";
		echo "<div class='inicio_fact'>";
			$precio_equipo = $row_inicial_1['tot_arriendo']/$row_inicial_1['dias_arriendo'];
			echo (("<div class='floatLeft precio_arr'>Renovacion o Saldo por ".$row_inicial_1['dias_arriendo']."</div>"));
			echo (("<div class='floatLeft dias_arr'> dias a ".$precio."</div>"));
			echo (("<div class='floatRight neto'>Neto : ".$row_inicial_1['tot_arriendo']."</div>"));
			echo "<br class='clearFloat'/>";
			$arrendado_hasta  =$row_inicial_1['arrendado_hasta'];
				if (($arrendado_hasta=='0000-00-00')&&(empty($row_inicial_1['arrendado_hasta']))){
					$arrendado_hasta='';
					}
			echo (("<div class='floatLeft vence'>Vence : ".$arrendado_hasta."</div>"));
			echo (("<div class='floatLeft nro_fact'>Nro Factura : ".$row_inicial_1['num_factura']."</div>"));
			echo (("<div class='floatRight iva'>Iva    : ".$row_inicial_1['tot_arriendo']*0.19."</div>"));
			echo "<br class='clearFloat'/>";
			echo (("<div class='floatLeft observaciones'>Observaciones : Dias Ajuste = ".$row_inicial_1['dias_ajuste']." </div>"));
			echo (("<div class='floatRight total'>Total : ".$row_inicial_1['tot_arriendo']*1.19."</div>"));
			echo "<br class='clearFloat'/>";
		echo "</div>";
		echo "<br class='clearFloat'/>";
		}
?>