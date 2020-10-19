<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_mant_boletas_emitidas.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$FechaBoleta = $data['FechaBoleta'];
	$FechaBoletaAnula = $data['FechaBoletaAnula'];
	
	list($d1,$m1,$a1) = explode('/',$FechaBoleta);
	$FechaBoleta = $a1.'-'.$m1.'-'.$d1;
	list($d2,$m2,$a2) = explode('/',$FechaBoletaAnula);
	$FechaBoletaAnula = $a2.'-'.$m2.'-'.$d2;
	
	if($FechaBoletaAnula!=''){
		if($FechaBoleta <= $FechaBoletaAnula){
			$EstadoBoleta = $data['EstadoBoleta'];
			$TipoPagoBoleta = $data['TipoPagoBoleta'];
			$NumeroBoleta = $data['nro_boleta'];

			$update = "update gescolcl_arcoiris_administracion.Movimientos 
							set FechaBoleta		= '".$FechaBoleta."',
								FechaBoletaAnula		= '".$FechaBoletaAnula."',
								EstadoBoleta	= '".$EstadoBoleta."',
								TipoPagoBoleta	= '".$TipoPagoBoleta."'
							where NumeroBoleta = '".$NumeroBoleta."'
							";
			$res = mysql_query($update,$conexion) or die(mysql_error());
			$objResponse->addAlert("Registro Actualizado Correctamente.");
			$objResponse->addScript("document.Form1.submit();");
		}else{
			$objResponse->addAlert("Fecha Anulacion Superior");
		}
	}else{
		list($d,$m,$a) = explode('/',$FechaBoleta);
		$FechaBoleta = $a.'-'.$m.'-'.$d;
		list($d,$m,$a) = explode('/',$FechaBoletaAnula);
		$FechaBoletaAnula = $a.'-'.$m.'-'.$d;
		$EstadoBoleta = $data['EstadoBoleta'];
		$TipoPagoBoleta = $data['TipoPagoBoleta'];
		$NumeroBoleta = $data['nro_boleta'];
		$update = "update gescolcl_arcoiris_administracion.Movimientos 
						set FechaBoleta		= '".$FechaBoleta."',
							FechaBoletaAnula		= '".$FechaBoletaAnula."',
							EstadoBoleta	= '".$EstadoBoleta."',
							TipoPagoBoleta	= '".$TipoPagoBoleta."'
						where NumeroBoleta = '".$NumeroBoleta."'
						";
		$res = mysql_query($update,$conexion) or die(mysql_error());
		$objResponse->addAlert("Registro Actualizado Correctamente.");
		$objResponse->addScript("document.Form1.submit();");
	}
	return $objResponse->getXML();
	}

