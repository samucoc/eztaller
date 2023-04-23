<?php 

ob_start(); 
session_start(); 


if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}

require_once('classes/tc_calendar.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
  <title>Sistema de Arriendo y nota_debitoci&oacute;n - Vigomaq</title>
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
       <span class="Estilo23">Sistema de Arriendo y nota_debitoción - Vigomaq</span></div></td>
   </tr>
</table>
  <div id="div-menu">
    <?php 
      include('classes/menu.php'); //modulo menu
    ?>
  </div>
<table width="100%" border="0">
  <tr>
    <td ><table width="95%" border="0" align="center">
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
     $num_nc =  $_GET["num_nc"];
     if (empty($num_nc)) {
       $num_nc = $_POST['num_nc'];
       }
     $link=Conectarse();
    //busca nota_debito
    $sqlnc     = "SELECT * FROM nota_credito WHERE num_nota_cred ='$num_nc'";
    //echo "sqlnc= $sqlnc<br>";
    $resnc          = mysql_query($sqlnc,$link) or die(mysql_error()); 
    $registronc     = mysql_fetch_array($resnc);
     //echo ($num_nc);
   ?>
            <?php
      {
        $num_nota_debito =  $_POST["txt_nota_debito"];
        if (empty($_POST["txt_nota_debito"])) $num_nota_debito =  $_GET["txt_nota_debito"];
      
          $fact1       =  $_POST["fact1"];
        if (empty($_POST["fact1"])) $fact1 =  $_GET["fact1"];
        
        $cod_obra    = $_GET["cod_obra"];
        $cod_arr     = $_GET["codarr"];
        $valor1      = $_GET["equipo"];
       
        if (!empty($num_nota_debito))
        {
          
          $link=Conectarse();
          //busca nota_debito
          $sqlfact     = "SELECT * FROM nota_debito WHERE num_nota_debito ='$num_nota_debito'";
          
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
                          from det_nota_debito
                          where num_nota_debito = '".$num_nota_debito."'";
          $res_det_fact = mysql_query($sql_det_fact,$link);
          $row_det_fact = mysql_fetch_array($res_det_fact);

        }
      }
     ?>
            NOTA DE CREDITO</font></strong></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><form action="nc_nd.php" method="post"  name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td height="5" colspan="7" bgcolor="#06327D"><span class="Estilo24">DATOS NOTA DE CREDITO</span></td>
            </tr>
            <tr>
              <td width="18%">N&deg; Nota Credito</td>
              <td width="1%">:</td>
 <?php 
            $sql_num_nota_debito     = "SELECT (COALESCE(num_nota_cred  ,0)) as ncorr
                  FROM nota_credito
                  WHERE num_nota_cred  > 725
                  order by num_nota_cred   desc";
          
          $res_num_nota_debito     = mysql_query($sql_num_nota_debito,$link) or die(mysql_error()); 
          $registro_num_nota_debito= mysql_fetch_array($res_num_nota_debito);
          $num_nota_debito_nuevo = $registro_num_nota_debito['ncorr'];
          if ($registro_num_nota_debito['ncorr']=='') $num_nota_debito_nuevo= 726;
          else $num_nota_debito_nuevo = $registro_num_nota_debito['ncorr']+1;
         
          if ($num_nota_debito_nuevo=='') $num_nota_debito_nuevo=1;

            $sql_filtro = "select * 
                    from folios_dte
                    where desde <= '".$num_nota_debito_nuevo."' and 
                        hasta >= '".$num_nota_debito_nuevo."' and 
                        tipo = 61";
            $res_filtro = mysql_query($sql_filtro,$link);
            if (mysql_num_rows($res_filtro)==0){
              $num_nota_debito_nuevo = "Sin Folio";
              }
          
            ?>              <td width="28%"><span class="Estilo241">
                <input name="txt_num_nc"  id="txt_num_nc" type="text"value="<?php 
          if (($_POST['txt_num_nc']=='')&&($registrofact['txt_num_nc']=='')) echo $num_nota_debito_nuevo;
          else  if (!empty($_GET["txt_num_nc"])){
            echo($_GET["txt_num_nc"]);
          }else{
            echo $_POST['txt_num_nc'];
            }?>" size="10" maxlength="10" style="font-size:18px; color:red;  font-weight:bold; border:#F00 solid 2px; padding:5px"/>
                </span></td>
              <td width="18%" height="8"  align="right">Fecha Emision Nota Credito</td>
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
                  <?php 
                      $accion = $_POST['accion'];
                      if ($accion =='4'){
                        echo "<option value='4'>Anula Documento de Referencia</option>";
                        }
                  ?>
                  <option value="4">Anula Documento de Referencia</option>
                </select>
              </td>
              </tr>
            <tr>
              <td height="8" colspan="7" bgcolor="#06327D"><span class="Estilo24">DATOS Nota de Debito</span></td>
              </tr>
            <tr>
              <td height="8">N&deg; Nota de Debito</td>
              <td height="8">:</td>
              <td height="8"><span class="Estilo241">
                <input name="txt_nota_debito" type="text"value="<?php if (!empty($_POST["txt_nota_debito"])) {echo ($_POST["txt_nota_debito"]);}else{ echo($_GET["txt_nota_debito"]);}?>" size="10" maxlength="10" />
                <input type="submit" name="buscar" title="Buscar nota_debito" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton" />
              </span></td>
              <td height="8" align="right">Fecha Emision Nota de Debito</td>
              <td height="8" colspan="2"><input name="fecha" type="text" id="cal-field-2" value="<?php if (!empty($registro['fecha'])) {echo ($registro['fecha']);}?>" size="10" maxlength="10" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            </table>

      <table width="100%" border="0" align="center">
        <tr>
          <td><table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="30%" bgcolor="#06327D"><span class="Estilo17">Cantidad</span></th>
              <th width="30%" bgcolor="#06327D"><span class="Estilo17">Referencia</span></th>
              <th width="30%" bgcolor="#06327D"><span class="Estilo17">Monto</span></th>
            </tr>
            <?php
      $sql="SELECT * 
          FROM det_nd 
          where det_nd_ncorr = '$num_nota_debito'";
      $res = mysql_query($sql) or die(mysql_error()); 
      
      while ($registro = mysql_fetch_array($res)) {
        $cantidad = $registro['cantidad'];
        $monto = $registro['monto'];
        $referencias = $registro['referencias'];
        
      
    ?>
        <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
          <td align="center" valign="middle"><div ><font><strong><?php echo $cantidad ?></strong></font></div></td>
          <td align="center" valign="middle"><div ><font><strong><?php echo $monto ?></strong></font></div></td>
          <td align="center" valign="middle"><div ><font><strong><?php echo $referencias ?></strong></font></div></td>
        </tr>
        <?php }?>
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
                <textarea name="txt_observaciones" cols="45" rows="5+" id="txt_observaciones"><?php if (!empty($registronc['referencias'])) {echo ($registronc['referencias']);}?></textarea>
                </font></td>
              <td colspan="2" align="center" valign="middle"><font>
                <input name="txt_monto" type="text" id="txt_monto" size="10" maxlength="10" />
              </font></td>
              <td align="center" valign="middle"><a href="#" id="agregar-fila"><img src="images/guardar.gif" alt="" class="formato_boton" style="width:46px; height:52px;" title="Agregar Repuesto a nota_debito" /></a></td>
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
                echo ("<div id='neto'>NETO: $".number_format($costo_tot_nc, 0, ",", ".")."</div>");
     ?>
              <input type="hidden" name="txt_sumcosto" id="txt_sumcosto"  value="<?php echo number_format($costo_tot_nc, 0, ",", "")?>" size="20" maxlength="30" /></td>
            <td class="CONT">&nbsp;</td>
          </tr>
          <tr>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8" align="right"><span class="CONT">
              <?php
        if (empty($val_iva_nc)){
          $link=Conectarse();
          $sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
          $resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
          $registroiva = mysql_fetch_array($resiva);
          $valor_iva_nc = $registroiva['valor_iva'];
        }else{
          $valor_iva_nc = $val_iva_nc;
        }
        $iva_nc = $costo_tot_nc * ($valor_iva_nc/100);
        
        echo ("<div id='iva'>IVA : $".number_format($iva_nc, 0, ",", ".")."</div>");
     ?>
              <input type="hidden" name="txt_iva" id="txt_iva"  value="<?php echo number_format($iva_nc, 0, ",", "")?>" size="20" maxlength="30" />
            </span></td>
            <td height="8"></td>
          </tr>
          <tr>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8"></td>
            <td height="8" align="right"><span class="CONT">
              <?php
        $total_nc = $costo_tot_nc + $iva_nc;
        
        echo ("<div id='total'>TOTAL : $".number_format($total_nc, 0, ",", ".")."</div>");
     ?>
              <input type="hidden" name="total" id="total"  value="<?php echo number_format($total_nc, 0, ",", "")?>" size="20" maxlength="30" />
            </span></td>
            <td height="8"></td>
          </tr>
        </table>
</td>
            </tr> <?php   
      if ($_POST['buscar']=='Buscar') 
      {   
        if (empty($_POST['txt_nota_debito']))
        {  
          $link=mensaje();
        } else {
          $num_nc     = $_POST['txt_num_nc'];
          $sqlf        = "SELECT * from nota_credito WHERE num_nota_cred ='$num_nc'";
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
            alert('Ingrese número de nota de credito, fecha y/o número de nota_debito');
            </script>";
        }
  ?>
  <?php 
  if ($_POST['OK']=='Guardar y Seguir'){
    $num_nota_debito    = $_POST['txt_nota_debito'];                   
    $accion    = $_POST['accion'];                   
    $num_nc     = $_POST['txt_num_nc'];
    $fecha          = $_POST['cal-field-1'];              
  if (empty($num_nota_debito)or(empty($num_nc)or(empty($fecha)))){  
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
    $sqlf        = "SELECT * from nota_credito WHERE num_nota_cred ='$num_nc'";
    
    $resf        = mysql_query($sqlf,$link) or die(mysql_error()); 
    $registrof   = mysql_fetch_array($resf);
    if (mysql_num_rows($resf)>0) {
      echo "<script> alert (\"Nota de crédito existente.\"); </script>";                              
    }elseif ($registrof['estado']=="NULA") {
      echo "<script> alert (\"Nota de crédito se encuentra NULA.\"); </script>";                              
    }else{  
      //ingresar datos de la nota_debito        
      $sql_001  = "insert into nota_credito (num_nota_cred,cod_cliente,fecha,num_nota_debito, accion) 
              values ('$num_nc','$cod_cliente','$fecha','$num_nota_debito','$accion')";
      //echo "<br />";
      $res_001  = mysql_query($sql_001,$link) or die(mysql_error());
      $observaciones  = $_POST['observaciones'];
      $nro = count($observaciones);
      $monto    = $_POST['monto'];
      $cantidad   = $_POST['cantidad'];
      for($i=0; $i<$nro; $i++){
        $temp = htmlspecialchars_decode($observaciones[$i]);
        $temp = str_replace('Ã', "Ñ",$temp);
        $sql_temp = "insert into det_nc(num_nc, cantidad, monto, referencias) 
              values ('".$num_nc."','".$cantidad[$i]."','".$monto[$i]."', '". htmlspecialchars_decode($temp)."')";
        //echo "<br />"; 
        $res_temp = mysql_query($sql_temp,$link) or die(mysql_error());
        }
      $hora_actual = date("H:i:s");
      $fecha_actual = date("Y-m-d");
      mysql_query("insert into transacciones (fecha, hora, usuario, tipo_documento, folio)  values('$fecha_actual','$hora_actual','$usuario','NC','$num_nc')",$link); 
      echo "<script> alert (\"Proceso realizado con Exito\"); </script>";
      echo "<script language=Javascript> location.href=\"consulta_nc.php?num_nc=".$num_nc."\"; </script>";
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
    $("#txt_num_nc").bind('blur',function() {
        var num_gd = $("#txt_num_nc").val();
          $.ajax({
            url:'classes/nc/buscar-nc.php?num_gd='+num_gd,
            success: function(data){
              if (data=='1'){
                alert("Folio Existente");
                document.getElementById('txt_num_nc').focus();
                } 
              if (data=='2'){
                alert("Folio fuera de rango");
                document.getElementById('txt_num_nc').focus();
                }
              if (data=='3'){
                alert("Folio fuera de rango sugerido");
                document.getElementById('txt_num_nc').focus();
                }
              }
          });
        });
    $('#agregar-fila').live('click',function(){
      var cantidad = $("#txt_cantidad").val();
      var accion = $("#accion").val();
      var observaciones = $("#txt_observaciones").val();
      observaciones = observaciones.replace(/\"/g, ' plg. ');
      var monto = $("#txt_monto").val();
      var tot_fact = 0;
      tot_fact = <?php echo $row_det_fact['tot_arriendo']?>;
      if ((tot_fact=='')||(tot_fact==0)){
          tot_fact = <?php echo $row_det_fact['total_rep']?>;
          }
      var total = cantidad * monto;
      if (total>tot_fact){
        alert("Error. Total mayor al de la nota_debito.");
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
        if (accion=='2'){
          neto_actual = 0;
          }
        document.getElementById('txt_sumcosto').value = neto_actual;

        var iva_actual = neto_actual*(0.19);
        $("#iva").html("IVA : $"+iva_actual);
        if (accion=='2'){
          iva_actual = 0;
          }
        document.getElementById('txt_iva').value = iva_actual;
        
        var total_actual = neto_actual*(1.19);
        $("#total").html("TOTAL : $"+total_actual);
        if (accion=='2'){
          total_actual = 0;
          }
        document.getElementById('total').value = total_actual;  
        }
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
     });
 
</script>

</body>

</html>
