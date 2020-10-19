<?php
ob_start();
session_start();

ini_set('display_errors', 1); 
error_reporting(E_ALL);

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 
include "../includes/php/class.phpmailer.php"; 
include "../includes/php/class.smtp.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_alumnos_cobranza.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();
$anio = $_SESSION["sige_anio_escolar_vigente"];

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
        if ($select == 'anio_buscar'){
        	$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $_SESSION["sige_anio_escolar_vigente"]);
			$objResponse->addAssign("$select","options[".$j."].text", $_SESSION["sige_anio_escolar_vigente"]); 	
			$j++;
        }
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
	$_SESSION["alycar_pagina_volver"]	=   'sg_alumnos_cobranza.php';
	
    $objResponse->addScript("document.location.href='sg_mant_tablas.php?tbl=prestadores&empresa=".$empresa."&fecha=".$fecha."&cliente=".$cliente."&rut=".$rut."&nro_factura=".$nro_factura."&neto=".$neto."&iva=".$iva."&total=".$total."'");
	
	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	$alumno 			= 	$data["OBLIRutAlumno"];
	$anio				=	$_SESSION['sige_anio_escolar_vigente'];
	
	$sql = "delete from gescolcl_arcoiris_administracion.Movimientos_temp ";
	$res = mysql_query($sql,$conexion);	       
	

	$sql_bitacora = "select NumeroRutApoderado
					from gescolcl_arcoiris_administracion.Bitacoras
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_arcoiris_administracion.alumnos".$anio."
													where NumeroRutAlumno = '".$alumno."')";
	$res_bitacora = mysql_query($sql_bitacora,$conexion) ;
	$flag='1';
	if (mysql_num_rows($res_bitacora)==0){
		$flag='0';
		}

	$miSmarty->assign('enmarcado',$flag);
	

	$miSmarty->assign('anio',$anio);
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio_buscar','gescolcl_arcoiris_administracion.Periodos',
							'','Elija','distinct AnoAcademico','AnoAcademico', '')");
	
	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,
								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado
					from gescolcl_arcoiris_administracion.Apoderados
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_arcoiris_administracion.alumnos".$anio."
													where NumeroRutAlumno = '".$alumno."')";
	$res_apoderado = mysql_query($sql_apoderado,$conexion) ;
	$row_apoderado = mysql_fetch_array($res_apoderado);
	
	$apoderado = $row_apoderado['NumeroRutApoderado'];
	$miSmarty->assign('apoderado',$row_apoderado['nombre']);
	$miSmarty->assign('telefono_apoderado',$row_apoderado['TelefonoParticularApoderado']);
	$miSmarty->assign('email_apoderado',$row_apoderado['EMailApoderado']);
	
	
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso as NombreCurso,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				NumeroRutAlumno, Matriculado
				from gescolcl_arcoiris_administracion.Cursos
					inner join gescolcl_arcoiris_administracion.alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio.".NumeroRutApoderado = '".$apoderado."' 
				order by alumnos".$anio.".NumeroLista"; 
	$res_pd = mysql_query($sql_pd,$conexion) ;
	$arrRegistrosAlumnos = array();
	while ($row_pd = mysql_fetch_array($res_pd)){
		array_push($arrRegistrosAlumnos, array("alumnos"	=>	$row_pd['nombre_alumno'], 
     											"curso"		=> 	$row_pd['NombreCurso'], 
     											"rut_alumno"=> 	$row_pd['NumeroRutAlumno'], 
     											"matriculado"=> 	$row_pd['Matriculado']));
		}
	
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso as NombreCurso,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				FechaNacimiento, DireccionParticularAlumno, TelefonoParticularAlumno, EMailAlumno,
				alumnos".$anio.".BecaIncorporacion, alumnos".$anio.".BecaColegiatura
				from gescolcl_arcoiris_administracion.Cursos
					inner join gescolcl_arcoiris_administracion.alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio.".NumeroRutAlumno = '".$alumno."'"; 
	$res_pd = mysql_query($sql_pd,$conexion) ;
	while ($row_pd = mysql_fetch_array($res_pd)){
			$miSmarty->assign("alumno"	,$row_pd['nombre_alumno']); 
			$miSmarty->assign("curso" , $row_pd['NombreCurso']);
			$miSmarty->assign("rut_alumno", $alumno);
     											
			$sql_003 = "select TipoBeca, TipoBeca.NombreTipoBeca
						from gescolcl_arcoiris_administracion.alumnos".$anio."
							inner join gescolcl_arcoiris_administracion.Becas 
								on Becas.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno
							inner join gescolcl_arcoiris_administracion.TipoBeca
								on TipoBeca.CodigoTipoBeca = Becas.CodigoTipoBeca
						where alumnos".$anio.".NumeroRutAlumno = '".$alumno."' and Becas.PeriodoBeca = '".$anio."'";
			$res_003 = mysql_query($sql_003,$conexion) ;
			$row_003 = mysql_fetch_array($res_003);

     		$miSmarty->assign("fecha_alumno" , $row_pd['FechaNacimiento']); 
			$miSmarty->assign("direccion" ,$row_pd['DireccionParticularAlumno']);
     		$miSmarty->assign("telefono" ,	$row_pd['TelefonoParticularAlumno']);
     		$miSmarty->assign("email" ,	$row_pd['EMailAlumno']);
     		$miSmarty->assign("tipo_beca" ,	$row_003['NombreTipoBeca']);
     		$miSmarty->assign("porc_beca_incor" ,	$row_pd['BecaIncorporacion']);
     		$miSmarty->assign("porc_beca_colegiatura" ,	$row_pd['BecaColegiatura']);
		}
	
	// busca los registros
	$sql_ve = "select  
				`NumeroRutAlumno`, `CodigoItem`, `NumeroCuota`, `FechaVencimiento`, `ValorPactado`, `ValorPagado`, `EstadoCuentaCorriente`, `NumeroCompromiso`, `ValorCompromisoCC`, ctacte_ncorr
				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
				
				where
				NumeroRutAlumno = '".$alumno."' 
				order by CodigoItem asc, ctacte_ncorr asc
					";
	
	$res_ve = mysql_query($sql_ve, $conexion);
		$arrRegistros	= 	array();
		$i = 1;

		$tot_vpac = '0';
		$tot_vpat = '0';
		$tot_saldo = '0';
			
		while ($line_ve = mysql_fetch_row($res_ve)) {
			$cuota = $line_ve[2];
			if ($line_ve[1]==1){
				$codigo = "Colegiatura";
				$cuota = "0";
				}
			elseif($line_ve[1]==2){
				$codigo = "Colegiatura";
				}
			$sql_busca = "select * from gescolcl_arcoiris_administracion.Movimientos_Cheques where DescripcionBoleta like '%".$codigo." ".$cuota."' and PagadoMovimiento = 0 and NumeroRutAlumno = '".$alumno."'";
			$res_busca = mysql_query($sql_busca,$conexion) ;
			$cheque = 'NO';
			$boleta ='';
			if (mysql_num_rows($res_busca)>0){
				while($row_busca = mysql_fetch_array($res_busca)){
					$boleta = $row_busca['NumeroBoleta'];
					}
				}
			array_push($arrRegistros, array("item"					=>	$i, 
											"codigo"				=> 	$codigo, 
											"nro_cuota"				=> 	$cuota,
											"fecha" 				=> 	$line_ve[3],
											"pactado" 				=> 	$line_ve[4],
											"valorpagado"			=> 	$line_ve[5],
											"saldo"					=> 	$line_ve[4]-$line_ve[5],
											"id_ctacte"				=> 	$line_ve[9],
											"cheque"				=> 	$cheque,
											"boleta"				=> 	$boleta
											));
			$tot_vpac += $line_ve[4];
			$tot_vpat += $line_ve[5];
			$tot_saldo = $tot_saldo + ($line_ve[4]-$line_ve[5]);
			$i++;
			
		}
		
		$sql_mov = "SELECT `mov_ncorr`, `NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, 
							`ValorBoleta`, `EstadoBoleta`, `TipoPagoBoleta`, `DescripcionBoleta`, 
							`CodigoUsuario`, `PeriodoMovimiento` 
					FROM gescolcl_arcoiris_administracion.Movimientos
					WHERE NumeroRutAlumno = '".$alumno."' and PeriodoMovimiento = '".$anio."' and EstadoBoleta <> 2";
		$arrRegistrosMov	= 	array();
		$i = 1;
		$res_ve = mysql_query($sql_mov, $conexion);
		
		$tot_valor = '0';
		
		while ($line_ve = mysql_fetch_row($res_ve)) {
			if ($line_ve[6]=='1'){
				$tipo_pago = 'Efectivo';
				}
			elseif ($line_ve[6]=='2'){
				$tipo_pago = 'Cheque a Fecha';
				}
			elseif ($line_ve[6]=='6'){
				$tipo_pago = 'Cheque al Dia';
				}
			elseif ($line_ve[6]=='3'){
				$tipo_pago = 'Transferencia';
				}
			elseif ($line_ve[6]=='4'){
				$tipo_pago = 'Descuento por planilla';
				}
			elseif ($line_ve[6]=='5'){
				$tipo_pago = 'TransBank';
				}

			if ($line_ve[5]=='2'){
				$line_ve[4] = 0;
				}
				
			array_push($arrRegistrosMov, array("item"					=>	$i, 
											"nro_boleta"			=> 	$line_ve[1], 
											"fecha"					=> 	$line_ve[2],
											"valor" 				=> 	$line_ve[4],
											"tipo_pago"				=> 	$tipo_pago,
											"descripcion"			=> 	$line_ve[7]
											));

			$tot_valor += $line_ve[4];

			$i++;
			}

		$miSmarty->assign('tot_vpac', $tot_vpac);
		$miSmarty->assign('tot_vpat', $tot_vpat);
		$miSmarty->assign('tot_saldo', $tot_saldo);
		$miSmarty->assign('tot_valor', $tot_valor);

		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosMov', $arrRegistrosMov);
		$miSmarty->assign('arrRegistrosAlumnos', $arrRegistrosAlumnos);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_cobranza_list.tpl'));
		$objResponse->addAssign("divabonos_imp", "innerHTML", $miSmarty->fetch('sg_alumnos_cobranza_imp_list.tpl'));
		$objResponse->addAssign("divabonos_movimientos", "innerHTML", $miSmarty->fetch('sg_alumnos_cobranza_movimientos_list.tpl'));
		$objResponse->addAssign("divabonos_movimientos_imp", "innerHTML", $miSmarty->fetch('sg_alumnos_cobranza_movimientos_imp_list.tpl'));
		
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function Eliminar_1($data,$ncorr){
	global $conexion;
	
	$objResponse = new xajaxResponse('UTF8');
	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$sql_ve = "delete from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
				where
				ctacte_ncorr = '".$ncorr."'";
	
	$res_ve = mysql_query($sql_ve, $conexion) ;
	
	$objResponse->addAlert("Registro Eliminado");
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");

	return $objResponse->getXML();
}

