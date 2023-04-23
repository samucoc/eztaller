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
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo20 {color: #000000}
.Estilo6 {  font-size: large;
  font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {  color: #FFFFFF;
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
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
<style type="text/css">
.Estilo241 {  font-family: Arial, Helvetica, sans-serif;
  font-size: 16px;
  color: #666666;
  font-weight: bold;
  font-style: italic;
}
</style>
</head>
<body>
<table width="98%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td width="48%" valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <br />
       <span class="Estilo24">Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
 </table>
  <div id="div-menu">
    <?php 
      include('classes/menu.php'); //modulo menu
    ?>
  </div><p>&nbsp;</p>
<table width="95%" height="427" border="0" align="center">
    <tr>
      <td width="49%" height="31"></td>
      <td width="51%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13">  
      <?php
        {
          include("classes/conex.php");
          $link=Conectarse();
        }
       ?>
            <?php
          $gd = $_POST['txt_gd'];
          $link=Conectarse();
          if ($gd!=''){
            $sqlgd = "SELECT * FROM gd WHERE num_gd ='$gd'";           
            // echo "sqlfact= $sqlfact<br>";
            $resgd = mysql_query($sqlgd,$link) or die(mysql_error()); 
            $registrogd = mysql_fetch_array($resgd);
            $gd=$registrogd['num_gd'];
            $cod_cli=$registrogd['cod_cliente'];
            //echo($registrofact['num_factura']);
            $sqlcliente = "SELECT * FROM clientes WHERE cod_cliente ='$cod_cli'";
            $rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
            $registro = mysql_fetch_array($rescliente);
            if (empty($_POST['txt_gd'])and($_POST['buscar']=='Buscar')){
              echo "<script>alert('Guia de Despacho No Ingresada');</script>";
              }
          }
      ?>
CONSULTA GUIA DE DESPACHO </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td height="16" colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS GUIA DESPACHO
            <div align="right">
          <?php  $fecha = date ("d-m-Y"); echo($fecha);?>
        </div></span>
      </div></td>
    </tr>
    <tr>
      <td height="372" colspan="2" valign="top"><form action="consulta_gd.php" method="post" name="frmDatos" id="frmDatos">
          <table width="100%" border="0" align="center">
            <tr>
              <td height="8" colspan="2"><input type="hidden" name="txt_numgd" size="20" maxlength="30" value="<?php echo($registrogd['num_gd']);?>" />
                N&deg; Guia de Despacho<span class="Estilo24">
                  <input name="txt_gd" type="text" value="<?php if (!empty($registrogd['num_gd'])) {echo ($registrogd['num_gd']);}else{echo($_POST["txt_gd"]) ;}?>" size="10" maxlength="10" />
                  <input name="cod_arriendo" type="hidden" value="<?php echo $registrogd['id_arriendo'];?>" />
                  <input type="submit" name="buscar" value="Buscar" title="Buscar Guía Despacho" style="background-image:url(images/ver.png); width:16px; height:16px;" class="formato_boton"/></span></td>
              <td height="8" colspan="3"  align="right">Fecha Emision<input name="cal-field-1" type="text" id="cal-field-1" value="<?php if (!empty($registrogd['fecha'])) {echo ($registrogd['fecha']);}else{echo($_POST["cal-field-1"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td width="10%"><div align="left">Rut</div></td>
              <td width="59%"><input name="txt_rut" type="text" id="rut" value="<?php if (!empty($registro['rut_cliente'])) 
      {echo ($registro['rut_cliente']);}else{echo($_POST["txt_rut"]) ;} ?>" size="12" maxlength="12" disabled="disabled"/>
                <span class="Estilo20">
                <input type="hidden" name="txt_cod" size="20" maxlength="30" value="<?php echo $registro['rut_cliente'];?>" />
                </span></td>
              <td height="8" colspan="2"></td>
              <td width="7%" height="8">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Raz&oacute;n Social</div></td>
              <td colspan="3"><input  name="txt_razonsoc" type="text" value="<?php if (!empty($registro['raz_social'])) 
      {echo ($registro['raz_social']);}else{echo($_POST["txt_razonsoc"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td><input  name="txt_codcli" type="hidden" value="<?php if (!empty($registrofact['cod_cliente'])) {echo ($registrofact['cod_cliente']);}else{echo($_POST["txt_codcli"]) ;}?>" size="10" maxlength="10" disabled="disabled"/></td>
            </tr>
            <tr>
              <td><div align="left">Giro</div></td>
              <td colspan="3"><input name="txt_giro" type="text" value="<?php if (!empty($registro['giro_cliente'])) 
      {echo ($registro['giro_cliente']);}else{echo($_POST["txt_giro"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Direcci&oacute;n</div></td>
              <td colspan="3
              "><input name="txt_direccion" type="text" value="<?php if (!empty($registro['direcc_cliente'])) 
      {echo ($registro['direcc_cliente']);}else{echo($_POST["txt_direccion"]) ;}?>" size="50" maxlength="50" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Ciudad</div></td>
              <td colspan="3" align="left"><input name="txt_ciudad" type="text" value="<?php
         if (!empty($registro['cod_ciudad']))
            {
              $sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
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
              <td><div align="left">Comuna</div></td>
              <td colspan="3" align="left"><input name="txt_comuna" type="text" value="<?php
         if (!empty($registro['cod_comuna']))
            {
              $sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
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
              <td><div align="left">Tel&eacute;fono</div></td>
              <td colspan="3"><input name="txt_cod_area" type="text" value="<?php if (!empty($registro['cod_area'])) 
      {echo ($registro['cod_area']);}else{echo($_POST["txt_cod_area"]) ;}?>" size="3" maxlength="3" disabled="disabled"/>
                <input name="txt_fono" type="text" value="<?php if (!empty($registro['fono_cliente'])) 
      {echo ($registro['fono_cliente']);}else{echo($_POST["txt_fono"]) ;}?>" size="8" maxlength="8" disabled="disabled"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Orden de Compra</td>
              <td>
              <?php 
        
        if (!empty($gd)){
          $sqlfpago   = "SELECT * 
                FROM  arriendo
                WHERE num_gd =".$gd;
        $resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
        $registrofp= mysql_fetch_array($resfpago);
          }
        ?>
              <input name="orden_compra" type="text" id="orden_compra" value="<?php 
            if (!empty($registrofp['num_oc'])) {
            echo ($registrofp['num_oc']);
            }
          else{
            if (!empty($registrogd['orden_compra'])){
              echo $registrogd['orden_compra'];
              }
            else{
              echo($_POST["orden_compra"]) ;
              }
            }
        ?>" disabled="disabled"/></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td>Patente</td>
              <td>
              <?php 
        
        if (!empty($gd)){
          $sqlfpago   = "SELECT patente 
                FROM  gd
                WHERE num_gd =".$gd;
        $resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
        $registrofp= mysql_fetch_array($resfpago);
          }
        ?>
           <input name="patente" type="text" id="patente" value="<?php 
            echo ($registrofp['patente']);
           
        ?>" disabled="disabled"/></td>
              <td colspan="3" align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="left">Condicion de Venta/Arriendo</div></td>
              <td><textarea name="txt_cond_venta" cols="63" rows="4" id="txt_cond_venta" disabled="disabled"><?php if (!empty($registrogd['cond_venta'])) {echo ($registrogd['cond_venta']);}else{echo($_POST["txt_cond_venta"]) ;}?>
              </textarea></td>
              <td colspan="3" align="right">
                    <a id="imprimir-arriendo" href="#">
                      <img src="images/Excel-icon.png" width="48" height="48" title="Imprimir Hoja Arriendo" />
                    </a>
                    <a id="imprimir-contrato" href="#"><img width="48" height="48" border="0" class="oculto" title="Imprimir Contrato" src="images/gest_fin/proveedores.png"></a>
      
                    <?php if ($registrogd['estado']!='NULA'){
?>          <a id="vista-previa-gd" href="#" download>
                      <img width="48" height="48" border="0" class="oculto" title="Descargar Guia Despacho" src="images/gest_fin/factura.png" />
                    </a>
                    <?php }?>
        </td>
            </tr>
            <tr class="sortable">
              <th></th>
              <th><input type="hidden" name="txt_cod2" size="20" maxlength="30" />
                <input type="hidden" name="txt_equipo" size="25" maxlength="25" />
                <span class="Estilo241">
                <?php if ($registrogd['estado']=='NULA'){
          echo "<h3 align='center'>Guia de Despacho ".$registrogd['estado']."</h3>";
          }?>
                </span></th>
              <th width="15%"></th>
              <th width="9%"></th>
              <th align="right"></th>
            </tr>
            <tr class="sortable">
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Cantidad</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Detalle</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Valor Unitario</div></th>
              <th bgcolor="#06327D"><div align="center" class="Estilo17">Total</div></th>
              <th><?php
        if (empty($_POST["txt_gd"])) $_POST["txt_gd"]=0;
      $sqldet=" SELECT  det_gd.num_gd, det_gd.cod_equipo, det_gd.cantidad, 
                det_gd.porcentaje_vu, det_gd.precio, det_gd.observaciones, 
                det_gd.accesorio
            FROM  det_gd 
              inner join gd
                on det_gd.num_gd = gd.num_gd
            where gd.num_gd = ".$_POST["txt_gd"]." 
            order by gd.id_arriendo, det_gd.fila_num_gd ASC";
      
      $resdet = mysql_query($sqldet) or die(mysql_error()); 
      while ($registrodet = mysql_fetch_array($resdet)) {
    ?></th>
            </tr>
            <tr bordercolor="#FFFFFF" class="sortable">
        <?php 
                  if (($registrodet['cod_repuesto'] == 0 )&&($registrodet['cod_equipo'] == 0 )) {
        ?>
                
            <td align="left">
      <?php 
        echo($registrodet['cantidad']);?>
            </td>
            <td align="left"><?php 
        echo $registrodet['observaciones'];
       ?></td>
            <td align="right"><?php 
            echo "$".number_format($registrodet['precio'], 0, ",", ".");
        ?>
            </td>
              <td align="center" bgcolor="#FFFFFF"><?php echo("$ ".number_format(($registrodet['precio'] * $registrodet['cantidad']), 0, ",", "."));  $costo_tot = $costo_tot + (($registrodet['precio'])*($registrodet['cantidad']));  ?></td>

        <?php }else{?>            
              <td align="left"><?php echo($registrodet['cantidad']); ?></td>
              <td align="left"><?php 
            if (($registrodet['observaciones']=='CAMBIO')||($registrodet['observaciones']=='POR')){
            echo $registrodet['observaciones']." -> ";
          }
          if (!empty($_POST["txt_gd"]))
            {
              $sqlnomrep="SELECT nombre_equipo FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
              
              $resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
              $registronrep = mysql_fetch_array($resnomrep);
              echo htmlentities($registronrep['nombre_equipo']);
            }else{
              echo(" ");
            }
       ?></td>
              <td align="right"><?php echo("$ ".number_format($registrodet['precio'], 0, ",", ".")) ;?></td>
              <td align="right"><?php echo("$ ".number_format(($registrodet['precio'] * $registrodet['cantidad']), 0, ",", "."));  $costo_tot = $costo_tot + (($registrodet['precio'])*($registrodet['cantidad']));  ?></td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <?php }?>
            </tr>
            <tr class="sortable">
              <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <td class="CONT">&nbsp;</td>
              <td class="CONT">&nbsp;</td>
              <td class="CONT"  align="right">&nbsp;</td>
              <td class="CONT">&nbsp;</td>
            </tr>
            <tr class="sortable">
              <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
              <?php
        }
        mysql_free_result($resdet);
        mysql_close($link); 
     ?>
              <td class="CONT">&nbsp;</td>
              <td colspan="2" align="right" class="CONT"><?php echo ("NETO: $".number_format($costo_tot, 0, ",", "."));?>
              <input type="hidden" name="txt_sumcosto"  value="<?php echo $costo_tot?>" size="20" maxlength="30" /></td>
              <td class="CONT">&nbsp;</td>
            </tr>
            <tr>
              <td height="8"></td>
              <td height="8"></td>
              <td height="8" colspan="2" align="right"><span class="CONT">
                <?php $iva = $costo_tot * 0.19; echo ("IVA : $".number_format($iva, 0, ",", ".")); ?>
                <input type="hidden" name="txt_iva"  value="<?php echo $iva?>" size="20" maxlength="30" />
              </span></td>
              <td height="8"></td>
            </tr>
            <tr>
              <td height="8"></td>
              <td height="8"></td>
              <td height="8" colspan="2" align="right"><span class="CONT">
                <?php $total = $costo_tot + $iva; echo ("TOTAL : $".number_format($total, 0, ",", "."));?>
                <input type="hidden" name="txt_iva2"  value="<?php echo $costo_tot?>" size="20" maxlength="30" />
              </span></td>
              <td height="8"></td>
            </tr>
          </table>
      </form></td>
    </tr>
  </table>
       <?php
    function mensaje()
      {
        echo "<script> alert('Ingrese Numero Guia de Despacho');</script>";
        echo "<script language=Javascript> location.href=\"consulta_gd.php\"; </script>";
      }
    ?>

</div>
<script type="text/javascript">
  var menu=new menu.dd("menu");
  menu.init("menu","menuhover");
</script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
  $(document).ready(function(){

    $("#imprimir-contrato").fancybox({
      'width'       : '100%',
      'height'      : '100%',
      'autoScale'   : false,
      'transitionIn'  : 'none',
      'transitionOut' : 'none',
      'type'        : 'iframe'
      });

    $("#vista-previa-gd").attr('href','classes/consulta-gd/vista-previa-gd.php?num_gd=<?php echo $gd ?>&embedded=true');
    var temporal =  parseInt(<?php echo $registrogd['id_arriendo']; ?>);
    if (temporal){
      $("#imprimir-arriendo").attr('href','hoja_arriendo.php?num_gd=<?php echo $gd ?>');
      $("#imprimir-contrato").attr('href','doc_arriendo_contrato.php?num_gd=<?php echo $gd ?>');
      }
    else{
      $("#imprimir-arriendo").hide();
      $("#imprimir-contrato").hide();
      }

    });
</script>

</body>

</html>

