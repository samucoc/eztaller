<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_facturas_compras_periodo_fact.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Asociar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$facturas			=	array();
	$facturas			=	$data['fact_elegida'];
	$empresa			= 	$data["OBLIempresa"];
	$cier_mes			=	$data["cboMes"];
	$cier_anio			=	$data["cboAnio"];
	$ingresa			=	'SI';
	
	if ($ingresa == 'SI'){
		if ($cier_mes == '' OR $cier_mes == '- - Seleccione - -'){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Mes incorrecto.')");
		}
	}
	if ($ingresa == 'SI'){
		if ($cier_anio == '' OR $cier_anio == '- - Seleccione - -'){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Año incorrecto.')");
		}
	}
	if ($ingresa == 'SI'){
		$sql = "select cier_fecha from cierres where empe_rut = '".$empresa."' order by cier_fecha desc limit 1";
		$res = mysql_query($sql, $conexion);
		
		$ult_cierre = @mysql_result($res,0,"cier_fecha");
		
		$fecha = $cier_anio.'-'.$cier_mes.'-1';
		
		// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
		$sql_dif =	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
		$res_dif = mysql_query($sql_dif,$conexion);
		$dias_dif = @mysql_result($res_dif,0,"dias_dif");
		if ($dias_dif <= 0){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Fecha Incorrecta. Debe ser mayor a la fecha del ultimo cierre.')");
		}	
	}
	if ($ingresa == 'SI'){
		for ($i=0; $i<count($facturas);$i++){
			$tipo = array();
			$tipo = explode('_',$facturas[$i]);
			if ($tipo[0]=='FACTURA COMPRA'){
				$sql = "insert into facturas_periodo(`nro_factura`, `mes`, `anio`, tipo) values('".$tipo[1]."','".$cier_mes."','".$cier_anio."','FACTURA COMPRA')";
				}
			elseif ($tipo[0]=='NOTA DEBITO COMPRA'){
				$sql = "insert into nd_periodo(`nro_nota_debito`, `mes`, `anio`, tipo) values('".$tipo[1]."','".$cier_mes."','".$cier_anio."','NOTA DEBITO COMPRA')";
				}
			elseif ($tipo[0]=='NOTA CREDITO COMPRA'){
				$sql = "insert into nc_periodo(`nro_nota_credito`, `mes`, `anio`, tipo) values('".$tipo[1]."','".$cier_mes."','".$cier_anio."','NOTA CREDITO COMPRA')";
				}
			$res = mysql_query($sql,$conexion) or die(mysql_error());
			
			}
	
		$objResponse->addAlert("Registros almacenados correctamente.");
		$objResponse->addScript("document.Form1.submit();");
		}
	return $objResponse->getXML();
	
	}


