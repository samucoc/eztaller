<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
ob_start();
session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; //validaciones

/*

include "../includes/php/class.phpmailer.php";

include "../includes/php/class.pop3.php";

include "../includes/php/class.smtp.php";

include "../includes/php/PHPExcel.php";

include "../includes/php/PHPExcel/Reader/Excel2007.php";

*/

$xajax = new xajax();



$xajax->setRequestURI("sg_becas_asociar_detalle.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function Grabar($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');

	

	$CodigoCurso                = $data['CodigoCurso'];

    $NumeroRutAlumno            = $data['NumeroRutAlumno'];

    $CodigoTipoBeca             = $data['CodigoTipoBeca'];

    $PeriodoBeca			 	= $_SESSION["sige_anio_escolar_vigente"];



    $sql_pd = "select CodigoItem, sum(ValorPactado) as total

				from gescolcl_arcoiris_administracion.CuentaCorriente".$PeriodoBeca."

				where

					NumeroRutAlumno = '".$NumeroRutAlumno."' and 

					Year(FechaVencimiento) = '".$PeriodoBeca."'

				group by CodigoItem"; 

	

	$res_pd = mysql_query($sql_pd, $conexion);

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$cuota_0 = $row_nombre_profe['total'];



	$row_nombre_profe = mysql_fetch_array($res_pd);

	$colegiatura = $row_nombre_profe['total'];



	if ($CodigoTipoBeca!=''){



		$sql_pd = "select ValorIncorporacion, ValorColegiatura

					from gescolcl_arcoiris_administracion.Aranceles

					where

						CodigoNivel in (	select CodigoNivel

											from gescolcl_arcoiris_administracion.Cursos

											where CodigoCurso in (

																	select CodigoCurso

																	from gescolcl_arcoiris_administracion.alumnos".$PeriodoBeca."

																	where NumeroRutAlumno = '".$NumeroRutAlumno."'

																	)

											) and 

						AnioPeriodo = '".$PeriodoBeca."'"; 

		

		$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());

		

		$row_nombre_profe = mysql_fetch_array($res_pd);



	    $cuota_0 = $row_nombre_profe['ValorIncorporacion'];

		$colegiatura = $row_nombre_profe['ValorColegiatura'];



		$IncorporacionTipoBeca = str_replace(',', '', $data['cuota_0_beca']);

		$ColegiaturaTipoBeca = str_replace(',', '',$data['colegiatura_beca']);



		$PorcBecaIncorporacion = ($IncorporacionTipoBeca*100)/$cuota_0;

		$PorcBecaColegiatura = ($ColegiaturaTipoBeca*100)/$colegiatura;





			$sql_bb = "select NumeroRutAlumno, NombreTipoBeca

							from gescolcl_arcoiris_administracion.Becas 

								inner join gescolcl_arcoiris_administracion.TipoBeca

									on TipoBeca.CodigoTipoBeca = Becas.CodigoTipoBeca

							where NumeroRutAlumno='".$NumeroRutAlumno."' and 

									PeriodoBeca = '".$PeriodoBeca."'";

				$res_bb = mysql_query($sql_bb,$conexion);

				$row_bb = mysql_fetch_array($res_bb);



			if ($row_bb['NumeroRutAlumno']==''){

				$sql_nombre_profe ="INSERT INTO gescolcl_arcoiris_administracion.Becas(`PeriodoBeca`, `NumeroRutAlumno`, `CodigoCurso`,`CodigoTipoBeca`) 

									VALUES ('".$PeriodoBeca."','".$NumeroRutAlumno."','".$CodigoCurso."','".$CodigoTipoBeca."')";

				$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

				}

			else{

				$sql_nombre_profe ="update gescolcl_arcoiris_administracion.Becas set 

										PeriodoBeca = '".$PeriodoBeca."', 

										NumeroRutAlumno = '".$NumeroRutAlumno."', 

										CodigoCurso = '".$CodigoCurso."',

										CodigoTipoBeca = '".$CodigoTipoBeca."'

									where NumeroRutAlumno='".$NumeroRutAlumno."' and 

											PeriodoBeca = '".$PeriodoBeca."' ";

				$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

				}



			$sql_nombre_profe ="update gescolcl_arcoiris_administracion.alumnos".$PeriodoBeca." set 

										BecaIncorporacion = '".$IncorporacionTipoBeca."',

										BecaColegiatura = '".$ColegiaturaTipoBeca."',

										PorcBecaIncorporacion = '".round($PorcBecaIncorporacion,2)."',

										PorcBecaColegiatura = '".round($PorcBecaColegiatura,2)."'

									where NumeroRutAlumno='".$NumeroRutAlumno."' ";

			$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

				

			$cuota_0_resultado = str_replace(',', '',$data['cuota_0_resultado']);

	

			$sql_nombre_profe ="update gescolcl_arcoiris_administracion.CuentaCorriente".$PeriodoBeca." set 

										ValorPactado = '".$cuota_0_resultado."'

									where NumeroRutAlumno='".$NumeroRutAlumno."' and 

										Year(FechaVencimiento) = '".$PeriodoBeca."' and 

										CodigoItem = '1' ";

			$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

			

			$sql_001 = "select count(NumeroRutAlumno) as contador

						from gescolcl_arcoiris_administracion.CuentaCorriente".$PeriodoBeca." 

						where NumeroRutAlumno='".$NumeroRutAlumno."' and 

								Year(FechaVencimiento) = '".$PeriodoBeca."' and 

								CodigoItem = '2' ";

			$res_001 = mysql_query($sql_001,$conexion);

			$row_001 = mysql_fetch_array($res_001);

			$contador = $row_001['contador'];

			$colegiatura_resultado = str_replace(',', '',$data['colegiatura_resultado']);



			$cuota_resultado = $colegiatura_resultado/$contador;



			for($o=0;$o<$contador;$o++){

				$sql_nombre_profe ="update gescolcl_arcoiris_administracion.CuentaCorriente".$PeriodoBeca." set 

										ValorPactado = '".$cuota_resultado."'

									where NumeroRutAlumno='".$NumeroRutAlumno."' and 

											Year(FechaVencimiento) = '".$PeriodoBeca."' and 

											CodigoItem = '2' ";

				$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

				}

				

			$objResponse->addScript("alert('Cuenta Corriente Actualizada.')");	

			$objResponse->addScript("window.parent.hidePopWin(true)");	

			$objResponse->addScript("window.parent.xajax_Grabar(window.parent.xajax.getFormValues('Form1'))");

			

		}

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

	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla." order by NombreTipoBeca desc";

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



