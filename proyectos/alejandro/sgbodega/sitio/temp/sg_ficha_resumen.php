<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ficha_resumen.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();


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
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAfp','sgrrhh.afp','','- - Seleccione - -','afp_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItipo_monto_cot_vol','sgrrhh.tipo_pago','','- - Seleccione - -','tp_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItipo_monto_salud','sgrrhh.tipo_pago','','- - Seleccione - -','tp_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcaja_compensacion','sgrrhh.caja_compensacion','','- - Seleccione - -','cc_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIsalud','sgrrhh.salud','','- - Seleccione - -','salud_ncorr','nombre', '')");
	
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
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_ficha_previsional_list.tpl'));
	
	}
	
	return $objResponse->getXML();
}
function Grabar($data, $ncorr){
    
	global $conexion;
	global $miSmarty;
	
	$rut = $data['txtCodCobrador'];
	
    $objResponse = new xajaxResponse('ISO-8859-1');

	$sql_0 = "select sggeneral.trabajadores.rut, nombres,apellido_pat,apellido_mat
				 			from sggeneral.trabajadores 
							where  sggeneral.trabajadores.rut = '".$rut."'";
	$res_0 = mysql_query($sql_0,$conexion) or die(mysql_error());
	$row_0 = mysql_fetch_array($res_0);
	$objResponse->addAssign("OBLIape_mat", "innerHTML",  $row_0['apellido_pat'].' '.$row_0['apellido_mat']);
	$objResponse->addAssign("OBLInombres", "innerHTML", $row_0['nombres']);
	$objResponse->addAssign("OBLIrut", "innerHTML", $row_0['rut'].'-'.dv($row_0['rut']));
	$sql = "SELECT  `afp`, `porc_cotizacion`, `porc_adicional`, `monto_cotizacion`, `tipo_monto_cotizacion`, `salud`, `plan`, 
					`tipo_plan`, `caja_compensacion` ,ahorro_vol,plan_uf,plan_pesos,seguro_cesantia
			FROM sggeneral.trabajadores_tiene_prevision
			where rut_trab in ( '".$rut."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addAssign("OBLIAfp", "innerHTML", '');
	$objResponse->addAssign("OBLIporc_cot", "innerHTML", '');
	$objResponse->addAssign("OBLIporc_cot_adi", "innerHTML", '');
	$objResponse->addAssign("OBLImonto_cot_vol", "innerHTML", '');
	$objResponse->addAssign("OBLItipo_monto_cot_vol", "innerHTML", '');
	$objResponse->addAssign("OBLIsalud", "innerHTML", '');
	$objResponse->addAssign("OBLImonto_salud", "innerHTML", '');
	$objResponse->addAssign("OBLItipo_monto_salud", "innerHTML", '');
	$objResponse->addAssign("OBLIcaja_compensacion", "innerHTML", '');
	$objResponse->addAssign("ahorro_vol", "innerHTML", '');
	$objResponse->addAssign("plan_uf", "innerHTML", '');
	$objResponse->addAssign("plan_pesos", "innerHTML", '');
	$objResponse->addAssign("seguro_cesantia", "innerHTML", '');
	
	while($row = mysql_fetch_array($res)){
		
		$sql_22 = "select nombre 
					from sgrrhh.afp
					where afp_ncorr = ".$row['afp'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['nombre'];
		$objResponse->addAssign("OBLIAfp", "innerHTML", $nombre_area);
		$objResponse->addAssign("OBLIporc_cot", "innerHTML", $row['porc_cotizacion']);
		$objResponse->addAssign("OBLIporc_cot_adi", "innerHTML", $row['porc_adicional']);
		$objResponse->addAssign("OBLImonto_cot_vol", "innerHTML", $row['monto_cotizacion']);
		$objResponse->addAssign("OBLItipo_monto_cot_vol", "innerHTML", $row['tipo_monto_cotizacion']);
		$sql_22 = "select nombre 
					from sgrrhh.salud
					where salud_ncorr = ".$row['salud'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['nombre'];
		$objResponse->addAssign("OBLIsalud", "innerHTML", $nombre_area);
		$objResponse->addAssign("OBLImonto_salud", "innerHTML", $row['plan']);
		$objResponse->addAssign("OBLItipo_monto_salud", "innerHTML", $row['tipo_plan']);
		$sql_22 = "select nombre 
					from sgrrhh.caja_compensacion
					where cc_ncorr = ".$row['caja_compensacion'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['nombre'];
		$objResponse->addAssign("OBLIcaja_compensacion", "innerHTML", $nombre_area);
		$objResponse->addAssign("ahorro_vol", "innerHTML", $row['ahorro_vol']);
		$objResponse->addAssign("plan_uf", "innerHTML", $row['plan_uf']);
		$objResponse->addAssign("plan_pesos", "innerHTML", $row['plan_pesos']);
		$objResponse->addAssign("seguro_cesantia", "innerHTML", $row['seguro_cesantia']);
		
		}
	
	$sql = "SELECT  `cargo`, `area`, `empresa`, `fecha_ingreso`, `fecha_contrato`, `fecha_termino_contrato`, 
					`fecha_finiquito`, `causa_finiquito`, `estado_empleado`, `fecha_calculo_vacaciones`, 
					`asignacion_materiales`, `tipo_pago_remuneraciones`, `nro_cuenta`, `tipo_cuenta`, `banco`,
					`celular`, `auto`, `moto`, `asig_caja`, monto_asig_caja
			FROM sggeneral	.trabajadores_tiene_laboral
			where rut_trab in ( '".$rut."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addAssign("OBLIcargo", "innerHTML", '');
	$objResponse->addAssign("OBLIarea", "innerHTML", '');
	$objResponse->addAssign("OBLIempresa", "innerHTML", '');
	$objResponse->addAssign("OBLIfecha_ing", "innerHTML", '');
	$objResponse->addAssign("OBLIfecha_cont", "innerHTML", '');
	$objResponse->addAssign("fecha_ter_cont", "innerHTML", '');
	$objResponse->addAssign("fecha_fin", "innerHTML", '');
	$objResponse->addAssign("OBLIfiniquito", "innerHTML", '');
	$objResponse->addAssign("est_emp", "innerHTML", '');
	$objResponse->addAssign("OBLIcal_vac", "innerHTML", '');
	$objResponse->addAssign("OBLInacionalidad", "innerHTML", '');
	$objResponse->addAssign("tipo_pr", "innerHTML", '');
	$objResponse->addAssign("nro_cuenta", "innerHTML", '');
	$objResponse->addAssign("tipo_cuenta", "innerHTML", '');
	$objResponse->addAssign("banco", "innerHTML", '');
	$objResponse->addAssign("celular", "checked", '');
	$objResponse->addAssign("auto","checked", '');
	$objResponse->addAssign("moto","checked", '');
	$objResponse->addAssign("asig_caja","checked", '');
	$objResponse->addAssign("monto_asig_caja","innerHTML", '');
	
	while($row = mysql_fetch_array($res)){
		$objResponse->addAssign("OBLIcargo", "innerHTML", $row['cargo']);
		
		$sql_22 = "select nombre 
					from sgrrhh.areas
					where a_ncorr = ".$row['area'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['nombre'];
		$objResponse->addAssign("OBLIarea", "innerHTML", $nombre_area);
		
		$sql_22 = "select empe_desc 
					from sgyonley.empresas
					where empe_rut = ".$row['empresa'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['empe_desc'];
		$objResponse->addAssign("OBLIempresa", "innerHTML", $nombre_area);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_ingreso']);
			$fecha_inicio              = $dia1.'/'.$mes1.'/'.$anio1;
		$objResponse->addAssign("OBLIfecha_ing", "innerHTML", $fecha_inicio	);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_contrato']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
			$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
		$objResponse->addAssign("OBLIfecha_cont", "innerHTML", $fecha_inicio);
		if (($row['fecha_termino_contrato']!='1969-12-31')){
			list($anio1,$mes1,$dia1) = explode('-', $row['fecha_termino_contrato']);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
				$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
			$objResponse->addAssign("fecha_ter_cont", "innerHTML", $fecha_inicio);	
			}
		else{
			$objResponse->addAssign("fecha_ter_cont", "innerHTML",'');	
			}
		
		if (($row['fecha_finiquito']!='1969-12-31')){
			list($anio1,$mes1,$dia1) = explode('-', $row['fecha_finiquito']);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
				$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
			$objResponse->addAssign("fecha_fin", "innerHTML", $fecha_inicio);	
		}else{
			$objResponse->addAssign("fecha_fin", "innerHTML", '');	
			}
		
		$objResponse->addAssign("OBLIfiniquito", "innerHTML", $row['causa_finiquito']);	
		
		$sql_22 = "select nombre 
					from sgrrhh.estado_empleado
					where ee_ncorr = ".$row['estado_empleado'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['nombre'];
		$objResponse->addAssign("est_emp", "innerHTML", $nombre_area);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_calculo_vacaciones']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
			$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
		$objResponse->addAssign("OBLIcal_vac", "innerHTML", $fecha_inicio);	
		
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
		
		$objResponse->addAssign("OBLIdias_vacas", "innerHTML", $total);
		$asignacion="";
		if ( $row['celular'] == 'on' ){
			$asignacion .= "Celular - ";
			}
		if ( $row['auto'] == 'on' ){
			$asignacion .= "Auto - ";
			}
		if ( $row['moto'] == 'on' ){
			$asignacion .= "Moto - ";
			}
		if ( $row['asig_caja'] == 'on' ){
			$asignacion .= "Asig. Caja - ";
			}
		$objResponse->addAssign("OBLIasignacion", "innerHTML", $asignacion);
		$objResponse->addAssign("monto_asig_caja","innerHTML", $row['monto_asig_caja']);
	
		$sql_22 = "select nombre 
					from sgrrhh.tipo_remuneracion
					where tr_ncorr = ".$row['tipo_pago_remuneraciones'];
		$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
		$row_22 = mysql_fetch_array($res_22);
		$nombre_area = $row_22['nombre'];
		$objResponse->addAssign("tipo_pr", "innerHTML", $nombre_area);
		
		}
	$sql = "select  `sexo`, `direccion`, `ciudad`, `telefono`, `celular`, 
					`fecha_nac`, `nacionalidad`, `estado_civil`, `profesion`, 
					`estudios`, `contacto_emergencia`, `fono_emergencia` 
			from sggeneral.trabajadores 
			where rut in ('".$rut."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	while($row = mysql_fetch_array($res)){
		
		$row['sexo']==2 ? $sexo = 'Femenino' : $sexo = 'Masculino' ; 
		$objResponse->addAssign("sexo", "innerHTML", $sexo);
		$objResponse->addAssign("OBLIdireccion", "innerHTML", $row['direccion']);
		$objResponse->addAssign("OBLIciudad", "innerHTML", $row['ciudad']);
		$objResponse->addAssign("OBLItelefono", "innerHTML", $row['telefono']);
		$objResponse->addAssign("OBLIcelular", "innerHTML", $row['celular']);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_nac']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
			$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
	
				$objResponse->addAssign("OBLIfecha_nac", "innerHTML", $fecha_inicio	);

		list($ano,$mes,$dia) = explode("-",$row['fecha_nac']);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($ano_diferencia > 0)
			if ($dia_diferencia < 0 || $mes_diferencia < 0)
				$ano_diferencia--;
		$edad =  $ano_diferencia+1;

		$objResponse->addAssign("OBLIedad", "innerHTML", $edad);
		
		$objResponse->addAssign("OBLInacionalidad", "innerHTML", $row['nacionalidad']);
		
		if ($row['estado_civil'] == '1'){
			$estado_civil = 'Soltero';
		}elseif ($row['estado_civil'] == '2'){
			$estado_civil = 'Casado'; 
		}elseif($row['estado_civil'] == '3'){
			$estado_civil = 'Viudo';
		}else{
			$estado_civil = 'Divorciado';
			}
		$objResponse->addAssign("OBLIestado_civil", "innerHTML", $estado_civil);
		$objResponse->addAssign("OBLIprofesion", "innerHTML", $row['profesion']);
		$objResponse->addAssign("OBLIestudios", "innerHTML", $row['estudios']);
		$objResponse->addAssign("OBLIcont_eme", "innerHTML", $row['contacto_emergencia']);
		$objResponse->addAssign("OBLIfono_eme", "innerHTML", $row['fono_emergencia']);
		
		$rut_papa = $row_0['rut'];
		$sql = "select count(rut_papa) as cantidad
				from sggeneral.trabajadores_tienen_cargas
					where rut_papa = '".$rut_papa."'";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		$row = mysql_fetch_array($res);
		
		$objResponse->addAssign('OBLItotal_cargas','innerHTML',$row['cantidad']);
		
		$sql = "select rut_carga,	nombres,ape_pat ,ape_mat ,fecha_nac ,parentesco , estado
				from sggeneral.trabajadores_tienen_cargas
					where rut_papa = '".$rut_papa."'";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		$arrRegistros = array();
		while ($row = mysql_fetch_array($res)){	
		
			$sql_parentesco = "select nombre
										from parentesco
										where p_ncorr = ".$row['parentesco'];     
			$res_parentesco = mysql_query($sql_parentesco,$conexion);                                      
			$row_parentesco = mysql_fetch_array($res_parentesco);
			$parentesco = $row_parentesco['nombre'];
			
			$sql_estado = "select nombre
										from estado
										where e_ncorr = ".$row['estado'];     
			$res_estado = mysql_query($sql_estado,$conexion);                                      
			$row_estado = mysql_fetch_array($res_estado);
			$estado = $row_estado['nombre'];
					
			array_push($arrRegistros, array("rut" 				=> $row['rut_carga'] ,
											"nombre"			=> $row['nombres'] ,
											"apellido_paterno" 	=> $row['ape_pat'] ,
											"apellido_materno" 	=> $row['ape_mat'] ,
											"fec_nac"			=> $row['fecha_nac'] ,
											"parentesco" 		=> $parentesco,
											"estado" 			=> $estado));
			}
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_ficha_resumen_list.tpl'));			
		
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
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("MantCargas");
$xajax->registerFunction("Actualizar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_ficha_resumen.tpl');

?>

