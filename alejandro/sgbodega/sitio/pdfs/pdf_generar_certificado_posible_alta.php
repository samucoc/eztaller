<?php
ob_start();
session_start();

include "../../includes/php/conf_bd.php"; 
include "../../includes/php/validaciones.php"; 
include "../../includes/php/fpdf/fpdf.php"; 
include "../../includes/php/phpmailer/class.phpmailer.php"; 
include "../../includes/php/phpmailer/class.pop3.php"; 
include "../../includes/php/phpmailer/class.smtp.php"; 



function rojo($pdf,$val){
              $pdf->SetTextColor(255,0,0);
              return $pdf->Text(0,0,$val);
              }

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
        $this->MultiCell($w,7,$data[$i],0,$a); 
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



$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
$pdf->AliasNbPages();
$pdf->AddPage();

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(30, 25 , 30); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10);  

	$pdf->SetFont('Arial','B',16);


	mysql_query("SET NAMES utf8");

	$alumno                     =       $_GET['alumno'];
    $observacion                     =       $_GET['observacion'];

    $anio =   $_SESSION["sige_anio_escolar_vigente"];

	$sql_esta = "select NombreEstablecimiento, Resolucion, AnioResolucion, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno
				from Establecimiento
				";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$nombre_colegio = $row_esta['NombreEstablecimiento'];
	$resolucion = $row_esta['Resolucion'];
	$anio_resolucion = $row_esta['AnioResolucion'];
	$RBD = $row_esta['RBD'];
	$Logo = $row_esta['Logo'];
	$Foto = $row_esta['Foto'];
	$Representante = $row_esta['nombre_alumno'];
	$anio = $_SESSION["sige_anio_escolar_vigente"];
	
	$sql_pd = "select 
				concat(`NombresAlumno`,' ',`PaternoAlumno`,' ',`MaternoAlumno`) as nombre_alumno, 
				DescripcionLarga,
				DiagnosticoTEL,
				concat(`NombresProfesor`,' ',`PaternoProfesor`,' ',`MaternoProfesor`) as nombre_profesor,
				RegistroMineduc,
				Profesores.Firma
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Profesores
						on alumnos".$anio.".Fonoaudiologa = Profesores.NumeroRutProfesor
				where NumeroRutAlumno = '".$alumno."'"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	$arrRegistros		= 	array();
	$i 					= 	1;
	$flag= '';
		
	while ($line_pd = mysql_fetch_row($res_pd)) {
		
		$nombre_alumno = $line_pd[0];
		$DescripcionLarga = $line_pd[1];
		$diagnostico_alumno = $line_pd[2];
		if ($diagnostico_alumno == '1') {
			$diagnostico_alumno = 'TEL MIXTO' ;	
		}else if ($diagnostico_alumno == '2'){
			$diagnostico_alumno = 'TEL EXPRESIVO' ;
		}else if ($diagnostico_alumno == '3') {
			$diagnostico_alumno = 'En Observación'	;
		} else {
			$diagnostico_alumno = 'Sin Diagnóstico';
		}
		$nombre_profesor = $line_pd[3];
		$registro_mineduc = $line_pd[4];
		$firma = $line_pd[5];
	}

	$pdf->SetTextColor(0,0,0);
	$pdf->Image('../'.$Logo,10,10,25);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(160,5,'CERTIFICADO ',0,1,'C');
	$pdf->Ln();
	$pdf->Cell(160,5,'POSIBLE ALTA FONOAUDIOLOGICA',0,1,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->SetFont('Arial','',12);
    $pdf->SetWidths(array(160));
	$pdf->SetAligns(array('J'));
	$pdf->Row(array(utf8_decode('La Fonoaudióloga que suscribe, certifica que '.$nombre_alumno.' asiste a la Escuela Especial de Lenguaje "Arcoíris" en '.$DescripcionLarga.', con diagnóstico de '.$diagnostico_alumno.', y se encuentra en situación de POSIBLE ALTA de su trastorno específico de lenguaje.')),0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Durante los meses de Noviembre y Diciembre del presente año, se llevará a cabo el proceso de reevaluación fonoaudiológica en que se determinará la situación final del alumno(a).')),0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Se extiende el presente certificado a petición del apoderado para los fines que estime conveniente.')),0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();

	
	$pdf->SetWidths(array(160));
	$pdf->SetAligns(array('C'));
	//firma-tiembre-arcoiris.png
	$pdf->Image('../'.$firma,75,140,60);
	// $pdf->Row(array(utf8_decode($nombre_profesor)),0);
	// $pdf->Row(array(utf8_decode('Fonoaudiólogo(a)')),0);
	// $pdf->Row(array(utf8_decode($registro_mineduc)),0);
	
	$pdf->SetWidths(array(160));
	$pdf->SetAligns(array('R'));
	$dia = date("d");
	$mes = date("m");
	$anio_actual = date("Y");

	if ($mes=='1') $mes = 'Enero';
	if ($mes=='2') $mes = 'Febrero';
	if ($mes=='3') $mes = 'Marzo';
	if ($mes=='4') $mes = 'Abril';
	if ($mes=='5') $mes = 'Mayo';
	if ($mes=='6') $mes = 'Junio';
	if ($mes=='7') $mes = 'Julio';
	if ($mes=='8') $mes = 'Agosto';
	if ($mes=='9') $mes = 'Septiembre';
	if ($mes=='10') $mes = 'Octubre';
	if ($mes=='11') $mes = 'Noviembre';
	if ($mes=='12') $mes = 'Diciembre';
	
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Villa Alemana, '.$dia.' de '.$mes.' de '.$anio_actual)),0);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
    $pdf->SetWidths(array(160));
	$pdf->SetAligns(array('C'));
    $pdf->SetTextColor(180,180,180);
	$pdf->Row(array(utf8_decode('Escuela Especial de Lenguaje "Arcoíris"')),0);
	$pdf->SetFont('Arial','',8	);
    $pdf->SetWidths(array(160));
	$pdf->SetAligns(array('C'));
    $pdf->Row(array(utf8_decode('secretaria@elarcoiris.cl - Sargento Candelaria Pérez Nº 290 Villa Alemana')),0);
	$pdf->Row(array(utf8_decode('FONO: 032- 2731164 CEL: 09- 57396239')),0);
	
	$pdf->Output();
		
	?>