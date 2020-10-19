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











require('../includes/php/fpdf.php');

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



	$alumno = $_POST['rut_alumno'];

	$anio_vigente = $_POST['periodo'];



	$sql_esta = "SELECT `NumeroRutEstablecimiento`, `DigitoRutEstablecimiento`, `NombreEstablecimiento`, 

						`DireccionEstablecimiento`, `CiudadEstablecimiento`, `TelefonoEstablecimiento`, 

						`FaxEstablecimiento`, `EMailEstablecimiento`, `NumeroRutRepresentante`,

						`DigitoRutRepresentante`, `PaternoRepresentante`, `MaternoRepresentante`, 

						`NombresRepresentante`, `PeriodoEstablecimiento`, `RegionEstablecimiento`, 

						`ProvinciaEstablecimiento`, `SemestreEstablecimiento`, `UnidadPenDrive`, `RBD`, 

						`NumeroDecreto`, `FechaDecreto`, `PeriodoPostulacion`, `PorcentajeSintesis`, 

						`CorrelativoCertificado`, `CelularEstablecimiento` , `Resolucion` , 

						`AnioResolucion` , `Foto`  , `Logo` FROM gescolcl_nmva_administracion.Establecimiento limit 0,1";

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

	$pdf->Ln();



	$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('C'));

	$pdf->Row(array(utf8_decode('COMPROBANTE DE RECEPCION DE DINERO')),0);

	

		$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,

								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado,

								DireccionParticularApoderado, Ciudad

					from gescolcl_nmva_administracion.Apoderados

						inner join gescolcl_nmva_administracion.Ciudades 

							on Apoderados.CiudadParticularApoderado = Ciudades.CodigoCiudad

						inner join gescolcl_nmva_administracion.Postulantes

							on Apoderados.NumeroRutApoderado = Postulantes.ApoderadoPostulante

								and `PeriodoPostulacion` = '".$anio_vigente."' AND `NumeroRutAlumno` = '".$alumno."'

					";

	$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

	$row_apoderado = mysql_fetch_array($res_apoderado);

	

	$rut_apoderado = $row_apoderado['NumeroRutApoderado'].'-'.dv($row_apoderado['NumeroRutApoderado']);

	$nombre_apoderado = $row_apoderado['nombre'];

	$direccion_apoderado = $row_apoderado['DireccionParticularApoderado'];

	$ciudad_apoderado = $row_apoderado['Ciudad'];





	$sql_pd = "select 

				distinct

				Cursos.NombreCurso as NombreCurso,

				concat(`NombresAlumno`,' ',`PaternoAlumno`,' ',`MaternoAlumno`) as nombre_alumno,

				FechaNacimiento, DireccionParticularAlumno, TelefonoParticularAlumno

				from gescolcl_nmva_administracion.Cursos

					inner join gescolcl_nmva_administracion.Postulantes

						on Postulantes.CodigoCurso = Cursos.CodigoCurso

				where

					Postulantes.NumeroRutAlumno = '".$alumno."' and PeriodoPostulacion = '".$anio_vigente."'"; 

	$res_pd = mysql_query($sql_pd,$conexion) or die(mysql_error());

	$row_pd = mysql_fetch_array($res_pd);

	$nombre_alumno = $row_pd['nombre_alumno'];

	$nombre_curso = $row_pd['NombreCurso'];



			$pdf->Ln();



	

	// $sql_ve = "select  

	// 				ValorIncorporacion, ValorColegiatura

	// 			from Aranceles

	// 			where CodigoNivel in (select CodigoNivel

	// 									from Cursos

	// 									where CodigoCurso in (

	// 															select CodigoCurso

	// 															from Postulantes

	// 															where NumeroRutAlumno = '".$alumno."'  and 

	// 																	AnioPeriodo = '".$anio_vigente."'

	// 														)

	// 								)

	// 				";

	// $res_ve = mysql_query($sql_ve,$conexion) or die(mysql_error());

	// $line_ve = mysql_fetch_array($res_ve);

	// $incorporacion = $line_ve['ValorIncorporacion'];



	$incorporacion = $_POST['incorporacion'];

	$colegiatura = $_POST['colegiatura']/10;

	$total_colegiatura = $_POST['colegiatura'];



	$rut_alumno = $alumno.'-'.dv($alumno);



	$pdf->SetWidths(array(50,200));

	$pdf->SetAligns(array('L','L'));

	$pdf->Row(array(utf8_decode('Recibí de Don(ña) :'),utf8_decode(utf8_decode($nombre_apoderado).', Rut: '.$rut_apoderado)),0);

	$pdf->Row(array(utf8_decode('Apoderado de :'),utf8_decode($nombre_alumno.', Rut: '.$rut_alumno)),0);

	$pdf->Row(array(utf8_decode('Curso :'),utf8_decode($nombre_curso)),0);



	$pdf->Ln();

	$pdf->Ln();

	$pdf->Ln();

	$pdf->Ln();



	$pdf->Row(array(utf8_decode('Por los siguientes Conceptos'),''),0);

	$pdf->Row(array(utf8_decode('Abono Colegiatura '.$anio_vigente),'$ '.number_format($incorporacion,0,',','.')),0);

	

	$pdf->Ln();

	$pdf->Ln();

	$pdf->Ln();

	$pdf->Ln();



	$pdf->Row(array(utf8_decode('___________________________'),''),0);

	$pdf->Ln();

	$pdf->Row(array(utf8_decode('Firma y Timbre Establecimiento'),''),0);



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



    $pdf->SetWidths(array(125,75));

	$pdf->SetAligns(array('L','L'));



			$pdf->Ln();

			$pdf->Ln();

	$pdf->Row(array(utf8_decode(''),utf8_decode('Villa Alemana, '.$fecha_letras)),0);





$pdf->Output();

?>