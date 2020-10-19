<?php 
ob_start();
session_start();


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_establecimiento_ingresar.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('UTF8');

	list($dia1,$mes1,$anio1) = explode('/', $data['OBLIFechaDecreto']); $valor_campo 	= $anio1."-".$mes1."-".$dia1;
	$sql = "UPDATE `Establecimiento` SET 
						`NumeroRutEstablecimiento`= '".$data['OBLINumeroRutEstablecimiento']."',
						`NombreEstablecimiento`='".$data['OBLINombreEstablecimiento']."',
						`DireccionEstablecimiento`='".$data['OBLIDireccionEstablecimiento']."',
						`CiudadEstablecimiento`='".$data['OBLICiudadEstablecimiento']."',
						`TelefonoEstablecimiento`='".$data['OBLITelefonoEstablecimiento']."',
						`EMailEstablecimiento`='".$data['OBLIEMailEstablecimiento']."',
						`NumeroRutRepresentante`='".$data['OBLINumeroRutRepresentante']."',
						`PaternoRepresentante`='".$data['OBLIPaternoRepresentante']."',
						`MaternoRepresentante`='".$data['OBLIMaternoRepresentante']."',
						`NombresRepresentante`='".$data['OBLINombresRepresentante']."',
						`PeriodoEstablecimiento`='".$data['OBLIPeriodoEstablecimiento']."',
						`RegionEstablecimiento`='".$data['OBLIRegionEstablecimiento']."',
						`ProvinciaEstablecimiento`='".$data['OBLIProvinciaEstablecimiento']."',
						`SemestreEstablecimiento`='".$data['OBLISemestreEstablecimiento']."',
						`RBD`='".$data['OBLIRBD']."',
						`NumeroDecreto`='".$data['OBLINumeroDecreto']."',
						`FechaDecreto`='".$valor_campo."',
						`PeriodoPostulacion`='".$data['OBLIPeriodoPostulacion']."',
						`PorcentajeSintesis`='".$data['OBLIPorcentajeSintesis']."',
						`CorrelativoCertificado`='".$data['OBLICorrelativoCertificado']."',
						`CelularEstablecimiento`='".$data['OBLICelularEstablecimiento']."',
						Resolucion = '".$data['OBLIResolucion']."',
						AnioResolucion	 = '".$data['OBLIAnioResolucion']."',
						TipoEstablecimiento	 = '".$data['OBLITipoEstablecimiento']."',
						Foto = '".$data['OBLIFoto']."',
						Logo = '".$data['OBLILogo']."',
						sostenedor = '".$data['OBLIsostenedor']."'
						
						WHERE 1";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$objResponse->addAlert("Registro Actualizado Correctamente");

	return $objResponse->getXML();
	}
