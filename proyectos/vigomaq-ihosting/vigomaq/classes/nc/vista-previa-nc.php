<?php 
ob_start(); 
session_start(); 


function buscar_nro($frase,$limite_actual){
	if (substr($detalle,$limite_actual-1,$limite_actual)!=' '){
		buscar_nro(substr($detalle,0,$limite_actual),$limite_actual-1);
		}
	else{
		return count($frase);
		}
	}
	
	
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

$num_nc = $_GET['num_gd'];
$tipo = "";

require('../fpdf.php');
require('../htmlparser.inc');
include("../conex.php");

	class PDF extends FPDF{
			var $widths; 
			var $aligns; 
			// Cabecera de página
			function Header(){
				// Logo
				//$this->Image('../../images/fondo_nc.png',0,0,215);
				}
			
			function SetWidths($w) 	{ 
				//Set the array of column widths 
				$this->widths=$w; 
				} 
			
			function SetAligns($a) 			{ 
				//Set the array of column alignments 
				$this->aligns=$a; 
				} 
			
			function fill($f){
				//juego de arreglos de relleno
				$this->fill=$f;
			}
			
			function Row($data)  { 
				//Calculate the height of the row 
				$nb=0; 
				for($i=0;$i<count($data);$i++) 
					$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
				$h=5*$nb; 
				//Issue a page break first if needed 
				$this->CheckPageBreak($h); 
				//Draw the cells of the row 
				for($i=0;$i<count($data);$i++) { 
					$w=$this->widths[$i]; 
					$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
					//Save the current position 
					$x=$this->GetX(); 
					$y=$this->GetY(); 
					//Draw the border 
					//$this->Rect($x,$y,$w,$h,$style); 
					//Print the text 
					$this->MultiCell($w,5,$data[$i],'0',$a,$fill); 
					//Put the position to the right of the cell 
					$this->SetXY($x+$w,$y); 
				} 
				//Go to the next line 
				$this->Ln($h); 
			} 
			
			function CheckPageBreak($h) { 
				//If the height h would cause an overflow, add a new page immediately 
				if($this->GetY()+$h>$this->PageBreakTrigger) 
					$this->AddPage($this->CurOrientation); 
			} 
			
			function NbLines($w,$txt) { 
				//Computes the number of lines a MultiCell of width w will take 
				$cw=&$this->CurrentFont['cw']; 
				if($w==0) 
					$w=$this->w-$this->rMargin-$this->x; 
				$wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
				$s=str_replace("\r",'',$txt); 
				$nb=strlen($s); 
				if($nb>0 and $s[$nb-1]=="\n") 
					$nb--; 
				$sep=-1; 
				$i=0; 
				$j=0; 
				$l=0; 
				$nl=1; 
				while($i<$nb) { 
					$c=$s[$i]; 
					if($c=="\n") 	{ 
						$i++; 
						$sep=-1; 
						$j=$i; 
						$l=0; 
						$nl++; 
						continue; 
					} 
					if($c==' ') 
						$sep=$i; 
					$l+=$cw[$c]; 
					if($l>$wmax) 					{ 
						if($sep==-1) 						{ 
							if($i==$j) 
								$i++; 
						} 
						else 
							$i=$sep+1; 
						$sep=-1; 
						$j=$i; 
						$l=0; 
						$nl++; 
					} 
					else 
						$i++; 
				} 
				return $nl; 
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

		if (empty($num_nc)) $num_nc = $_GET['num_nc'];
		$link=Conectarse();
		
		$sqlguia = "SELECT * FROM nota_credito WHERE num_nota_cred ='$num_nc'";						
		
		$resguia = mysql_query($sqlguia,$link) or die(mysql_error()); 
		$registronc = mysql_fetch_array($resguia);

		$num_nc       	=	$registronc['num_nota_cred'];
		$cod_cli  		=	$registronc['cod_cliente'];
		$num_factura 	= 	$registronc['num_factura'];
		$fecha 			= 	$registronc['fecha'];
		$accion 		= 	$registronc['accion'];
		
		$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
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
			$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM clientes WHERE rut_cliente ='$valor1'";
			$res = mysql_query($sql,$link) or die(mysql_error()); 
			$registro = mysql_fetch_array($res);
			}

	mysql_query("SET NAMES utf8");   


 		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
 		// echo($sql3);
 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
 		$registrociu = mysql_fetch_array($resciu);

 		$sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
 		// echo($sql3);
 		$rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
 		$registrocom = mysql_fetch_array($rescom);

	
	$xmlstr = '<?xml version="1.0" encoding="utf-8"?>
				<DTE version="1.0">
					<Documento ID="R76836180-0T61F'.$num_nc.'">
						<Encabezado>
							<IdDoc>
			            		<TipoDTE>61</TipoDTE>
					            <Folio>'.$num_nc.'</Folio>
					            <FchEmis>'.$registronc['fecha'].'</FchEmis>
					            <FchVenc>'.$registronc['fecha'].'</FchVenc>
			        	  	</IdDoc>
			          		<Emisor>
					            <RUTEmisor>76836180-0</RUTEmisor>
					            <RznSoc>Sociedad de Inversiones y Servicios Vigomaq Ltda</RznSoc>
					            <GiroEmis>Arriendo, Venta y Reparación de  Maquinaria de Construcción</GiroEmis>
					            <Acteco>773002</Acteco>
					            <DirOrigen>AVDA CARLOS IBANEZ DEL C 3114 ACHUPALLAS</DirOrigen>
					            <CmnaOrigen>VINA DEL MAR</CmnaOrigen>
					            <CiudadOrigen>VINA DEL MAR</CiudadOrigen>
					        </Emisor>
					        <Receptor>
					        	<RUTRecep>'.str_replace('.', '', $registro['rut_cliente']).'</RUTRecep>
					            <RznSocRecep>'.substr(str_replace("Ã‘",'N',$registro['raz_social']),0,100).'</RznSocRecep>
					            <GiroRecep>'.substr(str_replace("Ã‘",'N',$registro['giro_cliente']),0,40).'</GiroRecep>
					            <Contacto>'.substr($registro['fono_cliente'],0,80).'</Contacto>
					            <DirRecep>'.substr(str_replace('Ã','',str_replace("Ã‘",'N',$registro['direcc_cliente'])),0,70).'</DirRecep>
					            <CmnaRecep>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$registrocom['comuna'])),0,20).'</CmnaRecep>
					            <CiudadRecep>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$registrociu['ciudad'])),0,20).'</CiudadRecep>
					        </Receptor>
					        ';

	$sqldet="SELECT sum(monto*cantidad) as neto, sum(monto*cantidad)*(19/100) as iva, sum(monto*cantidad)*(119/100) as total
 				FROM  det_nc
 				where num_nc = ".$num_nc." ";
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	while($registrodet = mysql_fetch_array($resdet)){
		$neto = $registrodet['neto'];
		$iva = $registrodet['iva'] ;
		$total = $registrodet['total'] ;
		if ($accion=='2'){
			$neto = '0';
			$iva = '0';
			$total = '0';
			}
		$xmlstr .= 				'<Totales>
						            <MntNeto>'.$neto.'</MntNeto>
						            <TasaIVA>19</TasaIVA>
						            <IVA>'.number_format($iva,0,'','').'</IVA>
						            <MntTotal>'.number_format($total,0,'','').'</MntTotal>
						        </Totales>
						</Encabezado>
						        ';
		}

	$sqldet="SELECT *
 				FROM  det_nc
 				where num_nc = ".$num_nc." ";	
	$resdet = mysql_query($sqldet,$link) or die(mysql_error()); 
	$i=1;
	while ($registrodet = mysql_fetch_array($resdet)) {
		$detalle = $registrodet['referencias'];
		$total = $registrodet['cantidad'] * $registrodet['monto'];
		$xmlstr .=			'<Detalle>
	  					        <NroLinDet>'.$i.'</NroLinDet>
	  					        <NmbItem>'.substr(str_replace("Ã‘",'N','Nota de Crédito que corresponde a :'),0,80).'</NmbItem>
	  					        <DscItem>'.str_replace('Â‘','',str_replace("Ã‘",'N',$detalle)).'</DscItem>
	  					        <QtyItem>'.$registrodet['cantidad'].'</QtyItem>
	  					        <PrcItem>'.$registrodet['monto'].'</PrcItem>
	  					        <MontoItem>'.$total.'</MontoItem>
			  				</Detalle>
			  				';
		$i++;
		}

	$sql_fact = "select * from factura where num_factura = '".$num_factura."'";
	$res_fact = mysql_query($sql_fact,$link);
	$row_fact = mysql_fetch_array($res_fact);

	$sql_dte = "select * 
					from folios_dte 
					where (tipo ='33' and desde <= '".$num_factura."') ";
	$res_dte = mysql_query($sql_dte,$link);
	
	if (mysql_num_rows($res_dte)>0){
		$xmlstr .=' <Referencia>
							<NroLinRef>1</NroLinRef>
							<TpoDocRef>33</TpoDocRef>
							<FolioRef>'.$num_factura.'</FolioRef>
							<FchRef>'.$row_fact['fecha'].'</FchRef>
							<CodRef>'.$registronc['accion'].'</CodRef>
						</Referencia>';
		}
	else{
		$sql_dte = "select * 
					from folios_dte 
					where (tipo ='56' and desde <= '".$num_factura."') ";
		$res_dte = mysql_query($sql_dte,$link);
		
		if (mysql_num_rows($res_dte)>0){
		    $sqlnc     = "SELECT * FROM nota_credito WHERE num_nota_cred ='$num_factura'";
		    $resnc          = mysql_query($sqlnc,$link) or die(mysql_error()); 
		    $row_fact = mysql_fetch_array($res_nc);

			$xmlstr .=' <Referencia>
							<NroLinRef>1</NroLinRef>
							<TpoDocRef>56</TpoDocRef>
							<FolioRef>'.$num_factura.'</FolioRef>
							<FchRef>'.$row_fact['fecha'].'</FchRef>
							<CodRef>'.$registronc['accion'].'</CodRef>
						</Referencia>';
		
			}
		else{
			$xmlstr .=' <Referencia>
								<NroLinRef>1</NroLinRef>
								<TpoDocRef>30</TpoDocRef>
								<FolioRef>'.$num_factura.'</FolioRef>
								<FchRef>'.$row_fact['fecha'].'</FchRef>
								<CodRef>'.$registronc['accion'].'</CodRef>
							</Referencia>';
			}
		}
	$xmlstr .=			'
		        	</Documento>
	        	</DTE>';

	$xml = new SimpleXMLElement($xmlstr);
	
	header('Content-Type: text/xml');
	header("Content-Disposition: attachment; filename=nc_".$num_nc.".xml");
	
	echo $xml->asXML(); 