function Eliminar($data,$ncorr){
	global $conexion;
	
   	$objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("if(confirm('Desea eliminar cuota pactada')) xajax_Eliminar_1(xajax.getFormValues('Form1'),".$ncorr.")");
	
	return $objResponse->getXML();
	}

function PagarMov($data,$boleta){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
    $anio = $_SESSION["sige_anio_escolar_vigente"];

	$sql = "select * from gescolcl_arcoiris_administracion.Movimientos_Cheques where NumeroBoleta = '".$boleta."' and ValorBoleta > 0";
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
		$res_mov = mysql_query($insert_mov,$conexion) ;

		$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
											set  `ValorPagado` = ValorPagado + '".$monto."'
													where NumeroRutAlumno = '".$alumno."' and
														NumeroCuota = '".$nro_cuota."' and
														CodigoItem = '".$codigo_item."' ";
		$res_update = mysql_query($sql_update,$conexion) ;

		$sql_update = "update gescolcl_arcoiris_administracion.Movimientos_Cheques
												set  `PagadoMovimiento` = 1
												where mov_ncorr = '".$row['mov_ncorr']."' ";
		$res_update = mysql_query($sql_update,$conexion) ;

		$sql_update = "update gescolcl_arcoiris_administracion.Cheques
						set  `EstadoCheque` = 1
						where NumeroBoleta = '".$boleta."' ";
		$res_update = mysql_query($sql_update,$conexion) ;

		}

	$objResponse->addAlert("Transaccion Terminada");
	$objResponse->addScript("window.document.Form1.submit();");
	//$objResponse->addScript("location.href='sg_alumnos_cobranza_pago_paso_2.php?numero_boleta=".$numero_boleta."'");
	/*	`NumeroBoleta`, `FechaBoleta`, `NumeroRutAlumno`, `ValorBoleta`, `EstadoBoleta`, `TipoPagoBoleta`, 
	 * `DescripcionBoleta`, `CodigoUsuario`, `PeriodoMovimiento`
	 */
	return $objResponse->getXML();

	}

