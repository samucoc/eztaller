<?php ob_start(); 
session_start(); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />

<link rel="stylesheet" href="css/style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
var anteriorFilaSeleccionada = null;
function selecciona(fila){
    var celdasEnFila = fila.getElementsByTagName("TD");
	alert(celdasEnFila);
}
</script> 
<script type="text/javascript">
function asignar_valor(celda) {
  cod = celda.getElementsByTagName('td')[0].innerHTML;
  com = celda.getElementsByTagName('td')[1].innerHTML;
  cot = celda.getElementsByTagName('td')[2].innerHTML;
  
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_obra'].value = com;
  document.forms[0]['txt_equipo'].value = cot;
}
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write('<head><link href="css/style.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
				   	temp.document.write(c.innerHTML);
				   	temp.document.close();
					  
				   	var is_chrome = function () { return Boolean(temp.chrome); }
					if(is_chrome) {
							setTimeout(function () { // wait until all resources loaded 
								temp.print();  // change window to winPrint
					            temp.close();// change window to winPrint
					        }, 100);
						}
					else{
					   	temp.print();
					   	temp.close();
					}
			}

</script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo19 {	color: #999999;
	font-weight: bold;
}
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style> 
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
</head>
<body>
<table width="85%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturación - Vigomaq</span></div></td>
   </tr>
</table>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>	
<br class="clearFloat"/>
<div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12" style="padding:10px;">
  <div align="right" class="Estilo19">
    <div align="right" class="Estilo20">ARRIENDO - FACTURAS ABIERTAS</div>
  </div>
