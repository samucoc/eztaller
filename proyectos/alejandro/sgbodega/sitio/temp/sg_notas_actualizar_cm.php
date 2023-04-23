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

$xajax->setRequestURI("sg_notas_actualizar_cm.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$curso = $data['curso'];
	$asignatura = $data['asignatura'];
	$anio = $data['anio'];
	$semestre = $data['semestre'];
	$prueba = $data['prueba'];
	$nro_nota  = $data['nro_nota'];
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
	
	if (count($seleccion) > 0){
		if ($ingresa == 'SI'){
			$total = count($seleccion);
			$flag=0;
			foreach ($data['seleccion'] as $ncorr) {
				$nota = $data['nota_'.$ncorr];
				$arr_nota = explode("_",$ncorr);
				
				if (($nota>=1)&&($nota<=7)){
					$select_notas ="select * 
									from NotasAlumnos
									where  NumeroRutAlumno = '".$arr_nota[0]."' and 
									CodigoCurso = '".$curso."' and 
									CodigoRamo = '".$asignatura."' and  
									AnoAcademico = '".$anio."' and  
									Semestre = '".$semestre."' and  
									NumeroNota = '".$nro_nota."'";
					$res_notas = mysql_query($select_notas,$conexion) or die(mysql_error());
					if (mysql_num_rows($res_notas)>0){
						$select_notas = "update NotasAlumnos
											set Nota = '".$nota."'
											where   NumeroRutAlumno = '".$arr_nota[0]."' and 
													CodigoCurso = '".$curso."' and 
													CodigoRamo = '".$asignatura."' and  
													AnoAcademico = '".$anio."' and  
													Semestre = '".$semestre."' and  
													NumeroNota = '".$nro_nota."'";
						$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
						
						}
					else{
						$insert_nota = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
																	`Semestre`, `NumeroNota`, `Nota`) 
										VALUES ('".$arr_nota[0]."','".$anio."','".$curso."','".$asignatura."',
												'".$semestre."','".$nro_nota."','".$nota."')";
						$res_notas = mysql_query($insert_nota, $conexion) or die(mysql_error());
						}
				}
				else{
					if ($nota==''){
						$select_notas ="select * 
										from NotasAlumnos
										where  NumeroRutAlumno = '".$arr_nota[0]."' and 
										CodigoCurso = '".$curso."' and 
										CodigoRamo = '".$asignatura."' and  
										AnoAcademico = '".$anio."' and  
										Semestre = '".$semestre."' and  
										NumeroNota = '".$nro_nota."'";
						$res_notas = mysql_query($select_notas,$conexion) or die(mysql_error());
						if (mysql_num_rows($res_notas)>0){
							$select_notas = "update NotasAlumnos
												set Nota = ''
												where   NumeroRutAlumno = '".$arr_nota[0]."' and 
														CodigoCurso = '".$curso."' and 
														CodigoRamo = '".$asignatura."' and  
														AnoAcademico = '".$anio."' and  
														Semestre = '".$semestre."' and  
														NumeroNota = '".$nro_nota."'";
							$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
							
							}
						else{
							$insert_nota = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
																		`Semestre`, `NumeroNota`, `Nota`) 
											VALUES ('".$arr_nota[0]."','".$anio."','".$curso."','".$asignatura."',
													'".$semestre."','".$nro_nota."','')";
							$res_notas = mysql_query($insert_nota, $conexion) or die(mysql_error());
							}		
						$flag++;
						}	
					else{
						$sql_1 ="select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre
								from alumnos".$anio."
								where `NumeroRutAlumno` = '".$arr_nota[0]."'
								";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
						$row_1 = mysql_fetch_array($res_1);
						$nombre = $row_1['nombre'];
						$objResponse->addAlert("Error al ingresar Nota de $nombre. Se dejara como pendiente.");	
						break;
						}
					}
				}
			$sql_notas_01 = "select Nota from NotasAlumnos
					where CodigoCurso = '".$curso."' and 
							CodigoRamo = '".$asignatura."' and  
							AnoAcademico = '".$anio."' and  
							Semestre = '".$semestre."' and
							NumeroNota = '".$nro_nota."'
							and Nota != ''";
			$res_nota_01 = mysql_query($sql_notas_01,$conexion);
			$muy_malo = $malo = $insuficiente = $suficiente = $bueno = $muy_bueno = $excelente = 0;
			while($row_notas_01=mysql_fetch_array($res_nota_01)){
					if (($row_notas_01['Nota']>='1')&&($row_notas_01['Nota']<'4'))$insuficiente++;
					if (($row_notas_01['Nota']>='4')&&($row_notas_01['Nota']<'5'))$suficiente++;
					if (($row_notas_01['Nota']>='5')&&($row_notas_01['Nota']<'6'))$bueno++;
					if (($row_notas_01['Nota']>='6')&&($row_notas_01['Nota']<='7'))$muy_bueno++;
					}

				$select_notas_01 = "update Pruebas
							set insuficiente = '".$insuficiente."', 
								suficiente = '".$suficiente."', bueno = '".$bueno."', muy_bueno = '".$muy_bueno."'
							where   
									CodigoCurso = '".$curso."' and 
									CodigoRamo = '".$asignatura."' and  
									AnoAcademico = '".$anio."' and  
									Semestre = '".$semestre."' and
									NumeroNota = '".$nro_nota."'";
				$res_notas_01 = mysql_query($select_notas_01, $conexion) or die(mysql_error());

		}
	$objResponse->addAlert("Registro Actualizado");	
	if ($flag>0){
		$objResponse->addAlert("Quedan $flag notas pendientes.");	
		}
	$objResponse->addScript("window.parent.hidePopWin(true)");	
	$objResponse->addScript("window.parent.xajax_CargaListado(window.parent.xajax.getFormValues('Form1'))");
	}
	else{
		$objResponse->addAlert("Registro no Actualizado. Error en la nota");	
		}
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
	
	$curso = $data['curso'];
	$asignatura = $data['asignatura'];
	$anio = $data['anio'];
	$semestre = $data['semestre'];
	$prueba = $data['prueba'];
	
	$sql = "select NombreCurso
			from Cursos 
			where CodigoCurso = '".$curso."'";
	$res = mysql_query($sql, $conexion);
	$row = mysql_fetch_array($res);
	$objResponse->addAssign('txt_curso','value',$row['NombreCurso']);
	
	$sql = "select CodigoRamo as codigo, Descripcion as descripcion 
			from Ramos 
			where CodigoRamo = '".$asignatura."'";
	$res = mysql_query($sql, $conexion);
	$row = mysql_fetch_array($res);
	$objResponse->addAssign('txt_asignatura','value',$row['descripcion']);
	
	$objResponse->addAssign('txt_anio','value',$anio);
	
	$objResponse->addAssign('txt_semestre','value',$semestre.' Semestre');
	
	$sql = "select concat(NumeroNota, '- ',DescripcionPrueba) as descripcion 
			from Pruebas 
			where 
				CodigoCurso = '".$curso."' and 
				CodigoRamo = '".$asignatura."' and  
				AnoAcademico = '".$anio."' and  
				Semestre = '".$semestre."' and
				NumeroNota = '".$prueba."' ";
	$res = mysql_query($sql, $conexion);
	$row = mysql_fetch_array($res);
	$objResponse->addAssign('txt_prueba','value',$row['descripcion']);
	
	$sql = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno
				from alumnos
			where NumeroRutAlumno = '".$rut_alumno."'";
	$res = mysql_query($sql, $conexion);
	$row = mysql_fetch_array($res);
	$objResponse->addAssign('txt_alumno','value',$row['nombre_alumno']);
		
	
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

