<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT *
	FROM factura_garantias
	where 1
	";

if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			$sql .= " and rut_cliente like '".$_GET["id_cliente"]."'";
		}
	}
if ((isset($_GET['txt_desde']))&&(isset($_GET['txt_hasta']))){
	if (($_GET["txt_desde"]!="")&&($_GET["txt_hasta"]!="")){
		list($dia1,$mes1,$anio1) = explode('-', $_GET["txt_desde"]);
		$fecha_emision 	= $anio1.'-'.$mes1.'-'.$dia1;
		list($dia1,$mes1,$anio1) = explode('-', $_GET["txt_hasta"]);
		$fecha_fin 	= $anio1.'-'.$mes1.'-'.$dia1;
		

			$sql .= " and fecha_venc between '".$fecha_emision."' and '".$fecha_fin."' ";
		}
	}
//echo $sql;
$res=mysql_query($sql,$link) or die(mysql_error());

?>
    	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Razon Social</div>
    	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Tipo Documento</div>
    	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Banco</div>
    	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Girador</div>
 	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">N° Documento</div>
 	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Emision</div>
 	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Vencimiento</div>
 	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Valor</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Estado</div>
  	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Seleccion</div>
  	<br class="clearFloat"/>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
       	<?php 
				$query = "select distinct clientes.raz_social
						from clientes
					 where clientes.cod_cliente = ".$registro['rut_cliente']."";
				$result=mysql_query($query,$link) or die(mysql_error()); 
			$row = mysql_fetch_array($result); ?>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php echo $row['raz_social']; ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
        	<?php
			$sql2="SELECT nombre FROM tipo_documentos where td_ncorr =".$registro['tipo_documento'];
			$res2 = mysql_query($sql2,$link) or die(mysql_error()); 
			$registro2 = mysql_fetch_array($res2);
			echo $registro2['nombre'];
		?>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php  			
			$sql2="SELECT nombre FROM bancos where banco_ncorr =".$registro['banco_emisor'];
			$res2 = mysql_query($sql2,$link) or die(mysql_error()); 
			$registro2 = mysql_fetch_array($res2);
			echo $registro2['nombre'];
		?>
        </div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['rut_girador'].' - '.$registro['nombre_girador']); ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['nro_documento']); ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['fecha_emision']); ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['fecha_venc']); ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  	echo number_format($registro['valor'],0,".",","); ?>
        </div>
  	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php echo $registro['estado']?>
	</div>
	<div class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
          	<input type="checkbox" name="facturar" class="check_button" id="<?php echo $registro['id_garantia']?>" value="<?php echo $registro['id_garantia']?>" title="Seleccionar" onclick="seleccionar(<?php echo $registro['id_garantia']?>)"/>
           	<input type="hidden" name="txt_numfactura"  value="<?php echo $registro['id_garantia']?>" />
    	</div>
  	<br class="clearFloat"/>
  <?php
	}
}
	
?>
