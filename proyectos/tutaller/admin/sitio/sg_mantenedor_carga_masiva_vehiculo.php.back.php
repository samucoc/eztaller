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

$xajax->setRequestURI("sg_mantenedor_carga_masiva_vehiculo.php");
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
			$patente 	= $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
			
			$sql_0 = "insert into personas_tienen_vehiculos(patente) values ('".$patente."')";
            $res_0 = mysql_query($sql_0,$conexion);
							
			$tipo_comb 	= $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
			$sql_1 = "select *
						from tipo_combustible
						where nombre like '%".$tipo_comb."%'";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			$nom_tip_com = $row_1['tip_com_ncorr'];
			
			$tipo 		= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
			$sql_2 = "select *
						from tipo_vehiculo
						where nombre like '%".$tipo."%'";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$row_2 = mysql_fetch_array($res_2);
			$nom_tip = $row_2['tipo_veh_ncorr'];
			
			$marca 		= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
			$modelo 	= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
			$anio 		= $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
			$avaluo 	= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
			$fecha_adq 	= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
			
			$empresa	= $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
			$sql_3 = "select *
						from empresas
						where empe_desc like '%".$empresa."%'";
			$res_3 = mysql_query($sql_3,$conexion) or die(mysql_error());
			$row_3 = mysql_fetch_array($res_3);
			$rut_emp = $row_3['empe_rut'];
			
			$seguro 	= $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
			$sql_4 = "select *
						from meses
						where nombre like '%".$seguro."%'";
			$res_4 = mysql_query($sql_4,$conexion) or die(mysql_error());
			$row_4 = mysql_fetch_array($res_4);
			$mes = $row_4['mes_ncorr'];
			
			$deducible 	= $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
			
			//inserto los datos en la table usuarios:
  		    $sql = "INSERT INTO vehiculos ( `veh_patente` ,`veh_tipo_comb` ,`veh_tipo_veh` , `veh_marca`, `veh_modelo` ,  `veh_anio`,
											`veh_valor_com`, `veh_fech_adq`, `veh_emp` ,`veh_term_seg`,`veh_deducible`  , `veh_estado`)
							VALUES ( '$patente','$nom_tip_com','$nom_tip','$marca','$modelo',
									 '$anio','$avaluo','$fecha_adq','$rut_emp','$mes',
									 '$deducible','1')";
			//echo "<br/>";
			$rst=mysql_query($sql,$conexion); //Ejecutamos la SQL
			if(!$rst) //Comprobamos si hay errores
					die("Error MySQL de Inserción de Datos");
			$i++;
		}
	
	}



$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_mantenedor_carga_masiva_vehiculo.tpl');

?>

