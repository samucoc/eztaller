<?php	
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_orden_compra_solicitud.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');

//		$arr_repuesto 		= explode(',',$data['arr_repuesto']);
//		$arr_nom_repuesto 	= explode(',',$data['arr_nom_repuesto']);
//		$arr_pu 			= explode(',',$data['arr_pu']);
//		$arr_cant 			= explode(',',$data['arr_cant']);
		$id = $data['nro_oc'];
//		if ($arr_repuesto[0]!=''){
//		for($i=0; $i< count($arr_repuesto); $i++){
//			$sql_2 = "insert into sgcompras.oc_tiene_detalle(`orden_compra_ncorr`, `producto`, `detalle_producto`, `cantidad`, `precio`) 
//						values ('".$id."', '".$arr_repuesto[$i]."', '".$arr_nom_repuesto[$i]."', '".$arr_cant[$i]."', '".$arr_pu[$i]."')"	;
//			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
//			}
//		}
		
	$sql_suma = "select sum(cantidad) as resto
					from sgcompras.oc_tiene_detalle
					where orden_compra_ncorr = '".$id."'";
	$res_suma = mysql_query($sql_suma,$conexion) or die(mysql_error());
	$row_suma = mysql_fetch_array($res_suma);
	$cant_ingresada = $row_suma['resto'];

	$sql_cant_rec="select sum(cant_rec) as resto
					from sgcompras.oc_tiene_cant_rec
					where oc_ncorr = '".$id."'";
	$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
	$row_cant_rec = mysql_fetch_array($res_cant_rec);
	$cant_recibida = $row_cant_rec['resto'];
	
	$total = $cant_ingresada - $cant_recibida;
	if ($total==0){
		$sql_update = "update sgcompras.ordenes_compras
						set estado = 'RECEPCION-PRODUCTOS'
						where orden_compra_ncorr = '".$id."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
		$objResponse->addScript("alert('Productos Recepcionados')");
		$objResponse->addScript("window.history.back();");
		}
	else{
		$objResponse->addScript("alert('Falta Recepcionar Productos')");
		$objResponse->addScript("document.Form1.submit();");
		} 
	
	return $objResponse->getXML();
	}

