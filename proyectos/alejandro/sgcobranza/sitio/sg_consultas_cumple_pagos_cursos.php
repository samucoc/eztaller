<?php
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_consultas_cumple_pagos_cursos.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data){
    global $conexion;
    global $miSmarty;
    
    $objResponse = new xajaxResponse('UTF8');
	$anio = $_SESSION["sige_anio_escolar_vigente"];

    $curso = $data['curso'];

    if (isset($curso)){

	    $sql_cuota = "select Sum(ValorPactado) as ValorPactado, sum(ValorPagado) as ValorPagado, FechaVencimiento
					  from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
					  	inner join gescolcl_arcoiris_administracion.alumnos".$anio."
					  		on alumnos".$anio.".NumeroRutAlumno = CuentaCorriente".$anio.".NumeroRutAlumno
					  	where FechaVencimiento between '".$_SESSION['sige_anio_escolar_vigente']."-1-1' and 
					  									'".$_SESSION['sige_anio_escolar_vigente']."-12-31' and
					  		alumnos".$anio.".CodigoCurso = '".$curso."'
					  	group by FechaVencimiento asc
						";
		$res_cuota = mysql_query($sql_cuota,$conexion) or die(mysql_error());
		
		$arrRegistros = array();
		$i=0;
		while($row_cuota = mysql_fetch_array($res_cuota)){
			$i++;
			$porcentaje = 100 - (($row_cuota['ValorPagado']*100)/$row_cuota['ValorPactado']);
			list($anio_ele,$mes_ele,$dia_ele) = explode('-',$row_cuota['FechaVencimiento']);
			
			array_push($arrRegistros, array('ncorr'			=>	$i,
							'mes'			=> 	$mes_ele.'-'.$anio_ele,
							'proyectado'	=>	number_format($row_cuota['ValorPactado'],0,'.',','),
							'real'			=>	number_format($row_cuota['ValorPagado'],0,'.',','),
							'porcentaje'	=>	round($porcentaje,2)
							));

			}

		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_consultas_cumple_pagos_cursos_list.tpl'));
			
		}

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

function CargaListado($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','gescolcl_arcoiris_administracion.Cursos','','Todos','CodigoCurso','NombreCurso', '')");
	
	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("Grabar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_consultas_cumple_pagos_cursos.tpl');

?>

