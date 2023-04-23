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

$cod_arriendo = $_GET['num_gd'];
$tipo = "";

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

		$pdf=new FPDF();
		//$pdf=new PDF();
		$pdf->SetFont('Arial','',9);
		
$pdf->AddPage();
			
			$pdf->SetXY(11,15);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,17);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,17);
			$pdf->Cell(50,5,utf8_decode_1("Neto : "));
			$pdf->Ln();
			$pdf->SetXY(170,22);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,27);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,27);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,27);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,34);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,37);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
			
			$pdf->SetXY(11,50);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,52);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,52);
			$pdf->Cell(50,5,utf8_decode_1("Neto : "));
			$pdf->Ln();
			$pdf->SetXY(170,57);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,62);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,62);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,62);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,68);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,68);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
			
			$pdf->SetXY(11,85);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,87);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,87);
			$pdf->Cell(50,5,utf8_decode_1("Neto : "));
			$pdf->Ln();
			$pdf->SetXY(170,92);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,97);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,97);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,97);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,104);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,107);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
			
			$pdf->SetXY(11,120);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,122);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,122);
			$pdf->Cell(50,5,utf8_decode_1("Neto  : "));
			$pdf->Ln();
			$pdf->SetXY(170,127);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,132);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,132);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,132);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,140);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,142);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
			
				
			$pdf->SetXY(11,155);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,157);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,157);
			$pdf->Cell(50,5,utf8_decode_1("Neto : "));
			$pdf->Ln();
			$pdf->SetXY(170,162);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,167);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,167);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,167);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,175);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,177);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
				
			$pdf->SetXY(11,190);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,192);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,192);
			$pdf->Cell(50,5,utf8_decode_1("Neto : "));
			$pdf->Ln();
			$pdf->SetXY(170,197);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,202);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,202);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,202);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,209);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,211);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
	
			$pdf->SetXY(11,225);
			$pdf->Cell(195,30,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,227);
			$pdf->Cell(50,5,utf8_decode_1("Renovacion o Saldo por                          dias a "));
			$pdf->SetXY(170,227);
			$pdf->Cell(50,5,utf8_decode_1("Neto : "));
			$pdf->Ln();
			$pdf->SetXY(170,232);
			$pdf->Cell(50,5,utf8_decode_1("Iva    : "));
			$pdf->Ln();
			$pdf->SetXY(15,237);
			$pdf->Cell(50,5,utf8_decode_1("Vence"));
			$pdf->SetXY(65,237);
			$pdf->Cell(50,5,utf8_decode_1("Nro Factura"));
			$pdf->SetXY(170,237);
			$pdf->Cell(50,5,utf8_decode_1("Total :"));
			$pdf->Ln();
			$pdf->SetXY(15,244);
			$pdf->Cell(185,0,utf8_decode_1(" "),1,0,'C',0);
			$pdf->Ln();
			$pdf->SetXY(15,247);
			$pdf->Cell(50,5,utf8_decode_1("Observaciones"));
			$pdf->Ln();
	
	
	ob_flush();		
	?>