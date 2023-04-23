<?php
require('../includes/php/fpdf.php');
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 


class PDF extends FPDF {
	//Cabecera de página
	function Header() {
		
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
	mysql_select_db("sgcompras", $conexion);
	$sql_1 = "select `proveedor`, `empresa`, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha, `tipo_compra`, `centro_costo`, `proyecto`, `area`, `monto_total`, `neto`, `iva`, `forma_pago`, `nro_cuotas`, `documento`, `tiempo_entrega`, `lugar_entrega`, `direccion`, `descripcion`, `usuario`, `fecha_digitacion`
					from ordenes_compras
				where orden_compra_ncorr = ".$_GET['oc_ncorr']."";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$row_1 = mysql_fetch_array($res_1);
	//Logo
	//$this->Image('logo_top.JPG',15,15,33);
	/*if ($row_1['empresa']=='76112370'){
		$pdf->Image('logo_new_solyvalle.jpg',15,15,33);
		}
	else{
		$pdf->Image('logo_new_yonley.jpg',15,15,33);
		}*/
	$pdf->Ln(4);
	
	$fecha_actual = date("d/m/Y");
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(50);
	$pdf->Cell(130,10,'Orden Compra Nro '.$_GET['oc_ncorr'],0,0,'R');
	$pdf->Ln();
	$pdf->Cell(180,10,'VALPARAISO, '.$row_1['fecha'],0,0,'R');
	$pdf->Ln(20);

	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$p1 = $x;
	$p2 = $y;
	$pdf->SetFont('Arial','',10);		

	$pdf->Cell(200,5,"PROVEEDOR",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);
	$pdf->Cell(10,5,"Proveedor",0,0,'L');	
	$sql = "SELECT * 
    	    FROM sgbodega.proveedor
			WHERE PR_NCORR = '".$row_1['proveedor']."'";
	$res = mysql_query($sql, $conexion);
	$row_pr = mysql_fetch_array($res);
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_pr['PR_RAZON'],0,0,'L');	
	$pdf->SetXY($x+100,$y);
	$pdf->Cell(10,5,"Rut",0,0,'L');	
	$pdf->Cell(10,5,$row_pr['PR_RUT'],0,0,'L');	
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
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Facturar a ",0,0,'L');	
	$sql = "SELECT * 
        	FROM sgyonley.empresas
        	WHERE empe_rut like '".$row_1['empresa']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_em['empe_desc'],0,0,'L');	
	$pdf->Ln();
	$pdf->Ln();

