<?php 
ob_start(); 
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
$costo_tot=0;
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
	padding:12px;
	}
#tabla-factura td{
	padding-left:10px;	
	padding-left:10px;	
	padding-top:8px;
	padding-bottom:10px;
	}
</style>

<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="styles_menu.css" />
</head>
<?php
$imprimir = $_GET['imprimir'];
if($imprimir==1) 
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
					if (empty($factura)) $factura = $_GET['num_fact'];
					$link=Conectarse();
					$sqlfact = "SELECT * FROM vigomaq_intranet.factura WHERE num_factura ='$factura'";						
					
					$resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
					$registrofact = mysql_fetch_array($resfact);
					$fact=$registrofact['num_factura'];
					$cod_cli=$registrofact['cod_cliente'];
					$fecha_factura=$registrofact['fecha'];
					$num_arriendo =  $registrofact['cod_arriendo'];
					
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
							$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente,
									 raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, 
									 nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2,
									 email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, 
									 cargo_resp3, movil_resp3, cond_env_fact 
									FROM vigomaq_intranet.clientes 
									WHERE rut_cliente ='$valor1'";
							
							
							$res = mysql_query($sql,$link) or die(mysql_error()); 
							$registro = mysql_fetch_array($res);
							
							
							//actualizar estado de factura
							
							$sqlact = "UPDATE vigomaq_intranet.factura SET estado ='CERRADA' where num_factura='$factura'";
							$resact = mysql_query($sqlact) or die(mysql_error());
					
					}
				}
			?>
</span></p>
<form method="post" name="frmDatos" id="frmDatos">
<table width="1280" id="tabla-factura" style="position:absolute; left:0px; top:125px;">
  <tr>
    <td valign="top">&nbsp;</td>
    <td width="678" valign="top">&nbsp;</td>
    <td colspan="2" align="left" valign="top"><?php 
					$fecha_temp = explode("-",$registrofact['fecha']);
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
					echo $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  ?></td>
    <td width="52" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="150" valign="top">&nbsp;</td>
    <td valign="top"><?php echo ($registro['raz_social']) ;?></td>
    <td colspan="3" align="left" valign="top"><?php echo ($registro['rut_cliente']) ;?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><?php echo ($registro['direcc_cliente']);?></td>
    <td colspan="3" align="left" valign="top"><?php 
		if (!empty($registro['cod_comuna']))
					  {
						  $sqlciu="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
						 
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['comuna']);
					  }else{
						  echo(" ");
					  } ;?>      <br /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><?php echo ($registro['giro_cliente']);?></td>
    <td colspan="3" align="left" valign="top"><?php if (!empty($registro['cod_ciudad']))
					  {
						  $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
						 
						  $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
						  $registrociu = mysql_fetch_array($resciu);
						  echo($registrociu['ciudad']);
					  }else{
						  echo(" ");
					  } ;?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">
		<?php 
		
	 	$sqlnumoc   = "		SELECT equipos_arriendo.num_gd
								FROM equipos_arriendo
									inner join gd
										on equipos_arriendo.cod_arriendo = gd.id_arriendo
									inner join factura 
										on factura.cod_arriendo = equipos_arriendo.cod_arriendo
									where equipos_arriendo.cod_arriendo =".$num_arriendo." 
										and factura.num_factura = '".$factura."'
										and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
										and equipos_arriendo.arrendado_desde <= '".$fecha_factura."'
										and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
									order by equipos_arriendo.num_gd asc
				";
	
		$resnumoc    = mysql_query($sqlnumoc,$link) or die(mysql_error()); 
		$registronumoc= mysql_fetch_array($resnumoc);
    	echo($registronumoc['num_gd']) ;
		
		?>
        
    </td>
    <td width="255" align="left" valign="top"><?php echo ($registro['fono_cliente']) ;?></td>
    <td colspan="2" align="left" valign="top" style="padding-left:50px;"><?php 
	$sqlfpago   = "SELECT forma_pago FROM vigomaq_intranet.arriendo WHERE cod_arriendo =".$registrofact['cod_arriendo'];
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registrofp= mysql_fetch_array($resfpago);
	$forma_pago = $registrofp['forma_pago'];
   
    $sqlfpago  = "SELECT * FROM vigomaq_intranet.forma_pago WHERE cod_forma_pago ='$forma_pago'";
	
	$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
	$registropago= mysql_fetch_array($resfpago);
	
    echo($registropago['forma_pago']) ;?></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">
		<div style="padding-top:-6px;">
		<?php 
	 	$sqlnumoc   = "SELECT num_oc FROM vigomaq_intranet.arriendo WHERE cod_arriendo =".$registrofact['cod_arriendo'];
	
		$resnumoc    = mysql_query($sqlnumoc,$link) or die(mysql_error()); 
		$registronumoc= mysql_fetch_array($resnumoc);
    	echo($registronumoc['num_oc']) ;?>
        </div>
      </td>
    <td align="left" valign="top">
				<div style="padding-top:-6px;">

	<?php 
	 $sqlobra   = "SELECT nombre_obra FROM vigomaq_intranet.obra WHERE cod_obra =".$registrofact['cod_obra'];
	
	$resobra    = mysql_query($sqlobra,$link) or die(mysql_error()); 
	$registrobra= mysql_fetch_array($resobra);
    echo($registrobra['nombre_obra']) ;?>
    	</div>
    </td>
    <td width="91" align="left"></td>
  </tr>
