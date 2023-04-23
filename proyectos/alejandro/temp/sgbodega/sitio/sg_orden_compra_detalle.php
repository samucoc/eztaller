<?php	
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_orden_compra_detalle.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$movim_ncorr = $data['movim_ncorr'];
	$nro_oc = $data['nro_oc'];
	
	$sql = "update sgcompras.movim set 
				movim_estado = 'FINALIZADO',
				movim_ncorr_ant =  '".$_SESSION["alycar_sgyonley_aumento"]."'
			where movim_ncorr = '".$_SESSION["alycar_sgyonley_aumento"]."' and movim_ncorr > 30000";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$sql = "update sgcompras.movim set 
				movim_estado = 'FINALIZADO',
				movim_ncorr_ant =  '".$_SESSION["alycar_sgyonley_aumento_bodega"]."'
			where movim_ncorr = '".$_SESSION["alycar_sgyonley_aumento_bodega"]."' and movim_ncorr > 30000";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addAlert("Registros guardados existosamente. El numero de ingreso es '".$movim_ncorr."'");

	unset($_SESSION["alycar_sgyonley_aumento"]);
	unset($_SESSION["alycar_sgyonley_aumento_bodega"]);
	
	$objResponse->addScript("window.parent.Form1.submit();");
	$objResponse->addScript("window.parent.hidePopWin(true);");
	
	return $objResponse->getXML();
	}
	
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
	global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
		
	if (@mysql_nurootm_rows($res) > 0) {
		$objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
			}
		}
		
	return $objResponse->getXML();
	}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$nro_oc	= $data['nro_oc'];

	$sql_busca = "select *
					from sgcompras.ordenes_compras
					where orden_compra_ncorr = '".$nro_oc."'";
	$res_busca = mysql_query($sql_busca,$conexion);
	$row_busca = mysql_fetch_array($res_busca);
	
	list($dia1,$mes1,$anio1) = explode('-', $row_busca['fecha']);	
	$fecha	= $anio1."/".$mes1."/".$dia1;
	$objResponse->addAssign("OBLI-txtFecha1", "innerHTML", $fecha);
	
	$sql_empresa = "SELECT * 
    			    FROM sgyonley.empresas
        			WHERE empe_rut = '".$row_busca['empresa']."'";
	$res_empresa = mysql_query($sql_empresa,$conexion) or die(mysql_error());
	$row_empresa = mysql_fetch_array($res_empresa);
	$objResponse->addAssign("OBLIempresa", "innerHTML", $row_empresa['empe_desc']);

	$sql_proveedor = "SELECT * 
						FROM sgbodega.proveedor
						WHERE PR_NCORR = '".$row_busca['proveedor']."'";
	$res_proveedor = mysql_query($sql_proveedor, $conexion);
	$row_proveedor = mysql_fetch_array($res_proveedor);
	$nombre_proveedor 	= $row_proveedor['PR_RAZON'];
	$rut_proveedor  	= $row_proveedor['PR_RUT'].'-'.dv($row_proveedor['PR_RUT']);
	$direccion_prov	 	= $row_proveedor['PR_DIRECCION'];
	$telefono_prov  	= $row_proveedor['PR_FONO1'];
	$email_prov 		= $row_proveedor['PR_MAIL'];
	$nc_prov			= $row_proveedor['PR_ATENCION'];
	$objResponse->addAssign("OBLIproveedores", "innerHTML", $nombre_proveedor);
	$objResponse->addAssign("rut_proveedor", "innerHTML", $rut_proveedor);
	$objResponse->addAssign("direccion_proveedor", "innerHTML", $direccion_prov);
	$objResponse->addAssign("telefono_prov", "innerHTML", $telefono_prov);
	$objResponse->addAssign("email_prov", "innerHTML", $email_prov);
	$objResponse->addAssign("nc_prov", "innerHTML", $nc_prov);

	$sql_tc = "SELECT * 
			FROM sgcompras.tipos_compras
			WHERE (`tipos_compras_ncorr` = '".$row_busca['tipo_compra']."' ) ";
	$res_tc = mysql_query($sql_tc, $conexion) or die(mysql_error());
	$row_tc = mysql_fetch_array($res_tc);
	$nombre_tc = $row_tc['nombre'];
	$objResponse->addAssign("OBLItipo_compra", "innerHTML", $nombre_tc);

	
	$sql_tc = "SELECT * 
			FROM sgcompras.forma_pago
			WHERE (`fp_ncorr` = '".$row_busca['forma_pago']."' ) ";
	$res_tc = mysql_query($sql_tc, $conexion) or die(mysql_error());
	$row_tc = mysql_fetch_array($res_tc);
	$nombre_tc = $row_tc['nombre'];
	$objResponse->addAssign("OBLIforma_pago", "innerHTML", $nombre_tc);

	$sql_tc = "SELECT * 
			FROM sgcompras.documentos
			WHERE (`documentos_ncorr` = '".$row_busca['documento']."' ) ";
	$res_tc = mysql_query($sql_tc, $conexion) or die(mysql_error());
	$row_tc = mysql_fetch_array($res_tc);
	$nombre_tc = $row_tc['nombre'];
	$objResponse->addAssign("OBLIdocumento", "innerHTML", $nombre_tc);

	$sql_tc = "SELECT * 
			FROM sgcompras.lugar_entrega
			WHERE (`le_ncorr` = '".$row_busca['lugar_entrega']."' ) ";
	$res_tc = mysql_query($sql_tc, $conexion) or die(mysql_error());
	$row_tc = mysql_fetch_array($res_tc);
	$nombre_tc = $row_tc['nombre'];
	$objResponse->addAssign("OBLIlugar_entrega", "innerHTML", $nombre_tc);

	$objResponse->addAssign("monto_total", "innerHTML", $row_busca['monto_total']);
	$objResponse->addAssign("neto", "innerHTML", $row_busca['neto']);
	$objResponse->addAssign("iva", "innerHTML", $row_busca['iva']);
	
	$str = "";
	$sql_detalle = "select distinct producto
					from sgcompras.oc_tiene_detalle
					where orden_compra_ncorr = '".$nro_oc."'
			and producto <> ''";
	$res_detalle = mysql_query($sql_detalle,$conexion);
	$str .= '<table align="left" class="tabla-alycar" style="width: 100%">';
	$arr_producto = "";
	$movim_ncorr = 0;
	$str .= '<tr align="left">
		<td class="tabla-alycar-label" align="center">Fecha</td>
		<td class="tabla-alycar-label" align="center">Factura</td>
		<td class="tabla-alycar-label" align="center">Guia Despacho</td>
		<td class="tabla-alycar-label" align="center">Producto</td>
		<td class="tabla-alycar-label" align="center">Cant. Recepcionada</td>
		<td class="tabla-alycar-label" align="center">Precio Unitario</td>
		<td class="tabla-alycar-label" align="center">Usuario</td>
		<td class="tabla-alycar-label" align="center">Fecha Digitacion</td>
		<td class="tabla-alycar-label" align="center"></td>
	</tr>';
	$no="";
	if (mysql_num_rows($res_detalle)>0){
		//$objResponse->addAlert(mysql_num_rows($res_detalle));
		while($row_detalle = mysql_fetch_array($res_detalle)){
			if(isset($_SESSION["alycar_sgyonley_aumento"]))	$movim_ncorr = $_SESSION["alycar_sgyonley_aumento"];
			else $movim_ncorr = 0;
			$sql_cant_rec="select *
					from sgcompras.oc_tiene_cant_rec
					where oc_ncorr = '".$nro_oc."'
						and codigo = '".$row_detalle['producto']."'
						and movim_ncorr = '".$movim_ncorr."'
					group by fecha_ingreso,factura,guia_despacho,
						codigo,detalle,precio,usuario,fecha_digitacion,movim_ncorr";
			$arr_producto .= $row_detalle['producto'].',';
			$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
			$cant_ingresada = $row_detalle['cantidad'];
			$cant_rec = 0;
			if (mysql_num_rows($res_cant_rec)>0){
				while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
					$aceptar = "xajax_EliminarFila(xajax.getFormValues('Form1'),".$row_cant_rec['oc_ncorr'].",".$row_detalle['producto'].",".$movim_ncorr.")";
					list($dia1,$mes1,$anio1) = explode('-', $row_cant_rec['fecha_ingreso']);	
					$fecha	= $anio1."/".$mes1."/".$dia1;
					$no .= $row_cant_rec['codigo'].',';
					$str .='<tr>
							<td class="tabla-alycar-texto" align="center">'.$fecha.'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['factura'].'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['guia_despacho'].'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['codigo'].' '.$row_cant_rec['detalle'].'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['cant_rec'].'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['precio'].'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['usuario'].'</td>
							<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['fecha_digitacion'].'</td>
							<td class="tabla-alycar-texto" align="center">'.
							'<input type="button" class="boton" name="btnAgregar" id="btnAgregar" value="Eliminar" onclick="'.$aceptar.'"/></td>
						</tr>';
					$movim_ncorr = $row_cant_rec['movim_ncorr'];
					$fecha_cant_rec = $row_cant_rec['fecha_ingreso'];
					}
				}
			}
		$sql_cant_rec="select *
			from sgcompras.oc_tiene_cant_rec
			where oc_ncorr = '".$nro_oc."'
			and codigo not in ( select distinct producto
										from sgcompras.oc_tiene_detalle
										where orden_compra_ncorr = '".$nro_oc."'
								and producto <> '')
			and movim_ncorr = '".$movim_ncorr."'
			group by fecha_ingreso,factura,guia_despacho,
			codigo,detalle,precio,usuario,fecha_digitacion,movim_ncorr";
		$arr_producto .= $row_detalle['producto'].',';
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_ingresada = $row_detalle['cantidad'];
		$cant_rec = 0;
		if (mysql_num_rows($res_cant_rec)>0){
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
				$aceptar = "xajax_EliminarFila(xajax.getFormValues('Form1'),".$row_cant_rec['oc_ncorr'].",".$row_cant_rec['codigo'].",".$movim_ncorr.")";
				list($dia1,$mes1,$anio1) = explode('-', $row_cant_rec['fecha_ingreso']);
				$fecha	= $anio1."/".$mes1."/".$dia1;
				$no .= $row_cant_rec['codigo'].',';
				$str .='<tr>
				<td class="tabla-alycar-texto" align="center">'.$fecha.'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['factura'].'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['guia_despacho'].'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['codigo'].' '.$row_cant_rec['detalle'].'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['cant_rec'].'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['precio'].'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['usuario'].'</td>
				<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['fecha_digitacion'].'</td>
				<td class="tabla-alycar-texto" align="center"><input type="button" class="boton" name="btnAgregar" id="btnAgregar" value="Eliminar" onclick="'.$aceptar.'"/></td>
				</tr>';
				$movim_ncorr = $row_cant_rec['movim_ncorr'];
				$fecha_cant_rec = $row_cant_rec['fecha_ingreso'];
				}
			}
		}
	else{
		if(isset($_SESSION["alycar_sgyonley_aumento"]))	$movim_ncorr = $_SESSION["alycar_sgyonley_aumento"];
		else $movim_ncorr = 0;
		$sql_cant_rec="select *
				from sgcompras.oc_tiene_cant_rec
				where oc_ncorr = '".$nro_oc."'
					and movim_ncorr = '".$movim_ncorr."'
				group by fecha_ingreso,factura,guia_despacho,
					codigo,detalle,precio,usuario,fecha_digitacion,movim_ncorr";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		if (mysql_num_rows($res_cant_rec)>0){
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
				$aceptar = "xajax_EliminarFila(xajax.getFormValues('Form1'),".$row_cant_rec['oc_ncorr'].",".$row_cant_rec['codigo'].",".$movim_ncorr.")";
				list($dia1,$mes1,$anio1) = explode('-', $row_cant_rec['fecha_ingreso']);	
				$fecha	= $anio1."/".$mes1."/".$dia1;
				$str .='<tr>
						<td class="tabla-alycar-texto" align="center">'.$fecha.'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['factura'].'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['guia_despacho'].'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['codigo'].' '.$row_cant_rec['detalle'].'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['cant_rec'].'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['precio'].'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['usuario'].'</td>
						<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['fecha_digitacion'].'</td>
						<td class="tabla-alycar-texto" align="center"><input type="button" class="boton" name="btnAgregar" id="btnAgregar" value="Eliminar" onclick="'.$aceptar.'"/></td>
					</tr>';
				}
			}
		}
	$str .="</table>";
	$objResponse->addAssign("detalle_producto", "innerHTML", $str);
	$objResponse->addAssign("movim_ncorr", "value", $movim_ncorr);

	if (isset($fecha_cant_rec)){	
		list($dia1,$mes1,$anio1) = explode('-', $fecha_cant_rec);	
		$fecha	= $anio1."/".$mes1."/".$dia1;
		if (($fecha!='--')&&($fecha!='//'))
			$objResponse->addAssign("fecha_cant_rec", "value", $fecha);
		}
	$forma_pago = $row_busca['forma_pago'];

	if ($forma_pago==1){
		$objResponse->addAssign("forma_pago", "innerHTML", 'Efectivo');
		$objResponse->addScript("document.getElementById('2').style.display='none';");
		$objResponse->addScript("document.getElementById('4').style.display='none';");
		$objResponse->addScript("document.getElementById('3').style.display='none';");
		}
	elseif ($forma_pago==2){
		$objResponse->addAssign("forma_pago", "innerHTML", 'Cheque');
		$objResponse->addScript("document.getElementById('2').style.display='table-row';");
		$objResponse->addScript("document.getElementById('4').style.display='none';");
		$objResponse->addScript("document.getElementById('3').style.display='none';");
		$sql_2 = "	select * 
					from sgcompras.oc_tiene_cheques
					where orden_compra_ncorr = '".$nro_oc."'";
		$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
		$str	=	"";
		while ($row_2 = mysql_fetch_array($res_2)){
			$str .=	"<tr>";
			$str .=	"<td class='tabla-alycar-label' align='center'>".$row_2['nro_cheque']."</td>";
				$sql = "SELECT * 
						FROM sgcaja.bancos
						WHERE (banc_ncorr = '".$row_2['banco']."' )";
				$res = mysql_query($sql, $conexion);
				$row = mysql_fetch_array($res);
				$banc_desc = $row['banc_desc'];
			$str .=	"<td class='tabla-alycar-label' align='center'>".$banc_desc."</td>";
				$sql = "SELECT * 
						FROM sgbanco.cuentas
						WHERE (CaId = '".$row_2['nro_cuenta']."' )";
				$res = mysql_query($sql, $conexion);
				$row = mysql_fetch_array($res);
				$banc_desc = $row['CaNumero'];
			$str .=	"<td class='tabla-alycar-label' align='center'>".$banc_desc."</td>";
			$str .=	"<td class='tabla-alycar-label' align='center'>".$row_2['fecha']."</td>";
			$str .=	"<td class='tabla-alycar-label' align='center'>".$row_2['valor']."</td>";
			$str .= "</tr>";
			}
		$objResponse->addAssign("detalle_cheques", "innerHTML", $str);
		}
	elseif ($forma_pago==3){
		$objResponse->addAssign("forma_pago", "innerHTML", 'Tarjeta de Credito');
		$objResponse->addScript("document.getElementById('3').style.display='table-row';");
		$objResponse->addScript("document.getElementById('2').style.display='none';");
		$objResponse->addScript("document.getElementById('4').style.display='none';");
		$sql_2 = "	select * 
					from sgcompras.oc_tiene_tc
					where oc_ncorr = '".$nro_oc."'";
		$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
		$row_2 = mysql_fetch_array($res_2);
	
			$sql = "SELECT * 
					FROM sgcaja.bancos
					WHERE (banc_ncorr = '".$row_2['banco']."' )";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_array($res);
			$banc_desc = $row['banc_desc'];

		$objResponse->addAssign("banco_tc", "value", $banc_desc);
		
			$sql = "SELECT * 
					FROM sgcompras.tarjeta_credito
					WHERE (tj_ncorr = '".$row_2['tipo_tarj_cred']."' )";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_array($res);
			$banc_desc = $row['nombre'];

		$objResponse->addAssign("tipo_tc", "value", $banc_desc);
		$objResponse->addAssign("cuotas_tc", "value", $row_2['cuotas']);
	
		}
	elseif ($forma_pago==4){
		$objResponse->addAssign("forma_pago", "innerHTML", 'Transferencia');
		$objResponse->addScript("document.getElementById('4').style.display='table-row';");
		$objResponse->addScript("document.getElementById('3').style.display='none';");
		$objResponse->addScript("document.getElementById('2').style.display='none';");

		$sql_2 = "	select * 
					from sgcompras.oc_tiene_transferencias
					where oc_ncorr = '".$nro_oc."'";
		$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
		$row_2 = mysql_fetch_array($res_2);
	
			$sql = "SELECT * 
					FROM sgcaja.bancos
					WHERE (banc_ncorr = '".$row_2['banco']."' )";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_array($res);
			$banc_desc = $row['banco_tr'];

		$objResponse->addAssign("banco_tr", "value", $banc_desc);
		$objResponse->addAssign("banco_tr", "value", $banc_desc);

		}
	elseif ($forma_pago==5){
		$objResponse->addAssign("forma_pago", "innerHTML", 'Pago Pendiente');
		}
	$objResponse->addAssign("direccion_entrega", "innerHTML", $row_busca['direccion']);
	$objResponse->addAssign("OBLIplazo_dias", "innerHTML", $row_busca['tiempo_entrega']);
	$objResponse->addAssign("observacion", "innerHTML", $row_busca['descripcion']);

	
	return $objResponse->getXML();
	}
