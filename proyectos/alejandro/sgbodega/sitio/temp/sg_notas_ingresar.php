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
				if (($nota<=7)||($nota=='')){
						$sql_1 = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
															 `Semestre`, `NumeroNota`, `Nota`) 
								VALUES ('".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."','".$arr_nota[1]."',
										'".$arr_nota[4]."','".$nro_nota."','".$nota."')";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 
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
					$sql_1 = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
														 `Semestre`, `NumeroNota`, `Nota`) 
							VALUES ('".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."','".$arr_nota[1]."',
									'".$arr_nota[4]."','".$nro_nota."','')";
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 
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
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]	."')");
	
	return $objResponse->getXML();

}  

function CargaPeriodos($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("semestre","innerHTML",""); 		
	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$anio."'";
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
            $objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", '');
			$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 
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
function CargaPruebas($data,$codigo_asignaturas){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$select 				= 'pruebas';
	$codigo_curso 			= $data['curso'];
	$anio 					= $_SESSION["sige_anio_escolar_vigente"];
	$semestre 			= $data['semestre'];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select prueba_ncorr as codigo, concat(NumeroNota, '- ',DescripcionPrueba) as descripcion 
			from Pruebas 
			where CodigoRamo = '".$codigo_asignaturas."'  and  
				CodigoCurso = '".$codigo_curso."'  and
				AnoAcademico = '".$anio."' and 
				Semestre = '".$semestre."' and 
				NumeroNota not in (select NumeroNota 
									from NotasAlumnos 
									where CodigoRamo = '".$codigo_asignaturas."'  and  
											CodigoCurso = '".$codigo_curso."'  and
											AnoAcademico = '".$anio."' and 
											Semestre = '".$semestre."')
			order by NumeroNota";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
		   $j=0;
            $objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", '');
			$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 
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
			$objResponse->addAssign("$select","options[".$j."].value", $codigo);
			$objResponse->addAssign("$select","options[".$j."].text", $descripcion); 	
			
                while ($line = mysql_fetch_array($res)) {
			$j++;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			
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
	$anio					=	$data['anio'];
	$semestre				=	$data['semestre'];
	$prueba					=	$data['pruebas'];
	$arrRegistros			= 	array();
	$arrRegistrosDetalle	= 	array();
	$arrRegistrosPrueba		= 	array();
		
	$select_notas = "select max(NumeroNota) as maximo
					from Pruebas 
					where CodigoCurso = '".$CodigoCurso."' and 
						  CodigoRamo = '".$Asignatura."' and  
						  AnoAcademico = '".$anio."' and  
						  Semestre = '".$semestre."' ";
	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
	$row_notas = mysql_fetch_array($res_notas);
	//echo $row_notas['maximo'];
	$miSmarty->assign('notas_ingresadas',$row_notas['maximo']);

	$select_notas = "select SituacionFinal
					from Cursos 
					where CodigoCurso = '".$CodigoCurso."' ";
	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
	$row_notas = mysql_fetch_array($res_notas);
	//echo $row_notas['maximo'];
	$miSmarty->assign('situacion_final',$row_notas['SituacionFinal']);

	$select_notas = "select distinct Pruebas.NumeroNota, Pruebas.CodigoCurso, Pruebas.CodigoRamo, 
									Pruebas.AnoAcademico, Pruebas.Semestre, Pruebas.NumeroNota, CoeficientePrueba,
									DescripcionPrueba
							from  Pruebas
								
							where Pruebas.CodigoCurso = '".$CodigoCurso."' and 
								  Pruebas.CodigoRamo = '".$Asignatura."' and  
								  Pruebas.AnoAcademico = '".$anio."' and  
								  Pruebas.Semestre = '".$semestre."'  
							";
	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
	while ($row_notas = mysql_fetch_array($res_notas)){
		for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
			array_push($arrRegistrosPrueba, array(
									"NumeroNota"			=> 	$row_notas['NumeroNota'], 
									"CodigoCurso"			=>	$row_notas['CodigoCurso'], 
									"CodigoRamo"			=>	$row_notas['CodigoRamo'], 
									"AnoAcademico"			=>	$row_notas['AnoAcademico'],
									"Semestre"				=>	$row_notas['Semestre'],
									"Prueba"				=>	$row_notas['NumeroNota'],
									"DescripcionPrueba"		=>	$row_notas['DescripcionPrueba']
									));
			}
		}
			
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	$anio = $_SESSION["sige_anio_escolar_vigente"];
	// busca los registros
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						alumnos".$anio.".NumeroRutAlumno, Asignaturas.CodigoRamo, Cursos.CodigoCurso, Matriculas.NroLista, 
						Pruebas.CoeficientePrueba
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
				Pruebas.NumeroNota in (select NumeroNota  
											from Pruebas 
											where CodigoRamo = '".$Asignatura."'  and  
												CodigoCurso = '".$CodigoCurso."'  and
												AnoAcademico = '".$anio."' and 
												Semestre = '".$semestre."' 
											) and 
				Cursos.CodigoCurso in  (select CodigoCurso from Asignaturas where Asignaturas.CodigoRamo = '".$Asignatura."')
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, Matriculas.NroLista
				order by Matriculas.NroLista";
	
	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());
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
											"prueba"				=> 	$prueba
											));
			$i++;
			$select_pruebas = "select CodigoCurso, CodigoRamo, AnoAcademico, Semestre, NumeroNota, DescripcionPrueba
							from Pruebas
							where  CodigoCurso = '".$line_ve[3]."' and 
									CodigoRamo = '".$line_ve[2]."' and  
									AnoAcademico = '".$anio."' and  
									Semestre = '".$semestre."'
							order by Pruebas.NumeroNota
							";
			$res_pruebas = mysql_query($select_pruebas, $conexion) or die(mysql_error());
			$j=1;
			$k=0;
			$total = 0;
			$promedio = 0;

			while($row_pruebas = mysql_fetch_array($res_pruebas)){
				$select_notas = "select Nota, NumeroRutAlumno, NotasAlumnos.CodigoCurso, NotasAlumnos.CodigoRamo, 
									NotasAlumnos.AnoAcademico, NotasAlumnos.Semestre, NotasAlumnos.NumeroNota
							from NotasAlumnos
							where  NotasAlumnos.NumeroRutAlumno = '".$line_ve[1]."' and 
									NotasAlumnos.CodigoCurso = '".$row_pruebas['CodigoCurso']."' and 
									NotasAlumnos.CodigoRamo = '".$row_pruebas['CodigoRamo']."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '".$semestre."' and  
									NotasAlumnos.NumeroNota = '".$row_pruebas['NumeroNota']."'
							";
				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
				if (mysql_num_rows($res_notas)>0){
					$row_notas = mysql_fetch_array($res_notas);
					for($r=0;$r<$line_ve[5];$r++){
						$nota_prueba = str_replace(',', '.', $row_notas['Nota']);
						substr($nota_prueba, -1)  == '0' ? '' :  $nota_prueba = round($nota_prueba,2) ; 
						array_push($arrRegistrosDetalle, array("item"					=>	$j, 
														"rut_alumno"			=> 	$row_notas['NumeroRutAlumno'], 
														"nota"					=>	$nota_prueba,
														"prueba"				=>	$row_notas['NumeroNota'], 
														"nro_nota"				=>	$row_notas['NumeroNota'],
														"nombre_prueba"			=>	$row_pruebas['DescripcionPrueba']
													));
						$total = $nota_prueba + $total;
						$j++;
						if ($row_notas[0]>0){
							$k++;
							}
						}
					}
						
				else{
					array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[1],
															"nota"					=>	'--',
															"prueba"				=>	$row_pruebas['NumeroNota'],
															"nro_nota"				=>	$row_pruebas['NumeroNota'],
															"nombre_prueba"			=>	$row_pruebas['DescripcionPrueba']
															));
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
		$miSmarty->assign('arrRegistrosPrueba', $arrRegistrosPrueba);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_notas_ingresar_list.tpl'));

		$sql = "select NombreCurso
			from Cursos 
			where CodigoCurso = '".$CodigoCurso."'";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);
		//$objResponse->addAlert($row['NombreCurso']);
		$objResponse->addAssign('txt_curso','innerHTML',$row['NombreCurso']);
		
		$sql = "select Descripcion as descripcion 
				from Ramos 
				where 
					CodigoRamo = '".$Asignatura."' ";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);
		$objResponse->addAssign('txt_asignatura','innerHTML',$row['descripcion']);
		
		$objResponse->addAssign('txt_anio','innerHTML',$anio);
		
		$objResponse->addAssign('txt_semestre','innerHTML',$semestre.' Semestre');
		
		$sql = "select DescripcionPrueba as descripcion 
				from Pruebas 
				where prueba_ncorr = '".$prueba."'";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);
		$objResponse->addAssign('txt_prueba','innerHTML',$row['descripcion']);

		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}
