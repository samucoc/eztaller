<?php ob_start(); 
session_start(); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<?php
require_once('classes/tc_calendar.php');
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
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
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
.Estilo20 {color: #000000}
.Estilo6 {  font-size: large;
  font-family: Arial, Helvetica, sans-serif;
}
.Estilo24 { color: #FFFFFF;
  font-style: italic;
  font-weight: bold;
}
.Estilo25 {
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
    <style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); .Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
    </style>
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2 Estilo25"><br />
       <br />
       <br />
       <span class="Estilo23">Sistema de Arriendo y Facturación - Vigomaq</span></div></td>
   </tr>
</table>
  <div id="div-menu">
    <?php 
      include('classes/menu.php'); //modulo menu
    ?>
  </div>
<table width="100%" border="0">
  <tr>
    <td height="592"><table width="95%" border="0" align="center">
      <tr>
        <td width="80%" ><div align="center" class="Estilo6">
          <div align="right" class="Estilo20"><strong><font>
            <?php

        {
      include("classes/conex.php");
      $link=Conectarse();
      }

   ?>
     <?php
     $num_nd =  $_GET["num_nd"];
     if (empty($num_nd)) {
       $num_nd = $_POST['num_nd'];
       }
     $link=Conectarse();
    //busca factura
    $sqlnc     = "SELECT * FROM nota_debito WHERE num_nota_cred ='$num_nd'";
    //echo "sqlnc= $sqlnc<br>";
    $resnc          = mysql_query($sqlnc,$link) or die(mysql_error()); 
    $registronc     = mysql_fetch_array($resnc);
     //echo ($num_nd);
   ?>
            <?php
      {
        $num_factura =  $_POST["txt_factura"];
        if (empty($_POST["txt_factura"])) $num_factura =  $_GET["txt_factura"];
      
          $fact1       =  $_POST["fact1"];
        if (empty($_POST["fact1"])) $fact1 =  $_GET["fact1"];
        
        $cod_obra    = $_GET["cod_obra"];
        $cod_arr     = $_GET["codarr"];
        $valor1      = $_GET["equipo"];
       
        if (!empty($num_factura))
        {
        
          $link=Conectarse();
          //busca factura
          $sqlfact     = "SELECT * FROM factura WHERE num_factura ='$num_factura'";
          
          $res          = mysql_query($sqlfact,$link) or die(mysql_error()); 
          $registro     = mysql_fetch_array($res);
          $cod_cliente  = $registro['cod_cliente'];
          $cod_arriendo = $registro['cod_arriendo'];
          $cod_obra     = $registro['cod_obra'];
          $gd           = $registro['gd_rep'];
          //buscar cliente
          $sqlcli   = "SELECT * FROM clientes WHERE cod_cliente ='$cod_cliente'";
    
          $rescli       = mysql_query($sqlcli,$link) or die(mysql_error()); 
          $registrocli = mysql_fetch_array($rescli);
          $cliente     = $registrocli['raz_social'];
          
          $sql_det_fact = "select sum(tot_arriendo) as tot_arriendo, sum(total_rep) as total_rep
                          from det_factura
                          where num_factura = '".$num_factura."'";
          $res_det_fact = mysql_query($sql_det_fact,$link);
          $row_det_fact = mysql_fetch_array($res_det_fact);    

        }
      }
     ?>
            NOTA DE Debito</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><form action="nd.php" method="post"  name="frmDatos" id="frmDatos">
          <table width="100%" height="402" border="0" align="center">
            <tr>
              <td height="20" colspan="7" bgcolor="#06327D"><span class="Estilo24">DATOS NOTA DE DEBITO</span><span class="Estilo24">
                <?php  $fecha = date ("d-m-Y");?>
                <div align="right"></div>
              </span></td>
            </tr>
            <tr>
              <td colspan="7"></td>
            </tr>
            <tr>
              <td width="18%">N&deg; Nota Debito</td>
              <td width="1%">:</td>
       <?php 
            $sql_num_factura     = "SELECT (COALESCE(num_nota_cred  ,0)) as ncorr
                  FROM nota_debito
                  WHERE num_nota_cred  >0
                  order by num_nota_cred   desc";
          
          $res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
          $registro_num_factura= mysql_fetch_array($res_num_factura);
          $num_factura_nuevo = $registro_num_factura['ncorr'];

          
          if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 0;
          else $num_factura_nuevo = $registro_num_factura['ncorr']+1;


          if ($num_factura_nuevo=='') $num_factura_nuevo=1;

            $sql_filtro = "select * 
                    from folios_dte
                    where desde <= '".$num_factura_nuevo."' and 
                        hasta >= '".$num_factura_nuevo."' and 
                        tipo = 56";
            $res_filtro = mysql_query($sql_filtro,$link);
            if (mysql_num_rows($res_filtro)==0){
              $num_factura_nuevo = "Error.";
              }
          
            ?>
              <td width="28%"><span class="Estilo241">
                <input name="txt_num_nd" type="text"value="<?php 
         if (($_POST['txt_num_nd']=='')&&($registrofact['txt_num_nd']=='')) echo $num_factura_nuevo;
                        else  if (!empty($_GET["txt_num_nd"])){
            echo($_GET["txt_num_nd"]);
          }else{
            echo $_POST['txt_num_nd'];
            }?>" size="10" maxlength="10" style="font-size:18px; color:red;  font-weight:bold; border:#F00 solid 2px; padding:5px"/>
                </span></td>
              <td width="18%" height="8"  align="right">Fecha Emision Nota Debito</td>
              <td height="8" colspan="2"><div align="left">
                <input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registronc['fecha'])) {echo ($registronc['fecha']);}else{echo($_POST["cal-field-1"]) ;}//=$registro['fecha'];?>" size="10" maxlength="10"/>
                <button type="submit" id="cal-button-1">...</button>
                <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
                </script>
                </div></td>
              <td width="12%">&nbsp;</td>
            </tr>
            <tr>
              <td height="8" >Acción a realizar al documento referenciado.</td>
              <td height="8" >:</td>
              <td height="8" >
                <select name="accion" id="accion">
                  <option value="3">Corrige montos</option>
                </select>
              </td>
              </tr>
            <tr>
            <tr>
              <td height="8" colspan="7" bgcolor="#06327D"><span class="Estilo24">DATOS FACTURA</span></td>
              </tr>
            <tr>
              <td height="8">N&deg; Factura</td>
              <td height="8">:</td>
              <td height="8"><span class="Estilo241">
                <input name="txt_factura" type="text"value="<?php if (!empty($_POST["txt_factura"])) {echo ($_POST["txt_factura"]);}else{ echo($_GET["txt_factura"]);}?>" size="10" maxlength="10" />
                <input type="submit" name="buscar" title="Buscar Factura" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
              </span></td>
              <td height="8" align="right">Fecha Emision Factura</td>
              <td height="8" colspan="2"><input name="fecha" type="text" id="cal-field-2" value="<?php if (!empty($registro['fecha'])) {echo ($registro['fecha']);}?>" size="10" maxlength="10" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Cliente</div></td>
              <td>:</td>
              <td colspan="4"><input name="txt_cliente" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Giro</div></td>
              <td>:</td>
              <td colspan="4"><input name="txt_giro" type="text" value="<?php if (!empty($registrocli['giro_cliente'])) {echo ($registrocli['giro_cliente']);}else{echo($_GET['txt_giro']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Direcci&oacute;n</div></td>
              <td>:</td>
              <td colspan="4"><input name="txt_direcc" type="text" value="<?php if (!empty($registrocli['direcc_cliente'])) {echo ($registrocli['direcc_cliente']);}else{echo($_GET['txt_direcc']);}?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Ciudad</div></td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_ciudad" type="text" value="<?php
         if (!empty($registrocli['cod_ciudad']))
            {
              $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registrocli['cod_ciudad'];
              // echo($sql3);
              $resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
              $registrociu = mysql_fetch_array($resciu);
              echo($registrociu['ciudad']);
            }else{
              echo(" ");
            } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Comuna</div></td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_comuna" type="text" value="<?php
         if (!empty($registrocli['cod_comuna']))
            {
              $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registrocli['cod_comuna'];
              // echo($sql3);
              $rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
              $registrocom = mysql_fetch_array($rescom);
              echo($registrocom['comuna']);
            }else{
              echo(" ");
            } ; ?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24"><div align="left">Tel&eacute;fono</div></td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_fono" type="text" value="<?php if (!empty($registrocli['fono_cliente'])) {echo ($registrocli['fono_cliente']);}else{echo($_GET['txt_fono']);}?>" size="8" maxlength="8" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="24">Guia despacho </td>
              <td>:</td>
              <td colspan="4" align="left"><input name="txt_cliente7" type="text" value="<?php if (!empty($registrocli['raz_social'])) {echo ($registrocli['raz_social']);}else{echo($_GET['txt_cliente']);}?><?php // =$_GET['nomequipo'];?>" size="50" maxlength="50" disabled="disabled" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="85"><div align="left">Condiciones envio</div></td>
              <td>:</td>
              <td colspan="4" align="left"><textarea name="txt_condic" cols="50" rows="5" disabled="disabled"><?php if (!empty($registrocli['cond_env_fact'])) {echo ($registrocli['cond_env_fact']);}else{echo($_GET['txt_condic']);}?>
              </textarea></td>
              <td><input type="submit" name="OK" title="Generar Nota de Debito" value="Guardar y Seguir" style="background-image:url(images/guardar.png); width:45px; height:45px;" class="formato_boton" />
              <a href="nc.php" class="menulink">
                <img src="images/clean.png" width="48" height="48" />"
              </a>
              </td>
            </tr>
            </table>


      <table width="100%" border="0" align="center">
        <tr>
          <td><table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="10%" bgcolor="#06327D"><span class="Estilo17">Cantidad</span></th>
              <th width="40%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Detalle</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Valor Unitario</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Total Neto</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Descuento</span></th>
              <th width="20%" bgcolor="#06327D" class="CONT">
                <span class="Estilo17 Estilo13 Estilo15">Total</span></th>
            </tr>
            <?php
      $sql="SELECT * 
          FROM det_factura 
          where det_factura.num_factura = '$num_factura'";
      $res = mysql_query($sql) or die(mysql_error()); 
      
      while ($registro = mysql_fetch_array($res)) {
        $dias_arriendo = $registro['dias_arriendo'];
        $dias_ajuste = $registro['dias_ajuste'];
        $valor_unitario = $registro['valor_unitario'];
        $total_rep = $registro['total_rep'];
        $monto_otros = $registro['monto_otros'];
        $cod_repuesto = $registro['cod_repuesto'];
        $cod_equipo = $registro['cod_equipo'];
        $porcentaje_vu = $registro['porcentaje_vu'];
      
    ?>
            <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
      <?php if (($registro['cod_equipo']==0)) {?>            
            <td align="left"  bgcolor="#FFFFFF"><?php 
        echo($registro['cantidad']);?>
            </td>
            <td align="left"  bgcolor="#FFFFFF"><?php 
        if ($registro['otros_reparacion']!='')
          echo utf8_decode($registro['otros_reparacion']);
        else
          echo utf8_decode($registro['observaciones']); 
       ?></td>
            <td align="right"  bgcolor="#FFFFFF"><?php 
        if (!empty($registro['valor_unitario']))
              echo "$".number_format($registro['valor_unitario'], 0, ",", ".");
        else
          echo "$".number_format($registro['precio'], 0, ",", ".");
        ?>
            </td>
            <td align="right"  bgcolor="#FFFFFF">
        <?php 
          if (!empty($registro['cod_equipo'])){
            echo "$".number_format($valor, 0, ",", ".") ; 
          }else{ 
            if (!empty($registro['total_rep'])){
              echo("$".number_format($registro['total_rep'], 0, ",", ".")); 
              }
            else{
              echo("$".number_format($registro['precio'], 0, ",", ".")); 
              }
          } 
        ?></td>
            <td  bgcolor="#FFFFFF"></td>
            <td align="right"  bgcolor="#FFFFFF">
        <?php 
          if (!empty($registro['cod_equipo'])){
            echo "$".number_format($valor, 0, ",", ".") ; 
            $costo_tot= $costo_tot + $valor; 
          }else{ 
            if (!empty($registro['total_rep'])){
              echo("$".number_format($registro['total_rep'], 0, ",", ".")); 
              $costo_tot= $costo_tot + ($registro['total_rep']);
              }
            else{
              echo("$".number_format($registro['precio'], 0, ",", ".")); 
              $costo_tot= $costo_tot + ($registro['precio']);
              }
          } 
        ?></td>
      <?php } else {?>            
              <td width="10%" bgcolor="#FFFFFF"><?php echo "Dias arriendo : ".$dias_arriendo."<br/>Dias ajuste : ".$dias_ajuste; ?> </td>
              <td width="40%" bgcolor="#FFFFFF">Día(s) de arriendo con contrato nro <?php 
        echo $num_gd.' ';   
        if (!empty($cod_repuesto[$contador-1])) {
          $sqlnomrep="SELECT cod_repuesto, nombre_repuesto FROM repuesto where cod_repuesto =".$cod_repuesto;
          $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
          $registronrep = mysql_fetch_array($resnomrep);
          echo($registronrep['nombre_repuesto']);
  
        }else{
          //BUSCAR FECHA DE ARRIENDO
          $sqlperiodo=" SELECT *
                  FROM equipos_arriendo
                    inner join gd
                      on equipos_arriendo.cod_arriendo = gd.id_arriendo
                    inner join factura 
                      on factura.cod_arriendo = equipos_arriendo.cod_arriendo
                    where equipos_arriendo.nro_factura = '".$num_factura."'
                      and equipos_arriendo.cod_equipo =".$cod_equipo." 
                    order by equipos_arriendo.arrendado_hasta asc
                  limit 0,1";
          $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
            $registroper_row = mysql_num_rows($resperiodo);
            if ($registroper_row==0){
              $sqlperiodo=" SELECT *
                    FROM equipos_arriendo
                      inner join factura 
                        on factura.cod_arriendo = equipos_arriendo.cod_arriendo
                      where equipos_arriendo.cod_arriendo =".$num_arriendo." 
                        and equipos_arriendo.cod_equipo =".$cod_equipo." 
                        and equipos_arriendo.num_gd =c
                        and factura.num_factura = '".$num_factura."'
                        and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
                        and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
                      order by equipos_arriendo.arrendado_hasta asc
                    limit 0,1";
              $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
            }
        $registroper = mysql_fetch_array($resperiodo); 
            if (!empty($registroper['arrendado_hasta'])){ 
              $hasta = $registroper['arrendado_hasta']; 
              }
            else{ 
              $hasta = "NO DEVUELTO";
              }
            $sqlnomob="SELECT cod_equipo, nombre_equipo,valor_unidad_arr 
                FROM equipo where cod_equipo =".$cod_equipo;
            $resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
            $registronob = mysql_fetch_array($resnomob);
            //echo($registronob['nombre_equipo']." "."PERIODO ".$registroper['arrendado_desde']."-".$hasta." "."ARRENDADO"." ".$registro['dias_arriendo']." "."DIAS"." "."AJUSTE"." ".$registro['dias_ajuste']." "."DIAS"." "."TOTAL"." ".($registro['dias_arriendo']-$registro['dias_ajuste'])." "."DIAS");
            
            $fecha_temp = explode("-",$registroper['arrendado_desde']);
            //año-mes-dia
            //0 -> dia, 1 -> mes, 2 -> año
            $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
            $fecha_factura_temp = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
  
            $fecha_temp = explode("-",$hasta);
            //año-mes-dia
            //0 -> dia, 1 -> mes, 2 -> año
            $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
            $hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
  
            
            echo(htmlentities($registronob['nombre_equipo'])." "." PERIODO: ".$fecha_factura_temp." --> ".$hasta);
           }
       ?></td>
              <td width="13%" align="right" bgcolor="#FFFFFF"><?php  
        if (!empty($cod_equipo)){
          $valor_u = $registro['tot_arriendo']/$dias_arriendo;
            echo "$".number_format($valor_u, 0, ",", "."); 
          $valor=(($dias_arriendo)*($valor_u));
        }else{
          echo "$".number_format($valor_unitario, 0, ",", ".");
        }?></td>
              <td width="13%" align="right" bgcolor="#FFFFFF"><?php if (!empty($cod_equipo)){
            echo "$".number_format($valor, 0, ",", ".") ; 
            
            }
          else{ 
            echo("$".number_format($total_rep, 0, ",", ".")/*($registro['total_rep'])*/); 
            $costo_tot= $costo_tot + $total_rep;}
        ?>
                <br /></td>
              <td width="13%" align="right" bgcolor="#FFFFFF">
          <?php 
        
        
        $porcentaje_emitir = ($registro['porcentaje_vu']);
        
        if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
          echo "0%";
          }
        else{
          echo $porcentaje_emitir."%";
          }
        ?>
              </td>
              <td width="20%" align="right" bgcolor="#FFFFFF"><?php 
      if (!empty($cod_equipo)){
                  $valor_def = $registro['tot_arriendo'];
                  $costo_tot= $costo_tot + $valor_def; 
                  echo "$".number_format($registro['tot_arriendo'], 0, ",", ".");
            
            }
          else{ 
                  $valor_def = $registro['total_rep'];
                  $costo_tot= $costo_tot + $valor_def; 
                  echo "$".number_format($registro['total_rep'], 0, ",", ".");
            }
      ?></td>
            </tr>
            <tr>
              <td width="10%" height="20" bordercolor="#FFFFFF" class="CONT"><?php if ($monto_otros>0) { echo(1);}?></td>
              <td width="40%" class="CONT"><?php if ($monto_otros>0) { echo ("REPARACION");} ?></td>
              <td width="13%" align="right" class="CONT"><?php if ($monto_otros>0) echo "$".number_format($monto_otros, 0, ",", ".") ; ?></td>
              <td width="13%" align="right" class="CONT"><?php if ($monto_otros>0) echo "$".number_format($monto_otros, 0, ",", ".") ; $costo_tot= $costo_tot + $monto_otros; ?></td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="20%" align="right" class="CONT">&nbsp;</td>
            </tr>
             <?php
      }
      }
        mysql_free_result($res);
        mysql_close($link);
     ?>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="13%" align="right" class="CONT">&nbsp;</td>
              <td width="20%" align="right" class="CONT"><?php
        echo ("NETO: $".number_format($costo_tot, 0, ",", "."));
     ?>
                <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
              </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="20%" align="right"><span class="CONT">
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
        echo ("IVA : $".number_format($iva, 0, ",", "."));
     ?>
                <input type="hidden" name="txt_iva"  value="<?php echo $iva?>" size="20" maxlength="30" />
              </span></td>
              </tr>
            <tr>
              <td width="10%" height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="40%" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td width="13%" class="CONT">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="13%" align="right">&nbsp;</td>
              <td width="20%" align="right"><span class="CONT">
                <?php
        $total = $costo_tot + $iva;
        echo ("TOTAL : $".number_format($total, 0, ",", "."));
     ?>
                <input type="hidden" name="txt_iva2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
              </span></td>
            </tr>
            </table></td>
        </tr>
      </table>






            <table width="100%" id="tabla-cantidad">
            <tr>
              <td colspan="7" align="center" bgcolor="#06327D"><span class="Estilo17">Agregar Montos</span></td>
            </tr>
            <tr>
              <td align="center" valign="middle"><div ><font><strong>Cantidad</strong></font></div></td>
              <td align="center" valign="middle">&nbsp;</td>
              <td colspan="2" align="center" valign="middle"><div ><font><strong>Observaciones</strong></font></div></td>
              <td colspan="2" align="center" valign="middle"><div ><strong>Precio Unitario</strong></div></td>
              <td align="center" valign="middle" class="Estilo21">Agregar</td>
            </tr>
            <tr>
              <td align="center" valign="middle"><font>
                <input name="txt_cantidad" type="text" id="txt_cantidad" size="10" maxlength="10" />
              </font></td>
              <td align="center" valign="middle">&nbsp;</td>
              <td colspan="2" align="center" valign="middle" class='mini_titulo'><font>
                <textarea name="txt_observaciones" cols="45" rows="10+" id="txt_observaciones"><?php if (!empty($registronc['referencias'])) {echo ($registronc['referencias']);}?></textarea>
                </font></td>
              <td colspan="2" align="center" valign="middle"><font>
                <input name="txt_monto" type="text" id="txt_monto" size="10" maxlength="10" />
              </font></td>
              <td align="center" valign="middle"><a href="#" id="agregar-fila"><img src="images/guardar.gif" alt="" class="formato_boton" style="width:46px; height:52px;" title="Agregar Repuesto a Factura" /></a></td>
            </tr>
            <tr>
              <td colspan="7">
              <table class="sortable" id="tabla-pre" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
                  <th width="9%" bgcolor="#06327D" class="Estilo17">Cantidad</th>
                  <th width="48%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Observaciones</span></th>
                  <th width="14%" bgcolor="#06327D" class="Estilo17">Precio Unitario</th>
                  <th width="13%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Total</span></th>
                  <th width="16%" bgcolor="#06327D" class="Estilo17">Accion</th>
                  </tr>
                 </table>
        <table width="100%" border="0" align="center">
          <tr class="sortable">
            <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
            <td class="CONT"></td>
            <td class="CONT">&nbsp;</td>
            <td align="right" class="CONT"><?php
                echo ("<div id='neto'>NETO: $".number_format($costo_tot_nd, 0, ",", ".")."</div>");
     ?>
              <input type="hidden" name="txt_sumcosto" id="txt_sumcosto"  value="<?php echo number_format($costo_tot_nd, 0, ",", "")?>" size="20" maxlength="30" /></td>
            <td class="CONT">&nbsp;</td>
          </tr>
          <tr>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8" align="right"><span class="CONT">
              <?php
        if (empty($val_iva_nd)){
          $link=Conectarse();
          $sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
          $resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
          $registroiva = mysql_fetch_array($resiva);
          $valor_iva_nd = $registroiva['valor_iva'];
        }else{
          $valor_iva_nd = $val_iva_nd;
        }
        $iva_nd = $costo_tot_nd * ($valor_iva_nd/100);
        
        echo ("<div id='iva'>IVA : $".number_format($iva, 0, ",", ".")."</div>");
     ?>
              <input type="hidden" name="txt_iva" id="txt_iva"  value="<?php echo number_format($iva_nd, 0, ",", "")?>" size="20" maxlength="30" />
            </span></td>
            <td height="8"></td>
          </tr>
          <tr>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8" align="right"><span class="CONT">
              <?php
        $total_nd = $costo_tot_nd + $iva_nd;
        
        echo ("<div id='total'>TOTAL : $".number_format($total_nd, 0, ",", ".")."</div>");
     ?>
              <input type="hidden" name="total" id="total"  value="<?php echo number_format($total_nd, 0, ",", "")?>" size="20" maxlength="30" />
            </span></td>
            <td height="8"></td>
          </tr>
        </table>