function Modificar($data,$ncorr){
	global $conexion;
    $anio = $_SESSION["sige_anio_escolar_vigente"];
	
    $objResponse = new xajaxResponse('UTF8');
	$anio = $_SESSION["sige_anio_escolar_vigente"];
	
	$sql_001 = "select  
				`NumeroRutAlumno`, `CodigoItem`, `NumeroCuota`, `FechaVencimiento`, `ValorPactado`, `ValorPagado`, `EstadoCuentaCorriente`, `NumeroCompromiso`, `ValorCompromisoCC`, ctacte_ncorr
				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
				
				where
				ctacte_ncorr = '".$ncorr."'";
	$res_001 = mysql_query($sql_001,$conexion) ;
	$row_001 = mysql_fetch_array($res_001);
	
	$objResponse->addAssign('tipo_pago','value',$row_001['CodigoItem']);
	$objResponse->addAssign('nro_cuenta','value',$row_001['NumeroCuota']);
	list($anio,$mes,$dia) = explode('-',$row_001['FechaVencimiento']);
	$objResponse->addAssign('fecha_pago','value',$dia.'/'.$mes.'/'.$anio);
	$objResponse->addAssign('pactado','value',$row_001['ValorPactado']);
	$objResponse->addAssign('pagado','value',$row_001['ValorPagado']);
	$objResponse->addAssign('ctacte_ncorr','value',$row_001['ctacte_ncorr']);
	
	
	return $objResponse->getXML();
	}