function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba,$nro_nota,$nota){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_notas_actualizar.php?rut_alumno=".$rut_alumno."&asignatura=".$asignatura."&anio=".$anio."&curso=".$curso."&semestre=".$semestre."&prueba=".$prueba."&nro_nota=".$nro_nota."&nota=".$nota."', 'Actualizar Nota', 800, 600, null);");

	return $objResponse->getXML();
	}

function ModificarNotaCM($data,$nro_nota,$curso,$asignatura,$anio,$semestre,$prueba){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_notas_actualizar_cm.php?nro_nota=".$nro_nota."&curso=".$curso."&anio=".$anio."&asignatura=".$asignatura."&semestre=".$semestre."&prueba=".$prueba."', 'Actualizar Nota Carga Masiva', 800, 600, null);");

	return $objResponse->getXML();
	}

function Nueva($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$curso		 			= 	$data["curso"];
	$asignatura				=	$data['asignaturas'];
	$anio					=	$data['anio'];
	$semestre				=	$data['semestre'];
	$prueba					=	$data['pruebas'];
	
	$objResponse->addScript("showPopWin('sg_notas_ingresar_cm.php?curso=".$curso."&anio=".$anio."&asignatura=".$asignatura."&semestre=".$semestre."&prueba=".$prueba."', 'Ingresar Nota Carga Masiva', 800, 600, null);");

	return $objResponse->getXML();
	}

function EliminarNota($data,$nro_nota,$curso,$asignatura,$anio,$semestre,$prueba){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$select_notas = "delete from NotasAlumnos
					where  NumeroNota = '".$nro_nota."' and 
							CodigoCurso = '".$curso."' and 
							CodigoRamo = '".$asignatura."' and  
							AnoAcademico = '".$anio."' and  
							Semestre = '".$semestre."' ";
	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

	$objResponse->addAlert("Registro Eliminado");	
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");	
	
	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("ConfirmarNotas");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("ModificarNota");
$xajax->registerFunction("ModificarNotaCM");
$xajax->registerFunction("Nueva");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaAsignaturas");
$xajax->registerFunction("CargaPruebas");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("EliminarNota");
$xajax->registerFunction("EliminarNota");
$xajax->registerFunction("CargaPeriodos");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_notas_ingresar.tpl');

ob_flush();
?>

