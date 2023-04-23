<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";

$xajax = new xajax();

$xajax->setRequestURI("sg_mantenedor_carga_masiva_trabajador.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

if (isset($_POST['btnGrabar'])) {
	global $conexion;
	
	    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    
    if ($archivo != "") {
        // guardamos el archivo a la carpeta files
        $destino =  "cargas_masivas/".$archivo;
        if (copy($_FILES['archivo']['tmp_name'],$destino)) {
            $status = "Archivo subido: <b>".$archivo."</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    	}
	
	$objReader = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $objReader->load("cargas_masivas/".$archivo); //cargamos el archivo excel (extensión *.xlsx)
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
	
		//Obtenemos un listado de usuarios desde un archivo excel
		$i=2; //Si existiera una fila con los títulos inicial $i=2
		//Recorremos las filas del excel
		while($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue() != '') {	
			$rut = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
			$paterno = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
			$materno = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
			$nombre = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
			
			//inserto los datos en la table usuarios:
			$sql = "INSERT INTO personas (pers_rut, pers_nombre, pers_ape_pat, pers_ape_mat) VALUES ('$rut','$nombre','$paterno','$materno')";
			$rst=mysql_query($sql,$conexion); //Ejecutamos la SQL
			if(!$rst) //Comprobamos si hay errores
					die("Error MySQL de Inserción de Datos");
			$i++;
		}
	
	}


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_mantenedor_carga_masiva_trabajador.tpl');

?>

