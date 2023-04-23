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

$xajax->setRequestURI("sg_notas_ingresar.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function ConfirmarNotas($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
				if (($nota<=7)){
					if (($nota!='')){
						$sql_1 = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
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
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	if ($obj1 == 'OBLI-txtCodCobrador'){
        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");
        
            }
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");
	
	return $objResponse->getXML();

}  

function CargaAsignaturas($data){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$CodigoCurso 			= 	$data["curso"];
	$Asignatura				=	$data['asignaturas'];
	$anio					=	$data['anio'];
	$semestre				=	$data['semestre'];
	$prueba					=	$data['pruebas'];
	
			$select_notas = "select max(NumeroNota) as maximo
							from NotasAlumnos 
							where CodigoCurso = '".$CodigoCurso."' and 
								  CodigoRamo = '".$Asignatura."' and  
								  AnoAcademico = '".$anio."' and  
								  Semestre = '".$semestre."' and 
								  NumeroRutAlumno <> ''";
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$row_notas = mysql_fetch_array($res_notas);
			//echo $row_notas['maximo'];
			$miSmarty->assign('notas_ingresadas',$row_notas['maximo']);

	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca los registros
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista, prueba_ncorr
				from alumnos
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
									AnoAcademico, Semestre, NumeroNota
							from NotasAlumnos
							where  NumeroRutAlumno = '".$line_ve[1]."' and 
									CodigoCurso = '".$line_ve[3]."' and 
									CodigoRamo = '".$line_ve[2]."' and  
									AnoAcademico = '".$anio."' and  
									Semestre = '".$semestre."'";
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$j=1;
			$k=0;
			$total = 0;
			$promedio = 0;
			while($row_notas = mysql_fetch_array($res_notas)){
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
											"rut_alumno"			=> 	$row_notas[1], 
											"nota"					=>	$row_notas[0], 
											"nro_nota"					=>	$row_notas[6]
											));
				$total = $row_notas[0] + $total;
				$j++;
				if ($row_notas[0]>0){
					$k++;
					}
				}
			if ($k>0){
				$promedio = $total/$k;
				}
			else{
				$promedio=0;
				}
			array_push($arrRegistrosDetalle, array("item"					=>	$j, 
											"rut_alumno"			=> 	$line_ve[1], 
											"nota"					=>	round($promedio,1)
											));
			
			}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_notas_ingresar_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}
function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba,$nro_nota){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');

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

$miSmarty->display('sg_notas_ingresar.tpl');

ob_flush();
?>

