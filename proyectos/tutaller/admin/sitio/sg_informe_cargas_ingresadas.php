<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_cargas_ingresadas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboPersona		= 	$data["cboPersona"];
	$cboPatente		= 	$data["cboPatente"];
	$cboEmpresa		= 	$data["cboEmpresa"];
	$persona		= 	$data["OBLI-txtCodCobrador"];
	$fecha_inicio	= 	$data["OBLI-txtFecha1"];
	$fecha_fin		= 	$data["OBLI-txtFecha2"];
	$tipo			= 	$data["cboTipo"];
	$boleta			=	$data['cboBoleta'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha_inicio);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
        
	list($dia1,$mes1,$anio1) = explode('/', $fecha_fin);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_fin              = date("Y-m-d",$nro_mes_anterior);
        $and="";
		
   if (($boleta == '0')){   
		$and = " AND cargas_vehiculos.veh_depto = '1' " ;
	 }
	elseif ($boleta == '1'){
		$and = " AND cargas_vehiculos.veh_depto = '2' " ;
	}
   if (($cboPatente != '')){   
		$and .= " AND carga_veh = '".$cboPatente."'" ;
	 }
    if (($cboEmpresa != '')&&($cboEmpresa != 'Todos')){   
		$and .= " AND cargas_vehiculos.veh_empe LIKE '%".$cboEmpresa."%' " ;
	 }
    if (($tipo != '')&&($tipo != 'Todos')){   
		$and .= " AND carga_tipo ='".$tipo."'" ;
	 }
    if ($cboPersona != ''){   
		$and .= " and cargas_vehiculos.carga_pers like '%".$persona."%'" ;
	 }
	        
	$sql_ab = "select distinct carga_pers
                    from cargas_vehiculos 
                     where
                       cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
					   and carga_tipo <> '9'
					   and carga_monto <> 0
                            ".$and."
						";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$arrRegistros	= 	array();
		$i = 1;
		while($row_ab = mysql_fetch_array($res_ab)){
				$saldo =0;
				
				$sql_pr = "select * from personas where pers_rut = '".$row_ab['carga_pers']."'";
				$res_pr = mysql_query($sql_pr, $conexion);
				$nombre_persona = @mysql_result($res_pr,0,"pers_nombre")." ".@mysql_result($res_pr,0,"pers_ape_pat");
				
				$sql_pr = "select * 
							from persona_tiene_cupos 
							where rut_pers = '".$row_ab['carga_pers']."' 
							order by ptc_ncorr desc, anio desc, mes desc
							limit 0,1";
				$res_pr = mysql_query($sql_pr, $conexion);
				$cupo_persona = @mysql_result($res_pr,0,"cupo");
				$fecha = @mysql_result($res_pr,0,"anio").'-'.@mysql_result($res_pr,0,"mes").'-1';

				/*array_push($arrRegistros, array("item"		=>	$i,
												"vehiculo" 	=> 	"Sin Vehiculo",
												"persona" 	=> 	$nombre_persona,
												"debe"      => 	$cupo_persona,
												"haber" 	=> 	"0",
												"saldo" 	=> 	$cupo_persona,
												"fecha" 	=> 	$fecha,
												"tipo"          => 	"Cupo Autorizado"));
				$saldo = $saldo + $cupo_persona;
				$i++;	*/
		}
				//normal
                $sql_ab_1 = "select  `carga_ncorr`, `veh_empe`, `carga_veh`, `carga_pers`, `carga_monto`, `carga_fecha`, `carga_fecha_adelanto`, `carga_tipo`, `ce_ncorr`, `ca_ncorr`, `carga_usuario`, `carga_fechadig`, `carga_observacion`, `carga_boleta`, cargas_vehiculos .veh_depto, tipo_combustible.nombre
                    from cargas_vehiculos 
                    		inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                        and carga_tipo = '1'
						and carga_monto <> 0
						".$and."
					order by carga_veh asc";
                $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
				
				while ($line_ab_1 = mysql_fetch_row($res_ab_1)){
					$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab_1[3]."'";
                   			$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
					$patente = $line_ab_1[2];
                    if ($line_ab_1[14]==0) {
						$boleta = 'Sin Boleta';
						}
					else{
						$boleta = $line_ab_1[13];
						}
				    $saldo = $saldo - $line_ab_1[4];
					$tipo_carga_comb = 'Normal';
					array_push($arrRegistros, array("item"			=>	$i,
													"ncorr"         => 	$line_ab_1[0],
													"vehiculo"  	=> 	$patente.' - '.$line_ab_1[15],
													"persona"       => 	$nombre_persona,
													"debe"      	=> 	"0",
													"haber"     	=> 	$line_ab_1[4],
													"saldo"     	=> 	$saldo,
													"fecha"         => 	$line_ab_1[5],
													"fecha_dig"     => 	$line_ab_1[10],
													"observacion"   => 	$line_ab_1[12],
													"tipo"          => 	$tipo_carga_comb,
													"boleta"        => 	$boleta));
				}
				