</table>
<table width="1280" border="0" height="45" style="position:absolute; left:0px; top:425px;">

<?php
		if (!empty($_GET["num_fact"])) $num_factura=$_GET["num_fact"];
			if (!empty($_POST["num_fact"])) $num_factura=$_POST["num_fact"];
			if (empty($num_factura)) $num_factura=0;
			$sqldet="SELECT * FROM  det_factura where num_factura = '$num_factura' order by cod_repuesto ASC";
			
			$resdet = mysql_query($sqldet) or die(mysql_error()); 
			while ($registrodet = mysql_fetch_array($resdet)) {
		?>
      <tr>

        <td width="188" align="center" valign="top"><?php //if (!empty($registrodet['cantidad'])) {echo($registrodet['cantidad']); }else{ echo("1");} ?>
        <?php //echo $registro['dias_arriendo'];
		
		echo $dias_arriendo = $registrodet['dias_arriendo'];
		 ?>
        </td>
        <td width="607" align="left" valign="bottom">Arriendo POR:
          
          <br/>
          <?php 
			  if (!empty($registrodet['cod_repuesto'])) {
				  if (!empty($valor1))
					  {
						  $sqlnomrep="SELECT nombre_repuesto FROM repuesto where cod_repuesto =".$registrodet['cod_repuesto'];
						 
						  $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
						  $registronrep = mysql_fetch_array($resnomrep);
						  echo($registronrep['nombre_repuesto']);
					  }else{
						  echo(" ");
					  }
			  }else{
				  if (!empty($valor1))
					  {
						  $sqlnomob="SELECT nombre_equipo FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
						 
						  $resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
						  $registronob = mysql_fetch_array($resnomob);
						
					
						  //echo((htmlentities($registronob['nombre_equipo']))." ".("ARRENDADO")." ".(($registrodet['dias_arriendo'])-($registrodet['dias_ajuste']))." ".("DIAS"));
					
						  echo htmlentities($registronob['nombre_equipo']);
						  
						  
						  //
						  
						  //BUSCAR FECHA DE ARRIENDO
				   		 $link=Conectarse();
				   		 //$sqlperiodo="SELECT * FROM equipos_arriendo where cod_arriendo ='$num_arriendo' and cod_equipo =".$registrodet['cod_equipo']." ";
						 
						 $num_arriendo = $registrofact['cod_arriendo'];
						 
						 
						 $sqlperiodo="
						SELECT *
								FROM equipos_arriendo
									inner join gd
										on equipos_arriendo.cod_arriendo = gd.id_arriendo
									inner join factura 
										on factura.cod_arriendo = equipos_arriendo.cod_arriendo
									where equipos_arriendo.cod_arriendo =".$num_arriendo." 
										and equipos_arriendo.cod_equipo =".$registrodet['cod_equipo']." 
										and factura.num_factura = '".$num_factura."'
										and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
										and equipos_arriendo.arrendado_desde <= '".$fecha_factura."'
										and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
									order by equipos_arriendo.arrendado_hasta asc
								limit 0,1
								
						 ";
						 
					/*
						 SELECT * 
						 				FROM equipos_arriendo 
						 				where cod_arriendo ='$num_arriendo' 
											and cod_equipo =".$registrodet['cod_equipo']."
											AND estado_equipo_arr LIKE  '%-FACTURADO%'
											and arrendado_hasta = '".$fecha_factura."'
											*/	 
						 
					  $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					  $registroper = mysql_fetch_array($resperiodo); 
				     if (!empty($registroper['arrendado_hasta'])){ 
					 	$hasta = $registroper['arrendado_hasta']; 
					}else{ 
						$hasta = "NO DEVUELTO";
						}
					 

 					$fecha_temp = explode("-",$registroper['arrendado_desde']);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$desde =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

					$fecha_temp = explode("-",$hasta);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

					 
					 echo("<br />PERIODO DESDE ".$desde." AL ".$hasta);
					 
						  
						  //
					  
					  }else{
						  echo(" ");
					  }
			  }
			 ?></td>
        <td width="175" align="center" valign="top">
		<?php /*if (!empty($registrodet['cod_equipo'])){
				  echo "$".number_format($registronob['valor_unidad_arr'], 0, ",", "."); 
			      $sqleval   = "SELECT valor_unidad_arr FROM vigomaq_intranet.equipo WHERE cod_equipo =".$registrodet['cod_equipo'];
				  
				  
				 	
					$resuni         = mysql_query($sqleval,$link) or die(mysql_error()); 
					$registroval    = mysql_fetch_array($resuni);
					
			  
			  $valor=(($registrodet['dias_arriendo'])-$registrodet['dias_ajuste'])*($registroval['valor_unidad_arr']);
			 
			  }else{
				
				  echo "$".number_format($registrodet['valor_unitario'], 0, ",", ".");
			  }
			  
			  */
			  
			  $link=Conectarse();
			 
			
			      $sqleval   = "SELECT valor_unidad_arr FROM vigomaq_intranet.equipo WHERE cod_equipo =".$registrodet['cod_equipo'];
				 	
					$resuni         = mysql_query($sqleval,$link) or die(mysql_error()); 
					$registroval    = mysql_fetch_array($resuni);
					$valor = $registroval['valor_unidad_arr'];
					  echo "$".number_format($registroval['valor_unidad_arr'], 0, ",", ".");
			  
			  //$valor=(($registrodet['dias_arriendo'])-$registrodet['dias_ajuste'])*($registroval['valor_unidad_arr']);
		//echo $registrodet['valor_unitario'];
		
		//if (!empty($registrodet['valor_unitario'])) {echo "$".number_format($registrodet['valor_unitario'], 0, ",", "."); }else{ echo "$".number_format($registrodet['tot_arriendo'], 0, ",", ".");} ?>
        </td>
        <td width="144" align="center" valign="top"><?php
			  	$total_neto =$dias_arriendo*$valor;
				$porcentaje_emitir = 0;
			  	$porcentaje_emitir = (($registrodet['porcentaje_vu']));
				if ($porcentaje_emitir==0){
					
					}
				else{
					echo $porcentaje_emitir."%";
					}
			?>
        </td>
        <td width="144" align="center" valign="top">
          <?php 
			  if (!empty($registrodet['total_rep'])) { 
			    if ($registrodet['porcentaje_vu']==100){
					$porcentaje = 0;
					}
				echo "( ".$dias_arriendo." X ".$registrodet['total_rep']." ) X (1 - ".($porcentaje/100).")";
			  	$total_desc = ($dias_arriendo*$registrodet['total_rep']) * (1 -($porcentaje/100));
				echo "$".number_format($total_desc, 0, ",", "."); 
				$costo_tot = $costo_tot + ($total_desc);
				}
			  else{ 
			  	$total_desc = $total_neto * (1 -($porcentaje/100));
				echo "$".number_format($total_desc, 0, ",", "."); 
				$costo_tot = $costo_tot + ($total_desc);
				}

			
			"$".number_format($registrodet['tot_arriendo'], 0, ",", "."); 
			
			?>
        </td>
   	</tr>
      <?php
				}
				mysql_free_result($res);
				mysql_close($link); 
		 ?>
