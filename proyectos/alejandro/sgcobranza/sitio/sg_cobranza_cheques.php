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



$xajax->setRequestURI("sg_cobranza_cheques.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	

	$alumno = $data['nro_cheque'];

	

	$arrRegistros = array();



	list($dia,$mes,$anio) = explode('/',$fecha_buscar);

	$fecha_hoy = $anio.'-'.$mes.'-'.$dia;



	$and = "";



	if (($data['cboBanco']!='Todos')){

		$and .= ' Cheques.CodigoBanco = '.$data['cboBanco'].' and ';

		}



	if (($data['txtFecha1']!='')&&($data['txtFecha2']!='')){

		

		list($dia,$mes,$anio) = explode('/',$data['txtFecha1']);

		$fecha_inicio = $anio.'-'.$mes.'-'.$dia;

		list($dia,$mes,$anio) = explode('/',$data['txtFecha2']);

		$fecha_fin = $anio.'-'.$mes.'-'.$dia;



		$and .= " Cheques.FechaCheque between '".$fecha_inicio."' and  '".$fecha_fin."' and ";

		}



	if (($data['txtNroCheque']!='')){

		$and .= ' Cheques.NumeroCheque = '.$data['txtNroCheque'].' and ';

		}

	$anio = $_SESSION["sige_anio_escolar_vigente"];

   

	$sql_boletas = "select distinct `NumeroCheque`, `NombreBanco`, `ValorCheque`,FechaCheque, `EstadoCheque`, Cheques.NumeroBoleta, cheque_ncorr, PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso, PaternoApoderado, MaternoApoderado, NombresApoderado  

			from gescolcl_arcoiris_administracion.Cheques  	

				inner join gescolcl_arcoiris_administracion.Bancos 		

					on Cheques.CodigoBanco = Bancos.CodigoBanco 	

				inner join gescolcl_arcoiris_administracion.Movimientos_Cheques   		

					on Cheques.NumeroBoleta = Movimientos_Cheques.NumeroBoleta  	

				inner join gescolcl_arcoiris_administracion.alumnos".$anio."   	

					on Movimientos_Cheques.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno 	 

				inner join gescolcl_arcoiris_administracion.Cursos   	

					on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso 	 

				inner join gescolcl_arcoiris_administracion.Apoderados   	

					on Apoderados.NumeroRutApoderado = alumnos".$anio.".NumeroRutApoderado 

				where $and 1  

			";

	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

	if (mysql_num_rows($res_boletas)>0){

		while($row_boletas = mysql_fetch_array($res_boletas)){

			

			list($anio,$mes,$dia) = explode('-',$row_boletas['FechaCheque']);

			$fecha = $dia.'-'.$mes.'-'.$anio;



			array_push($arrRegistros, array("item"					=>	"-",

											"NumeroCheque"		=>	$row_boletas['NumeroCheque'],

											"NombreBanco"		=>	$row_boletas['NombreBanco'],

											"ValorCheque"		=>	$row_boletas['ValorCheque'],

											"FechaCheque"		=>	$fecha,

											"EstadoCheque"		=>	$row_boletas['EstadoCheque'],

											"NumeroBoleta"		=>	$row_boletas['NumeroBoleta'],

											"cheque_ncorr"		=>	$row_boletas['cheque_ncorr'],

											"alumno"			=>	$row_boletas['PaternoAlumno'].' '.$row_boletas['MaternoAlumno'].' '.$row_boletas['NombresAlumno'],

											"apoderado"			=>	$row_boletas['PaternoApoderado'].' '.$row_boletas['MaternoApoderado'].' '.$row_boletas['NombresApoderado'],

											"curso"			=>	$row_boletas['NombreCurso']

											));

			$i++;

			

			}

			

		$miSmarty->assign('arrRegistros', $arrRegistros);



		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cobranza_cheques_list.tpl'));

		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");



		}

	else{

		$objResponse->addAlert("Cheques no encontrados");

		}

	return $objResponse->getXML();

}          



