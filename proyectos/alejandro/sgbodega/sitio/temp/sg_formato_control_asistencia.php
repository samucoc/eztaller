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

include "../includes/php/class.pop3.php";

include "../includes/php/class.smtp.php";

include "../includes/php/PHPExcel.php";

include "../includes/php/PHPExcel/Reader/Excel2007.php";

*/

$xajax = new xajax();



$xajax->setRequestURI("sg_formato_control_asistencia.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');

	

	$curso = $data['curso'];

	$mes = $data['mes'];

	

	$objResponse->addScript("showPopWin('pdfs/pdf_formato_control_asistencia.php?curso=".$curso."&mes=".$mes."', 'Imprimir Control Asistencia', 1200, 560, null);");

		       

	

	return $objResponse->getXML();

}



function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){

	global $conexion;

	

        $objResponse = new xajaxResponse('UTF8');

	

        $objResponse->addAssign("$obj1", "value", $campo1);

	$objResponse->addAssign("$obj2", "value", $campo2);

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");

	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");

        return $objResponse->getXML();

}



function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;

	$res = mysql_query($sql, $conexion);

	if (mysql_num_rows($res) > 0) {

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





function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]	."')");

	

	return $objResponse->getXML();

}          





function CargaPeriodos($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("semestre","innerHTML",""); 		

	$anio = $_SESSION["sige_anio_escolar_vigente"];



	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$anio."'";

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

                $j=0;

            $objResponse->addCreate("semestre","option",""); 		

			$objResponse->addAssign("semestre","options[".$j."].value", '0');

			$objResponse->addAssign("semestre","options[".$j."].text", 'Elija'); 

			$j++;	

                while ($line = mysql_fetch_array($res)) {

			$objResponse->addCreate("semestre","option",""); 		

			$objResponse->addAssign("semestre","options[".$j."].value", $line[0]);

			$objResponse->addAssign("semestre","options[".$j."].text", $line[1]); 	

			$j++;

		}

	}

	

	return $objResponse->getXML();

}



function CargaMeses($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("mes","innerHTML",""); 		

	

	$sql = "select InicioPeriodo as inicio, TerminoPeriodo as termino 

			from Periodos 

			where AnoAcademico = '".$data['anio']."' and Semestre = '".$data['semestre']."' ";

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

        $j=0;

        while ($line = mysql_fetch_array($res)) {

			

			$fecha1		= 	$line[0];

			$fecha2		=	$line[1];

				

			$sql_meses = "SELECT TIMESTAMPDIFF(MONTH, '".$fecha1."', '".$fecha2	."') as meses";

			$res_meses = mysql_query($sql_meses,$conexion);

			$row_meses = mysql_fetch_array($res_meses);

			$dias_dif = $row_meses['meses']+1;

			list($anio_1,$mes_1,$dia_1) = explode('-',$fecha1);

			for($i=0;$i<=$dias_dif;$i++){

				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$data['anio']));

				$objResponse->addCreate("mes","option",""); 		

				$objResponse->addAssign("mes","options[".$i."].value", $mes_pos);

				$mes_ele="";

					switch($mes_pos){

						case '1' : $mes_ele = "Enero";

									break;

						case '2' : $mes_ele = "Febrero";

									break;

						case '3' : $mes_ele = "Marzo";

									break;

						case '4' : $mes_ele = "Abril";

									break;

						case '5' : $mes_ele = "Mayo";

									break;

						case '6' : $mes_ele = "Junio";

									break;

						case '7' : $mes_ele = "Julio";

									break;

						case '8' : $mes_ele = "Agosto";

									break;

						case '9' : $mes_ele = "Septiembre";

									break;

						case '10' : $mes_ele = "Octubre";

									break;

						case '11' : $mes_ele = "Noviembre";

									break;

						case '12' : $mes_ele = "Diciembre";

									break;

						default : break;

						}



				$objResponse->addAssign("mes","options[".$i."].text", $mes_ele); 	

				

				}



			

		}

	}

	

	return $objResponse->getXML();

}







$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CargaPeriodos");

$xajax->registerFunction("CargaMeses");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->display('sg_formato_control_asistencia.tpl');





ob_flush();

?>



