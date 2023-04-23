<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones
include "../includes/php/class.phpmailer.php"; 
include "../includes/php/class.smtp.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_mant_tablas.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function date_interval($date1, $date2){
       $diff = abs(strtotime($date2) - strtotime($date1));

       $years = floor($diff / (365 * 60 * 60 * 24));
       $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
       $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

       return (($years > 0) ? $years . ' Año' . ($years > 1 ? '(s)' : '') . ', ' : '') . (($months > 0) ? $months . ' Mes' . ($months > 1 ? '(es)' : '') . ', ' : '') . (($days > 0) ? $days . ' Dia' . ($days > 1 ? '(s)' : '') : '');
	}

function Grabar($data){
	global $conexion;
	global $bd;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$tbl				=	$data["txtTabla"];
	$ncorr				=	$data["txtNcorr"];
	$ingresa 			= 'SI';

	if ($tbl == 'trabajadores_tienen_cargas'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores_tienen_cargas';
	}
	if ($tbl=='Postulantes'){
		$tbl = 'Postulantes';
		}
	// busca los campossd
	if ($ncorr == ''){

		$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."'  and COLUMN_COMMENT !='' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			$sql = "insert into $bd.$tbl (";
			while ($line = mysql_fetch_array($res_c)) {
				$campos .= $line[0].",";
				
				$objeto 		= 	"OBLI".$line[0];
				$valor_campo 	= 	($data[$objeto]);
				if ($line[0]=='HoraFin'){
					$valor_campo 	= 	date("H:i:s");
				}
				if ($valor_campo==''){
					$valor_campo 		= 	$data["NOTA".$line[0]];
					}
				if ($valor_campo==''){
					$valor_campo 		= 	$data["FCH".$line[0]];
					}
				if ($valor_campo==''){
					$valor_campo 		= 	$data["FT".$line[0]];
					list($f,$t) = explode(' ',$valor_campo);
					list($d,$m,$a) = explode('/',$f);$f = $a.'-'.$m.'-'.$d;
					$valor_campo = $f.' '.$t;
					}
				if ($valor_campo==''){
					$valor_campo 		= 	$data[$line[0]];
					}
						
				if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
                                    list($dia1,$mes1,$anio1) = 	explode('/', $valor_campo);
                                    $valor_campo 	= $anio1."-".$mes1."-".$dia1;
                                    //$valor_campo 	= $dia1."-".$mes1."-".$anio1; 
                                    }
				elseif ((strlen($valor_campo)==10)&&($valor_campo[7]=='-')){
					$arr_rut = explode('-',$valor_campo);
					$valor_campo = $arr_rut[0];
					}
				if ($tbl=='Postulantes'){
    				$values .= "'".strtoupper($valor_campo)."',";
	                }
                else{
					$values .= "'".($valor_campo)."',";
	                }

			}
			if ($tbl=='BitacorasAcademicas'){
				$campos .= 'usuario,';
				$values .= "'".$_SESSION["alycar_usuario"]."',";
			}

			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			$campos = $campos.")";
			
			$largo_values = strlen($values);
			$values = substr($values,0,$largo_values - 1);
			$values = $values.")";
			

			if ($tbl=='Entrevistas'){
				$OBLIGeneraCompromiso = $data['OBLIGeneraCompromiso'];
				if ($OBLIGeneraCompromiso=='0'){
					list($d,$m,$a) = explode('/',$data['FCHFechaEntrevista']);
					list($d1,$m1,$a1) = explode('/',$data['FCHFechaCompromiso']);
					$str_time_1 = strtotime($a.'-'.$m.'-'.$d);
					$str_time_2 = strtotime($a1.'-'.$m1.'-'.$d1);
					if($str_time_1<=$str_time_2){

					}
					else{
						$objResponse->addScript("alert('Fecha Compromiso debe ser mayor Fecha Entrevista')");
	 					$ingresa = 'NO';
					}
					$FCHFechaCompromiso = $data['FCHFechaCompromiso'];
					if ($FCHFechaCompromiso!='00/00/0000'){

					}
					else{
						$objResponse->addScript("alert('Elija una Fecha de Compromiso')");
	 					$ingresa = 'NO';
					}
					$OBLIEstadoCompromiso = $data['OBLIEstadoCompromiso'];
					if ($OBLIEstadoCompromiso!=''){}
					else{
						$objResponse->addScript("alert('Elija una Estado de Compromiso')");
		 				$ingresa = 'NO';
							
					}
				}
			}

			$sql .= $campos." values (".$values;
			if ($ingresa=='SI'){
				$res = mysql_query($sql,$conexion) or die(mysql_error($conexion));
				}
			if (mysql_errno($conexion)) { 
				$error = mysql_errno($conexion); 
				if ($error == '1062'){
					$objResponse->addScript("alert('Registro Duplicado.')");
					$ingresa = 'NO';
					}
 				}
			if ($tbl=='vehiculos'){
                            $sql_1 = "insert into personas_tienen_vehiculos(patente) values ('".$data['OBLIveh_patente']."')";
                            $res_1 = mysql_query($sql_1,$conexion);
                        }
		}
		
	}else{
		
		//busca el campo clave
		$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
		$res_cc = mysql_query($sql_cc,$conexion);
		$campo_clave = @mysql_result($res_cc,0,"campo_clave");
		
		$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			if (($data['OBLINumeroRutAlumno']=='')&&($tbl=='Postulantes')){
				$objResponse->addAlert("Error al ingresar Rut");
				}	
			else{
				$sql = "update $bd.$tbl set ";
				while ($line = mysql_fetch_array($res_c)) {
					if ($line[1] != ''){
						$objeto 		= 	"OBLI".$line[0];
						$valor_campo 	= 	($data[$objeto]);
						if ($valor_campo==''){
							$valor_campo 		= 	$data["NOTA".$line[0]];
							}
						if ($valor_campo==''){
							$valor_campo 		= 	$data["FCH".$line[0]];
							}
						if ($valor_campo==''){
							$valor_campo 		= 	$data["FT".$line[0]];
							list($f,$t) = explode(' ',$valor_campo);
							list($d,$m,$a) = explode('/',$f);$f = $a.'-'.$m.'-'.$d;
							$valor_campo = $f.' '.$t;
							}
						if ($valor_campo==''){
							$valor_campo 		= 	$data[$line[0]];
							}
						
						if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
							list($dia1,$mes1,$anio1) = explode('/', $valor_campo);
							$valor_campo 	= $anio1."-".$mes1."-".$dia1;
							}
						elseif ((strlen($valor_campo)==10)&&($valor_campo[7]=='-')){
							$arr_rut = explode('-',$valor_campo);
							$valor_campo = $arr_rut[0];
							}
						if ($tbl=='Postulantes'){
		                    $campos .= $line[0]." = '".strtoupper($valor_campo)."',";
		                    }
		                else{
		                    $campos .= $line[0]." = '".($valor_campo)."',";
			                }
			            if ($tbl=='BitacorasAcademicas'){
							$campos .= " usuario = '".$_SESSION["alycar_usuario"]."',";
						}    
					}
				}
				if ($tbl == 'trabajadores_tienen_cargas'){
					$rut_papa = $data['rut_papa'];
					$campos .= "rut_papa = '".$rut_papa."',";
					}
				if ($tbl=='Postulantes'){
					$objeto 		= 	"OBLIAutorizado";
					$valor_campo 	= 	($data[$objeto]);
					$campos .= " Autorizado = '".($valor_campo)."',";
					}
				
				$largo_campos = strlen($campos);
				$campos = substr($campos,0,$largo_campos - 1);
				$campos = $campos." where ".$campo_clave." = '".$ncorr."'";
				

				if ($tbl=='Entrevistas'){
					$OBLIGeneraCompromiso = $data['OBLIGeneraCompromiso'];
					if ($OBLIGeneraCompromiso=='0'){
						list($d,$m,$a) = explode('/',$data['FCHFechaEntrevista']);
						list($d1,$m1,$a1) = explode('/',$data['FCHFechaCompromiso']);
						$str_time_1 = strtotime($a.'-'.$m.'-'.$d);
						$str_time_2 = strtotime($a1.'-'.$m1.'-'.$d1);
						if($str_time_1<=$str_time_2){

						}
						else{
							$objResponse->addScript("alert('Fecha Compromiso debe ser mayor Fecha Entrevista')");
		 					$ingresa = 'NO';
						}
						$FCHFechaCompromiso = $data['FCHFechaCompromiso'];
						if ($FCHFechaCompromiso!='00/00/0000'){

						}
						else{
							$objResponse->addScript("alert('Elija una Fecha de Compromiso')");
		 					$ingresa = 'NO';
						}
						$OBLIEstadoCompromiso = $data['OBLIEstadoCompromiso'];
						if ($OBLIEstadoCompromiso!=''){}
						else{
							$objResponse->addScript("alert('Elija una Estado de Compromiso')");
			 				$ingresa = 'NO';
								
						}
					}
				}

			
				$sql .= $campos;
				if ($ingresa=='SI'){
					$res = mysql_query($sql,$conexion);
					}
				if (mysql_errno($conexion)) { 
					$error = mysql_errno($conexion); 
	 				if ($error == '1062'){
	 					$objResponse->addScript("alert('Registro Duplicado.')");
	 					$ingresa = 'NO';
	 					}
 					}
				}
			}
		}
	if ($tbl=='BitacorasAcademicas'){
		$objResponse->addScript("alert('Registro Grabado Correctamente.')");
		$objResponse->addScript("document.Form1.submit();");
	}
	elseif (($data['OBLINumeroRutAlumno']=='')&&($tbl=='Postulantes')){
				
		}	
	else{
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");

		if ($ingresa=='SI'){
			$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			if ($tbl=='HojasDeVida'){
				$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'OBLINumeroRutAlumno','HojasDeVida','1')");
				}
			else{
				$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
				}
			}
		}

	return $objResponse->getXML();
	}
	

