<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_proceso_generar_archivo_situacion_final.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


if ($_POST['grabar']=='Realizar Archivo'){
	global $conexion;

	$curso  = $_POST['curso'];

    $anio 	= $_SESSION["sige_anio_escolar_vigente"];
	$file = fopen("sf_".$curso.".txt", "w");
	

	$sql_insert = "select  `NumeroRutAlumno`, `AnoAcademico`, `Situacion`, `ObservacionSituacion`	,
							`PromedioAno`, `AsistenciaAno`, Cursos.`CodigoCurso`, 
							`SexoAlumno`, `NumeroLista`, `CodigoUsuario`, NombreCurso
					from `SituacionFinal`
						inner join Cursos
							on SituacionFinal.CodigoCurso = Cursos.CodigoCurso
					where Cursos.CodigoCurso = '".$curso."' and 
							AnoAcademico = '".$_SESSION["sige_anio_escolar_vigente"]."'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	while($row_insert = mysql_fetch_array($res_insert)){

			$sql_esta = "select  RBD
						from Establecimiento
				";
			$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
			$row_esta = mysql_fetch_array($res_esta);
			
			list($a,$b,$c) = explode(' ',$row_insert['NombreCurso']);
			$c = substr($c,0,1);
			list($RBD_Rut,$RBD_Dv) = explode('-', $row_esta['RBD']);
			
			if ($row_insert['Situacion']=='0'){
				$row_insert['Situacion'] = 'R';
				}
			elseif ($row_insert['Situacion']=='1'){
				$row_insert['Situacion'] = 'P';
				}
			else{
				$row_insert['Situacion'] = 'Y';
				}
			$curso_ant='';
			if ($curso > '300'){
				$curso_ant = '310';
				}
			else{
				$curso_ant= '110';
				}
			
			if ($c=='O') $c='B';



			fwrite($file, "5\t".$RBD_Rut."\t".$RBD_Dv."\t".$curso_ant."\t".$a."\t".$c."\t".$_SESSION["sige_anio_escolar_vigente"]."\t".$row_insert['NumeroRutAlumno']."\t".dv($row_insert['NumeroRutAlumno'])."\t".($row_insert['PromedioAno'])."\t".substr(str_pad(($row_insert['AsistenciaAno']),2),0,2)."\t".(utf8_decode($row_insert['ObservacionSituacion']))."\t".($row_insert['Situacion'])."\t1\r\n");
	
		}
	fclose($file);
	
	header('Location: sg_descarga_situacion_final.php?nombre_archivo=sf_'.$curso);
	}

function CargaPagina($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');
	
	$where  = '"%ADMISION%"';
    $where_1  = '"%EGRESADO%"';
    $where_2  = '"%PROCESO%"';
            
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', 'where NombreCurso not like ".$where." and NombreCurso not like ".$where_1." and NombreCurso not like ".$where_2." ')");	return $objResponse->getXML();
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

$miSmarty->display('sg_proceso_generar_archivo_situacion_final.tpl');


ob_flush();
?>