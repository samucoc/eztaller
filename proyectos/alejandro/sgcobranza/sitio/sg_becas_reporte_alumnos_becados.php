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

$xajax->setRequestURI("sg_becas_reporte_alumnos_becados.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Buscar($data){
	
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');

	$anio = $data['anio'];

	$todos = $data['todos'];

	$arrRegistros			= 	array();



	$sql_esta = "select NombreEstablecimiento, RBD, Logo, Foto,

						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno, DireccionEstablecimiento

				from gescolcl_arcoiris_administracion.Establecimiento

				";

	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error($conexion));

	$row_esta = mysql_fetch_array($res_esta);

	
	$miSmarty->assign('nombre_establecimiento',$row_esta['NombreEstablecimiento']);
	$miSmarty->assign('direccion_establecimiento',$row_esta['DireccionEstablecimiento']);
	$miSmarty->assign('rbd_establecimiento',$row_esta['RBD']);

	if (($anio!='')){

		$and = " PeriodoBeca = '".$anio."' ";

		if ($todos=='BECADOS'){

			$sql_becas = "SELECT alumnos".$anio.".NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno,

									NombreCurso

								FROM gescolcl_arcoiris_administracion.alumnos".$anio."

									inner join gescolcl_arcoiris_administracion.Cursos

										on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso

								where alumnos".$anio.".BecaColegiatura > 0

								order by alumnos".$anio.".CodigoCurso, PaternoAlumno, MaternoAlumno, NombresAlumno";

			}

		elseif ($todos=='NO-BECADOS'){

				$sql_becas = "SELECT alumnos".$anio.".NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno,

									NombreCurso

								FROM gescolcl_arcoiris_administracion.alumnos".$anio."

									inner join gescolcl_arcoiris_administracion.Cursos

										on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso

								where NumeroRutAlumno not in (SELECT NumeroRutAlumno

																FROM gescolcl_arcoiris_administracion.Becas

																where 1 and $and)

										and alumnos.Matriculado = 1 and Cursos.CodigoCurso < 400

								order by alumnos".$anio.".CodigoCurso, PaternoAlumno, MaternoAlumno, NombresAlumno";

			}

		else {

				$sql_becas = "SELECT alumnos".$anio.".NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno,

									NombreCurso

								FROM gescolcl_arcoiris_administracion.alumnos".$anio."

									inner join gescolcl_arcoiris_administracion.Cursos

										on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso

								where Cursos.CodigoCurso < 400

								order by alumnos".$anio.".CodigoCurso, PaternoAlumno, MaternoAlumno, NombresAlumno";

			}	

		$res_becas = mysql_query($sql_becas,$conexion) or die(mysql_error($conexion));

		$i = 0;
		$sum_valor_beca = 0;
		while($row_becas = mysql_fetch_array($res_becas)){



			$sql_beca = "select NombreTipoBeca, alumnos".$anio.".BecaColegiatura

							from gescolcl_arcoiris_administracion.Becas

								inner join gescolcl_arcoiris_administracion.TipoBeca

									on TipoBeca.CodigoTipoBeca = Becas.CodigoTipoBeca

								inner join gescolcl_arcoiris_administracion.alumnos".$anio."

										on alumnos".$anio.".NumeroRutAlumno = Becas.NumeroRutAlumno

								where alumnos".$anio.".NumeroRutAlumno = '".$row_becas[0]."' and Becas.PeriodoBeca = '".$anio."'";

			$res_beca = mysql_query($sql_beca,$conexion) or die(mysql_error($conexion));

			$row_beca = mysql_fetch_array($res_beca);



			$sql_ii = "select count(ValorPactado) as cuotas

						from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."

						where NumeroRutAlumno = '".$row_becas[0]."' and 

								CodigoItem = '2' and 

								FechaVencimiento between '".$anio."-1-1' and '".$anio."-12-31' ";

			$res_ii = mysql_query($sql_ii,$conexion);

			$row_ii = mysql_fetch_array($res_ii);



			$sql_11 = "select ValorColegiatura

						from gescolcl_arcoiris_administracion.Aranceles

						where CodigoNivel in (select CodigoNivel 

												from gescolcl_arcoiris_administracion.Cursos

												where CodigoCurso in (select CodigoCurso

																		from gescolcl_arcoiris_administracion.alumnos".$anio."

																		where NumeroRutAlumno = '".$row_becas[0]."')

											) and 

							AnioPeriodo = '".$anio."'";

			$res_11 = mysql_query($sql_11,$conexion);

			$row_11 = mysql_fetch_array($res_11);



			$valor_becas = $row_beca['BecaColegiatura'];

			$cuotas = $row_ii['cuotas'] == '0' ? '10' : $row_ii['cuotas'] ;

			$colegiatura = $row_11['ValorColegiatura'];

			

			$porcentaje = $colegiatura>0 ? ($valor_becas*100)/$colegiatura : ($valor_becas*100);



			$valor_mensual = $cuotas>0 ? $colegiatura/$cuotas : $colegiatura;

			$valor_beca = $cuotas>0 ?  $valor_becas/$cuotas : $valor_becas;

			$ap_apoderado = $valor_mensual - $valor_beca;



			array_push($arrRegistros, array("item"					=>	$i, 

											"NumeroRutAlumno"		=> 	$row_becas[0], 

											"DVAlumno"				=> 	dv($row_becas[0]), 

											"PaternoAlumno"			=> 	$row_becas[1],

											"MaternoAlumno" 		=> 	$row_becas[2],

											"NombresAlumno" 		=> 	$row_becas[3],

											"NombreCurso" 			=> 	$row_becas[4],

											"NombreNivel" 			=> 	'',

											"PeriodoBeca"			=> 	$anio,

											"porcentaje"			=>	number_format($porcentaje,2,',','.'),

											"valor_mensual"			=> 	$valor_mensual,

											"ap_apoderado"			=> 	$ap_apoderado,

											"valor_beca"			=> 	$valor_beca,

											"NombreTipoBeca"		=> 	$row_beca['NombreTipoBeca']

											));
			$sum_valor_beca += number_format($valor_beca,0,'','');
			$i++;

			}
			$miSmarty->assign('arrRegistros',$arrRegistros);
			$miSmarty->assign('sum_valor_beca',number_format($sum_valor_beca,0,',','.'));
			$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_becas_reporte_alumnos_becados_list.tpl'));
		
		}

	else{

		echo "Seleccione un periodo";

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
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[0].value", '');
			$objResponse->addAssign("$select","options[0].text", 'Elija'); 	
			$j++;
            while ($line = mysql_fetch_array($res)) {
                    $objResponse->addCreate("$select","option",""); 		
                    $objResponse->addAssign("$select","options[".$j."].value", $line[0]);
                    $objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
                    $j++;
            }
        }
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','gescolcl_arcoiris_administracion.Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', '')");
	
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
	//$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	return $objResponse->getXML();
} 

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("LlamaDetalle");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Buscar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->assign('rut_alumno', $_GET["rut_alumno"]);

$miSmarty->display('sg_becas_reporte_alumnos_becados.tpl');

ob_flush();
?>