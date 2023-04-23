<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
include "../includes/php/phpmailer/class.phpmailer.php";
include "../includes/php/phpmailer/class.pop3.php";
include "../includes/php/phpmailer/class.smtp.php";

$xajax = new xajax();

$xajax->setRequestURI("sg_combustible_ce_penau.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function EnviarCorreo($data, $id_carga, $tipo){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
		$autoriza=$carga_monto=$detalle="";
		if ($tipo="Carga Extra"){
	      	$sql = "select *
					from cargas_extras 
        	        where ce_ncorr = '".$id_carga."'";
			$res = mysql_query($sql,$conexion);
			$row = mysql_fetch_array($res);
			$autoriza		=	$row["ce_pers_aut"];
			$carga_monto	=	$row["ce_monto"];
			$detalle		=	$row["ce_obs"];
			}
		else{
			//$sql = "select *
			//		from cargas_adelantos
        	//       where ca_ncorr = '".$id_carga."'";
			//$res = mysql_query($sql,$conexion);
			//$row = mysql_fetch_array($res);
			//$autoriza		=	$row["ca_pers_aut"];
			//$carga_monto	=	$row["ca_monto"];
			//$detalle		=	$row["ca_obs"];			
			}
		
		$sql_1 = "select *
                from correos
                where nombre = '".$autoriza."'";
        $res_1 = mysql_query($sql_1,$conexion);
        $row_1 = mysql_fetch_array($res_1);
        $correo_autoriza = $row_1['correo'];
		
		$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com from personas where pers_rut = '".$row["ce_pers"]."'";
		$res_pr = mysql_query($sql_pr, $conexion);
		$trabajador = @mysql_result($res_pr,0,"pers_nombre_com");
		
        $body ="<html>
			<head>
			<style>
            .floatLeft{
                float:left;
            }
            .clearBoth{
                clear:both;
            }
            .treinta{
                width:30%;
            }
            .sesenta{
                width:60%;
            }
	        </style>
			</head>";
        $body             .= "<body><div>";
        $body             .= "<p>RECORDATORIO</p>";
        $body             .= "<p>RECORDATORIO</p>";
        $body             .= "<p>RECORDATORIO</p>";
        $body             .= "<p>Se recuerda autorizar carga al trabajador ".$trabajador." por $".$carga_monto."</p>";
        $body             .= "<div class='treinta floatLeft'>Asunto</div>";
        $body             .= "<div class='sesenta floatLeft'>".$detalle."</div>";
        $body             .= "<br class='clearBoth'/>";
        $body             .= "<br />";
        $body             .= "<p class='clearBoth'>RECORDATORIO</p>";
        $body             .= "<p class='clearBoth'>RECORDATORIO</p>";
        $body             .= "<p class='clearBoth'>RECORDATORIO</p>";
        $body             .= "</div>";
        
        $body             .= "<br />";
        $body             .= "<br />";
        if ($tipo="Carga Extra"){
			$body             .= "<p class='clearBoth'><a href='http://cyonley-com.no-ip.org/sgcopec/sitio/scripts/autoriza_carga.php?id_carga=".$id_carga."'>Aceptar Carga Extra</a></p></body>";
		}else{
			$body             .= "<p class='clearBoth'><a href='http://cyonley-com.no-ip.org/sgcopec/sitio/scripts/autoriza_carga_adelanto.php?id_carga=".$id_carga."'>Aceptar Adelanto</a></p></body>";	
			}
        $mail             = new PHPMailer(true);
        $mail->SetLanguage("en", '../includes/php/phpmailer/language/');
        $mail->IsSMTP(); // telling the class to use SMTP                                                            
        $mail->Host       = "mail.cyonley.com"; // SMTP server
        $mail->SMTPDebug  =  1   ;               // enables SMTP debug information (for testing)
                                                // 1 = errors and messages
                                                // 2 = messages only

        $mail->From = 'ehanglin@cyonley.com';
        $mail->FromName = 'No Responder';

   		if ($tipo="Carga Extra"){
		    $mail->Subject    = "Recordatorio Solicitud de carga extra Nro. ".$id_carga;
		}
        $mail->MsgHTML($body);

		$correo_autoriza = 'jgarrido@cyonley.com';

        $address = $correo_autoriza;
        //$mail->AddAddress($address, $correo_autoriza);

        /*if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
          $objResponse->addAlert("Correo Enviado");
        }
*/
        //$objResponse->addScript("window.parent.hidePopWin(true)");
		//$objResponse->addScript("document.location.href='sg_vehiculos_ingresar_carga.php';");
		return $objResponse->getXML();
}


