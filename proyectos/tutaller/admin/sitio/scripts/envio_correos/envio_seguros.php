<?php 
include '../../../includes/php/conf_bd.php';
include "../../../includes/php/class.phpmailer.php";
include "../../../includes/php/class.pop3.php";
include "../../../includes/php/class.smtp.php";
/**
 * Devuelve la diferencia entre 2 fechas según los parámetros ingresados
 * @author Gerber Pacheco
 * @param string $fecha_principal Fecha Principal o Mayor
 * @param string $fecha_secundaria Fecha Secundaria o Menor
 * @param string $obtener Tipo de resultado a obtener, puede ser SEGUNDOS, MINUTOS, HORAS, DIAS, SEMANAS
 * @param boolean $redondear TRUE retorna el valor entero, FALSE retorna con decimales
 * @return int Diferencia entre fechas
 */
function diferenciaEntreFechas($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false){
    $f0 = strtotime($fecha_principal);
    $f1 = strtotime($fecha_secundaria);
    if ($f0 < $f1) { 
   		$tmp = $f1; 
		$f1 = $f0; 
		$f0 = $tmp; 
		}
    $resultado = ($f0 - $f1);
    switch ($obtener) {
       default: break;
       case 'MINUTOS'   :   $resultado = $resultado / 60;   break;
       case 'HORAS'     :   $resultado = $resultado / 60 / 60;   break;
       case 'DIAS'      :   $resultado = $resultado / 60 / 60 / 24;   break;
       case 'SEMANAS'   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
    }
    if($redondear) $resultado = round($resultado);
    return $resultado;
}

$sql = 'select *
        from envio_correos';
$res = mysql_query($sql,$conexion);
while ($row = mysql_fetch_array($res)){
	
	$correo 		= $row['correo'];
	$dias_anticipa 	= $row['dias_anticipa'];
	$repeticion 	= $row['repeticion'];
	
	$mes_post = date('m',mktime(0, 0, 0, date('m')  , date('d')+$dias_anticipa, date('Y')));
	$fecha_post = date('Y-m-d',mktime(0, 0, 0, date('m')  , date('d')+$dias_anticipa, date('Y')));
	
	$arr_fp = explode('-',$fecha_post);
	$dia_ultimo = date('t',mktime(0, 0, 0, $arr_fp[1]  , 1,  $arr_fp[0]));
	$fecha_peticion = date('Y-m-d',mktime(0, 0, 0, $arr_fp[1]  , $dia_ultimo,  $arr_fp[0]));
	
		$cant_post = diferenciaEntreFechas(date('Y-m-d'),$fecha_post,'DIAS',TRUE);
		$cant_pet  = diferenciaEntreFechas(date('Y-m-d'),$fecha_peticion,'DIAS',TRUE);
		
		if (($cant_pet  % $repeticion ==0 )||($cant_pet / $repeticion < 0 )){
			$mail             = new PHPMailer(true);
			$body             = "
				<style>
					.floatLeft{
						float:left;
						}
					.clearBoth{
						clear:both
						}
					.quince{
						width:15%;
						}
					.titulo{
						padding: 25px;
						text-align: left;
						}
				</style>
				<link rel='stylesheet' type='text/css' href='http://cyonley.no-ip.org:8080/sgcopec/estilos/estilo.css'/>
					<div class='titulo'>
						Estimado/a
						<br /> 
						<br /> 
						En ".$cant_pet." d&iacute;as caducar&aacute; el seguro automotriz de los siguientes veh&iacute;culos
						<br /> 
						<br /> 
						<div class='quince floatLeft'>
							Patente
						</div>
						<div class='quince floatLeft'>
							Modelo
						</div>
						<div class='quince floatLeft'>
							A&ntilde;o
						</div>
						<div class='quince floatLeft'>
							Responsable
						</div>
						<div class='quince floatLeft'>
							Aseguradora
						</div>
						<div class='quince floatLeft'>
							Prima
						</div>
						<br class='clearBoth'> 
				";
			$sql_1 = 'select veh_patente, veh_modelo, veh_anio, veh_emp_ase, veh_mont_prima
						from vehiculos
						where veh_term_seg = '.$mes_post;
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			while ($row_1 = mysql_fetch_array($res_1)){
				$sql_1 = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut in	(select rut
													from personas_tienen_vehiculos
													where patente = '".$row_1['veh_patente']."')";
				$res_1 = mysql_query($sql_1, $conexion);
                $nombre_persona = @mysql_result($res_1,0,"pers_nombre_com");
				if ($nombre_persona==''){
					$nombre_persona = 'Sin responsable';
					}
				
				$sql_1 = "select nombre
							from empresas_aseguradoras 
							where empresa_ncorr = '".$row_1['veh_emp_ase']."'";
				$res_1 = mysql_query($sql_1, $conexion);
                $aseguradora = @mysql_result($res_1,0,"nombre");
				
				$body .= "
						<div class='quince floatLeft'>
							".$row_1['veh_patente']."
						</div>
						<div class='quince floatLeft'>
							".$row_1['veh_modelo']."
						</div>
						<div class='quince floatLeft'>
							".$row_1['veh_anio']."
						</div>
						<div class='quince floatLeft'>
							".$nombre_persona."
						</div>
						<div class='quince floatLeft'>
							".$aseguradora."
						</div>
						<div class='quince floatLeft'>
							".$row_1['veh_mont_prima']."
						</div>
						<br class='clearBoth'> ";
				}
			$body .= "<br class='clearBoth'><br class='clearBoth'>Atte. Sistema Veh&iacute;culos";
			$mail->IsSMTP(); // telling the class to use SMTP                                                          
			$mail->Host       = '190.98.219.16'; // SMTP server
			$mail->SMTPDebug  = 0   ;               // enables SMTP debug information (for testing)
													// 1 = errors and messages
													// 2 = messages only
		
			$mail->From = 'no-responder@cyonley.com';
			$mail->FromName = 'No Responder';
		
			$mail->Subject    = 'Vencimiento de seguros de vehiculos';
			
			//echo $body;
			$mail->MsgHTML($body);
		
			$address = $correo;
			$mail->AddAddress($address, $address);
		
			if(!$mail->Send()) {
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			  //echo 'Message sent!';
			}
			
		}
	}
	
	
	
