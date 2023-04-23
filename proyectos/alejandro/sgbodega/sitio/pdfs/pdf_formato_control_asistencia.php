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



$pdf=new PDF('L','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);


	mysql_query("SET NAMES utf8");

	$curso                     	=       $_GET['curso'];
    $mes 						=		$_GET['mes'];
    $anio 						= 		$_SESSION["sige_anio_escolar_vigente"];
	 
	$sql_nombre_profe ="select 
				distinct
				Cursos.NombreCurso
				from Cursos
				where
					Cursos.CodigoCurso = '".$curso."'
				";
	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());
	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);

	$nombre_curso = $row_nombre_profe['NombreCurso'];
	
	$sql_pd = "select 
				distinct
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				Matriculas.NroLista	, 
				alumnos".$anio.".SexoAlumno, 
				alumnos".$anio.".NumeroRutAlumno,
				Matriculas.FechaRetiro
				from alumnos".$anio."
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where
					alumnos".$anio.".Matriculado = '1' and alumnos".$anio.".CodigoCurso = '".$curso."'
				order by Matriculas.NroLista	"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
		$arrRegistros		= 	array();
		$i 					= 	1;
		$temp = $var = 0;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			if ($temp!=''){
				$var = $line_pd[1] - $temp;
			}
			$temp = $line_pd[1];
			if($var>1){
				array_push($arrRegistros, array("item"				=>	$i,
										"nro_lista"			=> 	$line_pd[1]-1,
										"rut_alumno" 		=> 'CAMBIO DE CURSO',
										"SexoAlumno" 		=> '',
										"rut"		 		=> '',
										"fecha_retiro"		=> 	''
										));
				array_push($arrRegistros, array("item"				=>	$i,
										"nro_lista"			=> 	$line_pd[1],
										"rut_alumno" 		=> 	$line_pd[0],
										"SexoAlumno" 		=> 	$line_pd[2],
										"rut"		 		=> 	$line_pd[3],
										"fecha_retiro"		=> 	$line_pd[4]
										));
			}
			else{
				array_push($arrRegistros, array("item"				=>	$i,
										"nro_lista"			=> 	$line_pd[1],
										"rut_alumno" 		=> 	$line_pd[0],
										"SexoAlumno" 		=> 	$line_pd[2],
										"rut"		 		=> 	$line_pd[3],
										"fecha_retiro"		=> 	$line_pd[4]
										));
			}
			$temp = $line_pd[1];
			$i++;                     
		}

	
		$pdf->Cell(250,5,'Asistencia Mensual',0,0,'C');
		$pdf->Ln();
		$pdf->Cell(250,5,'Mes : '.$mes.' de '.$anio,0,0,'C');
		$pdf->Ln();
		$pdf->Cell(250,5,'Curso : '.$nombre_curso,0,0,'C');
		
	$pdf->SetFont('Arial','',8);
		
	
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->Cell(5,3,'nl',1,0,'C');
	$pdf->Cell(65,3,'Alumno(a)',1,0,'C');
		
	$maximo = date("t",mktime(0,0,0,$mes,'1',$anio));

	$px_nota = (190*1)/($maximo);

	for($c=1;$c<=$maximo;$c++){
		$pdf->Cell($px_nota,3,$c,1,0,'C');
		}
	$pdf->Ln();
    
    $mujer=0;
    $hombre=0;
	for($d= 0; $d<count($arrRegistros); $d++){
		if (($arrRegistros[$d]['SexoAlumno']=='1')){
	   		if ($arrRegistros[$d]['fecha_retiro']!='0000-00-00'){
					$pdf->SetFont('Arial','BIU');
					}
			$pdf->SetTextColor(255,0,0);
	     	$pdf->Cell(5,3,$arrRegistros[$d]['nro_lista'],1,0,'C');
			$pdf->Cell(65,3,utf8_decode($arrRegistros[$d]['rut_alumno']),1,0,'L');    
			$mujer++;
			$pdf->SetTextColor(0,0,0);
	        for($c=1;$c<=$maximo;$c++){
	        	if (strlen(trim($c)) == 1){$c_format = "0".$c;}
				else $c_format = $c;
	        	$select_notas = "select NumeroRutAlumno
								from Inasistencias
								where  NumeroRutAlumno = '".$arrRegistros[$d]['rut']."' 
									and FechaInasistencia = '".$anio."-".$mes."-".$c_format."'";
				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
				if ($arrRegistros[$d]['fecha_retiro']!='0000-00-00'){
					$pdf->Cell($px_nota,3,'R',1,0,'C');
					}
				else{
					if (mysql_num_rows($res_notas)>0){
						$pdf->Cell($px_nota,3,'x',1,0,'C');
						}
					else{
						$pdf->Cell($px_nota,3,'',1,0,'C');
						}
					}
				}
		 	if ($arrRegistros[$d]['fecha_retiro']!='0000-00-00'){
				$pdf->SetFont('Arial','');
				}
		 	}
	    else{
	    	if ($arrRegistros[$d]['fecha_retiro']!='0000-00-00'){
				$pdf->SetFont('Arial','BIU');
				}
	        $pdf->Cell(5,3,$arrRegistros[$d]['nro_lista'],1,0,'C');
			$pdf->Cell(65,3,utf8_decode($arrRegistros[$d]['rut_alumno']),1,0,'L');       
			$hombre++;
	        for($c=1;$c<=$maximo;$c++){
				if (strlen(trim($c)) == 1){$c_format = "0".$c;}
				else $c_format = $c;
        		$select_notas = "select NumeroRutAlumno
								from Inasistencias
								where  NumeroRutAlumno = '".$arrRegistros[$d]['rut']."' 
									and FechaInasistencia = '".$anio."-".$mes."-".$c_format."'";
				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
				if ($arrRegistros[$d]['fecha_retiro']!='0000-00-00'){
					$pdf->Cell($px_nota,3,'R',1,0,'C');
					}
				else{
					if (mysql_num_rows($res_notas)>0){
						$pdf->Cell($px_nota,3,'x',1,0,'C');
						}
					else{
						$pdf->Cell($px_nota,3,'',1,0,'C');
						}
					}
				}
	    	if ($arrRegistros[$d]['fecha_retiro']!='0000-00-00'){
					$pdf->SetFont('Arial','');
				}
	    	}	

		$pdf->Ln();
    	}
		
    $pdf->Cell(250,5,'Resumen',0,0,'L');
	$pdf->Ln();


	$pdf->Cell(70,3,'Total Presentes',0,0,'L');
	for($c=1;$c<=$maximo;$c++){
		if (strlen(trim($c)) == 1){$c_format = "0".$c;}
		else $c_format = $c;
		$select_notas = "select count(NumeroRutAlumno) as inasis
							from Inasistencias
							where  FechaInasistencia = '".$anio."-".$mes."-".$c_format."'
								and NumeroRutAlumno in (select NumeroRutAlumno 
														from alumnos".$anio." 
														where CodigoCurso = '".$curso."')";
		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
		$row_notas = mysql_fetch_array($res_notas);
		$presentes = $i - $row_notas['inasis'];
		//$pdf->Cell($px_nota,3,$presentes,1,0,'C');
		$pdf->Cell($px_nota,3,'',1,0,'C');
		}
	$pdf->Ln();
	
	$pdf->Cell(70,3,'Total Ausentes',0,0,'L');
	for($c=1;$c<=$maximo;$c++){
		if (strlen(trim($c)) == 1){$c_format = "0".$c;}
		else $c_format = $c;
		$select_notas = "select count(NumeroRutAlumno) as inasis
							from Inasistencias
							where  FechaInasistencia = '".$anio."-".$mes."-".$c_format."'
								and NumeroRutAlumno in (select NumeroRutAlumno 
														from alumnos".$anio." 
														where CodigoCurso = '".$curso."')";
		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
		$row_notas = mysql_fetch_array($res_notas);
		$inasistentes = $row_notas['inasis'];
		
		//$pdf->Cell($px_nota,3,$inasistentes,1,0,'C');
		$pdf->Cell($px_nota,3,'',1,0,'C');
		}
	$pdf->Ln();
	
	$pdf->Cell(70,3,'Total Matricula',0,0,'L');
	for($c=1;$c<=$maximo;$c++){
		//$pdf->Cell($px_nota,3,$i,1,0,'C');
		$pdf->Cell($px_nota,3,'',1,0,'C');
		}
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->Cell(250,3,'Hombres : '.$hombre,0,0,'L');
	$pdf->Ln();
	$pdf->Cell(250,3,'Mujer : '.$mujer,0,0,'L');
	$pdf->Ln();

	$pdf->Output();
    
	?>
