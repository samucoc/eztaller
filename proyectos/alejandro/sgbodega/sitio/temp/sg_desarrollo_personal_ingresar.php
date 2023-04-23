<?php
ob_start();
session_start();
set_time_limit(999999);
date_default_timezone_set('America/Santiago');
ini_set('memory_limit', '1024M');

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_desarrollo_personal_ingresar.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function ConfirmarDP($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
	
	if (count($seleccion) > 0){
		if ($ingresa == 'SI'){
			$total = count($seleccion);
			foreach ($data['seleccion'] as $ncorr) {
				$nota = $data['dp_'.$ncorr];
				$arr_nota = explode("_",$ncorr);//{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre_{$arrRegistros[registros].itemdesa}
				$sql_busca = "select * 
							  from DesarrolloPersonal 
							  where `itemdesa_ncorr` = '".$arr_nota[4]."' AND RutAlumno = '".$arr_nota[0]."' AND 
							  		`CodigoCurso` = '".$arr_nota[0]."' AND `Semestre` = '".$arr_nota[3]."' AND
									`Anio` = '".$arr_nota[1]."'";
				$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
				if (mysql_num_rows($res_busca)>0){
					$sql_1  ="update DesarrolloPersonal set
								Concepto = '".$nota."'
								 where `itemdesa_ncorr` = '".$arr_nota[4]."', RutAlumno = '".$arr_nota[0]."', 
							  		`CodigoCurso` = '".$arr_nota[0]."', `Semestre` = '".$arr_nota[3]."', 
									`Anio` = '".$arr_nota[1]."'";
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
					}
				else{
					$sql_1 = "INSERT INTO `DesarrolloPersonal`(`itemdesa_ncorr`,RutAlumno, `CodigoCurso`, `Semestre`, 
																	 `Anio`, `Concepto`) 
								VALUES ('".$arr_nota[4]."','".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."',
										'".$arr_nota[1]."','".$nota."')";
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 
					}
				}
			}
		}
		
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");	
	
    return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	if ($obj1 == 'OBLI-txtCodCobrador'){
        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");
        
            }
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");
	
	return $objResponse->getXML();

}  

function CargaAsignaturas($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$select 		= 'asignaturas';
	$codigo_curso 	= $data['curso'];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select CodigoRamo as codigo, Descripcion as descripcion 
			from Ramos 
			where CodigoRamo in (select CodigoRamo
								from Asignaturas
								where CodigoCurso = '".$codigo_curso."')";
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
function CargaPruebas($data,$codigo_asignaturas){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$select 				= 'pruebas';
	$codigo_curso 			= $data['curso'];
	$anio 					= $data['anio'];
	$semestre 			= $data['semestre'];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select prueba_ncorr as codigo, DescripcionPrueba as descripcion 
			from Pruebas 
			where CodigoRamo = '".$codigo_asignaturas."'  and  
				CodigoCurso = '".$codigo_curso."'  and
				AnoAcademico = '".$anio."' and 
				Semestre = '".$semestre."'";
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

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$CodigoCurso 			= 	$data["curso"];
	$anio					=	$data['anio'];
	$semestre				=	$data['semestre'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca los registros
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						`NumeroRutAlumno`, Cursos.CodigoCurso, NumeroLista
				from alumnos
					inner join Cursos
						on alumnos.CodigoCurso = Cursos.CodigoCurso
				where
				Cursos.CodigoCurso = '".$CodigoCurso."' 
				order by NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$arrRegistrosDetalle	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {
			array_push($arrRegistros, array("item"					=>	$i, 
											"nombre_alumno"			=> 	$line_ve[0], 
											"rut_alumno"			=> 	$line_ve[1],
											"curso" 				=> 	$line_ve[2],
											"nro_lista_alumno" 		=> 	$line_ve[3],
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre
											));
			$i++;
			$select_notas = "select ItemsDesarrollo.itemdesa_ncorr
							from ItemsDesarrollo"; 
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$j=1;
			while($row_notas = mysql_fetch_array($res_notas)){
				$sql_busca_dp = "select Concepto 
								from DesarrolloPersonal 
								where RutAlumno = '".$line_ve[1]."' and 
								  CodigoCurso = '".$CodigoCurso."' and 
								  Semestre = '".$semestre."' and
								  Anio = '".$anio."' and
								  itemdesa_ncorr = '".$row_notas[0]."'
								 order by dp_ncorr desc
								 limit 0,1";
				$res_busca_dp = mysql_query($sql_busca_dp,$conexion) or die(mysql_error());
				$row_busca_dp = mysql_fetch_array($res_busca_dp);
				$concepto = $row_busca_dp['Concepto'];
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
											"rut_alumno"			=> 	$line_ve[1], 
											"itemdesa"				=>	$row_notas[0] , 
											"concepto"				=>	$concepto 
											));
				$j++;
				}
			}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_desarrollo_personal_ingresar_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}
function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_notas_actualizar.php?rut_alumno=".$rut_alumno."&asignatura=".$asignatura."&anio=".$anio."&curso=".$curso."&semestre=".$semestre."&prueba=".$prueba."', 'Actualizar Nota', 800, 600, null);");

	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("ConfirmarDP");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("ModificarNota");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaAsignaturas");
$xajax->registerFunction("CargaPruebas");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_desarrollo_personal_ingresar.tpl');

ob_flush();
?>

