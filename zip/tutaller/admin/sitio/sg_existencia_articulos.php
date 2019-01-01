<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

/* EL CODIGO DEL PRODUCTO SE ARMAR� POR:
- COD. MARCA
- COD. FAMILIA
- COD. SUBFAMILIA
- COD. CLASIFICACION
- COD. TRAMO
- COD. ARTICULO
*/

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_existencia_articulos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ta_ncorr			=	$data["txtNcorr"];
	$ta_codigo			=	$data["txtCodArticulo"];
	$ta_marca 			= 	$data["OBLI-cboMarca"];
	$ta_familia			=	$data["OBLI-cboFamilia"];
	$ta_subfamilia 		=	$data["OBLI-cboSubFamilia"];
	$ta_clasificacion	=	$data["OBLI-cboClasificacion"];
	$ta_busqueda		=	trim(strtoupper($data["OBLI-txtDescripcion"]));
	$ta_descripcion		=	trim(strtoupper($data["OBLI-txtDescripcion2"]));
	$ta_empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$ta_tramo			=	$data["OBLI-cboTramo"];
	$ta_barra			=	$data["txtCodigoBarras"];
	$ta_estado			=	$data["OBLI-cboActivo"];
	$ta_venta			=	$data["txtPrecioVenta"];
	$ta_venta2			=	$data["txtPrecioVenta2"];
	$ta_venta3			=	$data["txtPrecioVenta3"];
	$ta_venta4			=	$data["txtPrecioVenta4"];
	$ta_porcdesc		=	$data["txtPorcDesc"];
	$ta_observacion		=	trim($data["txtObservacion"]);
	$ta_lista_precio	=	trim($data["ta_toma_inventario"]);
	$ta_toma_inventario	=	trim($data["ta_lista_precio"]);
	
	if ($ta_toma_inventario=='on'){
		$ta_toma_inventario = '1';
		}
	else{
		$ta_toma_inventario = '0';
		}
	if ($ta_lista_precio=='on'){
		$ta_lista_precio = '1';
		}
	else{
		$ta_lista_precio = '0';
		}

	$ingresa = 'SI';
	
	if ($ingresa == 'SI'){
		
		if ($ta_ncorr == ''){
			$sql = "insert into sgcopec.tallasnew 
					(ta_marca, ta_familia, ta_subfamilia, ta_clasificacion, ta_descripcion, ta_estado, ta_empresa, ta_tramo,
					ta_venta, ta_venta2, ta_venta3, ta_venta4, ta_porcdesc, ta_observacion, ta_busqueda, ta_lista_precio, ta_toma_inventario)
					
					values 
					('".$ta_marca."', '".$ta_familia."', '".$ta_subfamilia."', '".$ta_clasificacion."', '".$ta_descripcion."', 
					'".$ta_estado."', '".$ta_empresa."', '".$ta_tramo."', '".$ta_venta."', '".$ta_venta2."','".$ta_venta3."','".$ta_venta4."','".$ta_porcdesc."', '".$ta_observacion."',
					'".$ta_busqueda."',
					'".$ta_lista_precio."',
					'".$ta_toma_inventario."')";
		
			$res = mysql_query($sql, $conexion);
			$cod_articulo = mysql_insert_id($conexion);
			
			if (trim($ta_barra) != ''){
				$cod_barras		= 	$ta_barra;
			}else{
				$cod_barras		= 	$ta_familia.$ta_subfamilia.$ta_clasificacion.$ta_tramo.$cod_articulo;
			}
			
			$cod_producto	= 	$ta_familia.$ta_subfamilia.$ta_clasificacion.$ta_tramo.$cod_articulo;
			
			//actualiza el codigo de barras y el codigo del producto
			/*
			$sql_aa = "update sgcopec.tallasnew set ta_barra 	= '".$cod_barras."', ta_codigo 	= '".$cod_producto."'
						where ta_ncorr = '".$cod_articulo."'";
			*/
			
			$sql_aa = "update sgcopec.tallasnew set ta_barra 	= '".$cod_barras."', ta_codigo 	= '".$cod_articulo."'
						where ta_ncorr = '".$cod_articulo."'";
			
			$res_aa = mysql_query($sql_aa, $conexion);
			
			//  carga el listado
			//$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
			
			$objResponse->addScript("alert('Articulo Ingresado, Se Asigna el Codigo: $cod_articulo')");
			
			$objResponse->addAssign("txtCodArticulo", "value", $cod_producto);
			$objResponse->addScript("window.document.Form1.submit();");	
			
		}else{
			if (trim($ta_barra) == ''){
				$ta_barra	=	$ta_codigo;
			}
			$sql="";
				$sql = "update sgcopec.tallasnew set
						TA_MARCA			=	'".$ta_marca."',
						TA_FAMILIA			=	'".$ta_familia."',
						TA_SUBFAMILIA		=	'".$ta_subfamilia."',
						TA_CLASIFICACION	=	'".$ta_clasificacion."',
						TA_BARRA			=	'".$ta_barra."',
						TA_BUSQUEDA			=	'".$ta_busqueda."',
						TA_DESCRIPCION		=	'".$ta_descripcion."',
						TA_ESTADO			=	'".$ta_estado."',
						TA_EMPRESA			=	'".$ta_empresa."',
						TA_TRAMO			=	'".$ta_tramo."',
						TA_VENTA			=	'".$ta_venta."',
						TA_VENTA2			=	'".$ta_venta2."',
						TA_VENTA3			=	'".$ta_venta3."',
						TA_VENTA4			=	'".$ta_venta4."',
						TA_PORCDESC			=	'".$ta_porcdesc."',
						TA_OBSERVACION		=	'".$ta_observacion."',
						TA_LISTA_PRECIO		=	'".$ta_toma_inventario."',
						TA_TOMA_INVENTARIO	=	'".$ta_lista_precio."'
					
						where
						TA_NCORR 			=	'".$ta_ncorr."'";
					
			$res = mysql_query($sql, $conexion) or die(mysql_error());		
			$objResponse->addScript("alert('Articulo Modificado Correctamente')");
		
		}
	}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//  carga marcas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboMarca','marcas','','- - Seleccione - -','marca_ncorr', 'nombre')");

	//  carga familias
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboFamilia','sgbodega.familias','','- - Seleccione - -','FA_CODIGO', 'FA_NOMBRE')");

	//  carga subfalimias
	$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");
	
	//  carga clasificacion
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboClasificacion','sgbodega.clasificacion','','- - Seleccione - -','FA_CODIGO', 'FA_NOMBRE')");
	
	//  carga tramos
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboTramo','sgbodega.tramos','','- - Seleccione - -','TR_CODIGO', 'TR_GLOSA')");
	
	$objResponse->addScript("document.getElementById('OBLI-txtCodVendedor').focus();");
	
	//  carga el listado
	//$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}          
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa"];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla ORDER BY $campo2 ASC";
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
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

