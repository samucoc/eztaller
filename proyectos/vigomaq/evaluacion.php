<?php ob_start(); 
session_start(); 

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
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo23 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.Estilo25 {
	color: #666666;
	font-style: italic;
	font-weight: bold;
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); .Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
}
    </style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <br />
     <span class="Estilo25">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><table width="95%" border="0" align="center">
  <tr>
    <td>  <table width="100%" border="0" align="center">
        <tr>
          <td><div align="center" class="Estilo6">
            <div align="right" class="Estilo20"><strong><font>
              <?php
  	    {
			include("classes/conex.php");
			$link=Conectarse();

	    }
	 ?>
              <?php
			{
				$valor1 = $_GET["id"];
				if (!empty($valor1)){
				
					$link=Conectarse();
					$sqleval   = "SELECT * FROM eval_tecnica WHERE cod_eval_tecnica ='$valor1'";
				 
					$reseval   = mysql_query($sqleval,$link) or die(mysql_error()); 
					$registro1 = mysql_fetch_array($reseval);
					$id        = $registro1['cod_equipo'];
					
					$sqleq     = "SELECT cod_equipo, nombre_equipo, cod_estado_equipo FROM equipo WHERE cod_equipo ='$id'";
				
					$reseq     = mysql_query($sqleq,$link) or die(mysql_error()); 
					$registro  = mysql_fetch_array($reseq);
					}else{
		
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
              </font></strong> EVALUACION TECNICA </font></strong></div>
          </div></td>
        </tr>
        <tr>
          <td valign="top"><form method="post" name="frmDatos" id="frmDatos">
            <table width="100%" border="0" align="center">
              <tr>
                <td colspan="4" height="8"></td>
              </tr>
              <tr>
                <td colspan="4" bgcolor="#06327D"><span class="Estilo23">DATOS EVALUACION TECNICA </span></td>
              </tr>
              <tr>
                <td colspan="4"></td>
              </tr>
              <tr>
                <td><div align="left"><strong>C&oacute;d. Eval.T&eacute;cnica </strong></div></td>
                <td><strong>: </strong></td>
                <td><strong>
                  <input name="txt_numeval" type="hidden" value="<?php //echo($valor1); ?>" size="6" maxlength="6" disabled="disabled" />
                  <input type="text" name="txt_codevaltec" size="6" maxlength="6" value="<?php echo($valor1); ?>" disabled="disabled"/>
                </strong></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" bgcolor="#06327D"><strong><span class="Estilo23">BUSCAR EQUIPO</span></strong></td>
              </tr>
              <tr>
                <td height="24"><div align="left">C&oacute;digo </div></td>
                <td>:</td>
                <td><input  name="txt_codigo" type="text" size="8" maxlength="8" value=" "/>
                  <input type="submit" name="buscarcodigo" value="Buscar" title="Buscar Equipo por C&oacute;digo" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
                  
                  <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Equipo por C&oacute;digo" class="searchbutton" src="images/ver.png"/>-->
                  <input type="hidden" name="txt_cod" size="20" maxlength="30" /></td>
                <td align="left"><?php
				//envia el nombre
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$busca_cod=trim($_POST['txt_codigo']);
					
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eval.php?id=$busca_cod'>";
				}
				//envia el codigo
				if (($_POST['buscarnombre']=='Buscar'))
				{
					$busca_nom=$_POST['txt_nombre'];
				
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=busca_eval.php?nombre=$busca_nom'>";
				}
			?>
                  &nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Nombre</div></td>
                <td>:</td>
                <td><input  name="txt_nombre" type="text" value="" size="40" maxlength="40" />
                 
                  <input type="submit" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" style="background-image:url(images/ver.png); height:16px; width:16px;" class="formato_boton"/>
                  
                  <!--<input type="image" name="buscarnombre" value="Buscar" title="Buscar Equipo por Nombre" class="searchbutton" src="images/ver.png"/>-->
                  <input type="hidden" name="txt_nombre2" size="25" maxlength="25" /></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" bgcolor="#06327D"><span class="Estilo23">EQUIPO</span></td>
              </tr>
              <tr>
                <td>Equipo a Evaluar</td>
                <td>:</td>
                <td><input name="txt_nomequipo" type="text" value="<?php if (!empty($registro['nombre_equipo'])) {echo ($registro['nombre_equipo']);}else{echo($_GET['nomequipo']);}?><?php // =$_GET['nomequipo'];?>" size="40" maxlength="40" disabled="disabled" />
                  Cod.Equipo:
                  <input name="txt_codequipo" type="text" value="<?php if (!empty($registro1['cod_equipo'])) {echo ($registro1['cod_equipo']);}else{echo($_GET['codequipo']);}?><?php //=$_GET['codequipo'];?>" size="8" maxlength="8" disabled="disabled" /></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Estado Equipo </div></td>
                <td>:</td>
                <td><div align="left">
                  <?php
				if (!empty($_GET['codequipo']))
				{ 
					$estado = $_GET['codequipo'];
					$sqlest      = "SELECT cod_estado_equipo FROM equipo where cod_equipo = '$estado'";
					//echo($sqlest);
					$resest      = mysql_query($sqlest,$link) or die(mysql_error()); 
					$registroest = mysql_fetch_array($resest);
					$estado      = $registroest['cod_estado_equipo'];
				}else{ 
					$estado      = $registro['cod_estado_equipo'];
				}
				
				
				$sqlest="SELECT cod_estado_equipo, est_equipo, descripcion_estado FROM estado_equipo order by cod_estado_equipo ASC";
				$resest=mysql_query($sqlest,$link) or die(mysql_error());	
				
				echo "<select name=estado_equipo>\n"; 
	
				while($campos=mysql_fetch_row($resest))
				{	
				   if ($estado==$campos[0]){
						$selected = "SELECTED";
				   }
				   else {
						$selected = "";
				   }
		    ?>
                <div align="left">
                  <?php if ($campos[1]==0) {
					  $campos[1] ="NO DISPONIBLE" ;}else{ $campos[1] ="DISPONIBLE";}?>
                  <option value="<?php echo $campos[0].",".$campos[1]?>" <?php echo $selected?>>
                    <?php echo $campos[1]." - ".$campos[2]?>
                    </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo = explode( ',', $_POST['estado_equipo'] );
					$cargo_id = $cargo[0];
					$cargo_contenido = $cargo[1];  
					echo $campos; 
		 ?>
                  </div>
              </div></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td>Tipo Evaluaci&oacute;n </td>
                <td>:</td>
                <td><div align="left">
                  <?php
			$sql="SELECT cod_tipoeval, tipo_evaluar FROM tipo_evaluacion order by tipo_evaluar ASC";
  			$res2=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=tipo_evaluacion>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro1['cod_tipoeval']==$campos2[0]){
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
					$cargo2 = explode( ',', $_POST['tipo_evaluacion'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
                  </div>
                </div></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Forma Evaluaci&oacute;n </div></td>
                <td>:</td>
                <td><div align="left">
                  <?php
			$sql3="SELECT cod_formaeval, forma_evaluar FROM forma_evaluacion order by forma_evaluar ASC";
  			$res3=mysql_query($sql3,$link) or die(mysql_error());	
			
			echo "<select name=forma_evaluar>\n"; 

			while($campos3=mysql_fetch_row($res3))
			{	
               if ($registro1['cod_formaeval']==$campos3[0]){
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
					$cargo3 = explode( ',', $_POST['forma_evaluar'] );
					$cargo_id3 = $cargo3[0];
					$cargo_contenido3 = $cargo3[1];  
					echo $campos3; 
		 ?>
                  </div>
                </div></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Fecha </div></td>
                <td>:</td>
                <td><input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registro1['fecha_evaluacion'])) {echo ($registro1['fecha_evaluacion']);}else{echo($_POST["cal-field-1"]) ;}?>" size="10" maxlength="10"/>
                  <button type="submit" id="cal-button-1">...</button>
                  <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
                </script></td>
                <td><input  name="txt_costo1" type="hidden" onkeypress="return acceptNum(event)" value="<?php echo ($registro1['costo_evaluacion']); ?>" size="10" maxlength="10" /></td>
              </tr>
              <tr>
                <td><div align="left">Tiempo Estimado Disponible </div></td>
                <td> :</td>
                <td><input name="txt_tiempo" type="hid" value="<?php if (!empty($registro1['tiempo_est_repar'])) 
			{echo ($registro1['tiempo_est_repar']);}else{echo($_POST["txt_tiempo"]) ;}?>" size="35" maxlength="35" /></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="left">Detalle Evaluacion</div></td>
                <td>:</td>
                <td><textarea name="txt_det_falla" cols="50" rows="2"><?php if (!empty($registro1['det_falla'])){echo ($registro1['det_falla']);}else{echo($_POST["txt_det_falla"]) ;}?></textarea></td>
                <td height="10">
                <input type="submit" name="OK" value="Guardar" title="Guardar Datos Evaluacion" <?php echo $estado_objetos ;?> style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" />
                
                <!--<input name="OK" type="image" class="boton" title="Guardar Datos Evaluacion" value="Guardar"  src="images/guardar.png"<?php echo $estado_objetos ;?>/>-->
                
                <a href="evaluacion.php" class="menulink">
                <input type="submit" name="Limpiar" value="Limpiar" title="Limpiar" style="background-image:url(images/clean.png); width:64px; height:64px;" class="formato_boton" />
                
                <!--<input name="Limpiar" type="image" title="Limpiar"  width="30" height="30" value="Limpiar"  src="images/clean.png"/>-->
                
                </a></td>
              </tr>
              <tr>
                <td colspan="4" bgcolor="#06327D" class="Estilo23">Detalle Evaluaci&oacute;n</td>
              </tr>
              <tr>
                <td>Tecnico</td>
                <td>:</td>
                <td><?php $sql="SELECT cod_personal, nombres_personal, ap_patpersonal, ap_matpersonal, valor_hh FROM personal where cod_tipo_pers = 4 order by cod_personal ASC";
			  
			  ?>
                  <select name="selecprod" id="selecprod" onchange="otrosdatos.value=this.options[this.selectedIndex].getAttribute('descripcion');catidad.value=this.options[this.selectedIndex].getAttribute('cantidad');precio.value=this.options[this.selectedIndex].getAttribute('precio');">
                    <option value="" selected="selected" descripcion="" cantidad="" precio="">Seleccionar</option>
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
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Valor HH</td>
                <td>:</td>
                <td><input name="precio" type="text" id="precio" value="" size="10" maxlength="10" disabled="disabled" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="24">HH</td>
                <td>:</td>
                <td><input name="txt_cantidadhh" type="text" onkeypress="return acceptNum(event)" value="<?php echo $registro['cantidad_hh'];?>" size="3" maxlength="3" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Concepto</td>
                <td>:</td>
                <td align="right"><textarea name="txt_concepto" cols="75" rows="2"><?php echo $registro['concepto'];?></textarea></td>
                <td align="left" valign="bottom">
                <input type="submit" name="OK2" value="Guardar y Seguir" title="Agregar Detalle Evaluacion" <?php if(empty($valor1)) echo("disabled"); ?> <?php echo $estado_objetos ;?> style="background-image:url(images/guardar.gif); width:46px; height:50px;" class="formato_boton"/>
                <input type="button" name="IMPRIMIR" value="Imprimir" title="Imprimir"  style="background-image:url(images/impresora.gif); width:46px; height:50px;" class="formato_boton" onclick="window.print()"/></td>
              </tr>
              <tr>
                <td height="20" colspan="4"><table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                  <tr bordercolor="#FFFFFF">
                    <td align="left"><table class="sortable" id="unique_id2" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                      <tr>
                        <th width="12%"></th>
                        <th width="19%"><input type="hidden" name="txt_cod2" size="20" maxlength="30" />                          <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
                        <th width="11%"></th>
                        <th width="35%"></th>
                        <th width="13%"></th>
                        <th width="10%" align="right"></th>
                      </tr>
                      <tr>
                        <th bgcolor="#06327D"><div align="center" class="Estilo17">Cod.Tecnico</div></th>
                        <th bgcolor="#06327D"><div align="center" class="Estilo17">Tecnico</div></th>
                        <th bgcolor="#06327D"><div align="center" class="Estilo17">HH</div></th>
                        <th bgcolor="#06327D"><div align="center" class="Estilo17">Concepto</div></th>
                        <th bgcolor="#06327D"><div align="center" class="Estilo17">Monto</div></th>
                        <th bgcolor="#06327D"> <span class="Estilo17 Estilo13 Estilo15">Quitar</span></th>
                      </tr><?php
		    if (empty($_GET["id"])) $_GET["id"]=0;
			$sql="SELECT * FROM  det_eval where cod_eval_tecnica = ".$_GET["id"]." order by concepto ASC";
		
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		?>
                         
                      <tr bordercolor="#FFFFFF">
                        <td align="left"><?php echo($registro['cod_personal']); ?></td>
                        <td align="left"><?php 
				  if (!empty($valor1))
					  {
						  $sql3="SELECT nombres_personal,ap_patpersonal,valor_hh FROM personal where cod_personal =".$registro['cod_personal'];
						 
						  $res3 = mysql_query($sql3,$link) or die(mysql_error()); 
						  $registro3 = mysql_fetch_array($res3);
						  echo($registro3['nombres_personal']);
						
					  }else{
						  echo(" ");
					  }
			 ?></td>
                        <td align="left"><?php echo($registro['hh']); ?></td>
                        <td align="left"><?php echo($registro['concepto']);?></td>
                        <td align="left"><?php echo($registro['hh']*$registro3['valor_hh']);  $costo_tot = $costo_tot + ($registro['hh']*$registro3['valor_hh']) ?></td>
                        <td align="center" bgcolor="#FFFFFF"><input type="hidden" name="txt_coddeteval"  value="<?php echo $registro['cod_det_eval']?>" size="20" maxlength="30" />
                          <input type="submit" name="borrar" value="Borrar" title="Eliminar Detalle" src="images/error.png" onclick="elimina=confirm('�Esta seguro de que quiere eliminar?');return elimina;"<?php echo $estado_objetos ;?> style="background-image:url(images/error.png); width:16px; height:16px;"  class="formato_boton"/>
                          <!--<input type="image" name="borrar" value="Borrar" title="Eliminar Detalle" src="images/error.png" onclick="elimina=confirm('�Esta seguro de que quiere eliminar?');return elimina;"<?php echo $estado_objetos ;?>/>--></td>
                      </tr>
                      <tr>
                        <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                        <?php
				}
				mysql_free_result($res);
				mysql_close($link); 
		 ?>
                        <td class="CONT">&nbsp;</td>
                        <td class="CONT">&nbsp;</td>
                        <td class="CONT">&nbsp;</td>
                        <td class="CONT"><?php
				
				echo ("Costo: ".$costo_tot);
		 ?>
                          <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
                        <td class="CONT">&nbsp;</td>
                      </tr>
                      <?php
			function mensaje()
				{
					echo "<script>
					alert('Seleccione Tecnico e Ingrese Concepto y HH');
					</script>";
				}
		  ?>
                      <?php
		if ($_POST['borrar']=='Borrar')
		 { 
			 echo("borrar");
			 $link          = Conectarse();
			
			 $codigo_det     = trim($_POST['txt_coddeteval']);
			 $sql  = "DELETE FROM det_eval WHERE cod_det_eval = '$codigo_det'";
		 	
			 $res     = mysql_query($sql) or die(mysql_error()); 
			 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			 echo "<script language=Javascript> location.href=\"evaluacion.php?id=".$valor1."\"; </script>";
		 }   
	  ?>
                      <?php	
	  $valor2 = $_POST["OK"];
	  if ($_POST['OK']=='Guardar'){
			$codigo_equipo      = $_GET['codequipo'];                            
			if (empty($codigo_equipo)) $codigo_equipo=$registro1['cod_equipo'];  //echo "$codigo_equipo<br>";
			$cod_tipoeval       = $cargo_id2;                     	             //echo "$cod_tipoeval<br>";	
			$cod_formaeval      = $cargo_id3;  	                                 //echo "$cod_formaeval<br>";
			$cod_estado_equipo  = $cargo_id;                                     //echo "$cod_estado_equipo<br>";
			$fecha_evaluacion   = $_POST['cal-field-1'];	             //echo "$fecha_evaluacion<br>";
			$tiempo_est_repar   = strtoupper($_POST['txt_tiempo']);     //echo "$tiempo_est_repar<br>"; 
			$det_falla          = strtoupper($_POST['txt_det_falla']);  //echo "$det_falla<br>"; 		
			
			if (empty($codigo_equipo)||empty($cod_tipoeval)||empty($cod_formaeval)||empty($cod_estado_equipo)||empty($fecha_evaluacion)||empty($tiempo_est_repar)||empty($det_falla)){  
				$link=mensaje();
			} else {
				
				$codigo_equipo      = $_GET['codequipo'];                            
			if (empty($codigo_equipo)) $codigo_equipo=$registro1['cod_equipo']; //echo "$codigo_equipo<br>";
				$cod_tipoeval       = $cargo_id2;                     	             //echo "$cod_tipoeval<br>";	
				$cod_formaeval      = $cargo_id3;  	                                 //echo "$cod_formaeval<br>";
				$cod_estado_equipo  = $cargo_id;                                     //echo "$cod_estado_equipo<br>";
				$fecha_evaluacion   = $_POST['cal-field-1'];	             //echo "$fecha_evaluacion<br>";
				$tiempo_est_repar   = strtoupper($_POST['txt_tiempo']);     //echo "$tiempo_est_repar<br>"; 
				$det_falla          = strtoupper($_POST['txt_det_falla']);  //echo "$det_falla<br>"; 		
				$det_falla          = trim($det_falla);
				
				if (empty($valor1)){
				 $link   = Conectarse();
				mysql_query("insert into eval_tecnica (cod_equipo,cod_tipoeval,cod_formaeval,cod_estado_equipo,fecha_evaluacion,costo_evaluacion,tiempo_est_repar,det_falla) values ('$codigo_equipo','$cod_tipoeval','$cod_formaeval','$cod_estado_equipo','$fecha_evaluacion','$costo_tot','$tiempo_est_repar','$det_falla')",$link);
				
				$sql="SELECT * FROM  eval_tecnica where cod_eval_tecnica = LAST_INSERT_ID()";
		     	
			    $resid = mysql_query($sql) or die(mysql_error()); 
				$registroid = mysql_fetch_array($resid);
				
				$codevaltec=$registroid['cod_eval_tecnica'];
				echo "<script> alert (\"Proceso realizado con Exito. Ahora debe Ingresar Detalle Evaluacion\"); </script>";
				echo "<script language=Javascript> location.href=\"evaluacion.php?id=".$codevaltec."\"; </script>";
				
				mysql_close($link);
			
				 } else {
		 
		         $link   = Conectarse();
				 $sql = "UPDATE eval_tecnica SET cod_equipo='$codigo_equipo', cod_tipoeval='$cod_tipoeval', cod_formaeval='$cod_formaeval', cod_estado_equipo='$cod_estado_equipo', fecha_evaluacion='$fecha_evaluacion',  costo_evaluacion='$costo_tot',tiempo_est_repar='$tiempo_est_repar', det_falla='$det_falla' where cod_eval_tecnica='$valor1'";
				
				 $res  = mysql_query($sql) or die(mysql_error());
				 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
				echo "<script language=Javascript> location.href=\"evaluacion.php?id=".$valor1."\"; </script>";
			    }	  
			}
		 } 
		 
	?>
                      <?php	
	  $valor2 = $_POST["OK2"];
	  $link  = Conectarse();
	  if ($_POST['OK2']=='Guardar y Seguir')
	    {
			$cod_eval_tecnica   = $valor1;                                       //echo "$cod_eval_tecnica<br>";  
			$cod_personal       = $_POST['selecprod'];                  //echo "$cod_personal<br>";           
			$hh                 = $_POST['txt_cantidadhh'];             // echo "$hh<br>";	
			$concepto           = strtoupper($_POST['txt_concepto']);  
 		    $concepto           = trim($concepto);                               //echo "$concepto<br>"; 
			
			if (empty($cod_eval_tecnica)||empty($cod_personal)||empty($hh)||empty($concepto)){  
				$link=mensaje();
			} else {
				
				
				$cod_eval_tecnica   = $valor1;                                     //   echo "$cod_eval_tecnica<br>";  
				$cod_personal       = $_POST['selecprod'];               //     echo "$cod_personal<br>";           
				
			    $sqlval="SELECT valor_hh FROM personal where cod_personal ='$cod_personal'";
				
				$resval = mysql_query($sqlval,$link) or die(mysql_error()); 
				$registroval = mysql_fetch_array($resval);
				$valorhora =$registroval['valor_hh'];
						
						  
				$hh                 = $_POST['txt_cantidadhh'];           //   echo "$hh<br>";
				$concepto           = strtoupper($_POST['txt_concepto']);  
				$concepto           = trim($concepto);                           //    echo "$concepto<br>"; 

				mysql_query("insert into det_eval (cod_eval_tecnica,cod_personal,hh,valorhora,concepto) values ('$cod_eval_tecnica','$cod_personal','$hh','$valorhora','$concepto')",$link);	
				 mysql_close($link);	

			    $_POST['selecprod']       =" ";                          
				$_POST['txt_cantidadhh']  =" ";
				$_POST['txt_concepto']    =" "; 
			    echo "<script language=Javascript> location.href=\"evaluacion.php?id=".$valor1."\"; </script>";  
				
			}
		 } 
		 
	?>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table>
          </form></td>
        </tr>
        <tr>
          <td valign="top"></td>
        </tr>
        <tr>
          <td valign="top" align="right"></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>