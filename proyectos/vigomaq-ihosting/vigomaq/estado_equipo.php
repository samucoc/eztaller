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
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
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
</style> <script type="text/javascript">
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con Exito!");
  document.location = 'estado_equipo.php';
}
 //-->
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
  niv = celda.getElementsByTagName('td')[2].innerHTML;
  act = celda.getElementsByTagName('td')[3].innerHTML;
  des = celda.getElementsByTagName('td')[4].innerHTML;
	if (com=='DISPONIBLE'){
		com = 0; 
	 }
	else{
		com = 1;
		}
	if (act=='ACTIVO'){
		act = 1; 
	 }
	else{
		act = 0;
		}
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['cb_estado'].selectedIndex = com;
  document.forms[0]['activado'].selectedIndex = act;
  document.forms[0]['txt_descripcion'].value = des;
  document.forms[0]['nivel'].value = niv;
  return com;
}
</script>
<script language="text/javascript">
function confirmReemp()
{
	var agree=confirm("¿Realmente desea actualizar? ");
	if (agree) return true ;
	else return false ;
	
}
</script>
<script type="text/javascript">
	function eliminar(celda)
	{
		var statusConfirm = confirm("¿Realmente desea eliminar?");
		if (statusConfirm == true)
		{
		   alert ("Eliminas");
     	   document.forms.estado_equipo.php.value=celda;
           document.forms.submit();
		}
		else
		{
			alert("Haces otra cosa");
		}
	}
</script> 
<script type="text/javascript">
function eliminar(obj) {
  if (!confirm('�Seguro?')) return false
  fila = obj.parentNode.parentNode;
  fila.parentNode.removeChild(fila);
}
</script>
<script language="javascript">
{
function Eliminar_onClick() {      
         document.nuevo.action="borra_estado.php?Accion=eliminando"
         document.nuevo.submit()	           
        }                        
}
</script>
<script src="sorttable.js"></script>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
  <tr>
    <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
    <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
            <br />
            <br />
            <span class="Estilo23 Estilo21">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
  </tr>
