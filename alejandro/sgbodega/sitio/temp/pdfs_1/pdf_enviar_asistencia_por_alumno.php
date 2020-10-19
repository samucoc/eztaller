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

	$alumno                     =       $_GET['alumno'];
    
    $anio =   $_SESSION["sige_anio_escolar_vigente"];

	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(160,5,"Reporte de Inasistencias y Atrasos",0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	

	$select_nombre_alumno = "	select 	concat(NombresAlumno,' ',PaternoAlumno, ' ', MaternoAlumno) as nombre_alumno, 
										concat(NombresApoderado,' ',PaternoApoderado, ' ', MaternoApoderado) as nombre_apoderado, 
											NombreCurso,
											NumeroRutAlumno
									from alumnos".$anio." 
										inner join Cursos
											on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
										inner join Apoderados
											on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado
									where NumeroRutAlumno = '".$alumno."'";

	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());
	$arrRegistros	= 	array();
	
	$fecha1					=	'1-1-'.$anio;
	$fecha2					=	'31-12-'.$anio;
		
	$nombre_apoderado = $NombreCurso = $nombre_alumno = "";

	while($row_RA = mysql_fetch_array($res_nombre_alumno)){
		
		$nombre_apoderado = $row_RA['nombre_apoderado'];
		$NombreCurso = $row_RA['NombreCurso'];
		$nombre_alumno = $row_RA['nombre_alumno'];
	
		$rut = $row_RA['NumeroRutAlumno'];

		$sql_ve = "select DATE_FORMAT(FechaInasistencia, '%d-%m-%Y')
					from Inasistencias
						
					where NumeroRutAlumno = '".$rut."' and FechaInasistencia between '".$fecha1."' and '".$fecha2."'
					order by FechaInasistencia";
		
		$res_ve = mysql_query($sql_ve, $conexion);
		$i = '';
		array_push($arrRegistros, array("item"					=>	"Inasistencias", 
											"FechaInasistencia"		=>	''
											));
		if (mysql_num_rows($res_ve)==0){
			array_push($arrRegistros, array("item"					=>	$i, 
											"FechaInasistencia"		=>	"No existen registros"
											));
			
			}
		else{
			while ($line_ve = mysql_fetch_row($res_ve)) {
				array_push($arrRegistros, array("item"					=>	$i, 
												"FechaInasistencia"		=>	$line_ve[0]
												));
				
				}
			}

		$sql_ve = "select count(FechaInasistencia) as contador
					from Inasistencias
					where NumeroRutAlumno = '".$rut."' and FechaInasistencia between '".$fecha1."' and '".$fecha2."'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);
		array_push($arrRegistros, array("item"					=>	"Total Inasistencias", 
										"FechaInasistencia"		=>	$line_ve[0]
										));

		$sql_ve = "select DATE_FORMAT(FechaAtraso, '%d-%m-%Y')
					from Atrasos
						
					where NumeroRutAlumno = '".$rut."' and FechaAtraso between '".$fecha1."' and '".$fecha2."'
					order by FechaAtraso";
		
		$res_ve = mysql_query($sql_ve, $conexion);
				array_push($arrRegistros, array("item"					=>	"Atrasos", 
												"FechaInasistencia"		=>	''
												));
		if (mysql_num_rows($res_ve)==0){
			array_push($arrRegistros, array("item"					=>	$i, 
											"FechaInasistencia"		=>	"No existen registros"
											));
			
			}
		else{
			while ($line_ve = mysql_fetch_row($res_ve)) {
				array_push($arrRegistros, array("item"					=>	$i, 
												"FechaInasistencia"		=>	$line_ve[0]
												));
				}
			}

		$sql_ve = "select count(FechaAtraso) as contador
					from Atrasos
					where NumeroRutAlumno = '".$rut."' and FechaAtraso between '".$fecha1."' and '".$fecha2."'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);
		array_push($arrRegistros, array("item"					=>	"Total Atrasos", 
										"FechaInasistencia"		=>	$line_ve[0]
										));

		}
	$pdf->SetFont('Arial','',8);
   	$pdf->SetWidths(array(50,150));
	$pdf->SetAligns(array('L','L'));
	
		$pdf->Row(array(utf8_decode('Nombre Alumno'),utf8_decode($nombre_alumno)),0);
		$pdf->Row(array(utf8_decode('Nombre Curso'),utf8_decode($NombreCurso)),0);
		$pdf->Row(array(utf8_decode('Nombre Apoderado'),utf8_decode($nombre_apoderado)),0);
		
	$pdf->SetFont('Arial','',8);
   	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('J','J'));
	
	for($i=0;$i<count($arrRegistros);$i++){
		$pdf->Row(array(utf8_decode($arrRegistros[$i]['item']),utf8_decode($arrRegistros[$i]['FechaInasistencia'])),0);
		}
		
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
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
	
	$pdf->Row(array(utf8_decode('Atte.')),0);
	$pdf->Row(array(utf8_decode('Inspectoria')),0);
	$pdf->Row(array(utf8_decode('Colegio Nuevo Milenio')),0);
	$pdf->Row(array(utf8_decode('Villa Alemana, '.$dia.' de '.$mes.' de '.$anio_actual)),0);
	


	$fecha= date('Y-m-d_h-i-s', time());
	
	$alumno				=	$_GET['alumno'];
	
	$pdf->Output('pdfs/'.$fecha.'_'.$alumno."_asistencia_por_alumno.pdf","F");
	$path = 'pdfs/'.$fecha.'_'.$alumno."_asistencia_por_alumno.pdf";  	


       	$correo = new PHPMailer();
        $correo->SMTPDebug = 1;                               // Descripcion detallada debug
        $correo->isSMTP();                                      // Set mailer to use SMTP
        $correo->Host = 'mail.gescol.cl';          
        $correo->From = 'sae@nmva.cl';
        $correo->FromName = 'SIGE Colegio Nuevo Milenio';
      

		$email_apoderado = $_GET['email'];
 		//$email_apoderado = 'jhurtado@gescol.cl';
 
		$correo->addAddress($email_apoderado,$email_apoderado);   
		
		$correo->isHTML(true);                   
        $correo->Subject = utf8_decode('Reporte Sistema Integrado de Gestion Escolar - Reporte de Inasistencias y Atrasos');         

        $correo->AddAttachment($path, $correo->Subject, $encoding = 'base64', $type = 'application/pdf');

        $html = utf8_decode("<html>
        				<head>
        				</head>
        				<body>
        					<p>Señor(a) ".$nombre_apoderado."</p>
        					<p>Con la finalidad de mantenerlo informado(a) y solicitar su apoyo en la gestión de Asistencia y Puntualidad de su pupilo(a), Adjuntamos 'Informe de Inasistencia y Atrasos'</p>
        					<p>Saluda atentamente a usted.</p>
        					<p>Inspectoria General</p>
        					<p>Colegio Nuevo Milenio</p>
        				</body>
        		 </html>");

        $correo->Body = $html;

		        if(!$correo->send()) {
		            echo 'Message could not be sent.';
		            echo 'Mailer Error: ' . $correo->ErrorInfo;
		        	}
		        else {
		         	
		            } 

	?>
<script>
window.parent.hidePopWin(true);
</script>		