function CalculoResultados($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');



	$NumeroRutAlumno            = $data['NumeroRutAlumno'];

    $CodigoTipoBeca             = $data['CodigoTipoBeca'];

    $PeriodoBeca			 	= $_SESSION["sige_anio_escolar_vigente"];



	$sql_pd = "select ValorIncorporacion, ValorColegiatura

				from gescolcl_arcoiris_administracion.Aranceles

				where

					CodigoNivel in (	select CodigoNivel

										from gescolcl_arcoiris_administracion.Cursos

										where CodigoCurso in (

																select CodigoCurso

																from gescolcl_arcoiris_administracion.alumnos".$PeriodoBeca."

																where NumeroRutAlumno = '".$NumeroRutAlumno."'

																)

										) and 

					AnioPeriodo = '".$PeriodoBeca."'"; 

	

	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());

	

	$row_nombre_profe = mysql_fetch_array($res_pd);



    $cuota_0 = $row_nombre_profe['ValorIncorporacion'];

	$colegiatura = $row_nombre_profe['ValorColegiatura'];	

	

    $sql_pd = "select CodigoItem, sum(ValorPactado) as total, sum(ValorPagado) as total_1

				from gescolcl_arcoiris_administracion.CuentaCorriente".$PeriodoBeca."

				where

					NumeroRutAlumno = '".$NumeroRutAlumno."' and 

					Year(FechaVencimiento) = '".$PeriodoBeca."'

				group by CodigoItem"; 

	

	$res_pd = mysql_query($sql_pd, $conexion);

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$cuota_0_pagado = $row_nombre_profe['total_1'];

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$colegiatura_pagado = $row_nombre_profe['total_1'];



	$sql_tipo_beca = "SELECT IncorporacionTipoBeca, ColegiaturaTipoBeca

						FROM  gescolcl_arcoiris_administracion.TipoBeca

						where CodigoTipoBeca = '".$CodigoTipoBeca."'";	

	$res_tipo_beca = mysql_query($sql_tipo_beca,$conexion);

	$row_tipo_beca = mysql_fetch_array($res_tipo_beca);



	$IncorporacionTipoBeca = str_replace(',', '', $row_tipo_beca['IncorporacionTipoBeca']);

	$ColegiaturaTipoBeca = str_replace(',', '', $row_tipo_beca['ColegiaturaTipoBeca']);



	$cuota_0_resultado = $cuota_0 - $IncorporacionTipoBeca ;

	$colegiatura_resultado = $colegiatura - $ColegiaturaTipoBeca;



	$cuota_0_diferencia = $cuota_0_resultado - $cuota_0_pagado ;

	$colegiatura_diferencia = $colegiatura_resultado - $colegiatura_pagado;



	$objResponse->addAssign('cuota_0_pagado','value',number_format($cuota_0_pagado,0,'.',','));

	$objResponse->addAssign('colegiatura_pagado','value',number_format($colegiatura_pagado,0,'.',','));

	$objResponse->addAssign('cuota_0_diferencia','value',number_format($cuota_0_diferencia,0,'.',','));

	$objResponse->addAssign('colegiatura_diferencia','value',number_format($colegiatura_diferencia,0,'.',','));

	

	$objResponse->addAssign('cuota_0_resultado','value',number_format($cuota_0_resultado,0,'.',','));

	$objResponse->addAssign('colegiatura_resultado','value',number_format($colegiatura_resultado,0,'.',','));



	$objResponse->addAssign('cuota_0_beca','value',number_format($IncorporacionTipoBeca,0,'.',','));

	$objResponse->addAssign('colegiatura_beca','value',number_format($ColegiaturaTipoBeca,0,'.',','));



	return $objResponse->getXML();

	}





