<?php 
session_start();

require('../includes/php/fpdf.php');
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

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

function Row($_GET,$linea) { 
    //Calculate the height of the row 
    $nb=0; 
    for($i=0;$i<count($_GET);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$_GET[$i])); 
    $h=5*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($_GET);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border
	if ($linea==1) $this->Rect($x,$y,$w,$h); 
        //Print the text 
        $this->MultiCell($w,5,$_GET[$i],0,$a); 
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
	function Header()
		{
		//Logo
		$this->Image('logo_new_yonley.jpg',15,15,33);
		
		//$this->Cell(194,17,"",1,0,'R');
		//$this->Ln();

		//$this->Cell(194,230,'',1,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','B',10);
		$this->Cell(50);
		$this->SetFillColor(200,220,255);
		$this->Cell(130,8,'Informe PreCargas',1,0,'C',1);
		//Título
		//Salto de línea
		$this->Ln(10);
		//Movernos a la derecha
		$this->Cell(4);
		
		/*
		$this->SetFont('Arial','B',12);
		$this->SetFillColor(200,220,255);
		$this->Cell(186,10,'RECUPERACION DE CUENTAS CRITICAS (ENVIO COBRADOR)',1,0,'C',1);
		*/
		
		//Salto de línea
		$this->Ln(10);
		}
	//Pie de página
	function Footer()
		{
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}

