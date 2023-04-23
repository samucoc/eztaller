<?php
include("../conex.php");
$link=Conectarse();
		
$nombre_equipo = $_GET['nombre_equipo'];

$temp = str_replace(' inch. ',"\"",$nombre_equipo);
$nombre_equipo = str_replace('o.',"º",$temp);
	
$sqleval   = "SELECT * 
				FROM eval_tecnica 
				WHERE cod_equipo  = '$nombre_equipo'";
				 
$reseval   = mysql_query($sqleval,$link) or die(mysql_error()); 
?>
    <div class="floatLeft" style="padding:10px; width:10%">Nombre Equipo</div>
    <div class="floatLeft" style="padding:10px; width:10%">Estado Equipo</div>
    <div class="floatLeft" style="padding:10px; width:10%">Tipo Evaluación</div>
    <div class="floatLeft" style="padding:10px; width:10%">Forma Evaluación</div>
    <div class="floatLeft" style="padding:10px; width:10%">Fecha</div>
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
					where cod_estado_equipo	= '".$row['cod_estado_equipo']."'";
		$res_0 = mysql_query($sql_0,$link);
		$row_0 = mysql_fetch_array($res_0);
		echo htmlentities($row_0['descripcion_estado']);
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
		<?php 
		$sql_1 = "SELECT *
					FROM `tipo_evaluacion`
					where cod_tipoeval = '".$registro1['cod_tipoeval']."'";
		$res_1 = mysql_query($sql_1,$link);
		$row_1 = mysql_fetch_array($res_1);
		echo htmlentities($row_1['tipo_evaluar']);
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<?php 
		$sql_1 = "SELECT *
					FROM `forma_evaluacion`
					where cod_formaeval  = '".$registro1['cod_formaeval']."'";
		$res_1 = mysql_query($sql_1,$link);
		$row_1 = mysql_fetch_array($res_1);
		echo htmlentities($row_1['forma_evaluar']);
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<?php 
		echo $registro1['fecha_evaluacion'];	
		?>
    </div>
    <div class="floatLeft" style="padding:10px; width:10%">
    	<a href="consulta_ev_tec.php?id=<?php echo $registro1['cod_eval_tecnica']?>">Detalle</a>	
    </div>
	<br class="clearFloat"/>
<?php }?>