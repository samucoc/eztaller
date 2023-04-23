<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_movimientos_mensuales.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
        set_time_limit(100000);
        
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$cod_prod                       =       $data["OBLI-txtCodProducto"];
        $descr_prod                     =       $data["OBLI-txtDescProducto"];
        $familia 			= 	$data["cboFamilia"];
	$subfamilia			= 	$data["cboSubFamilia"];
	$estado_producto        	= 	$data["cboEstadoProducto"];
	$movimiento                     =       $data['cboMovimientos'];
        
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($familia != '') && ($familia != 'Todas')){
		$and = " and a.ta_familia = '".$familia."'";
	}
	if (($subfamilia != '') && ($subfamilia != 'Todas')){
		$and .= " and a.ta_subfamilia = '".$subfamilia."'";
	}
        
	
	// busca todos los productos
	$sql_pd = "select 
				concat(a.ta_busqueda,' ',a.ta_descripcion) as descripcion,
				a.ta_ncorr as codigo,
				a.ta_codigo as codigo_antiguo,
				a.ta_familia as familia,
				a.ta_subfamilia as subfamilia
				
				from 
				sgbodega.tallasnew a
				
				where
                                a.ta_empresa != '' and
				a.ta_estado like '%".$estado_producto."%' and
				a.ta_familia != '' and a.ta_subfamilia != '' and
                                concat(a.ta_busqueda,' ',a.ta_descripcion) like '%".$descr_prod."%'
                                $and
				order by b.fa_nombre asc, c.sf_nombre asc, descripcion asc";
	
	$res_pd = mysql_query($sql_pd, $conexion);
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$codigo_antiguo = $line_pd[2];
			//busca familia
				$sql_f = "select fa_nombre from sgbodega.familias where fa_codigo = '".$line_pd[3]."'";
				$res_f = mysql_query($sql_f, $conexion);
				$familia = @mysql_result($res_f,0,"fa_nombre");
			//fin
			
			//busca subfamilia
				$sql_sf = "select sf_nombre from sgbodega.subfamilias where sf_subcodigo = '".$line_pd[4]."'";
				$res_sf = mysql_query($sql_sf, $conexion);
				$subfamilia = @mysql_result($res_sf,0,"sf_nombre");
			//fin
			
			$codigo = $line_pd[1];
			$codigo_antiguo = $line_pd[2];
			
                        $stock_nuevo = 0;
			$stock_usado = 0;
			
                        $fecha_inicio   =   "";
                        $fecha_termino  =   "";
                        
                        $ventas_men_nuevo=0;
                        $ventas_men_usa = 0;
                        
                        $nro_mes_anterior  = mktime(0, 0, 0, date("m")-3, date("d"),   date("Y"));
                        $fecha_mes_anterior = date("Y-m-d",$nro_mes_anterior);
                        $cant_dias_mes_anterior = date("t",$nro_mes_anterior);
                        $hoy_array      =   explode("-",$fecha_mes_anterior);
                        $fecha_inicio   =   $hoy_array[0].'-'.$hoy_array[1].'-1';
                        
                        // busco datos de la venta - Nuevo promedio 3 meses atras
                        $sql_tvm = "select sgyonley.ventas_detalle_antigua.vent_cant
				from 
				sgyonley.ventas_antigua
                                    inner join  sgyonley.ventas_detalle_antigua
                                        on sgyonley.ventas_antigua.vent_num_folio =  sgyonley.ventas_detalle_antigua.vent_ncorr 
                               where sgyonley.ventas_detalle_antigua.arti_codigo = ".$codigo."
                                    and sgyonley.ventas_detalle_antigua.arti_nu = 'N'
                                    and sgyonley.ventas_antigua.vent_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                                    and sgyonley.ventas_antigua.vent_estado_ingreso not in ('A','N','B','D','P')";
                       
                        $res_tvm = mysql_query($sql_tvm,$conexion) OR die(mysql_error());
                        $ventas_tri_nuevo =0;
                        while ($row_tvm = @mysql_fetch_row($res_tvm)){
                            $ventas_tri_nuevo   = $ventas_tri_nuevo + $row_tvm[0]/3;
                            }
                        // busco datos de la venta - Usado promedio tres meses atras
                        $sql_tvm = "select sgyonley.ventas_detalle_antigua.vent_cant
				from 
				sgyonley.ventas_antigua
                                    inner join  sgyonley.ventas_detalle_antigua
                                        on sgyonley.ventas_antigua.vent_num_folio =  sgyonley.ventas_detalle_antigua.vent_ncorr 
                                where sgyonley.ventas_detalle_antigua.arti_codigo = ".$codigo."
                                    and sgyonley.ventas_detalle_antigua.arti_nu = 'U'
                                    and sgyonley.ventas_antigua.vent_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                                    and sgyonley.ventas_antigua.vent_estado_ingreso not in ('A','N','B','D','P')";
                       
                        $res_tvm = mysql_query($sql_tvm,$conexion) OR die(mysql_error());
                        $ventas_tri_usa  =0;
                        while ($row_tvm = @mysql_fetch_row($res_tvm)){
                            $ventas_tri_usa   = $ventas_tri_usa  + $row_tvm[0]/3;
                            }
