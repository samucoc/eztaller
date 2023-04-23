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
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}



$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
$pdf->AliasNbPages();
$pdf->AddPage();

	$pdf->SetFont('Arial','',8);


	mysql_query("SET NAMES utf8");


	$anio					=	$_SESSION["sige_anio_escolar_vigente"];

	$semestre				=	$_GET['semestre'];
	$curso 					= 	$_GET['curso'];
	
	
	$sql_alumno_busca = "select 
				NumeroRutAlumno
				from alumnos".$anio."
				where alumnos".$anio.".CodigoCurso = '".$curso."'
				order by NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno"; 
	
	$res_alumno_busca = mysql_query($sql_alumno_busca, $conexion);

	while($row_alumno_busca = mysql_fetch_array($res_alumno_busca)){
	
			$arrRegistros			= 	array();
			$arrRegistrosDetalle	= 	array();
			$arrRegistrosPrueba		= 	array();
			$arrRegistrosMaximo		= 	array();

			$rut 					=   $row_alumno_busca['NumeroRutAlumno'];	

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
			
		if ($semestre==1){
			$nombre_semestre = 'Primer Semestre - '.$anio;
		 	}
		else{
			$nombre_semestre = 'Segundo Semestre - '.$anio;
		 	}

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
		$pdf->Cell(200,5,'INFORME PARCIAL',0,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(200,5,$nombre_semestre,0,0,'C');
		$pdf->Ln();
		$pdf->Ln();
		

		$sql_pd = "select 
					concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
					NumeroRutAlumno,
					NombreCurso,
					NroLista,
					 concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor)
					from alumnos".$anio."
						inner join Cursos
							on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
						inner join Profesores
							on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
						inner join Matriculas
							on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
								Matriculas.Anio = '".$anio."'
					where NumeroRutAlumno = '".$rut."'"; 
		
		$res_pd = mysql_query($sql_pd, $conexion);
			$arrRegistros		= 	array();
			$i 					= 	1;
			while ($line_pd = mysql_fetch_row($res_pd)) {
				
				$nombre_alumno = $line_pd[0];
				$nombre_curso = $line_pd[2];
				$nro_lista = $line_pd[3]; 
				$nombre_profesor = $line_pd[4]; 
	                       
			}
		
		$select_notas = "select sum(CoeficientePrueba) as NumeroNota, CodigoRamo
								from Pruebas
								where Pruebas.CodigoCurso in (select CodigoCurso 
														from alumnos".$anio."
														where NumeroRutAlumno = '".$rut."' ) and 
									  Pruebas.AnoAcademico = '".$anio."' and  
									  Pruebas.Semestre = '".$semestre."' 
								group by CodigoRamo
								order by NumeroNota desc
								limit 0,1
									";
		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
		$maximo = 0;
		$ramo = "";
		while ($row_notas = mysql_fetch_array($res_notas)){
			$maximo = $row_notas['NumeroNota'];
			$ramo = $row_notas['CodigoRamo'];
			}
			
		$select_notas = "select CoeficientePrueba
								from Pruebas
								where Pruebas.CodigoCurso in (select CodigoCurso 
														from alumnos".$anio." 
														where NumeroRutAlumno = '".$rut."' ) and 
									  Pruebas.AnoAcademico = '".$anio."' and  
									  Pruebas.Semestre = '".$semestre."' and
									  Pruebas.CodigoRamo = '".$ramo."' 
									";
		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
		$i = 1;
		while ($row_notas = mysql_fetch_array($res_notas)){
			for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
				array_push($arrRegistrosMaximo, array("nro_nota"	=>	$i));
				$i++;
				}
			}
		$maximo_notas = $i;

		$sql_curso = "select CodigoCurso 
														from alumnos".$anio." 
														where NumeroRutAlumno = '".$rut."'";
		$res_curso = mysql_query($sql_curso,$conexion);
		$row_curso = mysql_fetch_array($res_curso);
		$curso_alumno = $row_curso['CodigoCurso'];
	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						alumnos".$anio.".NumeroRutAlumno, Asignaturas.CodigoRamo, Cursos.CodigoCurso, 
						NroLista as NumeroLista, Pruebas.CoeficientePrueba, Ramos.Descripcion, 
							Asignaturas.CalculaPromedio 
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso 
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 
					inner join Pruebas
						on  Pruebas.CodigoCurso = '".$curso_alumno."'
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where
				Cursos.CodigoCurso = '".$curso_alumno."' and 
				Pruebas.NumeroNota in (select NumeroNota  
											from Pruebas 
											where CodigoCurso = '".$curso_alumno."'  and
												AnoAcademico = '".$anio."' and 
												Semestre = '".$semestre."' 
											) and
				Pruebas.CodigoCurso = '".$curso_alumno."'  and
				Pruebas.AnoAcademico = '".$anio."' and 
				Pruebas.Semestre = '".$semestre."' and 
				alumnos".$anio.".NumeroRutAlumno = '".$rut."'
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista
				order by Asignaturas.NumeroOrden, NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";

	$select_max  ="select CodigoRamo, count(NumeroNota) as maximo
								from Pruebas
							where  Pruebas.CodigoCurso in (select CodigoCurso 
													from alumnos".$anio."
													where NumeroRutAlumno = '".$rut."' ) and 
									Pruebas.AnoAcademico = '".$anio."' and  
									Pruebas.Semestre = '".$semestre."'
					group by CodigoRamo";
	$res_max = mysql_query($select_max,$conexion)or die(mysql_error());
	$maximo = 0;
	while($row_max = mysql_fetch_array($res_max)){
		if ($maximo < $row_max['maximo']) $maximo = $row_max['maximo'];
		}

	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());
	
		$i = 1;
		$total_alumno = 0;
		$cont_notas_alumno = 0;

		while ($line_ve = mysql_fetch_row($res_ve)) {
			array_push($arrRegistros, array("item"					=>	$i, 
											"nombre_alumno"			=> 	$line_ve[0], 
											"rut_alumno"			=> 	$line_ve[1],
											"asignatura" 			=> 	$line_ve[2],
											"curso" 				=> 	$line_ve[3],
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nro_lista_alumno"		=> 	$line_ve[4],
											"prueba"				=> 	$prueba,
											"nombre_asignatura"		=> 	$line_ve[6],
											"calcula_promedio"		=> 	$line_ve[7]
											));
			$i++;
			$j=1;
			$k=0;
			$z="";
			$total = 0;
			$promedio = 0;
			$codigo_ramo = "";
			$contador_nota = 0;
			$total_nota = 0;		
			for($o=1;$o<=$maximo;$o++){

				$select_notas_1 = "select Nota, NumeroRutAlumno, NotasAlumnos.CodigoCurso, 
									NotasAlumnos.CodigoRamo, NotasAlumnos.AnoAcademico, NotasAlumnos.Semestre, 
									NotasAlumnos.NumeroNota, DescripcionPrueba
							from NotasAlumnos
								inner join Pruebas
									on Pruebas.NumeroNota = NotasAlumnos.NumeroNota and 
										Pruebas.CodigoCurso = '".$line_ve[3]."' and 
										Pruebas.CodigoRamo = '".$line_ve[2]."' and  
										Pruebas.AnoAcademico = '".$anio."' and  
										Pruebas.Semestre = '".$semestre."' 
							where  NotasAlumnos.NumeroRutAlumno = '".$line_ve[1]."' and 
									NotasAlumnos.CodigoCurso = '".$line_ve[3]."' and 
									NotasAlumnos.CodigoRamo = '".$line_ve[2]."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '".$semestre."' and 
									Pruebas.NumeroNota = '".$o."' and 
									NotasAlumnos.Nota > 0";
				$res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
				$j=0;
				if (mysql_num_rows($res_notas_1)>0){
					while($row_notas_1 = mysql_fetch_array($res_notas_1)){
							array_push($arrRegistrosDetalle, array("item"					=>	$j, 
														"rut_alumno"			=> 	$row_notas_1[1], 
														"nota"					=>	number_format($row_notas_1[0],1,".","," ), 
														"CodigoRamo"			=>	$row_notas_1[3], 
														"prueba"				=>	$row_notas_1[7], 
														"nro_nota"				=>	$row_notas_1[6],
														"nombre_prueba"			=>	$row_notas_1[8],
														"numero_nota"			=>	$o
														));
							$total_nota += str_replace(',', '.', number_format($row_notas_1[0],1,".","," ));
							$contador_nota++;
						}
					}
				else{
					array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[1], 
															"nota"					=>	'', 
															"CodigoRamo"			=>	$line_ve[2], 
															"numero_nota"			=>	$o));
					
					}
				}
				$select_notas_2 = "select Nota
							from NotasAlumnos
							where  NotasAlumnos.CodigoCurso = '".$line_ve[3]."' and 
									NotasAlumnos.CodigoRamo = '".$line_ve[2]."' and  
									NotasAlumnos.AnoAcademico = '".$anio."' and  
									NotasAlumnos.Semestre = '".$semestre."' and
									Nota > 0";
				$res_notas_2 = mysql_query($select_notas_2, $conexion) or die(mysql_error());
				$contador_prom = 0;
				$total_prom = 0;
				while($row_notas_2 = mysql_fetch_array($res_notas_2)){
					$total_prom += str_replace(',', '.', number_format($row_notas_2['Nota'],1,".","," ));
					$contador_prom++;
					}
			if ($line_ve[7]=='1'){
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[1], 
															"nota"					=>	'', 
															"CodigoRamo"			=>	$line_ve[2]));
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[1], 
															"nota"					=>	'', 
															"CodigoRamo"			=>	$line_ve[2]));
				}
			else{
				$promedio = $total_nota/$contador_nota;			
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[1], 
															"nota"					=>	number_format($promedio,1,".","," ), 
															"CodigoRamo"			=>	$line_ve[2]));
				$total_alumno += round($promedio,1);
				if ($promedio>0){
					$cont_notas_alumno++;
					}
				$promedio = $total_prom/$contador_prom;				
				array_push($arrRegistrosDetalle, array("item"					=>	$j, 
															"rut_alumno"			=> 	$line_ve[1], 
															"nota"					=>	number_format($promedio,1,".","," ), 
															"CodigoRamo"			=>	$line_ve[2]));
				}

			}
	
	$pdf->SetWidths(array(30,180));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Alumno'),utf8_decode($nombre_alumno)),0);

	$pdf->SetWidths(array(30,80,50,50));
	$pdf->SetAligns(array('L','L','L','L'));
	$pdf->Row(array(utf8_decode('Curso'),utf8_decode($nombre_curso),utf8_decode('Nro Lista'),$nro_lista),0);
	$pdf->Row(array(utf8_decode('Profesor(a) Jefe'),utf8_decode($nombre_profesor),utf8_decode('Fecha'),$fecha_actual),0);

	$pdf->Ln();
    
	$pdf->Cell(65,5,'Asignatura',1,0,'C');
	
	$px_nota = (135*1)/($maximo+2);

	$total_notas_px = $maximo+2;
	for($c=1;$c<=$maximo;$c++){
		$pdf->Cell($px_nota,5,'N '.$c,1,0,'C');
		}
	$pdf->Cell($px_nota,5,'Prom. Al.',1,0,'C');
	$pdf->Cell($px_nota,5,'Prom. Cur.	',1,0,'C');
	$pdf->Ln();
    
	$o=0;
	for($d= 0; $d<count($arrRegistros); $d++){
		if ($arrRegistros[$d]['calcula_promedio']=='1'){
			$pdf->SetFont('Arial','I',10);
			$pdf->Cell(65,5,utf8_decode($arrRegistros[$d]['nombre_asignatura']),1,0,'L');
			for($g=0; $g<count($arrRegistrosDetalle);$g++){
				if ($arrRegistros[$d]['asignatura']==$arrRegistrosDetalle[$g]['CodigoRamo']){
	               		if ($arrRegistrosDetalle[$g]['nota'] >= 1){
			               	if ($arrRegistrosDetalle[$g]['nota'] < 4 ){ 
			         			$pdf->SetTextColor(255,0,0);
			                 	$pdf->Cell($px_nota,5,$arrRegistrosDetalle[$g]['nota'],1,0,'C');    
			         			$pdf->SetTextColor(0,0,0);
			                 	}
			                else{
			                    $pdf->Cell($px_nota,5,$arrRegistrosDetalle[$g]['nota'],1,0,'C');       
			                	}	
		                	}
		                else{
		                	    $pdf->Cell($px_nota,5,'',1,0,'C');       
		                	}
					}	
				}
			$pdf->Ln();
			$o++;
			}
		else{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(65,5,utf8_decode($arrRegistros[$d]['nombre_asignatura']),1,0,'L');
			for($g=0; $g<count($arrRegistrosDetalle);$g++){
				if ($arrRegistros[$d]['asignatura']==$arrRegistrosDetalle[$g]['CodigoRamo']){
	               		if ($arrRegistrosDetalle[$g]['nota'] >= 1){
			               	if ($arrRegistrosDetalle[$g]['nota'] < 4 ){ 
			         			$pdf->SetTextColor(255,0,0);
			                 	$pdf->Cell($px_nota,5,$arrRegistrosDetalle[$g]['nota'],1,0,'C');    
			         			$pdf->SetTextColor(0,0,0);
			                 	}
			                else{
			                    $pdf->Cell($px_nota,5,$arrRegistrosDetalle[$g]['nota'],1,0,'C');       
			                	}	
		                	}
		                else{
		                	    $pdf->Cell($px_nota,5,'',1,0,'C');       
		                	}
					}	
				}
			$pdf->Ln();
	    	}
        }
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(65,5,utf8_decode('Promedio'),1,0,'L');
	$menos_uno = 135 - ($px_nota*2);
	$pdf->Cell($menos_uno,5,'',1,0,'R'); 
	$promedio_alumno = $total_alumno/$cont_notas_alumno;
    $pdf->Cell($px_nota,5,round($promedio_alumno,1),1,0,'C');            
    $pdf->Cell($px_nota,5,'',1,0,'C');       
    
    $pdf->Ln();

    
		$notas_ingresadas = $maximo;
    	$notas_ingresadas_2 = $maximo/2;
    		
		$sql_asistencia = "SELECT sum(DiasPeriodo) as cantidad
							from Periodos 
							where AnoAcademico = '".$anio."' ";
		$res_asistencia = mysql_query($sql_asistencia,$conexion) or die(mysql_error());
		$row_asistencia = mysql_fetch_array($res_asistencia);
		$asistencia = $row_asistencia['cantidad'];
		
		$sql_inasistencia = "select count(FechaInasistencia) as ina
							 from Inasistencias
							 where NumeroRutAlumno = '".$rut."' and Year(FechaInasistencia) = '".$anio."'";
		$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());
		$row_inasistencia = mysql_fetch_array($res_inasistencia);
		$inasistencia = $row_inasistencia['ina'];
		
		$porc_ina = 100-(($inasistencia*100)/$asistencia);
		$porc_ina = number_format($porc_ina , 2 , "." , ",");
		
		$sql_atrasos = "select count(FechaAtraso) as ina
								 from Atrasos
							 where NumeroRutAlumno = '".$rut."' and Year(FechaAtraso) = '".$anio."'";
		$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());
		$row_atrasos = mysql_fetch_array($res_atrasos);
		$atrasos = $row_atrasos['ina'];
			
		$sql_positiva = "select count(TipoHojaVida) as ina
								 from HojasDeVida
							 where NumeroRutAlumno = '".$rut."' and TipoHojaVida = 0 and Year(FechaHojaVida) = '".$anio."'";
		$res_positiva = mysql_query($sql_positiva,$conexion) or die(mysql_error());
		$row_positiva = mysql_fetch_array($res_positiva);
		$positiva = $row_positiva['ina'];
			
		$sql_negativa = "select count(TipoHojaVida) as ina
								 from HojasDeVida
							 where NumeroRutAlumno = '".$rut."' and TipoHojaVida = 1 and Year(FechaHojaVida) = '".$anio."'";
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

		$pdf->AddPage();
				
		}

	
	$fecha= date('Y-m-d_h-i-s', time());
	
	$semestre				=	$_GET['semestre'];
	$curso 					= 	$_GET['curso'];

	$pdf->Output('pdfs/'.$fecha.'_'.$semestre.'_'.$curso."_notas_parciales.pdf","F");
	$path = 'pdfs/'.$fecha.'_'.$semestre.'_'.$curso."_notas_parciales.pdf";  	


       	$correo = new PHPMailer();
        $correo->SMTPDebug = 1;                               // Descripcion detallada debug
        $correo->isSMTP();                                      // Set mailer to use SMTP
        $correo->Host = 'mail.gescol.cl';          
        $correo->SMTPAuth = true;         
        $correo->Username = 'sige@gescol.cl';
		$correo->Password = 'SIGE.jaho2019'; 
		$correo->From = $_SESSION["sige_email_usuario"];
        $correo->FromName = 'Sistema Integrado de Gestion Escolar';
      

      	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,
								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado
					from gescolcl_test.Apoderados
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_test.alumnos".$anio."
													where CodigoCurso = '".$curso."')";
		$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());
		$row_apoderado = mysql_fetch_array($res_apoderado);
		
		//$email_apoderado = $row_apoderado['EMailApoderado'];
 		$email_apoderado = 'jhurtado@gescol.cl';
 
		$correo->addAddress($email_apoderado);   
		
		$correo->isHTML(true);                   
        $correo->Subject = utf8_decode('Reporte Sistema Integrado de Gestion Escolar - Notas Parciales Curso');         

        $correo->AddAttachment($path, $asunto, $encoding = 'base64', $type = 'application/pdf');

        $correo->Body = "Envio de Notas Parciales Curso";

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