<?php ob_start(); 
session_start(); 

$usuario ="";

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
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
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_equipo'].value = com;
}

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 
</script>
<script type="text/javascript" src="script.js"></script>
<script>
function abrir() // windows open 
{

window.open("busca_cod_manual.php?id",""," width = 400,height=300,scrollbars=NO");
}
function cerrarVentana(){

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
.Estilo71 {color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
}
-->
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<input type="hidden" name="tipo_busqueda" id="tipo_busqueda" value="" />
<table width="98%" border="0">
  <tr>
    <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
    <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
            <br />
            <br />
            <span class="Estilo23 Estilo21">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
  </tr>
</table>
<div id="menu">
	<?php 
	include("classes/menu.php")	;
	
	?>
</div>
  <p>&nbsp;</p>
  <table width="95%" border="0" align="center">
    <tr>
      <td width="50%" height="31"><div align="left" class="Estilo6 Estilo19 Estilo20"> 
        <?php
			{
	include("classes/conex.php");
$link=Conectarse();
			}
		?>
            <?php
			{
				//codigo de arriendo
				$valor2 = $_GET["codarr"];
				
			}
				
				if (!empty($valor2))
				{
					//busqueda datos arriendo
					$link       = Conectarse();
					$sql        = "SELECT * FROM arriendo_temp WHERE cod_arriendo ='$valor2' and usuario = '".$usuario."'";
					
					//echo '<h1>'.$sql.'</h1>';
					
					$res        = mysql_query($sql,$link) or die(mysql_error()); 
					$registro   = mysql_fetch_array($res);				
					$valor      = $registro['cod_arriendo'];
					$nom_obrarr = $registro['cod_obra'];
					//busqueda datos cliente

					$rut_cli    = $registro['rut_cliente']; 
					$sql1       = "SELECT * FROM clientes WHERE rut_cliente ='$rut_cli'";
					
					$res1       = mysql_query($sql1,$link) or die(mysql_error()); 
					$registro1  = mysql_fetch_array($res1);
					$nombre_cli = $registro1['raz_social'];
					//buscar obra
					$sqlobra    = "SELECT * FROM obra WHERE cod_obra ='$nom_obrarr'";
					
					$resobra    = mysql_query($sqlobra,$link) or die(mysql_error()); 
					$registrobra= mysql_fetch_array($resobra);
					$nomobra    = $registrobra['nombre_obra'];
					
				}		
		?>
      Paso 2</div></td>
      <td width="50%"><div align="right" class="Estilo6 Estilo19 Estilo20 ">SELECCION DE EQUIPO </div></td>
    </tr>
    <tr>
      <td height="162" colspan="2"valign="top">
      <form method="POST" name="frmDatos" id="frmDatos">
          <table width="100%"  align="center" border="0">
              <tr>
                <td colspan="5"><table width="100%" border="0" align="center">
                  <tr>
                    <td colspan="5" bgcolor="#06327D"><div align="left" class="Estilo7">
					<?php 
					if (!empty($nombre_cli))
		  			{
  						echo($nombre_cli);
		 			 }else{
			  			echo(" ");
		  			}
					?>
                    <?php echo"-".($nomobra);?></div></td><div align="left"> 
          </div>
                  </tr>
                  <tr>
                    <td colspan="5" bgcolor="#06327D"><span class="Estilo7">
                      <?php if (empty($registro['cod_arriendo'])){ }else{ echo " Arriendo N° " ;}?>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="22%"><div align="left">C&oacute;digo</div></td>
                    <td width="2%">: </td>
                    <td width="62%"><div align="left">
                      <input  name="txt_codigo" type="text" onkeypress="Nom(this.form,'buscarcodigo')"/>
                      <input type="submit" name="buscarcodigo" id="button" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px" class="formato_boton" title="Buscar Equipo por Código" />
                    </div></td>
                    <td width="9%">&nbsp;</td>
                    <td width="5%" align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Nombre</div></td>
                    <td>: </td>
                    <td><div align="left">
                      <input  name="txt_nombre" type="text" onkeypress="Nom(this.form,'buscarnombre')"/>
                      <input type="submit" name="buscarnombre" id="button2" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px" class="formato_boton" title="Buscar Equipo por Nombre" />
                      </div></td>
                    <td>&nbsp;</td>
                    <td>
<?php
//envia el nombre
if (($_POST['buscarcodigo']=='Buscar')||($_POST['tipo_busqueda']=='buscarcodigo'))
{
	$busca_cod=$_POST['txt_codigo'];
	$cod_arriendo=$registro['cod_arriendo'];
    echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_cod_manual.php?id=$busca_cod&cod_arr=$cod_arriendo'>";
}
//envia el codigo
if (($_POST['buscarnombre']=='Buscar')||($_POST['tipo_busqueda']=='buscarnombre'))
{
	$busca_nom=$_POST['txt_nombre'];
	$cod_arriendo=$registro['cod_arriendo'];
    echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_cod_manual.php?nombre=$busca_nom&cod_arr=$cod_arriendo'>";
}
?>
</td>
                  </tr>
                  <tr>
                    <td colspan="5"></td>
                  </tr>
                </table></td>
              </tr>
              <tr><br />

              </tr>
            </table>
            <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
                  <th width="18%">
              <input type="hidden" name="txt_cod" size="20" maxlength="30" />
              <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
                  <th colspan="2">&nbsp;</th>
                  <th width="2%">&nbsp;</th>
                  <th width="13%">&nbsp;</th>
                  <th width="10%" align="right">&nbsp;</th>
                </tr>
                <tr>
                  <th colspan="6" bgcolor="#06327D"><div align="center" class="Estilo7">Equipos Seleccionados</div></th>
                </tr>
                <tr>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">C&oacute;dgo Equipo</div></th>
                  <th width="44%" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
                  <th width="13%" bgcolor="#06327D"><div align="center" class="Estilo17">Imagen</div></th>
                  <th colspan="2" bgcolor="#06327D"><div align="center" class="Estilo17">Incluye Accesorios</div></th>
                  <th bgcolor="#06327D"><?php
			$sql="SELECT * FROM  equipos_arriendo_temp where cod_arriendo = '$valor2' and usuario = '".$usuario."'"." order by cod_equipo ASC";
			
			//echo '<h1>'.$sql.'</h1>';
		
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?>
                    <span class="Estilo17 Estilo13 Estilo15">Quitar</span></th>
                </tr>
                <tr bordercolor="#FFFFFF"  class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
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
                  <td align="left" bgcolor="#FFFFFF"><?php if (!empty($registro['cod_equipo']) && is_dir('images/producto'.$registro['cod_equipo'].'/'))
					   {
					   $codproducto  = $registro['cod_equipo'];
					   $codproducto2 = $registro['cod_equipo'];
					   $codproducto2 = preg_replace("/&Ntilde;/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/&ntilde;/", "%F1", $codproducto2);	
					   $result2 = mysql_query("SELECT cod_equipo FROM equipo WHERE cod_equipo = '$txt_cod'" );
					//   echo($result2);				
					   $row2=mysql_fetch_array($result2); 
					    echo '<div class="logo">'.'<img src="images/producto'.$codproducto2.'/thumb/foto0.thumb.jpg"></div>'; 
						}  ?></td>
                  <td colspan="2" align="left" bgcolor="#FFFFFF"><div align="center">
                    <input name="incluyeaccesorio[]" type="checkbox" id="incluye_accesorio[]" value="<?php echo $registro['cod_equipo']; ?>" onclick="seleccionar_accesorio(<?php echo $registro['cod_equipo']; ?>,<?php echo $valor2 ?>)" 
                    <?php 
						$sql_3    = "select * 
									from equipos_arriendo_temp
									where cod_equipo =".$registro['cod_equipo']." 
										and cod_arriendo = ".$valor2;
					 	$res_3=mysql_query($sql_3);
						while($row_acc = mysql_fetch_array($res_3)){
							if ($row_acc['inc_accesorio']=='0'){
								echo "";
								}
							else{
								echo 'checked="checked"';
								}
							}
					 ?>  />
                  </div></td>
                  <td align="center" bgcolor="#FFFFFF"><input type="image" name="borrar" value="Borrar" title="Eliminar Equipo del arriendo" src="images/error.png" onclick="elimina=confirm('¿Desea quitar?');return elimina;" /></td>
                </tr>
                <tr>
                  <td height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF"><p>&nbsp;</p></td>
                  <td colspan="2" class="CONT">&nbsp;</td>
                  <td class="CONT">&nbsp;</td>
              </tr><?php
				}
				mysql_free_result($res);
				mysql_close($link);
		 ?>
                <tr>
                  <td height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
                  <td colspan="3" class="CONT" align="right">
                  
                    <input type="submit" name="paso1" value="paso1" style="background-image:url(images/volver.png); width:40px; height:40px" class="formato_boton" onClick="history.back()" title="Ir al paso 1"/>
                    <!--<input type="image" name="paso1"  class="boton" title="Ir Paso 1" value="paso1"  src="images/volver.png" width="30"  height="30"/>-->
                  
                  
                    <span class="Estilo71">
                    <input type="submit" name="cancelar" value="Cancelar" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;" style="background-image:url(images/cancelar_arr.png); width:40px; height:40px" class="formato_boton"  title="Cancelar arriendo" />
                   
                   <!-- <input name="cancelar" type="image" class="boton" title="Cancelar Arriendo" value="Cancelar"  src="images/cancelar_arr.png" width="35" height="35" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;"  />-->
                    
                    
                    <input type="submit" name="OK" id="button3" value="Continuar" style="background-image:url(images/siguiente.png); width:40px; height:40px" class="formato_boton" title="Ir Paso 3"/>
                   <!--<input name="OK" type="image" class="boton" title="Ir Paso 3" value="Continuar"  src="images/siguiente.png" width="30"  height="30"/>-->
                  </span></td>
              </tr>
                
          <?php
			function mensaje()
				{
					echo "<script>
					alert('Seleccione al menos un Equipo');
					</script>";
				}
		  ?>
         <?php
		if($_POST['borrar']=='Borrar')
		 { 
			 $link         = Conectarse();
			 $cod_arriendo = $_GET['cod_arr'];
			 $codigo       = trim($_POST['txt_cod']);
			 $sql  = "DELETE FROM equipos_arriendo_temp WHERE cod_equipo = '$codigo' and cod_arriendo = '$valor2' and usuario = '".$usuario."'";
		
			 $res     = mysql_query($sql) or die(mysql_error()); 
			 
			 $sql = "UPDATE equipo SET cod_estado_equipo=1 where cod_equipo='$codigo'";
			
			 $res  = mysql_query($sql) or die(mysql_error());
			 mysql_close($link);	
			 
			 echo "<script type='text/javascript'>RegistroGrabado();</script>";
			 echo "<script language=Javascript> location.href=\"arriendo_equipo.php?codarr=".$valor2."\"; </script>";
		 }   
	  ?>
      <?php	 
	  if ($_POST['OK']=='Continuar')
	  {
		  //actualiza si incluye accesorio
		  if(isset($_POST['incluyeaccesorio']))
		  {
		  		$link=Conectarse();
				$sql = "UPDATE equipos_arriendo_temp SET inc_accesorio = 0 WHERE cod_arriendo = ".$valor2." and usuario = '".$usuario."'";
				$res  = mysql_query($sql) or die(mysql_error());
				
				
				for ($x=0; $x < count($_POST['incluyeaccesorio']); $x++)
			  	{
		  				//echo 'posicion '.$x.'  valor: '.$_POST['incluyeaccesorio'][$x];
						//echo '</br>';
						
						$link=Conectarse();
						$sql = "UPDATE equipos_arriendo_temp SET inc_accesorio = 1 WHERE cod_equipo = ".$_POST['incluyeaccesorio'][$x]." AND cod_arriendo = ".$valor2." and usuario = '".$usuario."'";
						$res  = mysql_query($sql) or die(mysql_error());
						
		  
		  		}
		  
		  }
		  
		 
		 
		  $link=Conectarse();
		
		  $result="SELECT COUNT(*) as filas FROM equipos_arriendo_temp WHERE cod_arriendo = '$valor2'";
		  $rs_busqueda=mysql_query($result);
		  $filas=mysql_result($rs_busqueda,0,"filas");
		
		  if ($filas>=1)
		  {
			echo "<script language=Javascript> location.href=\"arriendo_datos_manual.php?codarr=".$valor2."\"; </script>";
		  }else{
		  	$link=mensaje();
		  }
				
	  }	  
	?>
     <?php	 
	  if ($_POST['paso1']=='paso1')
		  {
			echo "<script language=Javascript> location.href=\"arriendo_cliente_manual.php?codarr=".$valor2."\"; </script>";	
		  }	  
	?>
     <?php
		if($_POST['cancelar']=='Cancelar')
		 { 
			 $link         = Conectarse();
			 $cod_arriendo = $_GET['cod_arr'];
			 $codigo       = trim($_POST['txt_cod']);
			 
			 //buscar el arriendo
			 $sql    = "SELECT * FROM equipos_arriendo_temp WHERE cod_arriendo = '$valor2'";
			 $res=mysql_query($sql);
			 
			 while ($registro = mysql_fetch_array($res))
			 {
		 		//borrar equipos del arriendo
				$cod_equipo=$registro['cod_equipo'];
			
				//actualizar estado del equipo
			    $sql2    = "UPDATE equipo SET cod_estado_equipo = '1' where cod_equipo =".$registro['cod_equipo']; 
			
				$res2   = mysql_query($sql2) or die(mysql_error());	
			}	
			 	
				mysql_query("DELETE FROM equipos_arriendo_temp WHERE cod_arriendo IN(".$valor2.") and usuario = '".$usuario."'");
					     
			 
			 //borrar arriendo
			 $sql    = "DELETE FROM arriendo_temp WHERE cod_arriendo = '$valor2' and usuario = '".$usuario."'";
			 $res    = mysql_query($sql) or die(mysql_error()); 

			 mysql_close($link);	
			 
			 echo "<script type='text/javascript'>RegistroGrabado();</script>";
			 echo "<script language=Javascript> location.href=\"menu.php\"; </script>";
		 }   
	  ?>
        </table>
      </form>
      </td>
    </tr>
  </table>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script>
	function seleccionar_accesorio(cod_equipo, valor2){
		$(document).ready(function(){
				$.ajax({
					url: 'classes/arriendo_equipo/seleccionar_accesorio.php?cod_equipo='+cod_equipo+'&codarr='+valor2+'&usuario='<?php echo $usuario?>,
					success : function(){
						//alert('seleccionar_accesorio.php?cod_equipo='+cod_equipo+'codarr='+valor2);
						}
					});
			});
		}
</script>
</body>

</html>