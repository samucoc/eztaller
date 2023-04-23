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

$xajax->setRequestURI("sg_informes_alumnos_notas.php");
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
	
	$anio					=	$data['anio'];
	$semestre				=	$data['semestre'];
	$rut 					=   $data['rut'];
	$arrRegistros			= 	array();
	$arrRegistrosDetalle	= 	array();
	$arrRegistrosPrueba		= 	array();
	$arrRegistrosMaximo		= 	array();
		
	$miSmarty->assign('nombre_semestre',$semestre.' - '.$anio);

	$select_notas = "select max(NumeroNota) as NumeroNota, CodigoRamo
							from Pruebas
							where Pruebas.CodigoCurso in (select CodigoCurso 
													from alumnos 
													where NumeroRutAlumno = '".$rut."' ) and 
								  Pruebas.AnoAcademico = '".$anio."' and  
								  Pruebas.Semestre = '".$semestre."' 
							group by CodigoRamo
							order by NumeroNota desc
							limit 0,1
								";
	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
	$maximo = 0;
	$ramo = "";
	while ($row_notas = mysql_fetch_array($res_notas)){
		$maximo = $row_notas['NumeroNota'];
		$ramo = $row_notas['CodigoRamo'];
		}
	
	$select_notas = "select CoeficientePrueba
							from Pruebas
							where Pruebas.CodigoCurso in (select CodigoCurso 
													from alumnos 
													where NumeroRutAlumno = '".$rut."' ) and 
								  Pruebas.AnoAcademico = '".$anio."' and  
								  Pruebas.Semestre = '".$semestre."' and
								  Pruebas.CodigoRamo = '".$ramo."' 
								";
	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
	$i = 1;
	while ($row_notas = mysql_fetch_array($res_notas)){
		for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
			array_push($arrRegistrosMaximo, array("nro_nota"	=>	$i));
			$i++;
			}
		}
	
	//var_dump($arrRegistrosMaximo);
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	// busca los registros
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, 
						NumeroLista, Pruebas.CoeficientePrueba, Ramos.Descripcion
				from alumnos
					inner join Cursos
						on alumnos.CodigoCurso = Cursos.CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso 
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 
					inner join Pruebas
						on  Pruebas.CodigoCurso in (select CodigoCurso 
													from alumnos 
													where NumeroRutAlumno = '".$rut."' )
				where
				Cursos.CodigoCurso in (select CodigoCurso 
													from alumnos 
													where NumeroRutAlumno = '".$rut."' )and 
				Pruebas.prueba_ncorr in (select prueba_ncorr  
											from Pruebas 
											where CodigoCurso in (select CodigoCurso 
													from alumnos 
													where NumeroRutAlumno = '".$rut."' )  and
												AnoAcademico = '".$anio."' and 
												Semestre = '".$semestre."' 
											) 
				and alumnos.NumeroRutAlumno = '".$rut."' and Pruebas.CodigoRamo = 'ARTE'
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista
				order by NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	//$objResponse->addAlert($sql_ve);
	if (mysql_num_rows($res_ve) > 0){
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
											"prueba"				=> 	$prueba,
											"nombre_asignatura"		=> 	$line_ve[6]
											));
			$i++;
			$select_notas = "select prueba_ncorr , CoeficientePrueba
								from Pruebas
							where  Pruebas.CodigoCurso = '".$line_ve[3]."' and 
									Pruebas.CodigoRamo = '".$line_ve[2]."' and  
									Pruebas.AnoAcademico = '".$anio."' and  
									Pruebas.Semestre = '".$semestre."'";
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$j=1;
			$k=0;
			$total = 0;
			$promedio = 0;
			$codigo_ramo = "";

			while($row_notas = mysql_fetch_array($res_notas)){

				$select_notas_1 = "select Nota
							from NotasAlumnos
								inner join Pruebas
									on Pruebas.prueba_ncorr = NotasAlumnos.Prueba
							where  NotasAlumnos.NumeroRutAlumno = '".$line_ve[1]."' and 
									NotasAlumnos.CodigoCurso = '".$line_ve[3]."' and 
									NotasAlumnos.CodigoRamo = '".$line_ve[2]."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '".$semestre."' and 
									Pruebas.prueba_ncorr = '".$row_notas['prueba_ncorr']."'";
				$res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
				if (mysql_num_rows($res_notas_1)>0){
					while($row_notas_1 = mysql_fetch_array($res_notas_1)){
						for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
							array_push($arrRegistrosDetalle, array("item"					=>	$j, 
														"rut_alumno"			=> 	$row_notas_1[1], 
														"nota"					=>	$row_notas_1[0], 
														"CodigoRamo"			=>	$row_notas_1[3], 
														"prueba"				=>	$row_notas_1[7], 
														"nro_nota"				=>	$row_notas_1[6],
														"nombre_prueba"			=>	$row_notas_1[8]
														));
							$total = $row_notas_1[0] + $total;
							$codigo_ramo = $row_notas_1[3];
							$j++;
							if ($row_notas_1[0]>0){
								$k++;
								}
							}
						}
					}
				else{
					
					for($r=0;$r<$line_ve[5];$r++){
						array_push($arrRegistrosDetalle, array("item"					=>	$j, 
													"rut_alumno"			=> 	$line_ve[1], 
													"nota"					=>	'0', 
													"CodigoRamo"			=>	$line_ve[2]
													));
						$total = 0 + $total;
						$codigo_ramo = $line_ve[2];
						$j++;
						if ($row_notas[0]>0){
							$k++;
							}
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
												"CodigoRamo"			=>	$codigo_ramo, 
												"nota"					=>	round($promedio,1)
												));
				}
			}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);
		$miSmarty->assign('arrRegistrosPrueba', $arrRegistrosPrueba);
		$miSmarty->assign('arrRegistrosMaximo', $arrRegistrosMaximo);
    		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_alumnos_notas_list.tpl'));
		
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
$miSmarty->assign('rut', $_GET['rut']);

$miSmarty->display('sg_informes_alumnos_notas.tpl');

ob_flush();
?>