// 	$fecha_temp = explode("-",$registronc['fecha']);
// 	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
// 	$dia_texto="";
// 	switch($dyh['mon']){
// 		case 1: $dia_texto = "Enero"; break;
// 		case 2: $dia_texto = "Febrero"; break;
// 		case 3: $dia_texto = "Marzo"; break;
// 		case 4: $dia_texto = "Abril"; break;
// 		case 5: $dia_texto = "Mayo"; break;
// 		case 6: $dia_texto = "Junio"; break;
// 		case 7: $dia_texto = "Julio"; break;
// 		case 8: $dia_texto = "Agosto"; break;
// 		case 9: $dia_texto = "Septiembre"; break;
// 		case 10: $dia_texto = "Octubre"; break;
// 		case 11: $dia_texto = "Noviembre"; break;
// 		case 12: $dia_texto = "Diciembre"; break;
// 		default: $dia_texto = "Error";    
// 	}
// 	$dia_esp = "";
// 	switch($dyh['weekday']){
// 		case 'Monday'	: $dia_esp = "Lunes"; break;
// 		case 'Tuesday'	: $dia_esp = "Martes"; break;
// 		case 'Wednesday': $dia_esp = "Miércoles"; break;
// 		case 'Thursday'	: $dia_esp = "Jueves"; break;
// 		case 'Friday': $dia_esp = "Viernes"; break;
// 		case 'Saturday': $dia_esp = "Sábado"; break;
// 		case 'Sunday': $dia_esp = "Domingo"; break;
// 		default: $dia_texto = "Error";    
// 	}
	
