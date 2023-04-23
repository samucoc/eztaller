<style>
#encabezado_ha{
	float:left;
	padding-left: 20%;
	width:75%;
	}
.quince{
	width:30%;
	}
.cincuenta{
	width:70%;
	}
#intro_ha{
	float:left;
	width:50%;
	}

</style>
<?php

include("../conex.php");
$num_gd = $_GET['num_gd'];
$parte = $_GET['parte'];
$nro_factura = 0;
$link = Conectarse();

	$sql_cod_arriendo = "SELECT * 
							FROM arriendo 
								inner join gd
									on gd.id_arriendo = arriendo.cod_arriendo
							WHERE gd.num_gd = '$num_gd'";						
	
	$res_cod_arriendo = mysql_query($sql_cod_arriendo,$link) or die(mysql_error());
	$registro_cod_arriendo = mysql_fetch_array($res_cod_arriendo);
	
	$cod_cli  		=	$registro_cod_arriendo['cod_cliente'];
	$cod_arriendo	=  	$registro_cod_arriendo['cod_arriendo'];
	$rut_cliente	=	$registro_cod_arriendo['rut_cliente'];
	$cod_obra		=	$registro_cod_arriendo['cod_obra'];
	$cod_tarifa		=	$registro_cod_arriendo['cod_tarifa'];
	$cod_personal	=	$registro_cod_arriendo['cod_personal'];
	$forma_pago		=	$registro_cod_arriendo['forma_pago'];
	$num_gd			=	$registro_cod_arriendo['num_gd'];
	$num_oc			=	$registro_cod_arriendo['num_oc'];
	$tipo_garantia	=	$registro_cod_arriendo['tipo_garantia'];
	$fecha_inicio 	=	$registro_cod_arriendo['fecha_inicio'];
	$fecha_vcmto 	=	$registro_cod_arriendo['fecha_vcmto'];
	$fecha_arr 		=	$registro_cod_arriendo['fecha_arr'];
	$hora_arr		=	$registro_cod_arriendo['hora_arr'];
	$fecha_devol	=	$registro_cod_arriendo['fecha_devol'];
	$hora_devol		=	$registro_cod_arriendo['hora_devol'];
	$forma_entrega	=	$registro_cod_arriendo['forma_entrega'];
	$monto_arriendo	=	$registro_cod_arriendo['monto_arriendo'];
	$tipo_oc		=	$regsitro_cod_arriendo['tipo_oc'];
	$vcmto_oc		=	$registro_cod_arriendo['vcmto_oc'];
	$obs_devolucion	=	$registro_cod_arriendo['obs_devolucion'];
	
	$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, 
				dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, 
				movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, 
				cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, 
				movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact 
		FROM clientes 
		WHERE rut_cliente ='$rut_cliente'";
	$res = mysql_query($sql,$link) or die(mysql_error());
	$registro = mysql_fetch_array($res);

	$sql_prepa_001 = "(select distinct num_gd
							from gd
							where id_arriendo = '$cod_arriendo'
								and tipo <> 'DEVOL EQUIPO')";
	$res_prepa_001 = mysql_query($sql_prepa_001,$link) or die(mysql_error());
	$row_prepa_001 = mysql_fetch_array($res_prepa_001) ;

	$fecha_temp = explode("-",$registro_cod_arriendo['fecha_arr']);
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]."</div>"));
	$dia_texto="";
	$fecha_gd = $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  
	
	$sqlobra     = "SELECT condic_arriendo.condiciones 
					FROM obra 
						inner join condic_arriendo
							on condic_arriendo.cod_cond_arr = obra.cod_condic
					WHERE obra.cod_obra ='$cod_obra'";
					
	$resobra     = mysql_query($sqlobra,$link) or die(mysql_error());
	$registroobra= mysql_fetch_array($resobra);
	$nombre_condicion_obra = $registroobra['condiciones'];
	if ($parte==1){
	echo "<div id='encabezado_ha'>";
		echo "<div class='floatLeft quince'>Condiciones de Arriendo</div><div class='cincuenta floatLeft'>".$nombre_condicion_obra."</div>";
		echo "<br class='clearFloat'/>";
	
		if ($forma_entrega == 1) {
			$forma_entrega = "RETIRA CLIENTE";
		}else{
			$forma_entrega ="ENTREGA EN OBRA";
			}
		echo "<div class='floatLeft quince'>Forma Entrega Producto</div><div class='cincuenta floatLeft'>".$forma_entrega."</div>";
		echo "<br class='clearFloat'/>";

		$sqlfp = "SELECT forma_pago FROM forma_pago WHERE cod_forma_pago ='$forma_pago'";
		$resfp = mysql_query($sqlfp,$link) or die(mysql_error());
		$registrofp = mysql_fetch_array($resfp);
		$nombre_forma_pago = $registrofp['forma_pago'];
		echo "<div class='floatLeft quince'>Forma de Pago</div><div class='cincuenta floatLeft'>".$nombre_forma_pago."</div>";
		echo "<br class='clearFloat'/>";
	
		$envio_factura = $registro['cond_env_fact'];
		echo ("<div class='floatLeft quince'>Envio Factura</div><div class='cincuenta floatLeft'>".$envio_factura."</div>");
		echo "<br class='clearFloat'/>";
		echo (("<div class='floatLeft quince'>Doc Anexo a la Factura</div><div class='cincuenta floatLeft'>"."</div>"));
		echo "<br class='clearFloat'/>";
	echo "</div>";
	echo "<br class='clearFloat'/>";
	echo "<br class='clearFloat'/>";
	}
	if ($parte==2){
	echo "<div id='intro_ha'>";
		echo (("<div class='floatLeft quince'>Fecha</div><div class='cincuenta floatLeft'>".$fecha_arr."</div>"));
		echo "<br class='clearFloat'/>";
		echo (("<div class='floatLeft quince'>Hora</div><div class='cincuenta floatLeft'>".$hora_arr."</div>"));
		echo "<br class='clearFloat'/>";
	
		$sql1       = "SELECT * FROM clientes WHERE rut_cliente ='$rut_cliente'";
		$res1       = mysql_query($sql1,$link) or die(mysql_error());
		$registro1  = mysql_fetch_array($res1);
		$nombre_cliente = $registro1['raz_social'];
		echo (("<div class='floatLeft quince'>Razon Social</div><div class='cincuenta floatLeft'>".$nombre_cliente."</div>"));
		echo "<br class='clearFloat'/>";
	
		$direcc_cliente = $registro1['direcc_cliente'];
		echo (("<div class='floatLeft quince'>Direccion</div><div class='cincuenta floatLeft'>".$direcc_cliente."</div>"));
		echo "<br class='clearFloat'/>";
	
		$sql2       = "SELECT ciudad.ciudad 
						FROM  ciudad
							INNER JOIN clientes 
								on ciudad.cod_ciudad = clientes.cod_ciudad
						WHERE clientes.rut_cliente ='$rut_cliente'";
		$res2      = mysql_query($sql2,$link) or die(mysql_error());
		$registro2  = mysql_fetch_array($res2);
		$nombre_ciudad = $registro2['ciudad'];
		echo (("<div class='floatLeft quince'>Ciudad</div><div class='cincuenta floatLeft'>".$nombre_ciudad."</div>"));
		echo "<br class='clearFloat'/>";
		
		echo (("<div class='floatLeft quince'>Rut</div><div class='cincuenta floatLeft'>".$rut_cliente."</div>"));
		echo "<br class='clearFloat'/>";
		
		$nro_fono = $registro1['fono_cliente'];
		echo (("<div class='floatLeft quince'>Fono</div><div class='cincuenta floatLeft'>".$nro_fono."</div>"));
		echo "<br class='clearFloat'/>";
		
		$giro_cliente = $registro1['giro_cliente'];
		echo (("<div class='floatLeft quince'>Giro</div><div class='cincuenta floatLeft'>".$giro_cliente."</div>"));
		echo "<br class='clearFloat'/>";
		
		echo (("<div class='floatLeft quince'>Orden N°</div><div class='cincuenta floatLeft'>".$num_oc."</div>"));
		echo "<br class='clearFloat'/>";
		
		$sql3 = "SELECT * 
						FROM  obra
						WHERE cod_obra = '$cod_obra'";
		$res3      = mysql_query($sql3,$link) or die(mysql_error());
		$registro3  = mysql_fetch_array($res3);
		$nombre_obra = $registro3['nombre_obra'];
		echo (("<div class='floatLeft quince'>Nombre Obra</div><div class='cincuenta floatLeft'>".$nombre_obra."</div>"));
		echo "<br class='clearFloat'/>";
		
		$direcc_obra = $registro3['direcc_obra'];
		echo (("<div class='floatLeft quince'>Direc. Obra</div><div class='cincuenta floatLeft'>".$direcc_obra."</div>"));
		echo "<br class='clearFloat'/>";

		echo (("<div class='floatLeft quince'>Guia N°</div><div class='cincuenta floatLeft'><strong>".$num_gd."</strong></div>"));
		echo "<br class='clearFloat'/>";
		
		$sql_0001 = "select *
						from det_gd
						where num_gd = ".$num_gd;
		$res_0001 = mysql_query($sql_0001,$link) or die(mysql_error());
		echo "<div class='floatLeft quince'>Maquinaria</div>";
		echo "<div class='cincuenta floatLeft'><select id='equipo' name='equipo' style='font: 11px Verdana,Arial;'>";
		echo "<option value='XXX'>Seleccione alguna opción</option>";
		while ($row_0001 = mysql_fetch_array($res_0001)){
			$cod_equipo = $row_0001['cod_equipo'];
			$sql_0002 = "select *
							from equipo
							where cod_equipo = ".$cod_equipo;
			$res_0002 = mysql_query($sql_0002,$link) or die(mysql_error()); 
			$row_0002 = mysql_fetch_array($res_0002);
			echo "<option value=".$cod_equipo.">".htmlentities($row_0002['nombre_equipo'])."</option>";
			}
		echo "</select></div>";
		echo "<br class='clearFloat'/>";
		
		
	echo "</div>";
	}
/*
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
	
	echo "Equipos Asociados a la Guia de Despacho Nro.</div><div class='cincuenta floatLeft'>".$num_gd;
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
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']."</div>"));
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
			$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]."</div>"));
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
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]."</div>"));
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
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']."</div>"));
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
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['descripcion_estado']."</div>"));
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
				echo quitar_espacios_extra(htmlentities($row_equipo_temp['nombre_equipo']."</div>"));
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