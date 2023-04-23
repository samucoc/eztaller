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

$xajax->setRequestURI("sg_alumnos_matricula.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Enviar($data, $ncorr,$matriculado){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');
	/*
	$sql_update = "update gescolcl_arcoiris_administracion.alumnos".$anio.". 
					set Matriculado = '1'
					where NumeroRutAlumno = '".$ncorr."'";
	$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
	*/
	$sigue='SI';
	$sql_2 = "select NumeroRutAlumno, MotivoCondicion
				from gescolcl_arcoiris_administracion.AlumnosCondicional
				where NumeroRutAlumno = '".$ncorr."'";
	$res_2 = mysql_query($sql_2,$conexion);
	if (mysql_num_rows($res_2)>0){
		$row_2 = mysql_fetch_array($res_2);
		$sql_2 = "select 	NombreCondicional
				from gescolcl_arcoiris_administracion.MotivosCondicionales
				where CodigoCondicional = '".$row_2['MotivoCondicion']."'";
		$res_2 = mysql_query($sql_2,$conexion);
		$row_2 = mysql_fetch_array($res_2);
		
		$objResponse->addAlert("Alumno ".$row['nombre_alumno']." con Matricula Condicionada - Motivo: ".$row_2['NombreCondicional']);
		
		$sigue="NO";
		}
	if ($sigue=='SI'){
		if ($matriculado == '0'){
			$objResponse->addScript("showPopWin('sg_alumnos_matriculados.php?rut_alumno=".$ncorr."', 'Ingresar Matricula', 1000, 400, null);");
			}
		else{
			$objResponse->addScript("location.href='sg_alumnos_cobranza.php?rut_alumno=".$ncorr."';");
			}
		}
	//$objResponse->addAlert("Registro Actualizado");
	//$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'));");


	return $objResponse->getXML();

}

function VolverMatricular_1($data,$rut_alumno){
	global $conexion;
	global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$rut_alumno = substr($rut_alumno,0,8);

	$sql_movimientos = "delete	from gescolcl_arcoiris_administracion.CuentaCorriente".$anio." 
					where NumeroRutAlumno = '".$rut_alumno."' ";
		//$res_movimientos = mysql_query($sql_movimientos,$conexion) or die(mysql_error());

		$sql_update = "update gescolcl_arcoiris_administracion.alumnos".$anio."
						set Matriculado = '0'
						where NumeroRutAlumno = '".$rut_alumno."'";
		$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
		
		$objResponse->addAlert("Registro Actualizado.");
		$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'));");

	return $objResponse->getXML();

}

