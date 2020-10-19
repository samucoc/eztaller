<?php

	ob_start();

	session_start();



	require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

	include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

	include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

	include "../includes/php/validaciones.php"; 

	

	include "../includes/php/phpmailer/class.phpmailer.php";

	include "../includes/php/phpmailer/class.pop3.php";

	include "../includes/php/phpmailer/class.smtp.php";





	$xajax = new xajax();



	$xajax->setRequestURI("sg_cobranza_alumnos_morosos.php");

	$xajax->setCharEncoding("UTF8");

	$xajax->decodeUTF8InputOn();





	function Grabar($data){

	    global $conexion;

	    global $miSmarty;

		$objResponse = new xajaxResponse('UTF8');

		

		$fecha_buscar = $data['fecha_buscar'];

		$curso 		  = $data['curso'];

		$arrRegistros = array();

		$and = "";

		if (($curso!='Todos')){

			$and .= " and Cursos.CodigoCurso = '".$curso."' ";

			}





		list($dia,$mes,$anio) = explode('/',$fecha_buscar);

		$fecha_hoy = $anio.'-'.$mes.'-'.$dia;



		$anio = $_SESSION["sige_anio_escolar_vigente"];



		$sql_boletas = "select distinct concat(PaternoAlumno,' ',MaternoAlumno,' ', NombresAlumno) as alumno, 

								Cursos.NombreCurso, alumnos".$anio.".NumeroRutAlumno, 

								sum(ValorPactado)-sum(ValorPagado) as saldo, FechaVencimiento,

								Matriculas.FechaRetiro

						from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."

							inner join gescolcl_arcoiris_administracion.alumnos".$anio."

								on alumnos".$anio.".NumeroRutAlumno = CuentaCorriente".$anio.".NumeroRutAlumno

							inner join gescolcl_arcoiris_administracion.Cursos 

								on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso

							inner join gescolcl_arcoiris_administracion.Matriculas 

								on Matriculas.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno

						where 1 $and

						and ValorPactado > ValorPagado 

						and FechaVencimiento < '".$fecha_hoy."'

						group by NroMatricula, NroLista, alumnos".$anio.".NumeroRutAlumno

						";

		$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

		while($row_boletas = mysql_fetch_array($res_boletas)){

			$sql_diff = "SELECT DATEDIFF('".$fecha_hoy."','".$row_boletas['FechaVencimiento']."') AS DiffDate";

			$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());

			$row_diff = mysql_fetch_array($res_diff);

			$da = $row_diff['DiffDate'];

			if ($da>0){

				$FechaRetiro = $row_boletas['FechaRetiro'];

				if ($FechaRetiro=='0000-00-00'){

					$retirado = 'NO';

				}

				else{

					$retirado = 'SI';
					$da = 'RETIRADO';

				}

				array_push($arrRegistros, array("item"			=>	"-",

												"rut_alumno"	=>	$row_boletas['NumeroRutAlumno'],

												"alumno"		=>	$row_boletas['alumno'],

												"curso"			=>	$row_boletas['NombreCurso'],

												"saldo"			=>	$row_boletas['saldo'],

												"fecha_buscar"	=>	$fecha_hoy,

												"fecha_retirado"	=>	$retirado,

												"da"			=>	$da

												));

				}

			}



		$miSmarty->assign('arrRegistros', $arrRegistros);

		$_SESSION["alycar_matriz"] 			= 	$arrRegistros;

			

		$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'alumno');");

				

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cobranza_alumnos_morosos_list.tpl'));

		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");



		return $objResponse->getXML();

	}          



	function VerDetalle($data,$rut_alumno){

	    global $conexion;

	    $objResponse = new xajaxResponse('UTF8');

		

		$fecha_buscar = $data['fecha_buscar'];

		

		$objResponse->addScript("showPopWin('sg_cobranza_alumnos_morosos_detalle.php?rut_alumno=$rut_alumno&fecha_buscar=$fecha_buscar', 'Detalle Cobranza', 800, 480, null);");





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

		

		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','gescolcl_arcoiris_administracion.Cursos','','Todos','CodigoCurso','NombreCurso', '')");

		

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



	function OrdenarRevision($data, $campo){

		global $conexion;

		global $miSmarty;

		

	    $objResponse = new xajaxResponse('UTF8');

		

		$orden_asc 	= 'ASC';

		$orden_desc = 'DESC';

		

		$campo_orden 		= 	$campo;

		if ($_SESSION["alycar_orden"] =='ASC')

			$direccion_orden	=	$orden_desc;

		else

			$direccion_orden	=	$orden_asc;



		$arrRegistros = array();

		$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);

		$_SESSION["alycar_orden"] 			= 	$direccion_orden;

		$_SESSION["alycar_matriz"] 			= 	$arrRegistros;

				

		$miSmarty->assign('arrRegistros', $arrRegistros);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cobranza_alumnos_morosos_list.tpl'));

		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");



		return $objResponse->getXML();

	}