function CargaListado($data,$select,$tabla,$flag=''){
    global $conexion;
    global $bd;
	global $miSmarty;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$tbl	=	$data["txtTabla"];
	$readonly	=	$data["readonly"];
	if ($tbl=='Postulantes'){
		$tbl = 'Postulantes';
		}
	// busca los campos de la tabla
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		while ($line = mysql_fetch_array($res_c)) {
			$campo_cont = $line[0];
			$campos .= $line[0].",";
			}
		$largo_campos = strlen($campos);
		$campos = substr($campos,0,$largo_campos - 1);
		$resultado_1 = $data['arr_select'];
		$arr_resultado = explode(',',$resultado_1);
		$resultado = "";
		$codigo="";
		if ($tbl =='Cursos'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoNivel'){
					$resultado .= " and CodigoNivel = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLICodigoNivel'){
				$resultado .= " and CodigoNivel = '".$data[$select]."' ";
				}
			}
		elseif ($tbl =='Profesores'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLIPaternoProfesor'){
					$resultado .= " and NumeroRutProfesor = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLIPaternoProfesor'){
				$resultado .= " and NumeroRutProfesor = '".$data[$select]."' ";
				}
			}
		elseif ($tbl =='Justificativos_Inasistencias'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLINumeroRutAlumno'){
					$resultado .= " and NumeroRutAlumno = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLINumeroRutAlumno'){
				$resultado .= " and NumeroRutAlumno = '".$data[$select]."' ";
				}
			}
		elseif ($tbl =='AlumnosCondicional'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLIperiodo'){
					$resultado .= " and Periodo = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLIperiodo'){
				$resultado .= " and Periodo = '".$data[$select]."' ";
				}
			}
		elseif ($tbl =='Postulantes'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLIPaternoAlumno'){
					$resultado .= " and PaternoAlumno = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLIPeriodoPostulacion'){
					$resultado .= "  and  PeriodoPostulacion = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLIAutorizado'){
					$resultado .= "  and  Autorizado = '".$data[$codigo]."' ";
					}
				
				}
			$codigo = $select;
			if($select == 'OBLIPaternoAlumno'){
				$resultado .= " and PaternoAlumno = '".$data[$select]."' ";
				}
			elseif($select == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
			elseif($select == 'OBLIPeriodoPostulacion'){
					$resultado .= "  and  PeriodoPostulacion = '".$data[$codigo]."' ";
					}
				
			elseif($select == 'OBLIAutorizado'){
					$resultado .= "  and  Autorizado = '".$data[$codigo]."' ";
					}
				
			}
		elseif ($tbl=='Asignaturas'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
				elseif ($codigo == 'OBLICodigoRamo'){
					$resultado .= "  and  CodigoRamo = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLIProfesor'){
					$resultado .= "  and  Profesor = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLICodigoCurso'){
				$resultado .= "  and  CodigoCurso = '".$data[$select]."' ";
				}
			elseif ($select == 'OBLICodigoRamo'){
				$resultado .= "  and  CodigoRamo = '".$data[$select]."' ";
				}
			elseif($select == 'OBLIProfesor'){
				$resultado .= "  and  Profesor = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='SituacionFinal'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
				elseif ($codigo == 'OBLIAnioAcademico'){
					$resultado .= "  and  AnioAcademico = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLICodigoCurso'){
				$resultado .= "  and  CodigoCurso = '".$data[$select]."' ";
				}
			elseif ($select == 'OBLIAnioAcademico'){
				$resultado .= "  and  AnioAcademico = '".$data[$select]."' ";
				}
			}
	    elseif (($tbl=='alumnos')||($tbl=='Postulantes')){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLIPaternoAlumno'){
					$resultado .= "  and  PaternoAlumno = '".$data[$codigo]."' ";
					}
				} 
			$codigo = $select;
			if($select == 'OBLICodigoCurso'){
				$resultado .= " and CodigoCurso = '".$data[$select]."' ";
				}
			elseif($select == 'OBLIPaternoAlumno'){
				$resultado .= " and PaternoAlumno = '".$data[$select]."' ";
				$objResponse->addAssign('rut_papa','value','');
				}
			if($tbl=='alumnos'){
				if ($data['rut_papa']!=''){
					if($select == 'OBLIPaternoAlumno'){
						}
					else{
						$resultado .= " and NumeroRutAlumno = '".$data['rut_papa']."' "; 
						}
					}
				$resultado .= " order by NumeroLista asc "; 
				}
			}
	    elseif ($tbl=='Pruebas'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' and  Semestre = '".$data['OBLISemestre']."' ";
					}
				elseif ($codigo == 'OBLICodigoRamo'){
					$resultado .= "  and  CodigoRamo = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLINumeroRutProfesor'){
					$resultado .= "  and  NumeroRutProfesor = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLICodigoCurso'){
				$resultado .= "  and  CodigoCurso = '".$data[$select]."' and  Semestre = '".$data['OBLISemestre']."' ";
				}
			elseif ($select == 'OBLICodigoRamo'){
				$resultado .= "  and  CodigoRamo = '".$data[$select]."' ";
				}
			elseif($select == 'OBLINumeroRutProfesor'){
				$resultado .= "  and  NumeroRutProfesor = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='usuarios_perfiles_menu'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLItper_ncorr'){
					$resultado .= "  and  tper_ncorr = '".$data[$codigo]."' ";
					}
				elseif ($codigo == 'OBLImenu_ncorr'){
					$resultado .= "  and  menu_ncorr = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLImhij_ncorr'){
					$resultado .= "  and  mhij_ncorr = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLItper_ncorr'){
				$resultado .= "  and  tper_ncorr = '".$data[$select]."' ";
				}
			elseif ($select == 'OBLImenu_ncorr'){
				$resultado .= "  and  menu_ncorr = '".$data[$select]."' ";
				}
			elseif($select == 'OBLImhij_ncorr'){
				$resultado .= "  and  mhij_ncorr = '".$data[$select]."' ";
				}
			}
		elseif (($tbl=='HojasDeVida')||($tbl=='Entrevistas')){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLINumeroRutAlumno'){
					$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
					}
				elseif($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
				elseif ($codigo == 'OBLICodigoRamo'){
					$resultado .= "  and  CodigoRamo = '".$data[$codigo]."' ";
					}
				
				}
			$codigo = $select;
			if($select == 'OBLINumeroRutAlumno'){
				$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
				}
			elseif($select == 'OBLICodigoCurso'){
				$resultado .= "  and  CodigoCurso = '".$data[$select]."' ";
				}
			elseif ($select == 'OBLICodigoRamo'){
				$resultado .= "  and  CodigoRamo = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='HojasDeVidaProfesores'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLINumeroRutProfesor'){
					$resultado .= "  and  NumeroRutProfesor = '".$data[$select]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLINumeroRutProfesor'){
				$resultado .= "  and  NumeroRutProfesor = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='Matriculas'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLINumeroRutAlumno'){
					$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
					}
				elseif ($codigo == 'matri_retri'){
					$matri = $data['matri_retri'];
					if ($matri =='1'){
						$resultado .= "  and  FechaRetiro = '0000-00-00' ";
						}
					elseif ($matri =='2'){
						$resultado .= "  and  FechaRetiro <> '0000-00-00' ";
						}
					}
				}
			$codigo = $select;
			if($select == 'OBLINumeroRutAlumno'){
				$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
				}
			elseif ($select == 'matri_retri'){
					$matri = $data['matri_retri'];
					if ($matri =='1'){
						$resultado .= "  and  FechaRetiro = '0000-00-00' ";
						}
					elseif ($matri =='2'){
						$resultado .= "  and  FechaRetiro <> '0000-00-00' ";
						}
					}
			}
		elseif ($tbl=='AgendaMatricula'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'FCHfechaAgenda'){
					list($d,$m,$a) = explode('/',$data[$select]);
					$resultado .= "  and  fechaAgenda = '".$a."-".$m."-".$d."' ";
					}
				}
			$codigo = $select;
			if($select == 'FCHfechaAgenda'){
					list($d,$m,$a) = explode('/',$data[$select]);
					$resultado .= "  and  fechaAgenda = '".$a."-".$m."-".$d."' ";
					}
			}
		elseif ($tbl=='menues_hijos'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLImenu_ncorr'){
					$resultado .= "  and  menu_ncorr = '".$data[$select]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLImenu_ncorr'){
				$resultado .= "  and  menu_ncorr = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='Retiros'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLINumeroRutAlumno'){
					$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLINumeroRutAlumno'){
				$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
				}
			}
		$where = '';
		if ($flag=='1'){
			$resultado = ' and NumeroRutAlumno = "'.$data['OBLINumeroRutAlumno'].'" and CodigoCurso = "'.$data['OBLICodigoCurso'].'" ';
			$objResponse->addScript("document.getElementById('OBLICodigoRamo').value=''");
			$objResponse->addScript("document.getElementById('OBLITipoHojaVida').value=''");
			$objResponse->addScript("document.getElementById('OBLICodigoMotivo').value=''");
			$objResponse->addScript("document.getElementById('FCHFechaHojaVida').value=''");
			$objResponse->addScript("document.getElementById('OBLIDescripcionHojaVida').value=''");
			}
		else{
			$where = $data['arr_select'];
		}
		$where = str_replace('$select','',$where);
		$where = $where.','.$codigo;
		$objResponse->addAssign('arr_select','value',$where);

		if ($tbl=='Matriculas'){
				$and_001 = " and Anio = '".$_SESSION['sige_anio_escolar_vigente']."' ";
				$and_002 = "    group by CodigoCurso, Anio, NumeroRutAlumno, Fecha, FechaRetiro 
								order by Anio asc, CodigoCurso asc, NroMatricula, FechaRetiro desc, Fecha desc ";
			}
		$sql = "select $campos from $bd.$tbl where 1 $resultado $and_001 $and_002";
		if (($tbl=='Postulantes')){
			$sql .= " order by concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) asc"; 
			}
		if (($tbl=='Asignaturas')){
			$sql .= " order by CodigoCurso, NumeroOrden asc"; 
			}
		if (($tbl=='Entrevistas')){
			$sql .= " and NumeroRutAlumno = '".$data['rut_papa']."' "; 
			}
		if (($tbl=='Periodos')){
			$sql .= " order by AnoAcademico, Semestre"; 
			}
		if (($tbl=='usuarios_perfiles_menu')){
			$sql .= " order by menu_ncorr, upme_orden"; 
			}
		if (($tbl=='AgendaMatricula')){
			$sql .= " order by fechaAgenda, horaAgenda"; 
			}
		if (($tbl=='MotivoAnotaciones')){
			$sql .= " order by TipoMotivo, DescripcionMotivo"; 
			}
		if (($tbl=='Feriados')){
			$sql .= " order by FechaFeriado desc "; 
			}
		if (($tbl=='HojasDeVida')){
			$sql .= " and Year(FechaHojaVida) = '".$_SESSION['sige_anio_escolar_vigente']."'  order by FechaHojaVida"; 
			}
		if (($tbl=='SituacionFinal')){
			$sql .= " and AnoAcademico = '".$_SESSION['sige_anio_escolar_vigente']."' 
						order by (
								   SELECT concat(PaternoAlumno,' ',MaternoAlumno,' ',NombresAlumno)
								   FROM alumnos".$_SESSION['sige_anio_escolar_vigente']."
								   WHERE SituacionFinal.NumeroRutAlumno = alumnos".$_SESSION['sige_anio_escolar_vigente'].".NumeroRutAlumno
								)
						"; 
			}
		if (($tbl=='Pruebas')){
			$sql .= " and AnoAcademico = '".$_SESSION['sige_anio_escolar_vigente']."' 
					order by NumeroNota asc"; 
			}
		if ($tbl=='declaracion_accidente'){
			$sql .= " order by da_ncorr desc"; 
			}
		if ($tbl=='Conceptos'){
			$sql .= " order by OrdenConcepto asc"; 
			}

		if ($tbl=='Evaluaciones'){
			$sql .= " order by OrdenEvaluacion asc"; 
			}

		if ($tbl=='HojasDeVidaProfesores'){
			if ($data['rut_papa']!=''){
				$sql .= " 	and Year(FechaHojaVida) = '".$_SESSION['sige_anio_escolar_vigente']."'  
							and NumeroRutProfesor = '".$data['rut_papa']."'  
						order by FechaHojaVida"; 
				}
			else{
				$sql .= " 	and Year(FechaHojaVida) = '".$_SESSION['sige_anio_escolar_vigente']."'  
						order by FechaHojaVida"; 
				}
			}
		if ($tbl=='CertificacionesProfesores' ){
			if ($data['rut_papa']!=''){
				$sql .= " 	and NumeroRutProfesor = '".$data['rut_papa']."'  
						"; 
				}
			}
		if ($tbl=='ArchivoPersonalAlumnos' ){
			if ($data['rut_papa']!=''){
				$sql .= " 	and NumeroRutAlumno = '".$data['rut_papa']."'  
						"; 
				}
			}
		if ($tbl=='CargasFamiliaresProfesores'){
			if ($data['rut_papa']!=''){
				$sql .= " 	and NumeroRutProfesor = '".$data['rut_papa']."'  
						"; 
				}
			}
		if ($tbl=='BitacorasAcademicas'){
			$sql .= " and NumeroRutAlumno = '".$data['rut_papa']."' order by FechaBitacora desc"; 
			}
		if (($tbl=='Profesores')&&($data['rut_papa']!='')){
			$sql .= " and NumeroRutProfesor = '".$data['rut_papa']."'"; 
			}
		
		$sql_1 = "select count('".$campo_cont."') as contador from $bd.$tbl where 1 $resultado $and_001";
		if ($tbl=='HojasDeVidaProfesores'){
			if ($data['rut_papa']!=''){
				$sql_1 .= " 	and Year(FechaHojaVida) = '".$_SESSION['sige_anio_escolar_vigente']."'  
							and NumeroRutProfesor = '".$data['rut_papa']."'  
						order by FechaHojaVida"; 
				}
			else{
				$sql_1 .= " 	and Year(FechaHojaVida) = '".$_SESSION['sige_anio_escolar_vigente']."'  
						order by FechaHojaVida"; 
				}
			}
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$i = 0;
		if ($tbl=='SituacionFinal'){
			$sql_qq = "SELECT count(Situacion) as plop, Situacion 
						FROM `SituacionFinal` 
						where 1 $resultado and AnoAcademico = '".$_SESSION['sige_anio_escolar_vigente']."'  
						group by `Situacion`, AnoAcademico, CodigoCurso";
			$res_qq = mysql_query($sql_qq,$conexion);
			while($row_qq = mysql_fetch_array($res_qq)){
				if ($row_qq['Situacion']=='0'){
					$miSmarty->assign('reprobados',$row_qq['plop']);
					}
				if ($row_qq['Situacion']=='1'){
					$miSmarty->assign('aprobados',$row_qq['plop']);
					}
				if ($row_qq['Situacion']=='2'){
					$miSmarty->assign('retirados',$row_qq['plop']);
					}
				$i += $row_qq['plop'];
				}
			}
		$i>0 ? $miSmarty->assign('cant_filas',$i) : $miSmarty->assign('cant_filas',$row_1['contador']);
			if ((($tbl!='Pruebas')&&($tbl!='alumnos')&&($tbl!='HojasDeVida'))){ 
				$res = mysql_query($sql, $conexion) or die(mysql_error());

				if (mysql_num_rows($res) > 0){
					$i=1;
					$arrRegistros = array();
					while ($line = mysql_fetch_row($res)) {
						
						if ($tbl == "alumnos"){  
							$sql_ff = "select NombreCurso
									   from Cursos
									   where CodigoCurso = ".$line[10];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"nombres"     		=> 	$line[4].' '.$line[5].', '.$line[6], 
															"curso"		      	=> 	$row_ff['NombreCurso'],
															"rut"			=>	$line[34]));
						}elseif ($tbl=='Postulantes'){  
							$sql_ff = "select NombreCurso
									   from Cursos
									   where CodigoCurso = ".$line[12];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							$sql_gg = "select nombre
									   from AutorizadoPostulantes
									   where ap_ncorr = ".$line[2];
							$res_gg = mysql_query($sql_gg, $conexion);
							$row_gg = mysql_fetch_array($res_gg);
							array_push($arrRegistros, array("ncorr"        			=> 	$line[1],
															//"rut"        			=> 	$line[2].'-'.dv($line[2]),
															"rut"        			=> 	$line[3],
															"nombres"     			=> 	strtoupper($line[5].' '.$line[6].', '.$line[7]), 
															"certificadoEstudio"  	=> 	$line[17], 
															"certificadoNacimiento"	=> 	$line[14], 
															"nombres"     			=> 	strtoupper($line[5].' '.$line[6].', '.$line[7]), 
															"curso"		      		=> 	$row_ff['NombreCurso'], 
															"periodo"		      	=> 	$line[0], 
															"autorizado"		    => 	$row_gg['nombre']));
						}elseif ($tbl == "Profesores"){  
							$fecha = $line[20];
							list($a,$m,$d) = explode('-', $fecha);

							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"rut"        		=> 	$line[1].'-'.dv($line[1]),
															"nombre"     		=> 	$line[6], 
															"apellido_paterno"  => 	$line[4], 
															"apellido_materno"  => 	$line[5], 
															"direccion"      	=> 	$line[8], 
															"fecha_nac"      	=> 	$line[13], 
															"telefono"      	=> 	$line[16], 
															"vigencia_cert_antecedentes"      	=> 	$d.'/'.$m.'/'.$a));
						}elseif ($tbl == "Apoderados"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"rut"        		=> 	$line[1].'-'.dv($line[1]),
															"nombre"     		=> 	$line[3], 
															"apellido_paterno"  => 	$line[4], 
															"apellido_materno"  => 	$line[5], 
															"direccion"      	=> 	$line[6], 
															"telefono"      	=> 	$line[7]));
						}elseif ($tbl == "ReunionesApoderados"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"periodo"        	=> 	$line[1],
															"fecha"        		=> 	$line[2],
															"descripcion"     	=> 	$line[3], 
															"observacion" 		=> 	$line[4]));
						}elseif ($tbl == "Niveles"){  
							array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
															"nombre_nivel"      		=> 	$line[1],
															"resolucion_autoriza"		=> 	$line[2], 
															"FechaResolucionAutoriza"  	=> 	$line[3], 
															"ResolucionCierre"  		=> 	$line[4], 
															"FechaResolucionCierre"     => 	$line[5]));
						}elseif ($tbl == "SituacionFinal"){  
							$sql_ff = "select NombreCurso
									   from Cursos
									   where CodigoCurso = ".$line[2];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							
							$curso  = $row_ff['NombreCurso'];
	
							$anio = $_SESSION["sige_anio_escolar_vigente"];
    
							$sql_ff_1 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
									   from alumnos".$anio."
									   where NumeroRutAlumno = ".$line[3];
							$res_ff_1 = mysql_query($sql_ff_1, $conexion) or die(mysql_error());
							$row_ff_1 = mysql_fetch_array($res_ff_1);
							
							$alumno = $row_ff_1['pool'];

							$sql_ff = "select nombre
									   from TiposSituaciones
									   where ts_ncorr = ".$line[4];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							
							$situacion  = $row_ff['nombre'];

							if ($situacion == 'Retirado'){
								$line[7] = $line[6] = '';
								}
							array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
															"anio"			      		=> 	$line[1],
															"curso"						=> 	$curso, 
															"alumno"				  	=> 	$alumno, 
															"situacion"			  		=> 	$situacion, 
															"asistencia"			  	=> 	$line[7].' %', 
															"promedio"			  		=> 	$line[6], 
															"observaciones"		  		=> 	$line[5]));
						
						}elseif ($tbl == "BitacorasAcademicas"){  
							$anio = $_SESSION["sige_anio_escolar_vigente"];
    
							$sql_ff_1 = "select concat(PaternoProfesor,' ',MaternoProfesor,', ',NombresProfesor) as pool
									   from Profesores
									   where NumeroRutProfesor = ".$line[4];
							$res_ff_1 = mysql_query($sql_ff_1, $conexion) or die(mysql_error());
							$row_ff_1 = mysql_fetch_array($res_ff_1);
							
							$alumno = $row_ff_1['pool'];

							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"alumno"			    => 	$alumno,
															"fecha"					=> 	$line[6], 
															"descripcion"			=> 	$line[13], 
															"usuario"				=> 	$line[17]));
						}elseif ($tbl == "correos"){  
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"fecha"      			=> 	$line[1],
															"destinatarios"      	=> 	substr($line[2],0,50),
															"asunto"		=> 	$line[3]
															));
						}elseif ($tbl == "Feriados"){  
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"fecha"      			=> 	$line[1],
															"descripcion"      	=> 	$line[2]
															));
						}elseif ($tbl == "PlazoPruebas"){  
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"descripcion"      		=> 	$line[1],
															"dias_plazo"			=> 	$line[2]
															));
						}elseif ($tbl == "correos_apoderados"){  
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"fecha"      			=> 	$line[1],
															"destinatarios"      	=> 	substr($line[2],0,50),
															"asunto"		=> 	$line[3]
															));
						}elseif ($tbl == "AlumnosCondicional"){  
							$anio_ant = $line[1]-1;
    						$anio = $line[1];
    
							$sql_ff = "select NombreCondicional
									   from MotivosCondicionales
									   where CodigoCondicional = ".$line[3];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							
							$sql_ff_1 = "select concat(NombresAlumno,' ',PaternoAlumno,' ',MaternoAlumno) as pool,
												NombreCurso
									   from alumnos".$anio_ant."
									   		inner join Cursos
								   				on Cursos.CodigoCurso = alumnos".$anio_ant.".CodigoCurso
									   where NumeroRutAlumno = ".$line[2];
							$res_ff_1 = mysql_query($sql_ff_1, $conexion);
							$row_ff_1 = mysql_fetch_array($res_ff_1);
								array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
																"alumno"      			=> 	$row_ff_1['pool'],
																"anio"      			=> 	$anio,
																"curso"      			=> 	$row_ff_1['NombreCurso'],
																"tipo"      			=> 	$row_ff['NombreCondicional'],
																"motivo"				=> 	$line[4]
																));
							
						}elseif ($tbl == "AgendaMatricula"){  
							$anio = $_SESSION["sige_anio_escolar_vigente"];
    
							$sql_ff_1 = "select concat(PaternoAlumno,' ',MaternoAlumno,' ',NombresAlumno) as pool,
												NombreCurso,
												concat(PaternoApoderado,' ',MaternoApoderado,' ',NombresApoderado) as apoderado
									   from alumnos".$anio."
									   		inner join Cursos
								   				on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
									   		inner join Apoderados
								   				on Apoderados.NumeroRutApoderado = alumnos".$anio.".NumeroRutApoderado
									   where NumeroRutAlumno = ".$line[4];
							$res_ff_1 = mysql_query($sql_ff_1, $conexion);
							if (mysql_num_rows($res_ff_1)==0){
								$anio--;
								$sql_ff_1 = "select concat(PaternoAlumno,' ',MaternoAlumno,' ',NombresAlumno) as pool,
												NombreCurso,
												concat(PaternoApoderado,' ',MaternoApoderado,' ',NombresApoderado) as apoderado
									   from alumnos".$anio."
									   		inner join Cursos
								   				on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
									   		left join Apoderados
								   				on Apoderados.NumeroRutApoderado = alumnos".$anio.".NumeroRutApoderado
									   where NumeroRutAlumno = ".$line[4];
								$res_ff_1 = mysql_query($sql_ff_1, $conexion);
								}
							$row_ff_1 = mysql_fetch_array($res_ff_1);
								

								array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
																"alumno"      			=> 	$row_ff_1['pool'],
																"NombreCurso"  			=> 	$row_ff_1['NombreCurso'],
																"apoderado"      		=> 	$row_ff_1['apoderado'],
																"periodo"      			=> 	$line[1],
																"fechaagenda"      		=> 	$line[2],
																"horaagenda"      		=> 	$line[3],
																"observacion"			=> 	$line[5]
																));
								$miSmarty->assign('anio',$anio);
						}elseif ($tbl == "declaracion_accidente"){  
							$anio = $_SESSION["sige_anio_escolar_vigente"];
    
							$sql_ff = "select nombre
									   from tipos_accidentes
									   where ta_ncorr = ".$line[3];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							
							$sql_ff_1 = "select concat(NombresAlumno,' ',PaternoAlumno,' ',MaternoAlumno) as pool,
												NombreCurso
									   from alumnos".$anio."
									   		inner join Cursos
								   				on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
									   where NumeroRutAlumno = ".$line[1];
							$res_ff_1 = mysql_query($sql_ff_1, $conexion);
							$row_ff_1 = mysql_fetch_array($res_ff_1);
							
							
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"alumno"      			=> 	$row_ff_1['pool'],
															"hora"      			=> 	$line[2],
															"observacion"      		=> 	substr($line[8],0,25),
															"testigo1"     			=> 	$line[5],
															"testigo2"     			=> 	$line[7],
															"tipo"      			=> 	$row_ff['nombre']
															));
							
						}elseif ($tbl == "Periodos"){  
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"AnoAcademico"     	=> 	$line[1],
															"Semestre"     		=> 	$line[2],
															"NombrePeriodo"     => 	$line[5],
															"NombreDirector"   	=> 	$line[12].' '.$line[10].' '.$line[11],
															"InicioPeriodo"     => 	$line[6],
															"TerminoPeriodo"    => 	$line[7],
															"DiasPeriodo"     	=> 	$line[3],
															"DiasPeriodo4Medio"	=> 	$line[4]	
															));
						}elseif ($tbl == "Asignaturas"){  
							$sql_ff = "select NombreCurso
									   from Cursos
									   where CodigoCurso = ".$line[1];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
		
							$sql_001 = "select Descripcion 
										from Ramos 
										where CodigoRamo = '".$line[2]."'";
							$res_001 = mysql_query($sql_001, $conexion);
							$row_001 = mysql_fetch_array($res_001);
		
							$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
										from Profesores 
										where NumeroRutProfesor  = '".$line[3]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
					
							array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
															"curso"        				=> 	$row_ff['NombreCurso'],
															"numero_orden"				=> 	$line[4],
															"asignatura"      			=> 	$row_001['Descripcion'],
															"profesor"					=> 	$row_002['pool'],
															"calcula_promedio"			=> 	$line[10],
															"bonifica"					=> 	$line[12],
															"criterio"					=> 	$line[13],
															"bonificacion"				=> 	$line[14],
															"RECH"						=> 	$line[11]));
						}elseif ($tbl == "Pruebas"){  
							$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[3];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[4]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);
			
								$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[5]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
			
								$sql_003 = "select NumeroNota 
											from gescolcl_arcoiris_administracion.NotasAlumnos
											where AnoAcademico = (select AnoAcademico from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and Semestre = (select Semestre from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and CodigoCurso = (select CodigoCurso from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and CodigoRamo = (select CodigoRamo from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and NumeroNota = (select NumeroNota from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')";
								$res_003 = mysql_query($sql_003, $conexion);
								if (mysql_num_rows($res_003)>0){
									$notas_pruebas = '1';
									}
								else{
									$notas_pruebas = '0';
									}
			
								array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
																"anio"        				=> 	$line[1],
																"semestre"        			=> 	$line[2],
																"curso"        				=> 	$row_ff['NombreCurso'],
																"asignatura"      			=> 	$row_001['Descripcion'],
																"profesor"					=> 	$row_002['pool'],
																"numero_prueba"				=> 	$line[6],
																"fecha_prueba"				=> 	$line[7],
																"notas_pruebas"				=> 	$notas_pruebas,
																"descripcion_prueba"		=> 	$line[10]));
						}elseif ($tbl == "usuarios"){                                             
							$sql_ff = "select perfil_nombre
															from perfiles
															where perfil_codigo = ".$line[4];
												$res_ff = mysql_query($sql_ff, $conexion);
												$row_ff = mysql_fetch_array($res_ff);
												array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																				"usuario"       => 	$line[1], 
																				"password"	=> 	$line[2], 
																				"nombre"	=> 	$line[3], 
																				"perfil"	=> 	$row_ff['perfil_nombre']));
						}elseif ($tbl == "Horas"){                                             
							$sql_ff = "select DescripcionTipoHorario
										from TiposHorario
										where CodigoTipoHorario = ".$line[1];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"tipo_horario"  => 	$row_ff['DescripcionTipoHorario'], 
															"codigo_hora"	=> 	$line[2], 
															"descripcion"	=> 	$line[3]));
						}elseif ($tbl == "Entrevistas"){                                             
							//nombre alñumno, fecha, tipo entrevista, tipo compromiso, cumple compromiso
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']."
											where NumeroRutAlumno  = '".$line[1]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);

							$sql_ff = "select nombre
										   from TiposEntrevista
										   where te_ncorr = ".$line[3];
							$res_ff = mysql_query($sql_ff, $conexion) or die(mysql_error());
							$row_ff = mysql_fetch_array($res_ff);

							$sql_ee = "select nombre
										   from sino
										   where sino_ncorr = ".$line[5];
							$res_ee = mysql_query($sql_ee, $conexion);
							$row_ee = mysql_fetch_array($res_ee);

							array_push($arrRegistros, array("ncorr"        		=>  $line[0], 
															"alumno"        	=>  $row_002['pool'], 
															"fecha"         	=>  $line[2], 
															"tipo_entrevista"   =>  $row_ff['nombre'], 
															"tipo_compromiso"  	=>  $row_ee['nombre'], 
															"estado_compromiso" =>  $line[10], 
															"EvidenciaCaso" 	=>  $line[7], 
															"Descripcion" 		=>  $line[6]
															));
						}elseif ($tbl == "Retiros"){                                             
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool,
												NombreCurso
										from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
											inner join Cursos
												on Cursos.CodigoCurso = alumnos".$_SESSION['sige_anio_escolar_vigente'].".CodigoCurso
										where NumeroRutAlumno  = '".$line[1]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
							
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"alumno"		=> 	$row_002['pool'], 
															"curso"			=> 	$row_002['NombreCurso'], 
															"observacion"	=> 	$line[4]));
						}elseif ($tbl == "Eximisiones"){                                             
								$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']."
											where NumeroRutAlumno  = '".$line[5]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[3];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[4]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"anio"			=> 	$line[1], 
																"curso"			=> 	$row_ff['NombreCurso'], 
																"asignatura"	=> 	$row_001['Descripcion'], 
																"alumno"		=> 	$row_002['pool'], 
																"fecha"			=> 	$line[7], 
																"numero"		=> 	$line[6], 
																"observacion"	=> 	$line[8]));
						}elseif ($tbl == "Justificativos_Inasistencias"){                                             
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool,
												Cursos.NombreCurso
										from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
											inner join Cursos
												on Cursos.CodigoCurso = alumnos".$_SESSION['sige_anio_escolar_vigente'].".CodigoCurso
										where NumeroRutAlumno  = '".$line[1]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
							$date1 = new DateTime($line[2]);
							$date2 = new DateTime($line[3]);
							$diff = $date1->diff($date2);
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"alumno"		=> 	$row_002['pool'], 
															"fecha_desde"	=> 	$line[2], 
															"fecha_hasta"	=> 	$line[3], 
															"diferencia"	=> 	($diff->days)+1, 
															"tipo"			=> 	$line[4], 
															"observacion"	=> 	$line[5], 
															"curso"			=> 	$row_002['NombreCurso']));
						}elseif ($tbl == "MotivoAnotaciones"){                                             
								$sql_002 = "select nombre
											from TipoHojaVida 
											where thv_ncorr  = '".$line[2]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"descripcion"	=> 	$line[1], 
																"motivo"			=> 	$row_002['nombre']));
						}elseif ($tbl == "HojasDeVida"){                                             
							$sql_002 = "select nombre
											from TipoHojaVida 
											where thv_ncorr  = '".$line[4]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_003 = "select DescripcionMotivo
											from MotivoAnotaciones 
											where CodigoMotivo  = '".$line[5]."'";
								$res_003 = mysql_query($sql_003, $conexion);
								$row_003 = mysql_fetch_array($res_003);
								

								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[1];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[3]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"fecha"			=> 	$line[7], 
																"curso"			=> 	$row_ff['NombreCurso'], 
																"ramo"			=> 	$row_001['Descripcion'], 
																"tipo"			=> 	$row_002['nombre'], 
																"motivo"		=> 	$row_003['DescripcionMotivo'], 
																"usuario"		=> 	$line[10], 
																"observacion"	=> 	$line[8]));
						}elseif ($tbl == "CertificacionesProfesores"){                                             
								$sql_004 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"fecha"			=> 	$line[2], 
																"observacion"	=> 	$line[3], 
																"foto"			=> 	$line[4]));
						}elseif ($tbl == "ArchivoPersonalAlumnos"){                                             
								$sql_004 = "select concat(NombresAlumno,' ',PaternoAlumno,' ',MaternoAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
											where NumeroRutAlumno  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"fecha"			=> 	$line[2], 
																"observacion"	=> 	$line[3], 
																"foto"			=> 	$line[4]));
						}elseif ($tbl == "CargasFamiliaresProfesores"){                                             
								$sql_004 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			
								$fecha_nacimiento = new DateTime($line[7]);
								$hoy = new DateTime();
								$edad = $hoy->diff($fecha_nacimiento);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"rut"			=> 	$line[2].'-'.dv($line[2]), 
																"nombres"		=> 	$line[4].' '.$line[5].', '.$line[6], 
																"fecha"			=> 	$line[7], 
																"edad"			=> 	$edad->y));
						}elseif ($tbl == "HojasDeVidaProfesores"){                                             
								$sql_002 = "select nombre
											from TipoHojaVida 
											where thv_ncorr  = '".$line[2]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_003 = "select DescripcionMotivo
											from MotivoAnotacionesProfesores 
											where CodigoMotivo  = '".$line[3]."'";
								$res_003 = mysql_query($sql_003, $conexion);
								$row_003 = mysql_fetch_array($res_003);
								
								$sql_004 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"fecha"			=> 	$line[4], 
																"tipo"			=> 	$row_002['nombre'], 
																"motivo"		=> 	$row_003['DescripcionMotivo'], 
																"observacion"	=> 	$line[5]));
						}elseif ($tbl == "Cursos"){  
								$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
										from Profesores 
										where NumeroRutProfesor  = '".$line[4]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
					

								array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
																"codigo"        	=> 	$line[0],
																"nombre"     		=> 	$line[1], 
																"descripcion"  		=> 	$line[3], 
																"profesor_jefe"		=> 	$row_002['pool']));
						}elseif ($tbl == "Matriculas"){                                             
								$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']."
												
											where NumeroRutAlumno  = '".$line[1]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								if (strlen($line[5])<3) $line[5] = '0'.$line[5];

								$sql_003 = "select NombreCurso from gescolcl_arcoiris_administracion.Cursos where CodigoCurso = '".$line[5]."'";
								$res_003 = mysql_query($sql_003, $conexion);
								$row_003 = mysql_fetch_array($res_003);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"rut" 			=>  $line[1].'-'.dv($line[1]), 
																"nro_matricula" =>  $line[6], 
																"codigo_curso" 	=>  $line[5].$line[0], 
																"curso" 		=>  $row_003['NombreCurso'], 
																"nro_lista" 	=>  $line[7], 
																"alumno"		=> 	$row_002['pool'], 
																"fecha"			=> 	$line[3], 
																"fecha_retiro"	=> 	$line[4], 
																"observacion"	=> 	$line[8]));
						}elseif ($tbl == "perfiles"){                                             
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																				"codigo"       => 	$line[1], 
																				"nombre"	=> 	$line[2], 
																				"descripcion"	=> 	$line[3]));
						}elseif ($tbl == "Conceptos"){                                             
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"codigo"       => 	$line[1], 
															"descripcion"       => 	$line[2], 
															"descripcion_larga"	=> 	$line[3], 
															"orden"				=> 	$line[4]));
						}elseif ($tbl == "Evaluaciones"){                                             
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"codigo"       => 	$line[1], 
															"descripcion"       => 	$line[2], 
															"descripcion_larga"	=> 	$line[3], 
															"orden"				=> 	$line[4]));

						}elseif ($tbl == "Desarrollos"){                                             
							$sql_1 = "SELECT `DescripcionCortaEvaluacion` FROM `Evaluaciones` WHERE `CodigoEvaluacion` = '".$line[1]."'";
							$res_1 = mysql_query($sql_1,$conexion);
							$row_1 = mysql_fetch_array($res_1);

							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"evaluacion"    => 	$row_1['DescripcionCortaEvaluacion'], 
															"ambito"       	=> 	$line[2]));
						}elseif ($tbl == "ItemsDesarrollo"){               
							$sql_1 = "SELECT `DescripcionCortaEvaluacion` FROM `Evaluaciones` WHERE `CodigoEvaluacion` = '".$line[1]."'";
							$res_1 = mysql_query($sql_1,$conexion);
							$row_1 = mysql_fetch_array($res_1);

							$sql_2 = "SELECT `DescripcionArea` FROM `Desarrollos` WHERE `CodigoArea` = '".$line[2]."'";
							$res_2 = mysql_query($sql_2,$conexion);
							$row_2 = mysql_fetch_array($res_2);

							

							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"evaluacion"    => 	$row_1['DescripcionCortaEvaluacion'], 
															"ambito"       	=> 	$row_2['DescripcionArea'], 
															"eje"    => 	$line[3], 
															"descripcion"       	=> 	$line[4]));
						}elseif ($tbl == "ElemnetosItemDesarrollo"){               
							$sql_1 = "SELECT `DescripcionItemDesarrollo` FROM `ItemsDesarrollo` WHERE `itemdesa_ncorr` = '".$line[1]."'";
							$res_1 = mysql_query($sql_1,$conexion);
							$row_1 = mysql_fetch_array($res_1);

							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"item"    => 	$row_1['DescripcionItemDesarrollo'], 
															"descripcion"       	=> 	$line[2], 
															"descripcion_larga"     => 	$line[3]));
						}elseif ($tbl == "menues"){                                             
							$sql_ff = "select perfil_nombre
															from perfiles
															where perfil_codigo = ".$line[2];
												$res_ff = mysql_query($sql_ff, $conexion);
												$row_ff = mysql_fetch_array($res_ff);
												array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																				"descripcion"       => 	$line[1], 
																				"perfil"	=> 	$row_ff['perfil_nombre'], 
																				"orden"	=> 	$line[3]));
						}elseif ($tbl == "usuarios_perfiles_menu"){  
							$sql_01 = "select perfil_nombre from gescolcl_arcoiris_administracion.perfiles where perfil_codigo = '".$line[1]."'";
							$res_01 = mysql_query($sql_01,$conexion);
							$row_01 = mysql_fetch_array($res_01);
							$perfil = $row_01['perfil_nombre'];
							
							$sql_01 = "select menu_desc from gescolcl_arcoiris_administracion.menues where menu_ncorr = '".$line[2]."'";
							$res_01 = mysql_query($sql_01,$conexion);
							$row_01 = mysql_fetch_array($res_01);
							$menu = $row_01['menu_desc'];
							
							$sql_01 = "select mhij_desc from gescolcl_arcoiris_administracion.menues_hijos where mhij_ncorr = '".$line[3]."'";
							$res_01 = mysql_query($sql_01,$conexion);
							$row_01 = mysql_fetch_array($res_01);
							$pagina = $row_01['mhij_desc'];
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"perfil"       	=> 	$perfil, 
																"menu"			=> 	$menu, 
																"pagina"		=> 	$pagina, 
																"orden"			=> 	$line[4]));
						}elseif ($tbl == "menues_hijos"){                                             
							$sql_ff = "select perfil_nombre
															from perfiles
															where perfil_codigo = ".$line[5];
												$res_ff = mysql_query($sql_ff, $conexion);
												$row_ff = mysql_fetch_array($res_ff);
							$sql_gg = "select menu_desc
															from menues
															where menu_ncorr = ".$line[1];
												$res_gg = mysql_query($sql_gg, $conexion);
												$row_gg = mysql_fetch_array($res_gg);
							$sql_dd = "select nombre
															from sub_menus
															where submenu_ncorr = ".$line[2];
												$res_dd = mysql_query($sql_dd, $conexion);
												$row_dd = mysql_fetch_array($res_dd);
												array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																				"padre"         => 	$row_gg['menu_desc'], 
																				"sub_menu"      => 	$row_dd['nombre'],  
																				"descripcion"   => 	$line[3], 
																				"link"          => 	$line[4], 
																				"perfil"        => 	$row_ff['perfil_nombre'], 
																				"orden"         => 	$line[6], 
																				"mostrar"       => 	$line[7]));
						}else{                                             
							array_push($arrRegistros, array("ncorr" => $line[0], "desc"	=> 	$line[1]));
						}
					}
				}	
			}
			else{
				//$objResponse->addAlert($resultado);
				if (($resultado!='')&&($resultado!=' order by NumeroLista asc ')){
					$res = mysql_query($sql, $conexion) or die(mysql_error());
					if (mysql_num_rows($res) > 0){
						$i=1;
						$arrRegistros = array();
						while ($line = mysql_fetch_row($res)) {
							if ($tbl == "alumnos"){  
								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[10];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
								array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
																"nombres"     		=> 	$line[4].' '.$line[5].', '.$line[6], 
																"curso"		      	=> 	$row_ff['NombreCurso'],
																"rut"			=>	$line[34]));
							}elseif ($tbl=='Postulantes'){  
							$sql_ff = "select NombreCurso
									   from Cursos
									   where CodigoCurso = ".$line[11];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							$sql_gg = "select nombre
									   from AutorizadoPostulantes
									   where ap_ncorr = ".$line[1];
							$res_gg = mysql_query($sql_gg, $conexion);
							$row_gg = mysql_fetch_array($res_gg);
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															//"rut"        			=> 	$line[2].'-'.dv($line[2]),
															"rut"        			=> 	$line[2],
															"nombres"     			=> 	$line[5].' '.$line[6].', '.$line[7], 
															"certificadoEstudio"  	=> 	$line[16], 
															"certificadoNacimiento"	=> 	$line[13], 
															"nombres"     			=> 	$line[5].' '.$line[6].', '.$line[7], 
															"curso"		      		=> 	$row_ff['NombreCurso'], 
															"autorizado"		    => 	$row_gg['nombre']));
						}elseif ($tbl == "declaracion_accidente"){  
							$anio = $_SESSION["sige_anio_escolar_vigente"]-1;
    
							$sql_ff = "select nombre
									   from tipos_accidentes
									   where ta_ncorr = ".$line[3];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							
							$sql_ff_1 = "select concat(NombresAlumno,' ',PaternoAlumno,' ',MaternoAlumno) as pool,
												NombreCurso
									   from alumnos".$anio."
									   		inner join Cursos
								   				on Cursos.CodigoCurso = alumnos".$anio.".CodigoCurso
									   where NumeroRutAlumno = ".$line[1];
							$res_ff_1 = mysql_query($sql_ff_1, $conexion);
							$row_ff_1 = mysql_fetch_array($res_ff_1);
							
							
							array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
															"alumno"      			=> 	$row_ff_1['pool'],
															"hora"      			=> 	$line[2],
															"observacion"      		=> 	substr($line[8],0,25),
															"testigo1"     			=> 	$line[5],
															"testigo2"     			=> 	$line[7],
															"tipo"      			=> 	$row_ff['nombre']
															));
							
							}elseif ($tbl == "BitacorasAcademicas"){  
								$anio = $_SESSION["sige_anio_escolar_vigente"];
	    
								$sql_ff_1 = "select concat(PaternoProfesor,' ',MaternoProfesor,', ',NombresProfesor) as pool
										   from Profesores
										   where NumeroRutProfesor = ".$line[4];
								$res_ff_1 = mysql_query($sql_ff_1, $conexion) or die(mysql_error());
								$row_ff_1 = mysql_fetch_array($res_ff_1);
								
								$alumno = $row_ff_1['pool'];

								array_push($arrRegistros, array("ncorr"        			=> 	$line[0],
																"alumno"			    => 	$alumno,
																"fecha"					=> 	$line[6], 
																"descripcion"			=> 	$line[13], 
																"usuario"			=> 	$line[17]));
							}elseif ($tbl == "Profesores"){  
								array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
																"rut"        		=> 	$line[0].'-'.dv($line[0]),
																"nombre"     		=> 	$line[5], 
																"apellido_paterno"  => 	$line[3], 
																"apellido_materno"  => 	$line[4], 
																"direccion"      	=> 	$line[6], 
																"fecha_nac"      	=> 	$line[12], 
																"telefono"      	=> 	$line[14], 
																	"vigencia_cert_antecedentes"      	=> 	$line[19]));
							}elseif ($tbl == "Apoderados"){  
								array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
																"rut"        		=> 	$line[0].'-'.dv($line[1]),
																"nombre"     		=> 	$line[4], 
																"apellido_paterno"  => 	$line[2], 
																"apellido_materno"  => 	$line[3], 
																"direccion"      	=> 	$line[5], 
																"telefono"      	=> 	$line[7]));
							}elseif ($tbl == "Cursos"){  
								$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
										from Profesores 
										where NumeroRutProfesor  = '".$line[4]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
					

								array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
																"codigo"        	=> 	$line[0],
																"nombre"     		=> 	$line[1], 
																"descripcion"  		=> 	$line[3], 
																"profesor_jefe"		=> 	$row_002['pool']));
							}elseif ($tbl == "Niveles"){  
								array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
																"nombre_nivel"      		=> 	$line[1],
																"resolucion_autoriza"		=> 	$line[2], 
																"FechaResolucionAutoriza"  	=> 	$line[3], 
																"ResolucionCierre"  		=> 	$line[4], 
																"FechaResolucionCierre"     => 	$line[5]));
							}elseif ($tbl == "Asignaturas"){  
								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[0];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[1]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);
			
								$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[2]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
			
								array_push($arrRegistros, array("curso"        				=> 	$row_ff['NombreCurso'],
																"asignatura"      			=> 	$row_001['Descripcion'],
																"profesor"					=> 	$row_002['pool']));
							}elseif ($tbl == "Pruebas"){  
								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[3];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[4]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);
			
								$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[5]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
			
								$sql_003 = "select NumeroNota 
											from gescolcl_arcoiris_administracion.NotasAlumnos
											where AnoAcademico = (select AnoAcademico from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and Semestre = (select Semestre from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and CodigoCurso = (select CodigoCurso from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and CodigoRamo = (select CodigoRamo from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')
												and NumeroNota = (select NumeroNota from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$line[0]."')";
								$res_003 = mysql_query($sql_003, $conexion);
								if (mysql_num_rows($res_003)>0){
									$notas_pruebas = '1';
									}
								else{
									$notas_pruebas = '0';
									}
			
								array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
																"anio"        				=> 	$line[1],
																"semestre"        			=> 	$line[2],
																"curso"        				=> 	$row_ff['NombreCurso'],
																"asignatura"      			=> 	$row_001['Descripcion'],
																"profesor"					=> 	$row_002['pool'],
																"numero_prueba"				=> 	$line[6],
																"fecha_prueba"				=> 	$line[7],
																"notas_pruebas"				=> 	$notas_pruebas,
																"descripcion_prueba"		=> 	$line[10]));
							}elseif ($tbl == "usuarios"){                                             
								$sql_ff = "select perfil_nombre
																from perfiles
																where perfil_codigo = ".$line[4];
													$res_ff = mysql_query($sql_ff, $conexion);
													$row_ff = mysql_fetch_array($res_ff);
													array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																					"usuario"       => 	$line[1], 
																					"password"	=> 	$line[2], 
																					"nombre"	=> 	$line[3], 
																					"perfil"	=> 	$row_ff['perfil_nombre']));
							}elseif ($tbl == "Horas"){                                             
								$sql_ff = "select DescripcionTipoHorario
											from TiposHorario
											where CodigoTipoHorario = ".$line[1];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"tipo_horario"  => 	$row_ff['DescripcionTipoHorario'], 
																"codigo_hora"	=> 	$line[2], 
																"descripcion"	=> 	$line[7]));
							}elseif ($tbl == "Retiros"){                                             
								$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool,
													NombreCurso
											from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
												inner join Cursos
													on Cursos.CodigoCurso = alumnos".$_SESSION['sige_anio_escolar_vigente'].".CodigoCurso
											where NumeroRutAlumno  = '".$line[1]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"alumno"		=> 	$row_002['pool'], 
																"curso"			=> 	$row_002['NombreCurso'], 
																"observacion"	=> 	$line[4]));
							}elseif ($tbl == "Matriculas"){                                             
								$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']."
												
											where NumeroRutAlumno  = '".$line[1]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_003 = "select NombreCurso from gescolcl_arcoiris_administracion.Cursos where CodigoCurso = '".$line[5]."'";
								$res_003 = mysql_query($sql_003, $conexion);
								$row_003 = mysql_fetch_array($res_003);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"rut" 			=>  $line[1].'-'.dv($line[1]), 
																"nro_matricula" =>  $line[6], 
																"curso" 		=>  $row_003['NombreCurso'], 
																"nro_lista" 	=>  $line[7], 
																"alumno"		=> 	$row_002['pool'], 
																"fecha"			=> 	$line[3], 
																"fecha_retiro"			=> 	$line[4], 
																"observacion"	=> 	$line[8]));
							}elseif ($tbl == "Eximisiones"){                                             
								$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']."
											where NumeroRutAlumno  = '".$line[5]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[3];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[4]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"alumno"		=> 	$line[1], 
																"curso"			=> 	$row_ff['NombreCurso'], 
																"aisgnatura"	=> 	$row_001['Descripcion'], 
																"alumno"		=> 	$row_002['pool'], 
																"fecha"			=> 	$line[7]));
							}elseif ($tbl == "HojasDeVida"){                                             
								$sql_002 = "select nombre
											from TipoHojaVida 
											where thv_ncorr  = '".$line[4]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_003 = "select DescripcionMotivo
											from MotivoAnotaciones 
											where CodigoMotivo  = '".$line[5]."'";
								$res_003 = mysql_query($sql_003, $conexion);
								$row_003 = mysql_fetch_array($res_003);
								

								$sql_ff = "select NombreCurso
										   from Cursos
										   where CodigoCurso = ".$line[1];
								$res_ff = mysql_query($sql_ff, $conexion);
								$row_ff = mysql_fetch_array($res_ff);
			
								$sql_001 = "select Descripcion 
											from Ramos 
											where CodigoRamo = '".$line[3]."'";
								$res_001 = mysql_query($sql_001, $conexion);
								$row_001 = mysql_fetch_array($res_001);

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"fecha"			=> 	$line[7], 
																"curso"			=> 	$row_ff['NombreCurso'], 
																"ramo"			=> 	$row_001['Descripcion'], 
																"tipo"			=> 	$row_002['nombre'], 
																"motivo"		=> 	$row_003['DescripcionMotivo'], 
																"usuario"		=> 	$line[10], 
																"observacion"	=> 	$line[8]));
							}elseif ($tbl == "CertificacionesProfesores"){                                             
								$sql_004 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"fecha"			=> 	$line[2], 
																"observacion"	=> 	$line[3], 
																"foto"			=> 	$line[4]));
							}elseif ($tbl == "ArchivoPersonalAlumnos"){                                             
								$sql_004 = "select concat(NombresAlumno,' ',PaternoAlumno,' ',MaternoAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
											where NumeroRutAlumno  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"fecha"			=> 	$line[2], 
																"observacion"	=> 	$line[3], 
																"foto"			=> 	$line[4]));
							}elseif ($tbl == "CargasFamiliaresProfesores"){                                             
								$sql_004 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								$fecha_nacimiento = new DateTime($line[7]);
								$hoy = new DateTime();
								$edad = $hoy->diff($fecha_nacimiento);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"rut"			=> 	$line[2].'-'.dv($line[2]), 
																"nombres"		=> 	$line[4].' '.$line[5].', '.$line[6], 
																"fecha"			=> 	$line[7], 
																"edad"			=> 	$edad->y));

							}elseif ($tbl == "HojasDeVidaProfesores"){                                             
								$sql_002 = "select nombre
											from TipoHojaVida 
											where thv_ncorr  = '".$line[2]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								$sql_003 = "select DescripcionMotivo
											from MotivoAnotacionesProfesores 
											where CodigoMotivo  = '".$line[3]."'";
								$res_003 = mysql_query($sql_003, $conexion);
								$row_003 = mysql_fetch_array($res_003);
								
								$sql_004 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
											from Profesores 
											where NumeroRutProfesor  = '".$line[1]."'";
								$res_004 = mysql_query($sql_004, $conexion);
								$row_004 = mysql_fetch_array($res_004);
			

								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"profesor"		=> 	$row_004['pool'], 
																"fecha"			=> 	$line[4], 
																"tipo"			=> 	$row_002['nombre'], 
																"motivo"		=> 	$row_003['DescripcionMotivo'], 
																"observacion"	=> 	$line[5]));
							}elseif ($tbl == "MotivoAnotaciones"){                                             
								$sql_002 = "select nombre
											from TipoHojaVida 
											where thv_ncorr  = '".$line[2]."'";
								$res_002 = mysql_query($sql_002, $conexion);
								$row_002 = mysql_fetch_array($res_002);
								
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"descripcion"	=> 	$line[1], 
																"motivo"			=> 	$row_002['nombre']));
							}elseif ($tbl == "perfiles"){                                             
								array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																					"codigo"       => 	$line[1], 
																					"nombre"	=> 	$line[2], 
																					"descripcion"	=> 	$line[3]));
							}elseif ($tbl == "usuarios_perfiles_menu"){                                             
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"perfil"       	=> 	$line[1], 
																"menu"			=> 	$line[2], 
																"pagina"		=> 	$line[3], 
																"orden"			=> 	$line[4]));
							}elseif ($tbl == "menues"){                                             
								$sql_ff = "select perfil_nombre
																from perfiles
																where perfil_codigo = ".$line[2];
													$res_ff = mysql_query($sql_ff, $conexion);
													$row_ff = mysql_fetch_array($res_ff);
													array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																					"descripcion"       => 	$line[1], 
																					"perfil"	=> 	$row_ff['perfil_nombre'], 
																					"orden"	=> 	$line[3]));
							}elseif ($tbl == "menues_hijos"){                                             
								$sql_ff = "select perfil_nombre
																from perfiles
																where perfil_codigo = ".$line[5];
													$res_ff = mysql_query($sql_ff, $conexion);
													$row_ff = mysql_fetch_array($res_ff);
								$sql_gg = "select menu_desc
																from menues
																where menu_ncorr = ".$line[1];
													$res_gg = mysql_query($sql_gg, $conexion);
													$row_gg = mysql_fetch_array($res_gg);
								$sql_dd = "select nombre
																from sub_menus
																where submenu_ncorr = ".$line[2];
													$res_dd = mysql_query($sql_dd, $conexion);
													$row_dd = mysql_fetch_array($res_dd);
													array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																					"padre"         => 	$row_gg['menu_desc'], 
																					"sub_menu"      => 	$row_dd['nombre'],  
																					"descripcion"   => 	$line[3], 
																					"link"          => 	$line[4], 
																					"perfil"        => 	$row_ff['perfil_nombre'], 
																					"orden"         => 	$line[6], 
																					"mostrar"       => 	$line[7]));
							}else{                                             
								array_push($arrRegistros, array("ncorr" => $line[0], "desc"	=> 	$line[1]));
							}
						}
					}

				}
			}
		if (($data['rut_papa']!='')){
			if ($data['rut_papa']!='0'){
				if ($tbl=='HojasDeVidaProfesores' || $tbl=='CertificacionesProfesores' || $tbl=='CargasFamiliaresProfesores' ){
					$valor_campo = $data['rut_papa'];
					$sql_002 = "select concat(PaternoProfesor,' ',MaternoProfesor,', ',NombresProfesor) as pool
											from Profesores
											where NumeroRutProfesor  = '".$valor_campo."'";
					$res_002 = mysql_query($sql_002, $conexion);
					$row_002 = mysql_fetch_array($res_002);
					$alumno = $row_002['pool'];
					$objResponse->addAssign("BSCNumeroRutProfesor", "value", $alumno);
					$objResponse->addAssign("OBLINumeroRutProfesor", "value",$valor_campo);
					}
				elseif ($tbl=='ArchivoPersonalAlumnos'){
					$sql = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool 
							from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
							where 1 and NumeroRutAlumno = '".$data['rut_papa']."'";
					$res = mysql_query($sql,$conexion) or die(mysql_error());
					$row = mysql_fetch_array($res);
					$alumno = $row['pool'];
					
					$objResponse->addAssign("BSCNumeroRutAlumno", "value", $alumno);
					$objResponse->addAssign("OBLINumeroRutAlumno", "value", $data['rut_papa']);
					
					}
				elseif($tbl=='Profesores'){
					$sql = "select proefsor_ncorr from $bd.$tbl where 1 and NumeroRutProfesor = '".$data['rut_papa']."'";
					$res = mysql_query($sql,$conexion) or die(mysql_error());
					$row = mysql_fetch_array($res);
					
					$objResponse->addScript("xajax_TraeValor(xajax.getFormValues('Form1'),'".$row[0]."')");
					}
				}
			else{
				$sql = "select $campos from $bd.$tbl where 1 $resultado";
				$res = mysql_query($sql,$conexion) or die(mysql_error());
				$row = mysql_fetch_array($res);
				$objResponse->addScript("xajax_TraeValor(xajax.getFormValues('Form1'),'".$row[0]."')");
				}
			}
		$tbl == "Matriculas" ? $arrRegistros = ordenar_matriz_multidimensionada($arrRegistros,'codigo_curso','ASC') : '';
		$miSmarty->assign('TBL', $tbl);
		$miSmarty->assign('readonly', $readonly);
		$sql = "select mant_titulo from mantenedores where mant_tabla = '".$tbl."'";
		$res = mysql_query($sql,$conexion);
		$miSmarty->assign('TITULO_TABLA', @mysql_result($res,0,"mant_titulo"));
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_mant_tablas_list.tpl'));
	
	}
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	$objResponse->addScript("document.getElementById('$obj1').focus();");
	
	return $objResponse->getXML();
}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa"];
	$ncorr 		= 	$data["$objeto1"];
	
	if ($c_and == 1){
		$and = " and empe_ncorr = '".$empresa."'";
	}
	
	$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    global $bd;
    
	$objResponse = new xajaxResponse('UTF8');
	
	$tbl =	$data["txtTabla"]; 
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC limit 1";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		$objeto  = 	"OBLI".@mysql_result($res_c,0,"campo");
            }	
	$objResponse->addScript("document.getElementById('$objeto').focus();");
        if (($tbl == "BitacorasAcademicas")){
        	$rut = $data['rut_papa'];

        	$sql = "select NumeroRutAlumno, concat(PaternoAlumno,' ', MaternoAlumno,', ', NombresAlumno) as pool
        			from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
        			where NumeroRutAlumno = '".$rut."'";
        	$res = mysql_query($sql,$conexion) or die(mysql_error());
        	$row = mysql_fetch_array($res);

        	$objResponse->addAssign("BSCNumeroRutAlumno", "value", $row['pool']);
			$objResponse->addAssign("OBLINumeroRutAlumno", "value",$row['NumeroRutAlumno']);
			
			$sql = "select Apoderados.NumeroRutApoderado, concat(PaternoApoderado,' ', MaternoApoderado,', ', NombresApoderado) as pool
        			from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
        				inner join Apoderados
        					on Apoderados.NumeroRutApoderado = alumnos".$_SESSION["sige_anio_escolar_vigente"].".NumeroRutApoderado
        			where alumnos".$_SESSION["sige_anio_escolar_vigente"].".NumeroRutAlumno = '".$rut."'";
        	$res = mysql_query($sql,$conexion) or die(mysql_error());
        	$row = mysql_fetch_array($res);

        	$objResponse->addAssign("BSCNumeroRutApoderado", "value", $row['pool']);
			$objResponse->addAssign("OBLINumeroRutApoderado", "value",$row['NumeroRutApoderado']);
			
			$sql = "select Cursos.CodigoCurso, NombreCurso, ProfesorJefe, concat(PaternoProfesor,' ', MaternoProfesor,', ', NombresProfesor) as pool
        			from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
        				inner join Cursos
        					on Cursos.CodigoCurso = alumnos".$_SESSION["sige_anio_escolar_vigente"].".CodigoCurso
        				inner join Profesores
        					on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor
        			where alumnos".$_SESSION["sige_anio_escolar_vigente"].".NumeroRutAlumno = '".$rut."'";
        	$res = mysql_query($sql,$conexion) or die(mysql_error());
        	$row = mysql_fetch_array($res);

        	$objResponse->addAssign("nombre_curso", "value", $row['NombreCurso']);
			$objResponse->addAssign("OBLICurso", "value",$row['CodigoCurso']);
			$objResponse->addAssign("nombre_profesor", "value", $row['pool']);
			$objResponse->addAssign("OBLIProfesorJefe", "value",$row['ProfesorJefe']);
			
			
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAsignatura','Ramos','','','CodigoRamo', 'Descripcion', '')");
        	}
        if (($tbl == "Entrevistas")){
        	$rut = $data['rut_papa'];

        	$sql = "select NumeroRutAlumno, concat(PaternoAlumno,' ', MaternoAlumno,', ', NombresAlumno) as pool
        			from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
        			where NumeroRutAlumno = '".$rut."'";
        	$res = mysql_query($sql,$conexion) or die(mysql_error());
        	$row = mysql_fetch_array($res);

        	$objResponse->addAssign("BSCNumeroRutAlumno", "value", $row['pool']);
			$objResponse->addAssign("OBLINumeroRutAlumno", "value",$row['NumeroRutAlumno']);

			$objResponse->addAssign("alumno", "innerHTML",' - ' .$row['pool']);

			$j = 0;
			//Alumno/Apoderado/Profesor/Extarna/Otro
			$objResponse->addCreate("OBLIsolicitadoPor","option",""); 		
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].value", '');
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].text", 'Elija'); 	
			$j++;
			$objResponse->addCreate("OBLIsolicitadoPor","option",""); 		
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].value", '1');
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].text", 'Alumno'); 	
			$j++;
			$objResponse->addCreate("OBLIsolicitadoPor","option",""); 		
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].value", '2');
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].text", 'Apoderado'); 	
			$j++;
			$objResponse->addCreate("OBLIsolicitadoPor","option",""); 		
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].value", '3');
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].text", 'Profesor'); 	
			$j++;
			$objResponse->addCreate("OBLIsolicitadoPor","option",""); 		
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].value", '4');
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].text", 'Externa'); 	
			$j++;
			$objResponse->addCreate("OBLIsolicitadoPor","option",""); 		
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].value", '5');
			$objResponse->addAssign("OBLIsolicitadoPor","options[".$j."].text", 'Otro'); 	
			
			$j = 0;
			//Agenda/Presencial/Teléfono/Correo/Mensajería
			$objResponse->addCreate("OBLImedioEntrevista","option",""); 		
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].value", '');
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].text", 'Elija'); 	
			$j++;
			$objResponse->addCreate("OBLImedioEntrevista","option",""); 		
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].value", '1');
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].text", 'Agenda'); 	
			$j++;
			$objResponse->addCreate("OBLImedioEntrevista","option",""); 		
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].value", '2');
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].text", 'Presencial'); 	
			$j++;
			$objResponse->addCreate("OBLImedioEntrevista","option",""); 		
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].value", '3');
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].text", 'Teléfono'); 	
			$j++;
			$objResponse->addCreate("OBLImedioEntrevista","option",""); 		
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].value", '4');
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].text", 'Correo'); 	
			$j++;
			$objResponse->addCreate("OBLImedioEntrevista","option",""); 		
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].value", '5');
			$objResponse->addAssign("OBLImedioEntrevista","options[".$j."].text", 'Mensajería'); 	
			
				
        	}
        if (($tbl == "usuarios_perfiles_menu")){
        	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItper_ncorr','perfiles','','','perfil_codigo', 'perfil_nombre', ' ')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_ncorr','menues','','','menu_ncorr', 'menu_desc', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImhij_ncorr','menues_hijos','','','mhij_ncorr', 'mhij_desc', '')");
            }
		if (($tbl == "alumnos")){
			$where  = '"%ADMISION%"';
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '  where NombreCurso not like ".$where." ')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoAlumno','sexo','','','sexo_ncorr', 'nombre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoReligion','Religiones','','','CodigoReligion', 'Religion', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoComuna','Comunas','','','CodigoComuna', 'Comuna', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoIsapre','Isapres','','','CodigoISapre', 'DescripcionISapre', '')"); 
			 $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoNivel','Niveles','','','nivel_ncorr', 'NombreNivel', '')");
             }
        if (($tbl == "Postulantes")){
			$where  = '"%ADMISION%"';
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '  where NombreCurso like ".$where." ')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoAlumno','sexo','','','sexo_ncorr', 'nombre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoReligion','Religiones','','','CodigoReligion', 'Religion', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoComuna','Comunas','','','CodigoComuna', 'Comuna', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoIsapre','Isapres','','','CodigoISapre', 'DescripcionISapre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoNivel','Niveles','','','nivel_ncorr', 'NombreNivel', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion','Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAutorizado','gescolcl_arcoiris_administracion.AutorizadoPostulantes','','','ap_ncorr', 'nombre', '')");

            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAsiste','sino','','','sino_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIEvaluadora','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIDiagnostico','DiagnosticosTEL','','','dtel_ncorr', 'nombre', '')");

             }
        if ($tbl == "Profesores"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoProfesor','sexo','','','sexo_ncorr', 'nombre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICiudadProfesor','Ciudades','','','CodigoCiudad', 'Ciudad', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoProfesor','TipoFuncionario','','','tf_ncorr', 'NombreTipoFuncionario', '')");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIEstadoCivil','TiposEstadosCivil','','','tec_ncorr', 'nombre', '')");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIafp','afp','','','afp_ncorr', 'nombre', '')");
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIisapre','Isapres','','','i_ncorr', 'DescripcionISapre', '')");
			} 
		if ($tbl=='CargasFamiliaresProfesores'){
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoCarga','sexo','','','sexo_ncorr', 'nombre', '')");
             
		}
		 if ($tbl == "Cursos"){
		 	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoNivel','Aranceles','','','CodigoNivel', 'NombreNivel', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICursoPrecede','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINivelCurso','Niveles','','','nivel_ncorr', 'NombreNivel', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIProfesorJefe','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISituacionFinal','sino','','','sino_ncorr', 'nombre', '')");
            } 
		 if ($tbl == "Asignaturas"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIProfesor','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIImputable','sino','','','sino_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICalculaPromedio','sino','','','sino_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIbonifica','sino','','','sino_ncorr', 'nombre', '')");
            } 
		if ($tbl == "SituacionFinal"){
			$anio_pos = $_SESSION["sige_anio_escolar_vigente"]+1;
            
            $where  = '"%ADMISION%"';
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '  where NombreCurso not like ".$where." ')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAnoAcademico','Periodos','','','distinct AnoAcademico', 'AnoAcademico', ' where AnoAcademico = ".$anio_pos." ')");
            
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISituacion','TiposSituaciones','','','ts_ncorr', 'nombre', '')");
            } 
		if ($tbl == 'Eximisiones'){
            $anio_pos = $_SESSION["sige_anio_escolar_vigente"]+1;
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
		 	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAnoAcademico','Periodos','','','distinct AnoAcademico', 'AnoAcademico', ' where AnoAcademico = ".$anio_pos." ')");
            }
		if ($tbl == 'Entrevistas'){
            
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoEntrevista','TiposEntrevista','','','te_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIEstadoCompromiso','GeneraCompromiso','','','gc_ncorr', 'nombre', '')");
		 	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIGeneraCompromiso','sino','','','sino_ncorr', 'nombre', '')");
            }
		if ($tbl == 'Matriculas'){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
		 	}
		if ($tbl == 'AgendaMatricula'){
			$anio_pos = $_SESSION["sige_anio_escolar_vigente"]+1;
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIPeriodo','Periodos','','','distinct AnoAcademico', 'AnoAcademico', ' where AnoAcademico = ".$anio_pos." ')");
		 	}
		if ($tbl == 'correos_apoderados'){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'correos_apoderados_cursos','Cursos','','','CodigoCurso', 'NombreCurso', '')");
		 	}
		if ($tbl == 'Apoderados'){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoParentesco','Parentesco','','','CodigoParentesco', 'Parentesco', '')");
		 	}
		if ($tbl == 'AlumnosCondicional'){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIMotivoCondicion','MotivosCondicionales','','','CodigoCondicional', 'NombreCondicional', '')");
		 	 $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIperiodo','Periodos','','','distinct AnoAcademico', 'AnoAcademico', ' where AnoAcademico = ".$anio_pos." ')");
		 	}
		if ($tbl == "Pruebas"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINumeroRutProfesor','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIEstadoPrueba','estado','','','e_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoPlazo','PlazoPruebas','','','CodigoPlazo', 'DescripcionPlazo', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISemestre','Periodos','','',' distinct Semestre ', 'NombrePeriodo', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]." ')");
            
            } 
		if ($tbl == "Horas"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoTipoHorario','TiposHorario','','','CodigoTipoHorario', 'DescripcionTipoHorario', '')");
            }
        if ($tbl == "MotivoAnotaciones"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoMotivo','TipoHojaVida','','','thv_ncorr', 'nombre', '')");
            }
        if ($tbl == "MotivoAnotacionesProfesores"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoMotivo','TipoHojaVida','','','thv_ncorr', 'nombre', '')");
            }
        if ($tbl == "HojasDeVida"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINumeroRutAlumno','alumnos".$_SESSION["sige_anio_escolar_vigente"]."','','','NumeroRutAlumno', 'concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoHojaVida','TipoHojaVida','','','thv_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoMotivo','MotivoAnotaciones','','','CodigoMotivo', 'DescripcionMotivo', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            }
        if ($tbl == "HojasDeVidaProfesores"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoHojaVida','TipoHojaVida','','','thv_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoMotivo','MotivoAnotacionesProfesores','','','CodigoMotivo', 'DescripcionMotivo', '')");
            }
        if ($tbl == "Retiros"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRetiro','TiposRetiros','','','CodigoRetiro', 'DescripcionRetiro', '')");
            }
        if ($tbl == "declaracion_accidente"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItipo_accidente','tipos_accidentes','','','ta_ncorr', 'nombre', '')");
            }
        if ($tbl == "Justificativos_Inasistencias"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoJusti','Tipos_justifica','','','tj_ncorr', 'nombre', '')");
            }
        if ($tbl == "Desarrollos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoEvaluacion','Evaluaciones','','','CodigoEvaluacion', 'DescripcionEvaluacion', '')");
            }
        if ($tbl == "ItemsDesarrollo"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoEvaluacion','Evaluaciones','','','CodigoEvaluacion', 'DescripcionEvaluacion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoArea','Desarrollos','','','CodigoArea', 'DescripcionArea', '')");
            }
        if ($tbl == "ElementosItemDesarrollo"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoItem','ItemsDesarrollo','','','itemdesa_ncorr', 'DescripcionItemDesarrollo', '')");
            }
         if ($tbl == "usuarios"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIperf_ncorr','perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            }
        if ($tbl == "menues"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItper_ncorr','perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            }
        if ($tbl == "menues_hijos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_sub','sub_menus','','','submenu_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImhij_perfil','perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_ncorr','menues','','','menu_ncorr', 'menu_desc', '')");
            }
    $objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
	
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$opt = "";
	$tbl				=	$data["txtTabla"];
	if ($tabla == 'Profesores'){
		$campo2 = " concat(PaternoProfesor,' ',MaternoProfesor,', ',NombresProfesor) ";
		$opt = " order by concat(PaternoProfesor,' ',MaternoProfesor,', ',NombresProfesor)";
		} 
	if ($select=='OBLISemestre'){
		$opt = " where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]." ";
		}
	if ($opt=='OBLICodigoCurso'){
		$ramo = $data['OBLICodigoCurso'];
		$curso = $data['OBLICodigoRamo'];
		$opt = 'where NumeroRutProfesor in (select distinct NumeroRutProfesor 
											from Pruebas 
											where CodigoCurso = "'.$ramo.'" and CodigoRamo = "'.$curso.'")';
		}
	
	if (($tbl=='SituacionFinal')&&($select=='OBLIAnoAcademico')){
		$opt = "where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]." ";
		}
	if ($select=='OBLICodigoMotivo'){
		$opt = 'where TipoMotivo = "'.$data['OBLITipoHojaVida'].'"';
		}
	if ($select == 'OBLICodigoRamo'){
		$tbl				=	$data["txtTabla"];
		if (($tbl=='Pruebas')||($tbl=='HojasDeVida')){
			$opt = ' where CodigoRamo in (select CodigoRamo 
											from Asignaturas 
											where CodigoCurso = "'.$data['OBLICodigoCurso'].'") order by Descripcion asc';
			}
		if (($tbl == 'Eximisiones')&&($tabla=='Ramos')){
    		$opt = " where CodigoRamo in (select CodigoRamo
    									from Asignaturas
    									where CodigoCurso = '".$data['OBLICodigoCurso']."')";
			} 
		else{
			$opt = ' order by Descripcion asc';
			}	
		}
	if ($select == 'OBLICodigoCurso'){
		$tbl				=	$data["txtTabla"];
		if ($tbl=='HojasDeVida'){
				
			$sql_temporal = 'select CodigoCurso, NombreCurso 
								from Cursos
								where CodigoCurso in (select CodigoCurso 
											from alumnos'.$_SESSION["sige_anio_escolar_vigente"].'
											where NumeroRutAlumno = "'.$data['OBLINumeroRutAlumno'].'") ';
			$res_temporal  = mysql_query($sql_temporal,$conexion);
			$row_temporal = mysql_fetch_array($res_temporal);

			$codigo = $row_temporal['CodigoCurso'];
			$descripcion = $row_temporal['NombreCurso'];

			$sql = 'select CodigoRamo, Descripcion from Ramos
						where CodigoRamo in (select CodigoRamo 
											from Asignaturas 
											where CodigoCurso = "'.$codigo.'") order by Descripcion asc';
			$res = mysql_query($sql, $conexion);
			
			if (mysql_num_rows($res) > 0) {
				$j = 0;
					$objResponse->addCreate("OBLICodigoRamo","option",""); 		
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", '');
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", 'Elija'); 	
				$j++;
					$objResponse->addCreate("OBLICodigoRamo","option",""); 		
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", 'INSP');
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", 'Inspectoria'); 	
				$j++;
				while ($line = mysql_fetch_array($res)) {
					$objResponse->addCreate("OBLICodigoRamo","option",""); 		
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $line[0]);
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $line[1]); 	
					$j++;
					}
				}
			}
		elseif ($tbl=='SituacionFinal'){
			$opt = " where NombreCurso not like '%ADMISION%' and 
							NombreCurso not like '%EGRESADO%'  and 
							NombreCurso not like '%PROCESO%' and 
							CodigoCurso in (select distinct CodigoCurso from SituacionFinal where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"].") ";
			}	
		else{
			
			}	
		}
	if ($select =='OBLINumeroRutAlumno'){
		$opt = ' where CodigoCurso = "'.$data['OBLICodigoCurso'].'" ';
	}
	if ($select == 'OBLINumeroRutProfesor'){
		$opt = ' where NumeroRutProfesor in (select Profesor 
											from Asignaturas 
											where CodigoRamo = "'.$data['OBLICodigoRamo'].'" and 
												CodigoCurso = "'.$data['OBLICodigoCurso'].'") ';
		
		}	
	if ($tabla == 'sino'){
			$opt = ' order by sino_ncorr asc';
		}
	if ($tabla=='Aranceles'){
		$opt = " where AnioPeriodo = '".$_SESSION["sige_anio_escolar_vigente"]."' ";
		}	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	if ($select =='OBLIPeriodoPostulacion'){
		$sql = "select distinct $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
		}
	//$objResponse->addAlert($sql);
	//echo $sql;
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	if (mysql_num_rows($res) > 0) {
		$j = 0;
		if ($select=='OBLIAutorizado' || $select=='OBLIEstadoCompromiso'){
			}
		else{
			if ($tabla == 'Periodos'){
				if($select=='OBLIPeriodoPostulacion'){
					$sql_es = "select PeriodoPostulacion from gescolcl_arcoiris_administracion.Establecimiento";
					$res_es = mysql_query($sql_es,$conexion);
					$row_es = mysql_fetch_array($res_es);
					$objResponse->addCreate("$select","option",""); 		
					$objResponse->addAssign("$select","options[".$j."].value", $row_es['PeriodoPostulacion']);
					$objResponse->addAssign("$select","options[".$j."].text",  $row_es['PeriodoPostulacion']);
					$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion','Postulantes');");
				}
				else{
					$objResponse->addCreate("$select","option",""); 		
					$objResponse->addAssign("$select","options[".$j."].value", '');
					$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 
				}
			}else{
				if ($codigo!=''){
					$objResponse->addCreate("$select","option",""); 		
					$objResponse->addAssign("$select","options[".$j."].value", $codigo);
					$objResponse->addAssign("$select","options[".$j."].text", $descripcion); 	
				}
				else{
					$objResponse->addCreate("$select","option",""); 		
					$objResponse->addAssign("$select","options[".$j."].value", '');
					$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 	
				}
			}
			$j++;
			}
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
		if ($select=='OBLICodigoRamo' && $tabla=='HojasDeVida'){
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", 'INSP');
			$objResponse->addAssign("$select","options[".$j."].text", 'Inspectoria'); 	
			$j++;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", 'CONC');
			$objResponse->addAssign("$select","options[".$j."].text", 'Consejo Curso'); 	
			$j++;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", 'ORIE');
			$objResponse->addAssign("$select","options[".$j."].text", 'Orientación'); 	
			$j++;
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", 'OTRO');
			$objResponse->addAssign("$select","options[".$j."].text", 'Otros'); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function CargaSelect_1($data, $select){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	//$objResponse->addAlert($select);
	$tbl =	$data["txtTabla"]; 
	if ($select == 'OBLICodigoCurso'){
		if ($tbl=='HojasDeVida'){
			$sql = "select NumeroRutAlumno, concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
					from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
					where CodigoCurso = '".$data['OBLICodigoCurso']."' 
					order by PaternoAlumno,MaternoAlumno,NombresAlumno";
			$res = mysql_query($sql, $conexion);
			
			if (mysql_num_rows($res) > 0) {
				$j = 0;
				$objResponse->addAssign("OBLINumeroRutAlumno","innerHTML",""); 		
				$objResponse->addCreate("OBLINumeroRutAlumno","option",""); 		
				$objResponse->addAssign("OBLINumeroRutAlumno","options[".$j."].value", '');
				$objResponse->addAssign("OBLINumeroRutAlumno","options[".$j."].text", 'Elija'); 	
				$j++;
				while ($line = mysql_fetch_array($res)) {
					$objResponse->addCreate("OBLINumeroRutAlumno","option",""); 		
					$objResponse->addAssign("OBLINumeroRutAlumno","options[".$j."].value", $line[0]);
					$objResponse->addAssign("OBLINumeroRutAlumno","options[".$j."].text", $line[1]); 	
					$j++;
				}
			}
			$sql = 'select CodigoRamo, Descripcion from Ramos
						where CodigoRamo in (select CodigoRamo 
											from Asignaturas 
											where CodigoCurso = "'.$data['OBLICodigoCurso'].'") order by Descripcion asc';
			$res = mysql_query($sql, $conexion);
			
			if (mysql_num_rows($res) > 0) {
				$j = 0;
				$objResponse->addAssign("OBLICodigoRamo","innerHTML",""); 		
				$objResponse->addCreate("OBLICodigoRamo","option",""); 		
				$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", '');
				$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", 'Elija'); 	
				$j++;
				while ($line = mysql_fetch_array($res)) {
					$objResponse->addCreate("OBLICodigoRamo","option",""); 		
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $line[0]);
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $line[1]); 	
					$j++;
					}
				$select = 'OBLICodigoRamo';
				$objResponse->addCreate("$select","option",""); 		
				$objResponse->addAssign("$select","options[".$j."].value", 'INSP');
				$objResponse->addAssign("$select","options[".$j."].text", 'Inspectoria'); 	
				$j++;
				$objResponse->addCreate("$select","option",""); 		
				$objResponse->addAssign("$select","options[".$j."].value", 'CONC');
				$objResponse->addAssign("$select","options[".$j."].text", 'Consejo Curso'); 	
				$j++;
				$objResponse->addCreate("$select","option",""); 		
				$objResponse->addAssign("$select","options[".$j."].value", 'ORIE');
				$objResponse->addAssign("$select","options[".$j."].text", 'Orientacion'); 	
				$j++;
				$objResponse->addCreate("$select","option",""); 		
				$objResponse->addAssign("$select","options[".$j."].value", 'OTRO');
				$objResponse->addAssign("$select","options[".$j."].text", 'Otros'); 	
				$j++;
			
				}
			}
		elseif ($tbl=='Pruebas'){
			$sql = 'select CodigoRamo, Descripcion from Ramos
						where CodigoRamo in (select CodigoRamo 
											from Asignaturas 
											where CodigoCurso = "'.$data['OBLICodigoCurso'].'") order by Descripcion asc';
			$res = mysql_query($sql, $conexion);
			
			if (mysql_num_rows($res) > 0) {
				$j = 0;
				$objResponse->addAssign("OBLICodigoRamo","innerHTML",""); 		
				$objResponse->addCreate("OBLICodigoRamo","option",""); 		
				$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", '');
				$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", 'Elija'); 	
				$j++;
				while ($line = mysql_fetch_array($res)) {
					$objResponse->addCreate("OBLICodigoRamo","option",""); 		
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $line[0]);
					$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $line[1]); 	
					$j++;
					}
				}
			}
		elseif ($tbl=='Matriculas'){
			$CodigoCurso = $data['OBLICodigoCurso'];
			if ($CodigoCurso =='060' || $CodigoCurso =='070' || $CodigoCurso =='080' || $CodigoCurso =='090' ){
				$sql_mx = "select max(NroMatricula)+1 as NroMat, max(NroLista)+1 as NroLis
							from Matriculas
							where Anio = '".$_SESSION["sige_anio_escolar_vigente"]."' and 
									CodigoCurso between '060' and '090'";
				$res_mx = mysql_query($sql_mx,$conexion) or die(mysql_error());
				$row_mx = mysql_fetch_array($res_mx);

				$objResponse->addAssign("OBLINroMatricula", "value",$row_mx['NroMat']);
				$objResponse->addAssign("OBLINroLista", "value",$row_mx['NroLis']);
			}
			if ($CodigoCurso =='110' || $CodigoCurso =='120' || $CodigoCurso =='130' || $CodigoCurso =='140' || 
				$CodigoCurso =='150' || $CodigoCurso =='160' || $CodigoCurso =='170' || $CodigoCurso =='180' || 
				$CodigoCurso =='190' || $CodigoCurso =='200' || $CodigoCurso =='210' || $CodigoCurso =='220' || 
				$CodigoCurso =='230' || $CodigoCurso =='240' || $CodigoCurso =='250' || $CodigoCurso =='260' 
				){
				$sql_mx = "select max(NroMatricula)+1 as NroMat, max(NroLista)+1 as NroLis
							from Matriculas
							where Anio = '".$_SESSION["sige_anio_escolar_vigente"]."' and 
									CodigoCurso between '110' and '260'";
				$res_mx = mysql_query($sql_mx,$conexion) or die(mysql_error());
				$row_mx = mysql_fetch_array($res_mx);

				$objResponse->addAssign("OBLINroMatricula", "value",$row_mx['NroMat']);
				$objResponse->addAssign("OBLINroLista", "value",$row_mx['NroLis']);
			}
			if ($CodigoCurso =='310' || $CodigoCurso =='320' || $CodigoCurso =='330' || $CodigoCurso =='340' || 
				$CodigoCurso =='350' || $CodigoCurso =='360' || $CodigoCurso =='370' || $CodigoCurso =='380' 
				){
				$sql_mx = "select max(NroMatricula)+1 as NroMat, max(NroLista)+1 as NroLis
							from Matriculas
							where Anio = '".$_SESSION["sige_anio_escolar_vigente"]."' and 
									CodigoCurso between '310' and '380'";
				$res_mx = mysql_query($sql_mx,$conexion) or die(mysql_error());
				$row_mx = mysql_fetch_array($res_mx);

				$objResponse->addAssign("OBLINroMatricula", "value",$row_mx['NroMat']);
				$objResponse->addAssign("OBLINroLista", "value",$row_mx['NroLis']);
			}
		}
		else{
			$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
			}
		}
        
    if ($select == 'OBLICodigoRamo'){
        $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINumeroRutProfesor','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', 'OBLICodigoCurso')");

    	}
	if ($select == 'OBLITipoHojaVida'){
		if ($tbl=='HojasDeVidaProfesores'){
	        $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoMotivo','MotivoAnotacionesProfesores','','','CodigoMotivo', 'DescripcionMotivo', 'OBLITipoHojaVida')");
			}
    	}
	return $objResponse->getXML();
}

