<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
ob_start();
session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; //validaciones



$xajax = new xajax();



$xajax->setRequestURI("sg_becas_asociar.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();


function Enviar($data){

}

function Grabar($data){

	global $conexion;

	global $miSmarty;

        set_time_limit(100000);

        

	$objResponse = new xajaxResponse('UTF8');

	

	$curso                     	= $data['curso'];

    $anio 						= $_SESSION["sige_anio_escolar_vigente"];

	$alumno 					= $data['rutAlumno'];



	$and_alumno = '';

	if (($curso!='')&&($curso!='- - Elija - -')&&($curso!='-- Elija --')){

		$and_alumno .= " and gescolcl_arcoiris_administracion.alumnos".$anio.".CodigoCurso = '".$curso."' ";

		$objResponse->addAssign('OBLI-cboAlumno','value','');

		$objResponse->addAssign('rutAlumno','value','');

		}

	else{

		if ($alumno!=''){

			$and_alumno .= " and gescolcl_arcoiris_administracion.alumnos".$anio.".NumeroRutAlumno IN (	select NumeroRutAlumno

																		from gescolcl_arcoiris_administracion.alumnos".$anio."

																		where NumeroRutApoderado in (select NumeroRutApoderado

																										from gescolcl_arcoiris_administracion.alumnos".$anio."

																										where NumeroRutAlumno = '".$alumno."'

																									)

																	)  ";

			}

		}

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	
	if ($curso>0){
		$sql_nombre_profe ="select 

					distinct

					Cursos.NombreCurso,

					Cursos.CodigoCurso,

					concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor

					from gescolcl_arcoiris_administracion.Cursos

						left join gescolcl_arcoiris_administracion.Profesores

							on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 

					where

						Cursos.CodigoCurso = '".$curso."'

					";
		}
	else{
		$sql_nombre_profe ="select 

				distinct

				Cursos.NombreCurso,
				
				Cursos.CodigoCurso,

				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor

				from gescolcl_arcoiris_administracion.Cursos

					left join gescolcl_arcoiris_administracion.Profesores

						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					
					left join gescolcl_arcoiris_administracion.alumnos".$anio."

						on gescolcl_arcoiris_administracion.alumnos".$anio.".CodigoCurso = gescolcl_arcoiris_administracion.Cursos.CodigoCurso
				where

					gescolcl_arcoiris_administracion.alumnos".$anio.".NumeroRutAlumno = '".$alumno."'

				";

	}
	
	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);



	$miSmarty->assign('nombre_curso', $row_nombre_profe['NombreCurso']);

	$miSmarty->assign('nombre_profe', $row_nombre_profe['nombre_profesor']);

	

	$sql_pd = "select 

				distinct

				Cursos.NombreCurso,

				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 

				alumnos".$anio.".NumeroLista,

				alumnos".$anio.".NumeroRutAlumno,

				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 

				alumnos".$anio.".SexoAlumno,

				alumnos".$anio.".FechaNacimiento,

				alumnos".$anio.".Matriculado,

				alumnos".$anio.".PorcBecaIncorporacion,

				alumnos".$anio.".PorcBecaColegiatura	

				from gescolcl_arcoiris_administracion.Cursos

					left join gescolcl_arcoiris_administracion.Profesores

						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 

					inner join gescolcl_arcoiris_administracion.alumnos".$anio."

						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

				where

					1 $and_alumno and alumnos".$anio.".CodigoCurso = ".$row_nombre_profe['CodigoCurso']."


				order by alumnos".$anio.".PaternoAlumno"; 

	

	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());

	$arrRegistros		= 	[];

	$i 					= 	1;

	while ($line_pd = mysql_fetch_row($res_pd)) {

		$sql_bb = "select  Becas.NumeroRutAlumno, TipoBeca.NombreTipoBeca, alumnos".$anio.".BecaIncorporacion, alumnos".$anio.".BecaColegiatura,

						TipoBeca.IncorporacionTipoBeca, TipoBeca.ColegiaturaTipoBeca

					from gescolcl_arcoiris_administracion.Becas 

						inner join gescolcl_arcoiris_administracion.TipoBeca

							on TipoBeca.CodigoTipoBeca = Becas.CodigoTipoBeca

						inner join gescolcl_arcoiris_administracion.alumnos".$anio."

							on alumnos".$anio.".NumeroRutAlumno = Becas.NumeroRutAlumno

					where  Becas.NumeroRutAlumno='".$line_pd[3]."' and 

							PeriodoBeca = '".$anio."'";

		$res_bb = mysql_query($sql_bb,$conexion) or die(mysql_error());

		$row_bb = mysql_fetch_array($res_bb);



		if ($row_bb['BecaIncorporacion']=='0'){

			$row_bb['BecaIncorporacion'] = $row_bb['IncorporacionTipoBeca'];

			}

		

		if ($row_bb['BecaColegiatura']=='0'){

			$row_bb['BecaColegiatura'] = $row_bb['ColegiaturaTipoBeca'];

			}

		

		array_push($arrRegistros, array("item"		=>	$i,

										"curso"		=>	$line_pd[0],

										"profesor"	=>	$line_pd[1],

										"nro_lista"	=> 	$line_pd[2],

										"rut_alumno_0" 		=> 	$line_pd[3],

										"rut_alumno" 		=> 	$line_pd[3].'-'.dv($line_pd[3]),

										"nombre_alumno"	=> 	$line_pd[4],

										"sexo_alumno"	=> 	$line_pd[5],

										"fecha_nacimiento"	=> 	$line_pd[6],

										"matriculado"	=> 	$line_pd[7],

										"con_beca"	=> 	$row_bb['NombreTipoBeca'],

										"IncorporacionTipoBeca"	=> 	$row_bb['BecaIncorporacion'],

										"ColegiaturaTipoBeca"	=> 	$row_bb['BecaColegiatura'],

										"PorcBecaIncorporacion"	=> 	$line_pd[8],

										"PorcBecaColegiatura"	=> 	$line_pd[9]));



		$tot_incor += $row_bb['BecaIncorporacion'];

		$tot_cole += $row_bb['BecaColegiatura'];



		$i++;

                   

	}

	

	array_push($arrRegistros, array("item"		=>	$i,

										"curso"		=>	'',

										"profesor"	=>	'',

										"nro_lista"	=> 	'Totales',

										"rut_alumno_0" 		=> 	'',

										"rut_alumno" 		=> '',

										"nombre_alumno"	=> 	'',

										"sexo_alumno"	=> 	'',

										"fecha_nacimiento"	=> 	'',

										"matriculado"	=> 	'',

										"con_beca"	=> '',

										"IncorporacionTipoBeca"	=> 	$tot_incor,

										"ColegiaturaTipoBeca"	=> 	$tot_cole));



		



	// asigno las sesiones para el ordenamiento

	$_SESSION["alycar_matriz"] 	= 	$arrRegistros;

	
	

	$miSmarty->assign('arrRegistros', $arrRegistros);

	

	//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");

	

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_becas_asociar_list.tpl'));

	//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);

		
	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	//$objResponse->addScript("para()");

    //Enviar($data,$arrRegistros);

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

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_becas_asociar_list.tpl'));

	

	

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

			$objResponse->addCreate("$select","option",""); 		

                    $objResponse->addAssign("$select","options[0].value", '');

                    $objResponse->addAssign("$select","options[0].text", '- - Elija - -'); 	

                    

			$j=1;

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

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','gescolcl_arcoiris_administracion.Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	

	//$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");



	return $objResponse->getXML();

}          

function LlamaDetalle($data, $rut_alumno){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$curso                     =       $data['curso'];

    $anio = $_SESSION["sige_anio_escolar_vigente"];

		

	$objResponse->addScript("showPopWin('sg_becas_asociar_detalle.php?rut_alumno=$rut_alumno&curso=$curso', 'Asociar Beca', 1000, 500, null);");

	

	return $objResponse->getXML();

}

function LlamaDetalle_1($data, $rut_alumno){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$curso                     =       $data['curso'];

    

		$objResponse->addScript("showPopWin('sg_becas_asociar_detalle.php?rut_alumno=$rut_alumno&curso=$curso', 'Asociar Beca', 1000, 500, null);");

	

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

$xajax->registerFunction("LlamaDetalle_1");

$xajax->registerFunction("CargaSubFamilias");

$xajax->registerFunction("Imprime");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);

$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);

$miSmarty->assign('DESDE', $_GET["desde"]);

$miSmarty->assign('HASTA', $_GET["hasta"]);



$miSmarty->display('sg_becas_asociar.tpl');

ob_flush();
?>