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
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
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
-->
</style>
<script type="text/javascript">
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con Exito!");
  document.location = 'proveedor.php';
}
 //-->
</script>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("Proveedor no ha sido ingresado!");
  document.location = 'proveedor.php';
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
<style type="text/css">
.Estilo221 {color: #FF0000}
</style>
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
</table>
<?php 
include("classes/menu.php");
?>
<table width="95%" height="335" border="0" align="center">
    <tr>	 
      <td width="320" height="31">&nbsp;</td>
      <td width="336"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
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
					if (empty($valor1)) $valor1= $_POST['txt_rut'];
					if (empty($valor1)) $valor1= $_GET['txt_rut'];
					
					
					if (empty($valor1)){
					
					}else{
							$link=Conectarse();
							$sql = "SELECT cod_fabricante, cod_ciudad , cod_comuna, raz_social, Rut, Dv, Giro, cod_area, fono, movil, Direcc, email, inst_pago, contacto1, fono_cont1, email_cont1, contacto2, fono_cont2, email_cont2, contacto3, fono_cont3, email_cont3, observaciones FROM proveedor WHERE Rut ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							if (empty($registro['cod_fabricante']) && $_POST["buscar"]=="Buscar"){
							 	echo "<script>
								alert('Proveedor No Ingresado');
								</script>";
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
            PROVEEDORES</div>
        </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS PROVEEDORES<?php if (empty($registro['cod_fabricante']) && $_POST["buscar"]=="Buscar"){
								 echo " - Nuevo Proveedor";}?> </span></div></td>
    </tr>
    <tr>
      <td height="276" colspan="2" align="left">
      <form  method="POST" name="frmDatos" id="frmDatos">
        <table width="100%" height="734" border="0">

            <tr>
              <td><?php //if (empty($registro['cod_fabricante'])){ }else{ echo " Código Proveedor: " ;}?></td>
              <td><?php //if (empty($registro['cod_fabricante'])){ }else{ echo ":" ;}?></td>
              <td><div align="left"> <span class='mini_titulo'>
                <?php /*if (empty($valor1)){ }else{ 
				   $cantidad = strlen($registro['cod_fabricante']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_fabricante'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_fabricante'] . ' ';  }		
				   */
           ?>
            </span>
                    <?php //} ?>
          </div> </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Rut</div></td>
              <td>:</td>
              <td><div align="left">

			  <input name="txt_rut" type="text" id="rut" value="<?php 
			  if (($registro['Rut']!= "") && (empty($registro['cod_proveedor'])))
			  {		$rut_param = $registro['Rut'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $registro['Rut'];
					}
					echo ($rutok);
				}else{ 
						echo $_POST['txt_rut'];
						}
				?>" size="12" maxlength="12" onblur="checkRutGenerico(this, true)" />
                  <input type="submit" name="buscar" title="Buscar Proveedor" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
                  
              <!--<input type="image" name="buscar" value="Buscar" title="Buscar Proveedor" class="searchbutton" src="images/ver.png"/>-->
                  <span class="Estilo20">
                  <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['Rut'];?>" />
              </span><strong>[11.111.111-1]</strong></div></td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Raz&oacute;n Social</div></td>
              <td>:</td>
              <td><div align="left">
                  <input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Giro</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_giro" type="text" value="<?php if (!empty($registro['Giro'])) 
			{echo ($registro['Giro']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Direcci&oacute;n</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_direccion" type="text" value="<?php if (!empty($registro['Direcc'])) 
			{echo ($registro['Direcc']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Ciudad</div></td>
              <td align="left">:</td>
              <td align="left"><?php
			$sql="SELECT cod_ciudad, ciudad FROM ciudad order by ciudad ASC";
  			$res=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=ciudad>\n"; 

			while($campos1=mysql_fetch_row($res))
			{	
					$cargo1 = explode( ',', $_POST['ciudad'] );
					$cargo_id1 = $cargo1[0];
					$cargo_contenido1 = $cargo1[1];  
               if (($registro['cod_ciudad']==$campos1[0])||($cargo_id1==$campos1[0])){
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
		 ?></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Comuna</div></td>
              <td align="left">:</td>
              <td align="left"><div align="left">
                  <?php
			$sql="SELECT cod_comuna, comuna FROM comuna order by comuna ASC";
  			$res2=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=comuna>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
					$cargo2 = explode( ',', $_POST['comuna'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					//echo $campos2; 
               if (($registro['cod_comuna']==$campos2[0])||($cargo_id2==$campos2[0])){
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
		 ?></div>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo221">(*)</span>Fono</div></td>
              <td>:</td>
              <td><div align="left">
                <input name="txt_cod_area" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" />
                
                <input name="txt_fono" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono'])) 
			{echo ($registro['fono']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Movil</div></td>
              <td>:</td>
              <td><div align="left">
                  <input name="txt_movil" type="text"  onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil'])) 
			{echo ($registro['movil']);}else{echo($_POST["txt_movil"]) ;}?>" size="9" maxlength="9" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">e-mail</div></td>
              <td align="left">:</td>
              <td align="left"><input name="txt_email" type="text" onkeypress="return verify_email(event)" value="<?php if (!empty($registro['email'])) 
			{echo ($registro['email']);}else{echo($_POST["txt_email"]) ;}?>" size="50" maxlength="50" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Instrumento de Pago</div></td>
              <td>:</td>
              <td><select name="inst_pago" >
                <option>EFECTIVO</option>
                <option>CHEQUE AL DIA</option>
                <option>CHEQUE A PLAZO</option>
                <option>TRANSFERENCIA ELECTRONICA</option>
              </select></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">
                <p>Contacto (1)</p>
                </div></td>
              <td>:</td>
              <td><div align="left">
                <input  name="txt_contacto1" type="text" value="<?php if (!empty($registro['contacto1'])) 
			{echo ($registro['contacto1']);}else{echo($_POST["txt_contacto1"]) ;}?>" size="50" maxlength="50" />
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
			{echo ($registro['fono_cont1']);}else{echo($_POST["txt_fonocont1"]) ;}?>" size="9" maxlength="9" />
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
			{echo ($registro['email_cont1']);}else{echo($_POST["txt_emailcont1"]) ;}?>" size="50" maxlength="50" />
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
			{echo ($registro['contacto2']);}else{echo($_POST["txt_contacto2"]) ;}?>" size="50" maxlength="50" />
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
			{echo ($registro['fono_cont2']);}else{echo($_POST["txt_fonocont2"]) ;}?>" size="9" maxlength="9" />
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
			{echo ($registro['email_cont2']);}else{echo($_POST["txt_emailcont2"]) ;}?>" size="50" maxlength="50" />
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
			{echo ($registro['contacto3']);}else{echo($_POST["txt_contacto3"]) ;}?>" size="50" maxlength="50" />
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
			{echo ($registro['fono_cont3']);}else{echo($_POST["txt_fonocont3"]) ;}?>" size="9" maxlength="9" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24" valign="top"><div align="left">
                  <p>email</p>
              </div></td>
              <td>:</td>
              <td><div align="left">
                <input  name="txt_emailcont3" type="text" value="<?php if (!empty($registro['email_cont3'])) 
			{echo ($registro['email_cont3']);}else{echo($_POST["txt_emailcont3"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><div align="left">Observaciones</div></td>
              <td valign="top">:</td>
              <td><textarea name="txt_observaciones" cols="60" rows="7"><?php if (!empty($registro['observaciones'])) 
			{echo ($registro['observaciones']);}else{echo($_POST["txt_observaciones"]) ;}?></textarea></td>
              <td align="left" valign="bottom">
              
              <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir"  style="background-image:url(images/guardar.png); width:45px; height:45px;" <?php echo $estado_objetos ;?> class="formato_boton"/>
              
              
              <a href="proveedor.php" class="menulink"><input name="Limpiar" type="image" title="Limpiar"  width="30" height="30" value="Limpiar"  src="images/clean.png" /></a>
                
                
                <input type="submit" name="eliminar" title="Eliminar Proveedor" value="Eliminar" style="background-image:url(images/salir.png); width:48px; height:48px;" class="formato_boton" onclick="elimina=confirm('&iquest;Desea eliminar?');return elimina;" <?php echo $estado_objetos ;?> />
                
                
                <?php if ($estado_objetos=="enabled") { echo "<a href='imp_proveedor.php?id=".$registro['Rut']."' target='_blank'>"?>
                <input type="image" name="impresion" value="Impresion" src="images/impresora.gif" onclick="" width="30" height="30"  title="Imprimir"/>
                </a>
                <?php } ?>
              </span></td>
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
					alert('Ingrese datos Proveeedor');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Rut Proveedor');
					</script>";
				 }
			function mensaje_prov()
				 {
					echo "<script>
					alert('No puede eliminar.');
					</script>";
				 }
			function mensaje_datos()
				 {
					echo "<script>
					alert('Faltan Datos.');
					</script>";
				 }
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_rut']))
				{  
					
				} else {
					
				};
			}
	  ?> 
      <?php
	if ($_POST['eliminar']=='Eliminar') 
	   {
		 if (!empty($registro['cod_fabricante']))
		 {
	    //veirificar si tiene documentos asociados
	    //no tiene elimina
	     $link       = Conectarse();
		 $codigo     = $registro['cod_fabricante'];
		 $result=mysql_query("SELECT COUNT(cod_fabricante) FROM equipo WHERE cod_proveedor = '$codigo'");
		 $filas=@mysql_num_rows($result);
			 if ($filas>=1)
			  {
				$link=mensaje_prov();
			  }else{
				$sql = "DELETE FROM proveedor WHERE cod_fabricante =".$registro['cod_fabricante'];
			 
				$res = mysql_query($sql) or die(mysql_error()); 
				echo "<script type='text/javascript'>RegistroGrabado();</script>";
			  }
		 }else{
			
		 }
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
	
	if ($_POST['OK']=='Guardar y Seguir') 
	{
		$raz_social    = strtoupper($_POST['txt_razonsoc']);     //  echo "$raz_social<br>";
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
		
		$giro          = strtoupper($_POST['txt_giro']);         //  echo "$giro<br>";
		$direccion     = strtoupper($_POST['txt_direccion']);    //  echo "$direccion<br>";
		$ciudad        = strtoupper($cargo_id1);                          //  echo "$ciudad<br>";
		$comuna        = strtoupper($cargo_id2);                          //  echo "$comuna<br>";
		$cod_area      = $_POST['txt_cod_area'];                 //  echo "$cod_area<br>";
		$fono          = $_POST['txt_fono'];                     //  echo "$fono<br>";
		$movil         = $_POST['txt_movil'];                    //  echo "$movil<br>";
		$email         = strtoupper($_POST['txt_email']);        //  echo "$email<br>";
		$inst_pago     = strtoupper($_POST['inst_pago']);        //  echo "$inst_pago<br>";	 
		$contacto1     = strtoupper($_POST['txt_contacto1']);    //  echo "$contacto1<br>";
		$fono_cont1    = $_POST['txt_fonocont1'];                //  echo "$fono_cont1<br>";
		$email_cont1   = strtoupper($_POST['txt_emailcont1']);   //  echo "$email_cont1<br>";
		$contacto2     = strtoupper($_POST['txt_contacto2']);    //  echo "$contacto2<br>";
		$fono_cont2    = $_POST['txt_fonocont2'];                //  echo "$fono_cont2<br>";
		$email_cont2   = strtoupper($_POST['txt_emailcont2']);   //  echo "$email_cont2<br>";
		$contacto3     = strtoupper($_POST['txt_contacto3']);    //  echo "$contacto3<br>";
		$fono_cont3    = $_POST['txt_fonocont3'];                //  echo "$fono_cont3<br>";
		$email_cont3   = strtoupper($_POST['txt_emailcont3']);   //  echo "$email_cont3<br>";
		$observaciones = strtoupper($_POST['txt_observaciones']);// echo "$observaciones<br>";
		$obs_reposicion =trim($obs_reposicion);
		
	if (empty($raz_social)||empty($rut)||empty($giro)||empty($direccion)||empty($cod_area)||empty($fono))
		{  
		mensaje_datos();
		} else {
			
			 if( $_POST['txt_rut'])
			 { 
				 if( validaRut($_POST['txt_rut'] )== true )
				 { 
					$raz_social    = strtoupper($_POST['txt_razonsoc']);     //  echo "$raz_social<br>";
					$giro          = strtoupper($_POST['txt_giro']);         //  echo "$giro<br>";
					$direccion     = strtoupper($_POST['txt_direccion']);    //  echo "$direccion<br>";
					$ciudad        = strtoupper($cargo_id1);                          //  echo "$ciudad<br>";
					$comuna        = strtoupper($cargo_id2);                          //  echo "$comuna<br>";
					$cod_area      = $_POST['txt_cod_area'];                 //  echo "$cod_area<br>";
					$fono          = $_POST['txt_fono'];                     //  echo "$fono<br>";
					$movil         = $_POST['txt_movil'];                    //  echo "$movil<br>";
					$email         = strtoupper($_POST['txt_email']);        //  echo "$email<br>";
					$inst_pago     = strtoupper($_POST['inst_pago']);        //  echo "$inst_pago<br>";	 
					$contacto1     = strtoupper($_POST['txt_contacto1']);    //  echo "$contacto1<br>";
					$fono_cont1    = $_POST['txt_fonocont1'];                //  echo "$fono_cont1<br>";
					$email_cont1   = strtoupper($_POST['txt_emailcont1']);   //  echo "$email_cont1<br>";
					$contacto2     = strtoupper($_POST['txt_contacto2']);    //  echo "$contacto2<br>";
					$fono_cont2    = $_POST['txt_fonocont2'];                //  echo "$fono_cont2<br>";
					$email_cont2   = strtoupper($_POST['txt_emailcont2']);   //  echo "$email_cont2<br>";
					$contacto3     = strtoupper($_POST['txt_contacto3']);    //  echo "$contacto3<br>";
					$fono_cont3    = $_POST['txt_fonocont3'];                //  echo "$fono_cont3<br>";
					$email_cont3   = strtoupper($_POST['txt_emailcont3']);   //  echo "$email_cont3<br>";
					$observaciones = strtoupper($_POST['txt_observaciones']);// echo "$observaciones<br>";
					$obs_reposicion =trim($obs_reposicion);
						
						$codigo = $_POST['txt_cod'];	
						if (empty($codigo))
						{
						
							 mysql_query("insert into proveedor (cod_ciudad,cod_comuna,raz_social,Rut,Dv,Giro,cod_area,fono,movil,Direcc,email,inst_pago,contacto1,fono_cont1,email_cont1,contacto2,fono_cont2,email_cont2,contacto3,fono_cont3,email_cont3,observaciones) values ('$ciudad','$comuna','$raz_social','$rut','$dv','$giro','$cod_area','$fono','$movil','$direccion','$email','$inst_pago','$contacto1','$fono_cont1','$email_cont1','$contacto2','$fono_cont2','$email_cont2','$contacto3','$fono_cont3','$email_cont3','$observaciones')",$link);
							 mysql_close($link);
							 echo "<script type='text/javascript'>RegistroGrabado();</script>";
							 echo "<script language=Javascript> location.href=\"proveedor.php?id=".$rut."\"; </script>";
						 } else {
				
								$sql = "UPDATE proveedor SET raz_social='$raz_social', Rut='$rut', Dv='$dv', Giro='$giro', Direcc='$direccion', cod_ciudad='$ciudad', cod_comuna='$comuna', fono='$fono', movil='$movil', email='$email', inst_pago='$inst_pago', contacto1='$contacto1', fono_cont1='$fono_cont1', email_cont1='$email_cont1', contacto2='$contacto2', fono_cont2='$fono_cont2', email_cont2='$email_cont2', contacto3='$contacto3', fono_cont3='$fono_cont3', email_cont3='$email_cont3', observaciones='$observaciones' where Rut='$codigo'";
								$res  = mysql_query($sql) or die(mysql_error());
								echo "<script type='text/javascript'>RegistroGrabado();</script>";
								echo "<script language=Javascript> location.href=\"proveedor.php?id=".$rut."\"; </script>";
						  }	  
				
				}else { 
					echo "<script> alert (\"Rut Incorrecto.\"); </script>";
				} 

			}	
		}
	}

?>  