function VolverMatricular($data,$rut_alumno){
	global $conexion;
	global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("var msj = confirm('RECUERDE SOLICITAR FIRMA RENUNCIA VACANTE. Desea eliminar la matricula del alumno seleccionado?');
							if (msj)
								xajax_VolverMatricular_1(xajax.getFormValues('Form1'),'$rut_alumno');");
		
		
	return $objResponse->getXML();
	
	}

function Grabar($data){
	global $conexion;
	global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');
	
	$curso_act                 =       $data['curso'];
	$curso                     =       $data['curso'];
	$alumno                    =       $data['OBLINumeroRutAlumno'];
	$apoderado                 =       $data['OBLINumeroRutApoderado'];
    $nombre_alumno             =       $data['BSCNombresAlumno'];

    $anio = $_SESSION["sige_anio_escolar_vigente"];
      
    /*
    if {
    	$and = " and alumnos".$anio.".NumeroRutAlumno = '".$alumno."' ";
    	}
	*/

	if ($alumno>'0'){
		$sql_pd = "select 
				distinct alumnos".$anio.".CodigoCurso
				from gescolcl_arcoiris_administracion.alumnos".$anio."
				where
					alumnos".$anio.".NumeroRutAlumno = '".$alumno."'
				order by alumnos".$anio.".NumeroLista"; 
	
		$res_pd = mysql_query($sql_pd, $conexion);
		$row_curso = mysql_fetch_array($res_pd);
		$curso_act = $row_curso['CodigoCurso'];
		$objResponse->addAssign('OBLINumeroRutAlumno','value','');
		$objResponse->addAssign('BSCNombresAlumno','value','');
		}


	if ($apoderado>'0'){
		$sql_pd = "select 
				distinct Cursos.CodigoCurso
				from gescolcl_arcoiris_administracion.Cursos
					inner join gescolcl_arcoiris_administracion.alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio.".NumeroRutApoderado = '".$apoderado."'
				order by alumnos".$anio.".NumeroLista"; 
	
		$res_pd = mysql_query($sql_pd, $conexion);
		$row_curso = mysql_fetch_array($res_pd);
		$curso = $row_curso['CodigoCurso'];
		$objResponse->addAssign('OBLINumeroRutAlumno','value','');
		$objResponse->addAssign('BSCNombresAlumno','value','');
		}


	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql_nombre_profe ="select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor
				from gescolcl_arcoiris_administracion.Cursos
					left join gescolcl_arcoiris_administracion.Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
				where
					Cursos.CodigoCurso = '".$curso_act."' 
				";
	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());
	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);

	$miSmarty->assign('nombre_curso', $row_nombre_profe['NombreCurso']);
	$miSmarty->assign('nombre_profe', $row_nombre_profe['nombre_profesor']);
	
	$sql_001 = "select count(Matriculado) as matriculados
				from gescolcl_arcoiris_administracion.alumnos".$anio."
				where
					CodigoCurso = '".$curso_act."' ";
	$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
	$row_001 = mysql_fetch_array($res_001);
	$miSmarty->assign('total', $row_001['matriculados']);
	
	$sql_001 = "select count(Matriculado) as matriculados
				from gescolcl_arcoiris_administracion.alumnos".$anio."
				where
					CodigoCurso = '".$curso_act."' and Matriculado = 1";
	$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
	$row_001 = mysql_fetch_array($res_001);
	$miSmarty->assign('matriculados', $row_001['matriculados']);
	
	$sql_001 = "select count(Matriculado) as matriculados
				from gescolcl_arcoiris_administracion.alumnos".$anio."
				where
					CodigoCurso = '".$curso_act."' and Matriculado = 0 ";
	$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
	$row_001 = mysql_fetch_array($res_001);
	$miSmarty->assign('no_matriculados', $row_001['matriculados']);
	
	$sql_001 = "select count(Matriculado) as matriculados
				from gescolcl_arcoiris_administracion.alumnos".$anio."
				where
					CodigoCurso = '".$curso_act."' and Matriculado = 2 ";
	$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
	$row_001 = mysql_fetch_array($res_001);
	$miSmarty->assign('retirados', $row_001['matriculados']);
	
	$and ='';
	
	if (($curso_act=='Elija')||($curso_act=='')){
		if ($alumno!=''){
			$sql_pd = "select 
					distinct Cursos.CodigoCurso
					from gescolcl_arcoiris_administracion.Cursos
						inner join gescolcl_arcoiris_administracion.alumnos".$anio."
							on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					where
						alumnos".$anio.".NumeroRutAlumno = '".$alumno."'"; 
		
			$res_pd = mysql_query($sql_pd, $conexion);
			$row_curso = mysql_fetch_array($res_pd);
			$curso = $row_curso['CodigoCurso'];
			}
		elseif($apoderado!=''){
			$sql_pd = "select 
					distinct Cursos.CodigoCurso
					from gescolcl_arcoiris_administracion.Cursos
						inner join gescolcl_arcoiris_administracion.alumnos".$anio."
							on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					where
						alumnos".$anio.".NumeroRutApoderado = '".$apoderado."'"; 
		
			$res_pd = mysql_query($sql_pd, $conexion);
			$row_curso = mysql_fetch_array($res_pd);
			$curso = $row_curso['CodigoCurso'];
			}
		else{
			$curso = "";
			}
		}
	else{
		$and = "Cursos.CodigoCurso = '".$curso_act."'";
		}
		
	
	if ($nombre_alumno!=''){
		if ($curso=='Elija'){
			$and = " alumnos".$anio.".NumeroRutAlumno = '".$alumno."' ";
		
		}else{
			$and = " Cursos.CodigoCurso = '".$curso."' and 
				  Cursos.CodigoCurso <> 0 and 
				  alumnos".$anio.".NumeroRutAlumno = '".$alumno."' ";
			}
		}
	if ($apoderado!=''){
		$and = " 1 and alumnos".$anio.".NumeroRutApoderado = '".$apoderado."' ";
		}
	
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 
				alumnos".$anio.".NumeroLista,
				alumnos".$anio.".NumeroRutAlumno,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				alumnos".$anio.".SexoAlumno,
				alumnos".$anio.".FechaNacimiento,
				alumnos".$anio.".Matriculado
				from gescolcl_arcoiris_administracion.Cursos
					left join gescolcl_arcoiris_administracion.Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join gescolcl_arcoiris_administracion.alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					$and
				order by concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) asc"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			$sql_2 = "select NumeroRutAlumno, MotivoCondicion
				from gescolcl_arcoiris_administracion.AlumnosCondicional
				where NumeroRutAlumno = '".$line_pd[3]."'";
			$res_2 = mysql_query($sql_2,$conexion);
			$condicional = '0';
			if (mysql_num_rows($res_2)>0){
				$condicional = '1';
				}			
			array_push($arrRegistros, array("item"		=>	$i,
											"curso"		=>	$line_pd[0],
											"profesor"	=>	$line_pd[1],
											"nro_lista"	=> 	$line_pd[2],
											"condicional"	=> 	$condicional,
											"rut_alumno" 		=> 	$line_pd[3].'-'.dv($line_pd[3]),
											"nombre_alumno"	=> 	$line_pd[4],
											"sexo_alumno"	=> 	$line_pd[5],
											"fecha_nacimiento"	=> 	$line_pd[6],
											"matriculado"	=> 	$line_pd[7]));
			$i++;
                       
		}
		       
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_matricula_list.tpl'));
		//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	$objResponse->addScript("para()");
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
	
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
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
$xajax->registerFunction("Enviar");
$xajax->registerFunction("VolverMatricular");
$xajax->registerFunction("VolverMatricular_1");
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

$miSmarty->display('sg_alumnos_matricula.tpl');


ob_flush();
?>

