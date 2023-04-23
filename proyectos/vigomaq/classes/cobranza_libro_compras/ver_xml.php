<?php 
	ob_start(); 
	session_start(); 

	include("../conex.php");
	
	list($dia,$mes,$anio) = explode('-',$_GET['fecha_inicio']);
	$fecha_inicio = $anio.'-'.$mes.'-'.$dia;

	list($dia,$mes,$anio) = explode('-',$_GET['fecha_fin']);
	$fecha_fin = $anio.'-'.$mes.'-'.$dia;


	mysql_query("SET NAMES utf8");   


	$sqlfact = "SELECT * FROM factura WHERE fecha between '".$fecha_inicio."' and '".$fecha_fin."'";						
	$resfact = mysql_query($sqlfact,$link) or die(mysql_error()); 
	while ($registrofact = mysql_fetch_array($resfact)){
		$fact=$registrofact['num_factura'];
		$cod_cli=$registrofact['cod_cliente'];
		$fecha_factura=$registrofact['fecha'];
		$num_arriendo =  $registrofact['cod_arriendo'];
		
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



	 		$sqlciu="SELECT ciudad FROM ciudad where cod_ciudad =".$registro['cod_ciudad'];
	 		// echo($sql3);
	 		$resciu = mysql_query($sqlciu,$link) or die(mysql_error()); 
	 		$registrociu = mysql_fetch_array($resciu);

	 		$sqlcom="SELECT comuna FROM comuna where cod_comuna =".$registro['cod_comuna'];
	 		// echo($sql3);
	 		$rescom = mysql_query($sqlcom,$link) or die(mysql_error()); 
	 		$registrocom = mysql_fetch_array($rescom);

		
		$xmlstr = '<?xml version="1.0" encoding="utf8"?>
					<DTE version="1.0">
						<Documento ID="R76836180-0T33F'.$fact.'">
							<Encabezado>
								<IdDoc>
				            		<TipoDTE>33</TipoDTE>
						            <Folio>'.$fact.'</Folio>
						            <FchEmis>'.$registrofact['fecha'].'</FchEmis>
				        	  	</IdDoc>
				          		<Emisor>
						            <RUTEmisor>76836180-0</RUTEmisor>
						            <RznSoc>Sociedad de Inversiones y Servicios Vigomaq Ltda</RznSoc>
						            <GiroEmis>Arriendo, Venta y Reparación de  Maquinaria de Construcción</GiroEmis>
						            <Acteco>99999</Acteco>
						            <DirOrigen>AVDA CARLOS IBANEZ DEL C 3114 ACHUPALLAS</DirOrigen>
						            <CmnaOrigen>VINA DEL MAR</CmnaOrigen>
						            <CiudadOrigen>VINA DEL MAR</CiudadOrigen>
						        </Emisor>
						        <Receptor>
						        	<RUTRecep>'.str_replace('.', '', $registro['rut_cliente']).'</RUTRecep>
						            <RznSocRecep>'.$registro['raz_social'].'</RznSocRecep>
						            <GiroRecep>'.$registro['giro_cliente'].'</GiroRecep>
						            <DirRecep>'.$registro['direcc_cliente'].'</DirRecep>
						            <CmnaRecep>'.$registrocom['comuna'].'</CmnaRecep>
						            <CiudadRecep>'.$registrociu['ciudad'].'</CiudadRecep>
						        </Receptor>';

		
		$sqldet="SELECT  sum(tot_arriendo) + sum(total_rep) as neto, '19' as valor_iva
					FROM  det_factura
					where num_factura = '".$num_factura."'";
		$resdet = mysql_query($sqldet) or die(mysql_error()); 
		while($registrodet = mysql_fetch_array($resdet)){
			$iva = $registrodet['neto'] * ($registrodet['valor_iva']/100);
			$total = $registrodet['neto'] * (1+($registrodet['valor_iva']/100));
			$xmlstr .= 				'<Totales>
							            <MntNeto>'.$registrodet['neto'].'</MntNeto>
							            <TasaIVA>19</TasaIVA>
							            <IVA>'.number_format($iva,0,'','').'</IVA>
							            <MntTotal>'.number_format($total,0,'','').'</MntTotal>
							        </Totales>';
			}

		$sqldet="SELECT * FROM  det_factura where num_factura = '".$factura."' order by cod_repuesto ASC";	
		$resdet = mysql_query($sqldet,$link) or die(mysql_error()); 

		
		$xmlstr .=			'</Encabezado>
			        	</Documento>
		        	</DTE>';
		}
	$xml = new SimpleXMLElement($xmlstr);
	
	header('Content-Type: text/xml');
	echo $xml->asXML(); 


/*
<LibroCompraVenta version="1.0">
<EnvioLibro ID="LC96928180-5M3A2010">
<Caratula>
<RutEmisorLibro>96928180-5</RutEmisorLibro>
<RutEnvia>15377845-0</RutEnvia>
<PeriodoTributario>2010-03</PeriodoTributario>
<FchResol>2008-01-01</FchResol>
<NroResol>0</NroResol>
<TipoOperacion>VENTA</TipoOperacion>
<TipoLibro>MENSUAL</TipoLibro>
<TipoEnvio>TOTAL</TipoEnvio>
</Caratula>
<ResumenPeriodo>
<TotalesPeriodo>
<TpoDoc>33</TpoDoc>
<TotDoc>2</TotDoc>
<TotMntExe>0</TotMntExe>
<TotMntNeto>69800</TotMntNeto>
<TotMntIVA>13262</TotMntIVA>
<TotMntTotal>83062</TotMntTotal>
</TotalesPeriodo>
</ResumenPeriodo>
<Detalle>
<TpoDoc>33</TpoDoc>
<NroDoc>119</NroDoc>
<TasaImp>19</TasaImp>
<FchDoc>2010-10-06</FchDoc>
<RUTDoc>98656569-2</RUTDoc>
<RznSoc>FIKTICIA S.A.</RznSoc>
<MntExe>0</MntExe>
<MntNeto>60000</MntNeto>
<MntIVA>11400</MntIVA>
<MntTotal>71400</MntTotal>
</Detalle>
<Detalle>
<TpoDoc>33</TpoDoc>
<NroDoc>120</NroDoc>
<TasaImp>19</TasaImp>
<FchDoc>2010-10-06</FchDoc>
<RUTDoc>78730897-0</RUTDoc>
<RznSoc>PARATEST</RznSoc>
<MntExe>0</MntExe>
<MntNeto>9800</MntNeto>
<MntIVA>1862</MntIVA>
<MntTotal>11662</MntTotal>
</Detalle>
</EnvioLibro>
</LibroCompraVenta> 
*/
?>