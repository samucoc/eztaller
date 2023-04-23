<?php
include("../../conex.php");
		$link=Conectarse();
$sql = "SELECT *
FROM equipos_arriendo
	inner join equipo
		on equipo.cod_equipo = equipos_arriendo.cod_equipo
WHERE (estado_equipo_arr = 'DEVUELTO-NO FACTURADO' or estado_equipo_arr = 'NO DEVUELTO') 
and arrendado_desde > '2017-01-01'";


if ($_GET["num_gd"]!=""){
   	$txt_codigo = $_GET["num_gd"];
	if ($_GET["num_gd"]!='XXX'){
	   $sql .= " and equipos_arriendo.num_gd like '$txt_codigo%'";
   		}
	}

$sql .= " order by equipos_arriendo.num_gd, equipos_arriendo.estado_equipo_arr DESC";

$res=mysql_query($sql,$link);

?>
    <div class="Estilo17 nro_gd floatLeft">N. Guía Despacho</div>
    <div  class="Estilo17 raz_social floatLeft">Cliente (Razon Social)</div>
    <div  class="Estilo17 obra_gd floatLeft">Obra</div>
    <div class="Estilo17 est_equipo floatLeft" style="; width:18% !important">Estado Equipo</div>
    <div  class="Estilo17 accion_gd floatLeft">Equipo</div>
    <div  class="Estilo17 accion_gd floatLeft">Arriendo desde</div>
    <div  class="Estilo17 accion_gd floatLeft">Accion</div>
  	<br class="clearFloat"/>
    <?php
	$num_rows = mysql_num_rows($res);
	if ($num_rows>0){ 
	?>
    <div class="Estilo17 floatLeft" style="background-color:#FF0; color:#000; height: 45px ;width:98%; padding:10px; ">
         Equipos Facturables : <?php echo $num_rows?>
    </div>
    <br style="clear:both" />
    <?php
	while($registro=mysql_fetch_array($res)){ ?>
        <div class="Estilo17 nro_gd floatLeft" style="background-color:#FF0; color:#000; height: 45px">
            <?php echo $registro['num_gd']; ?>
        <input type="hidden" name="txt_arriendo"  value="<?php echo $registro['cod_arriendo']?>" />
        </div>   
      <?php 
			$query = "select distinct clientes.raz_social
						from equipos_arriendo 
							inner join arriendo
								on equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
							inner join clientes
								on arriendo.rut_cliente = clientes.rut_cliente
						where equipos_arriendo.cod_arriendo = ".$registro['cod_arriendo']."
							and equipos_arriendo.num_gd = ".$registro['num_gd']."
							and equipos_arriendo.cod_equipo = ".$registro['cod_equipo']."";
			$result=mysql_query($query,$link); 
			$row = mysql_fetch_array($result); ?>
            <div  class="Estilo17 raz_social floatLeft" style="background-color:#FF0; color:#000; height: 45px">
	            <?php echo $row['raz_social']; ?>
            </div>
    		<div  class="Estilo17 obra_gd floatLeft" style="background-color:#FF0; color:#000; height: 45px">
				<?php
                  if (!empty($registro['cod_arriendo']))
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
						  echo(" ");
					  }
                ?>
      			<input type="hidden" name="txt_obra"  value="<?php echo $registro2['cod_obra']?>" />
		    </div>
		    <div class="Estilo17 est_equipo floatLeft" style="background-color:#FF0; color:#000; height: 45px; width:18% !important">
				<?php  echo($registro['estado_equipo_arr']); ?>
            </div>
            <div  class="Estilo17 accion_gd floatLeft" style="background-color:#FF0; color:#000; height: 45px">
		    <?php  
			  if (!empty($registro['cod_equipo']))
				{
				  $sql4="SELECT cod_equipo,nombre_equipo FROM equipo where cod_equipo =".$registro['cod_equipo'];
				 
				  $res4 = mysql_query($sql4,$link) or die(mysql_error()); 
				  $registro4 = mysql_fetch_array($res4);
				  echo htmlentities($registro4['nombre_equipo']);
			   }else{
			 	  echo(" ");
			   }
			  ?>
            </div>
		    <div class="Estilo17 accion_gd floatLeft" style="background-color:#FF0; color:#000; height: 45px">
				<?php  
					list($anio,$mes,$dia) = explode('-',$registro['arrendado_desde']); 
					echo $dia.'-'.$mes.'-'.$anio;
				?>
            </div>
            <div  class="Estilo17 accion_gd floatLeft" style="background-color:#FF0; color:#000; height: 45px">
            	<a href='detalle_factura.php?codarr=<?php echo $registro['cod_arriendo'];?>&amp;equipo=<?php echo $registro4['cod_equipo']?>&amp;cod_obra=<?php echo $registro2['cod_obra'];?>&amp;num_gd=<?php echo $registro['num_gd']?>'>
              		<img src="images/gest_fin/factura.png" title="Facturar" width="32"/>
           		</a>
                <input type="hidden" name="txt_codequipo"  value="<?php echo $registro4['cod_equipo']?>" />
    		</div>

  <?php
}
	}
	else{
		?>
        <div class="Estilo17 floatLeft" style="background-color:#FF0; color:#000; height: 45px width:98%; padding:10px; ">
         Equipos no Facturables
        </div>
		<?php
		}
?>
