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

<link rel="stylesheet" href="../../style.css" type="text/css" />
<script type="text/javascript" src="../../script.js"></script>
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
  document.location = 'bitacoras.php?num_factura='.$_GET["num_factura"];
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
  co1 = celda.getElementsByTagName('td')[2].innerHTML;
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_fecha'].value = com;
  document.forms[0]['txt_descripcion'].value = co1;
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
     	   document.forms.bitacoras.php.value=celda;
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
         document.nuevo.action="bitacoras.php?Accion=eliminando"
         document.nuevo.submit()	           
        }                        
}
</script>
<script src="sorttable.js"></script>
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
    
    <script type="text/javascript" src="../../jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="../../jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="../../jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> @import url("../../jscalendar-1.0/calendar-win2k-cold-1.css"); </style>

</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="../../images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
	<table width="100%" border="0" align="center">
    <tr>
      <td>      <?php
			{
			include("../conex.php");
			$link=Conectarse();
			}
		?>
		 <?php
			{
				$valor1 = $_GET["id"];
				$valor1=1;
				
			}
		?>
		 <span class="Estilo20">
		 <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
           	 
		}else{
			  $estado_objetos = 'disabled';
           	 
		};
		?>
		 </span></td>
    </tr>
    <tr>
      <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">Bitacoras de Cobranza</div> 
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS Bitacoras de Cobranza </span></div></td>
    </tr>
    <tr>
      <td height="16"></td>
    </tr>
    <tr>
      <td><form action="bitacoras.php?num_factura=".$_GET["num_factura"]."" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" height="30">
            <tr>
              <td width="10%" class='mini_titulo'><div align="left"><font><strong>Cliente :</strong></font></div></td>
              <td width="90%" class='mini_titulo'><font>
              		<?php 
              		if ($_GET['num_factura']!=''){
	                	$row_cliente["cod_cliente"] = $_GET["num_factura"];
						}
	                else{
	                	$row_cliente["cod_cliente"] = $_POST['txt_cod_cliente'];
	                	}

					$query = "select distinct clientes.raz_social
								from clientes
							 	where clientes.cod_cliente = ".$row_cliente["cod_cliente"]."";
					$result=mysql_query($query,$link) or die(mysql_error()); 
					$row = mysql_fetch_array($result);
					
              		?>
                <div id="txt_cliente" class="Estilo20" style="font-size: 20px"><?php echo $row['raz_social']; ?></div>
                <input type="hidden" name="txt_cod_cliente" size="20" maxlength="30" value="<?php echo $row_cliente['cod_cliente']; ?>"/> 
              </font> 
              </td>
            </tr>
            <tr>
              <td width="10%" class='mini_titulo'><div align="left"><font><strong>Fecha :</strong></font></div></td>
              <td width="90%" class='mini_titulo'><font>
                <input type="hidden" name="txt_cod" size="20" maxlength="30" /> <input type="text" name="txt_fecha"  id="txt_fecha" size="25" maxlength="25" />
                <button type="submit" id="cal-button-1">...</button>
                <script type="text/javascript">
			            Calendar.setup({
			              inputField    : "txt_fecha",
			              button        : "cal-button-1",
			              align         : "Tr"
			            });
                </script>
              </td>
            </tr>
            <tr>
              <td width="10%" class='mini_titulo'><div align="left"><font><strong>Descripcion :</strong></font></div></td>
              <td width="90%" class='mini_titulo'><font>
                <textarea name="txt_descripcion" cols="100" rows="5"></textarea>
              </font> 
              </td>
            </tr>
            <tr>
              <td width="44%" valign="bottom"><div align="left">
                <input type="submit" name="OK" value="Guardar y Seguir" title="Guardar y continuar" style="background-image:url(../../images/guardar.png); height:45px; width:45px;" class="formato_boton" <?php echo $estado_objetos ;?>/>
                
              </div></td>
            </tr>
			 <?php
			function mensaje()
				{
					echo "<script>
					alert('Debe Ingresar dato');
					</script>";
				}
		   ?>
          </table>
        <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="sortable" id="unique_id" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="3%" bgcolor="#06327D" class="CONT"><span class="Estilo17"></span></th>
              <th width="7%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Fecha</span></th>
              <th width="80%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Descripcion</span></th>
              <th width="10%" bgcolor="#06327D" class="CONT">
              <span class="Estilo17 Estilo13 Estilo15">Eliminar</span></th>
            </tr>
            <?php
			$sql="SELECT * FROM bitacoras_cobranza where rut_cliente = '".$row_cliente['cod_cliente']."' order by fecha desc";
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <td bgcolor="#fff" style="color:#fff">
			  <?php 
			  	   echo '' . $registro['bc_ncorr'] . ''	
			  ?> </td>
             
              <td bgcolor="#FFFFFF" style="padding:5px;"><?php echo '' . $registro['fecha'] . '';?></td>
              <td bgcolor="#FFFFFF" style="padding:5px;"><?php echo '' . $registro['descripcion'] . ' ';?></td>
              <td align="center" bgcolor="#FFFFFF" style="padding:5px;">
              
                <input type="submit" name="borrar" value="Borrar" title="Eliminar fecha" src="../../images/error.png" onclick="elimina=confirm('&iquest;Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style="background-image:url(../../images/error.png); height:16px; width:16px;" class="formato_boton" />
                
              
              </td>
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
			 echo $sql = "DELETE FROM bitacoras_cobranza WHERE bc_ncorr =".$_POST['txt_cod'];
			 
			 $res = mysql_query($sql) or die(mysql_error()); 
			 echo "<script type='text/javascript'>location.href='bitacoras.php?num_factura=".$_POST["txt_cod_cliente"]."'</script>";
			 }   
	 ?>
          <?php   
		 $link=Conectarse();
		  if($_POST['OK']=='Guardar y Seguir'){
				if (empty($_POST[txt_fecha])){  
					$link=mensaje();
				} else {  
					   $codigo = $_POST['txt_cod'];
					   $cliente = strtoupper($_POST['txt_cod_cliente']);
					   $fecha = strtoupper($_POST['txt_fecha']);
					   list($dia,$mes,$anio) = explode('-',$fecha);
					   $fecha = $anio.'-'.$mes.'-'.$dia;
					   $descripcion = strtoupper($_POST['txt_descripcion']);
					   $codigo = (string)(int)$codigo;
						if (empty($codigo)){
						   mysql_query("insert into bitacoras_cobranza (rut_cliente,fecha,descripcion) value ('$cliente','$fecha','$descripcion')",$link);
						   $okas="1";
						   echo "<script type='text/javascript'>location.href='bitacoras.php?num_factura=".$_POST["txt_cod_cliente"]."'</script>";
						   $txt_cod="";						
					  } else {
							$sql = "UPDATE bitacoras_cobranza SET rut_cliente='$cliente', fecha='$fecha', descripcion='$descripcion' where bc_ncorr='$codigo'";
							$res  = mysql_query($sql) or die(mysql_error());
							$okas="1";
							echo "<script type='text/javascript'>location.href='bitacoras.php?num_factura=".$_POST["txt_cod_cliente"]."'</script>";
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
  <?php if ($valor1!=1) echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=bitacoras.php?num_factura=".$_GET["num_factura"]."'>";?>
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>