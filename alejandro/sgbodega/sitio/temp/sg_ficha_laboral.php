<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ficha_laboral.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data['OBLIrut'];
	
	$arr_rut = explode('-',$rut);
	$rut = $arr_rut[0];
	
	$sql = "select rut_trab
			from sggeneral.trabajadores_tiene_laboral 
			where rut_trab = '".$rut."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	list($dia1,$mes1,$anio1) = explode('/', $data['OBLIfecha_nac']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
	
	$rut_trab =  $arr_rut[0];
	$cargo = $data['OBLIcargo'];
	$area = $data['OBLIarea'];
	$empresa = $data['OBLIempresa'];
	
	$fecha_ingreso = $data['OBLIfecha_ing'];
	list($dia1,$mes1,$anio1) = explode('/', $fecha_ingreso);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_ingreso              = date("Y-m-d",$nro_mes_anterior);
	
	$fecha_contrato = $data['OBLIfecha_cont'];
	list($dia1,$mes1,$anio1) = explode('/', $fecha_contrato);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_contrato              = date("Y-m-d",$nro_mes_anterior);
	
	$fecha_termino_contrato = $data['fecha_ter_cont'];
	list($dia1,$mes1,$anio1) = explode('/', $fecha_termino_contrato);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_termino_contrato              = date("Y-m-d",$nro_mes_anterior);
	
	$fecha_finiquito = $data['fecha_fin'];
	list($dia1,$mes1,$anio1) = explode('/', $fecha_finiquito);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_finiquito              = date("Y-m-d",$nro_mes_anterior);
	
	$causa_finiquito = $data['finiquito'];
	$estado_empleado = $data['est_emp'];
	$fecha_calculo_vacaciones = $data['OBLIcal_vac'];
	list($dia1,$mes1,$anio1) = explode('/', $fecha_calculo_vacaciones);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_calculo_vacaciones              = date("Y-m-d",$nro_mes_anterior);
	
	$tipo_pago_remuneraciones = $data['tipo_pr'];
	$nro_cuenta = $data['nro_cuenta'];
	$tipo_cuenta = $data['tipo_cuenta'];
	$banco = $data['banco'];
	$celular = $data['celular'];
	$auto = $data['auto'];
	$moto = $data['moto'];
	$asig_caja = $data['asig_caja'];
	$monto_asig_caja = $data['monto_asig_caja'];
	
	if ($fecha_termino_contrato!='') $set_ftc = " ,`fecha_termino_contrato` = '$fecha_termino_contrato' ";
	if ($fecha_finiquito) $set_f = " ,`fecha_finiquito` = '$fecha_finiquito' ";
							 
	if (mysql_num_rows($res)>0){
		//update
		$sql_update = "update sggeneral.trabajadores_tiene_laboral
						set  `rut_trab` = '$rut_trab',
							 `cargo` = '$cargo',
							 `area` = '$area',
							 `empresa` = '$empresa',
							 `fecha_ingreso` = '$fecha_ingreso',
							 `fecha_contrato` = '$fecha_contrato',
							 `causa_finiquito` = '$causa_finiquito',
							 `estado_empleado` = '$estado_empleado',
							 `fecha_calculo_vacaciones` = '$fecha_calculo_vacaciones',
							 `tipo_pago_remuneraciones` = '$tipo_pago_remuneraciones',
							 `nro_cuenta` = '$nro_cuenta',
							 `tipo_cuenta` = '$tipo_cuenta',
							 `banco` = '$banco',
							 `celular` = '$celular', 
							 `auto` = '$auto', 
							 `moto` = '$moto', 
							 `asig_caja` = '$asig_caja', 
							 `monto_asig_caja` = '$monto_asig_caja'
							 $set_ftc $set_f
						where rut_trab = '".$rut_trab."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
		$sql_update = "update sggeneral.trabajadores 
						set empresa_contr = '".$empresa."'
						where rut = '".$rut_trab."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
		
		}
	else{
		//insert
		$sql_insert = "insert into sggeneral.trabajadores_tiene_laboral (`rut_trab`, `cargo`, `area`, `empresa`, `fecha_ingreso`, `fecha_contrato`,
																		 `fecha_termino_contrato`, `fecha_finiquito`, `causa_finiquito`, `estado_empleado`, 
																		 `fecha_calculo_vacaciones`, `tipo_pago_remuneraciones`,
																		  `nro_cuenta`, `tipo_cuenta`, `banco`,`celular`, `auto`, `moto`, `asig_caja`, monto_asig_caja)
						values ('$rut_trab','$cargo','$area','$empresa','$fecha_ingreso','$fecha_contrato',
								'$fecha_termino_contrato','$fecha_finiquito','$causa_finiquito','$estado_empleado',
								'$fecha_calculo_vacaciones','$tipo_pago_remuneraciones','$nro_cuenta','$tipo_cuenta','$banco',
								'$celular','$auto','$moto','$asig_caja','$monto_asig_caja')
						";
		$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
		$sql_insert = "insert into sggeneral.trabajadores ( `rut`,empresa_contr)
					values ( '".$rut_trab."', '".$empresa."')";
		}
	$objResponse->addScript("alert('Registro Grabado Correctamente.')");
	$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIarea','sgrrhh.areas','','- - Seleccione - -','a_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIempresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'est_emp','sgrrhh.estado_empleado','','- - Seleccione - -','ee_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'tipo_pr','sgrrhh.tipo_remuneracion','','- - Seleccione - -','tr_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'tipo_cuenta','sgrrhh.tipo_cuentas','','- - Seleccione - -','tc_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'banco','sgyonley.bancos','','- - Seleccione - -','banc_ncorr','banc_desc', '')");
	return $objResponse->getXML();
} 
function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$tbl	=	"trabajadores";
	$bd		=	"sggeneral";
	
	// busca los campos de la tabla
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
	$res_c = mysql_query($sql_c, $conexion);
	$campos=""; 
			$arrRegistros = array();
	if (mysql_num_rows($res_c) > 0) {
		while ($line = mysql_fetch_array($res_c)) {
			$campos .= $line[0].",";
		}
		$largo_campos = strlen($campos);
		$campos = substr($campos,0,$largo_campos - 1);
		
		$sql = "select $campos from $bd.$tbl";
		if ($tbl=='trabajadores'){
			$sql = "select $campos from $bd.$tbl where rut > 50 order by  apellido_pat, apellido_mat, nombres";
			}
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			while ($line = mysql_fetch_row($res)) {
				if ($tbl == "trabajadores"){    
					$fxr='';
					if ($line[17]!=1){
						$fxr = 'NO';
						}
					else{
						$fxr = 'SI';
						}
					$vehiculos='';
					if ($line[18]!=1){
						$vehiculos = 'NO';
						}
					else{
						$vehiculos = 'SI';
						}
					$cuentas_personales='';
					if ($line[19]!=1){
						$cuentas_personales = 'NO';
						}
					else{
						$cuentas_personales = 'SI';
						}
					$ventas='';
					if ($line[20]!=1){
						$ventas = 'NO';
						}
					else{
						$ventas = 'SI';
						}
						
					$sql_ff = "select empe_desc
                               from sgyonley.empresas 
                               where empe_rut in (select empe_rut 
							   						from sggeneral.trabajadores_tienen_empresa
													where rut = '".$line[0]."')";
                    $res_ff = mysql_query($sql_ff, $conexion) or die(mysql_error());
					$empresas =  "";
                    while ($row_ff = mysql_fetch_array($res_ff)){
						$empresas .= $row_ff['empe_desc'].',';
						}
					
					$sql_001 = "select zona_desc
                               from sgyonley.zonas 
                               where zona_ncorr = '".$line[9]."'";
                    $res_001 = mysql_query($sql_001, $conexion);
                    $row_001 = mysql_fetch_array($res_001);
					
					$sql_ff = "select empe_desc
                               from sgyonley.empresas 
                               where empe_rut = '".$line[5]."'";
                    $res_ff = mysql_query($sql_ff, $conexion);
                    $row_ff = mysql_fetch_array($res_ff);
					/*
					select   nombres,apellidos,rut,empresa_contr,empresa,
							cod_vendedor,sector_vendedor,zona_vendedor,cod_cobrador
							,sector_cobrador,comision_cobrador,cod_supervisor,sector_supervisor,
							fondos_rendir,vehiculos,cuentas_personales,ventas,cargo 
							from sggeneral.trabajadores
					*/
					$rut = 	$line[4]; 
					
					$sql_obtener = "select * 
									from sgbodega.vendedores
									where VE_RUT = '".$rut."' and VE_RUT <> 0" ;
					$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
					$cod_vendedor = "";
					$comision_vendedor = "";
					$zona_vendedor = "";
					while ($row_obtener = mysql_fetch_array($res_obtener)){
						$cod_vendedor .= $row_obtener['VE_CODIGO'].',';
						$comision_vendedor .= $row_obtener['VE_COMISION'].',';
						$zona_vendedor .= $row_obtener['VE_ZONA'].',';
						}

					$sql_obtener = "select * 
									from sgyonley.cobrador
									where co_rut = '".$rut."' and co_rut <> 0";
					$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
					$cod_cobrador = "";
					$sector_cobrador ="";
					$comision_cobrador = "";
					while ($row_obtener = mysql_fetch_array($res_obtener)){
						$cod_cobrador .= $row_obtener['CO_CODIGO'].',';
						$sector_cobrador .= $row_obtener['CO_SECTOR'].',';
						$comision_cobrador .= $row_obtener['CO_COMISION'].',';
						$empresa_cobrador .= $row_obtener['CO_EMPRESA'].',';
						}
	
					$sql_obtener = "select * 
									from sgyonley.supervisor
									where sp_rut = '".$rut."' and sp_rut <> 0";
					$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
					$cod_supervisor = "";
					$sector_supervisor ="";
					$comision_supervisor = "";
					while ($row_obtener = mysql_fetch_array($res_obtener)){
						$cod_supervisor .= $row_obtener['sp_codigo'].',';
						$comision_supervisor .= $row_obtener['sp_comision'].',';
						}
					
					array_push($arrRegistros, array("ncorr"   	      	=>  $line[0], 
													"nombre"  	      	=> 	utf8_decode(str_replace('?','Ñ',$line[1])),
													"apellido_paterno"	=> 	utf8_decode(str_replace('?','Ñ',$line[2])),
													"apellido_materno"	=> 	utf8_decode(str_replace('?','Ñ',$line[3])),
													"rut"     			=> 	$line[4].'-'.dv($line[4]), 
													"empresa_contr" 	=> 	$row_ff['empe_desc'], 
													"empresa"      		=> 	$empresas, 
													"cod_vend"        	=> 	$cod_vendedor, 
													"zona_vend"        	=> 	$zona_vendedor, 
													"com_vend"        	=> 	$comision_vendedor, 
													"cod_cob"        	=> 	$cod_cobrador, 
													"com_cob"        	=> 	$comision_cobrador, 
													"cod_sup"        	=> 	$cod_supervisor, 
													"sect_sup"        	=> 	$sector_supervisor, 
													"com_sup"        	=> 	$comision_supervisor, 
													"fxr"        		=> 	$fxr, 
													"vehiculos"        	=> 	$vehiculos, 
													"cuentas_personales"=> 	$cuentas_personales, 
													"ventas"        	=> 	$ventas));
				}else{                                             
					array_push($arrRegistros, array("ncorr" => $line[0], "desc"	=> 	$line[1]));
				}
			}
		}	
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_ficha_laboral_list.tpl'));
	
	}
	
	return $objResponse->getXML();
}
function TraeValor($data, $ncorr){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$sql_0 = "select sggeneral.trabajadores.rut, nombres,apellido_pat,apellido_mat
				 			from sggeneral.trabajadores 
							where  sggeneral.trabajadores.trabajador_ncorr = '".$ncorr."'";
	$res_0 = mysql_query($sql_0,$conexion) or die(mysql_error());
	$row_0 = mysql_fetch_array($res_0);
	$objResponse->addAssign("OBLIape_mat", "value", $row_0['apellido_mat']);
	$objResponse->addAssign("OBLIape_pat", "value", $row_0['apellido_pat']);
	$objResponse->addAssign("OBLInombres", "value", $row_0['nombres']);
	$objResponse->addAssign("OBLIrut", "value", $row_0['rut'].'-'.dv($row_0['rut']));
	$sql = "SELECT  `cargo`, `area`, `empresa`, `fecha_ingreso`, `fecha_contrato`, `fecha_termino_contrato`, 
					`fecha_finiquito`, `causa_finiquito`, `estado_empleado`, `fecha_calculo_vacaciones`, 
					`asignacion_materiales`, `tipo_pago_remuneraciones`, `nro_cuenta`, `tipo_cuenta`, `banco`,
					`celular`, `auto`, `moto`, `asig_caja` , monto_asig_caja
			FROM sggeneral	.trabajadores_tiene_laboral
			where rut_trab in (select sggeneral.trabajadores.rut  
				 			from sggeneral.trabajadores 
							where  sggeneral.trabajadores.trabajador_ncorr = '".$ncorr."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addAssign("OBLIcargo", "value", '');
	$objResponse->addAssign("OBLIarea", "value", '');
	$objResponse->addAssign("OBLIempresa", "value", '');
	$objResponse->addAssign("OBLIfecha_ing", "value", '');
	$objResponse->addAssign("OBLIfecha_cont", "value", '');
	$objResponse->addAssign("fecha_ter_cont", "value", '');
	$objResponse->addAssign("fecha_fin", "value", '');
	$objResponse->addAssign("finiquito", "value", '');
	$objResponse->addAssign("est_emp", "value", '');
	$objResponse->addAssign("OBLIcal_vac", "value", '');
	$objResponse->addAssign("OBLInacionalidad", "value", '');
	$objResponse->addAssign("tipo_pr", "value", '');
	$objResponse->addAssign("nro_cuenta", "value", '');
	$objResponse->addAssign("tipo_cuenta", "value", '');
	$objResponse->addAssign("banco", "value", '');
	$objResponse->addAssign("celular", "checked", '');
	$objResponse->addAssign("auto","checked", '');
	$objResponse->addAssign("moto","checked", '');
	$objResponse->addAssign("asig_caja","checked", '');
	$objResponse->addAssign("monto_asig_caja","value", '');
	
	while($row = mysql_fetch_array($res)){
		$objResponse->addAssign("OBLIcargo", "value", $row['cargo']);
		$objResponse->addAssign("OBLIarea", "value", $row['area']);
		$objResponse->addAssign("OBLIempresa", "value", $row['empresa']);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_ingreso']);
			$fecha_inicio              = $dia1.'/'.$mes1.'/'.$anio1;
		$objResponse->addAssign("OBLIfecha_ing", "value", $fecha_inicio	);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_contrato']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
			$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
		$objResponse->addAssign("OBLIfecha_cont", "value", $fecha_inicio);
		
		if (($row['fecha_termino_contrato']!='1969-12-31')){
			list($anio1,$mes1,$dia1) = explode('-', $row['fecha_termino_contrato']);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
				$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
			$objResponse->addAssign("fecha_ter_cont", "value", $fecha_inicio);	
			}
		else{
			$objResponse->addAssign("fecha_ter_cont", "value",'');	
			}
		
		if (($row['fecha_finiquito']!='1969-12-31')){
			list($anio1,$mes1,$dia1) = explode('-', $row['fecha_finiquito']);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
				$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
			$objResponse->addAssign("fecha_fin", "value", $fecha_inicio);	
		}else{
			$objResponse->addAssign("fecha_fin", "value", '');	
			}
		
		$objResponse->addAssign("finiquito", "value", $row['causa_finiquito']);	
		$objResponse->addAssign("est_emp", "value", $row['estado_empleado']);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_calculo_vacaciones']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
			$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
		$objResponse->addAssign("OBLIcal_vac", "value", $fecha_inicio);	
		
		$fecha_inicio = $row['fecha_calculo_vacaciones'];
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_calculo_vacaciones']);
		$fecha_actual = date("Y-m-d");
		list($anio2,$mes2,$dia2) = explode('-', $fecha_actual);
		if ($anio2-$anio1 > 1) $anio2 = $anio1+1;
		
		$fechainicial = new DateTime($anio1.'-'.$mes1.'-'.$dia1);
		$fechafinal = new DateTime($anio2.'-'.$mes2.'-'.$dia2);

		$diferencia = $fechainicial->diff($fechafinal);
		$meses = ( $diferencia->y * 12 ) + $diferencia->m;
		$dias	=	$diferencia->d % $meses;
		
		$total = 1.25 * $meses;
		$total = $total + (0.04167*$dias);
		
		$objResponse->addAssign("OBLIdias_vacas", "value", $total);
		
		$objResponse->addAssign("celular", "value", $row['celular']);
		if ( $row['celular'] == 'on' ){
			$objResponse->addAssign("celular", "checked", 'checked');
			}
		$objResponse->addAssign("auto", "value", $row['auto']);
		if ( $row['auto'] == 'on' ){
			$objResponse->addAssign("auto","checked", 'checked');
			}
		$objResponse->addAssign("moto", "value", $row['moto']);
		if ( $row['moto'] == 'on' ){
			$objResponse->addAssign("moto","checked", 'checked');
			}
		$objResponse->addAssign("asig_caja", "value", $row['asig_caja']);
		if ( $row['asig_caja'] == 'on' ){
			$objResponse->addAssign("asig_caja","checked", 'checked');
			}
		
		$objResponse->addAssign("monto_asig_caja", "value", $row['monto_asig_caja']);
		$objResponse->addAssign("tipo_pr", "value", $row['tipo_pago_remuneraciones']);
		
		$objResponse->addAssign("nro_cuenta", "value", $row['nro_cuenta']);
		$objResponse->addAssign("tipo_cuenta", "value", $row['tipo_cuenta']);
		$objResponse->addAssign("banco", "value", $row['banco']);
		
		}
	
	return $objResponse->getXML();
	}
function MantCargas($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = explode('-',$data['OBLIrut']);
	$rut_1 = $rut[0];
	$objResponse->addScript("showPopWin('sg_mant_tablas.php?tbl=trabajadores_tienen_cargas&rut=".$rut_1."', 'Mantenedor Cargas Familiares', 800, 600, null);");

	return $objResponse->getXML();
	}
function Actualizar($data){
	global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$rut_papa = $data['OBLIrut'];
	$sql = "select count(rut_papa) as cantidad
			from sggeneral.trabajadores_tienen_cargas
				where rut_papa = '".$rut_papa."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
	
	$objResponse->addAssign('OBLItotal_cargas','value',$row['cantidad']);

	return $objResponse->getXML();
	}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0) {
            $j = 0;
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
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("MantCargas");
$xajax->registerFunction("Actualizar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_ficha_laboral.tpl');

?>

