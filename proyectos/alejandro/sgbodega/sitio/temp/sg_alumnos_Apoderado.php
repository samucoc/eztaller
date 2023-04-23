<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_alumnos_Apoderado.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function ConfirmarNotas($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
	
	if (count($seleccion) > 0){
		if ($ingresa == 'SI'){
			$total = count($seleccion);
			foreach ($data['seleccion'] as $ncorr) {
				$nota = $data['nota_'.$ncorr];
				$arr_nota = explode("_",$ncorr);//{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre_{$arrRegistros[registros].prueba}
				$select_notas = "select max(NumeroNota) as maximo
								from NotasAlumnos
								where  NumeroRutAlumno = '".$arr_nota[0]."' and 
										CodigoCurso = '".$arr_nota[3]."' and 
										CodigoRamo = '".$arr_nota[1]."' and  
										AnoAcademico = '".$arr_nota[2]."' and  
										Semestre = '".$arr_nota[4]."'";
				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
				$row_notas = mysql_fetch_array($res_notas);
				$nro_nota = $row_notas['maximo'] + 1;
				list($dia1,$mes1,$anio1) = explode('-', $data['fecha_'.$ncorr]);
				$fecha_prueba = $anio1.'-'.$mes1.'-'.$dia1;
				$observacion = $data['observacion_'.$ncorr];
				if (($nota<=7)){
					if (($nota!='')){
						$sql_1 = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 
															 `Semestre`, `NumeroNota`, `Prueba`, `Nota`) 
								VALUES ('".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."','".$arr_nota[1]."',
										'".$arr_nota[4]."','".$nro_nota."','".$arr_nota[5]."','".$nota."')";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 
						}
					}
				else{
					$objResponse->addAlert("Error al ingresar Nota");	
					}
				}
			}
		}
		
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");	
	
    return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	if ($obj1 == 'OBLI-txtCodCobrador'){
        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");
        
            }
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
		
	return $objResponse->getXML();

}  

function CargaAsignaturas($data){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$select 		= 'asignaturas';
	$codigo_curso 	= $data['curso'];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select CodigoRamo as codigo, Descripcion as descripcion 
			from Ramos 
			where CodigoRamo in (select CodigoRamo
								from Asignaturas
								where CodigoCurso = '".$codigo_curso."')";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
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
function CargaPruebas($data,$codigo_asignaturas){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$select 				= 'pruebas';
	$codigo_curso 			= $data['curso'];
	$anio 					= $data['anio'];
	$semestre 			= $data['semestre'];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select prueba_ncorr as codigo, DescripcionPrueba as descripcion 
			from Pruebas 
			where CodigoRamo = '".$codigo_asignaturas."'  and  
				CodigoCurso = '".$codigo_curso."'  and
				AnoAcademico = '".$anio."' and 
				Semestre = '".$semestre."'";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
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
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$ncorr 		= 	$data["$objeto1"];
	$ncorr_1 	= 	$data["$objeto2"];
        
    $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr_1."'  ";
	
    $res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", '0');
			$objResponse->addAssign("$select","options[".$j."].text", 'Apoderado Principal'); 	
 				
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$rut					=	$data['rut'];
	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$arrRegistros = array();
	
	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno, NombreCurso
							from alumnos".$anio."
							inner join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where NumeroRutAlumno = '".$rut."'";
	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());
	$row_RA = mysql_fetch_array($res_nombre_alumno);
	
	$miSmarty->assign("nombre_alumno",$row_RA['nombre_alumno']);
	$miSmarty->assign("nombre_curso",$row_RA['NombreCurso']);
	$objResponse->addAssign('alumno','innerHTML',' - '.$row_RA['nombre_alumno'].' - '.$row_RA['NombreCurso']);
	

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,
									concat(PaternoApoderado, ' ', MaternoApoderado, ' ', NombresApoderado) as nombre_apoderado,
									TiposApoderados.nombre as nombre, NombreCurso, DireccionParticularApoderado,
									TelefonoParticularApoderado, EMailApoderado, TelefonoMovilApoderado,
									Apoderados.NumeroRutApoderado, alumnos".$anio.".NumeroRutAlumno,
									Apoderados_tienen_Alumnos.ata_ncorr
							from Apoderados
								inner join Apoderados_tienen_Alumnos
									on Apoderados.NumeroRutApoderado = Apoderados_tienen_Alumnos.RutApoderado
								left join alumnos".$anio."
									on alumnos".$anio.".NumeroRutAlumno = Apoderados_tienen_Alumnos.RutAlumno
								inner join TiposApoderados
									on Apoderados.TipoApoderado = TiposApoderados.ta_ncorr
								left join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where Apoderados_tienen_Alumnos.RutAlumno = '".$rut."'
							union
							select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,
									concat(PaternoApoderado, ' ', MaternoApoderado, ' ', NombresApoderado) as nombre_apoderado,
									'Apoderado Principal' as nombre, NombreCurso, DireccionParticularApoderado,
									TelefonoParticularApoderado, EMailApoderado, TelefonoMovilApoderado,
									Apoderados.NumeroRutApoderado, alumnos".$anio.".NumeroRutAlumno,
									'9999999' as ata_ncorr
							from Apoderados
								left join alumnos".$anio."
									on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado
								left join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where alumnos".$anio.".NumeroRutAlumno = '".$rut."'
							";
	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());
		
		while ($row_RA = mysql_fetch_array($res_nombre_alumno)) {
			array_push($arrRegistros, array("item"					=>	"-",
											"ncorr"					=>	$row_RA['ata_ncorr'],
											"nombre_apoderado"		=>	$row_RA['nombre_apoderado'],
											"direcc_apoderado"		=>	$row_RA['DireccionParticularApoderado'],
											"telefono_apoderado"	=>	$row_RA['TelefonoParticularApoderado'],
											"movil_apoderado"		=>	$row_RA['TelefonoMovilApoderado'],
											"correo_apoderado"		=>	$row_RA['EMailApoderado'],
											"RutAlumno"				=>	$row_RA['NumeroRutAlumno'],
											"RutApoderado"			=>	$row_RA['NumeroRutApoderado'],
											"tipo_apoderado"		=>	$row_RA['nombre']
											));
			$i++;
			}

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_Apoderado_list.tpl'));
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	return $objResponse->getXML();
	}
