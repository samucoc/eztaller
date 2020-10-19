<?php
ob_start();
session_start();

require('../includes/php/fpdf/fpdf.php');
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

mysql_query("SET NAMES 'utf8'");	

function calcular_edad($fecha){
	$fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
	$fecha_hoy =  new DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
	$edad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
	return $edad;
}

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
		global $Logo;
		//Put the watermark
		$this->SetY(15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		//$this->Cell(0,5,'COLEGIO CATOLICO GALILEO GALILEI',0,1,'L');
		//$this->Cell(0,5,'Villa Alemana',0,1,'L');
		$this->Image($Logo,10,10,25);
		$this->Ln(10);
		}

		
	//Pie de página
	function Footer() {
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,5,'www.elarcoiris.cl -  secrectaria@elarcoiris.cl',0,1,'C');
		$this->Cell(0,5,'Sargento Candelaria 290, Villa Yungay - Villa Alemana',0,1,'C');
	}
}

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
	$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error($conexion));
	$row_apoderado = mysql_fetch_array($res_apoderado);
	
	$rut_apoderado = $row_apoderado['NumeroRutApoderado'].'-'.dv($row_apoderado['NumeroRutApoderado']);
	$nombre_apoderado = $row_apoderado['nombre'];
	$direccion_apoderado = $row_apoderado['DireccionParticularApoderado'];
	$ciudad_apoderado = $row_apoderado['Ciudad'];

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
	$res_pd = mysql_query($sql_pd,$conexion) or die(mysql_error($conexion));
	$row_pd = mysql_fetch_array($res_pd);
	$nombre_alumno = $row_pd['nombre_alumno'];
	$nombre_curso = $row_pd['NombreCurso'];
	$FechaNacimiento = $row_pd['FechaNacimiento'];

	$ma='';

			 
	$sql_esta = "SELECT `NumeroRutEstablecimiento`, `DigitoRutEstablecimiento`, `NombreEstablecimiento`, 
						`DireccionEstablecimiento`, `CiudadEstablecimiento`, `TelefonoEstablecimiento`, 
						`FaxEstablecimiento`, `EMailEstablecimiento`, `NumeroRutRepresentante`,
						`DigitoRutRepresentante`, `PaternoRepresentante`, `MaternoRepresentante`, 
						`NombresRepresentante`, `PeriodoEstablecimiento`, `RegionEstablecimiento`, 
						`ProvinciaEstablecimiento`, `SemestreEstablecimiento`, `UnidadPenDrive`, `RBD`, 
						`NumeroDecreto`, `FechaDecreto`, `PeriodoPostulacion`, `PorcentajeSintesis`, 
						`CorrelativoCertificado`, `CelularEstablecimiento` , `Resolucion` , 
						`AnioResolucion` , `Foto`  , `Logo` , `sostenedor` FROM gescolcl_arcoiris_administracion.Establecimiento limit 0,1";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error($conexion));
	$row_esta = mysql_fetch_array($res_esta);
	
	$nombre_establecimiento = $row_esta['NombreEstablecimiento'];
	$rut_estable 			= $row_esta['NumeroRutEstablecimiento'].'-'.dv($row_esta['NumeroRutEstablecimiento']);
	$nombre_repre			= $row_esta['NombresRepresentante'].' '.$row_esta['PaternoRepresentante'].' '.$row_esta['MaternoRepresentante'];
	$rut_repre				= $row_esta['NumeroRutRepresentante'].'-'.dv($row_esta['NumeroRutRepresentante']);
	$direccion_repre				= $row_esta['DireccionEstablecimiento'];
	$RBD				= $row_esta['RBD'];
	$NumeroDecreto				= $row_esta['NumeroDecreto'];
	$FechaDecreto				= $row_esta['FechaDecreto'];
	$CiudadEstablecimiento				= $row_esta['CiudadEstablecimiento'];
	$resolucion_estable = $row_esta['Resolucion'];
	$anio_resolu		= $row_esta['AnioResolucion'];
	$Foto		= $row_esta['Foto'];
	$Logo		= $row_esta['Logo'];
	$sostenedor		= $row_esta['sostenedor'];


	$pdf=new PDF('P','mm','legal'); //pagina carta horizontal
	$pdf->AliasNbPages();
	$pdf->AddPage();
	#Establecemos los márgenes izquierda, arriba y derecha: 
	$pdf->SetMargins(30, 25 , 30); 

	#Establecemos el margen inferior: 
	$pdf->SetAutoPageBreak(true,25);  

	mysql_query("SET NAMES utf8");

	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(160,10,'CONTRATO DE PRESTACION DE SERVICIOS EDUCACIONALES '.$anio_vigente,0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(160));
	$pdf->SetAligns(array('J'));
	
	list($anio,$mes,$dia) = explode('-',date("Y-m-d"));
	list($a2,$m2,$d2) = explode('-',$FechaDecreto);
	
	$fecha_letras = $dia.' de '.mes_letras($mes).' de '.$anio;
	$fecha_letras_d = $d2.' de '.mes_letras($m2).' de '.$a2;
	$fecha_letras_m = mes_letras($mes).' de '.$anio;
	
	// $rut_apoderado 			= $_POST['rut_apoderado'];
	// $nombre_apoderado 		= $_POST['nombre_apo'];
	// $direccion_apoderado 	= $_POST['direccion_apo'];
	// $ciudad_apoderado 		= $_POST['ciudad_apo'];
	
	/*
	En la ciudad de Villa Alemana, a 16 de Septiembre de 2020, entre  la  Fundación  Educacional  José y Josefina Oneto, representada legalmente por doña ANGELA SALANOVA ALTET  cédula de identidad N° 99.999.999-9, domiciliada en Maturana 1010, Villa Alemana, Región de Valparaíso, y que en delante se denominará 'el Colegio', e indistintamente 'el prestador', y Don(ña) ELIZABETH YESENIA CAÑAS HUAIQUIN, cédula de identidad N° 14.905.427-8, domiciliado (a) en CALLE ESMERALDA N° 160 PARADERO 8,VILLA ALEMANA en adelante e indistintamente denominado 'el apoderado (a)'  o  'sostenedor económico', se ha convenido en el siguiente Contrato de Prestación de Servicios  Educacionales,  conforme  a las siguientes cláusulas.
	*/


	$pdf->Row(array(utf8_decode("En Villa Alemana, a ".$fecha_letras.", comparecen: la FUNDACIÓN EDUCACIONAL ARCOIRIS, sociedad del giro de su denominación, RUT N° ".$rut_estable.", sostenedora del ".$nombre_establecimiento.", R.B.D. ".$RBD.", Resolución Exenta Nº ".$NumeroDecreto." del Ministerio de Educación de fecha ".$fecha_letras_d.", representada legalmente por don ".$nombre_repre.", chileno, cédula nacional de identidad Nº ".$rut_repre.", domiciliados en ".$direccion_repre.", Villa Alemana, y don(a) ".$nombre_apoderado.", chileno(a), cédula nacional de identidad Nº ".$rut_apoderado.", con dirección ".$direccion_apoderado." , ciudad de ".$ciudad_apoderado."; en adelante el 'APODERADO'; ambos comparecientes mayores de edad, exponen que vienen en celebrar el presente contrato de prestación de servicios educacionales, bajo las cláusulas que a continuación se expresan:")),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('PRIMERO: Por el presente instrumento, el Apoderado encomienda a la escuela, la labor de impartir enseñanza escolar para el año escolar 2021 al alumno(a):')),0);	
	$pdf->Row(array(utf8_decode('')),0);

	
	$pdf->Cell(80,5,utf8_decode("Nombre - Cédula de identidad Nro"),1,0,'C');	
	$pdf->Cell(80,5,utf8_decode("Nivel ".$anio_vigente),1,1,'C');	
	$pdf->Cell(80,5,utf8_decode($nombre_alumno),1,0,'C');	
	$pdf->Cell(80,5,utf8_decode($nombre_curso),1,1,'C');	
	$pdf->Row(array(utf8_decode('')),0);
	

	//$edad = calcular_edad($FechaNacimiento);
	$pdf->Row(array(utf8_decode('SEGUNDO: En virtud del presente contrato, la escuela, se obliga a prestar los servicios educacionales al alumno(a) antes individualizado, de acuerdo a los Planes y Programas de Estudios aprobados por el Ministerio de Educación.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->Row(array(utf8_decode('Así mismo, la escuela como entidad formativa tiene derecho y se obliga a:')),0);
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->Row(array(utf8_decode('1) Establecer y ejercer su proyecto educativo, de acuerdo a la autonomía que le garantiza el ordenamiento jurídico, difundir su contenido a los integrantes de la comunidad educativa del establecimiento, a dictar y establecer los Reglamentos Internos del Colegio y velar por el cumplimiento de sus disposiciones.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('2) Proporcionar a los estudiantes, de acuerdo con las normas internas, el uso de la infraestructura de la escuela, que se requiere para el desarrollo del programa curricular, ya sea en el aula, y otros espacios destinados al desarrollo educacional e integral del alumno(a).')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('3) Evaluar a los alumnos, conforme a las disposiciones legales y a las propias de la escuela.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('4) Brindar a los apoderados la información de avances pedagógicos, fonoaudiológicos y del proceso educativo del alumno(a), del funcionamiento del establecimiento educacional, oírlos y recibir sus sugerencias para el desarrollo del proceso educativo en los ámbitos que les competa y facilitar su participación en el Centro de Padres y Apoderados de la escuela. La información que se entregue a los apoderados y la atención personal de los mismos, se efectuará conforme al procedimiento de información y de entrevistas personales que determine la escuela.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('5) Disponer del personal docente, asistentes de la educación, equipo técnico, servicios de orientación y mantener en condiciones adecuadas las dependencias en que se entrega el servicio educacional.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('6) La escuela se obliga a entregar copia digital (Página Web, Correo Electrónico, otros) del Proyecto Educativo Institucional, el Reglamento Interno, y Manual de Convivencia Escolar, cuando el alumno se matricula por primera vez en la Escuela o cuando estos reglamentos se modifican para el desarrollo de actividades de extensión y de orientación vocacional.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('TERCERO:	El Apoderado, declara expresamente lo siguiente:')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('1) Que es el padre, madre, tercero autorizado, tutor o curador del alumno (a) individualizado (a) en la cláusula primero, y que se obliga personalmente a cumplir y a hacer cumplir las obligaciones que impone el presente contrato.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('2) Que se ha informado debidamente respecto de las características de la escuela y de la infraestructura con que cuenta el establecimiento educacional para realizar el quehacer de la enseñanza.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('3) Que al firmar este Contrato, se obliga a tomar conocimiento, leer y estudiar el Proyecto Educativo, Reglamento interno y Manual de Convivencia escolar.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('4) Que el alumno (a) se encuentra en buenas condiciones físicas, psíquicas y psicológicas, sin presentar: déficit sensorial, motor o intelectual, ni a factores ambientales, problemas de enseñanza o de estimulación, como tampoco a condiciones de vulnerabilidad social o trastorno afectivo, que afecten al desarrollo del lenguaje de los y las estudiantes de un curso. Esto según lo exigido por el DECRETO N°170 emitido por el Ministerio de Educación, lo cual se acreditará mediante el certificado de salud completado por el profesional correspondiente. ')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('5) El Apoderado declara conocer la obligación legal de la Dirección la escuela al denunciar ante el Ministerio Público, Policía de Investigaciones y/o Carabineros de Chile, Tribunales de Familia, según corresponda, los hechos que pudieren revestir características de delito que se hayan cometido al interior del establecimiento y que tenga participación el alumno (a) y/o apoderado o tercero y que hayan afectado a éste (a), como informar cualquier vulneración de derechos que es objeto el alumno; así mismo, de aquellos delitos o situaciones de violencia intrafamiliar que la escuela tome conocimiento y que digan relación con el alumno(a).')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('6) El Apoderado declara conocer y aceptar expresamente, en todas y cada una de sus partes, el Proyecto Educativo Institucional (PEI) del Colegio, así como todos los documentos y normas internas que explicitan, desarrollan y concretan el PEI esto es, Manual de Convivencia Escolar, Reglamento General del Centro de Padres y Apoderados y demás, generados por el Equipo Docente Directivo del Establecimiento en dicho carácter.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('7) El Apoderado declara que ha optado por la escuela por cuanto el tipo de educación y formación que entrega es la que quiere para la formación de su hijo o pupilo, por tanto, adhiere a su Proyecto Educativo y a su reglamentación interna.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('8) El Apoderado declara que se compromete a velar por el adecuado reforzamiento educativo del alumno(a), y que cumpla los deberes que la escuela le impone, participando activamente en la educación de el (la) estudiante. En consecuencia, el Apoderado se obliga a guiar al alumno(a) en el ejercicio de los derechos y en el cumplimiento de sus deberes, consagrados en el presente contrato y en la normativa interna del Colegio.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('9) Para la realización del proceso de educación y enseñanza,  se deben asumir, respetar y cumplir diversas obligaciones, entre las cuales se estipulan las que siguen a continuación:')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('a) Controlar y supervisar la educación del alumno(a), revisando, contestando y firmando las comunicaciones emanadas de la Dirección, UTP, profesores y, en general de la escuela; preocuparse del cumplimiento de los deberes del alumno, presentación, aseo personal, conducta, asistencia a clases y demás actividades, culturales, académicas y deportivas que la escuela dictamine; además de promover el estudio, la realización de tareas, guías, preparación de trabajos y toda actividad destinada al logro del aprendizaje.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('b) Se obliga a respetar el conducto regular para informar sus inquietudes o problemas.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('c) Se obliga a que cualquier requerimiento, solicitud, reclamo o denuncia lo realizará en forma personal, ya que el correo electrónico o llamadas telefónicas no son los conductos regulares o adecuados.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('d) Designar un representante con plenas facultades para que lo reemplace frente a la escuela en caso de ausencia por largo tiempo (comunicado y aceptado por la escuela); quien se entenderá facultado para ser válidamente notificado de toda comunicación emanada.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('e) Contribuir a crear un ambiente positivo en la escuela y evitar conductas que promuevan la intolerancia y falta de armonía entre los miembros de la comunidad escolar; y a evitar comentarios infundados que puedan dañar la imagen de la escuela o de su personal.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('f) Participar en las tareas educativas, formativas y deportivas que, en beneficio del alumno(a) y/o de la familia conciba y desarrolle en la escuela, observando las instrucciones que con este objetivo emita el establecimiento, asistiendo a las reuniones de curso, citaciones y/o entrevistas, y haciéndose responsable de todas las acciones de refuerzo, tratamiento y/o atención especial que solicite para el beneficio de su pupilo.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('g) Hacer cumplir al alumno (a) las Normas de Convivencia Escolar que promueva el Colegio establecidas en el Reglamento Interno.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('h) Acatar las indicaciones técnico-pedagógicas y disciplinarias que emanen del Consejo de Profesores, Comité de Convivencia Escolar, refrendadas por el Director del Colegio, que apuntan a velar por el bienestar académico y psicológico del alumno(a) y resguardar los derechos de los demás integrantes del grupo curso, que puedan estar siendo afectados por el actuar negativo del alumno(a).')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('i) Cumplir con los compromisos asumidos con el Establecimiento Educacional.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('j) Brindar un trato respetuoso a todos los integrantes de la Comunidad Educativa.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('k) El apoderado deberá participar y cooperar en las actividades que el centro general de padres programe.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('CUARTO: El Apoderado tiene derecho a:')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('1) Ser informado respecto del rendimiento académico y del proceso educativo del alumno;')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('2) Ser informado del funcionamiento del establecimiento')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('3) Ser escuchado y recibido por la Dirección (previa cita)')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('4) Participar del proceso educativo en los ámbitos que les corresponda, aportando al desarrollo del Proyecto Educativo en conformidad a la normativa interna del Establecimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('QUINTO:	El Apoderado reconoce y acepta que la Escuela está expresamente facultada para:')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('Que para el evento que quien incurra en una falta al Reglamento Interno del Colegio sea el apoderado, la escuela está facultada para aplicar las sanciones establecidas en el reglamento obligándose el apoderado acatarlas.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('SEXTO: La suscripción del presente contrato, por parte del Apoderado, concede al alumno(a) los siguientes derechos y deberes:')),0);
	$pdf->Row(array(utf8_decode('')),0);
	
	$pdf->Row(array(utf8_decode('DERECHOS')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('1) Recibir una educación que le ofrezca oportunidades para su formación y desarrollo integral, que será entregada de una manera segura resguardado siempre la vida y salud del Alumno.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('2) Estudiar en un ambiente tolerante y de respeto mutuo, a expresar su opinión y a que se respete su integridad física y moral, no pudiendo ser objeto de tratos vejatorios o degradantes y de maltratos psicológicos.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('3) Que se respete su libertad personal y de conciencia, sus convicciones religiosas, ideológicas y culturales, conforme al Reglamento Interno del Establecimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('4) Ser informados de los procedimientos evaluativos establecidos en el Reglamento de Evaluación y cumplimiento de éste.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('5) Ser evaluados de acuerdo a un sistema objetivo y transparente, de acuerdo al Reglamento del Establecimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('6) Participar en la vida cultural, deportiva y recreativa del Establecimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('DEBERES')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('1) Brindar un trato digno, respetuoso y no discriminatorio a todos los integrantes de la Comunidad Educativa.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('2) Ser el principal impulsor de su propio desarrollo, crecimiento y formación, tanto en el ámbito académico, deportivo, social, afectivo, cultural, y artístico.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('3) Colaborar y cooperar en mejorar la convivencia escolar, cuidar la infraestructura educacional y respetar el Proyecto Educativo y el Reglamento Interno de la escuela.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('4) Mantener un comportamiento de acuerdo a las exigencias de la Escuela, que se encuentran establecidas en el Reglamento Interno de Convivencia Escolar. En estas se incluyen, entre otras, horarios de entrada y salida de clases, relaciones interpersonales, disciplina, presentación personal y otras relacionadas con los principios y postulados que persigue a la escuela, que serán brindadas por el apoderado del alumno(a).')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('5) Utilizar la infraestructura de la Escuela según las normas internas del establecimiento y de acuerdo a las instrucciones que se impartan para el normal desarrollo de su formación personal y escolar.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('6) Asistir todos los días a las clases y a actividades planificadas vistiendo el uniforme oficial del establecimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);
	$pdf->Row(array(utf8_decode('7) Mantener una presentación personal de acuerdo a las exigencias de la escuela, incluyendo vestuario escolar.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('SÉPTIMO: El Apoderado se obliga a responder y pagar los montos de reparación o reposición ocasionados por la pérdida y/o deterioro de libros, instrumental deportivo, mobiliario, computadores, equipos, implementos o bienes de cualquier naturaleza que sea de propiedad de la escuela o de otro alumno en los que tenga responsabilidad el alumno (a) individual o colectivamente. Así mismo, por todo daño material que sufran las instalaciones, como cualquier otro menoscabo patrimonial que sufra dicha institución, por actos, conductas u omisiones del alumno, ya sea en cualquier situación escolar.  ')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('OCTAVO: Las partes acuerdan que la escuela no será responsable por los perjuicios derivados de la pérdida o sustracción de efectos personales o especies al interior del establecimiento, como aparatos eléctricos o electrónicos, de telefonía celular, o cualquier otro bien que esté prohibido traer al establecimiento; ni de los daños o perjuicios que se causen en razón de servicios contratados por el Apoderado académico con terceros, tales como transporte escolar, almuerzos, colaciones o semejantes. Asimismo, las partes dejan constancia de que la escuela no será responsable por los daños o perjuicios que se causen por actos, obras, hechos u omisiones de terceros y en el evento de caso fortuito o de fuerza mayor.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('NOVENO: En el caso de que el alumno (a) sea retirado(a) del Establecimiento Educacional, se observarán las siguientes condiciones:')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('1) Si el alumno(a) matriculado académicamente es retirado antes del inicio de las clases, se devolverá la totalidad de los materiales entregados al momento del retiro.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO: Si la Escuela para la realización de campañas de promoción, captación de nuevos alumnos, o destacar actividades escolares, imprime material promocional, produce videos, fotos u otro medio de publicidad en los cuales, se destaquen imágenes o la participación de alumnos de manera colectiva en que pueda salir o se distinga el rostro del alumno matriculado por este contrato en alguna de las dependencias del colegio u otras a fin, el apoderado da su autorización en forma expresa, por tiempo indefinido y a título gratuito desde ya, para que las imágenes de su pupilo puedan ser exhibidas o impresas en los medios de publicidad o de comunicación que se editen al efecto y ser entregados directamente a los interesados en recintos públicos, privados o publicados en medios de comunicación.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO PRIMERO: Si un alumno sufre un accidente en las dependencias de la escuela que requiera atención médica de urgencia y el Apoderado no es ubicado oportunamente, la escuela derivará o trasladará al establecimiento asistencial más cercano de la red de salud estatal.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO SEGUNDO: Si el alumno ingresa a la escuela con lesiones evidentes (moretones, quemaduras, fracturas, u otras) será trasladado inmediatamente a un Centro Asistencial y se avisará telefónicamente al apoderado para que se presente al centro asistencial.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO TERCERO: Los alumnos están protegidos por el seguro de accidente escolar, (D.S. 313 Mayo/1973. Ley 16.744 de Accidentes del Trabajo), por lo que, si sufre una lesión a causa o con ocasión de sus estudios, la práctica o el trayecto que le produzca incapacidad estará cubierto por este seguro, el que le da derecho a ser llevado a un centro asistencial de la red pública. Si el apoderado tiene contratado un seguro particular o decide llevarlo a un centro de salud privado, esto no es cubierto por el seguro escolar o la escuela.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO CUARTO: El presente Contrato comenzará a regir desde la fecha de su suscripción y durará hasta el término del año Escolar '.$anio_vigente.'.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO QUINTO:  Para todos los efectos legales derivados de este instrumento, el Apoderado fija su domicilio en la Ciudad y Comuna de Villa Alemana y se somete a la competencia de sus Tribunales Ordinarios de Justicia, sin perjuicio del que corresponda al lugar de domicilio o residencia del Apoderado, a elección de la escuela, quien podrá ejercer sus acciones ante los tribunales competentes según las reglas de procedimiento.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	$pdf->Row(array(utf8_decode('DÉCIMO SEXTO: El presente instrumento se extiende en dos ejemplares, quedando uno en poder de cada parte, dejando expresa constancia que la copia que por este acto se entrega al Apoderado  es copia fiel de su original que queda en poder del Colegio.')),0);
	$pdf->Row(array(utf8_decode('')),0);

	

	$pdf->Ln();
	$pdf->Ln();
	$pdf->Image($sostenedor,127,285,50);
	$pdf->Cell(80,5,"Apoderado",0,0,'C');	
	$pdf->Cell(80,5,"Representante Legal del Colegio",0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(80,5,utf8_decode($nombre_apoderado),0,0,'C');	
	$pdf->Cell(80,5,utf8_decode($nombre_repre),0,0,'C');	
	$pdf->Ln();
	$pdf->Cell(80,5,$rut_apoderado,0,0,'C');	
	$pdf->Cell(80,5,$rut_repre,0,0,'C');	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(160,10,utf8_decode('En la Región de Valparaíso, ciudad de Villa Alemana,'.$fecha_letras_m),0,0,'R');	
	
$pdf->Output();
?>
