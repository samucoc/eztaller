<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_reparaciones.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboPatente		= 	$data["cboPatente"];
	$cboPersona		= 	$data["cboPersona"];
	$persona		= 	$data["rut_trabajador"];
	$cboMecanico	= 	$data["cboMecanico"];
	$documento		= 	$data["documento"];
	$pago			= 	$data["cboPago"];
	$nro_cheque		= 	$data["nro_boleta"];
	$detalle_repara_ncorr		= 	$data["detalle_repara_ncorr"];
	$mecanico		= 	$data["rut_mecanico"];
	$fecha_inicio	= 	$data["OBLI-txtFecha1"];
	$fecha_fin		= 	$data["OBLI-txtFecha2"];
	$suma= 0;
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha_inicio);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
        
	list($dia1,$mes1,$anio1) = explode('/', $fecha_fin);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_fin              = date("Y-m-d",$nro_mes_anterior);
        $and="";
		
    if ($cboPatente != ''){   
		$and .= " and patente like '%".$cboPatente."%'" ;
	 }
	if ($cboPersona != ''){   
		$and .= " and trabajador like '%".$persona."%'" ;
	 }
	if ($cboMecanico != ''){   
		$and .= " and mecanico like '%".$mecanico."%'" ;
	 }
	if ($documento != ''){   
		$and .= " and documento like '%".$documento."%'" ;
	 }
	if (($pago != '')&&($pago!='Todos')){   
		$and .= " and pago like '%".$pago."%'" ;
	 }
	if ($nro_cheque!= ''){   
		$and .= " and cheque like '%".$nro_cheque."%'" ;
	 }
	if ($detalle_repara_ncorr!= ''){   
		$and .= " and detalle_repara_ncorr = '".$detalle_repara_ncorr."'" ;
	 }
	    
	$sql_ab = "select *
                    from reparaciones
                    where
                        (fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                            ".$and." )
                        and  repara_ncorr not in (select repara_ncorr
															from detalle_reparacion
															where gasto_detalle > 0)
					order by fecha asc";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	
		$arrRegistros	= 	array();
		$arrRegDetalle  = 	array();
		$i = 1;
			while ($line_ab_1 = mysql_fetch_row($res_ab)){
                $sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab_1[1]."'";
                $res_pr = mysql_query($sql_pr, $conexion);
                $nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
				if (($nombre_persona=='')&&($line_ab_1[1]!='')){
					$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
								from personas 
								where pers_rut like '".number_format($line_ab_1[1],0,'','.')."%'";
					$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					if ($nombre_persona==''){
						$sql_pr = "select concat(trab_nombres,' ',trab_apellidos) as pers_nombre_com 
									from sgcaja.trabajadores
									where trab_ncorr like '".$line_ab_1[1]."'";
						$res_pr = mysql_query($sql_pr, $conexion);
						$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
						}
					}
				    $sql_pr = "select nombre 
								from mecanicos 
								where rut = '".$line_ab_1[3]."'";
	                $res_pr = mysql_query($sql_pr, $conexion);
	                $nombre_mecanico = @mysql_result($res_pr,0,"nombre");

					$sql_1 = "select *
								from detalle_reparacion
								where repara_ncorr = '".$line_ab_1[0]."'";		
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
					$suma_total=0;
					while($row_1 = mysql_fetch_array($res_1)){
						$sql_pr = "select nombre 
								from repuestos 
								where repu_ncorr = '".$row_1['repuesto']."'";
						$res_pr = mysql_query($sql_pr, $conexion);
						$nombre_repuesto = @mysql_result($res_pr,0,"nombre");
						if ($nombre_repuesto==''){
							$nombre_repuesto = $row_1['repuesto'];
							}
						array_push($arrRegDetalle, array("item"				=>	$i,
														"detalle_ncorr"   	=> 	$row_1['detalle_repara_ncorr'],
														"repara_ncorr" 		=> 	$row_1['repara_ncorr'],
														"repuesto"      	=> 	$nombre_repuesto,
														"pu"      			=> 	$row_1['precio_unitario'],
														"cant"     			=> 	$row_1['cantidad'],
														"vt"     			=> 	$row_1['precio_unitario']*$row_1['cantidad']));
						$suma_total = $suma_total + ($row_1['precio_unitario']*$row_1['cantidad']);
						}
						
									
	                array_push($arrRegistros, array("item"				=>	$i,
													"ncorr"         	=> 	$line_ab_1[0],
													"trabajador"  		=> 	$nombre_persona,
													"patente"      		=> 	$line_ab_1[2],
													"mecanico"      	=> 	$nombre_mecanico,
													"fecha_ingreso"     => 	$line_ab_1[4],
													"fecha_repara"     	=> 	$line_ab_1[5],
													"observa"		    => 	$line_ab_1[6],
													"documento"		    => 	$line_ab_1[7],
													"cheque"		    => 	$line_ab_1[9],
													"suma_total"		=>	$suma_total));	
					$suma = $suma + $suma_total;
	                $i++;
	            } 

       // var_dump($arrRegDetalle)	;
            	
		if (($pago =='Efectivo')||($pago=='')||($pago=='Todos')){
           	if ($cboPatente != ''){   
				$and_1 .= " and gast_ncorr in ( select gast_ncorr 
												from sgcaja.gastos_detalle 
												where gdet_patente like '%".$cboPatente."%'  )" ;
				}
			if ($cboPersona != ''){   
					list($rut,$dv) = explode('-',$persona);
					list($mill,$mil,$cen) = explode('.',$rut);
					$rut= $mill.$mil.$cen;
					$and_1 .= " and trab_ncorr in (select distinct trab_ncorr
								                    from sgcaja.trabajadores
								                    where trab_rut like '%".$rut."%' )" ;
				 }
	 	
            $sql = "select gast_ncorr, trab_ncorr, gast_fecha
	            	from   		sgcaja.gastos
	            	where  		gast_fecha between '".$fecha_inicio."' and '".$fecha_fin."'  $and_1
	            	order by 	gast_fecha asc";
            		
            $res = mysql_query($sql, $conexion);
            if (@mysql_num_rows($res) > 0){
            	$total_cargos	=	0;
            	$total_abonos	=	0;
            	
            	while ($line = mysql_fetch_row($res)) {
	            		
	            	if ($cboPatente != ''){   
						$and_2 .= "and gdet_patente like '%".$cboPatente."%'" ;
						}
					
	            	$and_2 .= "  and gdet_fechadoc between '".$fecha_inicio."' and '".$fecha_fin."' " ;
					
	            	$sql_1 = "select *
								from sgcaja.gastos_detalle
								where gast_ncorr = '".$line[0]."' $and_2 and tsga_ncorr in (29,24,23,28,22,30,9,8,7,6,5,31,3,25) ";		
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
					$suma_total=0;
					$id = mysql_num_rows($res_1);
					while($row_1 = mysql_fetch_array($res_1)){

						$sql_sg = "SELECT tsga_desc FROM sgcaja.tipos_subgastos where tsga_ncorr = '".$row_1['tsga_ncorr']."'";
						$res_sg = mysql_query($sql_sg,$conexion);
						$row_sg = mysql_fetch_array($res_sg);
						
						array_push($arrRegDetalle, array("item"				=>	$i,
														"detalle_ncorr"   	=> 	$row_1['gdet_ncorr'],
														"repara_ncorr" 		=> 	$row_1['gast_ncorr'],
														"repuesto"      	=> 	'GASTO VEHICULO - '.$row_sg['tsga_desc'].' - '.$row_1['tgas_obs'],
														"pu"      			=> 	$row_1['gdet_total'],
														"cant"     			=> 	'1',
														"vt"     			=> 	$row_1['gdet_total']));
						$suma_total = $suma_total + ($row_1['gdet_total']);
	            		if ($row_1['gdet_patente']!='')
	            			$cboPatente_1 = $row_1['gdet_patente'];
	            		}
	            	$sql_pr = "select concat(trab_nombres,' ',trab_apellidos) as pers_nombre_com 
									from sgcaja.trabajadores
									where trab_ncorr like '".$line[1]."'";
					$res_pr = mysql_query($sql_pr, $conexion);
					$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					if ($id>0){
		            	array_push($arrRegistros, array("item"				=>	$i,
														"ncorr"         	=> 	$line[0],
														"trabajador"  		=> 	$nombre_persona,
														"patente"      		=> 	$cboPatente_1,
														"fecha_ingreso"     => 	$line[2],
														"fecha_repara"     	=> 	$line[2],
														"suma_total"		=>	$suma_total));	
		            	$suma = $suma + $suma_total;
						}
	                $i++;
	            		
	            	}
	            }
            }	

		$arrRegistros = ordenar_matriz_multidimensionada($arrRegistros,'fecha_repara','ASC');

		//var_dump($arrRegistros);

		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('suma', $suma);
        $miSmarty->assign('arrRegistros', $arrRegistros);
        $miSmarty->assign('arrRegDetalle', $arrRegDetalle);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_reparaciones_list.tpl'));
		
	
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_reparaciones_list.tpl'));
	
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
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_reparaciones.tpl');

?>

