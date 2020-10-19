<?php
ob_start();
session_start();
include "../includes/php/fpdf/fpdf.php"; 
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

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
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}



$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
$pdf->AliasNbPages();
$pdf->AddPage();

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

	$anio =   $_SESSION["sige_anio_escolar_vigente"];
	$fecha_letras = $dia.' de '.$mes_ele.' de '.$anio;
	
	$alumno = $_GET['rut_alumno'];

	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,
								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado,
								DireccionParticularApoderado
					from gescolcl_arcoiris_administracion.Apoderados
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_arcoiris_administracion.alumnos".$anio."
													where NumeroRutAlumno = '".$alumno."')";
	$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());
	$row_apoderado = mysql_fetch_array($res_apoderado);
	
	$rut_apoderado = $row_apoderado['NumeroRutApoderado'].'-'.dv($row_apoderado['NumeroRutApoderado']);
	$nombre_apoderado = $row_apoderado['nombre'];
	$direccion_apoderado = $row_apoderado['DireccionParticularApoderado'];
	
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso as NombreCurso,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				FechaNacimiento, DireccionParticularAlumno, TelefonoParticularAlumno, EMailAlumno,
				TipoBeca, BecaIncorporacion, BecaColegiatura
				from gescolcl_arcoiris_administracion.Cursos
					inner join gescolcl_arcoiris_administracion.alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio.".NumeroRutAlumno = '".$alumno."'"; 
	$res_pd = mysql_query($sql_pd,$conexion) or die(mysql_error());
	$row_pd = mysql_fetch_array($res_pd);
	$nombre_alumno = $row_pd['nombre_alumno'];
	$nombre_curso = $row_pd['NombreCurso'];
	$beca = $row_pd['BecaIncorporacion'] + $row_pd['BecaColegiatura'];
	
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
	$RBD		= $row_esta['RBD'];
	$Logo		= $row_esta['Logo'];

	
	$pdf->SetFont('Arial','',8);
	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$image_format = strtolower(pathinfo($Logo, PATHINFO_EXTENSION));
	$pdf->Image($Logo,25,15,25,20,$image_format);
	$pdf->SetXY($x+35,$y);		

	$pdf->Cell(165,10,$nombre_establecimiento,0,0,'R');

	$pdf->Ln();

	$pdf->Cell(200,10,$direccion_repre,0,0,'R');

	$pdf->Ln();

	$pdf->Cell(200,10,'RBD Nro. '.$RBD,0,0,'R');

	$pdf->Ln();

	
	
	$pdf->SetFont('Arial','B',10);

	$pdf->Cell(200,10,'CERTIFICADO DE BECA',0,0,'C');

	$pdf->Ln();

	$pdf->Ln();

	$pdf->SetFont('Arial','',8);

	

	$pdf->SetWidths(array(200));

	$pdf->SetAligns(array('J'));

	
	$pdf->Row(array(utf8_decode('Señor(a) '.$nombre_apoderado.', apoderado del alumno(a) '.$nombre_alumno.', RUT: '.$alumno.', de acuerdo a lo establecido en el Reglamento Interno de Asignación de Becas, informamos a usted que ha sido favorecido con una beca sobre el arancel por un monto de $ '.$beca.'.')),0);
	
	$pdf->Row(array(utf8_decode('Esta beca es otorgada  con vigencia para el año '.$anio.'.')),0);
	

	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(100,10,"Apoderado",0,0,'C');	
	$pdf->Cell(100,10,"Representante Legal del Colegio",0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(100,10,$nombre_apoderado,0,0,'C');	
	$pdf->Cell(100,10,$nombre_repre,0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(100,10,$rut_apoderado,0,0,'C');	
	$pdf->Cell(100,10,$rut_repre,0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(200,10,$fecha_letras,0,0,'R');	
	$pdf->Ln();
	
	
	
	
$pdf->Output();
?>
