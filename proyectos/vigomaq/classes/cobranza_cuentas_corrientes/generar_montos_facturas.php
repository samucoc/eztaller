
<?php 

include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total , sum(total_rep) as total_1, oc_rep, estado, valor_iva
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura
	where factura.num_factura in (".$_GET['facturas'].")
	group by num_factura";
$res=mysql_query($sql,$link) or die(mysql_error());
    $total_facturas = 0;

while ($row =mysql_fetch_array($res)){

	if ($row['total']>0)
				$total = $row['total']; 
			else
				$total = $row['total_1'];
			//$total_1 = number_format(round(($total*(1+($row['valor_iva']/100)))),0,".",","); 
            $total_facturas += $total*(1+($row['valor_iva']/100));
            $total_facturas_1 += $total*(1+($row['valor_iva']/100));

      $sql3="SELECT sum(monto) as monto
				from factura_pagos
				where num_factura = '".$row['num_factura']."'";
		$res3 = mysql_query($sql3,$link) or die(mysql_error());
		$registro3 = mysql_fetch_array($res3);
		$abono = $registro3['monto'];
		//echo number_format($abono,0,".",",");

        $resto = round(($total*(1+($row['valor_iva']/100)))) - $abono;
        
        if (($resto<0)&&($abonos>$total_1)){
            $resto = $total_facturas_1 ;
            $total_facturas_1 =0;
            }
        else{
            $total_facturas_1 -= $resto; 
            }

	}

echo round($total_facturas); 
?>