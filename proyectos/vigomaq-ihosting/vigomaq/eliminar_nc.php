<?php ob_start(); 
session_start(); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<?php
require_once('classes/tc_calendar.php');
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
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
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
       <span class="Estilo23">Sistema de Arriendo y Facturación - Vigomaq</span></div></td>
   </tr>
</table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><table width="100%" border="0">
  <tr>
    <td height="592"><table width="95%" border="0" align="center">
      <tr>
        <td width="80%" ><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php

  	    {
			include("classes/conex.php");
			$link=Conectarse();
	    }

	 ?>
     <?php
		 $num_nc =  $_GET["num_nc"];
		 if (empty($num_nc)) {
			 $num_nc = $_POST['num_nc'];
			 }
		 $link=Conectarse();
		$sqlnc     = "SELECT * FROM nota_credito WHERE num_nota_cred ='$num_nc'";
		$resnc          = mysql_query($sqlnc,$link) or die(mysql_error()); 
		$registronc     = mysql_fetch_array($resnc);
	 ?>
            <?php
			{
				$num_factura =  $registronc['num_factura'];
			 
				if (!empty($num_factura))
				{
				
					$link=Conectarse();
					//busca factura
					$sqlfact     = "SELECT * FROM factura WHERE num_factura ='$num_factura' ";
				 	
					$res          = mysql_query($sqlfact,$link) or die(mysql_error()); 
					$registro     = mysql_fetch_array($res);
					$cod_cliente  = $registro['cod_cliente'];
					$cod_arriendo = $registro['cod_arriendo'];
					$cod_obra     = $registro['cod_obra'];
					$gd           = $registro['gd_rep'];
					//buscar cliente
					$sqlcli   = "SELECT * FROM clientes WHERE cod_cliente ='$cod_cliente'";
		
					$rescli       = mysql_query($sqlcli,$link) or die(mysql_error()); 
					$registrocli = mysql_fetch_array($rescli);
					$cliente     = $registrocli['raz_social'];
					
							

				}
			}
		 ?>
            NOTA DE CREDITO</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><form action="eliminar_nc.php" method="post"  name="frmDatos" id="frmDatos">
          <table width="100%" height="544" border="0" align="center">
            <tr>
              <td colspan="7" bgcolor="#06327D"><span class="Estilo24">DATOS NOTA DE CREDITO</span><span class="Estilo24">
                <div align="right">
                  <?php  $fecha = date ("d-m-Y");?>
                </div>
              </span></td>
            </tr>
            <tr>
              <td colspan="7"></td>
            </tr>
            <tr>
              <td width="18%">N&deg; Nota Credito</td>
              <td width="1%">:</td>
              <td width="18%"><span class="Estilo241">
                <input name="num_nc" type="text"value="<?php 
					if (!empty($_GET["num_nc"])){
						echo($_GET["num_nc"]);
					}else{
						echo $_POST['num_nc'];
						}?>" size="10" maxlength="10" />
                <input type="submit" name="buscarfactura" title="Buscar Nota Crédito" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
              </span></td>
              <td width="28%" height="8"  align="right">Fecha Emision Nota Credito</td>
              <td height="8" colspan="2"><div align="left">
                <input name="cal-field-1" type="text" disabled="disabled" id="cal-field-1" value="<?php if (!empty($registronc['fecha'])) {echo ($registronc['fecha']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha'];?>" size="10" maxlength="10"/>
              </div></td>
              <td width="14%">&nbsp;</td>
            </tr>
            <tr>
              <td height="8" colspan="7" bgcolor="#06327D"><span class="Estilo24">DATOS FACTURA</span></td>
              </tr>
            <tr>
              <td height="8">N&deg; Factura</td>
              <td height="8">:</td>
              <td height="8"><span class="Estilo241">
                <input name="txt_factura" type="text" disabled="disabled"value="<?php 
						if (!empty($registro['num_factura'])){
							echo $registro['num_factura'];
							}
						elseif (!empty($_POST["txt_factura"])) {
							echo ($_POST["txt_factura"]);
						}else{ 
							echo($_GET["txt_factura"]);
							}?>" size="10" maxlength="10" />
              </span></td>
              <td height="8" align="right">Fecha Emision Factura</td>
              <td height="8" colspan="2"><input name="fecha" type="text" id="cal-field-2" value="<?php if (!empty($registro['fecha'])) {echo ($registro['fecha']);}?>" size="10" maxlength="10" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Cliente</div></td>
              <td>:</td>
              <td colspan="4"><input name="txt_cliente" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Giro</div></td>
              <td>:</td>
              <td colspan="4"><input name="txt_giro" type="text" value="<?php if (!empty($registrocli['giro_cliente'])) {echo ($registrocli['giro_cliente']);}else{echo($_GET['txt_giro']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Direcci&oacute;n</div></td>
              <td>:</td>
              <td colspan="4"><input name="txt_direcc" type="text" value="<?php if (!empty($registrocli['direcc_cliente'])) {echo ($registrocli['direcc_cliente']);}else{echo($_GET['txt_direcc']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Ciudad</div></td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registrocli['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registrocli['cod_ciudad'];
						  // echo($sql3);
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Comuna</div></td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_comuna" type="text" value="<?php
			   if (!empty($registrocli['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registrocli['cod_comuna'];
						  // echo($sql3);
						  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
						  $registrocom = mysql_fetch_array($rescom);
						  echo($registrocom['comuna']);
					  }else{
						  echo(" ");
					  } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Tel&eacute;fono</div></td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_fono" type="text" value="<?php if (!empty($registrocli['fono_cliente'])) {echo ($registrocli['fono_cliente']);}else{echo($_GET['txt_fono']);}?>" size="8" maxlength="8" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24">Guia despacho </td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_cliente7" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?><?php // =$_GET['nomequipo'];?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="85"><div align="left">Condiciones envio</div></td>
              <td>:</td>
              <td colspan="4" align="left"><textarea name="txt_condic" cols="50" rows="5" disabled="disabled"><?php if (!empty($registrocli['cond_env_fact'])) {echo ($registrocli['cond_env_fact']);}else{echo($_GET['txt_condic']);}?>
              </textarea></td>
              <td><a href="eliminar_nc.php" class="menulink">
                <input name="Limpiar" type="image" title="Limpiar"  width="42" height="42" value="Limpiar"  src="images/clean.png"/>
                </a>
                <input type="submit" name="borrar" id="borrar" value="Borrar" title="Eliminar Nota Credito" onclick="return confirm('Desea eliminar?');" style="background-image:url(images/anular_fact.png); width:48px; height:48px;" class="formato_boton" align="right" />
                </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td align="right"></td>
              <td align="right"></td>
              <td colspan="2" align="right"></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="7">
              <table class="sortable" id="tabla-pre" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                <tr class="Estilo17">
                  <th width="9%" align="center" bgcolor="#06327D" class="Estilo17">Cantidad</th>
                  <th width="67%" align="center" bgcolor="#06327D" class="CONT">Observaciones</th>
                  <th width="12%" align="center" bgcolor="#06327D" class="CONT">Precio Unitario</th>
                  <th width="12%" align="center" bgcolor="#06327D" class="CONT">Monto</th>
                  </tr>
                <?php 
				
				$num_nc =  $_GET["num_nc"];
				if (empty($num_nc)) {
					$num_nc = $_POST['num_nc'];
					}
				$link=Conectarse();
				$sqlnc = "SELECT * FROM det_nc WHERE num_nc ='$num_nc'";
				$resnc = mysql_query($sqlnc,$link) or die(mysql_error()); 
				while ($registronc  = mysql_fetch_array($resnc)){
				?>
                <tr>
                  <td align="center"><?php echo $registronc['cantidad']?></td>
                  <td align="center"><?php echo $registronc['referencias'];?></td>
                  <td align="center"><?php echo $registronc['monto']; ?></td>
                  <td align="center"><?php echo $registronc['cantidad']*$registronc['monto']; 
				  			$costo_tot = $costo_tot + ($registronc['cantidad']*$registronc['monto']); ?></td>
                  </tr>
                <?php }?>
                </table>
                <table width="100%" border="0" align="center">
                  <tr class="sortable">
                    <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                    <td class="CONT"></td>
                    <td class="CONT">&nbsp;</td>
                    <td align="right" class="CONT"><?php
								echo ("<div id='neto'>NETO: $".number_format($costo_tot, 0, ",", ".")."</div>");
		 ?>
                      <input type="hidden" name="txt_sumcosto" id="txt_sumcosto"  value="<?php echo number_format($costo_tot, 0, ",", "")?>" size="20" maxlength="30" /></td>
                    <td class="CONT">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="8"></td>
                    <td height="8"></td>
                    <td height="8"></td>
                    <td height="8" align="right"><span class="CONT">
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
				
				echo ("<div id='iva'>IVA : $".number_format($iva, 0, ",", ".")."</div>");
		 ?>
                      <input type="hidden" name="txt_iva" id="txt_iva"  value="<?php echo number_format($iva, 0, ",", "")?>" size="20" maxlength="30" />
                      </span></td>
                    <td height="8"></td>
                    </tr>
                  <tr>
                    <td height="8"></td>
                    <td height="8"></td>
                    <td height="8"></td>
                    <td height="8" align="right"><span class="CONT">
                      <?php
				$total = $costo_tot + $iva;
				
				echo ("<div id='total'>TOTAL : $".number_format($total, 0, ",", ".")."</div>");
		 ?>
                      <input type="hidden" name="total" id="total"  value="<?php echo number_format($total, 0, ",", "")?>" size="20" maxlength="30" />
                      </span></td>
                    <td height="8"></td>
                    </tr>
                  </table>

  </td>
            </tr> <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_rut']))
				{  
					$link=mensaje();
				} else {
					
				};
			}
	  ?>
	<?php
    function mensaje()
        {
            echo "<script>
            alert('Ingrese número de nota de credito, fecha y/o número de factura');
            </script>";
        }
	if ($_POST['borrar']=='Borrar'){
		$num_nc = $_POST['num_nc'];
		if (empty($num_nc)){
			echo "<script> alert (\"Nota de Crédito no encontrada.\"); </script>";
			}
		else{
			$link = Conectarse();
			$sql_5  = " delete
						from nota_credito
						where num_nota_cred='$num_nc'";
			$res_5  = mysql_query($sql_5,$link) or die(mysql_error());
			$sql_3  = " delete	
						from det_nc
						where num_nc='$num_nc'";
			$res_3  = mysql_query($sql_3,$link) or die(mysql_error());
			echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			echo "<script language=Javascript> location.href=\"menu.php\"; </script>";	

			}
		}
	?>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>


</body>

</html>
