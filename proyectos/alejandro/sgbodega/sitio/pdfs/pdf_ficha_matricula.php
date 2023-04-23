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

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(30, 25 , 30); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,25);  

	$pdf->SetFont('Arial','B',16);

	mysql_query("SET NAMES utf8");

	$alumno  =  $_GET['rut'];
    
    $anio =   $_SESSION["sige_anio_escolar_vigente"];

	$sql_esta = "select NombreEstablecimiento, Resolucion, AnioResolucion, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno
				 from Establecimiento";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$nombre_colegio = $row_esta['NombreEstablecimiento'];
	$resolucion = $row_esta['Resolucion'];
	$anio_resolucion = $row_esta['AnioResolucion'];
	$RBD = $row_esta['RBD'];
	$Logo = $row_esta['Logo'];
	$Foto = $row_esta['Foto'];
	$Representante = $row_esta['nombre_alumno'];
	
	
		

	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Image('../'.$Logo,25,15,25);
	$pdf->SetXY($x+25,$y+15);	
	$pdf->Cell(125,5,'MATRICULA',0,0,'C');
	$pdf->SetFont('Arial','',8);
    $pdf->Cell(50,5,'Nro.',1,0,'L');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('J'));
	$pdf->Row(array(utf8_decode('I.- DATOS DE ESTABLECIMIENTO')),0);

	

	$pdf->SetWidths(array(25, 85, 25,65));
	$pdf->SetAligns(array('J','J','J','J'));
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('NOMBRE'),utf8_decode('ESCUELA DE LENGUAJE "ARCOIRIS"'),utf8_decode('TELEFONO'),utf8_decode('')),0);
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('RBD-DV'),utf8_decode('14802-4'),utf8_decode('DIRECCION'),utf8_decode('')),0);
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('DIRECCION'),utf8_decode('Sargento Candelaria Pérez 290, Villa Yungay, Villa Alemana'),'',''),0);
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('COMUNA'),utf8_decode('Villa Alemana'),'',''),0);
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('DEPROV'),utf8_decode('Valparaíso e Isla de Pascua'),'',''),0);
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('REGION'),utf8_decode('V'),'',''),0);
	$y = $pdf->GetY();
	$pdf->SetXY(10,$y);	
	$pdf->Row(array(utf8_decode('FONO'),utf8_decode('0322731164 / 0957396239'),'',''),0);

	$sql_pd = "select PaternoAlumno, MaternoAlumno, NombresAlumno, FechaNacimiento, concat(NumeroRutAlumno,'-',DigitoRutAlumno) as rut,
						DireccionParticularAlumno 
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
				where NumeroRutAlumno = '".$alumno."'"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
		
	while ($line_pd = mysql_fetch_array($res_pd)) {
			
		$pdf->SetX(10);
		$pdf->SetWidths(array(200));
		$pdf->SetAligns(array('J'));
		$pdf->Row(array(utf8_decode('II.- DATOS DE ALUMNO')),0);
		$pdf->SetWidths(array(25, 75, 25,75));
		$pdf->SetAligns(array('J','J','J','J'));
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Apellido Paterno'),utf8_decode($line_pd['PaternoAlumno']),utf8_decode('Apellido Materno'),utf8_decode($line_pd['MaternoAlumno'])),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Nombres'),utf8_decode($line_pd['NombresAlumno']),utf8_decode('Fecha Nacimiento'),utf8_decode($line_pd['FechaNacimiento'])),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('RUT'),utf8_decode($line_pd['rut']),utf8_decode('Asistio Jardin'),utf8_decode('')),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Domicilio'),utf8_decode($line_pd['DireccionParticularAlumno']),utf8_decode('Niveles'),utf8_decode('')),0);
		$pdf->SetX(10);
                       
	}

	
	$sql_pd = "select PaternoApoderado, MaternoApoderado, NombresApoderado, FechaNacimientoApoderado, 
						concat(NumeroRutApoderado,'-',DigitoRutApoderado) as rut, DireccionParticularApoderado, 
						TelefonoParticularApoderado, TelefonoMovilApoderado, EMailApoderado , Parentesco
				from Apoderados
					join Parentescos using (CodigoParentesco)
				where NumeroRutApoderado in (select NumeroRutApoderado from alumnos".$anio." where NumeroRutAlumno = '".$alumno."')"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
		
	while ($line_pd = mysql_fetch_array($res_pd)) {
	
		$pdf->SetWidths(array(200));
		$pdf->SetAligns(array('J'));
		$pdf->Row(array(utf8_decode('II.- DATOS DEL APODERADO')),0);
		$pdf->SetWidths(array(25, 75, 25,75));
		$pdf->SetAligns(array('J','J','J','J'));
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Apellido Paterno'),utf8_decode($line_pd['PaternoApoderado']),utf8_decode('Apellido Materno'),utf8_decode($line_pd['MaternoApoderado'])),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Nombres'),utf8_decode($line_pd['NombresApoderado']),utf8_decode('Fecha Nacimiento'),utf8_decode($line_pd['FechaNacimientoApoderado'])),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('RUT'),utf8_decode($line_pd['rut']),utf8_decode('Domicilio'),utf8_decode($line_pd['DireccionParticularApoderado'])),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Teléfonos'),utf8_decode($line_pd['TelefonoParticularApoderado']),utf8_decode($line_pd['TelefonoMovilApoderado']),utf8_decode('')),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Emails'),utf8_decode($line_pd['EMailApoderado']),utf8_decode(''),utf8_decode('')),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Años escolaridad'),utf8_decode(''),utf8_decode('Profesión'),utf8_decode('')),0);
		$pdf->SetX(10);
		$pdf->Row(array(utf8_decode('Ocupacion'),utf8_decode(''),utf8_decode('Parentesco'),utf8_decode($line_pd['Parentesco'])),0);
		$pdf->SetX(10);
		}

	$pdf->SetWidths(array(50, 50, 50,50));
	$pdf->SetAligns(array('J','J','J','J'));
	$pdf->SetX(10);
	$pdf->Row(array(utf8_decode('Firma Apoderado'),utf8_decode('______________________________'),utf8_decode('Fecha'),utf8_decode(date("d/m/Y"))),0);
	$pdf->SetX(10);
	
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
	
	$pdf->Row(array(utf8_decode('Villa Alemana, '.$dia.' de '.$mes.' de '.$anio_actual)),0);
	

	$pdf->Output();
		
	?>