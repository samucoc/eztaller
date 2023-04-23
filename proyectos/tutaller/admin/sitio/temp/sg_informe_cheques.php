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
	
	$ChCtaCte 		=	$data["cboCtaCte"];
	$ChDocumento 	=	$data["txtNumDoc"];
	$ChDetalle 	=	$data["txtDetalle"];
	$tope_ncorr 	=	$data["cboOperacion"];
	$fecha1 		=	$data["txtFecha1"];
	$fecha2 		=	$data["txtFecha2"];
	$fecha3 		=	$data["txtFecha3"];
	$fecha4 		=	$data["txtFecha4"];
	$ChPagado 		=	$data["cboCobrado"];
	
	if ($ChCtaCte != '' && $ChCtaCte != 'Todas'){
		$where	.=	"a.ChCtaCte = '".$ChCtaCte."' and ";
	}
	if ($fecha1 != '' && $fecha2 != ''){
		list($dia1,$mes1,$anio1) = split('[/.-]', $fecha1);$fecha1 = $anio1."-".$mes1."-".$dia1;
		list($dia2,$mes2,$anio2) = split('[/.-]', $fecha2);$fecha2 = $anio2."-".$mes2."-".$dia2;
		$where	.=	"a.ChFechaEmite >= '".$fecha1."' and a.ChFechaEmite <= '".$fecha2."' and ";
	}
	if ($fecha3 != '' && $fecha4 != ''){
		list($dia3,$mes3,$anio3) = split('[/.-]', $fecha3);$fecha3 = $anio3."-".$mes3."-".$dia3;
		list($dia4,$mes4,$anio4) = split('[/.-]', $fecha4);$fecha4 = $anio4."-".$mes4."-".$dia4;
		$where	.=	"a.ChFechaVence >= '".$fecha3."' and a.ChFechaVence <= '".$fecha4."' and ";
	}
	if ($ChDocumento != ''){
		$where	.=	"a.ChDocumento = '".$ChDocumento."' and ";
	}
	if ($ChDetalle != ''){
		$where	.=	"a.ChDetalle LIKE '%".$ChDetalle."%' and ";
	}
	if ($tope_ncorr != '' && $tope_ncorr != 'Todas'){
		$where	.=	"a.tope_ncorr = '".$tope_ncorr."' and ";
	}
	if ($ChPagado != ''){
		$where	.=	"a.ChPagado = '".$ChPagado."' and ";
	}
	
	if ($where != ''){
		
		$objResponse->addAssign("divresultado", "innerHTML", "");
		
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
				a.ChValor as valor,
				c.tope_desc as operacion,
				DATE_FORMAT(a.ChFechaVence,'%Y/%m/%d') as fecha_vcto_ing,
				DATE_FORMAT(a.ChFechaPago,'%Y/%m/%d') as fecha_pago_ing
				
				from
				cheques a, cuentas b, tipos_operaciones c
				
				where
				$where
				a.ChCtaCte = b.CaId and
				a.tope_ncorr = c.tope_ncorr
				
				group by
				a.ChCtaCte, a.ChDocumento
				
				order by
				a.ChFechaVence asc";
				
		$res = mysql_query($sql, $conexion);
		if (@mysql_num_rows($res) > 0){
			
			$fecha	=	date("d/m/Y");
			$tbl 	.=	"<br>";
			$tbl 	.=	"<table class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='11' class='grilla-tab-fila-titulo' align='center'><b>Listado de Cheques al $fecha</b></td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Cód</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Operación</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Cód. Cta.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>N° Cta. Cte.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>N° Documento</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Cob.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Detalle</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Fecha Emisión</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Fecha Vcto.</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Fecha Pago</td>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'>Valor</td>";
			//$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'></td>";
			$tbl 	.=	"</tr>";
			
			while ($line = mysql_fetch_row($res)) {
				
				$ChFechaVence	=	$line[11];	
				$ChFechaPago	=	$line[12];
				$rojo			=	'NO';	
				if ($ChFechaPago != '' && $ChFechaPago != '0000/00/00' && $ChFechaPago != '0000-00-00'){
					$sql_dif = "SELECT DATEDIFF('".$ChFechaPago."','".$ChFechaVence."') as dif";
					$res_dif = mysql_query($sql_dif,$conexion);
					if (@mysql_result($res_dif,0,"dif") < 0){
						$rojo = 'SI';
					}
				}
				
				$total		=	$total + $line[9];
				$cobrado 	= 	'NO';
				
				// cobrado (SI, NO)
				if ($line[4] == 1){
					$cobrado = 'SI';
				}
				
				$ChFechaPagoEsp = $line[8];
				if ($ChFechaPagoEsp == '00/00/0000' OR $ChFechaPagoEsp == '00-00-0000'){
					$ChFechaPagoEsp = '';
				}
				
				$tbl	.=	"<tr>";
				$tbl	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[0]."</a></td>";
				$tbl	.=	"<td class='grilla-tab-fila-campo' align='left'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[10]."</a></td>";
				$tbl	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[1]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[2]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[3]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$cobrado."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[5]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[6]."</a></td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$line[7]."</a></td>";
				
				if ($rojo == 'NO'){
					$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".$ChFechaPagoEsp."</a></td>";
				}
				if ($rojo == 'SI'){
					$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'><a href='#' onclick="."xajax_Mostrar('$line[0]');"."><label class='requerido'><b>".$ChFechaPagoEsp."</b></label></a></td>";
				}
				
				$tbl 	.=	"<td class='grilla-tab-fila-campo' align='right'><a href='#' onclick="."xajax_Mostrar('$line[0]');".">".number_format($line[9], 0, ',', '.')."</a></td>";
				$tbl 	.=	"</tr>";
				
			}
			
			// totales
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='10' class='grilla-tab-fila-campo' align='right'><b>Totales:</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='right'><b>".number_format($total, 0, ',', '.')."</b></td>";
			//$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'></td>";
			$tbl 	.=	"</tr>";
			
			// botones
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='11' class='grilla-tab-fila-titulo'>";
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
	
	
	$objResponse->addScript("showPopWin('sg_modifica_cheques.php?ncorr=$ncorr', 'Modificación', 650, 350, null);");
	//$objResponse->addScript("document.location.href='sg_registro_cheques.php?ncorr=$ncorr';");
	
	//$objResponse->addScript("window.open('sg_produccion_ingreso.php', '_blank');");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga cuentas corrientes
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboCtaCte','cuentas','','Todas','CaId','CaNombre', '')");
	
	// carga tipos operaciones
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboOperacion','tipos_operaciones','','Todas','tope_ncorr','tope_desc', '')");
	
	$objResponse->addScript("document.getElementById('txtCodCtaCte').focus();");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	if($tabla == 'cuentas'){$campo2 = "concat(CaId, ' -- ', CaNombre)";}
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", $codigo);
	$objResponse->addAssign("$select","options[0].text", $descripcion); 	
	
	if (@mysql_num_rows($res) > 0) {
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
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("Mostrar");
$xajax->registerFunction("CargaSelect");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_cheques.tpl');

?>