function FiltrarSelect($data,$select,$tabla){
	global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	$resultado="";
	if ($tabla =='Cursos'){
		if($select == 'OBLICodigoNivel'){
			$resultado = " where CodigoNivel = '".$data[$select]."' ";
			}
		}
    //$objResponse->addAlert("xajax_CargaListado(xajax.getFormValues('Form1'),'".$resultado."')");
    //$objResponse->addScript("(xajax.getFormValues('Form1'),'$resultado')");
	return $objResponse->getXML();
	}
function EliminarItem($data, $ncorr){
    global $conexion;
    global $bd;
    
    $objResponse = new xajaxResponse('UTF8');
	
    $tbl =	$data["txtTabla"];
	
	if ($tbl=='Pruebas'){

		$sql = "select NumeroNota 
				from gescolcl_arcoiris_administracion.NotasAlumnos
				where AnoAcademico = (select AnoAcademico from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$ncorr."')
					and Semestre = (select Semestre from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$ncorr."')
					and CodigoCurso = (select CodigoCurso from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$ncorr."')
					and CodigoRamo = (select CodigoRamo from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$ncorr."')
					and NumeroNota = (select NumeroNota from gescolcl_arcoiris_administracion.Pruebas where prueba_ncorr = '".$ncorr."')";
		$res = mysql_query($sql,$conexion);
		if (mysql_num_rows($res)>0){
			$objResponse->addAlert("ATENCION!. Esta prueba tiene notas ya ingresadas.");
			}
		else{
			$objResponse->addScript("confirmacion = confirm('Confirma la Eliminacion del Registro ?');
						if (confirmacion == true) {
							xajax_EliminarItem_1(xajax.getFormValues('Form1'), '$ncorr');
							}
						");
			}
			
		}
	else{
		$objResponse->addScript("confirmacion = confirm('Confirma la Eliminacion del Registro ?');
					if (confirmacion == true) {
						xajax_EliminarItem_1(xajax.getFormValues('Form1'), '$ncorr');
						}
				");
		}
	return $objResponse->getXML();
}
function EliminarItem_1($data, $ncorr){
    global $conexion;
    global $bd;
    
	$objResponse = new xajaxResponse('UTF8');
		
	$tbl =	$data["txtTabla"];
	if ($tbl == 'trabajadores_tienen_cargas'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores_tienen_cargas';
		}


	//busca el campo clave
	$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
	$res_cc = mysql_query($sql_cc,$conexion);
	$campo_clave = @mysql_result($res_cc,0,"campo_clave");
	
	$sql = "delete from $bd.$tbl where $campo_clave = '".$ncorr."'";
	$res = mysql_query($sql,$conexion);
	
	$objResponse->addScript("alert('Registro Eliminado Correctamente.')");

	if ($tbl=='HojasDeVida'){
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'OBLINumeroRutAlumno','HojasDeVida')");
		}
	else{
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
		}
	
	return $objResponse->getXML();
}
function TraeValor($data, $ncorr){
    global $conexion;
    global	$miSmarty;
    global $bd;
    
	$objResponse = new xajaxResponse('UTF8');
		
	$tbl =	$data["txtTabla"];
	$objResponse->addAssign("txtNcorr", "value", $ncorr);
	if ($tbl == 'trabajadores_tienen_cargas'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores_tienen_cargas';
		}
	//busca el campo clave
	$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC LIMIT 1";
	$res_cc = mysql_query($sql_cc,$conexion);
	$campo_clave = @mysql_result($res_cc,0,"campo_clave");
	if ($campo_clave=='PeriodoPostulacion'){
		$campo_clave = 'postulante_ncorr';
		}
	// busca los campos de la tabla
	$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		$arrCampos = array();
		$arrCamposComentarios = array();
		$j = 0;
		while ($line_c = mysql_fetch_array($res_c)) {
			$arrCampos[$j] = $line_c[0];
			$arrCamposComentarios[$j] = $line_c[1];
			$campos .= $line_c[0].",";
			$j++;
			}
		if ($tbl=='Postulantes'){
			$arrCampos[$j] = 'Autorizado';
			$campos .= "Autorizado,";
			}
		$largo_campos = strlen($campos);
		$campos = substr($campos,0,$largo_campos - 1);
		
		$sql = "select $campos from $bd.$tbl where $campo_clave = '".$ncorr."'";
		if ($tbl=='HojasDeVidaProfesores'){
			$sql .= " and NumeroRutProfesor  = '".$data['rut_papa']."'";
			} 
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i = 0;
			//while ($line = mysql_fetch_row($res)) {
			$line = mysql_fetch_row($res);
			while ($i < $j) {
				$objeto  = 	"OBLI".$arrCampos[$i];
				$objeto_1  = 	"OBLI".$arrCampos[$i];
				$arr_1 = array();
				if ((strlen($line[$i])==10)&&($line[$i][4]=='-')&&($line[$i][7]=='-')){
					list($anio1,$mes1,$dia1) = explode('-', $line[$i]);
					$valor_campo 	= $dia1."/".$mes1."/".$anio1;
					$objResponse->addAssign("FCH".$arrCampos[$i], "value", $valor_campo);
					if (($objeto=='OBLIFechaNacimientoProfesor') || ($objeto=='OBLIIngresoFuncionario')){
						list($d,$m,$a) = explode('/',$valor_campo);
						$d1 = $m.'/'.$d.'/'.$a;
						$d2 = date("m/d/Y");
						$objResponse->addAssign("edad_".$arrCampos[$i], "innerHTML", date_interval($d1,$d2));
						}
					}
				elseif ($objeto=='OBLINumeroRutAlumno'){

					$valor_campo = $line[$i];
					$objResponse->addAssign("rut_postulante", "value", number_format ( $valor_campo , 0 , "" , "." ).'-'.dv($valor_campo));
					$periodo = $_SESSION["sige_anio_escolar_vigente"];
					
					$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$periodo."
												
											where NumeroRutAlumno  = '".$valor_campo."'";
					$res_002 = mysql_query($sql_002, $conexion);
					$row_002 = mysql_fetch_array($res_002);
					$alumno = $row_002['pool'];

					$sql_002 = "select concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as pool
								FROM Apoderados
								WHERE NumeroRutApoderado in (select NumeroRutApoderado
																from alumnos".$periodo."
																where NumeroRutAlumno = '".$valor_campo."')";
					$res_002 = mysql_query($sql_002, $conexion);
					$row_002 = mysql_fetch_array($res_002);
					$apoderado = $row_002['pool'];

					$objResponse->addAssign("OBLINumeroRutAlumno", "value",$valor_campo);
					
					if ($alumno==''){
						$periodo--;
						
						$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
												from alumnos".$periodo."
													
												where NumeroRutAlumno  = '".$valor_campo."'";
						$res_002 = mysql_query($sql_002, $conexion);
						$row_002 = mysql_fetch_array($res_002);
						$alumno = $row_002['pool'];

						$sql_002 = "select concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as pool
									FROM Apoderados
									WHERE NumeroRutApoderado in (select NumeroRutApoderado
																	from alumnos".$periodo."
																	where NumeroRutAlumno = '".$valor_campo."')";
						$res_002 = mysql_query($sql_002, $conexion);
						$row_002 = mysql_fetch_array($res_002);
						$apoderado = $row_002['pool'];
						$objResponse->addAssign("BSCNumeroRutAlumno", "value", $alumno);
						$objResponse->addAssign("apoderado_nombre", "value",$apoderado);
						}
					else{
						$objResponse->addAssign("BSCNumeroRutAlumno", "value", $alumno);
						$objResponse->addAssign("apoderado_nombre", "value",$apoderado);
						}
					}
				elseif ($objeto=='OBLINumeroRutProfesor'){
					if ($tbl=='HojasDeVidaProfesores'){
						$valor_campo = $data['rut_papa'];
						$sql_002 = "select concat(PaternoProfesor,' ',MaternoProfesor,', ',NombresProfesor) as pool
												from Profesores
												where NumeroRutProfesor  = '".$valor_campo."'";
						$res_002 = mysql_query($sql_002, $conexion);
						$row_002 = mysql_fetch_array($res_002);
						$alumno = $row_002['pool'];

						$objResponse->addAssign("BSCNumeroRutProfesor", "value", $alumno);
						$objResponse->addAssign("OBLINumeroRutProfesor", "value",$valor_campo);
						
						}
					else{
						$valor_campo = $line[$i];
						$objResponse->addAssign("rut_profesor", "value", number_format ( $valor_campo , 0 , "" , "." ).'-'.dv($valor_campo));
						$objResponse->addAssign("OBLINumeroRutProfesor", "value",$valor_campo);
						}
					}
				elseif (($arrCampos[$i]=='hora')&&($tbl=='declaracion_accidente')){
					$valor_campo = $line[$i];
					
					list($f,$t) = explode(' ',$valor_campo);
					list($d,$m,$a) = explode('-',$f);$f = $a.'/'.$m.'/'.$d;
					
					$valor_campo = $f.' '.$t;
					
					$objResponse->addScript("document.getElementById('FThora').value = '".$valor_campo."'");
					}
				elseif (($objeto=='OBLINumeroRutTestigo1')&&($tbl=='declaracion_accidente')){
					$valor_campo = $line[$i];
					$objResponse->addAssign("rut_testigo1", "value", number_format ( $valor_campo , 0 , "" , "." ).'-'.dv($valor_campo));
					$objResponse->addAssign("OBLINumeroRutTestigo1", "value",$valor_campo);
					}
				elseif (($objeto=='OBLINumeroRutCarga')&&($tbl=='CargasFamiliaresProfesores')){
					$valor_campo = $line[$i];
					$objResponse->addAssign("rut_carga", "value", number_format ( $valor_campo , 0 , "" , "." ).'-'.dv($valor_campo));
					$objResponse->addAssign("OBLINumeroRutCarga", "value",$valor_campo);
					}
				elseif (($objeto=='OBLIAutorizado')&&($tbl=='Postulantes')){
					$valor_campo = $line[$i];
					$objResponse->addAssign("OBLIAutorizado", "value",$valor_campo);
					$objResponse->addScript("document.getElementById('estado_oculto').style.display='block'");
					}
				elseif (($objeto=='OBLINumeroRutTestigo2')&&($tbl=='declaracion_accidente')){
					$valor_campo = $line[$i];
					$objResponse->addAssign("rut_testigo2", "value", number_format ( $valor_campo , 0 , "" , "." ).'-'.dv($valor_campo));
					$objResponse->addAssign("OBLINumeroRutTestigo2", "value",$valor_campo);
					}
				elseif (($objeto=='OBLICodigoRamo')&&($tbl=='Eximisiones')){
					$valor_campo = $line[$i];
					
					$sql_ramo = "select CodigoRamo , Descripcion
											from Ramos 
											where CodigoRamo = '".$valor_campo."'";
					$res_ramo = mysql_query($sql_ramo,$conexion);
					$row_ramo = mysql_fetch_array($res_ramo);

					$objResponse->addAssign("OBLICodigoRamo","innerHTML",""); 		
				    
					$sql_2 = "select CodigoRamo as codigo, Descripcion as descripcion from Ramos where CodigoRamo in  (select CodigoRamo from Asignaturas where CodigoCurso ='".$line[$i-1]."') ";
					$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
					
					if (mysql_num_rows($res_2) > 0) {
						$j = 0;
						$objResponse->addCreate("OBLICodigoRamo","option",""); 		
						$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $row_ramo['CodigoRamo']);
						$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $row_ramo['Descripcion']); 	
						$j++;
						while ($line_1 = mysql_fetch_array($res_2)) {
							$objResponse->addCreate("OBLICodigoRamo","option",""); 		
							$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $line_1[0]);
							$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $line_1[1]); 	
							$j++;
							}

						}

					}

				elseif (($objeto=='OBLICodigoRamo')&&($tbl=='Pruebas')){
					
					
            		$valor_campo = $line[$i];
					$objResponse->addAssign("$objeto", "value",$valor_campo);
					

					$k = $i+1;
					
					$sql_profe = "select concat(PaternoProfesor, ' ', MaternoProfesor,', ', NombresProfesor) as nop 
							from Profesores
							where NumeroRutProfesor = '".$line[$k]."'";
					$res_profe = mysql_query($sql_profe,$conexion);
					$row_profe = mysql_fetch_array($res_profe);
					$nombre_profesor = $row_profe['nop'];
					$rut_profesor = $line[$k];

					$select_profe = 'OBLINumeroRutProfesor';
					$objResponse->addAssign("$select","innerHTML",""); 		
	
						$m = 0;
							$objResponse->addCreate("$select_profe","option",""); 		
							$objResponse->addAssign("$select_profe","options[".$m."].value", $rut_profesor);
							$objResponse->addAssign("$select_profe","options[".$m."].text", $nombre_profesor); 	
						$m++;
					
						$sql_profe = "select concat(PaternoProfesor, ' ', MaternoProfesor,', ', NombresProfesor) as nop 
									from Profesores
								where NumeroRutProfesor in (select Profesor 
											from Asignaturas 
											where CodigoRamo = '".$valor_campo."' and 
												CodigoCurso = '".$data['OBLICodigoCurso']."') ";
						$res_profe = mysql_query($sql_profe,$conexion);
						$row_profe = mysql_fetch_array($res_profe);
					

						while ($row_profe = mysql_fetch_array($res_profe)) {
							$objResponse->addCreate("$select_profe","option",""); 		
							$objResponse->addAssign("$select_profe","options[".$m."].value", $row_profe[0]);
							$objResponse->addAssign("$select_profe","options[".$m."].text", $row_profe[1]); 	
							$m++;
							}
					

					}
				elseif ($objeto=='OBLICodigoCurso'){
					$valor_campo = $line[$i];

					$sql_ramo = "select CodigoCurso , NombreCurso
											from Cursos 
											where CodigoCurso = '".$valor_campo."'";
					$res_ramo = mysql_query($sql_ramo,$conexion);
					$row_ramo = mysql_fetch_array($res_ramo);

					$objResponse->addAssign("OBLICodigoCurso","innerHTML",""); 		
				    
					$sql_2 = "select CodigoCurso , NombreCurso from Cursos ";
					$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
					
					if (mysql_num_rows($res_2) > 0) {
						$j = 0;
						$objResponse->addCreate("OBLICodigoCurso","option",""); 		
						$objResponse->addAssign("OBLICodigoCurso","options[".$j."].value", $row_ramo['CodigoCurso']);
						$objResponse->addAssign("OBLICodigoCurso","options[".$j."].text", $row_ramo['NombreCurso']); 	
						$j++;
						while ($line_1 = mysql_fetch_array($res_2)) {
							$objResponse->addCreate("OBLICodigoCurso","option",""); 		
							$objResponse->addAssign("OBLICodigoCurso","options[".$j."].value", $line_1[0]);
							$objResponse->addAssign("OBLICodigoCurso","options[".$j."].text", $line_1[1]); 	
							$j++;
							}

						}
					}
				elseif (($objeto=='OBLICodigoRamo')&&($tbl=='Ramos')){
					$k = $i;
					
					$valor_campo = $line[$k];
					$objResponse->addAssign("$objeto", "value",$valor_campo);
					
					}
				elseif (($objeto=='OBLICodigoRamo')&&($tbl=='HojasDeVida')){
					$valor_campo = $line[$i];

					$sql_ramo = "select CodigoRamo , Descripcion
											from Ramos 
											where CodigoRamo = '".$valor_campo."'";
					$res_ramo = mysql_query($sql_ramo,$conexion);
					$row_ramo = mysql_fetch_array($res_ramo);

					$objResponse->addAssign("OBLICodigoRamo","innerHTML",""); 		
				    
					$sql_2 = "select CodigoRamo as codigo, Descripcion as descripcion from Ramos ";
					$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
					
					if (mysql_num_rows($res_2) > 0) {
						$j = 0;
						$objResponse->addCreate("OBLICodigoRamo","option",""); 		
						$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $row_ramo['CodigoRamo']);
						$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $row_ramo['Descripcion']); 	
						$j++;
						while ($line_1 = mysql_fetch_array($res_2)) {
							$objResponse->addCreate("OBLICodigoRamo","option",""); 		
							$objResponse->addAssign("OBLICodigoRamo","options[".$j."].value", $line_1[0]);
							$objResponse->addAssign("OBLICodigoRamo","options[".$j."].text", $line_1[1]); 	
							$j++;
							}

						}

					}
				elseif ($objeto=='OBLIrut_carga'){
					$valor_campo = $line[$i];
					$objResponse->addAssign("$objeto", "value", $valor_campo.'-'.dv($valor_campo));
					}
				elseif ($objeto=='OBLITipoHojaVida'){
					$valor_campo = $line[$i];
					$objResponse->addAssign("$objeto", "value",$valor_campo);
					
					$m = $i +1;
					$valor_campo = $line[$m];
					
					$sql_ramo = "select CodigoMotivo , DescripcionMotivo
											from MotivoAnotaciones 
											where CodigoMotivo = '".$valor_campo."'";
					$res_ramo = mysql_query($sql_ramo,$conexion);
					$row_ramo = mysql_fetch_array($res_ramo);

					$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoMotivo','MotivoAnotaciones','".$row_ramo['CodigoMotivo']."','".$row_ramo['DescripcionMotivo']."','CodigoMotivo', 'DescripcionMotivo', 'OBLITipoHojaVida')");

					}
				elseif ($objeto=='OBLIcuerpo'){
					$valor_campo = $line[$i];
					$objResponse->addAssign("$objeto", "innerHTML", $valor_campo);
					$objResponse->addAssign("jqte_editor", "innerHTML", $valor_campo);
					}
				else{	
					$temp = substr ( $arrCamposComentarios[$i] , 0 , 3 );
						
					if($temp == 'CHK'){
						if ($line[$i]==1) $objResponse->addAssign("$objeto", "checked", "checked");
						elseif($line[$i]==0)  $objResponse->addAssign("$objeto", "checked", "");
						//$objResponse->addAlert("$objeto");
						}
					elseif($temp=='fot'){
						//20271336
						$objResponse->addAssign("img_$objeto", "src", $line[$i]);
						$objResponse->addAssign("$objeto", "value", $line[$i]);
						//$objResponse->addAlert($line[$i]);
						}
					elseif($temp=='not'){
						//20271336
						$objResponse->addAssign("NOTA".$arrCampos[$i], "value", $line[$i]);
						//$objResponse->addAlert($line[$i]);
						}
					elseif($temp=='bus'){
						//20271336
						if ($arrCampos[$i]=='ApoderadoPostulante'){
							$sql_1  ="SELECT * 
							        FROM Apoderados
							        WHERE NumeroRutApoderado = '".$line[$i]."'" ;
							$res_1 = mysql_query($sql_1,$conexion);
							$row_1 = mysql_fetch_array($res_1);
							if($row_1['NumeroRutApoderado']=='0'){
								$objResponse->addAssign("BSC".$arrCampos[$i], "value",  (''));
								$objResponse->addAssign("OBLI".$arrCampos[$i], "value",  (''));
							}
							else{
								if (isset($row_1['NombresApoderado'])){
									$objResponse->addAssign("BSC".$arrCampos[$i], "value",  ($row_1['NombresApoderado'].' '.$row_1['PaternoApoderado'].' '.$row_1['MaternoApoderado']));	
									}
								else{
									$objResponse->addAssign("BSC".$arrCampos[$i], "value",  (''));
									}
								
								$objResponse->addAssign("OBLI".$arrCampos[$i], "value",  ($line[$i]));
								}
							}
						else{
							$objResponse->addAssign("BSC".$arrCampos[$i], "value",  ($line[$i]));
							$objResponse->addAssign("OBLI".$arrCampos[$i], "value",  ($line[$i]));
							}
						//$objResponse->addAlert($line[$i]);
						}
					elseif ($temp=='opc'){
						$objResponse->addAssign("$objeto_1", "value",  ($line[$i]));
						//$objResponse->addAlert("$objeto");
						}
					else{
						//$objResponse->addAlert(utf8_decode($line[$i]));
						$objResponse->addAssign("$objeto", "value",  ($line[$i]));
						}
					}
				$i++;

				}
			if ($tbl=='alumnos'){
				$sql_ff = "select NombreCurso
						   from Cursos
						   where CodigoCurso = ".$line[9];
				$res_ff = mysql_query($sql_ff, $conexion);
				$row_ff = mysql_fetch_array($res_ff);
				$nombre_alumno = $line[3].' '.$line[4].', '.$line[5];
				$curso_alumno = $row_ff['NombreCurso'];
				$objResponse->addAssign('alumno','innerHTML', (' - '.$nombre_alumno.' - '.$curso_alumno));
				}
			if ($TBL=='Matriculas'){
				$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
											from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
												
											where NumeroRutAlumno  = '".$line[1]."'";
				$res_ff = mysql_query($sql_002, $conexion);
				$row_ff = mysql_fetch_array($res_ff);
				$nombre_alumno = $row_ff['pool'];
				$objResponse->addAssign('BSCNumeroRutAlumno','value', ($nombre_alumno));
				$objResponse->addAssign('OBLINumeroRutAlumno','value',$line[1]);
				}
		}	
	}
	
	return $objResponse->getXML();
}