	$pdf->Cell(200,5,"DETALLE",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Tipo de compra",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$sql = "SELECT * 
        	FROM tipos_compras
        	WHERE tipos_compras_ncorr = '".$row_1['tipo_compra']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->SetXY($x+80,$y);
	$pdf->Cell(10,5,"Centro de Costo",0,0,'L');	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_1['centro_costo'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Proyecto",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$pdf->Cell(10,5,$row_1['proyecto'],0,0,'L');	
	$pdf->SetXY($x+80,$y);
	$pdf->Cell(10,5,"Area",0,0,'L');	
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+20,$y);
	$sql = "SELECT * 
        	FROM areas
        	WHERE area_ncorr = '".$row_1['area']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->Ln();
	$pdf->Cell(200,5,"PRODUCTOS DETALLE",1,0,'L');	
	$pdf->Ln();
	
	$sql_2 = "select `orden_compra_ncorr`, `producto`, `detalle_producto`, `cantidad`, `precio`
					from oc_tiene_detalle
				where `orden_compra_ncorr` = ".$_GET['oc_ncorr']."";
	$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,03,'Codigo Producto',1,0,'L');
	$pdf->Cell(100,03,'Detalle producto',1,0,'L');
	$pdf->Cell(25,03,'Cantidad',1,0,'L');
	$pdf->Cell(25,03,'Precio',1,0,'L');
	$pdf->Cell(25,03,'Total',1,0,'L');
	$pdf->Ln();
	while($row_2 = mysql_fetch_array($res_2)){
		$pdf->Cell(25,03,$row_2['producto'],1,0,'L');
		$pdf->Cell(100,3,$row_2['detalle_producto'],1,0,'L');
		$pdf->Cell(25,03,$row_2['cantidad'],1,0,'L');
		$pdf->Cell(25,03,$row_2['precio'],1,0,'L');
		$pdf->Cell(25,03,$row_2['precio']*$row_2['cantidad'],1,0,'L');
		$pdf->Ln();
		}
	$pdf->SetFont('Arial','',10);
	$pdf->Ln();
	$pdf->Cell(200,5,"CONDICIONES DE PAGO",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Monto Total",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$pdf->Cell(10,5,$row_1['monto_total'],0,0,'L');	
	$pdf->SetXY($x+50,$y);
	$pdf->Cell(10,5,"Neto",0,0,'L');	
	$pdf->Cell(10,5,$row_1['neto'],0,0,'L');	
	$pdf->SetXY($x+80,$y);
	$pdf->Cell(10,5,"Iva",0,0,'L');	
	$pdf->Cell(10,5,$row_1['iva'],0,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Forma de pago",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$sql = "SELECT * 
        	FROM forma_pago
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
        	FROM documentos
        	WHERE documentos_ncorr = '".$row_1['documento']."'";
	$res = mysql_query($sql, $conexion);
	$row_em = mysql_fetch_array($res);
	$pdf->Cell(10,5,$row_em['nombre'],0,0,'L');	
	$pdf->Ln();
	if (($row_1['forma_pago']==2)||($row_1['forma_pago']==3)||($row_1['forma_pago']==4)){
		$pdf->Cell(200,5,"DETALLE FORMA PAGO",1,0,'L');	
		$pdf->Ln();
		if ($row_1['forma_pago']==2){
			$sql_2 = "select `nro_cheque`, `fecha`, `valor`
							from oc_tiene_cheques
						where `orden_compra_ncorr` = ".$_GET['oc_ncorr']."";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(66,03,'Numero Cheque',1,0,'L');
			$pdf->Cell(67,03,'Fecha',1,0,'L');
			$pdf->Cell(67,03,'Valor',1,0,'L');
			$pdf->Ln();
			while($row_2 = mysql_fetch_array($res_2)){
				$pdf->Cell(66,03,$row_2['nro_cheque'],1,0,'L');
				list($anio1,$mes1,$dia1) = explode('-', $row_2['fecha']);	
				$fecha	= $dia1."-".$mes1."-".$anio1;
				$pdf->Cell(67,3,$fecha,1,0,'L');
				$pdf->Cell(67,03,$row_2['valor'],1,0,'L');
				$pdf->Ln();
				}
			}
		elseif ($row_1['forma_pago']==3){
			$sql_2 = "select `banco`, `tipo_tarj_cred`, `cuotas`
							from oc_tiene_tc
						where `oc_ncorr` = ".$_GET['oc_ncorr']."";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(66,03,'Banco',1,0,'L');
			$pdf->Cell(66,03,'Tipo Tarjeta Credito',1,0,'L');
			$pdf->Cell(66,03,'Cuotas',1,0,'L');
			$pdf->Ln();
			while($row_2 = mysql_fetch_array($res_2)){
				$pdf->Cell(66,03,$row_2['banco'],1,0,'L');
				$pdf->Cell(66,3,$row_2['tipo_tarj_cred'],1,0,'L');
				$pdf->Cell(66,03,$row_2['cuotas'],1,0,'L');
				$pdf->Ln();
				}
			}
		elseif ($row_1['forma_pago']==4){
			$sql_2 = "select `banco`, `nro_transferencia`
							from oc_tiene_transferencias
						where `oc_ncorr` = ".$_GET['oc_ncorr']."";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(100,03,'Banco',1,0,'L');
			$pdf->Cell(100,03,'Nro Transferencia',1,0,'L');
			$pdf->Ln();
			while($row_2 = mysql_fetch_array($res_2)){
				$pdf->Cell(100,03,$row_2['banco'],1,0,'L');
				$pdf->Cell(100,3,$row_2['nro_transferencia'],1,0,'L');
				$pdf->Ln();
				}
			}
		
		$pdf->SetFont('Arial','',10);
		}
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(200,5,"CONDICIONES DE ENTREGA",1,0,'L');	
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Lugar de entrega",0,0,'L');	
	$pdf->SetXY($x+30,$y);
	$sql = "SELECT * 
        	FROM lugar_entrega
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
	$pdf->Ln();
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->Cell(10,5,"Observaciones",0,0,'L');	
	$pdf->SetXY($x+20,$y);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x+10,$y);
	$pdf->Cell(200,5,$row_1['descripcion'],0,0,'L');
$pdf->Output();
?>