function CargaSubFamilias($data){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa"];
	$familia	=	$data["OBLI-cboFamilia"];
	
	$objResponse->addAssign("OBLI-cboSubFamilia","innerHTML",""); 		
	
	if ((trim($familia) == '') or (trim($familia) == '- - Seleccione - -')){
		$objResponse->addCreate("OBLI-cboSubFamilia","option",""); 		
		$objResponse->addAssign("OBLI-cboSubFamilia","options[0].value", '');
		$objResponse->addAssign("OBLI-cboSubFamilia","options[0].text", '- - Seleccione - -'); 	
	}else{
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0) {
			$objResponse->addCreate("OBLI-cboSubFamilia","option",""); 		
			$objResponse->addAssign("OBLI-cboSubFamilia","options[0].value", '');
			$objResponse->addAssign("OBLI-cboSubFamilia","options[0].text", '- - Seleccione - -'); 	
			$j = 1;
			while ($line = mysql_fetch_array($res)) {
				$objResponse->addCreate("OBLI-cboSubFamilia","option",""); 		
				$objResponse->addAssign("OBLI-cboSubFamilia","options[".$j."].value", $line[0]);
				$objResponse->addAssign("OBLI-cboSubFamilia","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
	}
	
	return $objResponse->getXML();
}

function Nueva($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("window.document.Form1.submit();");

	return $objResponse->getXML();
}
function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	
	$sql = "select ta_marca, ta_familia, ta_subfamilia, ta_clasificacion, ta_descripcion, ta_tramo, ta_barra, ta_codigo, ta_ncorr
			from sgcopec.tallasnew
			
			where 
			ta_empresa = '".$empresa."'";
			
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0){
			
		$arrRegistros 		= 	array();
		
		while ($line = mysql_fetch_row($res)) {
			
			//busca la marca
			$sql1 = "select mar_desc from sgcopec.marcas where mar_ncorr = '".$line[0]."'"; $res1 = mysql_query($sql1, $conexion);
			$marca = @mysql_result($res1,0,"mar_desc");
			
			//busca la familia
			$sql1 = "select fa_nombre from sgcopec.familias where fa_codigo = '".$line[1]."'"; $res1 = mysql_query($sql1, $conexion);
			$familia = @mysql_result($res1,0,"fa_nombre");
			
			//busca la subfamilia
			$sql1 = "select sf_nombre from sgcopec.subfamilias where sf_subcodigo = '".$line[2]."'"; $res1 = mysql_query($sql1, $conexion);
			$subfamilia = @mysql_result($res1,0,"sf_nombre");
			
			//busca clasificacion
			$sql1 = "select fa_nombre from sgcopec.clasificacion where fa_codigo = '".$line[3]."'"; $res1 = mysql_query($sql1, $conexion);
			$clasificacion = @mysql_result($res1,0,"fa_nombre");
			
			//busca tramo
			$sql1 = "select tr_glosa from sgcopec.tramos where tr_codigo = '".$line[5]."'"; $res1 = mysql_query($sql1, $conexion);
			$tramo = @mysql_result($res1,0,"tr_glosa");
			
			array_push($arrRegistros, array("ncorr" 		=> 	$line[8],
											"codigo" 		=> 	$line[6], 
											"descripcion" 	=> 	$line[4], 
											"marca" 		=> 	$marca, 
											"familia"		=> 	$familia, 
											"subfamilia"	=> 	$subfamilia,  
											"clasificacion"	=> 	$clasificacion,
											"tramo"			=> 	$tramo));
			
		}
			
		// sesion para ordenamiento
		$_SESSION["alycar_matriz"] 	= 	$arrRegistros;
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_existencia_articulos_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divresultado", "innerHTML", "No Se Encontraron Registros.");
		
	}	
	
	return $objResponse->getXML();
}
function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	//if ($obj1 == 'txtNcorr'){
		$objResponse->addScript("xajax_CargaArticulo(xajax.getFormValues('Form1'),'$campo1')");
	//}
	
	return $objResponse->getXML();
}
function CargaArticulo($data, $codigo){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	//$objResponse->addScript("alert('hola');");
	
	$sql = "select 
			ta_marca, ta_familia, ta_subfamilia, 
			ta_clasificacion, ta_descripcion, ta_tramo, 
			ta_codigo, ta_barra, ta_ncorr, ta_estado, 
			ta_busqueda, ta_precio, ta_porcdesc, ta_observacion, 
			ta_venta, ta_venta2, ta_venta3,
			ta_lista_precio, ta_toma_inventario, ta_venta4
			
			from sgcopec.tallasnew
			
			where 
			ta_ncorr = '".$codigo."'";
			
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0){
		//$objResponse->addScript("alert('hola');");

		while ($line = mysql_fetch_row($res)) {
	
			$objResponse->addAssign("txtCodArticulo", "value", $line[6]);
			$objResponse->addAssign("txtCodigoBarras", "value", $line[7]);
			
			//descripcion
			$objResponse->addAssign("OBLI-txtDescripcion", "value", $line[10]);
			$objResponse->addAssign("OBLI-txtDescripcion2", "value", $line[4]);
			
			//  muestra marca
			$sql1 = "select nombre from sgcopec.marcas where marca_ncorr = '".$line[0]."'"; $res1 = mysql_query($sql1, $conexion);
			//$objResponse->addAlert($sql1);
			$marca = @mysql_result($res1,0,"nombre");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboMarca','sgcopec.marcas','$line[0]','$marca','marca_ncorr', 'nombre')");
			
			//  muestra familia
			$sql1 = "select fa_nombre from sgcopec.familias where fa_codigo = '".$line[1]."'"; $res1 = mysql_query($sql1, $conexion);
			$familia = @mysql_result($res1,0,"fa_nombre");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboFamilia','sgcopec.familias','$line[1]','$familia','FA_CODIGO', 'FA_NOMBRE')");
			
			//muestra subfamilia
			$sql1 = "select sf_nombre from sgcopec.subfamilias where sf_subcodigo = '".$line[2]."'"; $res1 = mysql_query($sql1, $conexion);
			$subfamilia = @mysql_result($res1,0,"sf_nombre");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboSubFamilia','sgcopec.subfamilias','$line[2]','$subfamilia','sf_subcodigo', 'sf_nombre')");
			
			//muestra clasificacion
			$sql1 = "select fa_nombre from sgcopec.clasificacion where fa_codigo = '".$line[3]."'"; $res1 = mysql_query($sql1, $conexion);
			$clasificacion = @mysql_result($res1,0,"fa_nombre");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboClasificacion','sgcopec.clasificacion','$line[3]','$clasificacion','FA_CODIGO', 'FA_NOMBRE')");
			
			//muestra tramo
			$sql1 = "select tr_glosa from sgcopec.tramos where tr_codigo = '".$line[5]."'"; $res1 = mysql_query($sql1, $conexion);
			$tramo = @mysql_result($res1,0,"tr_glosa");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboTramo','sgcopec.tramos','$line[5]','$tramo','TR_CODIGO', 'TR_GLOSA')");
			
			//muestra el estado
			if ($line[9] == '1'){ //ACTIVO
				$activo = 'SI';
			}else{
				$activo = 'NO';
			}	
			
			$objResponse->addAssign("OBLI-cboActivo","innerHTML",""); 		
			
			$objResponse->addCreate("OBLI-cboActivo","option",""); 		
			$objResponse->addAssign("OBLI-cboActivo","options[0].value", $line[9]);
			$objResponse->addAssign("OBLI-cboActivo","options[0].text", $activo); 	
			
			$objResponse->addCreate("OBLI-cboActivo","option",""); 		
			$objResponse->addAssign("OBLI-cboActivo","options[1].value", '1');
			$objResponse->addAssign("OBLI-cboActivo","options[1].text", 'SI'); 	
			
			$objResponse->addCreate("OBLI-cboActivo","option",""); 		
			$objResponse->addAssign("OBLI-cboActivo","options[2].value", '0');
			$objResponse->addAssign("OBLI-cboActivo","options[2].text", 'NO'); 	
			
			$objResponse->addAssign("txtPrecioVenta", "value", $line[14]);
			$objResponse->addAssign("txtPrecioVenta2", "value", $line[15]);
			$objResponse->addAssign("txtPrecioVenta3", "value", $line[16]);
			$objResponse->addAssign("txtPrecioVenta4", "value", $line[19]);
			
			$objResponse->addAssign("txtPorcDesc", "value", $line[12]);
			$objResponse->addAssign("txtObservacion", "value", $line[13]);
			
			//echo $line[17].' '.$line[18];
			if ($line[17] == '1')
				$objResponse->addAssign("ta_lista_precio", "checked", "checked");
			if ($line[18]== '1')			
				$objResponse->addAssign("ta_toma_inventario", "checked", "checked");

		}
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Nueva");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaArticulo");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_existencia_articulos.tpl');

