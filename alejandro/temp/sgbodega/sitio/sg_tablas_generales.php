<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_tablas_generales.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_tbl			= 	$data["txtTabla"];
	$codigo			= 	$data["txtCodigo"];
	$zona			= 	$data["OBLI-cboZona"];
	$desc			= 	strtoupper($data["OBLI-txtDescripcion"]);
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa"];
	$empresa_rut	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$nombre			=	strtoupper($data["OBLI-txtNombre"]);
	$comision_ent	=	$data["OBLI-txtComisionEnt"];
	$comision_dec	=	$data["OBLI-txtComisionDec"];
	$activo			=	$data["OBLI-cboActivo"];
	$codigo_familia	=	$data["OBLI-cboFamilia"];
	
	if ($v_tbl == 'sectores'){
		if ($codigo == ''){
			$sql = "insert into sectores (sect_desc, empe_ncorr, zona_ncorr) 
					values ('".$desc."', '".$empresa."', '".$zona."')";
			$res = mysql_query($sql, $conexion);
			$id = mysql_insert_id($conexion);
			
			//actualizo el codigo del sector
			$sql = "update sectores set sect_cod = '".$id."' where sect_ncorr = '".$id."'";
			$res = mysql_query($sql, $conexion);
		}else{
			$sql = "update sectores set zona_ncorr = '".$zona."',  sect_desc = '".$desc."' where sect_ncorr = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}		
	
	if ($v_tbl == 'vendedores'){
		
		$comision = $comision_ent.".".$comision_dec;
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(VE_CODIGO) as codigo from vendedores";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			// en sgyonley
			$sql = "insert into vendedores (VE_EMPRESA, VE_VENDEDOR, VE_CODIGO, VE_COMISION) 
					values ('".$empresa_rut."', '".$nombre."', '".$codigo."', '".$comision."')";
			$res = mysql_query($sql, $conexion);
			
			// en sgbodega
			$sql = "insert into sgbodega.vendedores (VE_EMPRESA, VE_VENDEDOR, VE_CODIGO, VE_COMISION) 
					values ('".$empresa_rut."', '".$nombre."', '".$codigo."', '".$comision."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			
			// en sgyonley
			$sql = "update vendedores set 
						VE_VENDEDOR = '".$nombre."',  
						VE_COMISION = '".$comision."',
						VE_ACTIVO 	= '".$activo."'

						where VE_CODIGO = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
			
			// en sgbodega
			$sql = "update sgbodega.vendedores set 
						VE_VENDEDOR = '".$nombre."',  
						VE_COMISION = '".$comision."',
						VE_ACTIVO 	= '".$activo."'

						where VE_CODIGO = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}		
	if ($v_tbl == 'cobrador'){
		
		$comision = $comision_ent.".".$comision_dec;
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(CO_CODIGO) as codigo from cobrador";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into cobrador (CO_EMPRESA, CO_NOMBRE, CO_CODIGO, CO_COMISION) 
					values ('".$empresa_rut."', '".$nombre."', '".$codigo."', '".$comision."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update cobrador set 
						CO_NOMBRE = '".$nombre."',  
						CO_COMISION = '".$comision."',
						CO_ACTIVO 	= '".$activo."'

						where CO_CODIGO = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}		
	if ($v_tbl == 'supervisor'){
		
		$comision = $comision_ent.".".$comision_dec;
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(sp_codigo) as codigo from supervisor";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into supervisor (sp_empresa, sp_nombre, sp_codigo, sp_comision) 
					values ('".$empresa_rut."', '".$nombre."', '".$codigo."', '".$comision."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update supervisor set 
						sp_nombre = '".$nombre."',  
						sp_comision = '".$comision."',
						sp_activo 	= '".$activo."'

						where sp_codigo = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}		
	if ($v_tbl == 'familias'){
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(FA_CODIGO) as codigo from sgbodega.familias";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into sgbodega.familias (FA_CODIGO, FA_NOMBRE, FA_EMPRESA) 
					values ('".$codigo."', '".$nombre."','".$empresa_rut."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update sgbodega.familias set FA_NOMBRE = '".$nombre."' where FA_CODIGO = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}		
	if ($v_tbl == 'subfamilias'){
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(SF_SUBCODIGO) as codigo from sgbodega.subfamilias";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into sgbodega.subfamilias (SF_CODIGO, SF_SUBCODIGO, SF_NOMBRE, SF_EMPRESA) 
					values ('".$codigo_familia."', '".$codigo."','".$nombre."','".$empresa_rut."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update sgbodega.subfamilias set 
					SF_CODIGO = '".$codigo_familia."', 
					SF_NOMBRE = '".$nombre."' 
					
					where SF_SUBCODIGO = '".$codigo."'";
			
			$res = mysql_query($sql, $conexion);
		}
	}		
	if ($v_tbl == 'marcas'){
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(mar_ncorr) as codigo from sgbodega.marcas";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into sgbodega.marcas (mar_ncorr, mar_desc) 
					values ('".$codigo."', '".$nombre."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update sgbodega.marcas set mar_desc = '".$nombre."' where mar_ncorr = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}
	
	if ($v_tbl == 'clasificacion'){
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(FA_CODIGO) as codigo from sgbodega.clasificacion";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into sgbodega.clasificacion (FA_CODIGO, FA_NOMBRE) 
					values ('".$codigo."', '".$nombre."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update sgbodega.clasificacion set FA_NOMBRE = '".$nombre."' where FA_CODIGO = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}
	
	if ($v_tbl == 'tramos'){
		
		if ($codigo == ''){
			// busca el mayor codigo ingresado
			$sql = "select max(TR_CODIGO) as codigo from sgbodega.tramos";
			$res = mysql_query($sql, $conexion);
			$codigo = @mysql_result($res,0,"codigo") + 1;
			
			$sql = "insert into sgbodega.tramos (TR_CODIGO, TR_GLOSA) 
					values ('".$codigo."', '".$nombre."')";
			$res = mysql_query($sql, $conexion);
			
		}else{
			$sql = "update sgbodega.tramos set TR_GLOSA = '".$nombre."' where TR_CODIGO = '".$codigo."'";
			$res = mysql_query($sql, $conexion);
		}
	}		
	
	$objResponse->addScript("alert('Datos Grabados Correctamente.')");
	
	//INICIALIZA EL FORMULARIO
	$objResponse->addScript("window.document.Form1.submit();");
	
	return $objResponse->getXML();
}
function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$v_tbl			= 	$data["txtTabla"];
	$empresa	 	= 	$_SESSION["alycar_sgyonley_empresa"];
	$empresa_rut 	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	
	if ($v_tbl == 'sectores'){
		$sql = "select 
					b.zona_desc,
					a.sect_ncorr,  
					a.sect_cod,  
					a.sect_desc
				from 
					sectores a, zonas b
				where 
					b.zona_ncorr = a.zona_ncorr and
					a.empe_ncorr = '".$empresa."'";
	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				array_push($arrRegistros, array("item" 			=> 	$i, 
												"zona"			=>	$line[0],
												"ncorr" 		=> 	$line[1], 
												"codigo" 		=> 	$line[2], 
												"descripcion"	=> 	$line[3]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'vendedores'){
		$sql = "select 
					VE_CODIGO, VE_VENDEDOR, VE_COMISION, VE_ACTIVO
				from 
					vendedores
				where 
					VE_EMPRESA = '".$empresa_rut."'";
	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				//list($ent,$dec) = split('[.,]', $line[2]);
				//$objResponse->addScript("alert('Datos Grabados Correctamente.')");

				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"vendedor" 		=> 	$line[1], 
												"comision" 		=> 	$line[2], 
												"activo"		=> 	$line[3]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'cobrador'){
		$sql = "select 
					CO_CODIGO, CO_NOMBRE, CO_COMISION, CO_ACTIVO
				from 
					cobrador
				where 
					CO_EMPRESA = '".$empresa_rut."'";
	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				//list($ent,$dec) = split('[.,]', $line[2]);
				//$objResponse->addScript("alert('Datos Grabados Correctamente.')");

				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"cobrador" 		=> 	$line[1], 
												"comision" 		=> 	$line[2], 
												"activo"		=> 	$line[3]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'supervisor'){
		$sql = "select 
					sp_codigo, sp_nombre, sp_comision, sp_activo
				from 
					supervisor
				where 
					sp_empresa = '".$empresa_rut."'";
	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				//list($ent,$dec) = split('[.,]', $line[2]);
				//$objResponse->addScript("alert('Datos Grabados Correctamente.')");

				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"supervisor" 	=> 	$line[1], 
												"comision" 		=> 	$line[2], 
												"activo"		=> 	$line[3]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'familias'){
		$sql = "select FA_CODIGO, FA_NOMBRE	from sgbodega.familias ORDER BY FA_CODIGO ASC";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"descripcion"	=> 	$line[1]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'subfamilias'){
		$sql = "select 
				a.SF_SUBCODIGO as codigo,
				a.SF_NOMBRE as nombre,
				b.FA_NOMBRE as familia
				
				from sgbodega.subfamilias a, sgbodega.familias b 
				
				where a.SF_CODIGO = b.FA_CODIGO
				
				ORDER BY a.SF_SUBCODIGO ASC";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"descripcion"	=> 	$line[1],
												"familia"		=> 	$line[2]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'marcas'){
		$sql = "select mar_ncorr, mar_desc from sgbodega.marcas ORDER BY mar_ncorr ASC";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"descripcion"	=> 	$line[1]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'clasificacion'){
		$sql = "select FA_CODIGO, FA_NOMBRE from sgbodega.clasificacion ORDER BY FA_CODIGO ASC";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"descripcion"	=> 	$line[1]));
				$i++;
			}
		}	
	}
	if ($v_tbl == 'tramos'){
		$sql = "select TR_CODIGO, TR_GLOSA from sgbodega.tramos ORDER BY TR_CODIGO ASC";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i=1;
			$arrRegistros = array();
			while ($line = mysql_fetch_row($res)) {
				array_push($arrRegistros, array("item" 			=> 	$i, 
												"ncorr" 		=> 	$line[0], 
												"codigo" 		=> 	$line[0], 
												"descripcion"	=> 	$line[1]));
				$i++;
			}
		}	
	}
	
	$miSmarty->assign('TBL', $v_tbl);
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_tablas_generales_list.tpl'));
	
	return $objResponse->getXML();
}

function Eliminar($data, $codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_tbl		= 	$data["txtTabla"];
	$v_campo1	= 	$data["txtCampo1"];
	$v_campo2	= 	$data["txtCampo2"];
	$v_desc		= 	$data["OBLI-txtDescripcion"];
	
	$sql = "delete from $v_tbl where $v_campo1 = '".$codigo."'";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	$objResponse->addScript("window.parent.xajax_Refresca(xajax.getFormValues('Form1'))");

	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa"];
	$v_tbl			= 	$data["txtTabla"];
	
	if ($v_tbl == 'subfamilias'){
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboFamilia','familias','','- - Seleccione - -','FA_CODIGO', 'FA_NOMBRE')");
	}
	if ($v_tbl == 'sectores'){
		$sql = "select zona_ncorr as codigo, zona_desc as descripcion from zonas where empe_ncorr = '".$empresa."'";
		$res = mysql_query($sql, $conexion);
		
		if (mysql_num_rows($res) > 0) {
			$objResponse->addCreate("OBLI-cboZona","option",""); 		
			$objResponse->addAssign("OBLI-cboZona","options[0].value", '');
			$objResponse->addAssign("OBLI-cboZona","options[0].text", '- - Seleccione - -'); 	

			$j = 1;
			while ($line = mysql_fetch_row($res)) {
				$objResponse->addCreate("OBLI-cboZona","option",""); 		
				$objResponse->addAssign("OBLI-cboZona","options[".$j."].value", $line[0]);
				$objResponse->addAssign("OBLI-cboZona","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
	}
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa"];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from sgbodega.$tabla ORDER BY FA_CODIGO ASC";
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
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

function Modificar($data, $ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_tbl			= 	$data["txtTabla"];
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$empe_ncorr 	=	$_SESSION["alycar_sgyonley_empresa"];
	
	if ($v_tbl == 'sectores'){
		$sql = "select 
					b.zona_ncorr,
					b.zona_desc,
					a.sect_ncorr,  
					a.sect_cod,  
					a.sect_desc
				from 
					sectores a, zonas b
				where 
					b.zona_ncorr = a.zona_ncorr and
					a.sect_ncorr = '".$ncorr."'";
	
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		$zona_ncorr 	= $line[0];
		$zona_desc 		= $line[1];
		$descripcion 	= $line[4];
		
		$objResponse->addAssign("OBLI-cboZona","innerHTML",""); 		
		$objResponse->addCreate("OBLI-cboZona","option",""); 		
		$objResponse->addAssign("OBLI-cboZona","options[0].value", $zona_ncorr);
		$objResponse->addAssign("OBLI-cboZona","options[0].text", $zona_desc); 	
		
		$sql = "select zona_ncorr as codigo, zona_desc as descripcion from zonas where empe_ncorr = '".$empe_ncorr."'";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0) {
			$j = 1;
			while ($line = mysql_fetch_row($res)) {
				$objResponse->addCreate("OBLI-cboZona","option",""); 		
				$objResponse->addAssign("OBLI-cboZona","options[".$j."].value", $line[0]);
				$objResponse->addAssign("OBLI-cboZona","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtDescripcion", "value", $descripcion);
		
		$objResponse->addScript("document.getElementById('OBLI-cboZona').focus();");
	}
	if ($v_tbl == 'vendedores'){
		$sql = "select 
					VE_CODIGO, VE_VENDEDOR, VE_COMISION, VE_ACTIVO
				from 
					vendedores
				where 
					VE_CODIGO = '".$ncorr."' and VE_EMPRESA = '".$empresa."'";
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		list($ent,$dec) = split('[.,]', $line[2]);
		$objResponse->addAssign("OBLI-txtComisionEnt", "value", $ent);
		$objResponse->addAssign("OBLI-txtComisionDec", "value", $dec);
		
		$objResponse->addAssign("OBLI-cboActivo","innerHTML",""); 		
		
		$objResponse->addCreate("OBLI-cboActivo","option",""); 		
		$objResponse->addAssign("OBLI-cboActivo","options[0].value", $line[3]);
		$objResponse->addAssign("OBLI-cboActivo","options[0].text", $line[3]); 	
		
		$objResponse->addCreate("OBLI-cboActivo","option",""); 		
		$objResponse->addAssign("OBLI-cboActivo","options[1].value", 'SI');
		$objResponse->addAssign("OBLI-cboActivo","options[1].text", 'SI'); 	
		
		$objResponse->addCreate("OBLI-cboActivo","option",""); 		
		$objResponse->addAssign("OBLI-cboActivo","options[2].value", 'NO');
		$objResponse->addAssign("OBLI-cboActivo","options[2].text", 'NO'); 	
		
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	if (($v_tbl == 'cobrador') OR ($v_tbl == 'supervisor')){
		if ($v_tbl == 'cobrador'){
			$sql = "select 
						CO_CODIGO, CO_NOMBRE, CO_COMISION, CO_ACTIVO
					from 
						cobrador
					where 
						CO_CODIGO = '".$ncorr."' and CO_EMPRESA = '".$empresa."'";
		}
		if ($v_tbl == 'supervisor'){
			$sql = "select 
						sp_codigo, sp_nombre, sp_comision, sp_activo
					from 
						supervisor
					where 
						sp_codigo = '".$ncorr."' and sp_empresa = '".$empresa."'";
		}
		
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		list($ent,$dec) = split('[.,]', $line[2]);
		$objResponse->addAssign("OBLI-txtComisionEnt", "value", $ent);
		$objResponse->addAssign("OBLI-txtComisionDec", "value", $dec);
		
		$objResponse->addAssign("OBLI-cboActivo","innerHTML",""); 		
		
		$objResponse->addCreate("OBLI-cboActivo","option",""); 		
		$objResponse->addAssign("OBLI-cboActivo","options[0].value", $line[3]);
		$objResponse->addAssign("OBLI-cboActivo","options[0].text", $line[3]); 	
		
		$objResponse->addCreate("OBLI-cboActivo","option",""); 		
		$objResponse->addAssign("OBLI-cboActivo","options[1].value", 'SI');
		$objResponse->addAssign("OBLI-cboActivo","options[1].text", 'SI'); 	
		
		$objResponse->addCreate("OBLI-cboActivo","option",""); 		
		$objResponse->addAssign("OBLI-cboActivo","options[2].value", 'NO');
		$objResponse->addAssign("OBLI-cboActivo","options[2].text", 'NO'); 	
		
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	if ($v_tbl == 'familias'){
		$sql = "select FA_CODIGO, FA_NOMBRE	from sgbodega.familias where FA_CODIGO = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	if ($v_tbl == 'subfamilias'){
		$sql = "select 
				a.SF_SUBCODIGO as codigo,
				a.SF_NOMBRE as nombre,
				b.FA_CODIGO as cod_familia,
				b.FA_NOMBRE as familia
				
				from 
				sgbodega.subfamilias a, sgbodega.familias b 
				
				where 
				a.SF_CODIGO = b.FA_CODIGO and
				a.SF_SUBCODIGO = '".$ncorr."'";
		
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		$objResponse->addAssign("OBLI-cboFamilia","innerHTML",""); 		
		$sql_f = "select FA_CODIGO as codigo, FA_NOMBRE as descripcion from sgbodega.familias ORDER BY FA_CODIGO ASC";
		$res_f = mysql_query($sql_f, $conexion);
		
		if (mysql_num_rows($res_f) > 0) {
			$objResponse->addCreate("OBLI-cboFamilia","option",""); 		
			$objResponse->addAssign("OBLI-cboFamilia","options[0].value", $line[2]);
			$objResponse->addAssign("OBLI-cboFamilia","options[0].text", $line[3]); 	
			$j = 1;
			while ($line_f = mysql_fetch_array($res_f)) {
				$objResponse->addCreate("OBLI-cboFamilia","option",""); 		
				$objResponse->addAssign("OBLI-cboFamilia","options[".$j."].value", $line_f[0]);
				$objResponse->addAssign("OBLI-cboFamilia","options[".$j."].text", $line_f[1]); 	
				$j++;
			}
		}
			
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	if ($v_tbl == 'marcas'){
		$sql = "select mar_ncorr, mar_desc from sgbodega.marcas where mar_ncorr = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	if ($v_tbl == 'clasificacion'){
		$sql = "select FA_CODIGO, FA_NOMBRE from sgbodega.clasificacion where FA_CODIGO = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	if ($v_tbl == 'tramos'){
		$sql = "select TR_CODIGO, TR_GLOSA from sgbodega.tramos where TR_CODIGO = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		$line = mysql_fetch_row($res);
		
		$objResponse->addAssign("txtCodigo", "value", $ncorr);
		$objResponse->addAssign("OBLI-txtNombre", "value", $line[1]);
		
		$objResponse->addScript("document.getElementById('OBLI-txtNombre').focus();");
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("Eliminar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Modificar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('TIT', $_GET["tit"]);
$miSmarty->assign('TBL', $_GET["tbl"]);
$miSmarty->assign('CAMPO1', $_GET["campo1"]);
$miSmarty->assign('CAMPO2', $_GET["campo2"]);

$miSmarty->display('sg_tablas_generales.tpl');

?>