$sql = 'select *
        from envio_correos_rev_tec';
$res = mysql_query($sql,$conexion);
while ($row = mysql_fetch_array($res)){
	
	$correo 		= $row['correo'];
	$dias_anticipa 	= $row['dias_anticipa'];
	$repeticion 	= $row['repeticion'];
	
	$mes_post = date('m',mktime(0, 0, 0, date('m')  , date('d')+$dias_anticipa, date('Y')));
	$fecha_post = date('Y-m-d',mktime(0, 0, 0, date('m')  , date('d')+$dias_anticipa, date('Y')));
	
	$arr_fp = explode('-',$fecha_post);
	$dia_ultimo = date('t',mktime(0, 0, 0, $arr_fp[1]  , 1,  $arr_fp[0]));
	$fecha_peticion = date('Y-m-d',mktime(0, 0, 0, $arr_fp[1]  , $dia_ultimo,  $arr_fp[0]));
	
		$cant_post = diferenciaEntreFechas(date('Y-m-d'),$fecha_post,'DIAS',TRUE);
		$cant_pet  = diferenciaEntreFechas(date('Y-m-d'),$fecha_peticion,'DIAS',TRUE);
		$body="";
		if (($cant_pet  % $repeticion ==0 )||($cant_pet / $repeticion < 0 )){
			$mail             = new PHPMailer(true);
			$body             = "
				<style>
					.floatLeft{
						float:left;
						}
					.clearBoth{
						clear:both
						}
					.quince{
						width:15%;
						}
					.titulo{
						padding: 25px;
						text-align: left;
						}
				</style>
				<link rel='stylesheet' type='text/css' href='http://cyonley.no-ip.org:8080/sgcopec/estilos/estilo.css'/>
					<div class='titulo'>
						Estimado/a
						<br /> 
						<br /> 
						En ".$cant_pet." d&iacute;as caducar&aacute; la revisi&oacute;n t&eacute;cnica de los siguientes veh&iacute;culos
						<br /> 
						<br /> 
						<div class='quince floatLeft'>
							Patente
						</div>
						<div class='quince floatLeft'>
							Modelo
						</div>
						<div class='quince floatLeft'>
							A&ntilde;o
						</div>
						<br class='clearBoth'> 
				";
			$sql_1 = 'select veh_patente, veh_modelo, veh_anio, veh_emp_ase, veh_mont_prima
						from vehiculos
						where veh_term_seg = '.$mes_post;
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			while ($row_1 = mysql_fetch_array($res_1)){
				$body .= "
						<div class='quince floatLeft'>
							".$row_1['veh_patente']."
						</div>
						<div class='quince floatLeft'>
							".$row_1['veh_modelo']."
						</div>
						<div class='quince floatLeft'>
							".$row_1['veh_anio']."
						</div>
						<br class='clearBoth'> ";
				}
			$body .= "<br class='clearBoth'><br class='clearBoth'>Atte. Sistema Veh&iacute;culos";
			$mail->IsSMTP(); // telling the class to use SMTP                                                          
			$mail->Host       = '190.98.219.16'; // SMTP server
			$mail->SMTPDebug  = 0   ;               // enables SMTP debug information (for testing)
													// 1 = errors and messages
													// 2 = messages only
		
			$mail->From = 'no-responder@cyonley.com';
			$mail->FromName = 'No Responder';
		
			$mail->Subject    = 'Vencimiento de revision tecnica';
			
			//echo $body;
			$mail->MsgHTML($body);
		
			$address = $correo;
			$mail->AddAddress($address, $address);
		
			if(!$mail->Send()) {
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			  //echo 'Message sent!';
			}
			
		}
	}
?>
<script language="javascript">
window.close();
</script> 
