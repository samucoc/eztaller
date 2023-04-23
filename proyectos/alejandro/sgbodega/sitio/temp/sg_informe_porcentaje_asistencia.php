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



$xajax->setRequestURI("sg_informe_porcentaje_asistencia.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){

	global $conexion;

	

        $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$obj1", "value", $campo1);

	$objResponse->addAssign("$obj2", "value", $campo2);

	if ($obj1 == 'OBLI-txtCodCobrador'){

        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");

        

            }

	return $objResponse->getXML();

}



function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	// carga empresas

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -',' distinct AnoAcademico','AnoAcademico', '')");

	

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



function CargaListado($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$Curso 					= 	$data["curso"];

	$Semestre				=	$data['semestre'];

	$Mes					=	$data['mes'];

	$Anio					=	$data['anio'];

	$arrRegistros			= 	array();

	$miSmarty->assign('periodo',$Semestre);

	$miSmarty->assign('anio',$Anio);

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	// busca los registros

	$sql_ve = "SELECT * FROM Periodos where AnoAcademico = '".$Anio."' and Semestre = '".$Semestre."'";

	

	$res_ve = mysql_query($sql_ve, $conexion);



	$row_ve = mysql_fetch_array($res_ve);



	$fecha1		= 	$row_ve['InicioPeriodo'];

	$fecha2		=	$row_ve['TerminoPeriodo'];

	$cant_dias 	=	$row_ve['DiasPeriodo'];

	

		

			

			

		$select_notas = "select count(distinct alumnos.NumeroRutAlumno)/COALESCE(count(Inasistencias.NumeroRutAlumno),0) as inasistencia, 

						Cursos.CodigoCurso, NombreCurso

						from Inasistencias

							inner join alumnos

								on alumnos.NumeroRutAlumno = Inasistencias.NumeroRutAlumno

							inner join Cursos

								on Cursos.CodigoCurso = alumnos.CodigoCurso

						where FechaInasistencia between '".$fecha1."' and '".$fecha2."'

						group by CodigoCurso";

		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

		$atraso = "NO";

		while($row_notas = mysql_fetch_array($res_notas)){

			

			$porcentaje = round((100 - (($row_notas['inasistencia']*100)/$cant_dias)),2);

		

			array_push($arrRegistros, array(	"curso"				=> 	$row_notas['NombreCurso'] , 

												"porcentaje"		=>	$porcentaje.' %'

												));

					

			}

					

					

			

		$miSmarty->assign('arrRegistros', $arrRegistros);

		

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_porcentaje_asistencia_list.tpl'));

		

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

	

	return $objResponse->getXML();

}



function ConfirmarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "insert into Inasistencias(NumeroRutAlumno,FechaInasistencia) values ('$rut_alumno','$fecha')";

	$res = mysql_query($sql,$conexion) or die(mysql_error());



	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");



	return $objResponse->getXML();

	}



function EliminarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "delete from Inasistencias where NumeroRutAlumno = '$rut_alumno' and FechaInasistencia = '$fecha'";

	$res = mysql_query($sql,$conexion) or die(mysql_error());



	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");

	

	return $objResponse->getXML();

	}



$xajax->registerFunction("CargaListado");

$xajax->registerFunction("ConfirmarInasistencia");

$xajax->registerFunction("EliminarInasistencia");

$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaAsignaturas");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->display('sg_informe_porcentaje_asistencia.tpl');



ob_flush();

?>



