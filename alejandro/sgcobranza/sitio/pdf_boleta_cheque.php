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





        class PDF_Rotate extends FPDF

{

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





$pdf=new PDF();

//$pdf=new FPDF();

$pdf->SetFont('Arial','',9);

$pdf->AddPage();



	$boleta = $_GET['boleta'];

	$anio = $_SESSION["sige_anio_escolar_vigente"];

	

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

	

	$nombre_establecimiento = $row_esta['NombreEstablecimiento'];

	$rut_estable 			= $row_esta['NumeroRutEstablecimiento'].'-'.dv($row_esta['NumeroRutEstablecimiento']);

	$nombre_repre			= $row_esta['NombresRepresentante'].' '.$row_esta['PaternoRepresentante'].' '.$row_esta['MaternoRepresentante'];

	$rut_repre				= $row_esta['NumeroRutRepresentante'].'-'.dv($row_esta['NumeroRutRepresentante']);

	$direccion_repre				= $row_esta['DireccionEstablecimiento'];

	$resolucion_estable = $row_esta['Resolucion'];

	$anio_resolu		= $row_esta['AnioResolucion'];



	$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('L'));



	$pdf->Row(array(utf8_decode($nombre_establecimiento)),0);

	$pdf->Row(array(utf8_decode($direccion_repre)),0);

	$pdf->Row(array(utf8_decode('')),0);

	

	$pdf->Ln();

	

	$pdf->SetWidths(array(190));

	$pdf->SetAligns(array('R'));

	$pdf->Row(array(utf8_decode('Nro. __________')),0);

	

	$pdf->Ln();

	$pdf->Ln();



	$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('C'));

	$pdf->Row(array(utf8_decode('Comprobante de recepción de Cheques.')),0);

	

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

				where Cheques.NumeroBoleta = '".$boleta."'";

	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());



	$row_boletas = mysql_fetch_array($res_boletas);



			$pdf->Ln();



			$pdf->SetWidths(array(50,140));

			$pdf->SetAligns(array('L','L'));

			$pdf->Row(array(utf8_decode('Apoderado'),utf8_decode($row_boletas['PaternoApoderado'].' '.$row_boletas['MaternoApoderado'].' '.$row_boletas['NombresApoderado'])),1);

			$alumno = $row_boletas['PaternoAlumno'].' '.$row_boletas['MaternoAlumno'].' '.$row_boletas['NombresAlumno'].' del curso '.$row_boletas['NombreCurso'];



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



			$pdf->SetWidths(array(50,50,50,40));

			$pdf->SetAligns(array('L','L','L','L'));

			$pdf->Row(array(utf8_decode('Banco'),utf8_decode('Nro. Cheque'),utf8_decode('Fecha'),utf8_decode('Monto')),1);

			$pdf->Row(array(utf8_decode($row_boletas['NombreBanco']),utf8_decode($row_boletas['NumeroCheque']),utf8_decode($fecha),utf8_decode($row_boletas['ValorCheque'])),1);

			

			$i++;

			}



$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('L'));



			$pdf->Ln();

			$pdf->Ln();

	$pdf->Row(array(utf8_decode('Correspondiente al pago de la colegiatura correspondiente al alumno')),0);

	$pdf->Row(array(utf8_decode($alumno)),0);



			$pdf->Ln();

			$pdf->Ln();



list($anio,$mes,$dia) = explode('-',date("Y-m-d"));

	if ($mes=='1'){

		$mes_ele = 'Enero';

		}

	else if ($mes=='2'){

		$mes_ele = 'Febrero';

		}

	else if ($mes=='3'){

		$mes_ele = 'Marzo';

		}

	else if ($mes=='4'){

		$mes_ele = 'Abril';

		}

	else if ($mes=='5'){

		$mes_ele = 'Mayo';

		}

	else if ($mes=='6'){

		$mes_ele = 'Junio';

		}

	else if ($mes=='7'){

		$mes_ele = 'Julio';

		}

	else if ($mes=='8'){

		$mes_ele = 'Agosto';

		}

	else if ($mes=='9'){

		$mes_ele = 'Septiembre';

		}

	else if ($mes=='10'){

		$mes_ele = 'Octubre';

		}

	else if ($mes=='11'){

		$mes_ele = 'Noviembre';

		}

	else if ($mes=='12'){

		$mes_ele = 'Diciembre';

		}

	$fecha_letras = $dia.' de '.$mes_ele.' de '.$anio;



	$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('L'));



			$pdf->Ln();

			$pdf->Ln();

	$pdf->Row(array(utf8_decode('Villa Alemana, '.$fecha_letras)),0);





$pdf->Output();

?>