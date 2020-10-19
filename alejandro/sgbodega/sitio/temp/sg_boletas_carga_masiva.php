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

$xajax->setRequestURI("sg_boletas_carga_masiva.php");
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
            $status = "Archivo subido: ".$archivo."";
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
		$empresa = $_POST['empresa'];
		$mes	 = $_POST['cboMes'];
		$anio 	 = $_POST['cboAnio'];
		while($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue() != '') {	
			$fecha = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
			$boleta = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
			$monto = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
			
			list($dia3,$mes3,$anio3) = split('[/.-]', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;

			$sql = "select cier_fecha
					from cierres where empe_rut = '".$empresa."' order by cier_fecha desc limit 1";
			$res = mysql_query($sql, $conexion);
			$ult_cierre = @mysql_result($res,0,"cier_fecha");
			// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
			$sql_dif =	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
			$res_dif = mysql_query($sql_dif,$conexion);
			$dias_dif = @mysql_result($res_dif,0,"dias_dif");
			$ingresa = "SI";
			if ($dias_dif <= 0){
				$ingresa = 'NO';
				$status_1 .= $boleta.", ";
				}
				
			$sql = "select * from boletas where nro_boleta = ".$boleta;
			$res = mysql_query($sql,$conexion);
			if (mysql_num_rows($res)==0){
				if ($ingresa == 'SI'){
					//inserto los datos en la table boletas:
					$sql = "insert into `boletas` (`empresa`, `nro_boleta`, `fecha`, `monto`, `mes`, `anio`) values 
							('".$empresa."','".$boleta."','".$fecha."','".$monto."','".$mes."','".$anio."')";
					$res = mysql_query($sql, $conexion) or die(mysql_error());
					}
				}
			else{
				$status_2 .= $boleta.", ";
				
				}
			$i++;
		}
	echo "<script>";
	if ($status_1!=''){
		echo "alert('Boletas rechazadas por fecha: ".$status_1."');";
		}
	if ($status_2!=''){
		echo "alert('Boletas duplicadas : ".$status_2."');";
		}
	if (($status_1=='')&&($status_2=='')){
		echo "alert('Datos Guardados');";
		}
	echo "</script>"; 
	}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'empresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	       
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

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_boletas_carga_masiva.tpl');

?>

