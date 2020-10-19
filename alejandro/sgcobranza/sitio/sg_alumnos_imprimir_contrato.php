<?php
ob_start();
session_start();

require('../includes/php/fpdf/fpdf.php');
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

mysql_query("SET NAMES 'utf8'");	

function mes_letras($mes){
	$mes_ele = '';
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
	return $mes_ele;
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

	mysql_query("SET NAMES utf8");

	$alumno = $_GET['rut_alumno'];
	if ($alumno=='') $alumno = $_POST['rut_alumno'];
	$anio_vigente = $_SESSION['sige_anio_escolar_vigente'];

	$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,
								NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado,
								DireccionParticularApoderado, Ciudad
					from gescolcl_arcoiris_administracion.Apoderados
						inner join gescolcl_arcoiris_administracion.Ciudades 
							on Apoderados.CiudadParticularApoderado = Ciudades.CodigoCiudad
					where NumeroRutApoderado in (select NumeroRutApoderado
													from gescolcl_arcoiris_administracion.alumnos".$anio_vigente."
													where NumeroRutAlumno = '".$alumno."')";
	$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());
	$row_apoderado = mysql_fetch_array($res_apoderado);
	
	$rut_apoderado = $row_apoderado['NumeroRutApoderado'].'-'.dv($row_apoderado['NumeroRutApoderado']);
	$nombre_apoderado = $row_apoderado['nombre'];
	$direccion_apoderado = $row_apoderado['DireccionParticularApoderado'];
	$ciudad_apoderado = $row_apoderado['Ciudad'];

	$ma='';
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,5,'Periodo '.$_SESSION['sige_anio_escolar_vigente'],0,0,'R');
	$pdf->Ln();
	if (($rut_apoderado!=$_POST['rut_apoderado'])||($nombre_apoderado!=$_POST['nombre_apo'])
			||($direccion_apoderado!=$_POST['direccion_apo'])||($ciudad_apoderado!=$_POST['ciudad_apo'])){
		$ma = 'MA';
		$pdf->Cell(200,5,$ma,0,0,'R');
		$pdf->Ln();
		}
	else{
		$pdf->Cell(200,5,'',0,0,'R');
		$pdf->Ln();
		}
	$pdf->Cell(200,5,'CPS Nro.',0,0,'R');
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(200,10,'CONTRATO DE PRESTACION DE SERVICIOS EDUCACIONALES',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('J'));
	
	list($anio,$mes,$dia) = explode('-',date("Y-m-d"));
	
	$fecha_letras = $dia.' de '.mes_letras($mes).' de '.$anio;
	
	if(isset($_POST['rut_apoderado'])){
		$rut_apoderado 			= $_POST['rut_apoderado'];
		$nombre_apoderado 		= $_POST['nombre_apo'];
		$direccion_apoderado 	= $_POST['direccion_apo'];
		$ciudad_apoderado 		= $_POST['ciudad_apo'];
		}

	$sql_pd = "select 
				distinct
				Cursos.DescripcionLarga as NombreCurso,
				concat(`NombresAlumno`,' ',`PaternoAlumno`,' ',`MaternoAlumno`) as nombre_alumno,
				FechaNacimiento, DireccionParticularAlumno, TelefonoParticularAlumno, EMailAlumno,
				TipoBeca, BecaIncorporacion, BecaColegiatura
				from gescolcl_arcoiris_administracion.Cursos
					inner join gescolcl_arcoiris_administracion.alumnos".$anio_vigente."
						on alumnos".$anio_vigente.".CodigoCurso = Cursos.CodigoCurso
				where
					alumnos".$anio_vigente.".NumeroRutAlumno = '".$alumno."'"; 
	$res_pd = mysql_query($sql_pd,$conexion) or die(mysql_error());
	$row_pd = mysql_fetch_array($res_pd);
	$nombre_alumno = $row_pd['nombre_alumno'];
	$nombre_curso = $row_pd['NombreCurso'];
			 
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

	$pdf->Row(array(utf8_decode('En Villa Alemana, a '.$fecha_letras.', comparecen: la FUNDACION EDUCACIONAL NUEVO MILENIO, sociedad del giro  de su denominación, RUT N° 65.154.531-5, sostenedora del COLEGIO NUEVO MILENIO, R.B.D. 14674-9, Resolución Exenta Nº 01120 del Ministerio de Educación de fecha 1 de Marzo de 2002, representada legalmente por don '.$nombre_repre.', chileno, cédula nacional de identidad Nº '.$rut_repre.', todos domiciliados en calle Alcalde Rodolfo Galleguillos N° 197, Villa Alemana, en adelante el "COLEGIO" y don(a) '.$nombre_apoderado.',  chileno(a), cédula nacional de identidad Nº '.$rut_apoderado.', con dirección '.$direccion_apoderado.', ciudad de '.$ciudad_apoderado.'; en adelante el "APODERADO FINANCIERO"; ambos comparecientes mayores de edad, exponen que vienen en celebrar el presente contrato de prestación de servicios educacionales, bajo las cláusulas que a continuación se expresan: ')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('PRIMERO: Por el presente instrumento, el Apoderado Financiero encomienda al Colegio, la labor de impartir enseñanza escolar para el año escolar '.$anio_vigente.' al alumno(a):')),0);	
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(100,100));
	$pdf->SetAligns(array('C','C'));

	$pdf->Row(array(utf8_decode('Nombre - Cedula de identidad Nro'),utf8_decode('Curso '.$anio_vigente)),1);
	$pdf->Row(array(utf8_decode($nombre_alumno.' - '.$alumno.'-'.dv($alumno)),utf8_decode(str_replace('ADMISION', '', $nombre_curso))),1);
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('J'));
	
	$pdf->Row(array(utf8_decode('SEGUNDO: En virtud del presente contrato, el Colegio, se obliga a prestar los servicios educacionales al alumno(a) antes individualizado, de acuerdo a los Planes y Programas de Estudios aprobados por el Ministerio de Educación.')),0);	
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->Row(array(utf8_decode('Así mismo, el Colegio como entidad formativa tiene derecho y se obliga a:')),0);	
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->Row(array(utf8_decode('1)  Establecer y ejercer su proyecto educativo, de acuerdo a la autonomía que le garantiza el ordenamiento jurídico, difundir su contenido a los integrantes de la comunidad educativa del establecimiento, a dictar y establecer los Reglamentos Internos del Colegio y velar por el cumplimiento de sus disposiciones.')),0);	
	$pdf->Row(array(utf8_decode('2)  Proporcionar a los alumnos, de acuerdo con las normas internas, el uso de la infraestructura del Colegio, que se requiere para el desarrollo del programa curricular, ya sea en el aula, y otros espacios destinados al desarrollo educacional e integral del alumno(a).')),0);	

	$pdf->Row(array(utf8_decode('3)  Evaluar a los alumnos, conforme a las disposiciones legales y a las propias del Colegio, de acuerdo al Reglamento de Evaluación.')),0);	
	$pdf->Row(array(utf8_decode('4)  Promover actividades curriculares no lectivas que estimulen el desarrollo físico, deportivo e intelectual del alumno, a través de talleres deportivos, científicos, artísticos y culturales. ')),0);	
	$pdf->Row(array(utf8_decode('5)  Proporcionar a los apoderados la información del rendimiento académico y del proceso educativo del alumno(a), del funcionamiento del establecimiento educacional, oírlos y recibir sus sugerencias para el desarrollo del proceso educativo en los ámbitos que les competa y facilitar su participación en el Centro de Padres y Apoderados del Colegio.La información que se entregue a los apoderados y la atención personal de los mismos, se efectuará conforme al procedimiento de información y de entrevistas personales que determine el Colegio. ')),0);	
	$pdf->Row(array(utf8_decode('6)  Disponer del personal docente, asistentes de la educación, equipo técnico, servicios de orientación y mantener en condiciones adecuadas las dependencias en que se entrega el servicio educacional.')),0);	
	$pdf->Row(array(utf8_decode('7)  El Colegio se obliga a entregar copia digital (Página Web, Correo Electrónico, otros) del Proyecto Educativo Institucional, el Reglamento de Evaluación, y Manual de Convivencia Escolar, cuando el alumno se matricula por primera vez en el Colegio o cuando estos reglamentos se modifican para el desarrollo de actividades de extensión y de orientación vocacional.')),0);	
	//$pdf->Row(array(utf8_decode('8º Otorgar Becas, de acuerdo a….')),0);	
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('TERCERO:    El Apoderado Financiero, declara expresamente lo siguiente: ')),0);	
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('1)  Que es el padre, madre, tercero autorizado, tutor o curador del alumno (a) individualizado (a) en la cláusula Primero, y que se obliga personalmente a cumplir y a hacer cumplir las obligaciones que impone el presente contrato, y que en especial se obliga a pagar los compromisos u obligaciones económicas que para estos efectos contrae con el Colegio. ')),0);	
	$pdf->Row(array(utf8_decode('2)  Que se ha informado debidamente respecto de las características del Colegio y de la infraestructura con que cuenta el establecimiento educacional para realizar el quehacer de la enseñanza. ')),0);	
	$pdf->Row(array(utf8_decode('3)  Que al firmar este Contrato, se obliga a tomar conocimiento, leer y estudiar el Proyecto Educativo, el Reglamento de Evaluación y Manual de Convivencia escolar.')),0);	
	$pdf->Row(array(utf8_decode('4)   Que el alumno (a) se encuentra en buenas condiciones físicas, psíquicas y psicológicas para participar normalmente en el desarrollo del proceso educativo del Colegio, actividades deportivas, y que pondrá oportunamente en conocimiento del Colegio cualquier cambio, trastorno o alteración en sus condiciones psíquicas, psicológicas, físicas o en su estado de salud lo que deberá ser respaldado con el informe médico respectivo para resguardar al alumno en el proceso aprendizaje y la convivencia escolar.')),0);	
	$pdf->Row(array(utf8_decode('5)  El Apoderado Financiero declara conocer la obligación legal de la Dirección del Colegio de denunciar ante el Ministerio Público, Policía de Investigaciones y/o Carabineros de Chile, Tribunales de Familia, según corresponda, los hechos que pudieren revestir características de delito que se hayan cometido al interior del establecimiento y que tenga participación el alumno (a)  y/o apoderado o tercero y  que hayan afectado a éste (a), como informar cualquier vulneración de derechos que es objeto el alumno; así mismo, de aquellos delitos o situaciones de violencia intrafamiliar que el Colegio tome conocimiento y que digan relación con el alumno(a).')),0);
	$pdf->Row(array(utf8_decode('6)  El Apoderado Financiero declara conocer y aceptar expresamente, en todas y cada una de sus partes, el Proyecto Educativo Institucional (PEI) del Colegio, así como todos los documentos y normas internas que explicitan, desarrollan y concretan el PEI esto es, Manual de Convivencia Escolar, Reglamento de Evaluación y Promoción; Reglamento General del Centro de Padres y Apoderados y demás, generados por el Equipo Docente Directivo del Establecimiento en dicho carácter. ')),0);
	$pdf->Row(array(utf8_decode('7)  El Apoderado Financiero declara que ha optado por el Colegio por cuanto el tipo de educación y formación que entrega el Colegio es la que quiere para la formación de su hijo o pupilo, por tanto, adhiere a su Proyecto Educativo y a su reglamentación interna.')),0);
	$pdf->Row(array(utf8_decode('8)  El Apoderado Financiero declara que se compromete a velar por el adecuado reforzamiento educativo del alumno(a), y que cumpla los deberes que el Colegio le impone, participando activamente en la educación del alumno. En consecuencia, el Apoderado Financiero se obliga a guiar al alumno(a) en el ejercicio de los derechos y en el cumplimiento de sus deberes, consagrados en el presente contrato y en la normativa interna del Colegio.')),0);
	$pdf->Row(array(utf8_decode('9)  Que, en el evento que el Apoderado Financiero y/o Apoderado académico solicite autorización para que el alumno se retire almorzar a su domicilio, el Colegio no tiene responsabilidad alguna por accidentes y otro hecho que pueda ocurrir; si el alumno(a) no regresa a la jornada después de almuerzo el apoderado asume toda la responsabilidad y el alumno deberá presentarse con su apoderado al día siguiente a justificar su ausencia. Los atrasos e inasistencias serán contabilizados.')),0);
	$pdf->Row(array(utf8_decode('10) Para la realización del proceso de educación y enseñanza, sin perjuicio del pago del arancel educacional, se deben asumir, respetar y cumplir diversas obligaciones, entre las cuales se estipulan las que siguen a continuación: ')),0);
	$pdf->Row(array(utf8_decode('a)  Controlar y supervisar la educación del alumno(a), revisando, contestando y firmando las comunicaciones emanadas de la Dirección, Inspectoría, UTP, Administración, profesores y, en general, del Colegio; preocuparse del cumplimiento de los deberes del alumno, presentación, aseo personal, conducta, asistencia a clases y demás actividades, culturales, académicas y deportivas que el Colegio dictamine; además de promover el estudio, la realización de tareas, guías, preparación de pruebas, trabajos y toda actividad destinada al logro del aprendizaje.')),0);
	$pdf->Row(array(utf8_decode('b)  Se obliga a respetar el conducto regular para informar sus inquietudes o problemas.')),0);
	$pdf->Row(array(utf8_decode('c)  Se obliga a que cualquier requerimiento, solicitud, reclamo o denuncia lo realizará en forma personal, ya que el correo electrónico o llamadas telefónicas no son los conductos regulares o adecuados.')),0);
	$pdf->Row(array(utf8_decode('d)  Designar un representante con plenas facultades para que lo reemplace frente al Colegio en caso de ausencia por largo tiempo (comunicado y aceptado por el Colegio); quien se entenderá facultado para ser válidamente notificado de toda comunicación emanada del Colegio.')),0);
	$pdf->Row(array(utf8_decode('e)  Contribuir a crear un ambiente positivo en el Colegio y evitar conductas que promuevan la intolerancia y falta de de armonía entre los miembros de la comunidad escolar; y a evitar comentarios infundados que puedan dañar la imagen del Colegio o de su personal.')),0);
	
	$pdf->Row(array(utf8_decode('f)  Participar en las tareas educativas, formativas y deportivas que, en beneficio del alumno(a) y/o de la familia conciba y desarrolle el Colegio, observando las instrucciones que con este objetivo emita el establecimiento, asistiendo a las reuniones de curso, citaciones y/o entrevistas, y haciéndose responsable de todas las acciones de refuerzo, tratamiento y/o atención especial que solicite el Colegio para el beneficio de su pupilo.')),0);
	$pdf->Row(array(utf8_decode('g)  Aceptar que el alumno(a) asista a las clases de reforzamiento determinadas por el Colegio, entendiendo que esto es obligatorio. ')),0);
	$pdf->Row(array(utf8_decode('h)  Hacer cumplir al alumno (a) las Normas de Convivencia Escolar que promueva el Colegio establecidas en el Reglamento Interno. ')),0);
	$pdf->Row(array(utf8_decode('i)  Acatar las indicaciones técnico-pedagógicas y disciplinarias que emanen del Consejo de Profesores,  Inspectoría General, Orientación, Consejo de Disciplina y/o Comité de Convivencia Escolar, refrendadas por el Director del Colegio, que apuntan a velar por el bienestar académico y psicológico del alumno(a) y resguardar los derechos de los demás integrantes del grupo curso, que puedan estar siendo afectados por el actuar negativo del alumno(a).')),0);
	
	$pdf->Row(array(utf8_decode('j)  Cumplir con los compromisos asumidos con el Establecimiento Educacional.')),0);
	$pdf->Row(array(utf8_decode('k)  Brindar un trato respetuoso a los integrantes de la Comunidad Educativa. ')),0);
	$pdf->Row(array(utf8_decode('l)  Acatar el Reglamento Interno del Centro General de padres y  Apoderados, cooperar en las actividades que programe éste, y el subcentro de Padres y Apoderados del curso del alumno (a).')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('CUARTO:    El Apoderado Financiero tiene derecho a: ')),0);
	$pdf->Row(array(utf8_decode('1)   Ser informado respecto del rendimiento académico y del proceso educativo del alumno;')),0);
	$pdf->Row(array(utf8_decode('2)   Ser informado del funcionamiento del establecimiento; ')),0);
	$pdf->Row(array(utf8_decode('3)   Ser escuchado y recibido por la Dirección (previa cita); ')),0);
	$pdf->Row(array(utf8_decode('4)   Participar del proceso educativo en los ámbitos que les corresponda, aportando al desarrollo del Proyecto Educativo en conformidad a la normativa interna del Establecimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('QUINTO:     El Apoderado Financiero reconoce y acepta que el Colegio está expresamente facultado para:')),0);
	$pdf->Row(array(utf8_decode('1)  Terminar el presente contrato, en caso que situaciones disciplinarias graves o reiteradas impidan la mantención del alumno en el Colegio, todo ello previo proceso con resolución fundada y comunicada por escrito conforme a la normativa interna del Colegio.')),0);
	$pdf->Row(array(utf8_decode('2)  Suspender al alumno por actos de indisciplina o mala conducta por un plazo que determinará la Dirección, de conformidad a la normativa interna, debiendo reintegrarse el alumno a clases en la fecha que corresponda.')),0);
	$pdf->Row(array(utf8_decode('3)  Que la matrícula del alumno puede estar sujeta a pre-condicionalidad, condicionalidad o cancelación por transgresiones a la normativa interna del Colegio, todo ello de acuerdo a normativa interna de disciplina.')),0);
	$pdf->Row(array(utf8_decode('4)  Que para el evento que quien incurra en una falta al Reglamento Interno del Colegio sea el apoderado académico o financiero del alumno, el Colegio está facultado para aplicar las sanciones establecidas en el reglamento obligándose el apoderado acatarlas.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('SEXTO:  La suscripción del presente contrato, por parte del Apoderado Financiero, concede al alumno(a) los siguientes derechos y obligaciones: ')),0);
	$pdf->Row(array(utf8_decode('DERECHOS')),0);
	$pdf->Row(array(utf8_decode('1)   Recibir una educación que le ofrezca oportunidades para su formación y desarrollo integral. ')),0);
	$pdf->Row(array(utf8_decode('2)   Estudiar en un ambiente tolerante y de respeto mutuo, a expresar su opinión y a que se respete su integridad física y moral, no pudiendo ser objeto de tratos vejatorios o degradantes y de maltratos psicológicos.')),0);
	$pdf->Row(array(utf8_decode('3)   Que se respete su libertad personal y de conciencia, sus convicciones religiosas, ideológicas y culturales, conforme al Reglamento Interno del Establecimiento.')),0);
	$pdf->Row(array(utf8_decode('4)   Ser informados de los procedimientos evaluativos establecidos en el Reglamento de Evaluación y cumplimiento de éste.')),0);
	$pdf->Row(array(utf8_decode('5)   Ser evaluados y promovidos de acuerdo a un sistema objetivo y transparente, de acuerdo al Reglamento del Establecimiento. ')),0);
	$pdf->Row(array(utf8_decode('6)   Participar en la vida cultural, deportiva y recreativa del Establecimiento. ')),0);
	$pdf->Row(array(utf8_decode('7)   Recibir, a iniciativa y petición del Colegio, asistencia impartida por el psicólogo, psicopedagogo y/o orientador con los que contare el establecimiento educacional.')),0);
	$pdf->Row(array(utf8_decode('OBLIGACIONES')),0);
	$pdf->Row(array(utf8_decode('1)   Brindar un trato digno, respetuoso y no discriminatorio a todos los integrantes de la Comunidad Educativa.')),0);
	$pdf->Row(array(utf8_decode('2)   Ser el principal impulsor de su propio desarrollo, crecimiento y formación, tanto en el ámbito académico, deportivo, social, afectivo, cultural, y artístico.')),0);
	$pdf->Row(array(utf8_decode('3)   Colaborar y cooperar en mejorar la convivencia escolar, cuidar la infraestructura educacional y respetar el Proyecto Educativo y el Reglamento Interno del Colegio.')),0);
	$pdf->Row(array(utf8_decode('4)   Mantener un comportamiento de acuerdo a las exigencias del Colegio, que se encuentran establecidas en el Reglamento Interno de Convivencia Escolar.  En estas se incluyen, entre otras, horarios de entrada y salida de clases, relaciones interpersonales, disciplina, presentación personal y otras relacionadas con los principios y postulados que persigue el Colegio.')),0);
	$pdf->Row(array(utf8_decode('5)   Utilizar la infraestructura del Colegio según las normas internas del establecimiento y de acuerdo a las instrucciones que se  impartan para el normal desarrollo de su formación personal y escolar.')),0);
	$pdf->Row(array(utf8_decode('6)   Asistir todos los días a las clases y a actividades planificadas vistiendo el uniforme oficial del establecimiento.')),0);
	$pdf->Row(array(utf8_decode('7)   Mantener una presentación personal de acuerdo a las exigencias del Colegio, incluyendo vestuario escolar, corte de pelo, afeitado, sin maquillaje y adornos.')),0);
	
	$sql_ve = "select  
				`NumeroRutAlumno`, `CodigoItem`, `NumeroCuota`, date_format(FechaVencimiento,'%d/%m/%Y') as FechaVencimiento, 
				`ValorPactado`, `ValorPagado`, `EstadoCuentaCorriente`, `NumeroCompromiso`, `ValorCompromisoCC`, ctacte_ncorr
				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio_vigente."
				where
				NumeroRutAlumno = '".$alumno."'  
				order by CodigoItem asc, ctacte_ncorr asc
					";
	$res_ve = mysql_query($sql_ve,$conexion) or die(mysql_error());
	$total_col = 0;
	$total_colegiatura =0;
	while($line_ve = mysql_fetch_array($res_ve)){
			if ($line_ve[1]==1){
				$incorporacion = $line_ve[4];

				}
			else{
				$colegiatura = $line_ve[4];
				$total_colegiatura += $line_ve[4];
			}
		}
	$sql_ve = "select  
				min(FechaVencimiento) as FechaVencimientoMin, max(FechaVencimiento) as FechaVencimientoMax
				from gescolcl_arcoiris_administracion.CuentaCorriente".$anio_vigente."
				where
					NumeroRutAlumno = '".$alumno."'  
					and CodigoItem = 2
				order by CodigoItem asc, ctacte_ncorr asc
					";
	$res_ve = mysql_query($sql_ve,$conexion);
	$row_ve = mysql_fetch_array($res_ve);

	list($a1,$m1,$d1) = explode('-',$row_ve['FechaVencimientoMin']);
	list($a2,$m2,$d2) = explode('-',$row_ve['FechaVencimientoMax']);

	$mes_inicio = $d1.' de '. mes_letras($m1).' de '.$a1;
	$mes_fin = $d2.' de '. mes_letras($m2).' de '.$a2;
	
	$suma_incorporacion_colegiatura = $incorporacion + $total_colegiatura;
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('SÉPTIMO:   El Apoderado Financiero se obliga a pagar un arancel anual de $ '.number_format($suma_incorporacion_colegiatura,0,',','.').' por los servicios educacionales bajo las siguientes condiciones:  En este acto paga voluntariamente la suma de $ '.number_format($incorporacion,0,',','.').', por concepto de primera cuota del arancel educacional; las restantes cuotas de $ '.number_format($colegiatura,0,',','.').' cada una se pagaran  en la Secretaria  de Finanzas del Colegio, a más tardar el día '.$d1.' de cada mes, comenzando a pagar el '.$mes_inicio.' y terminando el '.$mes_fin.'. La mora o simple retardo en el pago de una o más cuotas del arancel devengará el interés máximo convencional para operaciones no reajustables que la ley permita estipular, calculado sobre la o las cuotas impagas hasta la fecha de su pago efectivo.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('J'));
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->Row(array(utf8_decode('OCTAVO: Si eventualmente el apoderado paga alguna cuota del arancel educacional mediante cheque y este no sale pagado sea por causal de protesto o por cualquier otro motivo el Apoderado Financiero se obliga a pagar dicha (s) cantidad(s) dentro del quinto día desde que se produjo el no pago, y a contar de esta fecha la obligación devengará el interés máximo convencional que la Ley permita estipular para operaciones de crédito en moneda nacional no reajustable.  Todo gasto que implique el cobro de los cheques por cobranza extrajudicial o judicial del mismo, será de cargo del Apoderado Financiero, debiendo reembolsar dichos gastos al momento de pagar su deuda. El cheque, será devuelto al Apoderado Financiero por la Secretaria de Finanzas, cuando cumpla íntegramente el pago del documento (s). ')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('NOVENO: El Apoderado Financiero se obliga a responder y pagar los montos de reparación o reposición ocasionados por la pérdida y/o deterioro de libros, instrumental deportivo, mobiliario, computadores, equipos, implementos o bienes de cualquier naturaleza que sea de propiedad del Colegio o de otro alumno en los que tenga responsabilidad el alumno (a) individual o colectivamente.   Así mismo, por todo daño material que sufran las instalaciones, como cualquier otro menoscabo patrimonial que sufra dicha institución, por actos, conductas u omisiones del alumno, ya sea en situaciones de entera normalidad escolar o con motivo de alguna ocupación estudiantil.  Ante el evento de una ocupación estudiantil del establecimiento, el Colegio se reserva el derecho de realizar el desalojo del alumnado o de terceras personas que se encuentren en su interior con auxilio de la fuerza pública.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO: Las partes acuerdan que el Colegio  no será responsable por los perjuicios derivados de la pérdida o sustracción de efectos personales  o especies al interior del establecimiento, como aparatos eléctricos o electrónicos, de telefonía celular, joyas, o cualquier otro bien que esté prohibido traer al Colegio;  ni de los daños o perjuicios que se causen en razón de servicios contratados por el Apoderado académico o Apoderado Financiero con terceros, tales como transporte escolar, almuerzos, colaciones o semejantes.  Asimismo, las partes dejan constancia de que el Colegio no será responsable por los daños o perjuicios que se causen por actos, obras, hechos u omisiones de terceros y en el evento de caso fortuito o de fuerza mayor.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO PRIMERO: En el caso de que el alumno (a) sea retirado(a) del Establecimiento Educacional, se observarán las siguientes condiciones: ')),0);
	$pdf->Row(array(utf8_decode('1)  Si el alumno(a) matriculado académicamente es retirado antes del inicio de las clases, se devolverá todos los montos pagados al momento del retiro, y/o se devolverá los restantes documentos que se hubieren aceptado (cheques).')),0);
	$pdf->Row(array(utf8_decode('2)  Si el alumno es retirado una vez iniciado el año escolar, el Apoderado Financiero debe dar aviso por escrito al Director y, sólo a contar del mes siguiente a esta comunicación, el Apoderado Financiero no está obligado a pagar las restantes cuotas pactadas del arancel educacional.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO SEGUNDO: El Apoderado Financiero declara y acepta expresamente que el pago de las sumas señaladas en este contrato en tiempo oportuno, constituye una obligación de la esencia del presente contrato, obligación que recaerá en el Apoderado Financiero durante el periodo completo del año escolar, por lo que si se atrasa más de 3 veces en pagar cualquier cuota del arancel educacional o a la fecha de proceder a la matrícula académica adeuda más de 2 cuotas, esto se considerará mal comportamiento de pago y habilitará al Colegio a no aceptar su solicitud de ser Apoderado Financiero para renovar matrícula para el año siguiente, si así lo decide el Consejo de Finanzas del Colegio. Asimismo, no podrá optar a ser Apoderado Financiero si hay una evidente mala intención o mal uso de los cheques dados a el Colegio, como: orden de no pago, firma disconforme, incumplimiento comercial, cuenta cerrada, falta de fondos y cualquier otro motivo imputable al Apoderado Financiero y que impliquen que los cheques no puedan ser cobrados.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO TERCERO: Si para el evento que el Apoderado Financiero no cumpla en forma total o parcial la deuda que por el presente instrumento documenta con cheques o pacta en cuotas, las partes acuerdan que si el Colegio deriva la deuda a Cobranza extrajudicial con las formalidades legales correspondientes,   se regirán por lo dispuesto en el inciso segundo del artículo 37  de la Ley Nº 19.496 en cuanto a los topes máximos por gastos de cobranza extrajudicial y según el tramo que corresponda (en obligaciones de hasta 10 unidades de fomento, 9%; por la parte que exceda de 10 y hasta 50 unidades de fomento, 6%, y por la parte que exceda de 50 unidades de fomento, 3%. La cobranza será realizada por el departamento de finanzas del Colegio y/o Abogado del Colegio, sin perjuicio de esto, el Apoderado Financiero autoriza al Colegio para que encomiende la recaudación de estas obligaciones a un servicio externo cuando lo estime conveniente, inclusive la cobranza prejudicial y judicial, obligándose el Colegio a informar mediante carta circular cuando la cobranza sea derivada a un servicio externo. ')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO CUARTO: El Apoderado Financiero declara expresamente que la deuda generada por el presente contrato de prestación de servicios educacionales, dice relación con el alumno individualizado en la cláusula primera, y por tanto, un futuro cambio de Apoderado Financiero no implica que el alumno quede sin deuda.   Así mismo, los comparecientes acuerdan que, si el Apoderado Financiero tiene dos o más alumnos matriculados en el Colegio, para proceder a renovar matricula académica por cualquiera de ellos, debe estar al día en el arancel educacional de todos sus pupilos. ')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO SEXTO: El Apoderado Financiero no tendrá derecho a solicitar renovación de la matrícula por un nuevo período académico, debido a las siguientes causales:')),0);
	$pdf->Row(array(utf8_decode('1)  Si el alumno que está condicional no cumple con los requisitos estipulados en la carta de condicionalidad.')),0);
	$pdf->Row(array(utf8_decode('2)  Si conforme al procedimiento contemplado en el Manual de Convivencia escolar, se ha determinado que el alumno(a) ha incurrido en incumplimiento disciplinario grave en su vida escolar en el establecimiento.')),0);
	$pdf->Row(array(utf8_decode('3)  Si el alumno no es promovido por segunda vez de curso de acuerdo a reglamento de evaluación y de acuerdo al nivel.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO SÉPTIMO: Si el COLEGIO para la realización de campañas de promoción, captación de nuevos alumnos, o destacar actividades escolares, imprime material promocional, produce videos, u otro medio de publicidad en los cuales, se destaquen imágenes o la participación de alumnos de manera colectiva en que pueda salir o se distinga el rostro del  alumno matriculado por este contrato en alguna de las dependencias del colegio u otras a fin,  el apoderado da su autorización en forma expresa, por tiempo indefinido y a título gratuito desde ya, para que las imágenes de su pupilo puedan ser exhibidas o impresas en los medios de publicidad o de comunicación  que se editen al efecto y ser entregados directamente a los interesados en recintos públicos, privados o publicados en medios de comunicación.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO OCTAVO:  Si un alumno sufre un accidente en las dependencias del Colegio que requiera atención médica de urgencia y el Apoderado no es ubicado oportunamente, el Colegio derivará o trasladará al establecimiento asistencial más cercano de la red de salud estatal.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DÉCIMO NOVENO:  Si el alumno ingresa al Colegio con lesiones evidentes (moretones, quemaduras, fracturas, u otras) será trasladado inmediatamente a un Centro Asistencial y se avisará telefónicamente al apoderado para que se presente al centro asistencial.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('VIGÉSIMO:  Los alumnos están protegidos por el seguro de accidente escolar, (D.S. 313 Mayo/1973. Ley 16.744 de Accidentes del Trabajo), por lo que, si sufre una lesión a causa o con ocasión de sus estudios, la práctica o el trayecto que le produzca incapacidad estará cubierto por este seguro, el que le da derecho a ser llevado a un centro asistencial de la red pública. Si el apoderado tiene contratado un seguro particular o decide llevar a un centro de salud privado, esto no es cubierto por el seguro escolar o el Colegio.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('VIGÉSIMO PRIMERO: El presente Contrato comenzará a regir desde la fecha de su suscripción y durará hasta el término del año Escolar '.$anio_vigente.'.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('VIGÉSIMO SEGUNDO:  Para todos los efectos legales derivados de este instrumento, el Apoderado Financiero fija su domicilio en la Ciudad y Comuna de Villa Alemana y se somete a la competencia de sus Tribunales Ordinarios de Justicia, sin perjuicio del que corresponda al lugar de domicilio o residencia del Apoderado Financiero, a elección del Colegio, quien podrá ejercer sus acciones ante los tribunales competentes según las reglas de procedimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('VIGÉSIMO TERCERO: El presente instrumento se extiende en dos ejemplares, quedando uno en poder de cada parte, dejando expresa constancia que la copia que por este acto se entrega al Apoderado Financiero es copia fiel de su original que queda en poder del Colegio.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	
	

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
	
/*	
*/	
$pdf->Output();
?>
