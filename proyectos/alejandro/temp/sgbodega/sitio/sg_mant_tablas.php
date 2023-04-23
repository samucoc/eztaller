<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_mant_tablas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $bd;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tbl				=	$data["txtTabla"];
	$ncorr				=	$data["txtNcorr"];
	
	if ($tbl == 'proveedores'){
		$bd = 'sgbodega';
		$tbl = 'proveedor';
		}
	
	// busca los campos
	if ($ncorr == ''){

		$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			$sql = "insert into $tbl (";
			while ($line = mysql_fetch_array($res_c)) {
				$campos .= $line[0].",";
				
				$objeto 		= 	"OBLI".$line[0];
				$valor_campo 	= 	$data[$objeto];
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
			if ($tbl=='vehiculos'){
                            $sql_1 = "insert into personas_tienen_vehiculos(patente) values ('".$data['OBLIveh_patente']."')";
                            $res_1 = mysql_query($sql_1,$conexion);
                        }
		}
		
	}else{
		
		//busca el campo clave
		$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
		$res_cc = mysql_query($sql_cc,$conexion);
		$campo_clave = @mysql_result($res_cc,0,"campo_clave");
		
		$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			$sql = "update $bd.$tbl set ";
			while ($line = mysql_fetch_array($res_c)) {
				if ($line[1] != ''){
					$objeto 		= 	"OBLI".$line[0];
					$valor_campo 	= 	($data[$objeto]);
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
			$res = mysql_query($sql,$conexion);
			
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
	
	if ($tbl == 'proveedores'){
		$bd = 'sgbodega';
		$tbl = 'proveedor';
		}
	
	// busca los campos de la tabla
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
	$res_c = mysql_query($sql_c, $conexion);
	$campos ="";
	if (mysql_num_rows($res_c) > 0) {
		while ($line = mysql_fetch_array($res_c)) {
			$campos .= $line[0].",";
		}
		$largo_campos = strlen($campos);
		$campos = substr($campos,0,$largo_campos - 1);
		
		$sql = "select $campos from $bd.$tbl";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
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
				}else{                                             
					array_push($arrRegistros, array("ncorr" => $line[0], "desc"	=> 	$line[1]));
				}
			}
		}	
		
		$miSmarty->assign('TBL', $tbl);
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_mant_tablas_list.tpl'));
	
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
	if ($tbl == 'proveedores'){
		$bd = 'sgbodega';
		$tbl = 'proveedor';
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
        if ($tbl == "usuarios"){
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
	if ($tbl == 'proveedores'){
		$bd = 'sgbodega';
		$tbl = 'proveedor';
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
	if ($tbl == 'proveedores'){
		$bd = 'sgbodega';
		$tbl = 'proveedor';
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
				$objResponse->addAssign("$objeto", "value", $line[$i]);
				$i++;
			}
		}	
	}
	
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

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

// busca el titulo de la tabla
$sql = "select mant_titulo from mantenedores where mant_tabla = '".$_GET['tbl']."'";
$res = mysql_query($sql,$conexion);
$tbl = $_GET['tbl'];
if ($tbl == 'proveedores'){
	$bd = 'sgbodega';
	$tbl = 'proveedor';
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
 		}elseif (substr($line[1],0,3) == 'opc'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"OPC";
 		}	
		array_push($arrCampos, array("campo" => $line[0], "titulo" => $titulo, "objeto" => $objeto));
	}
}

$miSmarty->assign('TABLA', $_GET['tbl']);
$miSmarty->assign('TITULO_TABLA', @mysql_result($res,0,"mant_titulo"));
$miSmarty->assign('arrCampos', $arrCampos);

if (isset($_SESSION["alycar_pagina_volver"]))
	$miSmarty->assign('pagina_volver',$_SESSION["alycar_pagina_volver"]);
if (isset($_SESSION["alycar_volver"]))
	if ($_SESSION['alycar_volver'] =='si'){
		$miSmarty->assign('volver',$_SESSION['alycar_volver']);
		$_SESSION['alycar_volver'] = 'no';
		}
if (isset($_SESSION["nombre_empresa"]))
	$miSmarty->assign('nombre_empresa', $_GET["nombre_empresa"]);
if (isset($_SESSION["empresa"]))
	$miSmarty->assign('empresa', $_GET["empresa"]);
if (isset($_SESSION["fecha"]))
	$miSmarty->assign('fecha', $_GET["fecha"]);
if (isset($_SESSION["cliente"]))
	$miSmarty->assign('cliente', $_GET["cliente"]);
if (isset($_SESSION["rut"]))
	$miSmarty->assign('rut', $_GET["rut"]);
if (isset($_SESSION["nro_factura"]))
	$miSmarty->assign('nro_factura', $_GET["nro_factura"]);
if (isset($_SESSION["neto"]))
	$miSmarty->assign('neto', $_GET["neto"]);
if (isset($_SESSION["iva"]))
	$miSmarty->assign('iva', $_GET["iva"]);
if (isset($_SESSION["total"]))
	$miSmarty->assign('total', $_GET["total"]);

$miSmarty->display('sg_mant_tablas.tpl');
?>

