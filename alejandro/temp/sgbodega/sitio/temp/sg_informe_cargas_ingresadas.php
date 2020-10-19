<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_cargas_ingresadas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$persona		= 	$data["OBLI-txtCodCobrador"];
	$fecha_inicio		= 	$data["OBLI-txtFecha1"];
	$fecha_fin		= 	$data["OBLI-txtFecha2"];
	$detalle		= 	$data["cboDetalle"];
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_inicio);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
        
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_fin);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_fin              = date("Y-m-d",$nro_mes_anterior);
        $and="";
        if ($persona != 'todos'){
            $and = " and carga_pers = '".$persona."'" ;
        }
        if ($detalle != 'todos'){
            $and .= " group by  carga_pers 
                        order by carga_fecha desc" ;
        }
        
	$sql_ab = "select *
                    from cargas_vehiculos 
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                            ".$and."";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		if ($detalle == 'todos'){
                    $line_ab = mysql_fetch_row($res_ab); 
                    $sql_pr = "select * from personas where pers_rut = '".$line_ab[2]."'";
                    $res_pr = mysql_query($sql_pr, $conexion);
                    $nombre_persona = @mysql_result($res_pr,0,"pers_nombre")." ".@mysql_result($res_pr,0,"pers_ape_pat");
                    
                    $sql_pr = "select * 
                                from persona_tiene_cupos 
                                where rut_pers = '".$line_ab[2]."' 
                                    and fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                                order by fecha desc 
                                limit 0,1";
                    $res_pr = mysql_query($sql_pr, $conexion);
                    $cupo_persona = @mysql_result($res_pr,0,"cupo");
                    $fecha = @mysql_result($res_pr,0,"fecha");

                    array_push($arrRegistros, array("item"		=>	$i,
                                                    "vehiculo" 	=> 	"Sin Vehiculo",
                                                    "persona" 	=> 	$nombre_persona,
                                                    "debe"      	=> 	$cupo_persona,
                                                    "haber" 	=> 	"0",
                                                    "saldo" 	=> 	$cupo_persona,
                                                    "fecha" 	=> 	$fecha,
                                                    "tipo"          => 	"Cupo Autorizado"));
                    $i++;
                    }
                $sql_ab = "select *
                    from cargas_vehiculos 
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                            ".$and."";
                $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$saldo = $cupo_persona;
                while ($line_ab_1 = mysql_fetch_row($res_ab)){
                    
                    $sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com from personas where pers_rut = '".$line_ab_1[2]."'";
                    $res_pr = mysql_query($sql_pr, $conexion);
                    $nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
                    
                    $patente = $line_ab_1[1];
                    
                    $sql_pr_1 = "select nombre from  tipo_carga_comb where tipo_carg_ncorr = '".$line_ab_1[5]."'";
                    $res_pr_1 = mysql_query($sql_pr_1, $conexion);
                    $tipo_carga_comb = @mysql_result($res_pr_1,0,"nombre");
                    $saldo = $saldo - $line_ab_1[3];
                    array_push($arrRegistros, array("item"		=>	$i,
                                                    "ncorr"         	=> 	$line_ab_1[0],
                                                    "vehiculo"  	=> 	$patente,
                                                    "persona"           => 	$nombre_persona,
                                                    "debe"      	=> 	"0",
                                                    "haber"     	=> 	$line_ab_1[3],
                                                    "saldo"     	=> 	$saldo,
                                                    "fecha"             => 	$line_ab_1[4],
                                                    "tipo"              => 	$tipo_carga_comb));
                    $i++;
                    
                    } 
		$_SESSION["alycar_matriz"] = $arrRegistros;
                $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_cargas_ingresadas_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros".$sql_ab);
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_cargas_ingresadas_list.tpl'));
	
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
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboPersona','personas','todos','Todos','pers_rut', 'pers_nombre', '')");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_informe_cargas_ingresadas.tpl');

?>

