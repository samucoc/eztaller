<?php
include("../conex.php");
		$link=Conectarse();
$sql = "SELECT factura.num_factura, fecha, cod_arriendo,cod_cliente, 
		sum(tot_arriendo) as total , sum(total_rep) as total_1, oc_rep, estado, valor_iva
	FROM factura
		inner join det_factura
			on factura.num_factura = det_factura.num_factura";

if (isset($_GET['id_cliente'])){
	if ($_GET["id_cliente"]!=""){
			$sql .= " and cod_cliente like '".$_GET["id_cliente"]."'";
		}
	}

if (isset($_GET['estado'])){
	if ($_GET["estado"]!=""){
			if ($_GET["estado"]=="on"){
				$sql .= " and estado not in ('ABONANDO','PAGADO')";
			}
		}
	}

if ((isset($_GET['txt_desde']))&&(isset($_GET['txt_hasta']))){
	if (($_GET["txt_desde"]!="")&&($_GET["txt_hasta"]!="")){
		list($dia1,$mes1,$anio1) = explode('-', $_GET["txt_desde"]);
		$fecha_emision 	= $anio1.'-'.$mes1.'-'.$dia1;
		list($dia1,$mes1,$anio1) = explode('-', $_GET["txt_hasta"]);
		$fecha_fin 	= $anio1.'-'.$mes1.'-'.$dia1;
		$sql .= " and fecha between '".$fecha_emision."' and '".$fecha_fin."' ";
		}
	}
$sql .=" group by factura.num_factura, fecha, cod_arriendo";
$res=mysql_query($sql,$link) or die(mysql_error());

?>
	<table width="100%">
	<tr>
    <td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">N° Factura</td> 
    <td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Emision</td> 
    <td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Razon Social</td> 
    <td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Obra</td> 
    <td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Valor Factura</td> 
    <td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Orden Compra</td> 
 	<td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Fecha Compromiso</td> 
 	<td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Dias Atraso</td> 
  	<td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Estado</td> 
  	<td   class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Seleccion</td> 
  	</tr>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	while($registro=mysql_fetch_array($res)){ ?>
	<tr>        
	<td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <a id="vista-previa-factura" href="classes/facturar/cerrar-factura.php?num_fact=<?php echo $registro['num_factura']?>" target="_blank">
                        <?php echo $registro['num_factura']; ?>
            </a>
        </td>    
      	<td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php echo $registro['fecha']; ?>
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
        <td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php echo $row['raz_social']; ?>
        </td> 
        <td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
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
		<td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
        	<?php  if ($registro['total']>0)
				echo number_format(round(($registro['total']*(1+($registro['valor_iva']/100)))),0,".",","); 
			else
				echo number_format(round(($registro['total_1']*(1+($registro['valor_iva']/100)))),0,".",","); 
			?>
        </td> 
		<td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
            <?php  echo($registro['oc_rep']); ?>
        </td> 
        <td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php 
			$sql3="SELECT * 
				FROM  factura_eventos
				where num_factura =".$registro['num_factura']."
				order by fecha_diag desc
				limit 0,1";
			$res3 = mysql_query($sql3,$link) or die(mysql_error());
			$registro3 = mysql_fetch_array($res3);
			  
			echo $registro3['fecha_diag'];
		
			$sql_dif 		=	"SELECT DATEDIFF('".date('Y-m-d')."','".$registro3['fecha_diag']."') as dias_dif";
			$res_dif		=	mysql_query($sql_dif, $link);
			$dias_dif		=	@mysql_result($res_dif,0,"dias_dif");
		?>
        </td> 
        <td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php 
			echo $dias_dif;
		?>
        </td> 
  	<td  class="floatLeft" style="padding: 5px;width: 8%; color: #000000 !important;">
		<?php echo $estado = $registro['estado'];?> - 
        <a class="link_resumen" href="#" id="<?php echo $registro['num_factura']?>">
		<?php 
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
	</td> 
	<td  class="floatLeft" style="padding: 5px;width: 10%; color: #000000 !important;">
          	<input type="checkbox" name="factura_<?php echo $registro['num_factura']?>" class="check_button" id="factura_<?php echo $registro['num_factura']?>" value="<?php echo $registro['num_factura']?>" title="Seleccionar" onclick="seleccionar('factura_<?php echo $registro['num_factura']?>')" />
           	<input type="hidden" name="txt_numfactura"  value="<?php echo $registro['num_factura']?>" />
    	</td> 
  	</tr>
  <?php
	}
}
	
?>
</table>