function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba,$nro_nota){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$objResponse->addScript("showPopWin('sg_notas_actualizar.php?rut_alumno=".$rut_alumno."&asignatura=".$asignatura."&anio=".$anio."&curso=".$curso."&semestre=".$semestre."&prueba=".$prueba."&nro_nota=".$nro_nota."', 'Actualizar Nota', 800, 600, null);");

	return $objResponse->getXML();
	}

function TraerApoderado($data,$RutApoderado, $RutAlumno){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

    $select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,
									concat(PaternoApoderado, ' ', MaternoApoderado, ' ', NombresApoderado) as nombre_apoderado,
									Apoderados.TipoApoderado
							from Apoderados
								inner join Apoderados_tienen_Alumnos
									on Apoderados.NumeroRutApoderado = Apoderados_tienen_Alumnos.RutApoderado
								left join alumnos".$anio."
									on alumnos".$anio.".NumeroRutAlumno = Apoderados_tienen_Alumnos.RutAlumno
								left join TiposApoderados
									on Apoderados.TipoApoderado = TiposApoderados.ta_ncorr
								left join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where Apoderados_tienen_Alumnos.RutAlumno = '".$RutAlumno."' and 
									 Apoderados.NumeroRutApoderado = '".$RutApoderado."'
							union
							select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,
									concat(PaternoApoderado, ' ', MaternoApoderado, ' ', NombresApoderado) as nombre_apoderado,
									'0' as TipoApoderado
							from Apoderados
								left join alumnos".$anio."
									on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado
								left join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where alumnos".$anio.".NumeroRutAlumno = '".$RutAlumno."' and 
									 Apoderados.NumeroRutApoderado = '".$RutApoderado."'
							";
	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());
		
	$row_RA = mysql_fetch_array($res_nombre_alumno);

	$objResponse->addAssign('apoderado','value',$row_RA['nombre_apoderado']);
	$objResponse->addAssign('OBLIApoderado','value',$RutApoderado);
	$objResponse->addAssign('rut','value',$RutAlumno);
	$objResponse->addAssign('tipo_apoderado','value',$row_RA['TipoApoderado']);

			
	return $objResponse->getXML();
	}

