<?php ob_start(); 
session_start(); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
require_once('classes/tc_calendar.php');

include("classes/conex.php");

$link = Conectarse();
$sql_bgd = "select * 
			from gd
				inner join clientes
					on clientes.cod_cliente = gd.cod_cliente
			where (gd.num_gd like '".$_GET['txt_gd']."' ) 
				or (gd.num_gd like '".$_POST['txt_gd']."')";
$respuesta_bgd = mysql_query($sql_bgd,$link) or die(mysql_error());
$temp_gd = "";
if (mysql_num_rows($respuesta_bgd)>0){
	if (!empty($_GET['txt_gd'])) {
		$temp_gd = $_GET['arr_gd'].",".$_GET['txt_gd'];
		}
	if ((!empty($_POST['txt_gd']))&&(empty($_GET['txt_gd']))) {
		$temp_gd = $_POST['arreglo_gd'].",".$_POST['txt_gd'];
		}
	}
else{
	if (!empty($_GET['txt_gd'])) {
		$temp_gd = $_GET['arr_gd'];
		}
	if ((!empty($_POST['txt_gd']))&&(empty($_GET['txt_gd']))) {
		$temp_gd = $_POST['arreglo_gd'];
		}
	}	
	$arr_gd = explode(',',$temp_gd);
	// 1--,1,2,3,4,5,5,6,2,9
	// 1,0--,2,3,4,5,5,6,2,9
	// 1,0,2--,3,4,5,5,6,2,9
	// 1,0,2,3--,4,5,5,6,0,9
	// 1,0,2,3,4--,5,5,6,0,9
	// 1,0,2,3,4,5--,5,6,0,9
	// 1,0,2,3,4,5,0--,6,0,9
	
	for($i=0;$i<count($arr_gd);$i++){
		for($j=0; $j<count($arr_gd);$j++){
			if ($i<>$j){
				if (($arr_gd[$i]==$arr_gd[$j])||($arr_gd[$j]=='')){
					$arr_gd[$j] = 0;
					}
				}
			}
		}
	
	for($k=0;$k<count($arr_gd);$k++){
		if ($arr_gd[$k]==0){
			unset($arr_gd[$k]);
			}
		}
	
	$arr_gd = implode(",", $arr_gd);

function mensaje(){
		echo "<script>
		alert('Ingrese Numero de Factura, Guia de Despacho y Fecha de Emision');
		</script>";
		 echo "<script language=Javascript> location.href=\"factura.php\"; </script>";	
	}
function mensaje2(){
		echo "<script>
		alert('Seleccione Repuesto e ingrese Cantidad');
		</script>";
		 echo "<script language=Javascript> location.href=\"factura.php\"; </script>";	
	}

function utf8_decode_1($string, $strip_zeroes = false) {
	$pos = 0;
	$len = strlen($string);
	$result = '';
 
	while ($pos < $len) {
		$code1 = ord($string[$pos++]);
		if ($code1 < 0x80) {
			$result .= chr($code1);
		} elseif ($code1 < 0xE0) {
			// Two byte
			$code1 = 0x1F & $code1;
			$code2 = 0x3F & ord($string[$pos++]);
			$res_code1 = $code1 >> 2;
			if ($res_code1 > 0 || $strip_zeroes) {
				$result .= chr($res_code1);
			}
			$result .= chr( ($code1 << 6) | $code2);
		} elseif ($code1 < 0xF0) {
			// Three byte
			$code1 = $code1; // No need to mask
			$code2 = 0x3F & ord($string[$pos++]);
			$code3 = 0x3F & ord($string[$pos++]);
			$res_code1 = chr( ($code1 << 4) | ($code2 >> 2));
			if ($res_code1 > 0 || $strip_zeroes) {
				$result .= chr($res_code1);
			}
			$result .= chr( ($code2 << 6) | $code3);
		}
	}
 
	return $result;
}

function PHP_slashes($string,$type='add') {
    if ($type == 'add')    {
        if (get_magic_quotes_gpc())        {
            return $string;
        }
        else        {
            if (function_exists('addslashes'))            {
                return addslashes($string);
            }
            else            {
                return mysql_real_escape_string($string);
            }
        }
    }
    else if ($type == 'strip')    {
        return stripslashes($string);
    }
    else    {
        die('error in PHP_slashes (mixed,add | strip)');
    }
}
function reverse_escape($str){
  $search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
  $replace=array("\\","\0","\n","\r","\x1a","'",'"');
  return str_replace($search,$replace,$str);
}

if ($_POST['buscar']=='Buscar') 	{   
	if (empty($_POST['txt_rut']))	{  
		$link=mensaje();
		} 
	}


if ($_POST['borrar']=='Borrar') { 
	
	 $link        = Conectarse();
	 $num_factura = $_POST['txt_factura'];    	             
	 $sqlelim     = "SELECT * from factura WHERE num_factura ='$num_factura'";
	
	 $reselim      = mysql_query($sqlelim,$link) or die(mysql_error()); 
	 $registroelim = mysql_fetch_array($reselim);
	 if (($registroelim['estado']=="CERRADA")or($registroelim['estado']=="NULA"))
	 {
		if ($registroelim['estado']=="CERRADA")echo "<script> alert (\"Factura no puede ser Modificada.\"); </script>";
		if ($registroelim['estado']=="NULA")echo "<script> alert (\"Factura se encuentra NULA.\"); </script>";															
	 }else{	
		$num_factura  = $_POST['txt_factura']; 
		
		$codigo_det  = trim($_POST['txt_codrepuesto']);
		$sqlelim     = "DELETE FROM det_factura WHERE cod_repuesto = '$codigo_det' and num_factura = '$num_factura'";
		
		 $res     = mysql_query($sqlelim) or die(mysql_error()); 
		 echo "<script language=Javascript> location.href=\"factura.php?num_fact=".$num_factura."\"; </script>";	
		
	 }
 }   

