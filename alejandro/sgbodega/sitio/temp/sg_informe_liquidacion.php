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

$xajax->setRequestURI("sg_informe_liquidacion.php");
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

	$sql = "SELECT  `empresa`, `fecha_contrato`
			FROM sggeneral.trabajadores_tiene_laboral
			where rut_trab in ('".$rut."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
	
	$sql_22 = "select empe_desc 
					from sgyonley.empresas
					where empe_rut = ".$row['empresa'];
	$res_22 = mysql_query($sql_22,$conexion) or die(mysql_error());
	$row_22 = mysql_fetch_array($res_22);
	$nombre_area = $row_22['empe_desc'];
	$objResponse->addAssign("empresa", "innerHTML", $nombre_area);
	$objResponse->addAssign("nombre_empresa", "innerHTML", $nombre_area);
	$objResponse->addAssign("rutEmpresa", "innerHTML", $row['empresa'].'-'.dv($row['empresa']));
		
	list($anio1,$mes1,$dia1) = explode('-', date("Y-m-d"));
		$fecha_inicio              = $dia1.'/'.$mes1.'/'.$anio1;
	$objResponse->addAssign("fecha_emision", "innerHTML", $fecha_inicio	);
	
	switch($mes1){
		case '1' : $mes1 = "Enero";
					break;
		case '2' : $mes1 = "Febrero";
					break;
		case '3' : $mes1 = "Marzo";
					break;
		case '4' : $mes1 = "Abril";
					break;
		case '5' : $mes1 = "Mayo";
					break;
		case '6' : $mes1 = "Junio";
					break;
		case '7' : $mes1 = "Julio";
					break;
		case '8' : $mes1 = "Agosto";
					break;
		case '9' : $mes1 = "Septiembre";
					break;
		case '10' : $mes1 = "Octubre";
					break;
		case '11' : $mes1 = "Noviembre";
					break;
		case '12' : $mes1 = "Diciembre";
					break;
		default : break;
		}
	$objResponse->addAssign("mes", "innerHTML", $mes1.'-'.$anio1);
	
    
	
	$sql_0 = "select sggeneral.trabajadores.rut, nombres,apellido_pat,apellido_mat
				 			from sggeneral.trabajadores 
							where  sggeneral.trabajadores.rut in ('".$rut."')";
	$res_0 = mysql_query($sql_0,$conexion) or die(mysql_error());
	$row_0 = mysql_fetch_array($res_0);
	$objResponse->addAssign("trabajador", "innerHTML",  $row_0['nombres'].' '.$row_0['apellido_pat'].' '.$row_0['apellido_mat']);
	$objResponse->addAssign("rut_trab", "innerHTML", $row_0['rut'].'-'.dv($row_0['rut']));
	list($anio1,$mes1,$dia1) = explode('-', $row['fecha_contrato']);
		$fecha_inicio              = $dia1.'/'.$mes1.'/'.$anio1;
	$objResponse->addAssign("fecha_contr", "innerHTML", $fecha_inicio );
	
	$sql = "SELECT  `porc_cotizacion`, `porc_adicional`, `afp`, plan, seguro_cesantia, salud
			FROM sggeneral.trabajadores_tiene_prevision
			where rut_trab in ('".$rut."')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
	$objResponse->addAssign("cot_pact", "innerHTML", $row['plan']);
	$uf = new Uf(2013); 
	$valor_uf = $uf->getDate(date("d-m-Y"));
	$objResponse->addAssign("valor_uf", "innerHTML", number_format ( $valor_uf , 2 , '.' , ',' ));
	$dias_trabajados = 30;
	$objResponse->addAssign("dias_trabajados", "innerHTML", $dias_trabajados);
	$objResponse->addAssign("tope_imponible", "innerHTML", number_format ( floor ( 70.3 * $valor_uf), 0 , '' , ',' ));
	$objResponse->addAssign("tope_salud", "innerHTML", number_format ( floor ( 70.3 * $valor_uf), 0 , '' , ',' ));
	
	$sql_afp = "select nombre from sgrrhh.afp where afp_ncorr = '".$row['afp']."'";
	$res_afp = mysql_query($sql_afp,$conexion) or die(mysql_error());
	$row_afp = mysql_fetch_array($res_afp);
	$objResponse->addAssign("nombre_afp", "innerHTML", $row_afp['nombre']);
	$objResponse->addAssign("hidden_afp", "value", $row['porc_cotizacion']);
	$objResponse->addAssign("afp", "innerHTML", 0);
	
	$sql_afp = "select nombre from sgrrhh.salud where salud_ncorr = '".$row['salud']."'";
	$res_afp = mysql_query($sql_afp,$conexion) or die(mysql_error());
	$row_afp = mysql_fetch_array($res_afp);
	$objResponse->addAssign("nombre_fonasa", "innerHTML", $row_afp['nombre']);
	$objResponse->addAssign("hidden_fonasa", "value", $row['plan']);
	$objResponse->addAssign("fonasa", "innerHTML", 0);
	
	$objResponse->addAssign("hidden_sc", "value", $row['seguro_cesantia']);
	$objResponse->addAssign("seg_cesantia", "innerHTML", 0);

	list($anio1,$mes1,$dia1) = explode('-', date("Y-m-d"));
	$fecha_inicio   = 	$anio1.'-'.$mes1.'-1';
	$mes_inicio		=	date("t");
	$fecha_fin 		= 	$anio1.'-'.$mes1.'-'.$mes_inicio;
	
	$sql_pd="SELECT COALESCE(sum(monto),0) as monto
			 FROM  sgvales.anticipos
			 where trabajador = $rut 
			 	and estado in ('PAGADO') 
				and anticipos.fecha between '".$fecha_inicio."' and '".$fecha_fin."' ";        
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	$total = 0;
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_array($res_pd)) {
			$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
						from sggeneral.trabajadores
						where rut = $rut";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$sql_2 = "select distinct tipo_trab from sgvales.anticipos where trabajador = $rut and tipo_trab not in (1,5)";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$cantidad_tt = mysql_num_rows($res_2);
			$row_2 = mysql_fetch_array($res_2);
			
			$nombre_trabajador = $row_1['nombres'];
			$monto_anticipo = $line_pd['monto'];
			//$objResponse->addAlert($cantidad_tt);
			if (($row_2['tipo_trab']!='1')&&($row_2['tipo_trab']!='5')&&($row_2['tipo_trab']!=''))
				$monto_anticipo -= 600*$cantidad_tt;
			$total = $total + $monto_anticipo;
			}
		// asigno las sesiones para el ordenamiento
	}
	$objResponse->addAssign("anticipos", "innerHTML", $total);
	
	//seguro vida
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.seguro_vida
				where 
				trabajador = '".$rut."'  and
				fecha between '".$fecha_inicio."' and '".$fecha_fin."' ";
	$res_pve = mysql_query($sql_pve,$conexion);
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
	$objResponse->addAssign("seguros", "innerHTML", $total_pie_vendedor);		

	//vales celular
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.vales_celular
					where 
					trabajador = '".$rut."'  and
					fecha between '".$fecha_inicio."' and '".$fecha_fin."' ";
						
		$res_pve = mysql_query($sql_pve,$conexion);
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
	$objResponse->addAssign("vales", "innerHTML", $total_pie_vendedor);

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
	
	//cuentas personales - ventas personales
	$sql_pve = "select COALESCE(sum(ccu_monto_pago),0) as total_pie_vendedor 
					from  yonleycp.cuentas_cuotas
						inner join yonleycp.cuentas
							on 	yonleycp.cuentas_cuotas.cue_ncorr = yonleycp.cuentas.cue_ncorr
				where 
				tra_ncorr in ( select tra_ncorr from yonleycp.trabajadores where tra_rut = '".$rut."' )  and
				ccu_fecha_pago between '".$fecha_inicio."' and '".$fecha_fin."' and
				tpro_ncorr	 = '2' ";
					
	$res_pve = mysql_query($sql_pve,$conexion) or die(mysql_error());
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
	$objResponse->addAssign("vent_pers", "innerHTML", $total_pie_vendedor);
	
	//otros
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.otros_descuentos
				where 
				trabajador = '".$trabajador."'  and
				fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
					
	$res_pve = mysql_query($sql_pve,$conexion);
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
	$objResponse->addAssign("otros", "innerHTML", $total_pie_vendedor);
	
	$sql = "select count(rut_papa) as cantidad
				from sggeneral.trabajadores_tienen_cargas
					where rut_papa = '".$rut."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
		
	$objResponse->addAssign('div_total_cargas','value',$row['cantidad']);

	
	
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

$miSmarty->display('sg_informe_liquidacion.tpl');

?>