function ReCalculoResultados($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');



	$NumeroRutAlumno            = $data['NumeroRutAlumno'];

    $PeriodoBeca			 	= $_SESSION["sige_anio_escolar_vigente"];



    $sql_pd = "select ValorIncorporacion, ValorColegiatura

				from gescolcl_arcoiris_administracion.Aranceles

				where

					CodigoNivel in (	select CodigoNivel

										from gescolcl_arcoiris_administracion.Cursos

										where CodigoCurso in (

																select CodigoCurso

																from gescolcl_arcoiris_administracion.alumnos".$PeriodoBeca."

																where NumeroRutAlumno = '".$NumeroRutAlumno."'

																)

										) and 

					AnioPeriodo = '".$PeriodoBeca."'"; 

	

	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());

	

	$row_nombre_profe = mysql_fetch_array($res_pd);



    $cuota_0 = $row_nombre_profe['ValorIncorporacion'];

	$colegiatura = $row_nombre_profe['ValorColegiatura'];	



    $sql_pd = "select CodigoItem, sum(ValorPactado) as total, sum(ValorPagado) as total_1

				from gescolcl_arcoiris_administracion.CuentaCorriente".$PeriodoBeca."

				where

					NumeroRutAlumno = '".$NumeroRutAlumno."' and 

					Year(FechaVencimiento) = '".$PeriodoBeca."'

				group by CodigoItem"; 

	

	$res_pd = mysql_query($sql_pd, $conexion);

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$cuota_0_pagado = $row_nombre_profe['total_1'];

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$colegiatura_pagado = $row_nombre_profe['total_1'];



	$IncorporacionTipoBeca = str_replace(',', '', $data['cuota_0_beca']);

	$ColegiaturaTipoBeca = str_replace(',', '', $data['colegiatura_beca']);



	$cuota_0_resultado = $cuota_0 - $IncorporacionTipoBeca ;

	$colegiatura_resultado = $colegiatura - $ColegiaturaTipoBeca;



	$cuota_0_diferencia = $cuota_0_resultado - $cuota_0_pagado ;

	$colegiatura_diferencia = $colegiatura_resultado - $colegiatura_pagado;



	$objResponse->addAssign('cuota_0_pagado','value',number_format($cuota_0_pagado,0,'.',','));

	$objResponse->addAssign('colegiatura_pagado','value',number_format($colegiatura_pagado,0,'.',','));

	$objResponse->addAssign('cuota_0_diferencia','value',number_format($cuota_0_diferencia,0,'.',','));

	$objResponse->addAssign('colegiatura_diferencia','value',number_format($colegiatura_diferencia,0,'.',','));

	

	$objResponse->addAssign('cuota_0_resultado','value',number_format($cuota_0_resultado,0,'.',','));

	$objResponse->addAssign('colegiatura_resultado','value',number_format($colegiatura_resultado,0,'.',','));



	$objResponse->addAssign('cuota_0_beca','value',number_format($IncorporacionTipoBeca,0,'.',','));

	$objResponse->addAssign('colegiatura_beca','value',number_format($ColegiaturaTipoBeca,0,'.',','));







	return $objResponse->getXML();

	}



