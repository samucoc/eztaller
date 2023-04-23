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

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <title>Sistema de Arriendo y Facturación - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css"/>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script language="JavaScript">
function verifica_rut(c){var r=false,d=c.value,t=d.replace(/\b[^0-9kK]+\b/g,'');if(t.length==8){t=0+t;};if(t.length==9){var a=t.substring(t.length-1,-1),b=t.charAt(t.length-1);if(b=='k'){b='K'};if(!isNaN(a)){var s=0,m=2,x='0',e=0;for(var i=a.length-1;i>=0;i--){s=s+a.charAt(i)*m;if(m==7){m=2;}else{m++;};}var y=s%11;if(y==1){x='K';}else{if(y==0){x='0';}else{e=11-y;x=e+'';};};if(x==b){r=true;c.value=a.substring(0,2)+'.'+a.substring(2,5)+'.'+a.substring(5,8)+'-'+b};}}return r;};
</script>
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
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-weight: bold}
.Estilo22 {font-weight: bold}
.Estilo24 {
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
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
<style type="text/css">
.Estilo241 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
</style>
</head>
<body>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php'); //modulo cabecera
	?>
</div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div>
    <br class="clearFloat"/>
    <form action="gd.php" method="post" name="frmDatos" id="frmDatos">
    <table width="90%" border="0" align="center">
    <tr>
      <td width="52%" ></td>
      <td width="48%"><div align="center" class="Estilo6"><div align="right" class="Estilo20"><strong><font>
        <?php
				function verifica_RUT($rut='') {
				  $sep = array();  $multi = 2;  $suma = 0;
				  if (empty($rut)) return 1;
				  $tmpRUT = preg_replace('/[^0-9kK]/','',$rut);
				  if (strlen($tmpRUT) == 8 ) $tmpRUT = '0'.$tmpRUT;
				  if (strlen($tmpRUT) != 9) return 2;
				  $sep['rut'] = substr($tmpRUT,0,8);
				  $sep['dv']  = substr($tmpRUT, -1);
				  if ($sep['dv'] == 'k') $sep['dv'] = 'K';
				  if (!is_numeric($sep['rut'])) return 3;
				  if (empty($sep['rut']) OR $sep['dv'] == '') return 4;
				  for ($i=strlen($sep['rut']) - 1; $i >= 0; $i--) {
					$suma = $suma + $sep['rut'][$i] * $multi;
					if ($multi == 7) $multi = 2;
					else $multi++;
				  }
				  $resto = $suma % 11;
				  if ($resto == 1) $sep['dvt'] = 'K';
				  else {
					if ($resto == 0) $sep['dvt'] = '0';
					else $sep['dvt'] = 11 - $resto;
				  }
				  if ($sep['dvt'] != $sep['dv']) return 5;
				  return 0;
				}

					include("classes/conex.php");
					$link=Conectarse();

					if (empty($gd)) $gd = $_GET['num_gd'];
			 		if (empty($gd)) $gd = $_POST['num_gd'];
					if (empty($gd)) $gd = $_POST['txt_gd'];

					$sqlgd = "SELECT * FROM gd WHERE num_gd ='$gd'";	
					$resgd = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$gd=$registrogd['num_gd'];
					
					$cod_cli=$registrogd['cod_cliente'];
					
					$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
					
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registrocliente = mysql_fetch_array($rescliente);
					$valor1=$registrocliente['rut_cliente'];
					if (empty($valor1)){
					$valor1 = $_GET['id'];
				    if (empty($valor1)) $valor1 = $_POST['txt_rut'];
					if (empty($valor1)) $valor1 = $_GET['txt_rut'];
			
				    }
					
					if (empty($valor1)){

					}else{
							$link=Conectarse();
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM clientes WHERE rut_cliente ='$valor1'";
						
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							$codigo_cli = $registro['cod_cliente'];
							if (empty($registro['rut_cliente']) && $_POST["buscar"]=="Buscar") {
								echo "<script>
								alert('Cliente No Ingresado');
								</script>";
							}else{ 
							}
					}
			?>
        GUIA DE DESPACHO</font></strong></div></div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS GUIA DESPACHO
        <?php  $fecha = date ("d-m-Y"); //echo($fecha);?></span>
      </div></td>
    </tr>
    </table>
          <table width="90%" border="0" align="center">
            <tr>
              <td height="8" align="left"><?php
			if (isset($_POST['txt_rut'])) {
			  $error = verifica_rut($_POST['txt_rut']);
			  switch($error) {
				case 0 :   
					$rut_param = $_POST['txt_rut'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $rut_param;
					}
		
				break;
				case 1 : /*echo "<script> alert (\"Ingrese Rut Cliente\"); </script>"; */break;
				case 2 : echo "<script>	alert (\"El Rut no cuenta con el mínimo de caracteres necesarios para validarlo\");					</script>"; break;
				case 4 : echo "<script>	alert (\"El Rut o el dígito viene vacío\");</script>"; break;
				case 5 : echo "<script>	alert (\"El Rut y el dígito no coinciden\");</script>"; break;
				default: echo "<script>	alert (\"Error\");</script>"; break;
			  }
			
			}
		?>
                <input type="hidden" name="txt_numgd" size="20" maxlength="30" value="<?php if (!empty($registrogd['num_gd'])) {echo ($registrogd['num_gd']);}else{echo($_POST["txt_gd"]) ;}?>?>" />
              N&deg; Guia de Despacho</td>
              <td height="8" align="left"><span class="Estilo241">
              <?php 
            $sql_num_factura     = "SELECT (COALESCE(num_gd,0)) as ncorr
                  FROM gd
                     WHERE num_gd > 30850 and num_gd < 100000
                  
					 order by num_gd desc";
          
          $res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
          $registro_num_factura= mysql_fetch_array($res_num_factura);
          $num_factura_nuevo = $registro_num_factura['ncorr'];
          if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 30851;
          else $num_factura_nuevo = $registro_num_factura['ncorr']+1;
         
          if ($num_factura_nuevo=='') $num_factura_nuevo=1;

            $sql_filtro = "select * 
                    from folios_dte
                    where desde <= '".$num_factura_nuevo."' and 
                        hasta >= '".$num_factura_nuevo."' and 
                        tipo = 52";
            $res_filtro = mysql_query($sql_filtro,$link);
            if (mysql_num_rows($res_filtro)==0){
              $num_factura_nuevo = "Error.";
              }
          
            ?>
                <input id="txt_gd" name="txt_gd" type="text" value="<?php 
						if (($_POST['txt_gd']=='')&&($registrofact['num_gd']=='')) echo $num_factura_nuevo;
                        else if (!empty($registrogd['num_gd'])) {
							echo ($registrogd['num_gd']);
						}
						else{
							if (!empty($_POST["txt_gd"]))
								echo($_POST["txt_gd"]) ;
							else
								echo $_GET["num_gd"];
							}?>" size="10" maxlength="10" style="font-size:18px; color:red;  font-weight:bold; border:#F00 solid 2px; padding:5px"/>
              <?php if (!empty($registrogd['id_arriendo'])){
					  echo "Guia de arriendo existente";
				  }else{
					if (!empty($_POST["txt_gd"])&&(!empty($registrogd['num_gd'])))
						echo "Guia de venta existente";
					elseif (!empty($_GET['num_gd'])&&(!empty($registrogd['num_gd'])))
						echo "Guia de venta existente";
				}?>
              </span></td>
              <td height="8" colspan="3"  align="right">Fecha Emision
                <input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registrogd['fecha'])) {echo ($registrogd['fecha']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha'];?>" size="10" maxlength="10"/>
                <button type="submit" id="cal-button-1">...</button>
              <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
                </script></td>
            </tr>
            <tr>
              <td width="19%"><div align="left">Rut</div></td>
              <td width="52%">
                           
              <input name="txt_rut" type="text" id="rut" value="<?php 
			  if ((($registro['rut_cliente'])!= "") && (empty($registro['cod_cliente'])))
			  {		$rut_param = $registro['rut_cliente'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $registro['rut_cliente'];
					}
					echo ($rutok);
				}else{ 
					if (!empty($registro['rut_cliente'])) {
						echo($registro['rut_cliente']); 
					}else{ 
						
						echo ($_POST['txt_rut']);
					}
				}?>" size="12" maxlength="12" onblur="if (this.value!='') checkRutGenerico(this, true);" />
                <input type="submit" name="buscar" value="Buscar" title="Buscar Cliente" style="background-image:url(images/ver.png); width:25px; height:25px;" class="formato_boton"/>
                
                <!--<input type="image" name="buscar" value="Buscar" title="Buscar Cliente" class="searchbutton" src="images/ver.png"/>-->
                <span class="Estilo20">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                <input type="hidden" name="txt_codigocli" size="20" maxlength="30" value="<?php echo $registro['cod_cliente'];?>" />
                </span>[11.111.111-1]</td>
              <td height="8" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td colspan="3">
              <input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td width="9%">
              <input  name="txt_codcli" type="hidden" value="<?php if (!empty($registrofact['cod_cliente'])) {echo ($registrofact['cod_cliente']);}else{echo($_POST["txt_codcli"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td colspan="3"><input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td colspan="3
              "><input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td colspan="3" align="left"><input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registro['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
						  
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Comuna</div></td>
              <td colspan="3" align="left"><input name="txt_comuna" type="text" value="<?php
			   if (!empty($registro['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
						 
						  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
						  $registrocom = mysql_fetch_array($rescom);
						  echo($registrocom['comuna']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Tel&eacute;fono</div></td>
              <td colspan="3"><input name="txt_cod_area" type="text" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled"/>
                <input name="txt_fono" type="text" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Obra/Direccion</td>
              <td><?php 
			$codigo_clie =  $registro['cod_cliente'];
			$sqlobra="SELECT cod_obra, nombre_obra, direcc_obra FROM obra where cod_cliente = '$codigo_clie'";?>
                <select name="selecobra" id="selecobra" onchange="otrosdatos2.value=this.options[this.selectedIndex].getAttribute('nombre_obra');cod_obra.value=this.options[this.selectedIndex].getAttribute('cod_obra');direcc_obra.value=this.options[this.selectedIndex].getAttribute('direcc_obra');">
                  <option value="" selected="selected" nombre_obra="" cod_obra="" direcc_obra="">Seleccionar</option>
                  <?php $resobra=mysql_query($sqlobra,$link) or die(mysql_error());	
        while ($rowobra = mysql_fetch_assoc($resobra)){
?>
                  <option value="<?php echo $rowobra['cod_obra'] ?>" nombre_obra="<?php echo $rowobra['nombre_obra']?>" cod_obra="<?php echo $rowobra['cod_obra'] ?>" direcc_obra="<?php echo $rowobra['direcc_obra'] ?>"><?php echo htmlentities($rowobra['nombre_obra']).'  -  '.htmlentities($rowobra['direcc_obra']); ?></option>
                  <?php 
}
?>
                </select></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td>Tipo Traslado</td>
              <td><select name="tipo_traslado" id="tipo_traslado">
              		<option value="1">Operacion constituye Venta</option>
              		<option value="2">Ventas por efectuar</option>
              		<option value="3">Consignaciones</option>
              		<option value="4">Entrega Gratuita</option>
              		<option value="5">Traslados Internos</option>
              		<option value="6">Otros Traslados no ventas</option>
              		<option value="7">Guia de Evolucion</option>
              		<option value="8">Traslado de exportacion (No venta)</option>
              		<option value="9">Venta para exportacion</option>
              		</select>
              </td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td>Orden de Compra</td>
              <td><input name="orden_compra" type="text" id="orden_compra" value="<?php 
			  		echo ($_POST['orden_compra']);
				?>" /></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td>Patente</td>
              <td><input name="patente" type="text" id="patente" value="<?php 
			  		echo ($_POST['patente']);
				?>" /></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Condicion de Venta</div></td>
              <td align="left">
              		<select name="txt_cond_venta" id="txt_cond_venta"  align="left"><?php 
			  		// $sql_num_gd = "select *
					// 				from gd
					// 				where num_gd = ".$num_gd;
					// $res_num_gd = mysql_query($sql_num_gd,$link);
					// $row_num_gd = mysql_fetch_array($res_num_gd);
			  		// 		if (!empty($row_num_gd['cond_venta'])) {
					// 			echo ($row_num_gd['cond_venta']);
					// 		}
					//	else{
				 	// 	$sql_num_gd = "select *
					// 				from factura
					// 				where num_factura = ".$num_factura;
					// 	$res_num_gd = mysql_query($sql_num_gd,$link);
					// 	$row_num_gd = mysql_fetch_array($res_num_gd);
					// 	if (!empty($row_num_gd['cond_venta'])) {
					// 		echo ($row_num_gd['cond_venta']);
					// 		}
					// 	else{
					// 		echo($_POST["txt_condicenv"]) ;
					// 		}
					// 	} 
					$sql_cond_venta = "select * from forma_pago order by cod_forma_pago asc";
					$res_cond_venta = mysql_query($sql_cond_venta,$link);
					while($row_cond_venta = mysql_fetch_array($res_cond_venta)){
					?>
						<option value="<?php echo $row_cond_venta['cod_forma_pago']?>"><?php echo $row_cond_venta['forma_pago']?> - <?php echo $row_cond_venta['forma_pago_dias']?> DIAS</option>
					<?php }?>
					</select>

				</td>
            </tr>
            <tr >
              <td colspan="4" align="right" >
 				<?php if (empty($registrogd['id_arriendo']) && empty($registrogd['num_gd'])){?>             
	              	<input type="submit" name="OK" id="OK" value="Guardar y Seguir" title="Guardar Guia Despacho" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" />
	            <?php }?>              
                </td>
                <td align="left" >
	            <?php if (empty($registrogd['id_arriendo']) && empty($registrogd['num_gd'])){
	            	if ($_POST['OK']=='Guardar y Seguir'){
					?>             
				    <a id="imprimir-gd" href="#" ><img width="45" height="45" border="0" class="oculto" title="Descargar Guía Despacho" src="images/gest_fin/factura.png"></a>
				    <?php }?>
	                <a href="gd.php" class="menulink" onclick="document.getElementById('rut').value = '';">
	                	<input name="Limpiar" type="image" title="Limpiar"  width="45" height="45" value="Limpiar"  src="images/clean.png"/>
	                </a> 
                <?php }?>              

               </td>
            </tr>
            <tr>
              <td colspan="5" height="8"></td>
            </tr>
      </table>
        <table width="90%" border="0" align="center">
          <tr>
            <td colspan="5" bgcolor="#06327D" height="15"><span class="Estilo7 sortable">AGREGAR DETALLE</span></td>
          </tr>
          <tr class="sortable">
            <th>Cantidad</th>
            <th>Servicio / Producto</th>
            <th>Descripcion</th>
            <th>Valor Unitario</th>
            <th colspan="2">Agregar</th>
          </tr>
          <tr class="sortable">
            <th valign="top"><input name="cantidad_detalle_previo" id="cantidad_detalle_previo" type="text"  class="validate[required,custom[number]]" value="0"/></th>
            <th><textarea name="detalle_previo_1" cols="40" rows="5" id="detalle_previo_1" class="" ></textarea></th>
            <th><textarea name="detalle_previo_2" cols="80" rows="5" id="detalle_previo_2" class="" ></textarea></th>
            <th valign="top"><input name="valor_unitario_detalle_previo" id="valor_unitario_detalle_previo" type="text" class="validate[required,custom[number]]" value="0" /></th>
            <th align="right" valign="top">
            	<?php if (empty($registrogd['id_arriendo']) && empty($registrogd['num_gd'])){?>  
                <a href="#" id="agregar-fila">
                	<img title="Agregar Detalle a Guía de Despacho" src="images/guardar.gif" style="width:46px; height:52px;" class="formato_boton" />
                </a>
                <?php }?>
              <input type="hidden" name="txt_cod2" size="20" maxlength="30" />
              <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
          </tr>
      </table>
 				<?php if (empty($registrogd['id_arriendo'])){?>             
          <table id="tabla-pre" width="90%" border="0" align="center">
              <tr class="sortable">
                <th bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
                <th bgcolor="#06327D"><div align="center" class="Estilo17">Detalle</div></th>
                <th bgcolor="#06327D"><div align="center" class="Estilo17">Valor Unitario</div></th>
                <th bgcolor="#06327D">
                  <span class="Estilo17 Estilo13 Estilo15">Quitar</span></th>
            </tr>
          <?php
			if (empty($_GET["num_gd"])||(empty($_POST["txt_gd"]))) $fact=0; 
			if (!empty($_GET["num_gd"])) $fact=$_GET["num_gd"];
			if (!empty($_POST["txt_gd"])) $fact=$_POST["txt_gd"];
			$sqldet="SELECT * FROM  det_gd where num_gd = ".$fact." order by fila_num_gd ASC";
		  
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
          <tr bordercolor="#FFFFFF" class="sortable" id="linea_<?php echo $registrodet['fila_num_gd'] ?>">
          	
            <td align="left">
			<?php 
				echo($registrodet['cantidad']);?>
           	</td>
            <td align="left"><?php 
				echo $registrodet['observaciones'];
			 ?></td>
            <td align="right"><?php 
   			  	echo "$".number_format($registrodet['precio'], 0, ",", ".");
			  ?>
           	</td>
            <td align="center" bgcolor="#FFFFFF">
            	<input type="hidden" name="txt_codrepuesto"  value="<?php echo $registrodet['cod_equipo']?>" size="20" maxlength="30" />
                <input type="hidden" name="txt_obser" value"<?php 
				echo $registrodet['observaciones'];
			 ?>" />
              <input type="submit" name="borrar" value="Borrar" title="Eliminar de la factura" onclick="elimina=confirm('Desea eliminar?');return elimina;" style="background-image:url(images/error.png); width:16px; height:16px;" class="formato_boton"/>
          </tr>
                    <?php
				}
				mysql_free_result($resdet);
				mysql_close($link); 
		 ?>
      </table>
      <?php }?>
</form>
</div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/languages/jquery.validationEngine-es.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
	var i =0;
	$(document).ready(function(){
		$("#txt_gd").bind('blur',function() {
			var num_gd = $("#txt_gd").val();
			$.ajax({
				url:'classes/consulta-gd/buscar-gd.php?num_gd='+num_gd,
				success: function(data){
					if (data=='1'){
						alert("Folio Existente");
						document.getElementById('txt_gd').focus();
						}	
					if (data=='2'){
						alert("Folio fuera de rango");
						document.getElementById('txt_gd').focus();
						}
					if (data=='3'){
						alert("Folio fuera de rango sugerido");
						document.getElementById('txt_gd').focus();
						}
					}
			});
			//location.href="gd.php?num_gd="+num_gd;
			});
		$("#cal-field-1").bind('blur',function() {
			$("#OK").show();
			});
		$("#cal-button-1").bind('click',function() {
			$("#OK").show();
			});
		/*
		$("#imprimir-gd").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});
		*/
		$('#agregar-fila').live('click',function() {
			var cantidad_detalle_previo = $("#cantidad_detalle_previo").val(); 
			var detalle_previo = $("#detalle_previo_1").val() +'//'+$("#detalle_previo_2").val();
			var valor_unitario_detalle_previo = $("#valor_unitario_detalle_previo").val();
			$('#tabla-pre').hide();
			detalle_previo = detalle_previo.replace(/\"/g, ' plg. ');
			$('#tabla-pre').append('<tr id="linea_'+i+'"><td>'+cantidad_detalle_previo+'<input type="hidden" id="cantidad_detalle" name="cantidad_detalle[]" value="'+cantidad_detalle_previo+'"/></td><td>'+detalle_previo+'<input type="hidden" id="detalle" name="detalle[]" value="'+detalle_previo+'"/></td><td align="right">$'+valor_unitario_detalle_previo+'<input type="hidden" id="valor_unitario" name="valor_unitario[]" value="'+valor_unitario_detalle_previo+'"/></td><td align="center"><a href="#" onclick="borrarFila('+i+'); return false"><img src="images/error.png" title="Borrar" /></a></td></tr>');
			$('#tabla-pre').show();
			i = i+1;
			var num_gd = $("#txt_gd").val();
			if (num_gd > 0){
				$("#imprimir-gd").attr('href','classes/consulta-gd/vista-previa-gd.php?num_gd'+num_gd);
				}
		
		});
	});
	function borrarFila(indice){
		$("#linea_" + indice).remove();
		}
</script>
<script>
	$(document).ready(function() {
		$("#frmDatos").validationEngine({
			validationEventTriggers:"keyup blur"
		});
		var num_gd = $("#txt_gd").val();
		if (num_gd > 0){
			$("#imprimir-gd").attr('href','classes/consulta-gd/vista-previa-gd.php?num_gd='+num_gd);
			}
	});
</script>
</body>

</html>
 <?php   
 	if ($_POST['buscar']=='Buscar') {   
		if (empty($_POST['txt_rut'])) {  
			$link=mensaje();
		} 
	}
	
	function mensaje()	{
		echo "<script> alert('Ingrese Guia de Despacho o Fecha de Emision');</script>";
	}

	if ($_POST['borrar']=='Borrar')	 { 
		 $link         	= Conectarse();
		 $num_gd       	= $_POST['txt_gd'];  
		 $codigo_det   	= trim($_POST['txt_codrepuesto']);
		 $detalle 		= $_POST['txt_obser'];
		 if ($codigo_det>0){
			 if (!empty($codigo_det)){
				 $sqlelim      = "DELETE FROM det_gd 
									WHERE cod_equipo = '$codigo_det' 
										and num_gd = '$num_gd' ";
				 }
				else{
					 $sqlelim      = "DELETE FROM det_gd 
										WHERE observaciones = '$detalle' 
											and num_gd = '$num_gd' ";
					}
			 $res     = mysql_query($sqlelim) or die(mysql_error()); 
			 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			 echo "<script language=Javascript> location.href=\"gd.php?num_gd=".$num_gd."\"; </script>";
		 	}
	 	}   

	
	$valor2 = $_POST["OK"];
	if ($_POST['OK']=='Guardar y Seguir'){
			//id_arriendo 	num_gd 	cod_cliente 	fecha 	tipo 	rut_cliente 	cod_obra
			$num_gd             = $_POST['txt_gd'];    	               // echo "$num_gd<br>";
			$tipo               = $_POST['txt_tipo'];    	   // echo "$tipo<br>";
			$cod_cliente        = $_POST["txt_codcli"];            // echo "$cod_cliente<br>";
			$rut_cliente        = $_POST["txt_cod"];            // echo "$cod_cliente<br>";
			$fecha              = $_POST['cal-field-1'];      // echo "$fecha<br>";
			$codigo_obra        = $_POST['selecobra'];       // echo($codigo_obra);
			$orden_compra 		= $_POST['orden_compra'];
			$patente 			= $_POST['patente'];
			$cond_venta 		= $_POST['txt_cond_venta'];
			$tipo_traslado 		= $_POST['tipo_traslado'];
			$hora_actual 		= date("H:i:s");
			if (empty($num_gd) or (empty($fecha))){  
				$link=mensaje();
			} else {
				
				$num_gd             = $_POST['txt_gd'];    	                 //echo "$num_gd<br>";
				$tipo               = $_POST['txt_tipo'];    	             //echo "$tipo<br>";
				$cod_cliente        = $registro["cod_cliente"];              //echo "$cod_cliente<br>";

				/*$fecha_temp = explode("-",$_POST['cal-field-1']);
				$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
				$fecha = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  */
				
				list($anio,$mes,$dia) = explode("-",$_POST['cal-field-1']);
				$fecha = $dia.'-'.$mes."-".$anio;  


				$link=Conectarse();
				$sqlf        = "SELECT * FROM gd WHERE num_gd ='$num_gd'";
			
				$resf        = mysql_query($sqlf,$link) or die(mysql_error()); 
				$registrof   = mysql_fetch_array($resf);
			
				if (!empty($registrof['num_gd'])) {
					echo "<script> alert (\"Guia despacho existente. Ingrese Otro Folio\"); </script>";
				}elseif ($registrof['estado']=='NULA') {
					echo "<script> alert (\"Guia despacho nula. Ingrese Otro Folio\"); </script>";
				}else{
					//buscar ese codigo en arriendos
					$sqlarrguia  = "SELECT * FROM arriendo WHERE num_gd ='$num_gd'";
					$resarrguia  = mysql_query($sqlarrguia,$link) or die(mysql_error()); 
					$resarrguia  = mysql_fetch_array($resarrguia);

					//verificar si existe
					if (empty($resarrguia['num_gd'])) {
						//ingresar datos de la nc				
						$sql = "insert into gd (id_arriendo,num_gd,cod_cliente,fecha,tipo,rut_cliente,cod_obra,orden_compra,cond_venta,hora_actual,tipo_traslado,patente) 
									values ('0','$num_gd','$cod_cliente','$fecha','$tipo','$rut_cliente','$codigo_obra','$orden_compra','$cond_venta','$hora_actual','$tipo_traslado','$patente')";
						mysql_query($sql,$link) or die(mysql_error());

						$cantidad_arr 	= $_POST['cantidad_detalle'];
						$nro = count($cantidad_arr);
						$descr_arr		= $_POST['detalle'];
						$valor_u_arr	= $_POST['valor_unitario'];
						for($i=0; $i<$nro; $i++){
							$sql_temp ="insert into det_gd(num_gd, fila_num_gd, cod_equipo, cantidad, porcentaje_vu, observaciones, precio, accesorio) values ('".$num_gd."','".$i."','0','".$cantidad_arr[$i]."','100', '".$descr_arr[$i]."','".$valor_u_arr[$i]."','0')";
							$res_temp = mysql_query($sql_temp,$link) or die(mysql_error());
							}
						echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
					}else{
						$id_arriendo = $resarrguia['cod_arriendo'];
						//comparar arriendo cliente
						if ($resarrguia['rut_cliente']==$registro["rut_cliente"]) {
							//ingresar datos de la nc				
							mysql_query("insert into gd (id_arriendo,num_gd,cod_cliente,fecha,tipo,rut_cliente,cod_obra,orden_compra,cond_venta,hora_actual, tipo_traslado, patente) 
								values ('$id_arriendo','$num_gd','$cod_cliente','$fecha','$tipo','$rut_cliente','$codigo_obra','$orden_compra','$cond_venta','$hora_actual','$tipo_traslado','$patente')",$link) or die(mysql_error());
							$cantidad_arr 	= $_POST['cantidad_detalle'];
							$nro = count($cantidad_arr);
							$descr_arr		= $_POST['detalle'];
							$valor_u_arr	= $_POST['valor_unitario'];
							for($i=0; $i<$nro; $i++){
								$sql_temp ="insert into det_gd(num_gd, fila_num_gd, cod_equipo, cantidad, porcentaje_vu, observaciones, precio, accesorio) values ('".$num_gd."','".$i."','0','".$cantidad_arr[$i]."','100', '".$descr_arr[$i]."','".$valor_u_arr[$i]."','0')";
								$res_temp = mysql_query($sql_temp,$link) or die(mysql_error());
								}
							echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
						}else{
							echo "<script> alert (\"Numero GD corresponde a otro Cliente/Arriendo.\"); </script>";
						}
					}
				}
			}
		 } 
		 
	/*		 
	  $valor2 = $_POST["OK"];
	  if ($_POST['OK2']=='Agregar'){
		
			    $link=Conectarse();
				$num_gd             = $_POST['txt_gd'];    	                          //    echo "$num_gd<br>";
				$cod_equipo         = $_POST['selecprod'];                    //   echo "equipo.$cod_equipo<br>";
				
				$sqlprecio          = "SELECT valor_unidad_arr FROM equipo where cod_equipo = '$cod_equipo'";
				$resprecio          = mysql_query($sqlprecio,$link) or die(mysql_error()); 
				$registroprecio     = mysql_fetch_array($resprecio);
				$precio             = $registroprecio['valor_unidad_arr'];              //  echo "$precio<br>";
				                 
				$cantidad           = $_POST['txt_cantidad'];                          //    echo "$cantidad<br>";
				$observaciones      = strtoupper($_POST['txt_observaciones']);  //    echo "$observaciones<br>";
				
				if (empty($num_gd)||empty($cantidad)||empty($cod_equipo)||empty($observaciones)){  
					echo "<script> alert('Debe especificar Equipo, cantidad y observaciones');	</script>";
					echo "<script language=Javascript> location.href=\"gd.php?num_gd=".$num_gd."\"; </script>";
				} else {
					$num_gd             = $_POST['txt_gd'];    	                            //  echo "$num_gd<br>";
					$cod_equipo         = $_POST['selecprod'];                    //   echo "$cod_equipo<br>";
					
					$sqlprecio          = "SELECT valor_unidad_arr FROM equipo where cod_equipo = '$cod_equipo'";
					$resprecio          = mysql_query($sqlprecio,$link) or die(mysql_error()); 
					$registroprecio     = mysql_fetch_array($resprecio);
					$precio             = $registroprecio['valor_unidad_arr'];             //   echo "$precio<br>";
									 
					$cantidad           = $_POST['txt_cantidad'];                          //    echo "$cantidad<br>";
					$observaciones      = strtoupper($_POST['txt_observaciones']);  //    echo "$observaciones<br>";
				
					//ingresar datos guia despacho
					$link=Conectarse();
					mysql_query("insert into det_gd (num_gd,cod_equipo,cantidad,precio,observaciones) values ('$num_gd','$cod_equipo','$cantidad','$precio','$observaciones')",$link);
					mysql_close($link);	
					echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
				    echo "<script language=Javascript> location.href=\"gd.php?num_gd=".$num_gd."\"; </script>";		
	 		   			 }
					}
			*/ ?>