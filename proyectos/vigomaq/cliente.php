<?php ob_start(); 
session_start(); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
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
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="css/style.css" type="text/css" />
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
function rut_formato(valor){
	valor = document.frmDatos.rut.value;
	largo = valor.length; 
	if(largo < 12){
		if(largo == 9){
			uno = valor.substring(0, 1);
			dos = valor.substring(1, 4);
			tres = valor.substring(4, 7);
			cuatro = valor.substring(7);
			//salida = uno+'.'+dos+'.'+tres+'-'+cuatro;
			salida = uno+'.'+dos+'.'+tres+cuatro;
			}
		else{
			uno = valor.substring(0, 2);
			dos = valor.substring(2, 5);
			tres = valor.substring(5, 8);
			cuatro = valor.substring(8);
			//salida = uno+'.'+dos+'.'+tres+'-'+cuatro;
			salida = uno+'.'+dos+'.'+tres+cuatro;
			}
		document.frmDatos.rut.value = salida;
		}
	if(largo == 0){
		salida = '';
		document.frmDatos.rut.value = salida;
		}
	}
</script>
<script type="text/javascript" src="script.js"></script>
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
.Estilo22 {color: #FF0000}
-->
</style>
<script type="text/javascript">
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con Exito!");
}
 //-->
</script>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("Cliente no ha sido ingresado!");
}
 //-->
</script>
<script language="text/javascript">
function confirmReemp()
{
	var agree=confirm("¿Realmente desea actualizar? ");
	if (agree) return true ;
	else return false ;
	
}
</script>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
                       <table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <br />
       <span class="Estilo23 Estilo21">Sistema de Arriendo y Facturación - Vigomaq</span></div></td>
   </tr>