function ReconocerNro($data,$ncorr){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$nota = $data['nota_'.$ncorr];

	if ($nota==''){


	}
	else{
		if (($nota>=1)&&($nota<=7)){
		
		}
		else{
			$arr_nota = explode("_",$ncorr);
			$sql_1 ="select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre
					from alumnos".$anio."
					where `NumeroRutAlumno` = '".$arr_nota[0]."'
					";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			$nombre = $row_1['nombre'];
			$objResponse->addAlert("Error al ingresar Nota de $nombre. Se dejara como pendiente.");	
			$objResponse->addAssign('nota_'.$ncorr,'value','');
		}
	}

	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$CodigoCurso 			= 	$data["curso"];
	$Asignatura				=	$data['asignatura'];
	$anio					=	$_SESSION["sige_anio_escolar_vigente"];
	$semestre				=	$data['semestre'];
	$prueba					=	$data['prueba'];
	$nro_nota				=	$data['nro_nota'];
	
	// busca los registros
 	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						alumnos".$anio.".NumeroRutAlumno, Asignaturas.CodigoRamo, Cursos.CodigoCurso, Matriculas.NroLista, 
						Pruebas.NumeroNota
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'  
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso 
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo and
							Ramos.CodigoRamo = '".$Asignatura."'
					inner join Pruebas
						on  Pruebas.AnoAcademico = '".$anio."'  and  
							Pruebas.CodigoRamo = '".$Asignatura."'  and  
							Pruebas.CodigoCurso = '".$CodigoCurso."' 
				where
				alumnos".$anio.".Matriculado = '1' and 
				Cursos.CodigoCurso = '".$CodigoCurso."' and 
				Pruebas.NumeroNota = '".$prueba."' and 
				Cursos.CodigoCurso in  (select CodigoCurso from Asignaturas where Asignaturas.CodigoRamo = '".$Asignatura."')
				order by Matriculas.NroLista";
	
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
			$select_notas = "select coalesce(Nota, '0') as Nota, alumnos".$anio.".NumeroRutAlumno
							from NotasAlumnos
								left join alumnos".$anio."
									on NotasAlumnos.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno
							where  NotasAlumnos.NumeroRutAlumno = '".$line_ve[1]."' and 
									NotasAlumnos.CodigoCurso = '".$line_ve[3]."' and 
									NotasAlumnos.CodigoRamo = '".$line_ve[2]."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '".$semestre."' and
									NotasAlumnos.NumeroNota = '".$nro_nota."'";
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$j=1;
			if (mysql_num_rows($res_notas)==0){
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
												"rut_alumno"			=> 	$line_ve[1], 
												"nota"					=>	''
												));
					$j++;
				}
			else{
				while($row_notas = mysql_fetch_array($res_notas)){
					array_push($arrRegistrosDetalle, array("item"					=>	$j, 
												"rut_alumno"			=> 	$row_notas[1], 
												"nota"					=>	$row_notas[0]
												));
					$j++;
					}
				}
			}
			
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_notas_actualizar_cm_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	
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
$xajax->registerFunction("ReconocerNro");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('anio',$_GET['anio']);
$miSmarty->assign('semestre',$_GET['semestre']);
$miSmarty->assign('curso',$_GET['curso']);
$miSmarty->assign('asignatura',$_GET['asignatura']);
$miSmarty->assign('prueba',$_GET['prueba']);
$miSmarty->assign('nro_nota',$_GET['nro_nota']);


$miSmarty->display('sg_notas_actualizar_cm.tpl');

ob_flush();
?>

