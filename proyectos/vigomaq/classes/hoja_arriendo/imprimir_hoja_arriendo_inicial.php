<?php 
ob_start(); 
session_start(); 

function utf8_decode_1($string, $strip_zeroes = false) {
	$pos = 0;
	$len = strlen($string);
	$result = '';
 
	while ($pos < $len) {
		$code1 = ord($string[$pos++]);
		if ($code1 < 0x80) {
			$result .= chr($code1);
		} elseif ($code1 < 0xE0) {
			// Two byte
			$code1 = 0x1F & $code1;
			$code2 = 0x3F & ord($string[$pos++]);
			$res_code1 = $code1 >> 2;
			if ($res_code1 > 0 || $strip_zeroes) {
				$result .= chr($res_code1);
			}
			$result .= chr( ($code1 << 6) | $code2);
		} elseif ($code1 < 0xF0) {
			// Three byte
			$code1 = $code1; // No need to mask
			$code2 = 0x3F & ord($string[$pos++]);
			$code3 = 0x3F & ord($string[$pos++]);
			$res_code1 = chr( ($code1 << 4) | ($code2 >> 2));
			if ($res_code1 > 0 || $strip_zeroes) {
				$result .= chr($res_code1);
			}
			$result .= chr( ($code2 << 6) | $code3);
		}
	}
 
	return $result;
}

$cod_arriendo = $_GET['num_gd'];
$tipo = "";

