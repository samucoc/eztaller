<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total , sum(total_rep) as total_1,
		oc_rep, estado, fecha_recepcion, lugar_recepcion, valor_iva
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura";

if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			$sql .= " and cod_cliente like '".$_GET["id_cliente"]."'";
		}
	}

$sql .=" group by factura.num_factura, fecha, cod_arriendo";
$res=mysql_query($sql,$link) or die(mysql_error());

?>
    <table width="100%">
	<tr>	
	<td   class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">N° Factura</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Fecha Emision</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Lugar Recepcion</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Fecha Recepcion</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Razon Social</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Obra</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Valor Factura</td> 
    <td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Orden Compra</td> 
  	<td   class="floatLeft " style="padding: 5px;width: 9%; color: #000000 !important;">Vendedor</td> 
  	<td   class="floatLeft " style="padding: 5px;width: 7%; color: #000000 !important;">Estado</td> 
  	<td   class="floatLeft " style="padding: 5px;width: 3%; color: #000000 !important;">Seleccion</td> 
  	</tr>
    <?php
	if (mysql_num_rows($res)>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
	<tr>
        <td  class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
		<a id="vista-previa-factura" href="classes/facturar/cerrar-factura.php?num_fact=<?php echo $registro['num_factura']?>" target="_blank">
                        <?php echo $registro['num_factura']; ?>
        	</a>
        </td>    
      	<td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
            <?php 
		list($anio,$mes,$dia) = explode('-', $registro['fecha']); 
		echo $dia.'-'.$mes.'-'.$anio;
		?>
        </td>    
      	<td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
            <?php if ($registro['lugar_recepcion']==''){		
			echo "Sin Lugar";
			}
			else{
			$sql_1 = "select * 
				from lugar_entrega 
				where le_ncorr = '".$registro['lugar_recepcion']."'";
			$res_1 = mysql_query($sql_1,$link) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			echo $row_1['nombre'];
			}
		?>
        </td>    
      	<td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
            <?php list($anio,$mes,$dia) = explode('-', $registro['fecha_recepcion']); 
		echo $dia.'-'.$mes.'-'.$anio;
		?>
        </td>    
      		<?php 
			$query = "select distinct clientes.raz_social
					from arriendo
						inner join clientes
							on arriendo.rut_cliente = clientes.rut_cliente
					where arriendo.cod_arriendo = ".$registro['cod_arriendo']."";
			$result=mysql_query($query,$link) or die(mysql_error()); 
			if (mysql_num_rows($result)==0){
				$query = "select distinct clientes.raz_social
						from clientes
					 where clientes.cod_cliente = ".$registro['cod_cliente']."";
				$result=mysql_query($query,$link) or die(mysql_error()); 
			}
			$row = mysql_fetch_array($result); ?>
        <td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
		<?php echo $row['raz_social']; ?>
        </td> 
        <td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
        	<?php
		if ((!empty($registro['cod_arriendo']))||($registro['cod_arriendo']!='0'))
		  {
			  $sql2="SELECT * FROM arriendo where cod_arriendo =".$registro['cod_arriendo'];
			 
			  //obtener codigo de obra desde arriendo
			  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
			  $registro2 = mysql_fetch_array($res2);
			  $codobra=$registro2['cod_obra'];
			 
			  //obtener nombre de obra
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
	<td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
        	<?php  if ($registro['total']>0)
				echo number_format(round(($registro['total']*(1+($registro['valor_iva']/100)))),0,".",","); 
			else
				echo number_format(round(($registro['total_1']*(1+($registro['valor_iva']/100)))),0,".",","); 
			?>
        </td> 
		<td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
            <?php  echo($registro['oc_rep']); ?>
        </td> 
        <td  class="floatLeft" style="padding: 5px;width: 9%; color: #000000 !important;">
            <?php  
            $sql2="select concat(nombres_personal,' ',ap_patpersonal,' ',ap_matpersonal) as nombre 
            		from personal 
            		where cod_personal in (SELECT cod_personal FROM arriendo where cod_arriendo =".$registro['cod_arriendo'].")";
            	
            $res2 = mysql_query($sql2,$link) or die(mysql_error());
            $registro2 = mysql_fetch_array($res2);
            $codobra=$registro2['nombre'];
            ?>
        </td> 
  	<td  class="floatLeft" style="padding: 5px;width: 7%; color: #000000 !important;">
		<?php 
			$estado = $registro['estado'];
			if ($estado=='RECHAZADA'){
			?>	
		<img src="images/cara_roja.jpg" title="<?php echo $estado?>" alt="<?php echo $estado?>"/>
			<?php
			}elseif ($estado=='RECIBIDA'){
			?>	
		<img src="images/cara_amarilla.jpg" title="<?php echo $estado?>" alt="<?php echo $estado?>"/>
			<?php
			}
		?>
	</td> 
	<td  class="floatLeft" style="padding: 5px;width: 3%; color: #000000 !important;">
          	<input type="checkbox" name="facturar" class="check_button" id="<?php echo $registro['num_factura']?>" value="<?php echo $registro['num_factura']?>" title="Seleccionar" onclick="seleccionar(<?php echo $registro['num_factura']?>)"/>
           	<input type="hidden" name="txt_numfactura"  value="<?php echo $registro['num_factura']?>" />
    	</td> 
  	</tr>
  <?php
	}
}
else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}	
?>
</table>
