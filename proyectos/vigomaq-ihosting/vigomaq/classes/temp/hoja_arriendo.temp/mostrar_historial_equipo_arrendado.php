<?php
function quitar_espacios_extra($str)
{
	//Utilizamos trim antes de empezar
	$str = trim($str);	   
 
	//Inicializamos el string que devolvemos
	$ret_str ="";
 
	//Recorremos el string
	for($i=0;$i < strlen($str);$i++) {
		/*Si estamos en algo que no es un espacio, seguimos copiando el 
		string de entrada al de salida */
		if(substr($str, $i, 1) != " ") {
			$ret_str .= trim(substr($str, $i, 1));
		} else {
			/*Si es un espacio nos lo saltamos, aumentando el contador i del bucle*/
			while(substr($str,$i,1) == " "){
				$i++;
			}		
 
			/* Dado que no queremos quitar todos los espacios, sino solo los repetidos
			añadimos un espacio después de habernos
			saltado un nº indeterminado de ellos SI nos saltamos uno, ponemos uno
			SI nos saltamos 20, ponemos uno igual */
			$ret_str.= " ";
			$i--;
		}
	}
	return $ret_str;
}		   

include("../../conex.php");
$num_gd = $_GET['num_gd'];
$cod_equipo = $_GET['cod_equipo'];
$nro_factura = 0;
$link = Conectarse();

$sql = "select distinct cod_equipo
		from equipos_arriendo
		where num_gd = ".$num_gd."
			and cod_equipo = ".$cod_equipo."
		order by cod_equipo";
?>
<div class="floatLeft texto_arriendo">
	Equipo
</div>
<div class="floatLeft control_arriendo">
	<?php 
		$cod_equipo = $cod_equipo;	
		$sql_equipo_temp = "select *
						from equipo
						where cod_equipo = ".$cod_equipo;
		$res_equipo_temp = mysql_query($sql_equipo_temp, $link);
		while($row_equipo_temp = mysql_fetch_array($res_equipo_temp)){
			echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']));
			}
	?>
</div>
<?php	
$res = mysql_query($sql,$link);
$sql_equipo = "select *
				from equipos_arriendo
				where num_gd = ".$num_gd."
					and cod_equipo = ".$cod_equipo;
