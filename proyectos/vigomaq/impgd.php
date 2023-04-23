<?php 
ob_start(); 
session_start(); 
//conectamos a la base de datos 
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

<SCRIPT LANGUAGE="JavaScript">
function cerrar() { setTimeout(window.close,1); }
</SCRIPT>
<script language="javascript">
function Imprimir(){
	window.print();
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
.Estilo24 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
td{
	padding:3px;
	}
body{
	width:925px;
	}
</style>

<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">

<link rel="stylesheet" type="text/css" href="styles_menu.css" />
  </head>
<?php
if(isset($_GET['imprimir']))
{
	?>
	<body onLoad='javascript:cerrar(); visibility:hidden();' >
	<?php
}else
{
	?>
	<body onLoad='javascript:Imprimir();javascript:cerrar(); visibility:hidden();' >
	<?php

}
?>
<p>
  <span class="Estilo13">
  <?php
				{
					include("conex.php");
					$link=Conectarse();
				}
			 ?>
	  <?php 
        $numeros =    array("-", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve");
        $numerosX =   array("-", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve");
        $numeros100 = array("-", "ciento", "doscientos", "trecientos", "cuatrocientos", "quinientos", "seicientos", "setecientos", "ochocientos", "novecientos");
        $numeros11 =  array("-", "once", "doce", "trece", "catorce", "quince", "dieciseis", "diecisiete", "dieciocho", "diecinueve");
        $numeros10 =  array("-", "-", "-", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa");
 
        function tresnumeros($n, $last) {
            global $numeros100, $numeros10, $numeros11, $numeros, $numerosX;
            if ($n == 100) return "cien ";
            if ($n == 0) return "cero ";
            $r = "";
            $cen = floor($n / 100);
            $dec = floor(($n % 100) / 10);
            $uni = $n % 10;
            if ($cen > 0) $r .= $numeros100[$cen] . " ";
 
            switch ($dec) {
                case 0: $special = 0; break;
                case 1: $special = 10; break;
                case 2: $special = 20; break;
                default: $r .= $numeros10[$dec] . " "; $special = 30; break;
            }
            if ($uni == 0) {
                if ($special==30);
                else if ($special==20) $r .= "veinte ";
                else if ($special==10) $r .= "diez ";
                else if ($special==0);
            } else {
                if ($special == 30 && !$last) $r .= "y " . $numerosX[$n%10] . " ";
                else if ($special == 30) $r .= "y " . $numeros[$n%10] . " ";
                else if ($special == 20) {
                    if ($uni == 3) $r .= "veintitr�s ";
                    else if (!$last) $r .= "veinti" . $numerosX[$n%10] . " ";
                    else $r .= "veinti" . $numeros[$n%10] . " ";
                } else if ($special == 10) $r .= $numeros11[$n%10] . " ";
                else if ($special == 0 && !$last) $r .= $numerosX[$n%10] . " ";
                else if ($special == 0) $r .= $numeros[$n%10] . " ";
            }
            return $r;
        }
 
        function seisnumeros($n, $last) {
            if ($n == 0) return "cero ";
            $miles = floor($n / 1000);
            $units = $n % 1000;
            $r = "";
            if ($miles == 1) $r .= "mil ";
            else if ($miles > 1) $r .= tresnumeros($miles, false) . "mil ";
            if ($units > 0) $r .= tresnumeros($units, $last);
            return $r;
        }
 
        function docenumeros($n) {
            if ($n == 0) return "cero ";
            $millo = floor($n / 1000000);
            $units = $n % 1000000;
            $r = "";
            if ($millo == 1) $r .= "un mill�n ";
            else if ($millo > 1) $r .= seisnumeros($millo, false) . "millones ";
            if ($units > 0) $r .= seisnumeros($units, true);
            return $r;
        } 
		?>
</span><span class="Estilo13">
<?php
					if (empty($guia)) $guia = $_GET['num_gd'];
					$link=Conectarse();
					$sqlguia = "SELECT * FROM vigomaq_intranet.gd WHERE num_gd ='$guia'";						
					
					$resguia = mysql_query($sqlguia,$link) or die(mysql_error()); 
					$registroguia = mysql_fetch_array($resguia);
					$gd       =$registroguia['num_gd'];
					$cod_cli  =$registroguia['cod_cliente'];
					
					$sqlcliente = "SELECT rut_cliente FROM vigomaq_intranet.clientes WHERE cod_cliente ='$cod_cli'";
					$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
					$registrocliente = mysql_fetch_array($rescliente);
					$valor1=$registrocliente['rut_cliente'];
			?>
<?php
				{
					if (empty($valor1)){
					$valor1 = $_GET['id'];
				    if (empty($valor1)) $valor1 = $_POST['txt_rut'];
					if (empty($valor1)) $valor1 = $_GET['txt_rut'];
				
				    }
					
					if (empty($valor1)){

					}else{
							$link=Conectarse();
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente, raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact FROM vigomaq_intranet.clientes WHERE rut_cliente ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							
							//actualizar estado de factura
							
							$sqlact = "UPDATE vigomaq_intranet.factura SET estado ='CERRADA' where num_factura='$factura'";
							$resact = mysql_query($sqlact) or die(mysql_error());
					
					}
				}
			?>
</span></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form method="post" name="frmDatos" id="frmDatos">
<table width="1190" border="0" id="tabla">
  <tr>
    <td width="122">&nbsp;</td>
    <td width="599">&nbsp;</td>
    <td width="108"></td>
    <td width="343" colspan="2"><?php 
	//echo '<strong>N&uacute;mero Gu&iacute;a Despacho: </strong>'.$gd.' <br /> ';
	//echo '<strong>N&uacute;mero Arriendo: </strong>'.$_GET['codarr'].' <br /> ';
	$fecha_temp = explode("-",$registroguia['fecha']);
	//año-mes-dia
	//0 -> dia, 1 -> mes, 2 -> año
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
	$dia_texto="";
	switch($dyh['mon']){
		case 1: $dia_texto = "Enero"; break;
		case 2: $dia_texto = "Febrero"; break;
		case 3: $dia_texto = "Marzo"; break;
		case 4: $dia_texto = "Abril"; break;
		case 5: $dia_texto = "Mayo"; break;
		case 6: $dia_texto = "Junio"; break;
		case 7: $dia_texto = "Julio"; break;
		case 8: $dia_texto = "Agosto"; break;
		case 9: $dia_texto = "Septiembre"; break;
		case 10: $dia_texto = "Octubre"; break;
		case 11: $dia_texto = "Noviembre"; break;
		case 12: $dia_texto = "Diciembre"; break;
		default: $dia_texto = "Error";    
	}
	
	echo $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];?></td>
  </tr>
  <tr>
    <td><br /></td>
    <td><?php echo ($registro['raz_social']);?></td>
    <td></td>
    <td colspan="2"><?php echo ($registro['rut_cliente']);?></td>
  </tr>
  <tr>
    <td><br /></td>
    <td><?php echo ($registro['direcc_cliente']);?></td>
    <td></td>
    <td colspan="2"><?php echo ($registro['giro_cliente']);?>
    <br /></td>
    </tr>
  <tr>
    <td><br /></td>
    <td><?php
			   if (!empty($registro['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
						  // echo($sql3);
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ; ?></td>
    <td></td>
    <td colspan="2"><?php 
		$sqlfpago   = "SELECT * 
					FROM vigomaq_intranet.arriendo 
						inner join gd
							on gd.id_arriendo = arriendo.cod_arriendo
					WHERE arriendo.cod_obra =".$registroguia['cod_obra']." 
						and arriendo.cod_arriendo =".$registroguia['id_arriendo'];
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registrofp= mysql_fetch_array($resfpago);
		echo $registrofp['num_oc']?></td>
    </tr>
  <tr>
    <td><br /></td>
    <td><?php 
	$sqlfpago   = "SELECT * 
					FROM vigomaq_intranet.arriendo 
						inner join gd
							on gd.id_arriendo = arriendo.cod_arriendo
					WHERE arriendo.cod_obra =".$registroguia['cod_obra']." 
						and arriendo.cod_arriendo =".$registroguia['id_arriendo'];
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registrofp= mysql_fetch_array($resfpago);
	$forma_pago = $registrofp['forma_pago'];
   
    $sqlfpago  = "SELECT * FROM vigomaq_intranet.forma_pago WHERE cod_forma_pago ='$forma_pago'";
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registropago= mysql_fetch_array($resfpago);
	
    echo($registropago['forma_pago']) ;?></td>
    <td>&nbsp;</td>
    <td colspan="2"><?php ($registro['fono_cliente']);?></td>
    </tr>
  <tr>
    <td></td>
    <td><?php 
	 $sqlobra   = "SELECT nombre_obra,direcc_obra FROM vigomaq_intranet.obra WHERE cod_obra =".$registroguia['cod_obra'];
	
	$resobra    = mysql_query($sqlobra,$link) or die(mysql_error()); 
	$registrobra= mysql_fetch_array($resobra);
    echo($registrobra['nombre_obra']) ;?></td>
    <td></td>
    <td colspan="2"><?php echo htmlentities($registrobra['direcc_obra']);?></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>Hora : </td>
    <td colspan="2"><?php echo $registrofp['hora_arr']?>&nbsp;</td>
    </tr>
  </table>
    <td width="1244"><table width="1190" height="74" border="0">
      <tr>
        <td width="145" height="15" align="center">&nbsp;</td>
        <td width="46" align="left" valign="bottom">&nbsp;</td>
        <td width="742" align="left">&nbsp;</td>
        <td width="236" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="15" align="center">&nbsp;</td>
        <td align="left" valign="bottom">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="center"><span class="Estilo17">
          <?php
		    if (empty($_GET["num_gd"])) $_GET["num_gd"]=0;
			$sqldet="SELECT * FROM  det_gd where num_gd = ".$_GET["num_gd"]." order by cod_equipo ASC";
		
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
          </span></td>
      </tr>
      <tr>
        <td height="15" align="center"><?php echo($registrodet['cantidad']); ?></td>
        <td align="left" valign="bottom">&nbsp;</td>
        <td align="left"><?php 
				  if (!empty($valor1))
					  {
						  $sqlnomrep="SELECT nombre_equipo, accesorios, cod_motor FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
						
						  $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
						  $registronrep = mysql_fetch_array($resnomrep);
						  echo 'Arriendo de ';
						  echo htmlentities($registronrep['nombre_equipo']);
						  
						  //si cod_motor > 1
						  if($registronrep['cod_motor'] > 1)
						  {
						   	//echo ' ,  INCLUYE MOTOR N. '.$registronrep['cod_motor']; 233, 134, 222
						  }
						  
						  
						  //incluye accesorio
						  if($registrodet['accesorio'] == 1)
						  {
						   	echo ' , '.$registronrep['accesorios'];
						  }
						  
						  
						  
					  }else{
						  echo(" ");
					  }
			 ?>
          <br />
          <?php echo($registrodet['observaciones']); ?></td>
        <td align="center"><?php echo("$ ".number_format($registrodet['precio'], 0, ",", ".")) ;?> + IVA</td>
      </tr>
      <?php
				}
				mysql_free_result($resdet);
				mysql_close($link); 
		 ?>
    </table>
</form>
</html>