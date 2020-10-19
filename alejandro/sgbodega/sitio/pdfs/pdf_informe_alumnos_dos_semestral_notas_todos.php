<?php
ob_start();
session_start();

include "../../includes/php/conf_bd.php"; 
include "../../includes/php/validaciones.php"; 
include "../../includes/php/fpdf/fpdf.php"; 

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
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}



$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
$pdf->AliasNbPages();
$pdf->AddPage();

	$pdf->SetFont('Arial','',8);


	mysql_query("SET NAMES utf8");


	$anio					=	$_SESSION["sige_anio_escolar_vigente"];

	$curso 					= 	$_GET['curso'];
	
	
	$sql_alumno_busca = "
				select 
					alumnos".$anio.".NumeroRutAlumno
					from alumnos".$anio."
					inner join Matriculas
							on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
								Matriculas.Anio = '".$anio."'  
					where alumnos".$anio.".CodigoCurso = '".$curso."'

				order by NroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno"; 
	
	$res_alumno_busca = mysql_query($sql_alumno_busca, $conexion);

	$linea_alumno=0;
	$contador_alumnos = mysql_num_rows($res_alumno_busca);

	while($row_alumno_busca = mysql_fetch_array($res_alumno_busca)){
		
		$linea_alumno++;
		$rut 					=   $row_alumno_busca['NumeroRutAlumno'];
	
	$arrRegistros			= 	array();
	$arrRegistrosDetalle_1	= 	array();
	$arrRegistrosDetalle_2	= 	array();
	$arrRegistrosDetalle_total 	= 	array();
	$arrRegistrosPrueba		= 	array();
	$arrRegistrosMaximo		= 	array();
	
	$sql_esta = "select NombreEstablecimiento, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno, DireccionEstablecimiento
				from Establecimiento
				";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$nombre_establecimiento = $row_esta['NombreEstablecimiento'];
	$direccion_establecimiento = $row_esta['DireccionEstablecimiento'];
	$resolucion = $row_esta['Resolucion'];
	$anio_resolucion = $row_esta['AnioResolucion'];
	$rbd_establecimiento = $row_esta['RBD'];
	$logo_establecimiento = $row_esta['Logo'];
	$foto = $row_esta['Foto'];
		
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Image('../'.$logo_establecimiento,17,7,20);
	$pdf->SetXY($x+100,$y);	
	$pdf->Cell(100,5,$nombre_establecimiento,0,0,'C');
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+100,$y);	
	$pdf->Cell(100,5,$direccion_establecimiento,0,0,'C');
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+100,$y);	
	$pdf->Cell(100,5,'R.D.B : '.$rbd_establecimiento,0,0,'C');
	
	$pdf->Ln();
	
	$fecha_actual = date("d/m/Y");
	$pdf->SetFont('Arial','B',10);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Cell(200,5,'INFORME DE RENDIMIENTO ESCOLAR',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(200,5,$nombre_semestre,0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	
	$sql_pd = "select 
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				alumnos".$anio.".NumeroRutAlumno,
				NombreCurso,
				Matriculas.NroLista,
				 concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor),
				 Cursos.CodigoCurso
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where alumnos".$anio.".NumeroRutAlumno = '".$rut."'"; 

	$res_pd = mysql_query($sql_pd, $conexion);
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$nombre_alumno = $line_pd[0];
			$nombre_curso = $line_pd[2];
			$CodigoCurso = $line_pd[5];
			$nro_lista = $line_pd[3]; 
			$nombre_profesor = $line_pd[4]; 
                       
		}

	$maximo = 3;
		