$res_equipo = mysql_query($sql_equipo, $link);
while($row_equipo = mysql_fetch_array($res_equipo)){
?>
<br class="clearFloat">	
<br class="clearFloat">	
<br class="clearFloat">	

<div class="mes-arriendo"> 
	<div class="lado-izq floatLeft">
    	<div class="floatLeft control_hoja">
        	Dias de Arriendo
        </div>
    	<div class="floatLeft texto_hoja">
			<?php
			$nro_factura=0;
			$dias_arriendo = 0;
			$tot_arriendo = 0;
        	if ($row_equipo['nro_factura']==''){
				if (($row_equipo['estado_equipo_arr']=='DEVUELTO-FACTURADO')||($row_equipo['estado_equipo_arr']=='NO DEVUELTO-FACTURADO')){
					$sqlperiodo="SELECT distinct factura.num_factura
								FROM equipos_arriendo
									inner join gd
										on equipos_arriendo.cod_arriendo = gd.id_arriendo
									inner join factura 
										on factura.cod_arriendo = equipos_arriendo.cod_arriendo
									where equipos_arriendo.cod_arriendo =".$row_equipo['cod_arriendo']." 
										and equipos_arriendo.cod_equipo =".$row_equipo['cod_equipo']." 
										and equipos_arriendo.num_gd = ".$row_equipo['num_gd']."
										and equipos_arriendo.arrendado_hasta = '".$row_equipo['arrendado_hasta']."'
										and equipos_arriendo.arrendado_desde = '".$row_equipo['arrendado_desde']."'
										and factura.fecha between equipos_arriendo.arrendado_desde and equipos_arriendo.arrendado_hasta
										and equipos_arriendo.estado_equipo_arr = '".$row_equipo['estado_equipo_arr']."'
									order by equipos_arriendo.arrendado_hasta asc
								limit 0,1";
					$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					$registroper = mysql_fetch_array($resperiodo); 
					$nro_factura = $registroper['num_factura'];
					}
				}
			else{
				$nro_factura = $row_equipo['nro_factura'];
				}
			$sql_det_fact = "select *
								from det_factura
								where num_factura = ".$nro_factura." 
									and cod_equipo = ".$cod_equipo;
			$res_det_fact = mysql_query($sql_det_fact,$link) or die();
			while($row_det_fact = mysql_fetch_array($res_det_fact)){
				echo $dias_arriendo = $row_det_fact['dias_arriendo'];
				$tot_arriendo = $row_det_fact['tot_arriendo'];
				}
			?>
	    </div>
		<br class="clearFloat"/>
		<br class="clearFloat"/>
		<div class="floatLeft control_hoja">
        	Fecha Inicio Arriendo
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $row_equipo['arrendado_desde']?>
	    </div>
		<div class="floatLeft control_hoja">
        	Hora Inicio Arriendo
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $row_equipo['hora_arr']?>
	    </div>
		<br class="clearFloat"/>
		<div class="floatLeft control_hoja">
        	Fecha Termino Arriendo
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $row_equipo['arrendado_hasta']?>
	    </div>
		<div class="floatLeft control_hoja">
        	Hora Termino Arriendo
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $row_equipo['hora_devol']?>
	    </div>
		<br class="clearFloat"/>
   		<div class="floatLeft control_hoja">
        	Nro. Factura
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $nro_factura?>
	    </div>
   		<div class="floatLeft control_hoja">
			Estado Facturacion
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $row_equipo['estado_equipo_arr']?>
	    </div>
		<br class="clearFloat"/>
    </div>
	<div class="lado-der floatLeft">
    	<div class="floatLeft control_hoja">
        	Neto
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $tot_arriendo?>
	    </div>
		<br class="clearFloat"/>
        <div class="floatLeft control_hoja">
        	IVA
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $tot_arriendo*0.19?>
	    </div>
		<br class="clearFloat"/>
        <div class="floatLeft control_hoja">
        	TOTAL
        </div>        
    	<div class="floatLeft control_hoja">
			<?php echo $tot_arriendo*1.19?>
	    </div>
		<br class="clearFloat"/>
    </div>
    <br class="clearFloat"/>
    <hr class="clearFloat"/>
    <br class="clearFloat"/>
	<div class="comentarios-equipo floatLeft">
    	<?php echo $row_equipo['comentarios']?>
    </div>
    <br class="clearFloat"/>
    <br class="clearFloat"/>
</div>
<?php
    }
?>
    <br class="clearFloat"/>
    <br class="clearFloat"/>
    <div class="floatLeft">
    	Reclamo/Cambio Equipo
    </div>
    <br class="clearFloat">	
    <div class="floatLeft nro_factura">
    	Fecha
	</div>
	<div class="floatLeft arrendado_desde">
		Equipo Entregado
	</div>
	<div class="floatLeft hora_arr">	
		Nro Guia Despacho Salida
	</div>
	<br class="clearFloat">
    <?php 
		$sql_reclamo = "select *
						from reclamo
						where cod_reclamo in (select distinct cod_reclamo
												from equipos_arriendo
												where num_gd = ".$num_gd."
													and cod_equipo = ".$row['cod_equipo'].")";
		$res_reclamo = mysql_query($sql_reclamo,$link);
		while ($row_reclamo = mysql_fetch_array($res_reclamo)){
		?>
    <div class="floatLeft arrendado_hasta">
		<?php echo $row_reclamo['fecha_reclamo']	?>
	</div>
	<div class="floatLeft arrendado_desde">
		<?php 
			$cod_equipo = $row_reclamo['cod_equipo_entreg'];	
			$sql_equipo_temp = "select *
							from equipo
							where cod_equipo = ".$cod_equipo;
			$res_equipo_temp = mysql_query($sql_equipo_temp, $link);
			while($row_equipo_temp = mysql_fetch_array($res_equipo_temp)){
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']));
				}
		?>
			
	</div>
    <div class="floatLeft hora_arr">	
		<?php echo $row_reclamo['num_gd_salida']	?>
	</div>
	<br class="clearFloat">
    <?php } 
	?>
    <hr class="clearFloat"/>
    <br class="clearFloat"/>