//                        todos = 0
//                        mensual =1
//                        3 meses =2
//                        sin movimientos = 3                        
                        if ($movimiento==3){
                            if (($ventas_men_nuevo>0)||($ventas_men_usa>0)||($ventas_tri_nuevo>0)||($ventas_tri_usa>0)){
                                $ventas_tri_no_estado='NO';
                                }
                            else{
                                $ventas_tri_no_estado='SI';
                                $ventas_men_estado='SI';
                                $ventas_tri_estado='SI';
                                }
                            }
                        else{
                                $ventas_tri_no_estado='SI';
                                if (($movimiento==0)){
                                    $ventas_men_estado='SI';
                                    $ventas_tri_estado='SI';
                                    }
                                if (($movimiento==1)){
                                    $ventas_men_estado='SI';
                                    $ventas_tri_estado='NO';
                                    }
                                if (($movimiento==2)){
                                    $ventas_men_estado='NO';
                                    $ventas_tri_estado='SI';
                                    }
                            }
                        if (($cod_prod == $line_pd[1])&&($cod_prod!='')&&($cod_prod!=' '))  { 
                            array_push($arrRegistros, array("item"		=>	$i,
                                                            "familia"		=>	$familia,
                                                            "subfamilia"	=>	$subfamilia,
                                                            "descripcion"	=> 	$line_pd[0],
                                                            "codigo" 		=> 	$line_pd[1],
                                                            "codigo_antiguo"	=> 	$line_pd[2],
                                                            "stock_nuevo"	=> 	$stock_nuevo,
                                                            "stock_usa"		=> 	$stock_usado,
                                                            "ventas_men_estado"	=> 	$ventas_men_estado,
                                                            "ventas_men_nuevo"	=> 	$ventas_men_nuevo,
                                                            "ventas_men_usa"	=> 	$ventas_men_usa,
                                                            "ventas_tri_estado"	=> 	$ventas_tri_estado,
                                                            "ventas_tri_nuevo"	=> 	$ventas_tri_nuevo,
                                                            "ventas_tri_usa"	=> 	$ventas_tri_usa,
                                                            "ventas_tri_no_estado"	=> 	$ventas_tri_no_estado));
                            }
                        if (($cod_prod=='')){
                            array_push($arrRegistros, array("item"		=>	$i,
                                                            "familia"		=>	$familia,
                                                            "subfamilia"	=>	$subfamilia,
                                                            "descripcion"	=> 	$line_pd[0],
                                                            "codigo" 		=> 	$line_pd[1],
                                                            "codigo_antiguo"	=> 	$line_pd[2],
                                                            "stock_nuevo"	=> 	$stock_nuevo,
                                                            "stock_usa"		=> 	$stock_usado,
                                                            "ventas_men_estado"	=> 	$ventas_men_estado,
                                                            "ventas_men_nuevo"	=> 	$ventas_men_nuevo,
                                                            "ventas_men_usa"	=> 	$ventas_men_usa,
                                                            "ventas_tri_estado"	=> 	$ventas_tri_estado,
                                                            "ventas_tri_nuevo"	=> 	$ventas_tri_nuevo,
                                                            "ventas_tri_usa"	=> 	$ventas_tri_usa,
                                                            "ventas_tri_no_estado"	=> 	$ventas_tri_no_estado));
                            }
			$i++;
                       
		}
		       
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_movimientos_mensuales_list.tpl'));
		//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	$objResponse->addScript("para()");
	
	
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
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_movimientos_mensuales_list.tpl'));
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
        $objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");
        return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLI-txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
                $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
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
	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
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
	
	$familia	=	$data["cboFamilia"];
	
        $objResponse->addAssign("OBLI-txtCodProducto", "value", "");
	$objResponse->addAssign("OBLI-txtDescProducto", "value", "");
	
	$objResponse->addAssign("cboSubFamilia","innerHTML",""); 		
	
	if 	($familia != 'Todas' &&  $familia != ''){
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";
	}else{
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO != '' group by SF_NOMBRE ORDER BY SF_NOMBRE ASC";
	}	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0) {
			$objResponse->addCreate("cboSubFamilia","option",""); 		
			$objResponse->addAssign("cboSubFamilia","options[0].value", '');
			$objResponse->addAssign("cboSubFamilia","options[0].text", 'Todas'); 	
			$j = 1;
			while ($line = mysql_fetch_array($res)) {
				$objResponse->addCreate("cboSubFamilia","option",""); 		
				$objResponse->addAssign("cboSubFamilia","options[".$j."].value", $line[0]);
				$objResponse->addAssign("cboSubFamilia","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
	//}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//carga familias
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
	$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	return $objResponse->getXML();
}          
function LlamaDetalle($data, $codigo, $descripcion){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	$cobrador			= 	$data["OBLI-txtCodCobrador"];
	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$ult_guia 			= 	$data["txtUltGuia"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;
	
	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 700, 280, null);");
	
	return $objResponse->getXML();
}
function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("LlamaDetalle");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_informe_movimientos_mensuales.tpl');

?>

