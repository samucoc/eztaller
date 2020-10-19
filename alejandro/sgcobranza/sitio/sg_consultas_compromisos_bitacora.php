<?php

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_consultas_compromisos_bitacora.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');



	$arrRegistros = [];



	list($d,$m,$a) = explode('/',$data['fch_buscar']);

	

	$anio = $_SESSION["sige_anio_escolar_vigente"];

   

	$sql = "select Bitacoras.NumeroRutApoderado, 

					concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as apoderado,

					concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as alumno,

					DireccionParticularApoderado,

					TelefonoMovilApoderado,

					TelefonoParticularApoderado,

					DescripcionCompromiso,

					EMailAlumno

			from gescolcl_arcoiris_administracion.Apoderados

				inner join gescolcl_arcoiris_administracion.Bitacoras

					on Bitacoras.NumeroRutApoderado = Apoderados.NumeroRutApoderado

				inner join gescolcl_arcoiris_administracion.alumnos".$anio."

					on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado

			where FechaCompromiso = '".$a."-".$m."-".$d."'";

	$res = mysql_query($sql,$conexion)or die(mysql_error());

	while($row = mysql_fetch_array($res)){

		$arrRegistros[] = [

							'apoderado' => $row['apoderado'],

							'alumno' => $row['alumno'],

							'direccion_apoderado' => $row['DireccionParticularApoderado'],

							'telefono_apoderado' => $row['TelefonoMovilApoderado'].'-'.$row['TelefonoParticularApoderado'],

							'email' => $row['EMailAlumno'],

							'fecha_compromiso' => $d."-".$m."-".$a,

							'descripcion_compromiso' => $row['DescripcionCompromiso']

							];



	}

	

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_consultas_compromisos_bitacora_list.tpl'));





	return $objResponse->getXML();

}          









$xajax->registerFunction("Grabar");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());





$miSmarty->display('sg_consultas_compromisos_bitacora.tpl');

?>

