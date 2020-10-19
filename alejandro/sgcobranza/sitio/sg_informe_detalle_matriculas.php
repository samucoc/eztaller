<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 
$xajax = new xajax();

$xajax->setRequestURI("sg_informe_detalle_matriculas.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();




function Grabar($data){
    global $conexion;
    global $miSmarty;
	$objResponse = new xajaxResponse('UTF8');
	
	$anio = $data['anio'];
	
	$and = " Movimientos.PeriodoMovimiento = '".$anio."' and 
				DescripcionBoleta like '%Pago Colegiatura 0%' and
				alumnos".$anio.".Matriculado = '1' ";

	$arrRegistros = array();

	
	$sql_boletas = "select distinct Movimientos.NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno,
									NombreCurso, FechaBoleta, NumeroBoleta
					from gescolcl_arcoiris_administracion.alumnos".$anio."  	
						inner join gescolcl_arcoiris_administracion.Cursos   	
							on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso 	 
						inner join gescolcl_arcoiris_administracion.Movimientos
							on alumnos".$anio.".NumeroRutAlumno = Movimientos.NumeroRutAlumno  	
						where $and  
			";
	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
		while($row_boletas = mysql_fetch_array($res_boletas)){
			
			list($anio,$mes,$dia) = explode('-',$row_boletas['FechaBoleta']);
			$fecha = $dia.'-'.$mes.'-'.$anio;

			array_push($arrRegistros, array("NumeroRutAlumno"		=>	$row_boletas['NumeroRutAlumno'].'-'.dv($row_boletas['NumeroRutAlumno']),
											"alumno"			=>	$row_boletas['PaternoAlumno'].' '.$row_boletas['MaternoAlumno'].', '.$row_boletas['NombresAlumno'],
											"curso"				=>	$row_boletas['NombreCurso'],
											"FechaBoleta"		=>	$fecha,
											"NumeroBoleta"		=>	$row_boletas['NumeroBoleta']
											
											));
			
			}
			
		$miSmarty->assign('arrRegistros', $arrRegistros);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_detalle_matriculas_list.tpl'));
		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	return $objResponse->getXML();
	}          

function CargaListado($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','gescolcl_arcoiris_administracion.Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', '')");

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

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_detalle_matriculas.tpl');
?>
