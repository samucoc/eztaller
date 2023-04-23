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











require('../includes/php/fpdf/fpdf.php');

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 



mysql_query("SET NAMES 'utf8'");	





class PDF_Rotate extends FPDF {

var $angle=0;

var $widths; 

var $aligns; 



function SetWidths($w) { 

    //Set the array of column widths 

    $this->widths=$w; 

	} 



function SetAligns($a) { 

    //Set the array of column alignments 

    $this->aligns=$a; 

	} 



function fill($f){

	//juego de arreglos de relleno

	$this->fill=$f;

	}



function Row($data,$linea) { 

    //Calculate the height of the row 

    $nb=0; 

    for($i=0;$i<count($data);$i++) 

        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 

    $h=5*$nb; 

    //Issue a page break first if needed 

    $this->CheckPageBreak($h); 

    //Draw the cells of the row 

    for($i=0;$i<count($data);$i++) 

    { 

        $w=$this->widths[$i]; 

        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 

        //Save the current position 

        $x=$this->GetX(); 

        $y=$this->GetY(); 

        //Draw the border

	if ($linea==1) $this->Rect($x,$y,$w,$h); 

        //Print the text 

        $this->MultiCell($w,5,$data[$i],0,$a); 

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

	    while($i<$nb) 

	    { 

		$c=$s[$i]; 

		if($c=="\n") 

		{ 

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

		if($l>$wmax) 

		{ 

		    if($sep==-1) 

		    { 

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

	function Rotate($angle,$x=-1,$y=-1)

	{

	    if($x==-1)

		$x=$this->x;

	    if($y==-1)

		$y=$this->y;

	    if($this->angle!=0)

		$this->_out('Q');

	    $this->angle=$angle;

	    if($angle!=0)

	    {

		$angle*=M_PI/180;

		$c=cos($angle);

		$s=sin($angle);

		$cx=$x*$this->k;

		$cy=($this->h-$y)*$this->k;

		$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));

	    }

	}

	function RotatedText($x,$y,$txt,$angle)

	{

	    //Text rotated around its origin

	    $this->Rotate($angle,$x,$y);

	    $this->Text($x,$y,$txt);

	    $this->Rotate(0);

	}

	function _endpage()

	{

	    if($this->angle!=0)

	    {

		$this->angle=0;

		$this->_out('Q');

	    }

	    parent::_endpage();

	}

}

class PDF extends PDF_Rotate {

	//Cabecera de página

	function Header() {

		//Put the watermark

		$this->SetFont('Arial','B',50);

		//$this->Image('../images/boleta_cnm.jpg',0,0,215);

		}

		

	//Pie de página

	function Footer() {

		//Posición: a 1,5 cm del final

		$this->SetY(-15);

		//Arial italic 8

		$this->SetFont('Arial','I',8);

		//Número de página

		//$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');

	}

}





$pdf=new PDF('L','mm',array(215,140));

//$pdf=new FPDF();

$pdf->SetFont('Arial','',9);

$pdf->AddPage();



	$boleta = $_GET['boleta'];



	$sql_esta = "SELECT `NumeroRutEstablecimiento`, `DigitoRutEstablecimiento`, `NombreEstablecimiento`, 

						`DireccionEstablecimiento`, `CiudadEstablecimiento`, `TelefonoEstablecimiento`, 

						`FaxEstablecimiento`, `EMailEstablecimiento`, `NumeroRutRepresentante`,

						`DigitoRutRepresentante`, `PaternoRepresentante`, `MaternoRepresentante`, 

						`NombresRepresentante`, `PeriodoEstablecimiento`, `RegionEstablecimiento`, 

						`ProvinciaEstablecimiento`, `SemestreEstablecimiento`, `UnidadPenDrive`, `RBD`, 

						`NumeroDecreto`, `FechaDecreto`, `PeriodoPostulacion`, `PorcentajeSintesis`, 

						`CorrelativoCertificado`, `CelularEstablecimiento` , `Resolucion` , 

						`AnioResolucion` , `Foto`  , `Logo` FROM gescolcl_arcoiris_administracion.Establecimiento limit 0,1";

	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());

	$row_esta = mysql_fetch_array($res_esta);

	



	$anio = $_SESSION["sige_anio_escolar_vigente"];

	



	$nombre_establecimiento = $row_esta['NombreEstablecimiento'];

	$rut_estable 			= $row_esta['NumeroRutEstablecimiento'].'-'.dv($row_esta['NumeroRutEstablecimiento']);

	$nombre_repre			= $row_esta['NombresRepresentante'].' '.$row_esta['PaternoRepresentante'].' '.$row_esta['MaternoRepresentante'];

	$rut_repre				= $row_esta['NumeroRutRepresentante'].'-'.dv($row_esta['NumeroRutRepresentante']);

	$direccion_repre				= $row_esta['DireccionEstablecimiento'];

	$resolucion_estable = $row_esta['Resolucion'];

	$anio_resolu		= $row_esta['AnioResolucion'];



	$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('L'));



	$pdf->SetXY($pdf->GetX,$pdf->GetY+5);



	

$sql_boletas = "select distinct Movimientos.NumeroBoleta,  alumnos".$anio.".NumeroRutAlumno , PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso, PaternoApoderado, MaternoApoderado, NombresApoderado, date_format(FechaBoleta, '%d-%m-%Y') as FechaBoleta

			from gescolcl_arcoiris_administracion.Movimientos

				inner join gescolcl_arcoiris_administracion.alumnos".$anio."   	

					on Movimientos.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno 	 

				inner join gescolcl_arcoiris_administracion.Cursos   	

					on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso 	 

				inner join gescolcl_arcoiris_administracion.Apoderados   	

					on Apoderados.NumeroRutApoderado = alumnos".$anio.".NumeroRutApoderado 

				where Movimientos.NumeroBoleta = '".$boleta."'";

	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());