function GuardarWhere($data, $ncorr){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	$where = $data['arr_select'];
	$where = str_replace('$ncorr','',$where);
	$where = $where.','.$ncorr;
	$objResponse->addAssign('arr_select','value',$where);
	return $objResponse->getXML();
	}

function CargaListado_alumnos_Notas($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutAlumno'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_alumnos_notas.php?rut=".$rut."'");
		}
	return $objResponse->getXML();
	}

function CargaListado_alumnos_HojaVida($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutAlumno'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_alumnos_HojaVida.php?rut=".$rut."'");
		}
	return $objResponse->getXML();
	}


function CargaListado_Profesores_HojaVida($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutProfesor'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_mant_tablas.php?tbl=HojasDeVidaProfesores&rut=".$rut."'");
		}
	return $objResponse->getXML();
	}

function CargaListado_Profesores_Certificados($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutProfesor'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_mant_tablas.php?tbl=CertificacionesProfesores&rut=".$rut."'");
		}
	return $objResponse->getXML();
	}

function CargaListado_Profesores_CargasFamiliaresProfesores($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutProfesor'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_mant_tablas.php?tbl=CargasFamiliaresProfesores&rut=".$rut."'");
		}
	return $objResponse->getXML();
	}

function CargaListado_alumnos_Asistencia($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutAlumno'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_alumnos_Asistencia.php?rut=".$rut."'");
		}
	return $objResponse->getXML();
	}


