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

$xajax->setRequestURI("sg_alumnos_Asistencia.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function ConfirmarNotas($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
	
	if (count($seleccion) > 0){
		if ($ingresa == 'SI'){
			$total = count($seleccion);
			foreach ($data['seleccion'] as $ncorr) {
				$nota = $data['nota_'.$ncorr];
				$arr_nota = explode("_",$ncorr);//{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre_{$arrRegistros[registros].prueba}
				$select_notas = "select max(NumeroNota) as maximo
								from Notasalumnos".$anio."
								where  NumeroRutAlumno = '".$arr_nota[0]."' and 
										CodigoCurso = '".$arr_nota[3]."' and 
										CodigoRamo = '".$arr_nota[1]."' and  
										AnoAcademico = '".$arr_nota[2]."' and  
										Semestre = '".$arr_nota[4]."'";
				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
				$row_notas = mysql_fetch_array($res_notas);
				$nro_nota = $row_notas['maximo'] + 1;
				list($dia1,$mes1,$anio1) = explode('-', $data['fecha_'.$ncorr]);
				$fecha_prueba = $anio1.'-'.$mes1.'-'.$dia1;
				$observacion = $data['observacion_'.$ncorr];
				if (($nota<=7)){
					if (($nota!='')){
						$sql_1 = "INSERT INTO `Notasalumnos".$anio."`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
															 `Semestre`, `NumeroNota`, `Prueba`, `Nota`) 
								VALUES ('".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."','".$arr_nota[1]."',
										'".$arr_nota[4]."','".$nro_nota."','".$arr_nota[5]."','".$nota."')";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 
						}
					}
				else{
					$objResponse->addAlert("Error al ingresar Nota");	
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
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
		
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
	
	$anio = $_SESSION["sige_anio_escolar_vigente"];


	$fecha1					=	$data['fecha1'];
	if ($fecha1==''){
		$sql = "select min(InicioPeriodo) as inicio
			from Periodos 
			where AnoAcademico = '".$anio."' ";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);
		$fecha1 = $row['inicio'];
		}
	$fecha2					=	$data['fecha2'];
	if ($fecha2==''){		
		$sql = "select max(TerminoPeriodo) as inicio
			from Periodos 
			where AnoAcademico = '".$anio."' ";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);
		$fecha2 = $row['inicio'];
		}
	$rut					=	$data['rut'];
	
	
                                    
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno, 
									Cursos.NombreCurso,
									Cursos.CodigoCurso
							from alumnos".$anio." 
								inner join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where NumeroRutAlumno = '".$rut."'";
	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());
	$row_RA = mysql_fetch_array($res_nombre_alumno);
	
	$miSmarty->assign("nombre_alumno",$row_RA['nombre_alumno']);
	$miSmarty->assign("nombre_curso",$row_RA['NombreCurso']);
	$objResponse->addAssign('alumno','innerHTML',' - '.$row_RA['nombre_alumno'].' - '.$row_RA['NombreCurso']);
						
	// busca los registros
	$sql_ve = "select DATE_FORMAT(FechaInasistencia, '%d-%m-%Y') ,FechaInasistencia
				from Inasistencias
					
				where Inasistencias.NumeroRutAlumno = '".$rut."' and FechaInasistencia between '".$fecha1."' and '".$fecha2."'
				order by FechaInasistencia";
	
	$res_ve = mysql_query($sql_ve, $conexion);
		$arrRegistros	= 	array();
		$arrRegistros1	= 	array();
		$i = 0;
			array_push($arrRegistros, array("item"					=>	$i, 
											"FechaInasistencia"		=>	"Inasistencias"
											));
			$i++;
		if (mysql_num_rows($res_ve)==0){
			array_push($arrRegistros, array("item"					=>	'', 
											"FechaInasistencia"		=>	"No existen registros"
											));
			
			}
		else{
			while ($line_ve = mysql_fetch_row($res_ve)) {
				$sql_justificativo = "select group_concat(observacion ,',') as observacion, 
												Tipos_justifica.nombre as tipo_justifica
										from Justificativos_Inasistencias
											inner join Tipos_justifica
												on Tipos_justifica.tj_ncorr =  Justificativos_Inasistencias.TipoJusti
										where NumeroRutAlumno = '".$rut."' and 
											'".$line_ve[1]."' between InicioJusti and TerminoJusti  ";
				$res_justificacion = mysql_query($sql_justificativo,$conexion);
				$row_justificacion = mysql_fetch_array($res_justificacion);
				array_push($arrRegistros, array("item"					=>	$i, 
												"FechaInasistencia"		=>	$line_ve[0],
												"Observacion"			=>	$row_justificacion['tipo_justifica'].' - '.$row_justificacion['observacion']
												));
				$i++;
				
				}
			}
	$sql_ve = "select DATE_FORMAT(FechaAtraso, '%d-%m-%Y')
				from Atrasos
					
				where NumeroRutAlumno = '".$rut."' and FechaAtraso between '".$fecha1."' and '".$fecha2."'
				order by FechaAtraso";
	
	$res_ve = mysql_query($sql_ve, $conexion);
		$i = 0;
		
			array_push($arrRegistros, array("item"					=>	$i, 
											"FechaInasistencia"		=>	"Atrasos"
											));
			$i++;
		if (mysql_num_rows($res_ve)==0){
			array_push($arrRegistros, array("item"					=>	'', 
											"FechaInasistencia"		=>	"No existen registros"
											));
			
			}
		else{
			while ($line_ve = mysql_fetch_row($res_ve)) {
				array_push($arrRegistros, array("item"					=>	$i, 
												"FechaInasistencia"		=>	$line_ve[0]
												));
				$i++;
				
				}
			}
		

	$sql_ve = "select count(FechaInasistencia) as contador
					from Inasistencias
					where NumeroRutAlumno = '".$rut."' and FechaInasistencia between '".$fecha1."' and '".$fecha2."'
					";
		
	$res_ve = mysql_query($sql_ve, $conexion);	
	$line_ve = mysql_fetch_row($res_ve);
	array_push($arrRegistros1, array("item"					=>	"Total Inasistencias", 
									"FechaInasistencia"		=>	$line_ve[0]
									));

	$tot_inasistencias = $line_ve[0];

	$CodigoCurso = $row_RA['CodigoCurso'];

	$porc_inasis_nominal = $sum = 0;

	if (($CodigoCurso=='370')||($CodigoCurso=='380')){
		$sql_ve = "select DiasPeriodo as contador
					from Periodos
					where AnoAcademico = '".$anio."' and Semestre = '1'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$DiasPeriodo = $line_ve[0];

		$sql_ve = "select DiasPeriodo4medio as contador
					from Periodos
					where AnoAcademico = '".$anio."' and Semestre = '2'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$DiasPeriodo4medio = $line_ve[0];

		$sum = $DiasPeriodo + $DiasPeriodo4medio;

		$porc_inasis_nominal = 100 - round(($tot_inasistencias*100)/$sum,2);


		}
	else{

		$sql_ve = "select sum(DiasPeriodo) as contador
					from Periodos
					where AnoAcademico = '".$anio."'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$sum  = $line_ve[0];
		$porc_inasis_nominal = 100 - round(($tot_inasistencias*100)/$line_ve[0],2);

		}

	array_push($arrRegistros1, array("item"					=>	"Total Dias Trabajados Nominal", 
	 								"FechaInasistencia"		=>	$sum 
	 								));
	
	array_push($arrRegistros1, array("item"					=>	"% Asistencia Nominal", 
	 								"FechaInasistencia"		=>	$porc_inasis_nominal 
	 								));

	$sql_ve = "select count(FechaAtraso) as contador
				from Atrasos
				where NumeroRutAlumno = '".$rut."' and FechaAtraso between '".$fecha1."' and '".$fecha2."'
				";
	
	$res_ve = mysql_query($sql_ve, $conexion);	
	$line_ve = mysql_fetch_row($res_ve);
	array_push($arrRegistros1, array("item"					=>	"Total Atrasos", 
									"FechaInasistencia"		=>	$line_ve[0]
									));

	

	$miSmarty->assign('arrRegistros', $arrRegistros);
	$miSmarty->assign('arrRegistros1', $arrRegistros1);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_Asistencia_list.tpl'));
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}
function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba,$nro_nota){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_notas_actualizar.php?rut_alumno=".$rut_alumno."&asignatura=".$asignatura."&anio=".$anio."&curso=".$curso."&semestre=".$semestre."&prueba=".$prueba."&nro_nota=".$nro_nota."', 'Actualizar Nota', 800, 600, null);");

	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("ConfirmarNotas");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("ModificarNota");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaAsignaturas");
$xajax->registerFunction("CargaPruebas");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('rut', $_GET['rut']);
$miSmarty->assign('readonly', $_GET['readonly']);

$miSmarty->display('sg_alumnos_Asistencia.tpl');

ob_flush();
?>
