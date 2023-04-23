<?php 
ob_start(); 
session_start(); 

$costo_tot=0;
$total_desc=0;

function cortarString($cadena, $largo, $caracter){
	$temporal = substr($cadena, $largo-1, 1);
	if ($temporal == $caracter){
		return $largo;
		}
	else{
		return cortarString($cadena, $largo-1, $caracter);
		}
	}

function hola($string, $strip_zeroes = false) {
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




$num_factura = $_GET['num_fact'];

require('../fpdf.php');
require('../htmlparser.inc');
include("../conex.php");

$link=Conectarse();

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
                    if ($uni == 3) $r .= "veintitrés ";
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
            if ($millo == 1) $r .= "un millón ";
            else if ($millo > 1) $r .= seisnumeros($millo, false) . "millones ";
            if ($units > 0) $r .= seisnumeros($units, true);
            return $r;
        } 
		
	class PDF extends FPDF{
			var $widths; 
			var $aligns; 
			// Cabecera de página
			function Header(){
				// Logo
				//$this->Image('../../images/back_gd.jpg',0,0,215);
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
		
$pdf=new PDF();
//$pdf=new FPDF();
$pdf->SetFont('Arial','',9);
$pdf->AddPage();


	if (empty($factura)) $factura = $_GET['num_fact'];
	$link=Conectarse();
	$sqlfact = "SELECT * FROM factura WHERE num_factura ='$factura'";						
	
	$resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
	$registrofact = mysql_fetch_array($resfact);
	$fact=$registrofact['num_factura'];
	$cod_cli=$registrofact['cod_cliente'];
	$fecha_factura=$registrofact['fecha'];
	$num_arriendo =  $registrofact['cod_arriendo'];
	
	$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
	$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
	$registrocliente = mysql_fetch_array($rescliente);
	$valor1=$registrocliente['rut_cliente'];
	if (empty($valor1)){
	
	}else{
			$link=Conectarse();
			$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente,
					 raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, 
					 nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2,
					 email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, 
					 cargo_resp3, movil_resp3, cond_env_fact 
					FROM clientes 
					WHERE rut_cliente ='$valor1'";
			
			
			$res = mysql_query($sql,$link) or die(mysql_error()); 
			$registro = mysql_fetch_array($res);
			
	}
	$fecha_temp = explode("-",$registrofact['fecha']);
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
	
	
	$fecha_factura_imprimir = $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  
	$fecha_factura = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
	$pdf->SetXY(130,51.5);
	$pdf->Cell(50,5,$fecha_factura_imprimir);
	$pdf->Ln();

	$pdf->SetXY(25,59.5);
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registro['raz_social'])) ;
	$pdf->SetXY(120,59.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,$registro['rut_cliente']) ;
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();

	$pdf->SetXY(25,68.5);
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registro['direcc_cliente']));
	if (!empty($registro['cod_comuna'])) {
		$sqlciu="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		$registrociu = mysql_fetch_array($resciu);;
		$pdf->SetXY(120,68.5);
		$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registrociu['comuna']));
	  }else{;
		$pdf->SetXY(120,68.5);
		$pdf->Cell(50,5," ");
	  } ;
	$pdf->Ln();

	$pdf->SetXY(25,77.5);
	$pdf->Cell(50,5,$registro['giro_cliente']);;
	if (!empty($registro['cod_ciudad'])){
		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		$registrociu = mysql_fetch_array($resciu);
		$pdf->SetXY(120,77.5);
		$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registrociu['ciudad']));
	}else{
		$pdf->SetXY(120,77.5);
		$pdf->Cell(50,5," ");
	} 
	$pdf->Ln(); 

	$sqlgd   = "SELECT * FROM arriendo WHERE cod_arriendo ='$num_arriendo'";

	$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
	$registrogd = mysql_fetch_array($resgd);
	if ((($registrogd['num_gd'])!='')&&(($registrogd['num_gd'])!=0)) {
		$num_gd     = $registrogd['num_gd'];
		}	
	else {
		$sqlgd   = "SELECT distinct num_gd FROM equipos_arriendo WHERE cod_arriendo ='$num_arriendo'";
	
		$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
		$registrogd = mysql_fetch_array($resgd);
		if (($registrogd['num_gd'])!='') {
			$num_gd     = $registrogd['num_gd'];
			}	
		else {
			$num_gd =  $registrofact['observaciones'];
		}
	}

	$pdf->SetXY(25,86.5);
	$pdf->Cell(50,5,$num_gd);
	$pdf->SetXY(120,86.5);
	$pdf->Cell(50,5,$registro['fono_cliente']) ;
	if(!empty($registrofact['cod_arriendo'])){
		$sqlfpago   = "SELECT forma_pago FROM arriendo WHERE cod_arriendo =".$registrofact['cod_arriendo'];
		$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
		$registrofp= mysql_fetch_array($resfpago);
		$forma_pago = $registrofp['forma_pago'];
		$sqlfpago  = "SELECT * FROM forma_pago WHERE cod_forma_pago ='$forma_pago'";
		$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
		$registropago= mysql_fetch_array($resfpago);
		}
	$pdf->SetXY(175,86.5);
	if (!empty($registropago['forma_pago'])){
		$total_string = strlen($registropago['forma_pago']);
		for ($i=0; $i<=($total_string/15);$i++){
			$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['forma_pago'],$i*15,15))));
			$pdf->Ln();
			$pdf->Cell(165,5,"");
			}
		$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['forma_pago'],$i*15,15)))) ;
		}
	else{
		$sqlfpago  = "SELECT gd.cond_venta, gd.tipo, factura.cond_venta as cond_venta_fact
						FROM factura
							left join gd 
								on factura.gd_rep = gd.num_gd
						WHERE factura.num_factura =".$num_factura;
		$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
		$registropago= mysql_fetch_array($resfpago);
		
		if (!empty($registropago['cond_venta'])){
			$total_string = strlen($registropago['cond_venta']);
			for ($i=0; $i<=($total_string/15);$i++){
				$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['cond_venta'],$i*15,15))));
				$pdf->Ln();
				$pdf->Cell(165,5,"");
				}
			$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['cond_venta'],$i*15,15)))) ;
			}
		elseif (!empty($registropago['tipo'])){
			$total_string = strlen($registropago['tipo']);
			for ($i=0; $i<=($total_string/15);$i++){
				$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['tipo'],$i*15,15))));
				$pdf->Ln();
				$pdf->Cell(165,5,"");
				}
			$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['tipo'],$i*15,15)))) ;
			}elseif (!empty($registropago['cond_venta_fact'])){
				$temp_string = $registropago['cond_venta_fact'];
				$total_string = strlen($temp_string);
				for ($i=0; $i<=($total_string/15);$i++){
					$pdf->Cell(15,5,utf8_decode( (substr($registropago['cond_venta_fact'],$i*15,15)) ));
					$pdf->Ln();
					$pdf->Cell(165,5,"");
					}
				$pdf->Cell(15,5,utf8_decode( (substr($registropago['cond_venta_fact'],$i*15,15)))) ;
				}
			else{
				$pdf->Cell(50,5,"") ;
			}
		}
	$pdf->Ln(); 

	if (!empty($registrofact['cod_arriendo'])){
		$sqlnumoc   = "SELECT num_oc FROM arriendo WHERE cod_arriendo =".$registrofact['cod_arriendo'];
		$resnumoc    = mysql_query($sqlnumoc,$link) or die(mysql_error()); 
		$registronumoc= mysql_fetch_array($resnumoc);
		}
	$pdf->SetXY(25,95.5);
	if (!empty($registronumoc['num_oc'])){
		$pdf->Cell(50,5,$registronumoc['num_oc']);
		}
	else{
		$sqlnumoc   = "SELECT * FROM factura WHERE num_factura ='$factura'";
		$resnumoc    = mysql_query($sqlnumoc,$link) or die(mysql_error()); 
		$registronumoc= mysql_fetch_array($resnumoc);
		$pdf->Cell(50,5,$registronumoc['oc_rep']);
		}

	
	$pdf->SetXY(25,95.5);
	$pdf->Cell(50,5,$registronumoc['num_oc']);
	
	if (($registrofact['cod_obra']!=0)||(!empty($registrofact['cod_obra']))){
		$sqlobra   = "SELECT nombre_obra FROM obra WHERE cod_obra =".$registrofact['cod_obra'];
		}
	elseif (!empty($registrofact['gd_rep'])) {
			$sqlobra   = "SELECT nombre_obra 
						FROM obra 
						WHERE cod_obra in (select cod_obra 
											from gd 
											where num_gd = ".$registrofact['gd_rep'].")";
		}
	$nombre_obra="";
	if (!empty($sqlobra)){
		$resobra    = mysql_query($sqlobra,$link) or die(mysql_error()); 
		$registrobra= mysql_fetch_array($resobra);
		$nombre_obra = $registrobra['nombre_obra'];
	}
	$pdf->SetXY(105,95.5);
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$nombre_obra));

	$sqldet="SELECT * FROM  det_factura where num_factura = '$factura' order by cod_repuesto ASC";
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	$pdf->Ln(23); 
	$costo_tot=0;
	
	while ($registrodet = mysql_fetch_array($resdet)) {
		$total_desc=0;
		$porcentaje_emitir = 0;
		$total_neto = 0;
		$detalle="";
		$detalle_1="";
		$dias_arriendo = $registrodet['dias_arriendo'];
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(5,6,"");
		if (($registrodet['cod_repuesto'] == 0 )&&($registrodet['cod_equipo'] == 0 )) {

			$pdf->SetWidths(array(20,100,20,27,20));
			$pdf->SetAligns(array('L','L','L','L','L'));
			
			$detalle = $registrodet['otros_reparacion'];
			
			$pdf->Row(array($registrodet['cantidad'],hola(hola($detalle)),"$".number_format($registrodet['valor_unitario'], 0, ",", "."),"","$".number_format($registrodet['total_rep'], 0, ",", ".")));
			$costo_tot = $costo_tot + $registrodet['total_rep'];
			$pdf->Ln();
			
					
		}else{
			$pdf->Cell(30,6,$registrodet['dias_arriendo']);
		 	if (!empty($valor1)){
				$sqlnomob="SELECT nombre_equipo FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
				$resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
				$registronob = mysql_fetch_array($resnomob);
				$detalle .= "Dias Arriendo de ".($registronob['nombre_equipo']);

				$link=Conectarse();
				$num_arriendo = $registrofact['cod_arriendo'];
				$sqlperiodo="SELECT *
							FROM equipos_arriendo
								inner join gd
									on equipos_arriendo.cod_arriendo = gd.id_arriendo
								inner join factura 
									on factura.cod_arriendo = equipos_arriendo.cod_arriendo
								where equipos_arriendo.cod_arriendo =".$num_arriendo." 
									and equipos_arriendo.cod_equipo =".$registrodet['cod_equipo']." 
									and factura.num_factura = '".$num_factura."'
									and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
								order by equipos_arriendo.arrendado_hasta desc
							limit 0,1
					 ";

				 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				 $registroper_row = mysql_num_rows($resperiodo);
					  if ($registroper_row==0){
						 $sqlperiodo=" SELECT *
									FROM equipos_arriendo
										inner join gd
											on equipos_arriendo.cod_arriendo = gd.id_arriendo
										inner join factura 
											on factura.cod_arriendo = equipos_arriendo.cod_arriendo
										where equipos_arriendo.nro_factura = '".$num_factura."'
										order by equipos_arriendo.arrendado_hasta desc
									limit 0,1";
						 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					  }
      			 $registroper = mysql_fetch_array($resperiodo); 				 
				 $hasta="";
				 if (!empty($registroper['arrendado_hasta'])){ 
					$fecha_temp = explode("-",$registroper['arrendado_hasta']);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

				}else{ 
					$hasta = "NO DEVUELTO";
					}
									 
				$fecha_temp = explode("-",$registroper['arrendado_desde']);
				//año-mes-dia
				//0 -> dia, 1 -> mes, 2 -> año
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
				$desde =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

    			$detalle_1 .= ("PERIODO DESDE ".$desde." AL ".$hasta);
				 
			}else{
					$detalle_1 .=(" ");
					 
			}
			$detalle = str_replace('?','°',$detalle);
			$pdf->Cell(100,6,($detalle));			  
			$link=Conectarse();
			$sqleval   = "SELECT valor_unidad_arr FROM equipo WHERE cod_equipo =".$registrodet['cod_equipo'];
			$resuni         = mysql_query($sqleval,$link) or die(mysql_error()); 
			$registroval    = mysql_fetch_array($resuni);
			$valor = $registroval['valor_unidad_arr'];
			//$valor = $registrodet['tot_arriendo']/$dias_arriendo;
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(20,6,"$".number_format($valor, 0, ",", "."),0);
		
			$total_neto = $dias_arriendo*$valor;
			$porcentaje_emitir = ($registrodet['porcentaje_vu']);
			if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
				$pdf->Cell(17,6," ",0);
				}
			else{
				$pdf->Cell(17,6,$porcentaje_emitir."%",0);
				}
		
			if (!empty($registrodet['total_rep'])) { 
				if ($porcentaje_emitir==100){
					$porcentaje_emitir=0;
					}
				$total_desc = $total_neto * (1 - ($porcentaje_emitir/100));
				//$total_desc = $total_neto * 1;
				$pdf->Cell(32,6,"$".number_format($total_desc, 0, ",", "."),0); 
				}
			else{ 
				if ($porcentaje_emitir==100){
					$porcentaje_emitir=0;
					}
				$total_desc = $total_neto * (1 - ($porcentaje_emitir/100));
				//$total_desc = $total_neto * 1;
				$pdf->Cell(32,6,"$".number_format($total_desc, 0, ",", "."),0);
				}
			$costo_tot = $costo_tot + ($total_desc);
			$pdf->Ln();
			$pdf->Cell(30);
			$pdf->Cell(100,6,iconv('UTF-8', 'windows-1252',($detalle_1)),0,0,'L');
			$pdf->Ln();
		}
	}
	
	mysql_free_result($res);
	mysql_close($link); 

	$link=Conectarse();
	$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
	$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
	$registroiva = mysql_fetch_array($resiva);
	$valor_iva = $registroiva['valor_iva'];
	$iva = $costo_tot * ($valor_iva/100);
	$total = $costo_tot + $iva;

	$pdf->SetXY(50,203.5);
	$pdf->SetFont('Arial','',10);
	$total = number_format($total,0,",","");
	$pdf->Cell(100,5,iconv('UTF-8', 'windows-1252',(strtoupper(docenumeros($total))))) ;
	$pdf->Ln();
	
	$pdf->SetXY(180,221);
	$pdf->Cell(100,5,(number_format($costo_tot, 0, ",", ".")));
	$pdf->Ln();
	
	$link=Conectarse();
	$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
	$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
	$registroiva = mysql_fetch_array($resiva);
	$valor_iva = $registroiva['valor_iva'];
	$iva = $costo_tot * ($valor_iva/100);

	$pdf->SetXY(180,230);
	$pdf->Cell(100,5,(number_format($iva, 0, ",", ".")));
	$pdf->Ln();
	
	$pdf->SetXY(180,238);
	$pdf->Cell(100,5,(number_format($total, 0, ",", ".")));
	$pdf->Ln();

$pdf->Output();
?>