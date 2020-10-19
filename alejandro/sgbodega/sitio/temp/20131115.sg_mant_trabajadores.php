<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_mant_trabajadores.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $bd;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tbl				=	$data["txtTabla"];
	$ncorr				=	$data["txtNcorr"];
	
	if ($tbl == 'trabajadores'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores';
		}
	// busca los campos
	if ($ncorr == ''){

		$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			$sql = "insert into $tbl (";
			$campos="";
			$valor_campo = "";
			$objeto="";
			$values  ="";
			while ($line = mysql_fetch_array($res_c)) {
				$campos .= $line[0].",";
				
				$objeto 		= 	"OBLI".$line[0];
					if (isset($data[$objeto])){
						$valor_campo 	= 	($data[$objeto]);
						}
					elseif(isset($data["CHK".$line[0]])){
						$valor_campo 	= 	$data["CHK".$line[0]];
						}
					else{
						if (isset($data[$line[0]])){
							$valor_campo 	= 	$data[$line[0]];
							}
						else{
							$valor_campo  	= "";
							}
						}
					if ($objeto == 'OBLIempresa'){
						$valor_campo = '';
						}
				if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
                                    list($dia1,$mes1,$anio1) = split('[/.-]', $valor_campo);
                                    $valor_campo 	= $anio1."-".$mes1."-".$dia1;
                                    }
				$values .= "'".$valor_campo."',";
			}
			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			$campos = $campos.")";
			
			$largo_values = strlen($values);
			$values = substr($values,0,$largo_values - 1);
			$values = $values.")";
			
			$sql .= $campos." values (".$values;
			$res = mysql_query($sql,$conexion);
			$id = mysql_insert_id();
			if ($tbl=='vehiculos'){
                            $sql_1 = "insert into personas_tienen_vehiculos(patente) values ('".$data['OBLIveh_patente']."')";
                            $res_1 = mysql_query($sql_1,$conexion);
                        }
			if ($tbl=='trabajadores'){
				$empe_rut = $data['OBLIempresa'];
				for($i=0; $i<count($empe_rut); $i++){
					$empresa = $empe_rut[$i];
					$sql = "select empe_rut from sgyonley.empresas where empe_desc = '".$empresa."'";
					$res = mysql_query($sql,$conexion) or die(mysql_error());
					$row = mysql_fetch_array($res);
					$empresa = $row['empe_rut'];
					$sql_1 = "insert into sggeneral.trabajadores_tienen_empresa(rut,empe_rut) 
									values ('".$id."','".$empresa."')";
					$res_1 = mysql_query($sql_1,$conexion);
					}
				}
		}
		
	}else{
		
		//busca el campo clave
		$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
		$res_cc = mysql_query($sql_cc,$conexion);
		$campo_clave = @mysql_result($res_cc,0,"campo_clave");
		
		$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
			$campos="";
			$valor_campo = "";
			$objeto="";
			
		if (mysql_num_rows($res_c) > 0) {
			$sql = "update $bd.$tbl set ";
			while ($line = mysql_fetch_array($res_c)) {
				if ($line[1] != ''){
					$objeto 		= 	"OBLI".$line[0];
					if (isset($data[$objeto])){
						$valor_campo 	= 	($data[$objeto]);
						}
					elseif(isset($data["CHK".$line[0]])){
						$valor_campo 	= 	$data["CHK".$line[0]];
						}
					else{
						if (isset($data[$line[0]])){
							$valor_campo 	= 	$data[$line[0]];
							}
						else{
							$valor_campo  	= "";
							}
						}
					if ($objeto == 'OBLIempresa'){
						$valor_campo = '';
						}
					if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
                                            list($dia1,$mes1,$anio1) = split('[/.-]', $valor_campo);
                                            $valor_campo 	= $anio1."-".$mes1."-".$dia1;
                                            }
                    $campos .= $line[0]." = '".$valor_campo."',";
				}
			}
			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			$campos = $campos." where ".$campo_clave." = '".$ncorr."'";
			
			$sql .= $campos;
			$objResponse->addAlert($sql);
			$res = mysql_query($sql,$conexion);
			if ($tbl=='trabajadores'){
				$empe_rut = $data['OBLIempresa'];
				
				$sql_1 = "delete from trabajadores_tienen_empresa where rut = '".$ncorr."'";
				$res_1 = mysql_query($sql_1,$conexion);
				
				for($i=0; $i<count($empe_rut); $i++){
					$empresa = $empe_rut[$i];
					$sql = "select empe_rut from sgyonley.empresas where empe_desc = '".$empresa."'";
					$res = mysql_query($sql,$conexion) or die(mysql_error());
					$row = mysql_fetch_array($res);
					$empresa = $row['empe_rut'];
					$sql_1 = "insert into sggeneral.trabajadores_tienen_empresa(rut,empe_rut) 
									values ('".$ncorr."','".$empresa."')";
					$res_1 = mysql_query($sql_1,$conexion);
					}
				}
		}
	}
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");

	$objResponse->addScript("alert('Registro Grabado Correctamente.')");
	
	//$objResponse->addScript("document.Form1.submit();");

	return $objResponse->getXML();
}
function CargaListado($data){
    global $conexion;
    global $bd;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$tbl	=	$data["txtTabla"];
	
	if ($tbl == 'trabajadores'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores';
		}
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
		//$objResponse->addAlert($sql);
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			while ($line = mysql_fetch_row($res)) {
				if ($tbl == "vehiculos"){
                        		$sql_ff = "select empe_ncorr,	empe_rut, empe_desc
                                                    from empresas 
                                                    where empe_rut = ".$line[7];
                                        $res_ff = mysql_query($sql_ff, $conexion);
                                        $row_ff = mysql_fetch_array($res_ff);

                                        $sql_gg = "select *
                                                    from tipo_combustible  
                                                    where tip_com_ncorr = ".$line[11];
                                        $res_gg = mysql_query($sql_gg, $conexion);
                                        $row_gg = mysql_fetch_array($res_gg);
                                        
                                        $sql_gg_1 = "select *
                                                    from estados_vehiculos   
                                                    where est_veh_ncorr = ".$line[12];
                                        $res_gg_1 = mysql_query($sql_gg_1, $conexion);
                                        $row_gg_1 = mysql_fetch_array($res_gg_1);
                                        
                                        $sql_gg_2 = "select *
                                                    from meses  
                                                    where mes_ncorr = ".$line[13];
                                        $res_gg_2 = mysql_query($sql_gg_2, $conexion);
                                        $row_gg_2 = mysql_fetch_array($res_gg_2);
                                        
                                        $sql_gg_3 = "select *
                                                    from  empresas_aseguradoras   
                                                    where empresa_ncorr = ".$line[14];
                                        $res_gg_3 = mysql_query($sql_gg_3, $conexion);
                                        $row_gg_3 = mysql_fetch_array($res_gg_3);
                                        
                                        $sql_gg_4 = "select *
                                                    from meses  
                                                    where mes_ncorr = ".$line[15];
                                        $res_gg_4 = mysql_query($sql_gg_4, $conexion);
                                        $row_gg_4 = mysql_fetch_array($res_gg_4);
                                        
                                        $sql_gg_5 = "select *
                                                    from tipo_vehiculo  
                                                    where tipo_veh_ncorr = ".$line[17];
                                        $res_gg_5 = mysql_query($sql_gg_5, $conexion);
                                        $row_gg_5 = mysql_fetch_array($res_gg_5);
                                        
                                        array_push($arrRegistros, array("ncorr"         => $line[0], 
                                                                        "marca"         => $line[1],
                                                                        "modelo"        => $line[2],
                                                                        "anio"          => $line[3],
                                                                        "color"         => $line[4],
                                                                        "patente"       => $line[5], 
                                                                        "fecha_adq"     => $line[6], 
                                                                        "empresa"	=> $row_ff['empe_desc'], 
                                                                        "valor"         => $line[8],
                                                                        "valor_actual"  => $line[9], 
                                                                        "rend"          => $line[10],
                                                                        "tipo_comb"	=> $row_gg['nombre'],
                                                                        "estado"        => $row_gg_1['nombre'],
                                                                        "rev_tec"       => $row_gg_2['nombre'],
                                                                        "emp_aseg"      => $row_gg_3['nombre'], 
                                                                        "mont_prima"    => $line[14], 
                                                                        "term_seguro"   => $row_gg_4['nombre'], 
                                                                        "tipo_veh"   => $row_gg_5['nombre']));
				}elseif ($tbl == "personas"){                                             
					array_push($arrRegistros, array("ncorr"         => $line[0], 
                                                                        "rut"           => 	$line[1], 
                                                                        "nombre"	=> 	$line[2], 
                                                                        "ape_pat"	=> 	$line[3], 
                                                                        "ape_mat"	=> 	$line[4]));
				}elseif ($tbl == "usuarios"){                                             
					$sql_ff = "select perfil_nombre
                                                    from perfiles
                                                    where perfil_codigo = ".$line[4];
                                        $res_ff = mysql_query($sql_ff, $conexion);
                                        $row_ff = mysql_fetch_array($res_ff);
                                        array_push($arrRegistros, array("ncorr"         =>      $line[0], 
                                                                        "usuario"       => 	$line[1], 
                                                                        "password"	=> 	$line[2], 
                                                                        "nombre"	=> 	$line[3], 
                                                                        "perfil"	=> 	$row_ff['perfil_nombre']));
				}elseif ($tbl == "perfiles"){                                             
					array_push($arrRegistros, array("ncorr"         =>      $line[0], 
                                                                        "codigo"       => 	$line[1], 
                                                                        "nombre"	=> 	$line[2], 
                                                                        "descripcion"	=> 	$line[3]));
				}elseif ($tbl == "menues"){                                             
					$sql_ff = "select perfil_nombre
                                                    from perfiles
                                                    where perfil_codigo = ".$line[2];
                                        $res_ff = mysql_query($sql_ff, $conexion);
                                        $row_ff = mysql_fetch_array($res_ff);
                                        array_push($arrRegistros, array("ncorr"         =>      $line[0], 
                                                                        "descripcion"       => 	$line[1], 
                                                                        "perfil"	=> 	$row_ff['perfil_nombre'], 
                                                                        "orden"	=> 	$line[3]));
				}elseif ($tbl == "menues_hijos"){                                             
					$sql_ff = "select perfil_nombre
                                                    from perfiles
                                                    where perfil_codigo = ".$line[5];
                                        $res_ff = mysql_query($sql_ff, $conexion);
                                        $row_ff = mysql_fetch_array($res_ff);
					$sql_gg = "select menu_desc
                                                    from menues
                                                    where menu_ncorr = ".$line[1];
                                        $res_gg = mysql_query($sql_gg, $conexion);
                                        $row_gg = mysql_fetch_array($res_gg);
					$sql_dd = "select nombre
                                                    from sub_menus
                                                    where submenu_ncorr = ".$line[2];
                                        $res_dd = mysql_query($sql_dd, $conexion);
                                        $row_dd = mysql_fetch_array($res_dd);
                                        array_push($arrRegistros, array("ncorr"         =>      $line[0], 
                                                                        "padre"         => 	$row_gg['menu_desc'], 
                                                                        "sub_menu"      => 	$row_dd['nombre'],  
                                                                        "descripcion"   => 	$line[3], 
                                                                        "link"          => 	$line[4], 
                                                                        "perfil"        => 	$row_ff['perfil_nombre'], 
                                                                        "orden"         => 	$line[6], 
                                                                        "mostrar"       => 	$line[7]));
				}elseif ($tbl == "correos"){                                             
					array_push($arrRegistros, array("ncorr"         =>      $line[0], 
                                                                        "nombre"         => 	$line[1],
                                                                        "usuario"     => 	$line[2], 
                                                                        "correo"          => 	$line[3]));
				}elseif ($tbl == "proveedor"){                                             
					array_push($arrRegistros, array("ncorr"         =>  $line[0], 
													"nombre"        => 	$line[1],
													"rut"     		=> 	$line[2], 
													"direccion"     => 	$line[3], 
													"telefono"      => 	$line[4], 
													"email"        	=> 	$line[5]));
				}elseif ($tbl == "clientes"){                                             
					array_push($arrRegistros, array("ncorr"         =>  $line[0], 
													"nombre"        => 	$line[1],
													"rut"     		=> 	$line[2], 
													"direccion"     => 	$line[3], 
													"telefono"      => 	$line[4], 
													"email"        	=> 	$line[5]));
				}elseif ($tbl == "prestadores"){                                             
					array_push($arrRegistros, array("ncorr"         =>  $line[0], 
													"nombre"        => 	$line[2],
													"rut"     		=> 	$line[1], 
													"direccion"     => 	$line[3], 
													"telefono"      => 	$line[4], 
													"email"        	=> 	$line[5]));
				}elseif ($tbl == "trabajadores"){    
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
													"nombre"  	      	=> 	$line[1],
													"apellido_paterno"	=> 	$line[2], 
													"apellido_materno"	=> 	$line[3], 
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
		
		$miSmarty->assign('TBL', $tbl);
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_mant_trabajadores_list.tpl'));
	
	}
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	$objResponse->addScript("document.getElementById('$obj1').focus();");
	
	return $objResponse->getXML();
}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa"];
	$ncorr 		= 	$data["$objeto1"];
	
	if ($c_and == 1){
		$and = " and empe_ncorr = '".$empresa."'";
	}
	
	$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    global $bd;
    
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$tbl =	$data["txtTabla"];
	if ($tbl == 'trabajadores'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores';
		}
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC limit 1";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		$objeto  = 	"OBLI".@mysql_result($res_c,0,"campo");
        }	
	$objResponse->addScript("document.getElementById('$objeto').focus();");
        if ($tbl == "vehiculos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_emp','empresas','','-Seleccione-','empe_rut', 'empe_desc', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_tipo_comb','tipo_combustible','','-Seleccione-','tip_com_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_emp_ase','empresas_aseguradoras','','','empresa_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_rev_tec','meses','','','mes_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_term_seg','meses','','','mes_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_estado','estados_vehiculos','','','est_veh_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIveh_tipo_veh','tipo_vehiculo','','','tipo_veh_ncorr', 'nombre', '')");
            }
        if ($tbl == "usuarios_sistema"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIperf_ncorr','perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            }
        if ($tbl == "menues"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItper_ncorr','perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            }
        if ($tbl == "menues_hijos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_sub','sub_menus','','','submenu_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImhij_perfil','perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_ncorr','menues','','','menu_ncorr', 'menu_desc', '')");
            }
        if ($tbl == "trabajadores"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIempresa_contr','sgyonley.empresas','','','empe_rut', 'empe_desc', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIzona_vendedor','sgyonley.zonas','','','zona_ncorr', 'zona_desc', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcargo','sgcaja.tipos_cargos','','','tcar_ncorr', 'tcar_desc', '')");
			
			$sql = "select empe_rut, empe_desc from sgyonley.empresas";
			$res = mysql_query($sql,$conexion) or die(mysql_error());
			$str_input="";
			while ($row = mysql_fetch_array($res)){
				if (isset($row['empe_desc'])&&isset($row['empe_rut'])){
					$str_input .= "<input type='checkbox' name='OBLIempresa[]' id='".$row['empe_rut']."' value='".$row['empe_desc']."'>".$row['empe_desc']."<br/>";
					}
				}
			$objResponse->addAssign("DIVempresa","innerHTML",$str_input); 		
			
            }
        $objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
        
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
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
function EliminarItem($data, $ncorr){
    global $conexion;
    global $bd;
    
	$objResponse = new xajaxResponse('ISO-8859-1');
		
	$tbl =	$data["txtTabla"];
	if ($tbl == 'trabajadores'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores';
		}
	//busca el campo clave
	$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
	$res_cc = mysql_query($sql_cc,$conexion);
	$campo_clave = @mysql_result($res_cc,0,"campo_clave");
	
	$sql = "delete from $bd.$tbl where $campo_clave = '".$ncorr."'";
	$res = mysql_query($sql,$conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}
function TraeValor($data, $ncorr){
    global $conexion;
    global $bd;
	$objResponse = new xajaxResponse('ISO-8859-1');
		
	$tbl =	$data["txtTabla"];
	$objResponse->addAssign("txtNcorr", "value", $ncorr);
	if ($tbl == 'trabajadores'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores';
		}
	//busca el campo clave
	$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
	$res_cc = mysql_query($sql_cc,$conexion);
	$campo_clave = @mysql_result($res_cc,0,"campo_clave");
	
	// busca los campos de la tabla
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		$arrCampos = array();
		$campos ="";
		$j = 0;
		while ($line_c = mysql_fetch_array($res_c)) {
			$arrCampos[$j] = $line_c[0];
			$campos .= $line_c[0].",";
			$j++;
		}
		$largo_campos = strlen($campos);
		$campos = substr($campos,0,$largo_campos - 1);
		
		$sql = "select $campos from $bd.$tbl where $campo_clave = '".$ncorr."'";
		//$objResponse->addScript("alert('$j $campos')");
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i = 0;
			//while ($line = mysql_fetch_row($res)) {
			$line = mysql_fetch_row($res);
			while ($i < $j) {
				$objeto  = 	"OBLI".$arrCampos[$i];
				if ($objeto == 'OBLIempresa'){
					$sql_1 = "select *
								from sgyonley.empresas
							";
					$res_1 = mysql_query($sql_1,$conexion);
					while ($row_1 = mysql_fetch_array($res_1)){
						$objResponse->addScript("document.getElementById('".$row_1['empe_rut']."').checked = false");
						}
					$sql = "select *
							from sggeneral.trabajadores_tienen_empresa
							where rut = '".$ncorr."'";
					$res = mysql_query($sql,$conexion);
					while ($row = mysql_fetch_array($res)){
						$objResponse->addScript("document.getElementById('".$row['empe_rut']."').checked = true");
						}
					}
				if (!isset($data[$objeto])){
					$objeto 	= 	$arrCampos[$i];
					if (!isset($data[$objeto])){
						if ($line[$i]==1){
							$objResponse->addAssign("CHK".$arrCampos[$i],"checked","checked");
							}
						}
					}

					$objResponse->addAssign("$objeto", "value", $line[$i]);
					
					if ($objeto=='OBLIrut'){
					$rut 				= $line[$i];

					$objResponse->addAssign("datos_vendedores", "innerHTML", "");
					$sql_obtener = "select * 
									from sgbodega.vendedores
									where VE_RUT = '".$rut."'";
					$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
					$str = "<table class='tabla-alycar-texto'><tr>
																	<td>Codigo vendedor</td>
																	<td>Empresa vendedor</td>
																	<td>Zona vendedor</td>
																  	<td>Comision Vendedor</td>
																  	<td>Eliminar</td>
																</tr>";
					while ($row_obtener = mysql_fetch_array($res_obtener)){
						$str .=	"<tr>";
						$str .= "<td >".$row_obtener['VE_sg_mant_trabajadores.phpCODIGO']."</td>";
						$sql_1 = "select *
									from sgyonley.empresas
									where empe_rut = '".$row_obtener['VE_EMPRESA']."'";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
						$row_1 = mysql_fetch_array($res_1);
						$str .= "<td >".$row_1['empe_desc']."</td>";
						$str .= "<td >".$row_obtener['VE_ZONA']."</td>";
						$str .= "<td >".$row_obtener['VE_COMISION']."</td>";
						$eliminar ="xajax_EliminarVendedor(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['VE_CODIGO'].",".$row_obtener['VE_ZONA'].",".$row_obtener['VE_COMISION'].",".$row_obtener['VE_EMPRESA'].")";
						$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
						$str .= "</tr>";
						}
					$str .= "</table>";
					$objResponse->addAssign("datos_vendedores", "innerHTML", $str);

									
					$sql_obtener = "select * 
									from sgyonley.cobrador
									where CO_RUT = '".$rut."'";
					$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
					$str = "<table class='tabla-alycar-texto'><tr>
																	<td>Codigo cobrador</td>
																	<td>Empresa cobrador</td>
																	<td>Sector cobrador</td>
																	<td>Comision cobrador</td>
																	<td>Eliminar</td>
																</tr>
																</tr>";
					while ($row_obtener = mysql_fetch_array($res_obtener)){
						$str .=	"<tr>";
						$str .= "<td >".$row_obtener['CO_CODIGO']."</td>";
						$sql_1 = "select *
									from sgyonley.empresas
									where empe_rut = '".$row_obtener['CO_EMPRESA']."'";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
						$row_1 = mysql_fetch_array($res_1);
						$str .= "<td >".$row_1['empe_desc']."</td>";
						$str .= "<td >".$row_obtener['CO_SECTOR']."</td>";
						$str .= "<td >".$row_obtener['CO_COMISION']."</td>";
						$eliminar ="xajax_EliminarCobrador(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['CO_CODIGO'].",".$row_obtener['CO_SECTOR'].",".$row_obtener['CO_COMISION'].",".$row_obtener['CO_EMPRESA'].")";
						$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
						$str .= "</tr>";
						}
					$str .= "</table>";
					$objResponse->addAssign("datos_cobradores", "innerHTML", $str);
					$sql_obtener = "select * 
									from sgyonley.supervisor
									where sp_rut = '".$rut."'";
					$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
					$str = "<table class='tabla-alycar-texto'><tr>
                                                	<td>Codigo supervisor</td>
                                                    <td>Comision supervisor</td>
                                                    <td>Empresa supervisor</td>
											      <td>Eliminar</td>
                                                </tr>";
					while ($row_obtener = mysql_fetch_array($res_obtener)){
						$str .=	"<tr>";
						$str .= "<td >".$row_obtener['sp_codigo']."</td>";
						$str .= "<td >".$row_obtener['sp_comision']."</td>";
						$sql_1 = "select *
									from sgyonley.empresas
									where empe_rut = '".$row_obtener['sp_empresa']."'";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
						$row_1 = mysql_fetch_array($res_1);
						$str .= "<td >".$row_1['empe_desc']."</td>";
						$eliminar ="xajax_EliminarSupervisor(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['sp_codigo'].",".$row_obtener['sp_comision'].",".$row_obtener['sp_empresa'].")";
						$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
						$str .= "</tr>";
						}
					$str .= "</table>";
					$objResponse->addAssign("datos_supervisores", "innerHTML", $str);
					}
				$i++;
			}
		}	
	}
	return $objResponse->getXML();
}
function AgregarVendedor($data){
    global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');

	$rut 				= $data['OBLIrut'];
	$cod_vendedor 		= $data['OBLIcod_vendedor']; 
	$sector_vendedor	= $data['OBLIsector_vendedor']; 
	$empresa_vendedor	= $data['OBLIempresa_vendedor']; 
	$zona_vendedor		= $data['OBLIzona_vendedor']; 
	$comision_vendedor	= $data['OBLIcomision_vendedor']; 
	$nombre					= $data['OBLInombres'].' '.$data['OBLIapellido_pat'].' '.$data['OBLIapellido_mat']; 
	
	$sql_insert = "INSERT INTO sgbodega.vendedores(`VE_EMPRESA`, `VE_VENDEDOR`, `VE_ZONA`, `VE_CODIGO`, `VE_RUT`, `VE_COMISION`) 
					VALUES ('$empresa_vendedor','$nombre','$zona_vendedor','$cod_vendedor','$rut','$comision_vendedor')";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$sql_insert = "INSERT INTO sgyonley.vendedores(`VE_EMPRESA`, `VE_VENDEDOR`, `VE_ZONA`, `VE_CODIGO`, `VE_RUT`, `VE_COMISION`, VE_ACTIVO) 
					VALUES ('$empresa_vendedor','$nombre','$zona_vendedor','$cod_vendedor','$rut','$comision_vendedor', 'SI')";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$objResponse->addAssign("datos_vendedores", "innerHTML", "");
	$sql_obtener = "select * 
					from sgbodega.vendedores
					where ve_rut = '".$rut."'";
	$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
	$str = "<table class='tabla-alycar-texto'><tr>
													<td>Codigo vendedor</td>
													<td>Empresa vendedor</td>
													<td>Zona vendedor</td>
													<td>Comision Vendedor</td>
													<td>Eliminar</td>
												</tr>";
	while ($row_obtener = mysql_fetch_array($res_obtener)){
		$str .=	"<tr>";
		$str .= "<td >".$row_obtener['VE_CODIGO']."</td>";
		$sql_1 = "select *
					from sgyonley.empresas
					where empe_rut = '".$row_obtener['VE_EMPRESA']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$str .= "<td >".$row_1['empe_desc']."</td>";
		$str .= "<td >".$row_obtener['VE_ZONA']."</td>";
		$str .= "<td >".$row_obtener['VE_COMISION']."</td>";
		$eliminar ="xajax_EliminarVendedor(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['VE_CODIGO'].",".$row_obtener['VE_ZONA'].",".$row_obtener['VE_COMISION'].",".$row_obtener['VE_EMPRESA'].")";
		$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
		$str .= "</tr>";
		}
	$str .= "</table>";
	$objResponse->addAssign("datos_vendedores", "innerHTML", $str);
	
	return $objResponse->getXML();
	}

