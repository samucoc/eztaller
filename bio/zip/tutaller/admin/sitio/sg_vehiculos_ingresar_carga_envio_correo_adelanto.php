<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 
include "../includes/php/phpmailer/class.phpmailer.php";
include "../includes/php/phpmailer/class.pop3.php";
include "../includes/php/phpmailer/class.smtp.php";

$xajax = new xajax();

$xajax->setRequestURI("sg_vehiculos_ingresar_carga_envio_correo_adelanto.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$autoriza		=	$data["autoriza"];
	$trabajador		=	$data["trabajador"];
	$carga_monto	=	str_replace(".", "", $data["monto"]);
	$detalle		=	$data["detalle"];
	$id_carga		=	$data["id_carga"];
	
        $sql = "select *
                from correos
                where correo = '".$autoriza."'";
        $res = mysql_query($sql,$conexion);
        $row = mysql_fetch_array($res);
        $nombre_autoriza = $row['nombre'];
        
        $sql = "update cargas_adelantos
                    set ca_pers_aut = '".$nombre_autoriza."',
						ca_obs = '".$detalle."'
                  where ca_ncorr = ".$id_carga;
        $res = mysql_query($sql,$conexion);
            
        //$body ="<html>
//			<head>
//			<style>
//            .floatLeft{
//                float:left;
//            }
//            .clearBoth{
//                clear:both;
//            }
//            .treinta{
//                width:30%;
//            }
//            .sesenta{
//                width:60%;
//            }
//	        </style>
//			</head>";
//        $body             .= "<body><div>";
//		$body			  .= "<p>ADELANTO ADELANTO ADELANTO ADELANTO</p>";
//        $body             .= "<p>Se ruega autorizar adelanto al trabajador ".$trabajador." por $".$carga_monto."</p>";
//        $body             .= "<div class='treinta floatLeft'>Asunto</div>";
//        $body             .= "<div class='sesenta floatLeft'>".$detalle."</div>";
//        $body             .= "</div>";
//        
//        $body             .= "<br />";
//        $body             .= "<br />";
//        $body             .= "<p class='clearBoth'><a href='http://cyonley-com.no-ip.org/sgcopec/sitio/scripts/autoriza_carga_adelanto.php?id_carga=".$id_carga."'>Aceptar Adelanto</a></p></body>";
//		$body			  .= "<p>ADELANTO ADELANTO ADELANTO ADELANTO</p>";
//        
//        $mail             = new PHPMailer(true);
//        $mail->SetLanguage("en", '../includes/php/phpmailer/language/');
//        $mail->IsSMTP(); // telling the class to use SMTP                                                            
//        $mail->Host       = "mail.yonley.com"; // SMTP server
//        $mail->SMTPDebug  =  1   ;               // enables SMTP debug information (for testing)
//                                                // 1 = errors and messages
//                                                // 2 = messages only
//
//        $mail->From = 'no-responder@yonley.com';
//        $mail->FromName = 'No Responder';
//
//        $mail->Subject    = "Solicitud de adelanto Nro. ".$id_carga;
//            
//        $mail->MsgHTML($body); 
//
//		$autoriza = 'jgarrido@yonley.com';
//        $address = $autoriza;
//        $mail->AddAddress($address, $autoriza);
//
//        if(!$mail->Send()) {
//            echo "Mailer Error: " . $mail->ErrorInfo;
//        } else {
//          //echo "Message sent!";
//        }
    $objResponse->addScript("window.parent.hidePopWin(true)");
	$objResponse->addScript("document.location.href='sg_vehiculos_ingresar_carga.php';");
	$objResponse->addScript("window.parent.Form1.submit();");

	return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	if ($obj1 == 'OBLI-txtCodCobrador'){
        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");
        
            }
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'autoriza','correos','','Todos','correo', 'nombre', '')");
	$carga_pers = $data['carga_pers'];
	
	$sql = "select concat(pers_nombre,' ',pers_ape_pat) as nombre
                from personas
                where pers_rut = '".$carga_pers."'";
	$res = mysql_query($sql,$conexion);
	$row = mysql_fetch_array($res);
	$nombre = $row['nombre'];
	
	$objResponse->addAssign("trabajador", "value",$nombre);
	
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
	
        if ($tabla != 'personas'){
            $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
        }
        else{
            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";
        }
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("LlamaMantenedorVxC");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('carga_monto', $_GET["carga_monto"]);
$miSmarty->assign('carga_pers', $_GET["carga_pers"]);
$miSmarty->assign('id', $_GET["id_carga"]);

$miSmarty->display('sg_vehiculos_ingresar_carga_envio_correo_adelanto.tpl');

?>