function CargaListado_alumnos_Apoderado($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['OBLINumeroRutAlumno'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_alumnos_Apoderado.php?rut=".$rut."'");
		}
	return $objResponse->getXML();
	}

function CursoMallaCurricular($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut = $data['txtNcorr'];
	if ($rut != ''){
		$objResponse->addScript("location.href='sg_cursos_malla_curricular.php?curso=".$rut."'");
		}
	return $objResponse->getXML();
	}

function ApoderadoPostulante($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("location.href='../../sgcobranza/sitio/sg_mant_tablas.php?tbl=Apoderados&volver=SI'");
	
	return $objResponse->getXML();
	}


function Todos($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$sql = "SELECT * 
        FROM Profesores";

    $res = mysql_query($sql, $conexion);
	$i=0;        
	while ($row = mysql_fetch_assoc($res)) {
		$ncorr_proveedor = $row['EMailFuncionario'];
			$email = $email.$ncorr_proveedor.';';
		}

	$objResponse->addAssign('OBLIdestinatarios','value',$email);

	return $objResponse->getXML();
	}

function Quitar($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign('OBLIdestinatarios','value','');

	return $objResponse->getXML();
	}




function Todos_apoderados($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$sql = "SELECT * 
        FROM Apoderados
        where EMailApoderado not in ('','@','.','X','x','0')";

    $res = mysql_query($sql, $conexion);
	$i=0;        
	while ($row = mysql_fetch_assoc($res)) {
		$ncorr_proveedor = $row['EMailApoderado'];
			$email = $email.$ncorr_proveedor.';';
		}

	$objResponse->addAssign('OBLIdestinatarios','value',$email);

	return $objResponse->getXML();
	}

