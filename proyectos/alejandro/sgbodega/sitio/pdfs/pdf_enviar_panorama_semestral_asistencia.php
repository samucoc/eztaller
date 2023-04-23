<?php
ob_start();
session_start();
ini_set('display_errors', 1); 
error_reporting(E_ALL);
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

	$pdf->SetFont('Arial','B',16);


	mysql_query("SET NAMES utf8");

	$curso       =      $_GET['curso'];
    $anio        =      $_GET['anio'];
	$semestre    =      $_GET['semestre'];
	$Asistencia  = 		'';

	if (($curso=='370')||($curso=='380')){
		$sql_ve = "select DiasPeriodo as contador
					from Periodos
					where AnoAcademico = '".$anio."' and Semestre = '1'
					";
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$DiasPeriodo = $line_ve[0];

		$sql_ve = "select DiasPeriodo4medio as contador
					from Periodos
					where AnoAcademico = '".$anio."' and Semestre = '2'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$DiasPeriodo4medio = $line_ve[0];

		$asistencia = $DiasPeriodo + $DiasPeriodo4medio;
		}
	else{
		$sql_ve = "select sum(DiasPeriodo) as contador
					from Periodos
					where AnoAcademico = '".$anio."'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$asistencia  = $line_ve[0];
		}

	$arrRegistros		= 	array();
	$arrNotas			= 	array();
	$arrRamos			=	array();
	$arrPromCursos		=	[];

    $sql_pd = "select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 
				alumnos".$anio.".NumeroRutAlumno,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				Matriculas.NroMatricula	,
				Matriculas.NroLista	
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
    						Matriculas.Anio = '".$anio."'
    			where
					Cursos.CodigoCurso = '".$curso."' and Matriculas.FechaRetiro = '0000-00-00'
				order by Matriculas.NroLista	"; 

	
	$res_pd = mysql_query($sql_pd, $conexion);
		
	while ($line_pd = mysql_fetch_row($res_pd)) {
		
		$i 					= 	0;
		array_push($arrNotas, array("item"					=>	$i, 
										"rut_alumno"			=> 	'linea',
										"asignatura" 			=> 	'Inasistencias',
										"CodigoRamo"			=>	'Inasistencias',
										"nota"					=> 	'XXX'
										));

		array_push($arrNotas, array("item"					=>	$i, 
										"rut_alumno"			=> 	'linea',
										"asignatura" 			=> 	'Justificaciones',
										"CodigoRamo"			=>	'Justificaciones',
										"nota"					=> 	'XXX'
										));

		array_push($arrNotas, array("item"					=>	$i, 
										"rut_alumno"			=> 	'linea',
										"asignatura" 			=> 	'Porcentaje Asistencia',
										"CodigoRamo"			=>	'Porcentaje Asistencia',
										"nota"					=> 	'XXX'
										));


		array_push($arrRegistros, array("item"					=>	$i, 
									"NroLista"				=>  'Nro. Lista', 
									"nombre_alumno"			=> 	'Nombre Alumno', 
									"rut_alumno"			=> 	'linea'
									));

		while ($line_pd = mysql_fetch_row($res_pd)) {

			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo
							from Asignaturas
								inner join Ramos 
									on Ramos.CodigoRamo = Asignaturas.CodigoRamo
							where Asignaturas.CodigoCurso = '".$curso."'
							order by Asignaturas.NumeroOrden";

			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

			$k = 0;
			$promedio = 0;

			$sql_inasistencia = "select count(FechaInasistencia) as ina
								 from Inasistencias
								 where NumeroRutAlumno = '".$line_pd[2]."' and Year(FechaInasistencia) = '".$anio."'";

			$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());
			$row_inasistencia = mysql_fetch_array($res_inasistencia);
			$inasistencia = $row_inasistencia['ina'];

			array_push($arrNotas, array("item"					=>	$i, 
										"rut_alumno"			=> 	$line_pd[2],
										"asignatura" 			=> 	'Inasistencias',
										"CodigoRamo"			=>	'Inasistencias',
										"curso" 				=> 	$curso,
										"anio"					=> 	$anio,
										"semestre"				=>	$semestre,
										"nota"					=> 	$inasistencia,
										"negro"					=>	'1'
										));

			$sql_just = "SELECT TIMESTAMPDIFF(DAY, InicioJusti, TerminoJusti)+1 AS sum_dias_trans
									from Justificativos_Inasistencias
									where NumeroRutAlumno = '".$line_pd[2]."' and Year(InicioJusti) = '".$anio."'";
			$res_just = mysql_query($sql_just,$conexion) or die(mysql_error());
			$just = '';
			while ($row_just = mysql_fetch_array($res_just)){
				$just += $row_just['sum_dias_trans'];
			}
			
			array_push($arrNotas, array("item"					=>	$i, 
										"rut_alumno"			=> 	$line_pd[2],
										"asignatura" 			=> 	'Justificaciones',
										"CodigoRamo"			=>	'Justificaciones',
										"curso" 				=> 	$curso,
										"anio"					=> 	$anio,
										"semestre"				=>	$semestre,
										"nota"					=> 	$just,
										"negro"					=>	'1'
										));

			$porc_ina = 100-(($inasistencia*100)/$asistencia);
			$porc_ina = number_format($porc_ina , 2 , "." , ",");

			$sql_atrasos = "select count(FechaAtraso) as ina
									 from Atrasos
								 where NumeroRutAlumno = '".$line_pd[2]."' and Year(FechaAtraso) = '".$anio."'";

			$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());
			$row_atrasos = mysql_fetch_array($res_atrasos);
			$atrasos = $row_atrasos['ina'];

			$sql_positiva = "select count(TipoHojaVida) as ina
									 from HojasDeVida
								 where NumeroRutAlumno = '".$line_pd[2]."' and TipoHojaVida = 0 and Year(FechaHojaVida) = '".$anio."'";

			$res_positiva = mysql_query($sql_positiva,$conexion) or die(mysql_error());
			$row_positiva = mysql_fetch_array($res_positiva);
			$positiva = $row_positiva['ina'];

			$sql_negativa = "select count(TipoHojaVida) as ina
									 from HojasDeVida
								 where NumeroRutAlumno = '".$line_pd[2]."' and TipoHojaVida = 1 and Year(FechaHojaVida) = '".$anio."'";

			$res_negativa = mysql_query($sql_negativa,$conexion) or die(mysql_error());
			$row_negativa = mysql_fetch_array($res_negativa);
			$negativa = $row_negativa['ina'];

			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	$line_pd[2],
											"asignatura" 			=> 	'Porcentaje Asistencia',
											"CodigoRamo"			=>	'Porcentaje Asistencia',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	str_replace('.', ',', round($porc_ina,1)),
											"negro"					=>	$porc_ina > '85' ? '1': '0'
											));



			array_push($arrRegistros, array("NroLista"				=> 	$line_pd[5], 
											"nombre_alumno"			=> 	$line_pd[3], 
											"rut_alumno"			=> 	$line_pd[2]
											));

			$sql_inasistencia = "select count(FechaInasistencia) as ina
							 from Inasistencias
							 where NumeroRutAlumno in (select 
																alumnos".$anio.".NumeroRutAlumno
														from alumnos".$anio."
														where alumnos".$anio.".CodigoCurso = '".$curso."') and 
									Year(FechaInasistencia) = '".$anio."'";

			$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());
			$row_inasistencia = mysql_fetch_array($res_inasistencia);
			$inasistencia = $row_inasistencia['ina'];

			$porc_ina = 100-((($inasistencia/mysql_num_rows($res_pd))*100)/$asistencia);
			$porc_ina = number_format($porc_ina , 2 , "." , ",");

			$sql_atrasos = "select count(FechaAtraso) as ina
									 from Atrasos
								 where NumeroRutAlumno in (select alumnos".$anio.".NumeroRutAlumno
															from alumnos".$anio."
															where alumnos".$anio.".CodigoCurso = '".$curso."') and 
										Year(FechaAtraso) = '".$anio."'";

			$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());
			$row_atrasos = mysql_fetch_array($res_atrasos);
			$atrasos = $row_atrasos['ina'];

			array_push($arrRamos, array("asignatura" 			=> 	'Inasistencias',
										"CodigoRamo"			=>	'----',
										"nota"					=> 	str_replace('.', ',', round($porc_ina,1)).' %'
										));

			array_push($arrNotas, array("item"					=>	$i, 
										"rut_alumno"			=> 	'linea_1',
										"asignatura" 			=> 	'Inasistencias',
										"CodigoRamo"			=>	'----',
										"nota"					=> 	str_replace('.', ',', round($porc_ina,1)).' %'
										)); 
                       
		}
	}	

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

	$pdf->SetFont('Arial','',16);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Image('../'.$Logo,25,15,25);
	$pdf->SetXY($x+25,$y+15);	
	$pdf->Cell(175,5,'Panorama de Asistencia',0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->SetFont('Arial','',8);
	
	$sql_nombre_profe ="select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor,
				EMailFuncionario
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
				where
					Cursos.CodigoCurso = '".$curso."'
				";

	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());
	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);

	$pdf->SetWidths(array(50,150));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Año'),$anio),0);
	$pdf->Row(array(utf8_decode('Días del Periodo'),$asistencia),0);
	$pdf->Row(array('Curso',$row_nombre_profe['NombreCurso']),0);
	$pdf->Row(array('Profesor Jefe',utf8_decode($row_nombre_profe['nombre_profesor'])),0);
	$pdf->Row(array('Email',utf8_decode($row_nombre_profe['EMailFuncionario'])),0);
	$pdf->Ln();
	$pdf->SetWidths(array(10,100,30,30,30));
	$pdf->SetAligns(array('J','J','C','C','C'));
		
	for($i=0; $i<sizeof($arrRegistros); $i++){
		for($j=0;$j<sizeof($arrNotas); $j++){
			if ($arrRegistros[$i]['rut_alumno'] == $arrNotas[$j]['rut_alumno']){
				if ($arrNotas[$j]['nota'] == 'XXX'){
					$j1 = $j;
					$j2 = $j+1;
					$j3 = $j+2;
					$pdf->Row(array($arrRegistros[$i]['NroLista'],utf8_decode($arrRegistros[$i]['nombre_alumno']),$arrNotas[$j1]['CodigoRamo'],$arrNotas[$j2]['CodigoRamo'],$arrNotas[$j3]['CodigoRamo']),1);
					$j=$j3;
				}
				else{
					$j1 = $j;
					$j2 = $j+1;
					$j3 = $j+2;
					if ($arrNotas[$j3]['nota']<'85'){
						$pdf->Row(array($arrRegistros[$i]['NroLista'],utf8_decode($arrRegistros[$i]['nombre_alumno']),$arrNotas[$j1]['nota'],$arrNotas[$j2]['nota'],$arrNotas[$j3]['nota']),1);
					}
					$j=$j3;
				}
			}
		}	
	}
	
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
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('R'));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Villa Alemana, '.$dia.' de '.$mes.' de '.$anio_actual)),0);
	
	
	$fecha= date('Y-m-d_h-i-s', time());
	//$pdf->Output();
	$pdf->Output('pdfs/'.$fecha.'_'.$curso.'_'.$anio.'_'.$semestre."_panorama_asistencia.pdf","F");
	$path = 'pdfs/'.$fecha.'_'.$curso.'_'.$anio.'_'.$semestre."_panorama_asistencia.pdf";  	


       	$correo = new PHPMailer();
        $correo->SMTPDebug = 1;                               // Descripcion detallada debug
        $correo->isSMTP();                                      // Set mailer to use SMTP
        $correo->isHTML(true);
        $correo->Host = 'mail.gescol.cl'; 
        $correo->SMTPAuth = true;         
        $correo->Username = 'sige@gescol.cl';
		$correo->Password = 'SIGE.jaho2019';         
        $correo->From = 'sae@nmva.cl';
        $correo->FromName = 'Sistema Integrado de Gestion Escolar';
      

		$email_apoderado = $_GET['email'];
 		//$email_apoderado = 'jhurtado@gescol.cl';
 
		$correo->addAddress($email_apoderado);   
		
		$correo->isHTML(true);                   
        $correo->Subject = utf8_decode('Alerta SIGE | Gescol - Panorama de Asistencia - '.$row_nombre_profe['NombreCurso']);         

        $correo->AddAttachment($path, $asunto, $encoding = 'base64', $type = 'application/pdf');

        $correo->Body = utf8_decode("Se adjunta reporte con indicadores de asistencia correspondiente a su curso (".$row_nombre_profe['NombreCurso']."), se requiere de sus gestiones<br><br>Atte.<br><br>Equipo Gestión");

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