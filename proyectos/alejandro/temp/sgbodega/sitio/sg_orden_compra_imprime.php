<?php
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
	
	$sql_1 = "select `proveedor`, tipo_orden, `empresa`, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha, `tipo_compra`,
					`opcion_compra`,`folio_compra`,  `monto_total`, `neto`, `iva`, `forma_pago`, `nro_cuotas`, 
					`documento`, `nro_documento`, `tiempo_entrega`, `lugar_entrega`, `direccion`, `descripcion`, `descripcion_1`, 
					`usuario`, `fecha_digitacion`,estado, cond_pago
					from sgcompras.ordenes_compras
				where orden_compra_ncorr = ".$_GET['oc_ncorr']."";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$row_1 = mysql_fetch_array($res_1);
	
	$estado	= $row_1['estado'];
	if ($estado=='AUTORIZADO'){
		$estado='AUTORIZADO';
		}					
	elseif ($estado =='CANCELADO'){
		$estado='RECHAZADO';
		}
	elseif ($estado =='AUTORIZADO-FP'){
		$estado='AUTORIZADO FORMAS PAGO';
		}
	elseif ($estado =='RECEPCION-PRODUCTOS'){
		$estado='RECEPCION COMPLETA PRODUCTOS';
		}
	elseif ($estado =='PENDIENTE'){
		$estado='PENDIENTE';
		}
	elseif ($estado =='RECEPCION-PENDIENTE-PRODUCTOS'){
		$estado='RECEPCION PENDIENTE PRODUCTOS';
		}
	

	$pdf->SetTextColor(255,192,203);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y+100);	
	$pdf->MultiCell(200,35,$estado,0,'C');	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetXY($x,$y);	
	if ($row_1['empresa']=='76112370'){
		$pdf->Image('logo_new_solyvalle.jpg',15,15,33);
		}
	else{
		//$pdf->Image('logo_new_yonley.jpg',15,15,33);
		}
	$pdf->Ln(4);
	
	$fecha_actual = date("d/m/Y");
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(50);
	$pdf->Cell(130,10,'Orden '.$row_1['tipo_orden'].' Nro '.$_GET['oc_ncorr'],0,0,'R');
	$pdf->Ln();
	$pdf->Cell(180,10,'CASABLANCA, '.$row_1['fecha'],0,0,'R');
	$pdf->Ln(20);

	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$p1 = $x;
	$p2 = $y;
	$pdf->SetFont('Arial','',10);		
	
	$pdf->Cell(200,5,"EMPRESA",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Facturar a ",0,0,'L');	
	list($rut_empe,$dv_empe) = explode('-',$row_1['empresa']);
	$sql = "SELECT * 
        	from sgyonley.empresas
        	WHERE empe_rut like '".substr($rut_empe,0,8)."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_em['empe_desc'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Rut empresa",0,0,'L');	
	$pdf->SetXY($x+25,$y);
	$pdf->Cell(10,5,$row_em['empe_rut'].'-'.dv($row_em['empe_rut']),0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(35,5,"Direccion Empresa",0,0,'L');	
	$pdf->Cell(10,5,$row_em['empe_direccion'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Ciudad Empresa",0,0,'L');	
	$pdf->SetXY($x+30,$y);
	$pdf->Cell(10,5,$row_em['empe_ciudad'],0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(35,5,"Giro Empresa",0,0,'L');	
	$pdf->Cell(10,5,$row_em['empe_giro'],0,0,'L');	
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->Cell(200,5,"PROVEEDOR",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);
	$pdf->Cell(10,5,"Proveedor",0,0,'L');	
	$sql = "SELECT * 
    	    from sgbodega.proveedor
			WHERE PR_NCORR = '".$row_1['proveedor']."'";
	$res = mysql_query($sql, $conexion);
	$row_pr = mysql_fetch_array($res);
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,utf8_decode($row_pr['PR_RAZON']),0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Rut",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_pr['PR_RUT'].'-'.dv($row_pr['PR_RUT']),0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Direccion",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_pr['PR_DIRECCION'],0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(10,5,"Fono",0,0,'L');	
	$pdf->Cell(10,5,$row_pr['PR_FONO1'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Email",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_pr['PR_MAIL'],0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(35,5,"Nombre de Contacto",0,0,'L');	
	$pdf->Cell(10,5,$row_pr['PR_ATENCION'],0,0,'L');	
	$pdf->Ln();
	$pdf->Ln();

	$pdf->Cell(200,5,"DETALLE",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Tipo de compra",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$sql = "SELECT * 
        	FROM sgcompras.tipos_compras
        	WHERE tipos_compras_ncorr = '".$row_1['tipo_compra']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->Ln();
	$pdf->Ln();
	
	$pdf->Cell(200,5,"PRODUCTOS DETALLE",1,0,'L');	
	$pdf->Ln();
	
	$sql_2 = "select `orden_compra_ncorr`, `producto`, `detalle_producto`, `cantidad`, `precio`
					from sgcompras.oc_tiene_detalle
				where `orden_compra_ncorr` = ".$_GET['oc_ncorr']."";
	$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
	$pdf->SetFont('Arial','',10);
	if ($row_1['tipo_compra']=='2'){
		$pdf->Cell(170,7,'Trabajador',1,0,'L');
		$pdf->Cell(30,7,'Monto',1,0,'L');
		$pdf->Ln();
		while($row_2 = mysql_fetch_array($res_2)){
			
			$sql_trab = "SELECT concat(trab_nombres,' ',trab_apellidos) as trabajador, trab_rut
        					FROM sgcaja.trabajadores 
							where trab_ncorr = '".$row_2['producto']."'";
			$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
			$nom_trab = @mysql_result($res_trab,0,"trabajador");
			$rut_trab = @mysql_result($res_trab,0,"trab_rut");


			$pdf->SetWidths(array(100,70,30));
			$pdf->SetAligns(array('C','C','C'));
			$pdf->Row(array(utf8_decode($rut_trab.'-'.dv($rut_trab).' - '.$nom_trab),
							utf8_decode($row_2['cant_recibida']),
							number_format( $row_2['precio'], 0 , '' , '.' )),1);
			
			}
		}
	else if (($row_1['tipo_compra']=='10')||($row_1['tipo_compra']=='11')||($row_1['tipo_compra']=='12')||($row_1['tipo_compra']=='13')||
			($row_1['tipo_compra']=='14')||($row_1['tipo_compra']=='15')||($row_1['tipo_compra']=='16')||($row_1['tipo_compra']=='17')||
			($row_1['tipo_compra']=='21')||($row_1['tipo_compra']=='20')||($row_1['tipo_compra']=='22')||($row_1['tipo_compra']=='23')||
			($row_1['tipo_compra']=='24')||($row_1['tipo_compra']=='26')||($row_1['tipo_compra']=='27')){
		$pdf->Cell(140,7,'Concepto',1,0,'L');
		$pdf->Cell(30,7,'Cantidad',1,0,'L');
		$pdf->Cell(30,7,'Monto',1,0,'L');
		$pdf->Ln();
		while($row_2 = mysql_fetch_array($res_2)){
			
			$sql_busca = "SELECT nombre
			FROM sgcaja_chica.cuentas
			WHERE (`cuentas_ncorr` like '".$row_2['producto']."'
			)";
			$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
			$row_busca = mysql_fetch_array($res_busca);
			$nombre = $row_busca['nombre'];
			
			if ($nombre == ''){
				$nombre = $row_2['producto'];
				}
			$pdf->Cell(140,7,utf8_decode($nombre),1,0,'L');
			$pdf->Cell(30,7,number_format( $row_2['cantidad'], 0 , '' , '.' ),1,0,'L');
			$pdf->Cell(30,7,number_format( $row_2['precio'], 0 , '' , '.' ),1,0,'L');
			$pdf->Ln();
			}
		}
	else if ($row_1['tipo_compra']=='3'){
		$pdf->Cell(150,7,'Trabajador',1,0,'L');
		$pdf->Cell(50,7,'Total a Pagar',1,0,'L');
		$pdf->Ln();
		while($row_2 = mysql_fetch_array($res_2)){
			
			$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
        					FROM sggeneral.trabajadores 
							where rut = '".$row_2['producto']."'";
			$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
			$nom_trab = @mysql_result($res_trab,0,"trabajador");
			$pdf->Cell(150,7,utf8_decode($row_2['producto'].'-'.dv($row_2['producto']).' '.$nom_trab),1,0,'L');
			
			$pdf->Cell(50,7,number_format( $row_2['precio'], 0 , '' , '.' ),1,0,'L');
			$pdf->Ln();
			}
		}
	elseif ($row_1['tipo_compra']=='4'){
		$pdf->Cell(80,7,'Trabajador',1,0,'L');
		$pdf->Cell(80,7,'Patente',1,0,'L');
		$pdf->Cell(40,7,'Monto',1,0,'L');
		$pdf->Ln();
		while($row_2 = mysql_fetch_array($res_2)){
			
			$sql_trab = "SELECT concat(pers_nombre,' ',pers_ape_pat,' ',pers_ape_mat) as trabajador
        					FROM sgcopec.personas 
							where pers_rut = '".$row_2['producto']."'";
			$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
			$nom_trab = @mysql_result($res_trab,0,"trabajador");
			$pdf->Cell(80,7,utf8_decode($row_2['producto'].'-'.dv($row_2['producto']).' '.$nom_trab),1,0,'L');
			
			$pdf->Cell(80,7,$row_2['detalle_producto'],1,0,'L');
		
			$pdf->Cell(40,7,number_format( $row_2['precio'], 0 , '' , '.' ),1,0,'L');
			$pdf->Ln();
			}
		}
	elseif (($row_1['tipo_compra']=='1')||($row_1['tipo_compra']=='25')){
		$pdf->Cell(15,7,'Codigo',1,0,'L');
		$pdf->Cell(130,7,'Detalle',1,0,'L');
		$pdf->Cell(15,7,'Cant',1,0,'L');
		$pdf->Cell(15,7,'Precio',1,0,'L');
		$pdf->Cell(25,7,'Total',1,0,'L');
		$pdf->Ln();
		while($row_2 = mysql_fetch_array($res_2)){
			if ($row_2['producto']!=$row_2['detalle_producto'])
				$pdf->Cell(15,7,$row_2['producto'],1,0,'L');
			else
				$pdf->Cell(15,7,'',1,0,'L');
			$pdf->Cell(130,7,utf8_decode($row_2['detalle_producto'].' '.$row_2['detalle']),1,0,'L');
			$pdf->Cell(15,7,number_format( $row_2['cantidad'], 0 , '' , '.' ),1,0,'L');
			$pdf->Cell(15,7,number_format( $row_2['precio'], 0 , '' , '.' ),1,0,'L');
			$pdf->Cell(25,7,number_format( $row_2['precio']*$row_2['cantidad'], 0 , '' , '.' ),1,0,'L');
			$pdf->Ln();
			}	
		}
	else if ($row_1['tipo_compra']=='5'){
		
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_anticipo
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(25,25,25,25,25,25,25,25));
			$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Sector'),utf8_decode('Trabajador'),utf8_decode('Tipo Trabajador'),utf8_decode('Tipo Anticipo'),
							utf8_decode('Es Deposito'),
							utf8_decode('Forma Pago'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
				
				$empe_rut = $row_1['empresa'];
				$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".substr($empe_rut,0,8)."'";
				$res_eco = mysql_query($sql_eco,$conexion);
				$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
				$sql = "select sect_desc as descripcion from sgyonley.sectores where sect_cod = '".$row_cant_rec['trabajador']."' and empe_ncorr = '".$empe_ncorr."'";
				$res = mysql_query($sql, $conexion);
				$sector = @mysql_result($res,0,"descripcion");
				
				$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
							FROM sggeneral.trabajadores
							where rut = '".$row_cant_rec['sector']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				
				$tipo_trabajador="";
				if ($row_cant_rec['tipo_trabajador']=='1'){
					$tipo_trabajador = 'Administrativo';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='2'){
					$tipo_trabajador = 'Vendedor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='3'){
						$tipo_trabajador = 'Cobrador';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='4'){
						$tipo_trabajador = 'Supervisor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='5'){
						$tipo_trabajador = 'Bodega';
					}

			$tipo_anticipo="";
					if ($row_cant_rec['tipo_anticipo']=='1'){
						$tipo_anticipo = 'Quincenal';
					}
					elseif ($row_cant_rec['tipo_anticipo']=='2'){
						$tipo_anticipo = 'Por comision Ventas';
					}
					elseif ($row_cant_rec['tipo_anticipo']=='3'){
						$tipo_anticipo = 'Extra';
					}

			$tipo_liquidacion_anticipo="";
					if ($row_cant_rec['tipo_liquidacion_anticipo']=='1'){
						$tipo_liquidacion_anticipo = 'Liquidacion 1';
					}
					elseif ($row_cant_rec['tipo_liquidacion_anticipo']=='2'){
						$tipo_liquidacion_anticipo = 'Liquidacion 2';
					}

			$es_deposito="";
					if ($row_cant_rec['deposito']=='0'){
						$es_deposito = 'NO';
					}
					elseif ($row_cant_rec['deposito']=='1'){
						$es_deposito = 'SI';
					}

				$forma_pago_ant="";
				if ($row_cant_rec['forma_pago']=='1'){
						$forma_pago_ant = 'Efectivo';
					}
					elseif ($row_cant_rec['forma_pago']=='4'){
						$forma_pago_ant = 'Transferencia';
					}
				
				$pdf->Row(array(utf8_decode($sector),utf8_decode($row_cant_rec['sector'].'-'.dv($row_cant_rec['sector']).' '.$nom_trab),
								utf8_decode($tipo_trabajador),
								utf8_decode($tipo_anticipo),
								utf8_decode($es_deposito),utf8_decode($forma_pago_ant),
								utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				
			}
		}
	}	
else if ($row_1['tipo_compra']=='6'){
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_prestamos
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(25,25,25,25,25,25,25,25));
			$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Sector'),utf8_decode('Trabajador'),utf8_decode('Forma Pago'),utf8_decode('Caja/Deposito'),
					utf8_decode('Tipo Prestamo'),utf8_decode('Fecha Emision'),
					utf8_decode('Nro Cuotas'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
				
				$empe_rut = $row_1['empresa'];
				$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".substr($empe_rut,0,8)."'";
				$res_eco = mysql_query($sql_eco,$conexion);
				$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
				$sql = "select sect_desc as descripcion 
						from sgyonley.sectores 
						where sect_cod = '".$row_cant_rec['sector']."' and 
							empe_ncorr = '".$empe_ncorr."'";
				$res = mysql_query($sql, $conexion);
				$sector = @mysql_result($res,0,"descripcion");
				
				$sql_trab = "SELECT tra_nombre as trabajador, tra_rut
									FROM yonleycp.trabajadores
									where tra_ncorr = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				$tra_rut = @mysql_result($res_trab,0,"tra_rut");
				
				$tipo_trabajador="";
				if ($row_cant_rec['forma_pago']=='1'){
					$tipo_trabajador = 'Efectivo';
				}
				elseif ($row_cant_rec['forma_pago']=='2'){
					$tipo_trabajador = 'Transferencia';
				}
				
				
				$tipo_anticipo="";
				if ($row_cant_rec['es_caja']=='0'){
					$tipo_anticipo = 'Caja';
				}
				elseif ($row_cant_rec['es_caja']=='1'){
					$tipo_anticipo = 'Deposito';
				}
				
				$tipo_liquidacion_anticipo="";
				if ($row_cant_rec['tipo_prestamo']=='1'){
					$tipo_liquidacion_anticipo = 'Empresa';
				}
				elseif ($row_cant_rec['tipo_prestamo']=='2'){
					$tipo_liquidacion_anticipo = 'Caja';
				}
				
				list($anio,$mes,$dia) = explode('-',$row_cant_rec['fecha_emision']);
				
				$pdf->Row(array(utf8_decode($sector),utf8_decode($tra_rut.'-'.dv($tra_rut).' - '.$nom_trab),utf8_decode($tipo_trabajador),
						utf8_decode($tipo_anticipo),utf8_decode($tipo_liquidacion_anticipo),
						utf8_decode($dia.'/'.$mes.'/'.$anio	),utf8_decode($row_cant_rec['num_cuotas']),
						utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				
				}
			}
		}
else if ($row_1['tipo_compra']=='30'){
		$sql_cant_rec="select trabajador, num_cuotas,fecha_emision, sum(cantidad*precio_venta) as monto, cod_producto
		from sgcompras.oc_tiene_detalle_cp
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'
		group by cod_producto";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(40,40,40,40,40));
			$pdf->SetAligns(array('C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Trabajador'),utf8_decode('Producto'),utf8_decode('Fecha Emision'),
					utf8_decode('Nro Cuotas'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
				
				$sql_trab = "SELECT tra_nombre as trabajador, tra_rut
									FROM yonleycp.trabajadores
									where tra_ncorr = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				$tra_rut = @mysql_result($res_trab,0,"tra_rut");
				
				list($anio,$mes,$dia) = explode('-',$row_cant_rec['fecha_emision']);
				
				$sql_prod = "select concat(TA_BUSQUEDA,' ',TA_DESCRIPCION) as prod
							from sgbodega.tallasnew
							where ta_ncorr = '".$row_cant_rec['cod_producto']."'";
				$res_prod = mysql_query($sql_prod,$conexion);
				$row_prod = mysql_fetch_array($res_prod);

				$producto = $row_cant_rec['cod_producto'].' - '.$row_prod['prod'];

				$pdf->Row(array(utf8_decode($tra_rut.'-'.dv($tra_rut).' - '.$nom_trab),
						utf8_decode($producto),utf8_decode($dia.'/'.$mes.'/'.$anio	),utf8_decode($row_cant_rec['num_cuotas']),
						utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				
				}
			}
		}
else if ($row_1['tipo_compra']=='7'){
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_bonos
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(33,33,34,33,33,34));
			$pdf->SetAligns(array('C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Sector'),utf8_decode('Trabajador'),utf8_decode('Tipo Trabajador'),utf8_decode('Es Deposito'),
							utf8_decode('Forma Pago'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
	
				$empe_rut = $row_1['empresa'];
				$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".substr($empe_rut,0,8)."'";
				$res_eco = mysql_query($sql_eco,$conexion);
				$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
				$sql = "select sect_desc as descripcion
				from sgyonley.sectores
				where sect_cod = '".$row_cant_rec['sector']."' and
				empe_ncorr = '".$empe_ncorr."'";
				$res = mysql_query($sql, $conexion);
				$sector = @mysql_result($res,0,"descripcion");
	
				$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
							FROM sggeneral.trabajadores
							where rut = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				
				$tipo_trabajador="";
				if ($row_cant_rec['tipo_trabajador']=='1'){
					$tipo_trabajador = 'Administrativo';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='2'){
					$tipo_trabajador = 'Vendedor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='3'){
						$tipo_trabajador = 'Cobrador';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='4'){
						$tipo_trabajador = 'Supervisor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='5'){
						$tipo_trabajador = 'Bodega';
					}

				$es_deposito="";
					if ($row_cant_rec['deposito']=='0'){
						$es_deposito = 'NO';
					}
					elseif ($row_cant_rec['deposito']=='1'){
						$es_deposito = 'SI';
					}

				$forma_pago_ant="";
				if ($row_cant_rec['forma_pago']=='1'){
						$forma_pago_ant = 'Efectivo';
					}
					elseif ($row_cant_rec['forma_pago']=='4'){
						$forma_pago_ant = 'Transferencia';
					}
				
				$pdf->Row(array(utf8_decode($sector),utf8_decode($row_cant_rec['trabajador'].'-'.dv($row_cant_rec['trabajador']).' '.$nom_trab),
								utf8_decode($tipo_trabajador),
								utf8_decode($es_deposito),utf8_decode($forma_pago_ant),
								utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				}
			}
		}
		
else if ($row_1['tipo_compra']=='19'){
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_ae
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(33,33,33,33,34,34));
			$pdf->SetAligns(array('C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Sector'),utf8_decode('Trabajador Aportador'),utf8_decode('Trabajador Beneficiario'),
							utf8_decode('Forma Pago'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
	
				$empe_rut = $row_1['empresa'];
				$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".substr($empe_rut,0,8)."'";
				$res_eco = mysql_query($sql_eco,$conexion);
				$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
				$sql = "select sect_desc as descripcion
				from sgyonley.sectores
				where sect_cod = '".$row_cant_rec['sector']."' and
				empe_ncorr = '".$empe_ncorr."'";
				$res = mysql_query($sql, $conexion);
				$sector = @mysql_result($res,0,"descripcion");
	
				$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
							FROM sggeneral.trabajadores
							where rut = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				
				$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
							FROM sggeneral.trabajadores
							where rut = '".$row_cant_rec['detalle']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab_1 = @mysql_result($res_trab,0,"trabajador");
				
				$tipo_trabajador="";
				if ($row_cant_rec['tipo_trabajador']=='1'){
					$tipo_trabajador = 'Administrativo';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='2'){
					$tipo_trabajador = 'Vendedor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='3'){
						$tipo_trabajador = 'Cobrador';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='4'){
						$tipo_trabajador = 'Supervisor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='5'){
						$tipo_trabajador = 'Bodega';
					}

				$es_deposito="";
					if ($row_cant_rec['deposito']=='0'){
						$es_deposito = 'NO';
					}
					elseif ($row_cant_rec['deposito']=='1'){
						$es_deposito = 'SI';
					}

				$forma_pago_ant="";
				if ($row_cant_rec['forma_pago']=='1'){
						$forma_pago_ant = 'Efectivo';
					}
					elseif ($row_cant_rec['forma_pago']=='4'){
						$forma_pago_ant = 'Transferencia';
					}
				
				$pdf->Row(array(utf8_decode($sector),utf8_decode($row_cant_rec['trabajador'].'-'.dv($row_cant_rec['trabajador']).' '.$nom_trab),
								utf8_decode($row_cant_rec['detalle'].'-'.dv($row_cant_rec['detalle']).' '.$nom_trab_1),
								utf8_decode($forma_pago_ant),
								utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				}
			}
		}
		
		else if ($row_1['tipo_compra']=='8'){
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_gratificaiones
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(33,33,34,33,33,34));
			$pdf->SetAligns(array('C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Sector'),utf8_decode('Trabajador'),utf8_decode('Tipo Trabajador'),utf8_decode('Es Deposito'),
							utf8_decode('Forma Pago'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
	
				$empe_rut = $row_1['empresa'];
				$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".substr($empe_rut,0,8)."'";
				$res_eco = mysql_query($sql_eco,$conexion);
				$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
				$sql = "select sect_desc as descripcion
				from sgyonley.sectores
				where sect_cod = '".$row_cant_rec['sector']."' and
				empe_ncorr = '".$empe_ncorr."'";
				$res = mysql_query($sql, $conexion);
				$sector = @mysql_result($res,0,"descripcion");
	
				$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
							FROM sggeneral.trabajadores
							where rut = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				
				$tipo_trabajador="";
				if ($row_cant_rec['tipo_trabajador']=='1'){
					$tipo_trabajador = 'Administrativo';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='2'){
					$tipo_trabajador = 'Vendedor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='3'){
						$tipo_trabajador = 'Cobrador';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='4'){
						$tipo_trabajador = 'Supervisor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='5'){
						$tipo_trabajador = 'Bodega';
					}

				$es_deposito="";
					if ($row_cant_rec['deposito']=='0'){
						$es_deposito = 'NO';
					}
					elseif ($row_cant_rec['deposito']=='1'){
						$es_deposito = 'SI';
					}

				$forma_pago_ant="";
				if ($row_cant_rec['forma_pago']=='1'){
						$forma_pago_ant = 'Efectivo';
					}
					elseif ($row_cant_rec['forma_pago']=='4'){
						$forma_pago_ant = 'Transferencia';
					}
				
				$pdf->Row(array(utf8_decode($sector),utf8_decode($row_cant_rec['trabajador'].'-'.dv($row_cant_rec['trabajador']).' '.$nom_trab),
								utf8_decode($tipo_trabajador),
								utf8_decode($es_deposito),utf8_decode($forma_pago_ant),
								utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				}
			}
		}
		
	else if ($row_1['tipo_compra']=='9'){
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_gratificaiones
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(33,33,34,33,33,34));
			$pdf->SetAligns(array('C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Sector'),utf8_decode('Trabajador'),utf8_decode('Tipo Trabajador'),utf8_decode('Monto Diario'),
							utf8_decode('Cantidad Dias'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
	
				$empe_rut = $row_1['empresa'];
				$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".substr($empe_rut,0,8)."'";
				$res_eco = mysql_query($sql_eco,$conexion);
				$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
				$sql = "select sect_desc as descripcion
				from sgyonley.sectores
				where sect_cod = '".$row_cant_rec['sector']."' and
				empe_ncorr = '".$empe_ncorr."'";
				$res = mysql_query($sql, $conexion);
				$sector = @mysql_result($res,0,"descripcion");
	
				$sql_trab = "SELECT concat(nombres,' ',apellido_pat,' ',apellido_mat) as trabajador
							FROM sggeneral.trabajadores
							where rut = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				
				$tipo_trabajador="";
				if ($row_cant_rec['tipo_trabajador']=='1'){
					$tipo_trabajador = 'Administrativo';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='2'){
					$tipo_trabajador = 'Vendedor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='3'){
						$tipo_trabajador = 'Cobrador';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='4'){
						$tipo_trabajador = 'Supervisor';
					}
				elseif ($row_cant_rec['tipo_trabajador']=='5'){
						$tipo_trabajador = 'Bodega';
					}

				$pdf->Row(array(utf8_decode($sector),utf8_decode($row_cant_rec['trabajador'].'-'.dv($row_cant_rec['trabajador']).' '.$nom_trab),
								utf8_decode($tipo_trabajador),
								utf8_decode(number_format( $row_cant_rec['deposito'], 0 , '' , '.' )),
								utf8_decode(number_format( $row_cant_rec['forma_pago'], 0 , '' , '.' )),
								utf8_decode(number_format( $row_cant_rec['monto'], 0 , '' , '.' ))),1);
				}
			}
		}
	else if ($row_1['tipo_compra']=='18'){
		$sql_cant_rec="select *
		from sgcompras.oc_tiene_detalle_reparaciones
		where orden_compra_ncorr = '".$_GET['oc_ncorr']."'";
		$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
		$cant_rec = 0;
		$movim_ncorr = "";
		if (mysql_num_rows($res_cant_rec)>0){
			$pdf->SetWidths(array(40,40,40,40,40));
			$pdf->SetAligns(array('C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Trabajador'),utf8_decode('Patente'),utf8_decode('Concepto'),utf8_decode('Cantidad'),utf8_decode('Monto')),1);
			while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
		
				$sql_trab = "SELECT concat(pers_nombre,' ',pers_ape_pat,' ',pers_ape_mat) as trabajador
        					FROM sgcopec.personas 
							where pers_rut = '".$row_cant_rec['trabajador']."'";
				$res_trab = mysql_query($sql_trab,$conexion) or die(mysql_error());
				$nom_trab = @mysql_result($res_trab,0,"trabajador");
				
				
				$pdf->Row(array(utf8_decode($row_cant_rec['trabajador'].' '.$nom_trab),
						utf8_decode($row_cant_rec['sector']),
						utf8_decode($row_cant_rec['tipo_trabajador']),
						utf8_decode($row_cant_rec['tipo_anticipo']),
						utf8_decode(number_format( $row_cant_rec['deposito'], 0 , '' , '.' ))),1);
		
				}
			}
		}
	$pdf->Ln();
	$pdf->Cell(200,5,"DESCUENTOS",1,0,'L');	
	$pdf->Ln();
	$pdf->Cell(170,7,'Concepto',1,0,'L');
	$pdf->Cell(30,7,'Monto',1,0,'L');
	$pdf->Ln();
	$sql_2 = "select `orden_compra_ncorr`, `producto`, `detalle_producto`, `cantidad`, `precio`
	from sgcompras.oc_tiene_descuentos
	where `orden_compra_ncorr` = ".$_GET['oc_ncorr']."";
	$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
	
	while($row_2 = mysql_fetch_array($res_2)){
		$nombre = $row_2['producto'];
		$pdf->Cell(170,7,utf8_decode($nombre),1,0,'L');
		$pdf->Cell(30,7,number_format( $row_2['precio'], 0 , '' , '.' ),1,0,'L');
		$pdf->Ln();
		}
	$pdf->Ln();
	$pdf->Cell(200,5,"CONDICIONES DE PAGO",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Monto Total",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,number_format( $row_1['monto_total'], 0 , '' , '.' ),0,0,'L');	
	$pdf->SetXY($x+50,$y);
	//if (($row_1['tipo_compra']=='1')||($row_1['tipo_compra']=='21')||($row_1['tipo_compra']=='25')){
		$pdf->Cell(10,5,"Neto",0,0,'L');	
		$pdf->Cell(10,5,number_format( $row_1['neto'], 0 , '' , '.' ),0,0,'L');	
		$pdf->SetXY($x+80,$y);
		$pdf->Cell(10,5,"Iva",0,0,'L');	
		$pdf->Cell(10,5,number_format( $row_1['iva'], 0 , '' , '.' ),0,0,'L');	
	//	}
		$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Forma de pago",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$sql = "SELECT * 
        	from sgcompras.forma_pago
        	WHERE fp_ncorr = '".$row_1['forma_pago']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->SetXY($x+80,$y);
	$pdf->Cell(10,5,"Nro de Doc/Cuotas",0,0,'L');	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+30,$y);
	$pdf->Cell(10,5,$row_1['nro_cuotas'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Documento",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$sql = "SELECT * 
        	from sgcompras.documentos
        	WHERE documentos_ncorr = '".$row_1['documento']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->SetXY($x+80,$y);
	$pdf->Cell(10,5,"Nro Documento",0,0,'L');	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+30,$y);
	$pdf->Cell(10,5,$row_1['nro_documento'],0,0,'L');	
	$pdf->Ln();
	$pdf->Cell(10,5,"Observaciones de Pago",0,0,'L');
	$pdf->Ln();
	$pdf->SetWidths(array(200));
	$pdf->SetAligns(array('L'));
	$pdf->Row(array(utf8_decode($row_1['descripcion_1'])),0);
		
	//$pdf->Row(array(($row_1['descripcion_1'])),0);
	$pdf->Ln();
	$pdf->Ln();
	if (($row_1['forma_pago']==2)||($row_1['forma_pago']==3)||($row_1['forma_pago']==4)){
		$pdf->Cell(200,5,"DETALLE FORMA PAGO",1,0,'L');	
		$pdf->Ln();
		if ($row_1['forma_pago']==2){
			$sql_2 = "select `nro_cheque`, `fecha`, `valor`
							from sgcompras.oc_tiene_cheques
						where `orden_compra_ncorr` = ".$_GET['oc_ncorr']."";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(66,5,'Numero Cheque',1,0,'L');
			$pdf->Cell(67,5,'Fecha',1,0,'L');
			$pdf->Cell(67,5,'Valor',1,0,'L');
			$pdf->Ln();
			while($row_2 = mysql_fetch_array($res_2)){
				$pdf->Cell(66,5,$row_2['nro_cheque'],1,0,'L');
				list($anio1,$mes1,$dia1) = explode('-', $row_2['fecha']);	
				$fecha	= $dia1."-".$mes1."-".$anio1;
				$pdf->Cell(67,5,$fecha,1,0,'L');
				$pdf->Cell(67,5,number_format( $row_2['valor'], 0 , '' , '.' ),1,0,'L');
				$pdf->Ln();
				}
			}
		elseif ($row_1['forma_pago']==3){
			$sql_2 = "select `banco`, `tipo_tarj_cred`, `cuotas`
							from sgcompras.oc_tiene_tc
						where `oc_ncorr` = ".$_GET['oc_ncorr']."";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(66,5,'Banco',1,0,'L');
			$pdf->Cell(66,5,'Tipo Tarjeta Credito',1,0,'L');
			$pdf->Cell(66,5,'Cuotas',1,0,'L');
			$pdf->Ln();
			while($row_2 = mysql_fetch_array($res_2)){
				$pdf->Cell(66,5,$row_2['banco'],1,0,'L');
				$pdf->Cell(66,5,$row_2['tipo_tarj_cred'],1,0,'L');
				$pdf->Cell(66,5,$row_2['cuotas'],1,0,'L');
				$pdf->Ln();
				}
			}
		elseif ($row_1['forma_pago']==4){
			$sql_2 = "select `banco`, `nro_transferencia`
							from sgcompras.oc_tiene_transferencias
						where `oc_ncorr` = ".$_GET['oc_ncorr']."";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(100,5,'Banco',1,0,'L');
			$pdf->Cell(100,5,'Nro Transferencia',1,0,'L');
			$pdf->Ln();
			while($row_2 = mysql_fetch_array($res_2)){
				$sql_banco = "select banc_desc from sgyonley.bancos where banc_ncorr = '".$row_2['banco']."'";
				$res_banco = mysql_query($sql_banco,$conexion) or die(mysql_error());
				$row_banco = mysql_fetch_array($res_banco);
				$pdf->Cell(100,5,$row_banco['banc_desc'],1,0,'L');
				$pdf->Cell(100,5,$row_2['nro_transferencia'],1,0,'L');
				$pdf->Ln();
				}
			}	
		
		$pdf->SetFont('Arial','',10);
		}
	$pdf->Ln();
	$pdf->Cell(200,5,"CONDICIONES DE ENTREGA",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Lugar de entrega",0,0,'L');	
	$pdf->SetXY($x+30,$y);
	$sql = "SELECT * 
        	from sgcompras.lugar_entrega
        	WHERE le_ncorr = '".$row_1['lugar_entrega']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(10,5,"Direccion",0,0,'L');	
	$pdf->SetXY($x+120,$y);
	$pdf->Cell(10,5,$row_1['direccion'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Plazo en Dias",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$pdf->Cell(10,5,$row_1['tiempo_entrega'],0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(10,5,"Condiciones de pago",0,0,'L');	
	$pdf->SetXY($x+135,$y);
	$pdf->Cell(10,5,$row_1['cond_pago'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Observaciones de Despacho",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+50,$y);
	$pdf->SetWidths(array(120));
	$pdf->SetAligns(array('J'));
	$pdf->Row(array(($row_1['descripcion'])),0);
	
		$pdf->Ln();		
		$pdf->Ln();		
	
	$sql_cant_rec="select *
			from sgcompras.oc_tiene_cant_rec
			where oc_ncorr = '".$_GET['oc_ncorr']."'
				and movim_ncorr in (select movim_ncorr_ant
									from sgcompras.movim
									where movim_estado = 'FINALIZADO')";
	$res_cant_rec = mysql_query($sql_cant_rec,$conexion) or die(mysql_error());
	$cant_rec = 0;
	$movim_ncorr = "";
	if (mysql_num_rows($res_cant_rec)>0){
		$pdf->Cell(200,7,'Productos Ingresados por Orden de Compra',1,0,'C');
		$pdf->Ln();		
		$pdf->SetWidths(array(18,22,22,22,24,26,22,22,22));
		$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C'));
		$pdf->Row(array(utf8_decode('Nro Guia'),utf8_decode('Fecha'),utf8_decode('Factura'),utf8_decode('Guia Despacho'),utf8_decode('Producto'),utf8_decode('Cant. Recepcionada'),utf8_decode('Precio Unitario'),utf8_decode('Usuario'),utf8_decode('Fecha Digitacion')),1);
		while($row_cant_rec = mysql_fetch_array($res_cant_rec)){
			list($dia1,$mes1,$anio1) = explode('-', $row_cant_rec['fecha_ingreso']);	
			$fecha	= $anio1."/".$mes1."/".$dia1;
			$pdf->Row(array(utf8_decode($row_cant_rec['movim_ncorr']),utf8_decode($fecha),utf8_decode($row_cant_rec['factura']),utf8_decode($row_cant_rec['guia_despacho']),utf8_decode($row_cant_rec['codigo'].' '.$row_cant_rec['detalle']),utf8_decode($row_cant_rec['cant_rec']),utf8_decode($row_cant_rec['precio']),utf8_decode($row_cant_rec['usuario']),utf8_decode($row_cant_rec['fecha_digitacion'])),1);
			$mov = $row_cant_rec['movim_ncorr'] +1;	
			$movim_ncorr .= $mov.",";
		}
	}
	$movim_ncorr = substr($movim_ncorr, 0, -1);
	$pdf->Ln();		
	/*if (($row_1['opcion_compra']==3)&&($movim_ncorr!='')){
		$sql_comp_directa = "select movim.movim_ncorr, movim_fecha , concat(mdet_codigo,' ',mdet_desc) as mdet_desc, 	
						mdet_cantidad, usu_id ,movim_fecha_dig
					from sgcompras.movim
						inner join sgcompras.movim_detalle
							on movim.movim_ncorr = movim_detalle.movim_ncorr
					where movim.movim_ncorr in (".$movim_ncorr.")";
		$res_com_directa = mysql_query($sql_comp_directa,$conexion) or die(mysql_error());
		if (mysql_num_rows($res_com_directa)>0){
			$pdf->Cell(200,7,'Ordenes de Compra asociadas a la Compra directa',1,0,'C');
			$pdf->Ln();		
			$pdf->SetWidths(array(30,30,50,30,30,30));
			$pdf->SetAligns(array('C','C','C','C','C','C'));
			$pdf->Row(array(utf8_decode('Nro Guia'),utf8_decode('Fecha'),utf8_decode('Producto'),utf8_decode('Cantidad'),utf8_decode('Usuario'),utf8_decode('Fecha Digitacion')),1);
			while($row_com_directa = mysql_fetch_array($res_com_directa)){
				list($dia1,$mes1,$anio1) = explode('-', $row_com_directa['movim_fecha']);	
				$fecha	= $anio1."/".$mes1."/".$dia1;
				$pdf->Row(array(utf8_decode($row_com_directa['movim_ncorr']),utf8_decode($fecha),utf8_decode($row_com_directa['mdet_desc']),utf8_decode($row_com_directa['mdet_cantidad']),utf8_decode($row_com_directa['usu_id']),utf8_decode($row_com_directa['movim_fecha_dig'])),1);
				}
			
			}

		}
		*/
		$pdf->Ln();
		$pdf->Cell(50,5,"______________________",0,0,'L');
		$pdf->Ln();
		$pdf->Cell(50,5,utf8_decode("Recibí conforme"),0,0,'C');
		
$pdf->Output();
?>