</td>
            </tr> <?php   
      if ($_POST['buscar']=='Buscar') 
      {   
        if (empty($_POST['txt_factura']))
        {  
          $link=mensaje();
        } else {
          $num_nd     = $_POST['txt_num_nd'];
          $sqlf        = "SELECT * from nota_debito WHERE num_nota_cred ='$num_nd'";
          $resf        = mysql_query($sqlf,$link) or die(mysql_error()); 
          if (mysql_num_rows($resf)>0) {
            echo "<script> alert (\"Nota de crédito existente.\"); </script>";                              
          }
        };
      }
    ?>
  <?php
    function mensaje()
        {
            echo "<script>
            alert('Ingrese número de nota de Debito, fecha y/o número de factura');
            </script>";
        }
  ?>
  <?php 
  if ($_POST['OK']=='Guardar y Seguir'){
    $num_factura    = $_POST['txt_factura'];                   
    $num_nd     = $_POST['txt_num_nd'];
    $fecha          = $_POST['cal-field-1'];              
    $accion          = $_POST['accion'];     
    $observaciones  = $_POST['observaciones'];
    $nro = count($observaciones);         
  if ((empty($num_factura))or(empty($num_nd))or($nro>0)or(empty($fecha))){  
    $link=mensaje();
  } else {
    $link=Conectarse();
    
    $sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
    $resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
    $registroiva = mysql_fetch_array($resiva);
    $valor_iva = $registroiva['valor_iva'];
    
    $fecha_temp = explode("-",$_POST['cal-field-1']);
    //$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   
    $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
    $fecha = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
    $sqlf        = "SELECT * from nota_debito WHERE num_nota_cred ='$num_nd'";
    
    $resf        = mysql_query($sqlf,$link) or die(mysql_error()); 
    $registrof   = mysql_fetch_array($resf);
    if (mysql_num_rows($resf)>0) {
      echo "<script> alert (\"Nota de crédito existente.\"); </script>";                              
    }elseif ($registrof['estado']=="NULA") {
      echo "<script> alert (\"Nota de crédito se encuentra NULA.\"); </script>";                              
    }else{  
      //ingresar datos de la factura        
      $sql_001  = "insert into nota_debito (num_nota_cred,cod_cliente,fecha,num_factura,accion) 
              values ('$num_nd','$cod_cliente','$fecha','$num_factura','$accion')";
      //echo "<br />";
      $res_001  = mysql_query($sql_001,$link) or die(mysql_error());
      $observaciones  = $_POST['observaciones'];
      $nro = count($observaciones);
      $monto    = $_POST['monto'];
      $cantidad   = $_POST['cantidad'];
      for($i=0; $i<$nro; $i++){
        $temp = htmlspecialchars_decode($observaciones[$i]);
        $temp = str_replace('Ã', "Ñ",$temp);
       $sql_temp = "insert into det_nd(num_nd, cantidad, monto, referencias) 
              values ('".$num_nd."','".$cantidad[$i]."','".$monto[$i]."', '". htmlspecialchars_decode($temp)."')";
        //echo "<br />"; 
        $res_temp = mysql_query($sql_temp,$link) or die(mysql_error());
        }
      $hora_actual = date("H:i:s");
      $fecha_actual = date("Y-m-d");
      mysql_query("insert into transacciones (fecha, hora, usuario, tipo_documento, folio)  values('$fecha_actual','$hora_actual','$usuario','NC','$num_nd')",$link); 
      echo "<script> alert (\"Proceso realizado con Exito\"); </script>";
      echo "<script language=Javascript> location.href=\"consulta_nd.php?num_nd=".$num_nd."\"; </script>";
      }
    }
    }      
  ?>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>
