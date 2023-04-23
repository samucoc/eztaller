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



$xajax->setRequestURI("sg_alumnos_cobranza_pago_paso_2.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



    $anio = $_SESSION["sige_anio_escolar_vigente"];



define("ARCHIVO_LOG_PASO_2","log_alumnos_cobranza_pago_paso_2.log");

define("LOG_HABILITADO", true);



function sistemalog($mensaje){

	if (LOG_HABILITADO == true){

		file_put_contents(ARCHIVO_LOG_PASO_2, date("Y-m-d H:i:s")." - ".$mensaje.PHP_EOL, FILE_APPEND | LOCK_EX);

		}

	}



function Grabar($data){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$empresa 		= $data['empresa'];

	$fecha			= $data['OBLI-txtFecha'];

	$rut	 		= $data['rut_cliente'];

	$nro_factura	= $data['OBLIboleta'];

	$clase_factura	= $data['tipo_factura'];

	$neto	 		= $data['OBLItxtMontoIngresar'];

	$iva			= $data['iva'];

	$total	 		= $data['total'];

	

	list($dia3,$mes3,$anio3) = split('[/.-]', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;

	

	$sql = "select cier_fecha from cierres where empe_rut = '".$empresa."' order by cier_fecha desc limit 1";

	$res = mysql_query($sql, $conexion);

	

	$ult_cierre = @mysql_result($res,0,"cier_fecha");

	

	// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre

	$sql_dif =	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";

	$res_dif = mysql_query($sql_dif,$conexion);

	$dias_dif = @mysql_result($res_dif,0,"dias_dif");

	$ingresa = 'SI';

	if ($dias_dif <= 0){

		$ingresa = 'NO';

		$objResponse->addScript("alert('Fecha Incorrecta. Debe ser mayor a la fecha del ultimo cierre.')");

	}	

	$sql = "select * from boletas_honorarios where nro_boleta = ".$nro_factura;

	$res = mysql_query($sql,$conexion);

	if (mysql_num_rows($res)==0){

		if ($ingresa == 'SI'){

		$neto = str_replace(".", "", $neto);

		$sql = "insert into `boletas_honorarios` (`fecha`, `empresa`, `prestador`, `nro_boleta`, `neto`, `retencion`, `total`) values 

				('".$fecha."','".$empresa."','".$rut."','".$nro_factura."','".$neto."','".$iva."','".$total."')";

		$res = mysql_query($sql, $conexion);

		$objResponse->addScript("alert('Registro guardado correctamente')");

		$objResponse->addScript("document.Form1.submit();");

		}

	}

	else{

		$objResponse->addScript("alert('Boleta de Honorarios repetida')");

		}

    return $objResponse->getXML();

}





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

    global $miSmarty;

    $objResponse = new xajaxResponse('UTF8');

	

	$boleta = $data['boleta'];



	$sql = "select * from gescolcl_arcoiris_administracion.Movimientos_temp where NumeroBoleta = '".$boleta."'";

	$res = mysql_query($sql,$conexion);	       

	$arrRegistros = array();

	while($row = mysql_fetch_array($res)){

		if ($row['TipoPagoBoleta']==1){$tipo_pago = 'Efectivo';}

		if ($row['TipoPagoBoleta']==2){$tipo_pago = 'Cheque';}

		if ($row['TipoPagoBoleta']==3){$tipo_pago = 'Transferencia';}

		if ($row['TipoPagoBoleta']==4){$tipo_pago = 'Descuento por planilla';}

		if ($row['TipoPagoBoleta']==5){$tipo_pago = 'TransBank';}

		if ($row['TipoPagoBoleta']==6){$tipo_pago = 'Cheque al Dia';}

		array_push($arrRegistros, array('nro_boleta' => $row['NumeroBoleta'],

										'fecha' => $row['FechaBoleta'],

										'valor' => $row['ValorBoleta'],

										'tipo_pago' => $tipo_pago,

										'descripcion' => $row['DescripcionBoleta']

										));

		}

	//var_dump($arrRegistros);

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$_SESSION["alycar_matriz"] 			= 	$arrRegistros;

		

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_cobranza_pago_paso_2_list.tpl'));

	

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

	

        if ($tabla != 'personas'){

            $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";

        }

        else{

            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";

        }

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



function LlamaMantenedorVxC($data){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$empresa 		= $data['empresa'];

	$fecha			= $data['OBLI-txtFecha'];

	$cliente		= $data['OBLIcliente'];

	$rut	 		= $data['rut_cliente'];

	$nro_factura	= $data['OBLIboleta'];

	$neto	 		= $data['OBLItxtMontoIngresar'];

	$iva			= $data['iva'];

	$total	 		= $data['total'];

	

	$_SESSION["alycar_volver"]			=	'si';

	$_SESSION["alycar_pagina_volver"]	=   'sg_alumnos_cobranza_pago_paso_2.php';

	

    $objResponse->addScript("document.location.href='sg_mant_tablas.php?tbl=prestadores&empresa=".$empresa."&fecha=".$fecha."&cliente=".$cliente."&rut=".$rut."&nro_factura=".$nro_factura."&neto=".$neto."&iva=".$iva."&total=".$total."'");

	

	return $objResponse->getXML();

}



function CargaListado($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$alumno 			= 	$data["OBLIRutAlumno"];

	//$anio				=	date("Y");

    $anio = $_SESSION["sige_anio_escolar_vigente"];



	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");



	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'banco_cheque','gescolcl_arcoiris_administracion.Bancos','','','CodigoBanco','NombreBanco', '')");



	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,

								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado

					from gescolcl_arcoiris_administracion.Apoderados

					where NumeroRutApoderado in (select NumeroRutApoderado

													from gescolcl_arcoiris_administracion.alumnos".$anio.".

													where NumeroRutAlumno = '".$alumno."')";

	$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

	$row_apoderado = mysql_fetch_array($res_apoderado);

	

	$objResponse->addAssign("apoderado",'innerHTML',$row_apoderado['nombre']); 

			

	$sql_pd = "select 

				distinct

				Cursos.NombreCurso as NombreCurso,

				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,

				FechaNacimiento, DireccionParticularAlumno, TelefonoParticularAlumno, EMailAlumno,

				TipoBeca, BecaIncorporacion, BecaColegiatura

				from gescolcl_arcoiris_administracion.Cursos

					inner join gescolcl_arcoiris_administracion.alumnos".$anio.".

						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

				where

					alumnos".$anio.".NumeroRutAlumno = '".$alumno."'"; 

	$res_pd = mysql_query($sql_pd,$conexion) or die(mysql_error());

	while ($row_pd = mysql_fetch_array($res_pd)){

			$objResponse->addAssign("alumno",'innerHTML',$row_pd['nombre_alumno']); 

			$objResponse->addAssign("curso" ,'innerHTML', $row_pd['NombreCurso']);

		}

	

	$sql_fp = "select FechaVencimiento 

				from gescolcl_arcoiris_administracion.CuentaCorriente

				where NumeroRutAlumno = '".$alumno."' and ValorPactado > ValorPagado

				order by ctacte_ncorr asc

				limit 0,1";

	$res_fp = mysql_query($sql_fp,$conexion) or die(mysql_error());

	$row_fp = mysql_fetch_array($res_fp);

	$objResponse->addAssign("fecha_pago" ,'value', date("d/m/Y"));

	

	$sql_numero_boleta = "select max(NumeroBoleta) as boleta

							from gescolcl_arcoiris_administracion.Movimientos 

							where PeriodoMovimiento = '".$anio."'";

	$res_numero_boleta = mysql_query($sql_numero_boleta,$conexion) or die(mysql_error());

	$row_numero_boleta = mysql_fetch_array($res_numero_boleta);

	

	$numero_boleta = $row_numero_boleta['boleta']+1;

	

	$sql_numero_boleta = "select DesdeTimbrado

							from gescolcl_arcoiris_administracion.Talonarios 

							where (DesdeTimbrado) >= ".$numero_boleta." or 

									(HastaTimbrado) <= ".$numero_boleta."";

	$res_numero_boleta = mysql_query($sql_numero_boleta,$conexion) or die(mysql_error());

	if (mysql_num_rows($res_numero_boleta)>0){

		$objResponse->addAssign("nro_boleta" ,'value', $numero_boleta);

		}

	else{

		$objResponse->addAlert("Nro de boleta no autorizada.");

		$objResponse->addScript("window.parent.hidePopWin(true)");

		$objResponse->addScript("window.parent.document.Form1.submit();");

			

		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

		}

	return $objResponse->getXML();

}



function Eliminar($data,$ncorr){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$sql_ve = "delete from gescolcl_arcoiris_administracion.CuentaCorriente

				where

				ctacte_ncorr = '".$ncorr."'";

	

	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());

	

	$objResponse->addAlert("Registro Eliminado");

	

	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");

	

	return $objResponse->getXML();

	}