require('../fpdf.php');
require('../htmlparser.inc');
include("../conex.php");

	class PDF extends FPDF{
		// Cabecera de página
			function Header(){
				// Logo
				$this->Image('../../images/back_gd.jpg',0,0,215);
				
			}
		}

        $numeros =    array("-", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve");
        $numerosX =   array("-", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve");
        $numeros100 = array("-", "ciento", "doscientos", "trecientos", "cuatrocientos", "quinientos", "seicientos", "setecientos", "ochocientos", "novecientos");
        $numeros11 =  array("-", "once", "doce", "trece", "catorce", "quince", "dieciseis", "diecisiete", "dieciocho", "diecinueve");
        $numeros10 =  array("-", "-", "-", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa");
 
        function tresnumeros($n, $last) {
            global $numeros100, $numeros10, $numeros11, $numeros, $numerosX;
            if ($n == 100) return "cien ";
            if ($n == 0) return "cero ";
            $r = "";
            $cen = floor($n / 100);
            $dec = floor(($n % 100) / 10);
            $uni = $n % 10;
            if ($cen > 0) $r .= $numeros100[$cen] . " ";
 
            switch ($dec) {
                case 0: $special = 0; break;
                case 1: $special = 10; break;
                case 2: $special = 20; break;
                default: $r .= $numeros10[$dec] . " "; $special = 30; break;
            }
            if ($uni == 0) {
                if ($special==30);
                else if ($special==20) $r .= "veinte ";
                else if ($special==10) $r .= "diez ";
                else if ($special==0);
            } else {
                if ($special == 30 && !$last) $r .= "y " . $numerosX[$n%10] . " ";
                else if ($special == 30) $r .= "y " . $numeros[$n%10] . " ";
                else if ($special == 20) {
                    if ($uni == 3) $r .= "veintitr�s ";
                    else if (!$last) $r .= "veinti" . $numerosX[$n%10] . " ";
                    else $r .= "veinti" . $numeros[$n%10] . " ";
                } else if ($special == 10) $r .= $numeros11[$n%10] . " ";
                else if ($special == 0 && !$last) $r .= $numerosX[$n%10] . " ";
                else if ($special == 0) $r .= $numeros[$n%10] . " ";
            }
            return $r;
        }
 
        function seisnumeros($n, $last) {
            if ($n == 0) return "cero ";
            $miles = floor($n / 1000);
            $units = $n % 1000;
            $r = "";
            if ($miles == 1) $r .= "mil ";
            else if ($miles > 1) $r .= tresnumeros($miles, false) . "mil ";
            if ($units > 0) $r .= tresnumeros($units, $last);
            return $r;
        }
 
        function docenumeros($n) {
            if ($n == 0) return "cero ";
            $millo = floor($n / 1000000);
            $units = $n % 1000000;
            $r = "";
            if ($millo == 1) $r .= "un mill�n ";
            else if ($millo > 1) $r .= seisnumeros($millo, false) . "millones ";
            if ($units > 0) $r .= seisnumeros($units, true);
            return $r;
        } 

		function cambiar_mes($dyh){
			switch($dyh){
				case 1: $dyh = "Enero"; break;
				case 2: $dyh = "Febrero"; break;
				case 3: $dyh = "Marzo"; break;
				case 4: $dyh = "Abril"; break;
				case 5: $dyh = "Mayo"; break;
				case 6: $dyh = "Junio"; break;
				case 7: $dyh = "Julio"; break;
				case 8: $dyh = "Agosto"; break;
				case 9: $dyh = "Septiembre"; break;
				case 10: $dyh = "Octubre"; break;
				case 11: $dyh = "Noviembre"; break;
				case 12: $dyh = "Diciembre"; break;
				default: $dyh = "Error";    
			}
			return $dyh;
		}


		if (empty($cod_arriendo)) $cod_arriendo = $_GET['cod_arriendo'];
		$link=Conectarse();
		$sql_cod_arriendo = "SELECT * 
								FROM arriendo 
								WHERE cod_arriendo = '$cod_arriendo'";						
		
		$res_cod_arriendo = mysql_query($sql_cod_arriendo,$link) or die(mysql_error()); 
		$registro_cod_arriendo = mysql_fetch_array($res_cod_arriendo);
		
		$cod_cli  		=	$registro_cod_arriendo['cod_cliente'];
		$cod_arriendo	=  	$registro_cod_arriendo['cod_arriendo'];
		$rut_cliente	=	$registro_cod_arriendo['rut_cliente'];
		$cod_obra		=	$registro_cod_arriendo['cod_obra'];
		$cod_tarifa		=	$registro_cod_arriendo['cod_tarifa'];
		$cod_personal	=	$registro_cod_arriendo['cod_personal'];
		$forma_pago		=	$registro_cod_arriendo['forma_pago'];
		$num_gd			=	$registro_cod_arriendo['num_gd'];
		$num_oc			=	$registro_cod_arriendo['num_oc'];
		$tipo_garantia	=	$registro_cod_arriendo['tipo_garantia'];
		$fecha_inicio 	=	$registro_cod_arriendo['fecha_inicio'];
		$fecha_vcmto 	=	$registro_cod_arriendo['fecha_vcmto'];
		$fecha_arr 		=	$registro_cod_arriendo['fecha_arr'];
		$hora_arr		=	$registro_cod_arriendo['hora_arr'];
		$fecha_devol	=	$registro_cod_arriendo['fecha_devol'];
		$hora_devol		=	$registro_cod_arriendo['hora_devol'];
		$forma_entrega	=	$registro_cod_arriendo['forma_entrega'];
		$monto_arriendo	=	$registro_cod_arriendo['monto_arriendo'];
		$tipo_oc		=	$regsitro_cod_arriendo['tipo_oc'];
		$vcmto_oc		=	$registro_cod_arriendo['vcmto_oc'];
		$obs_devolucion	=	$registro_cod_arriendo['obs_devolucion'];
		
		$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, 
					dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, 
					movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, 
					cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, 
					movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact 
			FROM clientes 
			WHERE rut_cliente ='$rut_cliente'";
		$res = mysql_query($sql,$link) or die(mysql_error()); 
		$registro = mysql_fetch_array($res);
	
		$pdf=new FPDF();
		//$pdf=new PDF();
		$pdf->SetFont('Arial','',9);
		
		$sql_prepa_001 = "(select distinct num_gd
								from gd
								where id_arriendo = '$cod_arriendo'
									and tipo <> 'DEVOL EQUIPO')";
		$res_prepa_001 = mysql_query($sql_prepa_001,$link) or die(mysql_error());
		while ($row_prepa_001 = mysql_fetch_array($res_prepa_001)){
			$sql_equipos = "select * 
							from det_gd
							where num_gd = ".$row_prepa_001['num_gd']."";
			$res_equipos = mysql_query($sql_equipos,$link);
			$linea= 1;
			$fecha_temp = explode("-",$fecha_arr);
			$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
			$fecha_arr = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];
	
			while($row_equipos  = mysql_fetch_array($res_equipos)) {
				
				$pdf->AddPage();
				$fecha_temp = explode("-",$registro_cod_arriendo['fecha_arr']);
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
				$dia_texto="";
				$fecha_gd = $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  
				
				
				$sqlobra     = "SELECT condic_arriendo.condiciones 
								FROM obra 
									inner join condic_arriendo
										on condic_arriendo.cod_cond_arr = obra.cod_condic
								WHERE obra.cod_obra ='$cod_obra'";
								
				$resobra     = mysql_query($sqlobra,$link) or die(mysql_error()); 
				$registroobra= mysql_fetch_array($resobra);
				$nombre_condicion_obra = $registroobra['condiciones'];
				
				$pdf->SetXY(65,13);
				$pdf->Cell(50,5,utf8_decode_1("Condiciones de Arriendo : ".$nombre_condicion_obra));
				$pdf->Ln();
			
				$pdf->SetXY(65,18);
				if ($forma_entrega == 1) {
					$forma_entrega = "RETIRA CLIENTE";
				}else{
					$forma_entrega ="ENTREGA EN OBRA";
					}
				$pdf->Cell(50,5,utf8_decode_1("Forma Entrega Producto : ".$forma_entrega));
				$pdf->Ln();
			
				$pdf->SetXY(65,23);
				$sqlfp = "SELECT forma_pago FROM forma_pago WHERE cod_forma_pago ='$forma_pago'";
				$resfp = mysql_query($sqlfp,$link) or die(mysql_error()); 
				$registrofp = mysql_fetch_array($resfp);
				$nombre_forma_pago = $registrofp['forma_pago'];
				$pdf->Cell(50,5,utf8_decode_1("Forma de Pago : ".$nombre_forma_pago));
				$pdf->Ln();
			
				$envio_factura = $registro['cond_env_fact'];
				$pdf->SetXY(65,28);
				$pdf->Cell(50,5,substr(utf8_decode_1("Envio Factura : ".$envio_factura),0,80));
				$pdf->SetXY(65,33);
				$pdf->Cell(50,5,utf8_decode_1("Doc Anexo a la Factura : "));
				$pdf->Ln();
			
				$pdf->SetXY(11,38);
				$pdf->Cell(50,5,utf8_decode_1("Fecha : ".$fecha_arr));
				$pdf->SetXY(154,38);
				$pdf->Cell(50,5,utf8_decode_1("Hora : ".$hora_arr));
				$pdf->Ln();
			
				$pdf->SetXY(11,43);
				$sql1       = "SELECT * FROM clientes WHERE rut_cliente ='$rut_cliente'";
				$res1       = mysql_query($sql1,$link) or die(mysql_error()); 
				$registro1  = mysql_fetch_array($res1);
				$nombre_cliente = $registro1['raz_social'];
				$pdf->Cell(50,5,utf8_decode_1("Razon Social : ".$nombre_cliente));
				$pdf->Ln();
			
				$pdf->SetXY(11,48);
				$direcc_cliente = $registro1['direcc_cliente'];
				$pdf->Cell(50,5,utf8_decode_1("Direccion : ".$direcc_cliente));
				$pdf->Ln();
			
				$pdf->SetXY(11,53);
				$sql2       = "SELECT ciudad.ciudad 
								FROM  ciudad
									INNER JOIN clientes 
										on ciudad.cod_ciudad = clientes.cod_ciudad
								WHERE clientes.rut_cliente ='$rut_cliente'";
				$res2      = mysql_query($sql2,$link) or die(mysql_error()); 
				$registro2  = mysql_fetch_array($res2);
				$nombre_ciudad = $registro2['ciudad'];
				$pdf->Cell(50,5,utf8_decode_1("Ciudad : ".$nombre_ciudad));
				$pdf->Ln();
				
				$pdf->SetXY(11,58);
				$pdf->Cell(50,5,utf8_decode_1("Rut : ".$rut_cliente));
				$pdf->Ln();
			
				$pdf->SetXY(11,63);
				$nro_fono = $registro1['fono_cliente'];
				$pdf->Cell(50,5,utf8_decode_1("Fono : ".$nro_fono));
				$pdf->Ln();
			
				$pdf->SetXY(11,68);
				$giro_cliente = $registro1['giro_cliente'];
				$pdf->Cell(50,5,utf8_decode_1("Giro : ".$giro_cliente));
				$pdf->Ln();
			
				$pdf->SetXY(11,73);
				$pdf->Cell(50,5,utf8_decode_1("Orden N° : ".$num_oc));
				$pdf->Ln();
			
				$pdf->SetXY(11,78);
				$sql3 = "SELECT * 
								FROM  obra
								WHERE cod_obra = '$cod_obra'";
				$res3      = mysql_query($sql3,$link) or die(mysql_error()); 
				$registro3  = mysql_fetch_array($res3);
				$nombre_obra = $registro3['nombre_obra'];
				$pdf->Cell(50,5,utf8_decode_1("Nombre Obra : ".$nombre_obra));
				$pdf->Ln();
			
				$pdf->SetXY(11,83);
				$direcc_obra = $registro3['direcc_obra'];
				$pdf->Cell(50,5,utf8_decode_1("Direc. Obra : ".$direcc_obra));
				$pdf->Ln();
			
				$pdf->SetXY(11,88);
				$cod_equipo = $row_equipos['cod_equipo'];
				$sql_nom_equ = "select *
								from equipo
								where cod_equipo = '$cod_equipo'";
				$res_nom_equ = mysql_query($sql_nom_equ,$link);
				$row_nom_equ = mysql_fetch_array($res_nom_equ);
				$nombre_equipo = $row_nom_equ['nombre_equipo'];
				$pdf->Cell(50,5,(("Maquinaria : ".$nombre_equipo)));
				$pdf->Ln();
				$pdf->SetXY(35,93);
				$accesorio = $row_equipos['accesorio'];
				$tem="";
				if ($accesorio ==1){
					$tem .= $row_nom_equ['accesorios'];
					}
				else{
					$tem .= "No Incluye Accesorios";
					}
				$cod_motor = $row_equipos['cod_motor'];
				if ($cod_motor!=0){
					$tem .= " C/ Motor";
					$sql_nom_equ = "select *
									from equipo
									where cod_equipo = '$cod_motor'";
					$res_nom_equ = mysql_query($sql_nom_equ,$link);
					$row_nom_equ = mysql_fetch_array($res_nom_equ);
					$tem .= " ".$row_nom_equ['nombre_equipo'];
					}
				else{
					$tem .= "";
					}
				$pdf->Cell(50,5,utf8_decode_1($tem));
				$pdf->Ln();
				
			
				$pdf->SetXY(11,98);
				$num_gd = $row_equipos['num_gd'];
				$pdf->Cell(50,5,utf8_decode_1("Guia N° : ".$num_gd));
				$pdf->SetXY(65,98);
				$pdf->Cell(50,5,utf8_decode_1("Linea N° : ".$linea));
				$pdf->Ln();
			
				$pdf->SetXY(11,103);
				$pdf->Cell(50,5,utf8_decode_1("Dias de Arriendo : 1"));
				$pdf->Ln();
			
				$pdf->SetXY(11,108);
				$pdf->Cell(50,5,utf8_decode_1("Cheque Garantía : ".$cheque_garantia));
				$pdf->Ln();
	
				//Cambios . Devoluciones
				$pdf->SetXY(115,48);
				$pdf->Cell(60,5,utf8_decode_1("Cambios"),1,0,'C',0);
				$pdf->Ln();
				$pdf->SetXY(115,53);
				$pdf->Cell(20,5,utf8_decode_1("Fecha"),1,0,'C',0);
				$pdf->Ln();
				$pdf->SetXY(135,53);
				$pdf->Cell(20,5,utf8_decode_1("Equipo"),1,0,'C',0);
				$pdf->Ln();
				$pdf->SetXY(155,53);
				$pdf->Cell(20,5,utf8_decode_1("Guia"),1,0,'C',0);
				$pdf->Ln();
				
				$cod_equipo_temp = $cod_equipo;
				$cod_equipo_arr = array();
				$cod_reclamo_arr = array();
				for ($i=0;$i<10;$i++){
					$string_cod_reclamo = implode("','",$cod_reclamo_arr);
					$sql_inicial = "select cod_reclamo
									from equipos_arriendo
									where cod_equipo = ".$cod_equipo_temp."
									 and num_gd = ".$num_gd."
									 and cod_reclamo <> 0
									 and cod_reclamo not in ('".$string_cod_reclamo."')";
					$res_inicial = mysql_query($sql_inicial) or die();
					$row_inicial = mysql_fetch_array($res_inicial);
					if (!empty($row_inicial['cod_reclamo']))
						$cod_reclamo = $row_inicial['cod_reclamo'];
					else
						$cod_reclamo = 0;
					$cod_reclamo_arr[$i]=$cod_reclamo;
					$sql="select fecha_reclamo, cod_equipo_entreg, num_gd_salida
							from reclamo
							where cod_reclamo = ".$cod_reclamo."
							";
					$res_bus_equ_cam = mysql_query($sql) or die();
					$row_bus_equ_cam = mysql_fetch_array($res_bus_equ_cam);
					$pdf->SetXY(115,58 + ($i*5));
					$pdf->Cell(20,5,utf8_decode_1($row_bus_equ_cam['fecha_reclamo']),1,0,'C',0);
					$pdf->Ln();
					$pdf->SetXY(135,58 + ($i*5));
					if (!empty($row_bus_equ_cam['num_gd_salida'])){
						$sql_nom_equ = "select *
									from equipo
									where cod_equipo = '".$row_bus_equ_cam['cod_equipo_entreg']."'";
						$res_nom_equ = mysql_query($sql_nom_equ,$link);
						$row_nom_equ = mysql_fetch_array($res_nom_equ);
						$nombre_equipo = $row_nom_equ['nombre_equipo'];
						$pdf->Cell(20,5,utf8_decode_1(substr($nombre_equipo,-6,6)),1,0,'C',0); 
						}
					else{
						$pdf->Cell(20,5,utf8_decode_1(" "),1,0,'C',0);
						}
					$pdf->Ln();
					$pdf->SetXY(155,58 + ($i*5));
					$pdf->Cell(20,5,utf8_decode_1($row_bus_equ_cam['num_gd_salida']),1,0,'C',0);
					$pdf->Ln();
					$cod_equipo_arr[$i]=$cod_equipo_temp;
					if (!empty($row_bus_equ_cam['cod_equipo_entreg'])){
						$cod_equipo_temp=$row_bus_equ_cam['cod_equipo_entreg'];
						}
					}
				//Cambios . Devoluciones
	
				//detalle hoja arriendo		
				//primer detalle			
				$pdf->SetXY(11,120);
				$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
				$pdf->Ln();
				$pdf->SetXY(15,122);
	
				$string_cod_equipo = implode("','",$cod_equipo_arr);
				
				$sql_inicial_1 = "
								select * 
								from equipos_arriendo
									left join det_factura
										on equipos_arriendo.nro_factura = det_factura.num_factura
								where (equipos_arriendo.cod_equipo in ('".$string_cod_equipo."')
									and equipos_arriendo.num_gd = ".$num_gd."
									and equipos_arriendo.estado_equipo_arr like '%-FACTURADO')
									or (equipos_arriendo.cod_equipo in ('".$string_cod_equipo."')
									and equipos_arriendo.num_gd = ".$num_gd."
									and equipos_arriendo.estado_equipo_arr like 'NO DEVUELTO')
								";
				$res_inicial_1 = mysql_query($sql_inicial_1,$link) or die();
				$row_inicial_1 = mysql_fetch_array($res_inicial_1);
				
				$precio_equipo = $row_inicial_1['tot_arriendo']/$row_inicial_1['dias_arriendo'];
				$pdf->Cell(50,5,utf8_decode_1("Inicio Arriendo               ".$precio_equipo."           x ".$row_inicial_1['dias_arriendo']));
				$pdf->SetXY(150,122);
				$pdf->Cell(50,5,utf8_decode_1("dias               Neto  : ".$row_inicial_1['tot_arriendo']));
				$pdf->Ln();
				$pdf->SetXY(170,127);
				$pdf->Cell(50,5,utf8_decode_1("Iva    : ".$row_inicial_1['tot_arriendo']*0.19));
				$pdf->Ln();
				$pdf->SetXY(15,132);
				$pdf->Cell(50,5,utf8_decode_1("Vence : ".$row_inicial_1['arrendado_hasta']));
				$pdf->SetXY(65,132);
				$pdf->Cell(50,5,utf8_decode_1("Nro Factura :".$row_inicial_1['num_factura']));
				$pdf->SetXY(170,132);
				$pdf->Cell(50,5,utf8_decode_1("Total : ".$row_inicial_1['tot_arriendo']*1.19));
				$pdf->Ln();
				$pdf->SetXY(15,140);
				$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
				$pdf->Ln();
				$pdf->SetXY(15,142);
				$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
				$pdf->Ln();
				$row_inicial_1 = mysql_fetch_array($res_inicial_1);
					
				//otros detalles
				for($i=0; $i<3 ; $i++){				
					$row_inicial_1 = mysql_fetch_array($res_inicial_1);
					$pdf->SetXY(11,155 + ($i*35));
					$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
					$pdf->Ln();
					$pdf->SetXY(15,157 + ($i*35));
					$precio_equipo = $row_inicial_1['tot_arriendo']/$row_inicial_1['dias_arriendo'];
					$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por          ".$row_inicial_1['dias_arriendo']."                dias a ".$precio_equipo));
					$pdf->SetXY(170,157 + ($i*35));
					$pdf->Cell(50,5,utf8_decode_1("Neto : ".$row_inicial_1['tot_arriendo']));
					$pdf->Ln();
					$pdf->SetXY(170,162 + ($i*35));
					$pdf->Cell(50,5,utf8_decode_1("Iva    : ".$row_inicial_1['tot_arriendo']*0.19));
					$pdf->Ln();
					$pdf->SetXY(15,167 + ($i*35));
					$pdf->Cell(50,5,utf8_decode_1("Vence : ".$row_inicial_1['arrendado_hasta']));
					$pdf->SetXY(65,167 + ($i*35));
					$pdf->Cell(50,5,utf8_decode_1("Nro Factura : ".$row_inicial_1['num_factura']));
					$pdf->SetXY(170,167 + ($i*35));
					$pdf->Cell(50,5,utf8_decode_1("Total : ".$row_inicial_1['tot_arriendo']*1.19));
					$pdf->Ln();
					$pdf->SetXY(15,175 + ($i*35));
					$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
					$pdf->Ln();
					$pdf->SetXY(15,177 + ($i*35));
					$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
					$pdf->Ln();
					}
				$i=0;
				if (mysql_num_rows($res_inicial_1)>4){
					$pdf->AddPage();
					while ($row_inicial_1 = mysql_fetch_array($res_inicial_1)){
						$pdf->SetXY(11,5 + ($i*35));
						$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
						$pdf->Ln();
						$pdf->SetXY(15,7 + ($i*35));
						$precio_equipo = $row_inicial_1['tot_arriendo']/$row_inicial_1['dias_arriendo'];
						if (empty($precio_equipo)){
							$precio_equipo = $row_inicial_1['precio'];
						}else{
							
							 }
						$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por          ".$row_inicial_1['dias_arriendo']."                dias a ".$precio_equipo));
						$pdf->SetXY(170,7 + ($i*35));
						$pdf->Cell(50,5,utf8_decode_1("Neto : ".$row_inicial_1['tot_arriendo']));
						$pdf->Ln();
						$pdf->SetXY(170,12 + ($i*35));
						$pdf->Cell(50,5,utf8_decode_1("Iva    : ".$row_inicial_1['tot_arriendo']*0.19));
						$pdf->Ln();
						$pdf->SetXY(15,17 + ($i*35));
						$pdf->Cell(50,5,utf8_decode_1("Vence : ".$row_inicial_1['arrendado_hasta']));
						$pdf->SetXY(65,17 + ($i*35));
						$pdf->Cell(50,5,utf8_decode_1("Nro Factura : ".$row_inicial_1['num_factura']));
						$pdf->SetXY(170,17 + ($i*35));
						$pdf->Cell(50,5,utf8_decode_1("Total : ".$row_inicial_1['tot_arriendo']*1.19));
						$pdf->Ln();
						$pdf->SetXY(15,25 + ($i*35));
						$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
						$pdf->Ln();
						$pdf->SetXY(15,27 + ($i*35));
						$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
						$pdf->Ln();
						if ($i==8){
							$i=0;
							$pdf->AddPage();
							}
						else{
							$i++;
							}
						}
					}
				$linea = $linea+1;
				}
			}
		mysql_close($link); 
	
		$pdf->Output();
	?> 