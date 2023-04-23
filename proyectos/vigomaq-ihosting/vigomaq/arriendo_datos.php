<?php ob_start("ob_gzhandler"); 

session_start(); 



$pagina_ir = $_SERVER['REQUEST_URI'];

$usuario="";

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 

if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 

if (!$_SESSION['usuario']) {

    header("Location: ./login.php");

}

function restaFechas($dFecIni, $dFecFin) {

  $dFecIni = str_replace("-","",$dFecIni);

  $dFecIni = str_replace("/","",$dFecIni);

  $dFecFin = str_replace("-","",$dFecFin);

  $dFecFin = str_replace("/","",$dFecFin);



  ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);

  ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);



  $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);

  $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);



  return round(($date2 - $date1) / (60 * 60 * 24));

}

require_once('classes/tc_calendar.php');

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

<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>



<style type="text/css">

<!--

.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }

.Estilo19 { color: #999999;

  font-weight: bold;

}

.Estilo20 {color: #000000}

.Estilo6 {  font-size: large;

  font-family: Arial, Helvetica, sans-serif;

}

.Estilo7 {  color: #FFFFFF;

  font-style: italic;

  font-weight: bold;

  font-family: Verdana, Arial, Helvetica, sans-serif;

}

.Estilo21 { color: #FFFFFF;

  font-style: italic;

  font-weight: bold;

}

.Estilo23 { color: #666666;

  font-style: italic;

  font-weight: bold;

  font-size: 16px;

  font-family: Arial, Helvetica, sans-serif;

}

.Estilo71 { color: #FFFFFF;

  font-style: italic;

  font-weight: bold;

  font-family: Verdana, Arial, Helvetica, sans-serif;

  font-size: 13px;

}

-->

</style>

    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>

    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>

    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>

    <script type="text/javascript">

    function verificar(){

      var frase = document.getElementById('txt_oc').value;

      //frase = frase.replace(/[^a-zA-Z 0-9.]+/g,' ');

      document.getElementById('txt_oc').value = frase;

    }



    </script>

    <style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>

<link rel="shortcut icon" href="http://sebter.cl/favicon.ico">

</head>

<body onload="cambia_tipo_oc()">

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

<table width="80%" border="0">

  <tr>

    <td><form id="form1" name="form1" method="post" action="">

      <table width="80%" height="496" border="0" align="center">

        <tr>

          <td height="22" colspan="5"><?php

    {

    include("classes/conex.php");

    $link=Conectarse();

    }

  ?></td>

        </tr>

        <tr>

          <td width="27%" height="22"><div align="left" class="Estilo6 Estilo19 Estilo20"> <em>

            <?php

      {

        //codigo de arriendo

        $valor2 = $_GET["codarr"];

        

      }

        

        if (!empty($valor2))

        {

          //busqueda datos arriendo

          $link       = Conectarse();

          $sql        = "SELECT * 

                  FROM arriendo_temp 

                  WHERE cod_arriendo ='$valor2' and usuario = '".$usuario."'";

          

          $res        = mysql_query($sql,$link) or die(mysql_error()); 

          $registro   = mysql_fetch_array($res);        

          $valor      = $registro['cod_arriendo'];

          $nom_obrarr = $registro['cod_obra'];

          //busqueda datos cliente

          $rut_cli    = $registro['rut_cliente']; 

          $sql1       = "SELECT * FROM clientes WHERE rut_cliente ='$rut_cli'";

        

          $res1       = mysql_query($sql1,$link) or die(mysql_error()); 

          $registro1  = mysql_fetch_array($res1);

          $nombre_cli = $registro1['raz_social'];

          $codigocli  = $registro1['cod_cliente'];

        

            //buscar datos obra

          $sqlobra     = "SELECT nombre_obra,cod_condic,cod_personal FROM obra WHERE cod_obra ='$nom_obrarr'";

          

          $resobra     = mysql_query($sqlobra,$link) or die(mysql_error()); 

          $registroobra= mysql_fetch_array($resobra);

          

        }   

    ?>

            Paso 3</em></div></td>

          <td height="22" colspan="4"><div align="center" class="Estilo6">

            <div align="right" class="Estilo20"><strong><font>FINALIZAR ARRIENDO</font></strong></div>

            </div></td>

        </tr>

        <tr>

          <td colspan="5"><input type="hidden" name="rut_cli" id="rut_cli" value="<?php echo $rut_cli?>"></td>

        </tr>

        <tr>

          <td colspan="5" bgcolor="#06327D"><span class="Estilo71">

            <?php 

          if (!empty($nombre_cli))

            {

              echo($nombre_cli);

           }else{

              echo(" ");

            }

          ?>

            </span></td>

        </tr>

        <tr>

          <td colspan="5" bgcolor="#06327D"><span class="Estilo21">DATOS <span class="Estilo71">

            <?php if (empty($registro['cod_arriendo'])){ }else{ echo " Arriendo N&deg; " ;}?>

            <span class='mini_titulo'>

              <?php if (empty($registro['cod_arriendo'])){ }else{ echo " : " ;}?>

              <?php if (empty($valor1)&&(empty($valor2))){ }else{ 

           $cantidad = strlen($registro['cod_arriendo']); 

           if ($cantidad==1) { echo ("0000000" .('' . $registro['cod_arriendo'] . ' ') );  }

           if ($cantidad==2) { echo ("000000" .('' . $registro['cod_arriendo'] . ' ') );  }

           if ($cantidad==3) { echo ("00000" .('' . $registro['cod_arriendo'] . ' ') );  } 

           if ($cantidad==4) { echo ("0000" .('' . $registro['cod_arriendo'] . ' ') );  }

           if ($cantidad==5) { echo ("000" .('' . $registro['cod_arriendo'] . ' ') );  }

           if ($cantidad==6) { echo ("00" .('' . $registro['cod_arriendo'] . ' ') );  } 

           if ($cantidad==7) { echo ("0" .('' . $registro['cod_arriendo'] . ' ') );  }

        ?>

              </span>

            <?php } ?>

          </span></span></td>

        </tr>

        <tr>

          <td>Obra</td>

          <td colspan="3" align="left"><input name="txt_obra" type="text" value="<?php if (!empty($registroobra['nombre_obra'])) {echo ($registroobra['nombre_obra']);}else{echo($_GET['txt_obra']);}?><?php // =$_GET['nomequipo'];?>" size="40" maxlength="40" disabled="disabled" /></td>

          <td><input name="hora2" type="hidden" id="hora2" value="<?php  echo date ("H:i:s"); ?>" size="8" maxlength="8" /></td>

        </tr>

        <tr>

          <td>Condiciones de Arriendo</td>

          <td align="left"><input name="txt_condicarr" type="text" value="<?php if (($registroobra['cod_condic'])==1) {echo ("DIAS CORRIDOS");}else{echo("DIAS HABILES");}?>" size="20" maxlength="20" disabled="disabled" /></td>

          <td align="right">Vendedor:</td>

          <td align="left"><input name="ap_patpersonal" type="text" disabled="disabled" value="<?php 

      $cod_per = $registroobra['cod_personal'];

      $link=Conectarse();

      $result=mysql_query("select * from personal where cod_personal='$cod_per'" ,$link);

          $row = mysql_fetch_array($result);

      echo ($row["nombres_personal"].' '.$row["ap_patpersonal"]);?>" size="30" maxlength="30" />          </td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td><div align="left">N&deg; OC:</div></td>

          <td align="left"><input name="txt_oc" id="txt_oc" type="text" value="<?php if (!empty($registro['num_oc'])){echo ($registro['num_oc']);}else{echo($_POST["txt_oc"]) ;}?>" size="18" maxlength="18" onblur="verificar()"/></td>

          <td align="right">Fecha Emision OC:</td>

          <td><input name="fecha_emision_OC" type="text" id="fecha_emision_OC" value="<?php 

        if (!empty($registro['fecha_inicio'])){ //fecha_inicio_OC

        $fecha_temp = explode("-",$registro['fecha_inicio']);

        //año-mes-dia

        //0 -> dia, 1 -> mes, 2 -> año

        $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));

        echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

        }

      else{

        echo($_POST["fecha_emision_OC"]) ;

        }

        ?>" size="10" maxlength="10" readonly="readonly"/>

            <button type="submit" id="btn_fecha_emision_oc">...</button>

            <script type="text/javascript">

            Calendar.setup({

              inputField    : "fecha_emision_OC",

              button        : "btn_fecha_emision_oc",

              align         : "Tr"

            });

            </script></td>

          <td width="5%">&nbsp;</td>

        </tr>

        <tr>

          <td align="left"><div align="left">Tipo Orden de Compra: </div></td>

          <td width="24%" align="left">

          <select name="tipo_oc" id="tipo_oc" onchange="javascript:cambia_tipo_oc();">

            <option value="0">ABIERTA</option>

            <option value="1">CERRADA</option>

            <option value="2" selected="selected">SIN O/C</option>

            <option value="3">PENDIENTE</option>

          </select></td>

          <td width="21%" align="right">Fecha Vencimiento OC:</td>

          <td width="23%"><input name="fecha_vencimiento_OC" type="text" id="fecha_vencimiento_OC" value="<?php  

          if (!empty($registro['fecha_vcmto'])){

          $fecha_temp = explode("-",$registro['fecha_vcmto']);

          //año-mes-dia

          //0 -> dia, 1 -> mes, 2 -> año

          $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));

          echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

          }

        else{

          echo($_POST["fecha_vencimiento_OC"]) ;

          }?>" size="10" maxlength="10" readonly="readonly"/>

            <button type="submit" id="btn_fecha_vencimiento_oc">...</button>

            <script type="text/javascript">

            Calendar.setup({

              inputField    : "fecha_vencimiento_OC",

              button        : "btn_fecha_vencimiento_oc",

              align         : "Tr"

            });

          </script></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td align="left"><div align="left">N&deg; GD:</div></td>

          <?php 

           $sql_num_factura     = "SELECT (COALESCE(num_gd,0)) as ncorr

                  FROM gd

                  WHERE num_gd > 30850 and num_gd < 100000

                  order by num_gd desc";

          

          $res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 

          $registro_num_factura= mysql_fetch_array($res_num_factura);

          $num_factura_nuevo = $registro_num_factura['ncorr'];

          if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 30851;

          else $num_factura_nuevo = $registro_num_factura['ncorr']+1;

            

          if ($num_factura_nuevo=='') $num_factura_nuevo=1;



             $sql_filtro = "select * 

                    from folios_dte

                    where desde <= '".$num_factura_nuevo."' and 

                        hasta >= '".$num_factura_nuevo."' and 

                        tipo = 52";

            $res_filtro = mysql_query($sql_filtro,$link);

            if (mysql_num_rows($res_filtro)==0){

              $num_factura_nuevo = "Error.";

              }

          

            ?>

          <td align="left">

            <input name="txt_numgd" id="txt_numgd" type="text" 

                  onkeypress="return acceptNum(event)" value="<?php if (($_POST['txt_numgd']=='')&&($registrofact['num_gd']=='')) echo $num_factura_nuevo;

                                                                  else if (!empty($registro['num_gd'])){

                                                                    echo ($registro['num_gd']);}

                                                                  else{

                                                                    echo($_POST["txt_numgd"]) ;}

                                                            ?>" size="10" maxlength="10" style="font-size:18px;  color:red; font-weight:bold; border:#F00 solid 2px; padding:5px"/></td>

          <td align="right">Fecha Emisión GD:</td>

          <td><input name="fecha_emision_GD" type="text" id="fecha_emision_GD" value="<?php 

            if (!empty($_POST["fecha_emision_GD"])){

            echo($_POST["fecha_emision_GD"]) ;

            }

          else{

            echo (date("d-m-Y"));

            }?>" size="10" maxlength="10" readonly="readonly"/>

          <button type="submit" id="btn_fecha_emision_gd">...</button>

          <script type="text/javascript">

            Calendar.setup({

              inputField    : "fecha_emision_GD",

              button        : "btn_fecha_emision_gd",

              align         : "Tr"

            });

          </script>

          

          </td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td align="left"><div align="left">Patente</div></td>

          <td align="left">

            <input type="text" name="patente" id="patente" />

          </td>

          <td align="left">

          </td>

          <td>&nbsp;</td>

        </tr>

        

        <tr>

          <td><div align="left">Tipo de garant&iacute;a: </div></td>

          <td colspan="3" align="left"><?php

      $sqlgar = "SELECT * FROM tipo_garantia order by tipo_garantia ASC";

        $resgar = mysql_query($sqlgar,$link) or die(mysql_error()); 

      

      echo "<select name=tipo_garantia>\n"; 



      while($camposgar=mysql_fetch_row($resgar))

      { 

            if ($camposgar[1]=='SIN GARANTIA'){

        $selected = 'selected';

        }

      else{

        $selected = '';

        }

     ?>

            <div align="left">

              <option value="<?php echo $camposgar[0].",".$camposgar[1]?>" <?php echo $selected?>>

                <?php echo $camposgar[1]?>                </option>

              <?php

      }  

                    echo "</select>"; 

          $cargogar = explode( ',', $_POST['tipo_garantia'] );

          $cargo_idgar = $cargogar[0];

          $cargo_contenidogar = $cargogar[1];  

          echo $camposgar; 

     ?>

            </div></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td><div align="left">Forma de pago:</div></td>

          <td colspan="3"><?php

      $sql="SELECT cod_forma_pago, forma_pago FROM forma_pago order by forma_pago ASC";

        $res=mysql_query($sql,$link) or die(mysql_error()); 

      

      echo "<select name=forma_pago>\n"; 



      while($campos=mysql_fetch_row($res))

      { 

      if ($campos[0]=='6'){

        $selected = 'selected';

        }

      else{

        $selected = '';

        }

     ?>

            <div align="left">

              <option value="<?php echo $campos[0].",".$campos[1]?>" <?php echo $selected?>>

                <?php echo $campos[1]?>                </option>

              <?php

      }  

                    echo "</select>"; 

          $cargo = explode( ',', $_POST['forma_pago'] );

          $cargo_id = $cargo[0];

          $cargo_contenido = $cargo[1];  

          echo $campos; 

     ?>

            </div></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td>&nbsp;</td>

          <td colspan="3">&nbsp;</td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td><div align="left">Fecha Arriendo Equipo:</div></td>

          <td><input name="fecha_arriendo" type="text" id="fecha_arriendo" value="<?php 

            if (!empty($registro['fecha_arr'])){

            $fecha_temp = explode("-",$registro['fecha_arr']);

            //año-mes-dia

            //0 -> dia, 1 -> mes, 2 -> año

            $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));

            echo $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year']; 

          }

          else{

            echo $_POST['fecha_arriendo'];

          }

          

          ?>" size="10" maxlength="10" readonly="readonly"/>

            <button type="submit" id="btn_fecha_arriendo">...</button>

            <script type="text/javascript">

            Calendar.setup({

              inputField    : "fecha_arriendo",

              button        : "btn_fecha_arriendo",

              align         : "Tr"

            });

            </script></td>

          <td><div align="left">Hora Arriendo Equipo:</div></td>

          <td><input name="hora" type="text" id="hora" value="<?php  echo date ("H:i:s"); ?>" size="8" maxlength="8" /></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td height="26" valign="top"><div align="left">Forma entrega:</div></td>

          <td colspan="3"><select name="forma_entrega" >

            <option value="1" selected="selected">RETIRA CLIENTE</option>

            <option value="2" >ENTREGA EN OBRA</option>

          </select></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td></td>

          <td colspan="3"></td>

          <td></td>

        </tr>

        <tr>

          <td></td>

          <td colspan="4" align="right"><span class="Estilo71">

            

            <input type="submit" name="OK" id="button" value="Guardar y Seguir" title="Guardar y Finalizar Arriendo" style="background-image:url(images/guardar.png); width:45px; height:45px" class="formato_boton"/>

            

            <!--<input name="OK" type="image" class="boton" title="Guardar y Finalizar Arriendo" value="Guardar y Seguir"  src="images/guardar.png"width="35" height="35" />-->

            

            <input type="submit" name="cancelar" id="button2" value="Cancelar" title="Cancelar Arriendo" style="background-image:url(images/cancelar_arr.png); width:45px; height:45px;" class="formato_boton" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;"/>

            <!--<input name="cancelar" type="image" class="boton" title="Cancelar Ariendo" value="Cancelar"  src="images/cancelar_arr.png"width="35" height="35" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;"  />-->

            

            <a href='arriendo_equipo.php?codarr=<?php echo $registro['cod_arriendo'] ?>'>

            <input type="button" name="volver" value="Volver"  title="Ir Paso 2" style="background-image:url(images/volver.png); width:40px; height:40px" class="formato_boton" onclick=""/>

           <!-- <input type="image" name="volver" value="Volver"  title="Ir Paso 2" src="images/volver.png" onclick="" width="30" height="30"/>-->

           </a>

          </span></td>

          </tr>

        <?php

      function mensaje()

        {

          echo "<script>

          alert('Ingrese Datos Arriendo');

          </script>";

        }

     ?>

          <?php

    if($_POST['cancelar']=='Cancelar')

     { 

       $link         = Conectarse();

       $cod_arriendo = $_GET['cod_arr'];

       $codigo       = trim($_POST['txt_cod']);

       

       //buscar el arriendo

       $sql    = "SELECT * FROM equipos_arriendo_temp WHERE cod_arriendo = '$valor2' and usuario = '".$usuario."'";

       $res=mysql_query($sql);

       

       while ($registro = mysql_fetch_array($res))

       {

        //borrar equipos del arriendo

        $cod_equipo=$registro['cod_equipo'];

        //actualizar estado del equipo

          $sql2    = "UPDATE equipo SET cod_estado_equipo = '1' where cod_equipo =".$registro['cod_equipo']; 

      

        $res2   = mysql_query($sql2) or die(mysql_error()); 

      } 

        

        mysql_query("DELETE FROM equipos_arriendo_temp WHERE cod_arriendo IN(".$valor2.") and usuario = '".$usuario."'");

       

       

       //borrar arriendo

       $sql    = "DELETE FROM arriendo_temp WHERE cod_arriendo = '$valor2' and usuario = '".$usuario."'";

       $res    = mysql_query($sql) or die(mysql_error()); 



       mysql_close($link);  

       

       echo "<script type='text/javascript'>RegistroGrabado();</script>";

    

    ///rcb____

        

    

      echo "<script language=Javascript> location.href=\"menu.php\"; </script>";

     }   

    ?>

        <?php

     $link=Conectarse();

     if ($_POST['OK']=='Guardar y Seguir')

     {

      $tipo_oc       = $_POST['tipo_oc'];               //echo ($tipo_oc)."tipo_oc<br>";

      //echo "<br />";

      //echo $_POST['txt_oc'];               //echo ($tipo_oc)."tipo_oc<br>";

      //echo "<br />";

      //echo $_POST['txt_numgd'];               //echo ($tipo_oc)."tipo_oc<br>";

      //echo "<br />";

      //echo $_POST['fecha_emision_OC'];          //  ec  ho ($vcmto_oc)."vcmto_oc<br>";

      //echo "<br />";

      $vcmto_oc      = $_POST['fecha_vencimiento_OC'];          //  ec  ho ($vcmto_oc)."vcmto_oc<br>";

      //echo "<br />";

      $fecha_arr     = $_POST['fecha_arriendo'];         //  echo ($fecha_arr)."$fecha_arr<br>";

      //echo "<br />";

      //echo $_POST['fecha_emision_GD'];

      //echo "<br />";

      

      $seguir = 1;

      if (($_POST['txt_oc'] != '') and (empty($_POST['fecha_emision_OC'])))

      {

          echo "<script> alert (\"Ingrese Fecha emisión Orden de Compra.\"); </script>";

          $seguir = 0;

      }

      

      

      // RCB Valida Guia de Despacho

      if ($_POST['txt_numgd'] == '')

      {

          echo "<script> alert (\"Ingrese Número Guúa de Despacho.\"); </script>";

          $seguir = 0;

      }

      

      

      

      if ($_POST['txt_oc'] != '')

      {

          // Orden Cerrada

          if(($_POST['tipo_oc'] == 1) and (empty($_POST['fecha_vencimiento_OC'])))

          {

            echo "<script> alert (\"Fecha vencimiento no debe ser vacia\"); </script>";

            $seguir = 0;

          }

          

          $dyh_emision=0;

          $dyh_vcmto=0;

          //dia-mes-año

          //0 -> dia, 1 -> mes, 2 -> año

                    

          if ($_POST['fecha_vencimiento_OC']){

            $fecha_temp = explode("-",$_POST['fecha_vencimiento_OC']);

            //mktime(0,0,0,$mes,$dia,$ano)

            $dyh_vcmto = (mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));

            }

            else{

            $fecha_temp = '0000-00-00';

          }

          //dia-mes-año

          //0 -> dia, 1 -> mes, 2 -> año

          

          if ($_POST['fecha_emision_OC']){

            $fecha_temp = explode("-",$_POST['fecha_emision_OC']);

            //mktime(0,0,0,$mes,$dia,$ano)

            $dyh_emision= (mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));

            }

            else{

            $fecha_temp = '0000-00-00';

          }

          //año-mes-dia

          //0 -> dia, 1 -> mes, 2 -> año

          

          

          // Orden Cerrada

          if(($_POST['tipo_oc'] == 1) and ($dyh_vcmto < $dyh_emision))

          {

            echo "<script> alert (\"".$_POST['fecha_vencimiento_OC']." > ".$_POST['fecha_emision_OC']." -> Fecha vencimiento debe ser mayor que fecha de emision\"); </script>";

            $seguir = 0;

          }

          

          

          // Orden Abierta

          if(($_POST['tipo_oc'] == 0) and ($_POST['fecha_vencimiento_OC'] != ''))

          {

            echo "<script> alert (\"Para orden abierta, no debe haber echa vencimiento ingresada\"); </script>";

            $seguir = 0;

          }

          

      }

      

      //rcb

      if(($_POST['tipo_oc'] == 0) ||($_POST['tipo_oc'] == 1))

      {

         if (!(isset($_POST['txt_oc']))){

          echo "<script> alert (\"Debe ingresar un Número de Orden de Compra y debe ser mayor a 0.\"); </script>";

          $seguir =0;

        }

      }

      

      if (($tipo_oc == "1")and (empty($_POST['fecha_vencimiento_OC'])))

      {

          echo "<script> alert (\"". $_POST['fecha_vencimiento_OC']."->Ingrese Vencimiento Orden de Compra.\"); </script>";

          $seguir =0;

      }

      

      

      if($seguir == 0)

      {

      

      

      }

      else

      {

      

        ?>

        <script>

        var answer = confirm("Confirma Cierre Guía Despacho")

        if (answer)

        {

          seguir2 = 1;

          

        }

        else{

          alert("Ha cancelado el arriendo");

          

          

          //window.location = "procesa_arriendo.php?ir=session";

          

          //alert ('<?php echo  $pagina_ir; ?>');

          window.location = "<?php echo $pagina_ir; ?>";

          //seguir2 = 0;

        }

        

        if(seguir2 == 0)

        {

          $pagina_ir = $_SERVER['REQUEST_URI'];

          

          //window.location = "menu.php";

          

          //window.location = "<?php echo $pagina_ir; ?>";

          

          //window.location = "procesa_arriendo.php?ir="<?php echo $pagina_ir; ?>;

          

          //window.location = "procesa_arriendo.php?ir="<?php echo $pagina_ir; ?>;

          

          //window.location = "procesa_arriendo.php?ir="<?php echo $_GET['codarr']; ?>;

          //window.location = "arriendo_datos.php?codarr="<?php echo $_GET['codarr']; ?>;

          //history.back();

        }

        </script>

        <?php

        

        $resultado_resta = restaFechas($fecha_arr,$vcmto_oc);

        

              $num_oc        = strtoupper($_POST['txt_oc']);

              $tipo_oc       = $_POST['tipo_oc'];           

              

              if ($_POST['fecha_vencimiento_OC']){

                $fecha_temp = explode("-",$_POST['fecha_vencimiento_OC']);

                $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));

                $vcmto_oc  = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];

              }

              else{

                $vcmto_oc = '0000-00-00';

                }

              

              $num_gd        = $_POST['txt_numgd'];

              $patente        = $_POST['patente'];

              $fecha_temp = explode("-",$_POST['fecha_emision_GD']);

              $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));

              $fecha_emision_gd  = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];

              

              $tipo_garantia = $cargo_idgar;

              $forma_pago    = $cargo_id;   

              $vendedor      = $cod_per;    

              

              if ($_POST['fecha_emision_OC']){

                $fecha_temp = explode("-",$_POST['fecha_emision_OC']);

                $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));

                $fecha_inicio  = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  

                }

              else{

                $fecha_inicio = '0000-00-00';

                }

                      

              $fecha_temp = explode("-",$_POST['fecha_arriendo']);

              $dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));

              $fecha_arr  = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];





              $hora_arr      = $_POST['hora'];                

              $forma_entrega = $_POST['forma_entrega'];       

              

              $hora               = $_POST['hora'];                        //     echo "$hora<br>";            

              $tipo_doc           = "ARRIENDO";                              //    echo"$tipo_doc<br>"; 

              $usuario            = $_SESSION['usuario']; //echo "$usuario<br>";

        

              if (empty($oc)||empty($tipo_oc)||empty($num_gd)||empty($tipo_garantia)||empty($forma_pago)||empty($vendedor)||empty($fecha_inicio)||empty($fecha_arr)||empty($hora_arr)||empty($forma_entrega))

              {

                $sqlf        = "SELECT * FROM gd WHERE num_gd ='$num_gd'";

                

                $resf        = mysql_query($sqlf,$link) or die(mysql_error()); 

                $registrof   = mysql_fetch_array($resf);

                

                if (!empty($registrof['num_gd']))

                {

                  echo "<script> alert (\"Guia despacho existente. Ingrese Otro Folio\"); </script>";

                }elseif ($registrof['estado']=='NULA')

                {

                  echo "<script> alert (\"Guia despacho nula. Ingrese Otro Folio\"); </script>";

                }else{

                    //guardar ultimos datos del arriendo

                    $sql = "UPDATE arriendo_temp 

                        SET num_gd='$num_gd', 

                          num_oc='$num_oc',

                          tipo_oc='$tipo_oc', 

                          tipo_garantia='$tipo_garantia', 

                          forma_pago='$forma_pago', 

                          cod_personal='$vendedor', 

                          hora_arr='$hora_arr', 

                          forma_entrega='$forma_entrega',

                          fecha_vcmto='$vcmto_oc',  

                          fecha_inicio='$fecha_inicio', 

                          fecha_arr = '$fecha_arr'

                        where cod_arriendo='$valor2' and usuario = '".$usuario."'";

                    $res  = mysql_query($sql) or die(mysql_error());

                    //echo "<br/>";

                                        

                    $sql = "select *

                        from arriendo_temp

                        where usuario = '".$usuario."'

                        order by cod_arriendo desc

                        limit 0,1";

                    $res = mysql_query($sql) or die(mysql_error());

                    $row = mysql_fetch_array($res);

                    

                    $rut_cliente = $row['rut_cliente'];

                    $cod_obra = $row['cod_obra'];

                    
                    $sql = "insert into arriendo (`rut_cliente`, `cod_obra`, `cod_tarifa`, `cod_personal`, `forma_pago`, `num_gd`, `num_oc`, `tipo_garantia`, `fecha_inicio`, `fecha_vcmto`, `fecha_arr`, `hora_arr`, `fecha_devol`, `hora_devol`, `forma_entrega`, `monto_arriendo`, `tipo_oc`, `vcmto_oc`, `obs_devolucion`)

                                          values ('$rut_cliente','$cod_obra','0','$vendedor','0', '$num_gd','$num_oc','$tipo_garantia','$fecha_inicio','$fecha_inicio','$fecha_arr','$hora_arr','$fecha_arr','$hora_arr','$forma_entrega','0', '$tipo_oc','$vcmto_oc','0')";

                  
                    $res = mysql_query($sql) or die(mysql_error());

                    //echo "<br/>";

                    

                    $sql = "select cod_arriendo from arriendo order by cod_arriendo desc limit 0,1";

                    $res  = mysql_query($sql) or die(mysql_error());

                    $row = mysql_fetch_array($res);

                    $ultimo_cod_arriendo = $row['cod_arriendo'];

                

                    $sql = "UPDATE equipos_arriendo_temp 

                        SET num_gd='$num_gd', 

                          cod_arriendo='$valor2', 

                          arrendado_desde='$fecha_arr', 

                          hora_arr='$hora_arr' 

                        where cod_arriendo='$valor2' and usuario = '".$usuario."'";

                    $res  = mysql_query($sql) or die(mysql_error());

                    //echo "<br/>";

                    //echo "insert into gd (id_arriendo,num_gd,cod_cliente,fecha,tipo,rut_cliente,cod_obra) values ('$ultimo_cod_arriendo','$num_gd','$codigocli','$fecha_emision_gd','$tipo','$rut_cli','$nom_obrarr')";                 

                    //echo "<br/>";

                    mysql_query("insert into gd (`id_arriendo`, `num_gd`, `cod_cliente`, `fecha`, `tipo`, `estado`, `rut_cliente`, `cod_obra`, `patente`, `orden_compra`, `cond_venta`, `hora_actual`, `observaciones`, `tipo_traslado`) 
                                        values ('$ultimo_cod_arriendo','$num_gd','$codigocli','$fecha_emision_gd','$tipo','0','$rut_cli','$nom_obrarr','$patente','0','0','".date("H:i:s")."','0','0')",$link) or die(mysql_error());

  

                    $sql = "select *

                        from equipos_arriendo_temp where usuario = '".$usuario."'";

                    $res = mysql_query($sql) or die(mysql_error());

                    $fila =1;

                    

                    while ($row = mysql_fetch_array($res)){

                      $codigo = $row['cod_equipo'];

                      $precio = 0;  

                      $sqlest = "SELECT det_gd.precio as valor_unidad_arr 

                            FROM equipo 

                              inner join det_gd

                                on det_gd.cod_equipo = equipo.cod_equipo

                            where det_gd.cod_equipo='$codigo'

                              and det_gd.num_gd = '$num_gd'";

                      $resest      = mysql_query($sqlest,$link) or die(mysql_error()); 

                      $registroest = mysql_fetch_array($resest);

                      

                      if (empty($registroest['valor_unidad_arr'])){

                        $sqlest      = "SELECT cod_estado_equipo, valor_unidad_arr 

                                FROM equipo 

                                where cod_equipo='$codigo'";

                        $resest      = mysql_query($sqlest,$link) or die(mysql_error()); 

                        $registroest = mysql_fetch_array($resest);

                      }

                      $precio =   $registroest['valor_unidad_arr'];

                      //`cod_arriendo`, `cod_equipo`, `num_gd`, `nro_factura`, `cod_reclamo`, `arrendado_desde`, `hora_arr`, `arrendado_hasta`, `hora_devol`, `precio`, `comentarios`, `estado_equipo_arr`, `inc_accesorio`, `cod_equipo_arriendo`

                      $sql_1 = "insert into equipos_arriendo (`cod_arriendo`, `cod_equipo`, `num_gd`, `nro_factura`, `cod_reclamo`,
                                                                   `arrendado_desde`, `hora_arr`, `arrendado_hasta`, `hora_devol`, `precio`, 
                                                                   `comentarios`, `estado_equipo_arr`, `inc_accesorio`) 

                      values ('$ultimo_cod_arriendo','$codigo','$num_gd','0','0', 
                              '$fecha_arr','$hora_arr','$fecha_arr','$hora_arr','$precio','0','NO DEVUELTO','0')";

                      $res_1  = mysql_query($sql_1) or die(mysql_error());

                      //echo "<br/>";                     

                      

                      $sql_2 = "UPDATE equipo 

                            SET cod_estado_equipo='3' 

                            where cod_equipo='$codigo'";

                      $res_2  = mysql_query($sql_2) or die(mysql_error());

                      //echo "<br/>";

                      mysql_query("insert into transacciones (fecha, hora, usuario, tipo_documento, folio)  values('$fecha_arr','$hora','$usuario','$tipo_doc','$ultimo_cod_arriendo')",$link);

                      

                      $sqleqarr = "SELECT * FROM equipos_arriendo_temp WHERE cod_equipo ='$codigo'";

                      $reseqarr  = mysql_query($sqleqarr,$link) or die(mysql_error());

                      $regarr= mysql_fetch_array($reseqarr);

                      $cod_equipo = $regarr['cod_equipo'];

                      $inc_accesorio = $regarr['inc_accesorio'];

                      $cantidad = $regeqarr['cantidad'];

                      $link         = Conectarse();

                      $sqlvalor = "SELECT valor_unidad_arr FROM equipo WHERE cod_equipo ='$cod_equipo'";

                      $resvalor  = mysql_query($sqlvalor,$link) or die(mysql_error());

                      $registroval = mysql_fetch_array($resvalor);

                      $precio = $registroval['valor_unidad_arr'];

                      $observaciones = $regeqarr['Observaciones'];

                      //traspasar datos detalle

                      //echo "insert into det_gd (num_gd,cod_equipo,cantidad,precio,observaciones, accesorio) values ('$num_gd','$cod_equipo','1','$precio','$observaciones', '$inc_accesorio')";

                      //echo "<br/>";

                      mysql_query("insert into det_gd (num_gd,fila_num_gd,cod_equipo,cantidad,precio,observaciones, accesorio) values ('$num_gd','$fila','$cod_equipo','1','$precio','$observaciones','$inc_accesorio')",$link);

                      $fila=$fila+1;

                    }

                  echo "<script> alert (\"Proceso realizado con Exito.\"); </script>";

                  echo "<script language=Javascript> location.href=\"doc_arriendo.php?codarr=".$ultimo_cod_arriendo."\"; </script>";

                  }

                }

              }

            }

    ?>

      </table>

    </form></td>

  </tr>

