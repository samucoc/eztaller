<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bono_ingresar.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$centro_costo 		= $data['OBLIcentro_costo'];
	$fecha	 			= $data['OBLI-txtFecha'];
	$monto	 			= $data['OBLItxtMontoIngresar'];
	$trabajador			= $data['OBLItxtRut'];
	$caja				= $data['caja'];
	$observacion		= $data['detalle'];
	$usuario			= $_SESSION['alycar_usuario'];
	$fecha_digitacion 	= date("Y-m-d H:i:s");
	$estado				= 'ESPERANDO_CORREO';
	$grupo 				= 1;
	$es_deposito			= $data['es_deposito'];
	
	list($anio3,$mes3,$dia3) = explode('-', date("Y-m-d"));
	list($dia2,$mes2,$anio2) = explode('/', $fecha);
	
	if (($mes3 == $mes2)&&($anio3 == $anio2)&&($dia3 <= $dia2)) {
		if (($fecha!='')&&($monto!='')&&($trabajador!='')){
			list($dia3,$mes3,$anio3) = explode('/', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;
			$fecha_ant = "";
			if (!isset($_SESSION['bono_grupo'])){
				$sql_grupo = "select (grupo + 1) as grupo, fecha, estado
								from bonos
								order by grupo desc
								limit 0,1";
				$res_grupo = mysql_query($sql_grupo,$conexion);
				if (mysql_num_rows($res_grupo)==0){
					$grupo=1;
					$fecha_ant = $fecha; //dia-mes-anio
					}
				else{
					$row_grupo = mysql_fetch_array($res_grupo);
					$grupo = $row_grupo['grupo'];
					
					$estado = $row_grupo['estado'];
					if ($estado!='ESPERANDO_CORREO'){
						$fecha_ant = $fecha; //dia-mes-anio
						}
					else{
						$fecha_ant = $row_grupo['fecha']; //anio-mes-dia
						}
					}
				}
			else{
				$grupo 		= $_SESSION['bono_grupo'] ;
				$sql_grupo = "select grupo, fecha, estado
								from bonos
								where grupo = '".$_SESSION['bono_grupo']."'";
				$res_grupo = mysql_query($sql_grupo,$conexion);
				if (mysql_num_rows($res_grupo)==0){
					$grupo = $_SESSION['bono_grupo'];
					$estado = 'ESPERANDO_CORREO';
					$fecha_ant = $fecha; 
					}
				else{
					$row_grupo = mysql_fetch_array($res_grupo);
					$grupo = $row_grupo['grupo'];
					$estado = $row_grupo['estado'];
					if ($estado!='ESPERANDO_CORREO'){
						$fecha_ant = $fecha; //dia-mes-anio
						}
					else{
						$fecha_ant = $row_grupo['fecha']; //anio-mes-dia
						}
					}
				}
			$_SESSION['bono_grupo'] = $grupo ;
			$objResponse->addAssign("grupo", "innerHTML",$grupo );
			$monto = str_replace(".", "", $monto);
			//$objResponse->addAlert($fecha_ant.'->'.$fecha);
			if (($es_deposito==1)||($caja==4)){
				$monto = $monto + 600;
				}
			if ($fecha_ant==$fecha){
					$sql = "insert into bonos ( grupo, `centro_costo`, `fecha`, `trabajador`,`monto`, `caja`, `observacion`, `estado`, `usuario`, `fecha_digitacion`) 
							values ('$grupo','$centro_costo','$fecha','$trabajador','$monto','$caja','$observacion','ESPERANDO_CORREO','$usuario','$fecha_digitacion')";
					$res = mysql_query($sql,$conexion) or die(mysql_error());
				}
			$sql_buscar = "select bono_ncorr, fecha, trabajador, monto, caja, observacion
							from bonos 
							where grupo = '".$_SESSION['bono_grupo']."'";
			$res_buscar = mysql_query($sql_buscar,$conexion);
			$arrRegistros = array();
			while ($row=mysql_fetch_array($res_buscar)){
				$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
							from sggeneral.trabajadores
							where rut = ".$row['trabajador'];
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
				$row_1 = mysql_fetch_array($res_1);
				
				$nombre_trabajador = $row_1['nombres'];
				$cantidad = $row['monto'];
				array_push($arrRegistros, array(
								"trabajador"	=> $nombre_trabajador,
								"monto"			=> $cantidad,
								"detalle"		=> $row['observacion'],
								"fecha"			=> $row['fecha'],
								"codigo"		=> $row['bono_ncorr']
								));
				$total = $total + $cantidad;
				}
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$miSmarty->assign('total', $total);
			$miSmarty->assign('grupo', $_SESSION['bono_grupo']);
			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_bono_ingresar_list.tpl'));	
			$objResponse->addAssign("OBLI-txtFecha", "value","");
			$objResponse->addAssign("OBLItxtMontoIngresar", "value","");
			$objResponse->addAssign("OBLItxtRut", "value","");
			$objResponse->addAssign("OBLItxtNombres", "value","");
			$objResponse->addAssign("detalle", "value","");
			}
		}
		else{
			$objResponse->addAlert("Fecha fuera del rango del mes");
			}
    return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);

	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	unset($_SESSION['bono_grupo']);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItt','tipos_trabajadores','','- - Seleccione - -','tt_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcentro_costo','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboOperacion','sgbanco.tipos_operaciones','','- - Seleccione - -','tope_ncorr','tope_desc', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'caja','sgcompras.forma_pago','','- - Seleccione - -','	fp_ncorr','nombre', ' where fp_ncorr in (1,4)')");
	$objResponse->addAssign("grupo", "innerHTML", $_SESSION['bono_grupo'] );
  	return $objResponse->getXML();

}  

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data[$objeto1];
	$empresa = $data['OBLIcentro_costo'];
	
	if ($tabla == 'sggeneral.trabajadores'){
		$campo2 = "concat(nombres,' ',apellido_pat,' ',apellido_mat)";
		}
	$sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '$rut' $c_and and empresa_contr = '".$empresa."'";
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
    if ($tabla != 'personas'){
           $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
        } 
    else{
            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";
        }
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}
function CargaPopWin($data, $url){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$url = $url .'&empresa='.$data['OBLIcentro_costo'];
	$objResponse->addScript("showPopWin('".$url."', 'Busca Trabajador', 550, 350, null);");

	return $objResponse->getXML();
	
}
function Eliminar($data, $ncorr){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$sql_4 = "select grupo from sgvales.bonos where bono_ncorr = '".$ncorr."'";
	$res_4 = mysql_query($sql_4,$conexion) or die(mysql_error());
	$row_4 = mysql_fetch_array($res_4);
	$grupo = $row_4['grupo'];
	
	$sql_5 = "delete from sgvales.bonos where bono_ncorr = '".$ncorr."'";
	$res_5 = mysql_query($sql_5,$conexion) or die(mysql_error());
	
	$sql_buscar = "select bono_ncorr, fecha, trabajador, monto, caja, observacion
							from sgvales.bonos 
							where grupo = '".$grupo."'";
	$res_buscar = mysql_query($sql_buscar,$conexion) or die(mysql_error());
	$arrRegistros = array();
	$total = 0;
	if (mysql_num_rows($res_buscar)>0){
		while ($row=mysql_fetch_array($res_buscar)){
			$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
						from sggeneral.trabajadores
						where rut = ".$row['trabajador'];
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$nombre_trabajador = $row_1['nombres'];
			$cantidad = $row['monto'];
			array_push($arrRegistros, array(
							"trabajador"	=> $nombre_trabajador,
							"monto"			=> $cantidad,
							"detalle"		=> $row['observacion'],
							"fecha"			=> $row['fecha'],
							"codigo"		=> $row['bono_ncorr']
							));
			$total = $total + $cantidad;
			}
		}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$miSmarty->assign('total', $total);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_bono_ingresar_list.tpl'));			
	
	return $objResponse->getXML();
	
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPopWin");
$xajax->registerFunction("Eliminar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_bono_ingresar.tpl');

?>