function ImprimePDF($data,$rut_alumno,$fecha_buscar){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$objResponse->addScript("showPopWin('pdf_informe_cobranza_alumno_moroso.php?rut=$rut_alumno&fecha_buscar=$fecha_buscar', 'Imprime PDF', 800, 600, null);");



	return $objResponse->getXML();

	}







function EnviarPDF($data,$rut_alumno,$fecha_buscar){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$objResponse->addScript("showPopWin('sg_enviar_cobranza_alumnos_morosos.php?rut=$rut_alumno&fecha_buscar=$fecha_buscar', 'Enviar PDF', 800, 300, null);");



	return $objResponse->getXML();

	}





function ImprimePDF_2($data,$rut_alumno,$fecha_buscar){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$objResponse->addScript("showPopWin('pdf_informe_cobranza_alumno_moroso_2.php?rut=$rut_alumno&fecha_buscar=$fecha_buscar', 'Imprime PDF', 800, 600, null);");



	return $objResponse->getXML();

	}







function EnviarPDF_2($data,$rut_alumno,$fecha_buscar){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$objResponse->addScript("showPopWin('sg_enviar_cobranza_alumnos_morosos_2.php?rut=$rut_alumno&fecha_buscar=$fecha_buscar', 'Enviar PDF', 800, 300, null);");



	return $objResponse->getXML();

	}







function ImprimePDFSeleccionados($data,$fecha_buscar){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



    $_SESSION['seleccinados'] = $data['seleccion'];

	$fecha_buscar = $data['fecha_buscar'];

	list($d,$m,$a) = explode('/',$fecha_buscar);

	$fecha_buscar = $a.'-'.$m.'-'.$d;



	$objResponse->addScript("showPopWin('pdf_informe_cobranza_alumno_moroso_todos.php?fecha_buscar=$fecha_buscar', 'Imprime PDF Seleccionados', 800, 600, null);");



	return $objResponse->getXML();

	}







function EnviarCorreoSeleccionados($data,$fecha_buscar){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');

 

 	$_SESSION['seleccinados'] = $data['seleccion'];



	//$objResponse->addScript("showPopWin('pdf_cobranza_alumnos_morosos_todos.php?fecha_buscar=$fecha_buscar', 'Enviar Correo Seleccionados', 800, 600, null);");



	return $objResponse->getXML();

	}









	$xajax->registerFunction("Grabar");

	$xajax->registerFunction("CargaListado");

	$xajax->registerFunction("CargaSelect");

	$xajax->registerFunction("VerDetalle");

	$xajax->registerFunction("Imprime");

	$xajax->registerFunction("ImprimePDF");

	$xajax->registerFunction("EnviarPDF");

	$xajax->registerFunction("ImprimePDF_2");

	$xajax->registerFunction("EnviarPDF_2");

	$xajax->registerFunction("ImprimePDFSeleccionados");

	$xajax->registerFunction("EnviarCorreoSeleccionados");

	$xajax->registerFunction("OrdenarRevision");



	$xajax->processRequests();

	$miSmarty->assign('xajax_js', $xajax->getJavascript());



	$miSmarty->display('sg_cobranza_alumnos_morosos.tpl');





	ob_flush();

	?>



