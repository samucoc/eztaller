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

$xajax->setRequestURI("sg_atrasos_ingresar.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


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
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]	."')");
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
			$objResponse->addAssign("$select","options[".$j."].value", $codigo);
			$objResponse->addAssign("$select","options[".$j."].text", $descripcion); 	
			
                while ($line = mysql_fetch_array($res)) {
			$j++;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			
		}
	}
	
	return $objResponse->getXML();
}



function CargaPeriodos($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("semestre","innerHTML",""); 		
	$anio = $_SESSION["sige_anio_escolar_vigente"];

	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$anio."'";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
            $objResponse->addCreate("semestre","option",""); 		
			$objResponse->addAssign("semestre","options[".$j."].value", '0');
			$objResponse->addAssign("semestre","options[".$j."].text", 'Elija'); 
			$j++;	
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("semestre","option",""); 		
			$objResponse->addAssign("semestre","options[".$j."].value", $line[0]);
			$objResponse->addAssign("semestre","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function CargaMeses($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("mes","innerHTML",""); 		
	
	$anio = $_SESSION["sige_anio_escolar_vigente"];


	$sql = "select InicioPeriodo as inicio, TerminoPeriodo as termino 
			from Periodos 
			where AnoAcademico = '".$anio."' and Semestre = '".$data['semestre']."' ";
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
        $j=0;
        while ($line = mysql_fetch_array($res)) {
			
			$fecha1		= 	$line[0];
			$fecha2		=	$line[1];
				
			$sql_meses = "SELECT TIMESTAMPDIFF(MONTH, '".$fecha1."', '".$fecha2	."') as meses";
			$res_meses = mysql_query($sql_meses,$conexion);
			$row_meses = mysql_fetch_array($res_meses);
			$dias_dif = $row_meses['meses']+1;
			list($anio_1,$mes_1,$dia_1) = explode('-',$fecha1);
			for($i=0;$i<=$dias_dif;$i++){
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$data['anio']));
				$objResponse->addCreate("mes","option",""); 		
				$objResponse->addAssign("mes","options[".$i."].value", $mes_pos);
				$mes_ele="";
					switch($mes_pos){
						case '1' : $mes_ele = "Enero";
									break;
						case '2' : $mes_ele = "Febrero";
									break;
						case '3' : $mes_ele = "Marzo";
									break;
						case '4' : $mes_ele = "Abril";
									break;
						case '5' : $mes_ele = "Mayo";
									break;
						case '6' : $mes_ele = "Junio";
									break;
						case '7' : $mes_ele = "Julio";
									break;
						case '8' : $mes_ele = "Agosto";
									break;
						case '9' : $mes_ele = "Septiembre";
									break;
						case '10' : $mes_ele = "Octubre";
									break;
						case '11' : $mes_ele = "Noviembre";
									break;
						case '12' : $mes_ele = "Diciembre";
									break;
						default : break;
						}

				$objResponse->addAssign("mes","options[".$i."].text", $mes_ele); 	
				
				}

			
		}
	}
	
	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$Curso 					= 	$data["curso"];
	$Semestre				=	$data['semestre'];
	$Mes					=	$data['mes'];
	$Anio					=	$data['anio'];
	$arrRegistros	= 	array();
	$arrRegistrosDetalle	= 	array();
	$arrDias	= 	array();
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
		$anio = $_SESSION["sige_anio_escolar_vigente"];


	// busca los registros
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,	
						NroLista, alumnos".$Anio.".NumeroRutAlumno
				from alumnos".$Anio."
					inner join Cursos
						on alumnos".$Anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Matriculas
						on alumnos".$Anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$Anio."'
								where
				Cursos.CodigoCurso = '".$Curso."' 
				order by NroLista";
	
	$res_ve = mysql_query($sql_ve, $conexion);

	$fecha1		= 	date("Y-m-d",mktime(0,0,0,$Mes,1,$Anio));
	$fecha2		=	date("Y-m-d",mktime(0,0,0,$Mes,date('t',mktime(0,0,0,$Mes,1,$Anio)),$Anio));
	
	$sql_fec 	= 	"SELECT DATEDIFF('".$fecha2."','".$fecha1."') as dias";
	$res_fec 	=	mysql_query($sql_fec,$conexion);
	$dias		=	@mysql_result($res_fec,0,"dias");
	
	$miSmarty->assign('cant_dias',$dias+1);
	for($z=1;$z<=$dias;$z++){
		array_push($arrDias, array("nro_dia" =>	$z)) ;
		}
	array_push($arrDias, array("nro_dia" =>	$dias+1)) ;
		
	if (mysql_num_rows($res_ve) > 0){
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {

			$fecha1		= 	date("Y-m-d",mktime(0,0,0,$Mes,1,$Anio));
			$fecha2		=	date("Y-m-d",mktime(0,0,0,$Mes,date('t',mktime(0,0,0,$Mes,1,$Anio)),$Anio));
			
			$sql_fec 	= 	"SELECT DATEDIFF('".$fecha2."','".$fecha1."') as dias";
			$res_fec 	=	mysql_query($sql_fec,$conexion);
			$dias		=	@mysql_result($res_fec,0,"dias");
			
			if ($dias >= 0){
				$i = 0;
				$j = 0;
				$k = 0;
				while ($i <= $dias) {
					
					$select_notas = "select NumeroRutAlumno
									from Atrasos
									where  NumeroRutAlumno = '".$line_ve[2]."' 
										and FechaAtraso = '".$fecha1."'";
					$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
					$atraso = "NO";
					while($row_notas = mysql_fetch_array($res_notas)){
						$atraso = 'SI';
						$j--;
						}
					
					$dia_semana		=	date("l",mktime(0,0,0,$Mes,$i,$Anio));
					$domingo="NO";
					if (($dia_semana=='Friday')||($dia_semana=='Saturday')){
						$domingo="SI";
						$j--;
						$k--;
						}
						
					$select_feriado = "select FechaFeriado 
										from Feriados
										where FechaFeriado = '".$fecha1."'";
					$res_feriado = mysql_query($select_feriado,$conexion) or die(mysql_error());
					$festivo = "NO";
					while($row_f = mysql_fetch_array($res_feriado)){
						$festivo = "SI";
						$j--;
						$k--;
						}
					
					array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[2], 
															"fecha"					=>	$fecha1,
															"atraso"				=>	$atraso,
															"domingo"				=>	$domingo,
															"festivo"				=>	$festivo
															));
					
					$sql_ife 	= 	"SELECT DATE_ADD('".$fecha1."', INTERVAL 1 DAY) as fecha1";
					$res_ife 	= 	mysql_query($sql_ife,$conexion);
					$fecha1		=	@mysql_result($res_ife,0,"fecha1");
					$i++;
					$j++;
					$k++;
					}
				}

			$sql_cant_atrasos =  "select count(NumeroRutAlumno) as contador
									from Atrasos
									where  NumeroRutAlumno = '".$line_ve[2]."' 
										and FechaAtraso between '".date("Y-m-d",mktime(0,0,0,$Mes,1,$Anio))."' and '".$fecha2."' ";
			$res_cant_atrasos = mysql_query($sql_cant_atrasos,$conexion) or die(mysql_error());
			$row_cant_atrasos = mysql_fetch_array($res_cant_atrasos);
			
			$contador = $row_cant_atrasos['contador'];
			array_push($arrRegistros, array("item"					=>	$i, 
											"nombre_alumno"			=> 	$line_ve[0], 
											"numero_lista"			=> 	$line_ve[1],
											"rut_alumno"			=> 	$line_ve[2],
											'contador'				=>	$contador
											));
			$i++;

			}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);
		$miSmarty->assign('arrDias', $arrDias);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_atrasos_ingresar_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros".$sql_ve );
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function ConfirmarAtraso($data,$rut_alumno,$fecha){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$sql = "insert into Atrasos(NumeroRutAlumno,FechaAtraso) values ('$rut_alumno','$fecha')";
	$res = mysql_query($sql,$conexion) or die(mysql_error());

	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");

	return $objResponse->getXML();
	}

function EliminarAtraso($data,$rut_alumno,$fecha){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$sql = "delete from Atrasos where NumeroRutAlumno = '$rut_alumno' and FechaAtraso = '$fecha'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());

	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");
	
	return $objResponse->getXML();
	}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("ConfirmarAtraso");
$xajax->registerFunction("EliminarAtraso");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaAsignaturas");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPeriodos");
$xajax->registerFunction("CargaMeses");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_atrasos_ingresar.tpl');

ob_flush();
?>