	$row_boletas = mysql_fetch_array($res_boletas);



	$pdf->SetWidths(array(185));

	$pdf->SetAligns(array('R'));

	$pdf->Row(array(utf8_decode($row_boletas['FechaBoleta'])),0);

	$pdf->Row(array(utf8_decode($boleta)),0);

	

	$pdf->SetXY($pdf->GetX,20);



	$pdf->SetWidths(array(85,115));

	$pdf->SetAligns(array('R','R'));

	$pdf->Row(array(utf8_decode($row_boletas['PaternoApoderado'].' '.$row_boletas['MaternoApoderado'].' '.$row_boletas['NombresApoderado']),utf8_decode($row_boletas['NombreCurso'])),0);

	$pdf->SetWidths(array(85,105));

	$pdf->SetAligns(array('R','R'));

	$pdf->Row(array(utf8_decode($row_boletas['PaternoAlumno'].' '.$row_boletas['MaternoAlumno'].' '.$row_boletas['NombresAlumno']),utf8_decode(number_format($row_boletas['NumeroRutAlumno'],0,',','.').'-'.dv($row_boletas['NumeroRutAlumno']))),0);

	

	$pdf->SetXY($pdf->GetX+20,35);



	$sql = "select sum(ValorBoleta) as ValorBoleta from gescolcl_arcoiris_administracion.Movimientos where NumeroBoleta = '".$boleta."'";

	$res = mysql_query($sql,$conexion);	       

	while($row = mysql_fetch_array($res)){

		$pdf->SetWidths(array(130,35));

		$pdf->SetAligns(array('L','R'));

		$sql_desc = "select DescripcionBoleta 

					from gescolcl_arcoiris_administracion.Movimientos 

					where NumeroBoleta = '".$boleta."'";

		$res_desc = mysql_query($sql_desc,$conexion);	       

		$desc="";

		while($row_desc = mysql_fetch_array($res_desc)){

			$desc .= $row_desc['DescripcionBoleta'].' - ';

			}

		$desc = str_replace ( 'Pago ' , '' , $desc);



		$sql_boletas = "select distinct `NumeroCheque`, `NombreBanco`, `ValorCheque`,FechaCheque, Cheques.NumeroBoleta, cheque_ncorr, PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso, PaternoApoderado, MaternoApoderado, NombresApoderado  

				from gescolcl_arcoiris_administracion.Cheques  	

					inner join gescolcl_arcoiris_administracion.Bancos 		

						on Cheques.CodigoBanco = Bancos.CodigoBanco 	

					inner join gescolcl_arcoiris_administracion.Movimientos_Cheques

						on Cheques.NumeroBoleta = Movimientos_Cheques.NumeroBoleta  	

					inner join gescolcl_arcoiris_administracion.alumnos".$anio."   	

						on Movimientos_Cheques.NumeroRutAlumno = alumnos".$anio.".NumeroRutAlumno 	 

					inner join gescolcl_arcoiris_administracion.Cursos   	

						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso 	 

					inner join gescolcl_arcoiris_administracion.Apoderados   	

						on Apoderados.NumeroRutApoderado = alumnos".$anio.".NumeroRutApoderado 

					where Cheques.NumeroBoleta = '".$boleta."' 

				";

		$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());



			while($row_boletas = mysql_fetch_array($res_boletas)){

				

				list($anio,$mes,$dia) = explode('-',$row_boletas['FechaCheque']);

				$fecha = $dia.'-'.$mes.'-'.$anio;



				$desc .= ' - '.$row_boletas['NombreBanco'].' - '.$row_boletas['NumeroCheque'].' - '.$fecha;

				

				$i++;

				}



		$pdf->Row(array($desc,number_format($row['ValorBoleta'],0,',','.')),0);

		$total += $row['ValorBoleta'];

		}



	$pdf->SetXY($pdf->GetX,54);

	

	$pdf->SetWidths(array(185));

	$pdf->SetAligns(array('R'));

	$pdf->Row(array(utf8_decode(number_format($total,0,',','.'))),0);

	



$pdf->Output();

?>