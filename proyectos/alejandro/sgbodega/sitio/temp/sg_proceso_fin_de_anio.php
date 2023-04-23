<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_proceso_fin_de_anio.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data,$CodigoCurso){
	global $conexion;
	global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	$curso  = $CodigoCurso;
    $anio 	= $_SESSION["sige_anio_escolar_vigente"];
	
    $sql_verificar = "SELECT NombreCurso
    					FROM `SituacionFinal` 
    						inner join Cursos
    							on Cursos.CodigoCurso = SituacionFinal.CodigoCurso
    					where Cursos.CodigoCurso = '".$CodigoCurso."' and 
    							AnoAcademico = '".$anio."' ";
    $res_verificar = mysql_query($sql_verificar,$conexion) or die(mysql_error());

    if (mysql_num_rows($res_verificar)>0){
    	
    	$sql_ver = "SELECT NombreCurso
    					From Cursos
    					where Cursos.CodigoCurso = '".$CodigoCurso."' ";
		$res_ver = mysql_query($sql_ver,$conexion) or die(mysql_error());
		$row_ver = mysql_fetch_array($res_ver);
    	$objResponse->addScript("var msj =  confirm('IMPORTANTE - REPROCESO DE CIERRE DE CURSO - Recuerde que debe revisar y actualizar la SITUACION FINAL de cada alumno');
    			if (msj) xajax_GrabarSF(xajax.getFormValues('Form1'),'".$CodigoCurso."');");

    	}
    else{
    	$sql_ver = "SELECT NombreCurso
    					From Cursos
    					where Cursos.CodigoCurso = '".$CodigoCurso."' ";
		$res_ver = mysql_query($sql_ver,$conexion) or die(mysql_error());
		$row_ver = mysql_fetch_array($res_ver);
    	$objResponse->addScript("var msj =  confirm('PROCESO DE CIERRE DE CURSO - Curso: ".$row_ver['NombreCurso']." - Proceso: ".$anio." - Recuerde revisar SITUACION FINAL de cada alumno');
    			if (msj) xajax_GrabarSF(xajax.getFormValues('Form1'),'".$CodigoCurso."');");

    	}

	return $objResponse->getXML();
	}

function GrabarSF($data,$CodigoCurso){
	global $conexion;
	global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	$curso  = $CodigoCurso;
    $anio 	= $_SESSION["sige_anio_escolar_vigente"];
	
	$sql_verificar = "SELECT NombreCurso
    					FROM `SituacionFinal` 
    						inner join Cursos
    							on Cursos.CodigoCurso = SituacionFinal.CodigoCurso
    					where Cursos.CodigoCurso = '".$CodigoCurso."' and 
    							AnoAcademico = '".$anio."' ";
    $res_verificar = mysql_query($sql_verificar,$conexion) or die(mysql_error());

    if (mysql_num_rows($res_verificar)>0){
    	
    	$sql_borrar = "delete from `SituacionFinal` 
    					where CodigoCurso = '".$CodigoCurso."' and 
    							AnoAcademico = '".$anio."' ";
    	$res_borrar = mysql_query($sql_borrar,$conexion);

		$sql_nfa = "delete	FROM `NotasFinalesAsignaturas` 
						WHERE CodigoCurso = '".$CodigoCurso."' and
								AnoAcademico = '".$anio."' ";
		$res_nfa = mysql_query($sql_nfa,$conexion);

		}

    //Obtener alumnos del curso
	$sql_pd = "select 
				distinct
				alumnos".$anio.".NumeroRutAlumno,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				Matriculado
				from Cursos
					inner join alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

				where
					Cursos.CodigoCurso = '".$CodigoCurso."' and alumnos".$anio.".Matriculado in ('1') 
					"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	while ($row_alumnos = mysql_fetch_array($res_pd)){
		//sacar promedio final alumno
		$rut = $row_alumnos['NumeroRutAlumno'];
		$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
							alumnos".$anio.".NumeroRutAlumno, Asignaturas.CodigoRamo, Cursos.CodigoCurso, 
							NroLista as NumeroLista, Pruebas.CoeficientePrueba, Ramos.Descripcion,
							SexoAlumno
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso and 
							Asignaturas.CalculaPromedio = '0'
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 
					inner join Pruebas
						on  Pruebas.CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where
				Cursos.CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )and 
				Pruebas.prueba_ncorr in (select prueba_ncorr  
											from Pruebas 
											where CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )  and
												AnoAcademico = '".$anio."' and 
												Semestre = '1' 
											) 
				and alumnos".$anio.".NumeroRutAlumno = '".$rut."' 
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista
				order by Asignaturas.NumeroOrden, NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";
		$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());
		//$objResponse->addAlert($sql_ve);
		$promedio_1 = 0;
		$promedio_2 = 0;
		$i = 1;
		$nro_lista_alumno = "";
		$sexo_alumno = "";

		$arrRegistros = array();
		$arrRegistrosDetalle_1 = array();
		$arrRegistrosDetalle_2 = array();
		$arrRegistrosDetalle_total = array();
		$temp_array = array();

		while ($line_ve = mysql_fetch_row($res_ve)) {
			array_push($arrRegistros, array("item"					=>	$i, 
											"nombre_alumno"			=> 	$line_ve[0], 
											"rut_alumno"			=> 	$line_ve[1],
											"asignatura" 			=> 	$line_ve[2],
											"curso" 				=> 	$line_ve[3],
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nro_lista_alumno"		=> 	$line_ve[4],
											"prueba"				=> 	$prueba,
											"nombre_asignatura"		=> 	$line_ve[6]
											));
			$nro_lista_alumno = $line_ve[4];
			$sexo_alumno = $line_ve[7];
			$i++;
			$j=1;
		    $k=0;
		    $z="";
		    $total = 0;
		    $codigo_ramo = "";
		    $promedio_1 = 0;
		      
			$temp_array = array();
			$temp_array = generaPromedioSemestral($line_ve[1],$line_ve[3], $line_ve[2], $line_ve[5], $anio, 1);

			array_push($arrRegistrosDetalle_1, array("item"			=>	$j, 
													"rut_alumno"			=> 	$temp_array[0]['rut_alumno'], 
													"CodigoRamo"			=>	$temp_array[0]['CodigoRamo'], 
													"nota"					=>	$temp_array[0]['nota'],
													"semestre"				=>	'1'
													));

			$temp_array = array();
			$temp_array = generaPromedioSemestral($line_ve[1],$line_ve[3], $line_ve[2], $line_ve[5], $anio, 2);
			
			array_push($arrRegistrosDetalle_2, array("item"			=>	$j, 
												"rut_alumno"			=> 	$temp_array[0]['rut_alumno'], 
												"CodigoRamo"			=>	$temp_array[0]['CodigoRamo'], 
												"nota"					=>	$temp_array[0]['nota'],
												"semestre"				=>	'2'
												));

				
			}

	$contador_final=0;
	$promedio_final_1 = 0;
	$ramo_echado = array();
	$cant_prom_rojos = 0;
		
	if (($curso=='310')||($curso=='320')||($curso=='330')||($curso=='340')){
		
		array_push($arrRegistros, array("item"					=>	$i, 
											"rut_alumno"			=> 	$rut,
											"asignatura" 			=> 	'ENAT',
											"curso" 				=> 	$CodigoCurso,
											"anio"					=> 	$anio,
											"nombre_asignatura"		=> 	'Ciencias Naturales'
											));

		$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
								from NotasAlumnos
								where CodigoRamo in ('BIO','FIS','QUIM') and 
									  NumeroRutAlumno = '".$rut."' and 
									  AnoAcademico = '".$anio."' and
									  Semestre = '1' and 
									  Nota > 0
								group by Semestre, CodigoCurso, NumeroRutAlumno";
		$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
		$row_nota = mysql_fetch_array($res_notas);
		$row_nota['promedio'] = round($row_nota['promedio'],1,PHP_ROUND_HALF_UP);
		array_push($arrRegistrosDetalle_1, array("item"			=>	$j, 
													"rut_alumno"			=> 	$rut, 
													"CodigoRamo"			=>	'ENAT', 
													"nota"					=>	$row_nota['promedio'],
													"semestre"				=>	$row_nota['Semestre']
													));
		$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
								from NotasAlumnos
								where CodigoRamo in ('BIO','FIS','QUIM') and 
									  NumeroRutAlumno = '".$rut."' and 
									  AnoAcademico = '".$anio."' and
									  Semestre = '2' and 
									  Nota > 0
								group by Semestre, CodigoCurso, NumeroRutAlumno";
		$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
		$row_nota = mysql_fetch_array($res_notas);
		$row_nota['promedio'] = round($row_nota['promedio'],1,PHP_ROUND_HALF_UP);
		array_push($arrRegistrosDetalle_2, array("item"			=>	$j, 
													"rut_alumno"			=> 	$rut, 
													"CodigoRamo"			=>	'ENAT', 
													"nota"					=>	$row_nota['promedio'],
													"semestre"				=>	$row_nota['Semestre']
													));

		}


	for($z=0;$z<count($arrRegistrosDetalle_1);$z++){
		$nota_1 = $arrRegistrosDetalle_1[$z]['nota'];
		$nota_2 = $arrRegistrosDetalle_2[$z]['nota'];
		if (($nota_1>0)&&($nota_2>0)){
			$promedio = round(($arrRegistrosDetalle_1[$z]['nota']+$arrRegistrosDetalle_2[$z]['nota'])/2,1,PHP_ROUND_HALF_UP);
			}
		else{
			$temp = 0;
			if ($nota_1>0){
				$temp = $nota_1;
				}
			else{
				$temp = $nota_2;
				}
			$promedio = round($temp,1,PHP_ROUND_HALF_UP);
	
			}
		
		$sql_condBonif = "select CodigoCurso 
							from alumnos".$anio."
							where BonificacionCondicionada = '1' and 
								NumeroRutAlumno = '".$arrRegistrosDetalle_1[$z]['rut_alumno']."'";
		$res_cond_Bonif = mysql_query($sql_condBonif,$conexion);
		if (mysql_num_rows($res_cond_Bonif)>0){

			}
		else{
			$sql_bonifica = "select bonifica, criterio, bonificacion
													from Asignaturas
													where bonifica = '0' and
														CodigoRamo = '".$arrRegistrosDetalle_1[$z]['CodigoRamo']."' and
														CodigoCurso = '".$CodigoCurso."' 
								";
			$res_bonifica = mysql_query($sql_bonifica,$conexion);
			if (mysql_num_rows($res_bonifica)>0){
				$row_bonifica = mysql_fetch_array($res_bonifica);
				$criterio = $row_bonifica['criterio'];
				$bonificacion = $row_bonifica['bonificacion'];
				if ($promedio>=$criterio){
					$bonificacion = $bonificacion/10;
					$promedio = $promedio+ $bonificacion;
					}
				if ($promedio>'7')$promedio='7';
				}
			}			

		$primer_numero= substr($promedio,0,1);
		if ($primer_numero!='0') {
			$promedio_final_1 += $promedio;
			$contador_final++;
			}

		$sql_nfa = "INSERT INTO `NotasFinalesAsignaturas`(NumeroRutAlumno, `AnoAcademico`, `CodigoCurso`, 
														`CodigoRamo`,`NotaFinalCurso`) 
						VALUES ('".$arrRegistrosDetalle_1[$z]['rut_alumno']."','".$anio."','".$CodigoCurso."',
								'".$arrRegistrosDetalle_1[$z]['CodigoRamo']."','".$promedio."')";
		$res_nfa = mysql_query($sql_nfa,$conexion);

		if (($promedio<4)&&($promedio>=1)){
			array_push($ramo_echado,array(	'ramo'=> $arrRegistrosDetalle_1[$z]['CodigoRamo'],
											'rut_alumno'=> $arrRegistrosDetalle_1[$z]['rut_alumno']));
			}
		}
		
		$promedio_final_1 = $promedio_final_1/$contador_final;

		$p_parcial = round($promedio_final_1,3,PHP_ROUND_HALF_UP);
		$p_temp = round($p_parcial,2,PHP_ROUND_HALF_UP);
		$promedio_final = round($p_temp,1,PHP_ROUND_HALF_UP);

		//sacar inasistencia alumno
		$sql_ve = "select count(FechaInasistencia) as contador
					from Inasistencias
					where NumeroRutAlumno = '".$rut."' and 
						year(FechaInasistencia) = '".$anio."'
					order by FechaInasistencia";
		
		$res_ve = mysql_query($sql_ve, $conexion);
		$row_asistencia = mysql_fetch_array($res_ve);
		$cant_inasistencias = $row_asistencia['contador'];

		$porc_inasis_nominal = '';

		if (($CodigoCurso=='370')||($CodigoCurso=='380')){

			$sql_ve = "select DiasPeriodo as contador
						from Periodos
						where AnoAcademico = '".$anio."' and Semestre = '1'
						";
			$res_ve = mysql_query($sql_ve, $conexion);	
			$line_ve = mysql_fetch_row($res_ve);

			$DiasPeriodo = $line_ve[0];

			$sql_ve = "select DiasPeriodo4medio as contador
						from Periodos
						where AnoAcademico = '".$anio."' and Semestre = '2'
						";
			
			$res_ve = mysql_query($sql_ve, $conexion);	
			$line_ve = mysql_fetch_row($res_ve);

			$DiasPeriodo4medio = $line_ve[0];

			$sum = $DiasPeriodo + $DiasPeriodo4medio;

			$porc_inasis_nominal = 100 - round(($cant_inasistencias*100)/$sum,2);

			}
		else{

			$sql_ve = "select sum(DiasPeriodo) as contador
						from Periodos
						where AnoAcademico = '".$anio."'
						";
			
			$res_ve = mysql_query($sql_ve, $conexion);	
			$line_ve = mysql_fetch_row($res_ve);

			$sum  = $line_ve[0];
			$porc_inasis_nominal = 100 - round(($cant_inasistencias*100)/$line_ve[0],2);
	
			}

		$aprobado = '0';
		$observacion_sf = '';
		$cant_prom_rojos = count($ramo_echado);
		$cant_prom_rojos_alumno = '0';
			
		$flag_cond_1 = $flag_cond_2 = $flag_cond_3 = $flag_cond_4 = $flag_cond_5 = $flag_cond_6 = '0';
		

		if ($porc_inasis_nominal>='85'){
			$aprobado = '1';
			$observacion_sf = '';
			//alumno tiene promedio superior a 4
				if ($promedio_final >= '4'){
					// preguntar si tiene rojo
						foreach ($ramo_echado as $key) {
							$rut_alumno = $key['rut_alumno'];
							$ramo = $key['ramo'];
							if ($rut_alumno == $rut){
								if (($ramo == 'EMA2')||($ramo=='LCC')){
									$flag_cond_1 = '1';
									}
								//si tiene -> saber cuantos
								$cant_prom_rojos_alumno++;
								}
							}
									
						// si es 1 
						if ($cant_prom_rojos_alumno=='1'){
							//preguntar si su promedio es igual o mayor a 4.5
							if ($promedio_final>='4.5'){
								// si es asi
								if (($CodigoCurso=='110')||($CodigoCurso=='120')||($CodigoCurso=='150')||($CodigoCurso=='160')){
									//si es de basica 1
									//aprobado
									//art
									$aprobado = '1';
									$observacion_sf = 'Articulo 1, Letra B';
									}
								if (($CodigoCurso=='130')||($CodigoCurso=='140')||($CodigoCurso=='170')||($CodigoCurso=='180')||
									($CodigoCurso=='190')||($CodigoCurso=='200')||($CodigoCurso=='210')||($CodigoCurso=='220')||
									($CodigoCurso=='230')||($CodigoCurso=='240')||($CodigoCurso=='250')||($CodigoCurso=='260')){
									//si es de basica 2
									//aprobado
									//art
									$aprobado = '1';
									$observacion_sf = 'Articulo 1, Letra B';
									}
								if (($CodigoCurso=='310')||($CodigoCurso=='320')||($CodigoCurso=='330')||($CodigoCurso=='340')){
									//si es de media 1
									//aprobado
									//art
									$aprobado = '1';
									$observacion_sf ='Articulo 8, letra B';
									}
								if (($CodigoCurso=='350')||($CodigoCurso=='360')||($CodigoCurso=='370')||($CodigoCurso=='380')){
									//si es de media 2
									//aprobado
									//art
									$observacion_sf ='Articulo 5, letra B';
									$aprobado = '1';
									}
								}
							else{
								//sino 
								//no pasa
								$aprobado = '0';
								$observacion_sf = '';
								}
							}
						elseif ($cant_prom_rojos_alumno=='2'){
									
							//si son 2
								//si es de basica 1, basica 2, media 1
								if (($CodigoCurso=='110')||($CodigoCurso=='120')||($CodigoCurso=='150')||($CodigoCurso=='160')||
									($CodigoCurso=='130')||($CodigoCurso=='140')||($CodigoCurso=='170')||($CodigoCurso=='180')||
									($CodigoCurso=='190')||($CodigoCurso=='200')||($CodigoCurso=='210')||($CodigoCurso=='220')||
									($CodigoCurso=='230')||($CodigoCurso=='240')||($CodigoCurso=='250')||($CodigoCurso=='260')||
									($CodigoCurso=='310')||($CodigoCurso=='320')||($CodigoCurso=='330')||($CodigoCurso=='340')){
									//preguntar si tiene prom mayot o igual a 5
									if ($promedio_final>='5'){
										//si es asi
											//aprobado
											//art
										if (($CodigoCurso=='110')||($CodigoCurso=='120')||($CodigoCurso=='150')||($CodigoCurso=='160')||
											($CodigoCurso=='130')||($CodigoCurso=='140')||($CodigoCurso=='170')||($CodigoCurso=='180')||
											($CodigoCurso=='190')||($CodigoCurso=='200')||($CodigoCurso=='210')||($CodigoCurso=='220')||
											($CodigoCurso=='230')||($CodigoCurso=='240')||($CodigoCurso=='250')||($CodigoCurso=='260')){
												$aprobado= '1';
												$observacion_sf = 'Articulo 11, Letra C';
											}
										else{
												$aprobado= '1';
												$observacion_sf = 'Articulo 8, Letra C';
											}
										}
									else{
										$aprobado= '0';
										$observacion_sf = '';
										}
									}
								else{
									//si es media 2
										//verificar si ramo echado es EMAT2 o LCC
										if ($flag_cond_1=='1'){
											//si es asi
												//preguntar si rtiene promedio mayor o igual a5.5
													//si es asi
														//aprobado
														//art
													//SINO
														//reprobado
											if ($promedio_final>='5.5'){
												$aprobado= '1';
												$observacion_sf = 'Articulo 5, Letra C';
											}
											else{
												$aprobado= '0';
												$observacion_sf = '';
											}
										}
										else{
											//sino
												//preguntar si rtiene promedio mayor o igual a 5
													//si es asi
														//aprobado
														//art
													//SINO
														//reprobado	
											if ($promedio_final>='5'){
												$aprobado= '1';
												$observacion_sf = 'Articulo 5, Letra C';
											}
											else{
												$aprobado= '0';
												$observacion_sf = '';
											}
										}
									}

							}
						else{
							//sino 
								//aprobado
							$aprobado = '1';
							$observacion_sf = '';
							}		
						}
					else{
						$aprobado='0';
						$observacion_sf = '';
						}

			}
		else{
			if (($CodigoCurso=='110')||($CodigoCurso=='120')||($CodigoCurso=='150')||($CodigoCurso=='160')){
				//si es de basica 1
				//aprobado
				//art
				$aprobado = '0';
				$observacion_sf = 'Decreto 107, Articulo 10';
				}
			if (($CodigoCurso=='130')||($CodigoCurso=='140')||($CodigoCurso=='170')||($CodigoCurso=='180')||
				($CodigoCurso=='190')||($CodigoCurso=='200')||($CodigoCurso=='210')||($CodigoCurso=='220')||
				($CodigoCurso=='230')||($CodigoCurso=='240')||($CodigoCurso=='250')||($CodigoCurso=='260')){
				//si es de basica 2
				//aprobado
				//art
				$aprobado = '0';
				$observacion_sf = 'Articulo 11, N° 2';
				}
			if (($CodigoCurso=='310')||($CodigoCurso=='320')||($CodigoCurso=='330')||($CodigoCurso=='340')){
				//si es de media 1
				//aprobado
				//art
				$aprobado = '0';
				$observacion_sf ='Articulo 8, N° 2';
				}
			if (($CodigoCurso=='350')||($CodigoCurso=='360')||($CodigoCurso=='370')||($CodigoCurso=='380')){
				//si es de media 2
				//aprobado
				//art
				$observacion_sf ='Articulo 5, letra C';
				$aprobado = '0';
				}
			}

		unset($ramo_echado);

		$sql_fr = "select FechaRetiro 
					from Matriculas
					where NumeroRutAlumno = '".$rut."'
						and Anio = '".$anio."'";
		$res_fr = mysql_query($sql_fr,$conexion);
		$row_fr = mysql_fetch_array($res_fr);

		if ($row_fr['FechaRetiro']!='0000-00-00'){
			$aprobado='2';
			$observacion_sf = $row_fr['FechaRetiro'];
			}
 		if ($CodigoCurso<'100'){
			$aprobado = '1';
			$observacion_sf = '';
			}

		$sql_insert = "INSERT INTO `SituacionFinal`(`NumeroRutAlumno`, `AnoAcademico`, `Situacion`, `ObservacionSituacion`	,
													`PromedioAno`, `AsistenciaAno`, `CodigoCurso`, 
													`SexoAlumno`, `NumeroLista`, `CodigoUsuario`) 
						VALUES ('".$rut."','".$anio."','".$aprobado."','".$observacion_sf."',
								'".$promedio_final."','".$porc_inasis_nominal."','".$CodigoCurso."',
								'".$sexo_alumno."','".$nro_lista_alumno."','".$_SESSION['alycar_usuario']."')";
		$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

		}

		
	$objResponse->addAlert('Accion Realizada');
		
	$objResponse->addScript("xajax_CargaPagina(xajax.getFormValues('Form1'))");

	return $objResponse->getXML();
	}

function CargaPagina($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql_pd = "select 
				distinct
				Cursos.CodigoCurso,
				Cursos.NombreCurso,
				Cursos.SituacionFinal
				from Cursos
				where
					Cursos.CodigoCurso <= '380'"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {

			$sql_sf = "select * 
						from SituacionFinal 
						where CodigoCurso = '".$line_pd[0]."' and 
							AnoAcademico = '".$_SESSION["sige_anio_escolar_vigente"]."'";
			$res_sf = mysql_query($sql_sf,$conexion);
			$situacion = '';
			if (mysql_num_rows($res_sf)>0){
				$situacion = '1';
				}
			else{
				$situacion = '0';
				}
			
			array_push($arrRegistros, array("item"				=>	$i,
											"curso"				=>	$line_pd[1],
											"codigo_curso"		=>	$line_pd[0],
											"situacion_final"	=>	$line_pd[2],
											"situacion"			=>	$situacion));
			$i++;
                       
		}
		       
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_proceso_fin_de_anio_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	return $objResponse->getXML();
}


$xajax->registerFunction("Grabar");
$xajax->registerFunction("GrabarSF");
$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_proceso_fin_de_anio.tpl');


ob_flush();
?>