// 	$fecha_gd = $dia_esp.", ".$dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  
// 	$pdf->SetXY(87,53);
// 	$pdf->Cell(50,5,utf8_decode_1($fecha_gd));
// 	$pdf->Ln();

// 	$pdf->SetXY(30,58);
// 	$pdf->Cell(50,5,utf8_decode_1($registro['raz_social']));
// 	$pdf->SetXY(170,58);
// 	$pdf->Cell(50,5,utf8_decode_1($registro['rut_cliente']));
// 	$pdf->Ln();

// 	$pdf->SetXY(30,64);
// 	$pdf->Cell(50,5,utf8_decode_1($registro['direcc_cliente']));
	
// 	if (!empty($registro['cod_ciudad']))  {
// 		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
// 		// echo($sql3);
// 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
// 		$registrociu = mysql_fetch_array($resciu);
// 		$pdf->SetXY(170,64);
// 		$pdf->Cell(50,5,utf8_decode_1($registrociu['ciudad']));
// 	}else{
// 		$pdf->SetXY(170,64);
// 		$pdf->Cell(50,5," ");
// 		} ; 
// 	$pdf->Ln();

// 	$pdf->SetXY(35,69);
// 	$pdf->Cell(50,5,utf8_decode_1($registro['giro_cliente']));
// 	$pdf->SetXY(85,69);
// 	$pdf->Cell(50,5,utf8_decode_1($registro['fono_cliente']));
	
