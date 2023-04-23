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
  document.location = 'reparar_equipo.php';
}
 //-->
</script>
<script type="text/javascript">
  <!--
function Noingresado() {
  alert("Repuesto no ha sido ingresado!");
  document.location = 'reparar_equipo.php';
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
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php');
	?>
</div>
<div id="div-menu">
		<?php 
			include('classes/menu.php');
		?>
	</div>
<p>&nbsp;</p>
<table width="95%" border="0" align="center">
  <tr>
    <td width="80%" height="80" align="center" valign="top"><form action="reparar_equipo.php" method="POST" name="frmDatos" id="frmDatos">
      <table width="100%" border="0" align="center">
        <tr>
          <td width="8%" height="8">&nbsp;</td>
          <td width="44%" height="8">&nbsp;</td>
          <td height="8" colspan="4"><div align="center" class="Estilo6">
            <div align="right" class="Estilo20"><strong><font>
              <?php
  	    {
			include("classes/conex.php");
			$link=Conectarse();

	    }
	 ?>
     <?php
				//envia el nombre
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$busca_cod=trim($_POST['txt_codigo']);
					
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_repa.php?id=$busca_cod'>";
				}
				//envia el codigo
				if (($_POST['buscarnombre']=='Buscar'))
				{
					$busca_nom=$_POST['txt_nombre'];
				
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_repa.php?nombre=$busca_nom'>";
				}
			?> 
      <?php
			{
				$valor2 = $_GET["id"];
				if (!empty($valor2)){
				
					$link=Conectarse();
					$sqlrep     = "SELECT * FROM reparacion_equipos WHERE cod_reparacion ='$valor2'";
				 
					$resrep     = mysql_query($sqlrep,$link) or die(mysql_error()); 
					$registrorep= mysql_fetch_array($resrep);
					$idrep      = $registrorep['cod_equipo'];
					
					$sqleq      = "SELECT * FROM equipo WHERE cod_equipo ='$idrep'";
				
					$reseq      = mysql_query($sqleq,$link) or die(mysql_error()); 
					$registroeq = mysql_fetch_array($reseq);
					$valor1     = $registroeq['cod_equipo'];
				
					}else{
		
				}
				
				
			}
		?>
     
     
              <?php
			{
				if (empty($_GET["txt_nombre_equi"])){
				
					}else{
				$valor1 = $_GET["txt_nombre_equi"];
				}
			
				if (empty($valor1)){
				
					}
				else{
					  	$link=Conectarse();
						$sql = "SELECT * FROM equipo WHERE cod_equipo ='$valor1'";
					 //	echo "sql= $sql<br>";
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
					
					if (empty($registro['cod_equipo']) && $_POST["buscar"]=="Buscar"){
						 echo "<script> alert (\"Equipo No Encontrado\"); </script>";
					 }
				}
				
			}
		?>
              <strong><font>
              <?php
        if (($_SESSION['tipo_usuario']=="0")or($_SESSION['tipo_usuario']=="2") ){
		   	  $estado_objetos = 'enabled';
           	   
		}else{
			  $estado_objetos = 'disabled';
           	   
		};
		?>
              </font></strong>              REPARACION EQUIPO</font></strong></div>
          </div></td>
          </tr>
        <tr>
          <td colspan="6" height="8"></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#06327D"><div align="left"><span class="Estilo7">BUSCAR EQUIPO</span></div></td>
        </tr>
        <tr>
          <td class="bord_img"><div align="left"><strong>Nombre Equipo</strong></div></td>
          <td colspan="4" class="bord_img"><strong>:</strong><strong>
            <input  name="txt_nombre" type="text" value=" " size="40" maxlength="40" />
            
            
            <input type="submit" name="buscarnombre" title="Buscar Equipo por Nombre" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
            
            <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" class="searchbutton" src="images/ver.png"/>-->
            <input type="hidden" name="txt_nombre2" size="25" maxlength="25" />
            <strong><span class="Estilo20">
              <input type="hidden" name="txt_cod4" size="20" maxlength="30" value="<?php echo $registro['cod_equipo'];?>" />
              <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['cod_equipo'];?>" />
              <input type="hidden" name="txt_codrepara" size="20" maxlength="30" value="<?php echo $valor2;?>" />
            </span></strong></strong></td>
          <td width="14%">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#06327D"><div align="left"><span class="Estilo7 ">DATOS REPARACION EQUIPO</span> </div></td>
        </tr>
        <tr>
          <td><div align="left">Nombre Equipo</div></td>
          <td colspan="4">
            :
            <input name="txt_nombre_equi" type="text" value="<?php if (!empty($registro['nombre_equipo'])) 
			{echo ($registro['nombre_equipo']);}else{echo($_POST["txt_nombre_equipo"]) ;}?>" size="35" maxlength="35" disabled="disabled"/>
            </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>C&oacute;digo Arriendo</td>
          <td colspan="4">:
            <input name="txt_arriendo" type="text" value="<?php 
		  $cod_equipo=$registro['cod_equipo'];
		  $sql_arriendo = "SELECT * FROM equipos_arriendo WHERE cod_equipo ='$cod_equipo'";
				
			       $res_arriendo = mysql_query($sql_arriendo,$link) or die(mysql_error()); 
				   $registro_arr = mysql_fetch_array($res_arriendo);
				   $cod_arriendo = $registro_arr['cod_arriendo'];
		  
		 		   $cantidad = strlen($cod_arriendo); 
				   if ($cantidad==1) { echo ("00000000" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000000" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==3) { echo ("000000" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==4) { echo ("00000" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==5) { echo ("0000" .('' . $registro_arr['cod_arriendo'] . ' ') );  } 
				   if ($cantidad==6) { echo ("000" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==7) { echo ("00" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==8) { echo ("0" .('' . $registro_arr['cod_arriendo'] . ' ') );  }
				   if ($cantidad==9) { echo ('' . $registro_arr['cod_arriendo'] . '') ;}	
		  ?>" size="9" maxlength="9" disabled="disabled"/>
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Estado</div></td>
          <td colspan="4">
            :
            <?php
			$sql2="SELECT cod_estado_equipo, est_equipo, descripcion_estado FROM estado_equipo order by cod_estado_equipo ASC";
  			$res2=mysql_query($sql2,$link) or die(mysql_error());	
			
			echo "<select name=estado_equipo>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro['cod_estado_equipo']==$campos2[0]){
                    $selected2 = "SELECTED";
               }
               else {
                    $selected2 = "";
               }

		 ?>
            
              <?php if ($campos2[1]==0) {
					  $campos2[1] ="NO DISPONIBLE" ;}else{ $campos2[1] ="DISPONIBLE";}?>
              <option value="<?php echo $campos2[0].",".$campos2[1]?>" <?php echo $selected2?>>
                <?php echo $campos2[1]." - ".$campos2[2]?>
                </option>
              <?php
			}  
                    echo "</select>";	
					$cargo2 = explode( ',', $_POST['estado_equipo'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
            
         </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Fecha</div></td>
          <td colspan="4">:
            <input type="text" id="cal-field-1" name="cal-field-1" value="<?php echo $registrorep['fecha_reparacion'];?>"/>
            <button type="submit" id="cal-button-1">...</button>
            <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
              </script>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#06327D"><span class="Estilo7">DETALLE TECNICO</span></td>
        </tr>
        <tr>
          <td>Tecnico</td>
          <td colspan="2">:
            <?php $sql="SELECT cod_personal, nombres_personal, ap_patpersonal, ap_matpersonal, valor_hh FROM personal where cod_tipo_pers = 4 order by cod_personal ASC";
			  
			  ?>
            <select name="selectec" id="selectec" onchange="otrosdatos.value=this.options[this.selectedIndex].getAttribute('descripcion');catidad.value=this.options[this.selectedIndex].getAttribute('cantidad');precio.value=this.options[this.selectedIndex].getAttribute('precio');">
              <option value="" descripcion="" cantidad="" precio="">seleccionar</option>
              <?php $res5=mysql_query($sql,$link) or die(mysql_error());	
        while ($row = mysql_fetch_assoc($res5)){
?>
              <option value="<?php echo $row['cod_personal'] ?>" descripcion="<?php echo $row['nombres_personal'].' '.$row['ap_patpersonal'] ?>" cantidad="<?php echo $row['cod_personal'] ?>" precio="<?php echo $row['valor_hh'] ?>"><?php echo $row['nombres_personal'].' '.$row['ap_patpersonal']?></option>
              <?php 
}
?>
            </select>
            <input name="otrosdatos" type="hidden" id="otrosdatos" value="" size="40" maxlength="40" disabled="disabled" readonly="readonly" />
            <input name="cantidad" type="hidden" id="catidad" value="" size="10" maxlength="10" /></td>
          <td colspan="2"><strong>Total Tecnico:
            <input name="txt_cantidadhh3" type="text" value="<?php echo($registrorep['cant_hh']*$registrorep['valor_reparacion']);?>" size="10" maxlength="10" disabled="disabled"/>
          </strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Valor HH</td>
          <td colspan="2">:
            <input name="precio" type="text" id="precio" value="<?php //=$registrorep['valor_reparacion'];?>" size="10" maxlength="10" disabled="disabled" readonly="readonly" /></td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>HH</td>
          <td colspan="2">:
            <input name="txt_cantidadhh" type="text" onkeypress="return acceptNum(event)" value="<?php //=$registrorep['cant_hh'];?>" size="3" maxlength="3" /></td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Detalle reparaci&oacute;n</td>
          <td colspan="4"><textarea name="txt_det_repar" cols="60" rows="5"><?php //=$registrorep['detalle_reparacion'];?></textarea></td>
          <td align="right" valign="baseline">
          
          
          <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
          
          <!--<input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png"<?php echo $estado_objetos ;?>/>-->
          
          <a href="reparar_equipo.php" class="menulink"><input name="Limpiar" type="image" title="Limpiar"  value="Limpiar"  src="images/clean.png"/></a></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#06327D"><span class="Estilo7">DETALLE REPUESTOS</span></td>
        </tr>
        
        <tr>
          <td>Repuesto</td>
          <td colspan="4"><?php $sqlrep="SELECT cod_repuesto, nombre_repuesto, precio_sala FROM repuesto order by nombre_repuesto ASC";?>
            <select name="selecprod" id="selecprod" onchange="otrosdatos2.value=this.options[this.selectedIndex].getAttribute('nombre_repuesto');cod_repuesto.value=this.options[this.selectedIndex].getAttribute('cod_repuesto');precio_sala.value=this.options[this.selectedIndex].getAttribute('precio_sala');">
              <option value="" nombre_repuesto="" cod_repuesto="" precio_sala="">seleccionar</option>
              <?php $res6=mysql_query($sqlrep,$link) or die(mysql_error());	
        while ($row6 = mysql_fetch_assoc($res6)){
?>
              <option value="<?php echo $row6['cod_repuesto'] ?>" nombre_repuesto="<?php echo $row6['nombre_repuesto']?>" cod_repuesto="<?php echo $row6['cod_repuesto'] ?>" precio_sala="<?php echo $row6['precio_sala'] ?>"><?php echo $row6['nombre_repuesto'].'  -  '.'$'.$row6['precio_sala']?></option>
              <?php 
}
?>
            </select></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Repuesto</td>
          <td colspan="4"><input name="otrosdatos2" type="text" id="otrosdatos2" value="" size="40" maxlength="40" disabled="disabled" readonly="readonly" />
            Cod.Repuesto:
            <input name="cod_repuesto" type="text" id="cod_repuesto" value="" size="10" maxlength="10" disabled="disabled" readonly="readonly" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>P.unitario</td>
          <td colspan="4"><input name="precio_sala" type="text" id="precio_sala" value="" size="10" maxlength="10" disabled="disabled" readonly="readonly" /></td>
          <td rowspan="2">
          
          <input type="submit" name="OK2" title="Agregar Repuesto" value="Agregar" style="background-image:url(images/guardar.gif); width:46px; height:50px;" class="formato_boton" />
          <a href="#" onclick="window.print()">
          <img src="images/impresora.png" width="48" height="48" border="0" title="Imprimir"/>
          </a>
          </td>
        </tr>
        <tr>
          <td>Cantidad</td>
          <td colspan="4"><input name="txt_cantidadrep" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registrofact['cantidad'])) {echo ($registrofact['cantidad']);}else{echo($_POST["txt_cantidad"]) ;}?>" size="3" maxlength="3" />
            <input type="hidden" name="txt_cod2" size="20" maxlength="30" />
            <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></td>
        </tr>
        <tr class="sortable">
          <th bgcolor="#06327D"><div align="center" class="Estilo7">Cantidad</div></th>
          <th colspan="2" bgcolor="#06327D"><div align="center" class="Estilo7">Detalle</div></th>
          <th width="13%" bgcolor="#06327D"><div align="center" class="Estilo7">Valor Unitario</div></th>
          <th width="8%" bgcolor="#06327D"><div align="center" class="Estilo7">Total</div></th>
          <th bgcolor="#06327D"><span class="Estilo7">Quitar
            <?php
		    if (empty($_GET["id"])) $_GET["id"]=0;
			$sqldet="SELECT * FROM  det_reparacion where cod_reparacion = ".$_GET["id"]." order by cod_repuesto ASC";
		 
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
          </span></th>
          </tr>
        <tr bordercolor="#FFFFFF" class="sortable">
          <td align="center" valign="middle"><?php echo($registrodet['cantidad']); ?></td>
          <td colspan="2" align="center" valign="middle"><?php 
				  if (!empty($valor1))
					  {
						  $sqlnomrep="SELECT nombre_repuesto FROM repuesto where cod_repuesto =".$registrodet['cod_repuesto'];
						 
						  $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
						  $registronrep = mysql_fetch_array($resnomrep);
						  echo($registronrep['nombre_repuesto']);
					  }else{
						  echo(" ");
					  }
			 ?></td>
          <td align="center" valign="middle"><?php echo("$".number_format($registrodet['valor_unitario'], 0, ",", "."));?></td>
          <td align="center" valign="middle"><?php echo("$".number_format($registrodet['tot_rep'], 0, ",", "."));  $costo_tot = $costo_tot + ($registrodet['tot_rep']);  ?></td>
          <td align="center" valign="middle"><input type="hidden" name="txt_codrepuesto"  value="<?php echo $registrodet['cod_repuesto']?>" size="20" maxlength="30" />
            <input type="submit" name="borrar" title="Eliminar repuesto" value="Borrar" onclick="elimina=confirm('¿Esta seguro de que quiere eliminar?');return elimina;" style="background-image:url(images/error.png); width:16px; height:16px;" class="formato_boton" />
            <!--<input type="image" name="borrar" value="Borrar" title="Eliminar repuesto" src="images/error.png" onclick="elimina=confirm('&iquest;Esta seguro de que quiere eliminar?');return elimina;" />--></td>
          </tr>
        <tr class="sortable">              <?php
				}
				mysql_free_result($resdet);
				mysql_close($link); 
		 ?>
          <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
          <td height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
          <td width="13%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
          <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
          <td align="right" bgcolor="#FFFFFF"><strong><span class="CONT"><?php echo ("TOTAL: $".number_format($costo_tot, 0, ",", "."));?>
            <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
          </span></strong></td>
          <td class="CONT">&nbsp;</td>
        </tr>
        </table>
    </form></td>
  </tr>
</table>
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
					alert('Ingrese Datos Equipo');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Nombre Equipo');
					</script>";
				 }
			function mensaje3()
				 {
					echo "<script>
					alert('Seleccione Repuesto e Ingrese Cantidad');
					</script>";
				 }
		  ?>
		 <?php   
			if ($_POST['buscar']=='Buscar') 
			{   
				if (empty($_POST['txt_nombre_equi']))
				{  
					$link=mensaje2();
				} else {
					
				};
			}
	  ?>      
      <?php   
	$valor2 = $_POST["OK"];
	 
