<?php 

include "../../../includes/php/validaciones.php"; 
include "../../../includes/php/phpmailer/class.phpmailer.php";
include "../../../includes/php/phpmailer/class.pop3.php";
include "../../../includes/php/phpmailer/class.smtp.php";


		//coneccion local bd en mysql
		$servidor = "192.168.1.50";
		$usuario = "root";
		$pass = "admin.,240177";
		//$pass = "";
		$bd = "yonleycp";
		
		/*
		$servidor = "localhost";
		$usuario = "cyonley_vehusu";
		$pass = "vehusu";
		$bd = "cyonley_vehiculos";
		*/
		
		
		$conexion = mysql_connect($servidor, $usuario, $pass);
		mysql_select_db($bd, $conexion);

		$cue_ncorr = $_GET['cue_ncorr'];

		$sql = "select 	tra_nombre, tpro_desc	,cue_fecha	,cue_total	,cue_num_cuotas	,
						cue_obs,cue_tipo_trans,ccu_fecha_pago
						
				from yonleycp.cuentas 
					inner join  trabajadores
						on trabajadores.tra_ncorr = cuentas.tra_ncorr
					inner join tipos_productos
						on tipos_productos.tpro_ncorr = cuentas.tpro_ncorr
					inner join cuentas_cuotas
						on cuentas_cuotas.cue_ncorr = cuentas.cue_ncorr
							and cuentas_cuotas.ccu_num = 1	
				where
					cuentas.cue_ncorr = '".$cue_ncorr."'
				";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		$row = mysql_fetch_array($res);
		
		$trabajador = $row['tra_nombre'];
		$prodcuto = $row['tpro_desc'];
		
		//coneccion local bd en mysql
		$servidor_1 = "192.168.1.50";
		$usuario_1 = "root";
		$pass_1 = "admin.,240177";
		$bd_1 = "sgcaja";

		$conexion_1 = mysql_connect($servidor_1, $usuario_1, $pass_1);
		mysql_select_db($bd_1, $conexion_1);
		
		if($row['cue_tipo_trans']!=0){
			$sql_1 = "select ttra_desc from sgcaja.tipos_transacciones where ttra_ncorr = '".$row['cue_tipo_trans']."'";
			$res_1 = mysql_query($sql_1, $conexion_1) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			$tipo_trans = $row_1['ttra_desc'];
			}
		else{
			$tipo_trans = 'Sin tipo de transaccion';
			}
		$fech_ing = $row['cue_fecha'];
		$fech_desc = $row['ccu_fecha_pago'];
		$total = $row['cue_total'];
		$cuotas = $row['cue_num_cuotas'];
		$observacion = $row['cue_obs'];
		
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
        $body             .= "<p>Se informa la generacion de la siguiente cuenta personal</p>";
        $body             .= "<table><tr><td>Trabajador</td>";
        $body             .= "<td>".$trabajador."</td></tr>";
        $body             .= "<tr><td>Producto</div>";
        $body             .= "<td>".$prodcuto."</td></tr>";
        $body             .= "<tr><td>Tipo Transaccion</td>";
        $body             .= "<td>".$tipo_trans."</td></tr>";
        $body             .= "<tr><td>Fecha Ingreso</td>";
        $body             .= "<td>".$fech_ing."</td></tr>";
        $body             .= "<tr><td>Fecha 1º Descuento</td>";
        $body             .= "<td>".$fech_desc."</td></tr>";
        $body             .= "<tr><td>Total Cuenta</td>";
        $body             .= "<td>".$total."</td></tr>";
        $body             .= "<tr><td>Cuotas</div>";
        $body             .= "<td>".$cuotas."</td></tr>";
        $body             .= "<tr><td>Observacion</td>";
        $body             .= "<td>".$observacion."</td></tr>";
        $body             .= "</table>";
        
        $body             .= "<br />";
        $body             .= "<br />";
        $body             .= "</body>";
        $body             .= "</html>";
        
        
        $mail             = new PHPMailer(true);
        $mail->SetLanguage("en", '../includes/php/phpmailer/language/');
        $mail->IsSMTP(); // telling the class to use SMTP                                                            
        $mail->Host       = "190.98.219.16"; // SMTP server
        $mail->SMTPDebug  =  1   ;               // enables SMTP debug information (for testing)
                                                // 1 = errors and messages
                                                // 2 = messages only

        $mail->From = 'no-responder@cyonley.com';
        $mail->FromName = 'No Responder';

        $mail->Subject    = "Informe de cuenta personal Nro. ".$nro_cuenta;
        echo $body;  
        $mail->MsgHTML($body);

       	$address = 'tesoreria@cyonley.com';
        $mail->AddAddress($address, $address);

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
          //echo "Message sent!";
        }
		
		header("location: http://192.168.1.40/scyonley/sitio/cuentas.php");

?>