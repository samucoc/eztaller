<?php ob_start(); 
session_start(); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
require_once('classes/tc_calendar.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="imagetoolbar" content="no" />
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>

<link rel="stylesheet" href="style.css" type="text/css" />
<script language="JavaScript">
<!--
var nav4 = window.Event ? true : false;
function acceptNum(evt){	
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
var key = nav4 ? evt.which : evt.keyCode;	
return (key <= 13 || (key >= 48 && key <= 57));
}
//-->
</script>
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
<!--
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo24 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.Estilo25 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); .Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
    </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2 Estilo25"><br />
       <br />
       <br />
       <span class="Estilo23">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
</table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="95%" border="0" align="center">
  <tr>
    <td height="592"><table width="100%" border="0" align="center">
      <tr>
        <td width="80%" ><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php
			include("classes/conex.php");
			$link=Conectarse();

				$num_factura =  $_POST["txt_factura"];
				if (!isset($_POST["txt_factura"])) $num_factura =  $_GET["num_fact"];
			
				
				$cod_obra    = $_GET["cod_obra"];
				$cod_arr     = $_GET["codarr"];
				$valor1      = $_GET["equipo"];
			
				if (!empty($num_factura))
				{
				
					$link=Conectarse();
					//busca factura
					$sqlfact    = "SELECT * from factura WHERE num_factura ='$num_factura'";
				 	
					$res         = mysql_query($sqlfact,$link) or die(mysql_error()); 
					$registro    = mysql_fetch_array($res);
					$cod_cliente = $registro['cod_cliente'];
					$num_arriendo= $registro['cod_arriendo'];
					$fact_estado = $registro['estado'];
					$numero_factu= $registro['num_factura'];
					
					if (!empty($numero_factu)){
						//buscar cliente
						$sqlcli   = "SELECT * from clientes WHERE cod_cliente ='$cod_cliente'";
				
						$rescli       = mysql_query($sqlcli,$link) or die(mysql_error()); 
						$registrocli = mysql_fetch_array($rescli);
						$cliente     = $registrocli['raz_social'];	
						
						//num gd
						$sqlgd   = "SELECT * from arriendo WHERE cod_arriendo ='$num_arriendo'";
				
						$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
						$registrogd = mysql_fetch_array($resgd);
						$num_gd     = $registrogd['num_gd'];
						if (empty ($num_gd))
						{
							$sqlgd   = "SELECT * from factura WHERE num_factura ='$num_factura'";
					
							$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
							$registrogd = mysql_fetch_array($resgd);
							$num_gd     = $registrogd['gd_rep'];
						}
					}else{
						echo "<script>alert('Factura No Encontrada');</script>";
					}
				}
		 ?>
            ELIMINAR FACTURA</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><form method="post" enctype="multipart/form-data" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td colspan="6" height="8"></td>
            </tr>
            <tr>
              <td colspan="6" bgcolor="#06327D"><span class="Estilo24">DATOS FACTURA</span><span class="Estilo24">-ELIMINAR
                  <div align="right">
                  <?php  $fecha = date ("d-m-Y"); echo($fecha);//echo date ( "j - n - Y" );?>
                </div>
              </span></td>
            </tr>
            <tr>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td width="17%">N&deg; Factura</td>
              <td>:</td>
              <td width="23%"><span class="Estilo24">
                <input name="txt_factura" type="text"onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['num_factura'])) {echo ($registro['num_factura']);}else{echo($_POST["txt_factura"]) ;}// echo($_POST['txt_factura']);?>" size="10" maxlength="10" />
                
                <input type="submit" name="buscarfactura" value="Buscar" title="Buscar Factura" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
                
                <!--<input type="image" name="buscarfactura" value="Buscar" title="Buscar Factura" class="searchbutton" src="images/ver.png"/>-->A</span></td>
              <td width="11%" height="8"  align="right">Fecha Emision</td>
              <td width="36%" height="8"><div align="left">
                <input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registro['fecha'])) {echo ($registro['fecha']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha'];?>" size="10" maxlength="10" disabled="disabled"/></div></td>
              <td width="11%" class="Estilo25"><strong>
                <?php if ($fact_estado=="NULA") echo"NULA"; ?>
              </strong></td>
            </tr>
            <tr>
              <td><div align="left">Cliente</div></td>
              <td>:</td>
              <td colspan="3"><input name="txt_cliente" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?>" size="100" maxlength="100" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td>:</td>
              <td colspan="3"><input name="txt_giro" type="text" value="<?php if (!empty($registrocli['giro_cliente'])) {echo ($registrocli['giro_cliente']);}else{echo($_GET['txt_giro']);}?>" size="100" maxlength="100" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td width="2%">:</td>
              <td colspan="3"><input name="txt_direcc" type="text" value="<?php if (!empty($registrocli['direcc_cliente'])) {echo ($registrocli['direcc_cliente']);}else{echo($_GET['txt_direcc']);}?>" size="100" maxlength="100" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registrocli['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registrocli['cod_ciudad'];
						 
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?>" size="100" maxlength="100" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Comuna</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_comuna" type="text" value="<?php
			   if (!empty($registrocli['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registrocli['cod_comuna'];
						  
						  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
						  $registrocom = mysql_fetch_array($rescom);
						  echo($registrocom['comuna']);
					  }else{
						  echo(" ");
					  } ; ?>" size="100" maxlength="100" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Tel&eacute;fono</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_fono" type="text" value="<?php if (!empty($registrocli['fono_cliente'])) {echo ($registrocli['fono_cliente']);}else{echo($_GET['txt_fono']);}?>" size="8" maxlength="8" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Guia despacho </td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_numgd" type="text" value="<?php if (!empty($num_gd)){echo ($num_gd);}?>" size="10" maxlength="10" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Condiciones envio</div></td>
              <td>:</td>
              <td colspan="3" align="left"><textarea name="txt_condic" cols="100" rows="5" disabled="disabled"><?php if (!empty($registrocli['cond_env_fact'])) {echo ($registrocli['cond_env_fact']);}else{echo($_GET['txt_condic']);}?></textarea></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
              <td><?php if ($registro['estado']=='NULA'){
				  echo "<h3>Factura ".$registrogd['estado']."</h3>";
				  }?></td>
              <td colspan="2" align="right">&nbsp;</td>
              <td align="right">
              
                <input type="submit" name="borrar" id="button" value="Borrar" title="Eliminar factura" src="images/anular_fact.png" style="background-image:url(images/anular_fact.png); width:48px; height:48px;" class="formato_boton"/>
              <a href="eliminar_factura.php" class="menulink">
                <input type="submit" name="Limpiar" value="Limpiar"  title="Limpiar" style="background-image:url(images/clean.png); width:64px; height:64px" class="formato_boton"/>
               </a></td>
              <td><a href="menu.php" onmouseover="Volver"><img src="images/volver.png" width="40" height="40" align="right" title="Volver Menu Principal" border="0"/></a></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table>
      <table width="100%" border="0" align="center">
        <tr>
          <td><table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                        <tr class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="10%" bgcolor="#06327D"><span class="Estilo17">Cantidad</span></th>
              <th width="40%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Detalle</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Valor Unitario</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Total Neto</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Descuento</span></th>
              <th width="20%" bgcolor="#06327D" class="CONT">
                <span class="Estilo17 Estilo13 Estilo15">Total</span></th>
            </tr>
            <?php
			$sql="SELECT * 
					FROM det_factura 
					where det_factura.num_factura = '$num_factura'";
			$res = mysql_query($sql) or die(mysql_error()); 
			
			while ($registro = mysql_fetch_array($res)) {
				$dias_arriendo = $registro['dias_arriendo'];
				$dias_ajuste = $registro['dias_ajuste'];
				$valor_unitario = $registro['valor_unitario'];
				$total_rep = $registro['total_rep'];
				$monto_otros = $registro['monto_otros'];
				$cod_repuesto = $registro['cod_repuesto'];
				$cod_equipo = $registro['cod_equipo'];
				$porcentaje_vu = $registro['porcentaje_vu'];
			
		?>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
			<?php if (($registro['cod_equipo']==0)) {?>            
            <td align="left"  bgcolor="#FFFFFF"><?php 
				echo($registro['cantidad']);?>
           	</td>
            <td align="left"  bgcolor="#FFFFFF"><?php 
				if ($registro['otros_reparacion']!='')
					echo utf8_decode($registro['otros_reparacion']);
				else
					echo utf8_decode($registro['observaciones']);
			 ?></td>
            <td align="right"  bgcolor="#FFFFFF"><?php 
				if (!empty($registro['valor_unitario']))
	   			  	echo "$".number_format($registro['valor_unitario'], 0, ",", ".");
				else
				 	echo "$".number_format($registro['precio'], 0, ",", ".");
			  ?>
           	</td>
            <td align="right"  bgcolor="#FFFFFF">
				<?php 
					if (!empty($registro['cod_equipo'])){
						echo "$".number_format($valor, 0, ",", ".") ; 
					}else{ 
						if (!empty($registro['total_rep'])){
							echo("$".number_format($registro['total_rep'], 0, ",", ".")); 
							}
						else{
							echo("$".number_format($registro['precio'], 0, ",", ".")); 
							}
					} 
				?></td>
            <td  bgcolor="#FFFFFF"></td>
            <td align="right"  bgcolor="#FFFFFF">
				<?php 
					if (!empty($registro['cod_equipo'])){
						echo "$".number_format($valor, 0, ",", ".") ; 
						$costo_tot= $costo_tot + $valor; 
					}else{ 
						if (!empty($registro['total_rep'])){
							echo("$".number_format($registro['total_rep'], 0, ",", ".")); 
							$costo_tot= $costo_tot + ($registro['total_rep']);
							}
						else{
							echo("$".number_format($registro['precio'], 0, ",", ".")); 
							$costo_tot= $costo_tot + ($registro['precio']);
							}
					} 
				?></td>
			<?php } else {?>            
              <td width="10%" bgcolor="#FFFFFF"><?php echo "Dias arriendo : ".$dias_arriendo."<br/>Dias ajuste : ".$dias_ajuste; ?> </td>
              <td width="40%" bgcolor="#FFFFFF">Día(s) de arriendo <?php 
					  
			  if (!empty($cod_repuesto[$contador-1])) {
				  $sqlnomrep="SELECT cod_repuesto, nombre_repuesto FROM repuesto where cod_repuesto =".$cod_repuesto;
				  $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
				  $registronrep = mysql_fetch_array($resnomrep);
				  echo($registronrep['nombre_repuesto']);
	
			  }else{
				  //BUSCAR FECHA DE ARRIENDO
					
				  $sqlperiodo=" SELECT *
								FROM equipos_arriendo
									inner join gd
										on equipos_arriendo.cod_arriendo = gd.id_arriendo
									inner join factura 

										on factura.cod_arriendo = equipos_arriendo.cod_arriendo
									where equipos_arriendo.cod_arriendo =".$num_arriendo." 
										and equipos_arriendo.cod_equipo =".$cod_equipo." 
										and equipos_arriendo.num_gd = ".$num_gd."
										and factura.num_factura = '".$num_factura."'
										and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
										and equipos_arriendo.arrendado_desde <= '".$fecha_factura."'
										and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
									order by equipos_arriendo.arrendado_hasta asc
								limit 0,1";
				  $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				  $registroper_row = mysql_num_rows($resperiodo);
					  if ($registroper_row==0){
						$sqlperiodo=" SELECT *
									FROM equipos_arriendo
										inner join gd
											on equipos_arriendo.cod_arriendo = gd.id_arriendo
										inner join factura 
											on factura.cod_arriendo = equipos_arriendo.cod_arriendo
										where equipos_arriendo.nro_factura = '".$num_factura."'
										order by equipos_arriendo.arrendado_hasta asc
									limit 0,1";
						 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					  }
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
	
					  
					  //echo(htmlentities($registronob['nombre_equipo'])." "." PERIODO: ".$fecha_factura_temp." --> ".$hasta);
					  echo(htmlentities($registronob['nombre_equipo']));
					 }
			 ?></td>
              <td width="13%" align="right" bgcolor="#FFFFFF"><?php  
			  if (!empty($cod_equipo)){
			 		$valor_u = $registro['tot_arriendo']/$dias_arriendo;
				  	echo "$".number_format($valor_u, 0, ",", "."); 
					$valor=(($dias_arriendo)*($valor_u));
			  }else{
				  echo "$".number_format($valor_unitario, 0, ",", ".");
			  }?></td>
              <td width="13%" align="right" bgcolor="#FFFFFF"><?php if (!empty($cod_equipo)){
						echo "$".number_format($valor, 0, ",", ".") ; 
						
						}
					else{ 
						echo("$".number_format($total_rep, 0, ",", ".")/*($registro['total_rep'])*/); 
						$costo_tot= $costo_tot + $total_rep;}
				?>
                <br /></td>
              <td width="13%" align="right" bgcolor="#FFFFFF">
			  	<?php 
				
				
				$porcentaje_emitir = ($registro['porcentaje_vu']);
				
				if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
					echo "0%";
					}
				else{
					echo $porcentaje_emitir."%";
					}
				?>
              </td>
              <td width="20%" align="right" bgcolor="#FFFFFF"><?php 
			if (!empty($cod_equipo)){
                  $valor_def = $registro['tot_arriendo'];
                  $costo_tot= $costo_tot + $valor_def; 
                  echo "$".number_format($registro['tot_arriendo'], 0, ",", ".");
						
						}
					else{ 
                  $valor_def = $registro['total_rep'];
                  $costo_tot= $costo_tot + $valor_def; 
                  echo "$".number_format($registro['total_rep'], 0, ",", ".");
						}
			?></td>
            </tr>
            <tr>
              <td width="10%" height="20" bordercolor="#FFFFFF" class="CONT"><?php if ($monto_otros>0) { echo(1);}?></td>
              <td width="40%" class="CONT"><?php if ($monto_otros>0) { echo ("REPARACION");} ?></td>
              <td width="13%" align="right" class="CONT"><?php if ($monto_otros>0) echo "$".number_format($monto_otros, 0, ",", ".") ; ?></td>
              <td width="13%" align="right" class="CONT"><?php if ($monto_otros>0) echo "$".number_format($monto_otros, 0, ",", ".") ; $costo_tot= $costo_tot + $monto_otros; ?></td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="20%" align="right" class="CONT">&nbsp;</td>
            </tr>

             <?php
			}
			}
				mysql_free_result($res);
				mysql_close($link);
		 ?>

            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="20%" align="right" class="CONT"><?php
				echo ("NETO: $".number_format($costo_tot, 0, ",", "."));
		 ?>
                <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
              </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="20%" align="right"><span class="CONT">
                <?php
				if (empty($val_iva)){
					$link=Conectarse();
					$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
					$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
					$registroiva = mysql_fetch_array($resiva);
					$valor_iva = $registroiva['valor_iva'];
				}else{
					$valor_iva = $val_iva;
				}
				$iva = $costo_tot * ($valor_iva/100);
				echo ("IVA : $".number_format($iva, 0, ",", "."));
		 ?>
                <input type="hidden" name="txt_iva"  value="<?php echo $iva?>" size="20" maxlength="30" />
              </span></td>
              </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="20%" align="right"><span class="CONT">
                <?php
				$total = $costo_tot + $iva;
				echo ("TOTAL : $".number_format($total, 0, ",", "."));
		 ?>
                <input type="hidden" name="txt_iva2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
              </span></td>
            </tr>
            </table></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
     </td>
  </tr>
</table>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>
       <?php
		function mensaje()
			{
				echo "<script>
				alert('Ingrese Numero de Factura');
				</script>";
			}
	  ?>

	  <?php	
	  $valor2 = $_POST["OK"];
	  if ($_POST['borrar']=='Borrar'){
		$num_factura        = $_POST['txt_factura'];    	               // echo "$num_factura<br>";				
		if (empty($num_factura)){  
			$link=mensaje();
		} else {
			//	echo "si entra graba";
			$num_factura        = $_POST['txt_factura'];    	               // echo "$num_factura<br>";
			$fecha              = $_POST['cal-field-1'];              // echo "$fecha<br>";
			$link=Conectarse();
			
			//verificar estado de la factura
			$sqlanular   = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
			//echo "sqlfact= $sqlfact<br>";
			$resanular   = mysql_query($sqlanular,$link) or die(mysql_error()); 
			$registronula= mysql_fetch_array($resanular);
			if (empty($registronula['num_factura']))
			{
				echo "<script> alert (\"Factura no encontrada.\"); </script>";
			}else{
					$sql_nc ="select * from nota_credito where num_factura = '$num_factura'";
					$res_nc = mysql_query($sql_nc,$link) or die(mysql_error());
					$row_nc = mysql_fetch_array($res_nc);
					if ( empty($row_nc['num_factura'])){
						echo "<br />";
						echo $sql_1  = "delete FROM det_factura
										WHERE  num_factura =  '$num_factura'
										";
						echo "<br />";
						$res_1  = mysql_query($sql_1) or die(mysql_error());
						echo $sql_2  = "delete FROM factura
										WHERE  num_factura =  '$num_factura'
										";
						echo "<br />";
						$res_2  = mysql_query($sql_2) or die(mysql_error());
						echo $sql_3  = "		SELECT * 
										FROM equipos_arriendo
										WHERE  nro_factura =  '$num_factura'
											AND estado_equipo_arr LIKE  '%-FACTURADO%'
										";
						echo "<br />";
						$res_3  = mysql_query($sql_3) or die(mysql_error());
						while( $row_3 = mysql_fetch_array($res_3)){
							$cod_equipo = $row_3['cod_equipo'];
							$estado = $row_3['estado_equipo_arr'];
							$estado_anterior  = $row_3['estado_equipo_arr'];
							$cod_arriendo = $row_3['cod_arriendo'];
							$arrendado_desde = $row_3['arrendado_desde'];
							$hora_arr = $row_3['hora_arr'];
							$arrendado_hasta = $row_3['arrendado_hasta'];
							$arrendado_hasta_ant = $row_3['arrendado_hasta'];
							$hora_devol = $row_3['hora_devol'];
							$hora_devol_ant = $row_3['hora_devol'];
							$precio = $row_3['precio'];
							$comentarios = $row_3['comentarios'];
							$inc_accesorio = $row_3['inc_accesorio'];
							if ($estado == 'NO DEVUELTO-FACTURADO'){
								$estado = 'NO DEVUELTO';
								$arrendado_hasta="0000-00-00";
								$hora_devol="00:00:00"; 
								}
							elseif ($estado=='DEVUELTO-FACTURADO'){
								$estado = 'DEVUELTO-NO FACTURADO';
								}
							elseif ($estado=='NO DEVUELTO-FACTURADO-CAMBIO'){
								$estado = 'NO DEVUELTO-CAMBIO';
								}
							elseif ($estado=='DEVUELTO-FACTURADO-CAMBIO'){
								$estado = 'DEVUELTO-NO FACTURADO-CAMBIO';
								}
							$sql_insertar = "update equipos_arriendo 
												set estado_equipo_arr = '$estado' ,
													nro_factura = '0' ,
													cod_reclamo = '0' ,
													arrendado_hasta = '$arrendado_hasta',
													hora_devol = '$hora_devol'
											where												
											cod_arriendo = '$cod_arriendo' and
											cod_equipo = '$cod_equipo' and
											num_gd = '$num_gd' and
											arrendado_desde = '$arrendado_desde' and 
											hora_arr = '$hora_arr' and 
											arrendado_hasta = '$arrendado_hasta_ant' and 
											hora_devol = '$hora_devol_ant' and 
											precio = '$precio' and 
											comentarios = '$comentarios' and 
											estado_equipo_arr = '$estado_anterior' and 
											inc_accesorio = '$inc_accesorio'";
							//echo "<br />"; 
							$res_insertar = mysql_query($sql_insertar) or die(mysql_error());
							
							$fecha_temp = explode("-",$arrendado_hasta_ant);
							//año-mes-dia
							//0 -> año, 1 -> mes, 2 -> dia
							$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2]+1, $fecha_temp[0]));
							$dia_sig = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
							
							$fecha_arr_sig_sql = "delete from equipos_arriendo 
													where cod_arriendo = '$cod_arriendo' and
													cod_equipo = '$cod_equipo' and
													num_gd = '$num_gd' and
													arrendado_desde = '$dia_sig'";
							//echo "<br />";
							$res_fecha_arr_sig_sql = mysql_query($fecha_arr_sig_sql) or die(mysql_error());
							}					
						echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
						echo "<script language=Javascript> location.href=\"menu.php\"; </script>";
						}
					else{
						echo "<script> alert (\"Factura con notas de crédito.\"); </script>";
						}
					}
				}
			}
		 
		 
	?>