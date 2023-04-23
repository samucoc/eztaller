<?php
include("../conex.php");
		$link=Conectarse();
$sql = "select *
		from factura_entregas
		where 1";
if (isset($_GET['id'])){
	if ($_GET["id"]!=""){
		$sql .= " and fe_ncorr = ".$_GET['id'];
		}
	}
if ((isset($_GET['txt_desde']))&&(isset($_GET['txt_hasta']))){
	if (($_GET["txt_desde"]!="")&&($_GET["txt_hasta"]!="")){
		list($dia1,$mes1,$anio1) = explode('-', $_GET["txt_desde"]);
		$fecha_emision 	= $anio1.'-'.$mes1.'-'.$dia1;
		list($dia1,$mes1,$anio1) = explode('-', $_GET["txt_hasta"]);
		$fecha_fin 	= $anio1.'-'.$mes1.'-'.$dia1;
		$sql .= " and fecha_entrega between '".$fecha_emision."' and '".$fecha_fin."' ";
		}
	}

$res=mysql_query($sql,$link) or die(mysql_error());

?>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">N° Guia</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Recibe</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Fecha - Hora Entrega</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Entrega</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Detalle</div>
  	<br class="clearFloat"/>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
             	<a href="classes/cobranza_distr_facturas/comprobante_gi.php?id=<?php echo $registro['fe_ncorr']?>" target='_blank'>
			<?php echo $registro['fe_ncorr']?>
		</a>
        </div>   
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
		<?php $sql_1 = "SELECT nombres_personal,ap_patpersonal,ap_patpersonal
		FROM personal 
		where cod_personal = '".$registro['cod_vendedor_entrega']."'";
			$res_1 = mysql_query($sql_1,$link) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			echo $nombres = $row_1['nombres_personal'].' '.$row_1['ap_patpersonal'].' '.$row_1['ap_patpersonal'];
			?>
        </div>   
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
		<?php 
			$fecha =  $registro['fecha_entrega']; 
			list($anio,$mes,$dia) = explode('-',$fecha);
			echo $fecha = $dia.'-'.$mes.'-'.$anio.' '.$registro['hora_entrega'];
		?>          
        </div>   
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            	<?php
			echo $registro['quien_entrega'];
		?>
        </div>   
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            	<?php 
			echo $registro['facturas'];
		?>
        </div>   
	<br class="clearFloat"/>
  <?php
	}
}
else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}
?>
