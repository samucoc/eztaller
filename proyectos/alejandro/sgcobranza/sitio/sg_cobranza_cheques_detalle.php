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



$xajax->setRequestURI("sg_cobranza_cheques_detalle.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Actualizar($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');



	list($dia,$mes,$anio) = explode('-',$data['FechaCheque']);

	$fecha_inicio = $anio.'-'.$mes.'-'.$dia;

		



	$sql_update = "update gescolcl_arcoiris_administracion.Cheques 

					set NumeroCheque = '".$data['NumeroCheque']."', 

						CodigoBanco = '".$data['CodigoBanco']."', 

						ValorCheque = '".$data['ValorCheque']."', 

						FechaCheque = '".$fecha_inicio."', 

						EstadoCheque = '".$data['EstadoCheque']."'

					where cheque_ncorr = '".$data['cheque_ncorr']."'";

	$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());

	$objResponse->addAlert("Cheques guardado");



	$objResponse->addScript("window.parent.hidePopWin(true)");	

	$objResponse->addScript("window.parent.xajax_Grabar(window.parent.xajax.getFormValues('Form1'))");



	return $objResponse->getXML();

	}          



function Grabar($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	

	$cheque_ncorr = $data['cheque_ncorr'];

    $anio = $_SESSION["sige_anio_escolar_vigente"];

   



	$sql_boletas = "select *

					from gescolcl_arcoiris_administracion.Cheques

					where cheque_ncorr = '".$cheque_ncorr."'";

	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

	if (mysql_num_rows($res_boletas)>0){

		while($row_boletas = mysql_fetch_array($res_boletas)){

			$sql_banco = "select NombreBanco from gescolcl_arcoiris_administracion.Bancos where ".$row_boletas['CodigoBanco'];

			$res_banco = mysql_query($sql_banco,$conexion) or die(mysql_error());

			$row_banco = mysql_fetch_array($res_banco);



			$banco = $row_banco['NombreBanco'];



			$sql_alumno ="select PaternoAlumno, MaternoAlumno, NombresAlumno	

							from gescolcl_arcoiris_administracion.alumnos".$anio."

								inner join gescolcl_arcoiris_administracion.Movimientos_Cheques

								 on Movimientos_Cheques.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno 

							where NumeroBoleta = ".$row_boletas['NumeroBoleta'];

			$res_alumno = mysql_query($sql_alumno,$conexion) or die(mysql_error());

			$row_alumno = mysql_fetch_array($res_alumno);



			if($row_boletas['EstadoCheque']=='0'){

				$estado = 'No Cobrado';

				}

			else if($row_boletas['EstadoCheque']=='1'){

				$estado = 'Cobrado';

				}

			else{

				$estado = 'Anulado';

				}

			list($anio,$mes,$dia) = explode('-',$row_boletas['FechaCheque']);

			$fecha = $dia.'-'.$mes.'-'.$anio;

			

			$objResponse->addAssign('alumno','value',$row_alumno['PaternoAlumno'].' '.$row_alumno['MaternoAlumno'].' '.$row_alumno['NombresAlumno']);

			$objResponse->addAssign('NumeroCheque','value',$row_boletas['NumeroCheque']);

			$objResponse->addAssign('NombreBanco','value',$banco);

			$objResponse->addAssign('CodigoBanco','value',$row_boletas['CodigoBanco']);

			$objResponse->addAssign('ValorCheque','value',$row_boletas['ValorCheque']);

			$objResponse->addAssign('FechaCheque','value',$fecha);

			$objResponse->addAssign('EstadoCheque','value',$estado);

			$objResponse->addAssign('NumeroBoleta','value',$row_boletas['NumeroBoleta']);

			

			$sql_boletas = "select DATE_FORMAT(FechaBoleta,'%d/%m/%Y') as FechaBoleta, `DescripcionBoleta`, ValorBoleta

							from gescolcl_arcoiris_administracion.Movimientos_Cheques

							where NumeroBoleta = '".$row_boletas['NumeroBoleta']."' and ValorBoleta > 0";

			$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

			$tbl .= '<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">';

			while($row_boletas_1 = mysql_fetch_array($res_boletas)){

				$tbl .= '<tr>';

				$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas_1['FechaBoleta'].'</td>';

				$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas_1['DescripcionBoleta'].'</td>';

				$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas_1['ValorBoleta'].'</td>';

				$tbl .= '</tr>';

				}

			$tbl .= '</table>';

			$objResponse->addAssign("divabonos", "innerHTML", $tbl);



			}

		

		}

	else{

		$objResponse->addAlert("Cheques no encontrados");

		}

	return $objResponse->getXML();

}          



function VerDetalle($data,$rut_alumno){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("showPopWin('sg_cobranza_cheques_detalle_detalle.php?cheque_ncorr=$rut_alumno', 'Detalle Cheque', 700, 280, null);");





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

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboBanco','gescolcl_arcoiris_administracion.Bancos','','Todos','CodigoBanco','NombreBanco', '')");

	

	//$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");

	

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

$xajax->registerFunction("Actualizar");

$xajax->registerFunction("CargaListado");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("VerDetalle");

$xajax->registerFunction("Imprime");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('cheque_ncorr', $_GET['cheque_ncorr']);



$miSmarty->display('sg_cobranza_cheques_detalle.tpl');





ob_flush();

?>