</table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="80%" height="405" border="0" align="center">
    <tr>
      <td width="559" height="31">&nbsp;</td>
      <td width="559"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
        <div align="right" class="Estilo19">
          <div align="right" class="Estilo20">
            <?php
				{
					include("classes/conex.php");
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
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM clientes WHERE rut_cliente = '$valor1'";
														
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							if(mysql_num_rows($res)==0){
								$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM clientes WHERE cod_cliente ='$valor1'";
								$res = mysql_query($sql,$link) or die(mysql_error()); 
								}
							$registro = mysql_fetch_array($res);
							$codigocli = $registro['cod_cliente'];
							
							if (empty($registro['rut_cliente']) && $_POST["buscar"]=="Buscar")
							{
								echo "<script>
								alert('Cliente No Ingresado');
								</script>";
							}else{ 
							
							}
							
							  $resultobras="SELECT COUNT(*) as filas FROM obra WHERE cod_cliente ='$codigocli'";
							  $rs_busqueda=mysql_query($resultobras) or die(mysql_error()); 
							  $filas=mysql_result($rs_busqueda,0,"filas");
							  if ($filas<1)
							   {
								  echo "<script>alert('No existen Obras asociadas a este Cliente');</script>";
							   }
					}
					
				}
			?>
            <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
           	  
		}else{
			  $estado_objetos = 'disabled';
           	  
		};
		?>
            CLIENTES/OBRAS.</div>
        </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS CLIENTES</span></div></td>
    </tr>
    <tr>
      <td height="350" colspan="2" valign="top">
            <?php
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
				case 1 : echo "<script> alert (\"Ingrese Rut Cliente\"); </script>"; break;
				case 2 : echo "<script>	alert (\"El Rut no cuenta con el mínimo de caracteres necesarios para validarlo\");					</script>"; break;
				case 4 : echo "<script>	alert (\"El Rut o el dígito viene vacío\");</script>"; break;
				case 5 : echo "<script>	alert (\"El Rut y el dígito no coinciden\");</script>"; break;
				default: echo "<script>	alert (\"Error\");</script>"; break;
			  }
			
			}
		?> <form method="POST" name="frmDatos" id="frmDatos">
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
               <td><?php
				if (!empty($registro['cod_cliente'])) 
					{
					//$tipo_btn="image";
					$tipo_btn="button";
				}else{
					$tipo_btn="hidden";}
					?>
                    <a href='obras.php?id=<?php echo $registro['cod_cliente'];?>' class="boton">
			
            <input name="buscar2" type=<?php echo($tipo_btn);?> value="Buscar" title="Ingresar Obras" align="right" style="background-image:url(images/obras.jpg); width:64px; height:64px;" class="formato_boton"/>
            
             <!--<input name="buscar2" type=<?php echo($tipo_btn);?> class="searchbutton" title="Ingresar Obras" value="Buscar" src="images/obras.jpg" align="right" />-->
             
             </a></td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Rut<span class="Estilo20"> </span></div></td>
              <td>: </td>
              <td colspan="3"><div align="left">
                <input name="txt_rut" type="text" id="rut" value="<?php 
			  if ((($registro['rut_cliente'])!= "") && (empty($registro['cod_cliente'])))
			  {		$rut_param =$_POST['txt_rut'];
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
				}?>" size="12" maxlength="12"  onblur="checkRutGenerico(this, true)" />
                <input type="submit" name="buscar" value="Buscar"  title="Buscar Cliente" style="background-image:url(images/ver.png); height:16px; width:16px;" class="formato_boton"/>
                
                <!--<input type="image" name="buscar" value="Buscar" title="Buscar Cliente" class="searchbutton" src="images/ver.png"/>-->
                <span class="Estilo20">
                  <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </span>[11.111.111-1]</div></td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Raz&oacute;n Social </div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Tipo Cliente</div></td>
              <td>: </td>
              <td colspan="3"><?php
			$sql3="SELECT cod_tipocli, tipo_cliente FROM tipo_cliente order by tipo_cliente ASC";
  			$res3=mysql_query($sql3,$link) or die(mysql_error());	
			
			echo "<select name=tipocli>\n"; 

			while($campos3=mysql_fetch_row($res3))
			{	
			   if ($registro['cod_tipocli']==$campos3[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos3[0].",".$campos3[1]?>" <?php echo $selected?>>
                    <?php echo $campos3[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo3 = explode( ',', $_POST['tipocli'] );
					$cargo_id3 = $cargo3[0];
					$cargo_contenido3 = $cargo3[1];  
					echo $campos3; 
		 ?></div>                </td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Giro</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Direcci&oacute;n</div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                  <input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Ciudad</div></td>
              <td>:</td>
              <td align="left"><div align="left">
                <?php
			$sql="SELECT cod_ciudad, ciudad FROM ciudad order by ciudad ASC";
  			$res=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=ciudad>\n"; 

			while($campos1=mysql_fetch_row($res))
			{	
               if ($registro['cod_ciudad']==$campos1[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos1[0].",".$campos1[1]?>" <?php echo $selected?>>
                  <?php echo $campos1[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo1 = explode( ',', $_POST['ciudad'] );
					$cargo_id1 = $cargo1[0];
					$cargo_contenido1 = $cargo1[1];  
					echo $campos1; 
		 ?></div>
              </div></td>
              <td align="left"><div align="right"><span class="Estilo22">(*)</span> Comuna:</div></td>
                  <td align="left"><div align="left">
                     <?php
			$sql="SELECT cod_comuna, comuna FROM comuna order by comuna ASC";
  			$res2=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=comuna>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro['cod_comuna']==$campos2[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos2[0].",".$campos2[1]?>" <?php echo $selected?>>
                  <?php echo $campos2[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo2 = explode( ',', $_POST['comuna'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?></div>
              </div></td>
                  <div align="left"> </div>
            </tr>
            
            <tr>
              <td><div align="left">Fono</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_cod_area" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" />
                  <input name="txt_fono" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="7"  />
              </div></td>
              <td><div align="right">Movil:</div></td>
              <td><div align="left">
                <input name="txt_movil" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil_cliente'])) 
			{echo ($registro['movil_cliente']);}else{echo($_POST["txt_movil"]) ;}?>" size="8" maxlength="8" />
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
              <td colspan="3" align="left"><input name="txt_movilresp1" type="text" onkeypress="return acceptNum(event)"  value="<?php if (!empty($registro['movil_resp1'])) {echo($registro['movil_resp1']);}else{echo($_POST["txt_movilresp1"]);}?>" size="8" maxlength="8" /></td>
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
			{echo ($registro['movil_resp2']);}else{echo($_POST["txt_movilresp2"]) ;}?>" size="8" maxlength="8" /></td>
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
			{echo ($registro['movil_resp3']);}else{echo($_POST["txt_movilresp3"]) ;}?>" size="8" maxlength="8" /></td>
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
              <td height="101" colspan="5"><div align="center"><textarea name="txt_condicenv" cols="65" rows="6"><?php if (!empty($registro['cond_env_fact'])){echo ($registro['cond_env_fact']);}else{echo($_POST["txt_condicenv"]);}?></textarea>
              </div></td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td align="right" valign="middle">&nbsp;</td>
              <td colspan="3" align="right" valign="middle"><div align="right">
                <input type="submit" name="OK" value="Guardar y Seguir" title="Guardar y continuar" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?>/>
                
                <a href="cliente.php" class="menulink">
                
                <img src="images/clean.png" title="Limpiar" />
                
                </a> 
                
                <input type="submit" name="eliminar" value="Eliminar" title="Eliminar Cliente/Obras" onclick="elimina=confirm('�Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style="background-image:url(images/salir.png); width:48px; height:48px;" class="formato_boton"/>
                
                
                
                <?php if (($estado_objetos=="enabled") and (!empty($registro["cod_cliente"]))) {  echo "<a href='imp_cliente.php?id=".$registro['rut_cliente']."' target='_blank'>"?>
                
                <input type="button" name="impresion" value="Impresion" onclick="" style=" background-image:url(images/impresora.gif); width:50px; height:50px;" class="formato_boton"/>
                
                
                </a>
                <?php } ?>
              </div></td>
            </tr>             
          </table> 
      </form></td>
    </tr>
  </table>
  <br />
</div>
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
					alert('Ingrese todos los datos');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Rut Cliente');
					</script>";
				 }
			 function mensaje_cli()
				 {
					echo "<script>
					alert('No puede eliminar.');
					</script>";
				 }
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_rut']))
				{  
					$link=mensaje2();
				} else {
					
				};
			}
	  ?> 
  
      <?php 
		 function validaRut ( $rut ){ 
		 if( strpos ( $rut , "-" )== false ){ 
		 $RUT [ 0 ] = substr ( $rut , 0 , - 1 ); 
		 $RUT [ 1 ] = substr ( $rut , - 1 ); 
		 }else{ 
		 $RUT = explode ( "-" , trim ( $rut )); 
		 } 
		 $elRut = str_replace ( "." , "" , trim ( $RUT [ 0 ])); 
		 $factor = 2 ; 
		 for( $i = strlen ( $elRut )- 1 ; $i >= 0 ; $i --): 
		 $factor = $factor > 7 ? 2 : $factor ; 
		 $suma += $elRut { $i }* $factor ++; 
		 endfor; 
		 $resto = $suma % 11 ; 
		 $dv = 11 - $resto ; 
		 if( $dv == 11 ){ 
		 $dv = 0 ; 
		 }else if( $dv == 10 ){ 
		 $dv = "k" ; 
		 }else{ 
		 $dv = $dv ; 
		 } 
		 if( $dv == trim ( strtolower ( $RUT [ 1 ]))){ 
		 return true ; 
		 }else{ 
		 return false ; 
		 } 
		 } 
	 

?>
    <?php
	if ($_POST['eliminar']=='Eliminar') 
	   {
		  if (!empty($_POST["txt_cod"]))
		  {
				//veirificar si tiene documentos asociados
				//no tiene elimina
				  $link       = Conectarse();
				 
				  $rut_elim     = $_POST["txt_cod"];
				  $result=mysql_query("SELECT COUNT(rut_cliente) FROM arriendo WHERE rut_cliente = '$rut_elim'");
				  $filas=@mysql_num_rows($result);
				  if ($filas['total']>=1)
				  {
					$link=mensaje_cli();
				  }else{
					//borrar desde clientes
					$sql = "DELETE FROM clientes WHERE rut_cliente = '$rut_elim'";
					$res = mysql_query($sql) or die(mysql_error()); 
					
					//borrar obras del cliente
					$link       = Conectarse();
					$codelim = $registro['cod_cliente'];
					$sqlobra = "DELETE FROM obra WHERE cod_cliente = '$codelim'";
					$res = mysql_query($sqlobra) or die(mysql_error()); 
					echo "<script type='text/javascript'>RegistroGrabado();</script>";
					echo "<script language=Javascript> location.href=\"cliente.php\"; </script>";
				}
			}else{
				echo "<script>alert('Seleccione Cliente.');</script>";
			}
	   }
    ?>
     
      <?php     	  

	if ($_POST['OK']=='Guardar y Seguir') 
	{

		$rut           = $_POST['txt_rut'];                      //  echo "$rut<br>";
		//formatear el rut
		if (strlen($rut) == 9)
		{
		$rut_param = $rut;
		$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
		$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
		$parte2 = substr($rut_param, -7,3);  
		$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
		$rut    = $parte1.".".$parte2.".".$parte3."-".$parte4; 	
		}
		
	    $dv            = 0;
		$tipo_cli      = $cargo_id3;                                    //    echo "$tipo_cli<br>";
		$ciudad        = $cargo_id1;                                    //    echo "$ciudad<br>";
		$comuna        = $cargo_id2;                                    //    echo "$comuna<br>";
		$raz_social    = strtoupper($_POST['txt_razonsoc']);   //    echo "$raz_social<br>";
		$giro          = strtoupper($_POST['txt_giro']);       //    echo "$giro<br>";
		$cod_area      = $_POST['txt_cod_area'];               //    echo "$cod_area<br>";
		$fono          = $_POST['txt_fono'];                   //    echo "$fono<br>";
		$movil         = $_POST['txt_movil'];                  //    echo "$movil<br>";
		$direcc        = strtoupper($_POST['txt_direccion']);  //   echo "$direcc<br>";
		$resp1         = strtoupper($_POST['txt_respemp']);    //   echo "$resp1<br>";	 
		$cargoresp1    = strtoupper($_POST['txt_cargoresp1']); //    echo "$cargoresp1<br>";
		$movilresp1    = $_POST['txt_movilresp1'];             //    echo "$movilresp1<br>";
		$email_resp1   = strtoupper($_POST['txt_emailresp1']); //  echo "$email_resp1<br>";
		$resp2         = strtoupper($_POST['txt_respemp2']);   //   echo "$resp2<br>";	 
		$cargoresp2    = strtoupper($_POST['txt_cargoresp2']); //   echo "$cargoresp2<br>";
	 	$movilresp2    = $_POST['txt_movilresp2'];             //  echo "$movilresp2<br>";
		$email_resp2   = strtoupper($_POST['txt_emailresp2']); //   echo "$email_resp2<br>";
		$resp3         = strtoupper($_POST['txt_respemp3']);   //   echo "$resp3<br>";	 
		$cargoresp3    = strtoupper($_POST['txt_cargoresp3']); //  echo "$cargoresp3<br>";
		$movilresp3    = $_POST['txt_movilresp3'];             //  echo "$movilresp3<br>";
		$email_resp3   = strtoupper($_POST['txt_emailresp3']); //  echo "$email_resp3<br>";
		$condenvio     = strtoupper($_POST['txt_condicenv']);  //  echo "$condenvio<br>";
		$condenvio     = trim($condenvio);
		
		if (empty($tipo_cli)||empty($ciudad)||empty($comuna)||empty($raz_social)||empty($giro)||empty($direcc))
		
	//if (empty($tipo_cli)||empty($ciudad)||empty($comuna)||empty($raz_social)||empty($giro)||empty($cod_area)||empty($fono)||empty($movil)||empty($direcc)||empty($resp1)||empty($cargoresp1)||empty($movilresp1)||empty($email_resp1)||empty($resp2)||empty($cargoresp2)||empty($movilresp2)||empty($email_resp2)|| empty($resp3)||empty($cargoresp3)||empty($movilresp3)||empty($email_resp3)||empty($condenvio))
		{
				$link=mensaje(); 
		} else {
			
			 if( $_POST['txt_rut'])
			 { 
				 if( validaRut($_POST['txt_rut'] )== true )
				 { 
			    $dv            = 0;
				$tipo_cli      = $cargo_id3;                        //    echo "$tipo_cli<br>";
				$ciudad        = $cargo_id1;                        //    echo "$ciudad<br>";
				$comuna        = $cargo_id2;                        //    echo "$comuna<br>";
				$raz_social    = strtoupper($_POST['txt_razonsoc']);   //    echo "$raz_social<br>";
				$giro          = strtoupper($_POST['txt_giro']);       //    echo "$giro<br>";
				$cod_area      = $_POST['txt_cod_area'];   //    echo "$cod_area<br>";
				$fono          = $_POST['txt_fono'];       //    echo "$fono<br>";
				$movil         = $_POST['txt_movil'];      //    echo "$movil<br>";
				$direcc        = strtoupper($_POST['txt_direccion']);   //   echo "$direcc<br>";
				$resp1         = strtoupper($_POST['txt_respemp']);    //   echo "$resp1<br>";	 
				$cargoresp1    = strtoupper($_POST['txt_cargoresp1']); //    echo "$cargoresp1<br>";
				$movilresp1    = $_POST['txt_movilresp1']; //    echo "$movilresp1<br>";
				$email_resp1   = strtoupper($_POST['txt_emailresp1']);   //  echo "$email_resp1<br>";
				$resp2         = strtoupper($_POST['txt_respemp2']);    //   echo "$resp2<br>";	 
				$cargoresp2    = strtoupper($_POST['txt_cargoresp2']);  //   echo "$cargoresp2<br>";
				$movilresp2    = $_POST['txt_movilresp2'];   //  echo "$movilresp2<br>";
				$email_resp2   = strtoupper($_POST['txt_emailresp2']);  //   echo "$email_resp2<br>";
				$resp3         = strtoupper($_POST['txt_respemp3']);    //   echo "$resp3<br>";	 
				$cargoresp3    = strtoupper($_POST['txt_cargoresp3']);   //  echo "$cargoresp3<br>";
				$movilresp3    = $_POST['txt_movilresp3'];   //  echo "$movilresp3<br>";
				$email_resp3   = strtoupper($_POST['txt_emailresp3']);   //  echo "$email_resp3<br>";
				$condenvio     = strtoupper($_POST['txt_condicenv']);    //  echo "$condenvio<br>";
				$condenvio     = trim($condenvio);						
			    $codigo = $_POST['txt_cod'];
					if (empty($codigo))
					{
							 mysql_query("insert into clientes (cod_ciudad, cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, cargo_resp1 , movil_resp1, email_resp_emp1,  nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact) values ('$ciudad','$comuna','$tipo_cli','$rut','$dv','$raz_social','$giro','$cod_area','$fono','$movil','$direcc','$resp1','$cargoresp1','$movilresp1','$email_resp1','$resp2','$email_resp2','$cargoresp2','$movilresp2','$resp3','$email_resp3','$cargoresp3','$movilresp3','$condenvio')",$link);
							 mysql_close($link);
							 echo "<script type='text/javascript'>RegistroGrabado();</script>";
							 echo "<script language=Javascript> location.href=\"cliente.php?id=".$rut."\"; </script>";
						 } else {

								$sql = "UPDATE clientes SET cod_ciudad='$ciudad', cod_comuna='$comuna', cod_tipocli='$tipo_cli', rut_cliente='$rut', dv_cliente='$dv', raz_social='$raz_social', giro_cliente='$giro', cod_area='$cod_area', fono_cliente='$fono', movil_cliente='$movil', direcc_cliente='$direcc', nom_resp_emp1='$resp1', email_resp_emp1='$email_resp1', cargo_resp1='$cargoresp1', movil_resp1='$movilresp1', nom_resp_emp2='$resp2', email_resp_emp2='$email_resp2', cargo_resp2='$cargoresp2', movil_resp2='$movilresp2', nom_resp_emp3='$resp3', email_resp_emp3='$email_resp3', cargo_resp3='$cargoresp3', movil_resp3='$movilresp3', cond_env_fact='$condenvio' where rut_cliente='$codigo'";
								$res  = mysql_query($sql) or die(mysql_error());
								echo "<script type='text/javascript'>RegistroGrabado();</script>";
								echo "<script language=Javascript> location.href=\"cliente.php?id=".$rut."\"; </script>";
						  }	  
				
				}else { 
					echo "<script> alert (\"Rut Incorrecto.\"); </script>";
				} 

			}	
		}
	}

?> 