function EliminarVendedor($data,$rut,$cod_vendedor,$zona_vendedor,$comision_vendedor,$empresa_vendedor){
    global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');

	$sql_insert = "delete from sgbodega.vendedores
					where ve_rut = '$rut' 
						and VE_CODIGO = '$cod_vendedor'
						and VE_ZONA = '$zona_vendedor'
						and VE_EMPRESA = '$empresa_vendedor'
						and VE_COMISION = '$comision_vendedor'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$sql_insert = "delete from sgyonley.vendedores
					where ve_rut = '$rut' 
						and VE_CODIGO = '$cod_vendedor'
						and VE_ZONA = '$zona_vendedor'
						and VE_EMPRESA = '$empresa_vendedor'
						and VE_COMISION = '$comision_vendedor'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$objResponse->addAssign("datos_vendedores", "innerHTML", "");
	$sql_obtener = "select * 
					from sgbodega.vendedores
					where ve_rut = '".$rut."'";
	$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
	$str = "<table class='tabla-alycar-texto'><tr>
													<td>Codigo vendedor</td>
													<td>Empresa vendedor</td>
													<td>Zona vendedor</td>
													<td>Comision Vendedor</td>
													<td>Eliminar</td>
												</tr>";
	while ($row_obtener = mysql_fetch_array($res_obtener)){
		$str .=	"<tr>";
		$str .= "<td >".$row_obtener['VE_CODIGO']."</td>";
		$sql_1 = "select *
					from sgyonley.empresas
					where empe_rut = '".$row_obtener['VE_EMPRESA']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$str .= "<td >".$row_1['empe_desc']."</td>";
		$str .= "<td >".$row_obtener['VE_ZONA']."</td>";
		$str .= "<td >".$row_obtener['VE_COMISION']."</td>";
		$eliminar ="xajax_EliminarVendedor(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['VE_CODIGO'].",".$row_obtener['VE_ZONA'].",".$row_obtener['VE_COMISION'].",".$row_obtener['VE_EMPRESA'].")";
		$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
		$str .= "</tr>";
		}
	$str .= "</table>";
	$objResponse->addAssign("datos_vendedores", "innerHTML", $str);
	return $objResponse->getXML();
	}

