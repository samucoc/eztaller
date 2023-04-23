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

	$curso 					= 	$_GET['curso'];
	
	
	$sql_alumno_busca = "select 
				NumeroRutAlumno
				from alumnos".$anio."
				where alumnos".$anio.".CodigoCurso = '".$curso."'
				order by NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno"; 
	
	$res_alumno_busca = mysql_query($sql_alumno_busca, $conexion);

	while($row_alumno_busca = mysql_fetch_array($res_alumno_busca)){

		$rut 					=   $row_alumno_busca['NumeroRutAlumno'];
	
	$arrRegistros			= 	array();
	$arrRegistrosDetalle_1	= 	array();
	$arrRegistrosDetalle_2	= 	array();
	$arrRegistrosDetalle_total 	= 	array();
	$arrRegistrosPrueba		= 	array();
	$arrRegistrosMaximo		= 	array();
	
	$sql_esta = "select NombreEstablecimiento, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno, DireccionEstablecimiento,
						NumeroDecreto, date_format(FechaDecreto, '%d-%m-%Y') as FechaDecreto, TipoEstablecimiento
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
	$NumeroDecreto = $row_esta['NumeroDecreto'];
	$FechaDecreto = $row_esta['FechaDecreto'];
	$TipoEstablecimiento = $row_esta['TipoEstablecimiento'];
		
	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('L','R'));
	$pdf->Row(array(utf8_decode('REPUBLICA DE CHILE'),utf8_decode('Quinta Región')),0);
	$pdf->Row(array(utf8_decode('MINISTERIO DE EDUCACION'),utf8_decode('Provincia Valparaíso')),0);
	$pdf->Row(array(utf8_decode('DIVISION DE EDUCACION GENERAL'),utf8_decode('Comuna Villa Alemana')),0);
	$pdf->Row(array(utf8_decode('SECRETARIA REGIONAL MINISTERIAL DE EDUCACION'),utf8_decode('Rol base de datos: '.	$rbd_establecimiento)),0);
	$pdf->Row(array(utf8_decode(''),utf8_decode('Año Escolar: '.$anio)),0);
	
	$pdf->Ln();
	
	$fecha_actual = date("d/m/Y");
	$pdf->SetFont('Arial','B',10);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Cell(200,5,'CERTIFICADO ANUAL DE ESTUDIOS',0,0,'C');
	$pdf->Ln();