if ($_POST['OK']=='Guardar y Seguir') {
 	$codigo_equi        = $_POST['txt_cod'];                      //   echo "$codigo_equi<br>";
	$cod_estado_equipo  = $cargo_id2;                                      //   echo "$cod_estado_equipo<br>";
	$fecha_reparacion   = $_POST['cal-field-1']; 	               //   echo "$fecha_reparacion<br>";	
 	$det_reparac        = strtoupper($_POST['txt_det_repar']); 	//  echo "$det_reparac<br>";
	$det_reparac        = trim($det_reparac);
	$hh                 = $_POST['txt_cantidadhh'];               //   echo "$hh<br>";	
	//datos tecnico
	$cod_personal       = $_POST['selectec'];                   //   echo "$cod_personal<br>"; 
	$link          = Conectarse();
	$sqlval="SELECT valor_hh FROM personal where cod_personal ='$cod_personal'";
 
	$resval = mysql_query($sqlval,$link) or die(mysql_error()); 
	$registroval = mysql_fetch_array($resval);
	$valorhora =$registroval['valor_hh'];
   	  
	if (empty($codigo_equi)||empty($fecha_reparacion)||empty($det_reparac)){  
		$link=mensaje();
				echo "<script language=Javascript> location.href=\"reparar_equipo.php?id=".$_POST['txt_codrepara']."\"; </script>";
	} else {
	 
		$codigo_equi        = $_POST['txt_cod'];                        //echo "$codigo_equi<br>";
		$cod_estado_equipo  = $cargo_id2;                                        //echo "$cod_estado_equipo<br>";
		$fecha_reparacion   = $_POST['cal-field-1']; 	                 //echo "$fecha_reparacion<br>";	
		$valor_reparacion   = $_POST['txt_valor'];                      //echo "$valor_reparacion<br>";	
		$det_reparac        = strtoupper($_POST['txt_det_repar']); 	 //echo "$det_reparac<br>";
		$det_reparac        = trim($det_reparac);
		$codigo             = $_POST['txt_cod'];
		$nombre             = $_POST['txt_nombre_equi'];
		if (!empty($codigo)){
	 
			 mysql_query("insert into reparacion_equipos (cod_arriendo,cod_equipo,cod_estado_equipo,detalle_reparacion,valor_reparacion,fecha_reparacion,cod_personal,cant_hh) values ('$cod_arriendo','$codigo_equi','$cod_estado_equipo','$det_reparac','$valorhora','$fecha_reparacion','$cod_personal','$hh')",$link);
			 
			 $sql="SELECT * FROM  reparacion_equipos where cod_reparacion = LAST_INSERT_ID()";
		     
			 $resid = mysql_query($sql) or die(mysql_error()); 
			 $registroid = mysql_fetch_array($resid);
			 
			 $codrep=$registroid['cod_reparacion'];
			 echo "<script> alert (\"Proceso realizado con Exito. Ahora puede Ingresar Repuestos\"); </script>";
			 echo "<script language=Javascript> location.href=\"reparar_equipo.php?id=".$codrep."\"; </script>";

			 mysql_close($link);
		 }  
	}
 } 