function AgregarCobrador($data){
    global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');

	$rut 					= $data['OBLIrut'];
	$codigo_cobrador 		= $data['codigo_cobrador']; 
	$sector_cobrador		= $data['sector_cobrador']; 
	$empresa_cobrador		= $data['empresa_cobrador']; 
	$comision_cobrador		= $data['comision_cobrador']; 
	$nombre					= $data['OBLInombres'].' '.$data['OBLIapellido_pat'].' '.$data['OBLIapellido_mat']; 
	
	$sql_insert = "INSERT INTO sgyonley.cobrador(`CO_CODIGO`, `CO_RUT`, `CO_NOMBRE`, `CO_SECTOR`, `CO_EMPRESA`, `CO_COMISION`, `CO_ACTIVO`)
					 VALUES ('$codigo_cobrador','$rut','$nombre','$sector_cobrador','$empresa_cobrador','$comision_cobrador','SI')";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$sql_obtener = "select * 
					from sgyonley.cobrador
					where CO_RUT = '".$rut."'";
	$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
	$str = "<table class='tabla-alycar-texto'><tr>
                                                	<td>Codigo cobrador</td>
                                                    <td>Empresa cobrador</td>
                                                    <td>Sector cobrador</td>
											      	<td>Comision cobrador</td>
											      	<td>Eliminar</td>
                                                </tr>
                                                </tr>";
	while ($row_obtener = mysql_fetch_array($res_obtener)){
		$str .=	"<tr>";
		$str .= "<td >".$row_obtener['CO_CODIGO']."</td>";
		$sql_1 = "select *
					from sgyonley.empresas
					where empe_rut = '".$row_obtener['CO_EMPRESA']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$str .= "<td >".$row_1['empe_desc']."</td>";
		$str .= "<td >".$row_obtener['CO_SECTOR']."</td>";
		$str .= "<td >".$row_obtener['CO_COMISION']."</td>";
		$eliminar ="xajax_EliminarCobrador(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['CO_CODIGO'].",".$row_obtener['CO_SECTOR'].",".$row_obtener['CO_COMISION'].",".$row_obtener['CO_EMPRESA'].")";
		$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
		$str .= "</tr>";
		}
	$str .= "</table>";
	$objResponse->addAssign("datos_cobradores", "innerHTML", $str);
	return $objResponse->getXML();
	}

