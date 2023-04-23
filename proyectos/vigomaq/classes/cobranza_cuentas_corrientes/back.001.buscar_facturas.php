<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total , sum(total_rep) as total_1, oc_rep, estado
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
$saldo_total = 0;
?>
    <div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">N° Factura</div>
    <div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Emision</div>
    <div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Obra</div>
    <div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Valor Factura</div>
    <div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Orden Compra</div>
 	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Pago</div>
 	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Forma Pago</div>
 	<div  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Suma Abonos</div>
 	<div  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Saldo</div>
  	<div  class="floatLeft " style="padding: 8px;width: 8%; color: #000000 !important;">Estado</div>
  	<div  class="floatLeft " style="padding: 5px;width: 5%; color: #000000 !important;">Seleccion</div>
  	<br class="clearFloat"/>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <a id="vista-previa-factura" href="classes/facturar/cerrar-factura.php?num_fact=<?php echo $registro['num_factura']?>" target="_blank">
                        <?php echo $registro['num_factura']; ?>
            </a>
        </div>   
      	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
           <?php echo $registro['fecha']; ?>
        </div>   
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
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
        	<?php
		if ((!empty($registro['cod_arriendo']))||($registro['cod_arriendo']!='0'))
		  {
			  $sql2="SELECT * FROM arriendo where cod_arriendo =".$registro['cod_arriendo'];
			 
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
		<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
        	<?php  
			$total=0;
			if ($registro['total']>0)
				$total = $registro['total']; 
			else
				$total = $registro['total_1'];
			echo $total;
		?>
        </div>
		<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['oc_rep']); ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php 
			$sql3="SELECT fecha, tipo_pago
				FROM factura_pagos 
				where num_factura = '".$registro['num_factura']."'
				order by fecha desc";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			echo $registro3['fecha'];
		?>		
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php 
			$sql3="SELECT nombre
				FROM tipo_pagos 
				where tp_ncorr = '".$registro3['tipo_pago']."'";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			echo $registro3['nombre'];
		?>
        </div>
  	<div class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php //abonos
			$sql3="SELECT sum(monto) as monto
				from factura_pagos
				where num_factura = '".$registro['num_factura']."'";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			echo $abono = $registro3['monto'];
		?>
	</div>
  	<div class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php //saldo
			$saldo_total += ($total - $abono);
			echo ($total - $abono);
		?>
	</div>
  	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		 <a class="link_resumen" href="#" id="<?php echo $registro['num_factura']?>"><?php 
			$estado = $registro['estado'];
			if ($estado=='PROCESO_PAGO'){
			?>	
		<img src="images/cara_roja.jpg"/>
			<?php
			}elseif ($estado=='ABONANDO'){
			?>	
		<img src="images/cara_amarilla.jpg"/>
			<?php
			}else{
			?>	
		<img src="images/cara_verde.jpg"/>
			<?php
			}
		?>
        </a>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 5%; color: #000000 !important;">
          	<input type="checkbox" name="factura_<?php echo $registro['num_factura']?>" class="check_button" id="factura_<?php echo $registro['num_factura']?>" value="<?php echo $registro['num_factura']?>" title="Seleccionar" onclick="seleccionar('factura_<?php echo $registro['num_factura']?>')" />
           	<input type="hidden" name="txt_numfactura"  value="<?php echo $registro['num_factura']?>" />
    	</div>
  	<br class="clearFloat"/>
  <?php
	}
?>
	<div class="floatRight	" style="padding: 5px;width: 5%; color: #000000 !important;">
		<?php echo $saldo_total;?>
    	</div>
  	<div class="floatRight" style="padding: 5px;width: 8%; color: #000000 !important;">
		Saldo Total
	</div>
  	<br class="clearFloat"/>
<?php


}

else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}
?>
