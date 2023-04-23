<?php
include("../conex.php");
$link=Conectarse();
		
$nombre_equipo = $_GET['nombre_equipo'];

$temp = str_replace(' inch. ',"\"",$nombre_equipo);
$nombre_equipo = str_replace('o.',"º",$temp);
	
$sqleval   = "SELECT *
				FROM `reparacion_equipos`
				WHERE cod_equipo  = '$nombre_equipo'";
				 
$reseval   = mysql_query($sqleval,$link) or die(mysql_error()); 
?>
    <div class="floatLeft" style="padding:10px; width:10%">Nombre Equipo</div>
    <div class="floatLeft" style="padding:10px; width:10%">Estado Equipo</div>
    <div class="floatLeft" style="padding:10px; width:10%">Detalle</div>
    <div class="floatLeft" style="padding:10px; width:10%">Fecha</div>
    <div class="floatLeft" style="padding:10px; width:10%">Valor</div>
    <div class="floatLeft" style="padding:10px; width:10%">Accion</div>
    <br class="clearFloat"/>
<?php
while ($registro1 = mysql_fetch_array($reseval)){
?>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<?php 
		$sql = "select nombre_equipo, cod_estado_equipo
				FROM  equipo
				WHERE (cod_equipo = '$nombre_equipo')
			";
		$res = mysql_query($sql,$link);
		$row = mysql_fetch_array($res);
		echo htmlentities($row['nombre_equipo']);
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<?php 
		$sql_0 = "SELECT *
					FROM `estado_equipo`
					where cod_estado_equipo	= '".$registro1['cod_estado_equipo']."'";
		$res_0 = mysql_query($sql_0,$link);
		$row_0 = mysql_fetch_array($res_0);
		echo htmlentities($row_0['descripcion_estado']);
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
		<?php 
		echo $registro1['detalle_reparacion'];	
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<?php 
		echo $registro1['fecha_reparacion'];	
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<?php 
		echo $registro1['valor_reparacion'];
			?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<a href="consulta_rep.php?id=<?php echo $registro1['cod_reparacion']?>">Detalle</a>	
    </div>
	<br class="clearFloat"/>
<?php }?>