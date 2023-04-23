<?php ob_start(); 
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
  document.location = 'tarifas.php';
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
  des = celda.getElementsByTagName('td')[2].innerHTML;
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_destino'].value = com;
  document.forms[0]['txt_valor'].value = des;
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
     	   document.forms.tarifas.php.value=celda;
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
         document.nuevo.action="borra_destino.php?Accion=eliminando"
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
	</div><table width="662" border="0" align="center">
    <tr>
      <td width="664"><?php
			{
			include("conex.php");
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
      <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">TARIFA DESPACHO </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS TARIFA DESPACHO </span></div></td>
    </tr>
    
    <tr>
      <td><form action="tarifas.php" method="post" name="frmDatos" id="frmDatos">
        <table width="100%" >
          
          <tr>
            <td class='mini_titulo'><div align="left"><font><strong>Destino:</strong></font></div></td>
            <td bgcolor="#FFFFFF"  class='mini_titulo'><font>
              <input type="hidden" name="txt_cod" size="20" maxlength="30" />
              <input type="text" name="txt_destino" size="50" maxlength="50" />
            </font></td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td class='mini_titulo'><div align="left"><font><strong>Tarifa:</strong></font></div></td>
            <td bgcolor="#FFFFFF"  class='mini_titulo'><font>
              <input name="txt_valor" type="text" onKeyPress="return acceptNum(event)" value="<?php echo $registro['tarifa'];?>" size="9" maxlength="9">
            </font> </td>
            <td width="112" valign="bottom"><div align="left">
              
              <input type="submit" name="OK" title="Guardar y continuar" value="Guardar y Seguir"  style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" <?php echo $estado_objetos ;?> />
              <!--<input name="OK" type="image" class="boton" title="Guardar y continuar" value="Guardar y Seguir"  src="images/guardar.png"  width="30" height="30" <?php echo $estado_objetos ;?>/>-->
            </div></td>
          </tr>
		   <?php
			function mensaje()
				{
					echo "<script>
					alert('Debe Ingresar Destino y Tarifa');
					</script>";
				}
		   ?>
        </table>
        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th bgcolor="#06327D"><span class="Estilo17">C&oacute;digo Tarifa </span></th>
              <th bgcolor="#06327D"><span class="Estilo17">Destino</span></th>
              <th bgcolor="#06327D" class="CONT"><span class="Estilo17">Valor</span></th>
              <th bgcolor="#06327D" class="CONT"><?php
			$sql="SELECT * FROM Tarifa_Despacho order by cod_tarifa";
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?>
              <span class="Estilo17 Estilo13 Estilo15">Eliminar</span></th>
            </tr>
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <td width="25%" bordercolor="#FFFFFF">
			  <?php
			       $cantidad = strlen($registro['cod_tarifa']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_tarifa'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_tarifa'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_tarifa'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_tarifa'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_tarifa'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_tarifa'] . ' ';  }
			  ?>
			  </td>
              <td width="41%" bordercolor="#FFFFFF"><?php echo '' . $registro['lugar_despacho'] . ' ';?> </td>
              <td width="23%" bordercolor="#FFFFFF" align="right"><?php echo '' . $registro['tarifa'] . ' ';?> </td>
              <td width="11%" align="center">
              
              
              <input type="submit" name="borrar" title="Eliminar Tarifa" value="Borrar" onclick="elimina=confirm('&iquest;Esta seguro de que quiere Eliminar?');return elimina;"  <?php echo $estado_objetos ;?> style="background-image:url(images/error.png); width:16px; height:16px;" class="formato_boton"/>
            <!--<input type="image" name="borrar" value="Borrar" title="Eliminar Tarifa" src="images/error.png" onclick="elimina=confirm('&iquest;Esta seguro de que quiere Eliminar?');return elimina;"  <?php echo $estado_objetos ;?> />-->
                  <br />              </td>
          </tr>
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <td bordercolor="#FFFFFF">--------------------------------</td>
              <td bordercolor="#FFFFFF">-----------------------------------------------------</td>
              <td bordercolor="#FFFFFF">-----------------------------</td>
              <td>-------------</td>
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
			 $sql = "DELETE FROM Tarifa_Despacho WHERE cod_tarifa =".$_POST['txt_cod'];
			 //echo "sql= $sql<br>"; //muestra los valores de la consulta
			 $res = mysql_query($sql) or die(mysql_error()); 
			 echo "<script type='text/javascript'>RegistroGrabado();</script>";
		 }   
	 ?>
          <?php   
		 $link=Conectarse();
		  if($_POST['OK']=='Guardar y Seguir'){
				if (empty($_POST[txt_destino]) or empty($_POST[txt_valor]) ){  
					$link=mensaje();
				} else {  
					   $codigo    = $_POST['txt_cod'];
					   $despacho  = strtoupper($_POST['txt_destino']);		
					   $tarifa    = strtoupper($_POST['txt_valor']);
					   $codigo    = (string)(int)$codigo;
						if (empty($codigo)){
						   mysql_query("insert into vigomaq_intranet.Tarifa_Despacho (lugar_despacho, tarifa) values ('$despacho', '$tarifa')",$link);
						   $okas="1";
						   echo "<script type='text/javascript'>RegistroGrabado();</script>";	
						   $txt_cod="";						
					  } else {
							$sql = "UPDATE vigomaq_intranet.Tarifa_Despacho SET lugar_despacho='$despacho', tarifa = '$tarifa' where cod_tarifa='$codigo'";
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
  <?php if ($valor1!=1) echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=tarifas.php'>";?>
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>