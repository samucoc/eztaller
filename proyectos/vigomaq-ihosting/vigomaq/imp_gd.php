<?php 
ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 

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


<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
   <style type="text/css">
 @media print {
    .oculto {display:none}
  }
</style>
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
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<script type="text/javascript" src="ie.js"></script>

  <table width="70%" height="427" border="0" align="center">
    <tr>
      <td width="52%" height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo11 Estilo20">
          <div align="right" class="Estilo21">
            <div align="left" class="Estilo13"></div>
          </div>
      </div></td>
      <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13"><?php
				{
					include("conex.php");
					$link=Conectarse();
				}
			 ?>
            <?php
					if (empty($gd)) $gd = $_GET['num_gd'];
			
					$link=Conectarse();

					$sqlgd = "SELECT * FROM vigomaq_intranet.gd WHERE num_gd ='$gd'";						
				
					$resgd = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$gd=$registrogd['num_gd'];
					$cod_cli=$registrogd['cod_cliente'];
		
					$sqlcliente = "SELECT rut_cliente FROM vigomaq_intranet.clientes WHERE cod_cliente ='$cod_cli'";
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registrocliente = mysql_fetch_array($rescliente);
					$valor1=$registrocliente['rut_cliente'];
			?>
            <?php
				{
					if (empty($valor1)){
					$valor1 = $_GET['id'];
				    if (empty($valor1)) $valor1 = $_POST['txt_rut'];
					if (empty($valor1)) $valor1 = $_GET['txt_rut'];
			
				    }
					
					if (empty($valor1)){

					}else{
							$link=Conectarse();
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM vigomaq_intranet.clientes WHERE rut_cliente ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							if (empty($registro['rut_cliente']) && $_POST["buscar"]=="Buscar")
							{
								echo "<script>
								alert('Cliente No Ingresado');
								</script>";
							}else{ 
							}
					}
				}
			?>GUIA DE DESPACHO </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS GUIA DESPACHO</span>
          <div align="right">
          <?php  $fecha = date ("d-m-Y"); echo($fecha);?>
        </div>
      </div></td>
    </tr>
    <tr>
      <td height="372" colspan="2" valign="top"><form action="gd.php" method="post" name="frmDatos" id="frmDatos">
<table width="100%" border="0" align="center">
            <tr>
              <td width="18%" height="8"><input type="hidden" name="txt_numgd" size="20" maxlength="30" value="<?php echo($registrogd['num_gd']);?>" />
