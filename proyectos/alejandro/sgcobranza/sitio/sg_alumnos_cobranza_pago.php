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

$xajax->setRequestURI("sg_alumnos_cobranza_pago.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

$anio = $_SESSION["sige_anio_escolar_vigente"];

define("ARCHIVO_LOG","log_alumnos_cobranza_pago.log");
define("LOG_HABILITADO", true);

function sistemalog($mensaje){
	if (LOG_HABILITADO == true){
		file_put_contents(ARCHIVO_LOG, date("Y-m-d H:i:s")." - ".$mensaje.PHP_EOL, FILE_APPEND | LOCK_EX);
		}
	}
function remover ($valor,$arr){
    foreach (array_keys($arr, $valor) as $key) {
        unset($arr[$key]);
    }
    return $arr;
}

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
    $anio = $_SESSION["sige_anio_escolar_vigente"];
	
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
    $objResponse = new xajaxResponse('UTF8');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'empresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	       
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
	$_SESSION["alycar_pagina_volver"]	=   'sg_alumnos_cobranza_pago.php';
	
    $objResponse->addScript("document.location.href='sg_mant_tablas.php?tbl=prestadores&empresa=".$empresa."&fecha=".$fecha."&cliente=".$cliente."&rut=".$rut."&nro_factura=".$nro_factura."&neto=".$neto."&iva=".$iva."&total=".$total."'");
	
	return $objResponse->getXML();
}

function BuscaBoleta($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');

    $nro_boleta = $data['nro_boleta'];

	$sql_numero_boleta = "select NumeroBoleta as boleta
							from gescolcl_arcoiris_administracion.Movimientos
							where NumeroBoleta = '".$nro_boleta."'";
	$res_numero_boleta = mysql_query($sql_numero_boleta,$conexion) or die(mysql_error());
	
	if (mysql_num_rows($res_numero_boleta)>0)	{
		$objResponse->addAlert("Boleta ya existe.");
		}
	else{
		$sql_1 = "select talo_ncorr
					from gescolcl_arcoiris_administracion.Talonarios
					where DesdeTimbrado <= '".$nro_boleta."' and 
							HastaTimbrado >= '".$nro_boleta."' and
							'".$nro_boleta."' between DesdeTimbrado and HastaTimbrado
					";
		$res_1 = mysql_query($sql_1,$conexion);
		if (mysql_num_rows($res_1)>0){
			
			}
		else{
			$objResponse->addAlert("Nro Boleta fuera del rango.");
			}
		}

	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$alumno 			= 	$data["OBLIRutAlumno"];
	$anio				=	$_SESSION['sige_anio_escolar_vigente'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'banco_cheque','gescolcl_arcoiris_administracion.Bancos','','','CodigoBanco','NombreBanco', '')");

	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,
								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado
					from gescolcl_arcoiris_administracion.Apoderados
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_arcoiris_administracion.alumnos".$anio."
													where NumeroRutAlumno = '".$alumno."')";
	$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());
	$row_apoderado = mysql_fetch_array($res_apoderado);
	
	$objResponse->addAssign("apoderado",'innerHTML',$row_apoderado['nombre']); 
			
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso as NombreCurso,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				FechaNacimiento, DireccionParticularAlumno, TelefonoParticularAlumno, EMailAlumno,
				TipoBeca, BecaColegiatura, BecaColegiatura
				from gescolcl_arcoiris_administracion.Cursos
					inner join gescolcl_arcoiris_administracion.alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio.".NumeroRutAlumno = '".$alumno."'"; 
	$res_pd = mysql_query($sql_pd,$conexion) or die(mysql_error());
	while ($row_pd = mysql_fetch_array($res_pd)){
			$objResponse->addAssign("alumno",'innerHTML',$row_pd['nombre_alumno']); 
			$objResponse->addAssign("curso" ,'innerHTML', $row_pd['NombreCurso']);
		}
	
	$sql_fp = "select FechaVencimiento 
				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
				where NumeroRutAlumno = '".$alumno."' and ValorPactado > ValorPagado
				order by ctacte_ncorr asc
				limit 0,1";
	$res_fp = mysql_query($sql_fp,$conexion) or die(mysql_error());
	$row_fp = mysql_fetch_array($res_fp);
	$objResponse->addAssign("fecha_pago" ,'value', date("d/m/Y"));
	
	$sql_numero_boleta = "select max(NumeroBoleta) as boleta
							from gescolcl_arcoiris_administracion.Movimientos";
	$res_numero_boleta = mysql_query($sql_numero_boleta,$conexion) or die(mysql_error());
	$row_numero_boleta = mysql_fetch_array($res_numero_boleta);
	
	//$numero_boleta = $row_numero_boleta['boleta']+1;
	$objResponse->addAssign("nro_boleta" ,'value', '');
	// 	}
	
	// $sql_numero_boleta = "select DesdeTimbrado
	// 						from gescolcl_arcoiris_administracion.Talonarios 
	// 						where (DesdeTimbrado) >= ".$numero_boleta." or 
	// 								(HastaTimbrado) <= ".$numero_boleta."";
	// $res_numero_boleta = mysql_query($sql_numero_boleta,$conexion) or die(mysql_error());
	// if (mysql_num_rows($res_numero_boleta)>0){
	// 	$objResponse->addAssign("nro_boleta" ,'value', $numero_boleta);
	// 	}
	// else{
	// 	$objResponse->addAlert("Nro de boleta no autorizada.");
	// 	$objResponse->addScript("window.parent.hidePopWin(true)");
	// 	$objResponse->addScript("window.parent.document.Form1.submit();");
			
	// 	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	// 	}

	return $objResponse->getXML();
}

