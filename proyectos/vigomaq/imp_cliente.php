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
</head>
<body>
<div id="text" style="float:left; clear:center; width:80%; margin-top:10px">
  <script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
  </script>
  <table width="80%" height="405" border="0" align="center">
    <tr>
      <td width="559" height="31">&nbsp;</td>
      <td width="559"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
        <div align="right" class="Estilo19">
          <div align="right" class="Estilo20">
            <?php
				{
					include("conex.php");
					$link=Conectarse();
				}
			 ?>
            <?php
				{
					$valor1 = $_GET['id'];
				    if (empty($valor1)) $valor1 = $_POST['txt_rut'];
					if (empty($valor1)) $valor1 = $_GET['txt_rut'];
				
					
					if (empty($valor1)){

					}else{
							$link=Conectarse();
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM vigomaq_intranet.clientes WHERE rut_cliente ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);

					}
					
				}
			?>
            CLIENTE
            <br /><input type="image" name="impresion" value="Impresion" src="images/impresora.gif" onclick="window.print();" width="30" height="30" class="oculto" />
            
</div>
        </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS CLIENTES</span></div></td>
    </tr>
    <tr>
      <td height="350" colspan="2" valign="top">
            <form method="POST" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td><?php if (empty($registro['cod_cliente'])){ }else{ echo " C&oacute;digo Cliente: " ;}?></td>
              <td><?php if (empty($registro['cod_cliente'])){ }else{ echo ":" ;}?></td>
              <td><span class='mini_titulo'>
                <?php if (empty($valor1)){ }else{ 
				   $cantidad = strlen($registro['cod_cliente']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_cliente'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_cliente'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_cliente'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_cliente'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_cliente'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_cliente'] . ' ';  }		
				   
           ?>
              </span>
                <?php } ?></td>
              <td>&nbsp;</td>
               <td></td>
            </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social </div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Rut<span class="Estilo20">
              </span></div></td>
              <td>: </td>
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
				}?>" size="12" maxlength="12"  />
                <span class="Estilo20">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </span></div>
              
              </td>
            </tr>
            <tr>
              <td><div align="left">Tipo Cliente</div></td>
              <td>: </td>
              <td colspan="3"><?php if (!empty($registro['cod_tipocli']))
			  {
				  $sql5="SELECT tipo_cliente FROM tipo_cliente where cod_tipocli =".$registro['cod_tipocli'];
				  $res5= mysql_query($sql5,$link) or die(mysql_error()); 
				  $registro5 = mysql_fetch_array($res5);
				  echo($registro5['tipo_cliente']);
			  }else{
				  echo(" ");
			  } ?></td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td>:</td>
              <td align="left"><div align="left">
                <?php if (!empty($registro['cod_ciudad']))
			  {
				  $sql3="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
				  $res3 = mysql_query($sql3,$link) or die(mysql_error()); 
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['ciudad']);
			  }else{
				  echo(" ");
			  } ?>
              </div></td>
              <td align="left"><div align="right">Comuna:</div></td>
                  <td align="left"><?php if (!empty($registro['cod_comuna']))
			  {
				  $sql3="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
				  $res3 = mysql_query($sql3,$link) or die(mysql_error()); 
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['comuna']);
			  }else{
				  echo(" ");
			  } ?></td>
            </tr>
            
            <tr>
              <td><div align="left">Fono</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_cod_area" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" />
                  <input name="txt_fono" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" />
              </div></td>
              <td><div align="right">Movil:</div></td>
              <td><div align="left">
                <input name="txt_movil" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil_cliente'])) 
			{echo ($registro['movil_cliente']);}else{echo($_POST["txt_movil"]) ;}?>" size="9" maxlength="9" />
              </div></td>
            </tr>
            
            <tr>
              <td><div align="left">Responsable Empresa (1)</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_respemp" type="text" value="<?php if (!empty($registro['nom_resp_emp1'])) 
			{echo ($registro['nom_resp_emp1']);}else{echo($_POST["txt_respemp"]) ;}?>" size="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Cargo</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_cargoresp1" type="text" value="<?php if (!empty($registro['cargo_resp1'])) 
			{echo ($registro['cargo_resp1']);}else{echo($_POST["txt_cargoresp1"]) ;}?>" size="25" maxlength="25" /></td>
            </tr>
            <tr>
              <td><div align="left"> Movil</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_movilresp1" type="text" onkeypress="return acceptNum(event)"  value="<?php if (!empty($registro['movil_resp1'])) {echo($registro['movil_resp1']);}else{echo($_POST["txt_movilresp1"]);}?>" size="9" maxlength="9" /></td>
            </tr>
            <tr>
              <td><div align="left"> e-mail</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailresp1" type="text" value="<?php if (!empty($registro['email_resp_emp1'])) 
			{echo ($registro['email_resp_emp1']);}else{echo($_POST["txt_emailresp1"]) ;}?>" size="50" maxlength="50" /></td>
            </tr>
            
            <tr>
              <td><div align="left">Responsable Empresa (2)</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_respemp2" type="text" value="<?php if (!empty($registro['nom_resp_emp2'])) 
			{echo ($registro['nom_resp_emp2']);}else{echo($_POST["txt_respemp2"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Cargo</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_cargoresp2" type="text" value="<?php if (!empty($registro['cargo_resp2'])) 
			{echo ($registro['cargo_resp2']);}else{echo($_POST["txt_cargoresp2"]) ;}?>" size="25" maxlength="25" /></td>
            </tr>
            <tr>
              <td><div align="left">Movil</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_movilresp2" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil_resp2'])) 
			{echo ($registro['movil_resp2']);}else{echo($_POST["txt_movilresp2"]) ;}?>" size="9" maxlength="9" /></td>
            </tr>
            <tr>
              <td><div align="left"> e-mail</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailresp2" type="text" value="<?php if (!empty($registro['email_resp_emp2'])) 
			{echo ($registro['email_resp_emp2']);}else{echo($_POST["txt_emailresp2"]) ;}?>" size="50" maxlength="50" /></td>
            </tr>
            
            <tr>
              <td><div align="left">Responsable Empresa (3)</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_respemp3" type="text" value="<?php if (!empty($registro['nom_resp_emp3'])) 
			{echo ($registro['nom_resp_emp3']);}else{echo($_POST["txt_respemp3"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Cargo</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_cargoresp3" type="text" value="<?php if (!empty($registro['cargo_resp3'])) 
			{echo ($registro['cargo_resp3']);}else{echo($_POST["txt_cargoresp3"]) ;}?>" size="25" maxlength="25" /></td>
            </tr>
            <tr>
              <td><div align="left">Movil</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_movilresp3" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil_resp3'])) 
			{echo ($registro['movil_resp3']);}else{echo($_POST["txt_movilresp3"]) ;}?>" size="9" maxlength="9" /></td>
            </tr>
            <tr>
              <td><div align="left"> e-mail</div></td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailresp3" type="text" value="<?php if (!empty($registro['email_resp_emp3'])) 
			{echo ($registro['email_resp_emp3']);}else{echo($_POST["txt_emailresp3"]) ;}?>" size="50" maxlength="50" /></td>
            </tr>
            
            <tr>
              <td colspan="5">Condiciones env&iacute;o de
              factura:</td>
            </tr>
            <tr>
              <td colspan="5"><div align="center">
                <textarea name="txt_condicenv" cols="65" rows="6"><?php if (!empty($registro['cond_env_fact'])) 
			{echo ($registro['cond_env_fact']);}else{echo($_POST["txt_condicenv"]) ;}?>
                      </textarea>
              </div></td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3"><div align="right"></div></td>
            </tr>             
          </table> 
      </form></td>
    </tr>
  </table>
  <br />
</div>
	<link rel="stylesheet" type="text/css" href="styles_menu.css" />
	<script type="text/javascript" src="ie.js"></script>
</head>
</body>
</html>