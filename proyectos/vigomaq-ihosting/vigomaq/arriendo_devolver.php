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
	<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
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
  document.forms[0]['txt_obra'].value = cod;
  document.forms[0]['txt_codobra'].value = com;
}
</script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-weight: bold}
.Estilo22 {font-weight: bold}
.Estilo23 {
	color: #666666;
	font-style: italic;
	font-weight: bold;
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
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
       <span class="Estilo23">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
<table width="80%" border="0" align="center">
    <tr>
      <td width="52%"></td>
      <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13">
            <?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
            <?php
        if ($_SESSION['tipo_usuario']=="0") {
		   	  $estado_objetos = 'enabled';
           	  //echo $estado_objetos ;
		}else{
			  $estado_objetos = 'disabled';
           	  //echo $estado_objetos ;
		};
		?>
            ARRIENDO / DEVOLUCION </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7"><span class="Estilo13">

      </span><span class="Estilo13">
      <?php
				//numero de arriendo
				if (($_POST['buscarcodigo']=='Buscar'))
				{
					$valor2=trim($_POST['txt_codigo']);
				
				}else{
					$valor2=$_GET['cod_arr'];
				}
            	//rut del cliente lo busca por primera vez
				$valor1 = $_POST["txt_rut"];
		
				
				if (!empty($valor2))
				{
					$link=Conectarse();
					$sql1 = "SELECT * 
								FROM vigomaq_intranet.arriendo 
									inner join gd
										on gd.id_arriendo = arriendo.cod_arriendo
								WHERE gd.num_gd ='$valor2'";
					
					$res1 = mysql_query($sql1,$link) or die(mysql_error()); 
					$registro1 = mysql_fetch_array($res1);				
					$valor1=$registro1['rut_cliente']; 
					
				    if (empty($valor1))	echo "<script> alert (\"Arriendo No Encontrado\"); </script>";
			    }
					
				if (!empty($valor1))
				{
					$link=Conectarse();
					$sql = "SELECT * FROM vigomaq_intranet.clientes WHERE rut_cliente ='$valor1'";
				
					$res = mysql_query($sql,$link) or die(mysql_error()); 
					$registro = mysql_fetch_array($res);		
			      }
		?>
      </span>DATOS ARRIENDO</span></div></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><form method="POST" name="frmDatos" id="frmDatos"><table width="100%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="left">
      <tr>
        <td colspan="4">     </td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" height="2"></td>
      </tr>
      <tr>
        <td width="107"><div align="left">N&deg; Guia Despacho: </div></td>
        <td colspan="3"><div align="left">
          <input  name="txt_codigo" type="text" size="8" maxlength="8" value="<?php if (!empty($registro1['num_gd'])) 
			{echo ($registro1['num_gd']);}else{echo($_POST["txt_codigo"]) ;} ?>"/>
              
              
              
              <input type="submit" name="buscarcodigo" value="Buscar" title="Buscar Equipo por Código" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/>
              
             <!--<input type="image" name="buscarcodigo" value="Buscar" title="Buscar Equipo por Código" class="searchbutton" src="images/ver.png"/>-->
              
              
              
              <input type="hidden" name="txt_cod" size="20" maxlength="30" />
        </div></td>
        <td width="78" align="center" valign="middle"><?php  $fecha = date ("d-m-Y"); echo($fecha);//echo date ( "j - n - Y" );?></td>
      </tr>
      <tr>
        <td colspan="5" bgcolor="#06327D"><div align="left"><span class="Estilo7">Cliente</span></div></td>
        </tr>
      <tr>
        <td><div align="left">Raz&oacute;n Social :</div></td>
        <td colspan="3"><div align="left">
          <input  name="txt_razonsoc" type="text" value="<?php echo $registro['raz_social'];?>" size="50" maxlength="50" disabled="disabled"/>
        </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Contacto:</td>
        <td colspan="3"><div align="left">
          <input name="txt_nomresp" type="text" value="<?php echo $registro['nom_resp_emp1'];?>" size="50" maxlength="50" disabled="disabled" />
        </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">Obra</span></div></td>
      </tr>
      <tr>
        <td height="15"><div align="left">Nombre:</div></td>
        <td colspan="3"><input type="hidden" name="txt_obra" size="45" maxlength="45" />
          <input type="text" name="txt_nombreobra" size="45" maxlength="45" value="<?php 
		  if (!empty($registro1['cod_obra'])){
				$sql="SELECT * FROM obra where cod_obra = ".$registro1['cod_obra'];
				$res = mysql_query($sql) or die(mysql_error()); 
				$registroob = mysql_fetch_array($res) ;
				echo ($registroob['nombre_obra']);
		  }?>" disabled="disabled" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">Equipos</span></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table class="sortable" id="unique_id" border="0" align="center" cellpadding="1" cellspacing="1" >
      <tr title="Clic para seleccionar" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
        <th width="84" bgcolor="#06327D"><span class="Estilo17">Cod.  Equipo </span></th>
        <th width="187" bgcolor="#06327D"><span class="Estilo17"> Nombre Equipo </span></th>
        <th width="133" bgcolor="#06327D" class="CONT"><span class="Estilo17">Arriendo Desde</span></th>
        <th width="101" bgcolor="#06327D" class="CONT"><span class="Estilo17">Arriendo Hasta</span></th>
        <th width="106" bgcolor="#06327D" class="CONT"><span class="Estilo17">Estado Equipo</span></th>
        <th width="106" bgcolor="#06327D" class="CONT"><span class="Estilo17 Estilo13 Estilo15">Devolver<span class="Estilo17">
          <?php
			 if (!empty($registro1['cod_arriendo'])){
				$sqlarr="SELECT * 
						FROM equipos_arriendo 
						where cod_arriendo = ".$registro1['cod_arriendo']." 
							and num_gd = ".$valor2."
							and estado_equipo_arr = 'NO DEVUELTO'
						order by cod_equipo ASC";
				
				$resarr = mysql_query($sqlarr) or die(mysql_error()); 
				while ($registroarr = mysql_fetch_array($resarr)) {
		 ?>
        </span></span></th>
      </tr>
      <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para seleccionar" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
        <td bgcolor="#FFFFFF"><?php echo $registroarr['cod_equipo'];?></td>
        <td bgcolor="#FFFFFF"><?php
		 if (!empty($registroarr['cod_equipo'])){
				$sql="SELECT nombre_equipo FROM equipo where cod_equipo = ".$registroarr['cod_equipo'];
				$res = mysql_query($sql) or die(mysql_error()); 
				$registroeq = mysql_fetch_array($res) ;
				echo htmlentities($registroeq['nombre_equipo']);
		  }?></td>
        <td bgcolor="#FFFFFF"><?php echo '' . $registroarr['arrendado_desde'] . ' ';?></td>
        <td bgcolor="#FFFFFF"><?php echo '' . $registroarr['arrendado_hasta'] . ' ';?></td>
        <td bgcolor="#FFFFFF"><?php echo '' . $registroarr['estado_equipo_arr'] . ' ';?></td>
        <td bgcolor="#FFFFFF"><input type="hidden" name="txt_cod_eq"  value="<?php echo $registroarr['cod_equipo']?>" size="20" maxlength="30" />     <?php if ($registroarr['estado_equipo_arr']=="NO DEVUELTO") {?>    
        
        
          <input type="submit" name="devolver" value="Devolver" title="Ingresar devolucion Equipo" style="background-image:url(images/devolver_eq.png); width:83px; height:83px;" class="formato_boton" <?php echo $estado_objetos ;?>/>
          
          
         <!--<input type="image" name="devolver" value="Devolver" title="Ingresar devolucion Equipo" src="images/devolver_eq.png" <?php echo $estado_objetos ;?>/>-->
		 
		 
		 
		 <?php } ?></td>
      </tr>
      <tr>
        <td bordercolor="#FFFFFF" class="CONT">--------------</td>
        <td height="15" bordercolor="#FFFFFF" class="CONT">------------------------------</td>
        <td bordercolor="#FFFFFF" class="CONT">----------------------</td>
        <td bordercolor="#FFFFFF" class="CONT">-----------------</td>
        <td bordercolor="#FFFFFF" class="CONT">----------------</td>
        <td bordercolor="#FFFFFF" class="CONT">------------------</td>
      </tr>
      <?php
				}
			 
				mysql_free_result($res);
				mysql_close($link);}
		 ?>
         <?php
			//envia el nombre
			if (($_POST['devolver']=='Devolver'))
			{
				$busca_cod=$_POST['txt_obra'];
				$cod_arr  =$_POST['txt_codigo'];
				echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=devolucion.php?id=$busca_cod&cod_arr=$cod_arr'>";
			}
			?>
   </table></td>
  </tr>
</table>
      </form></td>
    </tr>
  </table>
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>