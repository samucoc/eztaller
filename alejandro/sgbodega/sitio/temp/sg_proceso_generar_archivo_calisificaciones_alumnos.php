<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_proceso_generar_archivo_calisificaciones_alumnos.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


if ($_POST['grabar']=='Realizar Archivo'){
	global $conexion;

	$curso  = $_POST['curso'];

    $anio 	= $_SESSION["sige_anio_escolar_vigente"];
	$file = fopen("cf_".$curso.".txt", "w");
	
	$arrRegistros			= 	array();
	$arrRegistrosDetalle_1	= 	array();
	$arrRegistrosDetalle_2	= 	array();
	$arrRegistrosDetalle_total 	= 	array();
	$arrRegistrosPrueba		= 	array();
	$arrRegistrosMaximo		= 	array();

	$sql_pd = "select 
				alumnos".$anio.".NumeroRutAlumno,
				Cursos.NombreCurso,
				concat(Cursos.DecretoPlanes,Year(FechaDecretoPlanes)) as DecretoFechaPlanes
				from alumnos".$anio."
					inner join Cursos
						on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where alumnos".$anio.".CodigoCurso = '".$curso."'
				group by alumnos".$anio.".NumeroRutAlumno"; 
	
	$res_pd = mysql_query($sql_pd, $conexion) OR die(mysql_error());
	$arrRegistros		= 	array();
	$i 					= 	1;
	while ($line_pd = mysql_fetch_row($res_pd)) {
			$rut = $line_pd[0];

			$sql_nfa = "SELECT distinct `NumeroRutAlumno`, `AnoAcademico`, Asignaturas.CodigoCurso, 
												Asignaturas.CodigoRamo, `NotaFinalCurso` , Asignaturas.CodigoRamoRECH
										FROM `NotasFinalesAsignaturas` 
											inner join Asignaturas
												on NotasFinalesAsignaturas.CodigoRamo = Asignaturas.CodigoRamo
										WHERE NumeroRutAlumno = '".$rut."' and 
											AnoAcademico = '".$anio."' and 
											NotaFinalCurso > 0 and
											Asignaturas.CodigoCurso = '".$curso."'
										group by NumeroRutAlumno, AnoAcademico, Asignaturas.CodigoCurso, Asignaturas.CodigoRamo";
			$res_nfa = mysql_query($sql_nfa,$conexion) or die(mysql_error());
			while($row_nfa = mysql_fetch_array($res_nfa)){
				$prom_total = $row_nfa['NotaFinalCurso'];
				$CodigoRamoRECH = $row_nfa['CodigoRamoRECH'];
				
				$sql_esta = "select  RBD from Establecimiento";
				$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
				$row_esta = mysql_fetch_array($res_esta);
				
				list($a,$b,$c) = explode(' ',$line_pd[1]);
				$c = substr($c,0,1);
				list($RBD_Rut,$RBD_Dv) = explode('-', $row_esta['RBD']);
					
				$curso_ant = '';
				if ($curso > '300'){
					$curso_ant = '310';
					}
				else{
					$curso_ant= '110';
					}
				if ($c=='O') $c='B';

				fwrite($file, "4\t".$RBD_Rut."\t".$RBD_Dv."\t".$curso_ant."\t".$a."\t".$c."\t".$anio."\t".$rut."\t".dv($rut)."\t".$line_pd[2]."\t".$line_pd[2]."\t".$CodigoRamoRECH."\t".round($prom_total,1,PHP_ROUND_HALF_UP)."\t\r\n");
				}
			}

	fclose($file);
	
	header('Location: sg_descarga_situacion_final.php?nombre_archivo=cf_'.$curso);
	}

function CargaPagina($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');
	
	$where  = '"%ADMISION%"';
    $where_1  = '"%EGRESADO%"';
    $where_2  = '"%PROCESO%"';
            
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', 'where NombreCurso not like ".$where." and NombreCurso not like ".$where_1." and NombreCurso not like ".$where_2." ')");

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
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_proceso_generar_archivo_calisificaciones_alumnos.tpl');


ob_flush();
?>