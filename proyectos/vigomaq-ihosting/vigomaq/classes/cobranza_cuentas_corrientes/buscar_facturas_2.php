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
  	<td  class="floatLeft " style="padding: 8px;width: 8%; color: #000000 !important;">Estado</td>
  	<td  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Seleccion</td>
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
			echo number_format($abono,0,".",",");;
			
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
			echo abs($saldo_actual.' '.$factor);
		?>
	</td>
  	<td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		 <a class="link_resumen" href="#" id="<?php echo $registro['num_factura']?>"><?php 
			$estado = $registro['estado'];
			if ($abono==0){
			?>	
		<img src="images/cara_roja.jpg" alt="IMPAGA" title="IMPAGA"/>
			<?php
			}elseif (($abono>0)&&($abono<$saldo_actual)){
			?>	
		<img src="images/cara_amarilla.jpg" alt="PENDIENTE" title="PENDIENTE"/>
			<?php
			}else{
			?>	
		<img src="images/cara_verde.jpg" alt="OK" title="OK"/>
			<?php
			}
		?>
        </a>
	</td>
	<td class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
          	<input type="checkbox" name="factura_<?php echo $registro['num_factura']?>" class="check_button" id="factura_<?php echo $registro['num_factura']?>" value="<?php echo $registro['num_factura']?>" title="Seleccionar" onclick="seleccionar('factura_<?php echo $registro['num_factura']?>')" />
           	<input type="hidden" name="txt_numfactura"  value="<?php echo $registro['num_factura']?>" />
    	</td>
  	</tr>
  <?php
	}
?>
  	</tr>
  		<?php 
	 	$sql_1 = "SELECT factura.num_factura, factura.fecha, cod_arriendo,factura.cod_cliente, 
						sum(tot_arriendo) as total , sum(total_rep) as total_1, oc_rep, estado, valor_iva,
						num_nota_cred, nota_credito.fecha as fecha_nc
					FROM factura
						inner join det_factura
							on factura.num_factura = det_factura.num_factura
						inner join nota_credito
							on nota_credito.num_factura = factura.num_factura
					";
		$sql_1 .= " where factura.fecha >= '".$row_cliente['fecha']."' ";

		if (isset($_GET['id_cliente'])){
			if ($_GET["id_cliente"]!=""){
					$sql_1 .= " and factura.cod_cliente = '".$_GET["id_cliente"]."'";
				}
			}

		if (isset($_GET['num_factura'])){
			if ($_GET["num_factura"]!=""){
					$sql_cliente = "select distinct cod_cliente from factura where num_factura = '".$_GET["num_factura"]."'";
					$res_cliente = mysql_query($sql_cliente,$link);
					$row_cliente = mysql_fetch_array($res_cliente);

					$sql_1 .= " and factura.cod_cliente = '".$row_cliente["cod_cliente"]."'";
				}
			}
		$sql_1 .= " and factura.num_factura = '".$registro['num_factura']."' ";
		$sql_1 .=" group by factura.num_factura, factura.fecha, factura.cod_arriendo";

		$res_1=mysql_query($sql_1,$link) or die(mysql_error());
		while($registro_1=mysql_fetch_array($res_1)){ ?>
		<tr>
		        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		                        <?php echo 'NC '.$registro_1['num_nota_cred']; ?>
		            
		        </td>   
		      	<td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		           <?php echo $registro_1['fecha_nc']; ?>
		        </td>   
		        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		        	<?php
				if ((!empty($registro_1['cod_arriendo']))||($registro_1['cod_arriendo']!='0'))
				  {
					  $sql2="SELECT * FROM arriendo where cod_arriendo =".$registro_1['cod_arriendo'];
					 
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
					if ($registro_1['total']>0)
						$total = $registro_1['total']; 
					else
						$total = $registro_1['total_1'];
					echo $total_1 =  number_format(round($total*(1+($registro_1['valor_iva']/100))),0,".",","); 
					$total = round($total*(1+($registro_1['valor_iva']/100)));
				?>
		        </td>
				<td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		            <?php  echo($registro_1['oc_rep']); ?>
		        </td>
		        <td class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
				<?php 
					$sql3="SELECT fecha, tipo_pago
						FROM factura_pagos 
						where num_factura = '".$registro_1['num_factura']."'
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
					$abono = $total;
					echo number_format($abono,0,".",",");;
					
				?>
			</td>
		  	<td class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
				<?php //saldo
					$saldo_total -= ($total + $abono);
					$total_deuda -= $total;
					$total_abonos -= $abono;
					$saldo_actual = ($total - $abono);
					if ($saldo_actual>0){
						$factor = '';
						}
					elseif ($saldo_actual<0){
						$factor = ' + ';
						}
					echo number_format(abs($saldo_actual),0,".",",").' '.$factor;
				?>
			</td>

		</tr>
		<?php } ?>
	<?php } ?>
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
