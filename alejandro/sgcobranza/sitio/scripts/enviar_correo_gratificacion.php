<?php 
session_start();

include "../../includes/php/phpmailer/class.phpmailer.php";
include "../../includes/php/phpmailer/class.pop3.php";
include "../../includes/php/phpmailer/class.smtp.php";
include "../../includes/php/validaciones.php"; //validaciones
include "../../includes/php/conf_bd.php";

$body="<html>
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
			.veinte{
                width:20%;
            }
            .sesenta{
                width:60%;
            }
	        </style>
			</head>";
		$grupo = $_GET['grupo'];
		$sql = "update gratificaciones
			set estado = 'PENDIENTE'
			where grupo = ".$grupo;
		$res = mysql_query($sql,$conexion) or die(mysql_error()); 
		$sql = "select  *
			from gratificaciones
			where grupo = ".$grupo;
		$res = mysql_query($sql,$conexion) or die(mysql_error()); 
		$cantidad_filas = mysql_num_rows($res);
		$total = 0;
		while ($row=mysql_fetch_array($res)){
			$cantidad = $row['monto'];
			$total = $total + $cantidad;
			}
		unset($_SESSION['gratificacion_grupo']);
		$body			.= "<body>
								Se han ingresado ".$cantidad_filas." gratificaciones por un total de $ ".$total." para su autorizacion
							</body></html>";
	    $mail             = new PHPMailer(true);
        $mail->SetLanguage("en", '../../includes/php/phpmailer/language/');
        $mail->IsSMTP(); // telling the class to use SMTP                                                            
        $mail->Host       = "190.98.219.16"; // SMTP server
        $mail->SMTPDebug  =  1   ;           // enables SMTP debug information (for testing)
                                             // 1 = errors and messages
                                             // 2 = messages only

        $mail->From = 'no-responder@cyonley.com';
        $mail->FromName = 'No Responder';

        $mail->Subject    = "Gratificaciones";
            
        $mail->MsgHTML($body);
		$address = "jgarrido@cyonley.com";
        //$address = "ssilva@cyonley.com";
        $mail->AddAddress($address, $address);

        if(!$mail->Send()) {
          	echo ("Mailer Error: " . $mail->ErrorInfo);
        	echo "No se ha podido enviar el correo. Intentelo haciendo click aca. <a href='http://192.168.0.50/sgvales/sitio/scripts/enviar_correo_gratificacion.php?grupo=".$grupo."' >Enviar Correo</a>";
        } else {
          
        }
	unset($_SESSION['gratificacion_grupo']);
?>
<script>
	location.href="http://cyonley-com.no-ip.org/sgvales/sitio/sg_gratificacion_ingresar.php";
</script>
