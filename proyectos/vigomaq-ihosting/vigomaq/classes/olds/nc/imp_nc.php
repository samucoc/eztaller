<?php ob_start("ob_gzhandler"); 
session_start(); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}

include('vista-previa-nc.php');

if(isset($html)){
    $pdf=new PDF();
    $pdf->Open();
    $pdf->SetCreator("HTML2PDF");
    $pdf->SetTitle($title);
    $pdf->SetSubject($subject);
    $pdf->SetAuthor($author);
    $pdf->SetFont('Arial', '', 12);
    $pdf->AddPage();
    if(ini_get('magic_quotes_gpc')=='1')
        $html=stripslashes($html);
    $pdf->WriteHTML($html);
    //save and redirect
    $pdf->Output('nc_'.$num_nc.'.pdf');
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
				?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="../../css/style.css" type="text/css" />
<script type="text/javascript">
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
<script type="text/javascript" src="../../script.js"></script>
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
<div id="text" style="float:left; clear:left; width:80%; margin-top:10px">
  <script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
  </script>
  <table width="80%" height="427" border="0" align="center">
    <tr>
      <td width="52%" height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo11 Estilo20">
          <div align="right" class="Estilo21">
            <div align="left" class="Estilo13"></div>
          </div>
      </div></td>
      <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13"> <?php
				{
					include("../conex.php");

					$link=Conectarse();
				}
			 ?>
            <?php
					if (empty($nota_credito)) $nota_credito = $_GET['num_nc'];
					$link=Conectarse();

					$sqlfact = "SELECT * FROM nota_credito WHERE num_nota_cred ='$nota_credito'";						
					
					$resncred = mysql_query($sqlfact,$link) or die(mysql_error()); 
					$registroncred = mysql_fetch_array($resncred);
					$nc=$registroncred['num_nota_cred'];
					$cod_cli=$registroncred['cod_cliente'];
					
					$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
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
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM clientes WHERE rut_cliente ='$valor1'";
							
							
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
			?>NOTA DE CREDITO </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS NOTA DE CREDITO
          <div align="right">
          <?php  $fecha = date ("d-m-Y"); echo($fecha);?>
        </div></span>
      </div></td>
    </tr>
    <tr>
      <td height="372" colspan="2" valign="top"><form method="post" name="frmDatos" id="frmDatos" action="<?php echo $PHP_SELF; ?>">
          <table width="100%" border="0" align="left">
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" height="8"></td>
            </tr>
            <tr>
              <td><input type="hidden" name="txt_numfact" size="20" maxlength="30" value="<?php echo($registroncred['num_nota_cred']);?>" />
              <strong>N&deg; Nota Credito</strong></td>
              <td><span class="Estilo24">
                <input name="txt_nc" type="text"onkeypress="return acceptNum(event)" value="<?php 
				 if (!empty($registroncred['num_nota_cred'])){ 
				   $cantidad = strlen($registroncred['num_nota_cred']); 
				   if ($cantidad==1) { echo ("00000000" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000000" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==3) { echo ("000000" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==4) { echo ("00000" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==5) { echo ("0000" .('' . $registroncred['num_nota_cred'] . ' ') );  } 
				   if ($cantidad==6) { echo ("000" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==7) { echo ("00" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==8) { echo ("0" .('' . $registroncred['num_nota_cred'] . ' ') );  }
				   if ($cantidad==9) { echo ('' . $registroncred['num_nota_cred'] . '') ;}
			}else{echo($_POST['txt_nc']);}
			?>" size="10" maxlength="10" disabled="disabled"/>
              </span></td>
              <td height="8" align="right">N&deg; Factura</td>
              <td height="8">:<span class="Estilo241">
                <input name="txt_factura" type="text"value="<?php if (!empty($registroncred['num_factura'])) {echo ($registroncred['num_factura']);}?>" size="10" maxlength="10" disabled="disabled"/>
              </span></td>
              <td height="8">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Rut</div></td>
              <td colspan="3"><div align="left">
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
              <td align="center" valign="middle"><input  name="txt_codcli" type="hidden" value="<?php if (!empty($registroncred['cod_cliente'])) {echo ($registroncred['cod_cliente']);}else{echo($_POST["txt_codcli"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td colspan="3"><input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td colspan="3"><div align="left">
                <input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td colspan="3"><div align="left">
                <input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
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
              <td>&nbsp;</td>
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
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Tel&eacute;fono</div></td>
              <td colspan="3"><div align="left">
                <input name="txt_cod_area" type="text" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled"/>
                <input name="txt_fono" type="text" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Referencias</div></td>
              <td colspan="3"><textarea name="txt_referencias" cols="63" rows="4" disabled="disabled"><?php if (!empty($registroncred['referencias'])) {echo ($registroncred['referencias']);}else{echo($_POST["txt_referencias"]) ;}?>
                      </textarea></td>
              <td>&nbsp;</td>
            </tr>
            <tr class="sortable">
              <th></th>
              <th><input type="hidden" name="txt_cod2" size="20" maxlength="30" />
                <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
              <th></th>
              <th></th>
              <th align="right"></th>
            </tr>
            <tr class="sortable">
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Detalle</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Valor Unitario</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Total
                <?php 
		?>
              </div></th>
              <th>&nbsp;</th>
            </tr>
            <tr bordercolor="#FFFFFF" class="sortable">
              <td align="left"><?php echo("1");?></td>
              <td align="left"><?php echo($registroncred['nombre']);?></td>
              <td align="right"><?php echo("$".number_format($registroncred['monto_nc'], 0, ",", ".")) ;?></td>
              <td align="right"><?php echo("$".number_format($registroncred['monto_nc'], 0, ",", "."));?>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr class="sortable">
              <td bordercolor="#FFFFFF" class="CONT">--------------</td>
              <td height="15" bordercolor="#FFFFFF" class="CONT">--------------------------------</td>
              <td bordercolor="#FFFFFF" class="CONT">---------------------</td>
              <td align="left" bgcolor="#FFFFFF">------------------</td>
              <td class="CONT">&nbsp;</td>
            </tr>
            <tr class="sortable">
              <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
              <td class="CONT">&nbsp;</td>
            </tr>
            <tr class="sortable">
              <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td class="CONT">&nbsp;</td>
              <td class="CONT">&nbsp;</td>
              <td class="CONT" align="right"><?php
				
				echo ("TOTAL: ".$registroncred['monto_nc']);
		 ?>
              <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
              <td class="CONT"><input type="image" name="impresion" value="Impresion" src="../../images/impresora.gif" width="25" height="25" title="Imprimir Nota de Credito"  class="oculto" /></td>
            </tr>
          </table>
      </form></td>
    </tr>
  </table>
</div>
	<link rel="stylesheet" type="text/css" href="../../styles_menu.css" />
	<script type="text/javascript" src="../../ie.js"></script>
</head>
</html>