<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_alumnos_beneficio_junaeb.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function CargaPagina($data){
    global $conexion;
    global $miSmarty;

    $objResponse = new xajaxResponse('UTF8');


	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$sql = "select 	Cursos.NombreCurso, 
					alumnos".$anio.".NumeroRutAlumno,
					concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
					NroLista
			from Cursos
				inner join alumnos".$anio."
					on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				inner join gescolcl_nmva_administracion.Matriculas
					on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
						Matriculas.Anio = '".$anio."' and 
						Matriculas.FechaRetiro = '0000-00-00'
			where BecaAlimenticia = '1' 
			order by Cursos.CodigoCurso, nombre_alumno
				";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	if (mysql_num_rows($res)>0){
		$arrRegistros		= 	array();
		$i=1;
		while($row = mysql_fetch_array($res)){
			array_push($arrRegistros, array("curso"			=>	$row['NombreCurso'],
											"rut_alumno"	=>	$row['NumeroRutAlumno'].'-'.dv($row['NumeroRutAlumno']),
											"nombre_alumno"	=> 	$row['nombre_alumno'],
											"NroLista"		=> 	$i,
											"observaciones" => 	''));
			$i++;
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_alumnos_beneficio_junaeb_list.tpl'));
	}
	else{
		$objResponse->addAssign("divabonos", "innerHTML", 'No se encontraron registros.');	
	}
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	return $objResponse->getXML();
       
}

$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_alumnos_beneficio_junaeb.tpl');

ob_flush();
?>