function EliminarCobrador($data,$rut,$cod_vendedor,$sector_vendedor,$comision_vendedor,$empresa_vendedor){
    global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');

	$sql_insert = "delete from sgyonley.cobrador
					where CO_RUT = '$rut' 
						and CO_CODIGO = '$cod_vendedor'
						and CO_SECTOR = '$sector_vendedor'
						and CO_COMISION = '$comision_vendedor'
						and CO_EMPRESA = '$empresa_vendedor'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	
	$sql_obtener = "select * 
					from sgyonley.cobrador
					where CO_RUT = '".$rut."'";
	$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
	$str = "<table class='tabla-alycar-texto'><tr>
                                                	<td>Codigo cobrador</td>
                                                    <td>Empresa cobrador</td>
                                                    <td>Sector cobrador</td>
											      	<td>Comision cobrador</td>
											      	<td>Eliminar</td>
                                                </tr>
                                                </tr>";
	while ($row_obtener = mysql_fetch_array($res_obtener)){
		$str .=	"<tr>";
		$str .= "<td >".$row_obtener['CO_CODIGO']."</td>";
		$sql_1 = "select *
					from sgyonley.empresas
					where empe_rut = '".$row_obtener['CO_EMPRESA']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$str .= "<td >".$row_1['empe_desc']."</td>";
		$str .= "<td >".$row_obtener['CO_SECTOR']."</td>";
		$str .= "<td >".$row_obtener['CO_COMISION']."</td>";
		$eliminar ="xajax_EliminarCobrador(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['CO_CODIGO'].",".$row_obtener['CO_SECTOR'].",".$row_obtener['CO_COMISION'].",".$row_obtener['CO_EMPRESA'].")";
		$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
		$str .= "</tr>";
		}
	$str .= "</table>";
	$objResponse->addAssign("datos_cobradores", "innerHTML", $str);
	return $objResponse->getXML();
	}