function ActualizarApoderado($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$apoderado = $data['OBLIApoderado'];
	$alumno = $data['rut'];
	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$update = "update alumnos".$anio." set
					NumeroRutApoderado = '".$apoderado."'
					where NumeroRutAlumno = '".$alumno."'";
	$res = mysql_query($update,$conexion) or die(mysql_error());

	$sql_insert = "update `Apoderados_tienen_Alumnos` set
						RutApoderado = '".$apoderado."'
					where RutAlumno = '".$alumno."'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	return $objResponse->getXML();
	}

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$apoderado = $data['OBLIApoderado'];
	$tipo_apoderado = $data['tipo_apoderado'];
	$alumno = $data['rut'];
	$direccion_apoderado = $data['direccion_apoderado'];
	$telefono_apoderado = $data['telefono_apoderado'];
	$movil_apoderado = $data['movil_apoderado'];
	$correo_apoderado = $data['correo_apoderado'];
	$tipo_apoderado = $data['tipo_apoderado'];

	$anio = $_SESSION["sige_anio_escolar_vigente"];
	
	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,
									concat(PaternoApoderado, ' ', MaternoApoderado, ' ', NombresApoderado) as nombre_apoderado,
									TiposApoderados.nombre as nombre, NombreCurso
							from Apoderados
								inner join Apoderados_tienen_Alumnos
									on Apoderados.NumeroRutApoderado = Apoderados_tienen_Alumnos.RutApoderado
								left join alumnos".$anio."
									on alumnos".$anio.".NumeroRutAlumno = Apoderados_tienen_Alumnos.RutAlumno
								inner join TiposApoderados
									on Apoderados.TipoApoderado = TiposApoderados.ta_ncorr
								left join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where Apoderados_tienen_Alumnos.RutAlumno = '".$alumno."'
							union
							select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,
									concat(PaternoApoderado, ' ', MaternoApoderado, ' ', NombresApoderado) as nombre_apoderado,
									'Apoderado Principal' as nombre, NombreCurso
							from Apoderados
								left join alumnos".$anio."
									on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado
								left join Cursos
									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
							where alumnos".$anio.".NumeroRutAlumno = '".$rut."'
							";
	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());
	
	if ($data['tipo_apoderado']=='0'){
		$objResponse->addScript("if (confirm('Desea modificar Apoderado Principal?')){
									xajax_GrabarApoderadoPrincipal(xajax.getFormValues('Form1'));	}");
		$objResponse->addScript("location.href='sg_alumnos_Apoderado.php?rut=".$alumno."'");
		return $objResponse->getXML();
		}

	$sql_ba = "select `RutApoderado`, `RutAlumno` 
				from `Apoderados_tienen_Alumnos`
				where RutApoderado = '".$apoderado."' and RutAlumno = '".$alumno."'";
	$res_ba = mysql_query($sql_ba,$conexion);
	if (mysql_num_rows($res_ba)==0){
		$sql_insert = "INSERT INTO `Apoderados_tienen_Alumnos`(`RutApoderado`, `RutAlumno`) 
					VALUES ('".$apoderado."','".$alumno."')";
		$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
		$objResponse->addAlert("Registro Guardado");
		}
	else{
		$sql_insert = "update `Apoderados_tienen_Alumnos` set
							RutApoderado = '".$apoderado."'
						where RutAlumno = '".$alumno."'";
		$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
		$objResponse->addAlert("Registro Actualizado");
		}
	$objResponse->addScript("location.href='sg_alumnos_Apoderado.php?rut=".$alumno."'");

	$sql_insert = "update `Apoderados` set
						DireccionParticularApoderado = '".$direccion_apoderado."',
						TelefonoParticularApoderado = '".$telefono_apoderado."',
						TelefonoMovilApoderado = '".$movil_apoderado."',
						EMailApoderado = '".$correo_apoderado."',
						TipoApoderado = '".$tipo_apoderado."'
					where NumeroRutApoderado = '".$apoderado."'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());


	return $objResponse->getXML();
	}

function EliminaApoderadoPrincipal($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	$alumno = $data['rut'];
	$anio = $_SESSION["sige_anio_escolar_vigente"];

		$sql_ba = "delete
					from `Apoderados_tienen_Alumnos`
					where RutApoderado in (select NumeroRutApoderado 
											from alumnos".$anio." 
											where NumeroRutAlumno = '".$alumno."') and 
							RutAlumno = '".$alumno."'";
		$res_ba = mysql_query($sql_ba,$conexion);

	return $objResponse->getXML();
	}

function EliminaApoderado($data, $ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	$alumno = $data['rut'];
	
	if ($ncorr =='9999999'){
		$objResponse->addScript("if (confirm('Desea eliminar Apoderado Principal?')){
									xajax_EliminaApoderadoPrincipal(xajax.getFormValues('Form1'));	}");
	}
	else{
		$sql_ba = "delete
					from `Apoderados_tienen_Alumnos`
					where ata_ncorr = '".$ncorr."'";
		$res_ba = mysql_query($sql_ba,$conexion);
	}
	
	$objResponse->addAlert("Registro Eliminado");
	$objResponse->addScript("location.href='sg_alumnos_Apoderado.php?rut=".$alumno."'");
	
	return $objResponse->getXML();
	}

function GrabarApoderadoPrincipal($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$apoderado = $data['OBLIApoderado'];
	$alumno = $data['rut'];
	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$update = "update alumnos".$anio." set
					NumeroRutApoderado = '".$apoderado."'
					where NumeroRutAlumno = '".$alumno."'";
	$res = mysql_query($update,$conexion) or die(mysql_error());

	$sql_insert = "update `Apoderados` set
						TipoApoderado = '0'
					where NumeroRutApoderado = '".$apoderado."'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
		
	$sql_insert = "update `Apoderados` set
						TipoApoderado = '3'
					where NumeroRutApoderado in (select RutApoderado 
													from Apoderados_tienen_Alumnos 
													where RutAlumno = '".$alumno."') and TipoApoderado = '0'";
	$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
		
	return $objResponse->getXML();
	}

$xajax->registerFunction("GrabarApoderadoPrincipal");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("ActualizarApoderado");
$xajax->registerFunction("TraerApoderado");
$xajax->registerFunction("EliminaApoderado");
$xajax->registerFunction("EliminaApoderadoPrincipal");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("ConfirmarNotas");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("ModificarNota");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaAsignaturas");
$xajax->registerFunction("CargaPruebas");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('rut', $_GET['rut']);
$miSmarty->assign('readonly', $_GET['readonly']);

$miSmarty->display('sg_alumnos_Apoderado.tpl');

ob_flush();
?>

