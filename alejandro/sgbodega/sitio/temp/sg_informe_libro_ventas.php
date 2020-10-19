<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_libro_ventas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa		= 	$data["OBLIempresa"];
	$mes			= 	$data["OBLIcboMes"];
	$anio			= 	$data['OBLIcboAnio'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	                
	if ($empresa != '- - Seleccione - -'){
		$and .= " and empresa = '".$empresa."' " ;
	}
	if ($mes != ''){
		$and_1 .= " and mes = '".$mes."' " ;
	}
	if ($anio != ''){
		$and_1 .= " and anio = '".$anio."' " ;
	}
	
	$sql_ab = "select fecha
				from boletas 
				where 1
						".$and." ".$and_1."
				group by fecha
				order by `fecha`";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$arrDetalle = array();
	$arrRegistros = array();
	$arr_resultado = array();
	while ($row_ab	= mysql_fetch_array($res_ab)){
		$fecha = $row_ab['fecha'];
		array_push($arrRegistros, array("fecha"=>$fecha));
		$sql_001 = "select nro_boleta , monto
					from boletas
					where fecha = '".$fecha."'  ".$and." ".$and_1."  
						ORDER BY  `nro_boleta` , fecha ";
		$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
		$i=0;
		$total = 0;
		$arr_nros = array();
		$arr_montos = array();
		while ($row_001 = mysql_fetch_array($res_001)){
			$arr_nros[$i] = $row_001['nro_boleta'];
			$arr_montos[$i] = $row_001['monto'];
			$i++;
			}
		//var_dump($arr_nros);
		$inicio = "";
		$fin = "";
		$monto = 0;
		//var_dump($arr_nros);
		for($j =0;$j<count($arr_nros);$j++){
		 	$temp_1 = $arr_nros[$j];
			$temp_monto_1 = $arr_montos[$j];
			//array_push($arr_resultado, array("fecha"=>$fecha,"inicio"=>$temp_1, "fin"=>"","monto"=>$temp_monto_1));
			$m = $j+1;
			if ($m<count($arr_nros)){
				$temp_2 = $arr_nros[$j+1];
				$temp_monto_2 = $arr_montos[$j+1];
				$temp = $temp_2-$temp_1;
				if ($temp==1){
					if($inicio==""){
						$inicio = $temp_1;
						}
					$monto += $temp_monto_1;
					}
				if($temp>1){	
					if($inicio!=""){
						$fin=$temp_1;
						$monto += $temp_monto_1;
						array_push($arr_resultado, array("fecha"=>$fecha,"inicio"=>$inicio, "fin"=>$fin,"monto"=>$monto));
						$inicio = "";
						$fin = "";
						$monto = 0 ;
						}
					else{
						$inicio = $temp_1;
						array_push($arr_resultado, array("fecha"=>$fecha,"inicio"=>$inicio, "fin"=>"","monto"=>$temp_monto_1 ));
						$inicio = "";
						$fin = "";
						$monto = 0 ;
						}
					}
				if ($temp<1){
					$inicio = $temp_1;
					array_push($arr_resultado, array("fecha"=>$fecha,"inicio"=>$inicio, "fin"=>"","monto"=>$temp_monto_1 ));
					$inicio = "";
					$fin = "";
					$monto = 0 ;
					}
				}
			else{
				if ($inicio==''){
					$inicio = $temp_1;
					}
				else{
					$fin = $temp_1;
					}
				$monto += $temp_monto_1;
				array_push($arr_resultado, array("fecha"=>$fecha,"inicio"=>$inicio, "fin"=>$fin,"monto"=>$monto ));
				$inicio = "";
				$fin = "";
				$monto = 0 ;
				}
			}	
		}
	//var_dump($arr_resultado); 
	$arrDetalle = ordenar_matriz_multidimensionada($arr_resultado,"inicio","ASC");
	//$arrDetalle = $arr_resultado;
	//var_dump ($arrDetalle);
	$arr_final = array();
	//obtener dias del mes contable
	$dias = date("t", mktime(0, 0, 0, $mes, 1, $anio));
	$j=0;
	$factor=0;
	$monto_0 = 0;
	$monto_1 = 0;
	$monto_2 = 0;
	$monto_3 = 0;
	$monto_4 = 0;
	$monto_total = 0;
	for($i=0; $i<count($arrDetalle);){
		$arr_dias_mes = array();
		for($k=1; $k<=$dias;$k++){
			list($anio1,$mes1,$dia1) = explode('-', $arrDetalle[$i]['fecha']);
			if ( mktime(0, 0, 0, $mes1, $dia1, $anio1) == mktime(0, 0, 0, $mes, $k, $anio) ){
				$arr_dias_mes[$k-1]['fecha'] 	= $arrDetalle[$i]['fecha'];
				$arr_dias_mes[$k-1]['inicio'] 	= $arrDetalle[$i]['inicio'];
				$arr_dias_mes[$k-1]['fin'] 		= $arrDetalle[$i]['fin'];
				$arr_dias_mes[$k-1]['monto'] 	= $arrDetalle[$i]['monto'];
				$i++;
				}
			else{
				$arr_dias_mes[$k-1]['fecha'] 	= $anio."-".$mes."-".$k;
				$arr_dias_mes[$k-1]['inicio']   = "";
				$arr_dias_mes[$k-1]['fin'] 		= "";
				$arr_dias_mes[$k-1]['monto'] 	= "";
				}
			}
		for($k=1; $k<=$dias;$k++){
			if ($j==0){
				$arr_final[$k-1+$factor]['fecha'] 	= $arr_dias_mes[$k-1]['fecha'];
				$arr_final[$k-1+$factor]['inicio'] 	= $arr_dias_mes[$k-1]['inicio'];
				$arr_final[$k-1+$factor]['fin'] 	= $arr_dias_mes[$k-1]['fin'];
				$arr_final[$k-1+$factor]['monto'] 	= $arr_dias_mes[$k-1]['monto'];
				$monto_0 += $arr_dias_mes[$k-1]['monto'];
				}
			else{
				$arr_final[$k-1+$factor]['fecha'] 		= $arr_dias_mes[$k-1]['fecha'];
				$arr_final[$k-1+$factor]['inicio_'.$j] 	= $arr_dias_mes[$k-1]['inicio'];
				$arr_final[$k-1+$factor]['fin_'.$j] 	= $arr_dias_mes[$k-1]['fin'];
				$arr_final[$k-1+$factor]['monto_'.$j] 	= $arr_dias_mes[$k-1]['monto'];
				if ($j==1){
					$monto_1 += $arr_dias_mes[$k-1]['monto'];
					}
				elseif ($j==2){
					$monto_2 += $arr_dias_mes[$k-1]['monto'];
					}
				elseif ($j==3){
					$monto_3 += $arr_dias_mes[$k-1]['monto'];
					}
				}
			if ($k==$dias){
				$j++;
				}
			if (($j==4)&&($k==$dias)){
				$arr_final[$k+$factor]['fecha'] 	= "----";
				$arr_final[$k+$factor]['inicio'] 	= "----";
				$arr_final[$k+$factor]['fin'] 	    = "----";
				$arr_final[$k+$factor]['monto'] 	= $monto_0;
				$arr_final[$k+$factor]['inicio_1'] 	= "----";
				$arr_final[$k+$factor]['fin_1'] 	= "----";
				$arr_final[$k+$factor]['monto_1'] 	= $monto_1;
				$arr_final[$k+$factor]['inicio_2'] 	= "----";
				$arr_final[$k+$factor]['fin_2'] 	= "----";
				$arr_final[$k+$factor]['monto_2'] 	= $monto_2;
				$arr_final[$k+$factor]['inicio_3'] 	= "----";
				$arr_final[$k+$factor]['fin_3'] 	= "----";
				$arr_final[$k+$factor]['monto_3'] 	= $monto_3;
				$subtotal = $monto_0+$monto_1+$monto_2+$monto_3;
				$monto_total = $subtotal + $monto_total;
				$arr_final[$k+$factor+1]['fecha'] 	= "xxxx";
				$arr_final[$k+$factor+1]['inicio'] 	= "----";
				$arr_final[$k+$factor+1]['fin'] 	= "----";
				$arr_final[$k+$factor+1]['monto'] 	= "----";
				$arr_final[$k+$factor+1]['inicio_1']= "----";
				$arr_final[$k+$factor+1]['fin_1'] 	= "----";
				$arr_final[$k+$factor+1]['monto_1'] = "----";
				$arr_final[$k+$factor+1]['inicio_2']= "----";
				$arr_final[$k+$factor+1]['fin_2'] 	= "----";
				$arr_final[$k+$factor+1]['monto_2'] = "----";
				$arr_final[$k+$factor+1]['inicio_3']= "----";
				$arr_final[$k+$factor+1]['fin_3'] 	= "Subtotal";
				$arr_final[$k+$factor+1]['monto_3'] = $subtotal;
				
				$monto_0 = $monto_1 =$monto_2 = $monto_3 = $monto_4 = 0;
				$factor=$dias+$factor+2;
				$j=0;
				}
			if ($i+1==count($arrDetalle)){
				
				$arr_final[$k+$factor]['fecha'] 	= "----";
				$arr_final[$k+$factor]['inicio'] 	= "----";
				$arr_final[$k+$factor]['fin'] 	    = "----";
				$arr_final[$k+$factor]['monto'] 	= $monto_0;
				$arr_final[$k+$factor]['inicio_1'] 	= "----";
				$arr_final[$k+$factor]['fin_1'] 	= "----";
				$arr_final[$k+$factor]['monto_1'] 	= $monto_1;
				$arr_final[$k+$factor]['inicio_2'] 	= "----";
				$arr_final[$k+$factor]['fin_2'] 	= "----";
				$arr_final[$k+$factor]['monto_2'] 	= $monto_2;
				$arr_final[$k+$factor]['inicio_3'] 	= "----";
				$arr_final[$k+$factor]['fin_3'] 	= "----";
				$arr_final[$k+$factor]['monto_3'] 	= $monto_3;
				$subtotal = $monto_0+$monto_1+$monto_2+$monto_3;
				$monto_total = $subtotal + $monto_total;
				$arr_final[$k+$factor+1]['fecha'] 	= "xxxx";
				$arr_final[$k+$factor+1]['inicio'] 	= "----";
				$arr_final[$k+$factor+1]['fin'] 	= "----";
				$arr_final[$k+$factor+1]['monto'] 	= "----";
				$arr_final[$k+$factor+1]['inicio_1']= "----";
				$arr_final[$k+$factor+1]['fin_1'] 	= "----";
				$arr_final[$k+$factor+1]['monto_1'] = "----";
				$arr_final[$k+$factor+1]['inicio_2']= "----";
				$arr_final[$k+$factor+1]['fin_2'] 	= "----";
				$arr_final[$k+$factor+1]['monto_2'] = "----";
				$arr_final[$k+$factor+1]['inicio_3']= "----";
				$arr_final[$k+$factor+1]['fin_3'] 	= "Subtotal";
				$arr_final[$k+$factor+1]['monto_3'] = $subtotal;

				
				$k=$dias;
				$monto_0 = $monto_1 =$monto_2 = $monto_3 = $monto_4 = 0;
				$factor=$dias+$factor+2;
				$j=0;
				}
			}
/*//	$arr_final[$i]['fecha'] 	= $arrDetalle[$i]['fecha'];
//		$arr_final[$i]['inicio'] 	= $arrDetalle[$i]['inicio'];
//		$arr_final[$i]['fin'] 	= $arrDetalle[$i]['fin'];
//		$arr_final[$i]['monto'] 	= $arrDetalle[$i]['monto'];
//		$monto_0 = $arrDetalle[$i]['monto']+$monto_0;
//		//echo $arrDetalle[$i]['inicio'];
		for($k=1; $k<=$dias ; $k++){
			list($anio1,$mes1,$dia1) = explode('-', $arrDetalle[$i]['fecha']);
			//$objResponse->addAlert((mktime(0, 0, 0, $mes1, $dia1, $anio1)-mktime(0, 0, 0, $mes, $k, $anio))."---".$arrDetalle[$i]['fecha']);
			//echo $arrDetalle[$i]['inicio'];
			if ($arrDetalle[$i]['inicio']=='60295'){
					//$objResponse->addAlert($arrDetalle[$i]['inicio']."--".$k."-".$mes."-".$anio."---".$arrDetalle[$i]['fecha']);
					}
			if ( ((mktime(0, 0, 0, $mes1, $dia1, $anio1)-mktime(0, 0, 0, $mes, $k, $anio))==0) ){
				if ($arrDetalle[$i]['inicio']=='60295'){
					//$objResponse->addAlert($arrDetalle[$i]['inicio']);
					}
				if ($j==0){
						$arr_final[$k-1+$factor]['fecha'] 	= $arrDetalle[$i]['fecha'];
						$arr_final[$k-1+$factor]['inicio'] 	= $arrDetalle[$i]['inicio'];
						$arr_final[$k-1+$factor]['fin'] 	= $arrDetalle[$i]['fin'];
						$arr_final[$k-1+$factor]['monto'] 	= $arrDetalle[$i]['monto'];
						$monto_0 += $arrDetalle[$i]['monto'];
						$i++;
					}
				else{
						$arr_final[$k-1+$factor]['fecha'] 		= $arrDetalle[$i]['fecha'];
						$arr_final[$k-1+$factor]['inicio_'.$j] 	= $arrDetalle[$i]['inicio'];
						$arr_final[$k-1+$factor]['fin_'.$j] 	= $arrDetalle[$i]['fin'];
						$arr_final[$k-1+$factor]['monto_'.$j] 	= $arrDetalle[$i]['monto'];
						$i++;
						if ($j==1){
							$monto_1 += $arrDetalle[$i]['monto'];
							}
						elseif ($j==2){
							$monto_2 += $arrDetalle[$i]['monto'];
							}
						elseif ($j==3){
							$monto_3 += $arrDetalle[$i]['monto'];
							}
					}
				//$i++;
				}
			else{
				$arr_final[$k-1+$factor]['fecha'] = $anio.'-'.$mes.'-'.$k;
				}
			if ($k==$dias){
				$j++;
				}
			if ($i+1==count($arrDetalle)){
				$arr_final[$k+$factor]['fecha'] 	= "----";
				$arr_final[$k+$factor]['inicio'] 	= "----";
				$arr_final[$k+$factor]['fin'] 	    = "----";
				$arr_final[$k+$factor]['monto'] 	= $monto_0;
				$arr_final[$k+$factor]['inicio_1'] 	= "----";
				$arr_final[$k+$factor]['fin_1'] 	= "----";
				$arr_final[$k+$factor]['monto_1'] 	= $monto_1;
				$arr_final[$k+$factor]['inicio_2'] 	= "----";
				$arr_final[$k+$factor]['fin_2'] 	= "----";
				$arr_final[$k+$factor]['monto_2'] 	= $monto_2;
				$arr_final[$k+$factor]['inicio_3'] 	= "----";
				$arr_final[$k+$factor]['fin_3'] 	= "----";
				$arr_final[$k+$factor]['monto_3'] 	= $monto_3;
				$subtotal = $monto_0+$monto_1+$monto_2+$monto_3+$monto_4;
				$arr_final[$k+$factor+1]['fecha'] 	= "xxxx";
				$arr_final[$k+$factor+1]['inicio'] 	= "----";
				$arr_final[$k+$factor+1]['fin'] 	= "----";
				$arr_final[$k+$factor+1]['monto'] 	= "----";
				$arr_final[$k+$factor+1]['inicio_1']= "----";
				$arr_final[$k+$factor+1]['fin_1'] 	= "----";
				$arr_final[$k+$factor+1]['monto_1'] = "----";
				$arr_final[$k+$factor+1]['inicio_2']= "----";
				$arr_final[$k+$factor+1]['fin_2'] 	= "----";
				$arr_final[$k+$factor+1]['monto_2'] = "----";
				$arr_final[$k+$factor+1]['inicio_3']= "----";
				$arr_final[$k+$factor+1]['fin_3'] 	= "Subtotal";
				$arr_final[$k+$factor+1]['monto_3'] = $subtotal;

				
				$k=$dias;
				$monto_0 = $monto_1 =$monto_2 = $monto_3 = $monto_4 = 0;
				$factor=$dias+$factor+2;
				$j=0;
				}
			if (($j==4)&&($k==$dias)){
				$arr_final[$k+$factor]['fecha'] 	= "----";
				$arr_final[$k+$factor]['inicio'] 	= "----";
				$arr_final[$k+$factor]['fin'] 	    = "----";
				$arr_final[$k+$factor]['monto'] 	= $monto_0;
				$arr_final[$k+$factor]['inicio_1'] 	= "----";
				$arr_final[$k+$factor]['fin_1'] 	= "----";
				$arr_final[$k+$factor]['monto_1'] 	= $monto_1;
				$arr_final[$k+$factor]['inicio_2'] 	= "----";
				$arr_final[$k+$factor]['fin_2'] 	= "----";
				$arr_final[$k+$factor]['monto_2'] 	= $monto_2;
				$arr_final[$k+$factor]['inicio_3'] 	= "----";
				$arr_final[$k+$factor]['fin_3'] 	= "----";
				$arr_final[$k+$factor]['monto_3'] 	= $monto_3;
				$subtotal = $monto_0+$monto_1+$monto_2+$monto_3+$monto_4;
				$arr_final[$k+$factor+1]['fecha'] 	= "xxxx";
				$arr_final[$k+$factor+1]['inicio'] 	= "----";
				$arr_final[$k+$factor+1]['fin'] 	= "----";
				$arr_final[$k+$factor+1]['monto'] 	= "----";
				$arr_final[$k+$factor+1]['inicio_1']= "----";
				$arr_final[$k+$factor+1]['fin_1'] 	= "----";
				$arr_final[$k+$factor+1]['monto_1'] = "----";
				$arr_final[$k+$factor+1]['inicio_2']= "----";
				$arr_final[$k+$factor+1]['fin_2'] 	= "----";
				$arr_final[$k+$factor+1]['monto_2'] = "----";
				$arr_final[$k+$factor+1]['inicio_3']= "----";
				$arr_final[$k+$factor+1]['fin_3'] 	= "Subtotal";
				$arr_final[$k+$factor+1]['monto_3'] = $subtotal;
				
				$monto_0 = $monto_1 =$monto_2 = $monto_3 = $monto_4 = 0;
				$factor=$dias+$factor+2;
				$j=0;
				}
			}*/
		}
	$arr_final[$k-1+$factor]['fecha'] 	= "----";
	$arr_final[$k-1+$factor]['inicio'] 	= "----";
	$arr_final[$k-1+$factor]['fin'] 	    = "----";
	$arr_final[$k-1+$factor]['monto'] 	= $monto_0;
	$arr_final[$k-1+$factor]['inicio_1'] 	= "----";
	$arr_final[$k-1+$factor]['fin_1'] 	= "----";
	$arr_final[$k-1+$factor]['monto_1'] 	= $monto_1;
	$arr_final[$k-1+$factor]['inicio_2'] 	= "----";
	$arr_final[$k-1+$factor]['fin_2'] 	= "----";
	$arr_final[$k-1+$factor]['monto_2'] 	= $monto_2;
	$arr_final[$k-1+$factor]['inicio_3'] 	= "----";
	$arr_final[$k-1+$factor]['fin_3'] 	= "----";
	$arr_final[$k-1+$factor]['monto_3'] 	= $monto_3;
	$subtotal = $monto_0+$monto_1+$monto_2+$monto_3;
	$monto_total = $subtotal + $monto_total;
	$arr_final[$k+$factor]['fecha'] 	= "xxxx";
	$arr_final[$k+$factor]['inicio'] 	= "----";
	$arr_final[$k+$factor]['fin'] 	= "----";
	$arr_final[$k+$factor]['monto'] 	= "----";
	$arr_final[$k+$factor]['inicio_1']= "----";
	$arr_final[$k+$factor]['fin_1'] 	= "----";
	$arr_final[$k+$factor]['monto_1'] = "----";
	$arr_final[$k+$factor]['inicio_2']= "----";
	$arr_final[$k+$factor]['fin_2'] 	= "----";
	$arr_final[$k+$factor]['monto_2'] = "----";
	$arr_final[$k+$factor]['inicio_3']= "----";
	$arr_final[$k+$factor]['fin_3'] 	= "Subtotal";
	$arr_final[$k+$factor]['monto_3'] = $subtotal;	
	$arr_final[$k+1+$factor]['fecha'] 	= "xxxx";
	$arr_final[$k+1+$factor]['inicio'] 	= "----";
	$arr_final[$k+1+$factor]['fin'] 	= "----";
	$arr_final[$k+1+$factor]['monto'] 	= "----";
	$arr_final[$k+1+$factor]['inicio_1']= "----";
	$arr_final[$k+1+$factor]['fin_1'] 	= "----";
	$arr_final[$k+1+$factor]['monto_1'] = "----";
	$arr_final[$k+1+$factor]['inicio_2']= "----";
	$arr_final[$k+1+$factor]['fin_2'] 	= "----";
	$arr_final[$k+1+$factor]['monto_2'] = "----";
	$arr_final[$k+1+$factor]['inicio_3']= "----";
	$arr_final[$k+1+$factor]['fin_3'] 	= "Total";
	$arr_final[$k+1+$factor]['monto_3'] = $monto_total;	
	//var_dump($arr_final);
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$miSmarty->assign('arrDetalle', $arr_final);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_libro_ventas_list.tpl'));
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	return $objResponse->getXML();
}



function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
        $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
        
	if (@mysql_num_rows($res) > 0) {
                $objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIempresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_libro_ventas.tpl');

?>