function AgregarSupervisor($data){
    global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');

	$rut 					= $data['OBLIrut'];
	$cod_supervisor 		= $data['codigo_supervisor']; 
	$nombre					= $data['OBLInombres'].' '.$data['OBLIapellido_pat'].' '.$data['OBLIapellido_mat']; 
	$comision_supervisor	= $data['comision_supervisor']; 
	$empresa_supervisor		= $data['empresa_supervisor']; 

	$sql_insert = "INSERT INTO sgyonley.supervisor(`sp_rut`, `sp_codigo`, `sp_nombre`, `sp_comision`, sp_empresa) 
					VALUES ('$rut','$cod_supervisor','$nombre','$comision_supervisor','$empresa_supervisor')";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$sql_obtener = "select * 
					from sgyonley.supervisor
					where sp_rut = '".$rut."'";
	$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
	$str = "<table class='tabla-alycar-texto'><tr>
                                                	<td>Codigo supervisor</td>
                                                    <td>Comision supervisor</td>
                                                    <td>Empresa supervisor</td>
											      <td>Eliminar</td>
                                                </tr>";
	while ($row_obtener = mysql_fetch_array($res_obtener)){
		$str .=	"<tr>";
		$str .= "<td >".$row_obtener['sp_codigo']."</td>";
		$str .= "<td >".$row_obtener['sp_comision']."</td>";
		$sql_1 = "select *
					from sgyonley.empresas
					where empe_rut = '".$row_obtener['sp_empresa']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$str .= "<td >".$row_1['empe_desc']."</td>";
		$eliminar ="xajax_EliminarSupervisor(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['sp_codigo'].",".$row_obtener['sp_comision'].",".$row_obtener['sp_empresa'].")";
		$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
		$str .= "</tr>";
		}
	$str .= "</table>";
	$objResponse->addAssign("datos_supervisores", "innerHTML", $str);
	return $objResponse->getXML();
	}

