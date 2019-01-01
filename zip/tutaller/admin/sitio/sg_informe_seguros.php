<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_seguros.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboPatente		= 	$data["cboPatente"];
	$cboPersona		= 	$data["cboPersona"];
	$persona		= 	$data["rut_trabajador"];
	$fecha_inicio	= 	$data["mes"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
    $and="";
		
    if ($cboPatente != ''){   
		$and = " and veh_patente like '%".$cboPatente."%'" ;
		}
	if ($cboPersona != ''){   
		$and = " and veh_patente in (select patente
										from personas_tienen_vehiculos
										where rut = '".$persona."')" ;
		}
		    
	$sql_ab = "select veh_patente, veh_term_seg, veh_emp_ase, veh_mont_prima
               	from vehiculos
                where veh_term_seg = '".$fecha_inicio."'
					".$and."";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 1;
			while ($line_ab_1 = mysql_fetch_row($res_ab)){
				
				$sql_1 = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut in	(select rut
													from personas_tienen_vehiculos
													where patente = '".$line_ab_1[0]."')";
				$res_1 = mysql_query($sql_1, $conexion);
                $nombre_persona = @mysql_result($res_1,0,"pers_nombre_com");
				
				$sql_2 = "select nombre	
							from meses 
							where mes_ncorr = '".$line_ab_1[1]."'";
				$res_2 = mysql_query($sql_2, $conexion);
                $mes = @mysql_result($res_2,0,"nombre");
				
				$sql_1 = "select nombre
							from empresas_aseguradoras 
							where empresa_ncorr = '".$line_ab_1[2]."'";
				$res_1 = mysql_query($sql_1, $conexion);
                $aseguradora = @mysql_result($res_1,0,"nombre");
				
                array_push($arrRegistros, array("item"				=>	$i,
												"patente"         	=> 	$line_ab_1[0],
												"responsable"  		=> 	$nombre_persona,
												"mes_caduca"      	=> 	$mes,
												"aseguradora"      	=> 	$aseguradora,
												"prima"     		=> 	$line_ab_1[3]));	
                $i++;
            	} 
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_seguros_list.tpl'));
		
	}else{
		
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_reparaciones_list.tpl'));
	
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


$miSmarty->display('sg_informe_seguros.tpl');

?>