/*
$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, 
						NroLista as NumeroLista, Pruebas.CoeficientePrueba, Ramos.Descripcion
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
	
*/
	if($anio=='2018'){
		$sql_pd = "select 
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				alumnos".$anio.".NumeroRutAlumno,
				DescripcionLarga,
				NroLista as NumeroLista,
				concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) ,
				Cursos.CodigoCurso, 
				DigitoRutAlumno,
				DecretoPlanes,
				date_format(FechaDecretoPlanes, '%Y') as FechaDecretoPlanes,
				DecretoEvaluacion,
				date_format(FechaDecretoEvaluacion, '%Y') as FechaDecretoEvaluacion
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where alumnos".$anio.".NumeroRutAlumno = '".$rut."'"; 
	}
	else{
		$sql_pd = "select 
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 
				alumnos".$anio.".NumeroRutAlumno,
				DescripcionLarga,
				NroLista as NumeroLista,
				concat(NombresProfesor,' ',PaternoProfesor,' ',MaternoProfesor) ,
				Cursos".$anio.".CodigoCurso, 
				DigitoRutAlumno,
				DecretoPlanes,
				date_format(FechaDecretoPlanes, '%Y') as FechaDecretoPlanes,
				DecretoEvaluacion,
				date_format(FechaDecretoEvaluacion, '%Y') as FechaDecretoEvaluacion
				from alumnos".$anio."
					inner join Cursos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos".$anio.".CodigoCurso
					inner join Profesores
						on Cursos".$anio.".ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where alumnos".$anio.".NumeroRutAlumno = '".$rut."'"; 
	
	}
	
	$res_pd = mysql_query($sql_pd, $conexion);
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$nombre_alumno = $line_pd[0];
			$nombre_curso = $line_pd[2];
			$nro_lista = $line_pd[3]; 
			$nombre_profesor = $line_pd[4]; 
            $CodigoCurso = $line_pd[5];
            $NumeroRutAlumno_completo = $line_pd[1].'-'.$line_pd[6];
            $DecretoPlanes = $line_pd[7];
            $FechaDecretoPlanes = $line_pd[8];
            $DecretoEvaluacion = $line_pd[9];
            $FechaDecretoEvaluacion = $line_pd[10];
		}

	$pdf->SetFont('Arial','',8);

	if ($CodigoCurso<'300'){
		$pdf->Cell(200,5,utf8_decode('Enseñanza Básica'),0,0,'C');
		$pdf->Ln();
		}
	else{
		$pdf->Cell(200,5,utf8_decode('Enseñanza Media'),0,0,'C');
		$pdf->Ln();
		}
	
	$pdf->Cell(200,5,utf8_decode($TipoEstablecimiento),0,0,'C');
	$pdf->Ln();
	$pdf->Ln();
		
	$pdf->SetWidths(array(150,50));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Plan y Programas de Estudio, Decreto Exento o Resolución Exenta de Educación'),utf8_decode($DecretoPlanes.' de '.$FechaDecretoPlanes)),0);
	$pdf->Row(array(utf8_decode('Decreto de Promoción o evaluación de alumnos, Decreto Exento de Educación'),utf8_decode($DecretoEvaluacion.' de '.$FechaDecretoEvaluacion)),0);
	$pdf->Row(array(utf8_decode('Decreto Cooperador de la función Educativa del Estado (Ley Decreto Supremo)'),utf8_decode($NumeroDecreto.' de '.$FechaDecreto)),0);
	$pdf->Ln();
	$pdf->Ln();

	$pdf->SetWidths(array(50,50,50,50));
	$pdf->SetAligns(array('L','L','L','L'));
	$pdf->Row(array(utf8_decode('Don(ña)'),utf8_decode($nombre_alumno),utf8_decode('Run'),utf8_decode($NumeroRutAlumno_completo)),0);
	
	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('L','L'));
	$pdf->Row(array(utf8_decode('Alumno(a) del '),utf8_decode($nombre_establecimiento)),0);
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('L'));
	$pdf->Row(array(utf8_decode('ha cursado el '.$nombre_curso.' y, de acuerdo a las disposiciones reglamentarias vigentes, ha obtenido los siguientes resultados:')),0);
	
	$maximo = 3;
		
	if($anio=='2018'){
		$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						alumnos".$anio.".`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, 
						NumeroLista, Ramos.Descripcion, Asignaturas.NumeroOrden
				from alumnos".$anio."
					inner join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos.CodigoCurso and 
							Asignaturas.CalculaPromedio = '0'
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 
				where
				Cursos.CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )
				and alumnos".$anio.".NumeroRutAlumno = '".$rut."' 
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos.CodigoCurso, NumeroLista
				order by Asignaturas.NumeroOrden, NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";

	}
	else{
		$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
						alumnos".$anio.".`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos".$anio.".CodigoCurso, 
						NumeroLista, Ramos.Descripcion, Asignaturas.NumeroOrden
				from alumnos".$anio."
					inner join Cursos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos".$anio.".CodigoCurso
					inner join Asignaturas
						on Asignaturas.CodigoCurso = Cursos".$anio.".CodigoCurso and 
							Asignaturas.CalculaPromedio = '0'
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 
				where
				Cursos".$anio.".CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )
				and alumnos".$anio.".NumeroRutAlumno = '".$rut."' 
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas.CodigoRamo, Cursos".$anio.".CodigoCurso, NumeroLista
				order by Asignaturas.NumeroOrden, NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";

	}
	
	$res_ve = mysql_query($sql_ve, $conexion);
	//$objResponse->addAlert($sql_ve);
	$promedio_1 = 0;
	$promedio_2 = 0;
		$i = 1;
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
			$promedio = round(($arrRegistrosDetalle_1[$z]['nota']+$arrRegistrosDetalle_2[$z]['nota'])/2,1);
			$primer_numero= substr($promedio,0,1);
			$segundo_numero= substr($promedio,2,1);
			$promedio_letras = num2letras($primer_numero).', '.num2letras($segundo_numero);
			if ($promedio_letras=='cero,cero') $promedio_letras = 'cero';
			array_push($arrRegistrosDetalle_total, array("item"			=>	$j, 
									"CodigoRamo_1"			=>	$arrRegistrosDetalle_1[$z]['CodigoRamo'], 
									"nota_t"				=>	$promedio, 
									"letra_nota"			=>	$promedio_letras, 
									"semestre_t"			=>	't'
												));
				
			
			}


	
	$pdf->Ln();
    
	$pdf->Cell(50,5,'Asignatura',1,0,'C');
	
	$px_nota = (150*1)/($maximo+2);

	$total_notas_px = $maximo+2;

	$pdf->Cell(75,5,'Cifras',1,0,'C');
	$pdf->Cell(75,5,'En Palabras',1,0,'C');
	$pdf->Ln();
    
	//var_dump($arrRegistrosDetalle_total);
	//var_dump($arrRegistros);

    for($d= 0; $d<count($arrRegistros); $d++){
		$pdf->Cell(50,5,utf8_decode($arrRegistros[$d]['nombre_asignatura']),1,0,'L');
		for($g=0; $g<count($arrRegistrosDetalle_total);$g++){
			if ($arrRegistros[$d]['asignatura']==$arrRegistrosDetalle_total[$g]['CodigoRamo_1']){
                if ($arrRegistrosDetalle_total[$g]['nota_t'] < 4) { 
         			$pdf->SetTextColor(255,0,0);
                 	$pdf->Cell(75,5,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');    
         			$pdf->SetTextColor(0,0,0);
                 	}
                else{
                    $pdf->Cell(75,5,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');       
                	}	
	   			if ($arrRegistrosDetalle_total[$g]['letra_nota']=='Cero , Cero '){
					$pdf->Cell(75,5,'Cero',1,0,'C');       		
					}
				else
					{
					$pdf->Cell(75,5,$arrRegistrosDetalle_total[$g]['letra_nota'],1,0,'C');       		
					}
				}
			}
		$pdf->Ln();
    	}
        
    $pdf->Ln();
    


	$pdf->Ln();
    
	$pdf->SetWidths(array(25,75,25,75));
	$pdf->SetAligns(array('L','L','L','L'));
	
	
	$pdf->Row(array(utf8_decode('En consecuencia'),utf8_decode(''),utf8_decode('Observación General'),utf8_decode('')),0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('C','C'));
	$pdf->Row(array(utf8_decode('Firma Director'),utf8_decode('Firma Profesor Jefe')),0);
	$pdf->Row(array(utf8_decode('_______________'),utf8_decode('_______________')),0);

			$pdf->AddPage();
				
		}

	$fecha= date('Y-m-d_h-i-s', time());
	$pdf->Output('pdfs/'.$fecha.'_'.$rut."_anual_notas_todos.pdf","F");
	$path = 'pdfs/'.$fecha.'_'.$rut.."_anual_notas_todos.pdf";  	


       	$correo = new PHPMailer();
        $correo->SMTPDebug = 1;                               // Descripcion detallada debug
        $correo->isSMTP();                                      // Set mailer to use SMTP
        $correo->SMTPAuth = true;         
        $correo->Username = 'sige@gescol.cl';
		$correo->Password = 'SIGE.jaho2019'; 
		$correo->Host = 'mail.gescol.cl';          
        $correo->From = $_SESSION["sige_email_usuario"];
        $correo->FromName = 'Sistema Integrado de Gestion Escolar';
      

      	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,
								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado
					from gescolcl_test.Apoderados
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_test.alumnos".$anio."
													where NumeroRutAlumno = '".$rut."')";
		$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());
		$row_apoderado = mysql_fetch_array($res_apoderado);
		
		//$email_apoderado = $row_apoderado['EMailApoderado'];
 		$email_apoderado = 'jhurtado@gescol.cl';
 
		$correo->addAddress($email_apoderado);   
		
		$correo->isHTML(true);                   
        $correo->Subject = utf8_decode('Reporte Sistema Integrado de Gestion Escolar - CERTIFICADO ANUAL DE ESTUDIOS');         

        $correo->AddAttachment($path, $asunto, $encoding = 'base64', $type = 'application/pdf');

        $correo->Body = "Envio de CERTIFICADO ANUAL DE ESTUDIOS";

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