function EliminarSupervisor($data,$rut,$cod_supervisor,$comision_supervisor,$empresa_supervisor){
    global $conexion;
	$objResponse = new xajaxResponse('ISO-8859-1');

	$sql_insert = "delete from sgyonley.supervisor
					where rut = '$rut' 
						and sp_codigo = '$cod_supervisor'
						and sp_comision = '$comision_supervisor'
						and sp_empresa = '$empresa_supervisor'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$objResponse->addAssign("datos_supervisores", "innerHTML", "");

	$sql_obtener = "select * 
					from sgyonley.supervisor
					where sp_rut = '".$rut."'";
	$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
	$str = "<table class='tabla-alycar-texto'><tr>
                                                	<td>Codigo supervisor</td>
                                                    <td>Comision supervisor</td>
                                                    <td>Empresa supervisor</td>
											      <td>Eliminar</td>
                                                </tr>";
	while ($row_obtener = mysql_fetch_array($res_obtener)){
		$str .=	"<tr>";
		$str .= "<td >".$row_obtener['sp_codigo']."</td>";
		$str .= "<td >".$row_obtener['sp_comision']."</td>";
		$sql_1 = "select *
					from sgyonley.empresas
					where empe_rut = '".$row_obtener['sp_empresa']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$str .= "<td >".$row_1['empe_desc']."</td>";
		$eliminar ="xajax_EliminarSupervisor(xajax.getFormValues('Form1'),".$rut.",".$row_obtener['sp_codigo'].",".$row_obtener['sp_comision'].",".$row_obtener['sp_empresa'].")";
		$str .= '<td ><input type="button" class="boton" value="Eliminar" name="btnEliminar" id="btnEliminar" onclick="'.$eliminar.'"/></td>';
		$str .= "</tr>";
		}
	$str .= "</table>";
	$objResponse->addAssign("datos_supervisores", "innerHTML", $str);
	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("LlamaIngresoVenta");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("AgregarVendedor");
$xajax->registerFunction("EliminarVendedor");
$xajax->registerFunction("AgregarCobrador");
$xajax->registerFunction("EliminarCobrador");
$xajax->registerFunction("AgregarSupervisor");
$xajax->registerFunction("EliminarSupervisor");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

// busca el titulo de la tabla
$sql = "select mant_titulo from mantenedores where mant_tabla = '".$_GET['tbl']."'";
$res = mysql_query($sql,$conexion);
$tbl = $_GET['tbl'];
if ($tbl == 'trabajadores'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores';
		}
	// busca los campos
$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
$res_c = mysql_query($sql_c, $conexion);

if (mysql_num_rows($res_c) > 0) {
	$arrCampos = array();
	while ($line = mysql_fetch_array($res_c)) {
		$titulo	=	$line[1];
		$objeto	=	"TEXT";
		if (substr($line[1],0,3) == 'CBO'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"SELECT";
 		}elseif (substr($line[1],0,3) == 'MLT'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"MLT";
 		}	
		elseif (substr($line[1],0,3) == 'fch'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"FECHA";
 		}elseif (substr($line[1],0,4) == 'pass'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"PASSWORD";
 		}elseif (substr($line[1],0,3) == 'rut'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"RUT";
 		}elseif (substr($line[1],0,3) == 'OPC'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"OPC";
 		}elseif (substr($line[1],0,3) == 'CHK'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"CHK";
 		}	
		array_push($arrCampos, array("campo" => $line[0], "titulo" => $titulo, "objeto" => $objeto));
	}
}

$miSmarty->assign('TABLA', $_GET['tbl']);
$miSmarty->assign('TITULO_TABLA', @mysql_result($res,0,"mant_titulo"));
$miSmarty->assign('arrCampos', $arrCampos);

$miSmarty->assign('pagina_volver',isset($_SESSION["alycar_pagina_volver"]));
if (isset($_SESSION['alycar_volver']) =='si'){
	$miSmarty->assign('volver',isset($_SESSION['alycar_volver']));
	$_SESSION['alycar_volver'] = 'no';
	}
$miSmarty->assign('nombre_empresa', isset($_GET["nombre_empresa"]));
$miSmarty->assign('empresa', isset($_GET["empresa"]));
$miSmarty->assign('fecha', isset($_GET["fecha"]));
$miSmarty->assign('cliente', isset($_GET["cliente"]));
$miSmarty->assign('rut', isset($_GET["rut"]));
$miSmarty->assign('nro_factura', isset($_GET["nro_factura"]));
$miSmarty->assign('neto', isset($_GET["neto"]));
$miSmarty->assign('iva', isset($_GET["iva"]));
$miSmarty->assign('total', isset($_GET["total"]));

$miSmarty->display('sg_mant_trabajadores.tpl');
?>

