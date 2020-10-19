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



$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
$pdf->AliasNbPages();
$pdf->AddPage();

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(30, 25 , 30); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10);  

	$pdf->SetFont('Arial','B',16);


	mysql_query("SET NAMES utf8");

	$alumno 		=       $_GET['alumno'];
    $observacion    =       $_GET['observacion'];
	$certs    		=       $_GET['certificados'];

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
	

	$sql_pd = "select 
				concat(`NombresAlumno`,' ',`PaternoAlumno`,' ',`MaternoAlumno`) as nombre_alumno, 
				NumeroRutAlumno,
				DigitoRutAlumno,
				NombreCurso
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where NumeroRutAlumno = '".$alumno."'"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
		
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$nombre_alumno = $line_pd[0];
			$rut = $line_pd[1].'-'.$line_pd[2];
			$nombre_curso = $line_pd[3];
                       
		}
	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
    $pdf->Image('../'.$Logo,20,10,25);
		

	$pdf->SetFont('Arial','B',8	);
    $pdf->SetWidths(array(200));
	$pdf->SetAligns(array('C'));
    $pdf->SetTextColor(180,180,180);
	$pdf->Row(array(utf8_decode('Escuela Especial de Lenguaje "Arcoíris"')),0);
	$pdf->SetFont('Arial','',8	);
    $pdf->SetWidths(array(160));
	$pdf->SetAligns(array('C'));
    $pdf->Row(array(utf8_decode('secretaria@elarcoiris.cl - Sargento Candelaria Pérez Nº 290 Villa Alemana')),0);
	$pdf->Row(array(utf8_decode('FONO: 032- 2731164 CEL: 09- 57396239')),0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(160,5,'CERTIFICADO DE TRASLADO',0,0,'C');
	$pdf->Ln();
	$pdf->Ln();

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
	

	$pdf->SetFont('Arial','',10);
    $pdf->SetWidths(array(160));
	$pdf->SetAligns(array('J'));

	$pdf->Row([utf8_decode('Villa Alemana a '.$dia.' de '.$mes.' de '.$anio_actual.', se solicita traslado a Escuela Especial de Lenguaje del Alumno/a:')],0);
	$pdf->Ln();
	$pdf->Row([utf8_decode($nombre_alumno.', R.U.N.: '.$rut)],0);
	$pdf->Ln();
	$pdf->Row([utf8_decode('Quien cursa '.$nombre_curso.' con el diagnostico de Trastorno Especifico de Lenguaje EXPRESIVO')],0);
	$pdf->Ln();
	$pdf->Row([utf8_decode('Se hace entrega al apoderado la documentación original, para hacer efectivo el traslado a contar de esta fecha.')],0);
	$pdf->Ln();
	$pdf->Row([utf8_decode('Documentos entregados: ')],0);

	list($cert_1,$cert_2,$cert_3,$cert_4,$cert_5,$cert_6,$cert_7,$cert_8,$cert_9,$cert_0) = explode('_',$certs);

	$pdf->Ln();

	$cert_1=='1' ? $pdf->Cell(150,5,utf8_decode('Certificado de Nacimiento'),0,1,'L') : '';

	$cert_2=='1' ? $pdf->Cell(150,5,utf8_decode('Autorización de Evaluación'),0,1,'L') : '';

	$cert_3=='1' ? $pdf->Cell(150,5,utf8_decode('Anamnesis de ingreso'),0,1,'L') : '';

	$cert_4=='1' ? $pdf->Cell(150,5,utf8_decode('Informe Fonoaudiológico'),0,1,'L') : '';

	$cert_5=='1' ? $pdf->Cell(150,5,utf8_decode('Protocolos Fonoaudiológicos'),0,1,'L') : '';

	$cert_6=='1' ? $pdf->Cell(150,5,utf8_decode('Valoración general de salud'),0,1,'L') : '';

	$cert_7=='1' ? $pdf->Cell(150,5,utf8_decode('Formulario único de ingreso'),0,1,'L') : '';

	$cert_8=='1' ? $pdf->Cell(150,5,utf8_decode('Formulario único de reevaluación'),0,1,'L') : '';

	$cert_9=='1' ? $pdf->Cell(150,5,utf8_decode('Informe a la familia'),0,1,'L') : '';

	$cert_0=='1' ? $pdf->Cell(150,5,utf8_decode('Informe pedagógico'),0,1,'L') : '';

	$pdf->Ln();
	$pdf->Ln();
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
	$pdf->Image('../'.$Foto,75,180,70);
	$pdf->Text(75, 210, utf8_decode('JOSSELYN CAMPOS SANCHEZ')); 
	$pdf->Text(95, 215, utf8_decode('DIRECTORA')); 
	$pdf->Text(65, 220, utf8_decode('ESCUELA ESPECIAL DE LENGUAJE ARCOÍRIS')); 
	
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
	$pdf->Ln();
	$pdf->Text(150, 250, utf8_decode('Villa Alemana, '.$dia.' de '.$mes.' de '.$anio_actual)); 
	
	

	$pdf->Output();
		
	?>