/*INSERT INTO `menues_hijos` (`menu_ncorr`, `menu_sub`, `mhij_desc`, `mhij_link`, `mhij_orden`, `mhij_mostrar`, `mhij_visible`) VALUES
(9, 1, 'Aprobar Ventas', 'sg_aprobar_ventas.2.php', 1, 'SI', 'SI'),
(9, 1, 'Devoluciones', 'sg_existencia_devoluciones.2.php', 9, 'SI', 'SI'),
(9, 1, 'Devoluciones Por Vendedor', 'sg_existencia_devoluciones_por_vendedor.2.php', 10, 'SI', 'SI'),
(9, 1, 'Guia Inicial', 'sg_existencia_guia_inicial.2.php', 11, 'SI', 'SI'),
(9, 1, 'Devoluciones Por Folio', 'sg_existencia_devoluciones_por_folio.2.php', 9, 'SI', 'SI'),
(9, 1, 'Movimientos Por Vendedor', 'sg_existencia_movimientos_vendedor.2.php', 16, 'SI', 'SI'),
(9, 1, 'Consulta Stock Vendedor', 'sg_consulta_stock_vendedor.2.php', 6, 'SI', 'SI'),
( 9, 1, 'Consulta Gu�as Iniciales', 'sg_consulta_guias_iniciales.2.php', 5, 'SI', 'SI'),
(9, 1, 'Recupera Guia Inicial', 'sg_existencia_recupera_guia_inicial.2.php', 11, 'SI', 'SI'),
(9, 1, 'Ver Guia Inicial', 'sg_existencia_ver_guia_inicial.2.php', 11, 'SI', 'SI'),
( 9, 1, 'Confirmar Devoluciones Que No Afectan Stock Bodega', 'sg_existencia_confirmar_devoluciones.2.php', 8, 'SI', 'SI'),
( 9, 1, 'Aumentos a Vendedor', 'sg_existencia_aumentos_vendedor.2.php', 2, 'SI', 'SI'),
( 9, 1, 'Recuperar Aumento a Vendedor', 'sg_existencia_recuperar_aumentos_vendedor.2.php', 19, 'NO', 'SI'),
( 9, 1, 'Buscar Aumentos a Vendedor (Que no Afectan Bodega)', 'sg_bodega_informe_aumento_vendedor2.2.php', 3, 'SI', 'SI'),
( 9, 1, 'Movimientos Anteriores Por Vendedor', 'sg_existencia_movimientos_anteriores_vendedor.2.php', 15, 'SI', 'SI'),
( 9, 1, 'Hoja de Venta Diaria', 'sg_hoja_venta_diaria.2.php', 12, 'SI', 'SI'),
( 9, 1, 'Devoluciones Enviadas a Confirmaci�n', 'sg_existencia_devoluciones_enviadas.2.php', 8, 'SI', 'SI'),
( 9, 1, 'Imprime Gu�a Aumento', 'sg_existencia_imp_guia.2.php', 2, 'SI', 'SI'),
( 9, 1, 'Registro Cuenta Devolucion a Cargo', 'sg_registra_cuenta_devolucion.2.php', 20, 'SI', 'SI'),
( 9, 1, 'Informe Cuentas con Devoluciones a Cargo', 'sg_informe_cuentas_devoluciones.2.php', 21, 'SI', 'SI'),
( 9, 1, 'Ventas Por Vendedor', 'sg_existencias_ventas_productos.2.php', 1, 'SI', 'SI'),
(9, 1, 'Rebajas a Vendedor (No Afecta Bodega)', 'sg_existencia_devoluciones_vendedor_no_afecta.2.php', 17, 'SI', 'SI');*/

?>
