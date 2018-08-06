<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_saldo_individual.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$trabajador		= 	$data["OBLI-txtCodCobrador"];
	$patente		= 	$data["cboPatente"];
	
	$empresa		= 	$data["empresa"];
	$depto			= 	$data["depto"];
	$producto		= 	$data["producto"];
	$quincena		= 	$data["quincena"];
	$mes_1			= 	$data["mes"];
	$anio_1			= 	$data["anio"];
	
	$arrRegistros		= 	array();

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$anio_trab = date("Y",mktime(0,0,0,$mes_1,1,$anio_1));
	$mes_trab = date("m",mktime(0,0,0,$mes_1,1,$anio_1));
	$inicio_mes_ant		= mktime(0, 0, 0, $mes_trab, 1,   $anio_trab);
	$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
	$cant_mes_ant		= date("t",$inicio_mes_ant);
	$fin_mes_ant 		= mktime(0, 0, 0, $mes_trab, $cant_mes_ant,   $anio_trab);
	$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
	$and="";
	
	if ($trabajador!=''){
		$and = " and carga_pers = '".$trabajador."' ";
		}
	if ($empresa!='Todas'){
		$and .= " and veh_empe = '".$empresa."' ";
		}
	if ($patente!=''){
		$and .= " and carga_veh = '".$patente."' ";
		}
	if ($depto!=''){
		if ($depto == '1') $and_1 = ' and cargas_vehiculos.veh_depto <> "2" ';
		else $and_1 = ' and cargas_vehiculos.veh_depto = "2" ';
		}
	if ($producto!=''){
		$and_2 = " and tipo_combustible.nombre = '".$producto."' ";
		}
	
	$sql_trab ="select carga_pers,carga_veh, tipo_combustible.nombre, carga_boleta
					    from cargas_vehiculos 
					    	inner join vehiculos 
					    		on cargas_vehiculos.carga_veh = vehiculos.veh_patente
					    	inner join tipo_combustible
					    		on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
					     where carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."'
						$and $and_1 $and_2
					group by carga_pers";
	$res_trab = mysql_query($sql_trab, $conexion) or die(mysql_error());

	while ($row_trab = mysql_fetch_array($res_trab)){

		$carga_veh = $row_trab['carga_veh'];
		$and = " and carga_pers = '".$row_trab['carga_pers']."' ";

		$fecha_inicio_ant="";
		$fecha_fin_ant ="";

		

			$inicio_mes_ant		= mktime(0, 0, 0, $mes_1, 1,   $anio_1);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
			$cant_mes_ant		= date("t",$inicio_mes_ant);
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_1, $cant_mes_ant,   $anio_1);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
		

		$sql_si = "SELECT coalesce(cupo,0) as cupo
				FROM `persona_tiene_cupos` 
					where rut_pers = '".$row_trab['carga_pers']."'
					order by ptc_ncorr desc
					limit 0,1
				   ";
		$res_si = mysql_query($sql_si, $conexion) or die(mysql_error());
		$row_si = mysql_fetch_array($res_si);
		$asignacion = ($row_si['cupo']);

		$sql_ab = "select coalesce(sum(carga_monto),0) as monto
            		from cargas_vehiculos 
            		where carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."' 						and carga_tipo = '1'
						$and_1
				$and ";
		$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
		$row_ab = mysql_fetch_array($res_ab);
		$carga_normal = $row_ab['monto'];



		$sql_ab = "select coalesce(sum(carga_monto),0) as monto
			    from cargas_vehiculos 
			     where carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."' 					and carga_tipo = '5'  
				$and ";
		$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
		$row_ab = mysql_fetch_array($res_ab);
		$devo_carga = $row_ab['monto'];

		$sql_ab = "select coalesce(sum(carga_monto),0) as monto
			    from cargas_vehiculos 
			     where carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."' 					and carga_tipo = '6'  
				$and ";
		$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
		$row_ab = mysql_fetch_array($res_ab);
		$devo_asig  = $row_ab['monto'];

		$disponible = $asignacion - $carga_normal - $cn_boleta - $devo_carga + $devo_asig;
						
		$sql_ab = "select coalesce(sum(carga_monto),0) as monto
			    from cargas_vehiculos 
			     where carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."' 					
				and carga_tipo = '2'
						$and_1
				$and ";
		$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
		$row_ab = mysql_fetch_array($res_ab);
		$extra = $row_ab['monto'];

		$total_extra = $extra + $extra_boleta;

		
		//$disponible = $asignacion-$carga_normal-$cn_boleta+$devo_carga-$devo_asig;

		$sql_pr = "select * from personas where pers_rut = '".$row_trab['carga_pers']."'";
		$res_pr = mysql_query($sql_pr, $conexion);
		$nombre_persona = @mysql_result($res_pr,0,"pers_nombre")." ".@mysql_result($res_pr,0,"pers_ape_pat");	
		
		$sql_pr = "select * from sgyonley.empresas where empe_rut = '".$empresa."'";
		$res_pr = mysql_query($sql_pr, $conexion);
		$nombre_empresa = @mysql_result($res_pr,0,"empe_desc");	

		$depto_1			= 	$row_trab["carga_boleta"];
		$producto_1			= 	$row_trab["nombre"];
	
		if ($depto_1 == '0') {
			$nombre_depto = 'Casa Matriz';
			}
		else {
			$nombre_depto = 'Boleta';
			}
		
		if ($producto_1=='PD'){
			$nombre_prod = 'DIESEL';
			}
		elseif ($producto_1=='93'){
			$nombre_prod = '93';
			}
		elseif ($producto_1=='95'){
			$nombre_prod = '95';
			}
		elseif ($producto_1=='97'){
			$nombre_prod = '97';
			}
		
		if ($quincena=='1'){
			$nombre_quin = '1ra Quincena';
			}
		elseif ($quincena=='2'){
			$nombre_quin = '2da Quincena';
			}
		
		
		$saldo_inicial = $saldo_inicial * (-1);

		array_push($arrRegistros, array( 
						"trabajador"	=>$nombre_persona,
						"patente"		=>$carga_veh,
						"empresa"		=>$nombre_empresa,
						"depto"			=>$nombre_depto,
						"producto"		=>$nombre_prod,
						"asignacion"	=>$asignacion,
						"disponible"	=>$disponible));
	
		}

	
	$miSmarty->assign('quincena', $quincena);	
	$miSmarty->assign('arrRegistros', $arrRegistros);	
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_saldo_individual_list.tpl'));
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
        $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
        
	if (@mysql_num_rows($res) > 0) {
                $objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	return $objResponse->getXML();
}  

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_saldo_individual.tpl');

?>

