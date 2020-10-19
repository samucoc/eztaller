<?php



include '../includes/php/PHPExcel/Classes/PHPExcel.php';

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax



include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty



$xajax = new xajax();



$xajax->setRequestURI("sg_exportar_alumnos_matriculados.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



if (isset($_POST['btnBuscar']) && $_POST['btnBuscar']=='Grabar'){

	header("Location: sg_exportar_alumnos_matriculados_xlsx.php");

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



$miSmarty->display('sg_exportar_alumnos_matriculados.tpl');



?>



