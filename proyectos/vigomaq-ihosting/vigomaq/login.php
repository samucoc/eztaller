<?php //ob_start("ob_gzhandler"); 
ob_start();
session_start(); 

session_name("sesiondirh");
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$usuario=$_SESSION['tipo_usuario'];else $usuario=false; 


if ($_SESSION['usuario']) { header("Location: ./login.php");
}

if (!empty($_POST['usuario'])) {
session_register("usuario");
$_SESSION['usuario'] = $_POST['usuario'];
header("Location: ./login.php");
}
?><html>
<title>Area de Administración - Vigomaq</title>
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
</style>
<style type="text/css">
<!--
a:link {
	color: #FF6600;
}
a:visited {
	color: #FF9900;
}
.style2 {font-size: 10px}
-->
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq.cl/favicon.ico">
</head>
<body bgcolor="#FFFFFF">
<span class="botones"></span><span class="imputbox"></span>
        <?php
				{
					include("classes/conex.php");
					$link=Conectarse();
				}
			 ?>

<br>

<table width="850" border="0" align="center" style="background-image:url(images/back_login.jpg); background-repeat:no-repeat">
  <tr>
    <td>
    <form  method="post">
    <div align="center" class="maincontainer_chico">  <br>
       <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
          <table width=0% border=0 align="center" cellpadding="0" cellspacing="0" class="bord_img">
    <tr> 
      <td width="266" height="141" colspan="2">
          <table width="262" border="0" cellspacing="0" cellpadding="5">
            <tr valign="middle">
              <td colspan="2" height="30"><div align="center" class="menu_top"><strong>Identificaci&oacute;n Usuarios</strong></div></td>
            </tr>
            <tr valign="middle"> 
              <td colspan="2" height="30"> <div align="center"> 
                  </div></td>
            </tr>
            <tr> 
              <td width="39%"> <div align="right"><span class="msg"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario</font></span><font face="Verdana, Arial, Helvetica, sans-serif" size="2">                  : </font></div></td>
              <td width="61%"> <div align="left"> 
                  <input name="user" type="text" class="imputbox" size="20" maxlength="20">
                </div></td>
            </tr>
            <tr> 
              <td width="39%"> <div align="right"><span class="msg"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password</font></span><font face="Verdana, Arial, Helvetica, sans-serif" size="2">                  : </font></div></td>
              <td width="61%"> <div align="left"> 
                  <input name="pass" type="password" class="imputbox" id="pass" size="10" maxlength="10">
                </div></td>
            </tr>
          </table>
          <div align="center">
            <input name="OK" type="submit" value="Entrar" class="searchbutton">
</div>      </td>
    </tr>
<?php  if($_POST['OK']=='Entrar'){
	
				if (empty($_POST['user'])|| empty($_POST['pass']))
				{  
					echo "<script>
					alert('Debe Ingresar Usuario y Password');
					</script>";
				} else { 
				    $usuario=$_POST['user'];
					$pass=$_POST['pass'];
				    $link=Conectarse();
					$sql = "SELECT * FROM usuario WHERE nombre_usuario ='$usuario' and contrasena = '$pass'";		
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);
							
					if (($_POST[user]==$registro['nombre_usuario']) && ($_POST[pass]==$registro['contrasena']))
					{
						$tipo_usuario = $registro['tipo_usuario'];
						$_SESSION['usuario']=$registro['nombre_usuario'];
						$_SESSION['tipo_usuario']=$registro['tipo_usuario'];
						echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=principal.php'>";
					}else{ 
						echo "<script>
						alert('Datos mal ingresados');
						</script>";
					}
				}
   }
	?>
</table>

            <br>
            <br>
            <br>
            <br>
        <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
            <? // Desarrollado por <a href="http://www.sebterconsultores.com/" target="_blank">Sebter Consultores</a> - <?php //echo date("Y")<br> -->?>
            Desarrollado por <a href="http://www.gescol.cl/" target="_blank">Gescol Consultores</a> - <?php echo date("Y")?><br>

			<table>
            <tr align="center">
            	<td>Fecha : <?php echo date("d-m-Y")?></td>
            	<td>Hora : <?php echo date("H:i:s")?></td>
            </tr>
            </table>

      </div>
</form>

    
    
    </td>
  </tr>
</table>




</body>
</html>
