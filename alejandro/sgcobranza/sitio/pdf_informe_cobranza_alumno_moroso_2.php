<?php

ob_start();

session_start();



include "../includes/php/conf_bd.php"; 

include "../includes/php/validaciones.php"; 

include "../includes/php/fpdf/fpdf.php"; 









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

#Establecemos los márgenes izquierda, arriba y derecha: 



#Establecemos el margen inferior: 

$pdf->SetAutoPageBreak(true,25);  



	$pdf->SetFont('Arial','B',8);





	mysql_query("SET NAMES utf8");



	$anio 			= $_SESSION["sige_anio_escolar_vigente"];

	

	$ncorr 			= $_GET['rut'];

	$fecha_buscar 	= $_GET['fecha_buscar'];



				$sql_esta = "select NombreEstablecimiento,

									DireccionEstablecimiento,

									CiudadEstablecimiento

							from gescolcl_arcoiris_administracion.Establecimiento

							";

				$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());

				$row_esta = mysql_fetch_array($res_esta);

				

				$nombre_establecimiento = $row_esta['NombreEstablecimiento'];

				$direccion_establecimiento = $row_esta['DireccionEstablecimiento'];

				$CiudadEstablecimiento = $row_esta['CiudadEstablecimiento'];

				

				$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,

								         NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado,

								         DireccionParticularApoderado, Ciudades.Ciudad

					from gescolcl_arcoiris_administracion.Apoderados

						inner join gescolcl_arcoiris_administracion.Ciudades

							on Ciudades.CodigoCiudad = Apoderados.CiudadParticularApoderado

					where NumeroRutApoderado in (select NumeroRutApoderado

													from gescolcl_arcoiris_administracion.alumnos".$anio."

													where NumeroRutAlumno = '".$ncorr."')";

				$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

				$row_apoderado = mysql_fetch_array($res_apoderado);

				

				$nombre_apoderado = $row_apoderado['nombre'];

				$rut_apoderado = $row_apoderado['NumeroRutApoderado'].'-'.dv($row_apoderado['NumeroRutApoderado']);

				$direccion_apoderado = $row_apoderado['DireccionParticularApoderado'];

				$ciudad_apoderado = $row_apoderado['Ciudad'];

				$sql_pd = "select 

							concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 

							NumeroRutAlumno,

							NombreCurso

						 	from gescolcl_arcoiris_administracion.alumnos".$anio."

						 		inner join gescolcl_arcoiris_administracion.Cursos

						 			on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

							where NumeroRutAlumno = '".$ncorr."'"; 

				

				$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());

				$row_pd = mysql_fetch_array($res_pd);



				$nombre_alumno = $row_pd['nombre_alumno'];

				$nombre_curso = $row_pd['NombreCurso'];



				$dia = date('d');

				$mes = date('m');

				$anio = date('Y');



				$mes_l = "";

				if ($mes=='1'){ $mes_l = 'Enero'; }

				if ($mes=='2'){ $mes_l = 'Febrero'; }

				if ($mes=='3'){ $mes_l = 'Marzo'; }

				if ($mes=='4'){ $mes_l = 'Abril'; }

				if ($mes=='5'){ $mes_l = 'Mayo'; }

				if ($mes=='6'){ $mes_l = 'Junio'; }

				if ($mes=='7'){ $mes_l = 'Julio'; }

				if ($mes=='8'){ $mes_l = 'Agosto'; }

				if ($mes=='9'){ $mes_l = 'Septiembre'; }

				if ($mes=='10'){ $mes_l = 'Octubre'; }

				if ($mes=='11'){ $mes_l = 'Noviembre'; }

				if ($mes=='12'){ $mes_l = 'Diciembre'; }

				

				$fecha_letras = $dia.' de '.$mes_l.' de '.$anio;



				

				$pdf->Cell(200,5,$nombre_establecimiento,0,0,'L');

				$pdf->Ln();

				$pdf->Cell(200,5,$direccion_establecimiento,0,0,'L');

				$pdf->Ln();

				$pdf->Cell(200,5,$CiudadEstablecimiento,0,0,'L');

				

				$pdf->Ln();

				$pdf->Ln();



				$fecha_actual = date("d/m/Y");

				$pdf->SetFont('Arial','',8);

				$pdf->Ln();

				$pdf->Cell(200,5,'Villa Alemana, '.$fecha_letras,0,0,'R');

				$pdf->Ln();

				

				$pdf->SetWidths(array(100,100));

				$pdf->SetAligns(array('L','L'));

				$pdf->Row(array(utf8_decode('Sr.(a) Apoderado'),utf8_decode('')),0);

				$pdf->Row(array(utf8_decode($nombre_apoderado),utf8_decode('')),0);

				$pdf->Row(array(utf8_decode($direccion_apoderado),utf8_decode($ciudad_apoderado)),0);

				$pdf->Ln();

				

				$pdf->SetWidths(array(200));

				$pdf->SetAligns(array('L'));

				$pdf->Row(array(utf8_decode("De nuestra consideración:")),0);

				

				$pdf->SetWidths(array(200));

				$pdf->SetAligns(array('J'));

				$pdf->Row(array(utf8_decode("Nuestro cliente, Fundación Educacional Nuevo Milenio nos encomendó el cobro de las cuotas impagas de colegiatura de su pupilo ".$nombre_alumno." devengadas en conformidad al Contrato de Prestación de Servicios Educacionales suscrito por usted con el Colegio ".$nombre_establecimiento.", correspondiente a los siguientes meses:")),0);



				$pdf->Ln();

				$pdf->Ln();

				$pdf->SetWidths(array(100,100));

				$pdf->SetAligns(array('C','C'));

				$pdf->Row(array(utf8_decode('Vencimiento'),utf8_decode('Saldo')),0);

				

				$sql_boletas = "select 

								alumnos".$anio.".NumeroRutAlumno, 

								ValorPactado, 

								ValorPagado, 

								date_format(FechaVencimiento,'%d-%m-%Y') as FechaVencimiento_1, 

								FechaVencimiento

						from gescolcl_arcoiris_administracion.CuentaCorriente".$anio." 

							inner join gescolcl_arcoiris_administracion.alumnos".$anio." 

								on alumnos".$anio.".NumeroRutAlumno = CuentaCorriente".$anio.".NumeroRutAlumno

						where 	alumnos".$anio.".NumeroRutAlumno = '".$ncorr."' and 

								FechaVencimiento <= '".$fecha_buscar."' and 

								CuentaCorriente".$anio.".CodigoItem > 1 

						group by alumnos".$anio.".NumeroRutAlumno, FechaVencimiento

						";

				$res_boletas = mysql_query($sql_boletas,$conexion);

				$total_saldo ='';

				while($row_boletas = mysql_fetch_array($res_boletas)){

					$saldo = $row_boletas['ValorPactado'] - $row_boletas['ValorPagado'];

					if ($saldo>0){

						$pdf->Row(array(utf8_decode($row_boletas['FechaVencimiento_1']),utf8_decode(number_format($saldo,0,',','.'))),0);

						$total_saldo += $saldo;

						}

					}

				$pdf->Ln();

				$pdf->Ln();

				

				$pdf->SetWidths(array(200));

				$pdf->SetAligns(array('J'));

				$pdf->Row(array(utf8_decode("Total adeudado a la fecha:  ".number_format($total_saldo,0,',','.')."")),0);

				$pdf->Row(array(utf8_decode("Ante el incumplimiento en el pago de los Servicios Educacionales que ha afectado a la Fundación, nos permitimos indicarle que iniciaremos la cobranza judicial y solicitaremos las medidas necesarias para obtener el cumplimiento de lo adeudado más los gastos y costas de cobranza; por lo que solicitamos desde ya se acerque a las Oficinas de Administración del Colegio para efectuar el pago inmediato de la totalidad o parte de los haberes adeudados dentro del plazo de 5 días a contar de esta fecha.  ")),0);



				$pdf->Row(array(utf8_decode("Si al recibo de la presente, usted ya canceló la deuda, rogamos dejar sin efecto este aviso.")),0);

				

				$pdf->Row(array(utf8_decode("Atentamente, le saluda,")),0);

				

				$pdf->SetWidths(array(200));

				$pdf->SetAligns(array('C'));

				$pdf->Ln();

				$pdf->Ln();

				

				$pdf->Ln();

				$pdf->Ln();

				

				

				$pdf->Row(array(utf8_decode("Aldo Féndez Pacheco")),0);

				$pdf->Row(array(utf8_decode("Abogado")),0);

				$pdf->Row(array(utf8_decode("afendez@abogalex.cl")),0);

				

	$pdf->Output();

		

	?>