function Quitar_apoderados($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign('OBLIdestinatarios','value','');

	return $objResponse->getXML();
	}


function EmitirContrato($data,$rut,$periodo){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut_alumno = $rut;
	$periodo = $periodo;

	$objResponse->addScript("showPopWin('sg_confirmar_contrato_postulantes.php?rut_alumno=".$rut_alumno."&periodo=".$periodo."', 'Imprimir Contrato Alumno Nuevo', 800, 600, null);");

	
	return $objResponse->getXML();
	}

function EmitirReciboDinero($data,$rut,$periodo){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$rut_alumno = $rut;
	$periodo = $periodo;

	$objResponse->addScript("showPopWin('sg_confirmar_recibo_dinero_postulantes.php?rut_alumno=".$rut_alumno."&periodo=".$periodo."', 'Imprimir Comprobante Recibo Dinero', 800, 600, null);");

	
	return $objResponse->getXML();
	}


function ApoderadosCurso($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$curso = $data['correos_apoderados_cursos'];

	$sql = "	select EMailApoderado from Apoderados where NumeroRutApoderado in (SELECT NumeroRutApoderado
																					FROM alumnos".$_SESSION['sige_anio_escolar_vigente']."
																					where CodigoCurso = '".$curso."'  and Matriculado = '1'	)
				  ";

    $res = mysql_query($sql, $conexion);
	$i=0;  
	$email = $data['OBLIdestinatarios'];
	while ($row = mysql_fetch_assoc($res)) {
		$ncorr_proveedor = $row['EMailApoderado'];
		$email = $email.$ncorr_proveedor.';';
		}

	$sql = "	SELECT NombreCurso
				FROM Cursos
				where CodigoCurso = '".$curso."' ";
	$res = mysql_query($sql,$conexion);
	$row = mysql_fetch_array($res);

	$cursos_nombre = $data['VERdestinatarios'];
	$objResponse->addAssign('VERdestinatarios','value',$email)	;

	$objResponse->addAssign('OBLIdestinatarios','value',$email);
	
	return $objResponse->getXML();
	}


