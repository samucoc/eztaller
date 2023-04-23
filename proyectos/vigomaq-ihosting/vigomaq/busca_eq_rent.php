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

function tranf_fecha_1($fecha){
	$fecha_temp = explode("/",$fecha);
	$fecha_temp = explode("-",$fecha);
	//dia-mes-año
	//0 -> dia, 1 -> mes, 2 -> año
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[0], $fecha_temp[2]));
	return $fecha = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday']; 
	}

function tranf_fecha_2($fecha){
	$fecha_temp = explode("-",$fecha);
	//año-mes-dia
	//0 -> año, 1 -> mes, 2 -> dia
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
	return $fecha = $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year']; 
	}

function restaFechas($dFecIni, $dFecFin){
    $dFecIni = str_replace("-","",$dFecIni);
    $dFecFin = str_replace("-","",$dFecFin);
    
    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
 
    $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
 
    return round(($date2 - $date1) / (60 * 60 * 24));
	}

function DiferenciaEntreFechas($fecha_principal, $fecha_secundaria, $formato_salida, $tipo_arriendo = 1){
 	if ($tipo_arriendo==1){
		$f0 = strtotime($fecha_principal);
		$f1 = strtotime($fecha_secundaria);
		if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
		return date($formato_salida, $f0 - $f1);
		}
	else{
		$sum =0;
		$fecha1  = $fecha_principal;
		//$fecha1=str_replace("/", "-", $fecha1);
		$fecha1=strftime('%Y-%m-%d',strtotime($fecha1));	
	 
		$fecha2  = $fecha_secundaria; 
		//$fecha2=str_replace("/", "-", $fecha2);
		$fecha2=strftime('%Y-%m-%d',strtotime($fecha2)); 

		$fecha1 = strtotime($fecha1); 
		$fecha2 = strtotime($fecha2); 
		
		for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
			if (($tipo_arriendo==2)||($tipo_arriendo==7)){
				if((strcmp(date('D',$fecha1),'Sun')!=0) and (strcmp(date('D',$fecha1),'Sat')!=0)){
					$sum=$sum+1;
				}
			}elseif (($tipo_arriendo==4)||($tipo_arriendo==5)){
				if((strcmp(date('D',$fecha1),'Sun')!=0)){
					$sum=$sum+1;
				}
			}
		}   
		return $sum;
		}
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
	</div><table width="550" border="0" align="center">
    <tr>
      <td>      <?php
			{
			include("classes/conex.php");
			$link=Conectarse();
			}
		?>
		 <?php
			{
				$valor1 = $_GET["id"];
				//$valor1=1;
				//"valor 1 = $valor1";
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
                <input type="hidden" name="txt_cod"> <input type="text" name="txt_equipo" size="45" maxlength="45" />
              </font> </td>
              <td valign="bottom"><div align="left">
                <input type="submit" name="OK" value="Equipo a Evaluar" title="Equipo a Analizar"/>
                <!--<input name="OK" type="image" class="boton" title="Equipo a Analizar" value="Equipo a Evaluar"  src="images/maquinarias_volver.png" align="left" width="30"  height="30"/>-->
              </div></td>
            </tr>
          </table>
        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
              <th width="38%" bgcolor="#06327D"><span class="Estilo17">C&oacute;digo Equipo </span></th>
              <th width="49%" bgcolor="#06327D" class="CONT"><span class="Estilo17">Nombre</span></th>
              <th width="13%" bgcolor="#06327D" class="CONT"><?php
		$codigo = "";
$txt_codigo = "";
if ($_GET["id"]!=""){
   $txt_codigo = $_GET["id"];	
   if ($txt_codigo=='0') $txt_codigo =" ";
   $codigo = " where cod_equipo like '".trim($txt_codigo) ."%'";

}

$nombre = "";
$txt_nombre = "";
if ($_GET["nombre"]!=""){
   $txt_nombre = $_GET["nombre"];	
   $txt_codigo = $_GET["nombre"];
   $codigo = " where nombre_equipo like '%" . $txt_nombre . "%'";

}

$sql="SELECT * FROM equipo ".($codigo);

$res=mysql_query($sql);
$numeroRegistros=mysql_num_rows($res);
if($numeroRegistros<=0)
{
    "<div align='center'>";
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
    echo "</div>";
}else{
    //////////elementos para el ord   	
	echo "<div align='center' class='Estilo17'>";
	echo "<font face='verdana' size='-2'>Se encontraron ".$numeroRegistros." resultados</font>";
    echo "</div>";
    if(!isset($orden))
    {
       $orden="cod_equipo";
"cod_equipo";
    }
    //fin elementos de orden

    //calculo de elementos necesarios para paginacion
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

//fin de dicho calculo

//creacion de la consulta con limites
$sql="SELECT * FROM equipo ".$codigo." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag;

$res=mysql_query($sql);

//fin consulta con limites


if(isset($txt_codigo)){

}

			while ($registro = mysql_fetch_array($res)) {
		 ?></th>
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
			  ?> </td>
              <td bgcolor="#FFFFFF"><?php echo htmlentities($registro['nombre_equipo']) ;?></td>
              <td align="center" bgcolor="#FFFFFF"><?php if (!empty($registro['cod_equipo']) && is_dir('images/producto'.$registro['cod_equipo'].'/'))
					   {
					   $codproducto  = $registro['cod_equipo'];
					   $codproducto2 = $registro['cod_equipo'];
					   $codproducto2 = preg_replace("/&Ntilde;/", "%D1", $codproducto2);
					   $codproducto2 = preg_replace("/&ntilde;/", "%F1", $codproducto2);	
					   $result2 = mysql_query("SELECT cod_equipo FROM equipo WHERE cod_equipo = '$txt_cod'" );
									
					   $row2=mysql_fetch_array($result2); 
					    echo '<div class="logo">'.'<img src="images/producto'.$codproducto2.'/thumb/foto0.thumb.jpg"></div>'; 
						}  ?></td>
            </tr>
            <tr>
              <td bordercolor="#FFFFFF" class="CONT">------------------------------------</td>
              <td bordercolor="#FFFFFF" class="CONT">----------------------------------------------</td>
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
              if ($_POST['OK']=='Equipo a Evaluar')
             {
                    
                    $link=Conectarse();
                    $sqlelim = "DELETE FROM rentabilidad";
                    $reselim = mysql_query($sqlelim,$link) or die(mysql_error());
                    
                    $valor1 = trim($_POST['txt_cod']);
					$valor1 = (int) ($valor1);
                    //echo($valor1);
                    //agregar inversion inicial
                    $sqlequipo  = "SELECT * FROM equipo WHERE cod_equipo ='$valor1'";
                    
                    $resequipo  = mysql_query($sqlequipo,$link) or die(mysql_error()); 
                    $registro1  = mysql_fetch_array($resequipo);
                    $fecha = $registro1['fecha_compra'];
                    
                    $fecha = tranf_fecha_1($fecha);
                    
                    $egreso = $registro1['valor_compra'];
                    $concepto = "INVERSION INICIAL";
                    
                    mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, egreso) values ('$valor1','$fecha','$concepto','$egreso')",$link);
                    
                    //buscar otros gastos	
                    $sqlotrosg = "SELECT * FROM otros_gastos_e WHERE cod_equipo ='$valor1'";
                    $resotrog  = mysql_query($sqlotrosg,$link) or die(mysql_error());
                    while ($registro2 = mysql_fetch_array($resotrog)) {
                        $fecha = $registro2['fecha_gasto'];
                        $egreso = $registro2['monto_gasto'];
                        $concepto = $registro2['Observaciones'];
                        //traspasar datos de otros gastos a rentabilidad
                        $tipo_ajuste = $registro2['tipo_ajuste'];
                        if ($tipo_ajuste=='egreso'){
                            mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, egreso) values ('$valor1','$fecha','$concepto','$egreso')",$link);
                            }
                        elseif ($tipo_ajuste=='ingreso'){
                            mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, ingreso) values ('$valor1','$fecha','$concepto','$egreso')",$link);
                            }
                        
                    }
                    //buscar reparaciones
                
                    $sqlrepara = "SELECT * FROM reparacion_equipos WHERE cod_equipo ='$valor1'";
                    
                    $resrepara = mysql_query($sqlrepara,$link) or die(mysql_error()); 
                    $registro3 = mysql_fetch_array($resrepara);
                    $fecha3 = $registro3['fecha_reparacion'];
                    $concepto3 = "REPAR.".$registro3['detalle_reparacion'];
                    $monto_repara = ($registro3['valor_reparacion']*$registro3['cant_hh']);
                    $codigo_rep   = $registro3['cod_reparacion'];
                    
                      $resultrep="SELECT SUM(tot_rep) as total_detrep FROM det_reparacion WHERE cod_reparacion = '$codigo_rep'";
                      $rs_rep=mysql_query($resultrep);
                      $filas=mysql_result($rs_rep,0,"total_detrep");
                      $monto3 = $monto_repara + $filas;
                      if ($monto3 > 0){
                      mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, egreso) values ('$valor1','$fecha3','$concepto3','$monto3')",$link);}
                
                    //buscar evaluaciones tecnicas
                    $sqlevaltec = "SELECT * FROM eval_tecnica WHERE cod_equipo ='$valor1'";
                    $resevaltec= mysql_query($sqlevaltec,$link) or die(mysql_error()); 
                    while ($registro4 = mysql_fetch_array($resevaltec)) {
                        $cod_eval_tecnica =	$registro4['cod_eval_tecnica'];
                        //buscar detalle de la evaluacion tecnica
                        $sqldeteval = "SELECT * FROM det_eval WHERE cod_eval_tecnica ='$cod_eval_tecnica'";
                        $resdeteval= mysql_query($sqldeteval,$link) or die(mysql_error()); 
                        while ($registro5 = mysql_fetch_array($resdeteval)) {
                            $monto4 = ($registro5['hh']*$registro5['valorhora']);
                            $concepto4 = "EVAL.TEC.".$registro5['concepto'];
                            $fecha4 = $registro4['fecha_evaluacion'];
                            //traspasar datos de evaluacion tecnica a rentabilidad
                            mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, egreso) values ('$valor1','$fecha4','$concepto4','$monto4')",$link);
                        }
                    }
                    
                    //buscar notas de credito
                    $sqlnotacred = "SELECT * FROM nota_credito WHERE codigo_eq_rep ='$valor1'";
                    $resnotacred= mysql_query($sqlnotacred,$link) or die(mysql_error()); 
                    while ($registronc = mysql_fetch_array($resnotacred)) {
                            $montonc = ($registronc['monto_nc']);
                            $conceptonc = "NOTA.CRED.".$registronc['referencias	'];
                            $fechanc = $registronc['fecha'];
                            //traspasar datos de notas de credito a rentabilidad
                            mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, egreso) values ('$valor1','$fechanc','$conceptonc','$montonc')",$link);
                        }
                     
                    
                    //buscar facturas
                    $sqlfactura = "SELECT * FROM det_factura WHERE cod_equipo ='$valor1' ";
                    $resfactura= mysql_query($sqlfactura,$link) or die(mysql_error()); 
                    while ($registro6 = mysql_fetch_array($resfactura)) {
                        $cod_factura =	$registro6['num_factura'];
                        //buscar detalle de la evaluacion tecnica
                        $sqlfact = "SELECT * FROM factura WHERE num_factura ='$cod_factura' and estado <> 'NULA'";
                        $resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
                        while ($registro7 = mysql_fetch_array($resfact)) {
                            $monto6 = ($registro6['tot_arriendo']);
                            $concepto6 = "FACTURA - Nro. ".$cod_factura." - Dias Ajuste ".$registro6['dias_ajuste']." - Cantidad días - ".$registro6['dias_arriendo'] ;
                            $fecha6 = $registro7['fecha'];
                            //traspasar datos de evaluacion tecnica a rentabilidad
                            mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, ingreso) values ('$valor1','$fecha6','$concepto6','$monto6')",$link);
                            
                            $sql_num_gd = "select num_gd, arrendado_desde, arrendado_hasta
                                            from equipos_arriendo
                                            where nro_factura = '$cod_factura'
                                                and cod_equipo = '$valor1'";
                            $res_num_gd = mysql_query($sql_num_gd,$link) or die(mysql_error());	
                            $row_num_gd = mysql_fetch_array($res_num_gd);
                            
                            $num_gd = $row_num_gd['num_gd'];
                            $arrendado_desde = $row_num_gd['arrendado_desde'];
                            $arrendado_hasta = $row_num_gd['arrendado_hasta'];
                            
                            $sql_cambio = "select equipos_arriendo.num_gd, equipos_arriendo.arrendado_desde, equipos_arriendo.arrendado_hasta, equipos_arriendo.precio, equipos_arriendo.cod_reclamo, obra.cod_condic
                                            from equipos_arriendo
												inner join arriendo
													on equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
												inner join obra
													on obra.cod_obra = arriendo.cod_obra
                                            where equipos_arriendo.num_gd = '".$num_gd."'
                                                and equipos_arriendo.arrendado_desde = '".$arrendado_desde."'
                                                and equipos_arriendo.arrendado_hasta <= '".$arrendado_hasta."'
                                                and equipos_arriendo.estado_equipo_arr like '%CAMBIO'
                                            order by arrendado_hasta desc
                                            limit 0,1";
                            $res_cambio = mysql_query($sql_cambio,$link) or die(mysql_error());
							
                            if (mysql_num_rows($res_cambio)>0){
                                while($row_cambio = mysql_fetch_array($res_cambio)){
									$cantidad_dias = DiferenciaEntreFechas($row_cambio['arrendado_desde'],$row_cambio['arrendado_hasta'],"d",$row_cambio['cod_condic']);		 
									$precio  = $row_cambio['precio'];
									$row_cambio['cod_reclamo'];
									$sql_reclamo = "select num_gd_salida,cod_equipo_dev
                                                    from reclamo
                                                    where cod_reclamo = ".$row_cambio['cod_reclamo'];			
                                    $res_reclamo = mysql_query($sql_reclamo,$link) or die(mysql_error());
                                    $row_reclamo = mysql_fetch_array($res_reclamo);
    
                                    if ($precio==0){
                                  $sql_010 = "select cod_equipo_dev
													from equipos_arriendo
														inner join reclamo
															on equipos_arriendo.cod_reclamo = reclamo.cod_reclamo
													where equipos_arriendo.num_gd = ".$num_gd."
														and reclamo.cod_reclamo <> 0
														and reclamo.cod_equipo_entreg = ".$valor1."";
										$res_010 = mysql_query($sql_010,$link) or die(mysql_error());
										$row_10 = mysql_fetch_array($res_010);
										
										$cod_equipo_entre = $row_10['cod_equipo_dev'];
										$i=0;
                    if (mysql_num_rows($res_010)>0){
  										while ($i==0){
  											$sql_gd = "select precio
  														from det_gd
  														where num_gd = ".$num_gd."
  															and cod_equipo = ".$cod_equipo_entre;
  											$res_gd = mysql_query($sql_gd,$link) or die(mysql_error());
  											if (mysql_num_rows($res_gd)>0){
  												$row_gd = mysql_fetch_array($res_gd);
  												$precio = $row_gd['precio'];
  												$i=1;
  												}
  											else{
  												$sql_010 = "select cod_equipo_dev
  															from equipos_arriendo
  																inner join reclamo
  																	on equipos_arriendo.cod_reclamo = reclamo.cod_reclamo
  															where equipos_arriendo.num_gd = ".$num_gd."
  																and reclamo.cod_reclamo <> 0
  																and reclamo.cod_equipo_entreg = ".$cod_equipo_entre." ";
  												$res_010 = mysql_query($sql_010,$link) or die(mysql_error());
  												$row_10 = mysql_fetch_array($res_010);
  												
  												$cod_equipo_entre = $row_10['cod_equipo_dev'];
  												}
  											}
                      }
                                        }

									$dias_totales = $registro6['dias_arriendo'] + $registro6['dias_ajuste'];
									$dias_ajuste = $registro6['dias_ajuste'];
									$porcentaje_ajuste = ($dias_ajuste*100)/$dias_totales;
									$monto = ($cantidad_dias*$precio) - (($cantidad_dias*($porcentaje_ajuste/100))*$precio);
									$concepto = "FACTURA - Nro. ".$cod_factura." - Ajuste Cambio Nro. ".$row_reclamo['num_gd_salida'];
                                    mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, egreso) values ('$valor1','".$row_cambio['arrendado_desde']."','$concepto','$monto')",$link);
                                    }
                                }
                            }
                        }
                    //bscar cambios	16
					       $sql_cambio = "select *
                                    from equipos_arriendo
                                        inner join arriendo
                                            on equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
                                        inner join obra
                                            on obra.cod_obra = arriendo.cod_obra
                                    where equipos_arriendo.cod_equipo = '$valor1'
                                        and equipos_arriendo.estado_equipo_arr like '%CAMBIO'
                                    order by equipos_arriendo.arrendado_desde ";
                    $res_cambio = mysql_query($sql_cambio,$link) or die(mysql_error());
                    if (mysql_num_rows($res_cambio)>0){
                        while($row_cambio = mysql_fetch_array($res_cambio)){
    
                            $num_gd  = $row_cambio['num_gd'];
                            $arrendado_desde = $row_cambio['arrendado_desde'];
                            $arrendado_hasta = $row_cambio['arrendado_hasta'];
                            $precio  = $row_cambio['precio'];
                            
                          $sql_fecha_fact = "select distinct num_gd 
                                                from equipos_arriendo 
                                                where arrendado_hasta >= '".$row_cambio['arrendado_hasta']."'
													and equipos_arriendo.cod_equipo = '$valor1'
                                                    and estado_equipo_arr like '%-FACTURADO'";
							$res_fecha_fact = mysql_query($sql_fecha_fact,$link) or die(mysql_error());
                            if (mysql_num_rows($res_fecha_fact)>0){				
                               $sql_busca = "select det_gd.num_gd, arrendado_desde, arrendado_hasta, det_gd.precio
                                                from equipos_arriendo
                                                    inner join det_gd
                                                        on det_gd.num_gd = equipos_arriendo.num_gd
                                                where det_gd.num_gd = '".$num_gd."'
                                                    and arrendado_desde >= ".$arrendado_desde."
                                                    and arrendado_hasta <= ".$arrendado_hasta."
                                                    and arrendado_hasta <> '0000-00-00'
                                                order by arrendado_hasta desc
                                                limit 0,1";
                                $res_busca = mysql_query($sql_busca,$link) or die(mysql_error());
                                $desde ="";
                                $hasta="";
                                if (mysql_num_rows($res_busca)>0){
                                    while($row_busca=mysql_fetch_array($res_busca)){
                                        $cantidad_dias = DiferenciaEntreFechas($row_busca['arrendado_hasta'],$row_cambio['arrendado_hasta'],"d",$row_cambio['cod_condic']);	
                                        $desde = $row_busca['arrendado_hasta'];
                                        $hasta = $row_cambio['arrendado_hasta'];
		                               	$precio = $row_busca['precio'];
                                        }
                                    }
                                else{
                                    $cantidad_dias = DiferenciaEntreFechas($row_cambio['arrendado_desde'],$row_cambio['arrendado_hasta'],"d",$row_cambio['cod_condic']);	
                                    $desde = $row_cambio['arrendado_desde'];
                                    $hasta = $row_cambio['arrendado_hasta'];
                                    }
                               $sql_reclamo = "select num_gd_salida, cod_equipo_dev
                                                        from reclamo
                                                        where cod_reclamo = ".$row_cambio['cod_reclamo'];			
                                $res_reclamo = mysql_query($sql_reclamo,$link) or die(mysql_error());
                                $row_reclamo = mysql_fetch_array($res_reclamo);
                                if ($precio==0){
                                   $sql_010 = "select cod_equipo_dev
												from equipos_arriendo
													inner join reclamo
														on equipos_arriendo.cod_reclamo = reclamo.cod_reclamo
												where equipos_arriendo.num_gd = ".$num_gd."
													and reclamo.cod_reclamo <> 0
													and reclamo.cod_equipo_entreg = ".$valor1."";
									$res_010 = mysql_query($sql_010,$link) or die(mysql_error());
									$row_10 = mysql_fetch_array($res_010);
									
									$cod_equipo_entre = $row_10['cod_equipo_dev'];
									$i=0;
									if(!empty($cod_equipo_entre)){
										while ($i==0){
											$sql_gd = "select precio
														from det_gd
														where num_gd = ".$num_gd."
															and cod_equipo = ".$cod_equipo_entre;
											$res_gd = mysql_query($sql_gd,$link) or die(mysql_error());
											if (mysql_num_rows($res_gd)>0){
												$row_gd = mysql_fetch_array($res_gd);
												$precio = $row_gd['precio'];
												$i=1;
												}
											else{
												$sql_010 = "select cod_equipo_dev
															from equipos_arriendo
																inner join reclamo
																	on equipos_arriendo.cod_reclamo = reclamo.cod_reclamo
															where equipos_arriendo.num_gd = ".$num_gd."
																and reclamo.cod_reclamo <> 0
																and reclamo.cod_equipo_entreg = ".$cod_equipo_entre." ";
												$res_010 = mysql_query($sql_010,$link) or die(mysql_error());
												$row_10 = mysql_fetch_array($res_010);
												
												$cod_equipo_entre = $row_10['cod_equipo_dev'];
												}
											}
										}
									else{
											$sql_gd = "select precio
														from det_gd
														where num_gd = ".$num_gd."
															and cod_equipo = ".$valor1;
											$res_gd = mysql_query($sql_gd,$link) or die(mysql_error());
											if (mysql_num_rows($res_gd)>0){
												$row_gd = mysql_fetch_array($res_gd);
												$precio = $row_gd['precio'];
												$i=1;
												}
										
										}
                                    }
        
                                $num_gd_salida = $row_reclamo['num_gd_salida'];

                               $sql_fact = "select dias_arriendo, dias_ajuste
                                                from equipos_arriendo
													inner join factura
														on equipos_arriendo.cod_arriendo = factura.cod_arriendo 
													inner join det_factura
														on factura.num_factura = det_factura.num_factura
                                                where num_gd = '".$num_gd."'
                                                    and arrendado_hasta >= ".$arrendado_hasta."
                                                    and estado_equipo_arr like '%-FACTURADO'
                                                order by arrendado_hasta asc
                                                limit 0,1";
                                $res_fact = mysql_query($sql_fact,$link) or die(mysql_error());
								$row_fact = mysql_fetch_array($res_fact);
                                
                                $dias_totales = $row_fact['dias_arriendo'] + $row_fact['dias_ajuste'];
								$dias_ajuste = $row_fact['dias_ajuste'];
								$porcentaje_ajuste = ($dias_ajuste*100)/$dias_totales;
								$monto = ($cantidad_dias*$precio) - (($cantidad_dias*($porcentaje_ajuste/100))*$precio);
								
								$concepto = "CAMBIO - Desde ".tranf_fecha_2($desde)." - Hasta ".tranf_fecha_2($hasta)." - Guia Nro. ".$num_gd_salida." - Cant dias ".$cantidad_dias." - Precio Unitario ".$precio; 
                                mysql_query("insert into rentabilidad (cod_equipo, fecha, concepto, ingreso) values ('$valor1','".$row_cambio['arrendado_desde']."','$concepto','$monto')",$link);
                                }
                            }
                        }
                  $codigo       = trim($_POST['txt_cod']);
                  $nomequipo    = trim($_POST['txt_equipo']);
                  $nomequipo = str_replace('"', '', $nomequipo);
                 echo "<script language=Javascript> location.href=\"rentabilidad.php?codequipo=".$codigo."&nomequipo=".$nomequipo."\"; </script>";	
                } else {
                    $link=mensaje();
                }
             }
        ?>
          </table>
         
      <br><a hre
      f="rentabilidad.php" onmouseover="Volver"><img src="images/volver.png" width="40" height="40" align="right" border="0"/></a>
      <table border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center" valign="top"><?php //a partir de aqui viene la paginacion
    if($pagina>1)
    {
       echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&nombre=".$txt_codigo."&id=".$txt_codigo."'>";
       echo "<font face='verdana' size='-2'>anterior</font>";
       echo "</a> ";
    }

    for($i=$inicio;$i<=$final;$i++)
    {
       if($i==$pagina)
       {
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>";
       }else{
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&nombre=".$txt_codigo."&id=".$txt_codigo."'>";
          echo "<font face='verdana' size='-2'>".$i."</font></a> ";
       }
    }
    if($pagina<$numPags)
   {
       echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&nombre=".$txt_codigo."&id=".$txt_codigo."''>";
       echo "<font face='verdana' size='-2'>siguiente</font></a>";
   }
//fin de la paginacion

//}
?></td>
        </tr>	
         
      </table>


      </form></td>
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