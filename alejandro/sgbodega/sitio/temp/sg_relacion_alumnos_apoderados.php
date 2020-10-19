<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 
$xajax = new xajax();

$xajax->setRequestURI("sg_relacion_alumnos_apoderados.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');

	$anio = $data['periodo'];
	$arrRegistros = array();
	
	if ($anio!=''){
		$sql = "select  alumnos".$anio.".NumeroRutAlumno, 
						concat(alumnos".$anio.".PaternoAlumno, ' ',alumnos".$anio.".MaternoAlumno, ' ',alumnos".$anio.".NombresAlumno) as alumno, 
						Apoderados.NumeroRutApoderado,
						concat(Apoderados.PaternoApoderado, ' ',Apoderados.MaternoApoderado, ' ',Apoderados.NombresApoderado) as apoderado, 
						Cursos.CodigoCurso,
						Cursos.NombreCurso,
						TelefonoParticularApoderado,
						TelefonoMovilApoderado,
						EmailApoderado
					from gescolcl_nmva_administracion.Apoderados
							inner join gescolcl_nmva_administracion.alumnos".$anio."
								on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado 							
							inner join gescolcl_nmva_administracion.Matriculas
								on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
							inner join gescolcl_nmva_administracion.Cursos
								on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					order by alumnos".$anio.".CodigoCurso, concat(alumnos".$anio.".PaternoAlumno, ' ',alumnos".$anio.".MaternoAlumno, ' ',alumnos".$anio.".NombresAlumno)
					";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
			$alumno 						= "";
			$apoderado 						= "";
			$TelefonoParticularApoderado 	= "";
			$TelefonoMovilApoderado			= "";
			$NombreCurso 	  				= "";
		if (mysql_num_rows($res)>0){
			while($row = mysql_fetch_array($res)){
				$alumno 						= 	$row['alumno'];
				$NumeroRutAlumno 				= 	$row['NumeroRutAlumno'].'-'.dv($row['NumeroRutAlumno']);
				$apoderado 						= 	$row['apoderado'];
				$NumeroRutApoderado 			= 	$row['NumeroRutApoderado'].'-'.dv($row['NumeroRutApoderado']);
				$TelefonoParticularApoderado 	= 	$row['TelefonoParticularApoderado'];
				$TelefonoMovilApoderado			= 	$row['TelefonoMovilApoderado'];
				$CodigoCurso 	  				= 	$row['CodigoCurso'];
				$NombreCurso 	  				= 	$row['NombreCurso'];
				$EmailApoderado 	  			= 	$row['EmailApoderado'];
				array_push($arrRegistros, array(	"apoderado" 	  				=> 	$apoderado,
													"NumeroRutApoderado" 	  		=> 	$NumeroRutApoderado,
													"TelefonoParticularApoderado" 	=> 	$TelefonoParticularApoderado,
													"TelefonoMovilApoderado" 	  	=> 	$TelefonoMovilApoderado,
													"alumno" 	  					=> 	$alumno,
													"NumeroRutAlumno" 	  			=> 	$NumeroRutAlumno,
													"CodigoCurso" 	  				=> 	$CodigoCurso,
													"NombreCurso" 	  				=> 	$NombreCurso,
													"EmailApoderado" 	  			=> 	$EmailApoderado));
				}
			}

		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_relacion_alumnos_apoderados_list.tpl'));
		}
	return $objResponse->getXML();
	
	}
function CargaListado($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');

 	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'periodo','Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
            

	return $objResponse->getXML();
	
	}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
    if ($tabla == 'Profesores'){
		$campo2 = " concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) ";
		} 
	if ($opt=='OBLICodigoCurso'){
		$ramo = $data['OBLICodigoCurso'];
		$curso = $data['OBLICodigoRamo'];
		if ($ramo=='Elija'){
			$opt = 'where NumeroRutProfesor in (select distinct NumeroRutProfesor 
											from Pruebas 
											where CodigoRamo = "'.$curso.'")';
		
			}
		else{
		$opt = 'where NumeroRutProfesor in (select distinct NumeroRutProfesor 
											from Pruebas 
											where CodigoCurso = "'.$ramo.'" and CodigoRamo = "'.$curso.'")';
			
			}
		}
	if ($select == 'OBLICodigoRamo'){
			$ramo = $data['OBLICodigoCurso'];
			if ($ramo=='Elija'){
				}
			else{
				$opt = 'where CodigoRamo in (select CodigoRamo
				from Asignaturas
				where CodigoCurso = "'.$ramo.'")';
				}
	}
		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	//$objResponse->addAlert($sql);
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		$j = 0;
		$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", '');
			$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 	
		$j++;	
		if ($descripcion!=''){
			}
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
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_relacion_alumnos_apoderados.tpl');


ob_flush();
?>
