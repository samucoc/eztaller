<?php

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax



include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley

//include "../includes/php/sgbodega.php"; 

include "../includes/php/validaciones.php"; 

include dirname(__FILE__) . '/../includes/php/PHPExcel/IOFactory.php';

include '../includes/php/PHPExcel/Classes/PHPExcel.php';

include '../includes/php/PHPExcel/Reader/Excel2007.php';





$xajax = new xajax();



$xajax->setRequestURI("sg_importar_matriculas_nro_lista_alumnos.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



if ($_POST['btnBuscar']=='Grabar'){

	global $conexion;

		

	$tipo = $_FILES['archivo']['type'];

	$tamanio = $_FILES['archivo']['size'];

	$archivotmp = $_FILES['archivo']['tmp_name'];



	$archivo = "./archivos/datos.xlsx";

	if (!file_exists($archivo)) {

		exit(EOL);

		}



	if (move_uploaded_file($archivotmp, $archivo) ){

		/**  Identify the type of $inputFileName  **/

		$inputFileType = PHPExcel_IOFactory::identify($archivo);

		/**  Create a new Reader of the type that has been identified  **/

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		/**  Load $inputFileName to a PHPExcel Object  **/

		$objPHPExcel = $objReader->load($archivo);



	    $sheet = $objPHPExcel->getSheet(0); 

		$highestRow = $sheet->getHighestRow(); 



		$anio 			= $_SESSION["sige_anio_escolar_vigente"];

		$fecha 			= $_POST['OBLI-txtFecha'];

		list($d,$m,$a)  = explode('/',$fecha);

		$fecha 			= $a.'-'.$m.'-'.$d;



		$sql = "delete from gescolcl_arcoiris_administracion.Matriculas where Anio = '".$anio."'";

		$res = mysql_query($sql,$conexion) or die(mysql_error());



		for($i = 2;$i<=$highestRow; $i++){

	       	//A = NumeroRutAlumno

			//B = CodigoCurso

			//C = NroMatricula

			//D = NroLista

			

	       	$sql = "insert into gescolcl_arcoiris_administracion.Matriculas (  `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, 

		 														`NroMatricula`, `NroLista` ) 

					values ( 	'".$sheet->getCell('A'.$i)->getValue()."',

								'".$anio."',

								'".$fecha."',

								'".$sheet->getCell('B'.$i)->getValue()."',

								'".$sheet->getCell('C'.$i)->getValue()."',

								'".$sheet->getCell('D'.$i)->getValue()."' )";

			$res = mysql_query($sql,$conexion) or die(mysql_error());



	       	}



	    echo "<script>alert('Proceso terminado con exito')</script>";

		// $lineas = file('archivos/datos.csv');

		// foreach ($lineas as $linea)		{

		// 		$datos 		= explode(';',$linea);

		// 		$alumno 		= trim($datos[0]);

		// 		$anio 			= $_SESSION["sige_anio_escolar_vigente"];

		// 		$fecha 			= date("Y-m-d");

		// 		$nro_matricula	= trim($datos[1]);

		// 		$nro_lista		= trim($datos[2]);

				



		// 		$sql_curso = "select CodigoCurso from gescolcl_nmva_administracion.Cursos where NombreCurso = '".trim($datos[3])."'";

		// 		$res_curso = mysql_query($sql_curso,$conexion) or die(mysql_error());

		// 		$row_curso = mysql_fetch_array($res_curso);



		// 		$CodigoCurso = $row_curso['CodigoCurso'];

		// 		//$CodigoCurso	= trim($datos[1]);

				



		// 		$sql = "insert into gescolcl_nmva_administracion.Matriculas (  `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, 

		// 														`NroMatricula`, `NroLista` ) 

		// 						values ( '$alumno','$anio','$fecha','".$row_curso['CodigoCurso']."','$nro_matricula','$nro_lista' )";

		// 		//echo "<br>"		;

		// 		$res = mysql_query($sql,$conexion) or die(mysql_error());





		// 		$sql = "update gescolcl_nmva_administracion.alumnos".$anio." 

		// 					set 

		// 					NumeroLista = '".$nro_lista."',

		// 					NumeroMatricula = '".$nro_matricula."'

		// 				where NumeroRutAlumno = '".$alumno."' ";

						

		// 		//$res = mysql_query($sql,$conexion) or die(mysql_error());

		// 	}

		}

	else{

		echo "error";

		}

	

	}



function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){

	global $conexion;

	

        $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$obj1", "value", $campo1);

	$objResponse->addAssign("$obj2", "value", $campo2);



	return $objResponse->getXML();

}



function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");

	

  	return $objResponse->getXML();



}  



function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$rut = $data[$objeto1];

	$empresa = $data['OBLIcboEmpresa'];

	

	if ($tabla == 'sggeneral.trabajadores'){

		$campo2 = "concat(nombres,' ',apellido_pat,' ',apellido_mat)";

		}

	if ($tabla == 'sgyonley.sectores'){

		$c_and = ' and empe_ncorr in (select empe_ncorr from sgyonley.empresas where empe_rut = "'.$empresa.'" )';

		}

	$sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '$rut' $c_and ";

	

	$res = mysql_query($sql, $conexion) or die(mysql_error());

	

	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));;

	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));;

	return $objResponse->getXML();

}



function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	

    if ($tabla != 'personas'){

           $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";

        } 

    else{

            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";

        }

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

function CargaPopWin($data, $url){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');



	$url = $url .'&empresa='.$data['OBLIcboEmpresa'];

	$objResponse->addScript("showPopWin('".$url."', 'Busca Trabajador', 550, 350, null);");



	return $objResponse->getXML();

	

}



$xajax->registerFunction("Grabar");

$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CargaPopWin");

$xajax->registerFunction("Eliminar");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->display('sg_importar_matriculas_nro_lista_alumnos.tpl');



?>



