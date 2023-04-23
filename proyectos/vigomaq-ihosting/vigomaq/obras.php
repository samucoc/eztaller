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
.Estilo22 {color: #FF0000}
-->
</style> <script type="text/javascript">
  <!--
function RegistroGrabado() {
  alert("Proceso realizado con Exito!");
  document.location = 'obras.php';
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
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_obra'].value = com;
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
     	   document.forms.obras.php.value=celda;
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
         document.nuevo.action="borra_obras.php?Accion=eliminando"
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
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
<div id="menu-div">
	<?php 
		include('classes/menu.php');
	?>
</div>
<p>&nbsp;</p>
<table width="95%" border="0" align="center">
    <tr>
      <td>      <?php
			{
			include("classes/conex.php");
			$link=Conectarse();
			}
		?></td>
    </tr>
    <tr>
      <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">OBRAS</div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">INGRESO DE OBRA 
        <?php
				{
					$codobra = $_GET['codobra'];
					$id =  $_GET['id'];
				
					$link=Conectarse();
					//busca cliente por codigo
					$sql1 = "SELECT * FROM clientes WHERE cod_cliente ='$id'";
					$res1 = mysql_query($sql1,$link) or die(mysql_error()); 
					$registro1 = mysql_fetch_array($res1);
					echo strtoupper(($registro1['raz_social']));
				}	
			  ?>
             <?php 	
				 	
						$id = $_GET['id'];
	 						//editar una obra
						if ($_GET['codobra']<>"")
						{
						
							$link      = Conectarse();
							$sql       = "SELECT * FROM obra WHERE cod_obra = $codobra ";
						
							$res       = mysql_query($sql,$link) or die(mysql_error()); 
							$registro  = mysql_fetch_array($res);
							$id        = $registro['cod_cliente'];
						
							$sql1      = "SELECT * FROM clientes WHERE cod_cliente ='$id'";
							$res1      = mysql_query($sql1,$link) or die(mysql_error()); 
							$registro1 = mysql_fetch_array($res1);							
						}
	        ?>
               
      </span><span class="Estilo20">
      <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
           	  
		}else{
			  $estado_objetos = 'disabled';
           	  
		};
		?>
      </span></div></td>
    </tr>
    <tr>
      <td height="16"></td>
    </tr>
    <tr>
      <td><form action="obras.php" method="post" name="frmDatos" id="frmDatos">
        <table border="0" align="center" width="100%">
            <tr>
            <input type="hidden" name="txt_codobras" size="20" maxlength="30" value="<?php echo $_GET['codobra'];?>" />
          <input name="txt_cod" type="hidden" value="<?php if (!empty($registro1['cod_cliente'])) 
			{echo ($registro1['cod_cliente']);}else{echo($_POST["txt_cod"]) ;}?>" size="12" maxlength="12" />
              <td width="189"><?php if (empty($registro['cod_obra']) && empty($_POST["codobra"])){ }else{ echo " C&oacute;digo Obra: " ;}?></td>
              <td width="17"><?php if (empty($registro['cod_obra']) && empty($_POST["codobra"])){ }else{ echo ":" ;}?></td>
              <td width="55"><span class='mini_titulo'>
                <?php if (empty($registro['cod_obra']) && empty($_POST["codobra"])){ }else{ 
															 
				 
				   $cantidad =  strlen($registro['cod_obra']);
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_obra'] . ' ';  }		
				   
           ?>
                </span>
                <?php } ?></td>
              <td width="158">&nbsp;</td>
              <td width="54">&nbsp;</td>
              <td width="48"><input type="hidden" name="txt_rutcliente" size="20" maxlength="30" value="<?php echo $registro1['rut_cliente']?>" />
              <input type="hidden" name="txt_codigocli" size="20" maxlength="30" value="<?php echo $registro1['cod_cliente']?>" /></td>
            </tr>
            <tr>
              <td><div align="left"><span class="Estilo22">(*)</span> Vendedor </div></td>
              <td>:</td>
              <td colspan="3"><?php
			$sql="SELECT cod_personal, nombres_personal, ap_patpersonal FROM personal order by cod_personal ASC";
  			$res5=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=personal>\n"; 

			while($campos5=mysql_fetch_row($res5))
			{	
               if ($registro['cod_personal']==$campos5[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos5[0].",".$campos5[1]?>" <?php echo $selected?>>
                    <?php echo $campos5[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo5 = explode( ',', $_POST['personal'] );
					$cargo_id5 = $cargo5[0];
					$cargo_contenido5 = $cargo5[1];  
					echo $campos5; 
		 ?>
                </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo22">(*)</span> Nombre Obra</td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <input name="txt_nombreobra" type="text" value="<?php if (!empty($registro['nombre_obra'])) 
			{echo ($registro['nombre_obra']);}else{echo($_POST["txt_nombreobra"]) ;}?>" size="45" maxlength="45" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo22">(*)</span> Tipo Obra </td>
              <td>:</td>
              <td><?php
			  
			
			  
			  
			$sql="SELECT cod_tipo_obra, tipo_obra FROM tipo_obra order by tipo_obra ASC";
  			$res4=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=tipo_obra>\n"; 

			while($campos4=mysql_fetch_row($res4))
			{	
               if ($registro['tipo_obra']==$campos4[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos4[0].",".$campos4[1]?>" <?php echo $selected?>>
                    <?php echo $campos4[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo4 = explode( ',', $_POST['tipo_obra'] );
					$cargo_id4 = $cargo4[0];
					$cargo_contenido4 = $cargo4[1];  
					echo $campos4; 
		 ?>
                </div></td>
              <td><div align="right">N&deg; Contrato </div></td>
              <td><input name="txt_numcontrato" type="text" value="<?php if (!empty($registro['num_contrato'])) 
			{echo ($registro['num_contrato']);}else{echo($_POST["txt_numcontrato"]) ;}?>" size="9" maxlength="9" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo22">(*)</span> Direcci&oacute;n</td>
              <td>:</td>
              <td colspan="3"><div align="left"><a href="#" class="menulink">
                <input name="txt_dirobra" type="text" value="<?php if (!empty($registro['direcc_obra'])) 
			{echo ($registro['direcc_obra']);}else{echo($_POST["txt_dirobra"]) ;}?>" size="50" maxlength="50" />
              </a></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo22">(*)</span> Ciudad</td>
              <td>:</td>
              <td><?php
			$sql="SELECT cod_ciudad, ciudad FROM ciudad order by ciudad ASC";
  			$res=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=ciudad>\n"; 

			while($campos1=mysql_fetch_row($res))
			{	
               if ($registro['cod_ciudad']==$campos1[0]){
                    $selected = "SELECTED";
               }
               else {
                    $selected = "";
               }

		 ?>
                <div align="left">
                  <option value="<?php echo $campos1[0].",".$campos1[1]?>" <?php echo $selected?>>
                    <?php echo $campos1[1]?>
                  </option>
                  <?php
			}  
                    echo "</select>";	
					$cargo1 = explode( ',', $_POST['ciudad'] );
					$cargo_id1 = $cargo1[0];
					$cargo_contenido1 = $cargo1[1];  

					echo $campos1; 
		 ?>
                </div></td>
              <td><div align="right"><span class="Estilo22">(*)</span> Comuna</div></td>
              <td><?php
			$sql="SELECT cod_comuna, comuna FROM comuna order by comuna ASC";
  			$res2=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=comuna>\n"; 

			while($campos2=mysql_fetch_row($res2))
			{	
               if ($registro['cod_comuna']==$campos2[0]){
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
					$cargo2 = explode( ',', $_POST['comuna'] );
					$cargo_id2 = $cargo2[0];
					$cargo_contenido2 = $cargo2[1];  
					echo $campos2; 
		 ?>
                </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Administrador </td>
              <td>:</td>
              <td colspan="3" align="left"><div align="left">
                <input name="txt_nomadmin" type="text" value="<?php if (!empty($registro['nom_adm'])) 
			{echo ($registro['nom_adm']);}else{echo($_POST["txt_nomadmin"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Tel&eacute;fono</td>
              <td>:</td>
              <td><div align="left">
                <div align="left">
                  <input name="txt_fonoadmin" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['fono_adm'])) 
			{echo ($registro['fono_adm']);}else{echo($_POST["txt_fonoadmin"]) ;}?>" size="8" maxlength="8" />
                </div>
              </div></td>
              <td><div align="right">Movil</div></td>
              <td><input name="txt_moviladmin" type="text" onkeypress="return acceptNum(event)"value="<?php if (!empty($registro['movil_adm'])) 
			{echo ($registro['movil_adm']);}else{echo($_POST["txt_moviladmin"]) ;}?>" size="9" maxlength="9" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>e-mail</td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailadmin" type="text" value="<?php if (!empty($registro['email_adm'])) 
			{echo ($registro['email_adm']);}else{echo($_POST["txt_emailadmin"]) ;}?>" size="50" maxlength="50" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Girador</td>
              <td>:</td>
              <td colspan="3" align="left"><div align="left">
                <input name="txt_girador" type="text"  value="<?php if (!empty($registro['girador'])) 
			{echo ($registro['girador']);}else{echo($_POST["txt_girador"]) ;}?>" size="25" maxlength="25" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Autorizado (1) </td>
              <td>:</td>
              <td colspan="3" align="left"><div align="left">
                <input name="txt_nomaut1" type="text" value="<?php if (!empty($registro['nom_aut1'])) 
			{echo ($registro['nom_aut1']);}else{echo($_POST["txt_nomaut1"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Cargo</td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <input name="txt_cargoaut1" type="text" value="<?php if (!empty($registro['cargo_aut1'])) 
			{echo ($registro['cargo_aut1']);}else{echo($_POST["txt_cargoaut1"]) ;}?>" size="25" maxlength="25" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Tel&eacute;fono</td>
              <td>:</td>
              <td><div align="left">
                <div align="left">
                  <input name="txt_fonoaut1" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['telefono_aut1'])) 
			{echo ($registro['telefono_aut1']);}else{echo($_POST["txt_fonoaut1"]) ;}?>" size="8" maxlength="8" />
                </div>
              </div></td>
              <td><div align="right">Movil</div></td>
              <td><input name="txt_moviaut1" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil_aut1'])) 
			{echo ($registro['movil_aut1']);}else{echo($_POST["txt_moviaut1"]) ;}?>" size="9" maxlength="9" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>e-mail</td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailaut1" type="text" value="<?php if (!empty($registro['email_aut1'])) 
			{echo ($registro['email_aut1']);}else{echo($_POST["txt_emailaut1"]) ;}?>" size="50" maxlength="50" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Autorizado (2) </td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <input name="txt_nomaut2" type="text" value="<?php if (!empty($registro['nom_aut2'])) 
			{echo ($registro['nom_aut2']);}else{echo($_POST["txt_nomaut2"]) ;}?>" size="50" maxlength="50" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Cargo</td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <input name="txt_cargoaut2" type="text" value="<?php if (!empty($registro['cargo_aut2'])) 
			{echo ($registro['cargo_aut2']);}else{echo($_POST["txt_cargoaut2"]) ;}?>" size="25" maxlength="25" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Tel&eacute;fono</td>
              <td>:</td>
              <td><div align="left">
                <div align="left">
                  <input name="txt_fonoaut2" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['telefono_aut2'])) 
			{echo ($registro['telefono_aut2']);}else{echo($_POST["txt_fonoaut2"]) ;}?>" size="8" maxlength="8" />
                </div>
              </div></td>
              <td><div align="right">Movil</div></td>
              <td><input name="txt_moviaut2" type="text" onkeypress="return acceptNum(event)"value="<?php if (!empty($registro['movil_aut2'])) 
			{echo ($registro['movil_aut2']);}else{echo($_POST["txt_moviaut2"]) ;}?>" size="9" maxlength="9" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td> e-mail</td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailaut2" type="text" value="<?php if (!empty($registro['email_aut2'])) 
			{echo ($registro['email_aut2']);}else{echo($_POST["txt_emailaut2"]) ;}?>" size="50" maxlength="50" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Autorizado (3) </td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_nomaut3" type="text" value="<?php if (!empty($registro['nom_aut3'])) 
			{echo ($registro['nom_aut3']);}else{echo($_POST["txt_nomaut3"]) ;}?>" size="50" maxlength="50" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Cargo</td>
              <td>:</td>
              <td colspan="3"><div align="left">
                <input name="txt_cargoaut3" type="text" value="<?php if (!empty($registro['cargo_aut3'])) 
			{echo ($registro['cargo_aut3']);}else{echo($_POST["txt_cargoaut3"]) ;}?>" size="25" maxlength="25" />
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Tel&eacute;fono</td>
              <td>:</td>
              <td><div align="left">
                <div align="left">
                  <input name="txt_fonoaut3" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['telefono_aut3'])) 
			{echo ($registro['telefono_aut3']);}else{echo($_POST["txt_fonoaut3"]) ;}?>" size="8" maxlength="8" />
                </div>
              </div></td>
              <td><div align="right">Movil</div></td>
              <td><input name="txt_moviaut3" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['movil_aut3'])) 
			{echo ($registro['movil_aut3']);}else{echo($_POST["txt_moviaut3"]) ;}?>" size="9" maxlength="9" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>e-mail</td>
              <td>:</td>
              <td colspan="3" align="left"><input name="txt_emailaut3" type="text" value="<?php if (!empty($registro['email_aut3'])) 
			{echo ($registro['email_aut3']);}else{echo($_POST["txt_emailaut3"]) ;}?>" size="50" maxlength="50" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo22">(*)</span> Monto Venta Cr&eacute;dito </td>
              <td>:</td>
              <td><div align="left">
                <input name="txt_montovtacred" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['monto_vta_cred'])) 
			{echo ($registro['monto_vta_cred']);}else{echo($_POST["txt_montovtacred"]) ;}?>" size="9" maxlength="9" />
              </div></td>
              <td><div align="right">Descuento</div></td>
              <td><input name="txt_descuento" type="text" onkeypress="return acceptNum(event)" value="<?php if (!empty($registro['descuento'])) 
			{echo ($registro['descuento']);}else{echo($_POST["txt_descuento"]) ;}?>" size="2" maxlength="2" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="Estilo22">(*)</span> Condiciones de Arriendo</td>
              <td>:</td>
              <td colspan="3" align="left"><?php
			$sql="SELECT cod_cond_arr, condiciones FROM condic_arriendo order by condiciones ASC";
  			$res3=mysql_query($sql,$link) or die(mysql_error());	
			
			echo "<select name=condiciones>\n"; 

			while($campos3=mysql_fetch_row($res3))
			{	
               if ($registro['cod_condic']==$campos3[0]){
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
					$cargo3 = explode( ',', $_POST['condiciones'] );
					$cargo_id3 = $cargo3[0];
					$cargo_contenido3 = $cargo3[1];  
					echo $campos3; 
		 ?>
                </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>
              <a <?php echo "href='cliente.php?id=".$_GET['id']."' "?>><input type="image" name="impresion" value="Impresion" src="images/volver.png" onclick="" width="30" height="30"/></a></td>
              <td></td>
              <td colspan="3" align="right">
              
                <input type="submit" name="OK" value="Guardar y Seguir" title="Agregar Obra a Cliente" style="background-image:url(images/guardar.gif); width:46px; height:50px;" class="formato_boton" <?php echo $estado_objetos ;?> />
                
                <!--<input type="image" name="OK" value="Guardar y Seguir" title="Agregar Obra a Cliente" class="searchbutton" src="images/guardar.gif" <?php echo $estado_objetos ;?>/>-->
              
              </td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <p><br />
          </p>
          <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="38%" bgcolor="#06327D"><span class="Estilo17">C&oacute;digo Obra </span></th>
              <th width="49%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Nombre Obra</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><?php
			//  $cod_cliente   = $_POST['txt_cod'];
			$sql="SELECT * FROM obra where cod_cliente = '$id' order by cod_obra ASC";
			// echo ($sql);
			$res = mysql_query($sql) or die(mysql_error()); 
			while ($registro = mysql_fetch_array($res)) {
		 ?><span class="Estilo17">Accion</span></th>
            </tr>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <td bgcolor="#FFFFFF">
			  <?php 
			  	   $cantidad = strlen($registro['cod_obra']); 
				   if ($cantidad==1) { echo ("00000" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==2) { echo ("0000" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==3) { echo ("000" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==4) { echo ("00" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==5) { echo ("0" .('' . $registro['cod_obra'] . ' ') );  }
				   if ($cantidad==6) { echo '' . $registro['cod_obra'] . ' ';  }		
			  ?> </td>
              <td bgcolor="#FFFFFF"><?php echo '' . $registro['nombre_obra'] . ' ';?></td>
              <td align="center" bgcolor="#FFFFFF">
              	<a href='obras.php?codobra=<?php echo $registro['cod_obra']?>&id=<?php echo $id;?>'>
                	<img name="modif" title="Editar Obra" src="images/modificar.png"/>
                </a>
                <input type="submit" name="borrar" ititle="Eliminar Obra" value="Borrar" onclick="elimina=confirm('&iquest;Esta seguro de que quiere Eliminar?');return elimina;" <?php echo $estado_objetos ;?> style="background-image:url(images/error.png); width:16px; height:16px;" class="formato_boton"/>
               
				</td>
            </tr>
			<?php
				}
				mysql_free_result($res);
				mysql_close($link);
		 ?>
         		<?php
			function mensaje()
				{
					echo "<script>
					alert('Ingrese Datos Obra');
					</script>";
				}
			 function mensaje2()
				 {
					echo "<script>
					alert('Ingrese Nombre Repuesto');
					</script>";
				
				
				}
		  ?>
		 <?php
			
			if($_POST['borrar']=='Borrar')
			 { 
				 $cod_cliente   = $_POST['txt_cod'];                  
				
				 $link=Conectarse();
				 $sql = "DELETE FROM obra WHERE cod_obra =".$_POST['txt_cod'];
				
				 $id = $_POST['txt_cod'];
				 $res = mysql_query($sql) or die(mysql_error()); 
				 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
				 echo "<script language=Javascript> location.href=\"obras.php?id=".$_POST["txt_codigocli"]."\"; </script>";
				 }   
	     ?>
           <?php   
		 $link=Conectarse();
	
		if ($_POST['OK']=='Guardar y Seguir') {
		$cod_cliente   = $_POST['txt_cod'];                          echo ("cod_cliente")."$cod_cliente<br>";
		$cod_obra      = $_POST['txt_codobras'];                     echo ("cod_obra")."$cod_obra<br>";
		$vendedor	   = $cargo_id5;                                    //     echo "$vendedor<br>";
		$nombre_obra   = strtoupper($_POST['txt_nombreobra']); //    echo "$nombre_obra<br>";
		$cod_tipo_obra = $cargo_id4;                                    //     echo "$cod_tipo_obra<br>"; 
		$num_contrato  = $_POST['txt_numcontrato'];            //     echo "$num_contrato<br>";
		$direcc_obra   = strtoupper($_POST['txt_dirobra']);    //     echo "$direcc_obra<br>"; 
		$cod_ciudad    = $cargo_id1;                     	            //     echo "$cod_ciudad<br>"; 	
		$cod_comuna    = $cargo_id2;  	                                //    echo "$cod_comuna<br>"; 
		$nom_admin     = strtoupper($_POST['txt_nomadmin']);   //     echo "$nom_admin<br>";
		$fono_admin    = $_POST['txt_fonoadmin']; 	            //     echo "$fono_admin<br>"; 
		$movil_admin   = $_POST['txt_moviladmin'];             //  	 echo "$movil_admin<br>";
		$mail_admin    = strtoupper($_POST['txt_emailadmin']); //    echo "$mail_admin<br>";
		$girador       = strtoupper($_POST['txt_girador']); 	//     echo "$girador<br>";
		$nom_aut1      = strtoupper($_POST['txt_nomaut1']); 	//     echo "$nom_aut1<br>";
		$cargo_aut1    = strtoupper($_POST['txt_cargoaut1']); 	//     echo "$cargo_aut1<br>";
		$fono_aut1     = $_POST['txt_fonoaut1'];               //     echo "$fono_aut1<br>";
		$movil_aut1    = $_POST['txt_moviaut1']; 	            //     echo "$movil_aut1<br>";
		$email_aut1    = strtoupper($_POST['txt_emailaut1']);  //    echo "$email_aut1<br>";
		$nom_aut2      = strtoupper($_POST['txt_nomaut2']); 	//     echo "$nom_aut2<br>";
		$cargo_aut2    = strtoupper($_POST['txt_cargoaut2']);  //  	 echo "$cargo_aut2<br>";
		$fono_aut2     = $_POST['txt_fonoaut2'];               ///     echo "$fono_aut2<br>";
		$movil_aut2    = $_POST['txt_moviaut2']; 	            //     echo "$movil_aut2<br>";
		$email_aut2    = strtoupper($_POST['txt_emailaut2']);  //     echo "$email_aut2<br>";
		$nom_aut3      = strtoupper($_POST['txt_nomaut3']); 	//     echo "$nom_aut3<br>";
		$cargo_aut3    = strtoupper($_POST['txt_cargoaut3']); 	//     echo "$cargo_aut3<br>";
		$fono_aut3     = $_POST['txt_fonoaut3'];               //      echo "$fono_aut3<br>";
		$movil_aut3    = $_POST['txt_moviaut3'];       	    //    echo "$movil_aut3<br>";
		$email_aut3    = strtoupper($_POST['txt_emailaut3']);  //     echo "$email_aut3<br>";
		$monto_credito = $_POST['txt_montovtacred'];           //     echo "$monto_credito<br>";
		$descuento     = $_POST['txt_descuento'];              //     echo "$descuento<br>";
		$condic_arr    = $cargo_id3;  	                                 //     echo "$condic_arr<br>";
		
		if (empty($cod_cliente)||empty($vendedor)||empty($nombre_obra)||empty($cod_tipo_obra)||empty($direcc_obra)||empty($cod_ciudad)||empty($cod_comuna)|| empty($monto_credito) || empty( $condic_arr)){  
				$link=mensaje();
			} else {
			
		$cod_cliente   = $_POST['txt_cod'];          //echo ("cod_cliente")."$cod_cliente<br>";
		$cod_obra      = $_POST['txt_codobras'];      //echo "$cod_obra<br>";
		$vendedor	   = $cargo_id5;                          //echo "$vendedor<br>";
		$nombre_obra   = strtoupper($_POST['txt_nombreobra']);  //echo "$nombre_obra<br>";
		$cod_tipo_obra = $cargo_id4;                          //echo "$cod_tipo_obra<br>"; 
		$num_contrato  = $_POST['txt_numcontrato']; // echo "$num_contrato<br>";
		$direcc_obra   = strtoupper($_POST['txt_dirobra']); //echo "$direcc_obra<br>"; 
		$cod_ciudad    = $cargo_id1;                     	   // echo "$cod_ciudad<br>"; 	
		$cod_comuna    = $cargo_id2;  	                   // echo "$cod_comuna<br>"; 
		$nom_admin     = strtoupper($_POST['txt_nomadmin']); //echo "$nom_admin<br>";
		$fono_admin    = $_POST['txt_fonoadmin']; 	//echo "$fono_admin<br>"; 
		$movil_admin   = $_POST['txt_moviladmin']; //	echo "$movil_admin<br>";
		$mail_admin    = strtoupper($_POST['txt_emailadmin']); //  echo "$mail_admin<br>";
		$girador       = strtoupper($_POST['txt_girador']); 	//    echo "$girador<br>";
		$nom_aut1      = strtoupper($_POST['txt_nomaut1']); 	//    echo "$nom_aut1<br>";
		$cargo_aut1    = strtoupper($_POST['txt_cargoaut1']); 	//echo "$cargo_aut1<br>";
		$fono_aut1     = $_POST['txt_fonoaut1'];  //   echo "$fono_aut1<br>";
		$movil_aut1    = $_POST['txt_moviaut1']; 	//echo "$movil_aut1<br>";
		$email_aut1    = strtoupper($_POST['txt_emailaut1']);   // echo "$email_aut1<br>";
		$nom_aut2      = strtoupper($_POST['txt_nomaut2']); 	 // echo "$nom_aut2<br>";
		$cargo_aut2    = strtoupper($_POST['txt_cargoaut2']); //	echo "$cargo_aut2<br>";
		$fono_aut2     = $_POST['txt_fonoaut2'];    // echo "$fono_aut2<br>";
		$movil_aut2    = $_POST['txt_moviaut2']; 	//echo "$movil_aut2<br>";
		$email_aut2    = strtoupper($_POST['txt_emailaut2']);  // echo "$email_aut2<br>";
		$nom_aut3      = strtoupper($_POST['txt_nomaut3']); 	// echo "$nom_aut3<br>";
		$cargo_aut3    = strtoupper($_POST['txt_cargoaut3']); 	//echo "$cargo_aut3<br>";
		$fono_aut3     = $_POST['txt_fonoaut3'];               //echo "$fono_aut3<br>";
		$movil_aut3    = $_POST['txt_moviaut3'];       	    //echo "$movil_aut3<br>";
		$email_aut3    = strtoupper($_POST['txt_emailaut3']);  //echo "$email_aut3<br>";
		$monto_credito = $_POST['txt_montovtacred'];           //echo "$monto_credito<br>";
		$descuento     = $_POST['txt_descuento'];              //echo "$descuento<br>";
		$condic_arr    = $cargo_id3;  	                                //echo "$condic_arr<br>";	
		
		if (empty($cod_obra)){
		//	 echo"txt_cod - $codigo";
			 mysql_query("insert into obra (cod_cliente,cod_ciudad,cod_comuna,cod_personal,cod_condic,tipo_obra,nombre_obra,direcc_obra,nom_adm,fono_adm,movil_adm,email_adm,num_contrato,girador,nom_aut1,cargo_aut1,telefono_aut1,movil_aut1,email_aut1,nom_aut2,cargo_aut2,telefono_aut2,movil_aut2,email_aut2,nom_aut3,cargo_aut3,telefono_aut3,movil_aut3,email_aut3,monto_vta_cred,descuento) values ('$cod_cliente','$cod_ciudad','$cod_comuna','$vendedor','$condic_arr','$cod_tipo_obra','$nombre_obra','$direcc_obra','$nom_admin','$fono_admin','$movil_admin','$mail_admin','$num_contrato','$girador','$nom_aut1','$cargo_aut1','$fono_aut1','$movil_aut1','$email_aut1','$nom_aut2','$cargo_aut2','$fono_aut2','$movil_aut2','$email_aut2','$nom_aut3','$cargo_aut3','$fono_aut3','$movil_aut3','$email_aut3','$monto_credito','$descuento')",$link);
			 mysql_close($link);
			 echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
			 echo "<script language=Javascript> location.href=\"obras.php?id=".$cod_cliente."\"; </script>";
		 } else {
 //		 echo"txt_cod - $txt_cod";
 //		 echo "update";
				$sql = "UPDATE obra SET cod_cliente='$cod_cliente', cod_ciudad='$cod_ciudad', cod_comuna='$cod_comuna', cod_personal='$vendedor', cod_condic='$condic_arr', tipo_obra='$cod_tipo_obra', nombre_obra='$nombre_obra', direcc_obra='$direcc_obra', nom_adm='$nom_admin', fono_adm='$fono_admin', movil_adm='$movil_admin', email_adm='$mail_admin', num_contrato='$num_contrato', girador='$girador',  nom_aut1='$nom_aut1', cargo_aut1='$cargo_aut1', telefono_aut1='$fono_aut1', 			movil_aut1='$movil_aut1', email_aut1='$email_aut1', nom_aut2='$nom_aut2', cargo_aut2='$cargo_aut2', telefono_aut2='$fono_aut2', movil_aut2='$movil_aut2',  email_aut2='$email_aut2', nom_aut3='$nom_aut3', cargo_aut3='$cargo_aut3', telefono_aut3='$fono_aut3', movil_aut3='$movil_aut3', email_aut3='$email_aut3', monto_vta_cred='$monto_credito', descuento='$descuento' where cod_obra='$cod_obra'";
				$res  = mysql_query($sql) or die(mysql_error());
				echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";
				echo "<script language=Javascript> location.href=\"obras.php?id=".$cod_cliente."\"; </script>";
				
		  }	  
	}
 }  
	?>
          </table>
      </form></td>
    </tr>
  </table>
  <br />
</div>

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>