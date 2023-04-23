<?php
require('../fpdf/fpdf.php');
include("../conex.php");
//include("courierier.php");
$conexion=Conectarse();

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
		$this->SetFont('courier','B',50);
		}
		
	//Pie de página
	function Footer() {
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//courier italic 8
		$this->SetFont('courier','I',8);
		//Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}



$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
//$pdf->AddFont('courier','','courierier.php'); //Fuente de windows convertida con el 
$pdf->AliasNbPages();
$pdf->AddPage();

	$sql_1 = "select *
			from factura_entregas
			where fe_ncorr = ".$_GET['id']."";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$row_1 = mysql_fetch_array($res_1);

	//$pdf->Image('logo.jpg',15,15,33);
	
	$pdf->SetFont('courier','B',10);
	$pdf->Cell(50,10,'VIGOMAQ',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(50);
	$pdf->Cell(130,10,'Guia Interna Nro '.$_GET['id'],0,0,'R');
	$pdf->Ln();
	$pdf->SetFont('courier','B',18);
	$pdf->Cell(200,10,'Guia Interna',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('courier','',10);
	list($anio,$mes,$dia) = explode('-',$row_1['fecha_entrega']);
	$fecha_entrega = $dia.'-'.$mes.'-'.$anio;
	$pdf->Cell(100,10,'Fecha : '.$fecha_entrega,0,0,'L');
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(100,10,'Hora : '.$row_1['hora_entrega'],0,0,'L');	
	$pdf->Ln();
	$facturas = $row_1['facturas'];
	$sql_comp_directa = "select factura.num_factura, fecha, cod_arriendo,cod_cliente,oc_rep,valor_iva
				FROM factura
				WHERE factura.num_factura in (".$facturas.")";
	$res_com_directa = mysql_query($sql_comp_directa,$conexion) or die(mysql_error());
	$pdf->SetWidths(array(20,25,30,50,40,30));
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->Row(array(utf8_decode('Factura'),utf8_decode('Fecha Emision'),utf8_decode('Tipo Factura'),utf8_decode('Razon Social'),utf8_decode('Obra'),utf8_decode('Valor')),1);
	if (mysql_num_rows($res_com_directa)>0){
		while($row_com_directa = mysql_fetch_array($res_com_directa)){
			list($anio,$mes,$dia) = explode('-', $row_com_directa['fecha']);	
			$fecha	= $dia."-".$mes."-".$anio;
			
			$factura = $row_com_directa['num_factura'];	
			$estado = "";			
			if ($row_com_directa['cod_arriendo']==0){
				$estado =  "Venta";
				}
			else {
				$estado = "Arriendo";
				}
			$query = "select distinct clientes.raz_social
					from arriendo
						inner join clientes
							on arriendo.rut_cliente = clientes.rut_cliente
					where arriendo.cod_arriendo = '".$row_com_directa['cod_arriendo']."'";
			$result=mysql_query($query,$conexion) or die(mysql_error()); 
			if (mysql_num_rows($result)==0){
				$query = "select distinct clientes.raz_social
						from clientes
					 where clientes.cod_cliente = ".$row_com_directa['cod_cliente']."";
				$result=mysql_query($query,$conexion) or die(mysql_error()); 
				}
			$row = mysql_fetch_array($result); 
			$raz_social = $row['raz_social'];
			$obra ="";
			if ((!empty($row_com_directa['cod_arriendo']))||($row_com_directa['cod_arriendo']!='0')){
			  $sql2="SELECT * FROM arriendo where cod_arriendo =".$row_com_directa['cod_arriendo'];
			  $res2 = mysql_query($sql2,$conexion) or die(mysql_error()); 
			  $registro2 = mysql_fetch_array($res2);
			  $codobra=$registro2['cod_obra'];
			 
			  //obtener nombre de obra
			  if ($codobra!=''){
				  $sql3="SELECT * FROM obra where cod_obra =".$registro2['cod_obra'];
				  $res3 = mysql_query($sql3,$conexion) or die(mysql_error());
				  $registro3 = mysql_fetch_array($res3);
				  $obra = ($registro3['nombre_obra']);
			  	}
			  else{
			  	$obra = ("Sin Obra");
		 		}
		  	}else{
			  $obra = ("Sin Obra");
		 	}
			$total ="";
			$sql_tot = "select COALESCE(sum(tot_arriendo),0) as total
					from det_factura
					where num_factura = '".$factura."'";
			$res_tot = mysql_query($sql_tot,$conexion) or die(mysql_error());
			$row_tot = mysql_fetch_array($res_tot);

			if ($row_tot['total']>0){
				$total = $row_tot['total']*(1+($row_com_directa['valor_iva']/100));
			}else{
				$sql_tot = "select COALESCE(sum(total_rep),0) as total
					from det_factura
					where num_factura = '".$factura."'";
				$res_tot = mysql_query($sql_tot,$conexion) or die(mysql_error());
				$row_tot = mysql_fetch_array($res_tot);
				$total = $row_tot['total']*(1+($row_com_directa['valor_iva']/100));
				}
			$total = number_format($total,0,"",".");
			$pdf->Row(array(utf8_decode($factura),utf8_decode($fecha),utf8_decode($estado),utf8_decode($raz_social),utf8_decode($obra),utf8_decode($total)),1);
			}
		}

	$pdf->ln(30);
	$x = $pdf->GetX()+15;
	$y = $pdf->GetY();
	$x2 = $pdf->GetX()+85;
	$y2 = $pdf->GetY();
	
	$pdf->Line($x,$y,$x2,$y2);

	$x = $pdf->GetX()+115;
	$y = $pdf->GetY();
	$x2 = $pdf->GetX()+185;
	$y2 = $pdf->GetY();
	$pdf->Line($x,$y,$x2,$y2);
	$pdf->ln();

	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+15,$y);

	$sql = "SELECT nombres_personal,ap_patpersonal,ap_patpersonal
		FROM personal 
		where cod_personal = '".$row_1['cod_vendedor_entrega']."'";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$row = mysql_fetch_array($res);
	$nombres = $row['nombres_personal'].' '.$row['ap_patpersonal'].' '.$row['ap_patpersonal'];
	$pdf->Cell(75,5,$nombres,0,0,'C');	
	$pdf->SetXY($x+115,$y);
	$pdf->Cell(75,5,$row_1['quien_entrega'],0,0,'C');	
	$pdf->ln();

	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+15,$y);

	$pdf->Cell(75,5,"RECIBE",0,0,'C');	
	$pdf->SetXY($x+115,$y);
	$pdf->Cell(75,5,"ENTREGA",0,0,'C');	

	$pdf->Output();
?>