</table>
<table width="1280" border="0" style="position:absolute; left:0px; top:740px;">
  <tr>
    <td width="301" height="70" align="right" valign="top">&nbsp;</td>
    <td width="430" valign="middle" align="left"><?php 
	            $link=Conectarse();
				$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
				$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
				$registroiva = mysql_fetch_array($resiva);
				$valor_iva = $registroiva['valor_iva'];
				$iva = $costo_tot * ($valor_iva/100);
				$total = $costo_tot + $iva;
			    echo (strtoupper(docenumeros($total))) ;?></td>
    <td width="384" valign="middle" align="right">&nbsp;</td>
    <td width="117" align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="43" align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
	<td align="center"  style="padding-top:16px !important; padding-bottom:8px !important;">
    <!--<td  valign="top">-->
      <?php
				echo (number_format($costo_tot, 0, ",", "."));
		 ?>
      <input type="hidden" name="txt_sumcosto2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
	</td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
    <td align="center">
      <?php
				$link=Conectarse();
				$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
				$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
				$registroiva = mysql_fetch_array($resiva);
				$valor_iva = $registroiva['valor_iva'];
				$iva = $costo_tot * ($valor_iva/100);
				
				echo (number_format($iva, 0, ",", "."));
		 ?>
      <input type="hidden" name="txt_iva3"  value="<?php echo $iva?>" size="20" maxlength="30" />
		</td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
	<td align="center"  style="padding-top:8px !important; padding-bottom:16px !important;">
    <!--<td align="center" style="padding-bottom:16px !important; padding-top:8px !important;">-->
      <?php
				$total = $costo_tot + $iva;
				echo (number_format($total, 0, ",", "."));
		 ?>
      <input type="hidden" name="txt_iva4"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
    </td>
  </tr>
</table>
</form>
</html>
