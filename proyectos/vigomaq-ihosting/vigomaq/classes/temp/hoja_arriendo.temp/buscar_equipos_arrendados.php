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
$nro_factura = 0;
$link = Conectarse();

$sql = "select *
		from gd
		where num_gd = ".$num_gd;
		
$res = mysql_query($sql,$link);
while($row = mysql_fetch_array($res)){
	
	$gd=$row['num_gd'];
	$cod_cli=$row['cod_cliente'];
	$sqlcliente = "SELECT * FROM vigomaq_intranet.clientes WHERE cod_cliente ='$cod_cli'";
	$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
	$registro = mysql_fetch_array($rescliente);
	echo '<div align="left">N&deg; Guia de Despacho</div>
                  <input name="txt_gd" type="text" value="'.$gd.'" size="10" maxlength="10" disabled="disabled"/>
          ';
	echo '<div align="left">Rut</div>
              <input name="txt_rut" type="text" id="rut" value="'.$registro['rut_cliente'].'" size="12" maxlength="12" disabled="disabled"/>';
	echo '<div align="left">Raz&oacute;n Social</div>
			<input  name="txt_razonsoc" type="text" value="'.$registro['raz_social'].'" size="50" maxlength="50" disabled="disabled"/>';
	echo '<div align="left">Giro</div>
			<input name="txt_giro" type="text" value="'.$registro['giro_cliente'].'" size="50" maxlength="50" disabled="disabled"/>';
	echo '<div align="left">Direcci&oacute;n</div>
			<input name="txt_direccion" type="text" value="'.$registro['direcc_cliente'].'" size="50" maxlength="50" disabled="disabled"/>';
	echo '<div align="left">Ciudad</div>
				<input name="txt_ciudad" type="text" value="';
   	if (!empty($registro['cod_ciudad']))
		  {
			  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
			  // echo($sql3);
			  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
			  $registrociu = mysql_fetch_array($resciu);
			  echo($registrociu['ciudad']);
		  }else{
			  echo(" ");
		  } ; 
	echo '" size="50" maxlength="50" disabled="disabled" />';
	echo '<div align="left">Comuna</div>
				<input name="txt_comuna" type="text" value="';
	if (!empty($registro['cod_comuna']))
		  {
			  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
			  // echo($sql3);
			  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
			  $registrocom = mysql_fetch_array($rescom);
			  echo($registrocom['comuna']);
		  }else{
			  echo(" ");
		  } ; 
	echo '" size="50" maxlength="50" disabled="disabled" />';
	echo '<div align="left">Tel&eacute;fono</div>
			<input name="txt_cod_area" type="text" value="'.$registro['cod_area'].'" size="3" maxlength="3" disabled="disabled"/>';
	echo  '<input name="txt_fono" type="text" value="'.$registro['fono_cliente'].'" size="8" maxlength="8" disabled="disabled"/>';
	echo '<div align="left">Tipo</div>
			<textarea name="txt_tipo" cols="63" rows="4" disabled="disabled">'.$registrogd['tipo'].'</textarea>';
	}
	echo "<hr />";
	
	echo "Equipos Asociados a la Guia de Despacho Nro. : ".$num_gd;
	echo "<br />";
	echo "<br />";
	$sql_equipo = "select distinct cod_equipo
		from equipos_arriendo
		where num_gd = ".$num_gd."
			and estado_equipo_arr not like '%CAMBIO'
		order by cod_equipo";
	$res_equipo = mysql_query($sql_equipo,$link) or die();
	while ($row_equipo =  mysql_fetch_array($res_equipo)){
		$cod_equipo = $row_equipo['cod_equipo'];	
		$sql_equipo_temp = "select *
						from equipo
						where cod_equipo = ".$cod_equipo;
		$res_equipo_temp = mysql_query($sql_equipo_temp, $link);
		while($row_equipo_temp = mysql_fetch_array($res_equipo_temp)){
			echo "<a href='#' id='".$row_equipo_temp['cod_equipo']."' class='equipo_arrendado' >".quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']))."</a>";
			echo "<br />";
			echo "<br />";
			}
		}
	echo "<hr />";
	echo "<br />";
	

