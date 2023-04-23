<?php ob_start("ob_gzhandler"); 
session_start(); 

if(isset($_GET['nombre']))
{
	$valor_buscar = $_GET['nombre'];
}else{
	$valor_buscar = '';
}

mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
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
</style> 
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
  document.forms[0]['txt_equipo'].value = com;
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
     	   document.forms.equipo.php.value=celda;
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
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div><p>&nbsp;</p>
 <table width="700" border="0" align="center">
    <tr>
      <td>      <?php
			{
			include("conex.php");
			$link=Conectarse();
			}
		?>
		 <?php
			{
				$valor1 = $_GET["id"];

			}
		?></td>
    </tr>
    <tr>
      <td height="31"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12">
          <div align="right" class="Estilo19">
            <div align="right" class="Estilo20">EQUIPOS</div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">RESULTADOS BUSQUEDA</span></div></td>
    </tr>
    <tr>
      <td width="664" height="16" align="right"> <?php  $fecha = date ("d-m-Y"); echo($fecha);?></td>
    </tr>
    <tr>
      <td><form action="" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" height="30">
            <tr>
              <td class='mini_titulo'><div align="left"><font><strong>Equipo seleccionado :</strong></font></div></td>
              <td  class='mini_titulo'><font>
                <input type="hidden" name="txt_cod"> <input name="txt_equipo" type="text" size="40" maxlength="40" readonly="readonly" />
              </font> </td>
              <td valign="bottom"><div align="left">
                <input type="submit" name="OK" value="Guardar y Seguir" title="Seleccionar y Volver" style="background-image:url(images/maquinarias_volver_ico.png); width:40px; height:40px;" class="formato_boton" />
                
                <!--<input name="OK" type="image" class="boton" title="Seleccionar y Volver" value="Guardar y Seguir"  src="images/maquinarias_volver.png" align="left" width="30"  height="30"/>-->
              </div></td>
            </tr>
          </table>
        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="12%" bgcolor="#06327D"><span class="Estilo17">C&oacute;d. Equipo</span></th>
              <th width="45%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Nombre</span></th>
              <th width="32%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Fecha Entrega - Obra - Empresa</span></th>
              <th width="32%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Obra</span></th>
              <th width="32%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Empresa</span></th>
              <th width="11%" bgcolor="#06327D" class="CONT"><?php
		$codigo = "";
$txt_codigo = "";
if ($_GET["id"]!=""){
   $txt_codigo = $_GET["id"];
   if (($txt_codigo) == '0') $txt_codigo = " ";
   	$codigo = " where cod_equipo like '".trim($txt_codigo) ."%' ";

}

$nombre = "";
$txt_nombre = "";
if ($_GET["nombre"]!=""){
   $txt_nombre = $_GET["nombre"];	
   $txt_codigo = $_GET["nombre"];
   $codigo = " where cod_estado_equipo = 3 and nombre_equipo like '%" . strtoupper($txt_nombre) . "%' ";

}else{
	$codigo = "where cod_estado_equipo = 3";
}


if(isset($_GET['tipo']))
{
	$txt_nombre = $_GET["nombre"];
	$codigo = "where cod_estado_equipo = 1 and nombre_equipo like '%" . strtoupper($txt_nombre) . "%' ";
}

	$sql="SELECT * FROM vigomaq_intranet.equipo ".($codigo);
	
	//rcb
	//echo '<h1>'.$sql.'</h1>';
	
	$res=mysql_query($sql);