function VerDetalle($data,$rut_alumno){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("showPopWin('sg_cobranza_cheques_detalle.php?cheque_ncorr=$rut_alumno', 'Detalle Cheque', 700, 480, null);");





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



	$fecha_hoy = date('d/m/Y');

	$fecha_30 = date('d/m/Y',mktime(0,0,0,date('m'),date('d')+30,date('Y')));



	$objResponse->addAssign('txtFecha1','value',$fecha_hoy);

	$objResponse->addAssign('txtFecha2','value',$fecha_30);

	

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



function PagarMov($data,$boleta_temp){

	global $conexion;

    $objResponse = new xajaxResponse('UTF8');



	$boleta = $data['cheque_'.$boleta_temp];



	$objResponse->addScript("showPopWin('sg_alumnos_cobranza_pago_cheque_paso_2.php?boleta_temp=".$boleta_temp."&boleta=".$boleta."', 'Detalle Pago Movimiento Cheque', 700, 280, null);");

	return $objResponse->getXML();

	}



function PagarMov_1($data,$boleta_temp){

	global $conexion;

    $objResponse = new xajaxResponse('UTF8');



    $boleta = $data['cheque_'.$boleta_temp];



	$sql = "select * from gescolcl_arcoiris_administracion.Movimientos_Cheques where NumeroBoleta = '".$boleta_temp."' and ValorBoleta > 0";

	$res = mysql_query($sql,$conexion);	       

	$arrRegistros = array();

	while($row = mysql_fetch_array($res)){

		if ($row['TipoPagoBoleta']==1){$tipo_pago = 'Efectivo';}

		else {$tipo_pago="Cheque";}

		$arr_cuotas = explode(" ",$row['DescripcionBoleta']);

		$nro_cuota = $arr_cuotas[3];

		if ($arr_cuotas[2]=='Incorporacion')$codigo_item = 1;

		else $codigo_item = 2;

		$alumno = $row['NumeroRutAlumno'];

		$monto = $row['ValorBoleta'];

		$forma_pago = $row['TipoPagoBoleta'];

		$anio = $row['PeriodoMovimiento'];

		$FechaBoleta = $row['FechaBoleta'];



		$insert_mov = "INSERT INTO gescolcl_arcoiris_administracion.Movimientos(`NumeroBoleta`, `FechaBoleta`, 

		 													`NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`,

		 													`TipoPagoBoleta`, `DescripcionBoleta`, `CodigoUsuario`,

		 													`PeriodoMovimiento`) 

		 				VALUES ('".$boleta."','".$FechaBoleta."','".$alumno."','".$monto."','1',

		 						'".$forma_pago."','".$row['DescripcionBoleta']."','admin','".$anio."')"; 

		$res_mov = mysql_query($insert_mov,$conexion) or die(mysql_error());



		$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente

											set  `ValorPagado` = ValorPagado + '".$monto."'

													where NumeroRutAlumno = '".$alumno."' and

														NumeroCuota = '".$nro_cuota."' and

														CodigoItem = '".$codigo_item."' ";

		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());



		$sql_update = "update gescolcl_arcoiris_administracion.Movimientos_Cheques

												set  `PagadoMovimiento` = 1

												where mov_ncorr = '".$row['mov_ncorr']."' ";

		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());



		$sql_update = "update gescolcl_arcoiris_administracion.Cheques

						set  `EstadoCheque` = 1, 

							`NumeroBoleta` = '".$boleta."'

						where NumeroBoleta = '".$boleta_temp."' ";

		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());



		}



	$objResponse->addAlert("Transaccion Terminada");

	$objResponse->addScript("window.document.Form1.submit();");

	//$objResponse->addScript("location.href='sg_alumnos_cobranza_pago_paso_2.php?numero_boleta=".$numero_boleta."'");

	/*	`NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`, `TipoPagoBoleta`, 

	 * `DescripcionBoleta`, `CodigoUsuario`, `PeriodoMovimiento`

	 */

	return $objResponse->getXML();



	}



$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaListado");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("VerDetalle");

$xajax->registerFunction("Imprime");

$xajax->registerFunction("PagarMov");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('rut_alumno', $_GET['rut_alumno']);



$miSmarty->display('sg_cobranza_cheques.tpl');





ob_flush();

?>



