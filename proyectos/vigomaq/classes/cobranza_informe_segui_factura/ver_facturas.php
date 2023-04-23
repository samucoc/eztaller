<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, sum(tot_arriendo) as total , sum(total_rep) as total_1, 	
		DATE_FORMAT(fecha,'%d-%m-%Y') as fecha,
		DATE_FORMAT(fecha_entrega,'%d-%m-%Y') as fecha_entrega,
		DATE_FORMAT(fecha_recepcion,'%d-%m-%Y') as fecha_recepcion,
		DATE_FORMAT(fecha_proceso_pago,'%d-%m-%Y') as fecha_proceso_pago
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura
	";

if ((isset($_GET['mes_1']))&&(isset($_GET['anio_1']))&&(isset($_GET['mes_2']))&&(isset($_GET['anio_2']))){
	if (($_GET["mes_1"]!="")&&($_GET["anio_1"]!="")&&($_GET["mes_2"]!="")&&($_GET["anio_2"]!="")){
			$fecha_1 = $_GET["anio_1"].'-'.$_GET["mes_1"].'-1';
			$fecha_2 = date("Y-m-d",mktime(0,0,0,$_GET["mes_2"]+1,1,$_GET["anio_2"]));
			$sql .= " and fecha >= '".$fecha_1."' and fecha < '".$fecha_2."' ";
		}
	}

$sql .=" group by factura.num_factura, fecha";
$res=mysql_query($sql,$link) or die(mysql_error());

?>
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
		<?php echo $registro['fecha']; ?>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
	<?php 
		if ($registro['fecha_entrega']!='00-00-0000')echo $registro['fecha_entrega'];
	?>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
	<?php 
		if ($registro['fecha_recepcion']!='00-00-0000')echo $registro['fecha_recepcion'];
	?>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
	<?php 
		if ($registro['fecha_proceso_pago']!='00-00-0000')echo $registro['fecha_proceso_pago'];	
	?>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
	<?php 
			$sql3="SELECT DATE_FORMAT(fecha,'%d-%m-%Y') as fecha
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
		$sql1="SELECT DATE_FORMAT(fecha_log,'%d-%m-%Y') as fecha_log	
			FROM  factura_logs
			where num_factura =".$registro['num_factura']."
				and estado_posterior = 'PAGADO'
		";
		$res1 = mysql_query($sql1,$link) or die(mysql_error());
		$row4 = mysql_fetch_array($res1); 
		echo $row4['fecha_log'];
	?>
	</div>
  	<br class="clearFloat"/>

  <?php
	}
}else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}