function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
        
	$sql_ab = "select *
                    from  cargas_extras
                    where ce_pers_aut is not null
						and ce_fecha > '2014-05-01'
						and ce_autorizado <> 'RECHAZADO'
                    ";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
		$arrRegistros	= 	array();
		$i = 1;
                while ($line_ab_1 = mysql_fetch_array($res_ab)){
                    $sql_res = "select distinct ce_ncorr
                                from cargas_vehiculos
                                WHERE carga_tipo = '2' and ce_ncorr = '".$line_ab_1['ce_ncorr']."'";
                    $row_res = mysql_query($sql_res,$conexion);
                    if (mysql_num_rows($row_res)==0){                    
	                    $sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com from personas where pers_rut = '".$line_ab_1['ce_pers']."'";
	                    $res_pr = mysql_query($sql_pr, $conexion);
	                    $nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
	                    
						if ($line_ab_1[2]==''){
							$autorizado_por='Sin autorizar';
							}
						else{
							$autorizado_por=$line_ab_1['ce_pers_aut'];
							}
						array_push($arrRegistros, array("item"		=>	$i,
	                                                    "ncorr"             => 	$line_ab_1['ce_ncorr'],
	                                                    "patente"           => 	$line_ab_1['ce_veh'],
	                                                    "persona"           => 	$nombre_persona,
	                                                    "monto"      		=> 	$line_ab_1['ce_monto'],
	                                                    "fecha"             => 	$line_ab_1['ce_fecha'],
	                                                    "observacion"             => 	$line_ab_1['ce_obs'],
	                                                    "autorizado_por"    => 	$autorizado_por,
	                                                    "autorizado"        => 	$line_ab_1['ce_autorizado'],
														"tipo"				=>	"Carga Extra"));
	                    $i++;
	                    }
                    } 
		
		/*$sql_ab = "select *
                    from  cargas_adelantos
                    where (ca_autorizado = 'NO'
							and ca_fecha >= '2013-10-01'
							and ca_obs <> '')
					union
					select *
					from cargas_adelantos
					where (
						 ca_autorizado = 'SI' 
						 and ca_fecha >= '2013-10-01'
						 and ca_obs <> ''
						 )
                    ";
		*/
	    $sql_ab =         "select *
                    from  cargas_adelantos
                    where   ca_pers_aut is not null
                    		and ca_fecha >= '2014-05-01'
                    		and ca_autorizado <> 'RECHAZADO'";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
                while ($line_ab_1 = mysql_fetch_array($res_ab)){
                	
                    $sql_busca ="select ce_ncorr 
                    			from cargas_vehiculos 
                    			where carga_tipo = '4' and 
                    				ce_ncorr = '".$line_ab_1['ca_ncorr']."'";
                    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
                    
                    if (mysql_num_rows($res_busca)==0){
                    
	                    $sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com from personas where pers_rut = '".$line_ab_1['ca_pers']."'";
	                    $res_pr = mysql_query($sql_pr, $conexion);
	                    $nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
	                    
						if ($line_ab_1[2]==''){
							$autorizado_por='Sin autorizar';
							}
						else{
							$autorizado_por=$line_ab_1['ca_pers_aut'];
							}
						
							array_push($arrRegistros, array("item"		=>	$i,
															"ncorr"             => 	$line_ab_1['ca_ncorr'],
															"patente"           => 	$line_ab_1['ca_veh'],
															"persona"           => 	$nombre_persona,
															"monto"      		=> 	$line_ab_1['ca_monto'],
															"fecha"             => 	$line_ab_1['ca_fecha'],
															"observacion"             => 	$line_ab_1['ca_obs'],
															"autorizado_por"    => 	$autorizado_por,
															"autorizado"        => 	$line_ab_1['ca_autorizado'],
															"tipo"				=>	"Anticipos"));
						$i++;
	                    }
                    } 
			
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_combustible_ce_penau_list.tpl'));
		
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_combustible_ce_penau_list.tpl'));
	
	return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	$ncorr_1 	= 	$data["$objeto2"];

        $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr_1."'  ";
	
        $res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
        $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
        
	if (@mysql_num_rows($res) > 0) {
                $objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
		
	return $objResponse->getXML();
}  
function EliminarItem($data,$ncorr,$tipo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$id_carga = $ncorr;
	if ($tipo=="Carga Extra"){
		$sql = "delete from cargas_extras 
				  where ce_ncorr = ".$id_carga;
		$res = mysql_query($sql,$conexion);
	}else{
		$sql = "delete from cargas_adelantos
		 		  where ca_ncorr = ".$id_carga;
		$res = mysql_query($sql,$conexion);
		}
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
		
	return $objResponse->getXML();
}  
function RealizarCarga($data,$ncorr,$tipo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$objResponse->addAlert("Realizando Carga...");
	$id_carga = $ncorr;

	if ($tipo=="Carga Extra"){
		$sql = "select *
				from cargas_extras
				where ce_ncorr = ".$id_carga;
		$res = mysql_query($sql,$conexion);
		$row = mysql_fetch_array($res);
		
		$carga_veh      = $row['ce_veh'];
		$carga_pers     = $row['ce_pers'];
		$carga_monto    = $row['ce_monto'];
		$carga_fecha    = $row['ce_fecha'];
		$carga_boleta   = $row['ce_boleta'];
		


		$sql_empe = "SELECT veh_emp, veh_depto
	        FROM vehiculos
			WHERE `veh_patente` = '".$carga_veh."'
	            ";
		$res_empe = mysql_query($sql_empe, $conexion);
		$row_empe = mysql_fetch_array($res_empe);

		$veh_empe = $row_empe['veh_emp'];
		$veh_depto = $row_empe['veh_depto'];



		$sql = "insert into cargas_vehiculos (carga_veh,veh_empe,carga_pers,carga_monto,carga_fecha,carga_tipo,ce_ncorr,carga_usuario,carga_boleta,veh_depto)
							values ('".$carga_veh."','".$veh_empe."','".$carga_pers."','".$carga_monto."','".$carga_fecha."','2','".$id_carga."','".$_SESSION['alycar_usuario']."','".$carga_boleta."','".$veh_depto."')";
		$res = mysql_query($sql,$conexion);
	}
	else{
		$sql = "select *
				from cargas_adelantos
				where ca_ncorr = ".$id_carga;
		$res = mysql_query($sql,$conexion);
		$row = mysql_fetch_array($res);
		
		$carga_veh      = $row['ca_veh'];
		$carga_pers     = $row['ca_pers'];
		$carga_monto    = $row['ca_monto'];
		$carga_fecha    = $row['ca_fecha'];
		$carga_ob    	= $row['ca_obs'];
		$carga_boleta   = $row['ca_boleta'];
		
		list($anio1,$mes1,$dia1) = explode('-', $carga_fecha);	
	
		$sql_empe = "SELECT veh_emp, veh_depto
	        FROM vehiculos
			WHERE `veh_patente` = '".$carga_veh."'
	            ";
		$res_empe = mysql_query($sql_empe, $conexion);
		$row_empe = mysql_fetch_array($res_empe);

		$veh_empe = $row_empe['veh_emp'];
		$veh_depto = $row_empe['veh_depto'];

		$nro_fecha        = mktime(0, 0, 0, $mes1 , $dia1, $anio1);
		$hoy              = mktime(0, 0, 0, date("m"), date("d"),   date("Y"));
		$carga_fecha_adelanto = date("Y-m-d",mktime(0, 0, 0, $mes1 , $dia1+15, $anio1));
		
		$sql = "insert into cargas_vehiculos (carga_veh,veh_empe,carga_pers,carga_monto,carga_fecha,carga_fecha_adelanto,carga_tipo,ce_ncorr,carga_usuario,carga_boleta,veh_depto)
							values ('".$carga_veh."','".$veh_empe."','".$carga_pers."','".$carga_monto."','".$carga_fecha."','".$carga_fecha_adelanto."','4','".$id_carga."','".$_SESSION['alycar_usuario']."','".$carga_boleta."','".$veh_depto."')";
		$res = mysql_query($sql,$conexion);
		}
	$objResponse->addAlert("Anticipo ingresado.");
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EnviarCorreo");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("RealizarCarga");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_combustible_ce_penau.tpl');

?>

