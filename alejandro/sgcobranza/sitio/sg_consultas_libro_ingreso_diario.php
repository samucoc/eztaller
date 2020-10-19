<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_consultas_libro_ingreso_diario.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





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





function Grabar($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');



	$mes = $data['mes'];

	$anio = $data['periodo'];



	$mes_ele = "";

	if ($mes=='1'){

		$mes_ele = 'Enero';

	}

	if ($mes=='2'){

		$mes_ele = 'Febrero';

		

	}

	if ($mes=='3'){

		$mes_ele = 'Marzo';

		

	}

	if ($mes=='4'){

		$mes_ele = 'Abril';

		

	}

	if ($mes=='5'){

		$mes_ele = 'Mayo';

		

	}

	if ($mes=='6'){

		$mes_ele = 'Junio';

		

	}

	if ($mes=='7'){

		$mes_ele = 'Julio';

		

	}

	if ($mes=='8'){

		$mes_ele = 'Agosto';

		

	}

	if ($mes=='9'){

		$mes_ele = 'Septiembre';

		

	}

	if ($mes=='10'){

		$mes_ele = 'Octubre';

		

	}

	if ($mes=='11'){

		$mes_ele = 'Noviembre';

		

	}

	if ($mes=='12'){

		$mes_ele = 'Diciembre';

		

	}





	$periodo_td = $mes_ele.' de '.$anio;

	

	$dia_fin = date("t", mktime(0,0,0,$mes,1,$anio));



	$arrRegistros  = array();

	$total = 0;



	for($i=1;$i<=$dia_fin;$i++){

		$sql_boletas = "select max(NumeroBoleta) as maximo, min(NumeroBoleta) as minimo, sum(ValorBoleta) as ValorBoleta

					from gescolcl_arcoiris_administracion.Movimientos

					where FechaBoleta = '".$anio."-".$mes."-".$i."' and EstadoBoleta = '1'

					";

		$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

		$row_boletas = mysql_fetch_array($res_boletas);



		$maximo = $row_boletas['maximo'];

		$minimo = $row_boletas['minimo'];

		$ValorBoleta = $row_boletas['ValorBoleta'];



		$sql_boletas = "select distinct NumeroBoleta

					from gescolcl_arcoiris_administracion.Movimientos

					where FechaBoleta = '".$anio."-".$mes."-".$i."' and EstadoBoleta <> '1'

					";

		$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

		$nulas ="";

		while($row_boletas = mysql_fetch_array($res_boletas)){

			$nulas .= $row_boletas['NumeroBoleta'].',';

			}

		

		$sql_boletas = "select BecaColegiatura, ValorBoleta, Movimientos.NumeroRutAlumno

						from gescolcl_arcoiris_administracion.Movimientos

							inner join gescolcl_arcoiris_administracion.alumnos".$anio."

								on alumnos".$anio.".NumeroRutAlumno = Movimientos.NumeroRutAlumno

						where FechaBoleta = '".$anio."-".$mes."-".$i."' and 

							  EstadoBoleta = '1' and

							  BecaColegiatura > 0

					";

		$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

		$exenciones = '0';

		while($row_boletas = mysql_fetch_array($res_boletas)){

			$sql_1 = "select count(ctacte_ncorr) as contador, ValorPactado

						from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."

						where CodigoItem = '2' and NumeroRutAlumno = '".$row_boletas['NumeroRutAlumno']."'";

			$res_1 = mysql_query($sql_1,$conexion);

			$row_1 = mysql_fetch_array($res_1);

			if($row_boletas['BecaColegiatura']==0){



			}

			else{

				$sql_001 = "select ValorIncorporacion, ValorColegiatura

							from gescolcl_arcoiris_administracion.Aranceles

							where

								CodigoNivel in (	select CodigoNivel

													from gescolcl_arcoiris_administracion.Cursos

													where CodigoCurso in (

																			select CodigoCurso

																			from gescolcl_arcoiris_administracion.alumnos".$anio."

																			where NumeroRutAlumno = '".$row_boletas['NumeroRutAlumno']."'

																			)

													) and 

								AnioPeriodo = '".$anio."'"; 

			

				$res_001 = mysql_query($sql_001, $conexion) or die(mysql_error());

				

				$row_001 = mysql_fetch_array($res_001);



				$colegiatura = $row_001['ValorColegiatura'];



				$valorBecaCuota = $row_boletas['BecaColegiatura']/$row_1['contador'];

				$valorArancelCuota = $colegiatura/$row_1['contador'];



				if($valorBecaCuota == $row_boletas['ValorBoleta']){

					$exenciones += ($valorArancelCuota - $valorBecaCuota);

				}

				else{

					$exenciones += ($valorArancelCuota - $valorBecaCuota)*($row_boletas['ValorBoleta']/$valorBecaCuota);

				}	

			}

		}





		array_push($arrRegistros, array(

						'dia' => $i,

						'maximo' => $maximo,

						'minimo' => $minimo,

						'exenciones' => number_format(round($exenciones),0,'.',','),

						'valor'  => number_format($ValorBoleta,0,'.',','),

						'nulas'	 =>	$nulas

					));



		$total +=$ValorBoleta;

		}

	

	array_push($arrRegistros, array(

						'dia' => 'Total',

						'maximo' => '---',

						'minimo' => '---',

						'valor'  => number_format($total,0,'.',','),

						'nulas'	 =>	'---'

					));

		

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_consultas_libro_ingreso_diario_list.tpl'));



	$objResponse->addScript('document.getElementById("periodo_td").innerHTML = "'.$periodo_td.'"');



	return $objResponse->getXML();

		

	}



	$xajax->registerFunction("Grabar");

	$xajax->registerFunction("CargaSelect");



	$xajax->processRequests();

	$miSmarty->assign('xajax_js', $xajax->getJavascript());





	$miSmarty->display('sg_consultas_libro_ingreso_diario.tpl');





ob_flush();

?>

