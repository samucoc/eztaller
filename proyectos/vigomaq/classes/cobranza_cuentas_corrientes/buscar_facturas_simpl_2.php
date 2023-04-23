<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total , sum(total_rep) as total_1, oc_rep, estado, valor_iva
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura";

	$sql_cliente = "select distinct fecha from cierres order by c_ncorr desc limit 0,1";
	$res_cliente = mysql_query($sql_cliente,$link);
	$row_cliente = mysql_fetch_array($res_cliente);

$sql .= " where factura.fecha >= '".$row_cliente['fecha']."' ";


if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			$sql .= " and cod_cliente like '".$_GET["id_cliente"]."'";
		}
	}

if (isset($_GET['num_factura'])){
	if ($_GET["num_factura"]!=""){
			$sql_cliente = "select distinct cod_cliente from factura where num_factura = '".$_GET["num_factura"]."'";
			$res_cliente = mysql_query($sql_cliente,$link);
			$row_cliente = mysql_fetch_array($res_cliente);

			$sql .= " and cod_cliente = '".$row_cliente["cod_cliente"]."'";
		}
	}

$sql .=" group by factura.num_factura, fecha, cod_arriendo";
$res=mysql_query($sql,$link) or die(mysql_error());
$saldo_total = 0;
?>
<table width="100%">
<?php
if (($_GET["id_cliente"]!='')){
?>
    <tr>
    <td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Empresa</td>
    <td  class="floatLeft " style="padding: 5px;width: 50%; color: #000000 !important;">
          		<?php 
				$query = "select distinct clientes.raz_social
						from clientes
					 where clientes.cod_cliente = ".$_GET["id_cliente"]."";
				$result=mysql_query($query,$link) or die(mysql_error()); 
			$row = mysql_fetch_array($result);
			echo $row['raz_social']; ?>
	</td>
  	</tr>
<?php }?>
	<tr>
    <td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">N° Factura</td>
    <td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Emision</td>
    <td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Obra</td>
    <td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Valor Factura</td>
    <td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Orden Compra</td>
 	<td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Pago</td>
 	<td  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Forma Pago</td>
 	<td  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Suma Abonos</td>
 	<td  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Saldo</td>
 	<td  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Factor</td>
  	</tr>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ 
		$sql3="SELECT sum(monto) as monto
				from factura_pagos
				where num_factura = '".$registro['num_factura']."'";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			$abono = $registro3['monto'];
		if (($abono==0)||($abono=='')){
		?>
    	<tr>
        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <a id="vista-previa-factura" href="classes/facturar/cerrar-factura.php?num_fact=<?php echo $registro['num_factura']?>" target="_blank">
                        <?php echo $registro['num_factura']; ?>
            </a>
        </td>   
      	<td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
           <?php echo $registro['fecha']; ?>
        </td>   
        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
        	<?php
		if ((!empty($registro['cod_arriendo']))||($registro['cod_arriendo']!='0'))
		  {
			  $sql2="SELECT * FROM arriendo where cod_arriendo =".$registro['cod_arriendo'];
			 
			  //obtener codigo de obra desde arriendo
			  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
			  $registro2 = mysql_fetch_array($res2);
			  $codobra=$registro2['cod_obra'];
			 
			   if (!empty($codobra)){
				  $sql3="SELECT * FROM obra where cod_obra =".$registro2['cod_obra'];
				  $res3 = mysql_query($sql3,$link) or die(mysql_error());
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['nombre_obra']);
			  }else{
				  echo("Sin Obra");
			  }

		  }else{
			  echo("Sin Obra");
		  }
                ?>
		</td>
		<td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
        	<?php  
			$total=0;
			if ($registro['total']>0)
				$total = $registro['total']; 
			else
				$total = $registro['total_1'];
			echo $total_1 = round($total*(1+($registro['valor_iva']/100))); 
			$total = round($total*(1+($registro['valor_iva']/100)));
		?>
        </td>
		<td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['oc_rep']); ?>
        </td>
        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php 
			$sql3="SELECT fecha, tipo_pago
				FROM factura_pagos 
				where num_factura = '".$registro['num_factura']."'
				order by fecha desc";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			echo $registro3['fecha'];
		?>		
        </td>
        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php 
			$sql3="SELECT nombre
				FROM tipo_pagos 
				where tp_ncorr = '".$registro3['tipo_pago']."'";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			echo $registro3['nombre'];
		?>
        </td>
  	<td class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php //abonos
			$sql3="SELECT sum(monto) as monto
				from factura_pagos
				where num_factura = '".$registro['num_factura']."'";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			$abono = $registro3['monto'];
			echo number_format($abono,0,",",".");;
			
		?>
	</td>
  	<td class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php //saldo
			$saldo_total += ($total - $abono);
			$total_deuda += $total;
			$total_abonos += $abono;
			$saldo_actual = ($total - $abono);
			if ($saldo_actual>0){
				$factor = '';
				}
			elseif ($saldo_actual<0){
				$factor = ' + ';
				}
			echo abs($saldo_actual);
		?>
	</td>
  	<td class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
  		<?php 
  			echo $factor;
  		?>
	</td>
  	</tr>
  <?php
	}
	}

?>
	<tr>
	<td class="floatRight	" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php echo $total_deuda;?>
    	</td>
  	<td class="floatRight" style="padding: 5px;width: 8%; color: #000000 !important;">
		Deuda Total
	</td>
  	</tr>
	<tr>
	<td class="floatRight	" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php echo $total_abonos;?>
    	</td>
  	<td class="floatRight" style="padding: 5px;width: 8%; color: #000000 !important;">
		Abono Total
	</td>
  	</tr>
	<tr>
	<td class="floatRight	" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php 
			if ($saldo_total>0){
				$factor = '';
				}
			elseif ($saldo_total<0){
				$factor = ' + ';
				}
			

		echo abs($saldo_total).' '.$factor;?>
    	</td>
  	<td class="floatRight" style="padding: 5px;width: 8%; color: #000000 !important;">
		Saldo Total
	</td>
  	</tr>
<?php
		

}

else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}
?>