$pdf=new PDF('P','mm','letter'); //pagina carta horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
			
	$cod_vendedor	= 	$_GET["vendedor"];
	$empresa 	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$fecha_actual	=	date("Y-m-d");
	
	if ($cod_vendedor != ''){
		$and_1 = "vend_ncorr = '".$cod_vendedor."' and ";
		}
		mysql_select_db('sgyonley', $conexion);
		
	$sql = "select
			vent_ncorr as ncorr,
			vent_num_folio as folio,
			sect_ncorr as sector,
			DATE_FORMAT(vent_fecha,'%d/%m/%Y') as fecha,
			vent_num_boleta as num_boleta,
			clie_rut as cliente,
			vent_total_venta as total_venta,
			vent_pie as pie,
			vent_saldo as saldo,
			vent_valor_cuotas as valor_cuota,
			vent_estado_ingreso as estado_venta,
			vent_fecha,
			vend_ncorr
			
			from 
			ventas_antigua
			
			where 
			($and_1
			empe_rut = '".$empresa."' and
			vent_estado_ingreso = 'A' and
			vent_estado = 'FINALIZADA' and 
			vent_num_folio not in (select folio 
						from sgyonley.cargas_aprobadas
						where estado = 'autorizado')
			)
			or 
			($and_1
			empe_rut = '".$empresa."' and
			vent_estado_ingreso = 'A' and
			vent_estado = 'FINALIZADA' and 
			vent_num_folio in (select folio 
						from sgyonley.cargas_aprobadas
						where estado = 'rechazado')
			)			
			order by vent_num_folio";
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	if (mysql_num_rows($res) > 0){
		$i					=	1;
		$arrRegistros 		= 	array();
		$arrDetalle 		= 	array();
		$total_articulos 	= 	0;
		$total_ventas		=	0;
		$arrRegistrosVend	= 	array();	
		$vend_ncorr =	$cod_vendedor;
		// busca al vendedor
		$sql_nom_vend = "select ve_vendedor 
				from sgbodega.vendedores 
				where ve_codigo = '".$vend_ncorr."'";
		$res_nom_vend = mysql_query($sql_nom_vend,$conexion) or die(mysql_error());
		$nombre_vendedor = @mysql_result($res_nom_vend,0,"ve_vendedor");;
		if ($nombre_vendedor=='CUENTA PERSONAL'){
			$nombre_vendedor = '';
			}
		
		$pdf->SetWidths(array(13,11,18,18,18,40,25,15,9,18,18));
		$pdf->SetAligns(array('L','L','L','L','L','L','L','L','L','L','L'));
		$pdf->Row(array(utf8_decode('Folio'),utf8_decode('Sector'),utf8_decode('Fecha'),utf8_decode('Vendedor'),utf8_decode('Codigo'),utf8_decode('Descripcion'),utf8_decode('Observacion'),utf8_decode('Cantidad'),utf8_decode('N/U'),utf8_decode('Pedido'),utf8_decode('Despachado')),1);
		
		while ($line = mysql_fetch_row($res)) {
			
			$folio		=	$line[1];
			$vent_fecha = 	$line[11];
		
			$estado_venta = '';
			if (($line[10] != 'A') AND ($line[10] != 'N') AND ($line[10] != 'B') AND ($line[10] != 'D') AND ($line[10] != 'P'))
				{$estado_venta 	= 	'ACTIVA';}		//#FFFF00
			
			if ($line[10] == 'A'){$estado_venta 	= 	'POR APROBAR';}	//#00CC00
			if ($line[10] == 'N'){$estado_venta 	= 	'NULA';}		//#FF0000
			if ($line[10] == 'B'){$estado_venta 	= 	'DE BAJA';}		//#FF99CC
			if ($line[10] == 'D'){$estado_venta 	= 	'DEVOLUCION';}	//#FF9900
			if ($line[10] == 'P'){$estado_venta 	= 	'PAGADA';}		//#0066FF
			
			// se agrega nuevo filtro que une ventas activas con canceladas (06/10/2010)
			$estado_venta_doble = '';
			if ($filtro_estado == 'AP'){
				if ($estado_venta == 'ACTIVA'){
					$estado_venta_doble = 'AP';
				}
				if ($estado_venta == 'PAGADA'){
					$estado_venta_doble = 'AP';
				}
			}

			// busca el cliente
			$sector = $line[2];
			if (strlen($sector) == 1){$sector = '0'.$sector;}
			$tabla_clientes	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_clientes".$sector;
			$sql_cli = "select clie_nombre from $tabla_clientes where clie_rut = '".$line[4]."'";
			$res_cli = mysql_query($sql_cli, $conexion);
			$cliente="";
			if (@mysql_num_rows($res_cli) > 0){
				$cliente=   $line[5].' - '.@mysql_result($res_cli,0,"clie_nombre");
			}else{
				$sql_cli = "select clie_nombre from clientes where clie_rut = '".$line[5]."'";
				$res_cli = mysql_query($sql_cli, $conexion);
				$cliente=  $line[5].' - '.@mysql_result($res_cli,0,"clie_nombre");
			}	
			$fecha_tarjeta = $line[3];
			if ($estado_venta != 'NULA'){
				$total_ventas	=	$total_ventas + $line[6];
				}

			
			// busca los productos de cada folio.
			$sql_p = "select
					vdet_ncorr,
					arti_codigo_largo as codigo,
					arti_desc as descripcion,
					arti_nu as nu,
					vent_cant as cantidad,
					vent_valor_venta as precio,
					vent_sub_total as total
					
					FROM 
					ventas_detalle_antigua
					
					WHERE
					vent_ncorr = '".$folio."'";
			
			$res_p = mysql_query($sql_p, $conexion);
			
			while ($line_p = mysql_fetch_row($res_p)) {
					
				// busca el total entregado por articulo
				$vdet_ncorr		=	$line_p[0];
				$codigo			=	$line_p[1];
				$pend_entrega 	= 	$line_p[4];
				
				$sql_obs = "select * 
						from ventas_detalle_obs 
						where vent_det_ncorr = '".$vdet_ncorr."' 
						order by vdo_ncorr ";
				$res_obs = mysql_query($sql_obs,$conexion);
				$row_obs = mysql_fetch_array($res_obs);
				
				$observacion = $row_obs['observacion'];

				$sql_cp = "select fecha_pedida
						from cargas_pedidas 
						where folio = '".$folio."' and
							codigo = '".$line_p[1]."'
						order by fecha_pedida desc
						limit 0,1";
				$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
				$row_cp = mysql_fetch_array($res_cp);
				$fecha_pedido = $row_cp['fecha_pedida'];
				
				$sql_cp = "select fecha_despacho
						from cargas_despachadas
						where folio = '".$folio."'
						order by fecha_despacho desc
						limit 0,1";
				$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
				$row_cp = mysql_fetch_array($res_cp);
				$fecha_despacho = $row_cp['fecha_despacho'];
				
				$pdf->Row(array(utf8_decode($line[1]),utf8_decode($line[2]),utf8_decode($fecha_tarjeta),utf8_decode($nombre_vendedor),utf8_decode($line_p[1]),utf8_decode($line_p[2]),utf8_decode($observacion),utf8_decode($line_p[4]),utf8_decode($line_p[3]),utf8_decode($fecha_pedido),utf8_decode($fecha_despacho)),1);
			}
			$i++;
			
		}
	
	}	
				
$pdf->Output();
		

?>

