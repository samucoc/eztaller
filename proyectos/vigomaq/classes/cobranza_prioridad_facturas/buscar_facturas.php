<?php
include("../conex.php");
$link=Conectarse();
$sql = "SELECT distinct factura.cod_cliente,(sum(tot_arriendo) + sum(total_rep)) -  COALESCE( sum( monto ) , 0 )  as total
		FROM factura
			inner join det_factura
				on factura.num_factura = det_factura.num_factura
			left join factura_pagos
				on  factura_pagos.num_factura = factura.num_factura
			inner join clientes
				on clientes.cod_cliente = factura.cod_cliente
		";

//id_cliente='+id_cliente+'&cant_dias='+cant_dias+'&todas='+todas,
if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			//$sql .= " and factura.cod_cliente = '".$_GET["id_cliente"]."'";
		}
	}
$sql .= " group by raz_social 
		  having (sum(tot_arriendo) + sum(total_rep)) -  COALESCE( sum( monto ) , 0 ) > 0 
		  order by raz_social asc ";
//echo $sql;
$res=mysql_query($sql,$link) or die(mysql_error());
?>
<table width="100%">
	<tr>	
		<td class="floatLeft " style="padding: 5px;width: 15%; color: #000000 !important;">Hora Sistema</td>
		<td class="floatLeft " style="padding: 5px;width: 15%; color: #000000 !important;" colspan="3"><?php echo date("d-m-Y H:i:s")?></td>
    </tr>
    <tr>	
		<td class="floatLeft " style="padding: 5px;width: 15%; color: #000000 !important;">Raz&oacute;n Social</td>
		<td class="floatLeft " style="padding: 5px;width: 15%; color: #000000 !important;">Estado</td>
	    <td class="floatLeft " style="padding: 5px;width: 15%; color: #000000 !important;">Fecha Ultima Revision</td>
	    <td class="floatLeft " style="padding: 5px;width: 15%; color: #000000 !important;">Ver Cuenta Corriente</td>
    </tr>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ 
	  	
			$query = "select distinct clientes.raz_social
						from clientes
					 where clientes.cod_cliente = ".$registro['cod_cliente']."";
			$result=mysql_query($query,$link) or die(mysql_error()); 
			$row = mysql_fetch_array($result); 
	?>
    <tr>
        <td class="floatLeft" style="padding: 5px;width: 15%; color: #000000 !important;">
			<?php echo $row['raz_social']; ?>
        </td>
		<td class="floatLeft" style="padding: 5px;width: 15%; color: #000000 !important;">
			<?php 
				$query_fr = "select fecha_revision as fecha
						from factura_revision_log
					 where cod_cliente = ".$registro['cod_cliente']." and fecha_revision >= '".date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d"),date("Y")))."' 
					 order by fecha_revision desc 
					 limit 0,1";
				$result_fr=mysql_query($query_fr,$link) or die(mysql_error()); 
				$num_rows_fr = mysql_num_rows($result_fr);
				if ($num_rows_fr>0){
					?>
					<img src="images/cara_verde.jpg"/>
					<?php
					}		
				else{
					?>
					<img src="images/cara_roja.jpg"/>
					<?php
					}
			?>
		</td>
		<td class="floatLeft" style="padding: 5px;width: 15%; color: #000000 !important;">
			<?php 
				$query = "select DATE_FORMAT(fecha_revision,'%d-%m-%Y %h:%i %p') as fecha
						from factura_revision_log
					 where cod_cliente = ".$registro['cod_cliente']."
					 order by fecha_revision desc 
					 limit 0,1";
				$result=mysql_query($query,$link) or die(mysql_error()); 
				$row = mysql_fetch_array($result); 
				echo $row['fecha'];
			?>
		</td>
		<td class="floatLeft" style="padding: 5px;width: 15%; color: #000000 !important;">
			<a href='cobranza_cuentas_corrientes.php?id_cliente=<?php echo $registro['cod_cliente'] ?>&volver=SI' title='Ir a Cuenta Corriente'>Ir a Cuenta Corriente</a>
		</td>
	</tr>
<?php } }
?>
</table>