$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						alumnos".$anio.".NumeroRutAlumno , Asignaturas.CodigoRamo, Cursos.CodigoCurso, 
						NroLista as NumeroLista, Pruebas.CoeficientePrueba, Ramos.Descripcion
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso 
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
					inner join Pruebas
						on  Pruebas.CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )
				where
				Cursos.CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )and 
				Pruebas.prueba_ncorr in (select prueba_ncorr  
											from Pruebas 
											where CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )  and
												AnoAcademico = '".$anio."' and 
												Semestre = '1' 
											) 
				and alumnos".$anio.".NumeroRutAlumno = '".$rut."' 
				group by nombre_alumno,	alumnos".$anio.".NumeroRutAlumno , Asignaturas.CodigoRamo, Cursos.CodigoCurso, NroLista
				order by Asignaturas.NumeroOrden, NroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";
	
	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());
	//$objResponse->addAlert($sql_ve);
	$promedio_1 = 0;
	$promedio_2 = 0;
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {
			if (strlen($line_ve[6])>40){
			 	$nombre_asignatura_contador = ((65*strlen($line_ve[6]))/40);
				}
			array_push($arrRegistros, array("item"					=>	$i, 
											"nombre_alumno"			=> 	$line_ve[0], 
											"rut_alumno"			=> 	$line_ve[1],
											"asignatura" 			=> 	$line_ve[2],
											"curso" 				=> 	$line_ve[3],
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nro_lista_alumno"		=> 	$line_ve[4],
											"prueba"				=> 	$prueba,
											"nombre_asignatura"		=> 	$line_ve[6]
											));
			$i++;
			$select_notas = "select prueba_ncorr , CoeficientePrueba, NumeroNota	
								from Pruebas
							where  Pruebas.CodigoCurso = '".$line_ve[3]."' and 
									Pruebas.CodigoRamo = '".$line_ve[2]."' and  
									Pruebas.AnoAcademico = '".$anio."' and  
									Pruebas.Semestre = '1'";
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$j=1;
			$k=0;
			$z="";
			$total = 0;
			$codigo_ramo = "";
			$promedio_1 = 0;
			while($row_notas = mysql_fetch_array($res_notas)){

				$select_notas_1 = "select Nota, NumeroRutAlumno, NotasAlumnos.CodigoCurso, 
									NotasAlumnos.CodigoRamo, NotasAlumnos.AnoAcademico, NotasAlumnos.Semestre, 
									NotasAlumnos.NumeroNota, DescripcionPrueba
							from NotasAlumnos
								inner join Pruebas
									on Pruebas.NumeroNota = NotasAlumnos.NumeroNota and 
										Pruebas.CodigoCurso = '".$line_ve[3]."' and 
										Pruebas.CodigoRamo = '".$line_ve[2]."' and  
										Pruebas.AnoAcademico = '".$anio."' and  
										Pruebas.Semestre = '1' 
							where  NotasAlumnos.NumeroRutAlumno = '".$line_ve[1]."' and 
									NotasAlumnos.CodigoCurso = '".$line_ve[3]."' and 
									NotasAlumnos.CodigoRamo = '".$line_ve[2]."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '1' and 
									Pruebas.NumeroNota = '".$row_notas['NumeroNota']."'";
				$res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
				$j=0;
				if (mysql_num_rows($res_notas_1)>0){
					while($row_notas_1 = mysql_fetch_array($res_notas_1)){
						for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
							$total = $row_notas_1[0] + $total;
							$codigo_ramo = $row_notas_1[3];
							$j++;
							if ($row_notas_1[0]>0){
								$k++;
								}
							}
						}
					}
				else{
					for($r=0;$r<$line_ve[5];$r++){
						$total = 0 + $total;
						$codigo_ramo = $line_ve[2];
						$j++;
						}
					}
				if ($k>0){
					$promedio_1 = $total/$k;
					}
				else{
					$promedio_1=0;
					}
				} 
			
			array_push($arrRegistrosDetalle_1, array("item"			=>	$j, 
												"rut_alumno"			=> 	$line_ve[1], 
												"CodigoRamo"			=>	$line_ve[2], 
												"nota"					=>	round($promedio_1,1),
												"semestre"				=>	'1'
												));
			$select_notas = "select prueba_ncorr , CoeficientePrueba, NumeroNota	
								from Pruebas
							where  Pruebas.CodigoCurso = '".$line_ve[3]."' and 
									Pruebas.CodigoRamo = '".$line_ve[2]."' and  
									Pruebas.AnoAcademico = '".$anio."' and  
									Pruebas.Semestre = '2'";
			$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
			$j=1;
			$k=0;
			$z="";
			$total = 0;
			$codigo_ramo = "";
			$promedio_2 = 0;	

			while($row_notas = mysql_fetch_array($res_notas)){

				$select_notas_1 = "select Nota, NumeroRutAlumno, NotasAlumnos.CodigoCurso, 
									NotasAlumnos.CodigoRamo, NotasAlumnos.AnoAcademico, NotasAlumnos.Semestre, 
									NotasAlumnos.NumeroNota, DescripcionPrueba
							from NotasAlumnos
								inner join Pruebas
									on Pruebas.NumeroNota = NotasAlumnos.NumeroNota and 
										Pruebas.CodigoCurso = '".$line_ve[3]."' and 
										Pruebas.CodigoRamo = '".$line_ve[2]."' and  
										Pruebas.AnoAcademico = '".$anio."' and  
										Pruebas.Semestre = '2' 
							where  NotasAlumnos.NumeroRutAlumno = '".$line_ve[1]."' and 
									NotasAlumnos.CodigoCurso = '".$line_ve[3]."' and 
									NotasAlumnos.CodigoRamo = '".$line_ve[2]."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '2' and 
									Pruebas.NumeroNota = '".$row_notas['NumeroNota']."'";
				$res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
				$j=0;
				if (mysql_num_rows($res_notas_1)>0){
					while($row_notas_1 = mysql_fetch_array($res_notas_1)){
						for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
							$total = $row_notas_1[0] + $total;
							$codigo_ramo = $row_notas_1[3];
							$j++;
							if ($row_notas_1[0]>0){
								$k++;
								}
							}
						}
					}
				else{
					for($r=0;$r<$line_ve[5];$r++){
						$total = 0 + $total;
						$codigo_ramo = $line_ve[2];
						$j++;
						}
					}
				if ($k>0){
					$promedio_2 = $total/$k;
					}
				else{
					$promedio_2=0;
					}
				} 
				array_push($arrRegistrosDetalle_2, array("item"			=>	$j, 
												"rut_alumno"			=> 	$line_ve[1], 
												"CodigoRamo"			=>	$line_ve[2], 
												"nota"					=>	round($promedio_2,1),
												"semestre"				=>	'2'
												));
			}
		
		for($z=0;$z<count($arrRegistrosDetalle_1);$z++){
			array_push($arrRegistrosDetalle_total, array("item"			=>	$j, 
									"rut_alumno_1"			=> 	$arrRegistrosDetalle_1[$z]['rut_alumno'], 
									"CodigoRamo_1"			=>	$arrRegistrosDetalle_1[$z]['CodigoRamo'], 
									"nota_1"				=>	$arrRegistrosDetalle_1[$z]['nota'], 
									"semestre_1"			=>	$arrRegistrosDetalle_1[$z]['semestre'], 
									"rut_alumno_2"			=> 	$arrRegistrosDetalle_2[$z]['rut_alumno'], 
									"CodigoRamo_2"			=>	$arrRegistrosDetalle_2[$z]['CodigoRamo'], 
									"nota_2"				=>	$arrRegistrosDetalle_2[$z]['nota'], 
									"semestre_2"			=>	$arrRegistrosDetalle_2[$z]['semestre'], 
									"rut_alumno_t"			=> 	$arrRegistrosDetalle_2[$z]['rut_alumno'], 
									"CodigoRamo_t"			=>	$arrRegistrosDetalle_2[$z]['rut_alumno'], 
									"nota_t"				=>	round(($arrRegistrosDetalle_1[$z]['nota']+$arrRegistrosDetalle_2[$z]['nota'])/2,1), 
									"semestre_t"			=>	't'
												));
				
			
			}


	$pdf->SetWidths(array(30,180));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Alumno'),utf8_decode($nombre_alumno)),0);

	$pdf->SetWidths(array(30,80,50,50));
	$pdf->SetAligns(array('L','L','L','L'));
	$pdf->Row(array(utf8_decode('Curso'),utf8_decode($nombre_curso),utf8_decode('Nro Lista'),$nro_lista),0);
	$pdf->Row(array(utf8_decode('Profesor(a) Jefe'),utf8_decode($nombre_profesor),utf8_decode('Fecha'),$fecha_actual),0);

	$pdf->Ln();
    
	$pdf->Cell(75,5,'Asignatura',1,0,'C');
	
	$px_nota = (125*1)/($maximo+2);

	$total_notas_px = $maximo+2;

	$pdf->Cell(41,5,'1er Semestre',1,0,'C');
	$pdf->Cell(41,5,'2do Semestre',1,0,'C');
	$pdf->Cell(41,5,'Promedio',1,0,'C');
	$pdf->Ln();
    

    for($d= 0; $d<count($arrRegistros); $d++){
		$pdf->Cell(75,5,utf8_decode($arrRegistros[$d]['nombre_asignatura']),1,0,'L');
		for($g=0; $g<count($arrRegistrosDetalle_total);$g++){
			if ($arrRegistros[$d]['asignatura']==$arrRegistrosDetalle_total[$g]['CodigoRamo_1']){
               	if ($arrRegistrosDetalle_total[$g]['nota_1'] < 4) { 
         			$pdf->SetTextColor(255,0,0);
                 	$pdf->Cell(41,5,$arrRegistrosDetalle_total[$g]['nota_1'],1,0,'C');    
         			$pdf->SetTextColor(0,0,0);
                 	}
                else{
                    $pdf->Cell(41,5,$arrRegistrosDetalle_total[$g]['nota_1'],1,0,'C');       
                	}	
				if ($arrRegistrosDetalle_total[$g]['nota_2'] < 4) { 
         			$pdf->SetTextColor(255,0,0);
                 	$pdf->Cell(41,5,$arrRegistrosDetalle_total[$g]['nota_2'],1,0,'C');    
         			$pdf->SetTextColor(0,0,0);
                 	}
                else{
                    $pdf->Cell(41,5,$arrRegistrosDetalle_total[$g]['nota_2'],1,0,'C');       
                	}	
				if ($arrRegistrosDetalle_total[$g]['nota_t'] < 4) { 
         			$pdf->SetTextColor(255,0,0);
                 	$pdf->Cell(41,5,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');    
         			$pdf->SetTextColor(0,0,0);
                 	}
                else{
                    $pdf->Cell(41,5,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');       
                	}	
				}	
			}
		$pdf->Ln();
    	}
    	    
    $pdf->Ln();
    
		$notas_ingresadas = $maximo;
    	$notas_ingresadas_2 = $maximo/2;
    		
    	$asistencia = '';
		if (($CodigoCurso=='370')||($CodigoCurso=='380')){
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


		
		$sql_inasistencia = "select count(FechaInasistencia) as ina
							 from Inasistencias
							 where NumeroRutAlumno = '".$rut."' and 
							 		Year(FechaInasistencia) = '".$anio."' and 
							 		FechaInasistencia > '".$TerminoPeriodo."'
							 		";
		$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());
		$row_inasistencia = mysql_fetch_array($res_inasistencia);
		$inasistencia = $row_inasistencia['ina'];
		
		$porc_ina = 100-(($inasistencia*100)/$asistencia);
		$porc_ina = number_format($porc_ina , 2 , "." , ",");
		
		$sql_atrasos = "select count(FechaAtraso) as ina
								 from Atrasos
							 where NumeroRutAlumno = '".$rut."' and 
							 		Year(FechaAtraso) = '".$anio."' and 
							 		FechaAtraso > '".$TerminoPeriodo."'";
		$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());
		$row_atrasos = mysql_fetch_array($res_atrasos);
		$atrasos = $row_atrasos['ina'];
			
		$sql_positiva = "select count(TipoHojaVida) as ina
								 from HojasDeVida
							 where NumeroRutAlumno = '".$rut."' and 
							 		TipoHojaVida = 0 and 
							 		Year(FechaHojaVida) = '".$anio."' and 
							 		FechaHojaVida > '".$TerminoPeriodo."'";
		$res_positiva = mysql_query($sql_positiva,$conexion) or die(mysql_error());
		$row_positiva = mysql_fetch_array($res_positiva);
		$positiva = $row_positiva['ina'];
			
		$sql_negativa = "select count(TipoHojaVida) as ina
								 from HojasDeVida
							 where NumeroRutAlumno = '".$rut."' and 
							 		TipoHojaVida = 1 and 
							 		Year(FechaHojaVida) = '".$anio."' and 
							 		FechaHojaVida > '".$TerminoPeriodo."'";
		$res_negativa = mysql_query($sql_negativa,$conexion) or die(mysql_error());
		$row_negativa = mysql_fetch_array($res_negativa);
		$negativa = $row_negativa['ina'];


	$pdf->Ln();
    
	$pdf->Cell(200,5,'Asistencia',1,0,'C');
	$pdf->Ln();
	$pdf->SetWidths(array(66,67,67));
	$pdf->SetAligns(array('C','C','C'));
	$pdf->Row(array(utf8_decode('Dias Trabajados'),utf8_decode('Dias Faltados'),utf8_decode('% Asistencia')),1);
	$pdf->Row(array(utf8_decode($asistencia),utf8_decode($inasistencia),utf8_decode($porc_ina)),1);
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->Cell(200,5,'Observaciones',1,0,'C');
	$pdf->Ln();
	$pdf->SetWidths(array(66,67,67));
	$pdf->SetAligns(array('C','C','C'));
	$pdf->Row(array(utf8_decode('Atrasos'),utf8_decode('Positivas'),utf8_decode('Negativas')),1);
	$pdf->Row(array(utf8_decode($atrasos),utf8_decode($positiva),utf8_decode($negativa)),1);
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->Row(array(utf8_decode('Firma Apoderado'),utf8_decode('Firma Director'),utf8_decode('Firma Prof Jefe')),0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('_______________'),utf8_decode('_______________'),utf8_decode('_______________')),0);

			if ($linea_alumno<$contador_alumnos){
			$pdf->AddPage();
			}
				
		}

	$pdf->Output();
		
	?>