function CargaBoleta($data){
    global $conexion;
	global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');
	$arrRegistros = [];

	$nro_boleta = $data['nro_boleta'];
	$periodo = $data['periodo'];

	$sql = "select 	NumeroBoleta, 
					date_format(FechaBoleta, '%d/%m/%Y') as FechaBoleta, 
					date_format(FechaBoletaAnula, '%d/%m/%Y') as FechaBoletaAnula, 
					Movimientos.NumeroRutAlumno,
					PeriodoMovimiento,					
					ValorBoleta,
					EstadoBoleta,
					TipoPagoBoleta,
					DescripcionBoleta
			from gescolcl_arcoiris_administracion.Movimientos 
			where 	NumeroBoleta = '".$nro_boleta."' ";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	while($row = mysql_fetch_array($res)){

		
		$sql_a = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as nombre_alumno
				   from gescolcl_arcoiris_administracion.alumnos".$row['PeriodoMovimiento']."
				   where NumeroRutAlumno = ".$row['NumeroRutAlumno'];
		$res_a = mysql_query($sql_a, $conexion);
		$row_a = mysql_fetch_array($res_a);

		
		$sql_ff = "select nombre
				   from gescolcl_arcoiris_administracion.EstadoBoleta
				   where eb_ncorr = ".$row['EstadoBoleta'];
		$res_ff = mysql_query($sql_ff, $conexion);
		$row_ff = mysql_fetch_array($res_ff);

		$sql_aa = "select nombre
				   from gescolcl_arcoiris_administracion.TipoPagoBoleta
				   where tpb_ncorr = ".$row['TipoPagoBoleta'];
		$res_aa = mysql_query($sql_aa, $conexion);
		$row_aa = mysql_fetch_array($res_aa);

		$sql_11 = "select sum(ValorBoleta) as valor
				   from gescolcl_arcoiris_administracion.Movimientos
				   where NumeroBoleta = ".$row['NumeroBoleta'];
		$res_11 = mysql_query($sql_11, $conexion);
		$row_11 = mysql_fetch_array($res_11);

		$descripcion .= $row['DescripcionBoleta'].',';

		$objResponse->addAssign("NumeroBoleta", 		"value", 	$row['NumeroBoleta'] );
		$objResponse->addAssign("FechaBoleta", 			"value",	$row['FechaBoleta'] );
		$objResponse->addAssign("FechaBoletaAnula", 	"value",	$row['FechaBoletaAnula'] );
		$objResponse->addAssign("BSCNumeroRutAlumno", 	"value",	$row_a['nombre_alumno'] );
		$objResponse->addAssign("OBLINumeroRutAlumno", 	"value",	$row['NumeroRutAlumno'] );
		$objResponse->addAssign("ValorBoleta", 			"value",	$row_11['valor'] );
		$objResponse->addAssign("EstadoBoleta", 		"value",	$row['EstadoBoleta'] );
		if ($row['EstadoBoleta'] == '1'){
			$objResponse->addScript('document.getElementById("FechaBoletaAnula").style="display:none";') ;
		}
		else{
			$objResponse->addScript('document.getElementById("FechaBoletaAnula").style="display:block";') ;
		}
		$objResponse->addAssign("TipoPagoBoleta", 		"value",	$row['TipoPagoBoleta'] );
		$objResponse->addAssign("DescripcionBoleta", 	"value",	$descripcion );

		$arrRegistros[] = 	['nro_boleta' 	=> $row['NumeroBoleta'],
							'fecha' 		=> $row['FechaBoleta'],
							'alumno' 		=> $row_a['nombre_alumno'],
							'descripcion'	=> $row['DescripcionBoleta'],
							'valor' 		=> $row['ValorBoleta'],
							'estado' 		=> $row_ff['nombre'],
							'tipo_pago' 	=> $row_aa['nombre']
							];

	}

	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_mant_boletas_emitidas_list.tpl'));
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	return $objResponse->getXML();
	}

function CargaListado($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');

    $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'EstadoBoleta','gescolcl_arcoiris_administracion.EstadoBoleta','','','eb_ncorr', 'nombre', '')");
    $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'TipoPagoBoleta','gescolcl_arcoiris_administracion.TipoPagoBoleta','','','tpb_ncorr', 'nombre', '')");
    
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'periodo','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
    
	return $objResponse->getXML();
	}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$bd = '';
	$tbl =	$data["txtTabla"]; 
	
	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
	$objResponse->addAssign("$select","innerHTML",""); 		
    if ($tabla == 'Profesores'){
		$campo2 = " concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) ";
		} 
	if (($opt=='OBLICodigoCurso')&&($tbl!='Becas')){
		$ramo = $data['OBLICodigoCurso'];
		$curso = $data['OBLICodigoRamo'];
		$opt = 'where NumeroRutProfesor in (select distinct NumeroRutProfesor 
											from gescolcl_arcoiris_administracion.Pruebas 
											where CodigoCurso = "'.$ramo.'" and CodigoRamo = "'.$curso.'")';
		}
	if (($select == 'OBLICodigoRamo')&&($tbl!='Becas')){
			$ramo = $data['OBLICodigoCurso'];
			$opt = 'where CodigoRamo in (select CodigoRamo
			from gescolcl_arcoiris_administracion.Asignaturas
			where CodigoCurso = "'.$ramo.'")';
	}
		
	if ($tabla=='Aranceles'){
		$opt = " where AnioPeriodo = '".$_SESSION["sige_anio_escolar_vigente"]."' ";
		}	

	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	//$objResponse->addAlert($sql); 
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		$j = 0;
		if ($tabla=='gescolcl_arcoiris_administracion.Periodos'){
			$periodo_actual = $_SESSION["sige_anio_escolar_vigente"];
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[0].value", $periodo_actual);
			$objResponse->addAssign("$select","options[0].text", $periodo_actual); 	
			$j++;
			}

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
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaBoleta");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('rut', $_GET['rut']);

$miSmarty->display('sg_mant_boletas_emitidas.tpl');
ob_flush();
?>