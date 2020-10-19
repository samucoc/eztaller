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
        $this->MultiCell($w,10,$data[$i],0,$a); 
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

	mysql_query("SET NAMES utf8");
	$anio =   $_SESSION["sige_anio_escolar_vigente"];

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
	$pdf->Cell(100,15,utf8_decode('REGISTRO DE ENTREVISTA A APODERADOS'),0,0,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->SetWidths(array(50));
	$pdf->SetAligns(array('C'));
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Ln();
	
	$sql_bitacora = "select *, alumnos".$_SESSION["sige_anio_escolar_vigente"].".NumeroRutAlumno, 
							concat(PaternoAlumno,' ', MaternoAlumno,', ', NombresAlumno) as nombre_alumno,
							Apoderados.NumeroRutApoderado, concat(PaternoApoderado,' ', MaternoApoderado,', ', NombresApoderado) as nombre_apoderado,
							Cursos.CodigoCurso, NombreCurso, 
							BitacorasAcademicas.ProfesorJefe, concat(PaternoProfesor,' ', MaternoProfesor,', ', NombresProfesor) as nombre_profesor_jefe,
							Ramos.Descripcion as NombreRamo
						from BitacorasAcademicas
							left  join alumnos".$_SESSION["sige_anio_escolar_vigente"]."
								on alumnos".$_SESSION["sige_anio_escolar_vigente"].".NumeroRutAlumno = BitacorasAcademicas.NumeroRutAlumno
							left  join Cursos
	        					on Cursos.CodigoCurso = alumnos".$_SESSION["sige_anio_escolar_vigente"].".CodigoCurso
	        				left  join Profesores
	        					on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor
	        				left  join Apoderados
        						on Apoderados.NumeroRutApoderado = alumnos".$_SESSION["sige_anio_escolar_vigente"].".NumeroRutApoderado
	        				left  join Ramos
        						on Ramos.CodigoRamo = BitacorasAcademicas.Asignatura
        				where BitacorasAcademicas.bitacora_ncorr = '".$_GET['bitacora_ncorr']."' ";
    $res_bitacora = mysql_query($sql_bitacora,$conexion) or die(mysql_error());
    $row_bitacora = mysql_fetch_array($res_bitacora);

    $pdf->SetWidths(array(30,70,30,70));
	$pdf->SetAligns(array('L','L','L','L'));
	$pdf->Row(array(utf8_decode('Nombre del Alumno'),utf8_decode($row_bitacora['nombre_alumno']),utf8_decode('Curso'),utf8_decode($row_bitacora['NombreCurso'])),0);
	$pdf->Ln();
	
	$pdf->SetWidths(array(50,150));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Nombre de Apoderado'),utf8_decode($row_bitacora['nombre_apoderado'])),0);
	$pdf->Ln();
	
	$pdf->SetWidths(array(30,70,30,70));
	$pdf->SetAligns(array('L','L','L','L'));
	$pdf->Row(array(utf8_decode('Profesor Jefe'),utf8_decode($row_bitacora['nombre_profesor_jefe']),utf8_decode('Asignatura'),utf8_decode($row_bitacora['NombreRamo'])),0);
	$pdf->Ln();
	
	$pdf->SetWidths(array(33,33,33,33,33,33));
	$pdf->SetAligns(array('L','L','L','L','L','L'));
	$pdf->Row(array(utf8_decode('Fecha'),utf8_decode($row_bitacora['FechaBitacora']),utf8_decode('Hora Inicio'),utf8_decode($row_bitacora['HoraInicio']),utf8_decode('Hora Fin'),utf8_decode($row_bitacora['HoraFin'])),0);
	$pdf->Ln();
	
	$pdf->SetWidths(array(50,150));
	$pdf->SetAligns(array('L','L'));
	if ($row_bitacora['Atrasos']=='1'){ $str_atraso ='Atrasos';}
	if ($row_bitacora['Falta']=='1'){ $str_falta  ='Falta al reglamento interno';}
	$str_otros  = $row_bitacora['Otros'];
	$pdf->Row(array(utf8_decode('Motivo Entrevista'),utf8_decode($str_atraso.' - '.$str_falta.' - '.$str_otros)),0);
	$pdf->Ln();
	
	$pdf->SetWidths(array(50,150));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Observaciones y Acuerdos'),utf8_decode($row_bitacora['DescripcionCompromiso'])),0);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetWidths(array(66,66,66));
	$pdf->SetAligns(array('L','L','L'));
	$pdf->Row(array(utf8_decode('Firma Apoderado'),utf8_decode('Firma Alumno'),utf8_decode('Firma Profesor')),0);
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('________________'),utf8_decode('________________'),utf8_decode('________________')),0);
	
	
	$pdf->Output();
?>	