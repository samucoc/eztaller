<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
/*
include "../includes/php/class.phpmailer.php";
include "../	includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";
*/
$xajax = new xajax();

$xajax->setRequestURI("sg_cobranza_depositos_cheques.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data){
    global $conexion;
    global $miSmarty;
	$objResponse = new xajaxResponse('UTF8');
	
	$arrRegistros = array();

	$fecha_inicio = $data['fecha_inicio'];
	$fecha_fin = $data['fecha_fin'];

	list($dia,$mes,$anio) = explode('/',$fecha_inicio);
	$fecha_inicio = $anio.'-'.$mes.'-'.$dia;
	list($dia,$mes,$anio) = explode('/',$fecha_fin);
	$fecha_fin = $anio.'-'.$mes.'-'.$dia;
	
	if (($data['banco']!='Todos')){
		$and .= ' Cheques.CodigoBanco = '.$data['banco'].' and ';
		}

	$sql_boletas = "select distinct `NumeroCheque`, `NombreBanco`, `ValorCheque`, 
							FechaCheque, `EstadoCheque`, Cheques.NumeroBoleta, cheque_ncorr,
							PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso,
							PaternoApoderado, MaternoApoderado, NombresApoderado
					from gescolcl_arcoiris_administracion.Cheques
						inner join gescolcl_arcoiris_administracion.Bancos 
							on Cheques.CodigoBanco = Bancos.CodigoBanco
						inner join gescolcl_arcoiris_administracion.Movimientos
							on Cheques.NumeroBoleta = Movimientos.NumeroBoleta
						inner join gescolcl_arcoiris_administracion.alumnos
							on Movimientos.NumeroRutAlumno = alumnos.NumeroRutAlumno
						inner join gescolcl_arcoiris_administracion.Cursos
							on alumnos.CodigoCurso = Cursos.CodigoCurso
						inner join gescolcl_arcoiris_administracion.Apoderados
							on Apoderados.NumeroRutApoderado = alumnos.NumeroRutApoderado
					where $and FechaCheque between '".$fecha_inicio."' and '".$fecha_fin."'";
	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

	if (mysql_num_rows($res_boletas)>0){
		while($row_boletas = mysql_fetch_array($res_boletas)){
			if($row_boletas['EstadoCheque']=='0'){
				$estado = 'No Cobrado';
				}
			else if($row_boletas['EstadoCheque']=='1'){
				$estado = 'Cobrado';
				}
			else if($row_boletas['EstadoCheque']=='2'){
				$estado = 'Anulado';
				}
			list($anio,$mes,$dia) = explode('-',$row_boletas['FechaCheque']);
			$fecha = $dia.'-'.$mes.'-'.$anio;
			array_push($arrRegistros, array("item"				=>	$i,
													"nro_cheque" 			=> 	$row_boletas['NumeroCheque'],
													"banco" 	=> 	$row_boletas['NombreBanco'],
													"valor"		=> 	$row_boletas['ValorCheque'],
													"fecha"		=> 	$fecha, 
													"estado" 			=> 	$estado,
											"alumno"			=>	$row_boletas['PaternoAlumno'].' '.$row_boletas['MaternoAlumno'].' '.$row_boletas['NombresAlumno'],
											"apoderado"			=>	$row_boletas['PaternoApoderado'].' '.$row_boletas['MaternoApoderado'].' '.$row_boletas['NombresApoderado'],
											"curso"			=>	$row_boletas['NombreCurso']
													));
			$total = $total +  $row_boletas['ValorCheque'];

			$miSmarty->assign('banco',$row_boletas['NombreBanco']);
			}

		$miSmarty->assign('desde',$fecha_inicio);
		$miSmarty->assign('hasta',$fecha_fin);
		$miSmarty->assign('total',$total);
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cobranza_depositos_cheques_list.tpl'));
		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		
		}
	else{
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cobranza_depositos_cheques_list.tpl'));
		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		$objResponse->addAlert("Cheques no encontrados");
		}

	return $objResponse->getXML();
}          

function VerDetalle($data,$rut_alumno){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("showPopWin('sg_cobranza_depositos_cheques_detalle.php?rut_alumno=$rut_alumno', 'Detalle Cobranza', 700, 280, null);");


	return $objResponse->getXML();
}

function Imprime($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'banco','gescolcl_arcoiris_administracion.Bancos','','Todos','CodigoBanco','NombreBanco', '')");
	
	//$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
	
	$fecha_hoy = date('d/m/Y');
	$fecha_30 = date('d/m/Y',mktime(0,0,0,date('m'),date('d')+30,date('Y')));

	$objResponse->addAssign('fecha_inicio','value',$fecha_hoy);
	$objResponse->addAssign('fecha_fin','value',$fecha_30);
	
	return $objResponse->getXML();
}


function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
             $j=0;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $codigo);
			$objResponse->addAssign("$select","options[".$j."].text", $descripcion); 	
			$j++;

                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}


$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("VerDetalle");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('rut_alumno', $_GET['rut_alumno']);

$miSmarty->display('sg_cobranza_depositos_cheques.tpl');


ob_flush();
?>