function Imprimir($data,$id){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$oc_ncorr = $id;
	$objResponse->addScript("showPopWin('sg_orden_compra_imprime.php?oc_ncorr=$oc_ncorr', 'Imprime Orden Compra', 800, 600, null);");
	$objResponse->addScript("document.getElementById('btnGrabar').style.display='none';");
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
	
	return $objResponse->getXML();
	}
	
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
	global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
		
	if (@mysql_num_rows($res) > 0) {
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
	$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
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
			FROM sgcompras.opcion_compras
			WHERE (`oc_ncorr` = '".$row_busca['opcion_compra']."' ) ";
	$res_tc = mysql_query($sql_tc, $conexion) or die(mysql_error());
	$row_tc = mysql_fetch_array($res_tc);
	$nombre_tc = $row_tc['nombre'];
	$objResponse->addAssign("OBLIopcion_compra", "innerHTML", $nombre_tc);
	$objResponse->addAssign("folio_compra", "innerHTML", $row_busca['folio_compra']);

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
	$sql_detalle = "select *
					from sgcompras.oc_tiene_detalle
					where orden_compra_ncorr = '".$nro_oc."'";
	$res_detalle = mysql_query($sql_detalle,$conexion);
	$str .= '<table align="left" class="tabla-alycar" style="width: 100%">';
	$arr_producto = "";
	$str .= '		<tr align="left">
			<td class="tabla-alycar-label" align="center">Producto</td>
			<td class="tabla-alycar-label" align="center">Cant. segun orden de compra</td>
			<td class="tabla-alycar-label" align="center">Precio Unitario</td>
			<td class="tabla-alycar-label" align="center">Total</td>
		</tr>';
	while($row_detalle = mysql_fetch_array($res_detalle)){
		//cod producto, nombre producto, cantidad pedida, cantidad llegada, precio unitario, eliminar||actualizar
		$str .= "<tr>";
		$str .=	"<td class='tabla-alycar-texto' align='left'>".$row_detalle['producto']."";
		$str .=	" ".$row_detalle['detalle_producto']."</td>";
		$str .=	"<td class='tabla-alycar-texto' align='left'>".$row_detalle['cantidad']."</td>";
		$str .=	"<td class='tabla-alycar-texto' align='left'>".$row_detalle['precio']."</td>";
		$total = $row_detalle['precio'] * $row_detalle['cantidad'];
		$str .=	"<td class='tabla-alycar-texto' align='left'>".$total."</td>";
		$str .= "</tr>";
		}
	$sql_cant_rec="select *
					from sgcompras.oc_tiene_cant_rec
					where oc_ncorr = '".$nro_oc."'
						and movim_ncorr in (select movim_ncorr
											from sgcompras.movim
											where movim_estado = 'FINALIZADO')";
	$arr_producto .= $row_detalle['producto'].',';
	$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
	$cant_ingresada = $row_detalle['cantidad'];
	$cant_rec = 0;
	$str .= '<tr><td  colspan="5"><table align="left" class="tabla-alycar" style="width: 100%">';
	if (mysql_num_rows($res_cant_rec)>0){
		$str .= '<tr align="left">
			<td class="tabla-alycar-label" align="center" colspan="7">Productos Ingresados por Orden de Compra</td>
		</tr>';
		$str .= '<tr align="left">
			<td class="tabla-alycar-label" align="center">Nro Guia</td>
			<td class="tabla-alycar-label" align="center">Fecha</td>
			<td class="tabla-alycar-label" align="center">Factura</td>
			<td class="tabla-alycar-label" align="center">Guia Despacho</td>
			<td class="tabla-alycar-label" align="center">Producto</td>
			<td class="tabla-alycar-label" align="center">Cant. Recepcionada</td>
			<td class="tabla-alycar-label" align="center">Precio Unitario</td>
			<td class="tabla-alycar-label" align="center">Usuario</td>
			<td class="tabla-alycar-label" align="center">Fecha Digitacion</td>
		</tr>';
		while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
			list($dia1,$mes1,$anio1) = explode('-', $row_cant_rec['fecha_ingreso']);	
			$fecha	= $anio1."/".$mes1."/".$dia1;
			$str .='<tr>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['movim_ncorr'].'</td>
					<td class="tabla-alycar-texto" align="center">'.$fecha.'</td>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['factura'].'</td>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['guia_despacho'].'</td>

					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['codigo'].' '.$row_cant_rec['detalle'].'</td>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['cant_rec'].'</td>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['precio'].'</td>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['usuario'].'</td>
					<td class="tabla-alycar-texto" align="center">'.$row_cant_rec['fecha_digitacion'].'</td>
				</tr>';
			}
		$str .= "</table></td></tr>";
		}
	$str .="</table>";
	$objResponse->addAssign("detalle_producto", "innerHTML", $str);

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
	$factura			=	$data['factura'];
	$guia_despacho			=	$data['guia_despacho'];

		list($dia1,$mes1,$anio1) = explode('/', $data['fecha_cant_rec']);	
		$fecha	= $anio1."-".$mes1."-".$dia1;
	
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
		if (!isset($_SESSION["alycar_sgyonley_aumento"])){
			$sql = "insert into sgbodega.movim (movim_tipo,empe_rut,movim_fecha,pr_rut,tdoc_ncorr,movim_numdoc,movim_obs,usu_id,movim_estado,movim_fecha_dig)
						values (
			'1','".$row_busca['empresa']."','".$fecha_ingreso."','".$rut_proveedor."','2','".$oc_ncorr."',
			'".$row_busca['descripcion']."','".$usuario."','FINALIZADO','".$fecha_digitacion."')";
				
			//$res = mysql_query($sql, $conexion);
			$ncorr = mysql_insert_id($conexion);
			
			$_SESSION["alycar_sgyonley_aumento"] = $ncorr;
			}
			
		// ingresa el articulo
		if (isset($_SESSION["alycar_sgyonley_aumento"]))
		$movim_ncorr		=	$_SESSION["alycar_sgyonley_aumento"];
		$mdet_subneto = $precio*$cant_rec;
		$sql_det = "insert into sgbodega.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_valor,mdet_cantidad,mdet_subneto,mdet_descuento,mdet_subtotal) 
		values ('".$movim_ncorr."','".$codigo."','".$detalle."','N','".$precio."','".$cant_rec."','".$mdet_subneto."','0','".$mdet_subneto."')";
		//$res_det = mysql_query($sql_det, $conexion);
		
		$sql_buscar ="insert into sgcompras.oc_tiene_cant_rec(`oc_ncorr`, movim_ncorr, `codigo`, `detalle`, `cant_rec`, `precio`, `fecha_ingreso`, `usuario`, `fecha_digitacion`, `factura`, `guia_despacho`) 
						values ('$oc_ncorr','$movim_ncorr','$codigo','$detalle','$cant_rec','$precio','$fecha_ingreso','$usuario','$fecha_digitacion','$factura','$guia_despacho')";
		$res_buscar = mysql_query($sql_buscar,$conexion) or die(mysql_error());
			
		$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
	}
function EliminarFila($data,$id){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$update = "delete from sgcompras.oc_tiene_detalle
					where oc_detalle_ncorr = '".$id."'";
	$res_update = mysql_query($update,$conexion) or die(mysql_error());
	$objResponse->addScript("document.Form1.submit();");

	return $objResponse->getXML();
	}
	
	function CargaProductos($data){
		global $conexion;
		$objResponse = new xajaxResponse('ISO-8859-1');
	
		$oc_ncorr			= 	$data['nro_oc'];
		unset($_SESSION["alycar_sgyonley_aumento"]);
		$objResponse->addScript("showPopWin('sg_orden_compra_detalle.php?nro_oc=".$oc_ncorr."', 'Detalle Productos Orden Compra', 1000, 400, null);");
	
		return $objResponse->getXML();
	}

function FinalizarOC($data){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$oc_ncorr			= 	$data['nro_oc'];
	$sql_update = "update sgcompras.ordenes_compras
	set estado = 'RECEPCION-PRODUCTOS'
	where orden_compra_ncorr = '".$oc_ncorr."'";
	$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
	
	return $objResponse->getXML();
	}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprimir");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("ActualizarFila");
$xajax->registerFunction("AgregarCantRec");
$xajax->registerFunction("EliminarFila");
$xajax->registerFunction("CargaProductos");
$xajax->registerFunction("FinalizarOC");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nro_oc',$_GET['nro_oc']);
$miSmarty->display('sg_orden_compra_solicitud.tpl');

?>

