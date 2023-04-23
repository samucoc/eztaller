<?php ob_start(); 
session_start(); 
//conectamos a la base de datos 
//mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");
//mysql_select_db("vigomaq_intranet"); 
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
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script type="text/javascript" src="script.js"></script>
<script>
function abrir() // windows open 
{

window.open("busca_cod.php?id",""," width = 400,height=300,scrollbars=NO");
}
function cerrarVentana(){
//la referencia de la ventana es el objeto window del popup. Lo utilizo para acceder al m�todo close	
ventana_secundaria.close()
}
</script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo19 {	color: #999999;
	font-weight: bold;
}
.Estilo20 {color: #000000}
.Estilo6 {
	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
}
.Estilo7 {
	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
}
.Estilo21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #666666;
}
-->
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq.cl/favicon.ico">
</head>
<body>
<table width="80%" border="0">
  <tr>
    <td><img src="images/logo.jpg" width="377" height="104" /></td>
  </tr>
</table>

	  

<div id="text" style="float:left; clear:center; width:80%; margin-top:10px">
  <script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
  </script>
   <style type="text/css">
 @media print {
    .oculto {display:none}
  }
</style>

  <table width="75%" border="0" align="center">
    <tr>
      <td width="50%" height="31"><div align="left" class="Estilo6 Estilo19 Estilo20"> 
        <?php
			{
			include("conex.php");
			$link=Conectarse();
			}
		?>

      </div><a href="menu.php" onmouseover="Volver"></a></td>
      <td width="50%"><div align="right" class="Estilo6 Estilo19 Estilo20 "><br />
        ARRIENDO </div></td>
    </tr>
    <tr>
      <td height="162" colspan="2"valign="top"><form method="POST" name="frmDatos" id="frmDatos">
          <table width="100%"  align="center" border="0">
              <tr>
                <td colspan="5"><table width="100%" border="0" align="center">
                  <tr>
                    <td colspan="6" bgcolor="#06327D"><div align="left" class="Estilo7">
		            <?php
			{
				//codigo de arriendo
				$valor2 = $_GET["codarr"];
				$valor2 = $valor2;
			}
				
				if (!empty($valor2))
				{
					//busqueda datos arriendo
					$link       = Conectarse();
					$sql        = "SELECT * 
									FROM arriendo 
									inner join gd 
										on arriendo.cod_arriendo = gd.id_arriendo
									WHERE arriendo.cod_arriendo ='$valor2'";
					
					$res        = mysql_query($sql,$link) or die(mysql_error()); 
					$registro   = mysql_fetch_array($res);				
					$valor      = $registro['cod_arriendo'];
					$gd         = $registro['num_gd'];
					//busqueda datos cliente
					$rut_cli    = $registro['rut_cliente']; 
					$sql1       = "SELECT * FROM clientes WHERE rut_cliente ='$rut_cli'";
					
					$res1       = mysql_query($sql1,$link) or die(mysql_error()); 
					$registro1  = mysql_fetch_array($res1);
					$nombre_cli = $registro1['raz_social'];
				}		
		?><?php 
					if (!empty($nombre_cli))
		  			{
  						echo($nombre_cli);
		 			 }else{
			  			echo(" ");
		  			}
					?></div></td><div align="left"> 
          </div>
                  </tr>
                  <tr>
                    <td colspan="6" bgcolor="#06327D"><span class="Estilo7">
                      <?php
					  if (empty($registro['cod_arriendo']))
					  { 
					   }else{ 
					  	echo (" Arriendo N° ") ;
					   }
					  ?>
                      <span class='mini_titulo'>
            <?php if (empty($registro['cod_arriendo'])){ }else{ echo " : " ;}?><?php if (empty($valor1)&&(empty($valor2))){ }else{ 
				   $cantidad = strlen($registro['cod_arriendo']); 
				   if ($cantidad==1) { echo ("0000000" .('' . $registro['cod_arriendo'] . ' ') );  }
				   if ($cantidad==2) { echo ("000000" .('' . $registro['cod_arriendo'] . ' ') );  }
				   if ($cantidad==3) { echo ("00000" .('' . $registro['cod_arriendo'] . ' ') );  } 
				   if ($cantidad==4) { echo ("0000" .('' . $registro['cod_arriendo'] . ' ') );  }
				   if ($cantidad==5) { echo ("000" .('' . $registro['cod_arriendo'] . ' ') );  }
				   if ($cantidad==6) { echo ("00" .('' . $registro['cod_arriendo'] . ' ') );  }	
				   if ($cantidad==7) { echo ("0" .('' . $registro['cod_arriendo'] . ' ') );  }
				?>
            </span>
                    <?php } ?>
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="21%"><div align="left">Raz&oacute;n Social</div></td>
                    <td width="2%">: </td>
                    <td colspan="3"><div align="left">
                      <input  name="txt_codigo" type="text" size="50" maxlength="50" value="<?php 
					if (!empty($nombre_cli))
		  			{
  						echo($nombre_cli);
		 			 }else{
			  			echo(" ");
		  			}
					?> " disabled="disabled"/>
                    </div></td>
                    <td width="4%" align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Rut</div></td>
                    <td>: </td>
                    <td colspan="3"><div align="left">
                      <input  name="txt_rut" type="text" value="<?php echo $registro['rut_cliente'];?>" size="12" maxlength="12" disabled="disabled"/>
                    </div></td>
                    <td>
