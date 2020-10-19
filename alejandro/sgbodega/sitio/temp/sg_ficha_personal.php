<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ficha_personal.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data['OBLIrut'];
	
	$arr_rut = explode('-',$rut);
	$rut = $arr_rut[0];
	
	$sql = "select  rut
			from sggeneral.trabajadores 
			where rut = '".$rut."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	list($dia1,$mes1,$anio1) = explode('/', $data['OBLIfecha_nac']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
			$fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
	
	if (mysql_num_rows($res)>0){
		//update
		$sql_update = "update sggeneral.trabajadores 
						set nombres = '".$data['OBLInombres']."',
							apellido_pat = '".$data['OBLIape_pat']."',
							apellido_mat = '".$data['OBLIape_mat']."',
							sexo = '".$data['OBLIsexo']."',
							direccion = '".$data['OBLIdireccion']."',
							ciudad = '".$data['OBLIciudad']."',
							telefono = '".$data['OBLItelefono']."',
							celular = '".$data['OBLIcelular']."',
							fecha_nac = '".$fecha_inicio."',
							nacionalidad = '".$data['OBLInacionalidad']."',
							estado_civil = '".$data['OBLIestado_civil']."',
							profesion = '".$data['OBLIprofesion']."',
							estudios = '".$data['OBLIestudios']."',
							contacto_emergencia = '".$data['OBLIcont_eme']."',
							fono_emergencia = '".$data['OBLIfono_eme']."'
						where rut = '".$rut."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
		}
	else{
		//insert
		$sql_insert = "insert into sggeneral.trabajadores ( `rut`, `sexo`, `direccion`, `ciudad`, `telefono`, `celular`, `fecha_nac`, `nacionalidad`, `estado_civil`, `profesion`, `estudios`, `contacto_emergencia`, `fono_emergencia`)
						values ('".$rut."','".$data['OBLIsexo']."', '".$data['OBLIdireccion']."','".$data['OBLIciudad']."','".$data['OBLItelefono']."',
								'".$data['OBLIcelular']."',	'".$fecha_inicio."', '".$data['OBLInacionalidad']."', '".$data['OBLIestado_civil']."',
								'".$data['OBLIprofesion']."', '".$data['OBLIestudios']."', '".$data['OBLIcont_eme']."', '".$data['OBLIfono_eme']."')
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
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_ficha_personal_list.tpl'));
	
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
	$sql = "select  `sexo`, `direccion`, `ciudad`, `telefono`, `celular`, 
					`fecha_nac`, `nacionalidad`, `estado_civil`, `profesion`, 
					`estudios`, `contacto_emergencia`, `fono_emergencia` 
			from sggeneral.trabajadores 
			where rut in (select sggeneral.trabajadores.rut  
				 			from sggeneral.trabajadores 
							where  sggeneral.trabajadores.trabajador_ncorr = '".$ncorr."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	while($row = mysql_fetch_array($res)){
		$objResponse->addAssign("OBLIsexo", "value", $row['sexo']);
		$objResponse->addAssign("OBLIdireccion", "value", $row['direccion']);
		$objResponse->addAssign("OBLIciudad", "value", $row['ciudad']);
		$objResponse->addAssign("OBLItelefono", "value", $row['telefono']);
		$objResponse->addAssign("OBLIcelular", "value", $row['celular']);
		
		list($anio1,$mes1,$dia1) = explode('-', $row['fecha_nac']);
			$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,  $anio1);
			$fecha_inicio              = date("d/m/Y",$nro_mes_anterior);
	
		
		$objResponse->addAssign("OBLIfecha_nac", "value", $fecha_inicio	);

		list($ano,$mes,$dia) = explode("-",$row['fecha_nac']);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($ano_diferencia > 0)
			if ($dia_diferencia < 0 || $mes_diferencia < 0)
				$ano_diferencia--;
		$edad =  $ano_diferencia+1;

		$objResponse->addAssign("OBLIedad", "value", $edad);
		
		$objResponse->addAssign("OBLInacionalidad", "value", $row['nacionalidad']);
		$objResponse->addAssign("OBLIestado_civil", "value", $row['estado_civil']);
		$objResponse->addAssign("OBLIprofesion", "value", $row['profesion']);
		$objResponse->addAssign("OBLIestudios", "value", $row['estudios']);
		$objResponse->addAssign("OBLIcont_eme", "value", $row['contacto_emergencia']);
		$objResponse->addAssign("OBLIfono_eme", "value", $row['fono_emergencia']);
		$rut_papa = $row_0['rut'];
		$sql = "select count(rut_papa) as cantidad
				from sggeneral.trabajadores_tienen_cargas
					where rut_papa = '".$rut_papa."'";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		$row = mysql_fetch_array($res);
		
		$objResponse->addAssign('OBLItotal_cargas','value',$row['cantidad']);

		
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
function EliminarItem($data,$ncorr){
	global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$sql = "delete from sggeneral.trabajadores
				where trabajador_ncorr	 = '".$ncorr."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
	$objResponse->addScript("alert('Registro Eliminado Correctamente.')");
	$objResponse->addScript("document.Form1.submit();");
	return $objResponse->getXML();
	}	
	
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("MantCargas");
$xajax->registerFunction("Actualizar");
$xajax->registerFunction("EliminarItem");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_ficha_personal.tpl');

?>