function GuardarPago($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	$anio_act = $_SESSION["sige_anio_escolar_vigente"];

	$ncorr = $data['ctacte_ncorr'];
	
	if ($ncorr!=''){
		list($dia,$mes,$anio) = explode('/',$data['fecha_pago']);
		$sql_001 = "update  gescolcl_arcoiris_administracion.CuentaCorriente".$anio_act."
						set	`NumeroRutAlumno` = '".$data['OBLIRutAlumno']."', 
							`CodigoItem` 	  = '".$data['tipo_pago']."', 
							`NumeroCuota` 	  = '".$data['nro_cuenta']."', 
							`FechaVencimiento`= '".$anio."-".$mes."-".$dia."',  
							`ValorPactado` 	  = '".$data['pactado']."',  
							`ValorPagado` 	  = '".$data['pagado']."'
				where ctacte_ncorr = '".$ncorr."'";
		$res_001 = mysql_query($sql_001,$conexion) ;
		$objResponse->addAlert("Registro Actualizado");
		}
	else{
		list($dia,$mes,$anio) = explode('/',$data['fecha_pago']);
		
		$sql_001 = "insert into  gescolcl_arcoiris_administracion.CuentaCorriente".$anio_act."
						(`NumeroRutAlumno`, `CodigoItem`, `NumeroCuota`, `FechaVencimiento`, `ValorPactado`, `ValorPagado`)
						values ('".$data['OBLIRutAlumno']."','".$data['tipo_pago']."','".$data['nro_cuenta']."',
								'".$anio."-".$mes."-".$dia."',  '".$data['pactado']."',   '".$data['pagado']."' )";
		$res_001 = mysql_query($sql_001,$conexion) ;
		$objResponse->addAlert("Registro Ingresado");
		}
		
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");

	return $objResponse->getXML();
	}
function FichaAlumno($data,$rut){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_mant_tablas_alumnos".$anio.".php?tbl=alumnos&rut_alumno=".$rut."', 'Ficha Alumno', 800, 600, null);");	

	return $objResponse->getXML();
	}