//extras
				$sql_ab_1 = "select `carga_ncorr`, `carga_veh`, `carga_pers`, `carga_monto`, `carga_fecha`, 
									`carga_fecha_adelanto`, `carga_tipo`, cargas_extras.ce_ncorr, `carga_usuario`, 
									`carga_fechadig`, `ce_obs`, `ce_boleta`
                    from cargas_vehiculos 
						inner join cargas_extras
							on cargas_extras.ce_ncorr = cargas_vehiculos.ce_ncorr
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                        and carga_tipo = '2'
						and carga_monto <> 0
						".$and."
					group by cargas_extras.ce_ncorr
					order by carga_veh asc";
                $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
				
				while ($line_ab_1 = mysql_fetch_row($res_ab_1)){
					$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab_1[2]."'";
                   			$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
					$patente = $line_ab_1[1];
                	if ($line_ab_1[11]==0) {
						$boleta = 'Sin Boleta';
						}
					else{
						$boleta = $line_ab_1[11];
						}
						$tipo_carga_comb = 'Extra';
						
						$sql_ce = "select ce_obs 
							from cargas_extras 
							where ce_ncorr in (select ce_ncorr 
									from cargas_vehiculos 
									where carga_ncorr = '".$line_ab_1[0]."')";
						$res_ce = mysql_query($sql_ce,$conexion) or die(mysql_error());
						$row_ce = mysql_fetch_array($res_ce);
						
						$tipo_carga_comb = $row_ce['ce_obs'];
						array_push($arrRegistros, array("item"			=>	$i,
														"ncorr"         => 	$line_ab_1[0],
														"vehiculo"  	=> 	$patente,
														"persona"       => 	$nombre_persona,
														"debe"      	=> 	"0",
														"haber"     	=> 	$line_ab_1[3],
														"saldo"     	=> 	$saldo,
														"fecha"         => 	$line_ab_1[4],
														"fecha_dig"     => 	$line_ab_1[9],
														"observacion"   => 	$tipo_carga_comb,
														"tipo"          => 	'Extra',
														"boleta"        => 	$boleta));
					}
					
				// //anticipos
				// $sql_ab_1 = "select `carga_ncorr`, `carga_veh`, `carga_pers`, `carga_monto`, `carga_fecha`, 
				// 					`carga_fecha_adelanto`, `carga_tipo`, cargas_adelantos.ca_ncorr, `carga_usuario`, 
				// 					`carga_fechadig`, `ca_obs`, `ca_boleta`
    //                 from cargas_vehiculos 
				// 		inner join cargas_adelantos
				// 			on cargas_adelantos.ca_ncorr = cargas_vehiculos.ce_ncorr
    //                 where
    //                     carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
    //                     and carga_tipo = '4'
				// 		and carga_monto <> 0
				// 		".$and."
				// 	group by cargas_adelantos.ca_ncorr
				// 	order by carga_veh asc
				// 	";
    //             $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
				
				// while ($line_ab_1 = mysql_fetch_row($res_ab_1)){
				// 	$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
				// 			from personas 
				// 			where pers_rut = '".$line_ab_1[2]."'";
    //                			$res_pr = mysql_query($sql_pr, $conexion);
				// 	$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
				// 	$patente = $line_ab_1[1];
    //             	if ($line_ab_1[11]==0) {
				// 		$boleta = 'Sin Boleta';
				// 		}
				// 	else{
				// 		$boleta = $line_ab_1[11];
				// 		}
				// 		$tipo_carga_comb = $line_ab_1[10];
						
				// 		$sql_ce = "select ca_obs 
				// 			from cargas_adelantos 
				// 			where ca_ncorr in (select ce_ncorr 
				// 					from cargas_vehiculos 
				// 					where carga_ncorr = '".$line_ab_1[0]."')";
				// 		$res_ce = mysql_query($sql_ce,$conexion) or die(mysql_error());
				// 		$row_ce = mysql_fetch_array($res_ce);
						
				// 		$tipo_carga_comb = $row_ce['ce_obs'];
				// 		array_push($arrRegistros, array("item"			=>	$i,
				// 										"ncorr"         => 	$line_ab_1[0],
				// 										"vehiculo"  	=> 	$patente,
				// 										"persona"       => 	$nombre_persona,
				// 										"debe"      	=> 	"0",
				// 										"haber"     	=> 	$line_ab_1[3],
				// 										"saldo"     	=> 	$saldo,
				// 										"fecha"         => 	$line_ab_1[4],
				// 										"fecha_dig"     => 	$line_ab_1[9],
				// 										"observacion"   => 	$tipo_carga_comb,
				// 										"tipo"          => 	'Anticipo',
				// 										"boleta"        => 	$boleta));
				// 	}
					
				//Devoluciones de Carga
				$sql_ab_1 = "select  `carga_ncorr`, `veh_empe`, `carga_veh`, `carga_pers`, `carga_monto`, `carga_fecha`, `carga_fecha_adelanto`, `carga_tipo`, `ce_ncorr`, `ca_ncorr`, `carga_usuario`, `carga_fechadig`, `carga_observacion`, `carga_boleta`, cargas_vehiculos .veh_depto, tipo_combustible.nombre
                    from cargas_vehiculos 
                    		inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                        and carga_tipo = '5'
						and carga_monto <> 0
						".$and."
					order by carga_veh asc";
                $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
				
				while ($line_ab_1 = mysql_fetch_row($res_ab_1)){
					$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab_1[3]."'";
                   			$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
					$patente = $line_ab_1[2];
                    if ($line_ab_1[14]==0) {
						$boleta = 'Sin Boleta';
						}
					else{
						$boleta = $line_ab_1[13];
						}
				        $saldo = $saldo + $line_ab_1[4];
						$tipo_carga_comb = 'Reversa de Consumo';
						array_push($arrRegistros, array("item"			=>	$i,
														"ncorr"         => 	$line_ab_1[0],
														"vehiculo"  	=> 	$patente.' - '.$line_ab_1[15],
														"persona"       => 	$nombre_persona,
														"debe"      	=> 	$line_ab_1[4],
														"haber"     	=> 	'0',
														"saldo"     	=> 	$saldo,
														"fecha"         => 	$line_ab_1[5],
														"fecha_dig"     => 	$line_ab_1[10],																
														"observacion"   => 	$line_ab_1[12],
														"tipo"          => 	$tipo_carga_comb,
														"boleta"        => 	$boleta));
					}
					
				//Devoluciones de Asignacion	
				$sql_ab_1 = "select  `carga_ncorr`, `veh_empe`, `carga_veh`, `carga_pers`, `carga_monto`, `carga_fecha`, `carga_fecha_adelanto`, `carga_tipo`, `ce_ncorr`, `ca_ncorr`, `carga_usuario`, `carga_fechadig`, `carga_observacion`, `carga_boleta`, cargas_vehiculos .veh_depto, tipo_combustible.nombre
                    from cargas_vehiculos 
                    		inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                        and carga_tipo = '6'
						and carga_monto <> 0
						".$and."
					order by carga_veh asc";
                $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
				
				while ($line_ab_1 = mysql_fetch_row($res_ab_1)){
					$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab_1[3]."'";
                   			$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
					$patente = $line_ab_1[2];
                    if ($line_ab_1[14]==0) {
						$boleta = 'Sin Boleta';
						}
					else{
						$boleta = $line_ab_1[13];
						}
				        $saldo = $saldo + $line_ab_1[4];
						$tipo_carga_comb = 'Devoluciones de Asignacion';
						array_push($arrRegistros, array("item"			=>	$i,
														"ncorr"         => 	$line_ab_1[0],
														"vehiculo"  	=> 	$patente.' - '.$line_ab_1[15],
														"persona"       => 	$nombre_persona,
														"debe"      	=> 	$line_ab_1[4],
														"haber"     	=> 	'0',
														"saldo"     	=> 	$saldo,
														"fecha"         => 	$line_ab_1[5],
														"fecha_dig"     => 	$line_ab_1[10],																
														"observacion"   => 	$line_ab_1[12],
														"tipo"          => 	$tipo_carga_comb,
														"boleta"        => 	$boleta));
					} 
					
				//Devoluciones de Asignacion	
				$sql_ab_1 = "select  `carga_ncorr`, `veh_empe`, `carga_veh`, `carga_pers`, `carga_monto`, `carga_fecha`, `carga_fecha_adelanto`, `carga_tipo`, `ce_ncorr`, `ca_ncorr`, `carga_usuario`, `carga_fechadig`, `carga_observacion`, `carga_boleta`, cargas_vehiculos .veh_depto, tipo_combustible.nombre
                    from cargas_vehiculos 
                    		inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
                    where
                        carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                        and carga_tipo = '7'
						and carga_monto <> 0
						".$and."
					order by carga_veh asc";
                $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
				
				while ($line_ab_1 = mysql_fetch_row($res_ab_1)){
					$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab_1[3]."'";
                   			$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
					$patente = $line_ab_1[2];
                    if ($line_ab_1[14]==0) {
						$boleta = 'Sin Boleta';
						}
					else{
						$boleta = $line_ab_1[13];
						}
				        $saldo = $saldo + $line_ab_1[4];
						$tipo_carga_comb = 'Reversa de Asignacion';
						array_push($arrRegistros, array("item"			=>	$i,
														"ncorr"         => 	$line_ab_1[0],
														"vehiculo"  	=> 	$patente.' - '.$line_ab_1[15],
														"persona"       => 	$nombre_persona,
														"debe"      	=> 	$line_ab_1[4],
														"haber"     	=> 	'0',
														"saldo"     	=> 	$saldo,
														"fecha"         => 	$line_ab_1[5],
														"fecha_dig"     => 	$line_ab_1[10],																
														"observacion"   => 	$line_ab_1[12],
														"tipo"          => 	$tipo_carga_comb,
														"boleta"        => 	$boleta));
					} 
			$i++;
		 
		 	/*if ($cboPersona != ''){  
		 		array_push($arrRegistros, array("item"		=>	$i,
						"ncorr"         	=> 	"",
						"vehiculo"  	=> 	"",
						"persona"           => 	$line_ab_1[2],
						"debe"      	=> 	"0",
						"haber"     	=> 	"0",
						"saldo"     	=> 	$saldo,
						"fecha"         => 	date("Y-m-d"),
						"tipo"          => 	"",
						"boleta"        => 	$boleta));			
			}*/
	
		$arrRegistros = ordenar_matriz_multidimensionada($arrRegistros,'fecha','ASC');
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_cargas_ingresadas_list.tpl'));
		
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_cargas_ingresadas_list.tpl'));
	
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
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboPersona','personas','todos','Todos','pers_rut', 'pers_nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboEmpresa','empresas','','Todos','empe_rut', 'empe_desc', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipo','tipo_carga_comb','','Todos','tipo_carg_ncorr', 'nombre', '')");
			
	return $objResponse->getXML();
}  
function EliminarItem($data, $ncorr){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$delete = "delete from cargas_vehiculos where carga_ncorr = '".$ncorr."'";
	$res_del = mysql_query($delete,$conexion) or die(mysql_error());
	
	return $objResponse->getXML();
	}
	
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_cargas_ingresadas.tpl');

?>

