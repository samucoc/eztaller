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



$xajax->setRequestURI("sg_cobranza_alumnos_morosos_detalle.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	

	$alumno = $data['rut_alumno'];



	$arrRegistros = array();



	$fecha_buscar = $data['fecha_buscar'];



	list($dia,$mes,$anio) = explode('/',$fecha_buscar);

	$fecha_buscar = $anio.'-'.$mes.'-'.$dia;





	$anio = $_SESSION["sige_anio_escolar_vigente"];







	$sql_boletas = "select concat(PaternoAlumno,' ',MaternoAlumno,' ', NombresAlumno) as alumno, 

							concat(PaternoApoderado,' ',MaternoApoderado,' ', NombresApoderado) as apoderado, 

							Cursos.NombreCurso, alumnos".$anio.".NumeroRutAlumno, 

							ValorPactado, ValorPagado,

							ValorPactado, ValorPagado,

							(ValorPactado)-(ValorPagado) as saldo, FechaVencimiento, 

							CuentaCorriente".$anio.".CodigoItem, CuentaCorriente".$anio.".NumeroCuota

					from gescolcl_arcoiris_administracion.CuentaCorriente".$anio." 

						inner join gescolcl_arcoiris_administracion.alumnos".$anio." 

							on alumnos".$anio.".NumeroRutAlumno = CuentaCorriente".$anio.".NumeroRutAlumno

						inner join gescolcl_arcoiris_administracion.Cursos 

							on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso

						inner join gescolcl_arcoiris_administracion.Apoderados 

							on Apoderados.NumeroRutApoderado = alumnos".$anio.".NumeroRutApoderado

					where alumnos".$anio.".NumeroRutAlumno = '".$alumno."'

						and FechaVencimiento < '".$fecha_buscar."'

					having saldo > 0 ";

	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

	while($row_boletas = mysql_fetch_array($res_boletas)){

		

		$CodigoItem = $row_boletas['CodigoItem'];

		if ($CodigoItem=='1'){

			$CodigoItem = 'Colegiatura';

			$row_boletas['NumeroCuota'] = 0;

			}

		else{

			$CodigoItem = 'Colegiatura';

			}

		array_push($arrRegistros, array("item"			=>	"-",

										"tipo_cuota"	=>	$CodigoItem,

										"nombre_alumno"	=>	$row_boletas['alumno'],

										"nro_cuota"		=>	$row_boletas['NumeroCuota'],

										"fecha_venc"	=>	$row_boletas['FechaVencimiento'],

										"pactado"		=>	$row_boletas['ValorPactado'],

										"pagado"		=>	$row_boletas['ValorPagado'],

										"saldo"			=>	$row_boletas['saldo']

										));

		$total_saldo += $row_boletas['saldo'];

		$nombre_alumno = $row_boletas['alumno'];

		$nombre_apoderado = $row_boletas['apoderado'];

		$nombre_curso = $row_boletas['NombreCurso'];

		}



	$miSmarty->assign('arrRegistros', $arrRegistros);

	$miSmarty->assign('total_saldo', $total_saldo);

	$miSmarty->assign('nombre_alumno', $nombre_alumno);

	$miSmarty->assign('nombre_apoderado', $nombre_apoderado);

	$miSmarty->assign('nombre_curso', $nombre_curso);



	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cobranza_alumnos_morosos_detalle_list.tpl'));

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");



	return $objResponse->getXML();

}          



function VerDetalle($data,$rut_alumno){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("showPopWin('sg_cobranza_alumnos_morosos_detalle_detalle.php?rut_alumno=$rut_alumno', 'Detalle Cobranza', 700, 280, null);");





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

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','gescolcl_arcoiris_administracion.Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	

	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");

	

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

$xajax->registerFunction("CargaListado");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("VerDetalle");

$xajax->registerFunction("Imprime");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('rut_alumno', $_GET['rut_alumno']);

$miSmarty->assign('fecha_buscar', $_GET['fecha_buscar']);



$miSmarty->display('sg_cobranza_alumnos_morosos_detalle.tpl');





ob_flush();

?>