N&deg; Guia de Despacho</td>
              <td width="38%" height="8"><span class="Estilo24">
                <input name="txt_gd" type="text"onkeypress="return acceptNum(event)" value="<?php if (!empty($registrogd['num_gd'])) {echo ($registrogd['num_gd']);}else{echo($_POST["txt_gd"]) ;}?>" size="10" maxlength="10" disabled="disabled"/>
              </span></td>
              <td width="24%" height="8"  align="right">Fecha Emision</td>
              <td width="20%" height="8"><div align="left">
                <input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registrogd['fecha'])) {echo ($registrogd['fecha']);}else{echo($_POST["cal-field-1"]) ;}?>" size="10" maxlength="10" disabled="disabled"/>
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Rut</div></td>
              <td><div align="left">
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
				}?>" size="12" maxlength="12" disabled="disabled"/>
                <span class="Estilo20">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </span></div></td>
              <td>&nbsp;</td>
              <td height="8"  align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td colspan="3"><input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              <input  name="txt_codcli" type="hidden" value="<?php if (!empty($registrofact['cod_cliente'])) {echo ($registrofact['cod_cliente']);}else{echo($_POST["txt_codcli"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td colspan="3"><div align="left">
                <input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td colspan="3
              "><div align="left">
                <input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td colspan="3" align="left"><div align="left">
                <input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registro['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
						  // echo($sql3);
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Comuna</div></td>
              <td colspan="3" align="left"><div align="left">
                <input name="txt_comuna" type="text" value="<?php
			   if (!empty($registro['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
						  // echo($sql3);
						  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
						  $registrocom = mysql_fetch_array($rescom);
						  echo($registrocom['comuna']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Tel&eacute;fono</div></td>
              <td colspan="3"><div align="left">
                <input name="txt_cod_area" type="text" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled"/>
                <input name="txt_fono" type="text" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"/>
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Tipo</div></td>
              <td><textarea name="txt_tipo" cols="63" rows="4" disabled="disabled"><?php if (!empty($registrogd['tipo'])) {echo ($registrogd['tipo']);}else{echo($_POST["txt_tipo"]) ;}?></textarea></td>
              <td>&nbsp;</td>
              <td align="right">
              	<a href="impgd.php?num_gd=<?php echo $_GET['num_gd']?>&cod_arriendo=<?php echo $registrogd['id_arriendo']?>&imprimir=0">
              		<input name="impresion" type="image" value="Impresion" src="images/impresora.gif" align="right"class="oculto"  />				
              	</a>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="3" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" height="8"><table width="85%" border="0" align="center">
                <tr class="sortable">
                  <th></th>
                  <th><input type="hidden" name="txt_cod3" size="20" maxlength="30" />
                    <input type="hidden" name="txt_equipo2" size="25" maxlength="25" /></th>
                  <th></th>
                  <th></th>
                </tr>
                <tr class="sortable">
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Detalle</div></th>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Valor Unitario</div></th>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Total
                    <?php
		    if (empty($_GET["num_gd"])) $_GET["num_gd"]=0;
			$sqldet="SELECT 	distinct det_gd.num_gd, det_gd.cod_equipo, det_gd.cantidad, 
								det_gd.porcentaje_vu, det_gd.precio, det_gd.observaciones, 
								det_gd.accesorio
						FROM  det_gd 
							inner join gd
								on det_gd.num_gd = gd.num_gd
						where gd.num_gd = ".$_GET["num_gd"]." 
						order by gd.id_arriendo, det_gd.fila_num_gd ASC";
			//echo($sql);
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
                  </div></th>
                </tr>
                <tr bordercolor="#FFFFFF" class="sortable">
                  <td align="left"><?php echo($registrodet['cantidad']); ?></td>
                  <td align="left"><?php 
				  if (!empty($valor1))
					  {
						  $sqlnomrep="SELECT nombre_equipo FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
						  
						  $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
						  $registronrep = mysql_fetch_array($resnomrep);
						  echo htmlentities($registronrep['nombre_equipo']);
					  }else{
						  echo(" ");
					  }
			 ?>
                    <br />
                    <?php echo htmlentities($registrodet['observaciones']); ?></td>
                  <td align="right"><?php echo("$ ".number_format($registrodet['precio'], 0, ",", ".")) ;?></td>
                  <td align="right"><?php echo("$ ".number_format(($registrodet['precio'] * $registrodet['cantidad']), 0, ",", "."));  $costo_tot = $costo_tot + (($registrodet['precio'])*($registrodet['cantidad']));   ?>
                    <input type="hidden" name="txt_codrepuesto2"  value="<?php echo $registrodet['cod_equipo']?>" size="20" maxlength="30" /></td>
                </tr>
                <tr class="sortable">
                  <td bordercolor="#FFFFFF" class="CONT">------------------------</td>
                  <td height="15" bordercolor="#FFFFFF" class="CONT">--------------------------------------------------</td>
                  <td bordercolor="#FFFFFF" class="CONT">------------------------</td>
                  <td align="left" bgcolor="#FFFFFF">---------------------------------</td>
                </tr>
                <tr class="sortable">
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr class="sortable">
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <?php
				}
				mysql_free_result($resdet);
				mysql_close($link); 
		 ?>
                  <td class="CONT">&nbsp;</td>
                  <td class="CONT">&nbsp;</td>
                  <td class="CONT" align="right"><?php
				
				echo ("NETO: $".number_format($costo_tot, 0, ",", "."));
		 ?>
                    <input type="hidden" name="txt_sumcosto2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
                </tr>
                <tr>
                  <td height="8"></td>
                  <td height="8"></td>
                  <td height="8"></td>
                  <td height="8" align="right"><span class="CONT">
                    <?php
					$link=Conectarse();
				$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
				$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
				$registroiva = mysql_fetch_array($resiva);
				$valor_iva = $registroiva['valor_iva'];
				$iva = $costo_tot * ($valor_iva/100);
				
				echo ("IVA : $".number_format($iva, 0, ",", "."));
		 ?>
                    <input type="hidden" name="txt_iva3"  value="<?php echo $iva?>" size="20" maxlength="30" />
                  </span></td>
                </tr>
                <tr>
                  <td height="8"></td>
                  <td height="8"></td>
                  <td height="8"></td>
                  <td height="8" align="right"><span class="CONT">
                    <?php
				$total = $costo_tot + $iva;
				echo ("TOTAL $".number_format($total, 0, ",", "."));?>
                    <input type="hidden" name="txt_iva3"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
                  </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
        </table>
      </form></td>
    </tr>
  </table>
</div>
	<link rel="stylesheet" type="text/css" href="styles_menu.css" />
<script type="text/javascript" src="ie.js"></script>
</head>
</html>