function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa		= 	$data["OBLIempresa"];
	$fecha_inicio	= 	$data["txtFecha1"];
	$fecha_fin		= 	$data["txtFecha2"];
	$boleta			= 	$data['boleta'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
		if (($fecha_inicio != '')&&($fecha_fin != '')){
       	
			list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_inicio);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
				$fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
				
			list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_fin);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
				$fecha_fin              = date("Y-m-d",$nro_mes_anterior);
				$and="";
			
			$and_1 .= "and fecha between '".$fecha_inicio."' and '".$fecha_fin."' ";
			
			}
                    
        if ($empresa != '- - Seleccione - -'){
            $and_2 .= " and empresa = '".$empresa."' " ;
        }
        if ($boleta != ''){
            $and_3 .= " and nro_factura = '".$boleta."' " ;
        }
    $arrRegistros	= 	array();   
	$sql_ab = "select *
                    from facturas
                    where tipo_factura = 'COMPRAS' and
							factura_ncorr not in (select nro_factura
											from facturas_periodo)
					        ".$and_1." ".$and_2." ".$and_3."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$ingresa_1 ='SI';
	if (mysql_num_rows($res_ab) > 0){
		$i = 1;
		$total = 0;
		while ($line_ab_1 = mysql_fetch_array($res_ab)){
			
			$sql_pr = "select empe_desc from sgyonley.empresas where empe_rut = '".$line_ab_1['empresa']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_empresa = @mysql_result($res_pr,0,"empe_desc");
			
			$sql_pr = "select PR_RAZON from sgbodega.proveedor where PR_RUT  = '".$line_ab_1['rut']."' union
						select PR_RAZON from sgbodega.proveedor where PR_NCORR  = '".$line_ab_1['rut']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_persona = @mysql_result($res_pr,0,"PR_RAZON");
			
			$total += $line_ab_1['total'];
			
			$sql = "select cier_fecha
					from cierres where empe_rut = '".$line_ab_1['empresa']."' order by cier_fecha desc limit 1";
			$res = mysql_query($sql, $conexion);
			$ult_cierre = @mysql_result($res,0,"cier_fecha");
			// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
			$sql_dif =	"SELECT DATEDIFF('".$line_ab_1['fecha']."','".$ult_cierre."') as dias_dif";
			$res_dif = mysql_query($sql_dif,$conexion);
			$dias_dif = @mysql_result($res_dif,0,"dias_dif");
			$ingresa = "SI";
			if ($dias_dif <= 0){
				$ingresa = 'NO';
				}
			
			array_push($arrRegistros, array("item"			=>	$i,
											"ncorr" 		=> 	$line_ab_1['factura_ncorr'],
											"empresa"  		=> 	$nombre_empresa,
											"tipo_factura"	=> 	"FACTURA COMPRA",
											"fecha"   		=> 	$line_ab_1['fecha'],
											"cliente" 		=> 	$nombre_persona,
											"nro_boleta"   	=> 	$line_ab_1['nro_factura'],
											"neto"   		=> 	$line_ab_1['neto'],
											"iva"   		=> 	$line_ab_1['iva'],
											"total"   		=> 	$line_ab_1['total'],
											"cierre"		=>  $ingresa 
											));
			$i++;
			
			} 

		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_facturas_compras_periodo_fact_list.tpl'));
		$objResponse->addAssign("total", "innerHTML", number_format($total,0 , '.', ','));
		$ingresa_1 ='SI';
	}else{
		$ingresa_1='NO';		
	}
	
	$sql_ab = "select *
                    from notas_debito
                    where tipo_nd = 'COMPRAS' and
							nd_ncorr not in (select nro_nota_debito
												from nd_periodo)
					        ".$and_1." ".$and_2." ".$and_3."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$ingresa_2 ='SI';
	if (mysql_num_rows($res_ab) > 0){
		$i = 1;
		$total = 0;
		while ($line_ab_1 = mysql_fetch_array($res_ab)){
			
			$sql_pr = "select empe_desc from sgyonley.empresas where empe_rut = '".$line_ab_1['empresa']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_empresa = @mysql_result($res_pr,0,"empe_desc");
			
			$sql_pr = "select raz_social from clientes where cliente_ncorr  = '".$line_ab_1['rut']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_persona = @mysql_result($res_pr,0,"raz_social");
			
			$total += $line_ab_1['total'];
			
			$sql = "select cier_fecha
					from cierres where empe_rut = '".$line_ab_1['empresa']."' order by cier_fecha desc limit 1";
			$res = mysql_query($sql, $conexion);
			$ult_cierre = @mysql_result($res,0,"cier_fecha");
			// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
			$sql_dif =	"SELECT DATEDIFF('".$line_ab_1['fecha']."','".$ult_cierre."') as dias_dif";
			$res_dif = mysql_query($sql_dif,$conexion);
			$dias_dif = @mysql_result($res_dif,0,"dias_dif");
			$ingresa = "SI";
			if ($dias_dif <= 0){
				$ingresa = 'NO';
				}
			
			array_push($arrRegistros, array("item"			=>	$i,
											"ncorr" 		=> 	$line_ab_1['nd_ncorr'],
											"empresa"  		=> 	$nombre_empresa,
											"tipo_factura"	=> 	"NOTA DEBITO COMPRA",
											"fecha"   		=> 	$line_ab_1['fecha'],
											"cliente" 		=> 	$nombre_persona,
											"nro_boleta"   	=> 	$line_ab_1['nro_nota_debito'],
											"neto"   		=> 	$line_ab_1['neto'],
											"iva"   		=> 	$line_ab_1['iva'],
											"total"   		=> 	$line_ab_1['total'],
											"cierre"		=>  $ingresa 
											));
			$i++;
			
			} 

		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_facturas_compras_periodo_fact_list.tpl'));
		$objResponse->addAssign("total", "innerHTML", number_format($total,0 , '.', ','));
		$ingresa_2 ='SI';
	}else{
		$ingresa_2='NO';		
	}	
	
	$sql_ab = "select *
                    from notas_credito
                    where tipo_nc= 'COMPRAS' and
							nc_ncorr not in (select nro_nota_credito
												from nc_periodo)
					        ".$and_1." ".$and_2." ".$and_3."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$ingresa_3 ='SI';
	if (mysql_num_rows($res_ab) > 0){
		$i = 1;
		$total = 0;
		while ($line_ab_1 = mysql_fetch_array($res_ab)){
			
			$sql_pr = "select empe_desc from sgyonley.empresas where empe_rut = '".$line_ab_1['empresa']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_empresa = @mysql_result($res_pr,0,"empe_desc");
			
			$sql_pr = "select raz_social from clientes where cliente_ncorr  = '".$line_ab_1['rut']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_persona = @mysql_result($res_pr,0,"raz_social");
			
			$total += $line_ab_1['total'];
			
			$sql = "select cier_fecha
					from cierres where empe_rut = '".$line_ab_1['empresa']."' order by cier_fecha desc limit 1";
			$res = mysql_query($sql, $conexion);
			$ult_cierre = @mysql_result($res,0,"cier_fecha");
			// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
			$sql_dif =	"SELECT DATEDIFF('".$line_ab_1['fecha']."','".$ult_cierre."') as dias_dif";
			$res_dif = mysql_query($sql_dif,$conexion);
			$dias_dif = @mysql_result($res_dif,0,"dias_dif");
			$ingresa = "SI";
			if ($dias_dif <= 0){
				$ingresa = 'NO';
				}
			
			array_push($arrRegistros, array("item"			=>	$i,
											"ncorr" 		=> 	$line_ab_1['nc_ncorr'],
											"empresa"  		=> 	$nombre_empresa,
											"tipo_factura"	=> 	"NOTA CREDITO COMPRA",
											"fecha"   		=> 	$line_ab_1['fecha'],
											"cliente" 		=> 	$nombre_persona,
											"nro_boleta"   	=> 	$line_ab_1['nro_nota_credito'],
											"neto"   		=> 	$line_ab_1['neto'],
											"iva"   		=> 	$line_ab_1['iva'],
											"total"   		=> 	$line_ab_1['total'],
											"cierre"		=>  $ingresa 
											));
			$i++;
			
			} 

		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_facturas_compras_periodo_fact_list.tpl'));
		$objResponse->addAssign("total", "innerHTML", number_format($total,0 , '.', ','));
		$ingresa_3 ='SI';
	}else{
		$ingresa_3='NO';		
	}	
	
	if (($ingresa_1 == 'NO')&&($ingresa_2 == 'NO')&&($ingresa_3 == 'NO')){
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
		}
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_facturas_compras_periodo_fact_list.tpl'));
	
	return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	$ncorr_1 	= 	$data["$objeto2"];

        $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr_1."'  ";
	
        $res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
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

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}
function Eliminar($data,$ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sql ="delete from facturas where factura_ncorr = ".$ncorr;
	$res = mysql_query($sql,$conexion);
	
		$objResponse->addScript("alert('Registro Eliminado')");
		$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIempresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Eliminar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");
$xajax->registerFunction("Asociar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_informe_facturas_compras_periodo_fact.tpl');

?>

