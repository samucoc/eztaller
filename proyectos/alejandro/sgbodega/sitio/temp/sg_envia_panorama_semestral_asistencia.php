<?php 

ob_start();

session_start();





require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley

//include "../includes/php/sgbodega.php"; 

include "../includes/php/validaciones.php"; 



$xajax = new xajax();



$xajax->setRequestURI("sg_envia_panorama_semestral_asistencia.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function Grabar($data){

	global $conexion;

	global $miSmarty;

    $objResponse = new xajaxResponse('UTF8');



	$curso                     	=       $data['curso'];
    $anio 						= 		$data["anio"];
	$semestre                   =       $data['semestre'];

    $email						=		$data['email']    ;



   	$objResponse->addScript("showPopWin('pdfs/pdf_enviar_panorama_semestral_asistencia.php?email=$email&curso=$curso&anio=$anio&semestre=$semestre', 'Imprime PDF', 800, 600, null);");



	return $objResponse->getXML();

	}



function CargaPagina($data){

    global $conexion;

	global $miSmarty;

    $objResponse = new xajaxResponse('UTF8');

	



		$anio =   $_SESSION["sige_anio_escolar_vigente"];

		$curso = $data['curso'];



     	$sql_apoderado = "select concat(NombresProfesor,' ', PaternoProfesor,' ',MaternoProfesor) as nombre,

								NumeroRutProfesor, EMailFuncionario, CelularProfesor

					from gescolcl_arcoiris_administracion.Profesores

					where NumeroRutProfesor in (select ProfesorJefe

													from gescolcl_nmva_administracion.Cursos
													
													where CodigoCurso = '".$curso."')";

		$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

		$row_apoderado = mysql_fetch_array($res_apoderado);

		

		$objResponse->addAssign('email','value',$row_apoderado['EMailFuncionario']);

	

	return $objResponse->getXML();



}  



function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

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

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	

	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";

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







$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('curso', $_GET['curso']);
$miSmarty->assign('anio', $_GET['anio']);
$miSmarty->assign('semestre', $_GET['semestre']);



$miSmarty->display('sg_envia_panorama_semestral_asistencia.tpl');



ob_flush();

?>