function ActualizarFila($data,$id){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$cant_recibida = $data['cant_recibida_'.$id];
	
	$sql_buscar ="select *
					from sgcompras.oc_tiene_detalle
					where oc_detalle_ncorr = '".$id."'";
	$res_buscar = mysql_query($sql_buscar,$conexion) or die(mysql_error());
	$row_buscar = mysql_fetch_array($res_buscar);
	$cant_ant = $row_buscar['cant_recibida'];
	if ($cant_ant<$cant_recibida){
		$update = "update sgcompras.oc_tiene_detalle
						set cant_recibida = '".$cant_recibida."'
						where oc_detalle_ncorr = '".$id."'";
		$res_update = mysql_query($update,$conexion) or die(mysql_error());
		$objResponse->addScript("document.Form1.submit();");
		}
	else{
		$objResponse->addAlert("Cantidad menor o igual a la anterior.");
		}
	return $objResponse->getXML();
	}
function AgregarCantRec($data){
	global $conexion;
	
	$objResponse = new xajaxResponse('ISO-8859-1');

	$oc_ncorr			= 	$data['nro_oc'];
	$codigo				= 	$data['txtCodProducto'];
	$detalle			= 	$data['txtDescProducto'];
	$cant_rec			=	$data['cant_rec'];
	$precio				=	$data['precio'];
	$movim_ncorr			=	$data['movim_ncorr'];
	$factura			=	$data['factura'];
	$guia_despacho			=	$data['guia_despacho'];

	if ($cant_rec>0){

		$sql_suma = "select sum(cantidad) as resto
				from sgcompras.oc_tiene_detalle
				where orden_compra_ncorr = '".$oc_ncorr."' and producto = '".$codigo."'";
		$res_suma = mysql_query($sql_suma,$conexion) or die(mysql_error());
		$row_suma = mysql_fetch_array($res_suma);
		$cant_ingresada = $row_suma['resto'];

		$sql_cant_rec="select sum(cant_rec) as resto
				from sgcompras.oc_tiene_cant_rec
				where oc_ncorr = '".$oc_ncorr."' and codigo = '".$codigo."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$row_cant_rec = mysql_fetch_array($res_cant_rec);
		$cant_recibida = $row_cant_rec['resto'];
		
		//$objResponse->addAlert($cant_ingresada ."-". $cant_recibida);
		
		$total = $cant_ingresada - $cant_recibida;
		if (($total>0)||($cant_ingresada==0)){
		list($dia1,$mes1,$anio1) = explode('/', $data['fecha_cant_rec']);	
		$fecha	= $anio1."-".$mes1."-".$dia1;

		$sql_detalle = "select *
						from sgcompras.oc_tiene_detalle
						where orden_compra_ncorr = '".$oc_ncorr."'
							and producto = '".$codigo."'";
		$res_detalle = mysql_query($sql_detalle,$conexion);
		//$objResponse->addAlert("($fecha != '')&&($codigo != '')&&($cant_rec != '')&&($precio != '')");
		if (($fecha != '')&&($codigo != '')&&($cant_rec != '')&&($precio != '')){
			//$objResponse->addAlert(mysql_num_rows($res_detalle));
			//if (($cant_ingresada>0)){
				$cant_ingresada = 0;
				$sql_suma = "select sum(cantidad) as resto
							from sgcompras.oc_tiene_detalle
							where orden_compra_ncorr = '".$oc_ncorr."'
								and producto = '".$codigo."'";
				$res_suma = mysql_query($sql_suma,$conexion) or die(mysql_error());
				$row_suma = mysql_fetch_array($res_suma);
				$cant_ingresada = $row_suma['resto'];
		
				$sql_cant_rec="select sum(cant_rec) as resto
								from sgcompras.oc_tiene_cant_rec
								where oc_ncorr = '".$oc_ncorr."'
									and codigo = '".$codigo."'";
				$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
				$row_cant_rec = mysql_fetch_array($res_cant_rec);
				$cant_recibida = $row_cant_rec['resto'] + $cant_rec;
				//$objResponse->addAlert($cant_ingresada." -> ".$cant_recibida);
				if (isset($cant_ingresada)){
					
					}
				else{
					$cant_ingresada = 0;
					}
				if (($cant_ingresada>$cant_recibida)||($cant_ingresada==$cant_recibida)||($cant_ingresada==0)){
					
					// bloqueo los ingresos posteriores a la fecha de cierre.
					$sql_cierre			= 	"select cier_fecha as ultimocierre from cierres order by cier_fecha desc limit 1";
					$res_cierre			= 	mysql_query($sql_cierre, $conexion);
					$ult_cierre 		= 	@mysql_result($res_cierre,0,"ultimocierre");
				
					$dias_dif = 0;
					$sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
					$res_dif			=	mysql_query($sql_dif, $conexion);
					//$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
					//$objResponse->addAlert($dias_dif);
					if (($dias_dif >= 0)||($_SESSION["alycar_sgyonley_bodega"]==5)){
					
						$sql_detalle = "select fecha
										from sgcompras.ordenes_compras
										where orden_compra_ncorr = '".$oc_ncorr."'";
						$res_detalle = mysql_query($sql_detalle,$conexion);
						$row_detalle = mysql_fetch_array($res_detalle);		
						$fecha_oc  	 = $row_detalle['fecha'];
					
						$sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$fecha_oc."') as dias_dif";
						$res_dif			=	mysql_query($sql_dif, $conexion);
						//$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
	
						if (($dias_dif >= 0)||($_SESSION["alycar_sgyonley_bodega"]==5)){
							$sql_detalle = "select fecha_ingreso
											from sgcompras.oc_tiene_cant_rec
											where oc_ncorr = '".$oc_ncorr."'
												and movim_ncorr = '".$movim_ncorr."'
											order by fecha_ingreso
											limit 0,1";
							$res_detalle = mysql_query($sql_detalle,$conexion);
							$row_detalle = mysql_fetch_array($res_detalle);		
							$fecha_oc  	 = $row_detalle['fecha_ingreso'];
						
							$sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$fecha_oc."') as dias_dif";
							$res_dif			=	mysql_query($sql_dif, $conexion);
							$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
							if (($dias_dif >= 0)||($fecha_oc=='')){
								
								$fecha_ingreso		=	$fecha;
								$usuario			= 	$_SESSION['alycar_usuario'];
								$fecha_digitacion	= 	date('Y-m-d H:i:s');
							
								$sql_busca = "select *
												from sgcompras.ordenes_compras
												where orden_compra_ncorr = '".$oc_ncorr."'";
								$res_busca = mysql_query($sql_busca,$conexion);
								$row_busca = mysql_fetch_array($res_busca);
						
								$sql_proveedor = "SELECT * 
													FROM sgbodega.proveedor
													WHERE PR_NCORR = '".$row_busca['proveedor']."'";
								$res_proveedor = mysql_query($sql_proveedor, $conexion);
								$row_proveedor = mysql_fetch_array($res_proveedor);
								$rut_proveedor  	= $row_proveedor['PR_RUT'];
							
								$ncorr = 0;
								$movim_bodega = $_SESSION['alycar_sgyonley_bodega'];
								//echo $_SESSION["alycar_sgyonley_aumento"];
								$sql = "";
								$empe_rut = $row_busca['empresa'];
								$movim_fecha = $fecha_ingreso;
								$tdoc_ncorr = 2;
								$movim_numdoc = $oc_ncorr;
								$usu_id = $usuario;
								$movim_obs = $data['observacion'];

								if ((!isset($_SESSION["alycar_sgyonley_aumento"])&&($_SESSION["alycar_sgyonley_bodega"]!=5))||
									(($_SESSION["alycar_sgyonley_aumento"]=='0')&&($_SESSION["alycar_sgyonley_bodega"]!=5))){
									$sql = "insert into sgcompras.movim (movim_bodega,movim_tipo,empe_rut,movim_fecha,pr_rut,tdoc_ncorr,movim_numdoc,movim_obs,usu_id,movim_estado,movim_fecha_dig)
												values (
									'".$movim_bodega."','1','".$row_busca['empresa']."','".$fecha_ingreso."','".$rut_proveedor."','2','".$oc_ncorr."',
									'".$row_busca['descripcion']."','".$usuario."','EN GENERACION','".$fecha_digitacion."')";
									$res = mysql_query($sql, $conexion);
									$ncorr = mysql_insert_id($conexion);
								
									$_SESSION["alycar_sgyonley_aumento"] = $ncorr;
									}
								else{
									if ((!isset($_SESSION["alycar_sgyonley_aumento"])&&($_SESSION["alycar_sgyonley_bodega"]==5))||
										(($_SESSION["alycar_sgyonley_aumento"]=='0')&&($_SESSION["alycar_sgyonley_bodega"]==5))){
										$vend_ncorr = $data['OBLItxtCodVendedor'];
										if ($vend_ncorr!=''){
												$sql = "insert into sgcompras.movim (movim_bodega,movim_tipo,empe_rut,movim_fecha,vend_ncorr,tdoc_ncorr,movim_numdoc,movim_obs,usu_id,movim_fecha_dig)
														values (
														'".$movim_bodega."','2','".$row_busca['empresa']."','".$fecha_ingreso."','".$vend_ncorr."','2','".$oc_ncorr."','".$movim_obs."','".$usu_id."','".$fecha_digitacion."')";
												// ingresa el articulo
												$res = mysql_query($sql, $conexion);
												$ncorr = mysql_insert_id($conexion);
												$movim_ncorr		=	$ncorr;
											}
										$_SESSION["alycar_sgyonley_aumento"] = $ncorr;
										$sql_bodega = "insert into sgcompras.movim (movim_bodega,movim_tipo,empe_rut,movim_fecha,vend_ncorr,tdoc_ncorr,movim_numdoc,movim_obs,usu_id,movim_fecha_dig)
												values (
												'".$movim_bodega."','1','".$row_busca['empresa']."','".$fecha_ingreso."','','2','".$oc_ncorr."','".$movim_obs."','".$usu_id."','".$fecha_digitacion."')";
										// ingresa el articulo
										$res_bodega = mysql_query($sql_bodega, $conexion);
										$ncorr_bodega = mysql_insert_id($conexion);
										$movim_ncorr_bodega		=	$ncorr_bodega;
										$_SESSION["alycar_sgyonley_aumento_bodega"] = $ncorr_bodega;
										}
									}
								
								$movim_ncorr		=	$_SESSION["alycar_sgyonley_aumento"];
								$movim_ncorr_bodega		=	$_SESSION["alycar_sgyonley_aumento_bodega"];
										
								$mdet_subneto = $precio*$cant_rec;
								
								//$sql_det = "insert into sgcompras.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_valor,mdet_cantidad,mdet_subneto,mdet_descuento,mdet_subtotal) 
								//values ('".$movim_ncorr."','".$codigo."','".$detalle."','N','".$precio."','".$cant_rec."','".$mdet_subneto."','0','".$mdet_subneto."')";
								//$res_det = mysql_query($sql_det, $conexion);
								
								if ($_SESSION["alycar_sgyonley_aumento"]!=''){
									$sql_buscar ="insert into sgcompras.oc_tiene_cant_rec(`oc_ncorr`, movim_ncorr, `codigo`, `detalle`, `cant_rec`, `precio`, `fecha_ingreso`, `usuario`, `fecha_digitacion`, `factura`, `guia_despacho`) 
								values ('$oc_ncorr','$movim_ncorr','$codigo','$detalle','$cant_rec','$precio','$fecha_ingreso','$usuario','$fecha_digitacion','$factura','$guia_despacho')";
									$res_buscar = mysql_query($sql_buscar,$conexion) or die(mysql_error());						
									$oc_rec_ncorr = mysql_insert_id($conexion);
									
									$sql_update = "update sgcompras.oc_tiene_cant_rec set
										movim_ncorr = '".$movim_ncorr."'
										where oc_rec_ncorr = '$oc_rec_ncorr'";
									$res_update = mysql_query($sql_update, $conexion);
										
									$sql_det = "insert into sgcompras.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_valor,mdet_cantidad,mdet_subneto,mdet_descuento,mdet_subtotal)
									values ('".$movim_ncorr."','".$codigo."','".$detalle."','N','".$precio."','".$cant_rec."','".$mdet_subneto."','0','".$mdet_subneto."')";
									$res_det = mysql_query($sql_det, $conexion);
									
									$precio_usado = $precio/2;
									$sql_buscar ="INSERT INTO sgbodega.articulos_costos(`codigo`, `descripcion`, `nuevo`, `usado`, `fecha_dig`) 
													VALUES ('".$codigo."','".$detalle."','".$precio."','".$precio_usado."','".date("Y-m-d H:i:s")."')";
									$res_buscar = mysql_query($sql_buscar,$conexion) or die(mysql_error());						
									
									}
								
								/*
									if ($_SESSION["alycar_sgyonley_bodega"] ==5){
										$es_bodega = $data['es_bodega'];
										$sql = "";
										$empe_rut = $row_busca['empresa'];
										$movim_fecha = $fecha_ingreso;
										$tdoc_ncorr = 2;
										$movim_numdoc = $oc_ncorr;
										$movim_obs ; 
										$usu_id = $usuario; 
										if ($data['OBLItxtCodVendedor']==''){
											$sql="";		
											if (!isset($_SESSION["alycar_sgyonley_aumento"])){
											
											 * 
											 if ($movim_bodega!='5'){																									
													$sql = "insert into sgcompras.movim (movim_bodega,movim_bodega_tras,movim_tipo,empe_rut,movim_fecha,pr_rut,tdoc_ncorr,movim_numdoc,movim_obs,usu_id,movim_fecha_dig)
															values (
															'".$movim_bodega."','5','8','".$empe_rut."','".$movim_fecha."','".$pr_rut."','".$tdoc_ncorr."','".$movim_numdoc."',
															'".$movim_obs."','".$usu_id."','".$fecha_digitacion."')";
													}
												else{
													$sql = "insert into sgcompras.movim (movim_bodega,movim_tipo,empe_rut,movim_fecha,pr_rut,tdoc_ncorr,movim_numdoc,movim_obs,usu_id,movim_estado,movim_fecha_dig)
													values (
													'".$movim_bodega."','1','".$empe_rut."','".$movim_fecha."','".$pr_rut."','".$tdoc_ncorr."','".$movim_numdoc."',
															'".$movim_obs."','".$usu_id."','".$fecha_digitacion."')";
													}
												}
												echo $sql;
											//$res = mysql_query($sql, $conexion);
											$ncorr = mysql_insert_id($conexion);
											// ingresa el articulo
											$_SESSION["alycar_sgyonley_aumento"] = $ncorr;
											$movim_ncorr		=	$ncorr;
											
											}
										else{
											$vend_ncorr = $data['OBLItxtCodVendedor'];
											if (!isset($_SESSION["alycar_sgyonley_aumento"])){
												echo $sql = "insert into sgcompras.movim (movim_bodega,movim_tipo,empe_rut,movim_fecha,vend_ncorr,movim_obs,usu_id,movim_fecha_dig)
													values (
													'".$movim_bodega."','2','".$empe_rut."','".$movim_fecha."','".$vend_ncorr."','".$movim_obs."','".$usu_id."','".$fecha_digitacion."')";
												// ingresa el articulo
												//$res = mysql_query($sql, $conexion);
												$ncorr = mysql_insert_id($conexion);
												$movim_ncorr		=	$ncorr;
												$_SESSION["alycar_sgyonley_aumento"] = $ncorr;
												
												$sql_update = "update sgcompras.oc_tiene_cant_rec set
																movim_ncorr = '".$movim_ncorr."'
																where oc_rec_ncorr = '$oc_rec_ncorr'";
												//$res_update = mysql_query($sql_update, $conexion);
												}
											}
											
										}
										*/
									if (isset($_SESSION["alycar_sgyonley_aumento_bodega"])){
										$sql_det_bodega = "insert into sgcompras.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_valor,mdet_cantidad,mdet_subneto,mdet_descuento,mdet_subtotal)
													values ('".$movim_ncorr_bodega."','".$codigo."','".$detalle."','N','".$precio."','".$cant_rec."','".$mdet_subneto."','0','".$mdet_subneto."')";
										$res_det_bodega= mysql_query($sql_det_bodega, $conexion);
										}
									$mdet_ncorr = mysql_insert_id();
									$sql = "update sgcompras.movim_detalle set
									mdet_conf_tras	= 	'1'
									where mdet_ncorr  = '".$mdet_ncorr."'";
									
									$res = mysql_query($sql, $conexion);
									
									$sql_1 = "select count(movim_ncorr) as nc
									from sgcompras.movim_detalle
									where movim_ncorr in (select movim_ncorr
															from sgcompras.movim_detalle
															where mdet_ncorr  = '".$mdet_ncorr."' and 
																movim_ncorr in (select movim_ncorr
																				from sgcompras.movim
																				where movim_estado = 'FINALIZADO' and 
																					movim_ncorr in (select movim_ncorr
																									from sgcompras.movim_detalle
																									where mdet_ncorr  = '".$mdet_ncorr."')
																				)
														 )";
									$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
									$row_1 = mysql_fetch_array($res_1);
									$total = $row_1['nc'];
									
									$sql_1 = "select count(movim_ncorr) as mc
									from sgcompras.movim_detalle
									where movim_ncorr in (select movim_ncorr
									from sgcompras.movim_detalle
									where mdet_ncorr  = '".$mdet_ncorr."' and 
																movim_ncorr in (select movim_ncorr
																				from sgcompras.movim
																				where movim_estado = 'FINALIZADO' and 
																					movim_ncorr in (select movim_ncorr
																									from sgcompras.movim_detalle
																									where mdet_ncorr  = '".$mdet_ncorr."')
																				))
									and mdet_conf_tras	= 	'1'";
									$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
									$row_1 = mysql_fetch_array($res_1);
									
									$resto = $row_1['mc'];
										
									$total = $total-$resto;
									if ($total==0){
										$sql = "update sgcompras.movim set
										movim_estado	= 	'FINALIZADO',
										movim_ncorr_ant	= 	'".$_SESSION["alycar_sgyonley_aumento"] ."'
										where movim_ncorr in (select movim_ncorr
										from sgcompras.movim_detalle
										where mdet_ncorr  = '".$mdet_ncorr."') and movim_ncorr > 30000";
									
										$res = mysql_query($sql, $conexion);
										}
																			
								$sql_update = "update sgcompras.ordenes_compras
									set estado = 'RECEPCION-PENDIENTE-PRODUCTOS'
									where orden_compra_ncorr = '".$oc_ncorr."'";
								$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								$objResponse->addAssign('txtCodProducto','value','');
								$objResponse->addAssign('txtDescProducto','value','');
								$objResponse->addAssign("cant_rec", "value", '');
								$objResponse->addAssign("precio", "value", '');
								$objResponse->addScript("xajax_CargaPagina(xajax.getFormValues('Form1'))");
								$sql_suma = "select sum(cantidad) as resto
												from sgcompras.oc_tiene_detalle
												where orden_compra_ncorr = '".$oc_ncorr."'";
								$res_suma = mysql_query($sql_suma,$conexion) or die(mysql_error());
								$row_suma = mysql_fetch_array($res_suma);
								$cant_ingresada = $row_suma['resto'];

								$sql_cant_rec="select sum(cant_rec) as resto
												from sgcompras.oc_tiene_cant_rec
												where oc_ncorr = '".$oc_ncorr."'";
								$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
								$row_cant_rec = mysql_fetch_array($res_cant_rec);
								$cant_recibida = $row_cant_rec['resto'];
	
								$total = $cant_ingresada - $cant_recibida;
								if ($total==0){
									$sql_update = "update sgcompras.ordenes_compras
													set estado = 'RECEPCION-PRODUCTOS'
													where orden_compra_ncorr = '".$oc_ncorr."'";
									$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
									}
								$objResponse->addScript("document.getElementById('txtCodProducto').focus();");
								}
								else{
									$objResponse->addAlert("Error de ingreso 1");
								}
							}
							else{
								$objResponse->addAlert("Error de ingreso 2");
							}
						}
						else{
							$objResponse->addAlert("Error de ingreso 3");
							}
					}
					else{
						$objResponse->addAlert("Error de ingreso 4");
						}
			/*	}
			else{
				$objResponse->addAlert("Error de ingreso 5");
				}
				*/
			}
		else{
			$objResponse->addAlert("Error de ingreso 6");
			}
		}
	else{
		$objResponse->addAlert("Error de ingreso 7");
		}
	}
	return $objResponse->getXML();
	}
