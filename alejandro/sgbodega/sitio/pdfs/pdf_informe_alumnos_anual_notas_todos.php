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
		// //Posición: a 1,5 cm del final
		// $this->SetY(-15);
		// //Arial italic 8
		// $this->SetFont('Arial','I',8);
		// //Número de página
		// $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}


//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
////////////////////////////////////

class PDF_HTML extends PDF
{
//variables of html parser
protected $B;
protected $I;
protected $U;
protected $HREF;
protected $fontList;
protected $issetfont;
protected $issetcolor;

function __construct($orientation='P', $unit='mm', $format='A4')
{
    //Call parent constructor
    parent::__construct($orientation,$unit,$format);
    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
    $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
    $this->issetfont=false;
    $this->issetcolor=false;
}

function WriteHTML($html)
{
    //HTML parser
    $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
    $html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,stripslashes(txtentities($e)));
        }
        else
        {
            //Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    //Opening tag
    switch($tag){
        case 'STRONG':
            $this->SetStyle('B',true);
            break;
        case 'EM':
            $this->SetStyle('I',true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag,true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        case 'TR':
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag, $enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
    {
        if($this->$s>0)
            $style.=$s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

}


$pdf=new PDF('P','mm','legal'); //pagina carta horizontal
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
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno, DireccionEstablecimiento,
						NumeroDecreto, date_format(FechaDecreto, '%Y') as FechaDecreto, TipoEstablecimiento
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
	$nombre_director = $row_esta['nombre_alumno'];

	$pdf->SetWidths(array(75,50,35,35));
	$pdf->SetAligns(array('C','C','L','L'));
	$pdf->SetFont('Arial','B',8);
	$pdf->Row(array(utf8_decode('REPUBLICA DE CHILE'),utf8_decode(''),utf8_decode('REGION'),utf8_decode('QUINTA')),0);
	$pdf->SetFont('Arial','',8);
	$pdf->Row(array(utf8_decode('MINISTERIO DE EDUCACION'),utf8_decode(''),utf8_decode('PROVINCIA'),utf8_decode('VALPARAISO')),0);
	$pdf->Row(array(utf8_decode('DIVISION DE EDUCACION GENERAL'),utf8_decode(''),utf8_decode('COMUNA'),utf8_decode('VILLA ALEMANA')),0);
	$pdf->Row(array(utf8_decode('SECRETARIA REGIONAL MINISTERIAL DE '),utf8_decode(''),utf8_decode('ROL BASE DE DATOS'),utf8_decode($rbd_establecimiento)),0);
	$pdf->Row(array(utf8_decode('EDUCACION'),utf8_decode(''),utf8_decode('AÑO ESCOLAR'),utf8_decode($anio)),0);

	
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	
	$fecha_actual = date("d/m/Y");
	$pdf->SetFont('Arial','B',12);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Cell(200,7,'CERTIFICADO ANUAL DE ESTUDIOS',0,0,'C');
	$pdf->Ln();

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
					left join Cursos
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					left join Matriculas
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
					left join Cursos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos".$anio.".CodigoCurso
					left join Profesores
						on Cursos".$anio.".ProfesorJefe = Profesores.NumeroRutProfesor 
					left join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where alumnos".$anio.".NumeroRutAlumno = '".$rut."'"; 
	
	}
	
	$res_pd = mysql_query($sql_pd, $conexion) OR die(mysql_error());
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$nombre_alumno = $line_pd[0];
			$nombre_curso = $line_pd[2];
			$nro_lista = $line_pd[3]; 
			$nombre_profesor = $line_pd[4]; 
            $CodigoCurso = $line_pd[5];
            $NumeroRutAlumno_completo = number_format($line_pd[1],0,',','.').'-'.$line_pd[6];
            $DecretoPlanes = $line_pd[7];
            $FechaDecretoPlanes = $line_pd[8];
            $DecretoEvaluacion = $line_pd[9];
            $FechaDecretoEvaluacion = $line_pd[10];
		}

	$pdf->SetFont('Arial','B',10);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	if ($CodigoCurso<'300'){
		$pdf->Cell(200,7,utf8_decode('ENSEÑANZA BÁSICA'),0,0,'C');
		}
	else{
		$pdf->Cell(200,7,utf8_decode('ENSEÑANZA MEDIA'),0,0,'C');
		}
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);	
	$pdf->Cell(200,7,utf8_decode('HUMANISTA - CIENTIFICO'),0,0,'C');
	$pdf->Ln();

	$pdf->SetFont('Arial','',10);

	// if ($CodigoCurso<'300'){
	// 	$pdf->Cell(200,5,utf8_decode('Enseñanza Básica'),0,0,'C');
	// 	$pdf->Ln();
	// 	}
	// else{
	// 	$pdf->Cell(200,5,utf8_decode('Enseñanza Media'),0,0,'C');
	// 	$pdf->Ln();
	// 	}
	
	// $pdf->Cell(200,5,utf8_decode($TipoEstablecimiento),0,0,'C');
	$pdf->Ln();
		
	$pdf->SetWidths(array(10,135,20,35));
	$pdf->SetAligns(array('L','L','L','L'));
	$pdf->Row(array(utf8_decode(''),utf8_decode('Plan y Programas de Estudio, Decreto Exento o Resolución Exenta de Educación'),utf8_decode('N° '.$DecretoPlanes),utf8_decode(' de '.$FechaDecretoPlanes)),0);
	$pdf->Row(array(utf8_decode(''),utf8_decode('Decreto de Promoción o evaluación de alumnos, Decreto Exento de Educación'),utf8_decode('N° '.$DecretoEvaluacion),utf8_decode(' de '.$FechaDecretoEvaluacion)),0);
	$pdf->Row(array(utf8_decode(''),utf8_decode('Decreto Cooperador de la función Educativa del Estado (Ley Decreto Supremo)'),utf8_decode('N° '.$NumeroDecreto),utf8_decode(' de '.$FechaDecreto)),0);
	$pdf->Ln();

	$pdf->Cell(25,5,utf8_decode('Don(ña)'),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->MultiCell(100,5,utf8_decode($nombre_alumno),0,'L');
	$pdf->SetXY($x+100,$y);	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,5,utf8_decode('R.U.N.'),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(25,5,utf8_decode($NumeroRutAlumno_completo),0,0,'L');
	$pdf->Ln();
    $pdf->SetFont('Arial','',10);
	
    $pdf->Cell(25,5,utf8_decode('Alumno(a) del '),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->MultiCell(100,5,utf8_decode($nombre_establecimiento),0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln();
   
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
						alumnos".$anio.".`NumeroRutAlumno`, Asignaturas".$anio.".CodigoRamo, Cursos".$anio.".CodigoCurso, 
						NumeroLista, Ramos.Descripcion, Asignaturas".$anio.".NumeroOrden
				from alumnos".$anio."
					inner join Cursos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos".$anio.".CodigoCurso
					inner join Asignaturas".$anio."
						on Asignaturas".$anio.".CodigoCurso = Cursos".$anio.".CodigoCurso and 
							Asignaturas".$anio.".CalculaPromedio = '0'
					inner join Ramos
						on Ramos.CodigoRamo	= Asignaturas".$anio.".CodigoRamo 
				where
				Cursos".$anio.".CodigoCurso in (select CodigoCurso 
													from alumnos".$anio." 
													where NumeroRutAlumno = '".$rut."' )
				and alumnos".$anio.".NumeroRutAlumno = '".$rut."' 
				group by nombre_alumno,	`NumeroRutAlumno`, Asignaturas".$anio.".CodigoRamo, Cursos".$anio.".CodigoCurso, NumeroLista
				order by Asignaturas".$anio.".NumeroOrden, NumeroLista, PaternoAlumno, MaternoAlumno,  NombresAlumno";

	}
	
	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());
	
	$i = 1;
	while ($line_ve = mysql_fetch_row($res_ve)) {
			$sql_ex = "select NumeroRutAlumno
						from Eximisiones
						WHERE NumeroRutAlumno = '".$rut."' and 
							AnoAcademico = '".$anio."' and
							CodigoRamo = '".$line_ve[2]."'";
			$res_ex = mysql_query($sql_ex,$conexion) or die(mysql_error());
			$eximido = '0';
			if (mysql_num_rows($res_ex)>0){
				$eximido = '1';
				}
			else{
				$eximido = '0';
				}
			array_push($arrRegistros, array("item"					=>	$i, 
											"nombre_alumno"			=> 	$line_ve[0], 
											"rut_alumno"			=> 	$line_ve[1],
											"asignatura" 			=> 	$line_ve[2],
											"curso" 				=> 	$line_ve[3],
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nro_lista_alumno"		=> 	$line_ve[4],
											"nombre_asignatura"		=> 	$line_ve[5],
											"eximido"				=> 	$eximido,
											"numero_orden"			=>	$line_ve[6]
											));
			}

	$promedio_final = $contador_final = 0;
	
		$sql_nfa = "SELECT `NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, 
							`CodigoRamo`, `NotaFinalCurso` 
						FROM `NotasFinalesAsignaturas` 
					WHERE NumeroRutAlumno = '".$rut."' and 
						AnoAcademico = '".$anio."' and
						NotaFinalCurso >0";
		$res_nfa = mysql_query($sql_nfa,$conexion);
		while($row_nfa = mysql_fetch_array($res_nfa)){

				$promedio = $row_nfa['NotaFinalCurso'];

				$primer_numero= substr($promedio,0,1);
				$segundo_numero= substr($promedio,2,1);
				if ($primer_numero!='0') {
					$promedio_final += $promedio;
					$contador_final++;
					if ($segundo_numero==''){
						$segundo_numero = 'cero';
						$promedio = $promedio.'.0';
						}
					$promedio_letras = num2letras($primer_numero).', '.num2letras($segundo_numero);
					}
				else{
					$promedio_letras = '';	
					$promedio = '';
					}
			array_push($arrRegistrosDetalle_total, array("item"			=>	$j, 
											"CodigoRamo_1" 			=> 	$row_nfa['CodigoRamo'],
											"nota_t"				=> 	$promedio,
											"letra_nota"			=>	$promedio_letras, 
											"semestre_t"			=>	't'
											));
								
			}

			
	$sql_situacion = "select nombre , ObservacionSituacion, AsistenciaAno, PromedioAno
						from TiposSituaciones
							inner join SituacionFinal
								on SituacionFinal.Situacion = TiposSituaciones.ts_ncorr
						where AnoAcademico = '".$anio."' and NumeroRutAlumno = '".$rut."'
					";
	$res_situacion = mysql_query($sql_situacion,$conexion);
	$row_situacion = mysql_fetch_array($res_situacion);

	// $promedio_final = round($promedio_final,3,PHP_ROUND_HALF_UP);
	// $promedio_final = round($promedio_final,1,PHP_ROUND_HALF_UP);


	// $promedio_final = round($promedio_final/$contador_final,1,PHP_ROUND_HALF_UP);
	// $primer_numero= substr($promedio_final,0,1);
	// $segundo_numero= substr($promedio_final,2,1);
	// $promedio_final_letras = num2letras($primer_numero).', '.num2letras($segundo_numero);
	// if ($promedio_final_letras=='cero,cero') $promedio_final_letras = 'cero';
	
	$promedio_final = round($row_situacion['PromedioAno'],1,PHP_ROUND_HALF_UP);
	$primer_numero= substr($promedio_final,0,1);
	$segundo_numero= substr($promedio_final,2,1);
	$promedio_final_letras = num2letras($primer_numero).', '.num2letras($segundo_numero);
	if ($promedio_final_letras=='cero,cero') $promedio_final_letras = 'cero';

	// array_push($arrRegistrosDetalle_total, array("item"			=>	$j, 
	// 							"CodigoRamo_1"			=>	'PROMEDIO GENERAL', 
	// 							"nota_t"				=>	$promedio_final, 
	// 							"letra_nota"			=>	$promedio_final_letras, 
	// 							"semestre_t"			=>	't'
	// 										));
		
	array_push($arrRegistrosDetalle_total, array("item"			=>	$j, 
								"CodigoRamo_1"			=>	'PROMEDIO GENERAL', 
								"nota_t"				=>	round($promedio_final,1,PHP_ROUND_HALF_UP), 
								"letra_nota"			=>	$promedio_final_letras, 
								"semestre_t"			=>	't'
											));
		
	$pdf->Ln();
	$pdf->SetFont('Arial','B',11);
    
	$pdf->Cell(130,14,'SUBSECTORES',1,0,'C');
	$pdf->Cell(70,7,utf8_decode('CALIFICACION FINAL'),1,0,'C');
	$pdf->Ln();
    
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(130,7,'',0,0,'C');
	$pdf->Cell(20,7,'Cifras',1,0,'C');
	$pdf->Cell(50,7,'En Palabras',1,0,'C');
	$pdf->Ln();
    
	$px_nota = (150*1)/($maximo+2);
	$total_notas_px = $maximo+2;
	
	$arrRegistros = ordenar_matriz_multidimensionada($arrRegistros, 'numero_orden','ASC');

	$asig_eximidas = '';
	
	for($d= 0; $d<count($arrRegistros); $d++){
		for($g=0; $g<count($arrRegistrosDetalle_total);$g++){
				if ($arrRegistros[$d]['eximido']=='1'){
					$pdf->Cell(130,7,utf8_decode($arrRegistros[$d]['nombre_asignatura']),1,0,'L');
					$pdf->Cell(20,7,'Ex',1,0,'C');    
	         		$pdf->Cell(50,7,'Eximido',1,0,'C');    
	         		$asig_eximidas .= $arrRegistros[$d]['nombre_asignatura'].',';
					$pdf->Ln();
					$g=count($arrRegistrosDetalle_total);
	         		}
				else{
	        		if ($arrRegistros[$d]['asignatura']==$arrRegistrosDetalle_total[$g]['CodigoRamo_1']){
						$pdf->Cell(130,7,utf8_decode($arrRegistros[$d]['nombre_asignatura']),1,0,'L');
				        if ($arrRegistrosDetalle_total[$g]['nota_t'] < 4) { 
		         			$pdf->SetTextColor(255,0,0);
		                 	$pdf->Cell(20,7,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');    
		         			$pdf->SetTextColor(0,0,0);
		                 	}
		                else{
		                    $pdf->Cell(20,7,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');       
		                	}	
			   			if ($arrRegistrosDetalle_total[$g]['letra_nota']=='Cero , Cero '){
							$pdf->Cell(50,7,'Cero',1,0,'C');       		
							}
						else
							{
							$pdf->Cell(50,7,$arrRegistrosDetalle_total[$g]['letra_nota'],1,0,'C');       		
							}
						$pdf->Ln();
						}
					elseif (($arrRegistrosDetalle_total[$g]['CodigoRamo_1']=='PROMEDIO GENERAL') &&($d==count($arrRegistros)-1) ){
						$pdf->SetFont('Arial','B',11);
						$pdf->Cell(130,7,utf8_decode($arrRegistrosDetalle_total[$g]['CodigoRamo_1']),1,0,'L');
						$pdf->Cell(20,7,$arrRegistrosDetalle_total[$g]['nota_t'],1,0,'C');       
		                $pdf->Cell(50,7,$arrRegistrosDetalle_total[$g]['letra_nota'],1,0,'C');       		
						$pdf->Ln();
						$pdf->SetFont('Arial','',11);
						}
				}
			}
    	}

        

    // $sql_situacion = "select nombre , ObservacionSituacion, AsistenciaAno
	// 					from TiposSituaciones
	// 						inner join SituacionFinal
	// 							on SituacionFinal.Situacion = TiposSituaciones.ts_ncorr
	// 					where AnoAcademico = '".$anio."' and NumeroRutAlumno = '".$rut."'
	// 				";
	// $res_situacion = mysql_query($sql_situacion,$conexion);
	// $row_situacion = mysql_fetch_array($res_situacion);

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(130,7,utf8_decode('PORCENTAJE DE ASISTENCIA'),1,0,'L');
	$pdf->Cell(20,7,substr(str_pad(($row_situacion['AsistenciaAno']),2),0,2).' %',1,0,'C');       
    $pdf->Cell(50,7,'',1,0,'C');       		
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);

 	$pdf->Ln();
    


	$pdf->Ln();
    
	
	
	$pdf->SetFont('Arial','I',11);
	$pdf->SetWidths(array(40,160));
	$pdf->SetAligns(array('L','L'));
	

	$sql_cp = "select DescripcionLarga from Cursos where CodigoCurso in (select CursoPrecede from Cursos where CodigoCurso='".$CodigoCurso."')";
	$res_cp = mysql_query($sql_cp,$conexion);
	$row_cp = mysql_fetch_array($res_cp);
		

	if ($row_situacion['nombre']=='Promovido'){
		if (($CodigoCurso=='370')||($CodigoCurso=='380')){
			$comentario = 'El alumno egresa de la Enseñanza Media Científico Humanista.';
			}
		else{
			$comentario = 'El alumno es promovido a '.$row_cp['DescripcionLarga'].'.';
			}
		}
	else{
		$comentario = 'El alumno fue '.$row_situacion['nombre'].' del curso '.$nombre_curso.'.';
		}
	$comentario_2 = '';
	if ($asig_eximidas!=''){
		$comentario_2 .='Eximido '.$asig_eximidas;
		}

	
	$pdf->Cell(40,5,utf8_decode('En consecuencia'),0,0,'L');
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(160,5,'__________________________________________________________________________',0,'L');
	$pdf->SetXY($x,$y);	
	$pdf->Cell(175,5,utf8_decode($comentario),0,'L');
	$pdf->Ln();
    $pdf->Cell(200,5,'_____________________________________________________________________________________________',0,'L');
	$pdf->Ln();
    $pdf->Ln();
    
    $pdf->Cell(40,5,utf8_decode('Observaciones'),0,0,'L');
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(160,5,'__________________________________________________________________________',0,'L');
	$pdf->SetXY($x,$y);	
	$pdf->Cell(175,5,utf8_decode($row_situacion['ObservacionSituacion'].'. '.substr($comentario_2,0,strlen($comentario_2)-1)),0,'L');
	$pdf->Ln();
    $pdf->Cell(200,5,'_____________________________________________________________________________________________',0,'L');
	$pdf->Ln();
    
    
	$fecha_actual_anual = date("Y-m-d");
	list($a,$m,$d) = explode('-',$fecha_actual_anual);
	$m_l = '';
	if ($m =='1'){$m_l = 'Enero';}
	elseif ($m =='2'){$m_l = 'Febrero';}
	elseif ($m =='3'){$m_l = 'Marzo';}
	elseif ($m =='4'){$m_l = 'Abril';}
	elseif ($m =='5'){$m_l = 'Mayo';}
	elseif ($m =='6'){$m_l = 'Junio';}
	elseif ($m =='7'){$m_l = 'Julio';}
	elseif ($m =='8'){$m_l = 'Agosto';}
	elseif ($m =='9'){$m_l = 'Septiembre';}
	elseif ($m =='10'){$m_l = 'Octubre';}
	elseif ($m =='11'){$m_l = 'Noviembre';}
	elseif ($m =='12'){$m_l = 'Diciembre';}
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('L'));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Villa Alemana, '.$d.' de '.$m_l.' de '.$a)),0);
	
	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('C','C'));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$sql_situacion = "select concat(NombresDirector,' ',PaternoDirector,' ',MaternoDirector) as nombre_director
						from Periodos
						where AnoAcademico = '".$anio."'
					";
	$res_situacion = mysql_query($sql_situacion,$conexion);
	$row_situacion = mysql_fetch_array($res_situacion);

	$pdf->SetFont('Arial','B',11);
	$pdf->Row(array(utf8_decode('_____________________________'),utf8_decode('_____________________________')),0);
	$pdf->Row(array(utf8_decode($nombre_profesor),utf8_decode($row_situacion['nombre_director'])),0);
	$pdf->Row(array(utf8_decode('Nombre y Firma'),utf8_decode('Nombre y Firma')),0);
	$pdf->Row(array(utf8_decode('Profesor(a) Jefe'),utf8_decode('Director(a)')),0);
	$pdf->SetFont('Arial','',8);
	
		
		if ($linea_alumno<$contador_alumnos){
			$pdf->AddPage();
			}
				
		}

	$pdf->Output();
		
	?>
