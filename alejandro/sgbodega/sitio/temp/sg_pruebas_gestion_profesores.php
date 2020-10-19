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

$xajax->setRequestURI("sg_pruebas_gestion_profesores.php");
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
								from NotasAlumnos
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
				if (($nota>=1)||($nota<=7)){
					$sql_1 = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
														 `Semestre`, `NumeroNota`, `Prueba`, `Nota`) 
							VALUES ('".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."','".$arr_nota[1]."',
									'".$arr_nota[4]."','".$nro_nota."','".$arr_nota[5]."','".$nota."')";
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 
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
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'profesores','Profesores','','- - Seleccione - -','NumeroRutProfesor','concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`)', '')");
	
	return $objResponse->getXML();

}  

function CargaPeriodos($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("semestre","innerHTML",""); 		
	
	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$data['anio']."'";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
            $objResponse->addCreate("semestre","option",""); 		
			$objResponse->addAssign("semestre","options[".$j."].value", '0');
			$objResponse->addAssign("semestre","options[".$j."].text", 'Elija'); 
			$j++;	
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("semestre","option",""); 		
			$objResponse->addAssign("semestre","options[".$j."].value", $line[0]);
			$objResponse->addAssign("semestre","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
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
function CargaPruebas($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$select 				= 'profesores';
	$codigo_curso 			= $data['curso'];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select NumeroRutProfesor as codigo, concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor)  as descripcion 
			from Profesores  
			where NumeroRutProfesor in (select Profesor 
										from Asignaturas 
										where CodigoCurso = '".$codigo_curso."')";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
		$j=0;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value",'');
			$objResponse->addAssign("$select","options[".$j."].text", 'Todos'); 	
			$j++;
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
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value",'');
			$objResponse->addAssign("$select","options[".$j."].text", 'Todos'); 	
			$j++;
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
	$Profesor				=	$data['profesores'];
	$anio					=	$data['anio'];
	$semestre				=	$data['semestre'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	if (($anio!='')&&($semestre!='')){
		$and1="";
		$and2="";
		if (($CodigoCurso!='')&&($CodigoCurso!='Todos')){
			$and1 = " Asignaturas.CodigoCurso = '".$CodigoCurso."' and ";
			}
		if (($Profesor!='')&&($Profesor!='Todos')){
			$and1 = " Asignaturas.Profesor = '".$Profesor."' and ";
			}

		// busca los registros
		$sql_ve = "select  distinct concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor,
							Cursos.CodigoCurso , Ramos.CodigoRamo , Asignaturas.CodigoRamo, Cursos.CodigoCurso, Profesores.NumeroRutProfesor, Ramos.Descripcion, NombreCurso
					from Asignaturas
						inner join Ramos
							on Asignaturas.CodigoRamo = Ramos.CodigoRamo
						inner join Cursos
							on Asignaturas.CodigoCurso = Cursos.CodigoCurso
						inner join Profesores 
							on Profesores.NumeroRutProfesor = Asignaturas.Profesor 
					where
					$and1
					$and2
					1
					order by Ramos.Descripcion asc";
		
		$res_ve = mysql_query($sql_ve, $conexion);
		if (mysql_num_rows($res_ve) > 0){
			$arrRegistros	= 	array();
			$arrRegistrosDetalle	= 	array();
			$i = 1;
			while ($line_ve = mysql_fetch_row($res_ve)) {
				
				$miSmarty->assign('anio_busqueda', $anio);
				$miSmarty->assign('periodo_busqueda',$semestre);
				$miSmarty->assign('curso_busqueda',$line_ve[7]);
				
				array_push($arrRegistros, array("item"					=>	$i, 
												"nombre_alumno"			=> 	$line_ve[0], 
												"curso"					=> 	$line_ve[1],
												"asignatura"			=> 	$line_ve[2],
												"FechaPrueba" 			=> 	$line_ve[3],
												"fecha_tope" 			=> 	$line_ve[4],
												"prueba_ncorr" 			=> 	$line_ve[5],
												"nombre_asignatura"		=> 	$line_ve[6]
												));
				$i++;
				$select_notas = "select NumeroRutProfesor, DATEDIFF(FechaPrueba,FechaRealPrueba) as intervalo,
										date_format(FechaPrueba,'%d-%m-%Y') as FechaPrueba, FechaRealPrueba, 
										CodigoCurso, CodigoRamo, NumeroNota,
										DescripcionPrueba, CoeficientePrueba
							from Pruebas
							where  NumeroRutProfesor = '".$line_ve[5]."' and 
									CodigoCurso = '".$line_ve[1]."' and 
									CodigoRamo = '".$line_ve[2]."' and  
									AnoAcademico = '".$anio."' and  
									Semestre = '".$semestre."' ";
				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
				$j=1;
				$k=0;
				$total = 0;
				$promedio = 0;
				while($row_notas = mysql_fetch_array($res_notas)){
					
					$select_notas_1 = "select NumeroNota
									from NotasAlumnos
									where CodigoCurso = '".$line_ve[1]."' and 
											CodigoRamo = '".$line_ve[2]."' and  
											AnoAcademico = '".$anio."' and  
											Semestre = '".$semestre."' and
											NumeroNota = '".$row_notas['NumeroNota']."'";
					$res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
					$row_notas_1 = mysql_fetch_array($res_notas_1);
				
					if ($row_notas_1['NumeroNota']!=''){
						$cant_dias = 'SI';
						}
					else{
						$cant_dias = 'NO';
						}
					array_push($arrRegistrosDetalle, array("item"					=>	$j, 
												"prueba_ncorr"			=> 	$row_notas[0], 
												"cant_dias"				=>	$cant_dias, 
												"FechaPrueba"			=>	$row_notas[2], 
												"FechaRealPrueba"		=>	$row_notas[3], 
												"curso"					=>	$row_notas[4], 
												"asignatura"			=>	$row_notas[5], 
												"DescripcionPrueba"		=>	$row_notas[7], 
												"CoeficientePrueba"		=>	$row_notas[8], 
												"NumeroNota"		=>	$row_notas['NumeroNota'], 
												"Semestre"		=>	$semestre, 
												"AnoAcademico"		=>	$anio
												));
					$j++;
					}
				}
			
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);
	
			$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_pruebas_gestion_profesores_list.tpl'));
			
		}else{
			
			$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
		}
	}
	else{
		$objResponse->addAssign("divabonos", "innerHTML", "Elija un periodo.");
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

function CargaVentana($data,$curso,$asignatura,$NumeroNota,$Semestre,$AnoAcademico){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_pruebas_gestion_profesores_visor.php?asignatura=".$asignatura."&anio=".$AnoAcademico."&curso=".$curso."&semestre=".$Semestre."&prueba=".$NumeroNota."', 'Detalle Prueba', 800, 600, null);");

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
$xajax->registerFunction("CargaPeriodos");
$xajax->registerFunction("CargaVentana");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_pruebas_gestion_profesores.tpl');

ob_flush();
?>

