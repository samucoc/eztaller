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
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script src="js/jquery-1.6.2.min.js"></script>
<script language="JavaScript">
<!--
function buscar_nombre(nombre){


window.location.href='busca_reclamo_nombre.php?nombre='+nombre;
}

function buscar_nombre_reemplazo(nombre){
var id1 = document.getElementById('txt_cod_eqdev').value;

if(id1 == '')
{
alert ('Debe primero ingresar un equipo para devolver');
}else{
window.location.href='busca_reclamo_nombre.php?nombre='+nombre+'&tipo=id2&id1='+id1;
}


}


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
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2 Estilo25"><br />
       <br />
       <br />
       <span class="Estilo23">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>	
<p>&nbsp;</p>
<form action="reclamo.php" method="post" enctype="multipart/form-data" name="frmDatos" id="frmDatos"> 
<table width="95%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="80%" height="37"><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php
  	    {
			include("classes/conex.php");
			$link=Conectarse();

	    }
	 ?>
      <?php if (!empty($valor1)) echo($valor1. " - ");?>
            <?php
			{		//busqueda equipo devuelto
					//rcb
					if(isset($_GET['id'])){
						$valor2 = $_GET['id'];
					}
					else{
						$valor2 = $_POST["txt_cod_eqdev"];
					
					}
					
					
				    if (empty($valor2)){
					}else{
					  	$link=Conectarse();
						$sql = "SELECT * 
								from equipos_arriendo 
								WHERE cod_equipo ='$valor2'
									and estado_equipo_arr = 'NO DEVUELTO'
								order by arrendado_desde desc
								limit 0,1";
						
						$res        = mysql_query($sql,$link) or die(mysql_error()); 
						$registro   = mysql_fetch_array($res);
						$codigo_arr = $registro['cod_equipo'];
						$codigo_clie= $registro['cod_cliente'];
						$arriendo_num=$registro['cod_arriendo'];
					    //buscar nombre equipo
						$sql_nombre = "SELECT * from equipo WHERE cod_equipo ='$codigo_arr' and cod_estado_equipo='3'";
			            
						$res_nombre = mysql_query($sql_nombre,$link) or die(mysql_error()); 
						$registro_nombre= mysql_fetch_array($res_nombre);
						
						if (empty($registro_nombre['cod_equipo']) && $_POST["buscar_equi"]=="Buscar_Equi")
						 {
							 echo "<script> alert (\"Equipo No se encuentra Arrendado\"); </script>";
							 echo "<script language=Javascript> location.href=\"reclamo.php\"; </script>";
							 
						 }else{
							 
							$sql = "SELECT * from arriendo WHERE cod_arriendo ='$arriendo_num'";
							
							$res_arr = mysql_query($sql,$link) or die(mysql_error()); 
							$registro_arr = mysql_fetch_array($res_arr);
						
							$rut  =$registro_arr['rut_cliente'];
							$cod_obra  =$registro_arr['cod_obra'];
							
							$sql = "SELECT * from clientes WHERE rut_cliente ='$rut'";
							
							
							
							$res_cli = mysql_query($sql,$link) or die(mysql_error()); 
							$registro_cli = mysql_fetch_array($res_cli);
							
							$valor1=$registro_cli['raz_social'];
							$codigo_cliente=$registro_cli['cod_cliente']; 
							
							
						
						 }
					}
				}
		?>
            <?php
			{		//busqueda equipo entregado
					//rcb
					if(isset($_GET['id2']))
					{
						$_POST["txt_cod_eqentr"] = $_GET['id2'];
					}
					
								
					if (($_POST["buscar_equientreg"]=="Buscar_Equintreg" ) || (!empty($_POST["txt_cod_eqentr"])))
					{
						$valor3 = $_POST["txt_cod_eqentr"];
	                   
					   
						if (empty($valor3)){
						}else{
							$link=Conectarse();
							$sql3 = "SELECT * from equipo WHERE cod_equipo ='$valor3' and cod_estado_equipo=1";
				//			
							$res3 = mysql_query($sql3,$link) or die(mysql_error()); 
							$registro3= mysql_fetch_array($res3);
							
							
							if (empty($registro3['cod_equipo']) && $_POST["buscar_equientreg"]=="Buscar_Equintreg")
							 {
								 echo "<script> alert (\"Equipo No Disponible para Cambio\"); </script>";
							 }
						}
					}
				}
		?>
            <strong><font>
            <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
           	 
		}else{
			  $estado_objetos = 'disabled';
           	  
		};
		?>
            </font></strong>RECLAMO/CAMBIO EQUIPO</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top">
          <table width="100%" border="0" align="center">
            <tr>
              <td colspan="5"></td>
            </tr>
            <tr>
              <td colspan="5" bgcolor="#06327D"><div align="left"> <span class="Estilo24">Datos Equipo Devuelto
                <?php 
					if (!empty($registro['cod_arriendo'])) {
						echo(" - Guia de Despacho N&deg;<span style='color:yellow'>:  ". $registro['num_gd']."</span>");
						} 
				?>
                </span></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3"><div align="left">
                <input name="txt_cod_eqdev" type="hidden" id="txt_cod_eqdev" value="<?php if (!empty($registro['cod_equipo_dev'])) 
			{echo ($registro['cod_equipo_dev']);}
			else
			{
					if(isset($_GET['id']))
					{
						$_POST["txt_cod_eqdev"] = $_GET['id'];
					}
					
					echo($_POST["txt_cod_eqdev"]) 
			
			;}?>" size="8" maxlength="8" readonly="readonly" />
                <!--<input type="image" name="buscar_equi" value="Buscar_Equi" title="Buscar Equipo Devuelto" class="searchbutton" src="images/ver.png"/>-->
                </div></td>
            </tr>
            <tr>
              <td>Nombre Equipo</td>
              <td>:</td>
              <td > <input id="txt_nombre"  name="txt_nombre" type="text" value="<?php echo htmlentities(strtoupper($registro_nombre['nombre_equipo']));?>" size="40" maxlength="40" />          <a href="#" onclick="javascript:buscar_nombre(document.frmDatos.txt_nombre.value);"><img title="Buscar Equipo por Nombre" src="images/ver.png" border="0"/></a></td>
              <td><div align="right">Fecha Arriendo:<?php //print_r ($registro_nombre); ?></div></td>
              <td>
              <?php 
			  if(isset($_GET['id'])){
			  
				  $id_equipo_rec = $_GET['id'];
				  
				  //echo $id_equipo_red;
				  
				  $sql_arr_1 = "SELECT * 
				  				FROM equipos_arriendo 
								where cod_equipo = ".$id_equipo_rec."
									and estado_equipo_arr = 'NO DEVUELTO'
								order by arrendado_desde desc
								limit 0,1";
				  $res_arr_1 = mysql_query($sql_arr_1,$link) or die(mysql_error()); 
				  $reg_arr_1 = mysql_fetch_array($res_arr_1);
				  
				  //print_r ($reg_arr_1);
				  
				  $arr_desde = $reg_arr_1['arrendado_desde'];
				  $hora_arr = $reg_arr_1['hora_arr'];
				  
				  //echo $sql_arr_1;
			  
			  }else{
			  		$arr_desde = '';
					$hora_arr = '';
			  }
			  
			  ?>
              <input name="txt_fecha_arr" type="text" id="txt_fecha_arr" value="<?php 
					if ($arr_desde!=''){
						$array_temp = explode('-',$arr_desde);
						echo date('d-m-Y',mktime(0, 0, 0, $array_temp[1], $array_temp[2], $array_temp[0]));
					}else{
						//echo date('d-m-Y');
						echo $_POST['txt_fecha_arr'];             // echo "$codigo_equidev<br>";
						}?>"  />
               <input type="hidden" name="hora_arriendo" id="hora_arriendo" value="<?php echo $hora_arr;?>" />
                        </td>
            </tr>
            <tr>
              <td>Estado Actual Equipo</td>
              <td>:</td>
              <td colspan="3"><?php 
			  
				$sqlest      = "SELECT estado_equipo.descripcion_estado
								FROM equipo 
									inner join estado_equipo 
										on equipo.cod_estado_equipo = estado_equipo.cod_estado_equipo
								where equipo.cod_equipo= '$valor2'";
				
				$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
				$registroest = mysql_fetch_array($resest);
			  	echo $registroest['descripcion_estado'];
			  ?></td>
            </tr>
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" bgcolor="#06327D"><div align="left"> <span class="Estilo24">Datos Cliente </span>
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php if (!empty($registro['cod_cliente'])) 
			{echo ($registro['cod_cliente']);}else{echo($_POST["txt_cod"]) ;}?>" />
                <input type="hidden" name="txt_cod2" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </div></td>
            </tr>
            <tr>
              <td><div align="left"> Rut </div></td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <input name="txt_rut" type="text" id="rut" value="<?php if (!empty($registro_cli['rut_cliente'])) 
			{echo ($registro_cli['rut_cliente']);}else{echo($_POST["txt_rut"]) ;}?>" size="12" maxlength="12" readonly="readonly"/>
                
                <input type="hidden" name="txt_cod3" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </div></td>
            </tr>
            <tr>
              <td><div align="left"> Razon Social </div></td>
              <td>:</td>
              <td colspan="3"><input name="txt_razonsoc" type="text" value="<?php if (!empty($registro_cli['raz_social'])) 
			{echo ($registro_cli['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" readonly="readonly"/></td>
            </tr>
            
            <tr>
              <td>Obra</td>
              <td>:</td>
              <td colspan="3"><?php 
			  
			  //echo $codigo_arr. ' ' . $arriendo_num. ' ' . $cod_obra; 
			  if(isset($_GET['id']))
			  {
			  	$sql_obra = "SELECT * FROM obra where cod_obra = ".$cod_obra;
			  	$res_obra = mysql_query($sql_obra,$link) or die(mysql_error()); 
			  	$registro_obra = mysql_fetch_array($res_obra);
			  }else{
			  	$registro_obra['nombre_obra'] = '';
			  }
			   ?>
			  
			     <input name="nombre_obra" type="text" value="<?php 
				 	if (!empty($registro_obra['nombre_obra'])){
						echo $registro_obra['nombre_obra'];
						}
					else{
						echo $_POST['nombre_obra'];
						}?>" size="50" readonly="readonly"/>              </td>
            </tr>
            <tr>
              <td>Dirección Obra</td>
              <td>:</td>
              <td colspan="3">
              
               <?php if(!isset($_GET['id'])){
			   		$registro_obra['direcc_obra'] = '';
			   
			   }
			   ?>
              
			  <input name="direcc_obra" type="text" value="<?php 
					if (!empty($registro_obra['direcc_obra'])){
						echo $registro_obra['direcc_obra'];
						}
					else{
						echo $_POST['direcc_obra'];
						}?>" size="50" readonly="readonly"/>			 </td>
            </tr>
            
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" bgcolor="#06327D"><div align="left"> <span class="Estilo24">Datos Equipo Reemplazo</span></div></td>
            </tr>
            <tr>
              <td><div align="left"></div></td>
              <td>&nbsp;</td>
              <td colspan="3" align="left"><input name="txt_cod_eqentr" type="hidden" value="<?php if (!empty($registro3['cod_equipo_entreg'])) 
			{echo ($registro3['cod_equipo_entreg']);}else{echo($_POST["txt_cod_eqentr"]) ;}?>" size="8" maxlength="8" readonly="readonly" />
                <!--<input type="image" name="buscar_equientreg" value="Buscar_Equintreg" title="Buscar Equipo Entregado" class="searchbutton" src="images/ver.png"/>-->                </td>
            </tr>
            <tr>
              <td>Nombre Equipo</td>
              <td>:</td>
              <td colspan="3" align="left"><input  name="txt_nombre_reemplazo" type="text" value="<?php 
			  		if (!empty($registro3['nombre_equipo'])) {
						echo htmlentities($registro3['nombre_equipo']);
						}
					else{
						echo htmlentities(strtoupper($_POST["txt_nom_equipo2"]));
						}
					?>" size="40" maxlength="40" /><a href="#" onclick="javascript:buscar_nombre_reemplazo(document.frmDatos.txt_nombre_reemplazo.value);"><img title="Buscar Equipo por Nombre" src="images/ver.png" border="0"/></a></td>
            </tr>
            <tr>
              <td><div align="left">Fecha Devolucion</div></td>
              <td>:</td>
              <td><div align="left">
                <input name="txt_fecha_dev" type="text" id="txt_fecha_dev" value="<?php 
						if (isset($_POST["txt_fecha_dev"])){
							echo $_POST["txt_fecha_dev"];
							}
						else{
							if (!empty($registro['fecha_reclamo'])) {
								$array_arr_desde = explode('-',$registro['fecha_reclamo']);
								echo date('d-m-Y',mktime(0, 0, 0, $array_arr_desde[1], $array_arr_desde[2], $array_arr_desde[0]));
								}
							else{
								echo date('d-m-Y');
							}
						} ?>" size="10" maxlength="10" />
                <button type="submit" id="cal-button-1">...</button>
                <script type="text/javascript">
            Calendar.setup({
              inputField    : "txt_fecha_dev",
              button        : "cal-button-1",
              align         : "Tr"
            });
              </script>
              </div></td>
              <td align="right">Hora Devolucion:</td>
              <td><input name="hora" type="text" id="hora2" value="<?php 
			  			if (empty($_POST['hora']))
							echo date ("H:i:s"); 
						else
							echo $_POST['hora'];
						?>" size="8" maxlength="8" /></td>
            </tr>
            <tr>
              <td style="font-weight:bolder">Estado equipo devuelto</td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <?php
				$valor2 = intval($valor2);
				$sqlest      = "SELECT cod_estado_equipo FROM equipo where cod_equipo= '$valor2'";
				
				$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
				$registroest = mysql_fetch_array($resest);
				$temp =  $registroest['cod_estado_equipo'];
				
				$sql2="SELECT cod_estado_equipo, est_equipo, descripcion_estado 
						FROM estado_equipo 
						where cod_estado_equipo <> 3
						order by cod_estado_equipo ASC";
				$res2=mysql_query($sql2,$link) or die(mysql_error());	
				$selected="";

				echo "<select name='estado_equipo' ><option value='XXX'>Indique estado equipo</option>\n"; 
				while($campos2=mysql_fetch_array($res2)) {	
				   if ($campos2['cod_estado_equipo']==$temp){
						$selected = 'selected="selected"';
					   }
				   else {
						$selected = "";
					   }
		    ?>
                <div align="left">
                  <?php if ($campos2['est_equipo']==0) {
					  $campos2['est_equipo'] ="NO DISPONIBLE" ;
					  }
					  else{ 
					  $campos2['est_equipo'] ="DISPONIBLE";
					  }
					?>
                  <option value="<?php echo $campos2['cod_estado_equipo'].",".$campos2['est_equipo']?>" <?php echo $selected?>> <?php echo $campos2['est_equipo']." - ".$campos2['descripcion_estado']?></option>
                  <?php
			}  
                    echo "</select>";	
					$cargo2 = explode( ',', $_POST['estado_equipo'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
                  </div>
                </div></td>
            </tr>
            <tr>
              <td><div align="left">N&deg;GD Ingreso </div></td>
              <td> :</td>
              <td colspan="3" align="left"><div align="left">
                <input type="text" name="txt_gd_ing" size="9" onkeypress="return acceptNum(event)" maxlength="9" value="<?php if (!empty($registro['num_gd_ingreso'])) 
			{echo ($registro['num_gd_ingreso']);}else{echo($_POST["txt_gd_ing"]) ;}?>" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">N&deg;GD Salida </div></td>
              <td> :</td>
               <?php 
            $sql_num_factura     = "SELECT (COALESCE(num_gd,0)) as ncorr
                  FROM gd
                     WHERE num_gd > 30850 and num_gd < 100000
                  
					 order by num_gd desc";
          
          $res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
          $registro_num_factura= mysql_fetch_array($res_num_factura);
          $num_factura_nuevo = $registro_num_factura['ncorr'];
          if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 30851;
          else $num_factura_nuevo = $registro_num_factura['ncorr']+1;
         
          if ($num_factura_nuevo=='') $num_factura_nuevo=1;

            $sql_filtro = "select * 
                    from folios_dte
                    where desde <= '".$num_factura_nuevo."' and 
                        hasta >= '".$num_factura_nuevo."' and 
                        tipo = 52";
            $res_filtro = mysql_query($sql_filtro,$link);
            if (mysql_num_rows($res_filtro)==0){
              $num_factura_nuevo = "Error.";
              }
          
            ?>
              <td colspan="2" align="left">
              	<div align="left">
                    <input type="text" name="txt_gd_sali" id="txt_gd_sali" size="10" maxlength="10" style="font-size:18px; color:red;  font-weight:bold; border:#F00 solid 2px; padding:5px" value="<?php 
                           if (($_POST['txt_gd_sali']=='')&&($registro['num_gd_salida']=='')) echo $num_factura_nuevo;
                                                                  else if (!empty($registro['num_gd_salida'])){
                                                                    echo ($registro['num_gd_salida']);}
                                                                  else{
                                                                    echo($_POST["txt_gd_sali"]) ;}
                            ?>"  onkeypress="return acceptNum(event)" class="validate[required,custom[number]]"/>
              	</div>
              </td>
              <td align="right" valign="middle">Fecha Emisión GD:
                <input name="txt_fecha_emi_gd" type="text" id="txt_fecha_emi_gd" value="<?php 
			  		if (!empty($registro['fecha_emision_gd'])) {
						$array_arr_desde = explode('-',$registro['fecha_emision_gd']);
						echo date('d-m-Y',mktime(0, 0, 0, $array_arr_desde[1], $array_arr_desde[2], $array_arr_desde[0]));
					}else{
						if (isset($_POST['txt_fecha_emi_gd'])){
							echo $_POST["txt_fecha_emi_gd"];
							}
							else{
								echo date('d-m-Y');
								}
						}?>" size="10" maxlength="10" />
                <button type="submit" id="cal-button-3">...</button>
                <script type="text/javascript">
            Calendar.setup({
              inputField    : "txt_fecha_emi_gd",
              button        : "cal-button-3",
              align         : "Tr"
            });
                </script></td>
            </tr>
            <tr>
              <td valign="top" class="Estilo20">Patente</td>
               <td valign="top" >:</td>
              
              <td><input name="patente" type="text" id="patente" value="<?php 
			  		echo ($_POST['patente']);
				?>" /></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td valign="top" class="Estilo20">Detalle Reclamo </td>
              <td valign="top" >:</td>
              <td colspan="3" class="Estilo24"><textarea name="txt_detalle" cols="50" rows="3"><?php if (!empty($registro['det_falla'])) 
			{echo ($registro['det_falla']);}else{echo($_POST["txt_detalle"]) ;}?></textarea></td>
            </tr>
            <tr>
              <td height="53" valign="top" class="Estilo20">Resolucion Reclamo</td>
              <td valign="top">:</td>
              <td colspan="2" class="Estilo24"><textarea name="txt_resolucion" cols="50" rows="3"><?php if (!empty($registro['resolucion_reclamo'])){echo ($registro['resolucion_reclamo']);}else{echo($_POST["txt_resolucion"]) ;}?></textarea></td>
              <td class="Estilo24">
              
              <input id="OK" type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir"  style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton"<?php echo $estado_objetos ;?> />
              <!--<input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png" align="left" width="35" height="35" <?php echo $estado_objetos ;?>/>-->              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<?php
			function mensaje()
				{
					echo "<script>
					alert('Ingrese Datos Reclamo');
					</script>";
				}
			function mensaje_1()
				{
					echo "<script>
					alert('Indique estado equipo devuelto');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Razon Social');
					</script>";
				 }
			function mensaje3()
				 {
					echo "<script>
					alert('N�GD Ingreso y N�GD Salida deben ser diferentes');
					</script>";
				 }
	if ($_POST['estado_equipo']=='XXX'){
		mensaje_1();
		}
	
if (($_POST['OK']=='Guardar y Seguir')&&($_POST['estado_equipo']!='XXX')) {

	$codigo_arriendo    = $registro['cod_arriendo'];                    // echo "$codigo_arriendo<br>";
	$codigo_cliente     = $registro_cli['cod_cliente'];        
	         // echo "$codigo_cliente<br>";
	$codigo_equidev     = $_POST['txt_cod_eqdev'];             // echo "$codigo_equidev<br>";
	$codigo_equientre   = $_POST['txt_cod_eqentr'];            // echo "$codigo_equientre<br>";
	$estado_equipo      = $_POST['estado_equipo'];                                   // echo "$estado_equipo<br>";

	$array_temp = explode('-',$_POST["txt_fecha_dev"]);
	$fecha_devolucion = date('Y-m-d',mktime(0, 0, 0, $array_temp[1], $array_temp[0], $array_temp[2]));
	$array_temp = explode('-',$_POST["txt_fecha_arr"]);
	$fecha_arriendo = date('Y-m-d',mktime(0, 0, 0, $array_temp[1], $array_temp[0], $array_temp[2]));
	//$array_temp = explode('-',$_POST["txt_fecha_ree"]);
	//$fecha_reemplazo = date('Y-m-d',mktime(0, 0, 0, $array_temp[1], $array_temp[0], $array_temp[2]));
	
	$hora               = $_POST['hora'];                      // echo "$hora<br>";
	$hora_arriendo      = $_POST['hora_arriendo'];             // echo "$hora_arriendo<br>";
	$num_gdingreso      = $_POST['txt_gd_ing'];                // echo "$num_gdingreso<br>";
	$num_gdsalida       = $_POST['txt_gd_sali'];               // echo "$num_gdsalida<br>";
	$det_falla          = strtoupper($_POST['txt_detalle']); 	// echo "$det_falla<br>";
	$det_falla          = trim($det_falla);
	$res_reclamo        = strtoupper($_POST['txt_resolucion']); //echo "$res_reclamo<br>";
	$res_reclamo        = trim($res_reclamo);	
	//$fecha_arriendo		= $_POST['fecha_arriendo'];
	
	/*
	echo '<h1>Codigo cliente es: '.$codigo_cliente.'</h1>';
	echo '<h1>Codigo equipo dev: '.$codigo_equidev.'</h1>';
	echo '<h1>Codigo equipo entre: '.$codigo_equientre.'</h1>';
	echo '<h1>estado equipo: '.$estado_equipo.'</h1>'; 
	echo '<h1>fecha '.$fecha.'</h1>';
	*/
	//if (empty($codigo_cliente)||empty($codigo_equidev)||empty($codigo_equientre)||empty($estado_equipo)||empty($fecha)||empty($hora)||empty($num_gdingreso)||empty($num_gdsalida)||empty($det_falla)||empty($res_reclamo)){  
	
	if (empty($codigo_cliente)||empty($codigo_equidev)||empty($codigo_equientre)||empty($estado_equipo)||empty($fecha_arriendo)||empty($hora)||empty($num_gdsalida)||empty($det_falla)||empty($res_reclamo)){  
	
		$link=mensaje();
	} else {
	  if ($num_gdingreso==$num_gdsalida){	
	 	 $link=mensaje3();
	  }else{
			
				$codigo_arriendo    = $registro['cod_arriendo'];                   //  echo "$codigo_arriendo<br>";
				$codigo_cliente     = $registro_cli['cod_cliente'];                //  echo "$codigo_cliente<br>";
				$codigo_equidev     = $_POST['txt_cod_eqdev'];            //  echo "$codigo_equidev<br>";
				$codigo_equientre   = $_POST['txt_cod_eqentr'];           //  echo "$codigo_equientre<br>";
				$estado_equipo      = $_POST['estado_equipo'];            //  echo "$estado_equipo<br>";
				$arr_estado_equipo = array();
				$arr_estado_equipo = explode(',',$estado_equipo);
				$estado_equipo = $arr_estado_equipo[0];
				
	
				$array_temp = explode('-',$_POST["txt_fecha_emi_gd"]);
				$fecha_emision_gd = date('Y-m-d',mktime(0, 0, 0, $array_temp[1], $array_temp[0], $array_temp[2]));
	
				$array_temp_1 = explode('-',$_POST["txt_fecha_arr"]);
				$fecha_arriendo = date('Y-m-d',mktime(0, 0, 0, $array_temp_1[1], $array_temp_1[0], $array_temp_1[2]));
	
				$hora               = $_POST['hora'];                     //  echo "$hora<br>";
				
				$hora_arriendo      = $_POST['hora_arriendo'];            //  echo "$hora_arriendo<br>";
				$num_gdingreso      = $_POST['txt_gd_ing'];               //  echo "$num_gdingreso<br>";
				$num_gdsalida       = $_POST['txt_gd_sali'];              //  echo "$num_gdsalida<br>";
				$patente      		= $_POST['patente'];              //  echo "$num_gdsalida<br>";
				$det_falla          = strtoupper($_POST['txt_detalle']);  //  echo "$det_falla<br>";
				$det_falla          = trim($det_falla);
				$res_reclamo        = strtoupper($_POST['txt_resolucion']); //echo "$res_reclamo<br>";
				$res_reclamo        = trim($res_reclamo);					
				$rut_cliente		= $_POST['txt_rut'];
				
				 //grabar en reclamo
				 mysql_query("insert into reclamo (cod_estado_equipo,cod_cliente,cod_equipo_dev,cod_equipo_entreg,det_falla,fecha_reclamo,hora_reclamo,num_gd_salida,num_gd_ingreso,resolucion_reclamo) values ('$estado_equipo','$codigo_cliente','$codigo_equidev','$codigo_equientre','$det_falla','$fecha_devolucion','$hora','$num_gdsalida','$num_gdingreso','$res_reclamo')",$link);
				
				 $sql="SELECT * FROM  reclamo where cod_reclamo = LAST_INSERT_ID()";
				
				 $res_reclamo  = mysql_query($sql) or die(mysql_error()); 
				 $registro_rec = mysql_fetch_array($res_reclamo);
				
				 $cod_reclamo  = $registro_rec['cod_reclamo'];
				  
				$sql="SELECT arrendado_desde 
						FROM  equipos_arriendo 
						where cod_equipo='$codigo_equidev' 
							and cod_arriendo='$codigo_arriendo'
						order by  arrendado_desde desc
						limit 0,1";
				
				 $res_reclamo  = mysql_query($sql) or die(mysql_error()); 
				 $registro_rec = mysql_fetch_array($res_reclamo);
				 
				 $arrendado_desde  = $registro_rec['arrendado_desde'];
				 
				 // cerrar arriendo equipo devuelto
				 $sql = "update equipos_arriendo 
				 			SET estado_equipo_arr='DEVUELTO-NO FACTURADO-CAMBIO', 
								cod_reclamo='$cod_reclamo', 
								arrendado_hasta='$fecha_devolucion', 
								hora_devol='$hora' 
							where cod_equipo='$codigo_equidev' 
								and cod_arriendo='$codigo_arriendo'
								and arrendado_desde = '$arrendado_desde'
								and cod_reclamo <> '$cod_reclamo'";
				 $res  = mysql_query($sql) or die(mysql_error());
				 //echo "<br/>";
				 //cambiar estado equipo devuelto
				 $sql = "update equipo SET cod_estado_equipo='$estado_equipo' where cod_equipo='$codigo_equidev'";
				 $res  = mysql_query($sql) or die(mysql_error());
						 
				 //cambiar estado equipo entregado
				 $sql = "update equipo SET cod_estado_equipo='3' where cod_equipo='$codigo_equientre'";
				 $res  = mysql_query($sql) or die(mysql_error());
				
  				 //RCB ACA
				 //asignar equipo nuevo arriendo
				 //$fecha_arriendo = $arr_desde;
				$array_temp = explode('-',$_POST["txt_fecha_arr"]);
				$fecha_arriendo = date('Y-m-d',mktime(0, 0, 0, $array_temp[1], $array_temp[0], $array_temp[2]));
				 

				$sqlf        = "SELECT * from gd WHERE num_gd ='$num_gdsalida'";
				
				$resf        = mysql_query($sqlf,$link) or die(mysql_error()); 
				$registrof   = mysql_fetch_array($resf);

				$sql = "select num_gd
						from gd 
						where id_arriendo='$codigo_arriendo'
						limit 0,1";
				$res  = mysql_query($sql) or die(mysql_error());
				$row = mysql_fetch_array($res);
				$num_gd = $row['num_gd'];

				//echo "insert into equipos_arriendo (cod_arriendo, cod_equipo, arrendado_desde, hora_arr, estado_equipo_arr, num_gd) values ('$codigo_arriendo','$codigo_equientre', '$fecha_arriendo','$hora_arriendo', 'NO DEVUELTO','$num_gd')";
				//echo "<br/>";
				
				$sql_precio = "select distinct precio 
								from equipos_arriendo
        						where cod_equipo='$codigo_equidev' 
									and cod_arriendo='$codigo_arriendo'
								limit 0,1";
				$res_precio = mysql_query($sql_precio,$link) or die();
				$row_precio = mysql_fetch_array($res_precio);
				
				$precio = $row_precio['precio'];
				
				/*echo "<script>
				alert('".$codigo_arriendo.",".$codigo_equientre.",".$fecha_arriendo.",".$hora_arriendo.",NO DEVUELTO,".$num_gd.",".$precio."');
				</script>";*/
				mysql_query("insert into equipos_arriendo (cod_arriendo, cod_equipo, arrendado_desde, hora_arr, estado_equipo_arr, num_gd,precio) values ('$codigo_arriendo','$codigo_equientre', '$fecha_arriendo','$hora_arriendo', 'NO DEVUELTO','$num_gd','$precio')",$link);  

				$sql_1 = "select num_gd 
						from gd 
						where num_gd = '$num_gdsalida' 
							and rut_cliente = '$rut_cliente'
						";
				$res_1 = mysql_query($sql_1,$link);
				if (mysql_num_rows($res_1)>0){
				
					}
				else{
					$sql_2 = "select num_gd 
							from gd 
							where num_gd = '$num_gdsalida' 
								and rut_cliente <> '$rut_cliente'
							";
					$res_2 = mysql_query($sql_2,$link);
					if (mysql_num_rows($res_2)>0){
				
						}
					else{
						$sql_3 = "select num_gd 
								from gd 
								where num_gd = '$num_gdsalida' 
								";
						$res_3 = mysql_query($sql_3,$link);
						if (mysql_num_rows($res_3)>0){
				
							}
						else{
							$tipo = "DEVOL EQUIPO";			
							$sql_04 = "insert into gd (num_gd,cod_cliente,fecha,tipo,rut_cliente,cod_obra,id_arriendo, patente) values ('$num_gdsalida','$codigo_cliente','$fecha_emision_gd','$tipo','$rut_cliente','$cod_obra','$codigo_arriendo','$patente')";
							$res_04  = mysql_query($sql_04) or die(mysql_error());
							}
						}
					}


				$sql_filas = "select num_gd 
						from det_gd 
						where num_gd = '$num_gdsalida' ";
				$res_filas = mysql_query($sql_filas,$link);
				$filas = mysql_num_rows($res_filas);
				
				$precio = 1;
				$observaciones = "CAMBIO";
				$inc_accedorio = 0;
				$fila_dev = $filas+1; 
				 
				$sql_05 = "insert into det_gd (num_gd,fila_num_gd,cod_equipo,cantidad,precio,observaciones, accesorio) values ('$num_gdsalida','$fila_dev','$codigo_equidev','1','$precio','$observaciones', '$inc_accesorio')";
				$res  = mysql_query($sql_05) or die(mysql_error());
				
				$precio = 1;
				$observaciones = "POR";
				$inc_accesorio = 0;
				$fila_reem = $filas+2; 
				
				$sql_06 = "insert into det_gd (num_gd,fila_num_gd,cod_equipo,cantidad,precio,observaciones, accesorio) values ('$num_gdsalida','$fila_reem','$codigo_equientre','1','$precio','$observaciones', '$inc_accesorio')";
				$res  = mysql_query($sql_06) or die(mysql_error());
				
				$pagina_iframe = "impgd_cambio.php?num_gd=".$num_gdsalida."&imprimir=0"; 
				?>
                
                <div class="floatRight">
                    <a href="menu.php">
                        <img width="40" height="40" border="0" src="images/volver.png" />
                    </a>
                    <a id="vista-previa-gd-cambio" href="#" download="">
                        <img width="50" height="51" border="0" class="oculto" title="Imprimir Guia Despacho" src="images/gest_fin/factura.png" />
                    </a>
                </div>
                <br class="clearFloat"/>
                <?php
				 
				 
				 mysql_close($link);	  
				 echo "<script> 
				 		alert (\"Proceso realizado con Exito.\"); 
						document.getElementById('OK').style.visibility='hidden';
						</script>";	
			}
    	} 
	}
?>

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/languages/jquery.validationEngine-es.js"></script>
<script>
	$(document).ready(function() {
		$("#frmDatos").validationEngine('attach');
		$("#txt_gd_sali").bind('blur',function() {
			var rut_cliente = $("#rut").val();
			var num_gd = $("#txt_gd_sali").val();
			$.ajax({
				url:'classes/reclamo/verificar_gd_salida.php?rut_cliente='+rut_cliente+'&num_gd='+num_gd,
			 	success:function(data){
					alert(data);
					}
				});
			 });
		 
		});
</script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
	$(document).ready(function(){
		// $("#vista-previa-gd-cambio").fancybox({
		// 	'width'    		: '100%',
		// 	'height'   		: '100%',
		// 	'autoScale'		: false,
		// 	'transitionIn'  : 'none',
		// 	'transitionOut' : 'none',
		// 	'type'    		: 'iframe'
		// 	});
		$("#txt_gd_sali").bind('blur',function() {
		      var num_gd = $("#txt_gd_sali").val();
		      $.ajax({
		        url:'classes/consulta-gd/buscar-gd.php?num_gd='+num_gd,
		        success: function(data){
		          if (data=='1'){
		            alert("Folio Existente");
		            document.getElementById('txt_gd_sali').focus();
		            } 
		          if (data=='2'){
		            alert("Folio fuera de rango");
		            document.getElementById('txt_gd_sali').focus();
		            }
		          if (data=='3'){
		            alert("Folio fuera de rango sugerido");
		            document.getElementById('txt_gd_sali').focus();
		            }
		          }
		      });
		      //location.href="gd.php?num_gd="+num_gd;
		      });
		});
	$(window).load(function() {
		var num_gd = $("#txt_gd_sali").val();
		if (num_gd){
			$("#vista-previa-gd-cambio").attr('href','classes/consulta-gd/vista-previa-gd.php?num_gd='+num_gd);
			}
		});    		
</script>

</body>

</html>

