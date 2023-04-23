<?php
require('classes/fpdf.php');
include "classes/conex.php"; //archivo de coneccion al servidor y base de datos

mysql_query("SET NAMES 'utf8'");	

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
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb} - Contrato de Arriendo Nro '.$_GET['num_gd'],0,0,'C');
	}
}



 $pdf=new PDF('P','mm','letter'); //pagina carta horizontal
 $pdf->AliasNbPages();
 $pdf->AddPage();

	$num_gd = $_GET['num_gd'];

	$link=Conectarse();

	$sqlfact = "SELECT * FROM gd WHERE num_gd ='$num_gd'";						
	$resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
	$registrofact = mysql_fetch_array($resfact);
	
	$cod_cli=$registrofact['cod_cliente'];
	$cod_obra=$registrofact['cod_obra'];
	$fecha_gd=$registrofact['fecha'];
	$num_arriendo =  $registrofact['id_arriendo'];
	
	$sql_arriendo = "SELECT * FROM `arriendo` where cod_arriendo = '".$num_arriendo."'";
	$res_arriendo = mysql_query($sql_arriendo,$link);
	$row_arriendo = mysql_fetch_array($res_arriendo);

	$num_oc = $row_arriendo['num_oc'];

	$sql_arriendo = "SELECT * FROM `obra` where cod_obra = '".$cod_obra."'";
	$res_arriendo = mysql_query($sql_arriendo,$link);
	$row_arriendo = mysql_fetch_array($res_arriendo);

	$nombre_obra = $row_arriendo['nombre_obra'];
	$direcc_obra = $row_arriendo['direcc_obra'];
	$cod_comuna_obra = $row_arriendo['cod_comuna'];

	$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
	$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
	$registrocliente = mysql_fetch_array($rescliente);
	$valor1=$registrocliente['rut_cliente'];
	if (empty($valor1)){
	
	}else{
			
			$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente,
					 raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, 
					 nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2,
					 email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, 
					 cargo_resp3, movil_resp3, cond_env_fact 
					FROM clientes 
					WHERE rut_cliente ='$valor1'";
			
			
			$res = mysql_query($sql,$link) or die(mysql_error()); 
			$registro = mysql_fetch_array($res);
			
	}
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y+10);	
	$pdf->Image('logo_vigomaq.jpg',10,5,45);
	
	$pdf->SetFont('Arial','B',10);
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('C'));
	$pdf->Row(array(utf8_decode('CONTRATO DE ARRIENDO NRO. '.$num_gd)),0);
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('J'));
	
	list($anio,$mes,$dia) = explode('-',$fecha_gd);
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
	$fecha_letras = $dia.' de '.$mes_ele.' de '.$anio;
	
	$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
 		// echo($sql3);
 	$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
 	$registrociu = mysql_fetch_array($resciu);

 	$sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
 	// echo($sql3);
 	$rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
 	$registrocom = mysql_fetch_array($rescom);
	
	$pdf->Row(array(utf8_decode('En Viña del Mar, '.$fecha_letras.',  entre la firma VIGOMAQ LTDA., Rut N° 76.836.180-0, representada para este efecto por el Sr. Christian Gastón Vicencio Urriola,  ambos con domicilio en Carlos Ibáñez del Campo N° 3114, Achupallas, Viña del Mar, al cual en adelante se denominará Arrendador, y por otra '.$registro['raz_social'].', Rut N° '.$registro['rut_cliente'].', con domicilio en '.$registro['direcc_cliente'].', Comuna de '.$registrocom['comuna'].'  y a quien en adelante se le denominará Arrendatario, se conviene de manera totalmente voluntaria el siguiente CONTRATO DE ARRIENDO que dan cuenta las cláusulas siguientes:')),0);
	$pdf->Row(array(utf8_decode('1.- El Arrendador entrega en arriendo al Arrendatario, declarando que los arrienda para sí, los bienes que a continuación se detallan. Las partes dejan constancia, que el Arrendatario en forma previa, ha verificado el estado del equipo y su correcto funcionamiento, declarando que no tiene reclamo que formular y que conoce la forma de operar la(s) maquinaria(s), así como las necesidades de conservación y mantenimiento que deben emplearse para su adecuado funcionamiento, por lo que recibe plenamente conforme y a su entera satisfacción:')),0);	
	$pdf->Row(array(utf8_decode('Según Orden de Compra Nº                 '.$num_oc.' para la Obra: '.$nombre_obra)),0);	
	
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(110,30,30,30));
	$pdf->SetAligns(array('L','C','C','C'));

	$pdf->Row(array(utf8_decode('Equipo - N° Equipo'),utf8_decode('Cantidad Dias'),utf8_decode('Descuento %'),utf8_decode('Precio Unitario')),1);
	$sqldet="SELECT  *
				FROM  det_gd 
				where num_gd = '".$_GET["num_gd"]."'
			 order by fila_num_gd ASC";	
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	$i=1;
	while ($registrodet = mysql_fetch_array($resdet)) {
		$array_temporal = array();
		$sqlnomrep="SELECT nombre_equipo, accesorios, cod_motor FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
		$resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
		$registronrep = mysql_fetch_array($resnomrep);
		$detalle="";
		$detalle_1="";
		if ($registrodet['observaciones']==''){
			$detalle .= $registronrep['nombre_equipo'];
			$detalle = substr($detalle, 0, strlen($detalle));
			$detalle = str_replace('\n', '', $detalle);
			}
		else{
			$detalle .= $registrodet['observaciones']." ";
			if (($registrodet['observaciones']=='CAMBIO')||($registrodet['observaciones']=='POR')){
				$detalle .= $registronrep['nombre_equipo']." ";
				}
			}
		if($registronrep['cod_motor'] > 1){
			$detalle .= ', C/MOTOR N. '.$registronrep['cod_motor'];
			}
		if($registrodet['accesorio'] == 1){
			$detalle .= ', '.$registronrep['accesorios'];
			}
		$total = $registrodet['cantidad']*$registrodet['precio'];
		$pdf->Row(array(utf8_decode($detalle),utf8_decode($registrodet['cantidad']),utf8_decode(''),utf8_decode($registrodet['precio']).' + IVA'),1);
		}
	
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('J'));
	
	$pdf->Row(array(utf8_decode('2.- El canon del arriendo será lo estipulado en la tabla anterior y corresponderá a un valor diario más IVA por cada equipo y tendrá una duración días calendario. El arriendo será facturado al momento de la devolución del o los equipos arrendados y/o al finalizar el mes de arrendamiento. Además, se destaca que el hecho de que lo arrendado no sea usado por el Arrendatario durante el período en que esté en vigencia el Contrato, no le dará derecho alguno a reclamar descuentos por tal concepto.')),0);	
	
	$pdf->Row(array(utf8_decode('3.- El Arrendatario, Representante legal o Socio Sr. ________________________________________________________________________________, para garantizar la tenencia responsable y/o la devolución en buenas condiciones del o los equipos arrendados, el cumplimiento oportuno de los pagos del arriendo y los posibles daños ocasionados por factores ajenos a su uso normal, entrega al Arrendador el siguiente documento de respaldo:')),0);	
	
	$pdf->Row(array(utf8_decode('Cheque Nº______________ Cta.: ______________     Banco: _____________________ por la suma $______________. En efectivo la suma de: _____________________')),0);	
	$pdf->Row(array(utf8_decode('El Arrendatario autoriza desde ya al Arrendador el empleo de esta suma de dinero en el caso de incumplimiento del Contrato. Asimismo, el Arrendatario otorga mandato al Arrendador para que en el evento que no cumpla con las obligaciones que emanan de este Contrato, proceda a llenar las menciones relativas a la fecha y monto o valor del documento entregado.')),0);	

	//equipos arriendo
	$sqlperiodo=" SELECT arrendado_desde, hora_arr
				FROM equipos_arriendo
					inner join gd
						on equipos_arriendo.cod_arriendo = gd.id_arriendo
					where equipos_arriendo.num_gd = '".$num_gd."'
					order by equipos_arriendo.arrendado_desde asc
				limit 0,1";
	$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
	$rowperiodo = mysql_fetch_array($resperiodo);

	list($anio,$mes,$dia) = explode('-',$rowperiodo['arrendado_desde']);
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
	$fecha_letras_1 = $dia.' de '.$mes_ele.' de '.$anio;
	
	$pdf->Row(array(utf8_decode('4.- El presente Contrato entrará en vigencia el día '.$fecha_letras_1.' a las '.$rowperiodo['hora_arr'].' Hrs y tendrá una duración indefinida, entendiéndose que se renueva sucesivamente en la medida que existan equipos y bienes entregados en arrendamiento. En caso de que el arrendatario no pague cualquiera de las cuentas a su vencimiento, Vigomaq Ltda. queda facultada para poner término de inmediato al presente contrato, exigiendo la devolución inmediata del material arrendado. Desde ya el arrendatario faculta y otorga mandato irrevocable al arrendador para que proceda al retiro de los bienes objeto del arrendamiento.')),0);	

	//datos obra
	$sqlcom="SELECT comuna FROM comuna where cod_comuna =".$cod_comuna_obra;
 	$rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
 	$registrocom = mysql_fetch_array($rescom);
	
	$pdf->Row(array(utf8_decode('5.- Lugar de Uso, Lugar de entrega, gastos de traslado y embalaje: El o los bienes arrendados, deberán permanecer en la siguiente ubicación '.$direcc_obra.', comuna de '.$registrocom['comuna'].'. En caso que el arrendatario quiera cambiar la ubicación del o los bienes arrendados deberá solicitar previamente autorización al arrendador y en caso que este lo autorice, deberá constar por escrito.')),0);	
	$pdf->Row(array(utf8_decode('Los bienes arrendados se entregarán en la ubicación detallada con anterioridad, siendo de exclusivo cargo del Arrendatario todos los gastos de embalaje, transporte e instalación del o los equipos, así como los perjuicios que pudiesen producirse.')),0);	

	$pdf->Row(array(utf8_decode('6.- Obligaciones del Arrendatario:')),0);	
	$pdf->Row(array(utf8_decode('a.- Previo al retiro del o los equipos arrendados, el Arrendatario deberá dar aviso mediante correo electrónico dirigido al Arrendador, indicando la fecha e individualización (a lo menos con nombre completo y Rut) de la persona autorizada para efectuar el retiro y firmar el contrato, siendo de su exclusiva responsabilidad la calidad de esta información. El Arrendador no podrá hacer la entrega mientras el Arrendatario no de cumplimiento al aviso antes indicado.')),0);	

	$pdf->Row(array(utf8_decode('b.- Mantener los bienes arrendados en perfecto estado de funcionamiento, realizando todo lo necesario para su conservación.')),0);	
	$pdf->Row(array(utf8_decode('c.- Evitar darle a los bienes un uso inadecuado contrario al uso que naturalmente está establecido, efectuando en forma periódica y de acuerdo a la pauta que se adjunta a cada equipo los trabajos de mantención y lubricación, restituyéndolos en perfecto estado de uso y funcionamiento.')),0);	
	$pdf->Row(array(utf8_decode('d.- Evitar remover la numeración, marcas e insignias propias de los bienes tomados en arriendo.')),0);	
	$pdf->Row(array(utf8_decode('f.- Autorizar al Arrendador el libre acceso a los lugares y locales donde se encuentren la/s maquinaria/s arrendadas durante el transcurso del arrendamiento, a fin de que pueda llevar a cabo labores de supervisión e inspección de los bienes arrendados en cuanto a su uso y operación normales, en el entendido de que dicha supervisión o inspección no interfiera en el uso y funcionamiento de la/s maquinaria/s.')),0);	
	$pdf->Row(array(utf8_decode('g.- Será de exclusiva cuenta del Arrendatario, todos los gastos de mantención, conservación, limpieza y/o lavado,lubricación y reparación del/los equipos arrendados, durante el período de arriendo.')),0);	
	$pdf->Row(array(utf8_decode('h.- Si durante el período de arriendo fuera necesario efectuar reparaciones y/o mantenciones al equipo arrendado, el Arrendador se reserva el derecho de utilizar para ello el tiempo equivalente a 1 día por semana, sin que signifique reducción del período de arriendo. Toda reparación, reposición e incorporación de cualquier elemento que se haga a los bienes arrendados deberá efectuarse directamente por el Arrendador.')),0);
	$pdf->Row(array(utf8_decode('i.- El Arrendador solo proporcionará los elementos originales que integran el o los equipos arrendados, siendo de cargo del Arrendatario las reposiciones o reemplazos que se requieran debido a su consumo o desgaste natural por su uso.')),0);
	$pdf->Row(array(utf8_decode('j.- El o los bienes dispuestos en arriendo se entregan con una carga básica de combustible, siendo el consumo subsiguiente de cargo exclusivo del Arrendatario.')),0);
	$pdf->Row(array(utf8_decode('k.- Devolver el o los equipos arrendados sin combustible en el estanque.')),0);
	$pdf->Row(array(utf8_decode('l.- Al momento de la devolución de la o las maquinarias arrendadas, el Arrendatario se obliga a costear todos los medios mecánicos para realizar el traslado seguro de los bienes, desde su ubicación hasta el camión que los trasladará hasta el domicilio comercial del Arrendador. En caso de que el Arrendador disponga que dichos bienes le sean devueltos en un lugar distinto al estipulado, lo comunicará por escrito al Arrendatario, aceptando que el aumento en los gastos que origine el cambio de ubicación serán por cuenta suya.')),0);
	$pdf->Row(array(utf8_decode('m.- Entregar y devolver los bienes arrendados en el domicilio comercial del Arrendador, limpios, armados y en buen estado de funcionamiento y mantención, facultando al Arrendador para cobrar y/o pagarse con la garantía otorgada en la cláusula número 3, de los gastos incurridos en la limpieza, montaje y/o reparación de los bienes arrendados si estos fueran devueltos en condiciones contrarias a las indicadas en este contrato y/o por los gastos de transporte en caso de ser retirados por el Arrendador.')),0);
	$pdf->Row(array(utf8_decode('7.- Dominio: Los bienes objeto del arrendamiento son de exclusivo dominio de VIGOMAQ LTDA. El Arrendatario deberá informar de inmediato al Arrendador en caso de producirse embargos, o cualquier otra acción o gravamen que limite o entrabe la libre disposición, uso y goce de los bienes arrendados. Asimismo, deberá ejercer de inmediato todas las acciones tendientes a dejar sin efecto los actos antes descritos.')),0);
	$pdf->Row(array(utf8_decode('8.- Indemnización: En caso de deterioro, pérdida y/o daños sean estos totales o parciales, incluidos el hurto, robo, extravío, destrucción y/o desperfecto de los equipos arrendados, incluidos el caso fortuito o fuerza mayor, y actos de terceros; el Arrendatario se hará responsable del pago del valor comercial de las maquinarias extraviadas. Para estos efectos, el valor comercial se entenderá como el precio tranzado en el mercado, por equipos nuevos al momento de ocurrido el siniestro. El Arrendatario se obliga a pagar tan pronto ocurra cualquiera de los eventos señalados o a requerimiento del Arrendador, quien por este acto, queda facultado por el Arrendatario para inspeccionar el o los bienes arrendados en cualquier momento. El Arrendatario indemnizará al Arrendador por todo gasto que éste tenga que incurrir, en razón de daños a terceros que se produzcan mientras el o los equipos estén en poder del primero o cuando sean transportados hacia o desde la ubicación de éste último.')),0);
	$pdf->Row(array(utf8_decode('9.- Seguro: El Arrendatario se obliga a mantener asegurados durante toda la vigencia de este contrato y de cualquiera de los anexos de éste, el o los equipos arrendados, contra todo riesgo y especialmente, pérdida total o parcial, incendio, caso fortuito, daños propios a terceros, robo o hurto. Los seguros se tomarán en beneficio del Arrendador por el total del valor de los bienes arrendados, debiendo pagarse la indemnización en caso de siniestro en forma directa al Arrendador por la compañía de seguros. El Arrendatario se obliga a pagar al Arrendador las diferencias que se produzcan en razón de la cobertura que no se encuentre cubierta con la indemnización.')),0);
	$pdf->Row(array(utf8_decode('10.- Subarriendo: Queda expresamente prohibido al Arrendatario subarrendar en todo o parte los bienes objeto del presente Contrato.')),0);
	$pdf->Row(array(utf8_decode('11.- Costos: Todos los gastos producidos con ocasión del presente Contrato de Arriendo serán de cargo exclusivo del Arrendatario.')),0);
	$pdf->Row(array(utf8_decode('12.- Autorización: El Arrendatario faculta y autoriza expresamente a VIGOMAQ LTDA., RUT N° 76.836.180-0 para que en caso de simple retardo, mora o incumplimiento de las obligaciones contraídas en documentos tales como: contratos, facturas, órdenes de compra, solicitudes de compra, guías de pedido, cartas de porte, pagarés, letras de cambio u otros; sus datos y los demás derivados de dichos documentos puedan ser ingresados, procesados, tratados y comunicados a terceros sin restricciones, en el registro de DICOM y/o al “Boletín de Informaciones Comerciales”. Asimismo, el Arrendatario renuncia expresamente al ejercicio de cualquier acción que pudiese intentar en contra del Arrendador como consecuencia del envío de sus antecedentes a DICOM.')),0);
	$pdf->Row(array(utf8_decode('13.- Las partes interesadas, enteradas de las declaraciones y las cláusulas del presente Contrato de Arriendo y el alcance del mismo, lo firman en duplicado, en Viña del Mar  el día  '.$fecha_letras.', expresando su conformidad a todos los puntos estipulados, fijando como domicilio la ciudad de Viña del Mar sometiéndose a la Jurisdicción de sus tribunales de Justicia.')),0);

	$pdf->SetFont('Arial','',8);
	
	$pdf->SetWidths(array(50,150));
	$pdf->SetAligns(array('C','C'));
	$pdf->Ln();
	$pdf->Row(array(utf8_decode('Por VIGOMAQ:__________________'),utf8_decode('Por Arrendatario. RUT:______________NOMBRE:_________________________________FIRMA:____________')),0);
	
	
/*	
*/	
$pdf->Output();
?>
