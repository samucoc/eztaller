<?php 
ob_start();
session_start(); 

/*
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
	header('Location: http://intranet.vigomaq_intranet.cl/movil');
	exit();
	}
*/

mysql_connect("localhost","vigomaq","sebterROOT9384"); 
mysql_select_db("vigomaq_intranet"); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<html>
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
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<script>
	var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	if(isAndroid) {
		window.location = 'http://intranet.vigomaq_intranet.cl/movil';
		}
</script>

</head>
<body bgcolor="#FFFFFF">
<span class="botones"></span><span class="imputbox"></span><br>
<table width="850" border="0" align="center" style="background-image:url(images/back_login.jpg); background-repeat:no-repeat">
  <tr>
    <td>
    <input type="hidden" name="autor" value="samuel silva"/>
    <form  method="post">
        <div align="center" class="maincontainer_chico"><br>
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
                              <input type="text" name="user" size="15" class="imputbox">
                            </div></td>
                        </tr>
                        <tr> 
                          <td width="39%"> <div align="right"><span class="msg"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password</font></span><font face="Verdana, Arial, Helvetica, sans-serif" size="2">                  : </font></div></td>
                          <td width="61%"> <div align="left"> 
                              <input name="pass" type="password" class="imputbox" id="pass" size="15">
                            </div></td>
                        </tr>
                      </table>
                      <div align="center">
                        <input name="OK" type="submit" value="Entrar" class="searchbutton">
            </div>      </td>
                </tr>
            <?php  if(isset($_POST['OK'])=='Entrar'){
                
                            if (empty($_POST['user'])|| empty($_POST['pass']))
                            {  
                                echo "<script>
                                alert('Debe Ingresar Usuario y Contraseña');
                                </script>";
                            } else { 
                                /*if (($_POST[user]=="Invitado") && ($_POST[pass]=="vigomaq"))
                                {**/
                                    echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=principal.php'>";
                                /*}else{ 
                                    echo "<script>
                                    alert('Datos mal ingresados');
                                    </script>";
                                }*/
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
            <br>
            <br> 
            <br>
            <br>
            Desarrollado por <a href="http://www.sebterconsultores.com/" target="_blank">Sebter Consultores</a> - 2011<br>
        </div>
    </form>
    </td>
  </tr>
</table>
</body>
</html>