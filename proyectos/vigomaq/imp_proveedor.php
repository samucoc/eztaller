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
  <table width="85%" height="335" border="0" align="center">
    <tr>	 
      <td width="320" height="31">&nbsp;</td>
      <td width="336"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
        <div align="right" class="Estilo19">
          <div align="right" class="Estilo20">
            <?php
				{
					include("conex.php");
					$link=Conectarse();
				}
			 ?>
            PROVEEDOR<br />
<input type="image" name="impresion" value="Impresion" src="images/impresora.gif" onclick="window.print();"  class="oculto" width="30" height="30"></div>
        </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS PROVEEDOR
        
      </span></div></td>
    </tr>
    <tr>
      <td height="276" colspan="2" align="left"><form  method="POST" name="frmDatos" id="frmDatos">
        <table width="104%" height="736" border="0">

            <tr>
              <td><span class="Estilo20">
                <?php
				{
					$valor1 = $_GET['id'];
					if (empty($valor1)){
					
					}else{
							$link=Conectarse();
							$sql = "SELECT cod_fabricante, cod_ciudad , cod_comuna, raz_social, Rut, Dv, Giro, cod_area, fono, movil, Direcc, email, inst_pago, contacto1, fono_cont1, email_cont1, contacto2, fono_cont2, email_cont2, contacto3, fono_cont3, email_cont3, observaciones FROM vigomaq_intranet.proveedor WHERE Rut ='$valor1'";
							
						
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							
					}
					
				}
			?>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><?php if (empty($registro['cod_fabricante'])){ }else{ echo " Código Proveedor: " ;}?></td>
              <td><?php if (empty($registro['cod_fabricante'])){ }else{ echo ":" ;}?></td>
              <td><div align="left"> <span class='mini_titulo'>
                <?php if (empty($valor1)){ }else{ 
				   $cantidad = strlen($registro['cod_fabricante']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_fabricante'] . ' ';  }		
				   
           ?>
            </span>
                    <?php } ?>
          </div> </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Rut</div></td>
              <td>:</td>
              <td><div align="left">

			  <input name="txt_rut" type="text" id="rut" value="<?php echo $registro['Rut']?>" size="12" maxlength="12" disabled="disabled"/>
</div></td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_giro" type="text" value="<?php if (!empty($registro['Giro'])) 
			{echo ($registro['Giro']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_direccion" type="text" value="<?php if (!empty($registro['Direcc'])) 
			{echo ($registro['Direcc']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td align="left">:</td>
              <td align="left">	<?php if (!empty($registro['cod_ciudad']))
			  {
				  $sql3="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
				  $res3 = mysql_query($sql3,$link) or die(mysql_error()); 
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['ciudad']);
			  }else{
				  echo(" ");
			  } ?></td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td><div align="left">Comuna</div></td>
              <td align="left">:</td>
              <td align="left"><div align="left">
			  <?php if (!empty($registro['cod_comuna']))
			  {
				  $sql3="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
				  $res3 = mysql_query($sql3,$link) or die(mysql_error()); 
				  $registro3 = mysql_fetch_array($res3);
				  echo($registro3['comuna']);
			  }else{
				  echo(" ");
			  } ?>
         </div>
              </td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td><div align="left">Fono</div></td>
              <td>:</td>
              <td><div align="left">
                <input name="txt_cod_area" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled"/>
                
                <input name="txt_fono" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono'])) 
			{echo ($registro['fono']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"/>
              </div></td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td><div align="left">Movil</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_movil" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil'])) 
			{echo ($registro['movil']);}else{echo($_POST["txt_movil"]) ;}?>" size="9" maxlength="9" disabled="disabled"/>
              </div></td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td><div align="left">e-mail</div></td>
              <td align="left">:</td>
              <td align="left"><input name="txt_email" type="text" onkeypress="return verify_email(event)" value="<?php if (!empty($registro['email'])) 
			{echo ($registro['email']);}else{echo($_POST["txt_email"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td><div align="left">Instrumento de Pago</div></td>
              <td>:</td>
              <td><input name="txt_instpago" type="text" value="<?php if (!empty($registro['inst_pago'])) 
			{echo ($registro['inst_pago']);}else{echo($_POST["txt_instpago"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                <p>Contacto (1)</p>
                </div></td>
              <td>:</td>
              <td><div align="left">
                <input  name="txt_contacto1" type="text" value="<?php if (!empty($registro['contacto1'])) 
			{echo ($registro['contacto1']);}else{echo($_POST["txt_contacto1"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                <p>Tel&eacute;fono</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                <input  name="txt_fonocont1" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono_cont1'])) 
			{echo ($registro['fono_cont1']);}else{echo($_POST["txt_fonocont1"]) ;}?>" size="9" maxlength="9" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                <p>email</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                <input  name="txt_emailcont1" type="text" value="<?php if (!empty($registro['email_cont1'])) 
			{echo ($registro['email_cont1']);}else{echo($_POST["txt_emailcont1"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
</div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                  <p>Contacto (2)</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_contacto2" type="text" value="<?php if (!empty($registro['contacto2'])) 
			{echo ($registro['contacto2']);}else{echo($_POST["txt_contacto2"]) ;}?>" size="50" maxlength="50" disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                  <p>Tel&eacute;fono</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_fonocont2" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono_cont2'])) 
			{echo ($registro['fono_cont2']);}else{echo($_POST["txt_fonocont2"]) ;}?>" size="9" maxlength="9"disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                  <p>email</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_emailcont2" type="text" value="<?php if (!empty($registro['email_cont2'])) 
			{echo ($registro['email_cont2']);}else{echo($_POST["txt_emailcont2"]) ;}?>" size="50" maxlength="50"disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                  <p>Contacto (3)</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_contacto3" type="text" value="<?php if (!empty($registro['contacto3'])) 
			{echo ($registro['contacto3']);}else{echo($_POST["txt_contacto3"]) ;}?>" size="50" maxlength="50"disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                  <p>Tel&eacute;fono</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_fonocont3" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono_cont3'])) 
			{echo ($registro['fono_cont3']);}else{echo($_POST["txt_fonocont3"]) ;}?>" size="9" maxlength="9"disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                  <p>email</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                <input  name="txt_emailcont3" type="text" value="<?php if (!empty($registro['email_cont3'])) 
			{echo ($registro['email_cont3']);}else{echo($_POST["txt_emailcont3"]) ;}?>" size="50" maxlength="50"disabled="disabled"/>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">Observaciones</div></td>
              <td valign="top">:</td>
              <td><textarea name="txt_observaciones" cols="75" rows="7" disabled="disabled"><?php if (!empty($registro['observaciones'])) 
			{echo ($registro['observaciones']);}else{echo($_POST["txt_observaciones"]) ;}?>
              </textarea></td>
              <td align="left" valign="bottom">&nbsp;</td>
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