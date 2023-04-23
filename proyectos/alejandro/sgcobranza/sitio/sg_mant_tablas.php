<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_mant_tablas.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	
	global $conexion;
	global $bd;

    $objResponse = new xajaxResponse('UTF8');
	
	$tbl				=	$data["txtTabla"];
	$ncorr				=	$data["txtNcorr"];
	$ingresa 			= 'SI';
	$campos 			= "";
	$values 			= "";


	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Apoderados')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
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
				if (($objeto == 'OBLINumeroRutApoderado')&&($tbl=='Apoderados')){
					$valor_campo = str_replace('undefined', '', $valor_campo);
					}
				if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
                    list($dia1,$mes1,$anio1) = explode('/', $valor_campo);
                    $valor_campo 	= $anio1."-".$mes1."-".$dia1;
                    //$valor_campo 	= $dia1."-".$mes1."-".$anio1; 
                    }
				elseif ((strlen($valor_campo)==10)&&($valor_campo[7]=='-')){
					$arr_rut = explode('-',$valor_campo);
					$valor_campo_1 = explode('.',$arr_rut[0]);
					$valor_campo = $valor_campo_1[0].$valor_campo_1[1].$valor_campo_1[2];
					}
				$values .= "'".$valor_campo."',";
			}
			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			$campos = $campos.")";
			
			$largo_values = strlen($values);
			$values = substr($values,0,$largo_values - 1);
			$values = $values.")";
			if ($tbl=='Bitacoras'){
				list($d,$m,$a) = explode('/',$data['OBLIFechaBitacora']);
				list($d1,$m1,$a1) = explode('/',$data['OBLIFechaCompromiso']);
				$str_time_1 = strtotime($a.'-'.$m.'-'.$d);
				$str_time_2 = strtotime($a1.'-'.$m1.'-'.$d1);
				if($data['OBLIFechaCompromiso']!='00/00/0000'){
					if($str_time_1<=$str_time_2){

					}
					else{
						$objResponse->addScript("alert('Fecha Compromiso debe ser mayor Fecha Entrevista')");
	 					$ingresa = 'NO';
					}
				}
			}
			$sql .= $campos." values (".$values;
			if($ingresa!='NO'){
				$res = mysql_query($sql,$conexion);
					if (mysql_errno($conexion)) { 
	 					$error = mysql_errno($conexion); 
	 					if ($error == '1062')
	 					{
	 					$objResponse->addScript("alert('Registro Duplicado.')");
	 					$ingresa = 'NO';
						}
 					}
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
					if (($objeto == 'OBLINumeroRutApoderado')&&($tbl=='Apoderados')){
						$valor_campo = str_replace('undefined', '', $valor_campo);
						}
					
					if ((strlen($valor_campo)==10)&&($valor_campo[2]=='/')&&($valor_campo[5]=='/')){
						list($dia1,$mes1,$anio1) = explode('/', $valor_campo);
						$valor_campo 	= $anio1."-".$mes1."-".$dia1;
						}
					elseif ((strlen($valor_campo)==10)&&($valor_campo[7]=='-')){
						$arr_rut = explode('-',$valor_campo);
						$valor_campo_1 = explode('.',$arr_rut[0]);
						$valor_campo = $valor_campo_1[0].$valor_campo_1[1].$valor_campo_1[2];
						}
					if($objeto == 'OBLIEstadoBoleta'){
	                    //$campos .= " EstadoBoleta = '".$valor_campo."',";
						if ($valor_campo=='2'){
							$sql_nro_boleta = " select DescripcionBoleta, ValorBoleta, PeriodoMovimiento
													from gescolcl_arcoiris_administracion.Movimientos
													where NumeroBoleta in (select NumeroBoleta 
															from gescolcl_arcoiris_administracion.Movimientos
															where mov_ncorr = '".$ncorr."')";
							$res_nro_boleta = mysql_query($sql_nro_boleta,$conexion) or die(mysql_error());
							while($row_nro_boleta = mysql_fetch_array($res_nro_boleta)){
								$arr_movim = explode(' ',$row_nro_boleta['DescripcionBoleta']);
								$row_nro_boleta['DescripcionBoleta'];
								$CodigoItem = '';
								$NumeroCuota = $arr_movim[3];
								if ($arr_movim[2]=='Incorporacion'){
									$CodigoItem = '1';
									}
								else{
									$CodigoItem = '2';
									}
								$alumno = $data['OBLINumeroRutAlumno'];
							
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$row_nro_boleta['PeriodoMovimiento']."
												set  ValorPagado = ValorPagado - ".$row_nro_boleta['ValorBoleta']."
												where NumeroRutAlumno = '".$alumno."' and
														NumeroCuota = '".$NumeroCuota."' and
														CodigoItem = '".$CodigoItem."'  ";
								$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								}
							}
						else{
							$sql_nro_boleta = " select DescripcionBoleta, ValorBoleta, PeriodoMovimiento
													from gescolcl_arcoiris_administracion.Movimientos
													where NumeroBoleta in (select NumeroBoleta 
															from gescolcl_arcoiris_administracion.Movimientos
															where mov_ncorr = '".$ncorr."')";
							$res_nro_boleta = mysql_query($sql_nro_boleta,$conexion) or die(mysql_error());
							while($row_nro_boleta = mysql_fetch_array($res_nro_boleta)){
								$arr_movim = explode(' ',$row_nro_boleta['DescripcionBoleta']);
								$row_nro_boleta['DescripcionBoleta'];
								$CodigoItem = '';
								$NumeroCuota = $arr_movim[3];
								if ($arr_movim[2]=='Incorporacion'){
									$CodigoItem = '1';
									}
								else{
									$CodigoItem = '2';
									}
								$alumno = $data['OBLINumeroRutAlumno'];
							
								$sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$row_nro_boleta['PeriodoMovimiento']."
												set  ValorPagado = ValorPagado + ".$row_nro_boleta['ValorBoleta']."
												where NumeroRutAlumno = '".$alumno."' and
														NumeroCuota = '".$NumeroCuota."' and
														CodigoItem = '".$CodigoItem."'  ";
								$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
								}
							
							}
						}
					if($objeto!=''){
						$campos .= $line[0]." = '".$valor_campo."',";
	                    }
				}
			}
			$largo_campos = strlen($campos);
			$campos = substr($campos,0,$largo_campos - 1);
			//echo $tbl;
			if($tbl=='Movimientos'){
				$sql_nb = "select NumeroBoleta from gescolcl_arcoiris_administracion.Movimientos where mov_ncorr = '".$ncorr."'";
				$res_nb = mysql_query($sql_nb,$conexion);
				$row_nb = mysql_fetch_array($res_nb);
				$campos = $campos." where NumeroBoleta = '".$row_nb['NumeroBoleta']."'";
				}
			else{
				$campos = $campos." where ".$campo_clave." = '".$ncorr."'";
				}

			$sql .= $campos;
			if ($tbl=='Bitacoras'){
				list($d,$m,$a) = explode('/',$data['OBLIFechaBitacora']);
				list($d1,$m1,$a1) = explode('/',$data['OBLIFechaCompromiso']);
				$str_time_1 = strtotime($a.'-'.$m.'-'.$d);
				$str_time_2 = strtotime($a1.'-'.$m1.'-'.$d1);
				if($data['OBLIFechaCompromiso']!='00/00/0000'){
					if($str_time_1<=$str_time_2){

					}
					else{
						$objResponse->addScript("alert('Fecha Compromiso debe ser mayor Fecha Entrevista')");
	 					$ingresa = 'NO';
					}
				}
			}
			if($ingresa!='NO'){
				$res = mysql_query($sql,$conexion);
					if (mysql_errno($conexion)) { 
	 					$error = mysql_errno($conexion); 
	 					if ($error == '1062')
	 					{
	 					$objResponse->addScript("alert('Registro Duplicado.')");
	 					$ingresa = 'NO';
						}
 					}
 				}
			}
		}
	
		if ($ingresa=='SI'){
			$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
		}
	$objResponse->addScript("document.Form1.submit();");

	return $objResponse->getXML();
}
function CargaListado($data,$select,$tabla){
    global $conexion;
    global $bd;
	global $miSmarty;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$tbl	=	$data["txtTabla"];
	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}// busca los campos de la tabla
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
		//$objResponse->addAlert(substr($resultado_1.','.$select,2,strlen($resultado_1.','.$select)));
		$arr_resultado = explode(',',substr($resultado_1.','.$select,2,strlen($resultado_1.','.$select)));
		$resultado = "";
		$codigo="";
		if ($tbl =='Cursos'){
			if ($data['anio_elegir'] == $_SESSION['sige_anio_escolar_vigente']){
				}
			elseif ($data['anio_elegir'] != $_SESSION['sige_anio_escolar_vigente']){
				$tbl = $tbl.$data['anio_elegir'];
				}
			//$objResponse->AddAlert($tbl);
			for($i=0; $i<count($arr_resultado) ; $i++){
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
		elseif ($tbl =='Movimientos'){
			for($i=0; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if ($data[$codigo]!=''){
					if($codigo == 'OBLINumeroBoleta'){
						$resultado .= " and NumeroBoleta = '".$data[$codigo]."' ";
						}
					elseif($codigo == 'OBLIFechaBoleta'){
						list($dia,$mes,$anio) = explode('/',$data[$codigo]);
						$resultado .= " and FechaBoleta = '".$anio.'-'.$mes.'-'.$dia."' ";
						}
					elseif($codigo == 'OBLINumeroRutAlumno'){
						$resultado .= " and NumeroRutAlumno = '".$data[$codigo]."' ";
						}
					elseif($codigo == 'OBLITipoPagoBoleta'){
						$resultado .= " and TipoPagoBoleta = '".$data[$codigo]."' ";
						}
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
		elseif ($tbl=='Asignaturas'){
			for($i=0; $i<count($arr_resultado) ; $i++){
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
	    elseif (($tbl=='Apoderados')){
			for($i=0; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLIPaternoApoderado'){
					$resultado .= "  and  PaternoApoderado = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLIMaternoApoderado'){
					$resultado .= "  and  MaternoApoderado = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLINombresApoderado'){
					$resultado .= "  and  NombresApoderado = '".$data[$codigo]."' ";
					}
				} 
			$codigo = $select;
			if($select == 'OBLIPaternoApoderado'){
				$resultado .= " and PaternoApoderado = '".$data[$select]."' ";
				}
			elseif($select == 'OBLIMaternoApoderado'){
				$resultado .= " and MaternoApoderado = '".$data[$select]."' ";
				}
			elseif($select == 'OBLINombresApoderado'){
				$resultado .= " and NombresApoderado = '".$data[$select]."' ";
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
			for($i=0; $i<count($arr_resultado) ; $i++){
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
	    elseif ($tbl=='Becas'){
			for($i=0; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLINumeroRutAlumno'){
					$resultado .= "  and  NumeroRutAlumno = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLICodigoTipoBeca'){
					$resultado .= "  and  CodigoTipoBeca = '".$data[$codigo]."' ";
					}
				elseif($codigo == 'OBLICodigoCurso'){
					$resultado .= "  and  NumeroRutAlumno in (select NumeroRutAlumno 
																from gescolcl_arcoiris_administracion.alumnos 
																where CodigoCurso = '".$data[$codigo]."' )";
					}
				elseif($codigo == 'OBLIPeriodoBeca'){
					$resultado .= "  and  PeriodoBeca = '".$data[$codigo]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLINumeroRutAlumno'){
				$resultado .= "  and  NumeroRutAlumno = '".$data[$select]."' ";
				}
			
			elseif($select == 'OBLICodigoTipoBeca'){
				$resultado .= "  and  CodigoTipoBeca = '".$data[$select]."' ";
				}
			elseif($select == 'OBLICodigoCurso'){
				$resultado .= "  and  NumeroRutAlumno in (select NumeroRutAlumno 
															from gescolcl_arcoiris_administracion.alumnos 
															where CodigoCurso = '".$data[$select]."' )";
				}
			elseif($select == 'OBLIPeriodoBeca'){
				$resultado .= "  and  PeriodoBeca = '".$data[$select]."' ";
				}
			
			}
	    elseif ($tbl=='TipoBeca'){
			for($i=0; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLIPeriodo'){
					$resultado .= "  and  Periodo = '".$data[$select]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLIPeriodo'){
				$resultado .= "  and  Periodo = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='Aranceles'){
			for($i=0; $i<count($arr_resultado) ; $i++){
				$codigo = $arr_resultado[$i];
				if($codigo == 'OBLIAnioPeriodo'){
					$resultado .= "  and  AnioPeriodo = '".$data[$select]."' ";
					}
				}
			$codigo = $select;
			if($select == 'OBLIAnioPeriodo'){
				$resultado .= "  and  AnioPeriodo = '".$data[$select]."' ";
				}
			}
		elseif ($tbl=='HojasDeVida'){
			for($i=0; $i<count($arr_resultado) ; $i++){
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
		elseif ($tbl=='Compromisos'){
			for($$i=0; $i<count($arr_resultado) ; $i++){
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
			for($i=0; $i<count($arr_resultado) ; $i++){
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
		if ($tbl=='Apoderados'){
			$resultado .= " order by NumeroRutApoderado"; 
			}
		if (($tbl=='usuarios_perfiles_menu')){
			$sql .= " order by menu_ncorr, upme_orden"; 
			}
		$sql = "select $campos from $bd.$tbl where 1 $resultado";
		if ($tbl=='Movimientos'){
			$sql = "select $campos 
					from $bd.$tbl 
					where 1 $resultado
					group by NumeroBoleta";
			}
		if ($tbl=='Bitacoras'){
			$sql_002 = "select concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as pool, NumeroRutApoderado
										from gescolcl_arcoiris_administracion.Apoderados 
										where NumeroRutApoderado  in  (select NumeroRutApoderado 
																		from gescolcl_arcoiris_administracion.alumnos".$_SESSION['sige_anio_escolar_vigente']." 
																		where NumeroRutAlumno = '".$data['rut_alumno_bitacora']."' )";
			$res_002 = mysql_query($sql_002, $conexion) or die(mysql_error());
			$row_002 = mysql_fetch_array($res_002);
                     

            $objResponse->addAssign("OBLINumeroRutApoderado", "value", $row_002['NumeroRutApoderado']);
            $objResponse->addAssign("BSCNumeroRutApoderado", "value", $row_002['pool']);

            $sql = "select $campos
					from $bd.$tbl 
					where 1 $resultado
					and NumeroRutApoderado in  (select NumeroRutApoderado 
												from gescolcl_arcoiris_administracion.alumnos".$_SESSION['sige_anio_escolar_vigente']." 
												where NumeroRutAlumno = '".$data['rut_alumno_bitacora']."' )
					order by FechaBitacora desc, bitacora_ncorr desc";

			}
		//$objResponse->addAlert($sql);
		$sql_1 = "select count('".$campo_cont."') as contador from $bd.$tbl where 1 $resultado";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		$miSmarty->assign('cant_filas',$row_1['contador']);
			if ((($tbl!='HojasDeVida')&&($tbl!='Pruebas')&&($tbl!='Movimientos')&&($resultado==''))||($resultado!='')){ 
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
															"rut"				=>	$line[34]));
						}elseif ($tbl == "Compromisos"){ 
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
										from gescolcl_arcoiris_administracion.alumnos 
										where NumeroRutAlumno  = '".$line[2]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
                                            
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"fecha"       	=> 	$line[1], 
															"alumno"		=> 	$row_002['pool'], 
															"descripcion"	=> 	$line[6], 
															"periodo"		=> 	$line[8]));
						}elseif ($tbl == "Bitacoras"){ 
							$sql_002 = "select concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as pool
										from gescolcl_arcoiris_administracion.Apoderados 
										where NumeroRutApoderado  = '".$line[1]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);
                            
                            $objResponse->addAssign("OBLINumeroRutApoderado", "value", $line[1]);
                            $objResponse->addAssign("BSCNumeroRutApoderado", "value", $row_002['pool']);
                            
                             
							array_push($arrRegistros, array("ncorr"         =>  $line[0], 
															"fecha"       	=> 	$line[2], 
															"fecha_1"      	=> 	$line[6], 
															"alumno"		=> 	$row_002['pool'], 
															"descripcion"	=> 	$line[4]));
						}elseif ($tbl == "Movimientos"){  
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool
										from gescolcl_arcoiris_administracion.alumnos".$_SESSION['sige_anio_escolar_vigente']."
										where NumeroRutAlumno  = '".$line[3]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);

							$sql_ff = "select nombre
									   from gescolcl_arcoiris_administracion.EstadoBoleta
									   where eb_ncorr = ".$line[5];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);

							$sql_aa = "select nombre
									   from gescolcl_arcoiris_administracion.TipoPagoBoleta
									   where tpb_ncorr = ".$line[6];
							$res_aa = mysql_query($sql_aa, $conexion);
							$row_aa = mysql_fetch_array($res_aa);

							$sql_11 = "select sum(ValorBoleta) as valor
									   from gescolcl_arcoiris_administracion.Movimientos
									   where NumeroBoleta = ".$line[1];
							$res_11 = mysql_query($sql_11, $conexion);
							$row_11 = mysql_fetch_array($res_11);

							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"nro_boleta"   		=> 	$line[1],
															"fecha"   			=> 	$line[2],
															"alumno"   			=> 	$row_002['pool'],
															"valor"   			=> 	$row_11['valor'],
															"estado"   			=> 	$row_ff['nombre'],
															"tipo_pago"   		=> 	$row_aa['nombre'],
															"usuario"   		=> 	$line[7]));
						}elseif ($tbl == "Becas"){  
							$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool, NombreCurso
										from gescolcl_arcoiris_administracion.alumnos
											inner join gescolcl_arcoiris_administracion.Cursos
												on alumnos.CodigoCurso = Cursos.CodigoCurso
										where NumeroRutAlumno  = '".$line[2]."'";
							$res_002 = mysql_query($sql_002, $conexion);
							$row_002 = mysql_fetch_array($res_002);

							$sql_ff = "select NombreTipoBeca, IncorporacionTipoBeca, ColegiaturaTipoBeca
									   from gescolcl_arcoiris_administracion.TipoBeca
									   where CodigoTipoBeca = ".$line[6];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);


							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"alumno"   			=> 	$row_002['pool'],
															"NombreCurso"   	=> 	$row_002['NombreCurso'],
															"periodo"   		=> 	$line[1],
															"incorporacion"		=> 	$row_ff['IncorporacionTipoBeca'],
															"colegiatura"		=> 	$row_ff['ColegiaturaTipoBeca'],
															"tipo_beca"			=> 	$row_ff['NombreTipoBeca']));

						}elseif ($tbl == "TipoBeca"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"descripcion"     		=> 	$line[1],
															"cuota_0"     		=> 	$line[2],
															"colegiatura"     		=> 	$line[3]));
						}elseif ($tbl == "Talonarios"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"desde"     		=> 	$line[1],
															"hasta"     		=> 	$line[2],
															"fecha"     		=> 	$line[3],
															"observacion"     		=> 	$line[4]));
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
															"rut"        		=> 	$line[1].'-'.dv($line[1]),
															"nombre"     		=> 	$line[6], 
															"apellido_paterno"  => 	$line[4], 
															"apellido_materno"  => 	$line[3], 
															"direccion"      	=> 	$line[9], 
															"telefono"      	=> 	$line[9]));
						}elseif ($tbl == "Apoderados"){  
							array_push($arrRegistros, array("ncorr"        		=> 	$line[0],
															"rut"        		=> 	$line[1].'-'.dv($line[1]),
															"nombre"     		=> 	$line[5], 
															"apellido_paterno"  => 	$line[3], 
															"apellido_materno"  => 	$line[4], 
															"direccion"      	=> 	$line[6], 
															"telefono"      	=> 	$line[9]));
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
						}elseif ($tbl == "usuarios_perfiles_menu"){  
							$sql_01 = "select perfil_nombre from gescolcl_cobranza.perfiles where perfil_codigo = '".$line[1]."'";
							$res_01 = mysql_query($sql_01,$conexion);
							$row_01 = mysql_fetch_array($res_01);
							$perfil = $row_01['perfil_nombre'];
							
							$sql_01 = "select menu_desc from gescolcl_cobranza.menues where menu_ncorr = '".$line[2]."'";
							$res_01 = mysql_query($sql_01,$conexion);
							$row_01 = mysql_fetch_array($res_01);
							$menu = $row_01['menu_desc'];
							
							$sql_01 = "select mhij_desc from gescolcl_cobranza.menues_hijos where mhij_ncorr = '".$line[3]."'";
							$res_01 = mysql_query($sql_01,$conexion);
							$row_01 = mysql_fetch_array($res_01);
							$pagina = $row_01['mhij_desc'];
								array_push($arrRegistros, array("ncorr"         =>  $line[0], 
																"perfil"       	=> 	$perfil, 
																"menu"			=> 	$menu, 
																"pagina"		=> 	$pagina, 
																"orden"			=> 	$line[4]));
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
						}elseif ($tbl == "Aranceles"){                                             
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"periodo"       => 	$line[1], 
															"codigo"       => 	$line[2], 
															"nombre"       => 	$line[3], 
															"incorporacion"	=> 	$line[4], 
															"colegiatura"	=> 	$line[5]));
						}elseif ($tbl == "Devoluciones"){                                             
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"numero"       	=> 	$line[1], 
															"fecha"       	=> 	$line[2], 
															"nro_boleta"    => 	$line[4], 
															"monto"			=> 	$line[5], 
															"glosa"			=> 	$line[6]));
						}elseif ($tbl == "Cursos"){                                             
							$sql_ff = "select NombreNivel
															from gescolcl_arcoiris_administracion.Aranceles
															where CodigoNivel = ".$line[2];
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
						
							array_push($arrRegistros, array("ncorr"         =>      $line[0], 
															"codigo"       	=> 	$line[0], 
															"descripcion"	=> 	$line[1], 
															"arancel"		=> 	$row_ff['NombreNivel']));
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
															from gescolcl_cobranza.perfiles
															where perfil_codigo = ".$line[5];
												$res_ff = mysql_query($sql_ff, $conexion);
												$row_ff = mysql_fetch_array($res_ff);
							$sql_gg = "select menu_desc
															from gescolcl_cobranza.menues
															where menu_ncorr = ".$line[1];
												$res_gg = mysql_query($sql_gg, $conexion);
												$row_gg = mysql_fetch_array($res_gg);
							$sql_dd = "select nombre
															from gescolcl_cobranza.sub_menus
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
							array_push($arrRegistros, array("ncorr" => $line[0], "desc"	=> 	($line[1])));
						}
					}
				}	
			}
		$miSmarty->assign('TBL', $tbl);
		$miSmarty->assign('USUARIO',$_SESSION["alycar_usuario"]);

		$sql = "select mant_titulo from mantenedores where mant_tabla = '".$tbl."'";
		$res = mysql_query($sql,$conexion);
		$miSmarty->assign('TITULO_TABLA', utf8_encode(mysql_result($res,0,"mant_titulo")));
		//var_dump( $arrRegistros);
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
	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	$sql_c = "select COLUMN_NAME AS campo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY != 'PRI' order by ORDINAL_POSITION ASC limit 1";
	$res_c = mysql_query($sql_c, $conexion);
	if (mysql_num_rows($res_c) > 0) {
		$objeto  = 	"OBLI".@mysql_result($res_c,0,"campo");
            }	
		//$objResponse->addScript("document.getElementById('$objeto').focus();");
		
        if (($tbl == "Devoluciones")){
       		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItiene_boleta','gescolcl_arcoiris_administracion.sino','','','sino_ncorr', 'nombre', '')");
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
             }
        if (($tbl == "Postulantes")){
			$where  = '"%ADMISION%"';
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','Cursos','','','CodigoCurso', 'NombreCurso', '  where NombreCurso like ".$where." ')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoAlumno','sexo','','','sexo_ncorr', 'nombre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoReligion','Religiones','','','CodigoReligion', 'Religion', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoComuna','Comunas','','','CodigoComuna', 'Comuna', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoIsapre','Isapres','','','CodigoISapre', 'DescripcionISapre', '')");
             }
        if ($tbl == "Profesores"){
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLISexoProfesor','sexo','','','sexo_ncorr', 'nombre', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICiudadProfesor','Ciudades','','','CodigoCiudad', 'Ciudad', '')");
             $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoProfesor','TipoFuncionario','','','tf_ncorr', 'NombreTipoFuncionario', '')");
			} 
		 if ($tbl == "Cursos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio_elegir','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoNivel','gescolcl_arcoiris_administracion.Aranceles','','','CodigoNivel', 'NombreNivel', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICursoPrecede','gescolcl_arcoiris_administracion.Cursos','','','CodigoCurso', 'NombreCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLINivelCurso','gescolcl_arcoiris_administracion.NivelesCurso','','','NivelCurso', 'NombreNivelCurso', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIProfesorJefe','gescolcl_arcoiris_administracion.Profesores','','','NumeroRutProfesor', 'NumeroRutProfesor', '')");
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
		if ($tbl == "Compromisos"){
            }
        if ($tbl == "Apoderados"){
        	$objResponse->addScript("xajax_CargaSelect(xajax.	getFormValues('Form1'),'OBLICiudadParticularApoderado','gescolcl_arcoiris_administracion.Ciudades','','','CodigoCiudad', 'Ciudad', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoParentesco','gescolcl_arcoiris_administracion.Parentescos','','','CodigoParentesco', 'Parentesco', '')");
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
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_sub','gescolcl_cobranza.sub_menus','','','submenu_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImhij_perfil','gescolcl_cobranza.perfiles','','','perfil_codigo', 'perfil_nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLImenu_ncorr','gescolcl_cobranza.menues','','','menu_ncorr', 'menu_desc', '')");
            }
    	if ($tbl == "Movimientos"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIEstadoBoleta','gescolcl_arcoiris_administracion.EstadoBoleta','','','eb_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLITipoPagoBoleta','gescolcl_arcoiris_administracion.TipoPagoBoleta','','','tpb_ncorr', 'nombre', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIPeriodoMovimiento','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
            }
    	if ($tbl == "Becas"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoTipoBeca','gescolcl_arcoiris_administracion.TipoBeca','','','CodigoTipoBeca', 'NombreTipoBeca', '')");
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIPeriodoBeca','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
            $where  = '"%ADMISION%"';
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLICodigoCurso','gescolcl_arcoiris_administracion.Cursos','','','CodigoCurso', 'NombreCurso', '  where NombreCurso not like ".$where." ')");
            }
    	if ($tbl == "TipoBeca"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIPeriodo','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
            }
    	if ($tbl == "Aranceles"){
            $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIAnioPeriodo','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico', 'AnoAcademico', '')");
            }
    $objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$bd = '';
	$tbl =	$data["txtTabla"]; 
	
	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}
	
	$objResponse->addAssign("$select","innerHTML",""); 		
    if ($tabla == 'Profesores'){
		$campo2 = " concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) ";
		} 
	if (($opt=='OBLICodigoCurso')&&($tbl!='Becas')){
		$ramo = $data['OBLICodigoCurso'];
		$curso = $data['OBLICodigoRamo'];
		$opt = 'where NumeroRutProfesor in (select distinct NumeroRutProfesor 
											from gescolcl_arcoiris_administracion.Pruebas 
											where CodigoCurso = "'.$ramo.'" and CodigoRamo = "'.$curso.'")';
		}
	if (($select == 'OBLICodigoRamo')&&($tbl!='Becas')){
			$ramo = $data['OBLICodigoCurso'];
			$opt = 'where CodigoRamo in (select CodigoRamo
			from gescolcl_arcoiris_administracion.Asignaturas
			where CodigoCurso = "'.$ramo.'")';
	}
		
	if ($tabla=='Aranceles'){
		$opt = " where AnioPeriodo = '".$_SESSION["sige_anio_escolar_vigente"]."' ";
		}	

	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	//$objResponse->addAlert($sql); 
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		$j = 0;
		if ($tabla=='gescolcl_arcoiris_administracion.Periodos'){
			$periodo_actual = $_SESSION["sige_anio_escolar_vigente"];
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[0].value", $periodo_actual);
			$objResponse->addAssign("$select","options[0].text", $periodo_actual); 	
			$j++;
			}

		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", ($line[1])); 	
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
	if (($select == 'OBLICodigoCurso')&&($tbl!='Becas')){
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
	
		$objResponse->addScript("confirmacion = confirm('Confirma la Eliminacion del Registro ?');
					if (confirmacion == true) {
						xajax_EliminarItem_1(xajax.getFormValues('Form1'), '$ncorr');
						}
				");
	return $objResponse->getXML();
}

function EliminarItem_1($data, $ncorr){
    global $conexion;
    global $bd;
    
	$objResponse = new xajaxResponse('UTF8');
		
	$tbl =	$data["txtTabla"];
	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
	$bd = 'gescolcl_arcoiris_administracion';
	}
	//busca el campo clave
	$sql_cc = "select COLUMN_NAME AS campo_clave from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' and COLUMN_KEY = 'PRI' order by ORDINAL_POSITION ASC LIMIT 1";
	$res_cc = mysql_query($sql_cc,$conexion);
	$campo_clave = @mysql_result($res_cc,0,"campo_clave");
	
	
	if ($tbl=='Movimientos'){
		
		$sql_nb = "select NumeroBoleta from gescolcl_arcoiris_administracion.Movimientos where $campo_clave = '".$ncorr."'";
		$res_nb = mysql_query($sql_nb,$conexion);
		$row_nb = mysql_fetch_array($res_nb);

		$sql_nro_boleta = "delete from gescolcl_arcoiris_administracion.Movimientos
							where NumeroBoleta = '".$row_nb['NumeroBoleta']."'";
		$res_nro_boleta = mysql_query($sql_nro_boleta,$conexion) or die(mysql_error());
		
		$sql_nro_boleta = " select DescripcionBoleta, ValorBoleta, PeriodoMovimiento, NumeroRutAlumno
								from gescolcl_arcoiris_administracion.Movimientos
								where NumeroBoleta in (select NumeroBoleta 
										from gescolcl_arcoiris_administracion.Movimientos
										where mov_ncorr = '".$ncorr."')";
		$res_nro_boleta = mysql_query($sql_nro_boleta,$conexion) or die(mysql_error());

		while($row_nro_boleta = mysql_fetch_array($res_nro_boleta)){
			$arr_movim = explode(' ',$row_nro_boleta['DescripcionBoleta']);
			$row_nro_boleta['DescripcionBoleta'];
			$CodigoItem = '';
			$NumeroCuota = $arr_movim[3];
			if ($NumeroCuota==0){
				$CodigoItem = '1';
				$NumeroCuota = '1';
				}
			else{
				if ($arr_movim[2]=='Incorporacion'){
					$CodigoItem = '1';
					}
				else{
					$CodigoItem = '2';
					}
				}
			$alumno = $row_nro_boleta['NumeroRutAlumno'];

			echo $sql_update = "update gescolcl_arcoiris_administracion.CuentaCorriente".$row_nro_boleta['PeriodoMovimiento']."
							set  `ValorPagado` = ValorPagado - ".$row_nro_boleta['ValorBoleta']."
							where NumeroRutAlumno = '".$alumno."' and
									NumeroCuota = '".$NumeroCuota."' and
									CodigoItem = '".$CodigoItem."' 
									";
			$res_update = mysql_query($sql_update,$conexion) or die(mysql_error());
			}
		}
	else{
		$sql = "delete from $bd.$tbl where $campo_clave = '".$ncorr."'";
		$res = mysql_query($sql,$conexion);
		}		

	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'),'','')");
	
	return $objResponse->getXML();
}
function TraeValor($data, $ncorr){
    global $conexion;
    global $bd;
    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');
		
	$tbl =	$data["txtTabla"];
	$objResponse->addAssign("txtNcorr", "value", $ncorr);
	if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
		$bd = 'gescolcl_arcoiris_administracion';
	}//busca el campo clave
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
		
		$sql = "select $campos from $bd.$tbl where $campo_clave = '".$ncorr."'";
		if($tbl=='Movimientos'){
			$sql = "select $campos 
					from $bd.$tbl 
					where NumeroBoleta in (select NumeroBoleta from $bd.Movimientos where mov_ncorr = '".$ncorr."')
					order by mov_ncorr asc
					limit 0,1";
			}
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
		//$objResponse->addAlert($sql);
		if (mysql_num_rows($res) > 0){
			$i = 0;
			//while ($line = mysql_fetch_row($res)) {
			$line = mysql_fetch_row($res);
			while ($i < $j) {
				$objeto  = 	"OBLI".$arrCampos[$i];
				$arr_1 = array();
				if ($objeto=='OBLICodigoTipoBeca'){
					$valor_campo = $line[$i];
					$sql_ff = "select NombreTipoBeca, IncorporacionTipoBeca, ColegiaturaTipoBeca
									   from gescolcl_arcoiris_administracion.TipoBeca
									   where CodigoTipoBeca = ".$valor_campo;
							$res_ff = mysql_query($sql_ff, $conexion);
							$row_ff = mysql_fetch_array($res_ff);
					$objResponse->addAssign("beca_incorporacion", "innerHTML", $row_ff['IncorporacionTipoBeca']);
					$objResponse->addAssign("beca_colegiatura", "innerHTML", $row_ff['ColegiaturaTipoBeca']);
					}
				
				if ((strlen($line[$i])==10)&&($line[$i][4]=='-')&&($line[$i][7]=='-')){
					list($anio1,$mes1,$dia1) = explode('-', $line[$i]);
					$valor_campo 	= $dia1."/".$mes1."/".$anio1;
					$objResponse->addAssign("$objeto", "value", $valor_campo);
					}
				elseif ($objeto=='OBLIrut_carga'){
					$valor_campo = $line[$i];
					$objResponse->addAssign("$objeto", "value", $valor_campo.'-'.dv($valor_campo));
					}
				elseif ($objeto=='OBLIDescripcionBoleta'){
					$sql_1 = "	select GROUP_CONCAT(DescripcionBoleta) as DescripcionBoleta
								from  $bd.Movimientos
								where NumeroBoleta in 
								(select NumeroBoleta from $bd.Movimientos where mov_ncorr = '".$ncorr."')";
					$res_1 = mysql_query($sql_1,$conexion);
					$row_1 = mysql_fetch_array($res_1);
					
					$objResponse->addAssign("$objeto", "value", $row_1['DescripcionBoleta']);
					}
				elseif ($objeto=='OBLInro_boleta' && $tbl=='Devoluciones'){
					$objResponse->addAssign("$objeto", "value",  ($line[$i]));
					$sql_a = "SELECT * 
							        FROM gescolcl_arcoiris_administracion.Movimientos
							        WHERE NumeroBoleta = '".$line[$i]."' 
							             ";
					$res_a = mysql_query($sql_a, $conexion);
					if (mysql_num_rows($res_a)>0){
					 	$row_a = mysql_fetch_array($res_a);
					 	$valor_boleta = $row_a['ValorBoleta'];
					 	$vigente = $row_a['EstadoBoleta'] == '1' ? 'vigente' : 'no vigente';
					 	$sql_b = "select concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as str1, 
					 					concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno,' - ',Cursos.NombreCurso) as str2
					 			from gescolcl_arcoiris_administracion.alumnos".$row_a['PeriodoMovimiento']."
					 				inner join gescolcl_arcoiris_administracion.Cursos on gescolcl_arcoiris_administracion.alumnos".$row_a['PeriodoMovimiento'].".CodigoCurso = gescolcl_arcoiris_administracion.Cursos.CodigoCurso
					 				inner join gescolcl_arcoiris_administracion.Apoderados on gescolcl_arcoiris_administracion.Apoderados.NumeroRutApoderado = gescolcl_arcoiris_administracion.alumnos".$row_a['PeriodoMovimiento'].".NumeroRutApoderado
					 			where gescolcl_arcoiris_administracion.alumnos".$row_a['PeriodoMovimiento'].".NumeroRutAlumno = '".$row_a['NumeroRutAlumno']."'	";
					 	$res_b = mysql_query($sql_b, $conexion);
					 	$row_b = mysql_fetch_array($res_b);
					 	$objResponse->addScript("document.getElementById('apoderado_boleta').innerHTML='Apoderado: ".$row_b['str1']."'");	
						$objResponse->addScript("document.getElementById('alumno_boleta').innerHTML='Alumno: ".$row_b['str2']."'");	
					 	$objResponse->addScript("document.getElementById('valor_boleta').innerHTML='Valor: ".$valor_boleta."'");	
					 	$objResponse->addScript("document.getElementById('estado_boleta').innerHTML='Estado: ".$vigente."'");	
						}   
					}
				elseif ($objeto=='OBLIValorBoleta'){
					$sql_1 = "	select sum(ValorBoleta) as suma
								from  $bd.Movimientos
								where NumeroBoleta in 
								(select NumeroBoleta from $bd.Movimientos where mov_ncorr = '".$ncorr."')";
					$res_1 = mysql_query($sql_1,$conexion);
					$row_1 = mysql_fetch_array($res_1);
					
					$objResponse->addAssign("$objeto", "value", $row_1['suma']);
					
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
					elseif($temp=='bus'){
						//20271336
						if (substr($objeto, 4)=='PaternoApoderado'){
							$objResponse->addScript("OBLIPaternoApoderado", "value", $line[$i]);	
							$objResponse->addScript("document.getElementById('BSCPaternoApoderado').value='".$line[$i]."'");	
							}
						elseif (substr($objeto, 4)=='NombresApoderado'){
							$objResponse->addScript("OBLINombresApoderado", "value", $line[$i]);	
							$objResponse->addScript("document.getElementById('BSCNombresApoderado').value='".$line[$i]."'");	
							}
						elseif (substr($objeto, 4)=='NumeroRutAlumno'){
							$sql = "SELECT * 
							        FROM gescolcl_arcoiris_administracion.alumnos
							        WHERE NumeroRutAlumno = '".$line[$i]."' ";
							$res = mysql_query($sql, $conexion);
							$row = mysql_fetch_assoc($res);
							$objResponse->addAssign("BSC".substr($objeto, 4), "value",  ($row['PaternoAlumno'].' '.$row['MaternoAlumno'].' '.$row['NombresAlumno']));
							}
						$objResponse->addAssign("OBLI".substr($objeto, 4), "value", $line[$i]);
						if (($tbl=='Becas')){
							$valor_campo = $line[$i];
							$sql_ff = "select CodigoCurso
											   from gescolcl_arcoiris_administracion.alumnos
											   where NumeroRutAlumno = ".$valor_campo;
									$res_ff = mysql_query($sql_ff, $conexion);
									$row_ff = mysql_fetch_array($res_ff);
							$objResponse->addAssign("OBLICodigoCurso", "value", $row_ff['CodigoCurso']);
							}
						//$objResponse->addAlert($line[$i]);
						}
					else{
						if ($objeto=='OBLINumeroRutApoderado'){
							$objResponse->addScript("document.getElementById('rut_postulante').value='".$line[$i]."-".dv($line[$i])."'");	
							$objResponse->addScript("document.getElementById('OBLINumeroRutApoderado').value='".$line[$i]."'");	
							}
						elseif (($objeto=='OBLICodigoCurso')&&(($tbl=='Becas'))){

							}
						else{
							$objResponse->addAssign("$objeto", "value",  ($line[$i]));
								
							}
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

function CargaListado_Movimientos($data){
    global $conexion;
	$objResponse = new xajaxResponse('UTF8');
	
	$ncorr = $data['txtNcorr'];
	if ($ncorr != ''){
		$objResponse->addScript("showPopWin('sg_movimientos_detalle.php?nro_boleta=".$ncorr."', 'Detalle Movimientos', 700, 280, null);");
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
$xajax->registerFunction("EliminarItem_1");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("GuardarWhere");
$xajax->registerFunction("CargaListado_alumnos_Notas");
$xajax->registerFunction("CargaListado_alumnos_HojaVida");
$xajax->registerFunction("CargaListado_alumnos_Asistencia");
$xajax->registerFunction("CargaListado_Movimientos");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

// busca el titulo de la tabla
$sql = "select mant_titulo from mantenedores where mant_tabla = '".$_GET['tbl']."'";
$res = mysql_query($sql,$conexion);
$tbl = $_GET['tbl'];
if (($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Becas')||($tbl == 'Bitacoras')||($tbl == 'Devoluciones')||($tbl == 'Compromisos')||($tbl == 'Movimientos')||($tbl == 'Talonarios')||($tbl == 'Apoderados')||($tbl == 'Comunas')||($tbl == 'Ciudades')||($tbl == 'Bancos')||($tbl == 'Parentescos')||($tbl == 'Niveles')||($tbl == 'Aranceles')||($tbl == 'Cursos')||($tbl == 'TipoBeca')){
	$bd = 'gescolcl_arcoiris_administracion';
	}
// busca los campos
$sql_c = "select COLUMN_NAME AS campo, COLUMN_COMMENT as titulo from information_schema.COLUMNS where table_schema = '".$bd."' and table_name = '".$tbl."' order by ORDINAL_POSITION ASC";
$res_c = mysql_query($sql_c, $conexion) or die(mysql_error());

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
isset($_GET['rut']) ? $miSmarty->assign('rut_trab', $_GET['rut']) : '';
isset($_GET['volver']) ? $miSmarty->assign('volver', $_GET['volver']) : '';
isset($_GET['rut']) ? $miSmarty->assign('rut', $_GET['rut']."-".dv($_GET['rut'])) : '';
isset($_GET['rut']) ? $miSmarty->assign('rut_alumno_bitacora', $_GET['rut']) : '';
$miSmarty->assign('TITULO_TABLA', @mysql_result($res,0,"mant_titulo"));
$miSmarty->assign('arrCampos', $arrCampos);
$miSmarty->assign('periodo_actual',$_SESSION["sige_anio_escolar_vigente"]);

isset($_GET['alycar_pagina_volver']) ? $miSmarty->assign('pagina_volver',$_SESSION["alycar_pagina_volver"]) : '';

if (isset($_GET['alycar_volver'])  && $_SESSION['alycar_volver'] =='si'){
	$miSmarty->assign('volver',$_SESSION['alycar_volver']);
	$_SESSION['alycar_volver'] = 'no';
	}

$miSmarty->display('sg_mant_tablas.tpl');
ob_flush();
?>