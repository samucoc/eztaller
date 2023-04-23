<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT cod_cliente, sum(tot_arriendo) + sum(total_rep) as total , valor_iva
		FROM factura
			inner join det_factura
				on factura.num_factura = det_factura.num_factura
		";

//id_cliente='+id_cliente+'&cant_dias='+cant_dias+'&todas='+todas,
if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			$sql .= " and cod_cliente like '".$_GET["id_cliente"]."'";
		}
	}
$res=mysql_query($sql,$link) or die(mysql_error());

?>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Raz&oacute;n Social</div>
	<div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Deuda Vencida</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Obra</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Facturas Vencidas</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Detalle Deuda</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Facturas x Vencer</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Deuda x Vencer</div>
  	<br class="clearFloat"/>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
    	<?php 
			$query = "select distinct clientes.raz_social
						from clientes
					 where clientes.cod_cliente = ".$registro['cod_cliente']."";
			$result=mysql_query($query,$link) or die(mysql_error()); 
			$row = mysql_fetch_array($result); ?>
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
		<?php echo $row['raz_social']; ?>
        </div>
		<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
        	<?php  if ($registro['total']>0){
				$total = round(($registro['total']*(1+($registro['valor_iva']/100)))); 
				$sql3="SELECT sum(monto) as monto
						from factura_pagos
						where num_factura in ( select num_factura from factura where cod_cliente = '".$registro['cod_cliente']."')";
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				$abono = $registro3['monto'];
                echo number_format(($total - $abono),0,".",",");
				}
			else{
				$total = round(($registro['total_1']*(1+($registro['valor_iva']/100))));
				$sql3="SELECT sum(monto) as monto
						from factura_pagos
						where num_factura in ( select num_factura from factura where cod_cliente = '".$registro['cod_cliente']."')";
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				$abono = $registro3['monto'];
                echo number_format(($total - $abono),0,".",",");
				}	
			?>
        </div>
		<br class="clearFloat"/>
			<?php 
				//obra
				echo $sql_6 = "SELECT cod_arriendo , sum(tot_arriendo) + sum(total_rep) as total , valor_iva
						FROM factura
							inner join det_factura
								on factura.num_factura = det_factura.num_factura
						where cod_cliente = '".$registro['cod_cliente']."'
						";	
				$res_6 = mysql_query($sql_6,$conexion) or die(mysql_error());
				while ($row_6 = mysql_fetch_array($res_6)){
			?>
		<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
		</div>
		<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
		</div>
		<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
        	<?php
		if ((!empty($row_6['cod_arriendo']))||($row_6['cod_arriendo']!='0'))
		  {
			  $sql2="SELECT * FROM arriendo where cod_arriendo =".$row_6['cod_arriendo'];
			 
			  //obtener codigo de obra desde arriendo
			  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
			  $registro2 = mysql_fetch_array($res2);
			  $codobra=$registro2['cod_obra'];
			 
			  //obtener nombre de obra
			  $sql3="SELECT * FROM obra where cod_obra =".$registro2['cod_obra'];
			  $res3 = mysql_query($sql3,$link) or die(mysql_error());
			  $registro3 = mysql_fetch_array($res3);
			  echo($registro3['nombre_obra']);
		  }else{
			  echo("Sin Obra");
		  }
                ?>
		</div>
		<br class="clearFloat"/>
			<?php 
				//obra
				}
		}
}
else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}
?>