/*
$sql = "select distinct cod_equipo
		from equipos_arriendo
		where num_gd = ".$num_gd."
		order by cod_equipo";
		
$res = mysql_query($sql,$link);
while($row = mysql_fetch_array($res)){
	$sql_equipo = "select *
					from equipos_arriendo
					where num_gd = ".$num_gd."
						and cod_equipo = ".$row['cod_equipo'];
	$res_equipo = mysql_query($sql_equipo, $link);
	
	<div class="floatLeft texto_arriendo">
    	Equipo
	</div>
	<div class="floatLeft control_arriendo">
	    <?php 
			$cod_equipo = $row['cod_equipo'];	
			$sql_equipo_temp = "select *
							from equipo
							where cod_equipo = ".$cod_equipo;
			$res_equipo_temp = mysql_query($sql_equipo_temp, $link);
			while($row_equipo_temp = mysql_fetch_array($res_equipo_temp)){
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']));
				}
	
    </div>
    <br class="clearFloat">	
    <br class="clearFloat">	
    <br class="clearFloat">	
    <div class="floatLeft">
    	Facturacion
    </div>
    <br class="clearFloat">	
    <div class="floatLeft nro_factura">
    	Nro. Factura
	</div>
	<div class="floatLeft arrendado_desde">
    	Arrendado Desde
	</div>
	<div class="floatLeft hora_arr">
    	Hora Arriendo
	</div>
	<div class="floatLeft arrendado_hasta">
    	Arrendado Hasta
	</div>
	<div class="floatLeft hora_devol">
    	Hora Devolucion
	</div>
	<div class="floatLeft comentarios">
    	Comentarios
	</div>
	<div class="floatLeft estado_equipo_arr">	
    	Estado
	</div>
	<div class="floatLeft inc_accesorio">
    	Incluye Accesorio?
	</div>
	<div class="floatLeft inc_accesorio">
		Accion
	</div>
    <br class="clearFloat">
	<?php
    while ($row_equipo = mysql_fetch_array($res_equipo)){
	
	<div class="floatLeft nro_factura">
	    <?php 
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
					echo $nro_factura = $registroper['num_factura'];
					}
				elseif ($row_equipo['estado_equipo_arr']=='DEVUELTO-NO FACTURADO-CAMBIO'){
					echo "Equipo Cambiado";
					}
				else{
					echo "Sin Facturar";
					}
				}
			else{
				echo $nro_factura = $row_equipo['nro_factura'];
				}
		
	</div>
	<div class="floatLeft arrendado_desde">
	    <?php 
			$fecha_temp = explode("-",$row_equipo['arrendado_desde']);
			//año-mes-dia
			//0 -> dia, 1 -> mes, 2 -> año
			$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
			echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
		
	</div>
	<div class="floatLeft hora_arr">
	    <?php echo $row_equipo['hora_arr'];	
	</div>
	<div class="floatLeft arrendado_hasta">
	    <?php 
			if ($row_equipo['hora_devol']!='00:00:00'){
				$fecha_temp = explode("-",$row_equipo['arrendado_hasta']);
				//año-mes-dia
				//0 -> dia, 1 -> mes, 2 -> año
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
				echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
				}
			else{
				echo "No devuelto";
				}
		
	</div>
	<div class="floatLeft hora_devol">
	    <?php 
			if ($row_equipo['hora_devol']!='00:00:00'){
				echo $row_equipo['hora_devol'];	
			}
			else{
				echo "No devuelto";
				}
			
	</div>
	<div class="floatLeft comentarios">
	    <?php echo $row_equipo['comentarios'];	
	</div>
	<div class="floatLeft estado_equipo_arr">
	    <?php echo $row_equipo['estado_equipo_arr'];	
	</div>
	<div class="floatLeft inc_accesorio">
	    <?php 
			if ($row_equipo['inc_accesorio']==0){
				echo "No";
				}
			elseif ($row['inc_accesorio']==1){
				echo "Si";
				}
			
	</div>
	<div class="floatLeft inc_accesorio">
	    <?php 
			if (($row_equipo['estado_equipo_arr']=='DEVUELTO-FACTURADO')||($row_equipo['estado_equipo_arr']=='NO DEVUELTO-FACTURADO')){
				echo "<a href='facturar.php?nro_factura=".$nro_factura."'>Ver Factura</a>";
				}
			elseif ($row_equipo['estado_equipo_arr']!='DEVUELTO-NO FACTURADO-CAMBIO'){
				$cod_arriendo = $row_equipo['cod_arriendo'];
				$sql_obra = "select cod_obra from arriendo where cod_arriendo = ".$cod_arriendo;
				$res_obra = mysql_query($sql_obra,$link);
				$row_obra = mysql_fetch_array($res_obra);
				$cod_obra = $row_obra['cod_obra'];
				echo "<a href='detalle_factura.php?codarr=".$cod_arriendo."&equipo=".$cod_equipo."&cod_obra=".$cod_obra."&num_gd=".$num_gd."'>Facturar</a>";
				}
			else{
				echo "Equipo Cambiado";
				}
			
	</div>
    <br class="clearFloat"/>
<?php 	}
	
    <br class="clearFloat">	
    <div class="floatLeft">
    	Reclamo/Cambio Equipo
    </div>
    <br class="clearFloat">	
    <div class="floatLeft nro_factura">
    	Cliente
	</div>
	<div class="floatLeft arrendado_desde">
		Equipo Devuelto
	</div>
	<div class="floatLeft hora_arr">
		Estado Equipo Devuelto
	</div>
	<div class="floatLeft arrendado_desde">
		Equipo Entregado
	</div>
	<div class="floatLeft hora_arr">
		Detalle Falla
	</div>
	<div class="floatLeft hora_arr">
		Resolucion Falla
	</div>
	<div class="floatLeft arrendado_hasta">
		Fecha Reclamo
	</div>
	<div class="floatLeft hora_devol">
		Hora Reclamo
	</div>
	<div class="floatLeft hora_arr">
		Nro GD Entrada
	</div>
	<div class="floatLeft hora_arr">	
		Nro GD Salida
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
	
    <div class="floatLeft nro_factura">
    	<?php 
			$cod_cliente = $row_reclamo['cod_cliente'];
			$sql_cliente = "select raz_social
							from clientes 
							where cod_cliente = ".$cod_cliente;
			$res_cliente = mysql_query($sql_cliente,$link);
			$row_cliente = mysql_fetch_array($res_cliente);
			echo $row_cliente['raz_social'];	
		
	</div>
	<div class="floatLeft arrendado_desde">
		<?php 
			$cod_equipo = $row_reclamo['cod_equipo_dev'];	
			$sql_equipo_temp = "select *
							from equipo
							where cod_equipo = ".$cod_equipo;
			$res_equipo_temp = mysql_query($sql_equipo_temp, $link);
			while($row_equipo_temp = mysql_fetch_array($res_equipo_temp)){
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']));
				}
		
	</div>
	<div class="floatLeft hora_arr">
		<?php 
			$cod_equipo_estado = $row_reclamo['cod_estado_equipo'];	
			$sql_equipo_temp = "select *
							from estado_equipo
							where cod_estado_equipo = ".$cod_equipo_estado;
			$res_equipo_temp = mysql_query($sql_equipo_temp, $link);
			while($row_equipo_temp = mysql_fetch_array($res_equipo_temp)){
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['descripcion_estado']));
				}
		
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
	
			
	</div>
	<div class="floatLeft hora_arr">
		<?php echo $row_reclamo['det_falla']
	</div>
	<div class="floatLeft hora_arr">
		<?php echo $row_reclamo['resolucion_reclamo']
	</div>
	<div class="floatLeft arrendado_hasta">
		<?php echo $row_reclamo['fecha_reclamo']
	</div>
	<div class="floatLeft hora_devol">
    	<?php echo $row_reclamo['hora_reclamo']
	</div>
	<div class="floatLeft hora_arr">
		<?php echo $row_reclamo['num_gd_ingreso']
	</div>
	<div class="floatLeft hora_arr">	
		<?php echo $row_reclamo['num_gd_salida']
	</div>
	<br class="clearFloat">
    <?php } 
    <hr class="clearFloat"/>
    <br class="clearFloat"/>
	<?php
    }*/
?>