function EnviarCorreoAlumno($data,$curso,$alumno,$email_apoderado){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
    $anio = $_SESSION["sige_anio_escolar_vigente"];
	    
       	$correo = new PHPMailer();
        $correo->SMTPDebug = 1;                               // Descripcion detallada debug
        $correo->isSMTP();                                      // Set mailer to use SMTP
        $correo->Host = 'mail.gescol.cl';          
        $correo->From = $_SESSION["sige_email_usuario"];
        $correo->FromName = 'Sistema Financiamiento Compartido';
       
       //	$objResponse->addAlert($email_apoderado);
        $correo->addAddress($email_apoderado);   //Añadir recipiente  (ejemplo@ej.com , Ejemplo)
		
		$correo->isHTML(true);                                              // Email formato HTML
        $correo->Subject = utf8_decode('Reporte Sistema Financiamiento Compartido');         //asunto del correo
        
        $anio = $_SESSION['sige_anio_escolar_vigente'];
        $valor = $data['enviar_correo'];
		$rut_alumno = $data['OBLIRutAlumno'];


		$sql_pd = "select 
						distinct
						Cursos.NombreCurso as NombreCurso,
						concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						NumeroRutAlumno, Matriculado
						from gescolcl_arcoiris_administracion.Cursos
							inner join gescolcl_arcoiris_administracion.alumnos".$anio."
								on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
						where
							alumnos".$anio.".NumeroRutAlumno = '".$rut_alumno."' 
						order by alumnos".$anio.".NumeroLista"; 
			$res_pd = mysql_query($sql_pd,$conexion) ;
			$arrRegistrosAlumnos = array();
			$row_pd = mysql_fetch_array($res_pd);
				
			$alumno = $row_pd['nombre_alumno'];

		$str="";
        if ($valor=='1'){
        		$str .= '
		                <html>
		                <head></head>
		                <body>
						<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
						    	<td colspan="2" class="grilla-tab-fila-titulo">Cartola A&ntilde;o '.$anio.'</td> 
						    </tr>
							<tr>
						    	<td class="grilla-tab-fila-titulo">Alumno</td>
						    	<td class="grilla-tab-fila-campo">'.$alumno.'</td>
						    </tr>
						    <tr>
						    	<td class="grilla-tab-fila-titulo">Curso</td>
						    	<td class="grilla-tab-fila-campo">'.$curso.'</td>
						    </tr>
						    <tr>
						        <td colspan="2">
						            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
						            <tr>
						                <td class="grilla-tab-fila-titulo" align="center">Codigo</td>
						                <td class="grilla-tab-fila-titulo" align="center">Nro Cuota</td>
						                <td class="grilla-tab-fila-titulo" align="center">Fecha</td>
						                <td class="grilla-tab-fila-titulo" align="center">Pactado</td>
						                <td class="grilla-tab-fila-titulo" align="center">Pagado</td>
						            </tr>';
				$sql_ve = "select  
							`NumeroRutAlumno`, `CodigoItem`, `NumeroCuota`, date_format(FechaVencimiento,'%d-%m-%Y') as FechaVencimiento_1, 
							`ValorPactado`, 
							`ValorPagado`, `EstadoCuentaCorriente`, `NumeroCompromiso`, `ValorCompromisoCC`, ctacte_ncorr
							from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
							
							where
							NumeroRutAlumno = '".$rut_alumno."' 
							order by CodigoItem asc, ctacte_ncorr asc
								";
				
				$res_ve = mysql_query($sql_ve, $conexion);
					$arrRegistros	= 	array();
					$i = 1;
					while ($line_ve = mysql_fetch_row($res_ve)) {
						$cuota = $line_ve[2];
						if ($line_ve[1]==1){
							$codigo = "Colegiatura";
							$cuota = "0";
							}
						elseif($line_ve[1]==2){
							$codigo = "Colegiatura";
							}
						array_push($arrRegistros, array("item"					=>	$i, 
														"codigo"				=> 	$codigo, 
														"nro_cuota"				=> 	$cuota,
														"fecha" 				=> 	$line_ve[3],
														"pactado" 				=> 	$line_ve[4],
														"valorpagado"			=> 	$line_ve[5],
														"saldo"					=> 	$line_ve[4]-$line_ve[5],
														"id_ctacte"				=> 	$line_ve[9]
														));
						$i++;
						
					}
					for($r=0;$r<count($arrRegistros);$r++){
		                    $str .='	<tr>';
		                    $str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistros[$r]['codigo'].'</td>';
		                    $str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistros[$r]['nro_cuota'].'</td>';
		                    $str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistros[$r]['fecha'].'</td>';
		                    $str .='	<td class="grilla-tab-fila-campo" align="left">'.number_format($arrRegistros[$r]['pactado'],0,'.',',').'</td>';
		                    $str .='	<td class="grilla-tab-fila-campo" align="left">'.number_format($arrRegistros[$r]['valorpagado'],0,'.',',').'</td>';
		                    $str .='	</tr>';
						}
				$str .='			</table>
						        </td>
						    </tr>';
		       			
		        $str .="</table>"; 
		        $str .="</body></html>"; 
		        $correo->Body    = $str;

		        if(!$correo->send()) {
		            echo 'Message could not be sent.';
		            echo 'Mailer Error: ' . $correo->ErrorInfo;
		        	}
		        else {
		         	$objResponse->addAlert("Correo Enviado");
		            } 

        	}

			if ($valor=='2'){
        		$str .= '
		                <html>
		                <head></head>
		                <body>
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
							    	<td colspan="2" class="grilla-tab-fila-titulo">Detalle de Pagos A&ntilde;o '.$anio.'</td> 
							    </tr>
								<tr>
							    	<td class="grilla-tab-fila-titulo">Alumno</td>
							    	<td class="grilla-tab-fila-campo">'.$alumno.'</td>
							    </tr>
							    <tr>
							    	<td class="grilla-tab-fila-titulo">Curso</td>
							    	<td class="grilla-tab-fila-campo">'.$curso.'</td>
							    </tr>
							    

							</table>
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

							<tr>
								<td class="grilla-tab-fila-titulo" align="center">Nro Boleta</td>
								<td class="grilla-tab-fila-titulo" align="center">Fecha</td>
								<td class="grilla-tab-fila-titulo" align="center">Valor</td>
								<td class="grilla-tab-fila-titulo" align="center">Tipo de Pago</td>
								<td class="grilla-tab-fila-titulo" align="center">Descripcion</td>

							    </tr>';
					$sql_mov = "SELECT `mov_ncorr`, `NumeroBoleta`, date_format(FechaBoleta,'%d-%m-%Y') as FechaBoleta, `NumeroRutAlumno`, 
										`ValorBoleta`, `EstadoBoleta`, `TipoPagoBoleta`, `DescripcionBoleta`, 
										`CodigoUsuario`, `PeriodoMovimiento` 
								FROM gescolcl_arcoiris_administracion.Movimientos
								WHERE NumeroRutAlumno = '".$rut_alumno."' and PeriodoMovimiento = '".$anio."' and EstadoBoleta = 1";
					$arrRegistrosMov	= 	array();
					$i = 1;
					$res_ve = mysql_query($sql_mov, $conexion);
					while ($line_ve = mysql_fetch_row($res_ve)) {
						if ($line_ve[6]=='1'){
							$tipo_pago = 'Efectivo';
							}
						elseif ($line_ve[6]=='2'){
							$tipo_pago = 'Cheque';
							}
						elseif ($line_ve[6]=='3'){
							$tipo_pago = 'Transferencia';
							}
						elseif ($line_ve[6]=='4'){
							$tipo_pago = 'Descuento por planilla';
							}
						elseif ($line_ve[6]=='5'){
							$tipo_pago = 'TransBank';
							}
						elseif ($line_ve[6]=='6'){
							$tipo_pago = 'Cheque Al Dia';
							}
						array_push($arrRegistrosMov, array("item"					=>	$i, 
														"nro_boleta"			=> 	$line_ve[1], 
														"fecha"					=> 	$line_ve[2],
														"valor" 				=> 	$line_ve[4],
														"tipo_pago"				=> 	$tipo_pago,
														"descripcion"			=> 	$line_ve[7]
														));
						$i++;
						}
					for($r=0;$r<count($arrRegistrosMov);$r++){
		                    
							$str .='		        <tr>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['nro_boleta'].'</td>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['fecha'].'</td>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.number_format($arrRegistrosMov[$r]['valor'],0,'.',',').'</td>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['tipo_pago'].'</td>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['descripcion'].'</td>';
							$str .='				</tr>';
		                   
						}
				 $str .='			</table>
						        </td>
						    </tr>';
		       			
		        $str .="</table>"; 
		        $str .="</body></html>"; 
		        $correo->Body    = $str;

		        if(!$correo->send()) {
		            echo 'Message could not be sent.';
		            echo 'Mailer Error: ' . $correo->ErrorInfo;
		        	}
		        else {
		         	$objResponse->addAlert("Correo Enviado");
		            } 

        	}

			if ($valor=='3'){
        		$str .= '
		                <html>
		                <head></head>
		                <body>
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
							    	<td colspan="2" class="grilla-tab-fila-titulo">Detalle de Compromisos A&ntilde;o '.$anio.'</td> 
							    </tr>
								<tr>
							    	<td class="grilla-tab-fila-titulo">Alumno</td>
							    	<td class="grilla-tab-fila-campo">'.$alumno.'</td>
							    </tr>
							    <tr>
							    	<td class="grilla-tab-fila-titulo">Curso</td>
							    	<td class="grilla-tab-fila-campo">'.$curso.'</td>
							    </tr>
							    

							</table>
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

							<tr>
								<td class="grilla-tab-fila-titulo" align="center">Fecha Gestion</td>
								<td class="grilla-tab-fila-titulo" align="center">Descripcion</td>
								<td class="grilla-tab-fila-titulo" align="center">Fecha Compromiso</td>
						    </tr>';
					$sql_mov = "SELECT date_format(FechaBitacora,'%d-%m-%Y') as FechaBitacora_1, 
										DescripcionCompromiso	, 
										date_format(FechaCompromiso ,'%d-%m-%Y') as FechaCompromiso_1
								FROM gescolcl_arcoiris_administracion.Bitacoras
								WHERE NumeroRutApoderado in (select NumeroRutApoderado
																from gescolcl_arcoiris_administracion.alumnos".$anio."
																where NumeroRutAlumno = '".$rut_alumno."')";
					$arrRegistrosMov	= 	array();
					$i = 1;
					$res_ve = mysql_query($sql_mov, $conexion);
					while ($line_ve = mysql_fetch_row($res_ve)) {
						array_push($arrRegistrosMov, array("item"					=>	$i, 
														"FechaBitacora"			=> 	$line_ve[0], 
														"DescripcionCompromiso"					=> 	$line_ve[1],
														"FechaCompromiso" 				=> 	$line_ve[2]
														));
						$i++;
						}
					for($r=0;$r<count($arrRegistrosMov);$r++){
		                    
							$str .='		        <tr>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['FechaBitacora'].'</td>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['DescripcionCompromiso'].'</td>';
							$str .='	<td class="grilla-tab-fila-campo" align="left">'.$arrRegistrosMov[$r]['FechaCompromiso'].'</td>';
							$str .='				</tr>';
		                   
						}
				 $str .='			</table>
						        </td>
						    </tr>';
		       			
		        $str .="</table>"; 
		        $str .="</body></html>"; 
		        $correo->Body    = $str;

		        if(!$correo->send()) {
		            echo 'Message could not be sent.';
		            echo 'Mailer Error: ' . $correo->ErrorInfo;
		        	}
		        else {
		         	$objResponse->addAlert("Correo Enviado");
		            } 

        	}



	return $objResponse->getXML();
	}