</td>
                  </tr>
                  <tr>
                    <td><div align="left">N&deg; OC:</div></td>
                    <td>:</td>
                    <td colspan="3"><input name="txt_oc" type="text" value="<?php echo $registro['num_oc'];?>" size="6" maxlength="6" disabled="disabled"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Tipo Orden de Compra: </div></td>
                    <td>:</td>
                    <td width="32%"><input name="txt_oc2" type="text"value="<?php
					if ($registro['tipo_oc']== 0) { 
						echo("ABIERTA");
					}elseif ($registro['tipo_oc']== 1){ 
						echo("CERRADA");
					}elseif ($registro['tipo_oc']== 2){ 
						echo "SIN OC";
					}elseif ($registro['tipo_oc']== 3){ 
						echo "ORDEN DE COMPRA PENDIENTE";
					}
					?>" size="20" maxlength="20" disabled="disabled"/></td>
                    <td><div align="right">Fecha Vencimiento OC: </div></td>
                    <td width="16%"><input name="txt_oc3" type="text" value="<?php 
						if (($registro['tipo_oc']== 1)){ 
							$fecha_temp = explode("-",$registro['fecha_vcmto']);
							//año-mes-dia
							//0 -> dia, 1 -> mes, 2 -> año
							$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
							echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];
						}
						else{
							echo "";
							}
						?>" 
                        size="25" maxlength="25" disabled="disabled" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">N&deg; GD:</div></td>
                    <td>:</td>
                    <td colspan="3"><input name="txt_numgd" type="text" value="<?php echo $registro['num_gd'];?>" size="6" maxlength="6" disabled="disabled"/>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Tipo de garant&iacute;a: </div></td>
                    <td>:</td>
                    <td colspan="3"><input name="txt_oc4" type="text" value="<?php $fp  = $registro['tipo_garantia'];
						$sqltg = "SELECT tipo_garantia FROM tipo_garantia WHERE cod_tipo_gar ='$fp'";
						//echo "sql= $sql<br>";
						$restg = mysql_query($sqltg,$link) or die(mysql_error()); 
						$registrotg = mysql_fetch_array($restg);
						echo($registrotg['tipo_garantia']);
					?>" size="25" maxlength="25" disabled="disabled"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Forma de pago:</div></td>
                    <td>:</td>
                    <td colspan="3"><input name="txt_oc5" type="text" value="<?php $fp  = $registro['forma_pago'];
						$sqlfp = "SELECT forma_pago FROM forma_pago WHERE cod_forma_pago ='$fp'";
						//echo "sql= $sql<br>";
						$resfp = mysql_query($sqlfp,$link) or die(mysql_error()); 
						$registrofp = mysql_fetch_array($resfp);
						echo($registrofp['forma_pago']);?>" size="25" maxlength="25" disabled="disabled" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Vendedor:</div></td>
                    <td>:</td>
                    <td colspan="3"><input name="txt_oc6" type="text"  value="<?php
						$vendedor  = $registro['cod_personal'];
						$sqlper    = "SELECT nombres_personal, ap_patpersonal FROM personal WHERE cod_personal ='$vendedor'";
						//echo "sql= $sql<br>";
						$resper = mysql_query($sqlper,$link) or die(mysql_error()); 
						$registroper = mysql_fetch_array($resper);
						echo($registroper['nombres_personal']. ' ' .$registroper['ap_patpersonal']);
					?>" 
                    size="50" maxlength="50" disabled="disabled"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Fecha Emisión GD</td>
                    <td>:</td>
                    <td><input name="txt_num_gd" id="txt_num_gd" value="<?php 
							
							$sql = "select fecha from gd where num_gd =".$gd;
							$res = mysql_query($sql,$link);
							$row = mysql_fetch_array($res);
							
							$fecha_temp = explode("-",$registro['fecha']);
							//año-mes-dia
							//0 -> dia, 1 -> mes, 2 -> año
							$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
							echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];
							?>" disabled="disabled"/></td>
                    <td><div align="right"></div></td>
                    <td><input name="txt_oc11" type="hidden" value="<?php echo $registro['fecha_vcmto'];?>" size="10" maxlength="10" disabled="disabled"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Fecha  Arriendo:</div></td>
                    <td>:</td>
                    <td><input name="txt_oc8" type="text" value="<?php 
							$fecha_temp = explode("-",$registro['fecha_arr']);
							//año-mes-dia
							//0 -> dia, 1 -> mes, 2 -> año
							$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
							echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];?>" 
							
                            size="10" maxlength="10" disabled="disabled"/></td>
                    <td><div align="right">Hora Arriendo:</div></td>
                    <td><input name="txt_oc10" type="text" value="<?php echo $registro['hora_arr'];?>" size="8" maxlength="8" disabled="disabled"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Forma Entrega:</div></td>
                    <td>:</td>
                    <td><input name="txt_oc9" type="text" value="<?php
						$fe  = $registro['forma_entrega'];
						if ($registro['forma_entrega'] == 1) 
						{
							echo("RETIRA CLIENTE");
						}else{
							echo("ENTREGA EN OBRA");
						}
					?>"  size="20" maxlength="20" disabled="disabled"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6"></td>
                  </tr>
                </table></td>
              </tr>
              <tr><br />

              </tr>
          </table>
            <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
                  <th width="21%"><input type="hidden" name="txt_cod" size="20" maxlength="30" /><input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
                  <th width="33%">&nbsp;</th>
                </tr>
                <tr>
                  <th colspan="2" bgcolor="#06327D"><div align="center" class="Estilo7">Equipos Seleccionados</div></th>
                </tr>
                <tr>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">C&oacute;dgo Equipo</div></th>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Nombre
                    <?php
			$sql="SELECT * FROM  equipos_arriendo where cod_arriendo = '$valor2' order by cod_equipo ASC";
		
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?>
                  </div></th>
                </tr>
                <tr bordercolor="#FFFFFF"  title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
                  <td align="left"> <?php 
			  	   $cantidad = strlen($registro['cod_equipo']); 
				
				   if ($cantidad==1) { echo ("0000000".($registro['cod_equipo']));}
				   if ($cantidad==2) { echo ("000000".($registro['cod_equipo']));}
				   if ($cantidad==3) { echo ("00000".($registro['cod_equipo']));}
				   if ($cantidad==4) { echo ("0000".($registro['cod_equipo']));}
				   if ($cantidad==5) { echo ("000".($registro['cod_equipo']));}
				   if ($cantidad==6) { echo ('00'.$registro['cod_equipo']);}		
				   if ($cantidad==7) { echo ('0'.$registro['cod_equipo']);}	
				   if ($cantidad==8) { echo $registro['cod_equipo'];}	
			  ?> </td>
                  <td align="left"><?php
				  if (!empty($registro['cod_equipo']))
					  {
						  $sql3="SELECT nombre_equipo FROM equipo where cod_equipo = " .$registro['cod_equipo']. "";
						 
						  $res3 = mysql_query($sql3) or die(mysql_error());
						  $registro3 = mysql_fetch_array($res3);
						  echo htmlentities($registro3['nombre_equipo']);
					  }else{
						  echo(" ");
					  }
			 ?></td>
                </tr>
                <tr>
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                </tr>
                <?php
				}
				mysql_free_result($res);
				mysql_close($link);
		 ?>
 
        </table>
      </form>
      </td>
    </tr>
    <tr>
      <td colspan="2"valign="top" align="right"><a href="menu.php" onmouseover="Volver" title="Volver"><span class="Estilo6 Estilo19 Estilo20 ">
        </span><img src="images/volver.png" width="40" height="40" class="oculto" border="0"/></a>
     <!-- <a href="impgd.php?num_gd='<?php //echo $gd;?>'" onclick="window.open('impgd.php?num_gd=<?php //echo $gd; ?>','','width=1,height=1');return false"></a>-->
      <a id="vista-previa-gd" href="#" download><img width="50" height="51" border="0" class="oculto" title="Descargar Guia Despacho" src="images/gest_fin/factura.png"></a>
      <a id="imprimir-arriendo" href="#"><img width="50" height="51" border="0" class="oculto" title="Imprimir Hoja Arriendo" src="images/impresora.png"></a>
      <a id="imprimir-contrato" href="#"><img width="50" height="51" border="0" class="oculto" title="Imprimir Contrato" src="images/gest_fin/proveedores.png"></a>
      
      <!--<input type="image" name="impresion" value="Impresion" title="Imprimir Arriendo" width="40" height="40" src="images/impresora.gif" onclick="window.print();"class="oculto"/>-->
 </td>
    </tr>
  </table>
  
  <!--<div><strong>Vista Previa de Impresi&oacute;n - Gu&iacute;a de Despacho</strong></div>
  <iframe src="impgd.php?num_gd=<?php //echo $gd;?>&codarr=<?php //echo $_GET['codarr'];?>&imprimir=0" width="1200" height="725" ></iframe>-->
 <br />
</div>
	<link rel="stylesheet" type="text/css" href="styles_menu.css" />
<script type="text/javascript" src="ie.js"></script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
	$(document).ready(function(){
		
		$("#imprimir-contrato").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});

		$("#imprimir-arriendo").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});
		$("#vista-previa-gd").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});
		});
	$(window).load(function() {
		$("#imprimir-arriendo").attr('href','classes/hoja_arriendo/imprimir_hoja_arriendo_inicial.php?cod_arriendo=<?php echo $valor2 ?>');
		$("#vista-previa-gd").attr('href','classes/consulta-gd/vista-previa-gd-manual.php?num_gd=<?php echo $gd ?>&arriendo=1');
		$("#imprimir-contrato").attr('href','doc_arriendo_contrato.php?num_gd=<?php echo $gd ?>');
		});
</script>
</body>
</html>