function CargaPagina($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('UTF8');
	
	$sql_esta = "SELECT `NumeroRutEstablecimiento`, `DigitoRutEstablecimiento`, `NombreEstablecimiento`, 
						`DireccionEstablecimiento`, `CiudadEstablecimiento`, `TelefonoEstablecimiento`, 
						`FaxEstablecimiento`, `EMailEstablecimiento`, `NumeroRutRepresentante`,
						`DigitoRutRepresentante`, `PaternoRepresentante`, `MaternoRepresentante`, 
						`NombresRepresentante`, `PeriodoEstablecimiento`, `RegionEstablecimiento`, 
						`ProvinciaEstablecimiento`, `SemestreEstablecimiento`, `UnidadPenDrive`, `RBD`, 
						`NumeroDecreto`, date_format(`FechaDecreto`,'%d/%m/%Y') as FechaDecreto, `PeriodoPostulacion`, `PorcentajeSintesis`, 
						`CorrelativoCertificado`, `CelularEstablecimiento` , `Resolucion` , 
						`AnioResolucion` ,TipoEstablecimiento, `Foto`  , `Logo`, `sostenedor` FROM `Establecimiento` limit 0,1";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$objResponse->addAssign('OBLINumeroRutEstablecimiento', 'value', $row_esta['NumeroRutEstablecimiento']);
	$objResponse->addAssign('OBLINombreEstablecimiento', 'value', $row_esta['NombreEstablecimiento']);
	$objResponse->addAssign('OBLIDireccionEstablecimiento', 'value', $row_esta['DireccionEstablecimiento']);
	$objResponse->addAssign('OBLICiudadEstablecimiento', 'value', $row_esta['CiudadEstablecimiento']);
	$objResponse->addAssign('OBLITelefonoEstablecimiento', 'value', $row_esta['TelefonoEstablecimiento']);
	$objResponse->addAssign('OBLIFaxEstablecimiento', 'value', $row_esta['FaxEstablecimiento']);
	$objResponse->addAssign('OBLIEMailEstablecimiento', 'value', $row_esta['EMailEstablecimiento']);
	$objResponse->addAssign('OBLINumeroRutRepresentante', 'value', $row_esta['NumeroRutRepresentante']);
	$objResponse->addAssign('OBLIPaternoRepresentante','value',  $row_esta['PaternoRepresentante']);
	$objResponse->addAssign('OBLIMaternoRepresentante', 'value', $row_esta['MaternoRepresentante']);
	$objResponse->addAssign('OBLINombresRepresentante', 'value', $row_esta['NombresRepresentante']);
	$objResponse->addAssign('OBLIPeriodoEstablecimiento', 'value', $row_esta['PeriodoEstablecimiento']);
	$objResponse->addAssign('OBLIRegionEstablecimiento', 'value', $row_esta['RegionEstablecimiento']);
	$objResponse->addAssign('OBLIProvinciaEstablecimiento', 'value', $row_esta['ProvinciaEstablecimiento']);
	$objResponse->addAssign('OBLISemestreEstablecimiento', 'value', $row_esta['SemestreEstablecimiento']);
	$objResponse->addAssign('OBLIUnidadPenDrive', 'value', $row_esta['UnidadPenDrive']);
	$objResponse->addAssign('OBLIRBD', 'value', $row_esta['RBD']);
	$objResponse->addAssign('OBLINumeroDecreto', 'value', $row_esta['NumeroDecreto']);
	$objResponse->addAssign('OBLIFechaDecreto', 'value', $row_esta['FechaDecreto']);
	$objResponse->addAssign('OBLIPeriodoPostulacion', 'value', $row_esta['PeriodoPostulacion']);
	$objResponse->addAssign('OBLIPorcentajeSintesis', 'value', $row_esta['PorcentajeSintesis']);
	$objResponse->addAssign('OBLICorrelativoCertificado', 'value', $row_esta['CorrelativoCertificado']);
	$objResponse->addAssign('OBLICelularEstablecimiento','value',  $row_esta['CelularEstablecimiento']);
	$objResponse->addAssign('OBLIResolucion', 'value', $row_esta['Resolucion']);
	$objResponse->addAssign('OBLIAnioResolucion', 'value', $row_esta['AnioResolucion']);
	$objResponse->addAssign('OBLITipoEstablecimiento', 'value', $row_esta['TipoEstablecimiento']);
	$objResponse->addAssign('img_OBLILogo', 'src', $row_esta['Logo']);
	$objResponse->addAssign('OBLILogo','value',  $row_esta['Logo']);
	$objResponse->addAssign('img_OBLIFoto', 'src', $row_esta['Foto']);
	$objResponse->addAssign('OBLIFoto','value',  $row_esta['Foto']);
	$objResponse->addAssign('img_OBLIsostenedor', 'src', $row_esta['sostenedor']);
	$objResponse->addAssign('OBLIsostenedor','value',  $row_esta['sostenedor']);
	
	return $objResponse->getXML();

}  

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
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
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
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
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_establecimiento_ingresar.tpl');

ob_flush();
?>