</table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><table width="95%" height="223" border="0" align="center">
    <tr>
      <td><?php
			{
			include("classes/conex.php");
			$link=Conectarse();
			}
		?>
        <?php
			{
				$valor1 = $_GET["id"];
				$valor1=1;
				
			}
		?>
        <?php
        if ($_SESSION['tipo_usuario']=="0") { 
		   	  $estado_objetos = 'enabled';
           	 
		}else{
			  $estado_objetos = 'disabled';
           	  
		};
		?></td>
    </tr>
    <tr>
      <td width="800" height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">ESTADO EQUIPO </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS ESTADO EQUIPO </span></div></td>
    </tr>
    <tr>
      <td width="664" height="16"></td>
    </tr>
    <tr>
      <td height="124"><form action="estado_equipo.php" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" height="30">
            <tr>
              <td class='mini_titulo'><div align="left"><font><strong>Estado:</strong></font></div></td>
              <td  class='mini_titulo'>
                <input type="hidden" name="txt_cod" size="20" maxlength="30" />
                <select name="cb_estado" class="menuhover" >
                  <option value="1">DISPONIBLE</option>
                  <option value="0">NO DISPONIBLE</option>
                  <?php echo ($txt_cod2); echo($_GET["com"]);?>
                </select></td>
              <td valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td><font><strong>Activado</strong></font></td>
              <td>
              <select name="activado" id="activado" >
              	<option value="0">NO ACTIVADO</option>
              	<option value="1">ACTIVADO</option>
              </select>
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><font><strong>Nivel Pantalla Menú:</strong></font></td>
              <td><input type="text" name="nivel" id="nivel" value="<?php echo $_POST['nivel_hidden']?>" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class='mini_titulo'><div align="left"><font><strong>Descripci&oacute;n:</strong></font></div></td>
              <td  class='mini_titulo'><font>
                <textarea name="txt_descripcion" cols="50" rows="2"></textarea>
              </font> </td>
              <td width="112" valign="bottom"><div align="right">
                <input type="submit" name="OK" id="button" value="Guardar y Seguir" title="Guardar y continuar" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?>/>
              </div></td>
            </tr>
          			 <?php
			function mensaje()
				{
					echo "<script>
					alert('Debe Ingresar Estado de Equipo');
					</script>";
				}
		   ?></table>
        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th align="center" bgcolor="#06327D"><span class="Estilo17">C&oacute;digo Estado </span></th>
              <th align="center" bgcolor="#06327D"><span class="Estilo17">Estado</span></th>
              <th align="center" valign="middle" bgcolor="#06327D"><span class="Estilo17">Nivel</span></th>
              <th align="center" bgcolor="#06327D"><span class="Estilo17">Activo</span></th>
              <th align="center" bgcolor="#06327D" class="CONT"><span class="Estilo17">Descripci&oacute;n</span></th>
              <th bgcolor="#06327D" class="CONT"><?php
			$sql="SELECT * FROM estado_equipo order by cod_estado_equipo";
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?></th>
          </tr>
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
               <?php
			  	$temp ="";
                       $cantidad = strlen($registro['cod_estado_equipo']); 
                       if ($cantidad==1) { $temp = "00000" .('' . $registro['cod_estado_equipo']) ;  }
                       if ($cantidad==2) { $temp = "0000" .('' . $registro['cod_estado_equipo']) ;  }
                       if ($cantidad==3) { $temp = "000" .('' . $registro['cod_estado_equipo']) ;  }
                       if ($cantidad==4) { $temp = "00" .('' . $registro['cod_estado_equipo']) ;  }
                       if ($cantidad==5) { $temp = "0" .('' . $registro['cod_estado_equipo']) ;  }
                       if ($cantidad==6) { $temp = $registro['cod_estado_equipo'];  }		   
                 ?>		
              <td width="25%" align="center" bordercolor="#FFFFFF"><?php echo $temp?></td>
              <?php 
			  	$temp ="";
                  if ($registro['est_equipo']==0){ 
                        $temp  = "NO DISPONIBLE";
                   } else { 
                        $temp = "DISPONIBLE";
                   }?>
              <td width="14%" align="center" bordercolor="#FFFFFF"><?php echo $temp?></td>
              <td width="14%" align="center" valign="middle" bordercolor="#FFFFFF"><?php echo $registro['nivel'];?></td>
              <?php 
			  	$temp ="";
                  if ($registro['activado']==1){ 
                        $temp  = "ACTIVO";
                   } else { 
                        $temp = "NO ACTIVO";
                   }?>
              <td width="14%" align="center" bordercolor="#FFFFFF"><?php echo $temp;?></td>
              <td width="50%" align="center" bordercolor="#FFFFFF"><?php echo '' . $registro['descripcion_estado'] . ' ';?> </td>
              <td width="11%" align="center">
			  <input type="hidden" name="txt_cod2" id="txt_cod2" size="20" maxlength="30" value="<?php echo $registro['est_equipo'];?>" />
              <input type="hidden" name="nivel_hidden" id="nivel_hidden" value="<?php echo $registro['nivel'] ;?>" /> 
              <input type="submit" name="borrar" value="Borrar" title="Eliminar Estado Equipo" onclick="elimina=confirm('&iquest;Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style="background-image:url(images/error.png); width:16px; height:16px;" class="formato_boton"/>

                  <br />              </td>
          </tr>
			<?php
				}
				mysql_free_result($res);
				mysql_close($link);
		 ?>
          <?php
		if($_POST['borrar']=='Borrar')
		 { 
			 $link=Conectarse();
			 $sql = "DELETE FROM estado_equipo WHERE cod_estado_equipo =".$_POST['txt_cod'];
			 
			 $res = mysql_query($sql) or die(mysql_error()); 
			 echo "<script type='text/javascript'>RegistroGrabado();</script>";
		 }   
	 ?>
          <?php   
		 $link=Conectarse();
		  if($_POST['OK']=='Guardar y Seguir'){
				if (empty($_POST[txt_descripcion])){  
					$link=mensaje();
				} else {  
					   $codigo      = 	$_POST['txt_cod'];
					   $estado      = 	strtoupper($_POST['cb_estado']);
					   $activado      = 	strtoupper($_POST['activado']);
					   $descripcion = 	strtoupper($_POST['txt_descripcion']);
					   $nivel		= 	$_POST['nivel'];
					   $nivel		= 	(string)(int)$nivel;
					   $codigo		=	(string)(int)$codigo;
						if (empty($codigo)){
							$sql= "insert into estado_equipo (est_equipo, descripcion_estado,nivel,activado) values ('$estado', '$descripcion','$nivel','$activado')";
						  	mysql_query($sql,$link);
						   $okas="1";
						   echo "<script type='text/javascript'>RegistroGrabado();</script>";	
						   $txt_cod="";						
					  } else {
							$sql = "UPDATE estado_equipo 
										SET est_equipo='$estado', 
										descripcion_estado = '$descripcion',
										nivel = '$nivel',
										activado = '$activado'
									where cod_estado_equipo='$codigo'";
							$res  = mysql_query($sql) or die(mysql_error());
							$okas="1";
							echo "<script type='text/javascript'>RegistroGrabado();</script>";
							$txt_cod="";
					  }
			 }
		} 
	?>
        </table>
      </form></td>
    </tr>
  </table> 
<br />
  <br />
  <?php if ($valor1!=1) echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=estado_equipo.php'>";?>
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>