function ApoderadosCursoEliminar($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	
	$objResponse->addAssign('OBLIdestinatarios','value','');
	$objResponse->addAssign('VERdestinatarios','value','');
	

	return $objResponse->getXML();
	}


function EnviarCorreo($data,$ncorr,$tabla){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
   		
        $sql_001 = "select * from $tabla where c_ncorr = '".$ncorr."'";
        $res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
        $row_001 = mysql_fetch_array($res_001);

        $destinatarios = $row_001['destinatarios'];
        $asunto = $row_001['asunto'];
        $cuerpo = $row_001['cuerpo'];

        $correos_enviados = '0';
        $correos_erroneos = '0';
        $arr_dest = explode(';',$destinatarios);
        for($i=0;$i<count($arr_dest)-1;$i++){
	        $correo = new PHPMailer();
	        $correo->SMTPDebug = 1;                               
	        $correo->isSMTP();                                    
	        $correo->Host = 'mail.gescol.cl';          
	        
	        $correo->From = 'sae@nmva.cl';
	        $correo->FromName = 'Sistema Academico';
	       	
        	$correo->addAddress($arr_dest[$i],$arr_dest[$i]);   
	    
			$correo->isHTML(true);                              
	        $correo->Subject = utf8_decode($asunto);         
	    
	    	$correo->Body    = $cuerpo;

	    	//var_dump($correo);

	        if(!$correo->send()) {
	            $correos_erroneos++;
	        	}
	        else {
	         	$correos_enviados++;
	            } 
	        }

		$objResponse->addAlert("Total Correos Enviados : ".$correos_enviados." - Total Correos Erroneos : ".$correos_erroneos);
    	return $objResponse->getXML();
	}


