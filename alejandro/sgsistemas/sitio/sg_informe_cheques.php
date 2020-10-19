<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_cheques.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ChCtaCte 		=	$data["txtCodCtaCte"];
	$ChDocumento 	=	$data["txtNumDoc"];
	$ChDetalle 		=	$data["txtDetalle"];
	$fecha1 		=	$data["txtFecha1"];
	$fecha2 		=	$data["txtFecha2"];
	
	if ($ChCtaCte != ''){
		$where	.=	"a.ChCtaCte = '".$ChCtaCte."' and ";
	}
	if ($fecha1 != '' && $fecha2 != ''){
		list($dia1,$mes1,$anio1) = split('[/.-]', $fecha1);$fecha1 = $anio1."-".$mes1."-".$dia1;
		list($dia2,$mes2,$anio2) = split('[/.-]', $fecha2);$fecha2 = $anio2."-".$mes2."-".$dia2;
		$where	.=	"a.ChFechaEmite >= '".$fecha1."' and a.ChFechaEmite <= '".$fecha2."' and ";
	}
	if ($ChDocumento != ''){
		$where	.=	"a.ChDocumento = '".$ChDocumento."' and ";
	}
	if ($ChDetalle != ''){
		$where	.=	"a.ChDetalle LIKE '%".$ChDetalle."%' and ";
	}
	
	if ($where != ''){
		
		$sql = "select
				a.ChId as ncorr,
				a.ChCtaCte as cod_cta,
				b.CaNumero as num_cta,
				a.ChDocumento as num_cheque,
				a.ChPagado as cobrado,
				a.ChDetalle as detalle,
				DATE_FORMAT(a.ChFechaEmite,'%d/%m/%Y') as fecha_emision,
				DATE_FORMAT(a.ChFechaVence,'%d/%m/%Y') as fecha_vcto,
				DATE_FORMAT(a.ChFechaPago,'%d/%m/%Y') as fecha_pago,
				a.ChValor as valor
				
				from
				cheques a, cuentas b
				
				where
				$where
				a.ChCtaCte = b.CaId
				
				order by
				a.ChFechaEmite asc";
				
		$res = mysql_query($sql, $conexion);
		if (@mysql_num_rows($res) > 0){
			$fecha	=	date("d/m/Y");
			$tbl 	.=	"<br>";
			$tbl 	.=	"<table class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='10' class='grilla-tab-fila-titulo' align='center'><b>Listado de Cheques Emitidos al $fecha</b></td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Cód. Cta.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>N° Cta. Cte.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>N° Documento</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Cob.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Detalle</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Fecha Emisión</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Fecha Vcto.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Fecha Pago</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Valor</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'></td>";
			$tbl 	.=	"</tr>";
			
			while ($line = mysql_fetch_row($res)) {
				$total		=	$total + $line[9];
				$cobrado 	= 	'NO';
				
				// cobrado (SI, NO)
				if ($line[4] == 1){
					$cobrado = 'SI';
				}
				
				
				
				$tbl	.=	"<tr>";
				$tbl	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[1]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[2]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[3]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$cobrado."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[5]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[6]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[7]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[8]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".number_format($line[9], 0, ',', '.')."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'>";
				$tbl	.=	"<a href='#' style='cursor: hand;'><img src='../images/magnify.png' border='0' title='Mostrar' onclick="."xajax_Mostrar('$line[0]');"."></a>";
				$tbl 	.=	"</td>";
				$tbl 	.=	"</tr>";
				
			}
			
			// totales
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='8' class='grilla-tab-fila-campo' align='right'><b>Totales</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='right'><b>".number_format($total, 0, ',', '.')."</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'></td>";
			$tbl 	.=	"</tr>";
			
			// botones
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='10' class='grilla-tab-fila-titulo'>";
			$tbl 	.=	"<input type='button' name='btnImprimir' value='Imprimir' class='boton' onclick="."ImprimeDiv('divresultado');".">";
			$tbl 	.=	"</td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"</table>";
		
			$objResponse->addAssign("divresultado", "innerHTML", $tbl);
		
		}else{
			$objResponse->addScript("alert('No se Encontraron Registro(s).')");
		}
	}else{
		
		$objResponse->addScript("alert('Debe Seleccionar al Menos un Criterio de Búsqueda.')");
	}	
	
	return $objResponse->getXML();
}

function Mostrar($ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$objResponse->addScript("showPopWin('sg_modifica_cheques.php?ncorr=$ncorr', 'Edita Cheque', 660, 380, null);");
	//$objResponse->addScript("document.location.href='sg_registro_cheques.php?ncorr=$ncorr';");
	
	//$objResponse->addScript("window.open('sg_produccion_ingreso.php', '_blank');");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	//$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	
	$objResponse->addScript("document.getElementById('txtCodCtaCte').focus();");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("Mostrar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_cheques.tpl');

?>

