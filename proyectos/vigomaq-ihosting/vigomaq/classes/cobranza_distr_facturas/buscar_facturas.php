<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total ,sum(total_rep) as total_1, oc_rep, valor_iva
FROM factura
	inner join det_factura
		on factura.num_factura = det_factura.num_factura";

//id_cliente='+id_cliente+'&cant_dias='+cant_dias+'&todas='+todas,
if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			$sql .= " and cod_cliente like '".$_GET["id_cliente"]."'";
		}
	}

if (isset($_GET['cant_dias'])){
	if ($_GET["cant_dias"]!=""){
			$f_cd 		= mktime(0, 0, 0, date("m") , date("d")+$_GET["cant_dias"], date("Y"));
			$sql .= " and fecha <= '".date("Y-m-d",$f_cd)."'";
		}
	}
$sql .=" group by factura.num_factura, fecha, cod_arriendo";
$res=mysql_query($sql,$link) or die(mysql_error());

?>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">N° Factura</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Tipo Factura</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Fecha Emisi&oacute;n</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Raz&oacute;n Social</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Obra</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Valor Factura</div>
    <div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Orden Compra</div>
  	<div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">Vendedor</div>
  	<div  class="floatLeft " style="padding: 5px;width: 10%; color: #000000 !important;">
    	<input type="checkbox" name="seleccion[]" id="seleccion" onclick="cambiar()"/>
    </div>
  	<br class="clearFloat"/>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            <a id="vista-previa-factura" href="classes/facturar/cerrar-factura.php?num_fact=<?php echo $registro['num_factura']?>" target="_blank">
            <?php echo $registro['num_factura']; ?>
	    </a>
        </div>   
      	<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            <?php 
		if ($registro['cod_arriendo']==0){
			echo "Venta";
			}
		else {
			echo "Arriendo";
			}?>
        </div>   
      	<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            <?php 
		list($anio,$mes,$dia) = explode('-',$registro['fecha']);
		echo $dia.'-'.$mes.'-'.$anio;
	    ?>
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
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
		<?php echo $row['raz_social']; ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
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
			  if ($registro2['cod_obra']!='') {
   			  	  $res3 = mysql_query($sql3,$link) or die(mysql_error());
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['nombre_obra']);
				  }
			  else{
			  	  echo("Sin Obra");
		  	  }
		  }else{
			  echo("Sin Obra");
		  }
                ?>
		</div>
	<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
        	<?php  if ($registro['total']>0)
				echo number_format(round(($registro['total']*(1+($registro['valor_iva']/100)))),0,".",","); 
			else
				echo number_format(round(($registro['total_1']*(1+($registro['valor_iva']/100)))),0,".",","); 
			?>
        </div>
		<div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            <?php  echo($registro['oc_rep']); ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
            <?php  
            $sql2="select concat(nombres_personal,' ',ap_patpersonal,' ',ap_matpersonal) as nombre 
            		from personal 
            		where cod_personal in (SELECT cod_personal FROM arriendo where cod_arriendo =".$registro['cod_arriendo'].")";
            	
            $res2 = mysql_query($sql2,$link) or die(mysql_error());
            $registro2 = mysql_fetch_array($res2);
            echo $codobra=$registro2['nombre'];
            ?>
        </div>
        <div class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
          	<input type="checkbox" name="facturar[]" class="check_button" id="<?php echo $registro['num_factura']?>" value="<?php echo $registro['num_factura']?>" title="Seleccionar" onclick="seleccionar(<?php echo $registro['num_factura']?>)"/>
           	<input type="hidden" name="txt_numfactura"  value="<?php echo $registro['num_factura']?>" />
    	</div>
  	<br class="clearFloat"/>
  <?php
	}
	$sql_1 = "SELECT count(factura.num_factura) as contador
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura
	";
	if (isset($_GET['id_cliente'])){
		if ($_GET["id_cliente"]!=""){
				$sql_1 .= " and cod_cliente like '".$_GET["id_cliente"]."'";
			}
		}
	
	if (isset($_GET['cant_dias'])){
		if ($_GET["cant_dias"]!=""){
				$f_cd 		= mktime(0, 0, 0, date("m") , date("d")+$_GET["cant_dias"], date("Y"));
				$sql_1 .= " and fecha <= '".date("Y-m-d",$f_cd)."'";
			}
		}
	$res_1=mysql_query($sql_1,$link) or die(mysql_error());
	while ($row_1 = mysql_fetch_array($res_1)){
		?>		
    <div class="floatRight" style="padding-left:80%; width: 20%; color: #000000 !important;">
		Total Facturas : <?php echo $row_1['contador']?>
   	</div>
  	<br class="clearFloat"/>

		<?php
		}
}
else{

	echo "<h2 align='center'>Sin movimientos</h2>";

}
?>
