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

$xajax->setRequestURI("sg_alumnos_matriculados.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();
$anio = $_SESSION["sige_anio_escolar_vigente"];


function Grabar($data){
	global $conexion;
	global $miSmarty;
	$objResponse = new xajaxResponse('UTF8');
	
	$ncorr = $data['rut_alumno'];
    $anio = $_SESSION["sige_anio_escolar_vigente"];
    list($ncorr,$dv) = explode('-',$ncorr);

	if (($data['mes_inicio_incorporacion']!='')&&($data['mes_inicio_colegiatura']!='')){
	
		$anio_vigente = $_SESSION["sige_anio_escolar_vigente"];
	
		$sql_update = "update gescolcl_arcoiris_administracion.alumnos".$anio." 
						set Matriculado = '1'
						where NumeroRutAlumno = '".$ncorr."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
	
		$tipo_pago_incorporacion 	= $data['tipo_pago_incorporacion'];
		$fecha_incorporacion 		= $data['mes_inicio_incorporacion'];
		$valor_cuota_incorporacion	= $data['valor_cuota_incorporacion'];
	
		list($dia,$mes,$anio) = explode('/',$fecha_incorporacion);
		
		$sql_ver = "select NumeroRutAlumno 
					from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
					where NumeroRutAlumno = '".$ncorr."' ";
		$res_ver = mysql_query($sql_ver,$conexion) or die(mysql_error());
		if (mysql_num_rows($res_ver)==0){
			
			for($i=0;$i<1;$i++){
				$fecha_in = date("Y-m-d",mktime(0,0,0,$mes+$i,5,$anio));
				$nro_cuota = $i+1;
				$anio_vigente = $_SESSION["sige_anio_escolar_vigente"];

				$sql_ii = "insert into gescolcl_arcoiris_administracion.CuentaCorriente".$anio_vigente."( `NumeroRutAlumno`, `CodigoItem`, 
																						`NumeroCuota`, `FechaVencimiento`, 
																						`ValorPactado`, ValorPagado)
												values ('".$ncorr."','1','".$nro_cuota."','".$fecha_in."',
														'".$valor_cuota_incorporacion."', '0')";
				$res_ii = mysql_query($sql_ii,$conexion) or die(mysql_error());
				}
		
			$tipo_pago_colegiatura 	= $data['tipo_pago_colegiatura'];
			$fecha_colegiatura 		= $data['mes_inicio_colegiatura'];
			$valor_cuota_colegiatura	= $data['valor_cuota_colegiatura'];
		
			list($dia,$mes,$anio) = explode('/',$fecha_colegiatura);

			for($i=0;$i<$tipo_pago_colegiatura;$i++){
				$fecha_in = date("Y-m-d",mktime(0,0,0,$mes+$i,5,$anio));
				$nro_cuota = $i+1;
				$anio_vigente = $_SESSION["sige_anio_escolar_vigente"];

				$sql_ii = "insert into gescolcl_arcoiris_administracion.CuentaCorriente".$anio_vigente."( `NumeroRutAlumno`, `CodigoItem`, 																						`NumeroCuota`, `FechaVencimiento`, 
																						`ValorPactado`, ValorPagado)
												values ('".$ncorr."','2','".$nro_cuota."','".$fecha_in."',
														'".$valor_cuota_colegiatura."','0')";
				$res_ii = mysql_query($sql_ii,$conexion) or die(mysql_error());
				}
			$objResponse->addAlert("Registro Actualizado");
			$objResponse->addScript("window.parent.hidePopWin(true)");	
			$objResponse->addScript("window.parent.xajax_Grabar(window.parent.xajax.getFormValues('Form1'))");
			$objResponse->addScript("window.parent.location.href='sg_alumnos_cobranza.php?rut_alumno=".$ncorr."'");
			}
		else{
			$objResponse->addAlert("Cuotas ya agregadas");
			$objResponse->addScript("window.parent.hidePopWin(true)");	
			}
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_matricula_list.tpl'));
	
	
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
    global $miSmarty;
	$objResponse = new xajaxResponse('UTF8');
	
	//$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','gescolcl_arcoiris_administracion.Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");
	
	//$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	$rut_alumno = $data['rut_alumno'];
	list($rut,$dv) = explode('-',$rut_alumno);

    $anio = $_SESSION["sige_anio_escolar_vigente"];

	$sql_pd = "select 
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno
				from gescolcl_arcoiris_administracion.alumnos".$anio."
				where NumeroRutAlumno = '".$rut."' "; 
	$res_pd = mysql_query($sql_pd,$conexion);
	$row_pd = mysql_fetch_array($res_pd);
	$objResponse->addAssign('nombre_alumno','innerHTML',$row_pd['nombre_alumno']);
	
	$anio_ant = $anio-1;
	$sql = "SELECT sum(ValorPactado)-sum(ValorPagado) as saldo
        FROM 	gescolcl_arcoiris_administracion.CuentaCorriente".$anio_ant."
        WHERE NumeroRutAlumno like '".$rut."' and 
        		FechaVencimiento <= '".date('Y-m-d',mktime(0,0,0,date("m"),date("d"),$anio_ant))."'";
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
	if ($row['saldo']>0){
		$objResponse->addScript("alert('Alumno con deuda.')");
		}
	
	$date_inco = date("d/m/Y",mktime(0,0,0,3,5,$_SESSION["sige_anio_escolar_vigente"]));
	$objResponse->addAssign('mes_inicio_incorporacion','value',$date_inco);
	$objResponse->addAssign('mes_inicio_colegiatura','value',$date_inco);
	 
	$rut_alumno = $data['rut_alumno'];
	list($rut,$dv) = explode('-',$rut_alumno);

	$sql_niveles = "select 	ValorIncorporacion, ValorColegiatura 
					from gescolcl_arcoiris_administracion.Aranceles 
					where CodigoNivel in (select CodigoNivel 
											from gescolcl_arcoiris_administracion.Cursos 
											where CodigoCurso in (select CodigoCurso
																	from gescolcl_arcoiris_administracion.alumnos".$anio."
																	where NumeroRutAlumno = '".$rut."'))
						and AnioPeriodo = '".$anio."'";
	$res_niveles = mysql_query($sql_niveles,$conexion) or die(mysql_error());
	$row_niveles = mysql_fetch_array($res_niveles);

	$sql_beca = "select IncorporacionTipoBeca, ColegiaturaTipoBeca
							from gescolcl_arcoiris_administracion.Becas
								inner join gescolcl_arcoiris_administracion.TipoBeca
									on Becas.CodigoTipoBeca = TipoBeca.CodigoTipoBeca
					where NumeroRutAlumno = '".substr($rut_alumno,0,8)."'  and PeriodoBeca = '".$anio."'";
	$res_beca = mysql_query($sql_beca,$conexion) or die(mysql_error());
	$row_beca = mysql_fetch_array($res_beca);

	$BecaIncorporacion = $row_beca['IncorporacionTipoBeca'];
	$BecaColegiatura = $row_beca['ColegiaturaTipoBeca'];

	if ($row_beca['IncorporacionTipoBeca']=='0'&&$row_beca['ColegiaturaTipoBeca']=='0'){
		$sql_ayuda = "select BecaIncorporacion, BecaColegiatura 
						from gescolcl_arcoiris_administracion.alumnos".$anio." 
						where NumeroRutAlumno = '".substr($rut_alumno,0,8)."'";
		$res_ayuda = mysql_query($sql_ayuda,$conexion) or die(mysql_error());
		$row_ayuda = mysql_fetch_array($res_ayuda);		

		$BecaIncorporacion = $row_ayuda['BecaIncorporacion'];
		$BecaColegiatura = $row_ayuda['BecaColegiatura'];
	}


	$objResponse->addAssign('beca_incorporacion','value',$BecaIncorporacion);
	$objResponse->addAssign('beca_colegiatura','value',$BecaColegiatura);
	
	$a_cancelar = $row_niveles['ValorIncorporacion'] - $BecaIncorporacion;

	$objResponse->addAssign('valor_incorporacion','value',$row_niveles['ValorIncorporacion']);
	$objResponse->addAssign('a_cancelar_incorporacion','value',$a_cancelar);
	$objResponse->addAssign('valor_cuota_incorporacion','value',$a_cancelar);
	
	$a_cancelar = $row_niveles['ValorColegiatura'] - $BecaColegiatura;
	
	$objResponse->addAssign('valor_colegiatura','value',$row_niveles['ValorColegiatura']);
	$objResponse->addAssign('a_cancelar_colegiatura','value', $a_cancelar);
	$objResponse->addAssign('valor_cuota_colegiatura','value', $a_cancelar/10);
	
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
	
	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 700, 280, null);");
	
	return $objResponse->getXML();
}
function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
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

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);
$miSmarty->assign('rut_alumno', $_GET["rut_alumno"]);

$miSmarty->display('sg_alumnos_matriculados.tpl');


ob_flush();
?>