</div>
<div id="resultado" style="display:block"> 
    <div class=" floatLeft" style="width:20%;font-size:18px">Nro Factura</div>
    <div class="floatLeft" style="width:20%;font-size:18px">Nro Guia Despacho</div>
    <div class=" floatLeft" style="width:20%;font-size:18px">Razon Social</div>
    <div class=" floatLeft" style="width:40%;font-size:18px">Obra</div>
    <br class="clearFloat" />
    <?php 
			include("classes/conex.php");
			$link=Conectarse();

    		$sql = "select * from factura where estado = '' and num_factura < 100";
	   		$result=mysql_query($sql,$link) or die(mysql_error()); 
		while($row = mysql_fetch_array($result)){
	?>
		<div class=" floatLeft" style="width:20%;font-size:14px">
			<?php
				echo $row['num_factura'];
			?>
		</div>
    	<div class=" floatLeft" style="width:20%;font-size:14px">
			<?php
				$sqlgd   = "SELECT * FROM arriendo WHERE cod_arriendo ='".$row['cod_arriendo']."'";
			
					$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$num_gd     = $registrogd['num_gd'];
					if (empty ($num_gd)) {
						$sqlgd   = "SELECT * FROM factura WHERE num_factura ='".$row['num_factura']."'";
				
						$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
						$registrogd = mysql_fetch_array($resgd);
						if (empty($registrogd['gd_rep'])){
							$sqlgd   = "SELECT * 
										FROM equipos_arriendo
										WHERE cod_arriendo ='".$row['cod_arriendo']."'";
							$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
							$registrogd = mysql_fetch_array($resgd);
							$num_gd     = $registrogd['num_gd'];
							}
						else{
							$num_gd     = $registrogd['gd_rep'];
							}
					}
				echo $num_gd  ;
			?>
		</div>
    	<div class=" floatLeft" style="width:20%;font-size:14px">
    		<?php 
    			$sql3="SELECT * FROM clientes where cod_cliente =".$row['cod_cliente'];
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				echo($registro3['raz_social']);
	   		?>
    	</div>
    	<div class=" floatLeft" style="width:40%;font-size:14px">
    		  <?php
    		  	  $sql3="SELECT * FROM obra where cod_obra =".$row['cod_obra'];
				  $res3 = mysql_query($sql3,$link) or die(mysql_error());
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['nombre_obra']);
				?>
    	</div>
    	<br	class="clearFloat" />
   		<br	class="clearFloat" />
   		<?php 
   			$sql_1 = "SELECT * FROM `det_factura` where num_factura = ".$row['num_factura'];
   			$res_1 = mysql_query($sql_1,$link);
   			while ($row_1 = mysql_fetch_array($res_1)){
				$dias_arriendo = $row_1['dias_arriendo'];
				$dias_ajuste = $row_1['dias_ajuste'];
				$valor_unitario = $row_1['valor_unitario'];
				$total_rep = $row_1['total_rep'];
				$monto_otros = $row_1['monto_otros'];
				$cod_repuesto = $row_1['cod_repuesto'];
				$cod_equipo = $row_1['cod_equipo'];
				$porcentaje_vu = $row_1['porcentaje_vu'];
				if ($row_1['cod_equipo']==0) {
					?>
					<div class=" floatLeft" style="width:20%">
						<?php echo($row_1['cantidad']);?>
			    	</div>
			    	<div class=" floatLeft" style="width:20%">
						<?php if ($row_1['otros_reparacion']!='')
									echo utf8_decode($row_1['otros_reparacion']);
								else
									echo utf8_decode($row_1['observaciones']); 
						?>
			    	</div>
			    	<div class=" floatLeft" style="width:20%">
						<?php 
							if (!empty($row_1['valor_unitario']))
				   			  	echo "$".number_format($row_1['valor_unitario'], 0, ",", ".");
							else
							 	echo "$".number_format($row_1['precio'], 0, ",", ".");
						?>
			    	</div>
			    	<div class=" floatLeft" style="width:20%">
						<?php 
							if (!empty($row_1['cod_equipo'])){
								echo "$".number_format($valor, 0, ",", ".") ; 
							}else{ 
								if (!empty($row_1['total_rep'])){
									echo("$".number_format($row_1['total_rep'], 0, ",", ".")); 
									}
								else{
									echo("$".number_format($row_1['precio'], 0, ",", ".")); 
									}
								} 
						?>
			    	</div>
			    	<div class=" floatLeft" style="width:20%">
						<?php 
							if (!empty($row_1['cod_equipo'])){
								echo "$".number_format($valor, 0, ",", ".") ; 
							}else{ 
								if (!empty($row_1['total_rep'])){
									echo("$".number_format($row_1['total_rep'], 0, ",", ".")); 
									}
								else{
									echo("$".number_format($row_1['precio'], 0, ",", ".")); 
									}
							} 
						?>
			    	</div>
			    	<br	class="clearFloat" />

					<?php
					}
				else{
					?>

					<div class=" floatLeft" style="width:10%">
						<?php echo "Dias arriendo : ".$dias_arriendo?>
			    	</div>
			    	<div class=" floatLeft" style="width:30%">
						<?php 
							{
							  //BUSCAR FECHA DE ARRIENDO
								$sqlperiodo=" SELECT *
												FROM equipos_arriendo
													inner join gd
														on equipos_arriendo.cod_arriendo = gd.id_arriendo
													inner join factura 
														on factura.cod_arriendo = equipos_arriendo.cod_arriendo
													where equipos_arriendo.nro_factura = '".$row['num_factura']."'
														and equipos_arriendo.cod_equipo =".$cod_equipo." 
													order by equipos_arriendo.arrendado_hasta asc
												limit 0,1";
								$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
							  	$registroper = mysql_fetch_array($resperiodo); 
								  if (!empty($registroper['arrendado_hasta'])){ 
										$hasta = $registroper['arrendado_hasta']; 
									  }
								  else{ 
										$hasta = "NO DEVUELTO";
									  }
								  $sqlnomob="SELECT cod_equipo, nombre_equipo,valor_unidad_arr 
											FROM equipo where cod_equipo =".$cod_equipo;
								  $resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
								  $registronob = mysql_fetch_array($resnomob);
									
									$fecha_temp = explode("-",$registroper['arrendado_desde']);
									//año-mes-dia
									//0 -> dia, 1 -> mes, 2 -> año
									$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
									$fecha_factura_temp = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
				
									$fecha_temp = explode("-",$hasta);
									//año-mes-dia
									//0 -> dia, 1 -> mes, 2 -> año
									$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
									$hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
				
								  
								  echo(htmlentities($registronob['nombre_equipo'])." "." PERIODO: ".$fecha_factura_temp." --> ".$hasta);
								 }
						?>
			    	</div>
			    	<div class=" floatLeft" style="width:20%">
						<?php 
							if (!empty($cod_equipo)){
							 		$valor_u = $row_1['tot_arriendo']/$dias_arriendo;
								  	echo "$".number_format($valor_u, 0, ",", "."); 
									$valor=(($dias_arriendo)*($valor_u));
							  }else{
								  echo "$".number_format($valor_unitario, 0, ",", ".");
							  }			
			  			?>
			    	</div>
			    	<div class=" floatLeft" style="width:20%">
						<?php 
							if (!empty($cod_equipo)){
								echo "$".number_format($valor, 0, ",", ".") ; 
								
								}
							else{ 
								echo("$".number_format($total_rep, 0, ",", ".")/*($registro['total_rep'])*/); 
								$costo_tot= $costo_tot + $total_rep;}
						?>
			    	</div>
			    	<div class=" floatLeft" style="width:10%">
						<?php 
							$porcentaje_emitir = ($row_1['porcentaje_vu']);
				
				if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
					echo "0%";
					}
				else{
					echo $porcentaje_emitir."%";
					}
						?>
			    	</div>
			    	<div class=" floatLeft" style="width:10%">
						<?php 
						if (!empty($cod_equipo)){
			                  $valor_def = $row_1['tot_arriendo'];
			                  $costo_tot= $costo_tot + $valor_def; 
			                  echo "$".number_format($row_1['tot_arriendo'], 0, ",", ".");
									
									}
								else{ 
			                  $valor_def = $row_1['total_rep'];
			                  $costo_tot= $costo_tot + $valor_def; 
			                  echo "$".number_format($row_1['total_rep'], 0, ",", ".");
									}
						?>
			    	</div>
			    	<br	class="clearFloat" />



					<?php
					}
   		?>

   		<?php
   			}
   		?>
   		<br	class="clearFloat" />
		<hr	class="clearFloat" />

	<?php
		} 
	?>
           
</div>
<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('resultado');">

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>