<?php 
ob_start(); 
session_start(); 

$guia = $_GET['num_gd'];
$arriendo = $_GET['arriendo'];
$tipo = "";

include("../conex.php");


		if (empty($guia)) $guia = $_GET['num_gd'];
		$link=Conectarse();
		$sqlguia = "SELECT * FROM gd WHERE num_gd ='$guia'";						
		
		$resguia = mysql_query($sqlguia,$link) or die(mysql_error()); 
		$registroguia = mysql_fetch_array($resguia);
		$gd       =$registroguia['num_gd'];
		$cod_cli  =$registroguia['cod_cliente'];
		$tipo 	 	= $registroguia['tipo'];
		$arriendo = $registroguia['id_arriendo'];


		$sqlcliente = "SELECT rut_cliente FROM clientes WHERE cod_cliente ='$cod_cli'";
		$rescliente = mysql_query($sqlcliente,$link) or die(mysql_error()); 
		$registrocliente = mysql_fetch_array($rescliente);
		$valor1=$registrocliente['rut_cliente'];
		if (empty($valor1)){
			$valor1 = $_GET['id'];
			if (empty($valor1)) $valor1 = $_POST['txt_rut'];
			if (empty($valor1)) $valor1 = $_GET['txt_rut'];
		}
		
		if (empty($valor1)){

		}else{
			$link=Conectarse();
			$sql = "SELECT cod_cliente, cod_ciudad , cod_comuna, cod_tipocli, 
							rut_cliente, dv_cliente, raz_social, giro_cliente, 
							cod_area, fono_cliente, movil_cliente, direcc_cliente, 
							nom_resp_emp1, email_resp_emp1, cargo_resp1, movil_resp1, nom_resp_emp2, email_resp_emp2, 
							cargo_resp2, movil_resp2, nom_resp_emp3, email_resp_emp3, cargo_resp3, movil_resp3, cond_env_fact 
					FROM clientes WHERE rut_cliente ='$valor1'";
			$res = mysql_query($sql,$link) or die(mysql_error()); 
			$registro = mysql_fetch_array($res);
			}

	//$pdf=new FPDF();
	//$pdf=new PDF();
	//$pdf->SetFont('Arial','',9);
	//$pdf->AddPage();
	
	//mysql_query("SET NAMES utf8");   


 		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
 		// echo($sql3);
 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
 		$registrociu = mysql_fetch_array($resciu);

 		$sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
 		// echo($sql3);
 		$rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
 		$registrocom = mysql_fetch_array($rescom);

 	if (($arriendo!='')&&($arriendo!='0')){
 		$tipo_despacho = '2';
 		$int_traslado = "6";
 		}
 	else{
 		$tipo_despacho = '1';
 		if (isset($registroguia['tipo_traslado'])) $int_traslado = $registroguia['tipo_traslado'];
 		else $int_traslado = "1";
 		}
	

	$xmlstr = '<?xml version="1.0" encoding="utf-8"?>
				<DTE version="1.0">
					<Documento ID="R76836180-0T52F'.$guia.'">
						<Encabezado>
							<IdDoc>
			            		<TipoDTE>52</TipoDTE>
					            <Folio>'.$guia.'</Folio>
					            <FchEmis>'.$registroguia['fecha'].'</FchEmis>
					            <TipoDespacho>'.$tipo_despacho.'</TipoDespacho>
					            <IndTraslado>'.$int_traslado.'</IndTraslado>
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

	$sqldet="SELECT  sum(precio*cantidad) as neto, sum(precio*cantidad)*(0.19) as iva, sum(precio*cantidad)*(1.19) as total
				FROM  det_gd
				where num_gd = '".$_GET["num_gd"]."'";
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	while($registrodet = mysql_fetch_array($resdet)){
		$xmlstr .= 				'<Totales>
						            <MntNeto>'.$registrodet['neto'].'</MntNeto>
						            <TasaIVA>19</TasaIVA>
						            <IVA>'.number_format($registrodet['iva'],0,'','').'</IVA>
						            <MntTotal>'.number_format($registrodet['total'],0,'','').'</MntTotal>
						        </Totales>
						        </Encabezado>';
		}
	$sqldet="SELECT  *
				FROM  det_gd 
				where num_gd = '".$_GET["num_gd"]."' 
			 order by fila_num_gd ASC";	
	$resdet = mysql_query($sqldet) or die(mysql_error()); 
	$i=1;
	while ($registrodet = mysql_fetch_array($resdet)) {
		$array_temporal = array();
		$sqlnomrep="SELECT nombre_equipo, accesorios, cod_motor FROM equipo where cod_equipo =".$registrodet['cod_equipo'];
		$resnomrep = mysql_query($sqlnomrep,$link) or die(mysql_error()); 
		$registronrep = mysql_fetch_array($resnomrep);
		$detalle="";
		$detalle_1="";
		if ($registrodet['observaciones']==''){
			$detalle .= 'ARRIENDO DE ';
			$array_temporal = explode('°', ($registronrep['nombre_equipo'])); 
			for( $k=0 ; $k<count($array_temporal) ; $k++){
				$detalle .= $array_temporal[$k]." ";
				}
			$detalle = str_replace('\n', '', $detalle);
			}
		else{
			$detalle .= $registrodet['observaciones']." ";
			if (($registrodet['observaciones']=='CAMBIO')||($registrodet['observaciones']=='POR')){
				$detalle .= $registronrep['nombre_equipo']." ";
				}
			
			list($d1,$d2) = explode('//',$detalle);
			$detalle = substr($d1, 0,80);
			$detalle_1 = $d2;

			/*1 tomar detalle
			2 cortarlo donde diga //
			3 primer corte va parar detalle  --> NmbItem
				3.1 detalle truncado a los 80
			4 segundo corte va parar detalle_1 ---> DscItem
			*/
			}
		if($registronrep['cod_motor'] > 1){
			$detalle_1 .= ' , C/MOTOR N. '.$registronrep['cod_motor'];
			}
		if($registrodet['accesorio'] == 1){
			$detalle_1 .= ' , '.$registronrep['accesorios'];
			}
		$total = $registrodet['cantidad']*$registrodet['precio'];
		
		$xmlstr .=			'<Detalle>
		  					        <NroLinDet>'.$i.'</NroLinDet>
		  					        <NmbItem>'.str_replace("Ã‘",'N',substr($detalle,0,80)).'</NmbItem>
				  					<DscItem>'.str_replace("?",'N',utf8_decode($detalle_1)).'</DscItem>
				  				 	<QtyItem>'.$registrodet['cantidad'].'</QtyItem>
		  					        <PrcItem>'.$registrodet['precio'].'</PrcItem>
		  					        <MontoItem>'.number_format($total,0,'','').'</MontoItem>
		  				        </Detalle>';
		$i++;
		}

	//referencia
		$sqlgd   = "SELECT * FROM arriendo WHERE num_gd ='".$guia."'";
			
					$resgd       = mysql_query($sqlgd,$link) or die(mysql_error()); 
					$registrogd = mysql_fetch_array($resgd);
					$num_gd     = $registrogd['num_gd'];
					$num_oc     = $registrogd['num_oc'];
					$fecha_arr     = $registrogd['fecha_arr'];
					$cod_obra     = $registrogd['cod_obra'];
					$tipo_oc     = $registrogd['tipo_oc'];
		
					
		if ($cod_obra>0){
		  	   	$sql3="SELECT * FROM obra where cod_obra =".$cod_obra;
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				$obra = $registro3['nombre_obra'];
				$direccion_obra =str_replace("Ã?Â",'', utf8_encode($registro3['direcc_obra']));

				$sqlciu="SELECT comuna FROM comuna where cod_comuna =".$registro3['cod_comuna'];
		 		// echo($sql3);
		 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		 		$registrociu_1 = mysql_fetch_array($resciu);
		 		$comuna_1 = $registrociu_1['comuna']; 
			}
		else{
			$sql_002 = "select * from gd where num_gd = '".$guia."'";
			$res_002 = mysql_query($sql_002,$link);
			$row_002 = mysql_fetch_array($res_002);
			$cod_obra     = $row_002['cod_obra'];
			
			if ($cod_obra>0){
				$sql3="SELECT * FROM obra where cod_obra =".$cod_obra;
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				$obra = $registro3['nombre_obra'];
				$direccion_obra = str_replace("Ã?Â",'', utf8_encode($registro3['direcc_obra']));
				}
			if ($registro3['cod_comuna']!=''){
				$sqlciu="SELECT comuna FROM comuna where cod_comuna =".$registro3['cod_comuna'];
		 		// echo($sql3);
		 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
		 		$registrociu_1 = mysql_fetch_array($resciu);
		 		$comuna_1 = $registrociu_1['comuna'];
		 		}
			}
		$sql_002 = "select * from gd where num_gd = '".$guia."'";
		$res_002 = mysql_query($sql_002,$link);
		$row_002 = mysql_fetch_array($res_002);
		$fecha_gd = $row_002['fecha'];
		$id_arriendo = $row_002['id_arriendo'];
		if ($num_oc=='') $num_oc     = $row_002['orden_compra'];
		
	$razon = substr('OC : '.$num_oc.' ; Obra : '.$obra.' - '.$direccion_obra.' - '.$comuna_1,0,90);
	$razon_1 = substr('Obra : '.$obra.' - '.$direccion_obra.' - '.$comuna_1,0,90);
	if ($id_arriendo>0){
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

		 $url = $num_oc;
		 //Reemplazamos caracteres especiales latinos
		 $find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
		 $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
		 $url = str_replace($find, $repl, $url);

		$xmlstr .=' <Referencia>
							<NroLinRef>1</NroLinRef>
							<TpoDocRef>801</TpoDocRef>
							<FolioRef>'.$url.'</FolioRef>
							<FchRef>'.$fecha_gd.'</FchRef>
							<RazonRef>'.$razon_1.'</RazonRef>
						</Referencia>';
			}
	else{
		$xmlstr .='';
		}

	$xmlstr .=			'
		        	</Documento>';
	$sql_002 = "select * from gd where num_gd = '".$guia."'";
	$res_002 = mysql_query($sql_002,$link);
	$row_002 = mysql_fetch_array($res_002);
	$cond_venta_1 = $row_002['cond_venta'];
	$patente = $row_002['patente'];
		$sql_002 = "select forma_pago.forma_pago 
						from arriendo
							inner join forma_pago
								on forma_pago.cod_forma_pago = arriendo.forma_pago
					where num_gd = '".$guia."'";
		$res_002 = mysql_query($sql_002,$link);
		$row_002 = mysql_fetch_array($res_002);
		$cond_venta = $row_002['forma_pago'];
		if ($cond_venta==''){

			$sql_002 = "select forma_pago.forma_pago 
							from forma_pago
						where cod_forma_pago = '".$cond_venta_1."'";
			$res_002 = mysql_query($sql_002,$link);
			$row_002 = mysql_fetch_array($res_002);
			$cond_venta = $row_002['forma_pago'];
		

		}

	$url = $num_oc;
	//Reemplazamos caracteres especiales latinos
	$find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
	$repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
	$num_oc = str_replace($find, $repl, $url);


	$xmlstr .= '<Parametros>
				<FormaPago>'.substr($cond_venta,0,15).'</FormaPago>
				<OrdenCompra>'.substr($num_oc,0,15).'</OrdenCompra>
				<Obra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$obra)),0,40).'</Obra>
				<DirObra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$direccion_obra)),0,40).'</DirObra>
				<ComunaObra>'.substr(str_replace("Ñ",'N',str_replace("Ã‘",'N',$comuna_1)),0,40).'</ComunaObra>
				<Patente>'.$patente.'</Patente>
				</Parametros>
	        	</DTE>';

	$xml = new SimpleXMLElement($xmlstr);

	//echo $xmlstr;

	header('Content-Type: text/xml');
	header("Content-Disposition: attachment; filename=gd_".$guia.".xml");
	
	echo $xml->asXML();
	
	
	?>
