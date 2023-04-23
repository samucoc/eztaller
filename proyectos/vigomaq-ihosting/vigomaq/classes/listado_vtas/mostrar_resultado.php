<?php 
	include("../conex.php");
	$link = Conectarse();
	$rut_cliente = $_GET['rut_cliente'];
	$sqlcli = "SELECT raz_social FROM clientes WHERE rut_cliente = '".$rut_cliente."'";		

	$rescli = mysql_query($sqlcli,$link) or die(mysql_error()); 
	$registrocl = mysql_fetch_array($rescli);
	echo "<h3 style='padding-left:20px'>Cliente : ".($registrocl["raz_social"])."</h3>";

?>

<table align="center" width="100%">
      <tr>
        <td colspan="2"><table width="100%" border="0" align="center">
          <tr>
            <th width="14%" bgcolor="#06327D"><div align="center" class="Estilo17">N&deg; Factura </div></th>
            <th width="42%" bgcolor="#06327D"><div align="center" class="Estilo17">Cliente/Obra</div></th>
            <th width="19%" bgcolor="#06327D"><span class="Estilo17">Fecha</span></th>
            <th width="12%" bgcolor="#06327D"><span class="Estilo17">Total</span></th>
            <th width="13%" bgcolor="#06327D">&nbsp;</th>
          </tr>
            <?php 
			
			
			$sql = "select *
					from factura
						inner join clientes
							on clientes.cod_cliente = factura.cod_cliente
					where clientes.rut_cliente = '".$rut_cliente."'";
			$res = mysql_query($sql,$link) or die(mysql_error());
			
			while($registro=mysql_fetch_array($res))
{
?>	
          <tr>
            <td><input type="hidden" name="txt_numfactura"  value="<?php echo $registro['num_factura']?>" size="20" maxlength="30" />
              <?php echo $registro['num_factura']; ?></td>
            <td><?php
			      if (!empty($registro['cod_obra']))
					  {
						  $sql2="SELECT * FROM obra where cod_obra =".$registro['cod_obra'];
						
						  //obtener codigo de obra desde arriendo
						  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
						  $registro2 = mysql_fetch_array($res2);
						
					   if (!empty($registro2['nombre_obra'])){ echo($registro2['nombre_obra']);}//else{echo(" ");}
				 }else{
						$sqlcli = "SELECT raz_social, giro_cliente FROM clientes WHERE rut_cliente = '".$registro['rut_cliente']."'";		
				
						$rescli = mysql_query($sqlcli,$link) or die(mysql_error()); 
						$registrocl = mysql_fetch_array($rescli);
						echo($registrocl["raz_social"]);
					  }
					 
                  ?>
              <input type="hidden" name="txt_fecha"  value="<?php echo $registro2['fecha']?>" size="20" maxlength="30" /></td>
            <td><?php  echo($registro['fecha']); ?></td>
            <td align="right"><?php 
					
			        $sql_sumas   = "SELECT SUM(tot_arriendo) as total FROM det_factura where num_factura =".$registro['num_factura'];
					$res_sumas    = mysql_query($sql_sumas,$link) or die(mysql_error()); 
					$registroar = mysql_fetch_array($res_sumas);
					if ($registroar['total']>0){
						
						$monto_reparacion=$registroar['total'];
						$costo_tot = $costo_tot + ($registroar['total']); }
				
					
					$sql_suma    = "SELECT SUM(total_rep) as total2 FROM det_factura where num_factura =".$registro['num_factura'];
					$res_suma    = mysql_query($sql_suma,$link) or die(mysql_error()); 
					$registroarr = mysql_fetch_array($res_suma);
					if ($registroarr['total2']>0){
						
						$monto_reparacion=$registroarr['total2'];
						$costo_tot = $costo_tot + ($registroarr['total2']);}
					$sumados = 	$registroar['total'] + $registroarr['total2'];
					echo("$".number_format($sumados, 0, ",", "."));	
					
			  ?></td>
            <td align="center"><a href='ver_factura.php?num_fact=<?php echo $registro['num_factura'];?>' target="_blank">Ver</a></td>
          </tr>
          <tr>
            <td>---------------</td>
            <td>--------------------------------------------------------</td>
            <td>-------------------------</td>
            <td>------------------</td>
            <td>------------------</td>
          </tr>
          <!-- fin tabla resultados -->
          <?php
}//fin while

?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"><span class="CONT">
              <?php
				
				echo ("TOTAL : $".number_format($costo_tot, 0, ",", "."));
		 ?>
              <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
            </span></td>
          </tr>

        </table>