$valor2 = $_POST["OK"];
if ($_POST['OK']=='Guardar y Seguir'){
		$num_factura    = $_POST['txt_factura'];    	               // echo "$num_factura <br>";
		$rut 			= $_POST['txt_rut'];
		$fecha          = $_POST['cal-field-1'];              // echo "$fecha<br>";
		$cond_venta 	= $_POST['txt_condicenv'];
	if (empty($num_factura)or(empty($rut)or(empty($fecha)))){  
		$link=mensaje();
	} else {
		$gd = $_POST['txt_gd'];
		$cod_cliente = $_POST['txt_cod'];
		$cod_obra = $_POST['selecobra'];
		$observaciones_fact = $_POST['arreglo_gd'];
		$oc = $_POST['txt_oc'];
		$link=Conectarse();
		
		$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
		$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
		$registroiva = mysql_fetch_array($resiva);
		$valor_iva = $registroiva['valor_iva'];
		
		$fecha_temp = explode("-",$_POST['cal-field-1']);
		//$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   
		$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
		$fecha = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
		$hora_actual = date("H:i:s");
		$fecha_actual = date("Y-m-d");
		$sqlf        = "SELECT * from factura WHERE num_factura ='$num_factura'";
		
		$resf        = mysql_query($sqlf,$link) or die(mysql_error()); 
		$registrof   = mysql_fetch_array($resf);
		if (($registrof['estado']=="CERRADA")or($registrof['estado']=="NULA")) {
			if ($registrof['estado']=="CERRADA")
				echo "<script> alert (\"Factura no puede ser Modificada.\"); </script>";
			if ($registrof['estado']=="NULA")
				echo "<script> alert (\"Factura se encuentra NULA.\"); </script>";															
		}else{	
			$existe=$registrof['num_factura'];
			if ((empty($registrof['estado']))and(empty($existe))) {
					//buscar guia despacho repuestos
					$sqlgdfact   = "SELECT gd_rep,cod_cliente,num_factura 
									from factura 
									WHERE gd_rep ='$gd'";
					$resgdfact   = mysql_query($sqlgdfact,$link) or die(mysql_error()); 
					$registrogdf = mysql_fetch_array($resgdfact);		
					$guia_factura= $registrogdf['gd_rep'];
					
					//buscar guia despacho arriendos
						$sqlgdfact   = "SELECT num_gd from arriendo WHERE num_gd ='$gd'";
						$resgdfact   = mysql_query($sqlgdfact,$link) or die(mysql_error()); 
						$registrogdf = mysql_fetch_array($resgdfact);
						$guia_arriendo= $registrogdf['num_gd'];
					
					if (!empty($guia_factura)){
						echo "<script> alert (\"Debe ingresar otra GD. GD facturada\"); </script>";
						}
					else if(!empty($guia_arriendo)) {
						echo "<script> alert (\"Debe ingresar otra GD. GD de arriendo\"); </script>";
					}else{
						//ingresar datos de la factura				
						$sql_001  = "insert into factura (num_factura,cod_cliente,cod_obra,fecha,gd_rep,oc_rep,valor_iva,estado,observaciones,cond_venta) values ('$num_factura','$cod_cliente','$cod_obra','$fecha','$gd','$oc','$valor_iva','CERRADA','".htmlspecialchars_decode($observaciones_fact)."','$cond_venta')";
						//echo "<br />";
						$res_001  = mysql_query($sql_001,$link) or die(mysql_error());
						$cantidad_arr 	= $_POST['cantidad_detalle'];
						$nro = count($cantidad_arr);
						$descr_arr		= $_POST['detalle'];
						$valor_u_arr	= $_POST['valor_unitario'];
						for($i=0; $i<$nro; $i++){
							$total_temp = $cantidad_arr[$i] * $valor_u_arr[$i];
							$temp = htmlspecialchars_decode($descr_arr[$i]);
							$temp = str_replace('Ã', "Ñ",$temp);
							$sql_temp = "insert into det_factura(num_factura, cantidad, otros_reparacion, valor_unitario, total_rep) values ('".$num_factura."','".$cantidad_arr[$i]."', '". $temp."','".$valor_u_arr[$i]."','".$total_temp."')";
							//echo "<br />";
							$res_temp = mysql_query($sql_temp,$link) or die(mysql_error());
							}
																	
						mysql_query("insert into transacciones (fecha, hora, usuario, tipo_documento, folio)  values('$fecha_actual','$hora_actual','$usuario','$tipo_doc','$num_factura')",$link);	
						echo "<script> alert (\"Proceso realizado con Exito\"); </script>";
						echo "<script language=Javascript> location.href=\"facturar.php?nro_factura=".$num_factura."\"; </script>";
					}
				}	
			}
		}
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


<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
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
.Estilo24 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
<link rel="shortcut icon" href="http://intranet.gescolcl_vigomaq_beta.cl/favicon.ico">
<style type="text/css">
.Estilo241 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
</style>
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css"/>

<script language="JavaScript">
function verifica_rut(c){var r=false,d=c.value,t=d.replace(/\b[^0-9kK]+\b/g,'');if(t.length==8){t=0+t;};if(t.length==9){var a=t.substring(t.length-1,-1),b=t.charAt(t.length-1);if(b=='k'){b='K'};if(!isNaN(a)){var s=0,m=2,x='0',e=0;for(var i=a.length-1;i>=0;i--){s=s+a.charAt(i)*m;if(m==7){m=2;}else{m++;};}var y=s%11;if(y==1){x='K';}else{if(y==0){x='0';}else{e=11-y;x=e+'';};};if(x==b){r=true;c.value=a.substring(0,2)+'.'+a.substring(2,5)+'.'+a.substring(5,8)+'-'+b};}}return r;};
</script>
<script language="JavaScript">
<!--
var nav4 = window.Event ? true : false;
function acceptNum(evt){	
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
	var key = nav4 ? evt.which : evt.keyCode;	
	return (key <= 13 || (key >= 48 && key <= 57));
}
function irLink(valor,arr_gd){
	location.href="factura.php?txt_gd="+valor+"&arr_gd="+arr_gd;
	}
function verificar(){
		var frase = document.getElementById('txt_oc').value;
		//frase = frase.replace(/[^a-zA-Z 0-9.]+/g,' ');
		document.getElementById('txt_oc').value = frase;
	}


/**********************************************
LOGIN
**********************************************/
function checkRutGenerico(campo, isEmpresa)
{
var tmpstr = "";
rut = campo.value;
for ( i=0; i < rut.length ; i++ )
if ( rut.charAt(i) != ' ' && rut.charAt(i) != '.' && rut.charAt(i) != '-' )
tmpstr = tmpstr + rut.charAt(i);
rut = tmpstr;
largo = rut.length;
tmpstr = "";
for ( i=0; rut.charAt(i) == '0' ; i++ );
for (; i < rut.length ; i++ )
tmpstr = tmpstr + rut.charAt(i);
rut = tmpstr;
largo = rut.length;
if ( largo < 2 )
{
alert("Debe ingresar el RUT completo.");
campo.focus();
campo.select();
return false;
}
for (i=0; i < largo ; i++ )
{
if( (rut.charAt(i) != '0') && (rut.charAt(i) != '1') && (rut.charAt(i) !='2') && (rut.charAt(i) != '3') && (rut.charAt(i) != '4') && (rut.charAt(i) !='5') && (rut.charAt(i) != '6') && (rut.charAt(i) != '7') && (rut.charAt(i) != '8') && (rut.charAt(i) != '9') && (rut.charAt(i) !='k') && (rut.charAt(i) != 'K') )
{
alert("El valor ingresado no corresponde a un RUT valido.");
campo.focus();
campo.select();
return false;
}
}
rutMax = campo.value;
tmpstr="";
for ( i=0; i < rutMax.length ; i++ )
if ( rutMax.charAt(i) != ' ' && rutMax.charAt(i) != '.' && rutMax.charAt(i) != '-' )
tmpstr = tmpstr + rutMax.charAt(i);
tmpstr = tmpstr.substring(0, tmpstr.length - 1);
if ( (!(tmpstr < 50000000)) && (!isEmpresa) )
{
alert('El Rut ingresado no corresponde a un RUT de Persona Natural')
campo.focus();
campo.select();
return false;
}
var invertido = "";
for ( i=(largo-1),j=0; i>=0; i--,j++ )
invertido = invertido + rut.charAt(i);
var drut = "";
drut = drut + invertido.charAt(0);
drut = drut + '-';
cnt = 0;
for ( i=1,j=2; i<largo; i++,j++ )
{
if ( cnt == 3 )
{
drut = drut + '.';
j++;
drut = drut + invertido.charAt(i);
cnt = 1;
}
else
{
drut = drut + invertido.charAt(i);
cnt++;
}
}
invertido = "";
for ( i=(drut.length-1),j=0; i>=0; i--,j++ )
{
if (drut.charAt(i)=='k')
invertido = invertido + 'K';
else
invertido = invertido + drut.charAt(i);
}
campo.value = invertido;
if (!checkDV(rut))
{
alert("El RUT es incorrecto.");
campo.focus();
campo.select();
return false;
}
return true;
}
function checkDV(crut)	{
	largo = crut.length;
	if(largo < 2) {
		return false;
	}
	if(largo > 2){
		rut = crut.substring(0, largo - 1);
	}
	else {
		rut = crut.charAt(0);
	}
	dv = crut.charAt(largo-1);
	if(!checkCDV(dv))	
		return false;
	if(rut == null || dv == null){
		return false;
	}
	var dvr = '0';
	suma = 0;
	mul = 2;
	for (i= rut.length -1 ; i >= 0; i--) {
		suma = suma + rut.charAt(i) * mul;
		if(mul == 7){
			mul = 2;
		}
		else{
			mul++;
		}
	}
	res = suma % 11;
	if (res==1) {
		dvr = 'k';
	}
	else {
		if(res==0){
			dvr = '0';
		}
		else {
			dvi = 11-res;
			dvr = dvi + "";
		}
	}
	if(dvr != dv.toLowerCase()) 	{
		return false;
		}
	return true;
	}
function checkCDV(dvr)	{
	dv = dvr + "";
	if(dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k' && dv != 'K'){
		return false;
		}
	return true;
	}
//-->
</script>
<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php'); //modulo cabecera
	?>
</div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div>
    <br class="clearFloat"/>
<form action="factura.php" method="post" name="frmDatos" id="frmDatos">
<table width="90%" height="427" border="0" align="center">
    <tr>
      <td width="402"></td>
      <td width="309"  ><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13">	<?php
				function verifica_RUT($rut='') {
				  $sep = array();  $multi = 2;  $suma = 0;
				  if (empty($rut)) return 1;
				  $tmpRUT = preg_replace('/[^0-9kK]/','',$rut);
				  if (strlen($tmpRUT) == 8 ) $tmpRUT = '0'.$tmpRUT;
				  if (strlen($tmpRUT) != 9) return 2;
				  $sep['rut'] = substr($tmpRUT,0,8);
				  $sep['dv']  = substr($tmpRUT, -1);
				  if ($sep['dv'] == 'k') $sep['dv'] = 'K';
				  if (!is_numeric($sep['rut'])) return 3;
				  if (empty($sep['rut']) OR $sep['dv'] == '') return 4;
				  for ($i=strlen($sep['rut']) - 1; $i >= 0; $i--) {
					$suma = $suma + $sep['rut'][$i] * $multi;
					if ($multi == 7) $multi = 2;
					else $multi++;
				  }
				  $resto = $suma % 11;
				  if ($resto == 1) $sep['dvt'] = 'K';
				  else {
					if ($resto == 0) $sep['dvt'] = '0';
					else $sep['dvt'] = 11 - $resto;
				  }
				  if ($sep['dvt'] != $sep['dv']) return 5;
				  return 0;
				}
					$link=Conectarse();
					if (empty($num_gd)) $num_gd = $_GET['txt_gd'];
					if (empty($num_gd)) $num_gd = $_POST['txt_gd'];
					if (empty($factura)) $factura = $_GET['num_fact'];

					$sqlfact = "SELECT * from factura WHERE num_factura ='$factura'";						
					
					$resfact      = mysql_query($sqlfact,$link) or die(mysql_error()); 
					$registrofact = mysql_fetch_array($resfact);
					$fact         = $registrofact['num_factura'];
					$cod_cli      = $registrofact['cod_cliente'];
					$val_iva      = $registrofact['valor_iva'];
					$num_arriendo = $registrofact['cod_arriendo'];
					
					$sqlcliente = "SELECT rut_cliente from clientes WHERE cod_cliente ='$cod_cli'";
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registrocliente = mysql_fetch_array($rescliente);
					$valor1=$registrocliente['rut_cliente'];
					
					$sqlarriendo  = "SELECT * 
										from arriendo 
											WHERE (cod_arriendo ='$num_arriendo' 
												and num_gd = '$num_gd')
												or
												(cod_arriendo ='$num_arriendo' 
												and num_gd in (select distinct num_gd from gd where num_gd = '$num_gd'))";
					if (empty($num_arriendo)){
						$sqlarriendo="select *
										from gd
											inner join clientes
												on gd.cod_cliente = clientes.cod_cliente
										where gd.num_gd = '$num_gd'";
						}
			 	   
					$resarriendo   = mysql_query($sqlarriendo,$link) or die(mysql_error()); 
					$registroarri = mysql_fetch_array($resarriendo);
					
					if (empty($valor1)){
						$valor1 = $_GET['id'];
						if (empty($valor1)) $valor1 = $_POST['txt_rut'];
						if (empty($valor1)) $valor1 = $_GET['txt_rut'];
						if (empty($valor1)) $valor1 = $registroarri['rut_cliente'];
					    }
					
					if (empty($valor1)){

					}else{
							$link=Conectarse();
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact from clientes WHERE rut_cliente ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							if (empty($registro['rut_cliente']) && $_POST["buscar"]=="Buscar")	{
								echo "<script>
								alert('Cliente No Ingresado');
								</script>";
							}else{ 
							}
					}
			?>FACTURA </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td colspan="5" bgcolor="#06327D" height="15"><span class="Estilo7 sortable">DATOS FACTURA
        <div align="right">
          <?php  $fecha = date ("d-m-Y"); //echo($fecha);?>
      </div></span></td>
    </tr>
    <tr>
      <td height="372" colspan="2" valign="top"><?php
			if (isset($_POST['txt_rut'])) {
			  //$error = verifica_rut($_POST['txt_rut']);
			  $error = 0;
			  switch($error) {
				case 0 :   
					$rut_param = $_POST['txt_rut'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $rut_param;
					}
			
				break;
				case 1 : echo "<script> alert (\"Ingrese Rut Cliente\"); </script>"; break;
				case 2 : echo "<script>	alert (\"El Rut no cuenta con el mínimo de caracteres necesarios para validarlo\");					</script>"; break;
				case 4 : echo "<script>	alert (\"El Rut o el dígito viene vacío\");</script>"; break;
				case 5 : echo "<script>	alert (\"El Rut y el dígito no coinciden\");</script>"; break;
				default: echo "<script>	alert (\"Error\");</script>"; break;
			  }
					
			}
		?> 
        <table width="100%" border="0" align="center">
            <tr>
				<td>Guia despacho </td>
       	    <td align="left">
                	<input name="txt_gd" id="txt_gd" type="text" value="<?php 
						if (!empty($registrofact['gd_rep'])) {
							echo ($registrofact['gd_rep']);}
						else{
							if (empty($_POST['txt_gd']))
								echo($_GET["txt_gd"]) ;
							else
								echo($_POST["txt_gd"]) ;
							}?>" size="10" maxlength="10" onkeypress="return acceptNum(event)" />
             
            	<input type="submit" name="agregarGD" id="agregarGD" value="Agregar Guia Despacho" title="Agregar Guia Despacho" style="background-image:url(images/observaciones.png); width:16px; height:16px;" class="formato_boton"/>
                <input type="hidden" name="arreglo_gd" id="arreglo_gd" value="<?php echo $arr_gd;?>"/>
			  </td>
              <td width="26%">
              Guias de Despacho : <?php echo $arr_gd; ?>
              </td>
			</tr>
           <tr>
              <td width="10%"><div align="left">Rut</div></td>
              <td width="52%"><div align="left">
                <input name="txt_rut" type="text" id="rut" value="<?php 
			  if ((($registro['rut_cliente'])!= "") && (empty($registro['cod_cliente'])))
			  {		$rut_param = $registro['rut_cliente'];
					$parte4 = substr($rut_param, -1); // seria solo el numero verificador 
					$parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq  
					$parte2 = substr($rut_param, -7,3);  
					$parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq 
					if (strlen($rut_param) == 9)
					{
						$rutok = $parte1.".".$parte2.".".$parte3."-".$parte4; 
					}else{;
						$rutok = $registro['rut_cliente'];
					}
					echo ($rutok);
				}else{ 
					if (!empty($registro['rut_cliente'])) {
						echo($registro['rut_cliente']); 
					}else{ 
						
						echo ($_POST['txt_rut']);
					}
				}?>" onblur="if (this.value!='')
                				checkRutGenerico(this, true);" size="12" maxlength="12"  />
                <input type="image" name="buscar" value="Buscar" title="Buscar Cliente" class="searchbutton" src="images/ver.png"/>
                <span class="Estilo20">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['cod_cliente'];?>" />				
                </span>[11.111.111-1]</div></td>
              <td width="26%" align="right"><input name="hora" type="hidden" id="hora" value="<?php date_default_timezone_set('America/Santiago'); echo date ("g:i:s"); ?>" size="8" maxlength="8" />
                <input type="hidden" name="txt_numfact" size="20" maxlength="30" value="<?php echo($registrofact['num_factura']);?>" />
                N&deg; Factura</td>
              <td width="12%" align="right" valign="middle"><span class="Estilo241">
                <input id="txt_factura" name="txt_factura" type="text" onkeypress="return acceptNum(event)" value="<?php 
					
					$sql_num_factura     = "SELECT (COALESCE(num_factura,37750)) as ncorr
									FROM factura
														where 
											num_factura > '37750' 
									order by num_factura desc";
				 	
					$res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
					$registro_num_factura= mysql_fetch_array($res_num_factura);
					if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 37751;
						else $num_factura_nuevo = $registro_num_factura['ncorr']+1;
						
					if ($num_factura_nuevo=='') $num_factura_nuevo=1;

						$sql_filtro = "select * 
										from folios_dte
										where desde <= '".$num_factura_nuevo."' and 
												hasta >= '".$num_factura_nuevo."' and 
												tipo = 33";
						$res_filtro = mysql_query($sql_filtro,$link);
						if (mysql_num_rows($res_filtro)==0){
							$num_factura_nuevo = "Error.";
							}

                		if (!empty($registrofact['num_factura'])) {
                			echo ($registrofact['num_factura']);
                			}
                		else{
                			echo $num_factura_nuevo;
                			}
                		?>" size="10" maxlength="10" style="font-size:18px; color:red;  font-weight:bold; border:#F00 solid 2px; padding:5px"/>
              </span></td>
          </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td><input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
			{echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="75" maxlength="50" disabled="disabled"/></td>
              <td align="right">Fecha Emision</td>
              <td align="right">
                <div align="right"><input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registrofact['fecha'])) {echo ($registrofact['fecha']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha'];?>" size="10" maxlength="10" onblur='var msj = confirm("Confirme fecha de emisión de factura");
                                if (!(msj)){
                                    alert("Proceso no realizado");
                    }' />
                  <button type="submit" id="cal-button-1">...</button>
                  <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
                  </script>
                </div></td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td><div align="left">
                <input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
			{echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="75" maxlength="50" disabled="disabled"/>
              </div>
              </td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
             <td ><div align="left">
               <p>
                 <input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
			{echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="75" maxlength="50" disabled="disabled"/>
                </p>
</div></td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td><div align="left">
                <input name="txt_ciudad" type="text" value="<?php
			   if (!empty($registro['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
						  // echo($sql3);
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?>" size="75" maxlength="50" disabled="disabled" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Comuna</div></td>
              <td><div align="left">
                <input name="txt_comuna" type="text" value="<?php
			   if (!empty($registro['cod_comuna']))
					  {
						  $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
						  // echo($sql3);
						  $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
						  $registrocom = mysql_fetch_array($rescom);
						  echo($registrocom['comuna']);
					  }else{
						  echo(" ");
					  } ; ?>" size="75" maxlength="50" disabled="disabled" />
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Tel&eacute;fono</div></td>
              <td><div align="left">
                <input name="txt_cod_area" type="text" value="<?php if (!empty($registro['cod_area'])) 
			{echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled"/>
                <input name="txt_fono" type="text" value="<?php if (!empty($registro['fono_cliente'])) 
			{echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"/>
              </div></td>
            </tr>
            <tr>
              <td><div align="left">Condiciones de Venta</div></td>
              	<td>
              		<select name="txt_condicenv" id="txt_condicenv"><?php 
			  		// $sql_num_gd = "select *
					// 				from gd
					// 				where num_gd = ".$num_gd;
					// $res_num_gd = mysql_query($sql_num_gd,$link);
					// $row_num_gd = mysql_fetch_array($res_num_gd);
			  		// 		if (!empty($row_num_gd['cond_venta'])) {
					// 			echo ($row_num_gd['cond_venta']);
					// 		}
					//	else{
				 	// 	$sql_num_gd = "select *
					// 				from factura
					// 				where num_factura = ".$num_factura;
					// 	$res_num_gd = mysql_query($sql_num_gd,$link);
					// 	$row_num_gd = mysql_fetch_array($res_num_gd);
					// 	if (!empty($row_num_gd['cond_venta'])) {
					// 		echo ($row_num_gd['cond_venta']);
					// 		}
					// 	else{
					// 		echo($_POST["txt_condicenv"]) ;
					// 		}
					// 	} 
					$sql_cond_venta = "select * from forma_pago order by cod_forma_pago asc";
					$res_cond_venta = mysql_query($sql_cond_venta,$link);
					while($row_cond_venta = mysql_fetch_array($res_cond_venta)){
					?>
						<option value="<?php echo $row_cond_venta['cod_forma_pago']?>"><?php echo $row_cond_venta['forma_pago']?> - <?php echo $row_cond_venta['forma_pago_dias']?> DIAS</option>
					<?php }?>
					</select>

				</td>
            </tr>
            <tr>
              <td>Orden Compra</td>
              <td><input name="txt_oc" type="text" id="txt_oc" value="<? 
				  	$sql_num_oc = "select *
									from gd
									where num_gd = ".$num_gd;
					$res_num_oc = mysql_query($sql_num_oc,$link);
					$row_num_oc = mysql_fetch_array($res_num_oc);
				
				if (!empty($row_num_oc['orden_compra'])){
					echo $row_num_oc['orden_compra'];
					}
				else{
					echo($_POST["txt_oc"]) ;					
					}
					?>"  size="18" maxlength="18" onblur="verificar()" /></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td height="24">Obra/Direccion</td>
              <td><?php 
			$codigo_clie =  $registro['cod_cliente'];
			$sqlobra="SELECT cod_obra, nombre_obra, direcc_obra FROM obra where cod_cliente = '$codigo_clie'";?>
                <select name="selecobra" id="selecobra" >
                <option value="" selected="selected" nombre_obra="" cod_obra="" direcc_obra="">Seleccionar</option>
                <?php $resobra=mysql_query($sqlobra,$link) or die(mysql_error());	
        while ($rowobra = mysql_fetch_assoc($resobra)){
?>
                <option value="<?php echo $rowobra['cod_obra'] ?>"><?php echo iconv("UTF-8", "UTF-8//IGNORE",utf8_decode(($rowobra['nombre_obra']))).'  -  '.iconv("UTF-8", "UTF-8//IGNORE",utf8_decode(($rowobra['direcc_obra']))); ?></option>
                <?php 
}
?>
              </select>
              <input  name="txt_codcli" type="hidden" value="<?php if (!empty($registrofact['cod_cliente'])) {echo ($registrofact['cod_cliente']);}else{echo($_POST["txt_codcli"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td height="66">&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3" align="right">
              	<input type="submit" name="OK" id="OK" value="Guardar y Seguir" title="Guardar Factura" style="background-image:url(images/guardar.png); width:45px; height:45px; display:none" class="formato_boton" onclick='var msj = confirm("Confirme fecha de emisión de factura");
                                if (!(msj)){
                                    alert("Proceso no realizado");
                    }'  />
                <a href="factura.php" class="menulink">
                    <input type="submit" name="Limpiar" value="Limpiar" title="Limpiar" style="background-image:url(images/clean.png); width:64px; height:64px;" class="formato_boton"/>
                </a>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" align="center">
          <tr>
            <td colspan="5" bgcolor="#06327D" height="15"><span class="Estilo7 sortable">AGREGAR DETALLE</span></td>
          </tr>
          <tr class="sortable">
            <th>Cantidad</th>
            <th>Servicio / Producto</th>
            <th>Descripcion</th>
           	<th>Valor Unitario</th>
            <th colspan="2">Agregar</th>
          </tr>
          <tr class="sortable">
            <th valign="top"><input name="cantidad_detalle_previo" id="cantidad_detalle_previo" type="text"  class="validate[required,custom[number]]" value="0"/></th>
            <th><textarea name="detalle_previo_1" cols="40" rows="5" id="detalle_previo_1" class="" ></textarea></th>
            <th><textarea name="detalle_previo_2" cols="80" rows="5" id="detalle_previo_2" class="" ></textarea></th>
            <th valign="top"><input name="valor_unitario_detalle_previo" id="valor_unitario_detalle_previo" type="text" class="validate[required,custom[number]]" value="0" /></th>
            <th align="right" valign="top">
            	<a href="#" id="agregar-fila">
                	<img title="Agregar Repuesto a Factura" src="images/guardar.gif" style="width:46px; height:52px;" class="formato_boton" />
                </a>
              <input type="hidden" name="txt_cod2" size="20" maxlength="30" />
              <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
          </tr>
        </table>
          <table id="tabla-pre" width="100%" border="0" align="center">
              <tr class="sortable">
                <th width="20%" bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
                <th width="37%" bgcolor="#06327D"><div align="center" class="Estilo17">Detalle</div></th>
                <th width="14%" bgcolor="#06327D"><div align="center" class="Estilo17">Valor Unitario</div></th>
                <th width="14%" bgcolor="#06327D"><div align="center" class="Estilo17">Total</div></th>
                <th width="15%" bgcolor="#06327D">
                  <span class="Estilo17 Estilo13 Estilo15">Quitar</span></th>
            </tr>
          <?php
			if (empty($_GET["num_fact"])||(empty($_POST["txt_factura"]))) $fact=0; 
			if (!empty($_GET["num_fact"])) $fact=$_GET["num_fact"];
			if (!empty($_POST["txt_factura"])) $fact=$_POST["txt_factura"];
			if (!empty($_GET['txt_gd'])) { $fact=$_GET["txt_gd"];}
			if (!empty($_POST['txt_gd'])){ $fact=$_POST["txt_gd"];}

			if ($fact > 0){
				$sqldet="SELECT * FROM  det_factura where num_factura = ".$fact." order by cod_repuesto ASC";
			if (!empty($_POST['txt_gd'])){
					$arr_gd = str_replace(",,",",",$arr_gd);
					$arr_gd = "(".$arr_gd.")";
					$arr_gd = str_replace("(,","",$arr_gd);
					$arr_gd = str_replace(",)","",$arr_gd);
					$arr_gd = str_replace("(","",$arr_gd);
					$arr_gd = str_replace(")","",$arr_gd);
					$sqldet="SELECT * FROM  det_gd where num_gd in (".$arr_gd.") order by cod_equipo ASC";
				}
				elseif (empty($_GET["num_fact"])&&(empty($_POST['txt_gd'])) && (empty($_POST['txt_factura'])) ){
					$arr_gd = str_replace(",,",",",$arr_gd);
					$arr_gd = "(".$arr_gd.")";
					$arr_gd = str_replace("(,","",$arr_gd);
					$arr_gd = str_replace(",)","",$arr_gd);
					$arr_gd = str_replace("(","",$arr_gd);
					$arr_gd = str_replace(")","",$arr_gd);
					$sqldet="SELECT * FROM  det_gd where num_gd in (".$arr_gd.") order by cod_equipo ASC";
				}
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
          <tr bordercolor="#FFFFFF" class="sortable">
          	
            <td align="left"><?php 
				echo($registrodet['cantidad']);?>
                <input type="hidden" id="cantidad_detalle" name="cantidad_detalle[]" value="<?php echo($registrodet['cantidad']);?>"/>
           	</td>
            <td align="left"><?php 
					$sqlnomrep="SELECT nombre_equipo, accesorios, cod_motor FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
					$resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
					$registronrep = mysql_fetch_array($resnomrep);
					$detalle="";
					if ($registrodet['observaciones']==''){
						$detalle .= 'ARRIENDO DE ';
						}
					else{
						$detalle .= $registrodet['observaciones']." ";
						}
					$detalle .= (utf8_decode($registronrep['nombre_equipo']));
					if($registronrep['cod_motor'] > 1){
						$detalle .= ' , C/MOTOR N. '.$registronrep['cod_motor'];
						}
					//incluye accesorio
					if($registrodet['accesorio'] == 1){
						$detalle .= ' , '.$registronrep['accesorios'];
						}
					echo (htmlspecialchars_decode($detalle));
			 ?>
             <input type="hidden" id="detalle" name="detalle[]" value="<?php echo (utf8_encode($detalle)); ?>"/>
            </td>
            <td align="right"><?php 
				if (!empty($registrodet['valor_unitario'])){
	   			  	$temp_valor = "$".number_format($registrodet['valor_unitario'], 0, ",", ".");
					}
				else{
	   			  	$temp_valor = "$".number_format($registrodet['precio'], 0, ",", ".");
					}
				echo $temp_valor;
			  ?>
              <input type="hidden" id="valor_unitario" name="valor_unitario[]" value="<?php 
			  	if (!empty($registrodet['valor_unitario'])){
	   			  	echo $registrodet['valor_unitario'];
					}
				else{
	   			  	echo $registrodet['precio'];
					}?>"/>
           	</td>
            <td align="right">
				<?php 
					if ($registrodet['cod_equipo']>0){
						$temp_valor = "$".number_format($registrodet['precio']*$registrodet['cantidad'], 0, ",", ".") ; 
						$costo_tot= $costo_tot + ($registrodet['precio']*$registrodet['cantidad']); 
					}else{ 
						if (!empty($registrodet['total_rep'])){
							$temp_valor = ("$".number_format($registrodet['total_rep']*$registrodet['cantidad'], 0, ",", ".")); 
							$costo_tot= $costo_tot + ($registrodet['total_rep']*$registrodet['cantidad']);
							}
						else{
							$temp_valor = ("$".number_format($registrodet['precio']*$registrodet['cantidad'], 0, ",", ".")); 
							$costo_tot= $costo_tot + ($registrodet['precio']*$registrodet['cantidad']);
							}
						} 
					echo $temp_valor;
				?>
                <input type="hidden" id="total_detalle" name="total_detalle[]" value="<?php echo $registrodet['precio']*$registrodet['cantidad']?>"/>
            </td>
            <td align="center" bgcolor="#FFFFFF"><input type="hidden" name="txt_codrepuesto"  value="<?php echo $registrodet['cod_repuesto']?>" size="20" maxlength="30" />
              <input type="submit" name="borrar" value="Borrar" title="Eliminar de la factura" onclick="elimina=confirm('�Esta seguro de que quiere eliminar?');return elimina;" style="background-image:url(images/error.png); width:16px; height:16px;" class="formato_boton"/>
            </td>
          </tr>
                    <?php
				}
				mysql_free_result($resdet);
				mysql_close($link); 
			}
		 ?>
        </table>
        <table width="100%" border="0" align="center">
          <tr class="sortable">
            <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
            <td class="CONT"></td>
            <td class="CONT">&nbsp;</td>
            <td align="right" class="CONT"><?php
								echo ("<div id='neto'>NETO: $".number_format($costo_tot, 0, ",", ".")."</div>");
		 ?>
              <input type="hidden" name="txt_sumcosto" id="txt_sumcosto"  value="<?php echo number_format($costo_tot, 0, ",", "")?>" size="20" maxlength="30" /></td>
            <td class="CONT">&nbsp;</td>
          </tr>
          <tr>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8" align="right"><span class="CONT">
              <?php
				if (empty($val_iva)){
					$link=Conectarse();
					$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
					$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
					$registroiva = mysql_fetch_array($resiva);
					$valor_iva = $registroiva['valor_iva'];
				}else{
					$valor_iva = $val_iva;
				}
				$iva = $costo_tot * ($valor_iva/100);
				
				echo ("<div id='iva'>IVA : $".number_format($iva, 0, ",", ".")."</div>");
		 ?>
              <input type="hidden" name="txt_iva" id="txt_iva"  value="<?php echo number_format($iva, 0, ",", "")?>" size="20" maxlength="30" />
            </span></td>
            <td height="8"></td>
          </tr>
          <tr>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8" align="right"><span class="CONT">
              <?php
				$total = $costo_tot + $iva;
				
				echo ("<div id='total'>TOTAL : $".number_format($total, 0, ",", ".")."</div>");
		 ?>
              <input type="hidden" name="total" id="total"  value="<?php echo number_format($total, 0, ",", "")?>" size="20" maxlength="30" />
            </span></td>
            <td height="8"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</form>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/languages/jquery.validationEngine-es.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
	var i =0;
	$(document).ready(function(){
		$("#vista-previa-factura").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});
		$('#agregar-fila').live('click',function(){
			var cantidad_detalle_previo = $("#cantidad_detalle_previo").val(); 
			var detalle_previo = $("#detalle_previo_1").val()+ '//'+$("#detalle_previo_2").val();
			detalle_previo = detalle_previo.replace(/\"/g, ' plg. ');
			var valor_unitario_detalle_previo = $("#valor_unitario_detalle_previo").val();
			var total_detalle_previo = cantidad_detalle_previo * valor_unitario_detalle_previo;
			$('#tabla-pre').hide();
			$('#tabla-pre').append('<tr id="linea_'+i+'"><td>'+cantidad_detalle_previo+'<input type="hidden" id="cantidad_detalle" name="cantidad_detalle[]" value="'+cantidad_detalle_previo+'"/></td><td>'+detalle_previo+'<input type="hidden" id="detalle" name="detalle[]" value="'+detalle_previo+'"/></td><td align="right">$'+valor_unitario_detalle_previo+'<input type="hidden" id="valor_unitario" name="valor_unitario[]" value="'+valor_unitario_detalle_previo+'"/></td><td align="right">$'+total_detalle_previo+'<input type="hidden" id="total_detalle" name="total_detalle[]" value="'+total_detalle_previo+'"/></td><td align="center"><a href="#" onclick="borrarFila('+i+'); return false"><img src="images/error.png" title="Borrar" /></a></td></tr>');
			$('#tabla-pre').show();
			i = i+1;
			/*sumar valores*/
			var neto_actual = $("#txt_sumcosto").val();
			neto_actual = parseInt(neto_actual) + parseInt(total_detalle_previo);
			$("#neto").html("NETO : $"+neto_actual);
			document.getElementById('txt_sumcosto').value = neto_actual;

			var iva_actual = neto_actual*(0.19);
			$("#iva").html("IVA : $"+iva_actual);
			document.getElementById('txt_iva').value = iva_actual;
			
			var total_actual = neto_actual*(1.19);
			$("#total").html("TOTAL : $"+total_actual);
			document.getElementById('total').value = total_actual;
			
		});
	});
	function borrarFila(indice){
		var total_detalle_previo = $("#linea_" + indice + " #total_detalle").val();
		$("#linea_" + indice).remove();
		/*restar valores*/
		var neto_actual = $("#txt_sumcosto").val();
		neto_actual = parseInt(neto_actual) - parseInt(total_detalle_previo);
		$("#neto").html("NETO : $"+neto_actual);
		document.getElementById('txt_sumcosto').value = neto_actual;

		var iva_actual = neto_actual*(0.19);
		$("#iva").html("IVA : $"+iva_actual);
		document.getElementById('txt_iva').value = iva_actual;
		
		var total_actual = neto_actual*(1.19);
		$("#total").html("TOTAL : $"+total_actual);
		document.getElementById('total').value = total_actual;
		}
</script>
<script>
	$(document).ready(function() {
		$("#frmDatos").validationEngine({
			validationEventTriggers:"keyup blur"
			});
		$("#txt_factura").bind('blur',function() {
		    var num_gd = $("#txt_factura").val();
		      $.ajax({
		        url:'classes/facturar/buscar-factura.php?num_gd='+num_gd,
		        success: function(data){
		          if (data=='1'){
		            alert("Folio Existente");
		            document.getElementById('txt_factura').focus();
		            } 
		          if (data=='2'){
		            alert("Folio fuera de rango");
		            document.getElementById('txt_factura').focus();
		            }
		          if (data=='3'){
		            alert("Folio fuera de rango sugerido");
		            document.getElementById('txt_factura').focus();
		            }
		          }
		      });
		      //location.href="gd.php?num_gd="+num_gd;
		    });
		<?php if (($_POST['OK']=='Guardar y Seguir')||(!empty($_GET["num_fact"]))||(!empty($_POST["txt_factura"]))){?>
		$("#vista-previa-factura").show();
		$("#OK").show();
		<?php }?>
		$("#txt_factura").blur(function(){
			$("#OK").show();
			});
	});
</script>
	</body>
</html>