?>
 <?php	
	  $valor2 = $_POST["id"];
	  $link  = Conectarse();
	  if ($_POST['OK2']=='Agregar'){
		 
			$cod_reparacion     = $_POST['txt_codrepara'];          //     echo "$cod_reparacion<br>";  
			$cod_repuesto       = $_POST['selecprod'];              //     echo "$cod_repuesto<br>";           
			$cantidad           = $_POST['txt_cantidadrep'];         //    echo "$cantidad<br>";	
			
			
			if (empty($cod_reparacion)||empty($cod_repuesto)||empty($cantidad)){  
		       $link=mensaje3();
			   echo "<script language=Javascript> location.href=\"reparar_equipo.php?id=".$cod_reparacion."\"; </script>"; 
	        } else {
				$sqlprecio          = "SELECT precio_sala FROM repuesto where cod_repuesto = '$cod_repuesto'";
				 
				$resprecio          = mysql_query($sqlprecio,$link) or die(mysql_error()); 
				$registroprecio     = mysql_fetch_array($resprecio);
				$precio_sala        = $registroprecio['precio_sala'];             //  echo "$precio_sala<br>";
				$total_repuesto     = ($registroprecio['precio_sala'] * $_POST['txt_cantidadrep']);  // echo "$total_repuesto<br>";
	
				mysql_query("insert into det_reparacion (cod_reparacion,cod_repuesto,valor_unitario,cantidad,tot_rep) values ('$cod_reparacion','$cod_repuesto','$precio_sala','$cantidad','$total_repuesto')",$link);	
				mysql_close($link);	
				echo "<script language=Javascript> location.href=\"reparar_equipo.php?id=".$cod_reparacion."\"; </script>"; 
			}
	}
 
	?><?php
		if ($_POST['borrar']=='Borrar')
		 { 
			 
			 $link         = Conectarse();;
			 $cod_reparacion  = $_POST['txt_codrepara']; 
			 $codigo_det   = trim($_POST['txt_codrepuesto']);
			 $sqlelim      = "DELETE FROM det_reparacion WHERE cod_repuesto = '$codigo_det' and cod_reparacion = '$cod_reparacion'";
		  
			 $res     = mysql_query($sqlelim) or die(mysql_error()); 
			 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			 echo "<script language=Javascript> location.href=\"reparar_equipo.php?id=".$cod_reparacion."\"; </script>";
		 }   
	  ?>