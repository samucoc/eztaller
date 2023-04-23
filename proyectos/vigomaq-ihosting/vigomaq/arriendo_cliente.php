<?php ob_start(); 

session_start(); 



$registro = array();

$usuario="";

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 

if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 

if (!$_SESSION['usuario']) {

    header("Location: ./login.php");

}

				function verifica_RUT($rut='') {

				

					//if($count($rut = 9)){

					//	$rut_final = $rut[0].$rut[1].'.'.$rut[2].$rut[3].$rut[4].'.'.$rut[5].$rut[6].$rut[7].'-'.$rut[8];

					//	$rut = $rut_final;

					//}

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>

	<title>Sistema de Arriendo y Facturación - Vigomaq</title>

	<meta name="description"/>

	<meta name="keywords" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<meta http-equiv="imagetoolbar" content="no" />





<link rel="stylesheet" href="css/style.css" type="text/css" />

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

.Estilo23 {

	color: #666666;

	font-style: italic;

	font-weight: bold;

	font-size: 16px;

	font-family: Arial, Helvetica, sans-serif;

}

-->

</style>

<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">

<script type="text/javascript" src="script.js"></script>

</head>

<body>

<table width="98%" border="0">

   <tr>

     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>

     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />

       <br />

       <br />

       <span class="Estilo23">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>

   </tr>

 </table>

<div>

	<?php 

		include("classes/menu.php")	;

	

	?>

</div> 

  <p>&nbsp;</p>

  <table width="80%" border="0" align="center">

    <tr>

      <td>&nbsp;</td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td width="52%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo11 Estilo20">

          <div align="right" class="Estilo21">

            <div align="left" class="Estilo13">Paso 1</div>

          </div>

      </div></td>

      <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">

          <div align="right" class="Estilo22">

            <div align="right" class="Estilo13">

              <?php

  	    {

include("classes/conex.php");

$link=Conectarse();



	    }

	 ?>

        </font></strong></font></strong>CLIENTE / OBRA </div>

          </div>

      </div></td>

    </tr>

    <tr>

      <td colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7"><span class="Estilo13">

      <?php

			{

				//rut del cliente lo busca por primera vez

				$valor1 = $_POST["txt_rut"];

				if (empty($valor1)){

				$valor1 = $_GET["valor1"];}

				

				//codigo de arriendo

				$valor2 = $_POST["txt_codarriendo"];

				

				//codigo de arriendo

				if (empty($valor2)){

				$valor2 = $_GET["codarr"];



				}

			}

				

				if (!empty($valor2))

				{

					$sql1 = "SELECT * FROM arriendo_temp WHERE cod_arriendo ='$valor2' and usuario = '".$usuario."'";



					$res1 = mysql_query($sql1,$link) or die(mysql_error()); 

					$registro1 = mysql_fetch_array($res1);				

					$valor1=$registro1['rut_cliente'];

	

				}

					

				if (!empty($valor1))

				{

					$link=Conectarse();

					$sql = "SELECT * FROM clientes WHERE rut_cliente ='$valor1' order by cod_cliente limit 0,1";

			

					$res = mysql_query($sql,$link) or die(mysql_error()); 

					$registro = mysql_fetch_array($res);	

					$codigo_clien = $registro['cod_cliente'];

					if (($registro['cod_tipocli']==13)and ($_SESSION['tipo_usuario']<>0)) {

						echo "<script>alert('No es Posible Arrendar/Cliente Bloqueado. Consulte con Administrador');</script>";			 

					}

					

					$resultobras="SELECT COUNT(*) as filas FROM obra WHERE cod_cliente ='$codigo_clien'";

				    $rs_busqueda=mysql_query($resultobras);

				    $filas=mysql_result($rs_busqueda,0,"filas");



					if ($filas<1)

				   {

					  echo "<script>alert('No existen Obras asociadas a este Cliente');</script>";

				   }



                 }

				 if ( (empty($valor1)) && (empty($valor2)) ){

					$link=Conectarse();

					

					$sql1 = "delete from equipos_arriendo_temp where usuario = '".$usuario."'";

					$res1 = mysql_query($sql1,$link) or die(mysql_error()); 



					$sql1 = "delete from arriendo_temp where usuario = '".$usuario."'";

					$res1 = mysql_query($sql1,$link) or die(mysql_error()); 



					 }

		?>

        <?php

			if (isset($_POST['txt_rut'])) {

		

			  $error = verifica_rut(isset($_POST['txt_rut']));

			  switch($error) {

				case 0 : 

					$rut_param = $_POST['txt_rut'];

					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 

					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  

					$parte2 = substr($rut_param, -7,3);  

					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 

					$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 

			//		echo ($rutok);

				break;

				case 1 : echo "<script> alert (\"Ingrese Rut Cliente\"); </script>"; break;

				//case 2 : echo "<script>	alert (\"El Rut no cuenta con el mínimo de caracteres necesarios para validarlo\");					</script>"; break;

				case 4 : echo "<script>	alert (\"El Rut o el dígito viene vacío\");</script>"; break;

				case 5 : echo "<script>	alert (\"El Rut y el dígito no coinciden\");</script>"; break;

				//default: echo "<script>	alert (\"Error\");</script>"; break;

			  }

			

			}

		?><?php

		 if (($_SESSION['tipo_usuario']=="1") and ($registro['cod_tipocli']==13)) {

			$estado_objetos = 'disabled';

		 }else{

			$estado_ojetos = 'enabled';

		}

		?>

      </span>DATOS CLIENTE </span></div></td>

    </tr>

    <tr>

      <td colspan="2" valign="top"><form method="POST" name="frmDatos" id="frmDatos"><table width="100%" border="0" align="center">

  <tr>

    <td><table width="100%" border="0" align="left">

      <tr>

        <td colspan="4"><?php /*if (empty($registro1['cod_arriendo'])){ }else{ echo " N� Arriendo " ;}?>

          <?php if (empty($registro['cod_arriendo'])){ }else{ echo " : " ;}?>

          <input type="hidden" name="txt_codarriendo" size="20" maxlength="30" value="<?php echo $registro1['cod_arriendo'];?>" />

          <?php if (empty($valor1)&&(empty($registro1['cod_arriendo']))){ }else{ 

				   $cantidad = strlen($registro1['cod_arriendo']); 

				   if ($cantidad==1) { echo ("00000000" .('' . $registro1['cod_arriendo'] . ' ') );  }

				   if ($cantidad==2) { echo ("0000000" .('' . $registro1['cod_arriendo'] . ' ') );  }

				   if ($cantidad==3) { echo ("000000" .('' . $registro1['cod_arriendo'] . ' ') );  }

				   if ($cantidad==4) { echo ("00000" .('' . $registro1['cod_arriendo'] . ' ') );  }

				   if ($cantidad==5) { echo ("0000" .('' . $registro1['cod_arriendo'] . ' ') );  } 

				   if ($cantidad==6) { echo ("000" .('' . $registro1['cod_arriendo'] . ' ') );  }

				   if ($cantidad==7) { echo ("00" .('' . $registro1['cod_arriendo'] . ' ') );  }

				   if ($cantidad==8) { echo ("0" .('' . $registro1['cod_arriendo'] . ' ') );  } }*/?></td>

        <td align="center"><?php  $fecha = date("d-m-Y"); echo($fecha);//echo date ( "j - n - Y" );?></td>

      </tr>

      <tr>

        <td colspan="5" height="2"></td>

      </tr>

      <tr>

        <td width="149"><div align="left"><strong>Rut: </strong></div></td>

        <td width="295" colspan="3"><div align="left">

          <strong>

          <input name="txt_rut" type="text" id="rut" value="<?php 

			  if (($registro['rut_cliente']!= "") && (empty($registro1['cod_arriendo'])))

			  {		

					echo($_POST['txt_rut']);

				}else{ 

				  	if (!empty($registro['rut_cliente'])) {

						echo($registro['rut_cliente']); 

					}else{ 

						echo($_POST['txt_rut']);

						

					}

				 }?>" size="12" maxlength="12" />

          

          <input type="submit" name="buscarcodigo" id="button" value="Buscar" onclick="javascript:rut_formato()" style="background-image:url(images/ver.png); width:20px; height:20px" title="Buscar Cliente por Rut" class="formato_boton" />

          

         <!-- <input type="image" name="buscarcodigo" value="Buscar" title="Buscar Cliente por Rut" class="searchbutton" src="images/ver.png" onclick="javascript:rut_formato()"/>-->

          

          

          <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['cod_cliente'];?>" />

        [11.111.111-1]</strong></div></td>

        <td width="131" align="center" valign="middle" class="Estilo23"><strong>

          <?php if (!empty($registro['cod_tipocli']))

			  {

				  $sql5="SELECT tipo_cliente FROM tipo_cliente where cod_tipocli =".$registro['cod_tipocli'];

				  $res5= mysql_query($sql5,$link) or die(mysql_error()); 

				  $registro5 = mysql_fetch_array($res5);

				  echo($registro5['tipo_cliente']);

			  }else{

				  echo(" ");

			  } ?>

        </strong></td>

      </tr>

      <tr>

        <td><div align="left"><strong>Raz&oacute;n Social :</strong></div></td>

        <td colspan="3"><div align="left"><strong>

          <input  name="txt_razonsoc" type="text" value="<?php echo $registro['raz_social'];?>" size="50" maxlength="50" disabled="disabled"/>

        </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><div align="left"><strong>Giro:</strong></div></td>

        <td colspan="3"><div align="left">

          <strong>

          <input name="txt_giro" type="text" value="<?php echo $registro['giro_cliente'];?>" size="50" maxlength="50" disabled="disabled"/>

          </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><div align="left"><strong>Direcci&oacute;n:</strong></div></td>

        <td colspan="3"><div align="left">

          <strong>

          <input name="txt_direccion" type="text" value="<?php echo $registro['direcc_cliente'];?>" size="50" maxlength="50" disabled="disabled" />

          </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><div align="left"><strong>Ciudad:</strong></div></td>

        <td colspan="3" align="left"><div align="left">

          <strong>

          <input name="txt_ciudad" type="text" value="<?php

		  if (!empty($registro['cod_ciudad']))

		  {

			  $sql3="SELECT ciudad FROM ciudad where cod_ciudad = " .$registro['cod_ciudad']. "";

			  // echo($sql3);

			  $res3 = mysql_query($sql3) or die(mysql_error());

			  $registro3 = mysql_fetch_array($res3);

			  echo($registro3['ciudad']);

		  }else{

			  echo(" ");

		  }

		  ?>" size="40" maxlength="40" disabled />

          </option>

          </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><div align="left"><strong>Comuna:</strong></div></td>

        <td colspan="3" align="left"><div align="left">

          <strong>

          <input name="txt_comuna" type="text" value="<?php

		  if (!empty($registro['cod_comuna']))

		  {

			  $sql4="SELECT comuna FROM comuna where cod_comuna = " .$registro['cod_comuna']. "";

			  // echo($sql3);

			  $res4= mysql_query($sql4) or die(mysql_error());

			  $registro4 = mysql_fetch_array($res4);

			  echo($registro4['comuna']);		 

		  }else{

			  echo(" ");

		  }	

		  ?>" size="40" maxlength="40" disabled="disabled"/>

          </option>

          </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><div align="left"><strong>Fono:</strong></div></td>

        <td colspan="3"><div align="left">

          <strong>

          <input name="txt_cod_area" type="text" onkeypress="return acceptNum(event)" value="<?php echo $registro['cod_area'];?>" size="4" maxlength="8" disabled="disabled"/>

          <input name="txt_fono" type="text" onkeypress="return acceptNum(event)" value="<?php echo $registro['fono_cliente'];?>" size="8" maxlength="8" disabled="disabled"/>

          </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><strong>Contacto:</strong></td>

        <td colspan="3"><div align="left">

          <strong>

          <input name="txt_nomresp" type="text" value="<?php echo $registro['nom_resp_emp1'];?>" size="50" maxlength="50" disabled="disabled" />

          </strong></div></td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><div align="left"><strong>Email Contacto:</strong></div></td>

        <td colspan="3" align="left"><strong>

          <input name="txt_email" type="text" value="<?php echo $registro['email_resp_emp1'];?>" size="50" maxlength="50" disabled="disabled"/>

        </strong></td>

        <td align="right">&nbsp;</td>

      </tr>

      <tr>

        <td height="15">&nbsp;</td>

        <td colspan="3">&nbsp;</td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td colspan="5" valign="top" bgcolor="#06327D"><div align="left"><strong><span class="Estilo7">Obra Seleccionada</span></strong></div></td>

        </tr>

      <tr>

        <td height="15"><div align="left"><strong>Nombre:</strong></div></td>

        <td colspan="3"><input name="txt_codobra" type="text" value="<?php echo $registro1['cod_obra'] ?>" size="6" maxlength="6"/>

          <input type="text" name="txt_obra" size="45" maxlength="45" value="<?php if (!empty($registro1['cod_obra']))

					{

						$sqlobra="SELECT nombre_obra FROM obra where cod_obra = " .$registro1['cod_obra']. "";

						//echo($sqlobra);

						$resobra = mysql_query($sqlobra) or die(mysql_error());

						$registroobra = mysql_fetch_array($resobra);

						echo($registroobra['nombre_obra']);

					  }else{

						echo(" ");

					  } ?>" disabled="disabled"/></td>

        <td><strong>

          <input type="submit" name="OK" id="button2" value="Guardar y Seguir" style="background-image:url(images/siguiente.png); width:40px; height:40px" class="formato_boton"  title="Ir al paso 2" />

          <!--

          <input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/siguiente.png" width="32"  height="32" <?php echo $estado_objetos ;?>/>-->

        </strong></td>

      </tr>

      <tr>

        <td></td>

        <td colspan="3"></td>

        <td></td>

      </tr>

    </table></td>

  </tr>

</table>



        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >

          <tr title="Clic para seleccionar Obra" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">

            <th bgcolor="#06327D"><strong><span class="Estilo17">Cod.  Obra </span></strong></th>

            <th bgcolor="#06327D"><strong><span class="Estilo17">

 Nombre Obra </span></strong></th>

            <th bgcolor="#06327D" class="CONT"><strong><span class="Estilo17">Autorizado 1</span></strong></th>

            <th bgcolor="#06327D" class="CONT"><strong><span class="Estilo17 Estilo13 Estilo15">Autorizado 2<span class="Estilo17">

        <?php

			 if (!empty($registro['cod_cliente'])){

				$sql="SELECT * FROM obra where cod_cliente = ".$registro['cod_cliente']." order by cod_obra ASC";

				//echo($sql);

				$res = mysql_query($sql) or die(mysql_error()); 

				while ($registro = mysql_fetch_array($res)) {

		 ?>

            </span></span></strong></th>

            </tr>

          <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para seleccionar Obra" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">

            <td bgcolor="#FFFFFF"><?php

			if (empty($valor1)&&(empty($registro['cod_obra']))){ }else{ 

				   $cantidad = strlen($registro['cod_obra']); 

				   if ($cantidad==1) { echo ("00000000".($registro['cod_obra']));}

				   if ($cantidad==2) { echo ("0000000".($registro['cod_obra']));}

				   if ($cantidad==3) { echo ("000000".($registro['cod_obra']));}

				   if ($cantidad==4) { echo ("00000".($registro['cod_obra']));}

				   if ($cantidad==5) { echo ("0000".($registro['cod_obra']));} 

				   if ($cantidad==6) { echo ("000".($registro['cod_obra']));}

				   if ($cantidad==7) { echo ("00".($registro['cod_obra']));}

				   if ($cantidad==8) { echo ("0".($registro['cod_obra']));}	

				   if ($cantidad==9) { echo ($registro['cod_obra']);}};

		   ?>

           </td>

            <td bgcolor="#FFFFFF"><?php echo '' . $registro['nombre_obra'] . ' ';?></td>

            <td bgcolor="#FFFFFF"><?php echo '' . $registro['nom_aut1'] . ' ';?></td>

            <td align="center" bgcolor="#FFFFFF"><?php echo '' . $registro['nom_aut2'] . ' ';?></td>

            </tr>

          <tr>

            <td bordercolor="#FFFFFF" class="CONT" align="center">&nbsp;</td>

            <td height="15" bordercolor="#FFFFFF" class="CONT" align="center">&nbsp;</td>

            <td bordercolor="#FFFFFF" class="CONT" align="center">&nbsp;</td>

            <td bordercolor="#FFFFFF" class="CONT" align="center">&nbsp;</td>

          </tr>

          <?php

				}

			 

				mysql_free_result($res);

				mysql_close($link);}

		 ?>

          

         <?php

 

		 $link=Conectarse();

		 if (isset($_POST['OK'])=='Guardar y Seguir')

		 {

			$rut_cliente   = $_POST['txt_rut'];                  //  echo ($rut_cliente)."$rut_cliente<br>";

			$cod_obra      = $_POST['txt_codobra'];              //  echo ($cod_obra)."$cod_obra<br>";

			$cod_arriendo  = $_POST['txt_codarriendo'];          //  echo ($cod_arriendo)."$cod_arriendo<br>";

			//$fecha         = $_POST['fecha']; 

			if (empty($cod_obra))

			{

				echo "<script>

					alert('Seleccione Cliente / Obra');

					</script>";

			}else{

				if (empty($cod_arriendo))

				{

					//guardar arriendo nuevo

					

					$cod_obra = rtrim($cod_obra);

					

					mysql_query("insert into arriendo_temp (`rut_cliente`, `cod_obra`, `cod_tarifa`, `cod_personal`, `forma_pago`, `num_gd`, `num_oc`, `tipo_garantia`, `fecha_inicio`, `fecha_vcmto`, `fecha_arr`, `hora_arr`, `fecha_devol`, `hora_devol`, `forma_entrega`, `monto_arriendo`, `tipo_oc`, `vcmto_oc`, `obs_devolucion`, `usuario`) 
								values ('$rut_cliente','$cod_obra','0','0','0','0','0','0','".date('Y-m-d')."','".date('Y-m-d')."','".date('Y-m-d')."','00:00:00','".date('Y-m-d')."','00:00:00','0','0','0','0','0','$usuario')",$link) or die(mysql_error()); 


					$sql5="SELECT * FROM  arriendo_temp where cod_arriendo = LAST_INSERT_ID() and usuario = '".$usuario."'";

				

					$res5 = mysql_query($sql5,$link) or die(mysql_error()); 

					$registro5 = mysql_fetch_array($res5);

					$cod_arriendo = $registro5['cod_arriendo'];

					echo "<script language=Javascript> location.href=\"arriendo_equipo.php?codarr=".$cod_arriendo."\"; </script>";

				} else {

					//guardar cambios

					$sql = "UPDATE arriendo_temp SET cod_obra='$cod_obra', fecha_arr = '".date('Y-m-d')."' where cod_arriendo='$cod_arriendo' and usuario = '".$usuario."'";

					$res  = mysql_query($sql) or die(mysql_error());

					echo "<script language=Javascript> location.href=\"arriendo_equipo.php?codarr=".$cod_arriendo."\"; </script>";

				 }

			}

		 }

	?>

        </table>

      </form></td>

    </tr>

  </table>

<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>

<script type="text/javascript">

	var menu=new menu.dd("menu");

	menu.init("menu","menuhover");

</script>

<script type="text/javascript">

function verifica_rut(c){var r=false,d=c.value,t=d.replace(/\b[^0-9kK]+\b/g,'');if(t.length==8){t=0+t;};if(t.length==9){var a=t.substring(t.length-1,-1),b=t.charAt(t.length-1);if(b=='k'){b='K'};if(!isNaN(a)){var s=0,m=2,x='0',e=0;for(var i=a.length-1;i>=0;i--){s=s+a.charAt(i)*m;if(m==7){m=2;}else{m++;};}var y=s%11;if(y==1){x='K';}else{if(y==0){x='0';}else{e=11-y;x=e+'';};};if(x==b){r=true;c.value=a.substring(0,2)+'.'+a.substring(2,5)+'.'+a.substring(5,8)+'-'+b};}}return r;};

</script>

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

  document.forms[0]['txt_codobra'].value = cod;

  document.forms[0]['txt_obra'].value = com;

}



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

</body>



</html>