</table>

<br />

<div id="text" style="float:left; clear:left; width:650px; margin-top:10px"></div>

<script language="JavaScript">

<!--

var nav4 = window.Event ? true : false;

function acceptNum(evt){  

// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57  

var key = nav4 ? evt.which : evt.keyCode; 

return (key <= 13 || (key >= 48 && key <= 57));

}





function cambia_tipo_oc(){



  var fechaActual = new Date();

  dia = fechaActual.getDate();

  mes = fechaActual.getMonth() +1;

  anno = fechaActual.getYear();

    if (dia <10) dia = "0" + dia;

  if (mes <10) mes = "0" + mes;  

  //fechaHoy = dia + "/" + mes + "/" + anno;



  fechaHoy1 = <?php echo date('d'); ?>;

  fechaHoy2 = <?php echo date('m'); ?>;

  fechaHoy3 = <?php echo date('Y'); ?>;

  fechaHoy = fechaHoy1+"-"+fechaHoy2 + "-" + fechaHoy3;

  



  valor = document.getElementById('tipo_oc').value;

  

  if(valor == 0)

  {

  

    document.getElementById('txt_oc').readOnly = false;

  

    document.getElementById('fecha_emision_OC').value = fechaHoy;

    document.getElementById('fecha_emision_OC').disabled = false;

  

    document.getElementById('fecha_vencimiento_OC').value = '';

    document.getElementById('fecha_vencimiento_OC').disabled = true;

    document.getElementById('btn_fecha_emision_oc').disabled = false;

    document.getElementById('btn_fecha_vencimiento_oc').disabled = true;

    

  }

  

  if(valor ==1)

  {

    document.getElementById('fecha_emision_OC').value = fechaHoy;

    document.getElementById('fecha_emision_OC').disabled = false;

    document.getElementById('fecha_vencimiento_OC').value = fechaHoy;

  

    document.getElementById('txt_oc').readOnly = false;

    

    document.getElementById('btn_fecha_emision_oc').disabled = false;

    document.getElementById('btn_fecha_vencimiento_oc').disabled = false;

    document.getElementById('fecha_vencimiento_OC').disabled = false;

    

  }

  

  

  

  if(valor == 2 | valor ==3)

  {

    //Campos: Nº OC, Fecha Emisión OC y Fecha Vencimiento OC, deben quedar bloqueados (sin valores)

    document.getElementById('txt_oc').value = '';

    document.getElementById('txt_oc').readOnly = true;

    

    document.getElementById('fecha_emision_OC').value = '0000-00-00';

    document.getElementById('fecha_emision_OC').disabled = true;

    

    document.getElementById('fecha_vencimiento_OC').value = '0000-00-00';

    document.getElementById('fecha_vencimiento_OC').disabled = true;

    

    document.getElementById('btn_fecha_emision_oc').disabled = true;

    document.getElementById('btn_fecha_vencimiento_oc').disabled = true;

    

  }



}

