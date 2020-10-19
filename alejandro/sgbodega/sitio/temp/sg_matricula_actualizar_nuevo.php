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

$xajax->setRequestURI("sg_matricula_actualizar_nuevo.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$rut_alumno = $data['rut_alumno'];
	$autoriza = $data['autoriza'];
	$anio = $_SESSION["sige_anio_escolar_vigente"];
    
    $anio_sup = $anio+1;
	if ($autoriza==1){
		$select_apoderado = "SELECT ApoderadoPostulante FROM Postulantes WHERE NumeroRutAlumno = '".$rut_alumno."'";
		$res_apoderado = mysql_query($select_apoderado,$conexion);
		$row_apoderado = mysql_fetch_array($res_apoderado);

		if ($row_apoderado['ApoderadoPostulante']=='0'){
			$objResponse->addAlert("Postulante no tiene Apoderado asignado");		
			}
		else{
			$select_notas = "INSERT INTO alumnos".$anio_sup." (`NumeroRutAlumno`, `DigitoRutAlumno`, `PaternoAlumno`, `MaternoAlumno`, 
														`NombresAlumno`, `DireccionParticularAlumno`, `CiudadParticularAlumno`, 
														`TelefonoParticularAlumno`, `CodigoCurso`, `FechaIngreso`, `FechaNacimiento`, 
														`SexoAlumno`, `OtroColegio`, `ColegioAnterior`, `CodigoComuna`, NumeroRutApoderado)
							SELECT 	`NumeroRutAlumno`, '".dv($rut_alumno)."', `PaternoAlumno`, `MaternoAlumno`, `NombresAlumno`,
									`DireccionParticularAlumno`, `CiudadParticularAlumno`, `TelefonoParticularAlumno`, 
									`CodigoCurso`, ".date("Y-m-d").",`FechaNacimiento`, `SexoAlumno`, `OtroColegio`, 
									`ColegioAnterior`, `CodigoComuna`, ApoderadoPostulante
							FROM Postulantes WHERE NumeroRutAlumno = '".$rut_alumno."'";
			$res_notas = mysql_query($select_notas, $conexion);
			$select_notas = "update Postulantes set Autorizado = '1' WHERE NumeroRutAlumno = '".$rut_alumno."';";
			$res_notas = mysql_query($select_notas, $conexion);
			$objResponse->addAlert("Registro Actualizado");		
			}
		}
	else{
			$select_alumnos = "select Matriculado from alumnos".$anio_sup." where NumeroRutAlumno = '".$rut_alumno."'";
			$res_alumnos = mysql_query($select_alumnos,$conexion);
			$row_alumnos = mysql_fetch_array($res_alumnos);
			if ($row_alumnos['Matriculado']=='0'){
				$select_alumnos = "delete from alumnos".$anio_sup." where NumeroRutAlumno = '".$rut_alumno."'";
				$res_alumnos = mysql_query($select_alumnos,$conexion);
				$select_notas = "update Postulantes set Autorizado = '2' WHERE NumeroRutAlumno = '".$rut_alumno."';";
				$res_notas = mysql_query($select_notas, $conexion);
				$objResponse->addAlert("Registro No Autorizado");		
				}
			else{
				$objResponse->addAlert("Alumno ya matriculado");		
				
				}

		}	
	$objResponse->addScript("window.parent.hidePopWin(true)");	
	$objResponse->addScript("window.parent.xajax_CargaListado(window.parent.xajax.getFormValues('Form1'))");
	
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
	
	$rut_alumno = $data['rut_alumno'];
	
	$sql = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
					NombreCurso
				from Postulantes
					inner join Cursos
						on Cursos.CodigoCurso = Postulantes.CodigoCurso
			where NumeroRutAlumno = '".$rut_alumno."'";
	$res = mysql_query($sql, $conexion);
	$row = mysql_fetch_array($res);
	$objResponse->addAssign('txt_alumno','value',$row['nombre_alumno']);
	$objResponse->addAssign('txt_curso','value',$row['NombreCurso']);
		
	
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
	$Asignatura				=	$data['asignaturas'];
	$anio 					= 	$_SESSION["sige_anio_escolar_vigente"];
    $semestre				=	$data['semestre'];
	$prueba					=	$data['pruebas'];
	
			$select_notas = "select max(NumeroNota) as maximo
							from NotasAlumnos 
							where CodigoCurso = '".$CodigoCurso."' and 
								  CodigoRamo = '".$Asignatura."' and  
								  AnoAcademico = '".$anio."' and  
								  Semestre = '".$semestre."' and 
								  NumeroRutAlumno <> ''";
			$res_notas = mysql_query($select_notas, $conexion);
			$row_notas = mysql_fetch_array($res_notas);
			//echo $row_notas['maximo'];
			$miSmarty->assign('notas_ingresadas',$row_notas['maximo']);

	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca los registros
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista, prueba_ncorr
				from alumnos".$anio."
					inner join Cursos
						on alumnos.CodigoCurso = Cursos.CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso 
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo and
							Ramos.CodigoRamo = '".$Asignatura."'
					inner join Pruebas
						on  Pruebas.CodigoRamo = '".$Asignatura."'  and  
							Pruebas.CodigoCurso = '".$CodigoCurso."' 
				where
				Cursos.CodigoCurso = '".$CodigoCurso."' and 
				Pruebas.prueba_ncorr = '".$prueba."' and 
				Cursos.CodigoCurso in  (select CodigoCurso from Asignaturas where Asignaturas.CodigoRamo = '".$Asignatura."')
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
											"asignatura" 			=> 	$line_ve[2],
											"curso" 				=> 	$line_ve[3],
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nro_lista_alumno"		=> 	$line_ve[4],
											"prueba"				=> 	$line_ve[5]
											));
			$i++;
			$select_notas = "select Nota, NumeroRutAlumno, CodigoCurso, CodigoRamo, 
									AnoAcademico, Semestre
							from NotasAlumnos
							where  NumeroRutAlumno = '".$line_ve[1]."' and 
									CodigoCurso = '".$line_ve[3]."' and 
									CodigoRamo = '".$line_ve[2]."' and  
									AnoAcademico = '".$anio."' and  
									Semestre = '".$semestre."'";
			$res_notas = mysql_query($select_notas, $conexion);
			$j=1;
			while($row_notas = mysql_fetch_array($res_notas)){
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
											"rut_alumno"			=> 	$row_notas[1], 
											"nota"					=>	$row_notas[0]
											));
				$j++;
				}
			}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_matricula_actualizar_nuevo_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaAsignaturas");
$xajax->registerFunction("CargaPruebas");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('rut_alumno',$_GET['rut_alumno']);

$miSmarty->display('sg_matricula_actualizar_nuevo.tpl');

ob_flush();
?>

