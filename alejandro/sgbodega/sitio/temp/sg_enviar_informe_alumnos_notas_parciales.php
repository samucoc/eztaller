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



$xajax->setRequestURI("sg_enviar_informe_alumnos_notas_parciales.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function Grabar($data){

	global $conexion;

	global $miSmarty;

    $objResponse = new xajaxResponse('UTF8');



	$rut                     =       $data['rut'];

    $semestre                =       $data['semestre'];

    $email					 =		 $data['email']    ;



   	$objResponse->addScript("showPopWin('pdfs/pdf_enviar_informe_alumnos_notas_parciales.php?rut=$rut&semestre=$semestre&email=$email', 'Imprime PDF', 800, 600, null);");



	return $objResponse->getXML();

	}



function CargaPagina($data){

    global $conexion;

	global $miSmarty;

    $objResponse = new xajaxResponse('UTF8');

	



		$anio =   $_SESSION["sige_anio_escolar_vigente"];

		$alumno = $data['rut'];



     	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,

								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado

					from gescolcl_arcoiris_administracion.Apoderados

					where NumeroRutApoderado in (select NumeroRutApoderado

													from gescolcl_nmva_administracion.alumnos".$anio."

													where NumeroRutAlumno = '".$alumno."')";

		$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

		$row_apoderado = mysql_fetch_array($res_apoderado);

		

		$objResponse->addAssign('email','value',$row_apoderado['EMailApoderado']);

	

		$sql_apoderado = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,

									alumnos".$anio.".`NumeroRutAlumno`, NroLista, NroMatricula

							from alumnos".$anio."

								inner join Matriculas

									on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and

										Matriculas.Anio = '".$anio."'

													where alumnos".$anio.".NumeroRutAlumno = '".$alumno."'";

		$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

		$row_apoderado = mysql_fetch_array($res_apoderado);

		

		$objResponse->addAssign('nombre_alumno','innerHTML',$row_apoderado['nombre_alumno']);

	

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



$miSmarty->assign('rut', $_GET['rut']);

$miSmarty->assign('semestre', $_GET['semestre']);

$miSmarty->assign('observacion', $_GET['observacion']);



$miSmarty->display('sg_enviar_informe_alumnos_notas_parciales.tpl');



ob_flush();

?>