function EliminarFila($data,$oc,$id,$movim_ncorr){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$sql_002 = "delete from sgcompras.movim_detalle 
				where mdet_codigo = '".$id."' and movim_ncorr = '".$movim_ncorr."'";
	$res_002 = mysql_query($sql_002,$conexion);

	$update = "delete from sgcompras.oc_tiene_cant_rec
					where oc_ncorr = '".$oc."' and codigo = '".$id."' and movim_ncorr = '".$movim_ncorr."' ";
	$res_update = mysql_query($update,$conexion) or die(mysql_error());
	$objResponse->addScript("document.Form1.submit();");

	return $objResponse->getXML();
	}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	
	if ($tabla == 'sgbodega.tallas'){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta, ta_venta2 from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
	}else{
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	$sql_detalle = "select *
					from sgcompras.oc_tiene_detalle
					where orden_compra_ncorr = '".$c_and."'
						and producto = '".$ncorr."'";
	$res_detalle = mysql_query($sql_detalle,$conexion) or die(mysql_error());
	$row_detalle = mysql_fetch_array($res_detalle);
	$objResponse->addAssign("precio", "value", $row_detalle['precio']);
	
	
	return $objResponse->getXML();
	}
function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
		global $conexion;
	
		$objResponse = new xajaxResponse('ISO-8859-1');
	
		$objResponse->addAssign("$obj1", "value", $campo1);
		$objResponse->addAssign("$obj2", "value", $campo2);
	
		return $objResponse->getXML();
	}
	
$xajax->registerFunction("MuestraRegistro");	
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprimir");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("ActualizarFila");
$xajax->registerFunction("AgregarCantRec");
$xajax->registerFunction("EliminarFila");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nro_oc',$_GET['nro_oc']);
$miSmarty->assign('fecha',$_POST['fecha_cant_rec']);
$miSmarty->assign('factura',$_POST['factura']);
$miSmarty->assign('guia_despacho',$_POST['guia_despacho']);
$miSmarty->assign('cod_vendedor',$_POST['OBLItxtCodVendedor']);
$miSmarty->assign('nombre_vendedor',$_POST['OBLItxtDescVendedor']);

$miSmarty->display('sg_orden_compra_detalle.tpl');

?>

