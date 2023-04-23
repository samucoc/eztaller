<style>
	.cambio{
		width:66%;
		text-align:center;
		}
	.fecha{
		width:33%;
		}
	.equipo{
		width:33%;
		}
	.guia{
		width:33%;
		}
</style>

<?php
include("../conex.php");
$num_gd = $_GET['num_gd'];
$cod_equipo = $_GET['cod_equipo'];
$nro_factura = 0;
$link = Conectarse();

//Cambios . Devoluciones
				echo (("<div class='floatLeft cambio'>Cambios</div>"));
				echo "<br class='clearFloat'/>";
				echo (("<div class='floatLeft fecha'>Fecha</div>"));
				echo (("<div class='floatLeft equipo'>Equipo</div>"));
				echo (("<div class='floatLeft guia'>Guia</div>"));
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
									 and cod_reclamo not in ('".$string_cod_reclamo."')
									 order by cod_reclamo asc
									 limit 0,1";
					$res_inicial = mysql_query($sql_inicial) or die();
					while ($row_inicial = mysql_fetch_array($res_inicial)){
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
						echo (("<div class='floatLeft fecha'>".$row_bus_equ_cam['fecha_reclamo']."</div>"));
						if (!empty($row_bus_equ_cam['num_gd_salida'])){
							$sql_nom_equ = "select *
										from equipo
										where cod_equipo = '".$row_bus_equ_cam['cod_equipo_entreg']."'";
							$res_nom_equ = mysql_query($sql_nom_equ,$link);
							$row_nom_equ = mysql_fetch_array($res_nom_equ);
							$nombre_equipo = $row_nom_equ['nombre_equipo'];
							echo (("<div class='floatLeft equipo'>".htmlentities(substr($nombre_equipo,-7,7))."</div>")); 
							}
						else{
							echo (("<div class='floatLeft cambio'> </div>"));
							}
						echo (("<div class='floatLeft guia'>".$row_bus_equ_cam['num_gd_salida']."</div>"));
						echo "<br class='clearFloat'/>";
						$cod_equipo_arr[$i]=$cod_equipo_temp;
						if (!empty($row_bus_equ_cam['cod_equipo_entreg'])){
							$cod_equipo_temp=$row_bus_equ_cam['cod_equipo_entreg'];
							}
						}
					}
?>