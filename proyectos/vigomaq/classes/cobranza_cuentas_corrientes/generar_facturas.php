<table>
<tr style="width:25%">
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">Nro Factura</td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">Valor Factura</td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">Saldo</td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">Monto a Abonar</td>
</tr>
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
?>
<tr style="width:25%">
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;"><?php echo $row['num_factura']?></td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">
    <?php 
			if ($row['total']>0)
				$total = $row['total']; 
			else
				$total = $row['total_1'];
			echo $total_1 = number_format(round(($total*(1+($row['valor_iva']/100)))),0,".",","); 
            $total_facturas += $total*(1+($row['valor_iva']/100));
            $total_facturas_1 += $total*(1+($row['valor_iva']/100));
	?>
	</td>  
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">
    <?php
    	$sql3="SELECT sum(monto) as monto
				from factura_pagos
				where num_factura = '".$row['num_factura']."'";
		$res3 = mysql_query($sql3,$link) or die(mysql_error());
		$registro3 = mysql_fetch_array($res3);
		$abono = $registro3['monto'];
		echo number_format($abono,0,".",",");

        $resto = round(($total*(1+($row['valor_iva']/100)))) - $abono;
        
        if (($resto<0)&&($abonos>$total_1)){
            $resto = $total_facturas_1 ;
            $total_facturas_1 =0;
            }
        else{
            $total_facturas_1 -= $resto; 
            }
	?>
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important;">
    	<input type="text" name="seleccion[]" id="seleccion_<?php echo $row['num_factura']?>" onchange='sumar();' class="sumar_facturas" value="<?php echo round($resto) ?>">
    </td>
</tr>
	
<?php }?>
</table>
<table>
<tr style="width:25%">
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="3">
        -----
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:left;" colspan="3">
        <?php   echo  number_format(round($total_facturas),0,".",","); ?>
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="3">
        Saldo
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="1">
    	<input type="text" readonly="readonly" name="saldo_pago" id="saldo_pago" readonly="readonly" value="0">
    </td>
</tr>
<tr style="width:25%">
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="3">
        -----
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="3">
        -----
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="3">
        Total
    </td>
    <td  style="padding: 5px;width: 25%; color: #FFFFFF !important; text-align:right;" colspan="1">
    	<input type="text" readonly="readonly" name="total_pago" id="total_pago" readonly="readonly" value="<?php echo round($total_facturas) ?>">
    </td>
</tr>

</table>