function Eliminar($data,$ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$anio				=	$_SESSION['sige_anio_escolar_vigente'];
	
	$sql_ve = "delete from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
				where
				ctacte_ncorr = '".$ncorr."'";
	
	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());
	
	$objResponse->addAlert("Registro Eliminado");
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");
	
	return $objResponse->getXML();
	}

function Pagar($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');

    $anio = $_SESSION["sige_anio_escolar_vigente"];
	$alumno 			= 	$data["OBLIRutAlumno"];
	$anio				=	$_SESSION['sige_anio_escolar_vigente'];
	$numero_boleta 		= 	$data['nro_boleta'];
	$forma_pago			= 	$data['forma_pago'];

	$sql = "delete from gescolcl_arcoiris_administracion.Movimientos_temp ";
	$res = mysql_query($sql,$conexion);	       
	
	$sql_numero_boleta = "select NumeroBoleta as boleta
							from gescolcl_arcoiris_administracion.Movimientos
							where NumeroBoleta = '".$numero_boleta."'";
	$res_numero_boleta = mysql_query($sql_numero_boleta,$conexion) or die(mysql_error());
	
	if (mysql_num_rows($res_numero_boleta)>0)	{
		$objResponse->addAlert("Boleta ya existe.");
		}
	else{

		$sql = "SET AUTOCOMMIT=0";
		$res = mysql_query($sql,$conexion);

		$sql = "START TRANSACTION;";
		$res = mysql_query($sql,$conexion);

		sistemalog('Inicio Transaccion');
		$sql_cuota = "select `NumeroCuota`, CodigoItem, `ValorPactado`, ValorPagado, ctacte_ncorr
					  from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
						where NumeroRutAlumno = '".$alumno."' and ValorPactado > ValorPagado
						order by CodigoItem asc, ctacte_ncorr asc
						limit 0,1";
		$res_cuota = mysql_query($sql_cuota,$conexion) or die(mysql_error());
		$row_cuota = mysql_fetch_array($res_cuota);
		sistemalog($sql_cuota);

		$nro_cuota = $row_cuota['NumeroCuota'];
		$codigo_item = $row_cuota['CodigoItem'];
		$valor_pactado = $row_cuota['ValorPactado'];
		$valor_pagado = $row_cuota['ValorPagado'];
		$ctacte_ncorr = $row_cuota['ctacte_ncorr'];

		$monto = $data['valor_pagar'];
		$forma_pago = $data['forma_pago'];
		$detalle="";
		$nombre="";
		$monto_pagado = 0;
		$arr_monto = array();
		$resto = 0;
		$q = 0;
		
		sistemalog($nro_cuota.'-'.$codigo_item.'-'.$valor_pactado.'-'.$valor_pagado.'-'.$ctacte_ncorr.'-'.$monto.'-'.$forma_pago);
		
		if ($monto>=$valor_pactado){
			sistemalog('valor_pagado : '.$valor_pagado);
			if ($valor_pagado==0){
				$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
								set  `ValorPagado` = ValorPagado + '".$valor_pactado."'
								where ctacte_ncorr = '".$ctacte_ncorr."' ";
				//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
				sistemalog($sql_update);
				
				if ($codigo_item=='1'){
					$nombre='Colegiatura';
					$detalle .= ' ; Pago '.$nombre.' 0';
					sistemalog($detalle);
					}
				else{
					$nombre='Colegiatura';
					$detalle .= ' ; Pago '.$nombre.' '.$nro_cuota;
					sistemalog($detalle);
					}
				
				$monto = $monto - $valor_pactado;
				$monto_pagado += $valor_pactado;
				
				sistemalog($valor_pactado.'-'.$valor_pagado);
				$valor_pagado>0? $arr_monto[$q] = $valor_pagado : $arr_monto[$q] = $valor_pactado;
				
				$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
							 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
							 where ctacte_ncorr = '".$ctacte_ncorr."' ";
				$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
				while($row_diff = mysql_fetch_array($res_diff)){
					sistemalog('resto : '.$row_diff['resto']);
					if ($row_diff['resto']==0){

						}
					elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
						$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
						$monto = $monto + $resto;
						$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										set  `ValorPagado` = ValorPagado
										where ctacte_ncorr = '".$ctacte_ncorr."' ";
						//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
						sistemalog($sql_update);
						}
					}
				sistemalog($monto.'-'.$monto_pagado.'-'.$arr_monto[$q]);
				$q++;
				}
			else{
				$diff = $valor_pactado - $valor_pagado;
				$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
								set  `ValorPagado` = ValorPagado + '".$diff."'
								where ctacte_ncorr = '".$ctacte_ncorr."' ";
				//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
				sistemalog($sql_update);
				sistemalog($valor_pactado.'-'.$valor_pagado);
				$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
							 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
							 where ctacte_ncorr = '".$ctacte_ncorr."' ";
				$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
				while($row_diff = mysql_fetch_array($res_diff)){
					sistemalog('resto : '.$row_diff['resto']);
					if ($row_diff['resto']==0){

						}
					elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
						$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
						$monto = $monto + $resto;
						$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										set  `ValorPagado` = ValorPagado
										where ctacte_ncorr = '".$ctacte_ncorr."' ";
						//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
						sistemalog($sql_update);
						}
					}
				if ($codigo_item=='1'){
					$nombre='Colegiatura';
					$detalle .= ' ; Pago '.$nombre.' 0';
					sistemalog(' ; Pago '.$nombre.' 0');
					}
				else{
					$nombre='Colegiatura';
					$detalle .= ' ; Pago '.$nombre.' '.$nro_cuota;
					sistemalog(' ; Pago '.$nombre.' '.$nro_cuota);
					}
				
				$monto = $monto - $diff;
				$monto_pagado += $diff;
				$diff>0? $arr_monto[$q] = $diff : $arr_monto[$q] = $monto;
				sistemalog($monto.'-'.$monto_pagado.'-'.$diff);
				$q++;
				}
			
			sistemalog('Ingreso Cuotas');
			$sql_nro_cuotas = "select max(NumeroCuota) as max, count(NumeroCuota) as cant , ValorPactado , ValorPagado
								from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
								where NumeroRutAlumno = '".$alumno."' and 
								NumeroCuota > '".$nro_cuota."' and
								CodigoItem = '".$codigo_item."' and 
								ctacte_ncorr >= '".$ctacte_ncorr."'";
			$res_nro_cuenta = mysql_query($sql_nro_cuotas,$conexion) or die(mysql_error());
			$row_nro_cuenta = mysql_fetch_array($res_nro_cuenta);
			$max = $row_nro_cuenta['max'];
			$cant = $row_nro_cuenta['cant'];
			$valor_pactado = $row_nro_cuenta['ValorPactado'];
			$valor_pagado = $row_nro_cuenta['ValorPagado'];
			sistemalog($max.'-'.$cant.'-'.$valor_pactado);
			sistemalog($sql_nro_cuotas);
						
			if ($codigo_item=='1'){
				if ($cant>0){
					$i = ($max - $cant)+1;
					sistemalog($i."<=".$max." && ".$monto.">=".$valor_pactado);
				
					while (($i<=$max)&&($monto>=$valor_pactado)){
						$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										set  `ValorPagado` = '".$valor_pactado."'
										where 
											NumeroRutAlumno = '".$alumno."' and
											NumeroCuota = '".$i."' and
											CodigoItem = '".$codigo_item."' and 
											ctacte_ncorr > '".$ctacte_ncorr."' ";
						//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
						sistemalog($sql_update.' - Paso 1');
				
						$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
									 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
									 where NumeroRutAlumno = '".$alumno."' and
											NumeroCuota = '".$i."' and
											CodigoItem = '".$codigo_item."' and 
											ctacte_ncorr > '".$ctacte_ncorr."' ";
						$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
						while($row_diff = mysql_fetch_array($res_diff)){
							if ($row_diff['resto']==0){

								}
							elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
								$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
								$monto = $monto + $resto;
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												set  `ValorPagado` = ValorPagado
												where NumeroRutAlumno = '".$alumno."' and
														NumeroCuota = '".$i."' and
														CodigoItem = '".$codigo_item."' and 
														ctacte_ncorr > '".$ctacte_ncorr."' ";
								//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								sistemalog($sql_update.' - Paso 1 . 1');
								}
							}

						if ($codigo_item=='1'){
							$nombre='Colegiatura';
							}
						else{
							$nombre='Colegiatura';
							}
						$detalle .= ' ; Pago '.$nombre.' 0';	
						sistemalog(' ; Pago '.$nombre.' 0');
						$monto = $monto - $valor_pactado;
					   	$monto_pagado += $valor_pactado;
						$arr_monto[$q] = $valor_pactado - $valor_pagado;
						$q++;
						$i++;
						$nro_cuota = '0';
						}
					}
				else{
					$codigo_item='2';
					$nro_cuota='1';
					$sql_nro_cuotas = "select max(NumeroCuota) as max, count(NumeroCuota) as cant , ValorPactado, ValorPagado
										from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										where NumeroRutAlumno = '".$alumno."' and 
										NumeroCuota >= '".$nro_cuota."' and
										CodigoItem = '".$codigo_item."' and 
										ctacte_ncorr >= '".$ctacte_ncorr."'";
					$res_nro_cuenta = mysql_query($sql_nro_cuotas,$conexion) or die(mysql_error());
					$row_nro_cuenta = mysql_fetch_array($res_nro_cuenta);
					$max = $row_nro_cuenta['max'];
					$cant = $row_nro_cuenta['cant'];
					$valor_pactado = $row_nro_cuenta['ValorPactado'];
					$valor_pagado = $row_nro_cuenta['ValorPagado'];
					sistemalog($max.'-'.$cant.'-'.$valor_pactado.'-'.$valor_pagado);
					sistemalog($sql_nro_cuotas);
					}
				}
			if ($codigo_item=='2'){
				if ($cant>0){
					$i = ($max - $cant)+1;
					sistemalog($i."<=".$max." && ".$monto.">=".$valor_pactado);
					if (($monto<$valor_pactado)&&($nro_cuota<11)){
						sistemalog($max."-".$i."+1");
						$nro_cuota = $i;
						if (($monto>0)&&($nro_cuota<11)){
							$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											set  `ValorPagado` = ValorPagado + '".$monto."'
											where NumeroRutAlumno = '".$alumno."' and
											NumeroCuota = '".$nro_cuota."' and
											CodigoItem = '".$codigo_item."'  and 
											ctacte_ncorr > '".$ctacte_ncorr."' ";
							//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
							sistemalog($sql_update.' - Paso 3');
							$detalle .= ' ; Abono '.$nombre.' '.$nro_cuota;
							sistemalog(' ; Abono '.$nombre.' '.$nro_cuota);
							$monto_pagado += $monto;
							$arr_monto[$q] = $monto;
							sistemalog($arr_monto[$q]);
							$q++;
							
							$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
										 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										 where NumeroRutAlumno = '".$alumno."' and
												NumeroCuota = '".$i."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr > '".$ctacte_ncorr."' ";
							$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
							while($row_diff = mysql_fetch_array($res_diff)){
								if ($row_diff['resto']==0){

									}
								elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
									$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
									$monto = $monto + $resto;
									$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
													set  `ValorPagado` = ValorPagado
													where NumeroRutAlumno = '".$alumno."' and
															NumeroCuota = '".$i."' and
															CodigoItem = '".$codigo_item."' and 
															ctacte_ncorr > '".$ctacte_ncorr."' ";
									//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
									sistemalog($sql_update.' - Paso 3.1');
									}
								}
							if ($codigo_item=='1'){
								$nombre='Colegiatura';
								}
							else{
								$nombre='Colegiatura';
								}
							$monto = $monto - $monto;
							}
						}
					}
					else{
						$nro_cuota = $i+1;
						while (($i<=$max)&&($monto>=$valor_pactado)){
							$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											set  `ValorPagado` = '".$valor_pactado."'
											where 
												NumeroRutAlumno = '".$alumno."' and
												NumeroCuota = '".$i."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr > '".$ctacte_ncorr."' ";
							//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
							sistemalog($sql_update.' - Paso 2');

							$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
										 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										 where NumeroRutAlumno = '".$alumno."' and
												NumeroCuota = '".$i."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr > '".$ctacte_ncorr."' ";
							$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
							while($row_diff = mysql_fetch_array($res_diff)){
								if ($row_diff['resto']==0){

									}
								elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
									$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
									$monto = $monto + $resto;
									$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
													set  `ValorPagado` = ValorPagado
													where NumeroRutAlumno = '".$alumno."' and
															NumeroCuota = '".$i."' and
															CodigoItem = '".$codigo_item."' and 
															ctacte_ncorr > '".$ctacte_ncorr."' ";
									//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
									sistemalog($sql_update.' - Paso 2.1');
									}
								}
							if ($codigo_item=='1'){
								$nombre='Colegiatura';
								}
							else{
								$nombre='Colegiatura';
								}
							$detalle .= ' ; Pago '.$nombre.' '.$i;
							sistemalog(' ; Pago '.$nombre.' '.$i);

							$monto = $monto - $valor_pactado;
							$monto_pagado += $valor_pactado;
							$arr_monto[$q] = $valor_pactado - $valor_pagado;
							$q++;
							$i++;
							$nro_cuota = $i;
						}
					}
				}
			if ($monto>0){
				if($nro_cuota>=11){
						$objResponse->addAlert("Hay un saldo de $".$monto);	
				}
				else{
					sistemalog($max."-".$i."+1");
					$nro_cuota = $i;
					$nombre='Colegiatura';
					$flag=1;
					do{
						$sql_update = "select sum(ValorPactado) as sumado
											from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											where NumeroRutAlumno = '".$alumno."' ";
						$res_update = mysql_query($sql_update,$conexion);
						$row_update = mysql_fetch_array($res_update);
						sistemalog('Valor Pactado : '.$row_update['suma'].' - Monto Pagado '.array_sum($arr_monto))	;
						if ($row_update['sumado']==array_sum($arr_monto)){
							$flag=0;
						}
						else{
							$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											set  `ValorPagado` = ValorPagado + '".$monto."'
											where NumeroRutAlumno = '".$alumno."' and
											NumeroCuota = '".$nro_cuota."' and
											CodigoItem = '".$codigo_item."'  and 
											ctacte_ncorr > '".$ctacte_ncorr."' ";
							sistemalog($sql_update.' - Paso 3');
							$monto < $valor_pactado ? $tipo_1 = 'Abono' : $tipo_1 = 'Pago' ;
							sistemalog(' ; '.$tipo_1.' '.$nombre.' '.$nro_cuota);
							$detalle .= ' ; '.$tipo_1.' '.$nombre.' '.$nro_cuota;
							$monto_pagado += $monto;
							$monto < $valor_pactado ? $arr_monto[$q] = $monto : $arr_monto[$q] = $valor_pactado;
							sistemalog($arr_monto[$q].'---'.$monto.'---'.$valor_pactado);
							$q++;
							$monto < $valor_pactado ? $monto = 0 : $monto = $monto - $valor_pactado;
							$nro_cuota++;
						}
					}while (($monto>0)&&($nro_cuota<11)&&($flag=='1'));	
				}
			}
		}
		else{
			$diff = $valor_pactado - $valor_pagado;
			sistemalog($valor_pactado.'-'.$valor_pagado.'-'.$monto.'-'.$diff);
			if($monto>=$diff){
				$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
								set  `ValorPagado` = ValorPagado + '".$diff."'
								where ctacte_ncorr = '".$ctacte_ncorr."' ";
				//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
				sistemalog($sql_update);
				$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
							 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
							 where ctacte_ncorr = '".$ctacte_ncorr."' ";
				$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
				while($row_diff = mysql_fetch_array($res_diff)){
					sistemalog('resto : '.$row_diff['resto']);
					if ($row_diff['resto']==0){

						}
					elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
						$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
						$monto = $monto + $resto;
						$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										set  `ValorPagado` = ValorPagado
										where ctacte_ncorr = '".$ctacte_ncorr."' ";
						//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
						sistemalog($sql_update);
						}
					}
				if ($codigo_item=='1'){
					$nombre='Colegiatura';
					$detalle .= ' ; Pago '.$nombre.' 0';
					}
				else{
					$nombre='Colegiatura';
					$detalle .= ' ; Pago '.$nombre.' '.$nro_cuota;
					}
				$monto = $monto - $diff;
				$monto_pagado += $diff;
				$arr_monto[$q] = $diff;
				sistemalog($monto.'-'.$monto_pagado.'-'.$diff);
				$q++;

				if ($monto>0){
					$sql_nro_cuotas = "select max(NumeroCuota) as max, count(NumeroCuota) as cant , ValorPactado, ValorPagado
										from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										where NumeroRutAlumno = '".$alumno."' and 
										NumeroCuota > '".$nro_cuota."' and
										CodigoItem = '".$codigo_item."' and 
										ctacte_ncorr >= '".$ctacte_ncorr."'";
					$res_nro_cuenta = mysql_query($sql_nro_cuotas,$conexion) or die(mysql_error());
					$row_nro_cuenta = mysql_fetch_array($res_nro_cuenta);
					$max = $row_nro_cuenta['max'];
					$cant = $row_nro_cuenta['cant'];
					$valor_pactado = $row_nro_cuenta['ValorPactado'];
					$valor_pagado = $row_nro_cuenta['ValorPagado'];
					if ($codigo_item=='1'){
						if ($cant>0){
							$i = ($max - $cant)+1;
							while (($i<=$max)&&($monto>=$valor_pactado)){
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												set  `ValorPagado` = '".$valor_pactado."'
												where 
													NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								sistemalog($sql_update.' - Paso 4');

								$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
											 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											 where NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
								while($row_diff = mysql_fetch_array($res_diff)){
									if ($row_diff['resto']==0){

										}
									elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
										$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
										$monto = $monto + $resto;
										$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
														set  `ValorPagado` = ValorPagado
														where NumeroRutAlumno = '".$alumno."' and
																NumeroCuota = '".$i."' and
																CodigoItem = '".$codigo_item."' and 
																ctacte_ncorr > '".$ctacte_ncorr."' ";
										//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
										sistemalog($sql_update.' - Paso 4.1');
										}
									}

								if ($codigo_item=='1'){
									$nombre='Colegiatura';
									}
								else{
									$nombre='Colegiatura';
									}
								$detalle .= ' ; Pago '.$nombre.' '.$i;	
								$monto = $monto - $valor_pactado;
							   	$monto_pagado += $valor_pactado;
								$arr_monto[$q] = $valor_pactado - $valor_pagado;
								$q++;
								$i++;
								$nro_cuota = $i;
								}
							}
						else{
							$codigo_item='2';
							$nro_cuota='1';
							$sql_nro_cuotas = "select max(NumeroCuota) as max, count(NumeroCuota) as cant , ValorPactado, ValorPagado
												from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												where NumeroRutAlumno = '".$alumno."' and 
												NumeroCuota >= '".$nro_cuota."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr >= '".$ctacte_ncorr."'";
							$res_nro_cuenta = mysql_query($sql_nro_cuotas,$conexion) or die(mysql_error());
							$row_nro_cuenta = mysql_fetch_array($res_nro_cuenta);
							$max = $row_nro_cuenta['max'];
							$cant = $row_nro_cuenta['cant'];
							$valor_pactado = $row_nro_cuenta['ValorPactado'];
							$valor_pagado = $row_nro_cuenta['ValorPagado'];
							}
						}
					if ($codigo_item=='2'){
						if ($cant>0){
							$i = ($max - $cant)+1;
							//echo $monto.">=".$valor_pactado;
							//echo ($max.'-'.$cant).'+'.$nro_cuota;
							while (($i<=$max)&&($monto>=$valor_pactado)){
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												set  `ValorPagado` = '".$valor_pactado."'
												where 
													NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								sistemalog($sql_update.' - Paso 5');

								$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
											 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											 where NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
								while($row_diff = mysql_fetch_array($res_diff)){
									if ($row_diff['resto']==0){

										}
									elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
										$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
										$monto = $monto + $resto;
										$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
														set  `ValorPagado` = ValorPagado
														where NumeroRutAlumno = '".$alumno."' and
																NumeroCuota = '".$i."' and
																CodigoItem = '".$codigo_item."' and 
																ctacte_ncorr > '".$ctacte_ncorr."' ";
										//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
										sistemalog($sql_update.' - Paso 5.1');
										}
									}
								if ($codigo_item=='1'){
									$nombre='Colegiatura';
									}
								else{
									$nombre='Colegiatura';
									}
								$detalle .= ' ; Pago '.$nombre.' '.$i;
								$monto = $monto - $valor_pactado;
								$monto_pagado += $valor_pactado;
								$arr_monto[$q] = $valor_pactado - $valor_pagado;
								$q++;
								$i++;
								$nro_cuota = $i;
								}
							}
						}
					if (($monto<$valor_pactado)&&($nro_cuota<11)){
						$nro_cuota = $nro_cuota;
						if (($monto>0)&&($nro_cuota<11)){
							$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											set  `ValorPagado` = ValorPagado + '".$monto."'
											where NumeroRutAlumno = '".$alumno."' and
											NumeroCuota = '".$nro_cuota."' and
											CodigoItem = '".$codigo_item."'  and 
											ctacte_ncorr > '".$ctacte_ncorr."' ";
							//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
							sistemalog($sql_update.' - Paso 6');
							$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
										 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										 where NumeroRutAlumno = '".$alumno."' and
												NumeroCuota = '".$i."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr > '".$ctacte_ncorr."' ";
							$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
							while($row_diff = mysql_fetch_array($res_diff)){
								if ($row_diff['resto']==0){

									}
								elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
									$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
									$monto = $monto + $resto;
									$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
													set  `ValorPagado` = ValorPagado
													where NumeroRutAlumno = '".$alumno."' and
															NumeroCuota = '".$i."' and
															CodigoItem = '".$codigo_item."' and 
															ctacte_ncorr > '".$ctacte_ncorr."' ";
									//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
									sistemalog($sql_update.' - Paso 6.1');
									}
								}
							if ($codigo_item=='1'){
								$nombre='Colegiatura';
								}
							else{
								$nombre='Colegiatura';
								}
							$detalle .= ' ; Abono '.$nombre.' '.$nro_cuota;
							$monto_pagado += $monto;
							$arr_monto[$q] = $monto;
							$q++;
							$monto = $monto - $monto;
							}
						}
					}
				}	
			else{
				$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
							set  `ValorPagado` = ValorPagado + '".$monto."'
							where NumeroRutAlumno = '".$alumno."' and
							NumeroCuota = '".$nro_cuota."' and
							CodigoItem = '".$codigo_item."'  and 
							ctacte_ncorr = '".$ctacte_ncorr."' ";
				//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
				sistemalog($sql_update.' - Paso 3'.$monto);

				$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
						 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
						 where NumeroRutAlumno = '".$alumno."' and
								NumeroCuota = '".$nro_cuota."' and
								CodigoItem = '".$codigo_item."' and 
								ctacte_ncorr = '".$ctacte_ncorr."' ";
				$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
				$resto=0;
				while($row_diff = mysql_fetch_array($res_diff)){
					if ($row_diff['resto']==0){

						}
					elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
						$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
						$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										set  `ValorPagado` = ValorPagado
										where NumeroRutAlumno = '".$alumno."' and
												NumeroCuota = '".$i."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr = '".$ctacte_ncorr."' ";
						//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
						sistemalog($sql_update.' - Paso 3.1');
						}
					}
				if ($codigo_item=='1'){
					$nombre='Colegiatura';
					$nro_cuota = '0';
					}
				else{
					$nombre='Colegiatura';
					}
				$detalle .= ' ; Abono '.$nombre.' '.$nro_cuota;
				$monto_pagado += $monto;
				$arr_monto[$q] = $monto;
				$q++;
				$monto = $monto + $resto;
				if ($monto>0){
					$sql_nro_cuotas = "select max(NumeroCuota) as max, count(NumeroCuota) as cant , ValorPactado, ValorPagado
										from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
										where NumeroRutAlumno = '".$alumno."' and 
										NumeroCuota > '".$nro_cuota."' and
										CodigoItem = '".$codigo_item."' and 
										ctacte_ncorr >= '".$ctacte_ncorr."'";
					$res_nro_cuenta = mysql_query($sql_nro_cuotas,$conexion) or die(mysql_error());
					$row_nro_cuenta = mysql_fetch_array($res_nro_cuenta);
					$max = $row_nro_cuenta['max'];
					$cant = $row_nro_cuenta['cant'];
					$valor_pactado = $row_nro_cuenta['ValorPactado'];
					$valor_pagado = $row_nro_cuenta['ValorPagado'];
					if ($codigo_item=='1'){
						if ($cant>0){
							$i = ($max - $cant)+1;
							while (($i<=$max)&&($monto>=$valor_pactado)){
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												set  `ValorPagado` = '".$valor_pactado."'
												where 
													NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								sistemalog($sql_update.' - Paso 4');

								$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
											 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											 where NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
								while($row_diff = mysql_fetch_array($res_diff)){
									if ($row_diff['resto']==0){

										}
									elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
										$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
										$monto = $monto + $resto;
										$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
														set  `ValorPagado` = ValorPagado
														where NumeroRutAlumno = '".$alumno."' and
																NumeroCuota = '".$i."' and
																CodigoItem = '".$codigo_item."' and 
																ctacte_ncorr > '".$ctacte_ncorr."' ";
										//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
										sistemalog($sql_update.' - Paso 4.1');
										}
									}

								if ($codigo_item=='1'){
									$nombre='Colegiatura';
									}
								else{
									$nombre='Colegiatura';
									}
								$detalle .= ' ; Pago '.$nombre.' '.$i;	
								$monto = $monto - $valor_pactado;
							   	$monto_pagado += $valor_pactado;
								$arr_monto[$q] = $valor_pactado - $valor_pagado;
								$q++;
								$i++;
								$nro_cuota = $i;
								}
							}
						else{
							$codigo_item='2';
							$nro_cuota='1';
							$sql_nro_cuotas = "select max(NumeroCuota) as max, count(NumeroCuota) as cant , ValorPactado, ValorPagado
												from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												where NumeroRutAlumno = '".$alumno."' and 
												NumeroCuota >= '".$nro_cuota."' and
												CodigoItem = '".$codigo_item."' and 
												ctacte_ncorr >= '".$ctacte_ncorr."'";
							$res_nro_cuenta = mysql_query($sql_nro_cuotas,$conexion) or die(mysql_error());
							$row_nro_cuenta = mysql_fetch_array($res_nro_cuenta);
							$max = $row_nro_cuenta['max'];
							$cant = $row_nro_cuenta['cant'];
							$valor_pactado = $row_nro_cuenta['ValorPactado'];
							$valor_pagado = $row_nro_cuenta['ValorPagado'];
							}
						}
					if ($codigo_item=='2'){
						if ($cant>0){
							$i = ($max - $cant)+1;
							//echo $monto.">=".$valor_pactado;
							//echo ($max.'-'.$cant).'+'.$nro_cuota;
							while (($i<=$max)&&($monto>=$valor_pactado)){
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
												set  `ValorPagado` = '".$valor_pactado."'
												where 
													NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								sistemalog($sql_update.' - Paso 5');

								$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
											 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											 where NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
								while($row_diff = mysql_fetch_array($res_diff)){
									if ($row_diff['resto']==0){

										}
									elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
										$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
										$monto = $monto + $resto;
										$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
														set  `ValorPagado` = ValorPagado
														where NumeroRutAlumno = '".$alumno."' and
																NumeroCuota = '".$i."' and
																CodigoItem = '".$codigo_item."' and 
																ctacte_ncorr > '".$ctacte_ncorr."' ";
										//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
										sistemalog($sql_update.' - Paso 5.1');
										}
									}
								if ($codigo_item=='1'){
									$nombre='Colegiatura';
									}
								else{
									$nombre='Colegiatura';
									}
								$detalle .= ' ; Pago '.$nombre.' '.$i;
								$monto = $monto - $valor_pactado;
								$monto_pagado += $valor_pactado;
								$arr_monto[$q] = $valor_pactado - $valor_pagado;
								$q++;
								$i++;
								$nro_cuota = $i;
								}
							}
						}
					if (($monto<$valor_pactado)&&($nro_cuota<11)){
						$nro_cuota = $nro_cuota;
						if (($monto>0)&&($nro_cuota<11)){
							$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											set  `ValorPagado` = ValorPagado + '".$monto."'
											where NumeroRutAlumno = '".$alumno."' and
											NumeroCuota = '".$nro_cuota."' and
											CodigoItem = '".$codigo_item."'  and 
											ctacte_ncorr > '".$ctacte_ncorr."' ";
							//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								sistemalog($sql_update.' - Paso 6');
								$sql_diff = "select (ValorPactado - ValorPagado) as resto, ValorPagado, ValorPactado
											 from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											 where NumeroRutAlumno = '".$alumno."' and
													NumeroCuota = '".$i."' and
													CodigoItem = '".$codigo_item."' and 
													ctacte_ncorr > '".$ctacte_ncorr."' ";
								$res_diff = mysql_query($sql_diff,$conexion) or die(mysql_error());
								while($row_diff = mysql_fetch_array($res_diff)){
									if ($row_diff['resto']==0){

										}
									elseif ($row_diff['ValorPactado']<$row_diff['ValorPagado']){
										$resto = $row_diff['ValorPagado']-$row_diff['ValorPactado'];
										$monto = $monto + $resto;
										$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
														set  `ValorPagado` = ValorPagado
														where NumeroRutAlumno = '".$alumno."' and
																NumeroCuota = '".$i."' and
																CodigoItem = '".$codigo_item."' and 
																ctacte_ncorr > '".$ctacte_ncorr."' ";
										//$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
										sistemalog($sql_update.' - Paso 6.1');
										}
									}
							if ($codigo_item=='1'){
								$nombre='Colegiatura';
								}
							else{
								$nombre='Colegiatura';
								}
							$detalle .= ' ; Abono '.$nombre.' '.$nro_cuota;
							$monto_pagado += $monto;
							$arr_monto[$q] = $monto;
							$q++;
							$monto = $monto - $monto;
							}
						}
					}
				}
			}
		
		/*`NumeroRutAlumno`, `CodigoItem`, `NumeroCuota`, `FechaVencimiento`, `ValorPactado`, `ValorPagado`, 
		 *`EstadoCuentaCorriente`, `NumeroCompromiso`, `ValorCompromisoCC`*/

		//var_dump($arr_monto);

		$sql_cuota = "select `NumeroCuota`, CodigoItem, `ValorPactado`, ValorPagado, ctacte_ncorr
				  from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
					where NumeroRutAlumno = '".$alumno."' and ValorPactado > ValorPagado
					order by CodigoItem asc, ctacte_ncorr asc
					limit 0,1";
		$res_cuota = mysql_query($sql_cuota,$conexion) or die(mysql_error());
		$row_cuota = mysql_fetch_array($res_cuota);

		$nro_cuota = $row_cuota['NumeroCuota'];
		$codigo_item = $row_cuota['CodigoItem'];
		$valor_pactado = $row_cuota['ValorPactado'];
		$valor_pagado = $row_cuota['ValorPagado'];
		$ctacte_ncorr = $row_cuota['ctacte_ncorr'];

		$monto = $data['valor_pagar'];

		$arr_repuesto = $data['arr_repuesto'];
		$arr_repuesto = explode(',',$arr_repuesto);
		$arr_nom_repuesto = $data["arr_nom_repuesto"];
		$arr_nom_repuesto = explode(',',$arr_nom_repuesto);
	    $arr_pu = $data["arr_pu"];
		$arr_pu = explode(',',$arr_pu);
	    $arr_cant = $data["arr_cant"];
		$arr_cant = explode(',',$arr_cant);
	    $arr_vt = $data["arr_vt"];
		$arr_vt = explode(',',$arr_vt);
		
		sistemalog('Ingreso Cheques');
		$flag="0";
		if ($forma_pago=="2" && $arr_repuesto[0] == ''){
			sistemalog('No se ingresaron hay cheques');
			$objResponse->addAlert("No se ingresaron hay cheques");
			//$sql = "COMMIT; ";
			$sql = "ROLLBACK;";
			$res = mysql_query($sql,$conexion);
			sistemalog($sql);
			$objResponse->addScript("document.getElementById('btnPagar').disabled=false");
			return $objResponse->getXML();
		}
		if ($forma_pago=="2"){
			for($i=0;$i<count($arr_repuesto);$i++){
				$nro_cheque 	= $arr_repuesto[$i];
				$banco_cheque 	= $arr_nom_repuesto[$i];
				$fecha_cheque 	= $arr_cant[$i];
				$valor_cheque 	= $arr_pu[$i];
				list($dia,$mes,$anio) = explode('/',$fecha_cheque);
				$insert_mov = "INSERT INTO gescolcl_arcoiris_administracion.`Cheques`(`NumeroCheque`, `CodigoBanco`, `ValorCheque`, 
																   `FechaCheque`,  `NumeroBoleta`) 
								VALUES ('".$nro_cheque."','".$banco_cheque."','".$valor_cheque."',
										'".$anio."-".$mes."-".$dia."','".$numero_boleta."')";
				$res_mov = mysql_query($insert_mov,$conexion) or die(mysql_error());
				sistemalog($insert_mov);
				$flag= "1";
				}
			}
		
		list($dia,$mes,$anio) = explode('/',$data['fecha_pago']);
		$arr_boleta = explode(';',$detalle);
		sistemalog('Ingreso Movimientos');
		sistemalog('arr_monto');
		foreach ($arr_monto as $value) {
			sistemalog($value);
		}
		sistemalog('arr_boleta');
		array_splice($arr_boleta, array_search(" ",$arr_boleta),1);
		$temp = [];
		foreach ($arr_boleta as $value) {
			$temp[] = rtrim($value);
		}
		$arr_boleta = array_unique($temp);
		foreach ($arr_boleta as $value) {
			sistemalog($value);
		}
		
		for($m=0;$m<count($arr_boleta);$m++){
			$anio_vigente = $_SESSION["sige_anio_escolar_vigente"];
			if($arr_monto[$m]>0){
				if ($forma_pago=="2"){
					$insert_mov = "INSERT INTO gescolcl_arcoiris_administracion.Movimientos_Cheques(`NumeroBoleta`, `FechaBoleta`, 
																		`NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`,
																		`TipoPagoBoleta`, `DescripcionBoleta`, `CodigoUsuario`,
																		`PeriodoMovimiento`) 
									VALUES ('".$numero_boleta."','".$anio."-".$mes."-".$dia."','".$alumno."','".$arr_monto[$m]."','1',
											'".$forma_pago."','".$arr_boleta[$m]."','admin','".$anio_vigente."')"; 
					$res_mov = mysql_query($insert_mov,$conexion) or die(mysql_error());
					}
				else{
					$insert_mov = "INSERT INTO gescolcl_arcoiris_administracion.Movimientos_temp(`NumeroBoleta`, `FechaBoleta`, 
																		`NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`,
																		`TipoPagoBoleta`, `DescripcionBoleta`, `CodigoUsuario`,
																		`PeriodoMovimiento`) 
									VALUES ('".$numero_boleta."','".$anio."-".$mes."-".$dia."','".$alumno."','".$arr_monto[$m]."','1',
											'".$forma_pago."','".$arr_boleta[$m]."','admin','".$anio_vigente."')"; 
					$res_mov = mysql_query($insert_mov,$conexion) or die(mysql_error());
					}	
				sistemalog($insert_mov);
				}
			}

			$delete_mov = "delete from gescolcl_arcoiris_administracion.Movimientos_temp where DescripcionBoleta = ''";
			$res_mov = mysql_query($delete_mov,$conexion) or die(mysql_error());
			
			
			//$objResponse->addAlert("Pago Registrado.");
			//sistemalog("Pago Registrado.");
			
			$sql = "COMMIT; ";
			//$sql = "ROLLBACK;";
			$res = mysql_query($sql,$conexion);

			sistemalog("Termino Transaccion");
			//$objResponse->addScript("window.parent.hidePopWin(true)");
			//$objResponse->addScript("window.parent.document.Form1.submit();");
			
			if ($forma_pago=="2"){				
				$objResponse->addScript("location.href='sg_alumnos_cobranza_pago_cheque_paso_2.php?boleta_temp=".$numero_boleta."&boleta=".$numero_boleta."'");
				}
			else{
				$objResponse->addScript("location.href='sg_alumnos_cobranza_pago_paso_2.php?numero_boleta=".$numero_boleta."'");
				//$objResponse->addScript("window.parent.hidePopWin(true)");
				//$objResponse->addScript("window.parent.document.Form1.submit();");
				}
			/*	`NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`, `TipoPagoBoleta`, 
			 * `DescripcionBoleta`, `CodigoUsuario`, `PeriodoMovimiento`
			 */
		}	
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
$xajax->registerFunction("BuscaBoleta");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('rut_alumno', substr($_GET['rut_alumno'],0,8));

$miSmarty->display('sg_alumnos_cobranza_pago.tpl');

ob_flush();
?>