// 	//guia de despacho
// 	$sql_prepa_001 = "select num_gd 
// 							from equipos_arriendo
// 							where nro_factura = ".$registronc['num_factura']."
// 							limit 0,1";	
// 	$res_prepa_001 = mysql_query($sql_prepa_001,$link) or die(mysql_error());
// 	$row_prepa_001 = mysql_fetch_array($res_prepa_001);
// 	$pdf->SetXY(142,69);
// 	if (empty($row_prepa_001['num_gd'])){
// 		$sql_prepa_002 = "SELECT * FROM factura WHERE num_factura ='".$registronc['num_factura']."'";						
// 		$res_prepa_002 = mysql_query($sql_prepa_002,$link) or die(mysql_error()); 
// 		$row_prepa_002 = mysql_fetch_array($res_prepa_002);
// 		$pdf->Cell(50,5,utf8_decode_1($row_prepa_002['observaciones']));
// 		}
// 	else{
// 		$pdf->Cell(50,5,utf8_decode_1($row_prepa_001['num_gd']));
// 		}


// 	//cond venta
// 	$sql_prepa_003 = "select cod_arriendo 
// 							from factura
// 							where num_factura = ".$registronc['num_factura']."
// 							limit 0,1";	
// 	$res_prepa_003 = mysql_query($sql_prepa_003,$link) or die(mysql_error());
// 	$row_prepa_003 = mysql_fetch_array($res_prepa_003);

// 	if (($row_prepa_003['cod_arriendo']!='')&&($row_prepa_003['cod_arriendo']!=0)){
		
// 		$sql_prepa_004 = "select forma_pago 
// 								from arriendo
// 								where cod_arriendo = ".$row_prepa_003['cod_arriendo']."
// 								limit 0,1";	
// 		$res_prepa_004 = mysql_query($sql_prepa_004,$link) or die(mysql_error());
// 		$row_prepa_004 = mysql_fetch_array($res_prepa_004);
	
// 		$sql_prepa_005 = "select forma_pago 
// 								from forma_pago
// 								where cod_forma_pago = ".$row_prepa_004['forma_pago']."
// 								limit 0,1";	
// 		$res_prepa_005 = mysql_query($sql_prepa_005,$link) or die(mysql_error());
// 		$row_prepa_005 = mysql_fetch_array($res_prepa_005);
	
// 		$pdf->SetXY(190,69);
// 		$pdf->Cell(50,5,utf8_decode_1($row_prepa_005['forma_pago']));
// 		}
// 	$pdf->Ln();
// 	$pdf->Ln();
// 	$pdf->Ln();

// 	$sqldet="SELECT  *
// 				FROM  det_nc
// 				where num_nc = ".$num_nc." ";
// 	$resdet = mysql_query($sqldet) or die(mysql_error()); 
// 	$tot_nc = 0;
// while ($registrodet = mysql_fetch_array($resdet)) {
// 		$pdf->SetFont('Arial','',10);
// 		$pdf->Cell(5,6," "); 
		
// 		$pdf->SetWidths(array(20,120,30,30));
// 		$pdf->SetAligns(array('C','L','C','C'));
// 		$pdf->Row(array($registrodet['cantidad'],utf8_decode_1($registrodet['referencias']),$registrodet['monto'],$registrodet['cantidad']*$registrodet['monto']));
// 		$pdf->Ln();
// 		$tot_nc = $tot_nc + ($registrodet['cantidad']*$registrodet['monto']);
// 		}
		
// 	$pdf->SetXY(180,140);
// 	$pdf->Cell(50,5,$tot_nc);

// 	$pdf->SetXY(180,145);
// 	$iva = $tot_nc*0.19;
// 	$pdf->Cell(50,5,$iva);

// 	$pdf->SetXY(180,150);
// 	$tot_iva = $tot_nc*1.19;
// 	$pdf->Cell(50,5,$tot_iva);
	
// 	$pdf->SetXY(50,140);
// 	$pdf->SetFont('Arial','',10);
// 	$tot_iva = number_format($tot_iva,0,",","");
// 	$pdf->Cell(100,5,"Son ".iconv('UTF-8', 'windows-1252',(strtoupper(docenumeros($tot_iva))))) ;
// 	$pdf->Ln();
		
// 	mysql_free_result($resdet);
// 	mysql_close($link); 
//  	$pdf->Output();
	?>