//-->

</script>

<script type="text/javascript" src="script.js"></script>

<script type="text/javascript">

  var menu=new menu.dd("menu");

  menu.init("menu","menuhover");

</script>

<script src="js/jquery-1.6.2.min.js"></script>

<script src="js/jquery.validationEngine.js"></script>

<script src="js/languages/jquery.validationEngine-es.js"></script>

<script>

  $(document).ready(function() {

    $("#frmDatos").validationEngine('attach');

    $("#txt_numgd").bind('blur',function() {

      var num_gd = $("#txt_numgd").val();

      $.ajax({

        url:'classes/consulta-gd/buscar-gd.php?num_gd='+num_gd,

        success: function(data){

          if (data=='1'){

            alert("Folio Existente");

            document.getElementById('txt_numgd').focus();

            } 

          if (data=='2'){

            alert("Folio fuera de rango");

            document.getElementById('txt_numgd').focus();

            }

          if (data=='3'){

            alert("Folio fuera de rango sugerido");

            document.getElementById('txt_numgd').focus();

            }

          }

      });

      //location.href="gd.php?num_gd="+num_gd;

      });

    $("#txt_gd_sali").bind('blur',function() {

      var rut_cliente = $("#rut_cli").val();

      var num_gd = $("#txt_numgd").val();

      $.ajax({

        url:'classes/reclamo/verificar_gd_salida.php?rut_cliente='+rut_cliente+'&num_gd='+num_gd,

        success:function(data){

          alert(data);

          }

        });

       });

     

    });

</script>

</body>



</html>