function EfectuarPago($data){

	global $conexion;

    $objResponse = new xajaxResponse('UTF8');



	$boleta 		= 	$data['boleta'];

    $anio = $_SESSION["sige_anio_escolar_vigente"];



	$sql = "SET AUTOCOMMIT=0";

	$res = mysql_query($sql,$conexion);



	$sql = "START TRANSACTION;";

	$res = mysql_query($sql,$conexion);



	sistemalog('Inicio Transaccion');

	

	$sql = "insert into gescolcl_arcoiris_administracion.Movimientos( `NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, `ValorBoleta`, 

													`EstadoBoleta`, `TipoPagoBoleta`, `DescripcionBoleta`, `CodigoUsuario`, 

													`PeriodoMovimiento`)

			select  `NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, `ValorBoleta`, 

					`EstadoBoleta`, `TipoPagoBoleta`, `DescripcionBoleta`, `CodigoUsuario`, 

					`PeriodoMovimiento` 

			from gescolcl_arcoiris_administracion.Movimientos_temp where NumeroBoleta = '".$boleta."'";

	$res = mysql_query($sql,$conexion);	       

	sistemalog($sql);

	



	$sql = "select * from gescolcl_arcoiris_administracion.Movimientos_temp where NumeroBoleta = '".$boleta."'";

	$res = mysql_query($sql,$conexion);	       

	$arrRegistros = array();

	while($row = mysql_fetch_array($res)){

		if ($row['TipoPagoBoleta']==1){$tipo_pago = 'Efectivo';}

		else {$tipo_pago="Cheque";}

		$arr_cuotas = explode(" ",$row['DescripcionBoleta']);

		$nro_cuota = $arr_cuotas[3];

		if ($nro_cuota=='0') {

			$codigo_item = 1;

			$nro_cuota= 1;

			}

		else $codigo_item = 2;

		$alumno = $row['NumeroRutAlumno'];

		$monto = $row['ValorBoleta'];

		

		$anio_vigente = $_SESSION["sige_anio_escolar_vigente"];



		$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio_vigente."

												set  `ValorPagado` = ValorPagado + '".$monto."'

												where NumeroRutAlumno = '".$alumno."' and

														NumeroCuota = '".$nro_cuota."' and

														CodigoItem = '".$codigo_item."' ";

		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());

		sistemalog($sql_update);

		}



	$sql = "delete from gescolcl_arcoiris_administracion.Movimientos_temp where NumeroBoleta = '".$boleta."'";

	$res = mysql_query($sql,$conexion);	       

	sistemalog($sql);

	

	sistemalog("Pago Registrado.");

	

	$sql = "COMMIT;";

	//$sql = "ROLLBACK;";

	$res = mysql_query($sql,$conexion);



	sistemalog("Termino Transaccion");

	$objResponse->addAlert("Transaccion Terminada");

	//$objResponse->addScript("window.parent.hidePopWin(true)");

	//$objResponse->addScript("window.parent.document.Form1.submit();");

	$objResponse->addScript("location.href='pdf_boleta_efectivo.php?boleta=".$boleta."'");



	//$objResponse->addScript("location.href='sg_alumnos_cobranza_pago_paso_2.php?numero_boleta=".$numero_boleta."'");

	/*	`NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`, `TipoPagoBoleta`, 

	 * `DescripcionBoleta`, `CodigoUsuario`, `PeriodoMovimiento`

	 */

	return $objResponse->getXML();

	}



$xajax->registerFunction("CargaListado");

$xajax->registerFunction("LlamaMantenedorVxC");

$xajax->registerFunction("Eliminar");

$xajax->registerFunction("Grabar");

$xajax->registerFunction("Pagar");

$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("EfectuarPago");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('boleta', $_GET['numero_boleta']);



$miSmarty->display('sg_alumnos_cobranza_pago_paso_2.tpl');



ob_flush();

?>