$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("LlamaIngresoVenta");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaSelect_1");
$xajax->registerFunction("FiltrarSelect");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("EliminarItem_1");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("GuardarWhere");
$xajax->registerFunction("CargaListado_alumnos_Notas");
$xajax->registerFunction("CargaListado_alumnos_HojaVida");
$xajax->registerFunction("CargaListado_profesores_HojaVida");
$xajax->registerFunction("CargaListado_alumnos_Asistencia");
$xajax->registerFunction("CargaListado_alumnos_Apoderado");
$xajax->registerFunction("CargaListado_Profesores_HojaVida");
$xajax->registerFunction("CargaListado_Profesores_Certificados");
$xajax->registerFunction("CargaListado_Profesores_CargasFamiliaresProfesores");
$xajax->registerFunction("CursoMallaCurricular");
$xajax->registerFunction("EnviarCorreo");
$xajax->registerFunction("Todos");
$xajax->registerFunction("Quitar");
$xajax->registerFunction("Todos_apoderados");
$xajax->registerFunction("Quitar_apoderados");
$xajax->registerFunction("ApoderadoPostulante");
$xajax->registerFunction("ApoderadosCurso");
$xajax->registerFunction("ApoderadosCursoEliminar");
$xajax->registerFunction("EmitirReciboDinero");
$xajax->registerFunction("EmitirContrato");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

// busca el titulo de la tabla
$sql = "select mant_titulo from mantenedores where mant_tabla = '".$_GET['tbl']."'";
$res = mysql_query($sql,$conexion);
$tbl = $_GET['tbl'];
if ($tbl == 'trabajadores_tienen_cargas'){
	$bd = 'sggeneral';
	$tbl = 'trabajadores_tienen_cargas';
	}

// busca los campos
$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
$res_c = mysql_query($sql_c, $conexion);

if (mysql_num_rows($res_c) > 0) {
	$arrCampos = array();
	while ($line = mysql_fetch_array($res_c)) {
		$titulo	=	$line[1];
		$objeto	=	"TEXT";
		if (substr($line[1],0,2) == 'ft'){
			$titulo	=	trim(substr($line[1],2));
			$objeto	=	"FECHATIEMPO";
 		}	
		elseif (substr($line[1],0,3) == 'CBO'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"SELECT";
 		}	
		elseif (substr($line[1],0,3) == 'USU'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"USUARIO";
 		}	
		elseif (substr($line[1],0,3) == 'fch'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"FECHA";
 		}elseif (substr($line[1],0,3) == 'hrs'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"HORA";
 		}elseif (substr($line[1],0,4) == 'pass'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"PASSWORD";
 		}elseif (substr($line[1],0,3) == 'rut'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"RUT";
 		}elseif (substr($line[1],0,3) == 'opc'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"OPC";
		}elseif (substr($line[1],0,3) == 'NUM'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"NUMERO";
 		}elseif (substr($line[1],0,3) == 'CHK'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"CHECK";
 		}elseif (substr($line[1],0,4) == 'arch'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"ARCHIVO";
 		}elseif (substr($line[1],0,4) == 'foto'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"FOTO";
 		}elseif (substr($line[1],0,4) == 'nota'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"NOTA";
 		}elseif (substr($line[1],0,4) == 'text'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"AREA";
 		}elseif (substr($line[1],0,5) == 'busca'){
			$titulo	=	trim(substr($line[1],5));
			$objeto	=	"BUSCA";
		}elseif (substr($line[1],0,5) == 'linea'){
			$titulo	=	trim(substr($line[1],5));
			$objeto	=	"linea";
			}
		array_push($arrCampos, array("campo" => $line[0], "titulo" => ($titulo), "objeto" => $objeto));
	}
}

$miSmarty->assign('TABLA', $_GET['tbl']);
$miSmarty->assign('usuario', $_SESSION['alycar_usuario']);
$miSmarty->assign('rut_trab', $_GET['rut']);
$miSmarty->assign('rut', $_GET['rut']."-".dv($_GET['rut']));
$miSmarty->assign('email',$_GET['email']);
$miSmarty->assign('nombre_alumno',$_GET['nombre_alumno']);
$miSmarty->assign('nombre_apoderado',$_GET['nombre_apoderado']);
$miSmarty->assign('nombre_curso',$_GET['nombre_curso']);
$miSmarty->assign('TITULO_TABLA', (mysql_result($res,0,"mant_titulo")));
$miSmarty->assign('arrCampos', $arrCampos);
$miSmarty->assign('anio_vigente', $_SESSION["sige_anio_escolar_vigente"]);
$miSmarty->assign('readonly', $_GET['readonly']);

$miSmarty->assign('pagina_volver',$_SESSION["alycar_pagina_volver"]);
if ($_SESSION['alycar_volver'] =='si'){
	$miSmarty->assign('volver',$_SESSION['alycar_volver']);
	$_SESSION['alycar_volver'] = 'no';
	}

$miSmarty->display('sg_mant_tablas.tpl');
ob_flush();
?>

