<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ficha_previsional.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data['OBLIrut'];
	
	$arr_rut = explode('-',$rut);
	$rut = $arr_rut[0];
	
	$sql = "select rut_trab
			from sggeneral.trabajadores_tiene_prevision 
			where rut_trab = '".$rut."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	list($dia1,$mes1,$anio1) = explode('/', $data['OBLIfecha_nac']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
	
	$rut_trab =  $arr_rut[0];
	$afp =  $data['OBLIAfp'];
	$porc_cotizacion =  $data['OBLIporc_cot'];
	$porc_adicional =  $data['porc_cot_adi'];
	$monto_cotizacion = $data['monto_cot_vol'];
	$tipo_monto_cotizacion =  $data['OBLItipo_monto_cot_vol'];
	$salud =  $data['OBLIsalud'];
	$plan =  $data['OBLImonto_salud'];
	$tipo_plan =  $data['OBLItipo_monto_salud'];
	$caja_compensacion =  $data['OBLIcaja_compensacion'];
	$ahorro_vol =  $data['ahorro_vol'];
	$plan_uf =  $data['plan_uf'];
	$plan_pesos =  $data['plan_pesos'];
	$seguro_cesantia =  $data['seguro_cesantia'];
	
	if (mysql_num_rows($res)>0){
		//update
		$sql_update = "update sggeneral.trabajadores_tiene_prevision
						set  `rut_trab` = '$rut_trab',
							 afp = '$afp',
							 porc_cotizacion = '$porc_cotizacion',
							 porc_adicional = '$porc_adicional',
							 monto_cotizacion = '$monto_cotizacion',
							 tipo_monto_cotizacion = '$tipo_monto_cotizacion',
							 salud = '$salud',
							 plan = '$plan',
							 tipo_plan = '$tipo_plan',
							 caja_compensacion = '$caja_compensacion',
							 ahorro_vol = '$ahorro_vol',
							 plan_uf = '$plan_uf',
							 plan_pesos = '$plan_pesos',
							 seguro_cesantia = '$seguro_cesantia'
						where rut_trab = '".$rut_trab."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
		}
	else{
		//insert
		$sql_insert = "insert into sggeneral.trabajadores_tiene_prevision (`rut_trab`, `afp`, `porc_cotizacion`, `porc_adicional`, `monto_cotizacion`,
																		 `tipo_monto_cotizacion`, `salud`, `plan`,
																		  `tipo_plan`, `caja_compensacion`,ahorro_vol,plan_uf, plan_pesos, seguro_cesantia)
						values ('$rut_trab','$afp','$porc_cotizacion','$porc_adicional','$monto_cotizacion',
								'$tipo_monto_cotizacion','$salud','$plan','$tipo_plan','$caja_compensacion',
								'$ahorro_vol','$plan_uf','$plan_pesos','$seguro_cesantia')
						";
		$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
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
	$sql = "SELECT  `afp`, `porc_cotizacion`, `porc_adicional`, `monto_cotizacion`, `tipo_monto_cotizacion`, `salud`, `plan`, 
					`tipo_plan`, `caja_compensacion` ,ahorro_vol,plan_uf,plan_pesos,seguro_cesantia
			FROM sggeneral.trabajadores_tiene_prevision
			where rut_trab in (select sggeneral.trabajadores.rut  
				 			from sggeneral.trabajadores 
							where  sggeneral.trabajadores.trabajador_ncorr = '".$ncorr."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addAssign("OBLIAfp", "value", '');
	$objResponse->addAssign("OBLIporc_cot", "value", '');
	$objResponse->addAssign("porc_cot_adi", "value", '');
	$objResponse->addAssign("monto_cot_vol", "value", '');
	$objResponse->addAssign("OBLItipo_monto_cot_vol", "value", '');
	$objResponse->addAssign("OBLIsalud", "value", '');
	$objResponse->addAssign("OBLImonto_salud", "value", '');
	$objResponse->addAssign("OBLItipo_monto_salud", "value", '');
	$objResponse->addAssign("OBLIcaja_compensacion", "value", '');
	$objResponse->addAssign("ahorro_vol", "value", '');
	$objResponse->addAssign("plan_uf", "value", '');
	$objResponse->addAssign("plan_pesos", "value", '');
	$objResponse->addAssign("seguro_cesantia", "value", '');
	
	while($row = mysql_fetch_array($res)){
		$objResponse->addAssign("OBLIAfp", "value", $row['afp']);
		$objResponse->addAssign("OBLIporc_cot", "value", $row['porc_cotizacion']);
		$objResponse->addAssign("porc_cot_adi", "value", $row['porc_adicional']);
		$objResponse->addAssign("monto_cot_vol", "value", $row['monto_cotizacion']);
		$objResponse->addAssign("OBLItipo_monto_cot_vol", "value", $row['tipo_monto_cotizacion']);
		$objResponse->addAssign("OBLIsalud", "value", $row['salud']);
		$objResponse->addAssign("OBLImonto_salud", "value", $row['plan']);
		$objResponse->addAssign("OBLItipo_monto_salud", "value", $row['tipo_plan']);
		$objResponse->addAssign("OBLIcaja_compensacion", "value", $row['caja_compensacion']);
		$objResponse->addAssign("ahorro_vol", "value", $row['ahorro_vol']);
		$objResponse->addAssign("plan_uf", "value", $row['plan_uf']);
		$objResponse->addAssign("plan_pesos", "value", $row['plan_pesos']);
		$objResponse->addAssign("seguro_cesantia", "value", $row['seguro_cesantia']);
		
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

$miSmarty->display('sg_ficha_previsional.tpl');

?>

