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

$xajax->setRequestURI("sg_cierre_caja.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data){
    global $conexion;
    global $miSmarty;
	$objResponse = new xajaxResponse('UTF8');
	
	$fecha_buscar = $data['fecha1'];
	$arr_fecha = explode('/',$fecha_buscar);
	$anio = $_SESSION["sige_anio_escolar_vigente"];
    
	$tbl="";
	$sql_boletas = "select NumeroBoleta, NumeroRutAlumno , 
							nombre, sum(ValorBoleta) as ValorBoleta, EstadoBoleta, DescripcionBoleta
					from gescolcl_arcoiris_administracion.Movimientos
						inner join gescolcl_arcoiris_administracion.TipoPagoBoleta
							on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr
					where FechaBoleta = '".$arr_fecha[2]."-".$arr_fecha[1]."-".$arr_fecha[0]."'
					group by NumeroBoleta
					order by NumeroBoleta asc";
	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
	$tbl .= '<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">';
	$tbl .= '<tr>';
	$tbl .= '<td class="grilla-tab-fila-campo" colspan="6">Cierre de Caja. Fecha '.$fecha_buscar.'</td>';
	$tbl .= '</tr>';
	$tbl .= '<tr>';
	$tbl .= '<td class="grilla-tab-fila-campo" >N&uacute;mero Boleta</td>';
	$tbl .= '<td class="grilla-tab-fila-campo" >Alumno</td>';
	$tbl .= '<td class="grilla-tab-fila-campo" >Descripci&oacute;n</td>';
	$tbl .= '<td class="grilla-tab-fila-campo" >Curso</td>';
	$tbl .= '<td class="grilla-tab-fila-campo" >Tipo de Pago</td>';
	$tbl .= '<td class="grilla-tab-fila-campo" >Valor Boleta</td>';
	$tbl .= '</tr>';
	while($row_boletas = mysql_fetch_array($res_boletas)){
		$tbl .= '<tr>';
		$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas['NumeroBoleta'].'</td>';
		
		$anio = $_SESSION["sige_anio_escolar_vigente"];
    
		$sql_1  ="select concat(PaternoAlumno,' ',MaternoAlumno,' ',NombresAlumno) as alumno, NombreCurso 
					from gescolcl_arcoiris_administracion.alumnos".$anio."
						inner join gescolcl_arcoiris_administracion.Cursos
							on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
					where NumeroRutAlumno = '".$row_boletas['NumeroRutAlumno']."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		
		if (mysql_num_rows($res_1)==0){
			$anio = $anio +1;
			$sql_1  ="select concat(PaternoAlumno,' ',MaternoAlumno,' ',NombresAlumno) as alumno, NombreCurso 
						from gescolcl_arcoiris_administracion.alumnos".$anio."
							inner join gescolcl_arcoiris_administracion.Cursos
								on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
						where NumeroRutAlumno = '".$row_boletas['NumeroRutAlumno']."'";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			}

		if (mysql_num_rows($res_1)==0){
			$anio = $anio -2;
			$sql_1  ="select concat(PaternoAlumno,' ',MaternoAlumno,' ',NombresAlumno) as alumno, NombreCurso 
					from gescolcl_arcoiris_administracion.alumnos".$anio."
						inner join gescolcl_arcoiris_administracion.Cursos
							on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
					where NumeroRutAlumno = '".$row_boletas['NumeroRutAlumno']."'";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			}

		$row_1 = mysql_fetch_array($res_1);
		$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_1['alumno'].'</td>';
		$descr = "";
		$sql_boleta_desc	=	"select DescripcionBoleta
									from gescolcl_arcoiris_administracion.Movimientos
									where NumeroBoleta = '".$row_boletas['NumeroBoleta']."'";
		$res_boleta_desc 	= 	mysql_query($sql_boleta_desc,$conexion);
		while($row_boleta_desc = mysql_fetch_array($res_boleta_desc)){
			$descr .= $row_boleta_desc['DescripcionBoleta'].',';
			}

		$tbl .= '<td class="grilla-tab-fila-campo" >'.$descr.'</td>';
		$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_1['NombreCurso'].'</td>';
		
		if ($row_boletas['EstadoBoleta']=='1'){
			$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas['nombre'].'</td>';
			$tbl .= '<td class="grilla-tab-fila-campo" align="right">'.number_format($row_boletas['ValorBoleta'],0,',','.').'</td>';
			}
		else{
			$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas['nombre'].' - NULA</td>';
			$tbl .= '<td class="grilla-tab-fila-campo" >0</td>';
			}
		$tbl .= '</tr>';
		}

	$sql_boletas = "select sum(ValorBoleta) as ValorBoleta, TipoPagoBoleta, nombre
					from gescolcl_arcoiris_administracion.Movimientos
						inner join gescolcl_arcoiris_administracion.TipoPagoBoleta
								on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr
					where FechaBoleta = '".$arr_fecha[2]."-".$arr_fecha[1]."-".$arr_fecha[0]."' and EstadoBoleta = '1'
					group by TipoPagoBoleta asc, nombre";
	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
	$total_dia=0;
	while($row_boletas = mysql_fetch_array($res_boletas)){
		$tbl .= '<tr>';
		$tbl .= '<td class="grilla-tab-fila-campo" >Total '.$row_boletas['nombre'].'</td>';
		$tbl .= '<td class="grilla-tab-fila-campo" >'.number_format($row_boletas['ValorBoleta'],0,',','.').'</td>';
		$tbl .= '</tr>';
		$total_dia += $row_boletas['ValorBoleta'];
		}
	$tbl .= '<tr>';
	$tbl .= '<td class="grilla-tab-fila-campo" >Total Dia</td>';
	$tbl .= '<td class="grilla-tab-fila-campo" >'.number_format($total_dia,0,',','.').'</td>';
	$tbl .= '</tr>';

	$tbl .= '</table>';

	$objResponse->addAssign("divabonos", "innerHTML", $tbl);
	
	return $objResponse->getXML();
}          

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nro_boleta', $_GET["nro_boleta"]);

$miSmarty->display('sg_cierre_caja.tpl');

?>