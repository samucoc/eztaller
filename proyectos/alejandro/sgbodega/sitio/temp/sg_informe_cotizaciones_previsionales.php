<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/uf.php"; 
include "../../sgyonley/includes/php/validaciones.php";
$xajax = new xajax();

$xajax->setRequestURI("sg_informe_cotizaciones_previsionales.php");
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
	
	$empresa = $data['txtCodCobrador'];
	
	$objResponse = new xajaxResponse('ISO-8859-1');

	$sql = "SELECT  rut_trab
			FROM sggeneral.trabajadores_tiene_laboral
			where  empresa = '".$empresa."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	while ($row = mysql_fetch_array($res)){
	
		$sql_0 = "select sggeneral.trabajadores.rut, nombres,apellido_pat,apellido_mat
								from sggeneral.trabajadores 
								where  sggeneral.trabajadores.rut in ('".$row['rut_trab']."')";
		$res_0 = mysql_query($sql_0,$conexion) or die(mysql_error());
		$row_0 = mysql_fetch_array($res_0);
		$objResponse->addAssign("trabajador", "innerHTML",  $row_0['nombres'].' '.$row_0['apellido_pat'].' '.$row_0['apellido_mat']);
		$objResponse->addAssign("rut_trab", "innerHTML", $row_0['rut'].'-'.dv($row_0['rut']));
		
		$sql = "SELECT  `porc_cotizacion`, `porc_adicional`, `afp`, plan, seguro_cesantia, salud
				FROM sggeneral.trabajadores_tiene_prevision
				where rut_trab in ('".$row['rut_trab']."')";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		$row = mysql_fetch_array($res);
			
		$sql_afp = "select nombre from sgrrhh.afp where afp_ncorr = '".$row['afp']."'";
		$res_afp = mysql_query($sql_afp,$conexion) or die(mysql_error());
		$row_afp = mysql_fetch_array($res_afp);
		$objResponse->addAssign("nombre_afp", "innerHTML", $row_afp['nombre']);
		$objResponse->addAssign("porc_cotizacion_afp", "value", $row['porc_cotizacion']);
		$objResponse->addAssign("porc_adicional_afp", "value", $row['porc_adicional']);
		
		$sql_afp = "select nombre from sgrrhh.salud where salud_ncorr = '".$row['salud']."'";
		$res_afp = mysql_query($sql_afp,$conexion) or die(mysql_error());
		$row_afp = mysql_fetch_array($res_afp);
		$objResponse->addAssign("nombre_fonasa", "innerHTML", $row_afp['nombre']);
		$objResponse->addAssign("plan_fonasa", "value", $row['plan']);
		
		$objResponse->addAssign("hidden_sc", "value", $row['seguro_cesantia']);
		
		//cuentas personales - prestamos
		$sql_pve = "select COALESCE(sum(ccu_monto_pago),0) as total_pie_vendedor 
						from  yonleycp.cuentas_cuotas
							inner join yonleycp.cuentas
								on 	yonleycp.cuentas_cuotas.cue_ncorr = yonleycp.cuentas.cue_ncorr
					where 
					tra_ncorr in ( select tra_ncorr from yonleycp.trabajadores where tra_rut = '".$rut."' )  and
					ccu_fecha_pago between '".$fecha_inicio."' and '".$fecha_fin."' and
					tpro_ncorr	 = '1' ";
						
		$res_pve = mysql_query($sql_pve,$conexion) or die(mysql_error());
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
		$objResponse->addAssign("prestamos", "innerHTML", $total_pie_vendedor);
		
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

$miSmarty->display('sg_informe_cotizaciones_previsionales.tpl');

?>