function CargaPagina($data){

    global $conexion;

    global $miSmarty;



    $objResponse = new xajaxResponse('UTF8');

	

	$NumeroRutAlumno            = $data['NumeroRutAlumno'];

	$CodigoCurso                = $data['CodigoCurso'];

    $anio					 	= $_SESSION["sige_anio_escolar_vigente"];

	$anio_ant = $anio - 1;

    

	$sql_nombre_profe ="select 

				Cursos.NombreCurso

				from gescolcl_arcoiris_administracion.Cursos

				where

					Cursos.CodigoCurso = '".$CodigoCurso."'

				";

	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

	if (mysql_num_rows($res_nombre_profe)=='0'){

		$sql_nombre_profe = "select 

									Cursos.NombreCurso

									from gescolcl_arcoiris_administracion.Cursos

									where

										Cursos.CodigoCurso in (select 	CodigoCurso

																from gescolcl_arcoiris_administracion.alumnos".$anio."

																where alumnos".$anio.".NumeroRutAlumno = '".$NumeroRutAlumno."')"; 

		$res_nombre_profe = mysql_query($sql_nombre_profe, $conexion) or die(mysql_error());

		}

	

	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);



	$objResponse->addAssign('NombreCurso','value',$row_nombre_profe['NombreCurso']);

	$objResponse->addAssign('anio_cursante','value',$anio);

	$objResponse->addAssign('anio_academico','innerHTML',$anio-1);

	

	$sql_pd = "select 

				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno

				from gescolcl_arcoiris_administracion.alumnos".$anio."

				where

					alumnos".$anio.".NumeroRutAlumno = '".$NumeroRutAlumno."'"; 

	

	$res_pd = mysql_query($sql_pd, $conexion);

	$row_nombre_profe = mysql_fetch_array($res_pd);



	$objResponse->addAssign('nombre_alumno','value',$row_nombre_profe['nombre_alumno']);



    

    $sql_pd = "select ValorIncorporacion, ValorColegiatura

				from gescolcl_arcoiris_administracion.Aranceles

				where

					CodigoNivel in (	select CodigoNivel

										from gescolcl_arcoiris_administracion.Cursos

										where CodigoCurso in (

																select CodigoCurso

																from gescolcl_arcoiris_administracion.alumnos".$anio."

																where NumeroRutAlumno = '".$NumeroRutAlumno."'

																)

										) and 

					AnioPeriodo = '".$anio."'"; 

	

	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());

	

	$row_nombre_profe = mysql_fetch_array($res_pd);



    $cuota_0 = $row_nombre_profe['ValorIncorporacion'];

	$colegiatura = $row_nombre_profe['ValorColegiatura'];

	

    $sql_pd = "select CodigoItem, sum(ValorPactado) as total, sum(ValorPagado) as total_1

				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."

				where

					NumeroRutAlumno = '".$NumeroRutAlumno."' and 

					Year(FechaVencimiento) = '".$anio."'

				group by CodigoItem"; 

	

	$res_pd = mysql_query($sql_pd, $conexion);

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$cuota_0_pagado = $row_nombre_profe['total_1'];

	$cuota_0_resultado = $row_nombre_profe['total'];

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$colegiatura_pagado = $row_nombre_profe['total_1'];

	$colegiatura_resultado = $row_nombre_profe['total'];



	

	$objResponse->addAssign('cuota_0','value',number_format($cuota_0,0,'.',','));

	$objResponse->addAssign('colegiatura','value',number_format($colegiatura,0,'.',','));

	

	$concat = ' concat(NombreTipoBeca, " $", FORMAT(IncorporacionTipoBeca,0), " $", FORMAT(ColegiaturaTipoBeca,0))  ';



		$sql_bb = "select  Becas.NumeroRutAlumno, TipoBeca.NombreTipoBeca,  TipoBeca.CodigoTipoBeca,

						 alumnos".$anio.".BecaIncorporacion, alumnos".$anio.".BecaColegiatura,

							TipoBeca.IncorporacionTipoBeca, TipoBeca.ColegiaturaTipoBeca

						from gescolcl_arcoiris_administracion.Becas 

							inner join gescolcl_arcoiris_administracion.TipoBeca

								on TipoBeca.CodigoTipoBeca = Becas.CodigoTipoBeca

							inner join gescolcl_arcoiris_administracion.alumnos".$anio."

								on alumnos".$anio.".NumeroRutAlumno = Becas.NumeroRutAlumno

						where  Becas.NumeroRutAlumno='".$NumeroRutAlumno."' and 

								PeriodoBeca = '".$anio."'";

			$res_bb = mysql_query($sql_bb,$conexion) or die(mysql_error());

			$row_bb = mysql_fetch_array($res_bb);



			if ($row_bb['BecaIncorporacion']=='0'){

				$row_bb['BecaIncorporacion'] = $row_bb['IncorporacionTipoBeca'];

				}

			

			if ($row_bb['BecaColegiatura']=='0'){

				$row_bb['BecaColegiatura'] = $row_bb['ColegiaturaTipoBeca'];

				}



		$sql_busca = "select concat(NombreTipoBeca, ' ', FORMAT(IncorporacionTipoBeca,0) , ' ', FORMAT(ColegiaturaTipoBeca,0)) as nombre

						from gescolcl_arcoiris_administracion.TipoBeca

						where CodigoTipoBeca = '".$row_bb['CodigoTipoBeca']."'";

		$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());

		$row_busca = mysql_fetch_array($res_busca);



	$nombre = $row_busca['nombre'];


	if ($row_bb['BecaColegiatura']=='0' && $row_bb['BecaColegiatura']=='0'){

		$sql_bb = "select  	Becas.NumeroRutAlumno, TipoBeca.NombreTipoBeca,  TipoBeca.CodigoTipoBeca,

							alumnos".$anio_ant.".BecaIncorporacion, alumnos".$anio_ant.".BecaColegiatura,

							TipoBeca.IncorporacionTipoBeca, TipoBeca.ColegiaturaTipoBeca

					from gescolcl_arcoiris_administracion.Becas 

						inner join gescolcl_arcoiris_administracion.TipoBeca

							on TipoBeca.CodigoTipoBeca = Becas.CodigoTipoBeca

						inner join gescolcl_arcoiris_administracion.alumnos".$anio_ant."

									on alumnos".$anio_ant.".NumeroRutAlumno = Becas.NumeroRutAlumno

					where  Becas.NumeroRutAlumno='".$NumeroRutAlumno."' and 

							PeriodoBeca = '".$anio_ant."'";

		$res_bb = mysql_query($sql_bb,$conexion) or die(mysql_error());

		$row_bb = mysql_fetch_array($res_bb);



		if ($row_bb['BecaIncorporacion']=='0'){

			$row_bb['BecaIncorporacion'] = $row_bb['IncorporacionTipoBeca'];

			}

		

		if ($row_bb['BecaColegiatura']=='0'){

			$row_bb['BecaColegiatura'] = $row_bb['ColegiaturaTipoBeca'];

			}

		}


	$sql_busca = "select concat(NombreTipoBeca, ' ', FORMAT(IncorporacionTipoBeca,0) , ' ', FORMAT(ColegiaturaTipoBeca,0)) as nombre

					from gescolcl_arcoiris_administracion.TipoBeca

					where CodigoTipoBeca = '".$row_bb['CodigoTipoBeca']."'";

	$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());

	$row_busca = mysql_fetch_array($res_busca);



	$nombre_beca_anio_pasado = $row_busca['nombre'];

	$objResponse->addAssign('nombre_beca_anio_pasado','innerHTML',$nombre_beca_anio_pasado);



	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'CodigoTipoBeca','gescolcl_arcoiris_administracion.TipoBeca','".$row_bb['CodigoTipoBeca']."','".$nombre."','CodigoTipoBeca','".$concat."', '')");

		

	$IncorporacionTipoBeca = $row_bb['BecaIncorporacion'];

	$ColegiaturaTipoBeca = $row_bb['BecaColegiatura'];





	$cuota_0_diferencia = $cuota_0_resultado - $cuota_0_pagado ;

	$colegiatura_diferencia = $colegiatura_resultado - $colegiatura_pagado;

	

	$objResponse->addAssign('cuota_0_pagado','value',number_format($cuota_0_pagado,0,'.',','));

	$objResponse->addAssign('colegiatura_pagado','value',number_format($colegiatura_pagado,0,'.',','));

	$objResponse->addAssign('cuota_0_diferencia','value',number_format($cuota_0_diferencia,0,'.',','));

	$objResponse->addAssign('colegiatura_diferencia','value',number_format($colegiatura_diferencia,0,'.',','));

	$objResponse->addAssign('cuota_0_resultado','value',number_format($cuota_0_resultado,0,'.',','));

	$objResponse->addAssign('colegiatura_resultado','value',number_format($colegiatura_resultado,0,'.',','));

	$objResponse->addAssign('cuota_0_beca','value',number_format($IncorporacionTipoBeca,0,'.',','));

	$objResponse->addAssign('colegiatura_beca','value',number_format($ColegiaturaTipoBeca,0,'.',','));





	$sql_pd = "select CodigoItem, ValorPactado

				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio_ant."

				where

					NumeroRutAlumno = '".$NumeroRutAlumno."' and 

					Year(FechaVencimiento) = '".$anio_ant."'

				group by CodigoItem, NumeroCuota"; 

	$res_pd = mysql_query($sql_pd, $conexion);

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$valor_pactado_cuota_0 = $row_nombre_profe['ValorPactado'];

	

	$row_nombre_profe = mysql_fetch_array($res_pd);

	$valor_pactado_cuota_colegiatura = $row_nombre_profe['ValorPactado'];	



	$objResponse->addAssign('anio_ant','innerHTML',$anio_ant);

	$objResponse->addAssign('valor_pactado_cuota_0','innerHTML','C0. '.number_format($valor_pactado_cuota_0,0,'.',','));

	$objResponse->addAssign('valor_pactado_cuota_colegiatura','innerHTML','C1. '.number_format($valor_pactado_cuota_colegiatura,0,'.',','));



 	$sql_pd = "select count(ValorPactado) as contador

				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio_ant."

				where

					NumeroRutAlumno = '".$NumeroRutAlumno."' and 

					FechaVencimiento <= '".date("Y-m-d")."' and

					ValorPactado > ValorPagado"; 

	$res_pd = mysql_query($sql_pd, $conexion);

	$row_nombre_profe = mysql_fetch_array($res_pd);



	$objResponse->addAssign('cuotas_vencidas','innerHTML',$row_nombre_profe['contador']);





	// $arrRegistros			= 	array();

	// $arrRegistrosDetalle_1	= 	array();

	// $arrRegistrosDetalle_2	= 	array();

	// $arrRegistrosDetalle_total 	= 	array();

	// $arrRegistrosPrueba		= 	array();

	// $arrRegistrosMaximo		= 	array();

	

	// $maximo = 3;

		

	// $sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,

	// 					`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, 

	// 					NumeroLista, Pruebas.CoeficientePrueba, Ramos.Descripcion

	// 			from alumnos".$anio_ant."

	// 				inner join Cursos

	// 					on alumnos".$anio_ant.".CodigoCurso = Cursos.CodigoCurso

	// 				inner join Asignaturas

	// 					on Asignaturas.CodigoCurso = Cursos.CodigoCurso and 

	// 						Asignaturas.CalculaPromedio = '0'

	// 				inner join Ramos

	// 					on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 

	// 				inner join Pruebas

	// 					on  Pruebas.CodigoCurso in (select CodigoCurso 

	// 												from alumnos".$anio_ant." 

	// 												where NumeroRutAlumno = '".$NumeroRutAlumno."' )

	// 			where

	// 			Cursos.CodigoCurso in (select CodigoCurso 

	// 												from alumnos".$anio_ant." 

	// 												where NumeroRutAlumno = '".$NumeroRutAlumno."' )and 

	// 			Pruebas.prueba_ncorr in (select prueba_ncorr  

	// 										from Pruebas 

	// 										where CodigoCurso in (select CodigoCurso 

	// 												from alumnos".$anio_ant." 

	// 												where NumeroRutAlumno = '".$NumeroRutAlumno."' )  and

	// 											AnoAcademico = '".$anio_ant."' and 

	// 											Semestre = '1' 

	// 										) 

	// 			and alumnos".$anio_ant.".NumeroRutAlumno = '".$NumeroRutAlumno."' 

	// 			group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista

	// 			order by Asignaturas.NumeroOrden, NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";

	

	// $res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());

	// //$objResponse->addAlert($sql_ve);

	// $promedio_1 = 0;

	// $promedio_2 = 0;

	// 	$i = 1;

	// 	while ($line_ve = mysql_fetch_row($res_ve)) {	

	// 		array_push($arrRegistros, array("item"					=>	$i, 

	// 										"nombre_alumno"			=> 	$line_ve[0], 

	// 										"rut_alumno"			=> 	$line_ve[1],

	// 										"asignatura" 			=> 	$line_ve[2],

	// 										"curso" 				=> 	$line_ve[3],

	// 										"anio"					=> 	$anio_ant,

	// 										"semestre"				=>	$semestre,

	// 										"nro_lista_alumno"		=> 	$line_ve[4],

	// 										"prueba"				=> 	$prueba,

	// 										"nombre_asignatura"		=> 	$line_ve[6]

	// 										));

	// 		$i++;

	// 		$j=1;

	// 	    $k=0;

	// 	    $z="";

	// 	    $total = 0;

	// 	    $codigo_ramo = "";

	// 	    $promedio_1 = 0;

		      

	// 		$temp_array = array();

	// 		$temp_array = generaPromedioSemestral($line_ve[1],$line_ve[3], $line_ve[2], $line_ve[5], $anio_ant, 1);



	// 		array_push($arrRegistrosDetalle_1, array("item"			=>	$j, 

	// 												"rut_alumno"			=> 	$temp_array[0]['rut_alumno'], 

	// 												"CodigoRamo"			=>	$temp_array[0]['CodigoRamo'], 

	// 												"nota"					=>	$temp_array[0]['nota'],

	// 												"semestre"				=>	'1'

	// 												));



	// 		$temp_array = array();

	// 		$temp_array = generaPromedioSemestral($line_ve[1],$line_ve[3], $line_ve[2], $line_ve[5], $anio_ant, 2);



	// 		array_push($arrRegistrosDetalle_2, array("item"			=>	$j, 

	// 											"rut_alumno"			=> 	$temp_array[0]['rut_alumno'], 

	// 											"CodigoRamo"			=>	$temp_array[0]['CodigoRamo'], 

	// 											"nota"					=>	$temp_array[0]['nota'],

	// 											"semestre"				=>	'2'

	// 											));



				

	// 		}





	// 	for($z=0;$z<count($arrRegistrosDetalle_1);$z++){

	// 		$promedio = round(($arrRegistrosDetalle_1[$z]['nota']+$arrRegistrosDetalle_2[$z]['nota'])/2,1);

	// 		$primer_numero= substr($promedio,0,1);

	// 		$segundo_numero= substr($promedio,2,1);

	// 		$promedio_letras = num2letras($primer_numero).', '.num2letras($segundo_numero);

	// 		if ($promedio_letras=='cero,cero') $promedio_letras = 'cero';



	// 		$promedio_final += $promedio;



	// 		array_push($arrRegistrosDetalle_total, array("item"			=>	$j, 

	// 								"CodigoRamo_1"			=>	$arrRegistrosDetalle_1[$z]['CodigoRamo'], 

	// 								"nota_t"				=>	$promedio, 

	// 								"letra_nota"			=>	$promedio_letras, 

	// 								"semestre_t"			=>	't'

	// 											));

				

			

	// 		}



	// 	$promedio_final = round($promedio_final/count($arrRegistrosDetalle_1),1);

	// 	$primer_numero= substr($promedio_final,0,1);

	// 	$segundo_numero= substr($promedio_final,2,1);

	// 	$promedio_final_letras = num2letras($primer_numero).', '.num2letras($segundo_numero);

	// 	if ($promedio_final_letras=='cero,cero') $promedio_final_letras = 'cero';



	$sql_prom = "select PromedioAno as promedio_final , AsistenciaAno

				 from gescolcl_arcoiris_administracion.SituacionFinal

				 where NumeroRutAlumno = '".$NumeroRutAlumno."' and 

				 	AnoAcademico = '".$anio_ant."'";

	$res_prom = mysql_query($sql_prom,$conexion);

	$row_prom = mysql_fetch_array($res_prom);

	$promedio_final = isset($row_prom['promedio_final']) ? round($row_prom['promedio_final'],1) : 'Periodo no cerrado';

	$AsistenciaAno = isset($row_prom['AsistenciaAno']) ? $row_prom['AsistenciaAno'] : 'Periodo no cerrado';

	$objResponse->addAssign('promedio_general','innerHTML',$promedio_final);

	$objResponse->addAssign('porc_asistencia_nominal','innerHTML',$AsistenciaAno);



	$porc_ina = number_format($porc_ina , 2 , "." , ",");

	

	$sql_atrasos = "select count(FechaAtraso) as ina

							 from gescolcl_arcoiris_administracion.Atrasos

						 where NumeroRutAlumno = '".$rut."' and 

						 		Year(FechaAtraso) = '".$anio."' ";

	$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());

	$row_atrasos = mysql_fetch_array($res_atrasos);

	$atrasos = $row_atrasos['ina'];

	

	

	$objResponse->addAssign('atrasos','innerHTML',$atrasos);





	return $objResponse->getXML();

}          



$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CalculoResultados");

$xajax->registerFunction("ReCalculoResultados");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('NumeroRutAlumno', $_GET["rut_alumno"]);

$miSmarty->assign('CodigoCurso', $_GET["curso"]);



$miSmarty->display('sg_becas_asociar_detalle.tpl');





ob_flush();

?>