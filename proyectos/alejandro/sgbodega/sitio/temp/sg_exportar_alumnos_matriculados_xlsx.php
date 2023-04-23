<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax



include '../includes/php/PHPExcel/Classes/PHPExcel.php';

include '../includes/php/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';



include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley

//include "../includes/php/sgbodega.php"; 

include "../includes/php/validaciones.php"; 



	global $conexion;





		$objPHPExcel = new PHPExcel();



			$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");

			$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");

			$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");

			$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");

			$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");



			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', ("Rut del alumno")); // Titulo del reporte

			$objPHPExcel->getActiveSheet()->SetCellValue('B1',  "Dirgito alumno");  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->SetCellValue('C1',  ("Apellido Paterno"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->SetCellValue('D1',  ("Apellido Materno"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->SetCellValue('E1',  ("Nombres"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->setCellValue('F1',  ("Codigo Nivel"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->setCellValue('G1',  ("Nombre Nivel"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->setCellValue('H1',  ("Codigo Curso"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->setCellValue('I1',  ("Curso"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->setCellValue('J1',  ("Nro Matricula"));  //Titulo de las columnas

			$objPHPExcel->getActiveSheet()->setCellValue('K1',  ("Nro Lista"));  //Titulo de las columnas

			$i = 2;



			$anio = $_SESSION["sige_anio_escolar_vigente"];

			

			$sql = "select  alumnos".$anio.".NumeroRutAlumno, alumnos".$anio.".DigitoRutAlumno, 

							PaternoAlumno, MaternoAlumno, NombresAlumno, 

							NombreCurso,  Cursos.CodigoNivel, Cursos.CodigoCurso

					from gescolcl_arcoiris_administracion.alumnos".$anio."

						inner join gescolcl_arcoiris_administracion.Cursos

							on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

					where alumnos".$anio.".Matriculado = '1' 

					order by Cursos.CodigoNivel, Cursos.CodigoCurso, PaternoAlumno, MaternoAlumno, NombresAlumno";

			$res = mysql_query($sql,$conexion) or die(mysql_error());

			while($row = mysql_fetch_array($res)){

			

						if ($row['CodigoCurso']<'100'){

							$nivel = 'PREBASICA';

							}

						else if (($row['CodigoCurso']>='100')&&($row['CodigoCurso']<='299')){

							$nivel = 'BASICA';

							}

						else{

							$nivel = 'MEDIA';

							}



						$objPHPExcel->setActiveSheetIndex(0);

						$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$row['NumeroRutAlumno']);

						$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$row['DigitoRutAlumno']);

						$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,str_replace('\u00d1', '\u00D1', utf8_encode($row['PaternoAlumno'])));

						$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,str_replace('\u00d1', '\u00D1', utf8_encode($row['MaternoAlumno'])));

						$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,str_replace('\u00d1', '\u00D1', utf8_encode($row['NombresAlumno'])));

						$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$row['CodigoNivel']);

						$objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$nivel);

						$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$row['CodigoCurso']);

						$objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$row['NombreCurso']);

						

					$i++;

	



					}					

			

			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

			$objWriter->save('archivo_salida.xlsx');



			$enlace = 'archivo_salida.xlsx';

			header ("Content-Disposition: attachment; filename=$enlace ");

			header ("Content-Type: application/force-download");

			header ("Content-Length: ".filesize($enlace));

			readfile($enlace);







?>