<script type="text/javascript">
  var menu=new menu.dd("menu");
  menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
  var i =0;
  $(document).ready(function(){
    $("#tipo_ajuste").live('click',function(){
      $("#tabla-cantidad").show();
      $("#tabla-pre").show()
      });
    $("#tipo-encabezado").live('click',function(){
      $("#tabla-cantidad").hide();
      $("#tabla-pre").hide();     
      });
    $('#agregar-fila').live('click',function(){
      var cantidad = $("#txt_cantidad").val();
      var observaciones = $("#txt_observaciones").val();
      observaciones = observaciones.replace(/\"/g, ' plg. ');
      var monto = $("#txt_monto").val();
      var total = cantidad * monto;
      var tot_fact = 0;
      tot_fact = <?php echo $row_det_fact['tot_arriendo']?>;
      if ((tot_fact=='')||(tot_fact==0)){
          tot_fact = <?php echo $row_det_fact['total_rep']?>;
          }
      var total = cantidad * monto;
      if (total>tot_fact){
        alert("Error. Total mayor al de la factura.");
        }
      else
        {
        $('#tabla-pre').hide();
        $('#tabla-pre').append('<tr id="linea_'+i+'"><td align="center">'+cantidad+'<input type="hidden" id="cantidad" name="cantidad[]" value="'+cantidad+'"/></td><td align="center">'+observaciones+'<input type="hidden" id="observaciones" name="observaciones[]" value="'+observaciones+'"/></td><td align="right">$'+monto+'<input type="hidden" id="monto" name="monto[]" value="'+monto+'"/></td><td align="right">$'+total+'</td><td align="center"><a href="#" onclick="borrarFila('+i+'); return false"><img src="images/error.png" title="Borrar" /></a></td></tr>');
        $('#tabla-pre').show();
        i = i+1;
        /*sumar valores*/
        var neto_actual = $("#txt_sumcosto").val();
        neto_actual = parseInt(neto_actual) + parseInt(monto);
        $("#neto").html("NETO : $"+neto_actual);
        document.getElementById('txt_sumcosto').value = neto_actual;

        var iva_actual = neto_actual*(0.19);
        $("#iva").html("IVA : $"+iva_actual);
        document.getElementById('txt_iva').value = iva_actual;
        
        var total_actual = neto_actual*(1.19);
        $("#total").html("TOTAL : $"+total_actual);
        document.getElementById('total').value = total_actual;  
        }
      
    });
  });
  function borrarFila(indice){
    var monto = $("#linea_" + indice + " #monto").val();
    $("#linea_" + indice).remove();
    /*restar valores*/
    var neto_actual = $("#txt_sumcosto").val();
    neto_actual = parseInt(neto_actual) - parseInt(monto);
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

</body>

</html>
