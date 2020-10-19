<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_mant_tablas_alumnos.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $bd;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$tbl				=	$data["txtTabla"];
	$ncorr				=	$data["txtNcorr"];
	
	if (($tbl == 'alumnos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
	if ($tbl == 'trabajadores_tienen_cargas'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores_tienen_cargas';
	}
	
	// busca los campos
	if ($ncorr == ''){

		$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			$sql = "insert into $bd.$tbl (";
			while ($line = mysql_fetch_array($res_c)) {
				$campos .= $line[0].",";
				
				$objeto 		= 	"OBLI".$line[0];
				$valor_campo 	= 	$data[$objeto];
				if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
                                    list($dia1,$mes1,$anio1) = split('[/.-]', $valor_campo);
                                    $valor_campo 	= $anio1."-".$mes1."-".$dia1;
                                    //$valor_campo 	= $dia1."-".$mes1."-".$anio1; 
                                    }
				elseif ((strlen($valor_campo)==10)&&($valor_campo[7]=='-')){
					$arr_rut = explode('-',$valor_campo);
					$valor_campo = $arr_rut[0];
					}
				$values .= "'".$valor_campo."',";
			}
			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			$campos = $campos.")";
			
			$largo_values = strlen($values);
			$values = substr($values,0,$largo_values - 1);
			$values = $values.")";
			
			$sql .= $campos." values (".$values;
			$res = mysql_query($sql,$conexion);
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
		
		$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
		$res_c = mysql_query($sql_c, $conexion);
		if (mysql_num_rows($res_c) > 0) {
			$sql = "update $bd.$tbl set ";
			while ($line = mysql_fetch_array($res_c)) {
				if ($line[1] != ''){
					$objeto 		= 	"OBLI".$line[0];
					$valor_campo 	= 	($data[$objeto]);
					if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
						list($dia1,$mes1,$anio1) = explode('/', $valor_campo);
						$valor_campo 	= $anio1."-".$mes1."-".$dia1;
						}
					elseif ((strlen($valor_campo)==10)&&($valor_campo[7]=='-')){
						$arr_rut = explode('-',$valor_campo);
						$valor_campo = $arr_rut[0];
						}
                    $campos .= $line[0]." = '".$valor_campo."',";
				}
			}
			if ($tbl == 'trabajadores_tienen_cargas'){
				$rut_papa = $data['rut_papa'];
				$campos .= "rut_papa = '".$rut_papa."',";
				}
			
			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			$campos = $campos." where ".$campo_clave." = '".$ncorr."'";
			
			$sql .= $campos;
			$res = mysql_query($sql,$conexion);
			
		}
	}
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");

	$objResponse->addScript("alert('Registro Grabado Correctamente.')");
	
	//$objResponse->addScript("document.Form1.submit();");

	return $objResponse->getXML();
}
function CargaListado($data,$select,$tabla){
    global $conexion;
    global $bd;
	global $miSmarty;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	if (($tbl == 'alumnos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
	
	$tbl	=	$data["txtTabla"];
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
				elseif ($codigo == 'OBLIProfesorJefe'){
					$resultado .= "  and  ProfesorJefe = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLICodigoNivel'){
				$resultado .= " and CodigoNivel = '".$data[$select]."' ";
				}
			elseif ($select == 'OBLIProfesorJefe'){
				$resultado .= "  and  ProfesorJefe = '".$data[$select]."' ";
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
	    elseif (($tbl=='alumnos')||($tbl=='Postulantes')){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
					}
				} 
			$codigo = $select;
			if($select == 'OBLICodigoCurso'){
				$resultado .= " and CodigoCurso = '".$data[$select]."' ";
				}
			if($tbl=='alumnos')
				$resultado .= " order by NumeroLista asc "; 
			}
	    elseif ($tbl=='Pruebas'){
			for($i=1; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  CodigoCurso = '".$data[$codigo]."' ";
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
				$resultado .= "  and  CodigoCurso = '".$data[$select]."' ";
				}
			elseif ($select == 'OBLICodigoRamo'){
				$resultado .= "  and  CodigoRamo = '".$data[$select]."' ";
				}
			elseif($select == 'OBLINumeroRutProfesor'){
				$resultado .= "  and  NumeroRutProfesor = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='HojasDeVida'){
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
		$where = $data['arr_select'];
		$where = str_replace('$select','',$where);
		$where = $where.','.$codigo;
		$objResponse->addAssign('arr_select','value',$where);
		$sql = "select $campos from $bd.$tbl where 1 $resultado";
		//$objResponse->addAlert($sql);
		$sql_1 = "select count('".$campo_cont."') as contador from $bd.$tbl where 1 $resultado";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$miSmarty->assign('cant_filas',$row_1['contador']);
			if ((($tbl!='HojasDeVida')&&($tbl!='Pruebas'))||($resultado!='')){ 
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
									   where CodigoCurso = ".$line[9];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															//"rut"        		=> 	$line[2].'-'.dv($line[2]),
															"rut"        		=> 	$line[1],
															"nombres"     		=> 	$line[3].' '.$line[4].', '.$line[5], 
															"curso"		      	=> 	$row_ff['NombreCurso']));
						}elseif ($tbl == "Profesores"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"rut"        		=> 	$line[0].'-'.dv($line[1]),
															"nombre"     		=> 	$line[5], 
															"apellido_paterno"  => 	$line[3], 
															"apellido_materno"  => 	$line[4], 
															"direccion"      	=> 	$line[6], 
															"telefono"      	=> 	$line[13]));
						}elseif ($tbl == "Apoderados"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"rut"        		=> 	$line[0].'-'.dv($line[1]),
															"nombre"     		=> 	$line[4], 
															"apellido_paterno"  => 	$line[2], 
															"apellido_materno"  => 	$line[3], 
															"direccion"      	=> 	$line[5], 
															"telefono"      	=> 	$line[7]));
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
									   where CodigoCurso = ".$line[2];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
		
							$sql_001 = "select Descripcion 
										from Ramos 
										where CodigoRamo = '".$line[3]."'";
							$res_001 = mysql_query($sql_001, $conexion);
							$row_001 = mysql_fetch_array($res_001);
		
							$sql_002 = "select concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) as pool
										from Profesores 
										where NumeroRutProfesor  = '".$line[9]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
		
							array_push($arrRegistros, array("ncorr"        				=> 	$line[0],
															"curso"        				=> 	$row_ff['NombreCurso'],
															"asignatura"      			=> 	$row_001['Descripcion'],
															"profesor"					=> 	$row_002['pool'],
															"descripcion_prueba"		=> 	$line[6]));
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
						}elseif ($tbl == "Retiros"){                                             
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool,
												NombreCurso
										from alumnos 
											inner join Cursos
												on Cursos.CodigoCurso = alumnos.CodigoCurso
										where NumeroRutAlumno  = '".$line[1]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
							
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"alumno"		=> 	$row_002['pool'], 
															"curso"			=> 	$row_002['NombreCurso'], 
															"observacion"	=> 	$line[4]));
						}elseif ($tbl == "Eximisiones"){                                             
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
										from alumnos 
										where NumeroRutAlumno  = '".$line[1]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
							
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"alumno"		=> 	$row_002['pool'], 
															"fecha"			=> 	$line[6]));
						}elseif ($tbl == "HojasDeVida"){                                             
							$sql_002 = "select nombre
										from TipoHojaVida 
										where thv_ncorr  = '".$line[6]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
							
							$sql_003 = "select DescripcionMotivo
										from MotivoAnotaciones 
										where CodigoMotivo  = '".$line[7]."'";
							$res_003 = mysql_query($sql_003, $conexion);
							$row_003 = mysql_fetch_array($res_003);
							
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"fecha"			=> 	$line[3], 
															"tipo"			=> 	$row_002['nombre'], 
															"motivo"		=> 	$row_003['DescripcionMotivo'], 
															"observacion"	=> 	$line[4].'-'.$line[5]));
						}elseif ($tbl == "perfiles"){                                             
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
																				"codigo"       => 	$line[1], 
																				"nombre"	=> 	$line[2], 
																				"descripcion"	=> 	$line[3]));
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
		$miSmarty->assign('TBL', $tbl);
		$sql = "select mant_titulo from mantenedores where mant_tabla = '".$tbl."'";
		$res = mysql_query($sql,$conexion);
		$miSmarty->assign('TITULO_TABLA', @mysql_result($res,0,"mant_titulo"));
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_mant_tablas_alumnos_list.tpl'));
	
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
	if (($tbl == 'alumnos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
	
	$tbl =	$data["txtTabla"]; 
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC limit 1";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		$objeto  = 	"OBLI".@mysql_result($res_c,0,"campo");
            }	
	$objResponse->addScript("document.getElementById('$objeto').focus();");
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
             }
        if ($tbl == "Profesores"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoProfesor','sexo','','','sexo_ncorr', 'nombre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICiudadProfesor','Ciudades','','','CodigoCiudad', 'Ciudad', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoProfesor','TipoFuncionario','','','tf_ncorr', 'NombreTipoFuncionario', '')");
			} 
		 if ($tbl == "Cursos"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoNivel','Niveles','','','CodigoNivel', 'NombreNivel', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICursoPrecede','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINivelCurso','NivelesCurso','','','NivelCurso', 'NombreNivelCurso', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIProfesorJefe','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
            } 
		 if ($tbl == "Asignaturas"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIProfesor','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
            } 
		 if ($tbl == "Eximisiones"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
		 	}
		if ($tbl == "Pruebas"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINumeroRutProfesor','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIEstadoPrueba','estado','','','e_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoPlazo','PlazoPruebas','','','CodigoPlazo', 'DescripcionPlazo', '')");
            } 
		if ($tbl == "Horas"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoTipoHorario','TiposHorario','','','CodigoTipoHorario', 'DescripcionTipoHorario', '')");
            }
        if ($tbl == "HojasDeVida"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoHojaVida','TipoHojaVida','','','thv_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoMotivo','MotivoAnotaciones','','','CodigoMotivo', 'DescripcionMotivo', '')");
            }
        if ($tbl == "Retiros"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRetiro','TiposRetiros','','','CodigoRetiro', 'DescripcionRetiro', '')");
            }
        if ($tbl == "Desarrollos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoEvaluacion','Evaluaciones','','','CodigoEvaluacion', 'DescripcionEvaluacion', '')");
            }
        if ($tbl == "ItemsDesarrollo"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoEvaluacion','Evaluaciones','','','CodigoEvaluacion', 'DescripcionEvaluacion', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoArea','Desarrollos','','','CodigoArea', 'DescripcionArea', '')");
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
	global $bd;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	    
	if ($tabla == 'Profesores'){
		$campo2 = " concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) ";
		} 
	if ($opt=='OBLICodigoCurso'){
		$ramo = $data['OBLICodigoCurso'];
		$curso = $data['OBLICodigoRamo'];
		$opt = 'where NumeroRutProfesor in (select distinct NumeroRutProfesor 
											from Pruebas 
											where CodigoCurso = "'.$ramo.'" and CodigoRamo = "'.$curso.'")';
		}
	if ($select == 'OBLICodigoRamo'){
			$ramo = $data['OBLICodigoCurso'];
			$opt = 'where CodigoRamo in (select CodigoRamo
			from Asignaturas
			where CodigoCurso = "'.$ramo.'")';
	}
		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from gescolcl_arcoiris_administracion.$tabla $opt";
	//$objResponse->addAlert($sql);
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		$j = 0;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function CargaSelect_1($data, $select){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	//$objResponse->addAlert($select);
	if ($select == 'OBLICodigoCurso'){
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoRamo','Ramos','','','CodigoRamo', 'Descripcion', '')");
		}
        
    if ($select == 'OBLICodigoRamo'){
        $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINumeroRutProfesor','Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', 'OBLICodigoCurso')");

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
	if (($tbl == 'alumnos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
		
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
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
	
	return $objResponse->getXML();
}
function TraeValor($data, $ncorr){
    global $conexion;
    global $bd;
    
	$objResponse = new xajaxResponse('UTF8');
	
	$tbl =	'alumnos';
	$bd	= 'gescolcl_arcoiris_administracion';
	
	$objResponse->addAssign("txtNcorr", "value", $ncorr);
	
	if ($tbl == 'trabajadores_tienen_cargas'){
		$bd = 'sggeneral';
		$tbl = 'trabajadores_tienen_cargas';
		}
	//busca el campo clave
	$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC LIMIT 1";
	$res_cc = mysql_query($sql_cc,$conexion);
	$campo_clave = @mysql_result($res_cc,0,"campo_clave");
	
	// busca los campos de la tabla
	$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC";
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
		$largo_campos = strlen($campos);
		$campos = substr($campos,0,$largo_campos - 1);
		
		$sql = "select $campos from $bd.$tbl where NumeroRutAlumno = '".$ncorr."'";
		//$objResponse->addAlert($sql);
		if ($tbl=='Asignaturas'){
			$arr_campos = explode("_", $ncorr);
			$sql = "select $campos 
					from $bd.$tbl 
					where CodigoCurso in (select CodigoCurso 
											from Cursos 
											where NombreCurso = '".$arr_campos[0]."') and 
							CodigoRamo in (select CodigoRamo 
											from Ramos 
											where Descripcion = '".$arr_campos[1]."') and 
							Profesor in (select NumeroRutProfesor 
											from Profesores 
											where concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) = '".$arr_campos[2]."')";
			
			}
		//$objResponse->addScript("alert('$j $campos')");
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$i = 0;
			//while ($line = mysql_fetch_row($res)) {
			$line = mysql_fetch_row($res);
			while ($i < $j) {
				$objeto  = 	"OBLI".$arrCampos[$i];
				$arr_1 = array();
				if ((strlen($line[$i])==10)&&($line[$i][4]=='-')&&($line[$i][7]=='-')){
					list($anio1,$mes1,$dia1) = explode('-', $line[$i]);
					$valor_campo 	= $dia1."/".$mes1."/".$anio1;
					$objResponse->addAssign("$objeto", "value", $valor_campo);
					}
				elseif ($objeto=='OBLIrut_carga'){
					$valor_campo = $line[$i];
					$objResponse->addAssign("$objeto", "value", $valor_campo.'-'.dv($valor_campo));
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
					else{
						$objResponse->addAssign("$objeto", "value", $line[$i]);
						}
					}
				$i++;
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
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("GuardarWhere");
$xajax->registerFunction("CargaListado_alumnos_Notas");
$xajax->registerFunction("CargaListado_alumnos_HojaVida");
$xajax->registerFunction("CargaListado_alumnos_Asistencia");
$xajax->registerFunction("CargaListado_alumnos_Apoderado");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

// busca el titulo de la tabla
$sql = "select mant_titulo from mantenedores where mant_tabla = '".$_GET['tbl']."'";
$res = mysql_query($sql,$conexion);
$tbl = $_GET['tbl'];
if (($tbl == 'alumnos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
	
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
		if (substr($line[1],0,3) == 'CBO'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"SELECT";
 		}	
		elseif (substr($line[1],0,3) == 'fch'){
			$titulo	=	trim(substr($line[1],3));
			$objeto	=	"FECHA";
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
 		}elseif (substr($line[1],0,4) == 'foto'){
			$titulo	=	trim(substr($line[1],4));
			$objeto	=	"FOTO";
 		}elseif (substr($line[1],0,5) == 'busca'){
			$titulo	=	trim(substr($line[1],5));
			$objeto	=	"BUSCA";
			}
		array_push($arrCampos, array("campo" => $line[0], "titulo" => $titulo, "objeto" => $objeto));
	}
}

$miSmarty->assign('TABLA', $_GET['tbl']);
$miSmarty->assign('rut_trab', $_GET['rut']);
$miSmarty->assign('rut_alumno', $_GET['rut_alumno']);
$miSmarty->assign('rut', $_GET['rut']."-".dv($_GET['rut']));
$miSmarty->assign('TITULO_TABLA', @mysql_result($res,0,"mant_titulo"));
$miSmarty->assign('arrCampos', $arrCampos);

$miSmarty->assign('pagina_volver',$_SESSION["alycar_pagina_volver"]);
if ($_SESSION['alycar_volver'] =='si'){
	$miSmarty->assign('volver',$_SESSION['alycar_volver']);
	$_SESSION['alycar_volver'] = 'no';
	}

$miSmarty->display('sg_mant_tablas_alumnos.tpl');
ob_flush();
?>

