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

$xajax->setRequestURI("sg_informes_listado_curso_beneficio.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Enviar($data,$arrRegistros){

}

function Grabar($data){
	global $conexion;
	global $miSmarty;
        set_time_limit(100000);
        
	$objResponse = new xajaxResponse('UTF8');
	
	$curso                     =       $data['curso'];
    $anio = $_SESSION["sige_anio_escolar_vigente"];
	 
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql_nombre_profe ="select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
				where
					Cursos.CodigoCurso = '".$curso."'
				";
	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());
	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);

	$miSmarty->assign('nombre_curso', $row_nombre_profe['NombreCurso']);
	$miSmarty->assign('nombre_profe', $row_nombre_profe['nombre_profesor']);
	
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 
				alumnos".$anio.".NumeroRutAlumno,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				alumnos".$anio.".SexoAlumno,
				date_format(alumnos".$anio.".FechaNacimiento, '%d/%m/%Y') as FechaNacimiento,
				alumnos".$anio.".Matriculado,
				alumnos".$anio.".EMailAlumno as EMailApoderado	
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					Cursos.CodigoCurso = '".$curso."' and alumnos".$anio.".Matriculado	='1'
				order by alumnos".$anio.".PaternoAlumno,  alumnos".$anio.".MaternoAlumno,  alumnos".$anio.".NombresAlumno"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	$arrRegistros		= 	array();
	$i 					= 	1;
	$j=1;
	$o = 1;	
	while ($line_pd = mysql_fetch_row($res_pd)) {
		$sql_matriculado = "
			select 	Matriculas.NroMatricula	,
					Matriculas.NroLista	,
					Matriculas.Fecha	,
					Matriculas.FechaRetiro	
			from Matriculas
				inner join alumnos".$anio."
					on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
						Matriculas.Anio = '".$anio."'
			where  alumnos".$anio.".NumeroRutAlumno = '".$line_pd[2]."'
			order by FechaRetiro desc 
			limit 0,1";
		$res_matriculado = mysql_query($sql_matriculado,$conexion) or die(mysql_error());
		$row_matriculado = mysql_fetch_array($res_matriculado);

		array_push($arrRegistros, array("item"		=>	$o,
										"curso"		=>	$line_pd[0],
										"profesor"	=>	$line_pd[1],
										"FechaRetiro"	=> 	$row_matriculado['FechaRetiro'],
										"nro_lista"	=> 	$row_matriculado['NroLista'],
										"rut_alumno" 		=> 	$line_pd[2].'-'.dv($line_pd[2]),
										"nombre_alumno"	=> 	$line_pd[3],
										"sexo_alumno"	=> 	$line_pd[4],
										"fecha_nacimiento"	=> 	$line_pd[5],
										"matriculado"	=> 	$line_pd[6],
										"EMailApoderado"	=> 	$line_pd[7]));
		if ($row_matriculado['FechaRetiro']!='0000-00-00'){
			$i++;
		}
		else{
			$j++;
		}
		$o++;
        //{if $arrRegistros[registros].FechaRetiro != '0000-00-00'} style="text-decoration:line-through;" {/if}     
	}
	
	$anio_ant = $anio-1;

	$sql_pd = "select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 
				alumnos".$anio_ant.".NumeroRutAlumno,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				alumnos".$anio_ant.".SexoAlumno,
				date_format(alumnos".$anio_ant.".FechaNacimiento, '%d/%m/%Y') as FechaNacimiento,
				'0'	as Matriculado
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join alumnos".$anio_ant."
						on alumnos".$anio_ant.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio_ant.".Matriculado = '1' and
					Cursos.CursoPrecede = '".$curso."' and 
					alumnos".$anio_ant.".NumeroRutAlumno not in (
																select alumnos".$anio.".NumeroRutAlumno
																from alumnos".$anio."
																where 	alumnos".$anio.".Matriculado	='1'  and
																		alumnos".$anio.".CodigoCurso = '".$curso."'	

																)
				order by alumnos".$anio_ant.".PaternoAlumno"; 
		
	$res_pd = mysql_query($sql_pd, $conexion);
	$m=1;
	if (mysql_num_rows($res_pd) > 0){
		while ($line_pd = mysql_fetch_row($res_pd)) {
			$sql_matriculado = "
				select 	Matriculas.NroMatricula	,
						Matriculas.NroLista	,
						Matriculas.Fecha	,
						Matriculas.FechaRetiro	
				from Matriculas
					inner join alumnos".$anio_ant."
						on alumnos".$anio_ant.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio_ant."'
				where  alumnos".$anio_ant.".NumeroRutAlumno = '".$line_pd[2]."'
				order by FechaRetiro desc 
				limit 0,1";
			$res_matriculado = mysql_query($sql_matriculado,$conexion) or die(mysql_error());
			$row_matriculado = mysql_fetch_array($res_matriculado);

			array_push($arrRegistros, array("item"		=>	$m,
											"curso"		=>	$line_pd[0],
											"profesor"	=>	$line_pd[1],
											"nro_lista"	=> 	$row_matriculado['NroLista'],
											"rut_alumno" 		=> 	$line_pd[2].'-'.dv($line_pd[2]),
											"nombre_alumno"	=> 	$line_pd[3],
											"sexo_alumno"	=> 	$line_pd[4],
											"fecha_nacimiento"	=> 	$line_pd[5],
											"FechaRetiro"	=> 	$row_matriculado['FechaRetiro'],
											"matriculado"	=> 	$row_matriculado['FechaRetiro'] != '0000-00-00' ? '2' : '0'));
			$m++;
                       
		}
		       
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	// array_push($arrRegistros, array("item"		=>	'----',
	// 								"rut_alumno"		=>	'Matricula Vigente',
	// 								"nombre_alumno"	=>	$j-$i+1,
	// 								"FechaRetiro"	=> 	'0000-00-00'));

	// array_push($arrRegistros, array("item"		=>	'----',
	// 								"rut_alumno"		=>	'Retiros',
	// 								"nombre_alumno"	=>	$i-1,
	// 								"FechaRetiro"	=> 	'0000-00-00'));

	// array_push($arrRegistros, array("item"		=>	'----',
	// 								"rut_alumno"		=>	'No Matriculados',
	// 								"nombre_alumno"	=>	$m-1,
	// 								"FechaRetiro"	=> 	'0000-00-00'));

	
	// asigno las sesiones para el ordenamiento
	$_SESSION["alycar_matriz"] 	= 
	$arrRegistros;
	$miSmarty->assign('arrRegistros', $arrRegistros);
	//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_listado_curso_beneficio_list.tpl'));
	//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	$objResponse->addScript("para()");
        Enviar($data,$arrRegistros);
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_listado_curso_beneficio_list.tpl'));
	
	
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

$miSmarty->display('sg_informes_listado_curso_beneficio.tpl');


ob_flush();
?>