function CambiarAnio($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
    $anio = $data['anio_buscar'];
	$_SESSION['sige_anio_escolar_vigente'] = $anio;
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");
	
	return $objResponse->getXML();
	}

	

function Volver($data,$rut_alumno){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
    $objResponse->addScript("location.href='sg_alumnos_matricula.php?rut_alumno=".$rut_alumno."';");

	
	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("LlamaMantenedorVxC");
$xajax->registerFunction("Eliminar");
$xajax->registerFunction("Eliminar_1");
$xajax->registerFunction("Modificar");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("GuardarPago");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("EnviarCorreoAlumno");
$xajax->registerFunction("CambiarAnio");
$xajax->registerFunction("PagarMov");
$xajax->registerFunction("Volver");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$arr_rut = explode('-',$_GET['rut_alumno']);
$miSmarty->assign('rut_alumno', $arr_rut[0]);

	
	$anio				=	$_SESSION['sige_anio_escolar_vigente'];
	

	$sql_bitacora = "select NumeroRutApoderado
					from gescolcl_arcoiris_administracion.Bitacoras
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_arcoiris_administracion.alumnos".$anio."
													where NumeroRutAlumno = '".substr($_GET['rut_alumno'],0,8)."')";
	$res_bitacora = mysql_query($sql_bitacora,$conexion) ;
	$flag='1';
	if (mysql_num_rows($res_bitacora)==0){
		$flag='0';
		}

	$miSmarty->assign('enmarcado',$flag);


$miSmarty->display('sg_alumnos_cobranza.tpl');

ob_flush();
?>

