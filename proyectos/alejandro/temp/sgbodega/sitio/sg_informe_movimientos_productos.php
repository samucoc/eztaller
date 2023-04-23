<?php	
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_movimientos_productos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();


function ImprimeGuia($data,$guia){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$_SESSION["alycar_pag_regreso"] = 'sg_informe_movimientos_productos.php';
	$objResponse->addScript("location.href='sg_bodega_imp_guia.php?guia=$guia'");
	
	return $objResponse->getXML();
	}


function Grabar($data){
	global $conexion;
	global $miSmarty;	
    $objResponse = new xajaxResponse('ISO-8859-1');

	$movim_tipo			= 	$data['estado'];
	$mdet_codigo		=	$data["OBLItxtCodProducto"];
	$movim_bodega		=	$_SESSION['alycar_sgyonley_bodega'];
	$total				=	0;
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$and="";
	if ($mdet_codigo != ''){
		$and .= " and c.mdet_codigo = '".$mdet_codigo."'";
		}

	if (($movim_tipo != '')&&($movim_tipo != 'Todos')){
		$and .= " and a.movim_tipo = '".$movim_tipo."' ";
		}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql = "select
				d.empe_desc as empresa,
				a.movim_ncorr as guia,
				DATE_FORMAT(a.movim_fecha,'%d/%m/%Y') as fecha,
				a.pr_rut as proveedor,
				sum(c.mdet_cantidad) as cant_articulos,
				sum(c.mdet_valor * c.mdet_cantidad) as total,
				a.movim_obs as obs,
				DATE_FORMAT(a.movim_fecha_dig,'%d/%m/%Y %T') as fecha_dig,
				a.usu_id as usuario,
				a.movim_numdoc as factura,
				c.mdet_desc as descripcion,
				a.tdoc_ncorr as documento,
				c.mdet_codigo as cod_producto,
				a.vend_ncorr as vendedor,
				a.movim_tipo as tipo
				
				from 
				sgcompras.movim a
					left join sgcompras.movim_detalle c
						on a.movim_ncorr = c.movim_ncorr 
					left join sgyonley.empresas d
						on a.empe_rut = d.empe_rut
					
				where
				   	a.movim_estado = 'FINALIZADO' and
					a.movim_bodega = '".$movim_bodega."'
					
				$and 
				
				group by c.mdet_ncorr
				
				order by a.movim_fecha asc, a.movim_ncorr asc
			";
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	if (mysql_num_rows($res) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line = mysql_fetch_row($res)) {
			//busca al proveedor
			
			$sql_pr = "select pr_razon from sgbodega.proveedor where pr_rut = '".$line[3]."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$proveedor = @mysql_result($res_pr,0,"pr_razon");
			$documento ="";
			if($line[11]==0){$documento = 'Sin documento';}
			elseif ($line[11]==1){$documento = 'Factura';}
			else{$documento = 'Orden de Compra';}
			
			$sql_movim = "select *
						from sgyonley.tipos_movim
						where tmov_ncorr = '".$movim_tipo."'";
			$res_movim = mysql_query($sql_movim, $conexion)	or die(mysql_error());
			$row_movim = mysql_fetch_array($res_movim);
			
			if ($line[13]!=0){
				$sql_movim1 = "select *
							from sgbodega.vendedores
							where VE_CODIGO = '".$line[13]."'";
				$res_movim1 = mysql_query($sql_movim1, $conexion)	or die(mysql_error());
				$row_movim1 = mysql_fetch_array($res_movim1);
				}
			$det_movim 	=	"";
			$tipo_movim =	"";
			$factura 	= 	"";
			$cantidad   =   "";
			if($line[14]==1){
				$tipo_movim ="Aumento Bodega";
				$det_movim =$proveedor;
				$factura = $documento.' Nº '.$line[9];
				$cantidad = $line[4];
				}
			elseif($line[14]==2){
				$tipo_movim ="Aumento a Vendedor";
				$det_movim =$row_movim1['VE_VENDEDOR'];
				$factura = "";
				$cantidad = $line[4]*(-1);
				}
			elseif($line[14]==3){
				$tipo_movim ="Devolucion de Proveedor";
				$det_movim = "";
				$cantidad = $line[4]*(-1);
				}
			elseif($line[14]==4){
				$tipo_movim ="Devolucion de Vendedor";
				$det_movim =$row_movim1['VE_VENDEDOR'];
				$cantidad = $line[4];
				}
			elseif($line[14]==5){
				}
			elseif($line[14]==6){
				
				}
			elseif($line[14]==7){
				
				}
			elseif($line[14]==8){
				$tipo_movim ="Traspaso entre Bodegas";
				$sql_1 = "select movim_bodega,movim_bodega_tras
							from sgcompras.movim
							where movim_ncorr = '".$line[1]."'";
				$res_1 = mysql_query($sql_1,$conexion);
				$row_1 = mysql_fetch_array($res_1);
				
				$movim_bodega = $row_1['movim_bodega'];
				$movim_bodega_tras = $row_1['movim_bodega_tras'];
				
				$sql_2 = "select nombre
							from sgbodega.bodegas
							where bodega_ncorr = '".$movim_bodega."'";
				$res_2 = mysql_query($sql_2,$conexion);
				$row_2 = mysql_fetch_array($res_2);
				$nombre_1 = $row_2['nombre'];
				
				$sql_2 = "select nombre
							from sgbodega.bodegas
							where bodega_ncorr = '".$movim_bodega_tras."'";
				$res_2 = mysql_query($sql_2,$conexion);
				$row_2 = mysql_fetch_array($res_2);
				$nombre_2 = $row_2['nombre'];
				
				$det_movim =$nombre_2.' a '.$nombre_1;
				$cantidad = $line[4];
				}
			elseif($line[14]==9){
				
				}
			elseif($line[14]==10){
				
				}
			elseif($line[14]==11){
				
				}
			elseif($line[14]==12){
				$tipo_movim ="Ajuste Aumento"; 
				$det_movim =$_SESSION['alycar_sgyonley_bodega_nombre'];
				$cantidad = $line[4];
				}
			elseif($line[14]==13){
				$tipo_movim ="Ajuste Merma"; 
				$det_movim =$_SESSION['alycar_sgyonley_bodega_nombre'];
				$cantidad = $line[4]*(-1);
				}
			elseif($line[14]==14){
				$tipo_movim ="Ajuste Castigo"; 
				$det_movim =$_SESSION['alycar_sgyonley_bodega_nombre'];
				$cantidad = $line[4]*(-1);
				}
			
			array_push($arrRegistros, array("item"				=>	$i,
											"empresa"			=> 	$line[0],
											"guia" 				=> 	$line[1],
											"fecha" 			=> 	$line[2],
											"proveedor"			=> 	$proveedor,
											"descripcion"		=> 	$line[10],
											"cantidad"		 	=> 	$cantidad,
											"total" 			=> 	$line[5],
											"obs" 				=> 	$line[6],
											"fecha_dig"			=> 	$line[7],
											"usuario" 			=> 	$line[8],
											"factura" 			=> 	$factura,
											"tipo_documento"	=> 	$documento,
											"producto"			=> 	$line[12],
											"det_movim"			=>  $det_movim,
											"tipo_movim"		=>	$tipo_movim));
			$total = $total + $cantidad;
			$i++;
		}
		
		$miSmarty->assign('TOTAL', $total);
		$miSmarty->assign('DESDE', $fecha_desde);
		$miSmarty->assign('HASTA', $fecha_hasta);
		$miSmarty->assign('MOVIMIENTO', $movim_tipo);
		$_SESSION['DESDE'] = $fecha_desde;
		$_SESSION['HASTA'] = $fecha_hasta;
		$_SESSION['MOVIMIENTO'] = $movim_tipo;
		$movim_nombre_bodega		=	$_SESSION['alycar_sgyonley_bodega_nombre'];
		$miSmarty->assign('BODEGA',$movim_nombre_bodega);
		$sql_movim = "select *
						from sgyonley.tipos_movim
						where tmov_ncorr = '".$movim_tipo."'";
		$res_movim = mysql_query($sql_movim, $conexion)	or die(mysql_error());
		$row_movim = mysql_fetch_array($res_movim);
		if ( $row_movim['tmov_desc'] != ''){
			$miSmarty->assign('NOMBRE_MOVIMIENTO', $row_movim['tmov_desc']);
			$_SESSION['NOMBRE_MOVIMIENTO'] =$row_movim['tmov_desc'];
			}
		else
			{
			$miSmarty->assign('NOMBRE_MOVIMIENTO', 'Todos');
			$_SESSION['NOMBRE_MOVIMIENTO'] ='Todos';
			}
		
		$sql = "select concat(ta_descripcion,' ',ta_busqueda) as descripcion 
				from sgbodega.tallasnew 
				where ta_ncorr = '".$mdet_codigo."'";
		$res = mysql_query($sql, $conexion);
		$miSmarty->assign('CODIGO', $mdet_codigo);
		$miSmarty->assign('DESCRIPCION', @mysql_result($res,0,"descripcion"));
		$_SESSION['CODIGO'] =  $mdet_codigo;
		$_SESSION['DESCRIPCION'] =  @mysql_result($res,0,"descripcion");
		
		$_SESSION["alycar_matriz"] = $arrRegistros;
		$_SESSION["alycar_orden"] = "fecha"."ASC";
        $miSmarty->assign('arrRegistros', $arrRegistros);
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_movimientos_productos_list.tpl'));
	}else{
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
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
		
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
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
function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	$direccion_orden = "ASC";
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
		}		
	$_SESSION["alycar_orden"] = $campo.$direccion_orden;
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	
	$_SESSION["alycar_matriz"] = $arrRegistros;

	$miSmarty->assign('DESDE', $_SESSION['DESDE']);
	$miSmarty->assign('HASTA', $_SESSION['HASTA']);
	$miSmarty->assign('MOVIMIENTO', $_SESSION['MOVIMIENTO']);
	$sql_movim = "select *
					from sgyonley.tipos_movim
					where tmov_ncorr = '".$_SESSION['MOVIMIENTO']."'";
	$res_movim = mysql_query($sql_movim, $conexion)	or die(mysql_error());
	$row_movim = mysql_fetch_array($res_movim);
	if ( $row_movim['tmov_desc'] != ''){
		$miSmarty->assign('NOMBRE_MOVIMIENTO', $row_movim['tmov_desc']);
		$_SESSION['NOMBRE_MOVIMIENTO'] =$row_movim['tmov_desc'];
		}
	else
		{
		$miSmarty->assign('NOMBRE_MOVIMIENTO', 'Todos');
		$_SESSION['NOMBRE_MOVIMIENTO'] ='Todos';
		}


	$movim_nombre_bodega		=	$_SESSION['alycar_sgyonley_bodega_nombre'];
	$miSmarty->assign('BODEGA',$movim_nombre_bodega);
	$miSmarty->assign('CODIGO', $_SESSION['CODIGO']);
	$miSmarty->assign('DESCRIPCION', $_SESSION['DESCRIPCION']);

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_movimientos_productos_list.tpl'));
	
	return $objResponse->getXML();
}

$xajax->registerFunction("ImprimeGuia");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprimir");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Ordenar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_movimientos_productos.tpl');

?>