$numeroRegistros=mysql_num_rows($res);
if($numeroRegistros<=0)
{
    echo "<div align='center'>";
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
    echo "</div>";
}else{
    //////////elementos para el orden
    if(!isset($orden))
    {
       $orden="cod_equipo";
    }
    //////////fin elementos de orden

    //////////calculo de elementos necesarios para paginacion
    //tama&ntilde;o de la pagina
    $tamPag=5;

    //pagina actual si no esta definida y limites
    if(!isset($_GET["pagina"]))
    {
       $pagina=1;
       $inicio=1;
       $final=$tamPag;
    }else{
       $pagina = $_GET["pagina"];
    }
    //calculo del limite inferior
    $limitInf=($pagina-1)*$tamPag;

    //calculo del numero de paginas
    $numPags=ceil($numeroRegistros/$tamPag);
    if(!isset($pagina))
    {
       $pagina=1;
       $inicio=1;
       $final=$tamPag;
    }else{
       $seccionActual=intval(($pagina-1)/$tamPag);
       $inicio=($seccionActual*$tamPag)+1;

       if($pagina<$numPags)
       {
          $final=$inicio+$tamPag-1;
       }else{
          $final=$numPags;
       }

       if ($final>$numPags){
          $final=$numPags;
       }
    }

//////////fin de dicho calculo

//////////creacion de la consulta con limites
   if (($txt_codigo) == '0') $txt_codigo = " ";
	$sql="SELECT * FROM vigomaq_intranet.equipo ".$codigo." ORDER BY ".$orden.",cod_equipo ASC LIMIT ".$limitInf.",".$tamPag;

	$res=mysql_query($sql);

//////////fin consulta con limites

if(isset($txt_codigo)){
    echo "<br>Valor filtro: <b>".$txt_codigo."</b>";
}

			while ($registro = mysql_fetch_array($res)) {
		 ?>
              <span class="Estilo17 Estilo13 Estilo15">Imagen</span></th>
            </tr>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <td bgcolor="#FFFFFF">
			  <?php 
			  	  $cantidad = strlen($registro['cod_equipo']); 
				   if ($cantidad==1) { echo ("0000000".($registro['cod_equipo']));}
				   if ($cantidad==2) { echo ("000000".($registro['cod_equipo']));}
				   if ($cantidad==3) { echo ("00000".($registro['cod_equipo']));}
				   if ($cantidad==4) { echo ("0000".($registro['cod_equipo']));}
				   if ($cantidad==5) { echo ("000".($registro['cod_equipo']));}
				   if ($cantidad==6) { echo ('00'.$registro['cod_equipo']);}		
				   if ($cantidad==7) { echo ('0'.$registro['cod_equipo']);}	
				   if ($cantidad==8) { echo $registro['cod_equipo'];}	
			  
			  ?>              </td>
              <td bgcolor="#FFFFFF"><?php echo htmlentities($registro['nombre_equipo']) ;?></td>
              <td bgcolor="#FFFFFF">
              <?php
             
			  $cod_equipo =  $registro['cod_equipo'];
			  
			  $sql_ea = "SELECT *
			  				FROM equipo 
							where cod_equipo = ".$cod_equipo;
			  $res_ea = mysql_query($sql_ea) or die(mysql_error()); 
			  $registro_ea = mysql_fetch_array($res_ea);
			  		  
				if ($registro_ea['cod_estado_equipo']!=1){
					$codigo_busqueda = "";
					if ($registro_ea['cod_estado_equipo']=='3'){
						$codigo_busqueda = "and estado_equipo_arr = 'NO DEVUELTO'";
						}
					$sql_ea = "SELECT * 
								FROM equipos_arriendo
								where cod_equipo = ".$cod_equipo." ".$codigo_busqueda."
								order by arrendado_desde desc 
								limit 0,1";
					$res_ea = mysql_query($sql_ea) or die(mysql_error()); 
					$registro_ea = mysql_fetch_array($res_ea);
					
					$cod_arriendo 	= $registro_ea['cod_arriendo'];
					$arrendado_hasta 	= $registro_ea['arrendado_hasta'];
					$hora_devol 		= $registro_ea['hora_devol'];
					
					if ($arrendado_hasta=='0000-00-00'){
					  $arrendado_hasta 	= "NO DEVUELTO";
					  $hora_devol 		= "";
					  }
					
					if($cod_arriendo != '') {
						$sql_ea2 = "SELECT * FROM arriendo where cod_arriendo = ".$cod_arriendo;
						 
						$res_ea2 = mysql_query($sql_ea2) or die(mysql_error()); 
						$registro_ea2 = mysql_fetch_array($res_ea2);
						
						$rut_cliente 		= $registro_ea2['rut_cliente'];
						$cod_obra 		= $registro_ea2['cod_obra'];
						
						
						$sql_ea3 = "SELECT * FROM obra where cod_obra = ".$cod_obra;
						
						
						$res_ea3 = mysql_query($sql_ea3) or die(mysql_error()); 
						$registro_ea3 = mysql_fetch_array($res_ea3);
						
						$nombre_obra = $registro_ea3['nombre_obra'];
						
						
						$sql_ea4 = "SELECT raz_social FROM clientes where rut_cliente = '".$rut_cliente."'";
						
						
						$res_ea4 = mysql_query($sql_ea4) or die(mysql_error()); 
						$registro_ea4 = mysql_fetch_array($res_ea4);
						
						$raz_social = $registro_ea4['raz_social'];
						$salida_datos_obra = $nombre_obra.' - '.$raz_social;
						
						
						}
					else{
						$salda_datos_obra;
						}
					
					echo $salida_datos_obra.' - '.$arrendado_hasta.' - '.$hora_devol;
					//echo '<br />';
					//echo $salida_datos_obra;
				}
				else{
					echo "Disponible";
				}
			  ?>              </td>
              <td bgcolor="#FFFFFF"><?php echo $nombre_obra; ?></td>
              <td bgcolor="#FFFFFF"><?php echo $raz_social; ?></td>
              <td align="center" bgcolor="#FFFFFF"><?php if (!empty($registro['cod_equipo']) && is_dir('images/producto'.$registro['cod_equipo'].'/'))
					   {
					   $codproducto  = $registro['cod_equipo'];
					   $codproducto2 = $registro['cod_equipo'];
					   $codproducto2 = preg_replace("/&Ntilde;/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/&ntilde;/", "%F1", $codproducto2);	
					   $result2 = mysql_query("SELECT cod_equipo FROM vigomaq_intranet.equipo WHERE cod_equipo = '$txt_cod'" );
									
					   $row2=mysql_fetch_array($result2); 
					    echo '<div class="logo">'.'<img src="images/producto'.$codproducto2.'/thumb/foto0.thumb.jpg"></div>'; 
						}  ?></td>
            </tr>
            <tr>
              <td bordercolor="#FFFFFF" class="CONT">------------</td>
              <td bordercolor="#FFFFFF" class="CONT">----------------------------------------------</td>
              <td bordercolor="#FFFFFF" class="CONT">--------------------</td>
              <td bordercolor="#FFFFFF" class="CONT">--------------------------</td>
              <td bordercolor="#FFFFFF" class="CONT">------------------------</td>
              <td class="CONT">----------------------</td>
            </tr>
			<?php
				}
           ?>
             <?php
			function mensaje()
				{
					echo "<script>
					alert('Seleccione al menos un Equipo');
					</script>";
				}
		  ?>
          <?php   
		 $link=Conectarse();
		  if ($_POST['OK']=='Guardar y Seguir')
		 {
		
		   $codigo       = trim($_POST['txt_cod']);  
		        
				if(isset($_GET['tipo'])){
					//reemplazo
					$id1 = $_GET['id1'];
					
				echo "<script language=Javascript> location.href=\"reclamo.php?id=".$id1."&id2=".$codigo."\"; </script>";	
				}else{
				echo "<script language=Javascript> location.href=\"reclamo.php?id=".$codigo."\"; </script>";
				
				
				}
				
				
			} else {
				$link=mensaje();
			}
	//	 }
	?>
          </table>
         
      <br>
      <table border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center" valign="top">
		  
          
		  <?php //a partir de aqui viene la paginacion
    if($pagina>1)
    {
		if(isset($_GET['id1']))
		{
			$id1 = 	$_GET['id1'];
			echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?tipo=id2&id1=".$id1."&nombre=".$txt_nombre."&pagina=".($pagina-1)."'>";
       		echo "<font face='verdana' size='-2'>anterior</font>";
       		echo "</a> ";
			
			
		}else{
			//echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&id=".$txt_codigo."'>";
	   		echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?nombre=".$txt_nombre."&pagina=".($pagina-1)."'>";
       		echo "<font face='verdana' size='-2'>anterior</font>";
       		echo "</a> ";
		
		}
	
       
    }

    for($i=$inicio;$i<=$final;$i++)
    {
       if($i==$pagina)
       {
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>";
       }else{
	   
	   		if(isset($_GET['id1']))
			{
				$id1 = 	$_GET['id1'];
				echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?tipo=id2&id1=".$id1."&nombre=".$txt_nombre."&pagina=".$i."'>";
          		echo "<font face='verdana' size='-2'>".$i."</font></a> ";
			
			}else{
				//echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&id=".$txt_codigo."'>";
		  		echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?nombre=".$txt_nombre."&pagina=".$i."'>";
          		echo "<font face='verdana' size='-2'>".$i."</font></a> ";
			}
	   
	   
          
       }
    }
    if($pagina<$numPags)
   {
       	if(isset($_GET['id1']))
		{
			$id1 = 	$_GET['id1'];
			echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?tipo=id2&id1=".$id1."&nombre=".$txt_nombre."&pagina=".($pagina+1)."'>";
       		echo "<font face='verdana' size='-2'>siguiente</font></a>";
		
		}else{
			//echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&id=".$txt_codigo."'>";
	   		echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?nombre=".$txt_nombre."&pagina=".($pagina+1)."'>";
       		echo "<font face='verdana' size='-2'>siguiente</font></a>";
		
		}	   
	   
   }
//fin de la paginacion

}
?></td>
        </tr>	
         
      </table>


      </form><a href="javascript:history.back()" onmouseover="Volver"><img src="images/volver.png" width="40" height="40" align="right" border="0" /></a></td>
    </tr>
  </table>
  <br />
</div>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>