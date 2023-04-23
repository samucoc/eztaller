<?php 
ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.229","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 

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


$guia = $_GET['num_gd'];

require('../fpdf.php');
require('../htmlparser.inc');
include("../../conex.php");

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

		if (empty($guia)) $guia = $_GET['num_gd'];
		$link=Conectarse();
		$sqlguia = "SELECT * FROM vigomaq_intranet.gd WHERE num_gd ='$guia'";						
		
		$resguia = mysql_query($sqlguia,$link) or die(mysql_error()); 
		$registroguia = mysql_fetch_array($resguia);
		$gd       =$registroguia['num_gd'];
		$cod_cli  =$registroguia['cod_cliente'];
		
		$sqlcliente = "SELECT rut_cliente FROM vigomaq_intranet.clientes WHERE cod_cliente ='$cod_cli'";
		$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
		$registrocliente = mysql_fetch_array($rescliente);
		$valor1=$registrocliente['rut_cliente'];
		if (empty($valor1)){
			$valor1 = $_GET['id'];
			if (empty($valor1)) $valor1 = $_POST['txt_rut'];
			if (empty($valor1)) $valor1 = $_GET['txt_rut'];
		}
		
		if (empty($valor1)){

		}else{
			$link=Conectarse();
			$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM vigomaq_intranet.clientes WHERE rut_cliente ='$valor1'";
			$res = mysql_query($sql,$link) or die(mysql_error()); 
			$registro = mysql_fetch_array($res);
			}

	$pdf=new FPDF();
	//$pdf=new PDF();
	$pdf->SetFont('Arial','',8);
	$pdf->AddPage();

	$fecha_temp = explode("-",$registroguia['fecha']);
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
	$dia_texto="";
	switch($dyh['mon']){
		case 1: $dia_texto = "Enero"; break;
		case 2: $dia_texto = "Febrero"; break;
		case 3: $dia_texto = "Marzo"; break;
		case 4: $dia_texto = "Abril"; break;
		case 5: $dia_texto = "Mayo"; break;
		case 6: $dia_texto = "Junio"; break;
		case 7: $dia_texto = "Julio"; break;
		case 8: $dia_texto = "Agosto"; break;
		case 9: $dia_texto = "Septiembre"; break;
		case 10: $dia_texto = "Octubre"; break;
		case 11: $dia_texto = "Noviembre"; break;
		case 12: $dia_texto = "Diciembre"; break;
		default: $dia_texto = "Error";    
	}
	
	$fecha_gd = $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  
	$pdf->SetXY(140,53);
	$pdf->Cell(50,5,utf8_decode_1($fecha_gd));
	$pdf->Ln();

	$pdf->SetXY(30,58);
	$pdf->Cell(50,5,utf8_decode_1($registro['raz_social']));
	$pdf->SetXY(140,58);
	$pdf->Cell(50,5,utf8_decode_1($registro['rut_cliente']));
	$pdf->Ln();

	$pdf->SetXY(30,64);
	$pdf->Cell(50,5,utf8_decode_1($registro['direcc_cliente']));
	$pdf->SetXY(140,64);
	$pdf->Cell(50,5,utf8_decode_1($registro['giro_cliente']));
	$pdf->Ln();
	
	if (!empty($registro['cod_ciudad']))  {
		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
		// echo($sql3);
		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		$registrociu = mysql_fetch_array($resciu);
		$pdf->SetXY(30,69);
		$pdf->Cell(50,5,utf8_decode_1($registrociu['ciudad']));
	}else{
		$pdf->SetXY(30,69);
		$pdf->Cell(50,5," ");
		} ; 
	$sqlfpago   = "SELECT * 
					FROM vigomaq_intranet.arriendo 
						inner join gd
							on gd.id_arriendo = arriendo.cod_arriendo
					WHERE arriendo.cod_obra =".$registroguia['cod_obra']." 
						and arriendo.cod_arriendo =".$registroguia['id_arriendo'];
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registrofp= mysql_fetch_array($resfpago);
	$pdf->SetXY(140,69);
	$pdf->Cell(50,5,utf8_decode_1($registrofp['num_oc']));
	$pdf->Ln();

	$sqlfpago   = "SELECT * 
					FROM vigomaq_intranet.arriendo 
						inner join gd
							on gd.id_arriendo = arriendo.cod_arriendo
					WHERE arriendo.cod_obra =".$registroguia['cod_obra']." 
						and arriendo.cod_arriendo =".$registroguia['id_arriendo'];
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registrofp= mysql_fetch_array($resfpago);
	$forma_pago = $registrofp['forma_pago'];
	
    $sqlfpago  = "SELECT * FROM vigomaq_intranet.forma_pago WHERE cod_forma_pago ='$forma_pago'";
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registropago= mysql_fetch_array($resfpago);
	
    $pdf->SetXY(30,75);
	$pdf->Cell(50,5,utf8_decode_1($registropago['forma_pago'])) ;
	$pdf->SetXY(140,75);
	$pdf->Cell(50,5,utf8_decode_1($registro['fono_cliente']));
	$pdf->Ln();

	$sqlobra   = "SELECT nombre_obra,direcc_obra FROM vigomaq_intranet.obra WHERE cod_obra =".$registroguia['cod_obra'];
	
	$resobra    = mysql_query($sqlobra,$link) or die(mysql_error()); 
	$registrobra= mysql_fetch_array($resobra);
    $pdf->SetXY(30,80);
	$pdf->Cell(50,5,utf8_decode_1($registrobra['nombre_obra']));
	$pdf->SetXY(140,80);
	$pdf->Cell(50,5,utf8_decode_1($registrobra['direcc_obra']));
	$pdf->Ln();

	$sql_reclamo   = "SELECT hora_reclamo
					FROM reclamo
					WHERE cod_reclamo in (	select distinct cod_reclamo
											from equipos_arriendo
											where equipos_arriendo.cod_arriendo =".$registroguia['id_arriendo'].")";
	
	$res_reclamo    = mysql_query($sql_reclamo,$link) or die(mysql_error()); 
	$registro_reclamo= mysql_fetch_array($res_reclamo);

	$pdf->SetXY(130,85);
	$pdf->Cell(50,5,"Hora : ".utf8_decode_1($registro_reclamo['hora_reclamo']));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();

	$sqldet="SELECT  *
				FROM  det_gd 
				where num_gd = ".$_GET["num_gd"]." 
					and (observaciones = 'CAMBIO' or observaciones = 'POR')
			order by fila_num_gd ASC";
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	$posicion = 0;
	while ($registrodet = mysql_fetch_array($resdet)) {
		$posicion++;
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(5,6," "); 
		$pdf->Cell(30,6,utf8_decode_1($registrodet['cantidad'])); 
		if (!empty($valor1)){
			$sqlnomrep="SELECT nombre_equipo, accesorios, cod_motor FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
			$resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
			$registronrep = mysql_fetch_array($resnomrep);
			$detalle="";
			$detalle .= $registrodet['observaciones']." ";
			$detalle .= (utf8_decode_1($registronrep['nombre_equipo']));
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(100,6,utf8_decode_1($detalle));
			$pdf->Cell(25,6,"");
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,6,"$ ".number_format($registrodet['precio'], 0, ",", ".")) ;

			$pdf->Ln();

			$pdf->Cell(30,6,""); 
			$detalle="";
			if($registronrep['cod_motor'] > 1){
				$detalle .= ' ,  INCLUYE MOTOR N. '.$registronrep['cod_motor'];
				}
			//incluye accesorio
			if($registrodet['accesorio'] == 1){
				$detalle .= ' , '.$registronrep['accesorios'];
				}
			}else{
				$detalle .=(" ");
			  }
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(100,6,utf8_decode_1($detalle));
			$pdf->Ln(); 
		}
		mysql_free_result($resdet);
		mysql_close($link); 

	$pdf->Output();
	?>