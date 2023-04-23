<?php 
ob_start(); 
session_start(); 

$costo_tot=0;
$total_desc=0;



$num_factura = $_GET['num_fact'];

require('../fpdf.php');
require('../htmlparser.inc');
include("../conex.php");





	if (empty($factura)) $factura = $_GET['num_fact'];
	$link=Conectarse();
	
	$sqlfact = "update factura 
				set estado = 'CERRADA'
				WHERE num_factura ='$factura'";						
	$resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
	
	$sqlfact = "SELECT * FROM factura WHERE num_factura ='$factura'";						
	$resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
	$registrofact = mysql_fetch_array($resfact);
	
	$fact=$registrofact['num_factura'];
	$cod_cli=$registrofact['cod_cliente'];
	$fecha_factura=$registrofact['fecha'];
	$num_arriendo =  $registrofact['cod_arriendo'];
	
					$cod_obra 		= $registrofact['cod_obra'];

					$sql_obra = "select nombre_obra, direcc_obra from obra where cod_obra = '".$cod_obra."'";
					$reS_obra = mysql_query($sql_obra,$link);
					$row_obra = mysql_fetch_array($reS_obra);

					$nombre_obra = $row_obra['nombre_obra'];
					$direcc_obra = $row_obra['direcc_obra'];

	$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
	$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
	$registrocliente = mysql_fetch_array($rescliente);
	$valor1=$registrocliente['rut_cliente'];
	if (empty($valor1)){
	
	}else{
			$link=Conectarse();
			$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, rut_cliente, dv_cliente,
					 raz_social, giro_cliente, cod_area, fono_cliente, movil_cliente, direcc_cliente, 
					 nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2,
					 email_resp_emp2, cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, 
					 cargo_resp3, movil_resp3, cond_env_fact 
					FROM clientes 
					WHERE rut_cliente ='$valor1'";
			
			
			$res = mysql_query($sql,$link) or die(mysql_error()); 
			$registro = mysql_fetch_array($res);
			
	}

	mysql_query("SET NAMES utf8");   


 		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
 		// echo($sql3);
 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
 		$registrociu = mysql_fetch_array($resciu);

 		$sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
 		// echo($sql3);
 		$rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
 		$registrocom = mysql_fetch_array($rescom);

	//referencia
	$sqlgd   = "SELECT * FROM arriendo WHERE cod_arriendo ='".$num_arriendo."'";
		
					$resgd      = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$num_gd     = $registrogd['num_gd'];
					$num_oc     = $registrogd['num_oc'];
					$cod_obra   = $registrogd['cod_obra'];
					$tipo_oc    = $registrogd['tipo_oc'];
					
					if (empty ($num_gd)) {
						$sqlgd   = "SELECT * FROM factura WHERE num_factura ='".$factura."'";
				
						$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
						$registrogd = mysql_fetch_array($resgd);
						$cod_obra     = $registrogd['cod_obra'];
						$num_gd     = $registrogd['gd_rep'];
						$num_oc     = $registrogd['oc_rep'];
					
						if (empty($registrogd['gd_rep'])){
							if (empty($num_arriendo)){
								$num_gd =  "Sin GD";

								}
							else{
								$sqlgd   = "SELECT * 
											FROM equipos_arriendo
											WHERE cod_arriendo ='".$num_arriendo."'";
								$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
								$registrogd = mysql_fetch_array($resgd);
								$num_gd     = $registrogd['num_gd'];
								}
							}
						else{
							$num_gd     = $registrogd['gd_rep'];
							$num_oc     = $registrogd['oc_rep'];
					
							}
					}
		  	   	$sql3="SELECT * FROM obra where cod_obra =".$cod_obra;
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				$obra = $registro3['nombre_obra'];
				$direccion_obra = $registro3['direcc_obra'];
				if($registro3['cod_comuna']!=''){
					$sqlciu="SELECT comuna FROM comuna where cod_comuna =".$registro3['cod_comuna'];
			 		// echo($sql3);
			 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
			 		$registrocom_1 = mysql_fetch_array($resciu);
			 		$comuna_1 = $registrocom_1['comuna'];
			 		}
		$sql_002 = "select fecha from gd where num_gd = '".$num_gd."'";
		$res_002 = mysql_query($sql_002,$link);
		$row_002 = mysql_fetch_array($res_002);
		$fecha_gd = $row_002['fecha'];

	$razon = substr('Guia de Ventas.',0,90);
	$razon_1 = substr('Guia de Arriendo.',0,90);


	$sql_num_gd = "select *
					from gd
					where num_gd = ".$num_gd;
	$res_num_gd = mysql_query($sql_num_gd,$link);
	$row_num_gd = mysql_fetch_array($res_num_gd);
	

	if (!empty($row_num_gd['cond_venta'])) {
		if ($row_num_gd['cond_venta']<11){
			$sql_002 = "select forma_pago.forma_pago 
							from forma_pago
						where cod_forma_pago = '".$row_num_gd['cond_venta']."'";
			$res_002 = mysql_query($sql_002,$link);
			$row_002 = mysql_fetch_array($res_002);
			$cond_venta = $row_002['forma_pago'];

		}
		else{
			$cond_venta =  utf8_decode(utf8_encode($row_num_gd['cond_venta']));
			}
		}
	else{
		$sql_gd = "select num_gd from arriendo where num_gd = ".$num_gd."";
		$res_gd = mysql_query($sql_gd,$link);
		$row_gd = mysql_fetch_array($res_gd);
		if (!empty($row_gd['num_gd'])){

			$sql_002 = "select forma_pago.forma_pago , forma_pago_dias
							from arriendo
								inner join forma_pago
									on forma_pago.cod_forma_pago = arriendo.forma_pago
						where num_gd = '".$num_gd."'";
			$res_002 = mysql_query($sql_002,$link);
			$row_002 = mysql_fetch_array($res_002);
			$cond_venta = $row_002['forma_pago'];
			$dias_plazo = $row_002['forma_pago_dias'];
			}
		else{
	  		$sql_num_gd = "select *
						from factura
						where num_factura = ".$num_factura;
			$res_num_gd = mysql_query($sql_num_gd,$link);
			$row_num_gd = mysql_fetch_array($res_num_gd);
			$cond_venta = utf8_decode(utf8_encode($row_num_gd['cond_venta']));
			if ($row_num_gd['cond_venta']<11){
				$sql_002 = "select forma_pago.forma_pago 
								from forma_pago
							where cod_forma_pago = '".$row_num_gd['cond_venta']."'";
				$res_002 = mysql_query($sql_002,$link);
				$row_002 = mysql_fetch_array($res_002);
				$cond_venta = $row_002['forma_pago'];

				}
			else{
				$cond_venta = utf8_decode(utf8_encode($row_num_gd['cond_venta']));
				}
			}
		}
	$dias_plazo = 0 ;
	$sql_cond_venta = "select * from forma_pago where cod_forma_pago = '".$cond_venta."'";
	$resultado = mysql_query($sql_cond_venta, $link);
	if (mysql_num_rows($resultado)>0){
		$res_cond_venta = mysql_query($sql_cond_venta,$link);
		$row_cond_venta = mysql_fetch_array($res_cond_venta);
		// $cond_venta = $row_cond_venta['forma_pago'];
		if ($row_cond_venta['cod_forma_pago']=='30'){
			$dias_plazo = $row_cond_venta['cod_forma_pago'];
		}
		else{
			$dias_plazo = $row_cond_venta['forma_pago_dias'];
		}
	}
	else{
		list($dias_plazo,$texto) = explode(' ',$cond_venta);
		}
	
	if ($dias_plazo>0){
		$sql_fv = "select DATE_ADD('".$registrofact['fecha']."', INTERVAL ".$dias_plazo." DAY) as fecha_venc;";
		}
	else{
		$sql_fv = "select DATE_ADD('".$registrofact['fecha']."', INTERVAL 0 DAY) as fecha_venc;";
		}
	$res_fv = mysql_query($sql_fv,$link);
	$row_fv = mysql_fetch_array($res_fv);
	$fecha_venc = $row_fv['fecha_venc'];
	
	 $xmlstr = '<?xml version="1.0" encoding="utf-8"?>
	 			<DTE version="1.0">
	 				<Documento ID="R76836180-0T33F'.$factura.'">
	 					<Encabezado>
	 						<IdDoc>
	 		            		<TipoDTE>33</TipoDTE>
	 				            <Folio>'.$factura.'</Folio>
	 				            <FchEmis>'.$registrofact['fecha'].'</FchEmis>
	 				            <FchVenc>'.$fecha_venc.'</FchVenc>
	 		        	  	</IdDoc>
	 		          		<Emisor>
	 				            <RUTEmisor>76836180-0</RUTEmisor>
	 				            <RznSoc>Sociedad de Inversiones y Servicios Vigomaq Ltda</RznSoc>
	 				            <GiroEmis>Arriendo, Venta y Reparación de  Maquinaria de Construcción</GiroEmis>
	 				            <Acteco>773002</Acteco>
	 				            <DirOrigen>AVDA CARLOS IBANEZ DEL C 3114 ACHUPALLAS</DirOrigen>
	 				            <CmnaOrigen>VINA DEL MAR</CmnaOrigen>
	 				            <CiudadOrigen>VINA DEL MAR</CiudadOrigen>
	 				        </Emisor>
	 				        <Receptor>
	 				        	<RUTRecep>'.str_replace('.', '', $registro['rut_cliente']).'</RUTRecep>
	 				            <RznSocRecep>'.substr(htmlspecialchars(str_replace("Ã‘",'N',$registro['raz_social'])),0,100).'</RznSocRecep>
	 				            <GiroRecep>'.substr(str_replace("Ã‘",'N',$registro['giro_cliente']),0,40).'</GiroRecep>
	 				            <Contacto>'.substr($registro['fono_cliente'],0,80).'</Contacto>
	 				            <DirRecep>'.substr(str_replace('Ã','',str_replace("Ã‘",'N',$registro['direcc_cliente'])),0,70).'</DirRecep>
	 				            <CmnaRecep>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$registrocom['comuna'])),0,20).'</CmnaRecep>
	 				            <CiudadRecep>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$registrociu['ciudad'])),0,20).'</CiudadRecep>
	 				        </Receptor>
	 				        ';

	
	$sqldet="SELECT  sum(tot_arriendo) + sum(total_rep) as neto, '19' as valor_iva
				FROM  det_factura
				where num_factura = '".$factura."'";
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	while($registrodet = mysql_fetch_array($resdet)){
		$iva = $registrodet['neto'] * ($registrodet['valor_iva']/100);
		$total = $registrodet['neto'] * (1+($registrodet['valor_iva']/100));
		$xmlstr .= 				'<Totales>
						            <MntNeto>'.$registrodet['neto'].'</MntNeto>
						            <TasaIVA>19</TasaIVA>
						            <IVA>'.number_format($iva,0,'','').'</IVA>
						            <MntTotal>'.number_format($total,0,'','').'</MntTotal>
						        </Totales>
						       </Encabezado>';
		}

	$sqldet="SELECT * FROM  det_factura where num_factura = '".$factura."' order by cod_repuesto ASC";	
	$resdet = mysql_query($sqldet,$link) or die(mysql_error()); 

	$sqldet_1="SELECT count(num_factura) as num_factura FROM  det_factura where num_factura = '".$factura."' ";	
	$resdet_1 = mysql_query($sqldet_1,$link) or die(mysql_error()); 
	$rowdet_1 = mysql_fetch_array($resdet_1);

	$contador = $rowdet_1['num_factura'];

	$i=1;
	while ($registrodet = mysql_fetch_array($resdet)) {
		$total_desc=0;
		$porcentaje_emitir = 0;
		$total_neto = 0;
		$detalle="";
		$detalle_1="";
		$dias_arriendo = $registrodet['dias_arriendo'];
		if (($registrodet['cod_repuesto'] == 0 )&&($registrodet['cod_equipo'] == 0 )) {
			$detalle = $registrodet['otros_reparacion'];

			list($d1,$d2) = explode('//',$detalle);
			$detalle = substr($d1, 0,80);
			$detalle_1 = substr($d2, 0,1000);

			$xmlstr .=			'<Detalle>
				  					        <NroLinDet>'.$i.'</NroLinDet>
				  					        <NmbItem>'.str_replace('Â‘','',str_replace("Ã‘",'N',substr($detalle,0,80))).'</NmbItem>
				  					        <DscItem>'.str_replace('Â‘','',str_replace("Ã‘",'N',$detalle_1)).'</DscItem>
				  					        <QtyItem>'.$registrodet['cantidad'].'</QtyItem>
				  					        <PrcItem>'.$registrodet['valor_unitario'].'</PrcItem>
				  					        <MontoItem>'.$registrodet['total_rep'].'</MontoItem>
				  				</Detalle>
				  				';
			}
		
		else{
			/*
				Días de Arriendo según CONTRATO Nro 30376
				De  ROMPEPAVIMENTO 30KG HM 1810 NR. 448
				PERIODO DESDE 11-7-2016 AL 30-7-2016
			*/
			$cantidad = $registrodet['dias_arriendo'];
		 	if (!empty($valor1)){
				$sqlnomob="SELECT nombre_equipo FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
				$resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
				$registronob = mysql_fetch_array($resnomob);
				//$detalle .= "Dias Arriendo de ".($registronob['nombre_equipo']);

				$sqlperiodo="SELECT distinct nro_factura
							FROM equipos_arriendo
								where equipos_arriendo.num_gd = '".$registroper_row['num_gd']."'
									and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
								group by num_gd
								order by equipos_arriendo.arrendado_hasta asc
									
					 ";
				$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				
				if (mysql_num_rows($resperiodo)=='1'){
					$registroper_row = mysql_fetch_array($resperiodo);
					$detalle .= "Dias de Arriendo segun CONTRATO Nro ".$registroper_row['num_gd'];
					}
				else{
					$sqlperiodo="SELECT estado_equipo_arr, equipos_arriendo.num_gd
							FROM equipos_arriendo
								where equipos_arriendo.nro_factura = '".$num_factura."'
									and equipos_arriendo.cod_equipo = '".$registrodet['cod_equipo']."'
									and equipos_arriendo.estado_equipo_arr like 'NO DEVUELTO-FACTURADO%'
								order by equipos_arriendo.arrendado_hasta asc
							
					 ";
					$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					if (mysql_num_rows($resperiodo)>0){
						$registroper_row = mysql_fetch_array($resperiodo);
						$detalle .= "Dias de Renovacion segun CONTRATO Nro ".$registroper_row['num_gd'];
						}
					else{
						$sqlperiodo="SELECT estado_equipo_arr, equipos_arriendo.num_gd
							FROM equipos_arriendo
								where equipos_arriendo.nro_factura = '".$num_factura."'
									and equipos_arriendo.cod_equipo = '".$registrodet['cod_equipo']."'
									and equipos_arriendo.estado_equipo_arr like 'DEVUELTO-FACTURADO%'
								order by equipos_arriendo.arrendado_hasta asc
							
					 ";
						$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
						if (mysql_num_rows($resperiodo)>0){
							$registroper_row = mysql_fetch_array($resperiodo);
							$detalle .= "Dias de Saldo Arriendo segun CONTRATO Nro ".$registroper_row['num_gd'];
							}
						}
				
				$resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				$registroper_row = mysql_num_rows($resperiodo);
				
				}

				$detalle_1 .= "De ".utf8_decode($registronob['nombre_equipo']);

				$link=Conectarse();
				$num_arriendo = $registrofact['cod_arriendo'];
				$sqlperiodo="SELECT *
							FROM equipos_arriendo
								inner join gd
									on equipos_arriendo.cod_arriendo = gd.id_arriendo
								inner join factura 
									on factura.cod_arriendo = equipos_arriendo.cod_arriendo
								where equipos_arriendo.cod_arriendo =".$num_arriendo." 
									and equipos_arriendo.cod_equipo =".$registrodet['cod_equipo']." 
									and factura.num_factura = '".$num_factura."'
									and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
									and equipos_arriendo.arrendado_desde <= '".$fecha_factura."'
									and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
								order by equipos_arriendo.arrendado_hasta asc
							limit 0,1
					 ";
				 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				 $registroper_row = mysql_num_rows($resperiodo);
					  if ($registroper_row==0){
						 $sqlperiodo=" SELECT *
									FROM equipos_arriendo
										inner join gd
											on equipos_arriendo.cod_arriendo = gd.id_arriendo
										inner join factura 
											on factura.cod_arriendo = equipos_arriendo.cod_arriendo
										where equipos_arriendo.nro_factura = '".$num_factura."'
										order by equipos_arriendo.arrendado_hasta asc
									limit 0,1";
						 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					  }
      			 $registroper = mysql_fetch_array($resperiodo); 				 
				 $hasta="";
				 if (!empty($registroper['arrendado_hasta'])){ 
					$fecha_temp = explode("-",$registroper['arrendado_hasta']);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

					}else{ 
						$hasta = "NO DEVUELTO";
					}
									 
				$fecha_temp = explode("-",$registroper['arrendado_desde']);
				//año-mes-dia
				//0 -> dia, 1 -> mes, 2 -> año
				//var_dump($fecha_temp);
				if ((isset($fecha_temp[1]))&&(isset($fecha_temp[2]))&&(isset($fecha_temp[0]))){
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$desde =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
					}
				else{
					$desde = '';
					}
				
    			$detalle_1 .= (" PERIODO DESDE ".$desde." AL ".$hasta);
				 
			}else{
					$detalle_1 .=(" ");
					 
				}
			$link=Conectarse();
			$sqleval   = "SELECT valor_unidad_arr FROM equipo WHERE cod_equipo =".$registrodet['cod_equipo'];
			$resuni         = mysql_query($sqleval,$link) or die(mysql_error()); 
			$registroval    = mysql_fetch_array($resuni);
			$valor = $registrodet['tot_arriendo']/$dias_arriendo;
			$valor_le = number_format($valor, 0, "", "");
		
			$total_neto = $dias_arriendo*$valor;
			$porcentaje_emitir = ($registrodet['porcentaje_vu']);
			$total_desc="";
			$total_desc_le="";
			$porcentaje_emitir = "";
			if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
				$porcentaje_emitir = "";
				}
			else{
				$porcentaje_emitir = $porcentaje_emitir."%";
				}
		
			if (!empty($registrodet['total_rep'])) { 
				if ($porcentaje_emitir==100){
					$porcentaje_emitir=0;
					}
				$total_desc = $total_neto * (1 - ($porcentaje_emitir/100));
				$total_desc_le = number_format($total_desc, 0, "", ""); 
				}
			else{ 
				if ($porcentaje_emitir==100){
					$porcentaje_emitir=0;
					}
				$total_desc = $total_neto * (1 - ($porcentaje_emitir/100));
				$total_desc_le = number_format($total_desc, 0, "", "");
				}
				if ($contador == $i){
					$detalle_1 .= ' . Arriendo(s) correspondiente(s) a la obra : '.$nombre_obra;
					}				
				$xmlstr .=			'<Detalle>
				  					        <NroLinDet>'.$i.'</NroLinDet>
				  					        <NmbItem>'.str_replace("Ã‘",'N',substr($detalle,0,80)).'</NmbItem>
				  					        <DscItem>'.str_replace("Ñ",'N',str_replace("Ã‘",'N',$detalle_1)).'</DscItem>
				  					        <QtyItem>'.$dias_arriendo.'</QtyItem>
				  					        <PrcItem>'.$valor.'</PrcItem>
				  					        <MontoItem>'.$total_desc_le.'</MontoItem>
				  				        </Detalle>
				  				        ';
					
				
			}
			$i++;
			
		}
		/*
				$xmlstr .=			'<Detalle>
				  					        <NroLinDet>'.$i.'</NroLinDet>
				  					        <NmbItem>Nombre Obra</NmbItem>
				  					        <DscItem>'.$nombre_obra.'</DscItem>
				  					        <QtyItem></QtyItem>
				  					        <PrcItem></PrcItem>
				  					        <MontoItem></MontoItem>
				  				        </Detalle>
				  				        ';
		$i++;
				$xmlstr .=			'<Detalle>
				  					        <NroLinDet>'.$i.'</NroLinDet>
				  					        <NmbItem>Direccion Obra</NmbItem>
				  					        <DscItem>'.$direcc_obra.'</DscItem>
				  					        <QtyItem></QtyItem>
				  					        <PrcItem></PrcItem>
				  					        <MontoItem></MontoItem>
				  				        </Detalle>
				  				        ';
	*/
	
	if ($num_arriendo>0){
		if ($num_oc==''){ 
			if ($tipo_oc=='2')  {
				$num_oc = 'SIN OC';
				}
			elseif ($tipo_oc=='3')  {
				$num_oc = 'PENDIENTE';
				}
			else{
				$num_oc = '000';
				}
			}
		if ($fecha_gd!=''){
			$xmlstr .=' <Referencia>
								<NroLinRef>1</NroLinRef>
								<TpoDocRef>52</TpoDocRef>
								<FolioRef>'.$num_gd.'</FolioRef>
								<FchRef>'.$fecha_gd.'</FchRef>
								<RazonRef></RazonRef>
						</Referencia>';
			if (($num_oc!='SIN OC')&&($num_oc!='PENDIENTE')&&($num_oc!='000')){
							 $url = $num_oc;
							 //Reemplazamos caracteres especiales latinos
							 $find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
							 $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
							 $url = str_replace($find, $repl, $url);
							 //Añadimos los guiones
							 // $find = array(' ', '.', '_', '&amp;', '\r\n', '\n','+');
							 // $url = str_replace($find, '-', $url);
							 //Eliminamos y Reemplazamos los demas caracteres especiales
							 // $find = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;{^&gt;*&gt;/');
							 // $repl = array('', ' ', '');
							 // $url = ereg_replace('[^ A-Za-z0-9_-ñÑ]', ' ', $url);
							
						$xmlstr .='<Referencia>';	 		
						$xmlstr .=' 
						 		<NroLinRef>2</NroLinRef>
						 		<TpoDocRef>801</TpoDocRef>
						 		<FolioRef>'.$url.'</FolioRef>
						 		<FchRef>'.$registrofact['fecha'].'</FchRef>
						 		<RazonRef></RazonRef>';
						$xmlstr .='</Referencia>';
						}
				
				}
			}
	else{
		$linea_ref = 1;
			if ($fecha_gd!=''){
				$xmlstr .=' <Referencia>
									<NroLinRef>'.$linea_ref.'</NroLinRef>
									<TpoDocRef>52</TpoDocRef>
									<FolioRef>'.$num_gd.'</FolioRef>
									<FchRef>'.$fecha_gd.'</FchRef>
									<RazonRef></RazonRef>
							</Referencia>'; 
					$linea_ref++;
					}

			if (($num_oc!='SIN OC')&&($num_oc!='PENDIENTE')&&($num_oc!='000')&&($num_oc!='')){
							 $url = $num_oc;
							 //Reemplazamos caracteres especiales latinos
							 $find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
							 $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
							 $url = str_replace($find, $repl, $url);
							/*
							 //Añadimos los guiones
							 $find = array(' ', '.', '_', '&amp;', '\r\n', '\n','+');
							 $url = str_replace($find, '-', $url);
							 //Eliminamos y Reemplazamos los demas caracteres especiales
							 $find = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;{^&gt;*&gt;/');
							 $repl = array('', ' ', '');
							 $url = ereg_replace('[^ A-Za-z0-9_-ñÑ]', ' ', $url);
							*/
						$xmlstr .='<Referencia>';	 		
						$xmlstr .=' 
						 		<NroLinRef>'.$linea_ref.'</NroLinRef>
						 		<TpoDocRef>801</TpoDocRef>
						 		<FolioRef>'.$url.'</FolioRef>
						 		<FchRef>'.$registrofact['fecha'].'</FchRef>
						 		<RazonRef></RazonRef>';
						$xmlstr .='</Referencia>';
						}

		}
	$xmlstr .=			'
		        	</Documento>';



	
	$xmlstr .= '<Parametros>
					<FormaPago>'.substr($cond_venta,0,15).'</FormaPago>
					<Obra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$obra)),0,40).'</Obra>
					<DirObra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$direccion_obra)),0,40).'</DirObra>
					<ComunaObra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$comuna_1)),0,40).'</ComunaObra>
				</Parametros>';
	/*$xmlstr .= '<Parametros>
					<FormaPago>'.substr($cond_venta,0,15).'</FormaPago>
					<OrdenCompra>'.substr($num_oc,0,15).'</OrdenCompra>
					<Obra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$obra)),0,40).'</Obra>
					<DirObra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$direccion_obra)),0,40).'</DirObra>
					<ComunaObra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$comuna_1)),0,40).'</ComunaObra>
				</Parametros>';
				*/
	$xmlstr .= '</DTE>';

	
	$xml = new SimpleXMLElement($xmlstr);

	header('Content-Type: text/xml');
	header("Content-Disposition: attachment; filename=fact_".$factura.".xml");
	

	echo $xml->asXML();
	 /*
	$archivo = fopen("c:\XML\R76836180-0T33F".$factura.".xml",'a+');
	fputs($archivo,);
	fclose($archivo);

	
	/*$fecha_temp = explode("-",$registrofact['fecha']);
	$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
	$dia_texto="";
	switch($dyh['mon']){
		case 1: $dia_texto = "Enero"; break;
		case 2: $dia_texto = "Febrero"; break;
		case 3: $dia_texto = "Marzo"; break;
		case 4: $dia_texto = "Abril"; break;
		case 5: $dia_texto = "Mayo"; break;
		case 6: $dia_texto = "Junio"; break;
		case 7: $dia_texto = "Julio"; break;
		case 8: $dia_texto = "Agosto"; break;
		case 9: $dia_texto = "Septiembre"; break;
		case 10: $dia_texto = "Octubre"; break;
		case 11: $dia_texto = "Noviembre"; break;
		case 12: $dia_texto = "Diciembre"; break;
		default: $dia_texto = "Error";    
	}
	
	
	$fecha_factura_imprimir = $dyh['mday'].' de '.$dia_texto." de ".$dyh['year'];  
	$fecha_factura = $dyh['year'].'-'.$dyh['mon']."-".$dyh['mday'];  
	$pdf->SetXY(130,51.5);
	$pdf->Cell(50,5,$fecha_factura_imprimir);
	$pdf->Ln();

	$pdf->SetXY(25,59.5);
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registro['raz_social'])) ;
	$pdf->SetXY(120,59.5);
	$pdf->Cell(50,5,$registro['rut_cliente']) ;
	$pdf->Ln();

	$pdf->SetXY(25,68.5);
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registro['direcc_cliente']));
	if (!empty($registro['cod_comuna'])) {
		$sqlciu="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		$registrociu = mysql_fetch_array($resciu);;
		$pdf->SetXY(120,68.5);
		$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registrociu['comuna']));
	  }else{;
		$pdf->SetXY(120,68.5);
		$pdf->Cell(50,5," ");
	  } ;
	$pdf->Ln();

	$pdf->SetXY(25,77.5);
	$pdf->Cell(50,5,$registro['giro_cliente']);;
	if (!empty($registro['cod_ciudad'])){
		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		$registrociu = mysql_fetch_array($resciu);
		$pdf->SetXY(120,77.5);
		$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$registrociu['ciudad']));
	}else{
		$pdf->SetXY(120,77.5);
		$pdf->Cell(50,5," ");
	} 
	$pdf->Ln(); 

	$sqlgd   = "SELECT * FROM arriendo WHERE cod_arriendo ='$num_arriendo'";

	$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
	$registrogd = mysql_fetch_array($resgd);
	if ((($registrogd['num_gd'])!='')&&(($registrogd['num_gd'])!=0)) {
		$num_gd     = $registrogd['num_gd'];
		}	
	else {
		$sqlgd   = "SELECT distinct num_gd FROM equipos_arriendo WHERE cod_arriendo ='$num_arriendo'";
	
		$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
		$registrogd = mysql_fetch_array($resgd);
		if (($registrogd['num_gd'])!='') {
			$num_gd     = $registrogd['num_gd'];
			}	
		else {
			$num_gd =  $registrofact['observaciones'];
		}
	}
	$pdf->SetFont('arial','I',10);
	$pdf->SetXY(25,86.5);
	$pdf->Cell(50,5,$num_gd);
	$pdf->SetXY(120,86.5);
	$pdf->Cell(50,5,$registro['fono_cliente']) ;
	if(!empty($registrofact['cod_arriendo'])){
		$sqlfpago   = "SELECT forma_pago FROM arriendo WHERE cod_arriendo =".$registrofact['cod_arriendo'];
		$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
		$registrofp= mysql_fetch_array($resfpago);
		$forma_pago = $registrofp['forma_pago'];
		$sqlfpago  = "SELECT * FROM forma_pago WHERE cod_forma_pago ='$forma_pago'";
		$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
		$registropago= mysql_fetch_array($resfpago);
		}
	$pdf->SetXY(175,86.5);
	if (!empty($registropago['forma_pago'])){
		$total_string = strlen($registropago['forma_pago']);
		for ($i=0; $i<=($total_string/15);$i++){
			$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['forma_pago'],$i*15,15))));
			$pdf->Ln();
			$pdf->Cell(165,5,"");
			}
		$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['forma_pago'],$i*15,15)))) ;
		}
	else{
		$sqlfpago  = "SELECT gd.cond_venta, gd.tipo, factura.cond_venta as cond_venta_fact
						FROM factura
							left join gd 
								on factura.gd_rep = gd.num_gd
						WHERE factura.num_factura =".$num_factura;
		$resfpago    = mysql_query($sqlfpago,$link) or die(mysql_error()); 
		$registropago= mysql_fetch_array($resfpago);
		
		if (!empty($registropago['cond_venta'])){
			$total_string = strlen($registropago['cond_venta']);
			for ($i=0; $i<=($total_string/15);$i++){
				$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['cond_venta'],$i*15,15))));
				$pdf->Ln();
				$pdf->Cell(165,5,"");
				}
			$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['cond_venta'],$i*15,15)))) ;
			}
		elseif (!empty($registropago['tipo'])){
			$total_string = strlen($registropago['tipo']);
			for ($i=0; $i<=($total_string/15);$i++){
				$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['tipo'],$i*15,15))));
				$pdf->Ln();
				$pdf->Cell(165,5,"");
				}
			$pdf->Cell(15,5,iconv('UTF-8', 'windows-1252',iconv('UTF-8', 'windows-1252',substr($registropago['tipo'],$i*15,15)))) ;
			}elseif (!empty($registropago['cond_venta_fact'])){
				$temp_string = $registropago['cond_venta_fact'];
				$total_string = strlen($temp_string);
				for ($i=0; $i<=($total_string/15);$i++){
					$pdf->Cell(15,5,utf8_decode( (substr($registropago['cond_venta_fact'],$i*15,15)) ));
					$pdf->Ln();
					$pdf->Cell(165,5,"");
					}
				$pdf->Cell(15,5,utf8_decode( (substr($registropago['cond_venta_fact'],$i*15,15)))) ;
				}
			else{
				$pdf->Cell(50,5,"") ;
			}
		}
	$pdf->Ln(); 

	$pdf->SetFont('arial','I',10);
	if (!empty($registrofact['cod_arriendo'])){
		$sqlnumoc   = "SELECT num_oc FROM arriendo WHERE cod_arriendo =".$registrofact['cod_arriendo'];
		$resnumoc    = mysql_query($sqlnumoc,$link) or die(mysql_error()); 
		$registronumoc= mysql_fetch_array($resnumoc);
		}
	$pdf->SetXY(25,95.5);
	if (!empty($registronumoc['num_oc'])){
		$pdf->Cell(50,5,$registronumoc['num_oc']);
		}
	else{
		$sqlnumoc   = "SELECT * FROM factura WHERE num_factura ='$factura'";
		$resnumoc    = mysql_query($sqlnumoc,$link) or die(mysql_error()); 
		$registronumoc= mysql_fetch_array($resnumoc);
		$pdf->Cell(50,5,$registronumoc['oc_rep']);
		}

	
	$pdf->SetXY(25,95.5);
	//$pdf->Cell(50,5,$registronumoc['num_oc']);
	
	if (($registrofact['cod_obra']!=0)||(!empty($registrofact['cod_obra']))){
		$sqlobra   = "SELECT nombre_obra FROM obra WHERE cod_obra =".$registrofact['cod_obra'];
		}
	elseif (!empty($registrofact['gd_rep'])) {
			$sqlobra   = "SELECT nombre_obra 
						FROM obra 
						WHERE cod_obra in (select cod_obra 
											from gd 
											where num_gd = ".$registrofact['gd_rep'].")";
		}
	$nombre_obra="";
	if (!empty($sqlobra)){
		$resobra    = mysql_query($sqlobra,$link) or die(mysql_error()); 
		$registrobra= mysql_fetch_array($resobra);
		$nombre_obra = $registrobra['nombre_obra'];
	}
	$pdf->SetXY(105,95.5);
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252',$nombre_obra));

	$sqldet="SELECT * FROM  det_factura where num_factura = '$factura' order by cod_repuesto ASC";
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	$pdf->Ln(23); 
	$costo_tot=0;
	
	while ($registrodet = mysql_fetch_array($resdet)) {
		$total_desc=0;
		$porcentaje_emitir = 0;
		$total_neto = 0;
		$detalle="";
		$detalle_1="";
		$dias_arriendo = $registrodet['dias_arriendo'];
		$pdf->SetFont('arial','I',10);
		$pdf->Cell(5,6,"");
		if (($registrodet['cod_repuesto'] == 0 )&&($registrodet['cod_equipo'] == 0 )) {

			$pdf->SetWidths(array(20,80,20,27,20));
			$pdf->SetAligns(array('L','L','L','L','L'));
			
			$detalle = $registrodet['otros_reparacion'];
			
			$pdf->Row(array($registrodet['cantidad'],hola(hola($detalle)),"$".number_format($registrodet['valor_unitario'], 0, ",", "."),"","$".number_format($registrodet['total_rep'], 0, ",", ".")));
			$costo_tot = $costo_tot + $registrodet['total_rep'];
			$pdf->Ln();
			
					
		}else{
			$cantidad = $registrodet['dias_arriendo'];
		 	if (!empty($valor1)){
				$sqlnomob="SELECT nombre_equipo FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
				$resnomob = mysql_query($sqlnomob,$link) or die(mysql_error()); 
				$registronob = mysql_fetch_array($resnomob);
				$detalle .= "Dias Arriendo de ".($registronob['nombre_equipo']);

				$link=Conectarse();
				$num_arriendo = $registrofact['cod_arriendo'];
				$sqlperiodo="SELECT *
							FROM equipos_arriendo
								inner join gd
									on equipos_arriendo.cod_arriendo = gd.id_arriendo
								inner join factura 
									on factura.cod_arriendo = equipos_arriendo.cod_arriendo
								where equipos_arriendo.cod_arriendo =".$num_arriendo." 
									and equipos_arriendo.cod_equipo =".$registrodet['cod_equipo']." 
									and factura.num_factura = '".$num_factura."'
									and equipos_arriendo.arrendado_hasta >= '".$fecha_factura."'
									and equipos_arriendo.arrendado_desde <= '".$fecha_factura."'
									and equipos_arriendo.estado_equipo_arr like '%-FACTURADO%'
								order by equipos_arriendo.arrendado_hasta asc
							limit 0,1
					 ";
				 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
				 $registroper_row = mysql_num_rows($resperiodo);
					  if ($registroper_row==0){
						 $sqlperiodo=" SELECT *
									FROM equipos_arriendo
										inner join gd
											on equipos_arriendo.cod_arriendo = gd.id_arriendo
										inner join factura 
											on factura.cod_arriendo = equipos_arriendo.cod_arriendo
										where equipos_arriendo.nro_factura = '".$num_factura."'
										order by equipos_arriendo.arrendado_hasta asc
									limit 0,1";
						 $resperiodo = mysql_query($sqlperiodo,$link) or die(mysql_error()); 
					  }
      			 $registroper = mysql_fetch_array($resperiodo); 				 
				 $hasta="";
				 if (!empty($registroper['arrendado_hasta'])){ 
					$fecha_temp = explode("-",$registroper['arrendado_hasta']);
					//año-mes-dia
					//0 -> dia, 1 -> mes, 2 -> año
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$hasta =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  

				}else{ 
					$hasta = "NO DEVUELTO";
					}
									 
				$fecha_temp = explode("-",$registroper['arrendado_desde']);
				//año-mes-dia
				//0 -> dia, 1 -> mes, 2 -> año
				//var_dump($fecha_temp);
				if ((isset($fecha_temp[1]))&&(isset($fecha_temp[2]))&&(isset($fecha_temp[0]))){
					$dyh = getdate(mktime(0, 0, 0,$fecha_temp[1], $fecha_temp[2], $fecha_temp[0]));
					$desde =  $dyh['mday'].'-'.$dyh['mon']."-".$dyh['year'];  
					}
				else{
					$desde = '';
					}
				
    			$detalle_1 .= ("PERIODO DESDE ".$desde." AL ".$hasta);
				 
			}else{
					$detalle_1 .=(" ");
					 
			}
			$detalle = str_replace('?','°',$detalle);
			//$pdf->Cell(80,6,($detalle));			  
			$link=Conectarse();
			$sqleval   = "SELECT valor_unidad_arr FROM equipo WHERE cod_equipo =".$registrodet['cod_equipo'];
			$resuni         = mysql_query($sqleval,$link) or die(mysql_error()); 
			$registroval    = mysql_fetch_array($resuni);
			$valor = $registrodet['tot_arriendo']/$dias_arriendo;
			$pdf->SetFont('arial','I',10);
			$valor_le = "$".number_format($valor, 0, ",", ".");
		
			$total_neto = $dias_arriendo*$valor;
			$porcentaje_emitir = ($registrodet['porcentaje_vu']);
			$total_desc="";
			$porcentaje_emitir = "";
			if ($porcentaje_emitir==100 || $porcentaje_emitir==0){
				$porcentaje_emitir = "";
				}
			else{
				$porcentaje_emitir = $porcentaje_emitir."%";
				}
		
			if (!empty($registrodet['total_rep'])) { 
				if ($porcentaje_emitir==100){
					$porcentaje_emitir=0;
					}
				$total_desc = $total_neto * (1 - ($porcentaje_emitir/100));
				$total_desc_le = "$".number_format($total_desc, 0, ",", "."); 
				}
			else{ 
				if ($porcentaje_emitir==100){
					$porcentaje_emitir=0;
					}
				$total_desc = $total_neto * (1 - ($porcentaje_emitir/100));
				$total_desc_le = "$".number_format($total_desc, 0, ",", ".");
				}
			$costo_tot = $costo_tot + ($total_desc);
			$pdf->SetWidths(array(20,100,20,27,20));
			$pdf->SetAligns(array('L','L','L','L','L'));
			$pdf->Row(array($cantidad,hola(hola($detalle)),$valor_le,$porcentaje_emitir,$total_desc_le));
			$pdf->Ln();
			
		}
	}
	
	mysql_free_result($res);
	mysql_close($link); 

	$link=Conectarse();
	$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
	$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
	$registroiva = mysql_fetch_array($resiva);
	$valor_iva = $registroiva['valor_iva'];
	$iva = $costo_tot * ($valor_iva/100);
	$total = $costo_tot + $iva;

	$pdf->SetXY(50,203.5);
	$pdf->SetFont('arial','I',10);
	$total = number_format($total,0,",","");
	$pdf->Cell(100,5,iconv('UTF-8', 'windows-1252',(strtoupper(docenumeros($total))))) ;
	$pdf->Ln();
	
	$pdf->SetXY(180,221);
	$pdf->Cell(100,5,(number_format($costo_tot, 0, ",", ".")));
	$pdf->Ln();
	
	$link=Conectarse();
	$sqliva = "SELECT * FROM iva ORDER BY cod_iva DESC Limit 1";  
	$resiva = mysql_query($sqliva,$link) or die(mysql_error()); 
	$registroiva = mysql_fetch_array($resiva);
	$valor_iva = $registroiva['valor_iva'];
	$iva = $costo_tot * ($valor_iva/100);

	$pdf->SetXY(180,230);
	$pdf->Cell(100,5,(number_format($iva, 0, ",", ".")));
	$pdf->Ln();
	
	$pdf->SetXY(180,238);
	$pdf->Cell(100,5,(number_format($total, 0, ",", ".")));
	$pdf->Ln();

$pdf->Output();
*/
?>
