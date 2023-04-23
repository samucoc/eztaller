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
	if ($linea==1) $this->Rect($x,$y,$w,3); 
        //Print the text 
        $this->MultiCell($w,3,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln(3); 
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

	mysql_query("SET NAMES utf8");
	$anio	  =	$_SESSION["sige_anio_escolar_vigente"];


	$sql_esta = "select NombreEstablecimiento, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno, 
						DireccionEstablecimiento, CiudadEstablecimiento
				from Establecimiento
				";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$nombre_establecimiento = $row_esta['NombreEstablecimiento'];
	$direccion_establecimiento = $row_esta['DireccionEstablecimiento'];
	$CiudadEstablecimiento = $row_esta['CiudadEstablecimiento'];
	$resolucion = $row_esta['Resolucion'];
	$anio_resolucion = $row_esta['AnioResolucion'];
	$rbd_establecimiento = $row_esta['RBD'];
	$logo_establecimiento = $row_esta['Logo'];
	$foto = $row_esta['Foto'];
		
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Image('../'.$logo_establecimiento,17,7,20);
	$pdf->SetXY($x+50,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(100,15,utf8_decode('DECLARACION INDIVIDUAL DE ACCIDENTE ESCOLAR'),0,0,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->SetWidths(array(50));
	$pdf->SetAligns(array('C'));
	$pdf->Row(array(utf8_decode('')),0);
	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+150,$y+15);
	$pdf->SetWidths(array(40,10));
	$pdf->SetAligns(array('C','C'));
	$pdf->Row(array(utf8_decode('FISCAL O MUNICIPAL'),utf8_decode('1')),0);
	$pdf->SetXY($x+150,$y+20);
	$pdf->Row(array(utf8_decode('PARTICULAR'),utf8_decode('2')),0);
	$pdf->SetXY($x+150,$y+25);
	$pdf->Row(array(utf8_decode('SUBVENCIONADO'),utf8_decode('3')),0);
	$pdf->SetXY($x+150,$y+30);
	$pdf->Row(array(utf8_decode('ELECCION'),utf8_decode('3')),1);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,15,utf8_decode('A. INDIVIDUALIZACIÓN DEL ESTABLECIMIENTO'),0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->SetWidths(array(65,65,65));
	$pdf->SetAligns(array('C','C','C'));
	$pdf->Row(array(utf8_decode('Nombre Establecimiento'),utf8_decode('Ciudad'),utf8_decode('Comuna')),0);
	$pdf->Row(array(utf8_decode($nombre_establecimiento),utf8_decode($CiudadEstablecimiento),utf8_decode($CiudadEstablecimiento)),1);
	

	$da = $_GET['da_ncorr'];

	$sql_1 = "SELECT `da_ncorr`, `NumeroRutAlumno`, date_format(hora, '%d/%m/%Y %H:%i') as hora_1, 
					 hora as hora_temp, 
					 tipos_accidentes.nombre as nombre_ta, 
					 `NumeroRutTestigo1`, `NombreTestigo`, `NumeroRutTestigo2`, `NombreTestigo2`, `Observacion` 

			  FROM `declaracion_accidente` 
			  	inner join tipos_accidentes
						on declaracion_accidente.tipo_accidente = tipos_accidentes.ta_ncorr
				
			  WHERE da_ncorr = '".$da."'";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$row_1 = mysql_fetch_array($res_1);

	$sql_002 = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as pool,
						NombreCurso,
						sexo.Nombre as sexo_alumno,
						date_format(FechaNacimiento, '%Y') as anio_nacimiento, 
						DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`FechaNacimiento`)), '%Y')+0 AS age,
						DireccionParticularAlumno,
						Comuna
				from alumnos".$_SESSION['sige_anio_escolar_vigente']." 
					inner join Cursos
						on Cursos.CodigoCurso = alumnos".$_SESSION['sige_anio_escolar_vigente'].".CodigoCurso
					inner join sexo
						on sexo.sexo_ncorr = alumnos".$_SESSION['sige_anio_escolar_vigente'].".SexoAlumno
					inner join Comunas
						on Comunas.CodigoComuna = alumnos".$_SESSION['sige_anio_escolar_vigente'].".CodigoComuna
				where NumeroRutAlumno  = '".$row_1['NumeroRutAlumno']."'";
	$res_002 = mysql_query($sql_002, $conexion) or die(mysql_error());
	$row_002 = mysql_fetch_array($res_002);

	$pdf->Row(array(utf8_decode('Curso'),utf8_decode('Horario'),utf8_decode('Fecha Registro de los datos')),0);
	$pdf->Row(array(utf8_decode($row_002['NombreCurso']),utf8_decode($row_1['hora_1']),utf8_decode(date("d/m/Y"))),1);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,15,utf8_decode('B. INDIVIDUALIZACION DEL ACCIDENTADO '),0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->SetWidths(array(100,33,33,33));
	$pdf->SetAligns(array('C','C','C','C'));
	$pdf->Row(array(utf8_decode('Alumno'),utf8_decode('Sexo'),utf8_decode('Año Nacimiento'),utf8_decode('Edad')),0);
	$pdf->Row(array(utf8_decode($row_1['NumeroRutAlumno'].'-'.dv($row_1['NumeroRutAlumno']).' '.$row_002['pool']),utf8_decode($row_002['sexo_alumno']),utf8_decode($row_002['anio_nacimiento']),utf8_decode($row_002['age'])),1);
	$pdf->Row(array(utf8_decode('Dirección'),utf8_decode('Ciudad'),utf8_decode('Comuna'),utf8_decode('Codif. Com.')),0);
	$pdf->Row(array(utf8_decode($row_002['DireccionParticularAlumno']),utf8_decode($row_002['Comuna']),utf8_decode($row_002['Comuna']),utf8_decode('')),1);
	

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,15,utf8_decode('C. INFORME SOBRE EL ACCIDENTE (FECHA, HORA Y DÍA DE LA SEMANA EN QUE SE ACCIDENTO)'),0,0,'L');
	$pdf->SetFont('Arial','',8);
	
	$pdf->Ln();

	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('C','C'));
	$pdf->Row(array(utf8_decode('Día / Hora suceso'),utf8_decode('Tipo de Accidente')),0);

	list($f,$h) = explode(' ',$row_1['hora_temp']);
	list($a,$m,$d) = explode('-',$f); 

	$dia_semana = date('N',mktime(0,0,0,$m,$d+1,$a));
	
	if ($dia_semana=='1') $dia_semana = 'Domingo';
	if ($dia_semana=='2') $dia_semana = 'Lunes';
	if ($dia_semana=='3') $dia_semana = 'Martes';
	if ($dia_semana=='4') $dia_semana = 'Miércoles';
	if ($dia_semana=='5') $dia_semana = 'Jueves';
	if ($dia_semana=='6') $dia_semana = 'Viernes';
	if ($dia_semana=='7') $dia_semana = 'Sábado';
	
	$pdf->Row(array(utf8_decode($dia_semana.', '.$row_1['hora_1']),utf8_decode($row_1['nombre_ta'])),1);
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Numero Rut Testigo'),utf8_decode('Nombre Testigo')),0);
	$pdf->Row(array(utf8_decode($row_1['NumeroRutTestigo1'].'-'.dv($row_1['NumeroRutTestigo1'])),utf8_decode($row_1['NombreTestigo'])),1);
	$pdf->Row(array(utf8_decode($row_1['NumeroRutTestigo2'].'-'.dv($row_1['NumeroRutTestigo2'])),utf8_decode($row_1['NombreTestigo2'])),1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,15,utf8_decode('Circunstancia del Accidente (describa como ocurrió - causal)'),0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->SetWidths(array(150));
	$pdf->SetAligns(array('J','C'));
	$pdf->Row(array(utf8_decode($row_1['Observacion']),utf8_decode('__________________________')),0);
	$pdf->Row(array(utf8_decode(''),utf8_decode('Firma o Timbre Rector o Representante')),0);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,15,utf8_decode('SOLO ESTABLECIMIENTO ASISTENCIAL'),0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	
	$pdf->Cell(100,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(25,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(10,5,utf8_decode('S'),0,0,'C');
	$pdf->Cell(10,5,utf8_decode('S'),0,0,'C');
	$pdf->Cell(5,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(30,5,utf8_decode('Establecimiento'),0,0,'C');
		
	$pdf->Ln();
	
	$pdf->Cell(100,5,utf8_decode('____________________________________________________________'),0,0,'L');
	$pdf->Cell(25,5,utf8_decode('Código'),0,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(5,5,utf8_decode('-'),0,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
		
	$pdf->Ln();

	$pdf->Cell(100,5,utf8_decode('Establecimiento Asistencial'),0,0,'C');
	$pdf->Ln();
	$pdf->Ln();

	$pdf->Cell(100,5,utf8_decode('____________________________________________________________'),0,0,'L');
	$pdf->Ln();

	$pdf->Cell(100,5,utf8_decode('Diagnóstico Médico'),0,0,'C');
	$pdf->Ln();
	
	$pdf->Cell(60,5,utf8_decode('___________________________________'),0,0,'L');
	$pdf->Cell(40,5,utf8_decode('Hospitalización'),0,0,'L');
	$pdf->Cell(30,5,utf8_decode('Total días Hosp.'),0,0,'C');
	$pdf->Cell(40,5,utf8_decode('Incapacidad'),0,0,'L');
	$pdf->Cell(30,5,utf8_decode('Total días Incapacidad'),0,0,'L');
	$pdf->Ln();

	$pdf->Cell(60,5,utf8_decode('Parte del Cuerpo Afectada'),0,0,'C');
	$pdf->Cell(20,5,utf8_decode('SI=1 | NO=2'),0,0,'L');
	$pdf->Cell(20,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(30,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(20,5,utf8_decode('SI=1 | NO=2'),0,0,'L');
	$pdf->Cell(20,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Cell(10,5,utf8_decode(''),1,0,'L');
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->SetWidths(array(66,66,66));
	$pdf->SetAligns(array('J','J','J'));
	$pdf->Row(array(utf8_decode('Tipo de Incapacidad'),utf8_decode('Causa del cierre del caso'),utf8_decode('Fecha del cierre del caso')),0);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetWidths(array(66));
	$pdf->SetAligns(array('J'));
	$pdf->Row(array(utf8_decode('Leve = 1                                                     Temporal= 2                                                  Invalidez Parcial = 3                                                  Invalidez Total = 4                                                  Gran Invalidez = 5                                                  Muerte = 6')),0);	
	$pdf->SetXY($x+45,$y);
	$pdf->Cell(20,5,utf8_decode(''),1,0,'C');
		
	$pdf->SetXY($x+66,$y);	
	$pdf->SetWidths(array(66));
	$pdf->SetAligns(array('J'));
	$pdf->Row(array(utf8_decode('Alta Médica = 1                                                     Invalidez= 2                                                  Abandono Tratamiento = 3                                    Muerte = 4')),0);	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(20,5,utf8_decode(''),1,0,'C');
	
	$pdf->SetXY($x+132,$y);
	$pdf->Cell(20,5,utf8_decode(''),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(''),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(''),1,0,'C');
	$pdf->Ln();

	$pdf->Image('../../images/inp.jpg',177,13,25);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();

	$pdf->SetWidths(array(66,66,66));
	$pdf->SetAligns(array('J','J','C'));
	$pdf->Row(array(utf8_decode(''),utf8_decode(''),utf8_decode('____________________')),0);
	$pdf->Row(array(utf8_decode(''),utf8_decode(''),utf8_decode('Firma de Estadístico')),0);

			$pdf->Output();
		
	?>
