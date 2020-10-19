<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
/*
include "../includes/php/class.phpmailer.php";
include "../includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";
*/
$xajax = new xajax();

$xajax->setRequestURI("sg_informes_certificado_matricula.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Enviar($data,$arrRegistros){

}

function Grabar($data){
	global $conexion;
	global $miSmarty;
        set_time_limit(100000);
        
	$objResponse = new xajaxResponse('UTF8');
	
	$curso                     =       $data['OBLIRutAlumno'];
    $observacion                     =       $data['observacion'];

    $anio =   $_SESSION["sige_anio_escolar_vigente"];
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql_esta = "select NombreEstablecimiento, Resolucion, AnioResolucion, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno
				from Establecimiento
				";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$miSmarty->assign('nombre_colegio',$row_esta['NombreEstablecimiento']);
	$miSmarty->assign('resolucion',$row_esta['Resolucion']);
	$miSmarty->assign('anio_resolucion',$row_esta['AnioResolucion']);
	$miSmarty->assign('RBD',$row_esta['RBD']);
	$miSmarty->assign('Logo',$row_esta['Logo']);
	$miSmarty->assign('Foto',$row_esta['Foto']);
	$miSmarty->assign('Representante',$row_esta['nombre_alumno']);
	$miSmarty->assign('anio',$anio);
	
	$sql_pd = "select 
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				Matriculas.NumeroRutAlumno,
				NombreCurso,
				Matriculas.FechaRetiro
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and Matriculas.Anio = '".$anio."'
				where Matriculas.NumeroRutAlumno = '".$curso."'"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	$arrRegistros		= 	array();
	$i 					= 	1;
	$flag= '';
	while ($line_pd = mysql_fetch_row($res_pd)) {
		
		$miSmarty->assign('nombre_alumno',$line_pd[0]);
		$miSmarty->assign('rut',$line_pd[1].'-'.dv($line_pd[1]));
		$miSmarty->assign('nombre_curso',$line_pd[2]);

		$flag = $line_pd[3];
                   
	}
	$miSmarty->assign('observacion',$observacion);
	if ($flag=='0000-00-00'){
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_certificado_matricula_list.tpl'));	
		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);	
		}
	elseif ($flag==''){
		$sql_pd = "select 
			concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
			alumnos".$anio.".NumeroRutAlumno,
			NombreCurso
			from alumnos".$anio."
				inner join Cursos
					on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
			where alumnos".$anio.".NumeroRutAlumno = '".$curso."' and alumnos".$anio.".Matriculado='1'"; 
		$res_pd = mysql_query($sql_pd, $conexion);
		if (mysql_num_rows($res_pd)>0){
			while ($line_pd = mysql_fetch_row($res_pd)) {
				$miSmarty->assign('nombre_alumno',$line_pd[0]);
				$miSmarty->assign('rut',$line_pd[1].'-'.dv($line_pd[1]));
				$miSmarty->assign('nombre_curso',$line_pd[2]);
				$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_certificado_matricula_list.tpl'));	
				$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
			}	
		}else{
			$objResponse->addAlert("Alumno no se encuentra matriculado");
			$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
		}
	}
	else{
		list($a,$m,$d) = explode('-',$flag);
		$flag = $d.'-'.$m.'-'.$a;
		$objResponse->addAlert("Alumno retirado con fecha: ".$flag);
		$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
		}
	

	return $objResponse->getXML();
}
function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_certificado_matricula_list.tpl'));
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('UTF8');
	
        $objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");
        return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLI-txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
                $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
	}else{
		
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0) {
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

function CargaSubFamilias($data){
    global $conexion;	
    $objResponse = new xajaxResponse('UTF8');
	
	$familia	=	$data["cboFamilia"];
	
        $objResponse->addAssign("OBLI-txtCodProducto", "value", "");
	$objResponse->addAssign("OBLI-txtDescProducto", "value", "");
	
	$objResponse->addAssign("cboSubFamilia","innerHTML",""); 		
	
	if 	($familia != 'Todas' &&  $familia != ''){
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";
	}else{
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO != '' group by SF_NOMBRE ORDER BY SF_NOMBRE ASC";
	}	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0) {
			$objResponse->addCreate("cboSubFamilia","option",""); 		
			$objResponse->addAssign("cboSubFamilia","options[0].value", '');
			$objResponse->addAssign("cboSubFamilia","options[0].text", 'Todas'); 	
			$j = 1;
			while ($line = mysql_fetch_array($res)) {
				$objResponse->addCreate("cboSubFamilia","option",""); 		
				$objResponse->addAssign("cboSubFamilia","options[".$j."].value", $line[0]);
				$objResponse->addAssign("cboSubFamilia","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
	//}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");
	
	//$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	return $objResponse->getXML();
}          
function LlamaDetalle($data, $codigo, $descripcion){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	$cobrador			= 	$data["OBLI-txtCodCobrador"];
	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$ult_guia 			= 	$data["txtUltGuia"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;
	
	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 100, 280, null);");
	
	return $objResponse->getXML();
}


function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

function GenerarPDF($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

    $alumno                     =       $data['OBLIRutAlumno'];
    $observacion                     =       $data['observacion'];
        
	$objResponse->addScript("showPopWin('pdfs/pdf_generar_certificado_matricula_alumno.php?alumno=$alumno&observacion=$observacion', 'Imprime PDF', 1000, 700, null);");
	
	return $objResponse->getXML();
	}

function EnivarPDF($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$alumno                     =       $data['OBLIRutAlumno'];
    $observacion                     =       $data['observacion'];
        
	$objResponse->addScript("showPopWin('sg_envia_certificado_matricula_alumno.php?alumno=$alumno&observacion=$observacion', 'Enviar PDF', 600, 200, null);");

	return $objResponse->getXML();
	}


$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("LlamaDetalle");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Imprime");
$xajax->registerFunction("GenerarPDF");
$xajax->registerFunction("EnivarPDF");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informes_certificado_matricula.tpl');


ob_flush();
?>

